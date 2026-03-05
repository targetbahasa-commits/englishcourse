<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\GrammarQuestion;

class Meeting3Seeder extends Seeder
{
    public function run()
    {
        DB::transaction(function () {
            // Clear existing Meeting 3 data to avoid duplicates if re-run
            GrammarQuestion::where('meeting_number', 3)->delete();

            // 1. Sentences Data
            $questions = [
                1 => [
                    'id' => 'Tempat penyimpanan air telah dibangun di desa ini.', 
                    'en' => 'Water storage has been built in this village', 
                    'tense' => 'Present Perfect Passive',
                    'vocab' => [
                        'Water' => ['id' => 'Air', 'pos' => '(n)'],
                        'Storage' => ['id' => 'Penyimpanan', 'pos' => '(n)'],
                        'Village' => ['id' => 'Desa', 'pos' => '(n)']
                    ]
                ],
                2 => [
                    'id' => 'Kemerdekaan Indonesia ada pada tanggal 17 agustus 1945.', 
                    'en' => 'Indonesia\'s independence was on August 17, 1945', 
                    'tense' => 'Simple Past Nominal',
                    'vocab' => [
                        'Independence' => ['id' => 'Kemerdekaan', 'pos' => '(n)'],
                        'August' => ['id' => 'Agustus', 'pos' => '(n)']
                    ]
                ],
                3 => [
                    'id' => 'Pembangunan daerah membantu perekonomian lokal.', 
                    'en' => 'Regional development helps the local economy', 
                    'tense' => 'Simple Present Verbal',
                    'vocab' => [
                        'Regional' => ['id' => 'Daerah', 'pos' => '(adj)'],
                        'Development' => ['id' => 'Pembangunan', 'pos' => '(n)'],
                        'Help' => ['id' => 'Membantu', 'pos' => '(v)'],
                        'Local' => ['id' => 'Lokal', 'pos' => '(adj)'],
                        'Economy' => ['id' => 'Perekonomian', 'pos' => '(n)']
                    ]
                ],
                4 => [
                    'id' => 'Pemanasan global sedang dibicarakan oleh seluruh orang di dunia.', 
                    'en' => 'Global warming is being discussed by everyone in the world', 
                    'tense' => 'Present Continuous Passive',
                    'vocab' => [
                        'Global warming' => ['id' => 'Pemanasan global', 'pos' => '(n)'],
                        'Discuss' => ['id' => 'Membicarakan', 'pos' => '(v)'],
                        'Everyone' => ['id' => 'Seluruh orang', 'pos' => '(pron)'],
                        'World' => ['id' => 'Dunia', 'pos' => '(n)']
                    ]
                ],
                5 => [
                    'id' => 'Laut adalah tempat dari banyak mineral di Bumi.', 
                    'en' => 'The ocean is the place of many minerals on Earth', 
                    'tense' => 'Simple Present Nominal',
                    'vocab' => [
                        'Ocean' => ['id' => 'Laut', 'pos' => '(n)'],
                        'Place' => ['id' => 'Tempat', 'pos' => '(n)'],
                        'Many' => ['id' => 'Banyak', 'pos' => '(adj)'],
                        'Mineral' => ['id' => 'Mineral', 'pos' => '(n)'],
                        'Earth' => ['id' => 'Bumi', 'pos' => '(n)']
                    ]
                ],
                6 => [
                    'id' => 'Banyak kebijakan telah diterapkan untuk melindungi satwa liar.', 
                    'en' => 'Many policies have been implemented to protect wildlife', 
                    'tense' => 'Present Perfect Passive',
                    'vocab' => [
                        'Many' => ['id' => 'Banyak', 'pos' => '(adj)'],
                        'Policy' => ['id' => 'Kebijakan', 'pos' => '(n)'],
                        'Implement' => ['id' => 'Menerapkan', 'pos' => '(v)'],
                        'Protect' => ['id' => 'Melindungi', 'pos' => '(v)'],
                        'Wildlife' => ['id' => 'Satwa liar', 'pos' => '(n)']
                    ]
                ],
                7 => [
                    'id' => 'Pendidikan adalah kunci untuk masa depan yang lebih baik.', 
                    'en' => 'Education is the key to a better future', 
                    'tense' => 'Simple Present Nominal',
                    'vocab' => [
                        'Education' => ['id' => 'Pendidikan', 'pos' => '(n)'],
                        'Key' => ['id' => 'Kunci', 'pos' => '(n)'],
                        'Future' => ['id' => 'Masa depan', 'pos' => '(n)'],
                        'Better' => ['id' => 'Lebih baik', 'pos' => '(adj)']
                    ]
                ],
                8 => [
                    'id' => 'Mereka sedang mendiskusikan rencana proyek baru.', 
                    'en' => 'They are discussing the new project plan', 
                    'tense' => 'Present Continuous Verbal',
                    'vocab' => [
                        'Discuss' => ['id' => 'Mendiskusikan', 'pos' => '(v)'],
                        'Plan' => ['id' => 'Rencana', 'pos' => '(n)'],
                        'Project' => ['id' => 'Proyek', 'pos' => '(n)'],
                        'New' => ['id' => 'Baru', 'pos' => '(adj)']
                    ]
                ],
                9 => [
                    'id' => 'Teknologi telah mengubah cara kita berkomunikasi.', 
                    'en' => 'Technology has changed the way we communicate', 
                    'tense' => 'Present Perfect Verbal',
                    'vocab' => [
                        'Technology' => ['id' => 'Teknologi', 'pos' => '(n)'],
                        'Change' => ['id' => 'Mengubah', 'pos' => '(v)'],
                        'Way' => ['id' => 'Cara', 'pos' => '(n)'],
                        'Communicate' => ['id' => 'Berkomunikasi', 'pos' => '(v)']
                    ]
                ],
                10 => [
                    'id' => 'Gunung krakatau akan menjadi lebih tinggi.', 
                    'en' => 'Mount Krakatoa will become higher', 
                    'tense' => 'Simple Future Verbal',
                    'vocab' => [
                        'Mount' => ['id' => 'Gunung', 'pos' => '(n)'],
                        'Become' => ['id' => 'Menjadi', 'pos' => '(v)'],
                        'Higher' => ['id' => 'Lebih tinggi', 'pos' => '(adj)']
                    ]
                ],
                11 => [
                    'id' => 'Apollo 11 mendarat di bulan 50 tahun lalu.', 
                    'en' => 'Apollo 11 landed on the moon 50 years ago', 
                    'tense' => 'Simple Past Verbal',
                    'vocab' => [
                        'Land' => ['id' => 'Mendarat', 'pos' => '(v)'],
                        'Moon' => ['id' => 'Bulan', 'pos' => '(n)'],
                        'Ago' => ['id' => 'Lalu/Yang lalu', 'pos' => '(adv)']
                    ]
                ],
                12 => [
                    'id' => 'Pertanian telah berkembang di Asia sebelum di America.', 
                    'en' => 'Agriculture had developed in Asia before in America', 
                    'tense' => 'Past Perfect Verbal',
                    'vocab' => [
                        'Agriculture' => ['id' => 'Pertanian', 'pos' => '(n)'],
                        'Develop' => ['id' => 'Berkembang', 'pos' => '(v)'],
                        'Before' => ['id' => 'Sebelum', 'pos' => '(prep)']
                    ]
                ],
                13 => [
                    'id' => 'Pembangunan negara telah sedang diwujudkan saat ini.', 
                    'en' => 'National development has been being realized at this moment', 
                    'tense' => 'Present Perfect Continuous Passive',
                    'vocab' => [
                        'National' => ['id' => 'Negara', 'pos' => '(adj)'],
                        'Development' => ['id' => 'Pembangunan', 'pos' => '(n)'],
                        'Realize' => ['id' => 'Mewujudkan', 'pos' => '(v)'],
                        'Moment' => ['id' => 'Saat', 'pos' => '(n)']
                    ]
                ],
                14 => [
                    'id' => 'Kami akan mengimplementasikan kebijakan baru bulan depan.', 
                    'en' => 'We will implement the new policy next month', 
                    'tense' => 'Simple Future Verbal',
                    'vocab' => [
                        'Implement' => ['id' => 'Mengimplementasikan', 'pos' => '(v)'],
                        'Policy' => ['id' => 'Kebijakan', 'pos' => '(n)'],
                        'Next month' => ['id' => 'Bulan depan', 'pos' => '(adv)']
                    ]
                ],
                15 => [
                    'id' => 'Anak-anak itu bermain di taman setiap sore.', 
                    'en' => 'Those children play in the park every afternoon', 
                    'tense' => 'Simple Present Verbal',
                    'vocab' => [
                        'Children' => ['id' => 'Anak-anak', 'pos' => '(n)'],
                        'Play' => ['id' => 'Bermain', 'pos' => '(v)'],
                        'Park' => ['id' => 'Taman', 'pos' => '(n)'],
                        'Every afternoon' => ['id' => 'Setiap sore', 'pos' => '(adv)']
                    ]
                ],
                16 => [
                    'id' => 'Peraturan harus diikuti secara ketat.', 
                    'en' => 'Regulations must be followed strictly', 
                    'tense' => 'Modal Passive',
                    'vocab' => [
                        'Regulation' => ['id' => 'Peraturan', 'pos' => '(n)'],
                        'Must' => ['id' => 'Harus', 'pos' => '(modal)'],
                        'Follow' => ['id' => 'Mengikuti', 'pos' => '(v)'],
                        'Strictly' => ['id' => 'Secara ketat', 'pos' => '(adv)']
                    ]
                ],
                17 => [
                    'id' => 'Pemerintah sedang ceroboh dalam kebijakan ini.', 
                    'en' => 'The government is being careless in this policy', 
                    'tense' => 'Present Continuous Nominal',
                    'vocab' => [
                        'Government' => ['id' => 'Pemerintah', 'pos' => '(n)'],
                        'Careless' => ['id' => 'Ceroboh', 'pos' => '(adj)'],
                        'Policy' => ['id' => 'Kebijakan', 'pos' => '(n)']
                    ]
                ],
                18 => [
                    'id' => 'Kerusakan ekosistem bisa menyebabkan kerusakan ekonomi.', 
                    'en' => 'Ecosystem damage can cause economic damage', 
                    'tense' => 'Modal Present',
                    'vocab' => [
                        'Ecosystem' => ['id' => 'Ekosistem', 'pos' => '(n)'],
                        'Damage' => ['id' => 'Kerusakan', 'pos' => '(n)'],
                        'Can' => ['id' => 'Bisa', 'pos' => '(modal)'],
                        'Cause' => ['id' => 'Menyebabkan', 'pos' => '(v)'],
                        'Economic' => ['id' => 'Ekonomi', 'pos' => '(adj)']
                    ]
                ],
                19 => [
                    'id' => 'Iklim global telah dipengaruhi oleh aktivitas manusia selama 1 abad ini.', 
                    'en' => 'Global climate has been influenced by human activity for this century', 
                    'tense' => 'Present Perfect Passive',
                    'vocab' => [
                        'Global' => ['id' => 'Global', 'pos' => '(adj)'],
                        'Climate' => ['id' => 'Iklim', 'pos' => '(n)'],
                        'Influence' => ['id' => 'Mempengaruhi', 'pos' => '(v)'],
                        'Human' => ['id' => 'Manusia', 'pos' => '(n)'],
                        'Activity' => ['id' => 'Aktivitas', 'pos' => '(n)'],
                        'Century' => ['id' => 'Abad', 'pos' => '(n)']
                    ]
                ],
                20 => [
                    'id' => 'Populasi Asia telah berada nomor 1 di dunia selama berabad - abad.', 
                    'en' => 'Asia\'s population has been number 1 in the world for centuries', 
                    'tense' => 'Present Perfect Nominal',
                    'vocab' => [
                        'Population' => ['id' => 'Populasi', 'pos' => '(n)'],
                        'Number' => ['id' => 'Nomor', 'pos' => '(n)'],
                        'World' => ['id' => 'Dunia', 'pos' => '(n)'],
                        'Centuries' => ['id' => 'Berabad-abad', 'pos' => '(n)']
                    ]
                ]
            ];

            foreach ($questions as $idx => $q) {
                GrammarQuestion::create([
                    'meeting_number' => 3,
                    'section' => 'sentences',
                    'question_number' => $idx,
                    'question_text' => $q['id'],
                    'correct_answer' => $q['en'],
                    'tense' => $q['tense'],
                    'vocab' => $q['vocab']
                ]);
            }

            // 2. Paragraph Data
            $paragraph = [
                'id' => 'Polusi plastik merusak lingkungan setiap hari. Sampah plastik sedang mencemari lautan di seluruh dunia. Para ilmuwan telah menemukan mikroplastik dalam tubuh hewan laut. Banyak komunitas telah lama memperingatkan bahaya plastik sekali pakai. Larangan penggunaan kantong plastik dapat mengurangi jumlah sampah di tempat umum. Botol plastik bekas didaur ulang oleh beberapa perusahaan ramah lingkungan. Pada masa lalu, masyarakat kurang menyadari dampak jangka panjang limbah plastik. Anak-anak sekolah sedang diajari tentang pentingnya pengelolaan sampah. Masalah polusi plastik adalah ancaman serius bagi keberlanjutan bumi. Tahun depan, pemerintah akan memberlakukan regulasi baru tentang penggunaan plastik. Program pengurangan plastik akan sedang dilaksanakan di berbagai kota besar. Para aktivis lingkungan akan telah mengorganisir kampanye global dalam beberapa bulan mendatang. Upaya global harus difokuskan pada solusi jangka panjang. Negara-negara berkembang bisa mengalami kesulitan dalam menerapkan kebijakan ramah lingkungan. Organisasi internasional telah lama berusaha menyatukan negara-negara untuk mengatasi krisis ini. Edukasi sejak dini merupakan kunci dalam mengubah kebiasaan konsumen. Pada masa lalu, penggunaan plastik adalah simbol kemajuan dan kemudahan. Jika tidak dikendalikan, polusi plastik akan menjadi bencana lingkungan yang lebih besar.',
                'en' => 'Plastic pollution damages the environment every day. Plastic waste is polluting oceans all over the world. Scientists have found microplastics in the bodies of marine animals. Many communities have long warned about the dangers of single-use plastic. The ban on plastic bags can reduce the amount of waste in public places. Used plastic bottles are recycled by several eco-friendly companies. In the past, society was less aware of the long-term impact of plastic waste. School children are being taught about the importance of waste management. The problem of plastic pollution is a serious threat to the earth\'s sustainability. Next year, the government will enforce new regulations on plastic use. Plastic reduction programs will be being implemented in various major cities. Environmental activists will have organized global campaigns in the coming months. Global efforts must be focused on long-term solutions. Developing countries could experience difficulties in implementing eco-friendly policies. International organizations have long been trying to unite countries to overcome this crisis. Early education is the key to changing consumer habits. In the past, plastic use was a symbol of progress and convenience. If not controlled, plastic pollution will become a greater environmental disaster.',
                 // Flattened Vocab
                'vocab' => [
                    'Sample' => ['id' => 'Contoh', 'pos' => '(n)'],
                    'Paragraph' => ['id' => 'Paragraf', 'pos' => '(n)'],
                    'Provide' => ['id' => 'Menyediakan', 'pos' => '(v)'],
                    'Translate' => ['id' => 'Menerjemahkan', 'pos' => '(v)'],
                    'Sentence' => ['id' => 'Kalimat', 'pos' => '(n)'],
                    'Plastic' => ['id' => 'Plastik', 'pos' => '(n)'],
                    'Pollution' => ['id' => 'Polusi', 'pos' => '(n)'],
                    'Damage' => ['id' => 'Merusak', 'pos' => '(v)'],
                    'Environment' => ['id' => 'Lingkungan', 'pos' => '(n)'],
                    'Waste' => ['id' => 'Sampah/Limbah', 'pos' => '(n)'],
                    'Pollute' => ['id' => 'Mencemari', 'pos' => '(v)'],
                    'Ocean' => ['id' => 'Lautan', 'pos' => '(n)'],
                    'Scientist' => ['id' => 'Ilmuwan', 'pos' => '(n)'],
                    'Found' => ['id' => 'Menemukan', 'pos' => '(v)'],
                    'Microplastic' => ['id' => 'Mikroplastik', 'pos' => '(n)'],
                    'Marine' => ['id' => 'Laut', 'pos' => '(adj)'],
                    'Community' => ['id' => 'Komunitas', 'pos' => '(n)'],
                    'Long' => ['id' => 'Lama', 'pos' => '(adv)'],
                    'Warn' => ['id' => 'Memperingatkan', 'pos' => '(v)'],
                    'Danger' => ['id' => 'Bahaya', 'pos' => '(n)'],
                    'Single-use' => ['id' => 'Sekali pakai', 'pos' => '(adj)'],
                    'Ban' => ['id' => 'Larangan', 'pos' => '(n)'],
                    'Use' => ['id' => 'Penggunaan', 'pos' => '(n)'],
                    'Bag' => ['id' => 'Kantong/Tas', 'pos' => '(n)'],
                    'Reduce' => ['id' => 'Mengurangi', 'pos' => '(v)'],
                    'Amount' => ['id' => 'Jumlah', 'pos' => '(n)'],
                    'Public' => ['id' => 'Umum', 'pos' => '(adj)'],
                    'Recycle' => ['id' => 'Mendaur ulang', 'pos' => '(v)'],
                    'Company' => ['id' => 'Perusahaan', 'pos' => '(n)'],
                    'Society' => ['id' => 'Masyarakat', 'pos' => '(n)'],
                    'Aware' => ['id' => 'Menyadari', 'pos' => '(adj)'],
                    'Impact' => ['id' => 'Dampak', 'pos' => '(n)'],
                    'School' => ['id' => 'Sekolah', 'pos' => '(n)'],
                    'Teach' => ['id' => 'Mengajar', 'pos' => '(v)'],
                    'Importance' => ['id' => 'Pentingnya', 'pos' => '(n)'],
                    'Management' => ['id' => 'Pengelolaan', 'pos' => '(n)'],
                    'Threat' => ['id' => 'Ancaman', 'pos' => '(n)'],
                    'Sustainability' => ['id' => 'Keberlanjutan', 'pos' => '(n)'],
                    'Government' => ['id' => 'Pemerintah', 'pos' => '(n)'],
                    'Enforce' => ['id' => 'Memberlakukan', 'pos' => '(v)'],
                    'Regulation' => ['id' => 'Regulasi', 'pos' => '(n)'],
                    'Program' => ['id' => 'Program', 'pos' => '(n)'],
                    'Reduction' => ['id' => 'Pengurangan', 'pos' => '(n)'],
                    'Implement' => ['id' => 'Melaksanakan', 'pos' => '(v)'],
                    'Various' => ['id' => 'Berbagai', 'pos' => '(adj)'],
                    'Activist' => ['id' => 'Aktivis', 'pos' => '(n)'],
                    'Organize' => ['id' => 'Mengorganisir', 'pos' => '(v)'],
                    'Campaign' => ['id' => 'Kampanye', 'pos' => '(n)'],
                    'Effort' => ['id' => 'Upaya', 'pos' => '(n)'],
                    'Focus' => ['id' => 'Memfokuskan', 'pos' => '(v)'],
                    'Solution' => ['id' => 'Solusi', 'pos' => '(n)'],
                    'Developing' => ['id' => 'Berkembang', 'pos' => '(adj)'],
                    'Experience' => ['id' => 'Mengalami', 'pos' => '(v)'],
                    'Difficulty' => ['id' => 'Kesulitan', 'pos' => '(n)'],
                    'Organization' => ['id' => 'Organisasi', 'pos' => '(n)'],
                    'Unite' => ['id' => 'Menyatukan', 'pos' => '(v)'],
                    'Overcome' => ['id' => 'Mengatasi', 'pos' => '(v)'],
                    'Crisis' => ['id' => 'Krisis', 'pos' => '(n)'],
                    'Education' => ['id' => 'Edukasi', 'pos' => '(n)'],
                    'Key' => ['id' => 'Kunci', 'pos' => '(n)'],
                    'Change' => ['id' => 'Mengubah', 'pos' => '(v)'],
                    'Habit' => ['id' => 'Kebiasaan', 'pos' => '(n)'],
                    'Symbol' => ['id' => 'Simbol', 'pos' => '(n)'],
                    'Progress' => ['id' => 'Kemajuan', 'pos' => '(n)'],
                    'Convenience' => ['id' => 'Kemudahan', 'pos' => '(n)'],
                    'Control' => ['id' => 'Mengendalikan', 'pos' => '(v)'],
                    'Become' => ['id' => 'Menjadi', 'pos' => '(v)'],
                    'Disaster' => ['id' => 'Bencana', 'pos' => '(n)']
                ]
            ];

            GrammarQuestion::create([
                'meeting_number' => 3,
                'section' => 'paragraph',
                'question_number' => 1,
                'question_text' => $paragraph['id'],
                'correct_answer' => $paragraph['en'],
                'vocab' => $paragraph['vocab']
            ]);
        });
    }
}
