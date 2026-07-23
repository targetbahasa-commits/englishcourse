import os
path = "resources/views/assignments/pte-academic/summarize-spoken-text/practice.blade.php"
with open(path, 'r') as f:
    content = f.read()
if "playBtn.addEventListener('click'" in content:
    print("Found in SST")
else:
    print("Not found in SST")
