#!/usr/bin/env python3
"""
Generate 250 Describe Image topics (51-300) using QuickChart.io API and Matplotlib.
Images are saved to /Applications/MAMP/htdocs/TargetBahasaCourse/public/storage/describe-image/
"""

import os
import sys
import time
import json
import random
import urllib.request
import urllib.parse
import urllib.error
import ssl

OUTPUT_DIR = "/Applications/MAMP/htdocs/TargetBahasaCourse/public/storage/describe-image"

# QuickChart.io base
QUICKCHART_URL = "https://quickchart.io/chart"

ssl_ctx = ssl.create_default_context()
ssl_ctx.check_hostname = False
ssl_ctx.verify_mode = ssl.CERT_NONE

def download_image(url, filepath, retries=3):
    for attempt in range(retries):
        try:
            req = urllib.request.Request(url, headers={"User-Agent": "Mozilla/5.0"})
            with urllib.request.urlopen(req, context=ssl_ctx, timeout=20) as resp:
                data = resp.read()
            with open(filepath, "wb") as f:
                f.write(data)
            return True
        except Exception as e:
            print(f"  Attempt {attempt+1} failed: {e}")
            time.sleep(2)
    return False


def quickchart(chart_config, topic_id):
    """Download chart from QuickChart.io"""
    filepath = os.path.join(OUTPUT_DIR, f"di_topic_{topic_id}.png")
    if os.path.exists(filepath):
        print(f"  [{topic_id}] Already exists, skipping.")
        return True
    
    chart_json = json.dumps(chart_config)
    params = urllib.parse.urlencode({
        "c": chart_json,
        "width": 800,
        "height": 500,
        "backgroundColor": "white",
        "format": "png"
    })
    url = f"{QUICKCHART_URL}?{params}"
    ok = download_image(url, filepath)
    if ok:
        print(f"  [{topic_id}] ✓ Saved")
    else:
        print(f"  [{topic_id}] ✗ FAILED")
    return ok


# ─── TOPIC DEFINITIONS ────────────────────────────────────────────────────────

topics = {}

# 51: Global CO2 emissions
topics[51] = ("Global CO2 Emissions by Sector (2021)", {
    "type": "bar",
    "data": {
        "labels": ["Energy", "Industry", "Transport", "Buildings", "Agriculture", "Waste"],
        "datasets": [{"label": "CO2 Emissions (Gt)", "data": [16.1, 8.5, 7.7, 3.3, 5.8, 1.9],
                      "backgroundColor": ["#ef4444","#f97316","#eab308","#22c55e","#3b82f6","#a855f7"]}]
    },
    "options": {"plugins": {"title": {"display": True, "text": "Global CO2 Emissions by Sector (2021)"}}}
})

# 52: World Population Growth
topics[52] = ("World Population Growth (1950–2023)", {
    "type": "line",
    "data": {
        "labels": ["1950","1960","1970","1980","1990","2000","2010","2020","2023"],
        "datasets": [{"label": "Population (Billions)", "data": [2.5,3.0,3.7,4.4,5.3,6.1,6.9,7.8,8.0],
                      "borderColor": "#3b82f6", "backgroundColor": "rgba(59,130,246,0.1)", "fill": True}]
    },
    "options": {"plugins": {"title": {"display": True, "text": "World Population Growth (1950–2023)"}}}
})

# 53: Global Internet Users
topics[53] = ("Global Internet Users by Region (2022)", {
    "type": "horizontalBar",
    "data": {
        "labels": ["Asia-Pacific","Europe","Latin America","North America","Middle East","Africa"],
        "datasets": [{"label": "Users (Millions)", "data": [2831,745,486,350,220,570],
                      "backgroundColor": "#6366f1"}]
    },
    "options": {"plugins": {"title": {"display": True, "text": "Global Internet Users by Region (2022)"}}}
})

# 54: Electric Vehicle Sales
topics[54] = ("Electric Vehicle Sales Worldwide (2016–2022, Millions)", {
    "type": "bar",
    "data": {
        "labels": ["2016","2017","2018","2019","2020","2021","2022"],
        "datasets": [{"label": "EV Sales (Millions)", "data": [0.77,1.2,2.1,2.5,3.2,6.6,10.5],
                      "backgroundColor": "#22c55e"}]
    },
    "options": {"plugins": {"title": {"display": True, "text": "Electric Vehicle Sales Worldwide (2016–2022)"}}}
})

