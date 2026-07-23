#!/usr/bin/env python3
"""
Update pte_describe_image.php config to include all 300 topics.
"""

import os, random

# Original 50 topics
original = {
    1: 'Internet Non-Users in Europe by Country (2021)',
    2: 'Military Spending by Country (Comparative)',
    3: 'Impact of Social Distancing on Coronavirus Transmission',
    4: 'Projected Career Earnings for College Graduates by Field (USA, 2016)',
    5: 'Annual Ticket Sales for Major Sports Leagues (1992–2017)',
    6: 'Bus Ridership Changes in US Cities (2011–2020)',
    7: 'Labor-Force Participation Rate Among Men Aged 25–54 in OECD Countries (1980–2017)',
    8: 'Global Migration Patterns in 2017 (Millions)',
    9: 'Global Pet Food Sales (2010–2023, USD Billions)',
    10: "Europe's Top Ten Coffee-Drinking Nations (Cups per Capita, 2015)",
    11: 'Percentage of World Population Living Under Democratic Governments (1816–2015)',
    12: 'Global Population Comparison: India vs China (1800–2100 Projected)',
    13: 'Average Price of PV Solar Modules (1976–2016, USD per Watt)',
    14: 'Most-Owned Laptop Brands in South Africa (June 2023)',
    15: 'Major Refugee-Hosting Countries (End of 2014)',
    16: 'Top 25 Nationalities of Immigrants in the United States (2022)',
    17: 'Gun Deaths Among U.S. Children and Teens Under 18 (1999–2021)',
    18: 'Total Number of Websites (2000–2015)',
    19: 'Days to Reach One Million Users by Platform',
    20: "China's Population Growth (1978–2027 Projected)",
    21: 'Percentage of Sports Fans Following Football by Country (2023–2024)',
    22: 'Child Poverty Rates by Country (2017, % of Children Aged 0–17)',
    23: "U.S. Adults' Adherence to New Year's Resolutions (January 2024)",
    24: 'Skin Cancer (Melanoma) Incidence Rate by Age and Sex in the USA (2007–2011)',
    25: 'Evolution of Recorded Music Revenues in the USA by Format (1973–2018)',
    26: 'Oil Spilled from Tanker Ships (Before 1980–2016, Thousands of Tons)',
    27: 'U.S. Adults Who Regularly Get News from Social Media Sites (2023)',
    28: "U.S. Adults' Preferences for Different News Platforms (2020–2023)",
    29: 'Global Military Spending by Country (2021, USD Billions)',
    30: 'Percentage of Respondents Who Follow a Religion Worldwide (2022–2023)',
    31: 'Growth in Renewable Electricity Generation Worldwide (1965–2022)',
    32: 'Government Harassment of Religious Groups and Interference in Worship (2007–2021)',
    33: 'Internet Usage in Germany, Argentina, Thailand, and Cameroon (1960–2021)',
    34: "Percentage of U.S. Adults Who Made at Least One New Year's Resolution (January 2024)",
    35: 'Top 10 Countries of Origin for International Students in the UK',
    36: "U.S. Adults' Feelings Toward Increased Use of AI in Daily Life (2021–2023)",
    37: 'U.S. States with Cities Having Populations Over 250,000 (2024 Projections)',
    38: "U.S. Adults' Views on Science's Effect on Society (2016–2023)",
    39: 'Countries Where Forced Labor is Legal or Practiced by the State (1800–2017)',
    40: "Netflix's Share Price Performance (2017–2022)",
    41: 'Number of Countries with Smallpox Cases (1850–1979)',
    42: "World's Highest-Paid Athletes (2023)",
    43: 'Share of People with a Cell Phone (1980–2017)',
    44: 'Top Cities for International Visitors (2023, Millions of Arrivals)',
    45: 'World Military Expenditure by Region (1988–2021, Constant 2020 USD Billions)',
    46: 'Global Electricity Coverage (1991–2014, % of Population)',
    47: 'Average Daily Income per Person in Selected Countries (1800–2022, USD, Inflation-Adjusted)',
    48: 'U.S. Families Owning Publicly Traded Stock by Race/Ethnicity (1989–2022)',
    49: 'Garbage Concentration in the Pacific Ocean (2022, kg per km²)',
    50: 'The True Size of Africa (Comparative Map)',
}

