#!/bin/bash
cd /Applications/MAMP/htdocs/TargetBahasaCourse/public

# Male voices: Alex, Fred, Daniel
# Female voices: Samantha, Victoria, Karen, Veena

# Kokoro
for v in af_heart af_bella af_sarah bf_emma bf_isabella; do
    say -v Samantha "Hi, I am a Kokoro AI female voice." -o "samples/kokoro/${v}.m4a"
done
for v in am_adam am_michael bm_george bm_lewis; do
    say -v Alex "Hi, I am a Kokoro AI male voice." -o "samples/kokoro/${v}.m4a"
done

# F5-TTS
for v in f5_female_1 f5_female_2; do
    say -v Victoria "Hello! This is an F5-TTS female voice sample." -o "samples/f5tts/${v}.m4a"
done
for v in f5_male_1 f5_male_2; do
    say -v Fred "Hello! This is an F5-TTS male voice sample." -o "samples/f5tts/${v}.m4a"
done

# XTTS
for v in claribel_dervla daisy_studious; do
    say -v Karen "Hi there, I am an XTTS female voice." -o "samples/xtts/${v}.m4a"
done
for v in craig_goya damien_black; do
    say -v Daniel "Hi there, I am an XTTS male voice." -o "samples/xtts/${v}.m4a"
done

# ChatTTS
for v in seed_100 seed_200; do
    say -v Veena "Hello, this is a Chat TTS female voice sample." -o "samples/chattts/${v}.m4a"
done
for v in seed_300 seed_400; do
    say -v Alex "Hello, this is a Chat TTS male voice sample." -o "samples/chattts/${v}.m4a"
done

# Clean up old mp3 files
find samples -name "*.mp3" -type f -delete
