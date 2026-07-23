#!/usr/bin/env python3
"""
Kokoro TTS Server v3 — listens on port 8100
Async job-based architecture: endpoints return immediately, JS polls for status.

Endpoints:
  POST /api/generate-speech   → start speech job  → {job_id, status:"processing"}
  POST /api/generate-sfx      → start sfx job     → {job_id, status:"processing"}
  POST /api/compile-audio     → mix & finalize    → {job_id, status:"processing"}
  GET  /api/job-status/{job_id}   → {status, step, message}
  GET  /health
"""

import io
import os
import re
import wave
import json
import logging
import threading
from typing import List
from fastapi import FastAPI, HTTPException, Request
from fastapi.responses import Response, JSONResponse
from fastapi.middleware.cors import CORSMiddleware
import uvicorn

# ── Logging ──────────────────────────────────────────────────────────────────
logging.basicConfig(level=logging.INFO, format="%(asctime)s %(levelname)s %(message)s")
log = logging.getLogger("tts_server")

# ── Shared storage dir (same as Laravel public storage) ──────────────────────
BASE_DIR    = os.path.dirname(os.path.abspath(__file__))
STORAGE_DIR = os.path.join(BASE_DIR, "storage", "app", "public", "listening-banks")
os.makedirs(STORAGE_DIR, exist_ok=True)

# ── In-memory job tracker ─────────────────────────────────────────────────────
# job_id → {status, step, message, error}
_jobs: dict = {}
_jobs_lock  = threading.Lock()

app = FastAPI(title="Kokoro TTS Server", version="3.0.0")

# Allow browser polling from any origin (HTTPS local domain → HTTP 127.0.0.1)
app.add_middleware(
    CORSMiddleware,
    allow_origins=["*"],
    allow_methods=["GET", "POST", "OPTIONS"],
    allow_headers=["*"],
)


@app.on_event("startup")
async def startup_event():
    """Pre-load AudioGen model in background so it's ready for SFX requests."""
    def preload():
        try:
            log.info("Pre-loading AudioGen model in background thread…")
            get_audiogen_model()
            log.info("AudioGen model pre-loaded and ready!")
        except Exception as ex:
            log.warning(f"AudioGen pre-load failed (will retry on first use): {ex}")
    threading.Thread(target=preload, daemon=True).start()


# ── Model caches ──────────────────────────────────────────────────────────────
_pipeline      = None
_pipeline_lang = None
_audiogen_model = None


def get_pipeline(lang_code: str = "a"):
    global _pipeline, _pipeline_lang
    if _pipeline is None or _pipeline_lang != lang_code:
        log.info(f"Loading Kokoro pipeline (lang={lang_code})…")
        from kokoro import KPipeline
        _pipeline = KPipeline(lang_code=lang_code)
        _pipeline_lang = lang_code
        log.info("Kokoro pipeline ready.")
    return _pipeline


def get_audiogen_model():
    global _audiogen_model
    if _audiogen_model is None:
        log.info("Loading AudioGen model (facebook/audiogen-medium)…")
        from audiocraft.models import AudioGen
        _audiogen_model = AudioGen.get_pretrained('facebook/audiogen-medium')
        log.info("AudioGen model ready.")
    return _audiogen_model


# ── Job helpers ───────────────────────────────────────────────────────────────
def job_set(job_id: str, status: str, step: str = "", message: str = "", error: str = ""):
    with _jobs_lock:
        _jobs[job_id] = {"status": status, "step": step, "message": message, "error": error}


def job_get(job_id: str) -> dict:
    with _jobs_lock:
        return _jobs.get(job_id, {})


