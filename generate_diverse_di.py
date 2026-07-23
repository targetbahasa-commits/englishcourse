#!/usr/bin/env python3
"""
Generate 200 diverse PTE Describe Image topics (101-300).
Mix of: maps (choropleth via QuickChart), pie charts, tables, process diagrams,
bubble charts, stacked bars, area charts, radar charts, scatter plots, etc.
Uses QuickChart.io API + Matplotlib for variety.
"""

import os
import sys
import json
import random
import urllib.request
import urllib.parse
import urllib.error
import ssl
import io
import threading
from concurrent.futures import ThreadPoolExecutor

try:
    import matplotlib
    matplotlib.use('Agg')
    import matplotlib.pyplot as plt
    import matplotlib.patches as mpatches
    import matplotlib.patheffects as pe
    import numpy as np
    HAS_MPL = True
except ImportError:
    HAS_MPL = False

OUTPUT_DIR = "/Applications/MAMP/htdocs/TargetBahasaCourse/public/storage/describe-image"
QUICKCHART_URL = "https://quickchart.io/chart"

ssl_ctx = ssl.create_default_context()
ssl_ctx.check_hostname = False
ssl_ctx.verify_mode = ssl.CERT_NONE

random.seed(99)

# ─── QuickChart helper ────────────────────────────────────────────────────────

def download_image(url, filepath, retries=3):
    for attempt in range(retries):
        try:
            req = urllib.request.Request(url, headers={"User-Agent": "Mozilla/5.0"})
            with urllib.request.urlopen(req, context=ssl_ctx, timeout=25) as resp:
                data = resp.read()
            with open(filepath, 'wb') as f:
                f.write(data)
            return True
        except Exception as e:
            if attempt < retries - 1:
                import time; time.sleep(1.5)
    return False

def quickchart(config_dict, topic_id):
    fp = os.path.join(OUTPUT_DIR, f"di_topic_{topic_id}.png")
    if os.path.exists(fp):
        print(f"  [{topic_id}] Already exists, skipping.")
        return True
    params = urllib.parse.urlencode({
        "c": json.dumps(config_dict),
        "w": 900, "h": 600, "bkg": "white", "f": "png"
    })
    url = f"{QUICKCHART_URL}?{params}"
    ok = download_image(url, fp)
    print(f"  [{topic_id}] {'✓ Saved' if ok else '✗ FAILED'}")
    return ok


# ─── Matplotlib helper ────────────────────────────────────────────────────────

def save_mpl(fig, topic_id):
    fp = os.path.join(OUTPUT_DIR, f"di_topic_{topic_id}.png")
    if os.path.exists(fp):
        print(f"  [{topic_id}] Already exists, skipping.")
        plt.close(fig)
        return True
    try:
        fig.savefig(fp, dpi=120, bbox_inches='tight', facecolor='white')
        plt.close(fig)
        print(f"  [{topic_id}] ✓ Saved (matplotlib)")
        return True
    except Exception as e:
        plt.close(fig)
        print(f"  [{topic_id}] ✗ FAILED: {e}")
        return False


# ─── Image generators ─────────────────────────────────────────────────────────

COLORS = ['#3B82F6','#EF4444','#10B981','#F59E0B','#8B5CF6','#EC4899','#06B6D4','#84CC16','#F97316','#6366F1']
LIGHT = ['#DBEAFE','#FEE2E2','#D1FAE5','#FEF3C7','#EDE9FE','#FCE7F3','#CFFAFE','#D9F99D','#FFEDD5','#E0E7FF']

def make_pie(topic_id, title, labels, values, colors=None):
    if not HAS_MPL: return False
    fig, ax = plt.subplots(figsize=(9, 6))
    fig.patch.set_facecolor('white')
    c = colors or COLORS[:len(labels)]
    wedges, texts, autotexts = ax.pie(values, labels=None, autopct='%1.1f%%',
                                       colors=c, startangle=140,
                                       pctdistance=0.75, wedgeprops=dict(linewidth=2, edgecolor='white'))
    for at in autotexts:
        at.set_fontsize(9); at.set_color('white'); at.set_fontweight('bold')
    ax.legend(wedges, labels, loc='center left', bbox_to_anchor=(1, 0, 0.5, 1),
              fontsize=9, framealpha=0.9)
    ax.set_title(title, fontsize=13, fontweight='bold', pad=18, wrap=True)
    plt.tight_layout()
    return save_mpl(fig, topic_id)

def make_horizontal_bar(topic_id, title, labels, values, xlabel='', color='#3B82F6'):
    if not HAS_MPL: return False
    fig, ax = plt.subplots(figsize=(9, 6))
    fig.patch.set_facecolor('white'); ax.set_facecolor('#F8FAFC')
    y = range(len(labels))
    bars = ax.barh(list(y), values, color=color, edgecolor='white', height=0.65)
    for bar, v in zip(bars, values):
        ax.text(bar.get_width() + max(values)*0.01, bar.get_y() + bar.get_height()/2,
                f'{v:,.1f}', va='center', ha='left', fontsize=9, fontweight='bold')
    ax.set_yticks(list(y)); ax.set_yticklabels(labels, fontsize=9)
    ax.set_xlabel(xlabel, fontsize=10)
    ax.set_title(title, fontsize=13, fontweight='bold', pad=12, wrap=True)
    ax.spines['top'].set_visible(False); ax.spines['right'].set_visible(False)
    ax.grid(axis='x', alpha=0.3)
    plt.tight_layout()
    return save_mpl(fig, topic_id)

def make_stacked_bar(topic_id, title, categories, series_labels, series_data, colors=None):
    if not HAS_MPL: return False
    fig, ax = plt.subplots(figsize=(9, 6))
    fig.patch.set_facecolor('white'); ax.set_facecolor('#F8FAFC')
    c = colors or COLORS[:len(series_labels)]
    x = range(len(categories))
    bottoms = [0]*len(categories)
    for i, (slabel, sdata) in enumerate(zip(series_labels, series_data)):
        ax.bar(list(x), sdata, bottom=bottoms, label=slabel, color=c[i], edgecolor='white', linewidth=0.5)
        bottoms = [b+d for b,d in zip(bottoms, sdata)]
    ax.set_xticks(list(x)); ax.set_xticklabels(categories, fontsize=9, rotation=15, ha='right')
    ax.set_title(title, fontsize=13, fontweight='bold', pad=12, wrap=True)
    ax.legend(fontsize=9, loc='upper right')
    ax.spines['top'].set_visible(False); ax.spines['right'].set_visible(False)
    ax.grid(axis='y', alpha=0.3)
    plt.tight_layout()
    return save_mpl(fig, topic_id)

def make_area(topic_id, title, x_vals, series_labels, series_data, colors=None, xlabel='Year', ylabel='Value'):
    if not HAS_MPL: return False
    fig, ax = plt.subplots(figsize=(9, 6))
    fig.patch.set_facecolor('white'); ax.set_facecolor('#F8FAFC')
    c = colors or COLORS[:len(series_labels)]
    for i, (lbl, data) in enumerate(zip(series_labels, series_data)):
        n = min(len(x_vals), len(data))
        ax.fill_between(x_vals[:n], data[:n], alpha=0.35, color=c[i])
        ax.plot(x_vals[:n], data[:n], color=c[i], linewidth=2.5, label=lbl)
    ax.set_xlabel(xlabel, fontsize=10); ax.set_ylabel(ylabel, fontsize=10)
    ax.set_title(title, fontsize=13, fontweight='bold', pad=12, wrap=True)
    ax.legend(fontsize=9)
    ax.spines['top'].set_visible(False); ax.spines['right'].set_visible(False)
    ax.grid(alpha=0.3)
    plt.tight_layout()
    return save_mpl(fig, topic_id)

def make_scatter(topic_id, title, x_data, y_data, point_labels=None, xlabel='', ylabel='', color='#3B82F6'):
    if not HAS_MPL: return False
    fig, ax = plt.subplots(figsize=(9, 6))
    fig.patch.set_facecolor('white'); ax.set_facecolor('#F8FAFC')
    ax.scatter(x_data, y_data, c=color, s=100, alpha=0.8, edgecolors='white', linewidth=1.5)
    if point_labels:
        for lbl, xi, yi in zip(point_labels, x_data, y_data):
            ax.annotate(lbl, (xi, yi), textcoords='offset points', xytext=(5,5), fontsize=8)
    ax.set_xlabel(xlabel, fontsize=10); ax.set_ylabel(ylabel, fontsize=10)
    ax.set_title(title, fontsize=13, fontweight='bold', pad=12, wrap=True)
    ax.spines['top'].set_visible(False); ax.spines['right'].set_visible(False)
    ax.grid(alpha=0.3)
    plt.tight_layout()
    return save_mpl(fig, topic_id)

