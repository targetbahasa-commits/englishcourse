#!/usr/bin/env python3
"""
Deploy script: Upload all changed files to targetbahasa.com production server
Run from: /Applications/MAMP/htdocs/TargetBahasaCourse/
"""

import ftplib
import os
import sys

FTP_HOST = '153.92.9.128'
FTP_USER = 'u822472458'
FTP_PASS = '@Dreamer19'
REMOTE_BASE = '/domains/targetbahasa.com/public_html'
LOCAL_BASE = '/Applications/MAMP/htdocs/TargetBahasaCourse'

# Files to upload (relative paths from project root)
# Excludes audio files, vendor, node_modules, dev-only files
FILES_TO_UPLOAD = [
    # Controllers
    'app/Http/Controllers/AdminController.php',
    'app/Http/Controllers/AssignmentController.php',
    'app/Http/Controllers/Auth/RegisteredUserController.php',
    'app/Http/Controllers/Controller.php',
    'app/Http/Controllers/PublicRegistrationLeadController.php',
    'app/Http/Controllers/Admin/ToeflMockupResultController.php',
    'app/Http/Controllers/Admin/WHVApplicationController.php',

    # Models
    'app/Models/IeltsSpeakingTopic.php',
    'app/Models/IeltsWritingMeeting.php',
    'app/Models/ToeflStructureQuestion.php',
    'app/Models/ToeflMockupResult.php',

    # Services
    'app/Services/ToeflReadingPracticeData.php',

    # Migrations
    'database/migrations/2026_03_19_124505_add_is_locked_to_ielts_writing_and_speaking.php',
    'database/migrations/2026_04_06_090500_add_explanation_to_toefl_structure_questions_table.php',
    'database/migrations/2026_04_12_091442_create_toefl_mockup_results_table.php',

    # Storage data
    'storage/app/a1_vocabulary.json',
    'storage/app/a2_vocabulary.json',
    'storage/app/b1_vocabulary.json',
    'storage/app/b2_vocabulary.json',
    'storage/app/c1_vocabulary.json',

    # Seeders
    'database/seeders/IeltsLockSeeder.php',
    'database/seeders/PopulateToeflListeningMeeting2Seeder.php',
    'database/seeders/ToeflListeningMeeting1Seeder.php',
    'database/seeders/ToeflListeningMeeting2Set1Seeder.php',
    'database/seeders/ToeflListeningPackage1Seeder.php',
    'database/seeders/ToeflStructureMeeting62Seeder.php',
    'database/seeders/ToeflStructureMeeting67Seeder.php',

    # Routes
    'routes/web.php',
        'routes/web_test.php',

    # Views - Admin
    'resources/views/admin/dashboard.blade.php',
    'resources/views/admin/partials/campaign-pulse-header.blade.php',
    'resources/views/admin/partials/export-activity-panel.blade.php',
    'resources/views/admin/partials/lead-campaign-conversion-panel.blade.php',
    'resources/views/admin/programs/index.blade.php',
    'resources/views/admin/whv-applications/index.blade.php',
    'resources/views/admin/toefl-mockup-results/index.blade.php',

    # Views - IELTS Academic
    'resources/views/assignments/ielts-academic/mockup/cambridge/20/test-3/reading.blade.php',

    # Views - IELTS
    'resources/views/assignments/ielts/listening/index.blade.php',
    'resources/views/assignments/ielts/mockup/c19-listening-test-1.blade.php',
    'resources/views/assignments/ielts/mockup/c19-listening-test-2.blade.php',
    'resources/views/assignments/ielts/mockup/c19-listening-test-3.blade.php',
    'resources/views/assignments/ielts/mockup/c19-listening-test-4.blade.php',
    'resources/views/assignments/ielts/mockup/c19-reading-test-1.blade.php',
    'resources/views/assignments/ielts/mockup/c19-reading-test-2.blade.php',
    'resources/views/assignments/ielts/mockup/c19-reading-test-3.blade.php',
    'resources/views/assignments/ielts/mockup/c19-reading-test-4.blade.php',
    'resources/views/assignments/ielts/mockup/c19-speaking-test-1.blade.php',
    'resources/views/assignments/ielts/mockup/c19-speaking-test-2.blade.php',
    'resources/views/assignments/ielts/mockup/c19-speaking-test-3.blade.php',
    'resources/views/assignments/ielts/mockup/c19-speaking-test-4.blade.php',
    'resources/views/assignments/ielts/mockup/c19-writing-test-1.blade.php',
    'resources/views/assignments/ielts/mockup/c19-writing-test-2.blade.php',
    'resources/views/assignments/ielts/mockup/c19-writing-test-3.blade.php',
    'resources/views/assignments/ielts/mockup/c19-writing-test-4.blade.php',
    'resources/views/assignments/ielts/mockup/c20-listening-test-1.blade.php',
    'resources/views/assignments/ielts/mockup/c20-listening-test-2.blade.php',
    'resources/views/assignments/ielts/mockup/c20-listening-test-3.blade.php',
    'resources/views/assignments/ielts/mockup/c20-listening-test-4.blade.php',
    'resources/views/assignments/ielts/mockup/c20-reading-test-1.blade.php',
    'resources/views/assignments/ielts/mockup/c20-reading-test-2.blade.php',
    'resources/views/assignments/ielts/mockup/c20-reading-test-3.blade.php',
    'resources/views/assignments/ielts/mockup/c20-reading-test-4.blade.php',
    'resources/views/assignments/ielts/mockup/c20-speaking-test-1.blade.php',
    'resources/views/assignments/ielts/mockup/c20-speaking-test-2.blade.php',
    'resources/views/assignments/ielts/mockup/c20-speaking-test-3.blade.php',
    'resources/views/assignments/ielts/mockup/c20-speaking-test-4.blade.php',
    'resources/views/assignments/ielts/mockup/c20-writing-test-1.blade.php',
    'resources/views/assignments/ielts/mockup/c20-writing-test-2.blade.php',
    'resources/views/assignments/ielts/mockup/c20-writing-test-3.blade.php',
    'resources/views/assignments/ielts/mockup/c20-writing-test-4.blade.php',
    'resources/views/assignments/ielts/mockup/cambridge-edition.blade.php',
    'resources/views/assignments/ielts/mockup/cambridge-skills.blade.php',
    'resources/views/assignments/ielts/mockup/cambridge.blade.php',
    'resources/views/assignments/ielts/reading/index.blade.php',
    'resources/views/assignments/ielts/reading/material.blade.php',
    'resources/views/assignments/ielts/speaking/index.blade.php',
    'resources/views/assignments/ielts/writing/partials/meeting_card.blade.php',
    'resources/views/assignments/ielts/writing/practice_view.blade.php',

    # Views - Assignments
    'resources/views/assignments/index.blade.php',
    'resources/views/assignments/toefl-itp.blade.php',

    # Views - TOEFL Listening
    'resources/views/assignments/toefl-itp/listening/index.blade.php',
    'resources/views/assignments/toefl-itp/listening/meeting.blade.php',
    'resources/views/assignments/toefl-itp/listening/meeting2.blade.php',
    'resources/views/assignments/toefl-itp/listening/meeting3.blade.php',
    'resources/views/assignments/toefl-itp/listening/meeting4.blade.php',
    'resources/views/assignments/toefl-itp/listening/meeting5.blade.php',
    'resources/views/assignments/toefl-itp/listening/meeting6.blade.php',
    'resources/views/assignments/toefl-itp/listening/meeting7.blade.php',
    'resources/views/assignments/toefl-itp/listening/meeting8.blade.php',
    'resources/views/assignments/toefl-itp/listening/meeting9.blade.php',
    'resources/views/assignments/toefl-itp/listening/meeting10.blade.php',
    'resources/views/assignments/toefl-itp/listening/meeting11.blade.php',
    'resources/views/assignments/toefl-itp/listening/meeting12.blade.php',
    'resources/views/assignments/toefl-itp/listening/meeting13.blade.php',
    'resources/views/assignments/toefl-itp/listening/meeting14.blade.php',
    'resources/views/assignments/toefl-itp/listening/meeting15.blade.php',
    'resources/views/assignments/toefl-itp/listening/meeting16.blade.php',
    'resources/views/assignments/toefl-itp/listening/partials/admin-modals.blade.php',
    'resources/views/assignments/toefl-itp/listening/partials/audio-player-scripts.blade.php',
    'resources/views/assignments/toefl-itp/listening/partials/audio-player.blade.php',
    'resources/views/assignments/toefl-itp/listening/partials/question-card.blade.php',
    'resources/views/assignments/toefl-itp/listening/practice-index.blade.php',
    'resources/views/assignments/toefl-itp/listening/practice-package.blade.php',
    'resources/views/assignments/toefl-itp/listening/practice-part-a-range.blade.php',
    'resources/views/assignments/toefl-itp/listening/practice-part-a.blade.php',

    # Views - TOEFL Mockup
    'resources/views/assignments/toefl-itp/mockup.blade.php',
    'resources/views/assignments/toefl-itp/mockup-index.blade.php',

    # Views - TOEFL Reading
    'resources/views/assignments/toefl-itp/reading/index.blade.php',
    'resources/views/assignments/toefl-itp/reading/meeting.blade.php',
    'resources/views/assignments/toefl-itp/reading/meeting13.blade.php',
    'resources/views/assignments/toefl-itp/reading/practice-index.blade.php',
    'resources/views/assignments/toefl-itp/reading/practice-package.blade.php',
    'resources/views/assignments/toefl-itp/reading/selection.blade.php',

    # Views - TOEFL Structure
    'resources/views/assignments/toefl-itp/structure/index.blade.php',
    'resources/views/assignments/toefl-itp/structure/meeting.blade.php',
    'resources/views/assignments/toefl-itp/structure/practice-index.blade.php',
    'resources/views/assignments/toefl-itp/structure/selection.blade.php',

    # Views - Auth
    'resources/views/auth/register-student.blade.php',

    # Views - Components
    'resources/views/components/irregular-verbs-button.blade.php',
    'resources/views/components/program-sidebar.blade.php',
    'resources/views/components/sidebar-admin.blade.php',
    'resources/views/components/admin-sidebar.blade.php',
    'resources/views/components/sidebar-guest.blade.php',
    'resources/views/components/sidebar-student.blade.php',
    'resources/views/components/sidebar-teacher.blade.php',
    'resources/views/components/student-sidebar.blade.php',

    # Views - Dashboard & Layouts
    'resources/views/dashboard-content.blade.php',
    'resources/views/dashboard.blade.php',
    'resources/views/layouts/admin.blade.php',
    'resources/views/layouts/dashboard.blade.php',

    # Views - Guest
    'resources/views/guest/components/free-tests-content.blade.php',
    'resources/views/guest/index.blade.php',

    # Views - Vocabulary
    'resources/views/vocabulary-a1.blade.php',
    'resources/views/vocabulary-a2.blade.php',
    'resources/views/vocabulary-b1.blade.php',
    'resources/views/vocabulary-b2.blade.php',
    'resources/views/vocabulary-c1.blade.php',

    # Views - Other
    'resources/views/profile/edit.blade.php',
    'resources/views/registration/form.blade.php',
    'resources/views/scholarships/index.blade.php',
    'resources/views/scholarships/show.blade.php',
    'resources/views/welcome.blade.php',

    # Build assets
    'public/build/manifest.json',
    'public/build/assets/app-CdVPy7si.css',
    'public/build/assets/app-C6x9bDxv.js',
]

