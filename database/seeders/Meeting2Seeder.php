<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\GrammarQuestion;
use App\Models\GrammarVocabulary;
use Illuminate\Support\Facades\DB;

class Meeting2Seeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Data derived from AssignmentController
        $sentences = [
            1 => ['id' => 'Kita membangun dunia ini.', 'en' => 'We build this world', 'tense' => 'Simple Present', 'type' => 'verbal'],
            2 => ['id' => 'Dia (perempuan) menjadi pemimpin.', 'en' => 'She becomes a leader', 'tense' => 'Simple Present', 'type' => 'nominal']
        ];

        $matrix = [
            'Simple Present' => [
                'verbal' => ['id' => 'Bumi mengelilingi matahari.', 'en' => 'The earth orbits the sun'],
                'nominal' => ['id' => 'Perkembangan teknologi ini penting.', 'en' => 'This technological development is important'],
                'passive' => ['id' => 'Komputer dikendalikan oleh chip.', 'en' => 'Computers are controlled by chips']
            ],
            'Present Continuous' => [
                'verbal' => ['id' => 'Kita sedang menghadapi global warming.', 'en' => 'We are facing global warming'],
                'nominal' => ['id' => 'Pemerintah sedang berhati-hati.', 'en' => 'The government is being careful'],
                'passive' => ['id' => 'Sungai sedang dicemari oleh pabrik.', 'en' => 'Rivers are being polluted by factories']
            ],
            'Present Perfect' => [
                'verbal' => ['id' => 'Pemerintah sudah memberikan subsidi.', 'en' => 'The government has given subsidies'],
                'nominal' => ['id' => 'Tanggung jawab ini telah ada di pemerintah.', 'en' => 'This responsibility has been with the government'],
                'passive' => ['id' => 'Konservasi ini telah dibangun.', 'en' => 'This conservation has been built']
            ],
            'Present Perfect Continuous' => [
                'verbal' => ['id' => 'Pemanasan global telah sedang terjadi selama 30 tahun.', 'en' => 'Global warming has been happening for 30 years'],
                'nominal' => ['id' => 'Pemerintah sudah sedang berhati-hati.', 'en' => 'The government has been being careful'],
                'passive' => ['id' => 'Hutan sudah sedang dihancurkan.', 'en' => 'Forests have been being destroyed']
            ],
            'Simple Past' => [
                'verbal' => ['id' => 'Organisasi dunia bertemu 30 tahun yang lalu.', 'en' => 'World organizations met 30 years ago'],
                'nominal' => ['id' => 'Banyak hewan liar ada di Jawa dulu.', 'en' => 'Many wild animals were in Java in the past'],
                'passive' => ['id' => 'Perlindungan ini diberikan 10 tahun yang lalu.', 'en' => 'This protection was given 10 years ago']
            ],
            'Past Continuous' => [
                'verbal' => ['id' => 'Orang - orang sedang berburu dulu.', 'en' => 'People were hunting in the past'],
                'nominal' => ['id' => 'Pemerintah sedang berhati-hati dulu.', 'en' => 'The government was being careful in the past'],
                'passive' => ['id' => 'Industri sedang didorong pada waktu itu.', 'en' => 'Industry was being encouraged at that time']
            ],
            'Past Perfect' => [
                'verbal' => ['id' => 'Manusia telah mengembangkan pertanian 5000 tahun yang lalu.', 'en' => 'Humans had developed agriculture 5000 years ago'],
                'nominal' => ['id' => 'Manusia telah ada di Amerika Utara 7000 tahun yang lalu.', 'en' => 'Humans had been in North America 7000 years ago'],
                'passive' => ['id' => 'Pabrik - pabrik telah dibangun sebelum revolusi industri.', 'en' => 'Factories had been built before the industrial revolution']
            ],
            'Past Perfect Continuous' => [
                'verbal' => ['id' => 'Kepunahan dinosaurus telah terjadi sebelum tabrakan meteor.', 'en' => 'Dinosaur extinction had been happening before the meteor collision'],
                'nominal' => ['id' => 'Pemerintah telah sedang berhati-hati dulu.', 'en' => 'The government had been being careful in the past'],
                'passive' => ['id' => 'Mammoth telah diburu oleh manusia sebelum kepunahan mereka.', 'en' => 'Mammoths had been hunted by humans before their extinction']
            ],
            'Simple Future' => [
                'verbal' => ['id' => 'Dunia akan mengalami kegagalan panen.', 'en' => 'The world will experience crop failure'],
                'nominal' => ['id' => 'Banyak hewan akan punah.', 'en' => 'Many animals will be extinct'],
                'passive' => ['id' => 'Banyak ekosistem akan terpengaruh.', 'en' => 'Many ecosystems will be affected']
            ],
            'Future Continuous' => [
                'verbal' => ['id' => 'Dunia akan sedang berubah dalam 50 tahun.', 'en' => 'The world will be changing in 50 years'],
                'nominal' => ['id' => 'Pemerintah akan sedang berhati-hati.', 'en' => 'The government will be being careful'],
                'passive' => ['id' => 'Luar angkasa akan sedang dijelajahi dalam 300 tahun lagi', 'en' => 'Outer space will be being explored in 300 years']
            ],
            'Future Perfect' => [
                'verbal' => ['id' => 'Kerusakan lingkungan akan telah merusak 50% dari ekosistem dunia.', 'en' => 'Environmental damage will have destroyed 50% of the world\'s ecosystems'],
                'nominal' => ['id' => 'Banyak negara berkembang akan telah menjadi negara maju dalam 50 tahun lagi.', 'en' => 'Many developing countries will have become developed countries in 50 years'],
                'passive' => ['id' => 'DNA akan telah dipetakan 10 tahun lagi.', 'en' => 'DNA will have been mapped in 10 years']
            ],
            'Future Perfect Continuous' => [
                'verbal' => ['id' => 'Pemerintah akan telah sedang membangun proyek ini bulan depan.', 'en' => 'The government will have been building this project next month'],
                'nominal' => ['id' => 'Pemerintah akan telah sedang berhati - hati.', 'en' => 'The government will have been being careful'],
                'passive' => ['id' => 'Udara akan telah tercemar oleh polusi.', 'en' => 'The air will have been polluted by pollution']
            ],
            'Simple Past Future' => [
                'verbal' => ['id' => 'Hal ini akan merusak ekosistem.', 'en' => 'This would destroy the ecosystem'],
                'nominal' => ['id' => 'Masalah ini akan menjadi (nominal) masalah besar.', 'en' => 'This problem would be a big problem'],
                'passive' => ['id' => 'Bencana ini akan dihindari', 'en' => 'This disaster would be avoided']
            ],
            'Past Future Continuous' => [
                'verbal' => ['id' => 'Antartika akan sedang menghilang.', 'en' => 'Antarctica would be disappearing'],
                'nominal' => ['id' => 'Pemerintah akan sedang berhati-hati.', 'en' => 'The government would be being careful'],
                'passive' => ['id' => 'Bulan akan sedang ditambang.', 'en' => 'The moon would be being mined']
            ],
            'Past Future Perfect' => [
                'verbal' => ['id' => 'Teknologi ini akan telah berkembang.', 'en' => 'This technology would have developed'],
                'nominal' => ['id' => 'Manusia akan telah dalam harmoni.', 'en' => 'Humans would have been in harmony'],
                'passive' => ['id' => 'Perang di dunia akan telah dihentikan.', 'en' => 'Wars in the world would have been stopped']
            ],
            'Past Future Perfect Continuous' => [
                'verbal' => ['id' => 'Manusia akan telah berjalan di Mars.', 'en' => 'Humans would have been walking on Mars'],
                'nominal' => ['id' => 'Pemerintah akan telah sedang berhati-hati.', 'en' => 'The government would have been being careful'],
                'passive' => ['id' => 'Perdamaian dunia akan telah tercapai.', 'en' => 'World peace would have been achieved']
            ],
            'Modal' => [
                'verbal' => ['id' => 'Perusahaan harus memperhatikan lingkungan.', 'en' => 'Companies must pay attention to the environment'],
                'nominal' => ['id' => 'Hewan langka seharusnya ada di habitat terlindungi.', 'en' => 'Rare animals should be in protected habitats'],
                'passive' => ['id' => 'Air bisa dijaga dengan hati - hati.', 'en' => 'Water can be maintained carefully']
            ]
        ];
        
        // Examples Data
        $examples = [
            'Simple Present' => [
                'verbal' => ['id' => 'Bulan mengelilingi bumi.', 'en' => 'The moon orbits the earth.'],
                'nominal' => ['id' => 'Ini menjadi masalah.', 'en' => 'It becomes problem.'],
                'passive' => ['id' => 'Ruangan didinginkan oleh AC.', 'en' => 'The room is cooled by AC.']
            ],
            'Present Continuous' => [
                'verbal' => ['id' => 'Mereka sedang mendiskusikan rencana.', 'en' => 'They are discussing the plan.'],
                'nominal' => ['id' => 'Dia sedang sopan.', 'en' => 'He is being polite.'],
                'passive' => ['id' => 'Jalan sedang diperbaiki oleh pekerja.', 'en' => 'The road is being repaired by workers.']
            ],
            'Present Perfect' => [
                'verbal' => ['id' => 'Perusahaan sudah mengirimkan barang.', 'en' => 'The company has sent the goods.'],
                'nominal' => ['id' => 'Masalah ini telah ada di pikiran saya.', 'en' => 'This problem has been on my mind.'],
                'passive' => ['id' => 'Jembatan ini telah diselesaikan.', 'en' => 'This bridge has been completed.']
            ],
            'Present Perfect Continuous' => [
                'verbal' => ['id' => 'Hujan telah sedang turun selama 2 jam.', 'en' => 'Rain has been falling for 2 hours.'],
                'nominal' => ['id' => 'Anak-anak sudah sedang tenang.', 'en' => 'The children have been being quiet.'],
                'passive' => ['id' => 'Gedung sudah sedang direnovasi.', 'en' => 'The building has been being renovated.']
            ],
            'Simple Past' => [
                'verbal' => ['id' => 'Kami bertemu 2 hari yang lalu.', 'en' => 'We met 2 days ago.'],
                'nominal' => ['id' => 'Dinosaurus ada di bumi dulu.', 'en' => 'Dinosaurs were on earth in the past.'],
                'passive' => ['id' => 'Surat ini dikirim kemarin.', 'en' => 'This letter was sent yesterday.']
            ],
            'Past Continuous' => [
                'verbal' => ['id' => 'Mereka sedang bermain ketika hujan turun.', 'en' => 'They were playing when it rained.'],
                'nominal' => ['id' => 'Dia sedang marah waktu itu.', 'en' => 'He was being angry at that time.'],
                'passive' => ['id' => 'Mobil sedang dicuci ketika saya datang.', 'en' => 'The car was being washed when I arrived.']
            ],
            'Past Perfect' => [
                'verbal' => ['id' => 'Dia telah menyelesaikan tugas sebelum ibu pulang.', 'en' => 'He had finished the task before mom came home.'],
                'nominal' => ['id' => 'Mereka telah ada di sana sebelum kami tiba.', 'en' => 'They had been there before we arrived.'],
                'passive' => ['id' => 'Rumah telah dijual sebelum mereka pindah.', 'en' => 'The house had been sold before they moved.']
            ],
            'Past Perfect Continuous' => [
                'verbal' => ['id' => 'Dia telah sedang menunggu selama sejam...', 'en' => 'He had been waiting for an hour...'],
                'nominal' => ['id' => 'Dia telah sedang sedih sebelum kabar baik datang.', 'en' => 'He had been being sad before the good news came.'],
                'passive' => ['id' => 'Kota telah sedang diserang sebelum bantuan tiba.', 'en' => 'The city had been being attacked before help arrived.']
            ],
            'Simple Future' => [
                'verbal' => ['id' => 'Saya akan makan.', 'en' => 'I will eat.'],
                'nominal' => ['id' => 'Saya akan senang.', 'en' => 'I will be happy.'],
                'passive' => ['id' => 'Nasi akan dimakan.', 'en' => 'Rice will be eaten.']
            ],
            'Future Continuous' => [
                'verbal' => ['id' => 'Saya akan sedang makan.', 'en' => 'I will be eating.'],
                'nominal' => ['id' => 'Saya akan sedang senang.', 'en' => 'I will be being happy.'],
                'passive' => ['id' => 'Nasi akan sedang dimakan.', 'en' => 'Rice will be being eaten.']
            ],
            'Future Perfect' => [
                'verbal' => ['id' => 'Saya akan sudah makan.', 'en' => 'I will have eaten.'],
                'nominal' => ['id' => 'Saya akan sudah senang.', 'en' => 'I will have been happy.'],
                'passive' => ['id' => 'Nasi akan sudah dimakan.', 'en' => 'Rice will have been eaten.']
            ],
            'Future Perfect Continuous' => [
                'verbal' => ['id' => 'Saya akan sudah sedang makan.', 'en' => 'I will have been eating.'],
                'nominal' => ['id' => 'Saya akan sudah sedang senang.', 'en' => 'I will have been being happy.'],
                'passive' => ['id' => 'Nasi akan sudah sedang dimakan.', 'en' => 'Rice will have been being eaten.']
            ],
            'Simple Past Future' => [
                'verbal' => ['id' => 'Saya akan makan (dulu).', 'en' => 'I would eat.'],
                'nominal' => ['id' => 'Saya akan senang (dulu).', 'en' => 'I would be happy.'],
                'passive' => ['id' => 'Nasi akan dimakan (dulu).', 'en' => 'Rice would be eaten.']
            ],
            // Add other examples if needed
        ];

        DB::transaction(function () use ($sentences, $matrix, $examples) {
            // Clear existing M2 data to avoid duplicates if re-run
            GrammarQuestion::where('meeting_number', 2)->delete();

            // 1. Sentences
            foreach ($sentences as $idx => $item) {
                GrammarQuestion::create([
                    'meeting_number' => 2,
                    'question_number' => $idx,
                    'section' => 'sentences',
                    'question_text' => $item['id'], // Indo question
                    'correct_answer' => $item['en'],
                    'tense' => $item['tense'],
                    'structure' => $item['type']
                ]);
            }

            // 2. Matrix
            $qNum = 1;
            foreach ($matrix as $tenseName => $types) {
                foreach ($types as $type => $item) {
                    $exampleId = $examples[$tenseName][$type]['id'] ?? null;
                    $exampleEn = $examples[$tenseName][$type]['en'] ?? null;
                    $formula = null; // Can be filled if we have formula data, or add later

                    GrammarQuestion::create([
                        'meeting_number' => 2,
                        'question_number' => $qNum++,
                        'section' => 'matrix',
                        'question_text' => $item['id'],
                        'correct_answer' => $item['en'],
                        'tense' => $tenseName,
                        'structure' => $type,
                        'example_id' => $exampleId,
                        'example_en' => $exampleEn,
                        'formula' => $formula
                    ]);
                }
            }
        });
    }
}
