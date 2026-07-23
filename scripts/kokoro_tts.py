import sys
import os
import argparse
import numpy as np
import soundfile as sf
import warnings

# Suppress warnings for cleaner CLI output
warnings.filterwarnings("ignore")

try:
    from kokoro import KPipeline
except ImportError:
    print("ERROR: Modul 'kokoro' tidak ditemukan. Silakan instal dengan: pip install kokoro soundfile")
    sys.exit(1)

def main():
    parser = argparse.ArgumentParser(description="Kokoro TTS Wrapper for Laravel")
    parser.add_argument('--text', required=True, help="Teks yang akan diubah menjadi suara")
    parser.add_argument('--output', required=True, help="Path absolut untuk file .wav output")
    parser.add_argument('--voice', default="af_heart", help="Nama suara (contoh: af_heart, am_michael, dll)")
    parser.add_argument('--speed', type=float, default=1.0, help="Kecepatan suara (default: 1.0)")
    parser.add_argument('--lang', default="a", help="Kode bahasa (a: American English, b: British English)")
    
    args = parser.parse_args()

    try:
        # Inisialisasi KPipeline
        # Pipeline otomatis akan mengunduh config/model ke ~/.cache/huggingface jika belum ada
        pipeline = KPipeline(lang_code=args.lang)
        
        # Generator yang mengembalikan chunk audio
        generator = pipeline(
            args.text, 
            voice=args.voice, 
            speed=args.speed, 
            split_pattern=r'\n+' # Pemisahan kalimat agar tidak terpotong tiba-tiba
        )
        
        audio_chunks = []
        for i, (gs, ps, audio) in enumerate(generator):
            if audio is not None:
                audio_chunks.append(audio)
                
        if not audio_chunks:
            print("ERROR: Tidak ada audio yang dihasilkan.")
            sys.exit(1)
            
        # Gabungkan semua chunk audio
        final_audio = np.concatenate(audio_chunks)
        
        # Simpan sebagai WAV file (Kokoro menggunakan sample rate 24000Hz)
        sf.write(args.output, final_audio, 24000)
        
        print("SUCCESS")
        sys.exit(0)
        
    except Exception as e:
        print(f"ERROR: {str(e)}")
        sys.exit(1)

if __name__ == "__main__":
    main()
