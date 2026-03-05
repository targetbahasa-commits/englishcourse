from PIL import Image, ImageDraw, ImageFont
import os

# Create Persian Qanat Image
img1 = Image.new('RGB', (800, 400), color=(250, 250, 250))
d1 = ImageDraw.Draw(img1)

# Draw ground line (sloping down)
d1.line([(50, 100), (300, 250), (750, 300)], fill=(120, 120, 120), width=3)
# Draw water table (dashed line)
for i in range(150, 750, 20):
    d1.line([(i, 200 + (i-150)*0.2), (i+10, 200 + (i+10-150)*0.2)], fill=(100, 150, 255), width=2)
# Draw vertical shafts
for x in range(200, 700, 100):
   y_ground = 100 + (x-50)*150/250 if x <= 300 else 250 + (x-300)*50/450
   y_water = 200 + (x-150)*0.2
   d1.rectangle([(x-10, y_ground-20), (x+10, y_water)], outline=(80,80,80), width=2)

img1.save('public/assets/images/mockups/persian_qanat.png')

# Create Roman Qanat Shaft Image
img2 = Image.new('RGB', (600, 500), color=(250, 250, 250))
d2 = ImageDraw.Draw(img2)

# Draw ground
d2.rectangle([(0, 100), (600, 500)], fill=(220, 220, 220))
d2.rectangle([(150, 100), (450, 500)], fill=(255, 255, 255))
# Draw lid
d2.ellipse([(140, 80), (460, 120)], fill=(150, 150, 150), outline=(80,80,80), width=2)
d2.ellipse([(280, 70), (320, 90)], outline=(80,80,80), width=3) # Handle
# Draw walls
d2.line([(150, 100), (150, 500)], fill=(80,80,80), width=4)
d2.line([(450, 100), (450, 500)], fill=(80,80,80), width=4)
# Draw handholds
for y in range(200, 450, 50):
   d2.rectangle([(130, y), (150, y+10)], fill=(255,255,255), outline=(80,80,80))
   d2.rectangle([(450, y+25), (470, y+35)], fill=(255,255,255), outline=(80,80,80))
# Draw plumb line
d2.line([(150, 150), (450, 150)], fill=(100,100,100), width=3) # Rod
d2.line([(300, 150), (300, 400)], fill=(50,50,50), width=2) # String
d2.polygon([(290, 400), (310, 400), (300, 420)], fill=(80,80,80)) # Weight

img2.save('public/assets/images/mockups/roman_qanat.png')
print("Images created")
