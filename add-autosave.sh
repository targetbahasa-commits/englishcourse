#!/bin/bash

# Script to add auto-save functionality to all meeting blade files
# This script adds the auto-save.js script and initialization code before </body> tag

VIEWS_DIR="/Applications/MAMP/htdocs/TargetBahasaCourse/resources/views/assignments/grammar-writing"

# Array of meeting numbers to process
MEETINGS=(2 3 4 5 6 7 8 9 10 11 12 13 14 15 16 17 19 20)

for meeting in "${MEETINGS[@]}"; do
    FILE="$VIEWS_DIR/meeting${meeting}.blade.php"
    
    if [ ! -f "$FILE" ]; then
        echo "Skipping meeting${meeting} - file not found"
        continue
    fi
    
    # Check if auto-save is already added
    if grep -q "auto-save.js" "$FILE"; then
        echo "Auto-save already added to meeting${meeting}"
        continue
    fi
    
    echo "Adding auto-save to meeting${meeting}..."
    
    # Create temp file with auto-save code
    TEMP_FILE=$(mktemp)
    
    # Read the file and add auto-save before </body>
    awk -v meeting="$meeting" '
    /<\/body>/ {
        print "    "
        print "    <!-- Auto-Save Script -->"
        print "    <script src=\"{{ asset('"'"'js/auto-save.js'"'"') }}\"></script>"
        print "    <script>"
        print "        document.addEventListener('"'"'DOMContentLoaded'"'"', function() {"
        print "            AutoSave.init('"'"'meeting" meeting "'"'"');"
        print "        });"
        print "    </script>"
        print "    "
    }
    { print }
    ' "$FILE" > "$TEMP_FILE"
    
    # Replace original file with temp file
    mv "$TEMP_FILE" "$FILE"
    
    echo "✓ Auto-save added to meeting${meeting}"
done

echo ""
echo "Auto-save integration complete!"
echo "Total meetings processed: ${#MEETINGS[@]}"
