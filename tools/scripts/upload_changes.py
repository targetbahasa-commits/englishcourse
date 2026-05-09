import ftplib

ftp = ftplib.FTP('153.92.9.128')
ftp.login('u822472458', '@Dreamer19')

files = [
    ('app/Http/Controllers/Auth/RegisteredUserController.php',
     '/domains/targetbahasa.com/public_html/app/Http/Controllers/Auth/RegisteredUserController.php'),
    ('resources/views/auth/register-student.blade.php',
     '/domains/targetbahasa.com/public_html/resources/views/auth/register-student.blade.php'),
]

for local, remote in files:
    with open(local, 'rb') as f:
        ftp.storbinary(f'STOR {remote}', f)
    print(f"Uploaded: {local}")

ftp.quit()
