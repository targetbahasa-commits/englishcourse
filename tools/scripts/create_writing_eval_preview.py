import re
import os

promo_file = "resources/views/promo/result.blade.php"
dest_file = "resources/views/assignments/ielts/writing/evaluation_preview.blade.php"

with open(promo_file, "r") as f:
    content = f.read()

# Change the layout from layouts.guest to layouts.admin
# Wait, let's check what it extends first
match_extend = re.search(r"@extends\('([^']+)'\)", content)
if match_extend:
    print("Extends:", match_extend.group(1))
    content = content.replace(f"@extends('{match_extend.group(1)}')", "@extends('layouts.admin')")
else:
    # If it doesn't extend anything, just add it
    pass

# We also want to remove promo specific stuff like:
# "Konsultasi ke CS", WhatsApp buttons, etc.
# These are probably at the bottom. We'll leave them for now unless they cause issues, but maybe remove the bottom CTA.

# Write it
os.makedirs(os.path.dirname(dest_file), exist_ok=True)
with open(dest_file, "w") as f:
    f.write(content)

print("Created evaluation preview view.")
