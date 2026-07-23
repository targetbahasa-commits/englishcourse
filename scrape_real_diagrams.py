import os
import time
import urllib.request
import ssl
from duckduckgo_search import DDGS

ssl_ctx = ssl.create_default_context()
ssl_ctx.check_hostname = False
ssl_ctx.verify_mode = ssl.CERT_NONE

OUT_DIR = "public/storage/describe-image"
os.makedirs(OUT_DIR, exist_ok=True)

TOPICS = [
    (110, "Carbon Cycle educational science diagram infographic"),
    (115, "Photosynthesis educational diagram biology infographic"),
    (134, "Rock Cycle educational diagram geology infographic"),
    (143, "Volcanic Eruption cross section educational diagram"),
    (169, "Soil Formation profile horizons educational diagram"),
    (212, "Oxygen Cycle educational science diagram infographic"),
    (258, "Greenhouse Effect educational science diagram infographic"),
    (262, "Food Chain educational biology diagram infographic"),
    (266, "Nitrogen Cycle educational science diagram infographic"),
    (295, "Water Cycle educational science diagram infographic"),
    (123, "Olive Oil Extraction process flow educational diagram"),
    (162, "Wastewater Treatment process flow educational diagram"),
    (191, "Cement Production process flow educational diagram"),
    (201, "Glass Recycling process flow educational diagram"),
    (222, "Plastic Bottle Production process flow educational diagram"),
    (238, "Chocolate Manufacturing process flow educational diagram"),
    (243, "Paper Manufacturing process flow educational diagram"),
    (247, "Coffee Production process flow educational diagram"),
    (248, "Aluminum Recycling process flow educational diagram"),
    (300, "Water Purification process flow educational diagram"),
    (139, "Household Electricity Distribution educational diagram"),
    (145, "Wind Turbine Energy Generation educational diagram"),
    (153, "Geothermal Power Station cross section educational diagram"),
    (159, "Coal-Fired Power Plant cross section educational diagram"),
    (180, "Nuclear Power Plant cross section educational diagram"),
    (196, "Hydroelectric Power Plant cross section educational diagram"),
    (204, "Tidal Power Generation educational diagram"),
    (244, "Solar Power System educational diagram"),
    (283, "Wave Energy Converter educational diagram"),
    (288, "Biomass Energy Cycle educational diagram"),
    (109, "Ladybug Lifecycle educational biology diagram"),
    (131, "Chicken Life Cycle educational biology diagram"),
    (140, "Honeybee Life Cycle educational biology diagram"),
    (202, "Butterfly Metamorphosis educational biology diagram"),
    (224, "Sea Turtle Lifecycle educational biology diagram"),
    (226, "Frog Life Cycle educational biology diagram"),
    (236, "Sunflower Lifecycle educational biology diagram"),
    (249, "Mosquito Lifecycle educational biology diagram"),
    (296, "Salmon Lifecycle educational biology diagram"),
    (299, "Mushroom Life Cycle educational biology diagram"),
    (121, "Hotel Check-In process flow diagram infographic"),
    (160, "Supply Chain Logistics process flow diagram infographic"),
    (166, "Airport Passenger Departure process flow diagram infographic"),
    (186, "Recruitment Process flow diagram infographic"),
    (188, "Food Delivery App process flow diagram infographic"),
    (195, "Product Development process flow diagram infographic"),
    (228, "Library Book Borrowing process flow diagram infographic"),
    (246, "Customer Complaint Handling process flow diagram infographic"),
    (264, "E-Commerce Order Fulfillment process flow diagram infographic"),
    (291, "Software Bug Fixing process flow diagram infographic")
]

def search_and_download(tid, query):
    fp = os.path.join(OUT_DIR, f"di_topic_{tid}.png")
    print(f"[{tid}] Searching: {query}...")
    try:
        results = DDGS().images(query, max_results=3)
        for i, res in enumerate(results):
            img_url = res['image']
            print(f"  Attempt {i+1} downloading {img_url[:60]}...")
            try:
                req = urllib.request.Request(img_url, headers={'User-Agent': 'Mozilla/5.0'})
                with urllib.request.urlopen(req, context=ssl_ctx, timeout=10) as r:
                    data = r.read()
                    if len(data) > 30000:  # must be > 30KB
                        with open(fp, 'wb') as f:
                            f.write(data)
                        print(f"  ✓ Success: {len(data)//1024}KB")
                        return True
                    else:
                        print(f"  ✗ Too small: {len(data)}B")
            except Exception as e:
                print(f"  ✗ Failed download: {e}")
            time.sleep(2)
        print(f"[{tid}] ALL ATTEMPTS FAILED")
        return False
    except Exception as e:
        print(f"[{tid}] Search error: {e}")
        return False

print("Starting to pull real educational diagrams...")
success = 0
for tid, query in TOPICS:
    if search_and_download(tid, query):
        success += 1
    time.sleep(1)

print(f"\nDone! {success}/{len(TOPICS)} images successfully downloaded.")
