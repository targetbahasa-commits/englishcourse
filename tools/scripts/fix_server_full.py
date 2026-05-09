import ftplib
import traceback

try:
    ftp = ftplib.FTP('153.92.9.128')
    ftp.login('u822472458', '@Dreamer19')
    
    # 1. Check if laravel_app/vendor exists
    laravel_files = ftp.nlst('/domains/targetbahasa.com/laravel_app/')
    has_vendor = '/domains/targetbahasa.com/laravel_app/vendor' in laravel_files or 'vendor' in [f.split('/')[-1] for f in laravel_files]
    print(f"laravel_app has vendor: {has_vendor}")
    
    # 2. Check if laravel_app/.env exists
    has_env = '/domains/targetbahasa.com/laravel_app/.env' in laravel_files or '.env' in [f.split('/')[-1] for f in laravel_files]
    print(f"laravel_app has .env: {has_env}")
    
    # 3. If .env doesn't exist, try to copy it from public_html
    if not has_env:
        print("Copying .env from public_html to laravel_app...")
        with open('temp_env', 'wb') as f:
            ftp.retrbinary('RETR /domains/targetbahasa.com/public_html/.env', f.write)
        with open('temp_env', 'rb') as f:
            ftp.storbinary('STOR /domains/targetbahasa.com/laravel_app/.env', f)
            print("Copied .env")
            
    # 4. If vendor doesn't exist in laravel_app, we CANNOT boot from it unless we move it!
    # So we should check what public_html has.
    public_files = ftp.nlst('/domains/targetbahasa.com/public_html/')
    public_has_vendor = '/domains/targetbahasa.com/public_html/vendor' in public_files or 'vendor' in [f.split('/')[-1] for f in public_files]
    print(f"public_html has vendor: {public_has_vendor}")
    
    ftp.quit()
except Exception as e:
    print("Error:", e)
    traceback.print_exc()
