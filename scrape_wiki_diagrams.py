import os
import json
import urllib.request
import urllib.parse
import ssl
import time

ssl_ctx = ssl.create_default_context()
ssl_ctx.check_hostname = False
ssl_ctx.verify_mode = ssl.CERT_NONE

OUT_DIR = "public/storage/describe-image"
os.makedirs(OUT_DIR, exist_ok=True)

# Map topic ID to Wikipedia page title or Commons search term
TOPICS = {
    110: ("Carbon cycle", "page"),
    115: ("Photosynthesis", "page"),
    134: ("Rock cycle", "page"),
    143: ("Volcano", "page"),
    169: ("Soil", "page"),
    212: ("Oxygen cycle", "page"),
    258: ("Greenhouse effect", "page"),
    262: ("Food chain", "page"),
    266: ("Nitrogen cycle", "page"),
    295: ("Water cycle", "page"),
    123: ("Olive oil extraction", "page"),
    162: ("Sewage treatment", "page"),
    191: ("Cement", "page"),
    201: ("Glass recycling", "page"),
    222: ("Plastic recycling", "page"),
    238: ("Chocolate", "page"),
    243: ("Papermaking", "page"),
    247: ("Coffee production", "page"),
    248: ("Aluminium recycling", "page"),
    300: ("Water purification", "page"),
    139: ("Electric power distribution", "page"),
    145: ("Wind turbine", "page"),
    153: ("Geothermal power", "page"),
    159: ("Thermal power station", "page"),
    180: ("Nuclear power plant", "page"),
    196: ("Hydroelectricity", "page"),
    204: ("Tidal power", "page"),
    244: ("Photovoltaic system", "page"),
    283: ("Wave power", "page"),
    288: ("Biomass", "page"),
    109: ("Coccinellidae", "page"),
    131: ("Chicken", "page"),
    140: ("Honey bee", "page"),
    202: ("Butterfly", "page"),
    224: ("Sea turtle", "page"),
    226: ("Frog", "page"),
    236: ("Sunflower", "page"),
    249: ("Mosquito", "page"),
    296: ("Salmon", "page"),
    299: ("Mushroom", "page"),
    # Business processes
    121: ("Hotel", "page"),
    160: ("Supply chain", "page"),
    166: ("Airport", "page"),
    186: ("Recruitment", "page"),
    188: ("Online food ordering", "page"),
    195: ("New product development", "page"),
    228: ("Library", "page"),
    246: ("Customer complaint", "page"),
    264: ("Order fulfillment", "page"),
    291: ("Software bug", "page")
}

def get_wikipedia_image(title):
    url = f"https://en.wikipedia.org/w/api.php?action=query&titles={urllib.parse.quote(title)}&prop=pageimages&pithumbsize=1200&format=json"
    req = urllib.request.Request(url, headers={'User-Agent': 'Mozilla/5.0'})
    try:
        with urllib.request.urlopen(req, context=ssl_ctx, timeout=10) as response:
            data = json.loads(response.read())
            pages = data.get('query', {}).get('pages', {})
            for p in pages.values():
                if 'thumbnail' in p:
                    return p['thumbnail']['source']
    except Exception as e:
        print(f"Error fetching Wikipedia page for {title}: {e}")
    return None

def search_commons_diagram(query):
    url = f"https://commons.wikimedia.org/w/api.php?action=query&list=search&srsearch={urllib.parse.quote(query)}&srnamespace=6&format=json&srlimit=1"
    req = urllib.request.Request(url, headers={'User-Agent': 'Mozilla/5.0'})
    try:
        with urllib.request.urlopen(req, context=ssl_ctx, timeout=10) as response:
            data = json.loads(response.read())
            results = data.get('query', {}).get('search', [])
            if results:
                title = results[0]['title']
                url2 = f"https://commons.wikimedia.org/w/api.php?action=query&titles={urllib.parse.quote(title)}&prop=imageinfo&iiprop=url&format=json"
                req2 = urllib.request.Request(url2, headers={'User-Agent': 'Mozilla/5.0'})
                with urllib.request.urlopen(req2, context=ssl_ctx, timeout=10) as r2:
                    d2 = json.loads(r2.read())
                    pages = d2.get('query', {}).get('pages', {})
                    for p in pages.values():
                        if 'imageinfo' in p:
                            return p['imageinfo'][0]['url']
    except Exception as e:
        print(f"Error fetching Commons for {query}: {e}")
    return None

def download_image(url, fp):
    try:
        req = urllib.request.Request(url, headers={'User-Agent': 'Mozilla/5.0'})
        with urllib.request.urlopen(req, context=ssl_ctx, timeout=15) as r:
            data = r.read()
            with open(fp, 'wb') as f:
                f.write(data)
            return True
    except Exception as e:
        print(f"Failed to download {url}: {e}")
        return False

print("Starting to fetch real Wikipedia/Commons images...")
success = 0
for tid, (query, qtype) in TOPICS.items():
    print(f"[{tid}] Searching {query}...")
    img_url = None
    if qtype == "page":
        img_url = get_wikipedia_image(query)
    
    if not img_url:
        # Fallback to commons search
        img_url = search_commons_diagram(f"{query} diagram english")
        if not img_url:
            img_url = search_commons_diagram(f"{query} flowchart")
            
    if img_url:
        fp = os.path.join(OUT_DIR, f"di_topic_{tid}.png")
        if download_image(img_url, fp):
            print(f"  ✓ Success: {img_url.split('/')[-1][:30]}")
            success += 1
        else:
            print("  ✗ Failed to download")
    else:
        print("  ✗ No image found on Wikipedia")
    time.sleep(1)

print(f"\nDone! {success}/{len(TOPICS)} images successfully downloaded from Wikipedia.")