# 55: Global Obesity Rate
topics[55] = ("Prevalence of Obesity by World Region (2022)", {
    "type": "bar",
    "data": {
        "labels": ["North America","Pacific","Europe","Latin America","Middle East","Asia","Africa"],
        "datasets": [{"label": "Obesity Rate (%)", "data": [36,33,25,24,22,7,11],
                      "backgroundColor": "#f97316"}]
    },
    "options": {"plugins": {"title": {"display": True, "text": "Prevalence of Obesity by World Region (2022)"}}}
})

# 56: Global Tourism Arrivals
topics[56] = ("International Tourist Arrivals (2000–2022, Millions)", {
    "type": "line",
    "data": {
        "labels": ["2000","2005","2010","2015","2019","2020","2021","2022"],
        "datasets": [{"label": "Arrivals (Millions)", "data": [674,809,940,1189,1461,381,415,963],
                      "borderColor": "#ec4899", "backgroundColor": "rgba(236,72,153,0.1)", "fill": True}]
    },
    "options": {"plugins": {"title": {"display": True, "text": "International Tourist Arrivals (2000–2022)"}}}
})

# 57: Global Energy Mix
topics[57] = ("Global Primary Energy Mix (2022)", {
    "type": "pie",
    "data": {
        "labels": ["Oil","Coal","Natural Gas","Nuclear","Hydro","Wind","Solar","Other"],
        "datasets": [{"data": [31.6,26.7,23.5,4.3,6.8,3.4,2.4,1.3],
                      "backgroundColor": ["#374151","#78716c","#60a5fa","#fcd34d","#34d399","#93c5fd","#fde68a","#d1d5db"]}]
    },
    "options": {"plugins": {"title": {"display": True, "text": "Global Primary Energy Mix (2022)"}}}
})

# 58: Life Expectancy by Region
topics[58] = ("Life Expectancy by World Region (2023)", {
    "type": "horizontalBar",
    "data": {
        "labels": ["Europe","Americas","Asia Pacific","Global Avg","Middle East","South Asia","Sub-Saharan Africa"],
        "datasets": [{"label": "Life Expectancy (Years)", "data": [78,74,75,72,72,68,62],
                      "backgroundColor": "#8b5cf6"}]
    },
    "options": {"plugins": {"title": {"display": True, "text": "Life Expectancy by World Region (2023)"}}}
})

# 59: COVID Vaccination Rates
topics[59] = ("COVID-19 Vaccination Rate by Continent (% fully vaccinated, 2022)", {
    "type": "bar",
    "data": {
        "labels": ["Europe","South America","North America","Asia","Oceania","Africa"],
        "datasets": [{"label": "Vaccination Rate (%)", "data": [70,63,60,57,60,22],
                      "backgroundColor": ["#3b82f6","#22c55e","#f59e0b","#ef4444","#a78bfa","#fb923c"]}]
    },
    "options": {"plugins": {"title": {"display": True, "text": "COVID-19 Vaccination Rate by Continent (2022)"}}}
})

# 60: Global Food Waste
topics[60] = ("Food Wasted Along the Supply Chain (% of total, Global)", {
    "type": "pie",
    "data": {
        "labels": ["Production","Handling & Storage","Processing","Distribution","Consumption"],
        "datasets": [{"data": [28,17,10,14,31],
                      "backgroundColor": ["#ef4444","#f97316","#eab308","#22c55e","#3b82f6"]}]
    },
    "options": {"plugins": {"title": {"display": True, "text": "Food Wasted Along the Supply Chain (Global)"}}}
})

# 61: Global Literacy Rate
topics[61] = ("Adult Literacy Rate by Region (2022, %)", {
    "type": "bar",
    "data": {
        "labels": ["North America","Europe","East Asia","Latin America","South Asia","Sub-Saharan Africa"],
        "datasets": [{"label": "Literacy Rate (%)", "data": [99,98,96,93,74,65],
                      "backgroundColor": "#14b8a6"}]
    },
    "options": {"plugins": {"title": {"display": True, "text": "Adult Literacy Rate by Region (2022)"}}}
})

