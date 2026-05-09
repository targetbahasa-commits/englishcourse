import ftplib

ftp = ftplib.FTP('153.92.9.128')
ftp.login('u822472458', '@Dreamer19')

print("Listing /domains/targetbahasa.com/public_html:")
try:
    ftp.dir('/domains/targetbahasa.com/public_html')
except Exception as e:
    print(e)

print("\nListing /domains/targetbahasa.com/public_html/public:")
try:
    ftp.dir('/domains/targetbahasa.com/public_html/public')
except Exception as e:
    print(e)

ftp.quit()
