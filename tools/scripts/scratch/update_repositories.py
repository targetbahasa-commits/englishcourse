import os
import re

files_to_update = [
    'app/Infrastructure/Admin/EloquentAdminReportRepository.php',
    'app/Infrastructure/Admin/EloquentAdminStudentRepository.php',
    'app/Infrastructure/Dashboard/EloquentDashboardRepository.php',
    'app/Infrastructure/Progress/EloquentProgressRepository.php',
    'app/Infrastructure/GrammarWriting/EloquentGrammarWritingRepository.php',
]

for file_path in files_to_update:
    if not os.path.exists(file_path):
        continue
        
    with open(file_path, 'r') as f:
        content = f.read()
        
    # Replace MeetingScore::where('user_id', $userId) with MeetingScore::where('is_reported', true)->where('user_id', $userId)
    content = re.sub(r"MeetingScore::where\('user_id',", r"MeetingScore::where('is_reported', true)->where('user_id',", content)
    
    # Replace MeetingScore::query() with MeetingScore::where('is_reported', true)
    content = re.sub(r"MeetingScore::query\(\)", r"MeetingScore::where('is_reported', true)", content)
    
    with open(file_path, 'w') as f:
        f.write(content)

print("Updated repositories.")
