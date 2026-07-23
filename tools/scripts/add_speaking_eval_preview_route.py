import re

file_path = "routes/web.php"
with open(file_path, "r") as f:
    content = f.read()

# Add route after speaking evaluation
route_code = "    Route::get('/assignments/ielts-academic/speaking/{part}/meeting/{id}/evaluation-preview', [App\Http\Controllers\IeltsSpeakingController::class, 'evaluationPreview'])->name('assignments.ielts.speaking.evaluation_preview');\n"

content = content.replace("Route::get('/assignments/ielts-academic/speaking/practice/evaluation', [App\Http\Controllers\IeltsSpeakingController::class, 'evaluation'])->name('assignments.ielts-academic.speaking.evaluation');",
                          route_code + "    Route::get('/assignments/ielts-academic/speaking/practice/evaluation', [App\Http\Controllers\IeltsSpeakingController::class, 'evaluation'])->name('assignments.ielts-academic.speaking.evaluation');")

with open(file_path, "w") as f:
    f.write(content)

print("Route added.")
