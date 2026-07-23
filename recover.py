import json
import re

with open('/Users/macpro2021/.gemini/antigravity/brain/3fce8a38-abb8-4e82-af04-7587c3192fdb/.system_generated/logs/transcript_full.jsonl', 'r') as f:
    for line in f:
        data = json.loads(line)
        if 'content' in data:
            content = data['content']
            if '<!-- SPEAKING -->' in content:
                print("Found in content!")
                with open('/tmp/recovered_speaking.txt', 'w') as out:
                    out.write(content)
        if 'tool_calls' in data:
            for call in data['tool_calls']:
                if 'args' in call and 'Output' in call['args']:
                    out = call['args']['Output']
                    if '<!-- SPEAKING -->' in out:
                        print("Found in tool output!")
                        with open('/tmp/recovered_speaking.txt', 'w') as out_f:
                            out_f.write(out)
                if 'args' in call and 'output' in call['args']:
                    out = call['args']['output']
                    if '<!-- SPEAKING -->' in out:
                        print("Found in tool output2!")
                        with open('/tmp/recovered_speaking.txt', 'w') as out_f:
                            out_f.write(out)
