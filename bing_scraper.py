import urllib.request, urllib.parse
from bs4 import BeautifulSoup
import re
import ssl
import json

ssl_ctx = ssl.create_default_context()
ssl_ctx.check_hostname = False
ssl_ctx.verify_mode = ssl.CERT_NONE

def get_bing_image(query):
    query = urllib.parse.quote(query)
    url = f"https://www.bing.com/images/search?q={query}&qft=+filterui:imagesize-large"
    req = urllib.request.Request(url, headers={'User-Agent': 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.124 Safari/537.36'})
    try:
        with urllib.request.urlopen(req, context=ssl_ctx) as response:
            html = response.read().decode('utf-8')
            soup = BeautifulSoup(html, 'html.parser')
            for a in soup.find_all('a', class_='iusc'):
                m = json.loads(a.get('m', '{}'))
                img_url = m.get('murl')
                if img_url:
                    return img_url
    except Exception as e:
        print("Error:", e)
    return None

print("Test 1:", get_bing_image("water cycle diagram pte"))
print("Test 2:", get_bing_image("infographic paper manufacturing"))
