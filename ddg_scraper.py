import urllib.request, urllib.parse
from bs4 import BeautifulSoup
import re
import ssl
import json

ssl_ctx = ssl.create_default_context()
ssl_ctx.check_hostname = False
ssl_ctx.verify_mode = ssl.CERT_NONE

def get_ddg_image(query):
    query = urllib.parse.quote(query)
    url = f"https://html.duckduckgo.com/html/?q={query}"
    req = urllib.request.Request(url, headers={'User-Agent': 'Mozilla/5.0 (Windows NT 10.0; rv:91.0) Gecko/20100101 Firefox/91.0'})
    try:
        with urllib.request.urlopen(req, context=ssl_ctx) as response:
            html = response.read().decode('utf-8')
            soup = BeautifulSoup(html, 'html.parser')
            print("Found images in DDG HTML:")
            for img in soup.find_all('img'):
                print(img.get('src'))
    except Exception as e:
        print("Error:", e)

get_ddg_image("water cycle diagram pte")
