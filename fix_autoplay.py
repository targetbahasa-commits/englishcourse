import os
import re

target_block = """        // Auto start
        window.addEventListener('load', () => {
            startPrepTimer();
        });"""

replacement_block = """        // Auto start
        window.addEventListener('load', () => {
            let startBtn = document.getElementById('startTimerBtn');
            if (startBtn) {
                startBtn.style.display = 'inline-block';
            }
            let prepTimer = document.getElementById('prepTimer');
            if (prepTimer && prepTimer.parentElement) {
                prepTimer.parentElement.innerHTML = 'Status: <span class="teal-text">Waiting to Start</span>';
            }
        });"""

for root, dirs, files in os.walk('resources/views/assignments/pte-academic/'):
    for file in files:
        if file.endswith('.blade.php'):
            path = os.path.join(root, file)
            with open(path, 'r') as f:
                content = f.read()
            
            if target_block in content:
                content = content.replace(target_block, replacement_block)
                with open(path, 'w') as f:
                    f.write(content)
                print(f"Fixed {path}")
