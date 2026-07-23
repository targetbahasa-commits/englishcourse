import os
from gradio_client import Client, handle_file

SADTALKER_API_URL = "https://7ee30e079325bc11e3.gradio.live"
AVATAR = "/Applications/MAMP/htdocs/TargetBahasaCourse/public/images/promo/hallo_avatar.png"
AUDIO = "/Applications/MAMP/htdocs/TargetBahasaCourse/storage/app/scripts/web_assets/temp_84/temp_p3_2_padded.mp3"

client = Client(SADTALKER_API_URL)
try:
    result = client.predict(
        handle_file(AVATAR),
        handle_file(AUDIO),
        api_name="/predict"
    )
    print("RESULT:", result)
except Exception as e:
    print("ERROR:", e)
