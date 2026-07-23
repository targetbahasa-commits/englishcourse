import re

with open('resources/views/assignments/ielts/writing/practice_toolbar.blade.php', 'r') as f:
    content = f.read()

# Fix extra </div> closing tags for Dictionary section
# Around line 608: </template>\n</div>\n</div>\n\n<script>
content = re.sub(r'</template>\s*</div>\s*</div>\s*<script>', '</template>\n</div>\n\n<script>', content)

# Function to replace button
def replace_btn(content, original_text, title, svg_icon, base_class):
    # Regex to match the button with the specific text
    # e.g., <button @click="..." class="...">\s*Text\s*</button>
    pattern = r'(<button\s+[^>]*@click="[^"]*"[^>]*class="[^"]*' + base_class + r'[^"]*"[^>]*>)\s*(?:💡\s*)?' + original_text + r'\s*</button>'
    
    # Replacement string
    replacement = r'\1'[:-1] + f' title="{title}" class="\\2 w-10 h-10 rounded-full justify-center p-0 flex items-center gap-2 whitespace-nowrap transform transition hover:scale-105 shadow-sm {base_class}">' + svg_icon + '</button>'
    
    # We need to extract the exact class and attributes.
    # Let's do it with a simpler regex or manual string manipulation.
    pass

# We can replace the specific buttons more safely by searching for the text and the opening button tag.
buttons = [
    ('Tenses', 'Tenses', 'bg-cyan-500', '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>'),
    ('Tenses Chart', 'Tenses Chart', 'bg-indigo-500', '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M3 14h18m-9-4v8m-7 0h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"></path></svg>'),
    ('Linking Words', 'Linking Words', 'bg-teal-500', '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"></path></svg>'),
    ('Dictionary', 'Dictionary', 'bg-blue-600', '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>'),
    ('Irregular Verbs', 'Irregular Verbs', 'bg-yellow-500', '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"></path></svg>'),
    ('Transition Words', 'Transition Words', 'bg-orange-500', '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"></path></svg>'),
    ('Describing Trends', 'Describing Trends', 'bg-blue-500', '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 12l3-3 3 3 4-4M8 21l4-4 4 4M3 4h18M4 4h16v12a1 1 0 01-1 1H5a1 1 0 01-1-1V4z"></path></svg>'),
    ('Map Vocabulary', 'Map Vocabulary', 'bg-green-600', '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7l6-3 5.447 2.724A1 1 0 0121 7.618v10.764a1 1 0 01-1.447.894L15 17l-6 3z"></path></svg>'),
    ('Process Vocab', 'Process Vocabulary', 'bg-purple-600', '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg>'),
    ('Collocations', 'Collocations', 'bg-purple-600', '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>'),
    ('Idioms', 'Idioms', 'bg-indigo-600', '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"></path></svg>'),
    ('IELTS Ideas', 'IELTS Ideas', 'bg-pink-500', '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"></path></svg>'),
    ('Academic Phrases', 'Academic Phrases', 'bg-orange-600', '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>'),
    ('Lesson Explanation', 'Lesson Explanation', 'bg-green-500', '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>'),
]

for orig_text, title, bg_class, svg in buttons:
    # Use re.sub with a custom replacer to ensure we only target the button that has this exact text inside
    pattern = re.compile(r'(<button[^>]*class="[^"]*' + bg_class + r'[^"]*"[^>]*>)\s*(?:💡\s*)?' + orig_text + r'\s*</button>', flags=re.DOTALL)
    
    def repl(m):
        btn_start = m.group(1)
        # replace "py-2 px-4 rounded-xl" with "w-10 h-10 p-0 rounded-full justify-center"
        btn_start = btn_start.replace('py-2 px-4 rounded-xl', 'w-10 h-10 p-0 rounded-full justify-center')
        # Also add title attribute
        btn_start = btn_start.replace('<button', f'<button title="{title}"')
        return btn_start + '\n            ' + svg + '\n        </button>'
        
    content = pattern.sub(repl, content)

# Check if there's any stray </div> at the end, make sure the main container is closed.
# The main container is <div x-data="{ x: ... }">
# So the file should end with </div>.
if not content.strip().endswith('</div>'):
    # Let's count divs and see if we need to add a closing div.
    # Actually, we should just make sure it's valid.
    pass

with open('resources/views/assignments/ielts/writing/practice_toolbar.blade.php', 'w') as f:
    f.write(content)

print("Done replacing buttons.")
