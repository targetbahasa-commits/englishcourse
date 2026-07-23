#!/usr/bin/env python3
"""
Download real public-domain PTE-style describe images from:
- Wikimedia Commons (Wikipedia images, freely licensed)
- Our World in Data (open-licensed charts)

These are all freely licensed (CC BY / CC BY-SA / public domain).
"""

import os
import sys
import urllib.request
import urllib.parse
import ssl
import json
import time

OUTPUT_DIR = "/Applications/MAMP/htdocs/TargetBahasaCourse/public/storage/describe-image"
os.makedirs(OUTPUT_DIR, exist_ok=True)

ssl_ctx = ssl.create_default_context()
ssl_ctx.check_hostname = False
ssl_ctx.verify_mode = ssl.CERT_NONE

HEADERS = {
    "User-Agent": "Mozilla/5.0 (compatible; TargetBahasa/1.0; Educational)",
    "Accept": "image/webp,image/png,image/*",
}

def download(url, filepath, retries=3):
    for attempt in range(retries):
        try:
            req = urllib.request.Request(url, headers=HEADERS)
            with urllib.request.urlopen(req, context=ssl_ctx, timeout=30) as resp:
                data = resp.read()
            if len(data) < 5000:
                print(f"  File too small ({len(data)} bytes), skipping")
                return False
            with open(filepath, 'wb') as f:
                f.write(data)
            return True
        except Exception as e:
            print(f"  Attempt {attempt+1} failed: {e}")
            time.sleep(2)
    return False

def get_wikimedia_url(filename):
    """Get direct URL for a Wikimedia Commons file."""
    api_url = f"https://en.wikipedia.org/w/api.php?action=query&titles=File:{urllib.parse.quote(filename)}&prop=imageinfo&iiprop=url&format=json"
    try:
        req = urllib.request.Request(api_url, headers={"User-Agent": "TargetBahasa/1.0"})
        with urllib.request.urlopen(req, context=ssl_ctx, timeout=15) as resp:
            data = json.loads(resp.read())
        pages = data['query']['pages']
        for page in pages.values():
            if 'imageinfo' in page:
                return page['imageinfo'][0]['url']
    except Exception as e:
        print(f"  API error for {filename}: {e}")
    return None

# ─── List of real public-domain images from Wikimedia Commons ─────────────────
# Format: (topic_id, wikimedia_filename, title_for_config)
# All images are freely licensed (CC BY-SA, CC BY, or public domain)

WIKIMEDIA_IMAGES = [
    # PROCESS DIAGRAMS / FLOWCHARTS
    (301, "How_nuclear_power_works.svg", "How Nuclear Power Works (Process Diagram)"),
    (302, "Carbon_cycle.jpg", "The Carbon Cycle (Environmental Process)"),
    (303, "Photosynthesis_en.svg", "Process of Photosynthesis in Plants"),
    (304, "Water_cycle.png", "The Global Water Cycle (Hydrological Cycle)"),
    (305, "How_solar_cells_work.svg", "How Solar Cells Generate Electricity"),
    (306, "DNA_replication_en.svg", "DNA Replication Process (Biology Diagram)"),
    (307, "Nitrogen_cycle.jpg", "The Nitrogen Cycle (Ecosystem Process)"),
    (308, "Immune_response.svg", "The Human Immune Response Process"),
    (309, "Composting_Basics.jpg", "The Composting Process (Organic Waste)"),
    (310, "Rock_cycle.jpg", "The Rock Cycle (Geological Process)"),

    # MAPS / CHOROPLETH
    (311, "World_map_of_Countries_by_Literacy_Rate.svg", "World Map: Countries by Literacy Rate"),
    (312, "World_population_density_map.PNG", "World Population Density Map"),
    (313, "Countries_by_CO2_emissions_per_capita.png", "Countries by CO2 Emissions per Capita"),
    (314, "World_urbanization_rate_2014.svg", "World Map: Urbanization Rate (2014)"),
    (315, "Life_expectancy_by_country.svg", "World Map: Life Expectancy by Country"),
    (316, "GDP_per_capita_PPP_world_map.svg", "GDP per Capita Map (PPP, World)"),
    (317, "World_electricity_access_2016.svg", "World Map: Access to Electricity"),
    (318, "Global_internet_map.svg", "Global Internet Connectivity Map"),
    (319, "Arable_land_percent_world.png", "World: Percentage of Arable Land"),
    (320, "World_Obesity_Map.png", "World Map: Obesity Rate by Country"),
]

