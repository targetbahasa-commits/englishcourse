import os
import random
import re
import urllib.request
import urllib.parse
import ssl
import time

ssl_ctx = ssl.create_default_context()
ssl_ctx.check_hostname = False
ssl_ctx.verify_mode = ssl.CERT_NONE

RAW_THEMES = [
    ("Carbon Cycle", "Biosphere Exchange -> Soil/Pedosphere -> Geosphere Sink -> Hydrosphere -> Atmosphere Release"),
    ("Rock Cycle", "Magma Cooling -> Igneous Rock -> Weathering/Sediment -> Sedimentary Rock -> Metamorphic Rock -> Melting"),
    ("Glass Recycling", "Collection & Sorting -> Crushing into Cullet -> Melting at High Temp -> Molding/Blowing -> New Glass Bottles"),
    ("Water Purification", "Coagulation/Flocculation -> Sedimentation -> Filtration -> Disinfection (Chlorination) -> Clean Water Storage"),
    ("Wave Energy", "Wave Motion -> Buoy/Oscillator Movement -> Hydraulic/Air Pressure -> Turbine Spin -> Electricity Output"),
    ("Chicken Life Cycle", "Egg Laying -> Incubation Period -> Hatching -> Chick Development -> Adult Chicken"),
    ("Mushroom Life Cycle", "Spore Release -> Spore Germination -> Mycelium Growth -> Primordia (Pinhead) -> Mature Fruiting Body"),
    ("Sea Turtle Lifecycle", "Egg Laying on Beach -> Hatchlings Run to Sea -> Open Ocean Growth -> Coastal Feeding -> Return to Natal Beach"),
    ("Ladybug Lifecycle", "Yellow Eggs -> Spiky Larva -> Pupa Attached to Leaf -> Emerging Ladybug -> Adult Ladybug"),
    ("E-Commerce Fulfillment", "Customer Checkout -> Payment Processing -> Warehouse Picking -> Packing & Labeling -> Courier Delivery"),
    ("Recruitment Process", "Job Posting -> Resume Screening -> Initial Interview -> Assessment/Test -> Job Offer"),
    ("Product Development", "Idea Generation -> Market Research -> Design & Prototyping -> Testing & QA -> Product Launch"),
    ("Customer Complaint", "Ticket Received -> Support Triage -> Technical Escalation -> Issue Resolution -> Customer Feedback"),
    ("Supply Chain", "Raw Material Sourcing -> Factory Production -> Distribution Center -> Retail Store -> End Consumer"),
    ("Hotel Check-In", "Booking Confirmation -> Identity Verification -> Payment/Deposit -> Key Issuance -> Room Occupancy"),
    ("Library Borrowing", "Catalog Search -> Book Retrieval -> ID Scanning -> Loan Period -> Book Return"),
    ("Software Bug Fixing", "User Reports Error -> QA Verification -> Developer Debugging -> Code Patch & Test -> Software Update Release"),
    ("Airport Departure", "Terminal Entry -> Baggage Drop & Check-In -> Immigration/Passport -> Security Screening -> Boarding Gate"),
    ("Food Delivery App", "Order Placement -> Restaurant Prep -> Driver Pickup -> En-Route Tracking -> Doorstep Delivery")
]

ASSIGNED_IDS = [
    110, 134, 201, 300, 283, 131, 299, 224, 109, 264,
    186, 195, 246, 160, 121, 228, 291, 166, 188
]

OUTPUT_DIR = "/Applications/MAMP/htdocs/TargetBahasaCourse/public/storage/describe-image"

def download_image(args):
    tid, title, steps = args
    prompt = f"A highly realistic, professional educational process diagram infographic showing {title}. Clean white background, 3D colorful modern design, clean and attractive, no messy text. Clear visual representation of: {steps}."
    encoded = urllib.parse.quote(prompt)
    # Using a different free pollinations endpoint or format to maybe bypass cache/rate-limit?
    # Just standard is fine. Let's add a random string to bypass caching.
    url = f"https://image.pollinations.ai/prompt/{encoded}?width=900&height=600&nologo=true&seed={random.randint(1,10000)}"
    fp = os.path.join(OUTPUT_DIR, f"di_topic_{tid}.png")
    
    try:
        for attempt in range(2):
            try:
                req = urllib.request.Request(url, headers={'User-Agent': 'Mozilla/5.0'})
                with urllib.request.urlopen(req, context=ssl_ctx, timeout=20) as response:
                    with open(fp, 'wb') as f:
                        f.write(response.read())
                return f"[{tid}] Success: {title}"
            except Exception as e:
                if attempt == 1:
                    raise e
                time.sleep(3)
    except Exception as e:
        return f"[{tid}] Failed: {title} ({str(e)})"

def main():
    print("Retrying 19 failed AI process diagrams using Pollinations API sequentially...")
    tasks = []
    for i, (title, steps_str) in enumerate(RAW_THEMES):
        tid = ASSIGNED_IDS[i]
        tasks.append((tid, title, steps_str))
        
    for task in tasks:
        print(download_image(task))
        time.sleep(2) # longer sleep to prevent rate limit
            
    print("All retry images generated.")

if __name__ == '__main__':
    main()