def ensure_remote_dir(ftp, remote_dir):
    """Ensure remote directory exists, create if needed."""
    parts = remote_dir.split('/')
    path = ''
    for part in parts:
        if not part:
            continue
        path = path + '/' + part
        try:
            ftp.mkd(path)
        except ftplib.error_perm:
            pass  # Directory already exists

def upload_file(ftp, local_path, remote_path):
    """Upload a single file via FTP."""
    remote_dir = '/'.join(remote_path.split('/')[:-1])
    ensure_remote_dir(ftp, remote_dir)
    with open(local_path, 'rb') as f:
        ftp.storbinary(f'STOR {remote_path}', f)

def main():
    os.chdir(LOCAL_BASE)

    print(f"Connecting to FTP: {FTP_HOST}...")
    ftp = ftplib.FTP(FTP_HOST)
    ftp.login(FTP_USER, FTP_PASS)
    ftp.set_pasv(True)
    print("Connected!\n")

    uploaded = 0
    skipped = 0
    errors = []

    for relative_path in FILES_TO_UPLOAD:
        local_path = os.path.join(LOCAL_BASE, relative_path)
        remote_path = f"{REMOTE_BASE}/{relative_path}"

        if not os.path.exists(local_path):
            print(f"  [SKIP] {relative_path} (not found locally)")
            skipped += 1
            continue

        try:
            print(f"  Uploading: {relative_path}")
            upload_file(ftp, local_path, remote_path)
            uploaded += 1
        except Exception as e:
            print(f"  [ERROR] {relative_path}: {e}")
            errors.append((relative_path, str(e)))

    print(f"\n{'='*60}")
    print(f"Upload complete: {uploaded} files uploaded, {skipped} skipped, {len(errors)} errors")

    if errors:
        print("\nErrors:")
        for path, err in errors:
            print(f"  {path}: {err}")

    # Upload the updater script to run migrations & cache clear
    updater_php = b"""<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

echo "<h2>Running post-deploy tasks...</h2>";

try {
    require __DIR__.'/vendor/autoload.php';
    $app = require_once __DIR__.'/bootstrap/app.php';
    $kernel = $app->make(Illuminate\\Contracts\\Console\\Kernel::class);
    $kernel->bootstrap();

    echo "<b>Running migrations...</b><br>";
    Illuminate\\Support\\Facades\\Artisan::call('migrate', ['--force' => true]);
    echo "<pre>" . Illuminate\\Support\\Facades\\Artisan::output() . "</pre>";

    echo "<b>Clearing all caches...</b><br>";
    Illuminate\\Support\\Facades\\Artisan::call('optimize:clear');
    echo "<pre>" . Illuminate\\Support\\Facades\\Artisan::output() . "</pre>";

    echo "<b style='color:green'>Done! All tasks completed.</b>";
} catch (Exception $e) {
    echo "<b style='color:red'>Error: " . $e->getMessage() . "</b>";
}

// Self-delete for security
@unlink(__FILE__);
?>"""

    print("\nUploading post-deploy runner (run_deploy.php)...")
    with open('run_deploy.php', 'wb') as f:
        f.write(updater_php)
    with open('run_deploy.php', 'rb') as f:
        ftp.storbinary(f'STOR {REMOTE_BASE}/run_deploy.php', f)
    os.remove('run_deploy.php')

    ftp.quit()
    print("\nFTP upload done!")
    print("\n*** NEXT STEP ***")
    print("Visit this URL to run migrations & clear cache:")
    print("  https://targetbahasa.com/run_deploy.php")
    print("(The file will auto-delete after running.)")

if __name__ == '__main__':
    main()
