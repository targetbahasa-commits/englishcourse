<?php

use Illuminate\Database\Migrations\Migration;
use App\Models\GrammarQuestion;

return new class extends Migration
{
    public function up(): void
    {
        $helpers = [
            // Section A: Gerund, To Infinitive, and Complex Ditransitive Verb
            [
                'section' => 'gerund_infinitive_complex',
                'question_number' => 1,
                'example' => ['id' => 'Salah satu aspek penting dalam belajar bahasa adalah latihan.', 'en' => 'One of the important aspects in learning a language is practice.'],
                'vocab' => [
                    'important step' => ['id' => 'langkah penting', 'pos' => '(n)'],
                    'produce' => ['id' => 'memproduksi', 'pos' => '(v1)'],
                    'moving action' => ['id' => 'gerakan bergerak', 'pos' => '(n)'],
                    'film editing' => ['id' => 'editing film', 'pos' => '(n)'],
                ],
            ],
            [
                'section' => 'gerund_infinitive_complex',
                'question_number' => 2,
                'example' => ['id' => 'Ayah membiarkan adik bermain di luar.', 'en' => 'Father lets my brother play outside.'],
                'vocab' => [
                    'sleeve bearing' => ['id' => 'sleeve bearing / bantalan selongsong', 'pos' => '(n)'],
                    'let' => ['id' => 'membuat / membiarkan (+ Bare Inf)', 'pos' => '(v1)'],
                    'piston' => ['id' => 'piston', 'pos' => '(n)'],
                    'move back and forth' => ['id' => 'bergerak maju mundur', 'pos' => '(phrase)'],
                ],
            ],
            [
                'section' => 'gerund_infinitive_complex',
                'question_number' => 3,
                'example' => ['id' => 'Siswa diwajibkan memakai seragam sekolah.', 'en' => 'Students are required to wear school uniforms.'],
                'vocab' => [
                    'opera singer' => ['id' => 'penyanyi opera', 'pos' => '(n)'],
                    'require to' => ['id' => 'mewajibkan untuk', 'pos' => '(v1)'],
                    'strong and beautiful' => ['id' => 'kuat dan indah', 'pos' => '(adj)'],
                    'voice' => ['id' => 'suara', 'pos' => '(n)'],
                ],
            ],
            [
                'section' => 'gerund_infinitive_complex',
                'question_number' => 4,
                'example' => ['id' => 'Guru mengajari kami cara memecahkan masalah.', 'en' => 'The teacher taught us how to solve the problem.'],
                'vocab' => [
                    'century' => ['id' => 'abad', 'pos' => '(n)'],
                    'teach (taught)' => ['id' => 'mengajar', 'pos' => '(v2)'],
                    'Pilgrims' => ['id' => 'para Pilgrim', 'pos' => '(n)'],
                    'grow corn' => ['id' => 'menumbuhkan/menanam jagung', 'pos' => '(phrase)'],
                ],
            ],
            [
                'section' => 'gerund_infinitive_complex',
                'question_number' => 5,
                'example' => ['id' => 'Elang menggunakan cakar mereka untuk menangkap mangsa.', 'en' => 'Eagles use their claws to catch prey.'],
                'vocab' => [
                    'certain types' => ['id' => 'jenis tertentu', 'pos' => '(n)'],
                    'tongue' => ['id' => 'lidah', 'pos' => '(n)'],
                    'catch' => ['id' => 'menangkap', 'pos' => '(v1)'],
                    'insect' => ['id' => 'serangga', 'pos' => '(n)'],
                ],
            ],
            [
                'section' => 'gerund_infinitive_complex',
                'question_number' => 6,
                'example' => ['id' => 'Aplikasi ini mengizinkan pengguna berbagi file.', 'en' => 'This app permits users to share files.'],
                'vocab' => [
                    'permit' => ['id' => 'mengizinkan (+ Obj + to V1)', 'pos' => '(v1)'],
                    'communicate' => ['id' => 'berkomunikasi', 'pos' => '(v1)'],
                    'with one another' => ['id' => 'satu sama lain', 'pos' => '(phrase)'],
                    'telephone network' => ['id' => 'jaringan telepon', 'pos' => '(n)'],
                ],
            ],
            [
                'section' => 'gerund_infinitive_complex',
                'question_number' => 7,
                'example' => ['id' => 'Musik efektif dalam meredakan stres pikiran.', 'en' => 'Music is effective in relieving mental stress.'],
                'vocab' => [
                    'smell' => ['id' => 'bau / aroma', 'pos' => '(n)'],
                    'effective' => ['id' => 'efektif', 'pos' => '(adj)'],
                    'sensory stimuli' => ['id' => 'stimuli sensori', 'pos' => '(n)'],
                    'bring back memories' => ['id' => 'membawa kembali ingatan', 'pos' => '(phrase)'],
                ],
            ],
            [
                'section' => 'gerund_infinitive_complex',
                'question_number' => 8,
                'example' => ['id' => 'Teknologi ini memungkinkan dokter mendeteksi penyakit lebih awal.', 'en' => 'This technology allows doctors to detect diseases earlier.'],
                'vocab' => [
                    'knee transplant' => ['id' => 'transplantasi lutut', 'pos' => '(n)'],
                    'allow' => ['id' => 'mengizinkan (+ Obj + to V1)', 'pos' => '(v1)'],
                    'arthritis' => ['id' => 'radang sendi / artritis', 'pos' => '(n)'],
                    'bend' => ['id' => 'menekuk / membengkokkan', 'pos' => '(v1)'],
                ],
            ],
            [
                'section' => 'gerund_infinitive_complex',
                'question_number' => 9,
                'example' => ['id' => 'Suara keras membuat semua orang terkejut.', 'en' => 'A loud noise made everyone jump.'],
                'vocab' => [
                    'sudden noise' => ['id' => 'suara tiba-tiba', 'pos' => '(n)'],
                    'make' => ['id' => 'membuat (+ Obj + Bare Inf)', 'pos' => '(v1)'],
                    'golf player' => ['id' => 'pemain golf', 'pos' => '(n)'],
                    'miss a shot' => ['id' => 'melewatkan tembakan', 'pos' => '(phrase)'],
                ],
            ],
            [
                'section' => 'gerund_infinitive_complex',
                'question_number' => 10,
                'example' => ['id' => 'Angin kencang menyebabkan pepohonan tumbang.', 'en' => 'Strong wind caused trees to fall.'],
                'vocab' => [
                    'heavy spring snow' => ['id' => 'salju musim semi yang lebat', 'pos' => '(n)'],
                    'cause' => ['id' => 'menyebabkan (+ Obj + to V1)', 'pos' => '(v1)'],
                    'tree branch' => ['id' => 'cabang pohon', 'pos' => '(n)'],
                    'break' => ['id' => 'patah / rusak', 'pos' => '(v1)'],
                ],
            ],
            [
                'section' => 'gerund_infinitive_complex',
                'question_number' => 11,
                'example' => ['id' => 'Batu permata ini mustahil untuk digores.', 'en' => 'This gemstone is impossible to scratch.'],
                'vocab' => [
                    'fuel container' => ['id' => 'wadah bahan bakar / tangki', 'pos' => '(n)'],
                    'modern racing car' => ['id' => 'mobil balap modern', 'pos' => '(n)'],
                    'impossible' => ['id' => 'mustahil / tidak mungkin', 'pos' => '(adj)'],
                    'pierce' => ['id' => 'menusuk / menembus', 'pos' => '(v1)'],
                ],
            ],

            // Section B: To Infinitive
            [
                'section' => 'to_infinitive',
                'question_number' => 1,
                'example' => ['id' => 'Kita perlu melindungi habitat alami satwa.', 'en' => 'We need to protect natural habitats.'],
                'vocab' => [
                    'society' => ['id' => 'masyarakat', 'pos' => '(n)'],
                    'need to' => ['id' => 'perlu untuk', 'pos' => '(v1)'],
                    'consider' => ['id' => 'mempertimbangkan', 'pos' => '(v1)'],
                    'nature protection' => ['id' => 'perlindungan alam/lingkungan', 'pos' => '(n)'],
                ],
            ],
            [
                'section' => 'to_infinitive',
                'question_number' => 2,
                'example' => ['id' => 'Upaya untuk mengurangi polusi udara sangat krusial.', 'en' => 'The effort to reduce air pollution is crucial.'],
                'vocab' => [
                    'the need to' => ['id' => 'kebutuhan untuk', 'pos' => '(phrase)'],
                    'improve' => ['id' => 'meningkatkan', 'pos' => '(v1)'],
                    'welfare' => ['id' => 'kesejahteraan', 'pos' => '(n)'],
                    'important' => ['id' => 'penting', 'pos' => '(adj)'],
                ],
            ],
            [
                'section' => 'to_infinitive',
                'question_number' => 3,
                'example' => ['id' => 'Peraturan ini dibuat untuk melindungi hak cipta.', 'en' => 'This regulation is made to protect copyrights.'],
                'vocab' => [
                    'law' => ['id' => 'hukum / undang-undang', 'pos' => '(n)'],
                    'make (made)' => ['id' => 'dibuat', 'pos' => '(v3)'],
                    'guarantee' => ['id' => 'menjamin', 'pos' => '(v1)'],
                    'freedom of speech' => ['id' => 'kebebasan berpendapat', 'pos' => '(n)'],
                ],
            ],
            [
                'section' => 'to_infinitive',
                'question_number' => 4,
                'example' => ['id' => 'Robot itu dikirim untuk memeriksa kawah gunung.', 'en' => 'The robot was sent to examine the crater.'],
                'vocab' => [
                    'spacecraft' => ['id' => 'pesawat luar angkasa', 'pos' => '(n)'],
                    'send (sent)' => ['id' => 'dikirim', 'pos' => '(v3)'],
                    'explore' => ['id' => 'menjelajahi / mengeksplorasi', 'pos' => '(v1)'],
                    'Mercury' => ['id' => 'Merkurius', 'pos' => '(n)'],
                ],
            ],
            [
                'section' => 'to_infinitive',
                'question_number' => 5,
                'example' => ['id' => 'Warga meminta agar dilindungi dari bencana banjir.', 'en' => 'Residents ask to be protected from flood disasters.'],
                'vocab' => [
                    'ask' => ['id' => 'meminta / memohon', 'pos' => '(v1)'],
                    'government' => ['id' => 'pemerintah', 'pos' => '(n)'],
                    'be protected' => ['id' => 'dilindungi (pasif)', 'pos' => '(phrase)'],
                    'global crisis' => ['id' => 'krisis global', 'pos' => '(n)'],
                ],
            ],
            [
                'section' => 'to_infinitive',
                'question_number' => 6,
                'example' => ['id' => 'Anggaran dana perlu dikelola secara transparan.', 'en' => 'The budget needs to be managed transparently.'],
                'vocab' => [
                    'natural resources' => ['id' => 'sumber daya alam', 'pos' => '(n)'],
                    'need to be managed' => ['id' => 'perlu untuk dikelola', 'pos' => '(phrase)'],
                    'wisely' => ['id' => 'secara bijak', 'pos' => '(adv)'],
                ],
            ],
            [
                'section' => 'to_infinitive',
                'question_number' => 7,
                'example' => ['id' => 'Spesies ini diusulkan untuk dilindungi undang-undang.', 'en' => 'This species is proposed to be protected by law.'],
                'vocab' => [
                    'jungle cat' => ['id' => 'kucing hutan', 'pos' => '(n)'],
                    'propose' => ['id' => 'mengajukan / mengusulkan', 'pos' => '(v1)'],
                    'include' => ['id' => 'memasukkan / mencakup', 'pos' => '(v1)'],
                    'endangered animal list' => ['id' => 'daftar hewan langka', 'pos' => '(n)'],
                ],
            ],
            [
                'section' => 'to_infinitive',
                'question_number' => 8,
                'example' => ['id' => 'Isu iklim perlu dibahas di konferensi tingkat tinggi.', 'en' => 'Climate issues need to be discussed at the summit.'],
                'vocab' => [
                    'clean water problem' => ['id' => 'masalah air bersih', 'pos' => '(n)'],
                    'discuss' => ['id' => 'membahas / mendiskusikan', 'pos' => '(v1)'],
                    'next global meeting' => ['id' => 'pertemuan global berikutnya', 'pos' => '(n)'],
                ],
            ],
            [
                'section' => 'to_infinitive',
                'question_number' => 9,
                'example' => ['id' => 'Peneliti harus berhati-hati dalam percobaan ini.', 'en' => 'Researchers must be careful in this trial.'],
                'vocab' => [
                    'government' => ['id' => 'pemerintah', 'pos' => '(n)'],
                    'need to be' => ['id' => 'perlu untuk (nominal)', 'pos' => '(phrase)'],
                    'careful' => ['id' => 'berhati-hati', 'pos' => '(adj)'],
                    'in this matter' => ['id' => 'dalam hal ini', 'pos' => '(phrase)'],
                ],
            ],
            [
                'section' => 'to_infinitive',
                'question_number' => 10,
                'example' => ['id' => 'Remaja ingin menjadi mandiri secara finansial.', 'en' => 'Teenagers want to be financially independent.'],
                'vocab' => [
                    'young generation' => ['id' => 'generasi muda', 'pos' => '(n)'],
                    'want to be' => ['id' => 'ingin untuk menjadi', 'pos' => '(phrase)'],
                    'independent' => ['id' => 'mandiri', 'pos' => '(adj)'],
                ],
            ],
            [
                'section' => 'to_infinitive',
                'question_number' => 11,
                'example' => ['id' => 'Pengemudi diminta tidak ceroboh di jalan raya.', 'en' => 'Drivers are asked not to be careless on roads.'],
                'vocab' => [
                    'company' => ['id' => 'perusahaan', 'pos' => '(n)'],
                    'ask' => ['id' => 'meminta / menuntut', 'pos' => '(v1)'],
                    'careless' => ['id' => 'ceroboh / lalai', 'pos' => '(adj)'],
                    'in this matter' => ['id' => 'dalam hal ini', 'pos' => '(phrase)'],
                ],
            ],
            [
                'section' => 'to_infinitive',
                'question_number' => 12,
                'example' => ['id' => 'Pabrik diwajibkan mengolah limbah industri.', 'en' => 'Factories are required to treat industrial waste.'],
                'vocab' => [
                    'require' => ['id' => 'mewajibkan / mensyaratkan', 'pos' => '(v1)'],
                    'responsible for' => ['id' => 'bertanggung jawab atas', 'pos' => '(adj)'],
                    'waste' => ['id' => 'limbah / sampah', 'pos' => '(n)'],
                ],
            ],

            // Section C: Gerund
            [
                'section' => 'gerund',
                'question_number' => 1,
                'example' => ['id' => 'Membangun infrastruktur adalah prioritas nasional.', 'en' => 'Building infrastructure is a national priority.'],
                'vocab' => [
                    'create' => ['id' => 'menciptakan', 'pos' => '(v1)'],
                    'job opportunity' => ['id' => 'lapangan pekerjaan', 'pos' => '(n)'],
                    'main task' => ['id' => 'tugas utama', 'pos' => '(n)'],
                    'government' => ['id' => 'pemerintah', 'pos' => '(n)'],
                ],
            ],
            [
                'section' => 'gerund',
                'question_number' => 2,
                'example' => ['id' => 'Mengurangi pengeluaran membutuhkan disiplin.', 'en' => 'Reducing expenses requires discipline.'],
                'vocab' => [
                    'control' => ['id' => 'mengendalikan', 'pos' => '(v1)'],
                    'inflation rate' => ['id' => 'laju inflasi', 'pos' => '(n)'],
                    'need' => ['id' => 'membutuhkan', 'pos' => '(v1)'],
                    'strategy' => ['id' => 'strategi', 'pos' => '(n)'],
                ],
            ],
            [
                'section' => 'gerund',
                'question_number' => 3,
                'example' => ['id' => 'Melestarikan hutan tidak harus selalu mahal.', 'en' => 'Preserving forests does not have to be expensive.'],
                'vocab' => [
                    'protect' => ['id' => 'melindungi', 'pos' => '(v1)'],
                    'wildlife' => ['id' => 'satwa liar', 'pos' => '(n)'],
                    'does not have to' => ['id' => 'tidak harus', 'pos' => '(phrase)'],
                    'in situ' => ['id' => 'di habitat asli (in situ)', 'pos' => '(adj)'],
                ],
            ],
            [
                'section' => 'gerund',
                'question_number' => 4,
                'example' => ['id' => 'Tujuan hidupnya adalah membantu sesama manusia.', 'en' => 'His life goal is helping fellow humans.'],
                'vocab' => [
                    'human task' => ['id' => 'tugas manusia', 'pos' => '(n)'],
                    'preserve' => ['id' => 'melestarikan', 'pos' => '(v1)'],
                    'nature' => ['id' => 'alam', 'pos' => '(n)'],
                    'future generation' => ['id' => 'generasi mendatang', 'pos' => '(n)'],
                ],
            ],
            [
                'section' => 'gerund',
                'question_number' => 5,
                'example' => ['id' => 'Menjadi kreatif membutuhkan banyak eksperimen.', 'en' => 'Being creative requires many experiments.'],
                'vocab' => [
                    'being innovative' => ['id' => 'menjadi inovatif', 'pos' => '(phrase)'],
                    'need' => ['id' => 'memerlukan / butuh', 'pos' => '(v1)'],
                    'openness' => ['id' => 'keterbukaan', 'pos' => '(n)'],
                    'new idea' => ['id' => 'ide baru', 'pos' => '(n)'],
                ],
            ],
            [
                'section' => 'gerund',
                'question_number' => 6,
                'example' => ['id' => 'Menjadi waspada terhadap risiko adalah hal penting.', 'en' => 'Being alert to risks is essential.'],
                'vocab' => [
                    'being aware of' => ['id' => 'menjadi sadar akan/terhadap', 'pos' => '(phrase)'],
                    'environmental damage' => ['id' => 'kerusakan lingkungan', 'pos' => '(n)'],
                    'mission' => ['id' => 'misi / tujuan', 'pos' => '(n)'],
                    'organization' => ['id' => 'organisasi', 'pos' => '(n)'],
                ],
            ],
            [
                'section' => 'gerund',
                'question_number' => 7,
                'example' => ['id' => 'Menjadi anggota tim memberi banyak wawasan baru.', 'en' => 'Being a team member gives many new insights.'],
                'vocab' => [
                    'being part of' => ['id' => 'menjadi bagian dari', 'pos' => '(phrase)'],
                    'give' => ['id' => 'memberi', 'pos' => '(v1)'],
                    'young people' => ['id' => 'anak muda', 'pos' => '(n)'],
                    'opportunity to contribute' => ['id' => 'kesempatan untuk berkontribusi', 'pos' => '(phrase)'],
                ],
            ],
            [
                'section' => 'gerund',
                'question_number' => 8,
                'example' => ['id' => 'Menjadi jujur adalah prinsip hidup utamanya.', 'en' => 'Being honest is his main life principle.'],
                'vocab' => [
                    'being healthy' => ['id' => 'menjadi sehat', 'pos' => '(phrase)'],
                    'main thing' => ['id' => 'hal utama / yang terpenting', 'pos' => '(n)'],
                ],
            ],
            [
                'section' => 'gerund',
                'question_number' => 9,
                'example' => ['id' => 'Diproduksi di pabrik membuat kualitasnya terjaga.', 'en' => 'Being produced in a factory keeps its quality high.'],
                'vocab' => [
                    'being developed' => ['id' => 'dikembangkan (gerund pasif)', 'pos' => '(phrase)'],
                    'laboratory' => ['id' => 'laboratorium', 'pos' => '(n)'],
                    'make' => ['id' => 'membuat', 'pos' => '(v1)'],
                    'dangerous' => ['id' => 'berbahaya', 'pos' => '(adj)'],
                ],
            ],
            [
                'section' => 'gerund',
                'question_number' => 10,
                'example' => ['id' => 'Gedung bersejarah itu berisiko dirobohkan.', 'en' => 'That historical building risks being demolished.'],
                'vocab' => [
                    'risk' => ['id' => 'berisiko (+ V-ing)', 'pos' => '(v1)'],
                    'being abandoned' => ['id' => 'ditinggalkan (gerund pasif)', 'pos' => '(phrase)'],
                    'abandon' => ['id' => 'meninggalkan / menelantarkan', 'pos' => '(v1)'],
                    'government' => ['id' => 'pemerintah', 'pos' => '(n)'],
                ],
            ],
            [
                'section' => 'gerund',
                'question_number' => 11,
                'example' => ['id' => 'Alat tradisional ini tetap dipakai oleh para petani.', 'en' => 'This traditional tool remains being used by farmers.'],
                'vocab' => [
                    'transportation system' => ['id' => 'sistem transportasi', 'pos' => '(n)'],
                    'remain' => ['id' => 'tetap / bertahan', 'pos' => '(v1)'],
                    'being used' => ['id' => 'digunakan (gerund pasif)', 'pos' => '(phrase)'],
                    'society' => ['id' => 'masyarakat', 'pos' => '(n)'],
                ],
            ],
            [
                'section' => 'gerund',
                'question_number' => 12,
                'example' => ['id' => 'Perusahaan itu berhenti didukung oleh investor.', 'en' => 'That company stopped being supported by investors.'],
                'vocab' => [
                    'stop' => ['id' => 'berhenti (+ V-ing)', 'pos' => '(v1)'],
                    'being trusted' => ['id' => 'dipercayai (gerund pasif)', 'pos' => '(phrase)'],
                    'trust' => ['id' => 'mempercayai', 'pos' => '(v1)'],
                    'society' => ['id' => 'masyarakat', 'pos' => '(n)'],
                ],
            ],
            [
                'section' => 'gerund',
                'question_number' => 13,
                'example' => ['id' => 'Kota pesisir mulai membangun tanggul laut.', 'en' => 'Coastal cities begin building sea walls.'],
                'vocab' => [
                    'pacific country' => ['id' => 'negara pasifik', 'pos' => '(n)'],
                    'begin' => ['id' => 'memulai (+ V-ing)', 'pos' => '(v1)'],
                    'build' => ['id' => 'membangun', 'pos' => '(v1)'],
                    'sea wall' => ['id' => 'tembok laut / tanggul laut', 'pos' => '(n)'],
                ],
            ],
            [
                'section' => 'gerund',
                'question_number' => 14,
                'example' => ['id' => 'Para ilmuwan mencoba menguji senyawa kimia baru.', 'en' => 'Scientists try testing new chemical compounds.'],
                'vocab' => [
                    'try' => ['id' => 'mencoba (+ V-ing)', 'pos' => '(v1)'],
                    'launch' => ['id' => 'meluncurkan', 'pos' => '(v1)'],
                    'satellite' => ['id' => 'satelit', 'pos' => '(n)'],
                ],
            ],

            // Section Paragraph
            [
                'section' => 'paragraph',
                'question_number' => 1,
                'example' => null,
                'vocab' => [
                    'protect the environment' => ['id' => 'melindungi lingkungan', 'pos' => '(phrase)'],
                    'responsibility' => ['id' => 'tanggung jawab', 'pos' => '(n)'],
                    'eco-friendly policies' => ['id' => 'kebijakan ramah lingkungan', 'pos' => '(n)'],
                    'electronic waste' => ['id' => 'limbah elektronik', 'pos' => '(n)'],
                    'recycle used goods' => ['id' => 'mendaur ulang barang bekas', 'pos' => '(phrase)'],
                    'prioritize' => ['id' => 'memprioritaskan', 'pos' => '(v1)'],
                    'fatal impact' => ['id' => 'dampak fatal', 'pos' => '(n)'],
                    'clean-up campaign' => ['id' => 'kampanye bersih-bersih', 'pos' => '(n)'],
                ],
            ],
        ];

        foreach ($helpers as $h) {
            $q = GrammarQuestion::where('meeting_number', 5)
                ->where('section', $h['section'])
                ->where('question_number', $h['question_number'])
                ->first();

            if ($q) {
                $q->example = $h['example'];
                $q->vocab = $h['vocab'];
                $q->save();
            }
        }
    }

    public function down(): void
    {
        GrammarQuestion::where('meeting_number', 5)->update(['vocab' => null, 'example' => null]);
    }
};
