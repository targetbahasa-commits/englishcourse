import ftplib

ftp = ftplib.FTP('153.92.9.128')
ftp.login('u822472458', '@Dreamer19')

files = [
    # 1. Controller dengan method baru getSourceAudioFilesList + path fix
    ('app/Http/Controllers/AssignmentController.php',
     '/domains/targetbahasa.com/public_html/app/Http/Controllers/AssignmentController.php'),

    # 2. Routes dengan endpoint /api/audio-files
    ('routes/web.php',
     '/domains/targetbahasa.com/public_html/routes/web.php'),

    # 3. Admin modals view dengan AJAX file browser
    ('resources/views/assignments/toefl-itp/listening/partials/admin-modals.blade.php',
     '/domains/targetbahasa.com/public_html/resources/views/assignments/toefl-itp/listening/partials/admin-modals.blade.php'),
]

for local, remote in files:
    print(f"Uploading: {local}...")
    with open(local, 'rb') as f:
        ftp.storbinary(f'STOR {remote}', f)
    print(f"  OK: {local}")

ftp.quit()
print("\nDone! Choose Audio fix deployed to targetbahasa.com")
