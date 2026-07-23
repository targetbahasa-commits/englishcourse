"""
Listening Machine – Python Microservice
========================================
FastAPI + Kokoro TTS + pydub ambient layering

Kokoro version compatibility:
  - kokoro >= 0.9.4 : requires Python 3.10+ → use KPipeline API
  - kokoro 0.7.x    : works on Python 3.9  → use generate() API

Run:
    # With Python 3.10+ venv (recommended):
    source tools/listening-machine-api/venv310/bin/activate
    uvicorn main:app --host 127.0.0.1 --port 8100 --reload

    # Or simply:
    python main.py
"""

import io
import os
import re
import sys
from pathlib import Path
from typing import Optional

import numpy as np
import soundfile as sf
from fastapi import FastAPI, HTTPException
from fastapi.responses import Response
from pydantic import BaseModel
from pydub import AudioSegment
from pydub.effects import normalize

# ─────────────────────────────────────────────────────────────────────────────
#  Detect kokoro version & import accordingly
# ─────────────────────────────────────────────────────────────────────────────

try:
    import kokoro
    _kokoro_version = tuple(int(x) for x in kokoro.__version__.split(".")[:2])
except Exception:
    _kokoro_version = (0, 7)

KOKORO_NEW_API = _kokoro_version >= (0, 9)  # KPipeline style

if KOKORO_NEW_API:
    from kokoro import KPipeline
    print(f"[Listening Machine] Using kokoro {kokoro.__version__} (KPipeline API)")
else:
    from kokoro import generate, list_voices
    print(f"[Listening Machine] Using kokoro {kokoro.__version__} (generate API)")

# ─────────────────────────────────────────────────────────────────────────────
#  Constants
# ─────────────────────────────────────────────────────────────────────────────

BASE_DIR     = Path(__file__).parent
AMBIENT_DIR  = BASE_DIR / "assets" / "ambient"
SAMPLE_RATE  = 24_000
AMBIENT_DB   = -20
SILENCE_MS   = 600

# Pipeline cache (new API only)
_pipelines: dict[str, object] = {}

# Voice → language code map
VOICE_LANG_MAP: dict[str, str] = {
    "af_heart":    "a",
    "af_bella":    "a",
    "af_sarah":    "a",
    "am_adam":     "a",
    "am_michael":  "a",
    "bf_emma":     "b",
    "bf_isabella": "b",
    "bm_george":   "b",
    "bm_lewis":    "b",
}

# ─────────────────────────────────────────────────────────────────────────────
#  FastAPI app
# ─────────────────────────────────────────────────────────────────────────────

app = FastAPI(
    title="Listening Machine API",
    description="TTS pipeline for Target Bahasa LMS",
    version="1.0.0",
)


class Speaker(BaseModel):
    tag: str
    voice_id: str


class GenerateRequest(BaseModel):
    text: str
    speakers: list[Speaker]
    background: str = "none"
    engine: str = "Kokoro"


@app.get("/health")
def health():
    return {
        "status": "ok",
        "kokoro_version": getattr(kokoro, "__version__", "unknown"),
        "api_style": "KPipeline" if KOKORO_NEW_API else "generate()",
    }


@app.post("/api/generate-listening", response_class=Response)
async def generate_listening(req: GenerateRequest):
    segments = _parse_segments(req.text, req.speakers)
    if not segments:
        raise HTTPException(status_code=422, detail="No speakable segments found.")

    combined = AudioSegment.empty()
    silence  = AudioSegment.silent(duration=SILENCE_MS)

    for i, (speaker_tag, text_chunk) in enumerate(segments):
        voice_id  = _resolve_voice(speaker_tag, req.speakers)
        audio_seg = _synthesize(text_chunk, voice_id, req.engine)
        if i > 0:
            combined += silence
        combined += audio_seg

    if req.background and req.background != "none":
        combined = _overlay_ambient(combined, req.background)

    buf = io.BytesIO()
    combined.export(buf, format="mp3", bitrate="192k")
    buf.seek(0)

    return Response(
        content=buf.read(),
        media_type="audio/mpeg",
        headers={"X-Duration-Seconds": str(round(len(combined) / 1000))},
    )


# ─────────────────────────────────────────────────────────────────────────────
#  TTS synthesis (version-aware)
# ─────────────────────────────────────────────────────────────────────────────

def _synthesize(text: str, voice_id: str, engine: str) -> AudioSegment:
    engine_str = engine.lower()
    if "kokoro" in engine_str:
        if KOKORO_NEW_API:
            return _tts_new(text, voice_id)
        else:
            return _tts_legacy(text, voice_id)
    elif "f5-tts" in engine_str:
        return _tts_f5tts(text, voice_id)
    elif "xtts" in engine_str:
        return _tts_xtts(text, voice_id)
    elif "chattts" in engine_str:
        return _tts_chattts(text, voice_id)
    else:
        if KOKORO_NEW_API:
            return _tts_new(text, voice_id)
        else:
            return _tts_legacy(text, voice_id)


