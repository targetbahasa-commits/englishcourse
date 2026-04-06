import ftplib

ftp = ftplib.FTP('153.92.9.128')
ftp.login('u822472458', '@Dreamer19')

dirs = [
    '/domains/targetbahasa.com/public_html/storage',
    '/domains/targetbahasa.com/public_html/storage/framework',
    '/domains/targetbahasa.com/public_html/storage/framework/cache',
    '/domains/targetbahasa.com/public_html/storage/framework/cache/data',
    '/domains/targetbahasa.com/public_html/storage/framework/sessions',
    '/domains/targetbahasa.com/public_html/storage/framework/views',
    '/domains/targetbahasa.com/public_html/storage/logs'
]

for d in dirs:
    try:
        ftp.mkd(d)
        print(f"Created {d}")
    except Exception as e:
        print(f"Skipped {d} - {e}")

ftp.quit()
