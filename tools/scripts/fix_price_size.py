import re

with open('resources/views/brochure.blade.php', 'r') as f:
    content = f.read()

# Replace the conditional priceClass with a static large size
old_logic = r"\$priceClass = \$priceCount === 1 \? 'text-xl md:text-2xl' : \(\$priceCount === 2 \? 'text-base md:text-lg' : 'text-sm md:text-base'\);"
new_logic = "$priceClass = 'text-2xl md:text-3xl';"

content = re.sub(old_logic, new_logic, content)

with open('resources/views/brochure.blade.php', 'w') as f:
    f.write(content)

print("Done replacing priceClass logic")
