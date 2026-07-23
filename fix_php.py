import os

target = "@php($sidebarRole = strtolower(Auth::user()->active_role ?? 'student'))"
replacement = "<?php $sidebarRole = strtolower(Auth::user()->active_role ?? 'student'); ?>"

target2 = "@php($activeRole = strtolower(Auth::user()->active_role ?? 'student'))"
replacement2 = "<?php $activeRole = strtolower(Auth::user()->active_role ?? 'student'); ?>"

target3 = "@php($vocabItems = is_array($data['vocab'] ?? null) ? $data['vocab'] : [])"
replacement3 = "<?php $vocabItems = is_array($data['vocab'] ?? null) ? $data['vocab'] : []; ?>"

for root, dirs, files in os.walk('resources/views'):
    for file in files:
        if file.endswith('.blade.php'):
            path = os.path.join(root, file)
            with open(path, 'r') as f:
                content = f.read()
            
            if target in content or target2 in content or target3 in content:
                content = content.replace(target, replacement)
                content = content.replace(target2, replacement2)
                content = content.replace(target3, replacement3)
                
                with open(path, 'w') as f:
                    f.write(content)
                print(f"Fixed {path}")
