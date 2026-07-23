with open('resources/views/brochure.blade.php', 'r') as f:
    content = f.read()

# Replace {{ $base_price }} with {{ $base_price ?: 0 }}
content = content.replace('{{ $base_price }}', '{{ $base_price ?: 0 }}')
content = content.replace('{{ $base_semi }}', '{{ $base_semi ?: 0 }}')
content = content.replace('{{ $base_priv }}', '{{ $base_priv ?: 0 }}')

with open('resources/views/brochure.blade.php', 'w') as f:
    f.write(content)

print("Fixed")
