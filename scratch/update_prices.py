import re
import os

filepath = 'resources/views/brochure.blade.php'
with open(filepath, 'r') as f:
    content = f.read()

php_logic = """@if($base_price > 0 || $base_semi > 0 || $base_priv > 0)
@php
    $priceCount = ($base_price > 0 ? 1 : 0) + ($base_semi > 0 ? 1 : 0) + ($base_priv > 0 ? 1 : 0);
    $priceClass = $priceCount === 1 ? 'text-xl md:text-2xl' : ($priceCount === 2 ? 'text-base md:text-lg' : 'text-sm md:text-base');
@endphp"""

# Replace the @if statement with the @if + @php block
content = content.replace("@if($base_price > 0 || $base_semi > 0 || $base_priv > 0)", php_logic)

# Replace the text classes for the non-default blocks
content = content.replace(
    '<div class="text-base font-black text-tb-blue mt-0.5"',
    '<div class="{{ $priceClass }} font-black text-tb-blue mt-0.5"'
)

# Replace the text classes for the default block
content = content.replace(
    '<div class="text-[14px] font-black mt-0.5"',
    '<div class="{{ $priceClass }} font-black mt-0.5"'
)

with open(filepath, 'w') as f:
    f.write(content)

print("Updated brochure.blade.php successfully.")
