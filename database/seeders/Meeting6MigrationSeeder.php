<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\GrammarQuestion;
use Illuminate\Support\Facades\DB;

class Meeting6MigrationSeeder extends Seeder
{
    public function run()
    {
        // 1. Clear existing Meeting 6 data
        GrammarQuestion::where('meeting_number', 6)->delete();

        // 2. Data Definitions
        $verbPatterns = [
            1 => [
                'id' => 'Salah satu langkah - langkah penting dalam memproduksi sebuah gerakan bergerak adalah editing film.',
                'en' => 'One of the most important steps in producing a moving action is film editing',
                'example' => ['id' => 'Salah satu langkah penting adalah belajar.', 'en' => 'One of the important steps is learning.'],
                'vocab' => [
                    'Step' => ['id' => 'Langkah', 'pos' => '(n)'],
                    'Important' => ['id' => 'Penting', 'pos' => '(adj)'],
                    'Produce' => ['id' => 'Memproduksi', 'pos' => '(v)'],
                    'Editing' => ['id' => 'Editing', 'pos' => '(n)']
                ]
            ],
            2 => [
                'id' => 'Sleeve bearing membuat (let) piston untuk bergerak maju dan mundur.',
                'en' => 'Sleeve bearing lets the piston move forward and backward',
                'example' => ['id' => 'Dia membiarkan saya pergi.', 'en' => 'He lets me go.'],
                'vocab' => [
                    'Sleeve bearing' => ['id' => 'Bantalan lengan', 'pos' => '(n)'],
                    'Let' => ['id' => 'Membiarkan', 'pos' => '(v)'],
                    'Piston' => ['id' => 'Piston', 'pos' => '(n)'],
                    'Move' => ['id' => 'Bergerak', 'pos' => '(v)']
                ]
            ],
            3 => [
                'id' => 'Seorang penyanyi opera diwajibkan memiliki sebuah suara yang kuat dan indah.',
                'en' => 'An opera singer is required to have a strong and beautiful voice',
                'example' => ['id' => 'Siswa diwajibkan mengerjakan tugas.', 'en' => 'Students are required to do homework.'],
                'vocab' => [
                    'Opera singer' => ['id' => 'Penyanyi opera', 'pos' => '(n)'],
                    'Required' => ['id' => 'Diwajibkan', 'pos' => '(v)'],
                    'Voice' => ['id' => 'Suara', 'pos' => '(n)'],
                    'Strong' => ['id' => 'Kuat', 'pos' => '(adj)']
                ]
            ],
            4 => [
                'id' => 'Pada abad 17, Wampanoag Indians mengajar para Pilgrim bagaimana untuk menumbuhkan jagung.',
                'en' => 'In the 17th century, Wampanoag Indians taught the Pilgrims how to grow corn',
                'example' => ['id' => 'Guru mengajar siswa cara membaca.', 'en' => 'Teachers teach students how to read.'],
                'vocab' => [
                    'Century' => ['id' => 'Abad', 'pos' => '(n)'],
                    'Teach' => ['id' => 'Mengajar', 'pos' => '(v)'],
                    'Pilgrim' => ['id' => 'Peziarah', 'pos' => '(n)'],
                    'Grow' => ['id' => 'Menumbuhkan', 'pos' => '(v)'],
                    'Corn' => ['id' => 'Jagung', 'pos' => '(n)']
                ]
            ],
            5 => [
                'id' => 'Kodok dan jenis tertentu dari burung menggunakan lidah mereka untuk menangkap serangga-serangga.',
                'en' => 'Frogs and certain types of birds use their tongues to catch insects',
                'example' => ['id' => 'Dia menggunakan alat untuk bekerja.', 'en' => 'He uses tools to work.'],
                'vocab' => [
                    'Frog' => ['id' => 'Kodok', 'pos' => '(n)'],
                    'Certain' => ['id' => 'Tertentu', 'pos' => '(adj)'],
                    'Tongue' => ['id' => 'Lidah', 'pos' => '(n)'],
                    'Catch' => ['id' => 'Menangkap', 'pos' => '(v)'],
                    'Insect' => ['id' => 'Serangga', 'pos' => '(n)']
                ]
            ],
            6 => [
                'id' => 'Modem mengijinkan (permit) komputer berkomunikasi satu dengan lainnya melalui jaringan telepon.',
                'en' => 'Modems permit computers to communicate with each other through telephone networks',
                'example' => ['id' => 'Aturan mengizinkan siswa keluar.', 'en' => 'Rules permit students to leave.'],
                'vocab' => [
                    'Modem' => ['id' => 'Modem', 'pos' => '(n)'],
                    'Permit' => ['id' => 'Mengizinkan', 'pos' => '(v)'],
                    'Communicate' => ['id' => 'Berkomunikasi', 'pos' => '(v)'],
                    'Network' => ['id' => 'Jaringan', 'pos' => '(n)']
                ]
            ],
            7 => [
                'id' => 'Bau bisa efektif di dalam stimuli sensory dalam membawa kembali ingatan.',
                'en' => 'Smell can be effective in sensory stimuli in bringing back memories',
                'example' => ['id' => 'Musik efektif dalam menenangkan pikiran.', 'en' => 'Music is effective in calming the mind.'],
                'vocab' => [
                    'Smell' => ['id' => 'Bau', 'pos' => '(n)'],
                    'Effective' => ['id' => 'Efektif', 'pos' => '(adj)'],
                    'Stimuli' => ['id' => 'Rangsangan', 'pos' => '(n)'],
                    'Memory' => ['id' => 'Ingatan', 'pos' => '(n)']
                ]
            ],
            8 => [
                'id' => 'Transplantasi lutut mengijinkan (allow) orang - orang dengan arthritis untuk menekuk lutut mereka secara mudah.',
                'en' => 'Knee transplants allow people with arthritis to bend their knees easily',
                'example' => ['id' => 'Teknologi memungkinkan kita bekerja cepat.', 'en' => 'Technology allows us to work fast.'],
                'vocab' => [
                    'Transplant' => ['id' => 'Transplantasi', 'pos' => '(n)'],
                    'Knee' => ['id' => 'Lutut', 'pos' => '(n)'],
                    'Allow' => ['id' => 'Mengizinkan', 'pos' => '(v)'],
                    'Arthritis' => ['id' => 'Radang sendi', 'pos' => '(n)'],
                    'Bend' => ['id' => 'Menekuk', 'pos' => '(v)']
                ]
            ],
            9 => [
                'id' => 'Sebuah suara yang tiba - tiba bisa membuat seorang pemain golf melewatkan sebuah tembakan.',
                'en' => 'A sudden sound can make a golf player miss a shot',
                'example' => ['id' => 'Kebisingan membuat saya kehilangan fokus.', 'en' => 'Noise makes me lose focus.'],
                'vocab' => [
                    'Sudden' => ['id' => 'Tiba-tiba', 'pos' => '(adj)'],
                    'Sound' => ['id' => 'Suara', 'pos' => '(n)'],
                    'Make' => ['id' => 'Membuat', 'pos' => '(v)'],
                    'Miss' => ['id' => 'Melewatkan', 'pos' => '(v)'],
                    'Shot' => ['id' => 'Tembakan', 'pos' => '(n)']
                ]
            ],
            10 => [
                'id' => 'Salju musim semi yang berat mungkin menyebabkan cabang - cabang dari pohon untuk patah.',
                'en' => 'Heavy spring snow might cause tree branches to break',
                'example' => ['id' => 'Hujan menyebabkan jalan menjadi licin.', 'en' => 'Rain causes roads to be slippery.'],
                'vocab' => [
                    'Heavy' => ['id' => 'Berat', 'pos' => '(adj)'],
                    'Spring' => ['id' => 'Musim semi', 'pos' => '(n)'],
                    'Snow' => ['id' => 'Salju', 'pos' => '(n)'],
                    'Cause' => ['id' => 'Menyebabkan', 'pos' => '(v)'],
                    'Branch' => ['id' => 'Cabang', 'pos' => '(n)'],
                    'Break' => ['id' => 'Patah', 'pos' => '(v)']
                ]
            ],
            11 => [
                'id' => 'Wadah bahan bakar di mobil balap modern mustahil untuk di tusuk.',
                'en' => 'The fuel container in modern race cars is impossible to puncture',
                'example' => ['id' => 'Soal ini mustahil untuk dijawab.', 'en' => 'This question is impossible to answer.'],
                'vocab' => [
                    'Fuel' => ['id' => 'Bahan bakar', 'pos' => '(n)'],
                    'Container' => ['id' => 'Wadah', 'pos' => '(n)'],
                    'Race car' => ['id' => 'Mobil balap', 'pos' => '(n)'],
                    'Impossible' => ['id' => 'Mustahil', 'pos' => '(adj)'],
                    'Puncture' => ['id' => 'Menusuk', 'pos' => '(v)']
                ]
            ],
        ];

        $toInfinitive = [
            1 => [
                'id' => 'Masyarakat perlu untuk mempertimbangkan perlindungan lingkungan.',
                'en' => 'Society needs to consider nature protection',
                'example' => ['id' => 'Dia perlu untuk tidur.', 'en' => 'He needs to sleep.'],
                'vocab' => [
                    'Society' => ['id' => 'Masyarakat', 'pos' => '(n)'],
                    'Need' => ['id' => 'Perlu', 'pos' => '(v)'],
                    'Consider' => ['id' => 'Mempertimbangkan', 'pos' => '(v)'],
                    'Protection' => ['id' => 'Perlindungan', 'pos' => '(n)']
                ]
            ],
            2 => [
                'id' => 'Kebutuhan untuk meningkatkan kesejahteraan adalah penting.',
                'en' => 'The need to improve welfare is important',
                'example' => ['id' => 'Kebutuhan untuk makan.', 'en' => 'The need to eat.'],
                'vocab' => [
                    'Need' => ['id' => 'Kebutuhan', 'pos' => '(n)'],
                    'Improve' => ['id' => 'Meningkatkan', 'pos' => '(v)'],
                    'Welfare' => ['id' => 'Kesejahteraan', 'pos' => '(n)'],
                    'Important' => ['id' => 'Penting', 'pos' => '(adj)']
                ]
            ],
            3 => [
                'id' => 'Hukum ini dibuat untuk menjamin kebebasan berpendapat.',
                'en' => 'This law is made to guarantee freedom of speech',
                'example' => ['id' => 'Ini dibuat untuk membantu.', 'en' => 'This is made to help.'],
                'vocab' => [
                    'Law' => ['id' => 'Hukum', 'pos' => '(n)'],
                    'Made' => ['id' => 'Dibuat', 'pos' => '(v)'],
                    'Guarantee' => ['id' => 'Menjamin', 'pos' => '(v)'],
                    'Freedom' => ['id' => 'Kebebasan', 'pos' => '(n)']
                ]
            ],
            4 => [
                'id' => 'Pesawat luar angkasa ini dikirim untuk menjelajahi Merkurius.',
                'en' => 'This spacecraft is sent to explore Mercury',
                'example' => ['id' => 'Dia dikirim untuk belajar.', 'en' => 'He is sent to study.'],
                'vocab' => [
                    'Spacecraft' => ['id' => 'Pesawat luar angkasa', 'pos' => '(n)'],
                    'Sent' => ['id' => 'Dikirim', 'pos' => '(v)'],
                    'Explore' => ['id' => 'Menjelajahi', 'pos' => '(v)'],
                    'Mercury' => ['id' => 'Merkurius', 'pos' => '(n)']
                ]
            ],
            5 => [
                'id' => 'Masyarakat meminta kepada pemerintah untuk dilindungi dari krisis global.',
                'en' => 'Society asks the government to be protected from global crises',
                'example' => ['id' => 'Dia meminta untuk dibantu.', 'en' => 'He asks to be helped.'],
                'vocab' => [
                    'Ask' => ['id' => 'Meminta', 'pos' => '(v)'],
                    'Government' => ['id' => 'Pemerintah', 'pos' => '(n)'],
                    'Protected' => ['id' => 'Dilindungi', 'pos' => '(v)'],
                    'Crisis' => ['id' => 'Krisis', 'pos' => '(n)']
                ]
            ],
            6 => [
                'id' => 'Sumber daya alam perlu untuk dikelola secara bijak.',
                'en' => 'Natural resources need to be managed wisely',
                'example' => ['id' => 'Ini perlu untuk diperbaiki.', 'en' => 'This needs to be fixed.'],
                'vocab' => [
                    'Natural resources' => ['id' => 'Sumber daya alam', 'pos' => '(n)'],
                    'Need' => ['id' => 'Perlu', 'pos' => '(v)'],
                    'Managed' => ['id' => 'Dikelola', 'pos' => '(v)'],
                    'Wisely' => ['id' => 'Secara bijak', 'pos' => '(adv)']
                ]
            ],
            7 => [
                'id' => 'Kucing hutan diajukan untuk dimasukkan ke dalam daftar hewan langka.',
                'en' => 'Wild cats are proposed to be included in the list of rare animals',
                'example' => ['id' => 'Dia diajukan untuk dipilih.', 'en' => 'He is proposed to be chosen.'],
                'vocab' => [
                    'Wild cat' => ['id' => 'Kucing hutan', 'pos' => '(n)'],
                    'Proposed' => ['id' => 'Diajukan', 'pos' => '(v)'],
                    'Included' => ['id' => 'Dimasukkan', 'pos' => '(v)'],
                    'Rare' => ['id' => 'Langka', 'pos' => '(adj)']
                ]
            ],
            8 => [
                'id' => 'Masalah air bersih perlu dibahas di dalam pertemuan global selanjutnya.',
                'en' => 'Clean water issues need to be discussed in the next global meeting',
                'example' => ['id' => 'Ini perlu dibahas.', 'en' => 'This needs to be discussed.'],
                'vocab' => [
                    'Issue' => ['id' => 'Masalah', 'pos' => '(n)'],
                    'Clean water' => ['id' => 'Air bersih', 'pos' => '(n)'],
                    'Discussed' => ['id' => 'Dibahas', 'pos' => '(v)'],
                    'Meeting' => ['id' => 'Pertemuan', 'pos' => '(n)']
                ]
            ],
            9 => [
                'id' => 'Pemerintah perlu untuk berhati - hati dalam hal ini.',
                'en' => 'The government needs to be careful in this matter',
                'example' => ['id' => 'Kamu perlu untuk berhati-hati.', 'en' => 'You need to be careful.'],
                'vocab' => [
                    'Government' => ['id' => 'Pemerintah', 'pos' => '(n)'],
                    'Need' => ['id' => 'Perlu', 'pos' => '(v)'],
                    'Careful' => ['id' => 'Berhati-hati', 'pos' => '(adj)'],
                    'Matter' => ['id' => 'Hal', 'pos' => '(n)']
                ]
            ],
            10 => [
                'id' => 'Generasi muda ingin untuk menjadi mandiri.',
                'en' => 'The younger generation wants to be independent',
                'example' => ['id' => 'Dia ingin untuk menjadi dokter.', 'en' => 'He wants to be a doctor.'],
                'vocab' => [
                    'Generation' => ['id' => 'Generasi', 'pos' => '(n)'],
                    'Young' => ['id' => 'Muda', 'pos' => '(adj)'],
                    'Want' => ['id' => 'Ingin', 'pos' => '(v)'],
                    'Independent' => ['id' => 'Mandiri', 'pos' => '(adj)']
                ]
            ],
            11 => [
                'id' => 'Perusahaan tidak diminta untuk ceroboh dalam hal ini.',
                'en' => 'Companies are not asked to be careless in this matter',
                'example' => ['id' => 'Dia tidak diminta untuk datang.', 'en' => 'He is not asked to come.'],
                'vocab' => [
                    'Company' => ['id' => 'Perusahaan', 'pos' => '(n)'],
                    'Asked' => ['id' => 'Diminta', 'pos' => '(v)'],
                    'Careless' => ['id' => 'Ceroboh', 'pos' => '(adj)'],
                    'Matter' => ['id' => 'Hal', 'pos' => '(n)']
                ]
            ],
            12 => [
                'id' => 'Pemerintah mewajibkan perusahaan untuk bertanggung jawab atas limbah mereka.',
                'en' => 'The government requires companies to be responsible for their waste',
                'example' => ['id' => 'Sekolah mewajibkan siswa untuk hadir.', 'en' => 'Schools require students to attend.'],
                'vocab' => [
                    'Government' => ['id' => 'Pemerintah', 'pos' => '(n)'],
                    'Require' => ['id' => 'Mewajibkan', 'pos' => '(v)'],
                    'Responsible' => ['id' => 'Bertanggung jawab', 'pos' => '(adj)'],
                    'Waste' => ['id' => 'Limbah', 'pos' => '(n)']
                ]
            ]
        ];

        $gerund = [
            1 => [
                'id' => 'Menciptakan lapangan pekerjaan adalah salah satu tugas utama pemerintah.',
                'en' => 'Creating job opportunities is one of the government\'s main tasks',
                'example' => ['id' => 'Berenang adalah hobi saya.', 'en' => 'Swimming is my hobby.'],
                'vocab' => [
                    'Create' => ['id' => 'Menciptakan', 'pos' => '(v)'],
                    'Job opportunity' => ['id' => 'Lapangan pekerjaan', 'pos' => '(n)'],
                    'Task' => ['id' => 'Tugas', 'pos' => '(n)'],
                    'Government' => ['id' => 'Pemerintah', 'pos' => '(n)']
                ]
            ],
            2 => [
                'id' => 'Mengendalikan laju inflasi membutuhkan banyak strategi.',
                'en' => 'Controlling the inflation rate requires many strategies',
                'example' => ['id' => 'Membaca membutuhkan waktu.', 'en' => 'Reading requires time.'],
                'vocab' => [
                    'Control' => ['id' => 'Mengendalikan', 'pos' => '(v)'],
                    'Inflation rate' => ['id' => 'Laju inflasi', 'pos' => '(n)'],
                    'Require' => ['id' => 'Membutuhkan', 'pos' => '(v)'],
                    'Strategy' => ['id' => 'Strategi', 'pos' => '(n)']
                ]
            ],
            3 => [
                'id' => 'Melindungi satwa liar tidak harus in situ.',
                'en' => 'Protecting wildlife does not have to be in situ',
                'example' => ['id' => 'Belajar tidak harus membosankan.', 'en' => 'Learning does not have to be boring.'],
                'vocab' => [
                    'Protect' => ['id' => 'Melindungi', 'pos' => '(v)'],
                    'Wildlife' => ['id' => 'Satwa liar', 'pos' => '(n)'],
                    'In situ' => ['id' => 'Di tempat asli', 'pos' => '(adv)']
                ]
            ],
            4 => [
                'id' => 'Tugas manusia adalah melestarikan alam untuk generasi mendatang.',
                'en' => 'Human duty is preserving nature for future generations',
                'example' => ['id' => 'Tugasku adalah belajar.', 'en' => 'My duty is studying.'],
                'vocab' => [
                    'Duty' => ['id' => 'Tugas', 'pos' => '(n)'],
                    'Preserve' => ['id' => 'Melestarikan', 'pos' => '(v)'],
                    'Nature' => ['id' => 'Alam', 'pos' => '(n)'],
                    'Generation' => ['id' => 'Generasi', 'pos' => '(n)']
                ]
            ],
            5 => [
                'id' => 'Menjadi inovatif memerlukan keterbukaan kepada ide baru. (nominal)',
                'en' => 'Being innovative requires openness to new ideas',
                'example' => ['id' => 'Menjadi pintar memerlukan belajar.', 'en' => 'Being smart requires studying.'],
                'vocab' => [
                    'Innovative' => ['id' => 'Inovatif', 'pos' => '(adj)'],
                    'Require' => ['id' => 'Memerlukan', 'pos' => '(v)'],
                    'Openness' => ['id' => 'Keterbukaan', 'pos' => '(n)'],
                    'Idea' => ['id' => 'Ide', 'pos' => '(n)']
                ]
            ],
            6 => [
                'id' => 'Menjadi sadar terhadap kerusakan lingkungan adalah misi dari organisasi ini. (nominal)',
                'en' => 'Being aware of environmental damage is the mission of this organization',
                'example' => ['id' => 'Menjadi sehat adalah tujuan.', 'en' => 'Being healthy is the goal.'],
                'vocab' => [
                    'Aware' => ['id' => 'Sadar', 'pos' => '(adj)'],
                    'Damage' => ['id' => 'Kerusakan', 'pos' => '(n)'],
                    'Environment' => ['id' => 'Lingkungan', 'pos' => '(n)'],
                    'Mission' => ['id' => 'Misi', 'pos' => '(n)']
                ]
            ],
            7 => [
                'id' => 'Menjadi bagian dari organisasi ini memberi anak muda kesempatan untuk berkontribusi. (nominal)',
                'en' => 'Being part of this organization gives young people the opportunity to contribute',
                'example' => ['id' => 'Menjadi anggota memberimu akses.', 'en' => 'Being a member gives you access.'],
                'vocab' => [
                    'Part' => ['id' => 'Bagian', 'pos' => '(n)'],
                    'Organization' => ['id' => 'Organisasi', 'pos' => '(n)'],
                    'Opportunity' => ['id' => 'Kesempatan', 'pos' => '(n)'],
                    'Contribute' => ['id' => 'Berkontribusi', 'pos' => '(v)']
                ]
            ],
            8 => [
                'id' => 'Menjadi sehat adalah hal utama. (nominal)',
                'en' => 'Being healthy is the main thing',
                'example' => ['id' => 'Menjadi bahagia adalah penting.', 'en' => 'Being happy is important.'],
                'vocab' => [
                    'Healthy' => ['id' => 'Sehat', 'pos' => '(adj)'],
                    'Main' => ['id' => 'Utama', 'pos' => '(adj)'],
                    'Thing' => ['id' => 'Hal', 'pos' => '(n)']
                ]
            ],
            9 => [
                'id' => 'Dikembangkan di laboratorium membuat virus ini berbahaya.',
                'en' => 'Being developed in a laboratory makes this virus dangerous',
                'example' => ['id' => 'Dibuat di rumah membuatnya spesial.', 'en' => 'Being made at home makes it special.'],
                'vocab' => [
                    'Developed' => ['id' => 'Dikembangkan', 'pos' => '(v)'],
                    'Laboratory' => ['id' => 'Laboratorium', 'pos' => '(n)'],
                    'Virus' => ['id' => 'Virus', 'pos' => '(n)'],
                    'Dangerous' => ['id' => 'Berbahaya', 'pos' => '(adj)']
                ]
            ],
            10 => [
                'id' => 'Banyak proyek beresiko ditinggalkan oleh pemerintah.',
                'en' => 'Many risky projects are abandoned by the government',
                'example' => ['id' => 'Rumah tua ditinggalkan.', 'en' => 'Old houses are abandoned.'],
                'vocab' => [
                    'Risky' => ['id' => 'Beresiko', 'pos' => '(adj)'],
                    'Project' => ['id' => 'Proyek', 'pos' => '(n)'],
                    'Abandoned' => ['id' => 'Ditinggalkan', 'pos' => '(v)'],
                    'Government' => ['id' => 'Pemerintah', 'pos' => '(n)']
                ]
            ],
            11 => [
                'id' => 'Sistem transportasi tua ini tetap digunakan oleh masyarakat.',
                'en' => 'This old transportation system is still used by society',
                'example' => ['id' => 'Metode lama masih digunakan.', 'en' => 'Old methods are still used.'],
                'vocab' => [
                    'Transportation system' => ['id' => 'Sistem transportasi', 'pos' => '(n)'],
                    'Old' => ['id' => 'Tua', 'pos' => '(adj)'],
                    'Used' => ['id' => 'Digunakan', 'pos' => '(v)'],
                    'Society' => ['id' => 'Masyarakat', 'pos' => '(n)']
                ]
            ],
            12 => [
                'id' => 'Organisasi ini berhenti dipercayai oleh masyarakat.',
                'en' => 'This organization stops being trusted by society',
                'example' => ['id' => 'Dia berhenti dicintai.', 'en' => 'He stops being loved.'],
                'vocab' => [
                    'Organization' => ['id' => 'Organisasi', 'pos' => '(n)'],
                    'Stop' => ['id' => 'Berhenti', 'pos' => '(v)'],
                    'Trusted' => ['id' => 'Dipercayai', 'pos' => '(v)'],
                    'Society' => ['id' => 'Masyarakat', 'pos' => '(n)']
                ]
            ],
            13 => [
                'id' => 'Negara - negara pasifik memulai membangun tembok laut.',
                'en' => 'Pacific countries start building sea walls',
                'example' => ['id' => 'Mereka memulai bekerja.', 'en' => 'They start working.'],
                'vocab' => [
                    'Pacific' => ['id' => 'Pasifik', 'pos' => '(adj)'],
                    'Country' => ['id' => 'Negara', 'pos' => '(n)'],
                    'Start' => ['id' => 'Memulai', 'pos' => '(v)'],
                    'Build' => ['id' => 'Membangun', 'pos' => '(v)'],
                    'Sea wall' => ['id' => 'Tembok laut', 'pos' => '(n)']
                ]
            ],
            14 => [
                'id' => 'NASA mencoba meluncurkan satelit.',
                'en' => 'NASA tries launching satellites',
                'example' => ['id' => 'Dia mencoba belajar.', 'en' => 'He tries learning.'],
                'vocab' => [
                    'NASA' => ['id' => 'NASA', 'pos' => '(n)'],
                    'Try' => ['id' => 'Mencoba', 'pos' => '(v)'],
                    'Launch' => ['id' => 'Meluncurkan', 'pos' => '(v)'],
                    'Satellite' => ['id' => 'Satelit', 'pos' => '(n)']
                ]
            ],
            15 => [
                'id' => 'Ilmuwan terus melakukan penelitian tentang perubahan iklim.',
                'en' => 'Scientists continue conducting research on climate change',
                'example' => ['id' => 'Dia terus belajar.', 'en' => 'He continues studying.'],
                'vocab' => [
                    'Scientist' => ['id' => 'Ilmuwan', 'pos' => '(n)'],
                    'Continue' => ['id' => 'Terus', 'pos' => '(v)'],
                    'Research' => ['id' => 'Penelitian', 'pos' => '(n)'],
                    'Climate change' => ['id' => 'Perubahan iklim', 'pos' => '(n)']
                ]
            ]
        ];

        $paragraph = [
            'id' => 'Melindungi lingkungan <strong>menjadi tanggung jawab</strong> semua orang. Banyak orang <strong>telah mulai menyadari</strong> pentingnya <strong>mengurangi penggunaan</strong> plastik. Pemerintah <strong>berusaha untuk mengembangkan</strong> kebijakan ramah lingkungan. Kami <strong>telah mempertimbangkan untuk menanam</strong> pohon sebagai bagian dari program sekolah. Beberapa relawan <strong>sedang mencoba mengurangi</strong> penggunaan masyarakat tentang limbah elektronik. Organisasi lingkungan <strong>terus mendorong</strong> masyarakat <strong>untuk mendaur ulang</strong> barang bekas. Menjaga kebersihan sungai <strong>adalah hal yang harus diprioritaskan</strong> oleh warga sekitar. Para ilmuwan <strong>telah memperingatkan untuk memperhatikan</strong> perubahan iklim bisa berdampak fatal. Kami <strong>berencana untuk mengadakan</strong> kampanye bersih-bersih setiap bulan. (ini tidak) tidak mudah <strong>menghentikan pencemaran</strong>, tetapi <strong>mencoba memperbaikinya</strong> adalah langkah penting.',
            'en' => 'Protecting the environment becomes everyone\'s responsibility. Many people have started to realize the importance of reducing plastic use. The government strives to develop environmentally friendly policies. We have considered planting trees as part of the school program. Some volunteers are trying to reduce society\'s use of electronic waste. Environmental organizations continue to encourage society to recycle used goods. Maintaining river cleanliness is something that must be prioritized by local residents. Scientists have warned to pay attention to climate change can be fatal. We plan to hold clean-up campaigns every month. (this is not) not easy to stop pollution, but trying to improve it is an important step.',
            'vocab' => [
                'Protect' => ['id' => 'Melindungi', 'pos' => '(v)'],
                'Environment' => ['id' => 'Lingkungan', 'pos' => '(n)'],
                'Responsibility' => ['id' => 'Tanggung jawab', 'pos' => '(n)'],
                'Realize' => ['id' => 'Menyadari', 'pos' => '(v)'],
                'Importance' => ['id' => 'Pentingnya', 'pos' => '(n)'],
                'Reducing' => ['id' => 'Mengurangi', 'pos' => '(v)'],
                'Policy' => ['id' => 'Kebijakan', 'pos' => '(n)'],
                'Tree' => ['id' => 'Pohon', 'pos' => '(n)'],
                'Volunteer' => ['id' => 'Relawan', 'pos' => '(n)'],
                'Electronic waste' => ['id' => 'Limbah elektronik', 'pos' => '(n)'],
                'Recycle' => ['id' => 'Mendaur ulang', 'pos' => '(v)'],
                'Goods' => ['id' => 'Barang', 'pos' => '(n)'],
                'Prioritized' => ['id' => 'Diprioritaskan', 'pos' => '(v)'],
                'Resident' => ['id' => 'Warga', 'pos' => '(n)'],
                'Climate change' => ['id' => 'Perubahan iklim', 'pos' => '(n)'],
                'Fetal' => ['id' => 'Fatal', 'pos' => '(adj)'],
                'Campaign' => ['id' => 'Kampanye', 'pos' => '(n)'],
                'Pollution' => ['id' => 'Pencemaran', 'pos' => '(n)'],
                'Step' => ['id' => 'Langkah', 'pos' => '(n)']
            ]
        ];

        // 3. Insert Verb Patterns
        foreach ($verbPatterns as $idx => $data) {
            GrammarQuestion::create([
                'meeting_number' => 6,
                'section' => 'verb_patterns',
                'question_number' => $idx,
                'question_text' => $data['id'],
                'correct_answer' => $data['en'],
                'example' => $data['example'] ?? null,
                'vocab' => $data['vocab'] ?? []
            ]);
        }

        // 4. Insert To Infinitive
        foreach ($toInfinitive as $idx => $data) {
            GrammarQuestion::create([
                'meeting_number' => 6,
                'section' => 'to_infinitive',
                'question_number' => $idx,
                'question_text' => $data['id'],
                'correct_answer' => $data['en'],
                'example' => $data['example'] ?? null,
                'vocab' => $data['vocab'] ?? []
            ]);
        }

        // 5. Insert Gerund
        foreach ($gerund as $idx => $data) {
            GrammarQuestion::create([
                'meeting_number' => 6,
                'section' => 'gerund',
                'question_number' => $idx,
                'question_text' => $data['id'],
                'correct_answer' => $data['en'],
                'example' => $data['example'] ?? null,
                'vocab' => $data['vocab'] ?? []
            ]);
        }

        // 6. Insert Paragraph
        GrammarQuestion::create([
            'meeting_number' => 6,
            'section' => 'paragraph',
            'question_number' => 1,
            'question_text' => $paragraph['id'],
            'correct_answer' => $paragraph['en'],
            'vocab' => $paragraph['vocab'] ?? []
        ]);

        $this->command->info('Meeting 6 data migrated successfully!');
    }
}