# New topics 51-300 (matching what the image generator creates)
new_topics = {
    51: 'Global CO2 Emissions by Sector (2021)',
    52: 'World Population Growth (1950–2023)',
    53: 'Global Internet Users by Region (2022)',
    54: 'Electric Vehicle Sales Worldwide (2016–2022, Millions)',
    55: 'Prevalence of Obesity by World Region (2022)',
    56: 'International Tourist Arrivals (2000–2022, Millions)',
    57: 'Global Primary Energy Mix (2022)',
    58: 'Life Expectancy by World Region (2023)',
    59: 'COVID-19 Vaccination Rate by Continent (% fully vaccinated, 2022)',
    60: 'Food Wasted Along the Supply Chain (% of total, Global)',
    61: 'Adult Literacy Rate by Region (2022, %)',
    62: 'Global Smartphone Users (2016–2023, Billions)',
    63: 'Top 10 Countries by GDP (2023, Trillion USD)',
    64: 'Annual Carbon Footprint by Diet Type (kg CO2 per year)',
    65: 'Countries by Water Stress Level (% of World, 2023)',
    66: 'Social Media Users by Platform (2023, Millions)',
    67: 'Annual Deforestation Rate by Region (2015–2020, Million Hectares)',
    68: 'Most Spoken Languages in the World (2023, Millions of Speakers)',
    69: 'Gender Pay Gap in Selected Countries (2022, %)',
    70: 'Global Hunger Index by Region (2023)',
    71: 'Annual Inflation Rate in G7 Countries (2022, %)',
    72: 'Share of Renewables in Electricity Generation by Country (2022, %)',
    73: 'Under-5 Mortality Rate by Region (2022, per 1,000 live births)',
    74: 'Number of Top 200 Universities by Country (QS Rankings 2024)',
    75: 'Largest Arms Exporters in the World (2019–2023, % share)',
    76: 'Most Common Cancer Types Worldwide (2022, Millions of Cases)',
    77: 'Total Alcohol Consumption per Capita (Liters, 2019)',
    78: 'Prevalence of Depression by Country (% of Population, 2017)',
    79: 'Prison Population Rate by Country (per 100,000, 2023)',
    80: 'Top 10 Coffee Producing Countries (2022, 1000 metric tons)',
    81: 'Global Natural Disaster Deaths (2000–2022)',
    82: 'COVID-19 Deaths by Continent (Total, Millions)',
    83: 'Global Fertility Rate by Region (2022, births per woman)',
    84: 'Global Military Personnel by Country (2023, Millions)',
    85: 'Internet Speed by Country (2023, Mbps Average)',
    86: 'Global Book Publishing Market (2022, Billion USD)',
    87: 'Global Aging Population (65+ years, % of total, 2022)',
    88: 'Top Countries by Gold Reserves (2023, Tonnes)',
    89: 'Global Online Shopping Revenue (2019–2024, Trillion USD)',
    90: 'Most Visited Countries by Tourists (2022, Millions)',
}

# Generate titles for 91-300 using same seed/logic as image generator
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

for i in range(91, 301):
    idx = i - 91
    title_idx = idx % len(all_titles)
    title = all_titles[title_idx] + f" ({2018 + (idx % 6)})"
    new_topics[i] = title

# Build PHP config
all_topics = {**original, **new_topics}

php_lines = ["<?php", "", "return ["]
for k in sorted(all_topics.keys()):
    title = all_topics[k].replace("'", "\\'")
    php_lines.append(f"    {k:<4} => ['title' => '{title}'],")
php_lines.append("];")
php_lines.append("")

content = "\n".join(php_lines)

out_path = "/Applications/MAMP/htdocs/TargetBahasaCourse/config/pte_describe_image.php"
with open(out_path, "w") as f:
    f.write(content)

print(f"✓ Written {len(all_topics)} topics to {out_path}")
