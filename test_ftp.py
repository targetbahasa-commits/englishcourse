import ftplib
ftp = ftplib.FTP('153.92.9.128')
ftp.login(user='u822472458', passwd='@Dreamer19')
with open('downloaded_sst.php', 'wb') as f:
    ftp.retrbinary('RETR /domains/targetbahasa.com/public_html/config/pte_listening_sst_topics.php', f.write)
ftp.quit()
