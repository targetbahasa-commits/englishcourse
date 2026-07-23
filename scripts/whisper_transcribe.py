import sys
import json
import warnings
from transformers import pipeline
import torch

# Suppress warnings
warnings.filterwarnings("ignore")

def main():
    if len(sys.argv) < 2:
        print(json.dumps({"error": "No audio file provided"}))
        sys.exit(1)

    audio_file = sys.argv[1]

    try:
        # Check if MPS (Apple Silicon GPU) or CUDA is available, else fallback to CPU
        device = "cpu"
        if torch.backends.mps.is_available():
            device = "mps"
        elif torch.cuda.is_available():
            device = "cuda"

        # Initialize the pipeline
        transcriber = pipeline("automatic-speech-recognition", model="openai/whisper-small", device=device)
        
        # Transcribe the audio
        result = transcriber(audio_file)
        
        # Return result as JSON
        print(json.dumps({"text": result.get("text", "").strip()}))

    except Exception as e:
        print(json.dumps({"error": str(e)}))
        sys.exit(1)

if __name__ == "__main__":
    main()
