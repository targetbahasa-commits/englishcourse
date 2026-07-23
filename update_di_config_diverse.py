import sys
import generate_diverse_di as gd

# Mock the drawing functions to just return the title
titles = {}

def mock_make_pie(topic_id, title, *args, **kwargs): titles[topic_id] = title; return True
def mock_make_horizontal_bar(topic_id, title, *args, **kwargs): titles[topic_id] = title; return True
def mock_make_stacked_bar(topic_id, title, *args, **kwargs): titles[topic_id] = title; return True
def mock_make_area(topic_id, title, *args, **kwargs): titles[topic_id] = title; return True
def mock_make_scatter(topic_id, title, *args, **kwargs): titles[topic_id] = title; return True
def mock_make_bubble(topic_id, title, *args, **kwargs): titles[topic_id] = title; return True
def mock_make_table_image(topic_id, title, *args, **kwargs): titles[topic_id] = title; return True
def mock_make_process_diagram(topic_id, title, *args, **kwargs): titles[topic_id] = title; return True
def mock_make_radar(topic_id, title, *args, **kwargs): titles[topic_id] = title; return True
def mock_make_choropleth_map(topic_id, title, *args, **kwargs): titles[topic_id] = title; return True
def mock_make_donut_qc(topic_id, title, *args, **kwargs): titles[topic_id] = title; return True

gd.make_pie = mock_make_pie
gd.make_horizontal_bar = mock_make_horizontal_bar
gd.make_stacked_bar = mock_make_stacked_bar
gd.make_area = mock_make_area
gd.make_scatter = mock_make_scatter
gd.make_bubble = mock_make_bubble
gd.make_table_image = mock_make_table_image
gd.make_process_diagram = mock_make_process_diagram
gd.make_radar = mock_make_radar
gd.make_choropleth_map = mock_make_choropleth_map
gd.make_donut_qc = mock_make_donut_qc

# Get all titles
generator = gd.gen_all(101, 300)
for i in range(101, 301):
    generator(i)

# Now read the existing config to keep 1-100 intact
config_path = '/Applications/MAMP/htdocs/TargetBahasaCourse/config/pte_describe_image.php'
with open(config_path, 'r') as f:
    content = f.read()

# Generate new PHP array portion for 101-300
php_entries = []
for i in range(101, 301):
    title = titles.get(i, f"Topic {i}")
    # Escape single quotes in PHP
    title_escaped = title.replace("'", "\\'")
    php_entries.append(f"    {i}   => ['title' => '{title_escaped}'],")

php_str = "\n".join(php_entries)

# We need to replace everything from "    101 => ['title'" downwards until the end of the array.
# The easiest way is to use regex or just basic string splitting.
import re
new_content = re.sub(r'    101\s*=>\s*\[\'title\'.*?\n\];', php_str + "\n];", content, flags=re.DOTALL)

with open(config_path, 'w') as f:
    f.write(new_content)

print(f"Updated config/pte_describe_image.php with {len(titles)} new diverse titles!")
