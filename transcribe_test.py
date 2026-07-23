import edge_tts
import asyncio
import os

async def main():
    text = 'The notion of absolutism, which emerged in 17th-century Europe, refers to a system of governance where a single ruler holds complete control over the state and its subjects, unencumbered by constitutional limitations or institutional checks. This concept is often associated with monarchs such as Louis XIV of France, who famously declared "L\'etat, c\'est moi" - I am the state - encapsulating the idea that the ruler\'s authority was inextricably linked with the state itself.'
    communicate = edge_tts.Communicate(text, 'en-US-JennyNeural')
    await communicate.save('test_jenny.mp3')
    print(f"Size of Jenny: {os.path.getsize('test_jenny.mp3')}")

asyncio.run(main())
