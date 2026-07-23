<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\GrammarQuestion;

class Meeting5GerundInfinitiveSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // First delete old questions for Meeting 5
        GrammarQuestion::where('meeting_number', 5)->delete();

        $questions = [
            // Section A: Gerund, to infinitive, and Complex Ditransitive Verb
            [
                'question_number' => 1,
                'section' => 'gerund_infinitive_complex',
                'question_text' => 'Salah satu langkah - langkah penting dalam memproduksi sebuah gerakan bergerak adalah editing film.',
                'correct_answer' => 'One of the most important steps in producing a moving action is film editing.',
            ],
            [
                'question_number' => 2,
                'section' => 'gerund_infinitive_complex',
                'question_text' => 'Sleeve bearing membuat (let) piston untuk bergerak maju dan mundur.',
                'correct_answer' => 'Sleeve bearing lets the piston move back and forth.',
            ],
            [
                'question_number' => 3,
                'section' => 'gerund_infinitive_complex',
                'question_text' => 'Seorang penyanyi opera diwajibkan memiliki sebuah suara yang kuat dan indah.',
                'correct_answer' => 'An opera singer is required to have a strong and beautiful voice.',
            ],
            [
                'question_number' => 4,
                'section' => 'gerund_infinitive_complex',
                'question_text' => 'Pada abad 17, Wampanoag Indians mengajar para Pilgrim bagaimana untuk menumbuhkan jagung.',
                'correct_answer' => 'In the 17th century, Wampanoag Indians taught the Pilgrims how to grow corn.',
            ],
            [
                'question_number' => 5,
                'section' => 'gerund_infinitive_complex',
                'question_text' => 'Kodok dan jenis tertentu dari burung menggunakan lidah mereka untuk menangkap serangga-serangga.',
                'correct_answer' => 'Frogs and certain types of birds use their tongues to catch insects.',
            ],
            [
                'question_number' => 6,
                'section' => 'gerund_infinitive_complex',
                'question_text' => 'Modem mengijinkan (permit) komputer berkomunikasi satu dengan lainnya melalui jaringan telepon.',
                'correct_answer' => 'Modem permits computers to communicate with one another via telephone networks.',
            ],
            [
                'question_number' => 7,
                'section' => 'gerund_infinitive_complex',
                'question_text' => 'Bau bisa efektif di dalam stimuli sensory dalam membawa kembali ingatan.',
                'correct_answer' => 'Smells can be effective in sensory stimuli in bringing back memories.',
            ],
            [
                'question_number' => 8,
                'section' => 'gerund_infinitive_complex',
                'question_text' => 'Transplantasi lutut mengijinkan (allow) orang - orang dengan arthritis untuk menekuk lutut mereka secara mudah.',
                'correct_answer' => 'Knee transplants allow people with arthritis to bend their knees easily.',
            ],
            [
                'question_number' => 9,
                'section' => 'gerund_infinitive_complex',
                'question_text' => 'Sebuah suara yang tiba - tiba bisa membuat seorang pemain golf melewatkan sebuah tembakan.',
                'correct_answer' => 'A sudden noise can make a golf player miss a shot.',
            ],
            [
                'question_number' => 10,
                'section' => 'gerund_infinitive_complex',
                'question_text' => 'Salju musim semi yang berat mungkin menyebabkan cabang - cabang dari pohon untuk patah.',
                'correct_answer' => 'Heavy spring snow may cause branches of trees to break.',
            ],
            [
                'question_number' => 11,
                'section' => 'gerund_infinitive_complex',
                'question_text' => 'Wadah bahan bakar di mobil balap modern mustahil untuk di tusuk.',
                'correct_answer' => 'The fuel container in modern racing cars is impossible to pierce.',
            ],

            // Section B: To infinitive
            [
                'question_number' => 1,
                'section' => 'to_infinitive',
                'question_text' => 'Masyarakat perlu untuk mempertimbangkan perlindungan lingkungan.',
                'correct_answer' => 'Society needs to consider nature protection.',
            ],
            [
                'question_number' => 2,
                'section' => 'to_infinitive',
                'question_text' => 'Kebutuhan untuk meningkatkan kesejahteraan adalah penting.',
                'correct_answer' => 'The need to improve welfare is important.',
            ],
            [
                'question_number' => 3,
                'section' => 'to_infinitive',
                'question_text' => 'Hukum ini dibuat untuk menjamin kebebasan berpendapat.',
                'correct_answer' => 'This law is made to guarantee freedom of speech.',
            ],
            [
                'question_number' => 4,
                'section' => 'to_infinitive',
                'question_text' => 'Pesawat luar angkasa ini dikirim untuk menjelajahi Merkurius.',
                'correct_answer' => 'This spacecraft was sent to explore Mercury.',
            ],
            [
                'question_number' => 5,
                'section' => 'to_infinitive',
                'question_text' => 'Masyarakat meminta kepada pemerintah untuk dilindungi dari krisis global.',
                'correct_answer' => 'Society asks the government to be protected from global crisis.',
            ],
            [
                'question_number' => 6,
                'section' => 'to_infinitive',
                'question_text' => 'Sumber daya alam perlu untuk dikelola secara bijak.',
                'correct_answer' => 'Natural resources need to be managed wisely.',
            ],
            [
                'question_number' => 7,
                'section' => 'to_infinitive',
                'question_text' => 'Kucing hutan diajukan untuk dimasukkan ke dalam daftar hewan langka.',
                'correct_answer' => 'Jungle cats are proposed to be included in the endangered animals list.',
            ],
            [
                'question_number' => 8,
                'section' => 'to_infinitive',
                'question_text' => 'Masalah air bersih perlu dibahas di dalam pertemuan global selanjutnya.',
                'correct_answer' => 'Clean water problems need to be discussed in the next global meeting.',
            ],
            [
                'question_number' => 9,
                'section' => 'to_infinitive',
                'question_text' => 'Pemerintah perlu untuk berhati - hati dalam hal ini.',
                'correct_answer' => 'The government needs to be careful in this matter.',
            ],
            [
                'question_number' => 10,
                'section' => 'to_infinitive',
                'question_text' => 'Generasi muda ingin untuk menjadi mandiri.',
                'correct_answer' => 'Young generation wants to be independent.',
            ],
            [
                'question_number' => 11,
                'section' => 'to_infinitive',
                'question_text' => 'Perusahaan tidak diminta untuk ceroboh dalam hal ini.',
                'correct_answer' => 'The company is not asked to be careless in this matter.',
            ],
            [
                'question_number' => 12,
                'section' => 'to_infinitive',
                'question_text' => 'Pemerintah mewajibkan perusahaan untuk bertanggung jawab atas limbah mereka.',
                'correct_answer' => 'The government requires companies to be responsible for their waste.',
            ],

            // Section C: Gerund
            [
                'question_number' => 1,
                'section' => 'gerund',
                'question_text' => 'Menciptakan lapangan pekerjaan adalah salah satu tugas utama pemerintah.',
                'correct_answer' => 'Creating job opportunities is one of the government\'s main tasks.',
            ],
            [
                'question_number' => 2,
                'section' => 'gerund',
                'question_text' => 'Mengendalikan laju inflasi membutuhkan banyak strategi.',
                'correct_answer' => 'Controlling inflation rate needs many strategies.',
            ],
            [
                'question_number' => 3,
                'section' => 'gerund',
                'question_text' => 'Melindungi satwa liar tidak harus in situ.',
                'correct_answer' => 'Protecting wildlife does not have to be in situ.',
            ],
            [
                'question_number' => 4,
                'section' => 'gerund',
                'question_text' => 'Tugas manusia adalah melestarikan alam untuk generasi mendatang.',
                'correct_answer' => 'Human task is preserving nature for future generations.',
            ],
            [
                'question_number' => 5,
                'section' => 'gerund',
                'question_text' => 'Menjadi inovatif memerlukan keterbukaan kepada ide baru. (nominal)',
                'correct_answer' => 'Being innovative needs openness to new ideas.',
            ],
            [
                'question_number' => 6,
                'section' => 'gerund',
                'question_text' => 'Menjadi sadar terhadap kerusakan lingkungan adalah misi dari organisasi ini. (nominal)',
                'correct_answer' => 'Being aware of environmental damage is the mission of this organization.',
            ],
            [
                'question_number' => 7,
                'section' => 'gerund',
                'question_text' => 'Menjadi bagian dari organisasi ini memberi anak muda kesempatan untuk berkontribusi. (nominal)',
                'correct_answer' => 'Being part of this organization gives young people opportunities to contribute.',
            ],
            [
                'question_number' => 8,
                'section' => 'gerund',
                'question_text' => 'Menjadi sehat adalah hal utama. (nominal)',
                'correct_answer' => 'Being healthy is the main thing.',
            ],
            [
                'question_number' => 9,
                'section' => 'gerund',
                'question_text' => 'Dikembangkan di laboratorium membuat virus ini berbahaya.',
                'correct_answer' => 'Being developed in a laboratory makes this virus dangerous.',
            ],
            [
                'question_number' => 10,
                'section' => 'gerund',
                'question_text' => 'Banyak proyek beresiko ditinggalkan oleh pemerintah.',
                'correct_answer' => 'Many projects risk being abandoned by the government.',
            ],
            [
                'question_number' => 11,
                'section' => 'gerund',
                'question_text' => 'Sistem transportasi tua ini tetap digunakan oleh masyarakat.',
                'correct_answer' => 'This old transportation system remains being used by society.',
            ],
            [
                'question_number' => 12,
                'section' => 'gerund',
                'question_text' => 'Organisasi ini berhenti dipercayai oleh masyarakat.',
                'correct_answer' => 'This organization stops being trusted by society.',
            ],
            [
                'question_number' => 13,
                'section' => 'gerund',
                'question_text' => 'Negara - negara pasifik memulai membangun tembok laut.',
                'correct_answer' => 'Pacific countries begin building sea walls.',
            ],
            [
                'question_number' => 14,
                'section' => 'gerund',
                'question_text' => 'NASA mencoba meluncurkan satelit.',
                'correct_answer' => 'NASA tries launching satellites.',
            ],

            // Section D: Paragraph
            [
                'question_number' => 1,
                'section' => 'paragraph',
                'question_text' => 'Melindungi lingkungan menjadi tanggung jawab semua orang. Banyak orang telah mulai menyadari pentingnya mengurangi penggunaan plastik. Pemerintah berusaha untuk mengembangkan kebijakan ramah lingkungan. Kami telah mempertimbangkan untuk menanam pohon sebagai bagian dari program sekolah. Beberapa relawan sedang mencoba mengedukasi masyarakat tentang dampak limbah elektronik. Organisasi lingkungan terus mendorong masyarakat untuk mendaur ulang barang bekas. Menjaga kebersihan sungai adalah hal yang harus diprioritaskan oleh warga sekitar. Para ilmuwan telah memperingatkan untuk memperhatikan perubahan iklim bisa berdampak fatal. Kami berencana untuk mengadakan kampanye bersih-bersih setiap bulan. (ini tidak) tidak mudah menghentikan pencemaran, tetapi mencoba memperbaikinya adalah langkah penting.',
                'correct_answer' => 'Protecting the environment becomes everyone\'s responsibility. Many people have started realizing the importance of reducing plastic use. The government tries to develop eco-friendly policies. We have considered planting trees as part of the school program. Some volunteers are trying to educate society about the impact of electronic waste. Environmental organizations keep encouraging society to recycle used goods. Keeping the river clean is a thing that must be prioritized by local residents. Scientists have warned to pay attention that climate change can have a fatal impact. We plan to hold a clean-up campaign every month. It is not easy to stop pollution, but trying to fix it is an important step.',
            ]
        ];

        foreach ($questions as $q) {
            GrammarQuestion::create(array_merge($q, [
                'meeting_number' => 5,
            ]));
        }
    }
}
