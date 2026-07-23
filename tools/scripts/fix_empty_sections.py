import re

with open('resources/views/brochure.blade.php', 'r') as f:
    content = f.read()

php_logic = """
            @php
                $hasRegular = false;
                $hasSemi = false;
                $hasPrivate = false;

                foreach($group['items'] as $prog) {
                    $is_default = !in_array($prog->slug, ['ielts-academic-full-package', 'toefl-itp', 'toefl-ibt', 'ielts-general', 'pte-academic']);
                    
                    if ($is_default) {
                        $bp = $type === 'offline' ? ($prog->price_offline ?? $prog->price ?? 0) : ($prog->price ?? 0);
                        $bs = $type === 'offline' ? ($prog->price_semi_private_offline ?? $prog->price_semi_private ?? 0) : ($prog->price_semi_private ?? 0);
                        $bpv = $type === 'offline' ? ($prog->price_private_offline ?? $prog->price_private ?? 0) : ($prog->price_private ?? 0);
                    } else {
                        $bp = $type === 'offline' ? ($prog ? ($prog->price_offline ?? $prog->price ?? 1999000) : 1999000) : ($prog ? $prog->price : 1999000);
                        $bs = $type === 'offline' ? ($prog ? ($prog->price_semi_private_offline ?? $prog->price_semi_private ?? 2499000) : 2499000) : ($prog ? $prog->price_semi_private : 2499000);
                        $bpv = $type === 'offline' ? ($prog ? ($prog->price_private_offline ?? $prog->price_private ?? 3499000) : 3499000) : ($prog ? $prog->price_private : 3499000);
                    }

                    if ($bp > 0) $hasRegular = true;
                    if ($bs > 0) $hasSemi = true;
                    if ($bpv > 0) $hasPrivate = true;
                }
            @endphp
            <section class="py-16 px-8 relative" x-show="classType !== null && ((classType === 'regular' && {{ $hasRegular ? 'true' : 'false' }}) || (classType === 'semi_private' && {{ $hasSemi ? 'true' : 'false' }}) || (classType === 'private' && {{ $hasPrivate ? 'true' : 'false' }}))" x-transition.opacity.duration.500ms>
"""

content = content.replace(
    '<section class="py-16 px-8 relative" x-show="classType !== null" x-transition.opacity.duration.500ms>',
    php_logic.strip()
)

with open('resources/views/brochure.blade.php', 'w') as f:
    f.write(content)

print("Fixed sections")
