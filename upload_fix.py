import subprocess
import sys

def run_cmd(cmd):
    result = subprocess.run(cmd, shell=True, capture_output=True, text=True)
    if result.returncode != 0:
        print(f"Error running {cmd}: {result.stderr}")
        sys.exit(1)
    return result.stdout

run_cmd("python3 tools/scripts/upload_ftp.py app/Application/GrammarWriting/Concerns/LoadsLegacyGrammarWritingQuestions.php")
print("Uploaded successfully!")
