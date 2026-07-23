import re

file_path = "routes/web.php"
with open(file_path, "r") as f:
    content = f.read()

# Add route after practice_index
route_code = "    Route::get('/assignments/ielts-academic/writing/{task}/meeting/{id}/evaluation-preview', [App\Http\Controllers\IeltsWritingController::class, 'evaluationPreview'])->name('assignments.ielts.writing.evaluation_preview');\n"
if "assignments.ielts.writing.evaluation_preview" not in content:
    content = content.replace("Route::get('/assignments/ielts-academic/writing/practice-index/grammar-practice'", route_code + "    Route::get('/assignments/ielts-academic/writing/practice-index/grammar-practice'")

with open(file_path, "w") as f:
    f.write(content)

print("Route added.")