# ── Voice mapping ─────────────────────────────────────────────────────────────
VOICE_MAP = {
    "af_heart": "af_heart", "af_bella": "af_bella", "af_aoede": "af_aoede",
    "af_kore": "af_kore", "af_nicole": "af_nicole", "af_sarah": "af_sarah",
    "af_sky": "af_sky", "am_adam": "am_adam", "am_echo": "am_echo",
    "am_eric": "am_eric", "am_fenrir": "am_fenrir", "am_liam": "am_liam",
    "am_michael": "am_michael", "am_onyx": "am_onyx", "am_puck": "am_puck",
    "bf_emma": "bf_emma", "bf_isabella": "bf_isabella",
    "bm_george": "bm_george", "bm_lewis": "bm_lewis",
}
DEFAULT_VOICE = "af_heart"
DEFAULT_LANG  = "a"


def resolve_voice(voice_id: str) -> str:
    v = voice_id.lower().strip()
    if v in VOICE_MAP:
        return VOICE_MAP[v]
    for key, val in VOICE_MAP.items():
        if key in v or v in key:
            return val
    return DEFAULT_VOICE


# ── Text helpers ──────────────────────────────────────────────────────────────
def split_text(text: str, max_len: int = 400) -> List[str]:
    sentences = re.split(r'(?<=[.!?])\s+', text.strip())
    chunks, current = [], ""
    for s in sentences:
        if len(current) + len(s) + 1 <= max_len:
            current = (current + " " + s).strip()
        else:
            if current:
                chunks.append(current)
            current = s
    if current:
        chunks.append(current)
    return chunks or [text]


def parse_dialogue(text: str, speaker_tags: List[str]) -> List[dict]:
    pattern = re.compile(
        r'(?:\[)?(' + '|'.join(re.escape(t) for t in speaker_tags) + r')(?:\])?[:\s]+(.+)',
        re.IGNORECASE
    )
    pause_re = re.compile(r'\[PAUSE\s+(\d+)\]', re.IGNORECASE)
    lines = []
    for raw in text.strip().split('\n'):
        raw = raw.strip()
        if not raw:
            continue
        m_pause = pause_re.match(raw)
        if m_pause:
            lines.append({"speaker": "PAUSE", "duration": int(m_pause.group(1)), "text": ""})
            continue
        m = pattern.match(raw)
        if m:
            lines.append({"speaker": m.group(1), "text": m.group(2).strip()})
        elif lines:
            if lines[-1]["speaker"] != "PAUSE":
                lines[-1]["text"] += " " + raw
            else:
                lines.append({"speaker": speaker_tags[0] if speaker_tags else "UNKNOWN", "text": raw})
    return lines


def arrays_to_wav_bytes(chunks: list, sr: int = 24000) -> bytes:
    import numpy as np
    combined = np.clip(np.concatenate(chunks), -1.0, 1.0)
    pcm = (combined * 32767).astype(np.int16)
    buf = io.BytesIO()
    with wave.open(buf, 'wb') as wf:
        wf.setnchannels(1); wf.setsampwidth(2); wf.setframerate(sr)
        wf.writeframes(pcm.tobytes())
    return buf.getvalue()


def wav_to_mp3(wav_bytes: bytes) -> bytes:
    from pydub import AudioSegment
    seg = AudioSegment.from_wav(io.BytesIO(wav_bytes))
    out = io.BytesIO()
    seg.export(out, format="mp3", bitrate="128k")
    return out.getvalue()


def build_segments(text: str, speakers: list) -> List[dict]:
    tag_to_voice  = {s["tag"]: resolve_voice(s["voice_id"]) for s in speakers}
    default_voice = resolve_voice(speakers[0]["voice_id"])
    pause_re      = re.compile(r'\[PAUSE\s+(\d+)\]', re.IGNORECASE)
    if len(speakers) > 1:
        parsed = parse_dialogue(text, [s["tag"] for s in speakers])
    else:
        parsed = []
        for raw in text.strip().split('\n'):
            raw = raw.strip()
            if not raw:
                continue
            m = pause_re.match(raw)
            if m:
                parsed.append({"speaker": "PAUSE", "duration": int(m.group(1)), "text": ""})
            else:
                if parsed and parsed[-1]["speaker"] != "PAUSE":
                    parsed[-1]["text"] += " " + raw
                else:
                    parsed.append({"speaker": speakers[0]["tag"], "text": raw})
    segments = []
    for line in (parsed or [{"speaker": speakers[0]["tag"], "text": text}]):
        if line["speaker"] == "PAUSE":
            segments.append({"voice": "PAUSE", "duration": line.get("duration", 0)})
        else:
            segments.append({"voice": tag_to_voice.get(line["speaker"], default_voice), "text": line["text"]})
    return segments


