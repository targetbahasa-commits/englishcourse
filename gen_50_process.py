import os
import random
import re
import urllib.request
import urllib.parse
import ssl
from concurrent.futures import ThreadPoolExecutor

ssl_ctx = ssl.create_default_context()
ssl_ctx.check_hostname = False
ssl_ctx.verify_mode = ssl.CERT_NONE

RAW_THEMES = [
    ("Water Cycle", "Evaporation -> Condensation -> Precipitation -> Water Collection"),
    ("Carbon Cycle", "Biosphere Exchange -> Soil/Pedosphere -> Geosphere Sink -> Hydrosphere -> Atmosphere Release"),
    ("Nitrogen Cycle", "Nitrogen Fixation -> Nitrification -> Assimilation -> Ammonification -> Denitrification"),
    ("Oxygen Cycle", "Photosynthesis (Plants) -> Oxygen in Atmosphere -> Respiration (Animals) -> CO2 Release -> Cycle Repeats"),
    ("Rock Cycle", "Magma Cooling -> Igneous Rock -> Weathering/Sediment -> Sedimentary Rock -> Metamorphic Rock -> Melting"),
    ("Food Chain", "Sunlight -> Producers (Plants) -> Primary Consumers -> Secondary Consumers -> Apex Predators"),
    ("Volcanic Eruption", "Magma Chamber Filling -> Upward Pressure -> Magma Ascent -> Vent Eruption -> Lava & Ash Fall"),
    ("Soil Formation", "Bedrock Weathering -> Disintegration -> Organic Matter Accumulation -> Humus Formation -> Topsoil Development"),
    ("Photosynthesis", "Sunlight Absorption -> CO2 & Water Intake -> Chloroplast Reaction -> Glucose Production -> Oxygen Release"),
    ("Greenhouse Effect", "Solar Radiation -> Earth Surface Absorption -> Heat Emission (Infrared) -> Trapped by Gases -> Warming"),
    ("Paper Manufacturing", "Wood Harvesting -> Pulping & Bleaching -> Mixing with Water -> Pressing & Drying -> Paper Rolls"),
    ("Glass Recycling", "Collection & Sorting -> Crushing into Cullet -> Melting at High Temp -> Molding/Blowing -> New Glass Bottles"),
    ("Plastic Bottle Production", "Resin Pellet Melting -> Preform Injection -> Blow Molding -> Cooling & Ejection -> Filling & Capping"),
    ("Cement Production", "Limestone & Clay Crushing -> Raw Meal Grinding -> Rotary Kiln Burning (Clinker) -> Cement Milling -> Packaging"),
    ("Water Purification", "Coagulation/Flocculation -> Sedimentation -> Filtration -> Disinfection (Chlorination) -> Clean Water Storage"),
    ("Wastewater Treatment", "Screening & Grit Removal -> Primary Clarification -> Aeration (Biological) -> Secondary Settling -> Discharge"),
    ("Chocolate Manufacturing", "Cocoa Pod Harvesting -> Fermentation & Drying -> Roasting & Winnowing -> Grinding to Cocoa Mass -> Conching & Molding"),
    ("Olive Oil Extraction", "Olive Harvesting -> Washing & Crushing -> Malaxation (Mixing) -> Centrifugal Separation -> Filtering & Bottling"),
    ("Aluminum Recycling", "Scrap Collection -> Shredding & Decoating -> Melting in Furnace -> Casting into Ingot -> Rolling into Sheets"),
    ("Coffee Production", "Cherry Picking -> Pulping & Washing -> Sun Drying -> Roasting Beans -> Grinding & Packaging"),
    ("Hydroelectric Power", "Dam Water Storage -> Penstock Flow -> Turbine Rotation -> Generator Activation -> Electricity Transmission"),
    ("Solar Power System", "Solar Panel Absorption -> Direct Current (DC) Gen -> Inverter Conversion (AC) -> Breaker Box -> Home Appliances"),
    ("Wind Turbine", "Wind Turns Blades -> Rotor Spins Shaft -> Gearbox Increases Speed -> Generator Produces Power -> Grid Distribution"),
    ("Geothermal Station", "Hot Water Extraction -> Steam Separation -> Turbine Turning -> Generator Power -> Cooling & Reinjection"),
    ("Coal-Fired Plant", "Coal Pulverization -> Boiler Combustion -> High-Pressure Steam -> Steam Turbine -> Generator Power"),
    ("Nuclear Power", "Uranium Fission Reaction -> Heat Generation -> Water to Steam -> Turbine Rotation -> Power Generation"),
    ("Tidal Power", "Incoming Tide Flow -> Underwater Turbines Spin -> Generator Activation -> Outgoing Tide Flow -> Power Transmission"),
    ("Biomass Energy", "Biomass Collection -> Combustion or Gasification -> Heat/Steam Production -> Turbine Generation -> Carbon Absorption by Plants"),
    ("Wave Energy", "Wave Motion -> Buoy/Oscillator Movement -> Hydraulic/Air Pressure -> Turbine Spin -> Electricity Output"),
    ("Household Electricity", "Power Plant Generation -> Step-Up Transformer -> High-Voltage Transmission -> Step-Down Substation -> Home Distribution"),
    ("Frog Life Cycle", "Eggs (Spawn) -> Tadpole -> Tadpole with Legs -> Froglet -> Adult Frog"),
    ("Butterfly Metamorphosis", "Egg on Leaf -> Caterpillar (Larva) -> Chrysalis (Pupa) -> Emerging -> Adult Butterfly"),
    ("Honeybee Life Cycle", "Queen Lays Egg -> Larva Feeding -> Pupa (Capped Cell) -> Emerging Bee -> Adult Worker Bee"),
    ("Salmon Lifecycle", "Eggs in River Gravel -> Alevin & Fry -> Smolt (Migration) -> Adult Ocean Salmon -> Spawning Run"),
    ("Sunflower Lifecycle", "Seed Planting -> Germination & Sprout -> Vegetative Growth -> Budding & Flowering -> Seed Production"),
    ("Mosquito Lifecycle", "Eggs on Water -> Larva (Wriggler) -> Pupa (Tumbler) -> Emerging Adult -> Flying Mosquito"),
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
    295, 110, 266, 212, 134, 262, 143, 169, 115, 258,
    243, 201, 222, 191, 300, 162, 238, 123, 248, 247,
    196, 244, 145, 153, 159, 180, 204, 288, 283, 139,
    226, 202, 140, 296, 236, 249, 131, 299, 224, 109,
    264, 186, 195, 246, 160, 121, 228, 291, 166, 188
]

