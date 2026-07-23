import os

filepath = '/Applications/MAMP/htdocs/TargetBahasaCourse/resources/views/assignments/ielts/writing/practice_toolbar.blade.php'

with open(filepath, 'r') as f:
    content = f.read()

# Find the Irregular Verbs block
start_irregular = content.find('<!-- 2. IRREGULAR VERBS -->')

# Find the Dictionary block
start_dictionary = content.find('<!-- 6. DICTIONARY (Full Logic) -->')

if start_irregular != -1 and start_dictionary != -1:
    # We want to move the dictionary block to right before the irregular verb block.
    # The dictionary block goes from start_dictionary to the end of the file or next section?
    # Let's see what is after Dictionary block.
    # It seems dictionaryDataToolbar script goes until the end of the script tag.
    end_script = content.find('</script>', start_dictionary) + len('</script>')
    
    dictionary_block = content[start_dictionary:end_script].strip()
    
    # Remove dictionary block from its original position
    # also remove any trailing newlines if possible
    content = content[:start_dictionary] + content[end_script:]
    
    # Insert dictionary block before irregular verbs block
    content = content[:start_irregular] + dictionary_block + "\n\n    " + content[start_irregular:]
    
    # Remove any emoticon if present in the dictionary block (just in case)
    # The user said "hilangkan emoticonnya".
    content = content.replace('<span>📖</span> Dictionary', 'Dictionary')
    content = content.replace('<span>📖</span>', '')
    content = content.replace('📖', '')

    with open(filepath, 'w') as f:
        f.write(content)
    print("Successfully moved Dictionary block above Irregular Verbs and removed emoticons.")
else:
    print("Could not find the blocks.")
