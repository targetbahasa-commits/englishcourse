import re

file_path = "resources/views/assignments/ielts/writing/practice_toolbar.blade.php"
with open(file_path, "r") as f:
    content = f.read()

# 1. Hide SVGs on desktop
content = content.replace('<svg class="w-5 h-5"', '<svg class="w-5 h-5 block md:hidden"')

# 2. Add a drag handle inside the container
container_start = 'class="flex flex-col md:flex-row items-center justify-center gap-2 sm:gap-3 cursor-move select-none p-1 md:bg-white/90 md:backdrop-blur-sm md:p-3 md:rounded-2xl md:shadow-2xl md:border md:border-gray-200">'

drag_handle = """
    <!-- Drag Handle -->
    <div class="cursor-move p-2 text-gray-400 hover:text-gray-600 flex items-center justify-center opacity-50 hover:opacity-100" title="Drag to move">
        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24"><path d="M10 9h4V6h3l-5-5-5 5h3v3zm-1 1H6V7l-5 5 5 5v-3h3v-4zm14 2l-5-5v3h-3v4h3v3l5-5zm-9 3h-4v3H7l5 5 5-5h-3v-3z"></path></svg>
    </div>
"""

# The SVGs we replaced might have already had block md:hidden on them if I didn't replace them all?
# No, I removed it before. Let's be safe.
content = content.replace('<svg class="w-5 h-5 block md:hidden block md:hidden"', '<svg class="w-5 h-5 block md:hidden"')

if container_start in content and "Drag Handle" not in content:
    content = content.replace(container_start, container_start + drag_handle)

with open(file_path, "w") as f:
    f.write(content)

print("Updates applied.")