def _do_generate_speech(job_id: str, text: str, speakers: list):
    """Background thread: synthesise speech and save to disk."""
    try:
        import numpy as np
        job_set(job_id, "processing", "speech", "Loading Kokoro…")
        pipeline = get_pipeline(DEFAULT_LANG)
        segments = build_segments(text, speakers)

        all_audio = []
        sr = 24000
        silence = np.zeros(int(sr * 0.4), dtype=np.float32)

        job_set(job_id, "processing", "speech", f"Synthesising {len(segments)} segment(s)…")
        for i, seg in enumerate(segments):
            if seg["voice"] == "PAUSE":
                if seg.get("duration", 0) > 0:
                    all_audio.append(np.zeros(int(sr * seg["duration"]), dtype=np.float32))
                continue
            for chunk in split_text(seg["text"]):
                if not chunk.strip():
                    continue
                try:
                    for _, _, audio in pipeline(chunk, voice=seg["voice"], speed=1.0):
                        if audio is not None and len(audio) > 0:
                            all_audio.append(np.array(audio, dtype=np.float32))
                except Exception as e:
                    log.warning(f"Chunk synthesis error: {e}")
            if i < len(segments) - 1 and segments[i + 1]["voice"] != "PAUSE":
                all_audio.append(silence)

        if not all_audio:
            raise RuntimeError("No audio generated — check voices/text.")

        wav = arrays_to_wav_bytes(all_audio, sr)
        mp3 = wav_to_mp3(wav)

        path = os.path.join(STORAGE_DIR, f"{job_id}_speech.mp3")
        with open(path, "wb") as f:
            f.write(mp3)

        size_kb = len(mp3) / 1024
        log.info(f"[speech] Done: {job_id}_speech.mp3 ({size_kb:.1f} KB)")
        job_set(job_id, "done", "speech", f"Speech ready ({size_kb:.0f} KB)")

    except Exception as e:
        log.exception(f"[speech] Failed for job {job_id}")
        job_set(job_id, "error", "speech", "", str(e))


def _do_generate_sfx(job_id: str, prompt: str, duration: int):
    """Background thread: generate SFX with AudioGen and save to disk."""
    try:
        from audiocraft.data.audio import audio_write
        job_set(job_id, "processing", "sfx", "Loading AudioGen…")
        model = get_audiogen_model()
        model.set_generation_params(duration=duration)

        job_set(job_id, "processing", "sfx", f"Generating '{prompt[:40]}'…")
        wav = model.generate([prompt])

        base = os.path.join(STORAGE_DIR, f"{job_id}_sfx")
        audio_write(base, wav[0].cpu(), model.sample_rate, strategy="loudness", loudness_compressor=True)

        size_kb = os.path.getsize(base + ".wav") / 1024
        log.info(f"[sfx] Done: {job_id}_sfx.wav ({size_kb:.1f} KB)")
        job_set(job_id, "done", "sfx", f"SFX ready ({size_kb:.0f} KB)")

    except Exception as e:
        log.exception(f"[sfx] Failed for job {job_id}")
        job_set(job_id, "error", "sfx", "", str(e))


