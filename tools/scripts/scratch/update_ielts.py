import re

with open('resources/views/ielts/writing/index.blade.php', 'r') as f:
    content = f.read()

def replace_card(content, route_name, var_name, title_text):
    # Regex to find the anchor tag start and its attributes
    pattern = r'(<a href="\{\{\s*route\(\'' + route_name + r'\'\)\s*\}\}"[^>]*class="[^"]*)hover:shadow-2xl([^"]*)hover:scale-105\s*hover:-translate-y-1([^"]*">)'
    
    def replacer(match):
        prefix = match.group(1)
        mid = match.group(2)
        suffix = match.group(3)
        
        # Replace href
        prefix = prefix.replace(
            "{{ route('" + route_name + "') }}", 
            "{{ $" + var_name + " ? route('" + route_name + "') : 'javascript:void(0)' }}"
        )
        
        # We need to conditionally add the hover classes
        new_class = prefix + "{{ $" + var_name + " ? 'hover:shadow-2xl hover:scale-105 hover:-translate-y-1' : 'opacity-90' }}" + mid + suffix
        
        lock_html = f"""
                    @if(!${var_name})
                    <div class="absolute inset-0 bg-gray-50/60 backdrop-blur-[1.5px] z-20 flex flex-col items-center justify-center">
                        <div class="bg-white p-3 rounded-full shadow-md mb-2 text-gray-500">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                        </div>
                        <span class="font-bold text-gray-700 text-sm px-4 text-center">Registrasi IELTS {title_text}</span>
                    </div>
                    @endif"""
        return new_class + lock_html

    content = re.sub(pattern, replacer, content, count=1)
    return content

content = replace_card(content, 'assignments.ielts-academic.listening.index', 'hasListening', 'Listening')
content = replace_card(content, 'assignments.ielts-academic.reading.index', 'hasReading', 'Reading')
content = replace_card(content, 'assignments.ielts-academic.writing.index', 'hasWriting', 'Writing')
content = replace_card(content, 'assignments.ielts-academic.speaking.index', 'hasSpeaking', 'Speaking')

content = replace_card(content, 'assignments.ielts-academic.listening.practice.index', 'hasListening', 'Listening')
content = replace_card(content, 'assignments.ielts-academic.reading.practice-index', 'hasReading', 'Reading')
content = replace_card(content, 'assignments.ielts-academic.writing.practice.index', 'hasWriting', 'Writing')
content = replace_card(content, 'assignments.ielts-academic.speaking.practice.index', 'hasSpeaking', 'Speaking')

with open('resources/views/ielts/writing/index.blade.php', 'w') as f:
    f.write(content)

print("Done replacing.")
