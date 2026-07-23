from gradio_client import Client, handle_file
import os

AVATAR_IMAGE_PATH = os.path.abspath("public/images/promo/hallo_avatar.png")
audio_path = os.path.abspath("storage/app/scripts/web_assets/temp/temp_q1.mp3")

try:
    client = Client("https://511c1f6c2eaa7fb0ba.gradio.live/")
    res = client.predict(
        image_path=handle_file(AVATAR_IMAGE_PATH),
        audio_path=handle_file(audio_path),
        api_name="/predict"
    )
    print("RESULT:", res)
except Exception as e:
    print("ERROR:", e)
