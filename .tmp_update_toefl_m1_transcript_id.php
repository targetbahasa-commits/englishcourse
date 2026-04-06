<?php
require __DIR__ . '/vendor/autoload.php';
$app = require __DIR__ . '/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

$transcriptId = <<<'TXT'
1. M1: Saya belum pernah harus menunggu selama ini hanya untuk membayar beberapa bahan makanan!
F1: Menurut saya kamu sebaiknya pindah ke antrean lain.
M2: Apa yang disarankan wanita itu kepada pria tersebut?

2. M1: Bagaimana pekerjaanmu menjaga anak kemarin?
F2: Oh, baik-anak-anak menghabiskan sebagian besar hari dengan meluncur menuruni bukit memakai kereta luncur baru mereka.
M2: Apa yang dilakukan anak-anak itu?

3. M1: Di mana saya harus meletakkan surat-surat ini untukmu?
F1: Oh, masukkan saja ke map itu.
M2: Apa yang disuruh wanita itu dilakukan pria terhadap surat-surat itu?

4. F2: Apa kamu sudah selesai mengemas kopermu?
M1: Ya-tapi sekarang aku tidak bisa menutupnya!
M2: Apa maksud pria itu?

5. F1: Jenis roti apa yang Annie panggang?
F2: Favoritku-roti gandum utuh!
M2: Apa yang diketahui tentang Annie?

6. F1: Apakah Brenda sudah selesai menulis ceritanya untuk berita radio?
M1: Oh, tentu-dia sedang merekamnya sekarang.
M2: Apa yang dikatakan pria itu tentang cerita tersebut?

7. M1: Apakah kamu punya alamat Emily?
F1: Dia punya alamat baru-biar saya lihat apakah saya bisa menemukannya untukmu.
M2: Apa maksud wanita itu?

8. F2: Bagaimana kopi di sini, Dennis?
M1: Sedikit pahit, sejujurnya.
M2: Apa yang dikatakan Dennis tentang kopi itu?

9. F1: Saya membeli tiket untuk undian itu. Semoga saya menang.
M1: Apa hadiahnya, Ellen?
M2: Apa yang ditanyakan pria itu kepada Ellen?

10. M1: Aku penasaran apakah botol tua yang kutemukan ini bernilai uang. Warnanya indah.
F2: Ya, tapi lihat-ada bagian yang terkelupas.
M2: Apa yang dikatakan wanita itu tentang botol tersebut?

11. F1: Saya melihat Jerry berjalan memakai kruk. Apakah dia mengalami kecelakaan?
M1: Kakinya tergelincir di atas minyak dan dia terkilir lututnya.
M2: Apa yang terjadi pada Jerry?

12. M2: Ini bagian negara bagian yang indah. Tempat ini paling terkenal karena apa?
M1: Yah, kamu akan melihat beberapa kuda pacu yang luar biasa di sini.
M2: Mengapa daerah ini terkenal?

13. M1: Jadi, apakah komite akhirnya mencapai keputusan tentang masalah itu?
F2: Akhirnya-setelah mereka berdebat tentang hal itu sepanjang sore.
M2: Bagaimana komite menghabiskan sore itu?

14. F1: Saya belum pernah melihatmu memakai kemeja itu sebelumnya.
M1: Saya tidak terlalu sering memakainya-bagian kerahnya terlalu sempit.
M2: Apa masalah pada kemeja itu?

15. F1: Apakah kamu akan mengikuti ujian tengah semester di kelas Profesor Maguire?
F2: Tidak, dia memberi tugas makalah sebagai gantinya.
M2: Apa yang dilakukan Profesor Maguire?
TXT;

\App\Models\ToeflListeningQuestion::where('meeting_number', 1)
    ->where('set_number', 1)
    ->update([
        'transcript_id' => $transcriptId,
    ]);

$result = [
    'updated_questions' => \App\Models\ToeflListeningQuestion::where('meeting_number', 1)
        ->where('set_number', 1)
        ->whereNotNull('transcript_id')
        ->count(),
    'preview' => substr((string) optional(\App\Models\ToeflListeningQuestion::where('meeting_number', 1)
        ->where('set_number', 1)
        ->orderBy('question_number')
        ->first())->transcript_id, 0, 120),
];

echo json_encode($result, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) . PHP_EOL;
