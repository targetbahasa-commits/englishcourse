import re

file_path = "app/Http/Controllers/AdminPromoTestController.php"
with open(file_path, "r") as f:
    content = f.read()

# Replace the redirect in previewSpeaking
new_redirect = "return redirect()->route('assignments.ielts.speaking.evaluation_preview', ['part' => 1, 'id' => $test_id]);"

# Let's just find the previewSpeaking method block and replace the redirect inside it.
import textwrap

old_text = "return redirect()->route('promo.test.result', ['type' => $submission->test_type, 'id' => $test_id, 'submission_id' => $submission->id]);"

# But wait! I replaced 'promo.test.result' with 'promo.test.result' in the previous step?
# Oh! In the first step, I changed the URL in web.php. But did I change the name of the route?
# No. The name is still 'promo.test.result'.
# So the redirect in AdminPromoTestController still works and redirects to the promo page!
# Now I want to change it to redirect to the newly created Assignments Speaking Preview page!

content = content.replace(old_text, new_redirect, 1)

with open(file_path, "w") as f:
    f.write(content)

print("Updated previewSpeaking in AdminPromoTestController")
