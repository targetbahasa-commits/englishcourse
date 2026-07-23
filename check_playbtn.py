import os

files_with_playbtn = []
for root, dirs, files in os.walk('resources/views/assignments/pte-academic/'):
    for file in files:
        if file.endswith('.blade.php'):
            path = os.path.join(root, file)
            with open(path, 'r') as f:
                content = f.read()
            if "playBtn.addEventListener('click'" in content:
                files_with_playbtn.append(path)

for path in files_with_playbtn:
    print(path)
