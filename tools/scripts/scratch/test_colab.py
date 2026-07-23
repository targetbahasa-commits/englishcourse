import os
import sys
from gradio_client import Client, handle_file

SADTALKER_API_URL = "https://373da248f663832da6.gradio.live"
AVATAR_IMAGE_PATH = "/Applications/MAMP/htdocs/TargetBahasaCourse/public/images/promo/hallo_avatar.png"

# generate a quick audio
import subprocess
output_path = "/Applications/MAMP/htdocs/TargetBahasaCourse/storage/app/scripts/web_assets/temp_test.mp3"
command = [sys.executable, "-m", "edge_tts", "--voice", "en-US-AriaNeural", "--text", "Testing Colab connection", "--write-media", output_path]
subprocess.run(command, check=True, stdout=subprocess.PIPE, stderr=subprocess.PIPE)

try:
    client = Client(SADTALKER_API_URL, httpx_kwargs={"timeout": 1200.0})
    result = client.predict(
        handle_file(AVATAR_IMAGE_PATH),
        handle_file(output_path),
        api_name="/predict"
    )
    print("SUCCESS!")
    print(result)
except Exception as e:
    print("FAILED!")
    import traceback
    traceback.print_exc()
