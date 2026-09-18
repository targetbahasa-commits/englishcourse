import os
import ftplib

FTP_HOST = "153.92.9.128"
FTP_USER = "u822472458"
FTP_PASS = "@Dreamer19"

def ensure_dir_exists(ftp, remote_dir):
    parts = [p for p in remote_dir.split('/') if p]
    current = ""
    for p in parts:
        current += "/" + p
        try:
            ftp.cwd(current)
        except ftplib.error_perm:
            ftp.mkd(current)
            ftp.cwd(current)

ftp = ftplib.FTP()
ftp.connect(FTP_HOST)
ftp.login(FTP_USER, FTP_PASS)
ftp.cwd('/')

local_path = "resources/views/assignments/pte-academic/summarize-spoken-text/practice.blade.php"

target = """        // Auto start prep timer on load like the other modules
        window.addEventListener('load', () => {"""

replacement = """        // Auto start prep timer on load like the other modules
        if (playBtn) {
            playBtn.addEventListener('click', () => {
                if (typeof startTimerBtn !== 'undefined' && startTimerBtn && startTimerBtn.style.display !== 'none') {
                    startPrepTimer();
                    return;
                }
                if (prepTime > 0) return;
                if(isAudioPlaying) {
                    audioObj.pause();
                    isAudioPlaying = false;
                    playBtn.innerHTML = '<svg class="w-6 h-6 ml-1" fill="currentColor" viewBox="0 0 20 20"><path d="M4 4l12 6-12 6z"></path></svg>';
                } else {
                    audioObj.play().catch(e => console.error(e));
                    isAudioPlaying = true;
                    playBtn.innerHTML = '<svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zM7 8a1 1 0 012 0v4a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v4a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd"></path></svg>';
                }
            });
        }
        
        window.addEventListener('load', () => {"""

with open(local_path, 'r') as f:
    content = f.read()

if target in content:
    content = content.replace(target, replacement)
    with open(local_path, 'w') as f:
        f.write(content)
        
    print(f"Uploading {local_path}...")
    remote_path = "/domains/targetbahasa.com/public_html/" + local_path
    remote_dir = os.path.dirname(remote_path)
    ensure_dir_exists(ftp, remote_dir)
    with open(local_path, 'rb') as f:
        ftp.storbinary(f'STOR {remote_path}', f)

ftp.quit()