def make_bubble(topic_id, title, x_data, y_data, sizes, labels, colors=None, xlabel='', ylabel=''):
    if not HAS_MPL: return False
    fig, ax = plt.subplots(figsize=(9, 6))
    fig.patch.set_facecolor('white'); ax.set_facecolor('#F8FAFC')
    c = colors or COLORS[:len(labels)]
    for xi, yi, si, lbl, col in zip(x_data, y_data, sizes, labels, c):
        ax.scatter(xi, yi, s=si, c=col, alpha=0.7, edgecolors='white', linewidth=2)
        ax.annotate(lbl, (xi, yi), ha='center', va='center', fontsize=8,
                    fontweight='bold', color='white')
    ax.set_xlabel(xlabel, fontsize=10); ax.set_ylabel(ylabel, fontsize=10)
    ax.set_title(title, fontsize=13, fontweight='bold', pad=12, wrap=True)
    ax.spines['top'].set_visible(False); ax.spines['right'].set_visible(False)
    ax.grid(alpha=0.3)
    plt.tight_layout()
    return save_mpl(fig, topic_id)

def make_table_image(topic_id, title, headers, rows, col_widths=None):
    if not HAS_MPL: return False
    fig, ax = plt.subplots(figsize=(9, 6))
    fig.patch.set_facecolor('white')
    ax.axis('off')
    table = ax.table(cellText=rows, colLabels=headers, loc='center', cellLoc='center')
    table.auto_set_font_size(False); table.set_fontsize(9)
    table.scale(1.2, 1.8)
    # Style header
    for j in range(len(headers)):
        table[(0,j)].set_facecolor('#1E3A5F'); table[(0,j)].set_text_props(color='white', fontweight='bold')
    for i in range(1, len(rows)+1):
        for j in range(len(headers)):
            table[(i,j)].set_facecolor('#EFF6FF' if i % 2 == 0 else 'white')
    ax.set_title(title, fontsize=13, fontweight='bold', pad=22, wrap=True)
    plt.tight_layout()
    return save_mpl(fig, topic_id)

def make_process_diagram(topic_id, title, steps, colors=None):
    """Horizontal process/flow diagram with arrows."""
    if not HAS_MPL: return False
    n = len(steps)
    fig, ax = plt.subplots(figsize=(9, 4.5))
    fig.patch.set_facecolor('white'); ax.set_facecolor('white')
    ax.set_xlim(0, n*2.2); ax.set_ylim(-1, 2.5); ax.axis('off')
    c = colors or COLORS[:n]
    ax.set_title(title, fontsize=13, fontweight='bold', y=0.98, wrap=True)
    for i, (step, col) in enumerate(zip(steps, c)):
        x = i * 2.2 + 1.0
        rect = mpatches.FancyBboxPatch((x-0.85, 0.2), 1.7, 1.2,
                                        boxstyle="round,pad=0.1", facecolor=col, edgecolor='white', linewidth=2)
        ax.add_patch(rect)
        ax.text(x, 0.82, step, ha='center', va='center', fontsize=8.5,
                color='white', fontweight='bold', wrap=True,
                multialignment='center')
        ax.text(x, 1.65, f'Step {i+1}', ha='center', va='center', fontsize=8,
                color='#374151', fontweight='bold')
        if i < n-1:
            ax.annotate('', xy=(x+1.1, 0.82), xytext=(x+0.85, 0.82),
                        arrowprops=dict(arrowstyle='->', color='#9CA3AF', lw=2.5))
    plt.tight_layout()
    return save_mpl(fig, topic_id)

def make_radar(topic_id, title, categories, values_list, labels, colors=None):
    """Radar/spider chart."""
    if not HAS_MPL: return False
    N = len(categories)
    angles = [n / float(N) * 2 * 3.14159 for n in range(N)]
    angles += angles[:1]
    fig, ax = plt.subplots(figsize=(7, 7), subplot_kw=dict(polar=True))
    fig.patch.set_facecolor('white')
    c = colors or COLORS[:len(values_list)]
    for vals, lbl, col in zip(values_list, labels, c):
        vals = vals + vals[:1]
        ax.plot(angles, vals, 'o-', linewidth=2, color=col, label=lbl)
        ax.fill(angles, vals, alpha=0.2, color=col)
    ax.set_xticks(angles[:-1]); ax.set_xticklabels(categories, fontsize=9)
    ax.set_title(title, fontsize=13, fontweight='bold', pad=28, wrap=True)
    ax.legend(loc='upper right', bbox_to_anchor=(1.3, 1.1), fontsize=9)
    plt.tight_layout()
    return save_mpl(fig, topic_id)

def make_choropleth_map(topic_id, title, country_values):
    """Simplified world map with colored regions using QuickChart."""
    # Use a simple bar chart as a proxy for map data (choropleth difficult without geopandas)
    labels = list(country_values.keys())[:12]
    values = list(country_values.values())[:12]
    colors_sorted = COLORS[:len(labels)]
    config = {
        "type": "bar",
        "data": {
            "labels": labels,
            "datasets": [{"label": title, "data": values, "backgroundColor": colors_sorted}]
        },
        "options": {
            "plugins": {"title": {"display": True, "text": title, "font": {"size": 14, "weight": "bold"}}},
            "scales": {"y": {"grid": {"color": "#F3F4F6"}}},
            "indexAxis": "y"
        }
    }
    return quickchart(config, topic_id)

def make_donut_qc(topic_id, title, labels, values, colors=None):
    c = colors or COLORS[:len(labels)]
    config = {
        "type": "doughnut",
        "data": {"labels": labels, "datasets": [{"data": values, "backgroundColor": c, "borderWidth": 3}]},
        "options": {"plugins": {"title": {"display": True, "text": title, "font": {"size": 14, "weight": "bold"}},
                                "legend": {"position": "right"}}}
    }
    return quickchart(config, topic_id)


# ─── 200 Diverse Topics (101-300) ─────────────────────────────────────────────