def _do_compile(job_id: str, sfx_volume: int):
    """Background thread: mix speech + sfx (or just copy speech if no sfx)."""
    try:
        import shutil
        from pydub import AudioSegment
        job_set(job_id, "processing", "compile", "Mixing audio…")

        speech_path = os.path.join(STORAGE_DIR, f"{job_id}_speech.mp3")
        sfx_path    = os.path.join(STORAGE_DIR, f"{job_id}_sfx.wav")
        out_path    = os.path.join(STORAGE_DIR, f"{job_id}.mp3")

        if not os.path.exists(speech_path):
            raise FileNotFoundError(f"Speech file missing: {job_id}_speech.mp3")

        if not os.path.exists(sfx_path):
            log.info(f"[compile] No SFX — copying speech as final.")
            shutil.copy2(speech_path, out_path)
            os.remove(speech_path)
        else:
            speech_seg = AudioSegment.from_file(speech_path)
            sfx_seg    = AudioSegment.from_file(sfx_path) + sfx_volume
            loops      = int(len(speech_seg) / len(sfx_seg)) + 1
            sfx_looped = (sfx_seg * loops)[:len(speech_seg)]
            mixed      = speech_seg.overlay(sfx_looped)
            mixed.export(out_path, format="mp3", bitrate="128k")
            for f in [speech_path, sfx_path]:
                try: os.remove(f)
                except: pass

        size_kb = os.path.getsize(out_path) / 1024
        log.info(f"[compile] Done: {job_id}.mp3 ({size_kb:.1f} KB)")
        job_set(job_id, "done", "compile", f"Audio ready ({size_kb:.0f} KB)")

    except Exception as e:
        log.exception(f"[compile] Failed for job {job_id}")
        job_set(job_id, "error", "compile", "", str(e))


# ═══════════════════════════════════════════════════════════════════════════════
#  ENDPOINT: Generate Speech (async)
# ═══════════════════════════════════════════════════════════════════════════════
@app.post("/api/generate-speech")
async def generate_speech(request: Request):
    try:
        body = await request.json()
    except Exception:
        raise HTTPException(400, "Invalid JSON")

    job_id   = (body.get("job_id") or "").strip()
    text     = (body.get("text") or "").strip()
    speakers = body.get("speakers", [])

    if not job_id:  raise HTTPException(400, "'job_id' required")
    if not text:    raise HTTPException(400, "'text' required")
    if not speakers: raise HTTPException(400, "'speakers' required")

    job_set(job_id, "processing", "speech", "Queued…")
    threading.Thread(
        target=_do_generate_speech,
        args=(job_id, text, speakers),
        daemon=True
    ).start()

    log.info(f"[speech] Job {job_id} started in background")
    return JSONResponse({"status": "processing", "job_id": job_id})


# ═══════════════════════════════════════════════════════════════════════════════
#  ENDPOINT: Generate SFX (async)
# ═══════════════════════════════════════════════════════════════════════════════
@app.post("/api/generate-sfx")
async def generate_sfx(request: Request):
    try:
        body = await request.json()
    except Exception:
        raise HTTPException(400, "Invalid JSON")

    job_id   = (body.get("job_id") or "").strip()
    prompt   = (body.get("prompt") or "").strip()
    duration = int(body.get("duration", 10))

    if not job_id:  raise HTTPException(400, "'job_id' required")
    if not prompt:  raise HTTPException(400, "'prompt' required")

    job_set(job_id, "processing", "sfx", "Queued…")
    threading.Thread(
        target=_do_generate_sfx,
        args=(job_id, prompt, duration),
        daemon=True
    ).start()

    log.info(f"[sfx] Job {job_id} started in background")
    return JSONResponse({"status": "processing", "job_id": job_id})


# ═══════════════════════════════════════════════════════════════════════════════
#  ENDPOINT: Compile Audio (async)
# ═══════════════════════════════════════════════════════════════════════════════
@app.post("/api/compile-audio")
async def compile_audio(request: Request):
    try:
        body = await request.json()
    except Exception:
        raise HTTPException(400, "Invalid JSON")

    job_id     = (body.get("job_id") or "").strip()
    sfx_volume = int(body.get("sfx_volume", -15))

    if not job_id: raise HTTPException(400, "'job_id' required")

    job_set(job_id, "processing", "compile", "Queued…")
    threading.Thread(
        target=_do_compile,
        args=(job_id, sfx_volume),
        daemon=True
    ).start()

    log.info(f"[compile] Job {job_id} started in background")
    return JSONResponse({"status": "processing", "job_id": job_id})


