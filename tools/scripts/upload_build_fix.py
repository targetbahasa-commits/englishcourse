import ftplib
import os

print("Connecting to FTP...")
ftp = ftplib.FTP('153.92.9.128')
ftp.login('u822472458', '@Dreamer19')

base_dir = '/domains/targetbahasa.com/public_html/public/build'

# Try to make base_dir if it doesn't exist
try:
    ftp.mkd(base_dir)
except:
    pass
    
try:
    ftp.mkd(base_dir + '/assets')
except:
    pass

local_build = "public/build"

# Upload manifest.json
print("Uploading manifest.json...")
with open(os.path.join(local_build, "manifest.json"), 'rb') as f:
    ftp.storbinary(f'STOR {base_dir}/manifest.json', f)

# Upload assets
for item in os.listdir(os.path.join(local_build, "assets")):
    local_path = os.path.join(local_build, "assets", item)
    if os.path.isfile(local_path):
        print(f"Uploading {item}...")
        with open(local_path, 'rb') as f:
            ftp.storbinary(f'STOR {base_dir}/assets/{item}', f)

ftp.quit()
print("Done uploading fixed build!")
