import sys

file_path = "/Applications/MAMP/htdocs/TargetBahasaCourse/resources/views/assignments/ielts/mockup/c20-listening-test-2.blade.php"

with open(file_path, "r") as f:
    content = f.read()

target = '<input type="text" maxlength="1" class="border border-gray-300 outline-none px-2 py-2 w-12 bg-white focus:border-blue-500 transition-colors placeholder-gray-400 text-center font-bold uppercase shadow-sm rounded">'

dropdown1 = '''<select class="border border-gray-300 outline-none px-2 py-2 w-16 bg-white focus:border-blue-500 transition-colors font-bold uppercase shadow-sm rounded cursor-pointer appearance-none text-center text-lg">
                        <option value=""></option>
                        <option value="A">A</option>
                        <option value="B">B</option>
                        <option value="C">C</option>
                        <option value="D">D</option>
                        <option value="E">E</option>
                        <option value="F">F</option>
                        <option value="G">G</option>
                        <option value="H">H</option>
                        <option value="I">I</option>
                    </select>'''

dropdown2 = '''<select class="border border-gray-300 outline-none px-2 py-2 w-16 bg-white focus:border-blue-500 transition-colors font-bold uppercase shadow-sm rounded cursor-pointer appearance-none text-center text-lg">
                        <option value=""></option>
                        <option value="A">A</option>
                        <option value="B">B</option>
                        <option value="C">C</option>
                        <option value="D">D</option>
                        <option value="E">E</option>
                        <option value="F">F</option>
                        <option value="G">G</option>
                    </select>'''

parts = content.split(target)

if len(parts) == 12: # 11 occurrences = 12 parts
    new_content = ""
    for i in range(11):
        new_content += parts[i]
        if i < 6:
            new_content += dropdown1
        else:
            new_content += dropdown2
    new_content += parts[11]

    with open(file_path, "w") as f:
        f.write(new_content)
    print("Replaced all 11 inputs successfully.")
else:
    print(f"Error: expected 11 instances, found {len(parts)-1}")