# ═══════════════════════════════════════════════════════════════════════════════
#  ENDPOINT: Job Status (polled by JS every 3s)
# ═══════════════════════════════════════════════════════════════════════════════
@app.get("/api/job-status/{job_id}")
async def job_status(job_id: str):
    info = job_get(job_id)
    if not info:
        # Check if output file already exists on disk (job may have completed before tracking)
        final = os.path.join(STORAGE_DIR, f"{job_id}.mp3")
        speech = os.path.join(STORAGE_DIR, f"{job_id}_speech.mp3")
        sfx    = os.path.join(STORAGE_DIR, f"{job_id}_sfx.wav")
        if os.path.exists(final):
            return JSONResponse({"status": "done", "step": "compile", "message": "Audio ready"})
        if os.path.exists(speech):
            return JSONResponse({"status": "done", "step": "speech", "message": "Speech ready"})
        if os.path.exists(sfx):
            return JSONResponse({"status": "done", "step": "sfx", "message": "SFX ready"})
        return JSONResponse({"status": "unknown", "step": "", "message": "Job not found"})
    return JSONResponse(info)


# ═══════════════════════════════════════════════════════════════════════════════
#  LEGACY: /api/generate-listening (for backward compat)
# ═══════════════════════════════════════════════════════════════════════════════
@app.post("/api/generate-listening")
async def generate_listening(request: Request):
    try:
        body = await request.json()
    except Exception:
        raise HTTPException(400, "Invalid JSON")

    text     = (body.get("text") or "").strip()
    speakers = body.get("speakers", [])
    if not text:     raise HTTPException(400, "'text' required")
    if not speakers: raise HTTPException(400, "'speakers' required")

    import numpy as np
    try:
        pipeline = get_pipeline(DEFAULT_LANG)
        segments = build_segments(text, speakers)
        all_audio, sr = [], 24000
        silence = np.zeros(int(sr * 0.4), dtype=np.float32)
        for i, seg in enumerate(segments):
            if seg["voice"] == "PAUSE":
                if seg.get("duration", 0) > 0:
                    all_audio.append(np.zeros(int(sr * seg["duration"]), dtype=np.float32))
                continue
            for chunk in split_text(seg["text"]):
                if chunk.strip():
                    for _, _, audio in pipeline(chunk, voice=seg["voice"], speed=1.0):
                        if audio is not None and len(audio) > 0:
                            all_audio.append(np.array(audio, dtype=np.float32))
            if i < len(segments) - 1 and segments[i + 1]["voice"] != "PAUSE":
                all_audio.append(silence)
        if not all_audio:
            raise RuntimeError("No audio generated.")
        audio_bytes = wav_to_mp3(arrays_to_wav_bytes(all_audio, sr))
    except Exception as e:
        log.exception("[legacy] Failed")
        raise HTTPException(500, str(e))

    ct = "audio/mpeg" if audio_bytes[:3] == b'ID3' or audio_bytes[:2] == b'\xff\xfb' else "audio/wav"
    return Response(content=audio_bytes, media_type=ct)


# ── Health ────────────────────────────────────────────────────────────────────
@app.get("/health")
async def health():
    return {"status": "ok", "engine": "kokoro", "audiogen_loaded": _audiogen_model is not None}


# ── Entry point ───────────────────────────────────────────────────────────────
if __name__ == "__main__":
    port = int(os.environ.get("TTS_PORT", 8100))
    log.info(f"Starting Kokoro TTS Server v3 on port {port}")
    uvicorn.run(app, host="127.0.0.1", port=port, log_level="info")
