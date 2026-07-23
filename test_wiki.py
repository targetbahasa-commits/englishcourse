import urllib.request
import json
import re
import random

def get_random_sentences(n=5):
    sentences = []
    # Wikipedia API for random articles
    url = f"https://en.wikipedia.org/w/api.php?action=query&format=json&list=random&rnnamespace=0&rnlimit={n*2}"
    req = urllib.request.Request(url, headers={'User-Agent': 'Mozilla/5.0'})
    response = urllib.request.urlopen(req).read().decode('utf-8')
    data = json.loads(response)
    
    for item in data['query']['random']:
        title = urllib.parse.quote(item['title'])
        # Get extract
        ext_url = f"https://en.wikipedia.org/w/api.php?action=query&format=json&prop=extracts&exsentences=3&exlimit=1&titles={title}&explaintext=1"
        try:
            ext_req = urllib.request.Request(ext_url, headers={'User-Agent': 'Mozilla/5.0'})
            ext_res = urllib.request.urlopen(ext_req).read().decode('utf-8')
            ext_data = json.loads(ext_res)
            pages = ext_data['query']['pages']
            page = list(pages.values())[0]
            if 'extract' in page:
                text = page['extract']
                # split into sentences
                sents = re.split(r'(?<=[.!?])\s+', text)
                for s in sents:
                    words = s.split()
                    if 15 <= len(words) <= 40:
                        sentences.append(s)
                        break
        except Exception as e:
            pass
            
        if len(sentences) >= n:
            break
            
    return sentences

print(get_random_sentences(5))