# 62: Global Smartphone Users
topics[62] = ("Global Smartphone Users (2016–2023, Billions)", {
    "type": "line",
    "data": {
        "labels": ["2016","2017","2018","2019","2020","2021","2022","2023"],
        "datasets": [{"label": "Users (Billions)", "data": [3.67,3.99,4.31,4.63,4.96,5.27,5.48,5.62],
                      "borderColor": "#f59e0b", "fill": False}]
    },
    "options": {"plugins": {"title": {"display": True, "text": "Global Smartphone Users (2016–2023)"}}}
})

# 63: Top Countries by GDP
topics[63] = ("Top 10 Countries by GDP (2023, Trillion USD)", {
    "type": "horizontalBar",
    "data": {
        "labels": ["USA","China","Germany","Japan","India","UK","France","Italy","Canada","Brazil"],
        "datasets": [{"label": "GDP (Trillion USD)", "data": [26.8,19.4,4.4,4.2,3.7,3.1,2.9,2.1,2.1,2.1],
                      "backgroundColor": "#3b82f6"}]
    },
    "options": {"plugins": {"title": {"display": True, "text": "Top 10 Countries by GDP (2023)"}}}
})

# 64: Carbon Footprint by Diet
topics[64] = ("Annual Carbon Footprint by Diet Type (kg CO2 per year)", {
    "type": "horizontalBar",
    "data": {
        "labels": ["High Meat","Average Meat","Low Meat","Pescatarian","Vegetarian","Vegan"],
        "datasets": [{"label": "kg CO2 per year", "data": [3300,2500,1900,1700,1400,1100],
                      "backgroundColor": ["#ef4444","#f97316","#eab308","#22c55e","#3b82f6","#22d3ee"]}]
    },
    "options": {"plugins": {"title": {"display": True, "text": "Annual Carbon Footprint by Diet Type"}}}
})

# 65: Global Water Stress
topics[65] = ("Countries by Water Stress Level (% of World, 2023)", {
    "type": "doughnut",
    "data": {
        "labels": ["Low (<10%)","Low-Medium","Medium-High","High (40-80%)","Extremely High (>80%)"],
        "datasets": [{"data": [32,22,16,16,14],
                      "backgroundColor": ["#22d3ee","#3b82f6","#eab308","#f97316","#ef4444"]}]
    },
    "options": {"plugins": {"title": {"display": True, "text": "Countries by Water Stress Level (2023)"}}}
})

# 66: Global Social Media Users
topics[66] = ("Social Media Users by Platform (2023, Millions)", {
    "type": "horizontalBar",
    "data": {
        "labels": ["Facebook","YouTube","Instagram","TikTok","WeChat","LinkedIn","Snapchat","Twitter/X"],
        "datasets": [{"label": "Monthly Active Users (Millions)", 
                      "data": [3050,2500,2000,1500,1340,950,750,556],
                      "backgroundColor": "#6366f1"}]
    },
    "options": {"plugins": {"title": {"display": True, "text": "Social Media Users by Platform (2023)"}}}
})

# 67: Global Deforestation Rate
topics[67] = ("Annual Deforestation Rate by Region (2015–2020, Million Hectares)", {
    "type": "bar",
    "data": {
        "labels": ["South America","Africa","Southeast Asia","Central America","Caribbean","Other"],
        "datasets": [{"label": "Forest Loss (M Ha/year)", "data": [2.6,3.9,1.5,0.6,0.1,0.4],
                      "backgroundColor": "#ef4444"}]
    },
    "options": {"plugins": {"title": {"display": True, "text": "Annual Deforestation Rate by Region (2015–2020)"}}}
})

# 68: Top Languages
topics[68] = ("Most Spoken Languages in the World (2023, Millions of Speakers)", {
    "type": "horizontalBar",
    "data": {
        "labels": ["English","Mandarin","Hindi","Spanish","French","Arabic","Bengali","Russian"],
        "datasets": [{"label": "Speakers (Millions)", "data": [1456,1138,609,559,310,274,273,258],
                      "backgroundColor": "#a855f7"}]
    },
    "options": {"plugins": {"title": {"display": True, "text": "Most Spoken Languages in the World (2023)"}}}
})

