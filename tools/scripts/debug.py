import ftplib

ftp = ftplib.FTP('153.92.9.128')
ftp.login('u822472458', '@Dreamer19')

with open('env_local', 'wb') as f:
    ftp.retrbinary('RETR /domains/targetbahasa.com/public_html/.env', f.write)

with open('env_local', 'r') as f:
    content = f.read()

content = content.replace('APP_DEBUG=false', 'APP_DEBUG=true')

with open('env_local', 'w') as f:
    f.write(content)

with open('env_local', 'rb') as f:
    ftp.storbinary('STOR /domains/targetbahasa.com/public_html/.env', f)

ftp.quit()
