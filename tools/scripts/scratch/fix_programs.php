<?php
use App\Models\Program;

// Update the original if it exists
$prog = Program::where('slug', 'grammar-for-writing')->first();
if ($prog) {
    $prog->update([
        'slug' => 'introductory-grammar-for-writing',
        'name' => 'Introductory Grammar for Writing',
        'description' => 'Kelas dasar tata bahasa Inggris untuk penulisan akademik.',
        'color' => 'orange'
    ]);
}

Program::firstOrCreate(
    ['slug' => 'complexity-grammar-for-writing'],
    [
        'name' => 'Complexity Grammar for Writing',
        'period' => 'September 2024',
        'description' => 'Penguasaan struktur kalimat kompleks untuk penulisan lanjutan.',
        'color' => 'green',
    ]
);

Program::firstOrCreate(
    ['slug' => 'proficiency-grammar-for-writing'],
    [
        'name' => 'Proficiency Grammar for Writing',
        'period' => 'September 2024',
        'description' => 'Tingkat mahir tata bahasa untuk penulisan akademik dan profesional.',
        'color' => 'purple',
    ]
);

Program::firstOrCreate(
    ['slug' => 'fast-track-grammar-for-writing'],
    [
        'name' => 'Fast Track Grammar for Writing',
        'period' => 'September 2024',
        'description' => 'Kelas tata bahasa Inggris intensif yang akan mempersiapkanmu untuk kelas IELTS.',
        'color' => 'blue',
    ]
);

echo "Programs updated successfully.\n";