# 69: Gender Pay Gap
topics[69] = ("Gender Pay Gap in Selected Countries (2022, %)", {
    "type": "horizontalBar",
    "data": {
        "labels": ["South Korea","Japan","Canada","USA","UK","Australia","Sweden","Luxembourg"],
        "datasets": [{"label": "Pay Gap (%)", "data": [31,22,16,17,15,12,7,1],
                      "backgroundColor": "#ec4899"}]
    },
    "options": {"plugins": {"title": {"display": True, "text": "Gender Pay Gap in Selected Countries (2022)"}}}
})

# 70: Global Hunger Index
topics[70] = ("Global Hunger Index by Region (2023)", {
    "type": "bar",
    "data": {
        "labels": ["South Asia","Sub-Saharan Africa","Southeast Asia","East Asia","Near East","Latin America"],
        "datasets": [{"label": "GHI Score", "data": [29.4,27.0,17.5,8.5,7.7,11.8],
                      "backgroundColor": "#f97316"}]
    },
    "options": {"plugins": {"title": {"display": True, "text": "Global Hunger Index by Region (2023)"}}}
})

# 71: Inflation rates comparison
topics[71] = ("Annual Inflation Rate in G7 Countries (2022, %)", {
    "type": "bar",
    "data": {
        "labels": ["UK","Germany","Italy","USA","Canada","France","Japan"],
        "datasets": [{"label": "Inflation (%)", "data": [9.1,8.7,8.7,8.0,6.8,5.9,2.5],
                      "backgroundColor": ["#ef4444","#f97316","#eab308","#22c55e","#3b82f6","#8b5cf6","#ec4899"]}]
    },
    "options": {"plugins": {"title": {"display": True, "text": "Annual Inflation Rate in G7 Countries (2022)"}}}
})

# 72: Global Renewable Energy
topics[72] = ("Share of Renewables in Electricity Generation by Country (2022, %)", {
    "type": "horizontalBar",
    "data": {
        "labels": ["Norway","Iceland","Brazil","Canada","Germany","UK","USA","China","India"],
        "datasets": [{"label": "Renewables Share (%)", "data": [98,99,83,67,46,40,21,30,20],
                      "backgroundColor": "#22c55e"}]
    },
    "options": {"plugins": {"title": {"display": True, "text": "Share of Renewables in Electricity (2022)"}}}
})

# 73: Child Mortality Rate
topics[73] = ("Under-5 Mortality Rate by Region (2022, per 1,000 live births)", {
    "type": "bar",
    "data": {
        "labels": ["Sub-Saharan Africa","South Asia","Oceania","Middle East","Latin America","East Asia","Europe"],
        "datasets": [{"label": "Under-5 Mortality (per 1000)", "data": [74,43,20,16,14,9,5],
                      "backgroundColor": "#6366f1"}]
    },
    "options": {"plugins": {"title": {"display": True, "text": "Under-5 Mortality Rate by Region (2022)"}}}
})

# 74: University Rankings by Country
topics[74] = ("Number of Top 200 Universities by Country (QS Rankings 2024)", {
    "type": "horizontalBar",
    "data": {
        "labels": ["USA","UK","China","Australia","Germany","Canada","Switzerland","Singapore"],
        "datasets": [{"label": "Number of Universities in Top 200", "data": [52,27,17,12,8,6,5,4],
                      "backgroundColor": "#f59e0b"}]
    },
    "options": {"plugins": {"title": {"display": True, "text": "Top 200 Universities by Country (2024)"}}}
})

# 75: Global Arms Trade
topics[75] = ("Largest Arms Exporters in the World (2019–2023, % share)", {
    "type": "pie",
    "data": {
        "labels": ["USA","Russia","France","China","Germany","Italy","UK","Others"],
        "datasets": [{"data": [42,11,11,5.8,5.6,3.8,3.2,17.6],
                      "backgroundColor": ["#3b82f6","#ef4444","#eab308","#22c55e","#6366f1","#a855f7","#14b8a6","#d1d5db"]}]
    },
    "options": {"plugins": {"title": {"display": True, "text": "Largest Arms Exporters (2019–2023)"}}}
})

# 76: Global Cancer Rates
topics[76] = ("Most Common Cancer Types Worldwide (2022, Millions of Cases)", {
    "type": "horizontalBar",
    "data": {
        "labels": ["Lung","Colorectum","Breast","Prostate","Stomach","Liver","Thyroid","Cervix"],
        "datasets": [{"label": "Cases (Millions)", "data": [2.21,1.93,2.31,1.47,0.97,0.87,0.81,0.66],
                      "backgroundColor": "#ec4899"}]
    },
    "options": {"plugins": {"title": {"display": True, "text": "Most Common Cancer Types Worldwide (2022)"}}}
})