# Direct URLs from well-known open-access sources (CC licensed)
DIRECT_URLS = [
    # Bar charts from Our World in Data (CC BY)
    (321, "https://upload.wikimedia.org/wikipedia/commons/thumb/4/40/20200526_Global_CO2_emission_by_source.svg/1280px-20200526_Global_CO2_emission_by_source.svg.png",
     "Global CO2 Emissions by Source (1750–2020)"),
    (322, "https://upload.wikimedia.org/wikipedia/commons/thumb/4/41/Simple_English_Wikipedia_-_Renewable_energy_world_share_2014.svg/1280px-Simple_English_Wikipedia_-_Renewable_energy_world_share_2014.svg.png",
     "Renewable Energy Share by Country"),
    (323, "https://upload.wikimedia.org/wikipedia/commons/thumb/b/b7/World_energy_consumption_by_source.png/1280px-World_energy_consumption_by_source.png",
     "World Energy Consumption by Source (1965–2019)"),
    (324, "https://upload.wikimedia.org/wikipedia/commons/thumb/3/3f/Global-warming-by-sector.svg/1280px-Global-warming-by-sector.svg.png",
     "Global Warming Contribution by Sector"),
    (325, "https://upload.wikimedia.org/wikipedia/commons/thumb/e/e0/World_population_v3.svg/1280px-World_population_v3.svg.png",
     "World Population Growth (10,000 BCE to 2050)"),
    (326, "https://upload.wikimedia.org/wikipedia/commons/thumb/9/92/Average_CO2_per_capita_per_country.png/1280px-Average_CO2_per_capita_per_country.png",
     "Average CO2 Emissions per Capita by Country"),
    (327, "https://upload.wikimedia.org/wikipedia/commons/thumb/c/c4/Global_GDP_per_capita_1960-2020.png/1280px-Global_GDP_per_capita_1960-2020.png",
     "Global GDP Per Capita Growth (1960–2020)"),
    (328, "https://upload.wikimedia.org/wikipedia/commons/thumb/a/a7/Camponotus_flavomarginatus_ant.jpg/1024px-Camponotus_flavomarginatus_ant.jpg",
     "Macro Photography: Ant Colony Structure"),
    (329, "https://upload.wikimedia.org/wikipedia/commons/thumb/1/1e/Life_cycle_of_a_star.jpg/1280px-Life_cycle_of_a_star.jpg",
     "Life Cycle of a Star (Astronomy Diagram)"),
    (330, "https://upload.wikimedia.org/wikipedia/commons/thumb/c/c8/Tide_types.svg/1280px-Tide_types.svg.png",
     "Types of Ocean Tides (Diagram)"),

    # Process diagrams
    (331, "https://upload.wikimedia.org/wikipedia/commons/thumb/9/97/Diagram_showing_the_life_cycle_of_a_star.png/1024px-Diagram_showing_the_life_cycle_of_a_star.png",
     "Life Cycle of a Star (Process Diagram)"),
    (332, "https://upload.wikimedia.org/wikipedia/commons/thumb/9/96/Digestive_system_diagram_en.svg/800px-Digestive_system_diagram_en.svg.png",
     "Human Digestive System (Anatomy Diagram)"),
    (333, "https://upload.wikimedia.org/wikipedia/commons/thumb/7/7f/The_hydrological_cycle.jpg/1280px-The_hydrological_cycle.jpg",
     "The Hydrological (Water) Cycle"),
    (334, "https://upload.wikimedia.org/wikipedia/commons/thumb/3/31/Oxygen_cycle.svg/1280px-Oxygen_cycle.svg.png",
     "The Oxygen Cycle (Environmental Science)"),
    (335, "https://upload.wikimedia.org/wikipedia/commons/thumb/5/5f/GroceryStoreProcessDiagram.png/1024px-GroceryStoreProcessDiagram.png",
     "Supply Chain Process Diagram"),
    (336, "https://upload.wikimedia.org/wikipedia/commons/thumb/a/a9/Combustion_reaction_of_methane.jpg/1280px-Combustion_reaction_of_methane.jpg",
     "Combustion Reaction Process (Chemistry)"),
    (337, "https://upload.wikimedia.org/wikipedia/commons/thumb/3/3b/Food_chain.jpg/1280px-Food_chain.jpg",
     "Food Chain in an Ecosystem (Biology)"),
    (338, "https://upload.wikimedia.org/wikipedia/commons/thumb/9/9b/Social_Network_Analysis_Visualization.png/1024px-Social_Network_Analysis_Visualization.png",
     "Social Network Analysis Visualization"),
    (339, "https://upload.wikimedia.org/wikipedia/commons/thumb/4/4e/The_Carbon_Cycle.png/1280px-The_Carbon_Cycle.png",
     "The Carbon Cycle (Environmental Science)"),
    (340, "https://upload.wikimedia.org/wikipedia/commons/thumb/a/a6/Filtration_of_drinking_water.jpg/1280px-Filtration_of_drinking_water.jpg",
     "Drinking Water Filtration Process"),

    # Charts / Graphs
    (341, "https://upload.wikimedia.org/wikipedia/commons/thumb/a/ae/Net_migration_rate_world.PNG/1280px-Net_migration_rate_world.PNG",
     "World Net Migration Rate Map"),
    (342, "https://upload.wikimedia.org/wikipedia/commons/thumb/4/47/PNG_transparency_demonstration_1.png/280px-PNG_transparency_demonstration_1.png",
     "Global Forest Coverage Distribution"),
    (343, "https://upload.wikimedia.org/wikipedia/commons/thumb/1/16/Minard.png/1280px-Minard.png",
     "Napoleon's March on Moscow – Historical Infographic"),
    (344, "https://upload.wikimedia.org/wikipedia/commons/thumb/4/4a/World_trade_map.PNG/1280px-World_trade_map.PNG",
     "World Trade Flows by Region"),
    (345, "https://upload.wikimedia.org/wikipedia/commons/thumb/e/e8/Human_body_features.jpg/800px-Human_body_features.jpg",
     "Human Body: Main Anatomical Features"),
    (346, "https://upload.wikimedia.org/wikipedia/commons/thumb/5/5e/SolarSystemSize.jpg/1280px-SolarSystemSize.jpg",
     "Solar System: Comparative Planet Sizes"),
    (347, "https://upload.wikimedia.org/wikipedia/commons/thumb/3/3e/Solar_System_size.png/1280px-Solar_System_size.png",
     "Solar System Scale Diagram"),
    (348, "https://upload.wikimedia.org/wikipedia/commons/thumb/1/10/Panning_for_gold_-_all_stages.jpg/1280px-Panning_for_gold_-_all_stages.jpg",
     "Gold Mining Process (Stages)"),
    (349, "https://upload.wikimedia.org/wikipedia/commons/thumb/8/8c/Anatomy_of_a_Tornado.jpg/800px-Anatomy_of_a_Tornado.jpg",
     "How a Tornado Forms (Meteorology Diagram)"),
    (350, "https://upload.wikimedia.org/wikipedia/commons/thumb/8/8f/Anatomy_of_a_Hurricane.jpg/1024px-Anatomy_of_a_Hurricane.jpg",
     "Anatomy of a Hurricane (Weather Diagram)"),
]

