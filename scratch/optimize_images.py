import os
import glob
from PIL import Image

def convert_to_webp(filepath):
    if not filepath.endswith('.png'):
        return filepath
    
    webp_path = filepath[:-4] + '.webp'
    print(f"Converting {filepath} to {webp_path}...")
    
    try:
        with Image.open(filepath) as img:
            img.save(webp_path, 'WEBP', quality=80)
        return webp_path
    except Exception as e:
        print(f"Failed to convert {filepath}: {e}")
        return filepath

# Target directories
images_to_convert = []
images_to_convert.extend(glob.glob('public/images/programs/*.png'))
images_to_convert.extend(glob.glob('public/images/hero/*.png'))

converted_files = []

for img_path in images_to_convert:
    # Only convert the ones actually used or large ones
    if "ChatGPT" not in img_path:
        new_path = convert_to_webp(img_path)
        if new_path != img_path:
            converted_files.append((img_path, new_path))

# Now update the blade file
blade_file = 'resources/views/brochure.blade.php'
print(f"Updating {blade_file}...")

with open(blade_file, 'r', encoding='utf-8') as f:
    content = f.read()

# Replace png with webp
for old_path, new_path in converted_files:
    # old_path is something like public/images/programs/grammar.png
    # in blade, it is referenced as /images/programs/grammar.png or images/programs/grammar.png
    
    old_rel = old_path.replace('public/', '/')
    new_rel = new_path.replace('public/', '/')
    
    content = content.replace(old_rel, new_rel)
    
    # Also handle without leading slash just in case
    old_rel_no_slash = old_path.replace('public/', '')
    new_rel_no_slash = new_path.replace('public/', '')
    
    content = content.replace(old_rel_no_slash, new_rel_no_slash)

with open(blade_file, 'w', encoding='utf-8') as f:
    f.write(content)

print("Optimization complete.")