# 77: Global Alcohol Consumption
topics[77] = ("Total Alcohol Consumption per Capita (Liters, 2019)", {
    "type": "horizontalBar",
    "data": {
        "labels": ["Czech Republic","Latvia","Moldova","Germany","Lithuania","Ireland","Spain","Australia"],
        "datasets": [{"label": "Liters per Capita", "data": [14.4,13.2,12.9,12.7,12.6,12.1,11.6,10.6],
                      "backgroundColor": "#f97316"}]
    },
    "options": {"plugins": {"title": {"display": True, "text": "Alcohol Consumption per Capita (2019)"}}}
})

# 78: Global Depression Rates
topics[78] = ("Prevalence of Depression by Country (% of Population, 2017)", {
    "type": "bar",
    "data": {
        "labels": ["Ukraine","USA","Australia","UK","Brazil","Germany","France","China","Nigeria"],
        "datasets": [{"label": "Depression Prevalence (%)", "data": [6.3,5.9,5.9,4.5,5.8,4.7,5.2,3.6,3.9],
                      "backgroundColor": "#8b5cf6"}]
    },
    "options": {"plugins": {"title": {"display": True, "text": "Prevalence of Depression by Country (2017)"}}}
})

# 79: Global Prison Population
topics[79] = ("Prison Population Rate by Country (per 100,000, 2023)", {
    "type": "horizontalBar",
    "data": {
        "labels": ["USA","El Salvador","Cuba","Thailand","Russia","Mexico","UK","China","Japan","Iceland"],
        "datasets": [{"label": "Prisoners per 100,000", "data": [531,442,432,416,332,212,140,121,48,40],
                      "backgroundColor": "#6b7280"}]
    },
    "options": {"plugins": {"title": {"display": True, "text": "Prison Population Rate by Country (2023)"}}}
})

# 80: Global Coffee Production
topics[80] = ("Top 10 Coffee Producing Countries (2022, 1000 metric tons)", {
    "type": "horizontalBar",
    "data": {
        "labels": ["Brazil","Vietnam","Colombia","Indonesia","Ethiopia","Honduras","India","Uganda","Mexico","Peru"],
        "datasets": [{"label": "Production (1000 MT)", "data": [3180,1880,880,760,450,390,350,300,260,240],
                      "backgroundColor": "#78350f"}]
    },
    "options": {"plugins": {"title": {"display": True, "text": "Top 10 Coffee Producing Countries (2022)"}}}
})

# 81-110: More topics
more_topics_data = [
    (81, "Global Natural Disaster Deaths (2000–2022)", "line",
        ["2000","2002","2004","2006","2008","2010","2012","2014","2016","2018","2020","2022"],
        "Deaths (Thousands)", [12.3, 10.8, 240, 24, 235, 320, 11, 8.5, 10.2, 11.5, 15, 32], "#ef4444"),
    (82, "COVID-19 Deaths by Continent (Total, Millions)", "bar",
        ["Asia","Europe","North America","South America","Africa","Oceania"],
        "Deaths (Millions)", [1.6, 2.1, 1.5, 1.3, 0.26, 0.02], "#6b7280"),
    (83, "Global Fertility Rate by Region (2022, births per woman)", "bar",
        ["Sub-Saharan Africa","Middle East","South Asia","Latin America","East Asia","Europe","North America"],
        "Births per Woman", [4.6, 2.9, 2.5, 2.1, 1.7, 1.5, 1.6], "#f472b6"),
    (84, "Global Military Personnel by Country (2023, Millions)", "horizontalBar",
        ["China","India","USA","North Korea","Russia","Pakistan","South Korea","Iran","Egypt","Vietnam"],
        "Active Personnel (Millions)", [2.18, 1.46, 1.39, 1.28, 0.9, 0.65, 0.56, 0.61, 0.44, 0.48], "#374151"),
    (85, "Internet Speed by Country (2023, Mbps Average)", "horizontalBar",
        ["Singapore","UAE","Iceland","Denmark","South Korea","Norway","USA","Australia","UK","Brazil"],
        "Speed (Mbps)", [292,294,216,204,196,180,165,95,80,58], "#22d3ee"),
    (86, "Global Book Publishing Market (2022, Billion USD)", "bar",
        ["USA","Germany","China","Japan","UK","France","South Korea","Spain","Italy","Brazil"],
        "Revenue (Billion USD)", [31.5,10.2,9.7,7.4,6.9,4.5,3.1,2.8,2.5,2.3], "#a78bfa"),
    (87, "Global Aging Population (65+ years, % of total, 2022)", "bar",
        ["Japan","Italy","Finland","Portugal","Greece","Germany","France","UK","USA","China"],
        "Population 65+ (%)", [29.8,23.5,22.6,22.8,22.5,22.4,20.8,18.7,17.3,13.5], "#60a5fa"),
    (88, "Top Countries by Gold Reserves (2023, Tonnes)", "horizontalBar",
        ["USA","Germany","Italy","France","Russia","China","Switzerland","Japan","India","Netherlands"],
        "Gold Reserves (Tonnes)", [8133,3355,2452,2437,2333,2235,1040,846,797,612], "#fbbf24"),
    (89, "Global Online Shopping Revenue (2019–2024, Trillion USD)", "line",
        ["2019","2020","2021","2022","2023","2024"],
        "Revenue (Trillion USD)", [3.35,4.28,5.2,5.8,6.3,6.9], "#4ade80"),
    (90, "Most Visited Countries by Tourists (2022, Millions)", "horizontalBar",
        ["France","Spain","USA","Turkey","Italy","Mexico","UK","Germany","Greece","Austria"],
        "Arrivals (Millions)", [90,71,50,44,40,38,35,26,27,31], "#f87171"),
]

