import ftplib
import os

ftp = ftplib.FTP('153.92.9.128')
ftp.login('u822472458', '@Dreamer19')

# Check if directory exists
try:
    ftp.nlst('/domains/targetbahasa.com/public_html/database')
except:
    ftp.mkd('/domains/targetbahasa.com/public_html/database')

try:
    with open('database/database.sqlite', 'rb') as f:
        ftp.storbinary('STOR /domains/targetbahasa.com/public_html/database/database.sqlite', f)
    print("Database uploaded successfully.")
except Exception as e:
    print(f"Error uploading database: {e}")

ftp.quit()
