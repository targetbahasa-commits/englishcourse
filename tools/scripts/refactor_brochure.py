import re

with open('resources/views/brochure.blade.php', 'r') as f:
    content = f.read()

# 1. Add x-data to the main container
content = content.replace(
    '<div class="max-w-[1280px] mx-auto bg-white shadow-2xl relative overflow-hidden">',
    '<div class="max-w-[1280px] mx-auto bg-white shadow-2xl relative overflow-hidden" x-data="{ classType: null }">'
)

# 2. Modify "Pilihan Jenis Kelas" cards
content = content.replace(
    '<div class="bg-gray-50 rounded-2xl p-8 border border-gray-100 shadow-sm hover:shadow-md transition-shadow relative overflow-hidden group">',
    '<div @click="classType = \'regular\'" :class="classType === \'regular\' ? \'ring-4 ring-blue-500 bg-blue-50\' : \'\'" class="cursor-pointer bg-gray-50 rounded-2xl p-8 border border-gray-100 shadow-sm hover:shadow-md transition-shadow relative overflow-hidden group">'
)
content = content.replace(
    '<div class="bg-blue-50 rounded-2xl p-8 border border-blue-100 shadow-sm hover:shadow-md transition-shadow relative overflow-hidden group">',
    '<div @click="classType = \'semi_private\'" :class="classType === \'semi_private\' ? \'ring-4 ring-blue-500 bg-blue-100\' : \'\'" class="cursor-pointer bg-blue-50 rounded-2xl p-8 border border-blue-100 shadow-sm hover:shadow-md transition-shadow relative overflow-hidden group">'
)
content = content.replace(
    '<div class="bg-yellow-50 rounded-2xl p-8 border border-yellow-200 shadow-sm hover:shadow-md transition-shadow relative overflow-hidden group">',
    '<div @click="classType = \'private\'" :class="classType === \'private\' ? \'ring-4 ring-blue-500 bg-yellow-100\' : \'\'" class="cursor-pointer bg-yellow-50 rounded-2xl p-8 border border-yellow-200 shadow-sm hover:shadow-md transition-shadow relative overflow-hidden group">'
)

# 3. Add x-show to the Program section
content = content.replace(
    '@if($group[\'items\']->count() > 0)\n            <section class="py-16 px-8 relative">',
    '@if($group[\'items\']->count() > 0)\n            <section class="py-16 px-8 relative" x-show="classType !== null" x-transition.opacity.duration.500ms>'
)

# 4. Extract price variables from inside the switch and put them outside
price_calc = """@php $base_price = $type === 'offline' ? ($program ? ($program->price_offline ?? $program->price ?? 1999000) : 1999000) : ($program ? $program->price : 1999000);

$base_semi = $type === 'offline' ? ($program ? ($program->price_semi_private_offline ?? $program->price_semi_private ?? 2499000) : 2499000) : ($program ? $program->price_semi_private : 2499000);

$base_priv = $type === 'offline' ? ($program ? ($program->price_private_offline ?? $program->price_private ?? 3499000) : 3499000) : ($program ? $program->price_private : 3499000); @endphp"""

# Note: The default case at the end uses a slightly different fallback `($program->price ?? 0)`.
# Let's replace the whole foreach loop body start.
content = content.replace(
    '                    @php $__currentLoopData = $group[\'items\']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $program): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); @endphp\n                    @switch($program->slug)',
    '                    @php $__currentLoopData = $group[\'items\']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $program): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); @endphp\n' + 
    '                    ' + price_calc + '\n' +
    '                    <div x-show="(classType === \'regular\' && {{ $base_price }} > 0) || (classType === \'semi_private\' && {{ $base_semi }} > 0) || (classType === \'private\' && {{ $base_priv }} > 0)" x-transition>\n' +
    '                    @switch($program->slug)'
)

# Close the div at the end of the loop
content = content.replace(
    '                    @endswitch\n                    @php endforeach;',
    '                    @endswitch\n                    </div>\n                    @php endforeach;'
)

# 5. Remove the inner price calculations to avoid duplicate definitions
content = content.replace(price_calc, '')

# Wait, there's another variant of price calculation in the @default case (around line 1525)
price_calc_default = """@php $base_price = $type === 'offline' ? ($program->price_offline ?? $program->price ?? 0) : ($program->price ?? 0);
                            $base_semi = $type === 'offline' ? ($program->price_semi_private_offline ?? $program->price_semi_private ?? 0) : ($program->price_semi_private ?? 0);
                            $base_priv = $type === 'offline' ? ($program->price_private_offline ?? $program->price_private ?? 0) : ($program->price_private ?? 0); @endphp"""
content = content.replace(price_calc_default, '')

# 6. Add x-show to individual price cards
content = re.sub(
    r'<div class="relative group bg-white rounded p-2 border border-gray-200 text-center shadow-sm cursor-help">',
    '<div class="relative group bg-white rounded p-2 border border-gray-200 text-center shadow-sm cursor-help flex-1" x-show="classType === \'regular\'">',
    content
)
content = re.sub(
    r'<div class="relative group bg-blue-50 rounded p-2 border border-blue-200 text-center shadow-sm cursor-help">',
    '<div class="relative group bg-blue-50 rounded p-2 border border-blue-200 text-center shadow-sm cursor-help flex-1" x-show="classType === \'semi_private\'">',
    content
)
content = re.sub(
    r'<div class="relative group bg-yellow-50 rounded p-2 border border-yellow-300 text-center shadow-sm cursor-help">',
    '<div class="relative group bg-yellow-50 rounded p-2 border border-yellow-300 text-center shadow-sm cursor-help flex-1" x-show="classType === \'private\'">',
    content
)

with open('resources/views/brochure.blade.php', 'w') as f:
    f.write(content)

print("Done")