def gen_all(start, end):
    """Generate diverse images for topics 101-300."""

    def t(tid):
        """Generate one topic. Returns (tid, generator_fn_call)."""
        r = {}

        # PIE CHARTS (101-120)
        if tid == 101:
            return make_pie(101, "Global Energy Consumption by Source (2022)",
                ["Oil (31%)", "Coal (27%)", "Gas (23%)", "Renewables (13%)", "Nuclear (5%)"],
                [31, 27, 23, 13, 5])
        if tid == 102:
            return make_pie(102, "World Land Use by Category (2019)",
                ["Agriculture (50%)", "Forest (37%)", "Shrub/Grassland (11%)", "Other (2%)"],
                [50, 37, 11, 2], ['#10B981','#059669','#D97706','#6B7280'])
        if tid == 103:
            return make_donut_qc(103, "Global CO2 Emissions by Sector (2022)",
                ["Energy (73.2%)", "Agriculture (18.4%)", "Industrial (5.2%)", "Waste (3.2%)"],
                [73.2, 18.4, 5.2, 3.2], ['#EF4444','#10B981','#3B82F6','#F59E0B'])
        if tid == 104:
            return make_pie(104, "Internet Traffic by Device Type (2023)",
                ["Mobile (58%)", "Desktop (40%)", "Tablet (2%)"],
                [58, 40, 2], ['#3B82F6','#8B5CF6','#10B981'])
        if tid == 105:
            return make_pie(105, "Global Music Streaming Market Share (2023)",
                ["Spotify (31%)", "Apple Music (15%)", "Amazon (13%)", "YouTube (9%)", "Others (32%)"],
                [31, 15, 13, 9, 32], ['#1DB954','#FC3C44','#FF9900','#FF0000','#6B7280'])
        if tid == 106:
            return make_donut_qc(106, "Reasons for Employee Turnover (2023 Survey)",
                ["Better Pay (38%)", "Career Growth (22%)", "Work-Life Balance (18%)", "Culture (12%)", "Other (10%)"],
                [38, 22, 18, 12, 10])
        if tid == 107:
            return make_pie(107, "Household Water Usage Distribution (Average, %, USA)",
                ["Toilet (28%)", "Shower (19%)", "Faucet (15%)", "Washer (17%)", "Leaks (12%)", "Other (9%)"],
                [28, 19, 15, 17, 12, 9])
        if tid == 108:
            return make_pie(108, "Primary School Subjects Time Allocation (UK, 2023, %)",
                ["Literacy (30%)", "Numeracy (20%)", "Science (15%)", "Arts (10%)", "PE (10%)", "Other (15%)"],
                [30, 20, 15, 10, 10, 15])
        if tid == 109:
            return make_donut_qc(109, "Sources of Plastic Pollution in Oceans (2022)",
                ["Fishing (46%)", "Land-based (32%)", "Shipping (14%)", "Other (8%)"],
                [46, 32, 14, 8], ['#3B82F6','#EF4444','#10B981','#F59E0B'])
        if tid == 110:
            return make_pie(110, "Where Do Teens Get Their News? (USA, 2023)",
                ["Social Media (64%)", "TV (13%)", "Online News (11%)", "Family (7%)", "Other (5%)"],
                [64, 13, 11, 7, 5])

        # STACKED BAR CHARTS (111-130)
        if tid == 111:
            return make_stacked_bar(111, "Global Electricity Generation by Source (TWh, Selected Countries, 2022)",
                ['USA','China','Germany','Brazil','India'],
                ['Fossil','Nuclear','Hydro','Wind/Solar'],
                [[2800,4800,300,400,1200],[780,350,10,10,45],[150,60,20,100,50],[80,30,360,20,20]],
                ['#EF4444','#F59E0B','#3B82F6','#10B981'])
        if tid == 112:
            return make_stacked_bar(112, "Household Income Spending Breakdown by Country (%, 2022)",
                ['USA','UK','Japan','Germany','Brazil'],
                ['Housing','Food','Transport','Health','Other'],
                [[33,35,30,28,25],[12,11,14,12,13],[13,12,11,14,9],[8,6,5,12,7],[34,36,40,34,46]],
                ['#3B82F6','#10B981','#F59E0B','#EF4444','#8B5CF6'])
        if tid == 113:
            return make_stacked_bar(113, "World Tourism Revenue by Region (USD Billion, 2018–2022)",
                ['2018','2019','2020','2021','2022'],
                ['Europe','Americas','Asia-Pacific','Middle East','Africa'],
                [[563,580,140,230,475],[350,363,99,180,340],[359,374,56,140,294],[73,76,19,45,79],[38,40,5,25,40]],
                ['#3B82F6','#10B981','#F59E0B','#EF4444','#8B5CF6'])
        if tid == 114:
            return make_stacked_bar(114, "Social Media Time Per Day by Age Group (Minutes, 2023)",
                ['13-17','18-24','25-34','35-44','45-54','55+'],
                ['TikTok','Instagram','Facebook','Others'],
                [[55,60,40,25,12,5],[35,45,35,20,10,8],[20,30,45,40,30,20],[25,35,30,25,20,15]],
                ['#000000','#E1306C','#1877F2','#9CA3AF'])
        if tid == 115:
            return make_stacked_bar(115, "National Budget Allocation by Sector (%, Selected Nations, 2022)",
                ['Sweden','USA','Japan','India','Brazil'],
                ['Healthcare','Education','Defense','Infrastructure','Other'],
                [[25,25,21,6,14],[28,14,16,8,25],[22,9,6,13,40],[5,15,13,22,35],[10,14,5,15,51]],
                ['#EF4444','#3B82F6','#6B7280','#10B981','#F59E0B'])
        if tid == 116:
            return make_stacked_bar(116, "Causes of Death by Region (% of Total, WHO 2019)",
                ['Americas','Europe','Africa','S-E Asia','W-Pacific'],
                ['Cardiovascular','Cancer','Respiratory','Infectious','Other'],
                [[34,38,17,28,32],[52,44,15,35,40],[12,10,37,15,12],[9,8,12,10,9],[3,0,19,12,7]])
        if tid == 117:
            return make_stacked_bar(117, "Renewable Energy Capacity Added by Type (GW, 2018–2022)",
                ['2018','2019','2020','2021','2022'],
                ['Solar PV','Wind','Hydro','Other Renewables'],
                [[94,115,127,175,240],[51,60,73,93,77],[21,12,20,26,23],[8,9,11,12,14]],
                ['#F59E0B','#10B981','#3B82F6','#8B5CF6'])
        if tid == 118:
            return make_stacked_bar(118, "University Graduate Employment by Sector (%, 2022)",
                ['Engineering','Business','Medicine','Arts','Law'],
                ['Private Sector','Public Sector','Freelance/Self','Further Study'],
                [[62,55,40,35,65],[15,25,50,10,30],[10,12,5,25,3],[13,8,5,30,2]],
                ['#3B82F6','#10B981','#F59E0B','#EF4444'])
        if tid == 119:
            return make_stacked_bar(119, "Global Deforestation Causes by Region (%, 2020)",
                ['South America','Africa','S-E Asia','Central America'],
                ['Cattle Ranching','Smallholder Ag.','Commercial Ag.','Logging'],
                [[65,20,25,45],[4,68,15,12],[6,37,33,24],[50,35,10,5]],
                ['#EF4444','#10B981','#F59E0B','#6B7280'])
        if tid == 120:
            return make_stacked_bar(120, "Daily Calorie Intake Source by Country (%, 2020)",
                ['USA','India','Japan','Brazil','Nigeria'],
                ['Cereals & Grains','Meat & Dairy','Vegetables','Fats & Oils','Other'],
                [[28,36,40,32,55],[50,12,35,28,30],[41,18,15,18,12],[8,16,8,12,8],[14,18,2,10,7]],
                ['#F59E0B','#EF4444','#10B981','#8B5CF6','#6B7280'])

        # AREA / LINE CHARTS (121-140)
        if tid == 121:
            yrs = list(range(2000, 2024))
            return make_area(121, "Global Renewable Energy Share (% of Total Electricity, 2000–2023)",
                yrs,
                ['Solar PV','Wind','Hydro'],
                [[0.01,0.01,0.03,0.04,0.05,0.1,0.15,0.2,0.35,0.5,0.8,1.1,1.5,2.0,2.8,3.5,4.5,5.7,6.8,7.8,8.9,10.1,11.5,12.8],
                 [0.3,0.4,0.5,0.6,0.8,1.0,1.2,1.5,2.0,2.5,3.0,3.7,4.5,5.5,6.5,7.5,8.5,9.5,10.5,11.5,12.5,13.8,15.2,16.5],
                 [16,16.5,16.2,16.7,17,16.5,16.3,16.8,16.6,16.5,16.8,16.9,17.0,16.8,16.6,16.5,16.2,16.1,16.0,15.8,16.0,15.9,15.8,15.7]],
                xlabel='Year', ylabel='% Share')
        if tid == 122:
            yrs = list(range(1990, 2024))
            return make_area(122, "Global Urban vs Rural Population (Billions, 1990–2023)",
                yrs,
                ['Urban Population','Rural Population'],
                [[2.28,2.37,2.47,2.58,2.69,2.80,2.91,3.03,3.15,3.27,3.40,3.53,3.66,3.79,3.93,4.07,4.22,4.37,4.52,4.67,4.82,4.97,5.12,5.27,5.42,5.57,5.72,5.87,6.02,6.17,6.32,6.47,6.62,6.77],
                 [3.05,3.07,3.10,3.13,3.16,3.18,3.20,3.22,3.24,3.26,3.28,3.29,3.30,3.31,3.31,3.30,3.30,3.29,3.28,3.26,3.24,3.22,3.20,3.18,3.16,3.14,3.12,3.10,3.08,3.07,3.06,3.05,3.04,3.03]],
                xlabel='Year', ylabel='Billions', colors=['#3B82F6','#10B981'])
        if tid == 123:
            yrs = list(range(2010, 2024))
            return make_area(123, "Global E-Commerce Sales (USD Trillion, 2010–2023)",
                yrs,
                ['B2C Sales','B2B Sales'],
                [[0.57,0.78,1.05,1.31,1.57,1.88,2.35,2.93,3.53,4.28,5.46,5.21,5.79,6.31],
                 [7.2,8.1,9.0,10.0,11.5,13.2,15.0,17.2,20.0,22.0,25.0,22.0,26.0,30.0]],
                xlabel='Year', ylabel='USD Trillion', colors=['#3B82F6','#EF4444'])
        if tid == 124:
            yrs = list(range(2005, 2024))
            return make_area(124, "Global Average Temperature Anomaly (°C above Pre-industrial, 2005–2023)",
                yrs,
                ['Annual Average','5-Year Rolling Average'],
                [[0.72,0.67,0.66,0.54,0.64,0.72,0.61,0.65,0.68,0.75,0.87,0.91,1.01,0.93,1.02,1.01,1.13,1.20,1.45],
                 [0.64,0.65,0.65,0.64,0.65,0.66,0.65,0.67,0.69,0.73,0.78,0.84,0.90,0.96,1.01,1.07,1.12,1.18,1.26]],
                xlabel='Year', ylabel='°C', colors=['#EF4444','#F97316'])
        if tid == 125:
            yrs = list(range(2000, 2024))
            return make_area(125, "Number of Internet Users by Region (Millions, 2000–2023)",
                yrs,
                ['Asia-Pacific','Europe','Americas','Africa','Middle East'],
                [[114,186,289,397,514,620,737,862,1000,1142,1303,1446,1584,1726,1879,2026,2183,2344,2512,2680,2855,3020,3190,3362],
                 [105,147,190,231,271,303,337,373,409,447,484,512,540,566,593,619,645,671,697,723,749,775,801,827],
                 [180,218,257,296,332,364,397,431,466,500,534,561,588,615,643,671,700,730,762,796,830,865,900,936],
                 [4,7,12,17,24,33,46,62,80,100,120,140,160,182,208,237,270,308,352,400,453,510,576,648],
                 [4,7,11,15,19,24,30,37,44,52,61,68,75,83,92,101,111,122,134,148,163,179,197,216]],
                xlabel='Year', ylabel='Millions')
        if tid == 126:
            yrs = list(range(1950, 2024, 5))
            return make_area(126, "Global CO2 Concentration (ppm, 1950–2020)",
                yrs,
                ['Atmospheric CO2 (ppm)'],
                [[310,315,320,325,330,338,345,354,360,367,373,381,388,395,401,410,415]],
                xlabel='Year', ylabel='Parts Per Million (ppm)', colors=['#EF4444'])
        if tid == 127:
            yrs = list(range(2000, 2024))
            return make_area(127, "Global Electric Vehicle Stock (Millions, 2010–2023)",
                list(range(2010, 2024)),
                ['Battery EV','Plug-in Hybrid'],
                [[0.01,0.06,0.18,0.37,0.66,1.07,1.73,2.70,4.04,5.89,8.63,11.24,14.80,20.35],
                 [0.003,0.03,0.10,0.26,0.54,0.91,1.35,2.0,2.85,3.97,5.25,6.83,8.60,11.24]],
                xlabel='Year', ylabel='Millions', colors=['#3B82F6','#10B981'])
        if tid == 128:
            yrs = list(range(1970, 2024, 3))
            return make_area(128, "Global Life Expectancy at Birth (Years, 1970–2023)",
                yrs,
                ['World Average','High Income','Low Income'],
                [[58.7,60.1,61.6,63.0,64.3,65.5,66.7,68.0,69.3,70.5,71.5,72.3,73.0,73.7,74.4,75.2,75.9],
                 [71.5,72.1,73.0,73.8,74.5,75.2,75.9,76.5,77.1,77.8,78.5,79.1,79.7,80.3,80.9,81.4,81.9],
                 [44.9,46.5,48.1,49.7,51.2,52.7,54.1,55.4,56.7,57.8,58.9,60.0,61.1,62.1,63.1,64.0,65.0]],
                xlabel='Year', ylabel='Years', colors=['#3B82F6','#10B981','#EF4444'])
        if tid == 129:
            yrs = list(range(1960, 2024, 4))
            return make_area(129, "Global Agricultural Land Area (Million Hectares, 1961–2020)",
                list(range(1961, 2022, 4)),
                ['Cropland','Permanent Meadows & Pastures'],
                [[1368,1378,1388,1400,1415,1425,1435,1448,1458,1468,1475,1480,1485,1488,1490,1492],
                 [3210,3230,3260,3290,3350,3400,3440,3490,3510,3530,3550,3570,3580,3590,3600,3605]],
                xlabel='Year', ylabel='Million Hectares', colors=['#10B981','#F59E0B'])
        if tid == 130:
            yrs = list(range(2000, 2024))
            return make_area(130, "Global R&D Spending (% of GDP) by Region (2000–2023)",
                yrs,
                ['North America','Europe','East Asia','Rest of World'],
                [[2.55,2.61,2.59,2.62,2.62,2.57,2.58,2.62,2.72,2.73,2.68,2.69,2.72,2.74,2.75,2.74,2.74,2.77,2.78,2.82,2.85,2.87,2.90,2.93],
                 [1.80,1.84,1.87,1.87,1.84,1.83,1.84,1.85,1.87,1.90,1.91,1.93,1.93,1.95,1.94,1.93,1.95,1.96,1.97,2.0,2.01,2.03,2.05,2.07],
                 [2.3,2.4,2.5,2.6,2.7,2.9,3.1,3.3,3.5,3.7,3.9,4.1,4.2,4.3,4.4,4.5,4.6,4.7,4.8,4.9,4.95,5.0,5.05,5.1],
                 [0.6,0.65,0.7,0.72,0.75,0.78,0.82,0.86,0.90,0.95,1.0,1.05,1.10,1.14,1.18,1.21,1.24,1.26,1.28,1.30,1.31,1.32,1.33,1.34]],
                xlabel='Year', ylabel='% of GDP')

        # HORIZONTAL BAR CHARTS (131-150)
        if tid == 131:
            return make_horizontal_bar(131, "Countries with Highest Median Age (2023)",
                ['Japan','Monaco','Germany','Italy','Finland','Greece','Portugal','Bulgaria','Croatia','Sweden'],
                [49.5,55.4,47.8,47.3,43.2,45.3,46.0,44.0,44.9,41.2],
                'Median Age (Years)', '#6366F1')
        if tid == 132:
            return make_horizontal_bar(132, "Top 10 Countries by Renewable Energy Capacity (GW, 2022)",
                ['China','USA','Brazil','India','Germany','Japan','UK','Spain','France','Italy'],
                [1,132,186,175,134,133,74,60,59,56],
                'Installed Capacity (GW)', '#10B981')
        if tid == 133:
            return make_horizontal_bar(133, "Most Polluted Cities by PM2.5 (μg/m³, 2022)",
                ['Lahore, PK','Hotan, CN','Bhiwadi, IN','Delhi, IN','Peshawar, PK',
                 'Darbhanga, IN','N.Jehanabad, IN','Muzaffarpur, IN','Faridabad, IN','Bahawalpur, PK'],
                [97.4,95.0,92.7,92.6,91.8,90.3,87.4,84.9,83.5,83.0],
                'Annual Mean PM2.5 (μg/m³)', '#EF4444')
        if tid == 134:
            return make_horizontal_bar(134, "Top Countries by Number of UNESCO World Heritage Sites (2023)",
                ['Italy','China','Germany','France','Spain','India','Mexico','UK','Russia','Iran'],
                [58,57,52,52,50,42,35,33,30,26],
                'Number of Sites', '#F59E0B')
        if tid == 135:
            return make_horizontal_bar(135, "Global Teacher Salaries (Average Annual, USD, 2022)",
                ['Luxembourg','Switzerland','Germany','Australia','Ireland','USA','Netherlands','Belgium','Canada','Finland'],
                [80000,75000,67000,65000,60000,58000,55000,53000,51000,49000],
                'Annual Salary (USD)', '#8B5CF6')
        if tid == 136:
            return make_horizontal_bar(136, "Highest Food Waste Per Capita (kg/year, 2022)",
                ['Nigeria','Saudi Arabia','Ethiopia','Egypt','Japan','USA','Germany','UK','France','China'],
                [189,183,176,165,134,127,75,77,79,91],
                'Food Waste per Capita (kg/year)', '#F97316')
        if tid == 137:
            return make_horizontal_bar(137, "Countries Spending Most on Healthcare per Capita (USD, 2021)",
                ['USA','Switzerland','Norway','Germany','Austria','Sweden','Denmark','Netherlands','Belgium','Australia'],
                [12318,9660,8088,7383,6693,6262,6172,6008,5765,5765],
                'USD per Person', '#EF4444')
        if tid == 138:
            return make_horizontal_bar(138, "Countries with Most Public Holidays (days/year, 2023)",
                ['Cambodia','Myanmar','Sri Lanka','India','Colombia','Philippines','Nepal','Thailand','Malaysia','China'],
                [28,21,25,21,18,20,15,19,17,16],
                'Number of Public Holidays', '#06B6D4')
        if tid == 139:
            return make_horizontal_bar(139, "Busiest Container Ports in the World (Million TEUs, 2022)",
                ['Shanghai','Singapore','Ningbo','Shenzhen','Guangzhou','Busan','Tianjin','Hong Kong','Rotterdam','Dubai'],
                [47.3,37.3,33.4,30.0,24.2,21.3,20.8,16.7,14.5,14.0],
                'TEUs (millions)', '#3B82F6')
        if tid == 140:
            return make_horizontal_bar(140, "Countries with Highest Smartphone Penetration Rate (%, 2023)",
                ['UAE','South Korea','Netherlands','Sweden','Denmark','Norway','UK','USA','Japan','Australia'],
                [99,97,97,96,95,95,94,94,93,92],
                'Smartphone Penetration (%)', '#10B981')

        # SCATTER PLOTS (141-150)
        if tid == 141:
            return make_scatter(141, "GDP per Capita vs. Life Expectancy (Selected Countries, 2022)",
                [65000,80000,45000,55000,7000,2000,12000,18000,35000,28000],
                [79,83,77,81,68,60,74,75,77,76],
                ['USA','Norway','UK','Germany','China','Nigeria','Brazil','Mexico','France','S.Korea'],
                xlabel='GDP per Capita (USD)', ylabel='Life Expectancy (Years)', color='#3B82F6')
        if tid == 142:
            return make_scatter(142, "Education Spending vs. PISA Score (Countries, 2022)",
                [14000,12000,11000,9000,8000,7000,5000,3000,2000,15000],
                [495,523,520,513,497,482,419,428,401,497],
                ['USA','Finland','Singapore','Germany','UK','France','Brazil','India','Nigeria','Luxembourg'],
                xlabel='Education Spend per Student (USD)', ylabel='PISA Average Score', color='#8B5CF6')
        if tid == 143:
            return make_scatter(143, "Internet Access vs. Human Development Index (2022)",
                [93,90,88,85,80,70,55,40,25,12],
                [0.95,0.93,0.92,0.90,0.87,0.78,0.70,0.62,0.52,0.40],
                ['Norway','Germany','Japan','USA','S.Korea','Brazil','China','India','Nigeria','Ethiopia'],
                xlabel='Internet Access (%)', ylabel='HDI Score', color='#10B981')
        if tid == 144:
            return make_scatter(144, "Urbanization Rate vs. Income Level (Countries, 2022)",
                [82,84,79,91,60,35,55,40,30,95],
                [65000,45000,40000,55000,10000,800,3000,1800,700,85000],
                ['USA','UK','France','Singapore','China','Ethiopia','India','Nigeria','Cambodia','Monaco'],
                xlabel='Urbanization Rate (%)', ylabel='GDP per Capita (USD)', color='#EF4444')
        if tid == 145:
            return make_scatter(145, "CO2 Emissions vs. GDP per Capita (Top Economies, 2021)",
                [14.7,5.1,8.6,9.5,6.6,6.0,4.4,2.8,7.5,10.3],
                [65000,10000,50000,55000,30000,15000,40000,7000,45000,12000],
                ['USA','China','Germany','Australia','Japan','Brazil','UK','India','Canada','Russia'],
                xlabel='CO2 per Capita (tonnes)', ylabel='GDP per Capita (USD)', color='#F59E0B')

        # TABLES (146-160)
        if tid == 146:
            return make_table_image(146, "Top 10 Countries by Total Renewable Energy Output (2022)",
                ['Country','Solar (GW)','Wind (GW)','Hydro (GW)','Total (GW)'],
                [['China','392','342','398','1,132'],['USA','142','144','80','366'],
                 ['Brazil','28','25','109','162'],['India','63','44','47','154'],
                 ['Germany','66','67','5','138'],['UK','15','28','2','45'],
                 ['France','17','21','25','63'],['Japan','80','5','50','135'],
                 ['Australia','31','10','8','49'],['Spain','25','29','17','71']])
        if tid == 147:
            return make_table_image(147, "Comparative Cost of Living Index (2023, New York City = 100)",
                ['City','Cost Index','Rent Index','Restaurant Index','Groceries'],
                [['New York','100','100','100','100'],['London','79','73','75','62'],
                 ['Tokyo','69','28','60','60'],['Sydney','80','55','74','75'],
                 ['Singapore','83','86','65','61'],['Dubai','63','63','51','55'],
                 ['Paris','83','54','84','77'],['Berlin','58','39','56','55'],
                 ['Mumbai','27','17','19','26'],['Toronto','73','62','65','69']])
        if tid == 148:
            return make_table_image(148, "Global Mental Health Statistics by Region (WHO, 2022)",
                ['Region','Depression (%)','Anxiety (%)','Seeking Help (%)','Psychiatrists/100k'],
                [['North America','6.9','10.4','42','15.6'],['Europe','6.4','8.3','38','17.2'],
                 ['Latin America','7.7','9.8','27','3.5'],['S-E Asia','4.4','5.4','12','0.4'],
                 ['Africa','3.7','4.1','8','0.1'],['W.Pacific','3.8','5.2','15','1.2'],
                 ['Middle East','5.7','7.8','18','1.5'],['World Avg','4.4','3.6','20','1.6']])
        if tid == 149:
            return make_table_image(149, "Space Agency Budgets and Missions (2022–2023)",
                ['Agency','Country','Budget (USD B)','Active Missions','Staff (K)'],
                [['NASA','USA','24.0','96','17.4'],['ESA','Europe','7.2','29','2.5'],
                 ['ISRO','India','1.9','40','16.7'],['CNSA','China','12.0','N/A','N/A'],
                 ['Roscosmos','Russia','2.7','N/A','N/A'],['JAXA','Japan','2.0','24','1.7'],
                 ['CSA','Canada','0.5','7','0.67'],['KARI','S.Korea','0.7','5','0.9']])
        if tid == 150:
            return make_table_image(150, "World's Most Spoken Languages (Top 10, 2023)",
                ['Rank','Language','Native Speakers (M)','Total Speakers (M)','Official Countries'],
                [['1','English','380','1,500','67'],['2','Mandarin','920','1,120','3'],
                 ['3','Hindi','600','700','1'],['4','Spanish','475','600','21'],
                 ['5','French','80','280','29'],['6','Arabic','275','370','26'],
                 ['7','Bengali','265','270','2'],['8','Portuguese','240','265','9'],
                 ['9','Russian','155','260','2'],['10','Urdu','70','230','2']])

        # PROCESS / FLOW DIAGRAMS (151-170)
        if tid == 151:
            return make_process_diagram(151, "The Water Cycle: Natural Hydrological Process",
                ['Evaporation\n& Transpiration','Condensation\n& Cloud Form.','Precipitation\n(Rain/Snow)',
                 'Surface Runoff\n& Infiltration','Collection in\nOceans & Lakes'],
                ['#3B82F6','#60A5FA','#93C5FD','#6EE7B7','#34D399'])
        if tid == 152:
            return make_process_diagram(152, "How a Bill Becomes Law (USA Legislative Process)",
                ['Bill Introduced\nin Congress','Committee\nReview','Floor\nVoting',
                 'Presidential\nSignature','Law Enacted\n& Implemented'],
                ['#EF4444','#F97316','#F59E0B','#10B981','#3B82F6'])
        if tid == 153:
            return make_process_diagram(153, "Stages of Product Development in a Tech Company",
                ['Market\nResearch','Concept &\nDesign','Prototyping\n& Testing',
                 'Mass\nProduction','Launch &\nMarketing','Post-Launch\nSupport'],
                ['#8B5CF6','#6366F1','#3B82F6','#10B981','#F59E0B','#EF4444'])
        if tid == 154:
            return make_process_diagram(154, "Carbon Capture and Storage (CCS) Process",
                ['CO2\nEmission\n(Industry)','CO2 Capture\nFilter','Compression\n& Transport',
                 'Injection into\nGeological Store','Permanent\nUnderground\nStorage'],
                ['#EF4444','#F59E0B','#10B981','#3B82F6','#1E40AF'])
        if tid == 155:
            return make_process_diagram(155, "The Criminal Justice Process (Overview)",
                ['Crime\nCommitted','Police\nInvestigation','Arrest &\nCharging',
                 'Trial\n& Verdict','Sentencing','Incarceration\nor Probation'],
                ['#EF4444','#F97316','#F59E0B','#10B981','#3B82F6','#6366F1'])
        if tid == 156:
            return make_process_diagram(156, "How Solar Panels Generate Electricity",
                ['Sunlight\nHits Panels','Photovoltaic\nCells Activated','DC Electricity\nGenerated',
                 'Inverter\nConverts to AC','Powers Home\nor Grid Export'],
                ['#F59E0B','#FCD34D','#10B981','#3B82F6','#8B5CF6'])
        if tid == 157:
            return make_process_diagram(157, "Supply Chain Management: From Farm to Consumer",
                ['Raw Material\nProduction','Processing &\nManufacturing','Warehousing\n& Storage',
                 'Distribution\n& Logistics','Retail &\nSales','Consumer\nDelivery'],
                ['#10B981','#059669','#F59E0B','#3B82F6','#8B5CF6','#EC4899'])
        if tid == 158:
            return make_process_diagram(158, "Human Body: Blood Circulation Pathway",
                ['Heart Pumps\nOxygenated Blood','Arteries\nDistribute Blood','Capillaries\nDeliver Oxygen',
                 'Veins Return\nDeoxygenated','Lungs\nReoxygenate','Back to\nHeart'],
                ['#EF4444','#F97316','#10B981','#3B82F6','#8B5CF6','#EF4444'])
        if tid == 159:
            return make_process_diagram(159, "The Scientific Method",
                ['Observation\n& Question','Background\nResearch','Hypothesis\nFormulation',
                 'Experiment\nDesign & Test','Data Analysis','Conclusion\n& Report'],
                ['#8B5CF6','#6366F1','#3B82F6','#10B981','#F59E0B','#EF4444'])
        if tid == 160:
            return make_process_diagram(160, "How Vaccines Work in the Human Immune System",
                ['Vaccine\nAdministered','Antigens\nIntroduced','Immune\nResponse Triggered',
                 'Antibodies\nProduced','Memory Cells\nCreated','Future\nImmunity Achieved'],
                ['#EC4899','#EF4444','#F97316','#F59E0B','#10B981','#3B82F6'])

        # RADAR CHARTS (161-170)
        if tid == 161:
            return make_radar(161, "Quality of Life Index by Country (2023, Scale 0–100)",
                ['Healthcare','Education','Safety','Economy','Environment','Happiness'],
                [[82,90,82,85,88,90],[91,88,87,78,85,95],[75,78,80,88,70,72],[68,65,72,82,60,68],[52,58,65,55,78,65]],
                ['Norway','Finland','Germany','USA','Brazil'],
                ['#3B82F6','#10B981','#EF4444','#F59E0B','#8B5CF6'])
        if tid == 162:
            return make_radar(162, "University Performance Metrics (Top 5 Global, 2023)",
                ['Research Output','Teaching Quality','Citations','Int\'l Diversity','Industry Links','Graduate Rate'],
                [[95,88,95,85,90,93],[92,90,88,80,85,90],[88,85,92,90,88,88],[85,92,86,95,80,89],[90,87,85,82,95,91]],
                ['MIT','Oxford','Stanford','Cambridge','Harvard'])
        if tid == 163:
            return make_radar(163, "Country Competitiveness in Key Sectors (WEF, 2023)",
                ['Innovation','Infrastructure','Market Size','Business Env.','Human Capital','Macroeconomic'],
                [[95,90,90,88,85,90],[85,82,55,80,82,78],[88,79,100,72,75,72],[90,95,30,95,90,82],[72,65,90,68,65,55]],
                ['USA','Germany','China','Singapore','Brazil'],
                ['#3B82F6','#EF4444','#F59E0B','#10B981','#8B5CF6'])
        if tid == 164:
            return make_radar(164, "Digital Readiness Index by Region (2023, 0–100 Scale)",
                ['Connectivity','Digital Skills','E-Government','Innovation','Cybersecurity','Digital Economy'],
                [[82,85,88,90,85,88],[78,80,82,85,80,83],[55,58,60,62,55,60],[35,40,45,48,38,42],[25,30,32,35,28,30]],
                ['North America','Europe','E.Asia','L.America','S.S.Africa'])
        if tid == 165:
            return make_radar(165, "Athlete Performance Profile: Olympic Sports (Hypothetical)",
                ['Speed','Strength','Endurance','Agility','Technique','Mental Toughness'],
                [[95,70,60,90,95,88],[70,98,80,65,85,82],[60,55,98,70,75,90],[85,75,70,95,80,78],[75,85,95,75,80,88]],
                ['Sprinter','Weightlifter','Marathon','Gymnast','Swimmer'],
                ['#EF4444','#F59E0B','#3B82F6','#10B981','#8B5CF6'])

        # BUBBLE CHARTS (166-175)
        if tid == 166:
            return make_bubble(166, "Tech Giants: Revenue vs. Market Cap vs. Employees (2023)",
                [383,311,229,168,134,90,74,55],
                [2870,2830,1160,1780,726,780,1250,780],
                [15000,22000,10000,12000,6000,5000,9000,3500],
                ['Apple','MSFT','Alphabet','Amazon','Meta','TSMC','Samsung','Netflix'],
                ['#1D1D1F','#00A2ED','#EA4335','#FF9900','#1877F2','#EB1C24','#1428A0','#E50914'],
                xlabel='Revenue (USD B)', ylabel='Market Cap (USD B)')
        if tid == 167:
            return make_bubble(167, "Countries: Population vs. GDP vs. Carbon Footprint (2022)",
                [5.0,1.0,1.4,0.34,0.22,0.24,0.21,0.14],
                [65000,3500,10500,75000,50000,55000,35000,85000],
                [10000,8000,15000,5000,7000,4000,3000,3000],
                ['China*','India','USA*','Aus.','UK','Ger.','Bra.','Swi.'],
                ['#EF4444','#F59E0B','#3B82F6','#10B981','#8B5CF6','#F97316','#06B6D4','#EC4899'],
                xlabel='Avg Annual CO2/Capita (t)', ylabel='GDP per Capita (USD)')
        if tid == 168:
            return make_bubble(168, "Global Cities: Cost of Living vs. Quality of Life (2023)",
                [100,79,69,80,83,63,83,58,27,73],
                [85,88,82,83,88,80,81,84,60,80],
                [5000,4000,3500,4000,4500,4000,4000,3500,2000,3500],
                ['NYC','London','Tokyo','Sydney','Singapore','Dubai','Paris','Berlin','Mumbai','Toronto'],
                COLORS,
                xlabel='Cost of Living Index', ylabel='Quality of Life Score')

        # MORE HORIZONTAL BARS (169-180)
        if tid == 169:
            return make_horizontal_bar(169, "Countries with Highest Prison Population Rate (per 100,000, 2023)",
                ['El Salvador','Cuba','USA','Turkmenistan','Maldives','Thailand','Rwanda','Panama','St. Kitts','British VI'],
                [1086,794,531,522,513,459,456,454,434,425],
                'Prisoners per 100,000 People', '#6B7280')
        if tid == 170:
            return make_horizontal_bar(170, "Most Visited Art Museums in the World (2022, Millions)",
                ['Louvre, Paris','National Gallery, DC','Metropolitan, NYC','Tate Modern, London',
                 'Vatican Museums','British Museum','Hermitage, StP.','Uffizi, Florence',
                 'Musée d\'Orsay','Prado, Madrid'],
                [7.7,4.2,3.2,5.5,4.4,5.8,3.0,4.0,3.3,3.2],
                'Visitors (Millions)', '#EC4899')

        # MORE PIE CHARTS (171-180)
        if tid == 171:
            return make_pie(171, "Global Arms Sales by Country of Origin (2018–2022, %)",
                ['USA (40%)','Russia (16%)','France (11%)','China (5%)','Germany (4%)','Others (24%)'],
                [40,16,11,5,4,24], ['#3B82F6','#EF4444','#1E40AF','#F59E0B','#374151','#9CA3AF'])
        if tid == 172:
            return make_donut_qc(172, "Global Forest Area by Region (% of World Total, 2022)",
                ['S.America (33%)','N.America (16%)','Africa (16%)','Russia/CIS (20%)','Asia (10%)','Other (5%)'],
                [33,16,16,20,10,5], ['#10B981','#3B82F6','#F59E0B','#6B7280','#EF4444','#8B5CF6'])
        if tid == 173:
            return make_pie(173, "Top Reasons People Do Not Exercise (Global Survey, 2023)",
                ['No Time (41%)','Lack of Motivation (27%)','Health Issues (13%)','Too Expensive (10%)','Other (9%)'],
                [41,27,13,10,9])
        if tid == 174:
            return make_pie(174, "Global E-Waste by Product Category (2022, Metric Tonnes)",
                ['Small Equipment (24%)','Large Equipment (9%)','Temp Exchange (7%)','Screens (13%)','Lamps (1%)','Other (46%)'],
                [24,9,7,13,1,46], ['#EF4444','#3B82F6','#10B981','#F59E0B','#EC4899','#6B7280'])
        if tid == 175:
            return make_pie(175, "Causes of Global Freshwater Depletion (2022)",
                ['Agriculture (70%)','Industry (20%)','Municipal (10%)'],
                [70,20,10], ['#10B981','#3B82F6','#6B7280'])

        # MORE PROCESS / INFOGRAPHIC DIAGRAMS (176-190)
        if tid == 176:
            return make_process_diagram(176, "How Plastic Is Recycled: The Recycling Process",
                ['Collection &\nSorting','Cleaning &\nWashing','Shredding &\nGranulating',
                 'Melting &\nExtruding','Pelletizing','Manufacturing\nNew Products'],
                ['#EF4444','#F97316','#F59E0B','#10B981','#3B82F6','#8B5CF6'])
        if tid == 177:
            return make_process_diagram(177, "How a Virus Replicates Inside a Cell",
                ['Virus Attaches\nto Host Cell','Injects Genetic\nMaterial','Uses Cell\nMachinery',
                 'Replicates\nViral DNA','Assembles New\nViruses','Cell Bursts,\nReleases Viruses'],
                ['#EF4444','#F97316','#F59E0B','#10B981','#3B82F6','#8B5CF6'])
        if tid == 178:
            return make_process_diagram(178, "The Process of Making Paper (Industrial)",
                ['Timber\nHarvesting','Wood\nChipping','Pulping\n& Bleaching',
                 'Sheet\nForming','Drying &\nCalendering','Rolling &\nDistribution'],
                ['#10B981','#059669','#6B7280','#3B82F6','#F59E0B','#8B5CF6'])
        if tid == 179:
            return make_process_diagram(179, "How Insurance Works: Claims Process",
                ['Policyholder\nPays Premium','Risk Event\nOccurs','Claim\nSubmitted',
                 'Assessment\nby Insurer','Claim\nApproved','Payout to\nPolicyholder'],
                ['#3B82F6','#EF4444','#F59E0B','#8B5CF6','#10B981','#06B6D4'])
        if tid == 180:
            return make_process_diagram(180, "Coffee: From Bean to Cup",
                ['Planting &\nGrowing','Harvesting\nCherries','Pulping &\nFermentation',
                 'Drying &\nMilling','Roasting','Brewing &\nServing'],
                ['#10B981','#F59E0B','#F97316','#D97706','#92400E','#3B82F6'])

        # ADDITIONAL TABLES (181-200)
        if tid == 181:
            return make_table_image(181, "Global Literacy Rates and Education Data by Region (2022)",
                ['Region','Adult Literacy (%)','Youth Literacy (%)','Avg Years Schooling','Tertiary Enroll (%)'],
                [['North America','99','99','13.4','88'],['Europe','99','99','12.5','80'],
                 ['E.Asia & Pacific','95','99','8.5','55'],['L.America','94','98','9.0','51'],
                 ['World Avg','87','92','8.7','40'],['S.S.Africa','65','80','5.5','9'],
                 ['S.Asia','72','86','6.4','28'],['M.East & N.Africa','80','91','8.0','38']])
        if tid == 182:
            return make_table_image(182, "Comparative Smartphone Specs: Top 5 Flagship Phones (2024)",
                ['Model','Display','Camera','Battery','RAM','Price (USD)'],
                [['Samsung S24 Ultra','6.8" AMOLED','200MP','5000mAh','12GB','$1,299'],
                 ['iPhone 15 Pro Max','6.7" OLED','48MP','4422mAh','8GB','$1,199'],
                 ['Google Pixel 9 Pro','6.3" OLED','50MP','4700mAh','16GB','$999'],
                 ['OnePlus 12','6.82" AMOLED','50MP','5400mAh','16GB','$799'],
                 ['Xiaomi 14 Pro','6.73" AMOLED','50MP','4880mAh','16GB','$749']])
        if tid == 183:
            return make_table_image(183, "Top 10 Global Companies by Market Capitalization (2024)",
                ['Rank','Company','Country','Industry','Market Cap (USD T)'],
                [['1','Apple','USA','Technology','3.1'],['2','NVIDIA','USA','Technology','2.9'],
                 ['3','Microsoft','USA','Technology','2.8'],['4','Alphabet','USA','Technology','1.9'],
                 ['5','Saudi Aramco','Saudi Arabia','Energy','1.8'],['6','Amazon','USA','E-Commerce','1.8'],
                 ['7','Meta','USA','Social Media','1.2'],['8','TSMC','Taiwan','Semiconductors','0.8'],
                 ['9','Berkshire','USA','Finance','0.8'],['10','Eli Lilly','USA','Pharma','0.7']])
        if tid == 184:
            return make_table_image(184, "Olympic Games Medal Count: Top 10 Nations All-Time (Summer)",
                ['Nation','Gold','Silver','Bronze','Total'],
                [['USA','1022','794','704','2520'],['Soviet Union','395','319','296','1010'],
                 ['UK','273','295','291','859'],['Germany','191','194','230','615'],
                 ['China','283','226','193','702'],['France','212','241','262','715'],
                 ['Australia','164','173','207','544'],['Italy','206','178','193','577'],
                 ['Sweden','145','170','179','494'],['Hungary','175','147','169','491']])
        if tid == 185:
            return make_table_image(185, "Key Health Indicators: G7 Countries (WHO, 2022)",
                ['Country','Life Exp.','Infant Mort.','Obesity (%)','Healthcare Spend (% GDP)'],
                [['Canada','82.8','4.0','29','11.5'],['France','83.0','3.3','26','12.2'],
                 ['Germany','81.2','3.0','24','12.7'],['Italy','83.4','2.5','22','9.5'],
                 ['Japan','84.4','1.7','4','11.0'],['UK','81.6','3.5','28','12.0'],
                 ['USA','79.0','5.4','43','18.3'],['G7 Average','82.2','3.2','25','12.5']])

        # MORE STACKED BARS (186-200)
        if tid == 186:
            return make_stacked_bar(186, "Sources of Greenhouse Gas Emissions by Sector (%, World, 2022)",
                ['Energy (73%)','Agriculture (12%)','Industry (6%)','Waste (3%)','Other (6%)'],
                ['CO2','Methane','N2O','F-Gases'],
                [[72,7,5,2,3],[3,8,3,0,1],[1,6,4,0,1],[1,0,0,0,0]],
                ['#EF4444','#3B82F6','#10B981','#F59E0B'])
        if tid == 187:
            return make_stacked_bar(187, "Age Distribution of Online Shoppers by Platform (2023, %)",
                ['Amazon','eBay','Alibaba','Shopee','Lazada'],
                ['18-24','25-34','35-44','45-54','55+'],
                [[15,18,20,12,8],[35,30,28,25,18],[28,26,24,28,22],[14,18,18,22,25],[8,8,10,13,27]],
                ['#8B5CF6','#3B82F6','#10B981','#F59E0B','#6B7280'])
        if tid == 188:
            return make_stacked_bar(188, "Global Film Box Office Revenue by Genre (USD B, 2019–2023)",
                ['2019','2020','2021','2022','2023'],
                ['Action','Drama','Comedy','Animation','Other'],
                [[13.2,2.1,4.5,9.8,12.1],[5.0,0.8,1.7,3.9,4.8],[4.8,0.7,1.5,3.4,4.3],[6.3,1.2,2.3,5.1,6.0],[3.8,0.6,1.2,2.7,3.5]],
                ['#EF4444','#3B82F6','#10B981','#F59E0B','#8B5CF6'])
        if tid == 189:
            return make_stacked_bar(189, "Energy Mix of Major Power Grids (%, 2022)",
                ['USA Grid','EU Grid','China Grid','India Grid','Brazil Grid'],
                ['Coal','Gas','Nuclear','Renewables','Other'],
                [[20,38,19,21,2],[13,21,24,39,3],[56,3,5,31,5],[70,4,3,21,2],[1,10,0,85,4]],
                ['#374151','#3B82F6','#F59E0B','#10B981','#6B7280'])
        if tid == 190:
            return make_stacked_bar(190, "Digital Skills Level by Age Group (% of Population, EU, 2023)",
                ['16-24','25-34','35-44','45-54','55-64','65+'],
                ['Advanced','Intermediate','Basic','No Digital Skills'],
                [[28,22,15,10,6,3],[42,40,35,28,20,12],[20,25,28,32,30,25],[10,13,22,30,44,60]],
                ['#3B82F6','#10B981','#F59E0B','#EF4444'])

        # FINAL MIX: Areas, Scatter, Radar (191-200)
        if tid == 191:
            return make_scatter(191, "Correlation: Average Hours Worked vs. Productivity per Hour (OECD, 2022)",
                [1811,1590,1695,1354,1386,1420,1365,1556,1792,1508],
                [79.9,100.2,91.3,104.5,103.7,98.4,108.0,88.5,82.3,105.3],
                ['Mexico','Germany','USA','Luxembourg','Norway','Denmark','Ireland','UK','Greece','Belgium'],
                xlabel='Avg Hours Worked per Year', ylabel='GDP per Hour Worked (USD)', color='#3B82F6')
        if tid == 192:
            return make_scatter(192, "Obesity Rate vs. Sugar Consumption per Capita (Countries, 2022)",
                [39,28,26,24,22,20,17,15,12,4],
                [126,95,97,85,80,78,68,62,55,30],
                ['USA','UK','Germany','France','Japan*','Brazil','China','India','Vietnam','S.Korea*'],
                xlabel='Obesity Rate (%)', ylabel='Sugar Consumption (kg/capita/year)', color='#EF4444')
        if tid == 193:
            return make_area(193, "Global Cybercrime Losses (USD Billion, 2015–2023)",
                list(range(2015, 2024)),
                ['Total Global Losses'],
                [[3.0,4.5,6.5,8.0,9.5,11.5,16.0,20.0,28.5]],
                xlabel='Year', ylabel='USD Billion', colors=['#EF4444'])
        if tid == 194:
            return make_area(194, "Global Space Industry Revenue (USD Billion, 2010–2023)",
                list(range(2010, 2024)),
                ['Commercial Space','Government Civil','Government Defense'],
                [[185,200,218,230,248,260,278,298,322,360,388,340,385,430],
                 [75,80,82,85,88,90,92,94,96,98,100,102,104,106],
                 [80,85,88,90,92,96,98,100,102,105,108,110,113,116]],
                xlabel='Year', ylabel='USD Billion')
        if tid == 195:
            return make_radar(195, "Sustainable Development Goals Progress by Region (2023, 0–100)",
                ['No Poverty','Zero Hunger','Good Health','Quality Edu.','Clean Water','Clean Energy'],
                [[85,80,88,88,92,82],[72,75,80,80,85,75],[28,35,45,50,42,35],[55,60,65,68,58,60]],
                ['Europe','Americas','Africa','Asia'],
                ['#3B82F6','#10B981','#EF4444','#F59E0B'])
        if tid == 196:
            return make_radar(196, "Food Safety Standards Compliance by Country (2023, 0–10 Scale)",
                ['Hygiene','Labeling','Pesticides','Additives','Traceability','Import Controls'],
                [[9.1,8.8,9.0,9.2,8.9,9.0],[8.5,8.2,8.8,8.5,8.6,8.9],[7.8,7.5,8.0,7.9,7.5,8.2],[6.5,7.0,7.5,6.8,6.5,7.0],[4.5,5.0,5.5,5.2,4.8,5.5]],
                ['EU','USA','Japan','China','Developing'],
                ['#10B981','#3B82F6','#F59E0B','#EF4444','#8B5CF6'])
        if tid == 197:
            return make_horizontal_bar(197, "Top 10 Most Translated Books in History",
                ['Bible','Pinocchio','Little Prince','The Alchemist','Harry Potter (Sorcerer)','Quotations (Mao)',
                 'Pilgrim\'s Progress','Divine Comedy','Don Quixote','Arabian Nights'],
                [3350,260,300,80,85,800,200,150,145,135],
                'Number of Languages Translated', '#8B5CF6')
        if tid == 198:
            return make_horizontal_bar(198, "World's Largest Lakes by Surface Area (km², 2023)",
                ['Caspian Sea','Superior','Victoria','Huron','Michigan','Tanganyika','Baikal','Great Bear','Malawi','Erie'],
                [371000,82103,68800,59600,57800,32600,31500,31153,29500,25667],
                'Surface Area (km²)', '#3B82F6')
        if tid == 199:
            return make_table_image(199, "Comparison of Major Social Media Platforms (2024)",
                ['Platform','Monthly Users (B)','Founded','Primary Use','Age Group','Revenue (USD B)'],
                [['Facebook','3.0','2004','Social Networking','25-44','117'],
                 ['YouTube','2.7','2005','Video','18-34','34'],
                 ['WhatsApp','2.0','2009','Messaging','18-49','N/A'],
                 ['Instagram','2.0','2010','Photos/Video','18-34','N/A'],
                 ['TikTok','1.6','2016','Short Video','16-24','18'],
                 ['WeChat','1.3','2011','Messaging/All','25-44','N/A'],
                 ['Telegram','0.9','2013','Messaging','18-35','N/A'],
                 ['X (Twitter)','0.6','2006','News/Discussion','25-49','3']])
        if tid == 200:
            return make_radar(200, "Global Press Freedom Index by Region (RSF, 2023, 0–100)",
                ['Political Context','Legal Framework','Economic Context','Socio-Cultural','Safety of Journalists','Overall Score'],
                [[82,85,78,86,90,85],[68,70,65,70,75,70],[45,50,48,52,55,50],[30,35,28,32,40,35]],
                ['N.Europe','W.Europe','Americas','Asia'],
                ['#10B981','#3B82F6','#F59E0B','#EF4444'])

        # For 201-300, cycle through more diverse charts
        base = tid - 200
        category = base % 8

        if category == 1:
            # Pie
            labels = random.sample(['Services','Manufacturing','Agriculture','Tech','Finance',
                                    'Healthcare','Education','Real Estate','Energy','Transport'], 5)
            vals = [random.randint(8,35) for _ in labels]
            total = sum(vals)
            vals = [round(v/total*100,1) for v in vals]
            return make_pie(tid, f"Economic Sector Contribution (Country {base}, GDP %, 2022)",
                [f"{l} ({v}%)" for l,v in zip(labels,vals)], vals)

        if category == 2:
            # Horizontal bar
            regions = random.sample(['North America','Europe','East Asia','South Asia','SE Asia',
                                     'Middle East','Sub-Saharan Africa','Latin America','Oceania','Central Asia'], 6)
            vals = [round(random.uniform(20,90),1) for _ in regions]
            topic = random.choice(['Internet Penetration Rate (%)','Smartphone Adoption Rate (%)',
                                   'Higher Education Enrollment Rate (%)','Urban Population Rate (%)'])
            return make_horizontal_bar(tid, f"Regional Comparison: {topic} (2022)", regions, vals, topic, random.choice(COLORS))

        if category == 3:
            # Area
            yrs = list(range(2010, 2024))
            n_series = random.randint(2,4)
            s_labels = random.sample(['North America','Europe','Asia','Africa','Oceania','Middle East'], n_series)
            s_data = [[round(random.uniform(5,20) + i*random.uniform(0.5,2),1) for i in range(len(yrs))] for _ in s_labels]
            topic = random.choice(['Digital Adoption Index','Healthcare Access Score',
                                   'Renewable Energy Capacity (GW)','Food Security Index'])
            return make_area(tid, f"{topic} by Region (2010–2023)", yrs, s_labels, s_data, xlabel='Year', ylabel=topic.split('(')[0])

        if category == 4:
            # Stacked bar
            cats = random.sample(['2018','2019','2020','2021','2022','2023'], 5)
            s_labels = random.sample(['Category A','Category B','Category C','Category D'], 3)
            s_data = [[random.randint(10,40) for _ in cats] for _ in s_labels]
            return make_stacked_bar(tid, f"Trend Analysis: Market Segments Over Time (2018–2023)",
                cats, s_labels, s_data)

        if category == 5:
            # Table
            topics_list = ['Climate Vulnerability Index','Innovation Ranking',
                           'Global Peace Index','Social Progress Index']
            tname = random.choice(topics_list)
            countries = random.sample(['USA','China','Germany','Japan','India','Brazil','UK','France','Canada','Australia'], 6)
            headers = ['Country', 'Score', 'Rank', 'Change YoY']
            rows = [[c, str(round(random.uniform(40,95),1)), str(random.randint(1,50)), f'+{random.randint(0,5)}'] for c in countries]
            return make_table_image(tid, f"{tname}: Top Countries (2023)", headers, rows)

        if category == 6:
            # Process diagram
            processes = [
                ("How Food is Digested in the Human Body", ['Mouth\n& Saliva','Esophagus\n& Swallowing','Stomach\nBreaking Down','Small\nIntestine','Large\nIntestine','Waste\nElimination']),
                ("The Electoral Process in a Democracy", ['Voter\nRegistration','Nomination of\nCandidates','Campaign\n& Debate','Election\nDay Voting','Vote\nCounting','Results\n& Inauguration']),
                ("How Nuclear Power Generates Electricity", ['Uranium\nFuel Loaded','Fission\nReaction','Heat\nProduced','Steam\nGenerates','Turbine\nSpins','Electricity\nDistributed']),
                ("Stages in Building a Skyscraper", ['Site Survey\n& Design','Foundation\nExcavation','Steel Frame\nConstruction','Floor\nSlabs Poured','Facade &\nInteriors','Final\nInspection']),
            ]
            proc = random.choice(processes)
            n = min(6, len(proc[1]))
            return make_process_diagram(tid, proc[0], proc[1][:n], COLORS[:n])

        if category == 7:
            # Radar
            categories_r = random.sample(['Innovation','Infrastructure','Health','Education',
                                          'Environment','Economy','Social Cohesion','Digital'], 5)
            n_groups = 3
            group_labels = random.sample(['Group A','Group B','Group C','Group D','Group E'], n_groups)
            vals_list = [[random.randint(45,95) for _ in categories_r] for _ in group_labels]
            return make_radar(tid, f"Multi-Dimensional Performance Index (2023)", categories_r, vals_list, group_labels)

        # Default: donut (category == 0)
        sector_topics = [
            ("Global Tourism Revenue Share by Type (2022)", ['Leisure (58%)','Business (28%)','VFR (14%)'], [58,28,14]),
            ("World Gold Production by Country (2022, %)", ['China (12%)','Russia (10%)','Australia (9%)','Canada (7%)','USA (6%)','Others (56%)'], [12,10,9,7,6,56]),
            ("Global Book Sales by Format (2023, %)", ['Print (65%)','E-Book (20%)','Audio (15%)'], [65,20,15]),
        ]
        st = sector_topics[base % len(sector_topics)]
        return make_donut_qc(tid, st[0], st[1], st[2])

    return t


# ─── MAIN ────────────────────────────────────────────────────────────────────

if __name__ == "__main__":
    import threading

    start_from = int(sys.argv[1]) if len(sys.argv) > 1 else 101
    end_at = int(sys.argv[2]) if len(sys.argv) > 2 else 300
    workers = int(sys.argv[3]) if len(sys.argv) > 3 else 6

    os.makedirs(OUTPUT_DIR, exist_ok=True)

    topic_ids = [i for i in range(start_from, end_at + 1)]
    print(f"Generating {len(topic_ids)} diverse images (topics {start_from}–{end_at}) with {workers} threads...")

    generator = gen_all(start_from, end_at)
    success = 0
    failed = []
    lock = threading.Lock()

    def process(tid):
        global success
        try:
            ok = generator(tid)
            with lock:
                if ok:
                    success += 1
                else:
                    failed.append(tid)
        except Exception as e:
            print(f"  [{tid}] ✗ Exception: {e}")
            with lock:
                failed.append(tid)

    with ThreadPoolExecutor(max_workers=workers) as executor:
        executor.map(process, topic_ids)

    print(f"\n✓ Done! {success}/{len(topic_ids)} generated.")
    if failed:
        print(f"✗ Failed: {failed}")
