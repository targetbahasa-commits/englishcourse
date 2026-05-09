from PIL import Image

img = Image.open("/Users/macpro2021/.gemini/antigravity/brain/abf96f89-33ed-4c80-b1a4-a7201d1d5df9/media__1771913941112.png")
width, height = img.size

# Crop the top text out (approx top 280 pixels)
cropped = img.crop((0, 280, width, height))

cropped.save("/Applications/MAMP/htdocs/TargetBahasaCourse/public/assets/images/mockups/writing_test_4_task_1.png")
print(f"Saved cropped image: {cropped.size[0]}x{cropped.size[1]}")