OUTPUT_DIR = "/Applications/MAMP/htdocs/TargetBahasaCourse/public/storage/describe-image"

def download_image(args):
    tid, title, steps = args
    prompt = f"A highly realistic, professional educational process diagram infographic showing {title}. Clean white background, 3D colorful modern design, clean and attractive, no messy text. Clear visual representation of: {steps}."
    encoded = urllib.parse.quote(prompt)
    url = f"https://image.pollinations.ai/prompt/{encoded}?width=900&height=600&nologo=true"
    fp = os.path.join(OUTPUT_DIR, f"di_topic_{tid}.png")
    
    try:
        for attempt in range(2):
            try:
                req = urllib.request.Request(url, headers={'User-Agent': 'Mozilla/5.0'})
                with urllib.request.urlopen(req, context=ssl_ctx, timeout=15) as response:
                    with open(fp, 'wb') as f:
                        f.write(response.read())
                return f"[{tid}] Success: {title}"
            except Exception as e:
                if attempt == 1:
                    raise e
                time.sleep(2)
    except Exception as e:
        return f"[{tid}] Failed: {title} ({str(e)})"

import time
import subprocess

def send_notification(count):
    msg = f"Proses telah mencapai {count} dari 50!"
    title = f"Notifikasi Progress ({count}/50)"
    try:
        subprocess.run(["osascript", "-e", f'display notification "{msg}" with title "{title}"'], check=False)
    except Exception as e:
        pass

def main():
    print("Generating 50 AI process diagrams using Pollinations API sequentially...")
    tasks = []
    for i, (title, steps_str) in enumerate(RAW_THEMES):
        tid = ASSIGNED_IDS[i]
        tasks.append((tid, title, steps_str))
        
    for i, task in enumerate(tasks, 1):
        print(download_image(task))
        
        # Send notification at milestones 20, 30, 40, and 50
        if i in [20, 30, 40, 50]:
            print(f"\n==========================================")
            print(f"🔔 NOTIFIKASI: Telah mencapai {i} dari 50!")
            print(f"==========================================\n")
            send_notification(i)
            
        time.sleep(1) # prevent rate limit
            
    print("All AI images generated.")

if __name__ == '__main__':
    main()

