import requests

articles = ["Evolution", "Photosynthesis", "Industrial_Revolution", "Climate_change", "Artificial_intelligence", "World_War_II", "Dinosaur", "Solar_System", "Internet", "Quantum_mechanics", "Biology", "Chemistry", "Physics", "Mathematics", "History", "Geography", "Psychology", "Sociology", "Economics", "Philosophy", "Literature", "Art", "Music", "Religion", "Mythology", "Language", "Education", "Medicine", "Agriculture", "Technology", "Engineering", "Architecture"]
text = ""
for title in articles:
    url = f"https://en.wikipedia.org/w/api.php?action=query&prop=extracts&explaintext&titles={title}&format=json"
    print(f"Fetching {title}...")
    try:
        headers = {'User-Agent': 'TargetBahasa PTE Content Generator (contact@targetbahasa.com)'}
        data = requests.get(url, headers=headers, timeout=10).json()
        pages = data['query']['pages']
        for page_id in pages:
            text += pages[page_id].get('extract', '') + "\n\n"
    except Exception as e:
        print(f"Failed to fetch {title}: {e}")

with open("pg2009.txt", "w", encoding="utf-8") as f:
    f.write(text)

print("Saved to pg2009.txt")
