with open('resources/views/assignments/ielts/writing/practice_toolbar.blade.php', 'r') as f:
    content = f.read()

content = content.replace('min-w-[250px]', 'min-w-[150px] md:min-w-[250px]')
content = content.replace('p-4 align-top', 'p-2 md:p-4 align-top')
content = content.replace('text-lg text-left', 'text-base md:text-lg text-left')
content = content.replace('text-2xl font-bold', 'text-lg md:text-2xl font-bold')
content = content.replace('py-4">Present', 'py-2 md:py-4">Present')
content = content.replace('py-4">Past', 'py-2 md:py-4">Past')
content = content.replace('py-4">Future', 'py-2 md:py-4">Future')
content = content.replace('p-6 max-w-6xl', 'p-3 md:p-6 max-w-6xl')
content = content.replace('mb-1 text-base', 'mb-1 text-xs md:text-base')

with open('resources/views/assignments/ielts/writing/practice_toolbar.blade.php', 'w') as f:
    f.write(content)