for t in more_topics_data:
    num, title, chart_type, labels, label_str, data, color = t
    topics[num] = (title, {
        "type": chart_type,
        "data": {
            "labels": labels,
            "datasets": [{"label": label_str, "data": data, "backgroundColor": color,
                          "borderColor": color, "fill": False}]
        },
        "options": {"plugins": {"title": {"display": True, "text": title}}}
    })

# Generate more topics 91-300 with varied data
def gen_batch(start, end, categories):
    """Generate batch topics with varied categories"""
    cat_topics = [
        ("GDP per Capita Growth", "line", 
         ["2015","2016","2017","2018","2019","2020","2021","2022"],
         [lambda i: round(random.uniform(1.5, 4.5), 1) for _ in range(8)]),
    ]
    
    education_titles = [
        "Higher Education Enrollment Rate", "Primary School Dropout Rate",
        "Teacher-to-Student Ratio", "Public Education Spending (% of GDP)",
        "PISA Reading Score Average", "Science Achievement Gap by Gender",
        "School Attendance Rate (Rural vs Urban)", "Adult Continuing Education Rate"
    ]
    health_titles = [
        "Hospital Beds per 1,000 People", "Physicians per 1,000 People",
        "Health Spending as % of GDP", "Vaccination Coverage Rate",
        "Maternal Mortality Rate", "Antibiotic Resistance Rate",
        "Diabetes Prevalence (%)", "Smoking Rate Among Adults"
    ]
    env_titles = [
        "Annual Plastic Waste Generated", "Air Quality Index in Major Cities",
        "Species Extinction Rate (per decade)", "Ocean Temperature Anomaly",
        "Freshwater Withdrawals by Sector", "Renewable Energy Investment",
        "Electric Car Adoption Rate", "Urban Green Space per Capita"
    ]
    econ_titles = [
        "Unemployment Rate Comparison", "National Debt as % of GDP",
        "Export Volume by Sector", "Foreign Direct Investment Inflows",
        "Consumer Price Index Trend", "Manufacturing Output Growth",
        "Trade Balance by Country", "Minimum Wage Comparison"
    ]
    tech_titles = [
        "AI Patent Applications by Country", "R&D Spending as % of GDP",
        "Startup Funding by Sector", "Tech Industry Employment",
        "5G Coverage by Country", "Cloud Computing Market Share",
        "Cybersecurity Incidents by Type", "Robotics Adoption in Manufacturing"
    ]
    society_titles = [
        "Income Inequality (Gini Coefficient)", "Volunteer Rate by Age Group",
        "Organ Donation Rate", "Happiness Index by Region",
        "Trust in Government Index", "Social Media Time per Day",
        "Voter Turnout in Elections", "Crime Rate Trend"
    ]
    
    all_titles = education_titles + health_titles + env_titles + econ_titles + tech_titles + society_titles
    
    chart_types = ["bar", "horizontalBar", "line", "pie", "doughnut"]
    colors = ["#3b82f6","#ef4444","#22c55e","#f97316","#8b5cf6","#ec4899","#14b8a6","#f59e0b","#6366f1","#84cc16"]
    
    country_sets = [
        ["USA","UK","Germany","France","Japan","China","India","Brazil"],
        ["Norway","Denmark","Sweden","Finland","Netherlands","Belgium","Austria","Switzerland"],
        ["Kenya","Nigeria","Ethiopia","Ghana","South Africa","Egypt","Tanzania","Morocco"],
        ["Australia","New Zealand","Canada","Singapore","South Korea","Taiwan","Indonesia","Thailand"],
        ["Mexico","Argentina","Chile","Colombia","Peru","Venezuela","Cuba","Ecuador"],
    ]
    
    year_sets = [
        ["2015","2016","2017","2018","2019","2020","2021","2022","2023"],
        ["2010","2012","2014","2016","2018","2020","2022"],
        ["2000","2005","2010","2015","2020","2023"],
        ["1990","1995","2000","2005","2010","2015","2020"],
    ]
    
    for i in range(start, end + 1):
        idx = i - start
        title_idx = idx % len(all_titles)
        title = all_titles[title_idx] + f" ({2018 + (idx % 6)})"
        
        chart_type = chart_types[idx % len(chart_types)]
        color = colors[idx % len(colors)]
        
        if chart_type in ["pie", "doughnut"]:
            labels = country_sets[idx % len(country_sets)][:6]
            data = [round(random.uniform(5, 40), 1) for _ in labels]
            topics[i] = (title, {
                "type": chart_type,
                "data": {
                    "labels": labels,
                    "datasets": [{"data": data,
                                  "backgroundColor": ["#3b82f6","#ef4444","#22c55e","#f97316","#8b5cf6","#ec4899"]}]
                },
                "options": {"plugins": {"title": {"display": True, "text": title}}}
            })
        elif chart_type == "line":
            labels = year_sets[idx % len(year_sets)]
            n = len(labels)
            base = random.uniform(10, 60)
            data = [round(base + i * random.uniform(-2, 4), 1) for i in range(n)]
            topics[i] = (title, {
                "type": "line",
                "data": {
                    "labels": labels,
                    "datasets": [{"label": title, "data": data,
                                  "borderColor": color, "backgroundColor": "rgba(59,130,246,0.05)", "fill": False}]
                },
                "options": {"plugins": {"title": {"display": True, "text": title}}}
            })
        else:
            labels = country_sets[idx % len(country_sets)]
            data = [round(random.uniform(5, 100), 1) for _ in labels]
            topics[i] = (title, {
                "type": chart_type,
                "data": {
                    "labels": labels,
                    "datasets": [{"label": title, "data": data, "backgroundColor": color}]
                },
                "options": {"plugins": {"title": {"display": True, "text": title}}}
            })

random.seed(42)
gen_batch(91, 300, [])

# ─── MAIN ────────────────────────────────────────────────────────────────────

if __name__ == "__main__":
    import threading

    start_from = int(sys.argv[1]) if len(sys.argv) > 1 else 51
    end_at = int(sys.argv[2]) if len(sys.argv) > 2 else 300
    workers = int(sys.argv[3]) if len(sys.argv) > 3 else 5

    os.makedirs(OUTPUT_DIR, exist_ok=True)

    topic_ids = sorted([k for k in topics if start_from <= k <= end_at])
    print(f"Generating {len(topic_ids)} charts (topics {start_from}–{end_at}) with {workers} threads...")

    success = 0
    failed = []
    lock = threading.Lock()

    def process(tid):
        global success
        title, config = topics[tid]
        print(f"  [{tid}] {title[:60]}")
        ok = quickchart(config, tid)
        with lock:
            if ok:
                success += 1
            else:
                failed.append(tid)

    from concurrent.futures import ThreadPoolExecutor
    with ThreadPoolExecutor(max_workers=workers) as executor:
        executor.map(process, topic_ids)

    print(f"\n✓ Done! {success}/{len(topic_ids)} generated.")
    if failed:
        print(f"✗ Failed: {failed}")