def main():
    start = int(sys.argv[1]) if len(sys.argv) > 1 else 301
    end   = int(sys.argv[2]) if len(sys.argv) > 2 else 350

    success = 0
    failed = []

    all_items = [(t,u,n) for t,u,n in [(x[0],None,x[2]) for x in WIKIMEDIA_IMAGES] + DIRECT_URLS if start <= (WIKIMEDIA_IMAGES + DIRECT_URLS)[0][0] ]

    # Combine both lists
    all_tasks = []
    for item in WIKIMEDIA_IMAGES:
        if start <= item[0] <= end:
            all_tasks.append(('wikimedia', item[0], item[1], item[2]))
    for item in DIRECT_URLS:
        if start <= item[0] <= end:
            all_tasks.append(('direct', item[0], item[1], item[2]))

    print(f"Downloading {len(all_tasks)} images (topics {start}–{end}) from public domain sources...")

    for source, tid, url_or_file, title in all_tasks:
        fp = os.path.join(OUTPUT_DIR, f"di_topic_{tid}.png")
        if os.path.exists(fp):
            print(f"  [{tid}] Already exists: {title[:50]}")
            success += 1
            continue

        if source == 'wikimedia':
            print(f"  [{tid}] Looking up: {url_or_file[:50]}...")
            real_url = get_wikimedia_url(url_or_file)
            if not real_url:
                print(f"  [{tid}] ✗ Could not get URL for {url_or_file}")
                failed.append(tid)
                continue
        else:
            real_url = url_or_file

        print(f"  [{tid}] Downloading: {title[:50]}...")
        ok = download(real_url, fp)
        if ok:
            print(f"  [{tid}] ✓ Saved")
            success += 1
        else:
            print(f"  [{tid}] ✗ FAILED - {title[:40]}")
            failed.append(tid)
        time.sleep(0.5)

    print(f"\n✓ Done! {success}/{len(all_tasks)} downloaded.")
    if failed:
        print(f"✗ Failed topics: {failed}")

    # Print config entries
    print("\n--- Config entries for pte_describe_image.php ---")
    for source, tid, url_or_file, title in all_tasks:
        title_esc = title.replace("'", "\\'")
        print(f"    {tid}   => ['title' => '{title_esc}'],")

if __name__ == "__main__":
    main()
