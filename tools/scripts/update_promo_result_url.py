import re

# Update routes/web.php
file_path = "routes/web.php"
with open(file_path, "r") as f:
    content = f.read()

content = content.replace("Route::get('/{type}/{id}/result/{submission_id}',", "Route::get('/{type}/{id}/ielts-academic-evaluation/{submission_id}',")
content = content.replace("Route::post('/{type}/{id}/result/{submission_id}/send-wa',", "Route::post('/{type}/{id}/ielts-academic-evaluation/{submission_id}/send-wa',")

with open(file_path, "w") as f:
    f.write(content)

# Update resources/views/promo/show.blade.php
file_path = "resources/views/promo/show.blade.php"
with open(file_path, "r") as f:
    content = f.read()

content = content.replace("let redirectUrl = `/promo/test/${this.type}/${this.id}/result/${data.submission_id}`;", "let redirectUrl = `/promo/test/${this.type}/${this.id}/ielts-academic-evaluation/${data.submission_id}`;")

with open(file_path, "w") as f:
    f.write(content)

print("Promo result URL updated.")