def _tts_f5tts(text: str, voice_id: str) -> AudioSegment:
    """Generate audio using F5-TTS via HuggingFace Space API and return as AudioSegment"""
    try:
        from gradio_client import Client, handle_file
    except ImportError:
        print("[F5-TTS] gradio_client not installed. Returning silence.")
        return AudioSegment.silent(duration=500)

    # We use the dummy generated voice sample as the "voice clone" reference
    script_dir = Path(__file__).parent
    ref_audio_path = script_dir.parent.parent / "public" / "samples" / "f5tts" / f"{voice_id}.m4a"

    if not ref_audio_path.exists():
        print(f"[F5-TTS] Reference audio not found at: {ref_audio_path}. Returning silence.")
        # Fallback to Kokoro voice if reference audio is missing
        print("[F5-TTS Fallback] Using Kokoro voice: af_bella")
        if KOKORO_NEW_API:
            return _tts_new(text, "af_bella")
        else:
            return _tts_legacy(text, "af_bella")

    # Reference text must match what is spoken in the reference audio
    if "female" in voice_id:
        ref_text = "Hello! This is an F5-TTS female voice sample."
    else:
        ref_text = "Hello! This is an F5-TTS male voice sample."

    try:
        print(f"[F5-TTS] Calling HuggingFace E2-F5-TTS API for voice: {voice_id}...")
        client = Client("mrfakename/E2-F5-TTS")
        result = client.predict(
            ref_audio=handle_file(str(ref_audio_path)),
            ref_text=ref_text,
            gen_text=text,
            remove_silence=False,
            api_name="/predict"
        )
        output_audio_path = result[0]
        return AudioSegment.from_file(output_audio_path)
    except Exception as e:
        print(f"[F5-TTS] Error calling E2-F5-TTS: {e}. Falling back to Kokoro.")
        # Fallback to Kokoro voice if HF call fails
        fallback_voice = "af_sarah" if "female" in voice_id else "am_adam"
        if KOKORO_NEW_API:
            return _tts_new(text, fallback_voice)
        else:
            return _tts_legacy(text, fallback_voice)


def _tts_xtts(text: str, voice_id: str) -> AudioSegment:
    """Generate audio using XTTS via HuggingFace Space API (hasanbasbunar/Voice-Cloning-XTTS-v2)"""
    try:
        from gradio_client import Client
    except ImportError:
        print("[XTTS] gradio_client not installed. Falling back to Kokoro.")
        return _tts_legacy(text, "af_bella") if not KOKORO_NEW_API else _tts_new(text, "af_bella")

    # The space hasanbasbunar/Voice-Cloning-XTTS-v2 requires example_audio_name
    xtts_mapping = {
        "Claribel Dervla": "audio_1.wav",
        "Daisy Studious": "audio_2.wav",
        "Craig Goya": "audio_3.wav",
        "Damien Black": "audio_4.wav"
    }
    example_audio = xtts_mapping.get(voice_id, "audio_1.wav")

    try:
        print(f"[XTTS] Calling HuggingFace XTTS API with voice: {example_audio}...")
        client = Client("hasanbasbunar/Voice-Cloning-XTTS-v2")
        result = client.predict(
            text=text,
            reference_audio_url="",
            example_audio_name=example_audio,
            language="English",
            temperature=0.75,
            speed=1.0,
            do_sample=True,
            repetition_penalty=5.0,
            length_penalty=1.0,
            gpt_cond_len=30,
            top_k=50,
            top_p=0.85,
            remove_silence_enabled=True,
            silence_threshold=-45,
            min_silence_len=300,
            keep_silence=100,
            text_splitting_method="Native XTTS splitting",
            max_chars_per_segment=250,
            enable_preprocessing=False,
            api_name="/voice_clone_synthesis"
        )
        output_audio_path = result
        return AudioSegment.from_file(output_audio_path)
    except Exception as e:
        print(f"[XTTS] Error calling XTTS: {e}. Falling back to Kokoro.")
        kokoro_fallback = "bf_emma" if "Claribel" in voice_id or "Daisy" in voice_id else "bm_george"
        return _tts_legacy(text, kokoro_fallback) if not KOKORO_NEW_API else _tts_new(text, kokoro_fallback)


