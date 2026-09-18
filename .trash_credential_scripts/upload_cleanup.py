import os
import ftplib

FTP_HOST = "153.92.9.128"
FTP_USER = "u822472458"
FTP_PASS = "@Dreamer19"

ftp = ftplib.FTP(FTP_HOST)
ftp.login(FTP_USER, FTP_PASS)
try:
    ftp.delete('/domains/targetbahasa.com/public_html/public/run_migration_live.php')
    print("Deleted migrator from live server.")
except Exception as e:
    print(f"Error deleting: {e}")
ftp.quit()
