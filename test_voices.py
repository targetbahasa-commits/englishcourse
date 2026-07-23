import edge_tts
import asyncio
import os

EDGE_VOICES = [
    "en-US-JennyNeural", "en-US-GuyNeural", "en-GB-SoniaNeural", 
    "en-GB-RyanNeural", "en-AU-NatashaNeural", "en-AU-WilliamNeural",
    "en-CA-ClaraNeural", "en-CA-LiamNeural"
]

text = 'The notion of absolutism, which emerged in 17th-century Europe, refers to a system of governance where a single ruler holds complete control over the state and its subjects, unencumbered by constitutional limitations or institutional checks. This concept is often associated with monarchs such as Louis XIV of France, who famously declared "L\'etat, c\'est moi" - I am the state - encapsulating the idea that the ruler\'s authority was inextricably linked with the state itself.'

async def main():
    for v in EDGE_VOICES:
        communicate = edge_tts.Communicate(text, v)
        await communicate.save(f"test_{v}.mp3")
        print(f"Size of {v}: {os.path.getsize(f'test_{v}.mp3')}")

asyncio.run(main())
