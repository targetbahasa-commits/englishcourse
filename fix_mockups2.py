import re
import glob

files = glob.glob('resources/views/assignments/ielts/mockup/*.blade.php')
for f in files:
    with open(f, 'r') as file:
        content = file.read()
        
    parts = content.split("@include('assignments.ielts.listening.partials.audio-player'")
    if len(parts) > 1:
        subparts = parts[1].split("<script>", 1)
        if len(subparts) == 2:
            include_end = subparts[0].find(")") + 1
            if include_end > 0:
                include_args = subparts[0][:include_end]
                parts[1] = include_args + "\n\n<script>" + subparts[1]
                content = parts[0] + "@include('assignments.ielts.listening.partials.audio-player'" + parts[1]

    content = re.sub(r'x-data="\{\s*step:\s*1\s*\}"(?!\s*x-init)', 'x-data="{ step: 1 }" x-init="$watch(\'step\', value => $dispatch(\'part-changed\', value))"', content)
    content = re.sub(r'(?s)\s*const audio = document\.getElementById\(\'mainAudio\'\);.*?window\.toggleTranscriptDrawer = function\(\)[^}]*\};[\n\r]*', '', content)

    with open(f, 'w') as file:
        file.write(content)

print("fixed all mockups")