def _tts_chattts(text: str, voice_id: str) -> AudioSegment:
    """Generate audio using ChatTTS via HuggingFace Space API"""
    try:
        from gradio_client import Client
    except ImportError:
        print("[ChatTTS] gradio_client not installed. Falling back to Kokoro.")
        return _tts_legacy(text, "af_sarah") if not KOKORO_NEW_API else _tts_new(text, "af_sarah")

    try:
        print(f"[ChatTTS] Calling HuggingFace ChatTTS API...")
        # Note: Public ChatTTS spaces are frequently down or paused. 
        client = Client("2Noise/ChatTTS")
        result = client.predict(
            text=text,
            api_name="/generate_audio"
        )
        output_audio_path = result[0] if isinstance(result, (tuple, list)) else result
        return AudioSegment.from_file(output_audio_path)
    except Exception as e:
        print(f"[ChatTTS] Error calling ChatTTS Space (might be offline): {e}. Falling back to Kokoro.")
        chat_mapping = {
            "seed_100": "af_sarah",
            "seed_200": "af_bella",
            "seed_300": "am_adam",
            "seed_400": "am_michael"
        }
        target_voice = chat_mapping.get(voice_id, "af_sarah")
        return _tts_legacy(text, target_voice) if not KOKORO_NEW_API else _tts_new(text, target_voice)


def _tts_new(text: str, voice_id: str) -> AudioSegment:
    """Kokoro ≥0.9.4 with KPipeline."""
    lang_code = VOICE_LANG_MAP.get(voice_id, "a")
    if lang_code not in _pipelines:
        _pipelines[lang_code] = KPipeline(lang_code=lang_code)
    pipeline = _pipelines[lang_code]

    chunks: list[np.ndarray] = []
    for _, _, audio in pipeline(text, voice=voice_id, speed=0.95, split_pattern=r'\n+'):
        if audio is not None and len(audio) > 0:
            chunks.append(audio)

    if not chunks:
        return AudioSegment.silent(duration=500)

    return _np_to_audiosegment(np.concatenate(chunks))


def _tts_legacy(text: str, voice_id: str) -> AudioSegment:
    """Kokoro 0.7.x with generate()."""
    try:
        audio, _ = generate(text, voice=voice_id, speed=0.95)
        return _np_to_audiosegment(audio)
    except Exception as e:
        print(f"[TTS Legacy] Error for voice {voice_id}: {e}")
        return AudioSegment.silent(duration=500)


def _np_to_audiosegment(audio_np: np.ndarray) -> AudioSegment:
    """Convert float32 numpy array → pydub AudioSegment."""
    int16 = (audio_np * 32767).clip(-32768, 32767).astype(np.int16)
    buf   = io.BytesIO()
    sf.write(buf, int16, SAMPLE_RATE, format="WAV", subtype="PCM_16")
    buf.seek(0)
    return normalize(AudioSegment.from_wav(buf))


# ─────────────────────────────────────────────────────────────────────────────
#  Helpers
# ─────────────────────────────────────────────────────────────────────────────

def _parse_segments(text: str, speakers: list[Speaker]) -> list[tuple[str, str]]:
    """Split text into (speaker_tag, chunk) pairs."""
    if not speakers:
        return [("default", text.strip())]

    pattern = re.compile(
        r'\[(' + '|'.join(re.escape(s.tag) for s in speakers) + r')\]\s*:',
        re.IGNORECASE,
    )
    parts = pattern.split(text)

    if len(parts) <= 1:
        return [(speakers[0].tag, text.strip())]

    segments: list[tuple[str, str]] = []
    i = 1
    while i < len(parts) - 1:
        tag   = parts[i].strip()
        chunk = parts[i + 1].strip()
        if chunk:
            segments.append((tag, chunk))
        i += 2
    return segments


def _resolve_voice(tag: str, speakers: list[Speaker]) -> str:
    for s in speakers:
        if s.tag.lower() == tag.lower():
            return s.voice_id
    return speakers[0].voice_id if speakers else "am_adam"


def _overlay_ambient(speech: AudioSegment, sound_name: str) -> AudioSegment:
    path = AMBIENT_DIR / f"{sound_name}.mp3"
    if not path.exists():
        print(f"[Ambient] File not found: {path}. Skipping overlay.")
        return speech

    ambient  = AudioSegment.from_file(str(path))
    speech_ms = len(speech)

    # Loop ambient to cover full speech duration
    looped = AudioSegment.empty()
    while len(looped) < speech_ms + 1000:
        looped += ambient
    looped = looped[:speech_ms] + AMBIENT_DB  # trim + reduce volume

    return looped.overlay(speech)


# ─────────────────────────────────────────────────────────────────────────────
#  Entry
# ─────────────────────────────────────────────────────────────────────────────

if __name__ == "__main__":
    import uvicorn
    uvicorn.run("main:app", host="127.0.0.1", port=8100, reload=True)
