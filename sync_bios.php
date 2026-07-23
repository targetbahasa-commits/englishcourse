<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
$response = $kernel->handle(
    $request = Illuminate\Http\Request::capture()
);
$leads = \App\Models\RegistrationLead::whereNotNull('converted_user_id')->get();
foreach ($leads as $lead) {
    $user = \App\Models\User::find($lead->converted_user_id);
    if ($user && empty($user->bio)) {
        $bioParts = [];
        if (!empty($lead->learning_goal)) $bioParts[] = 'Tujuan: ' . $lead->learning_goal;
        if (!empty($lead->target_score)) $bioParts[] = 'Target Skor: ' . $lead->target_score;
        if (!empty($lead->has_previous_course) && $lead->has_previous_course) $bioParts[] = 'Kursus Sebelumnya: ' . ($lead->previous_course_name ?? 'Ya');
        if (!empty($lead->schedule_preference)) $bioParts[] = 'Jadwal: ' . $lead->schedule_preference;
        if (!empty($lead->preferred_time)) $bioParts[] = 'Waktu: ' . $lead->preferred_time;
        if (!empty($lead->best_contact_time)) $bioParts[] = 'Waktu Dihubungi: ' . $lead->best_contact_time;
        if (!empty($lead->notes)) $bioParts[] = 'Catatan: ' . $lead->notes;
        $bioStr = implode("\n", $bioParts);
        
        if (!empty($bioStr)) {
            $user->bio = $bioStr;
            $user->save();
        }
    }
}
echo 'Bio Sync Complete';
