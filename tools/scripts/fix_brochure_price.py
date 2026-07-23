import re

with open('resources/views/brochure.blade.php', 'r') as f:
    content = f.read()

price_calc = """@php $base_price = $type === 'offline' ? ($program ? ($program->price_offline ?? $program->price ?? 1999000) : 1999000) : ($program ? $program->price : 1999000);
$base_semi = $type === 'offline' ? ($program ? ($program->price_semi_private_offline ?? $program->price_semi_private ?? 2499000) : 2499000) : ($program ? $program->price_semi_private : 2499000);
$base_priv = $type === 'offline' ? ($program ? ($program->price_private_offline ?? $program->price_private ?? 3499000) : 3499000) : ($program ? $program->price_private : 3499000); @endphp"""

# Insert price calc back into the loop
content = content.replace(
    '<div x-show="(classType === \'regular\' && {{ $base_price }} > 0) || (classType === \'semi_private\' && {{ $base_semi }} > 0) || (classType === \'private\' && {{ $base_priv }} > 0)" x-transition>',
    price_calc + '\n<div x-show="(classType === \'regular\' && {{ $base_price }} > 0) || (classType === \'semi_private\' && {{ $base_semi }} > 0) || (classType === \'private\' && {{ $base_priv }} > 0)" x-transition>'
)

with open('resources/views/brochure.blade.php', 'w') as f:
    f.write(content)

print("Fixed")
