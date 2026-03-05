<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\GrammarQuestion;
use App\Models\GrammarVocabulary;

class PopulateMeeting5 extends Command
{
    protected $signature = 'populate:meeting5';
    protected $description = 'Populate Meeting 5 questions and vocabularies';

    public function handle()
    {
        $this->info('Populating Meeting 5 data...');
        
        // Clear existing
        GrammarQuestion::where('meeting_number', 5)->delete();
        $this->info('Cleared existing questions');
        
        // 1. Simple Sentences
        $sentences = [
            ['id' => 'Kita tidak menyelesaikan masalah ini', 'en' => 'We do not solve this problem', 'tense' => 'Simple Present'],
            ['id' => 'Dia (it) tidak membantu.', 'en' => 'It does not help', 'tense' => 'Simple Present'],
            ['id' => 'Pemerintah tidak melindungi hutan.', 'en' => 'The government does not protect the forest', 'tense' => 'Simple Present'],
            ['id' => 'Undang - undang tidak menjamin kebebasan berekspresi.', 'en' => 'The law does not guarantee freedom of expression', 'tense' => 'Simple Present'],
            ['id' => 'Mamalia tidak menyebar secara luas 2 juta tahun yang lalu', 'en' => 'Mammals did not spread widely 2 million years ago', 'tense' => 'Simple Past'],
        ];

        foreach ($sentences as $idx => $s) {
            GrammarQuestion::create([
                'meeting_number' => 5,
                'section' => 'sentences',
                'question_number' => $idx + 1,
                'tense' => $s['tense'],
                'question_text' => $s['id'],
                'correct_answer' => $s['en']
            ]);
        }
        $this->info('Created ' . count($sentences) . ' simple sentences');
        
        // 2. Matrix Questions
        $matrix = [
            // Simple Present
            ['tense' => 'Simple Present', 'structure' => 'nominal', 'id' => 'Beruang bukan karnivora.', 'en' => 'Bears are not carnivores'],
            ['tense' => 'Simple Present', 'structure' => 'passive', 'id' => 'Gajah utamanya tidak diburu untuk dagingnya.', 'en' => 'Elephants are not mainly hunted for their meat'],
            
            // Present Continuous
            ['tense' => 'Present Continuous', 'structure' => 'verbal', 'id' => 'Ekonomi global tidak sedang tumbuh.', 'en' => 'The global economy is not growing'],
            ['tense' => 'Present Continuous', 'structure' => 'nominal', 'id' => 'Pemerintah tidak sedang berhati - hati.', 'en' => 'The government is not being careful'],
            ['tense' => 'Present Continuous', 'structure' => 'passive', 'id' => 'Konsumsi bahan bakar tidak sedang dikurangi.', 'en' => 'Fuel consumption is not being reduced'],
            
            // Present Perfect
            ['tense' => 'Present Perfect', 'structure' => 'verbal', 'id' => 'Beberapa negara belum bergabung dengan PBB.', 'en' => 'Some countries have not joined the UN'],
            ['tense' => 'Present Perfect', 'structure' => 'nominal', 'id' => 'Hukum ini masih belum ada di negara kami.', 'en' => 'This law has not existed in our country yet'],
            ['tense' => 'Present Perfect', 'structure' => 'passive', 'id' => 'Air bersih masih belum dinikmati oleh semua orang.', 'en' => 'Clean water has not yet been enjoyed by everyone'],
            
            // Present Perfect Continuous
            ['tense' => 'Present Perfect Continuous', 'structure' => 'verbal', 'id' => 'Negara belum sedang mengembangkan teknologi semikonduktor.', 'en' => 'The country has not been developing semiconductor technology'],
            ['tense' => 'Present Perfect Continuous', 'structure' => 'nominal', 'id' => 'Pemerintah belum sedang berhati - hati.', 'en' => 'The government has not been being careful'],
            ['tense' => 'Present Perfect Continuous', 'structure' => 'passive', 'id' => 'Proyek ini belum sedang dibangun.', 'en' => 'This project has not been being built'],
            
            // Simple Past
            ['tense' => 'Simple Past', 'structure' => 'nominal', 'id' => 'Pantodonta tidak ada di berbagai ekosistem pada 65 juta tahun yang lalu.', 'en' => 'Pantodonta did not exist in various ecosystems 65 million years ago'],
            ['tense' => 'Simple Past', 'structure' => 'passive', 'id' => 'Kehidupan mamalia tidak dimusnahkan oleh komet.', 'en' => 'Mammalian life was not wiped out by the comet'],
            
            // Past Continuous
            ['tense' => 'Past Continuous', 'structure' => 'verbal', 'id' => 'Manusia tidak sedang menjelajahi Antartika 400 tahun yang lalu', 'en' => 'Humans were not exploring Antarctica 400 years ago'],
            ['tense' => 'Past Continuous', 'structure' => 'nominal', 'id' => 'Pemerintah tidak sedang berhati - hati.', 'en' => 'The government was not being careful'],
            ['tense' => 'Past Continuous', 'structure' => 'passive', 'id' => 'Minyak tidak sedang ditambang di Alaska.', 'en' => 'Oil was not being mined in Alaska'],
            
            // Past Perfect
            ['tense' => 'Past Perfect', 'structure' => 'verbal', 'id' => 'Columbus belum mengunjungi dataran utama Amerika sebelum pelayaran pertama', 'en' => 'Columbus had not visited the American mainland before the first voyage'],
            ['tense' => 'Past Perfect', 'structure' => 'nominal', 'id' => 'Mamalia belum ada di Selandia Baru 1000 tahun yang lalu.', 'en' => 'Mammals had not existed in New Zealand 1000 years ago'],
            ['tense' => 'Past Perfect', 'structure' => 'passive', 'id' => 'Permafrost belum ditemukan dulu.', 'en' => 'Permafrost had not been discovered before'],
            
            // Past Perfect Continuous
            ['tense' => 'Past Perfect Continuous', 'structure' => 'verbal', 'id' => 'Banyak pabrik belum sedang menerapkan standar keselamatan yang lalu.', 'en' => 'Many factories had not been implementing safety standards before'],
            ['tense' => 'Past Perfect Continuous', 'structure' => 'nominal', 'id' => 'Pemerintah belum sedang berhati - hati.', 'en' => 'The government had not been being careful'],
            ['tense' => 'Past Perfect Continuous', 'structure' => 'passive', 'id' => 'Nuklir belum sedang dikembangkan 100 tahun lalu.', 'en' => 'Nuclear had not been being developed 100 years ago'],
            
            // Simple Future
            ['tense' => 'Simple Future', 'structure' => 'verbal', 'id' => 'AI tidak akan menggantikan lapangan pekerjaan.', 'en' => 'AI will not replace jobs'],
            ['tense' => 'Simple Future', 'structure' => 'nominal', 'id' => 'Dunia tidak akan sama dalam 50 tahun lagi.', 'en' => 'The world will not be the same in 50 years'],
            ['tense' => 'Simple Future', 'structure' => 'passive', 'id' => 'Hidrogen tidak akan digunakan untuk bahan bakar utama dalam 10 tahun.', 'en' => 'Hydrogen will not be used as the main fuel in 10 years'],
            
            // Future Continuous
            ['tense' => 'Future Continuous', 'structure' => 'verbal', 'id' => 'Manusia tidak akan sedang menetap.', 'en' => 'Humans will not be settling'],
            ['tense' => 'Future Continuous', 'structure' => 'nominal', 'id' => 'Pemerintah tidak akan sedang berhati - hati.', 'en' => 'The government will not be being careful'],
            ['tense' => 'Future Continuous', 'structure' => 'passive', 'id' => 'Asteroid tidak akan sedang dipelajari dalam waktu dekat', 'en' => 'Asteroids will not be being studied in the near future'],
            
            // Future Perfect
            ['tense' => 'Future Perfect', 'structure' => 'verbal', 'id' => 'Manusia tidak akan sudah menemukan kota - kota pasti.', 'en' => 'Humans will not have found certain cities'],
            ['tense' => 'Future Perfect', 'structure' => 'nominal', 'id' => 'Teknologi tidak akan sudah ada di semua rumah tangga sampai disaat.', 'en' => 'Technology will not have existed in all households by then'],
            ['tense' => 'Future Perfect', 'structure' => 'passive', 'id' => 'Ujian anti gravitasi belum akan disembuhkan dalam 50 tahun.', 'en' => 'Anti-gravity tests will not have been cured in 50 years'],
            
            // Future Perfect Continuous
            ['tense' => 'Future Perfect Continuous', 'structure' => 'verbal', 'id' => 'Ekosistem akan belum sedang menyembuhkan.', 'en' => 'Ecosystems will not have been healing'],
            ['tense' => 'Future Perfect Continuous', 'structure' => 'nominal', 'id' => 'Pemerintah tidak akan telah sedang berhati - hati.', 'en' => 'The government will not have been being careful'],
            ['tense' => 'Future Perfect Continuous', 'structure' => 'passive', 'id' => 'Diyon Sphere belum akan sedang dibangun.', 'en' => 'Dyson Sphere will not have been being built'],
            
            // Simple Past Future
            ['tense' => 'Simple Past Future', 'structure' => 'verbal', 'id' => 'Bencana ini tidak akan terjadi dengan pencegahan.', 'en' => 'This disaster would not happen with prevention'],
            ['tense' => 'Simple Past Future', 'structure' => 'nominal', 'id' => 'Burung kiwi tidak akan ada di Selandia Baru.', 'en' => 'Kiwi birds would not exist in New Zealand'],
            ['tense' => 'Simple Past Future', 'structure' => 'passive', 'id' => 'Teknologi ini tidak akan dikembangkan.', 'en' => 'This technology would not be developed'],
            
            // Past Future Continuous
            ['tense' => 'Past Future Continuous', 'structure' => 'verbal', 'id' => 'Geyser tidak akan sedang membantu kota.', 'en' => 'Geysers would not be helping the city'],
            ['tense' => 'Past Future Continuous', 'structure' => 'nominal', 'id' => 'Pemerintah tidak akan sedang berhati - hati.', 'en' => 'The government would not be being careful'],
            ['tense' => 'Past Future Continuous', 'structure' => 'passive', 'id' => 'Tanah di daerah ini tidak akan sedang diteliti', 'en' => 'Land in this area would not be being studied'],
            
            // Past Future Perfect
            ['tense' => 'Past Future Perfect', 'structure' => 'verbal', 'id' => 'Aircraft belum akan menyebar tanpa insiden Heidelberg.', 'en' => 'Aircraft would not have spread without the Heidelberg incident'],
            ['tense' => 'Past Future Perfect', 'structure' => 'nominal', 'id' => 'Mammoth tidak akan punah.', 'en' => 'Mammoths would not have gone extinct'],
            ['tense' => 'Past Future Perfect', 'structure' => 'passive', 'id' => 'Pesawat jet belum akan dikembangkan di perang.', 'en' => 'Jet aircraft would not have been developed in war'],
            
            // Past Future Perfect Continuous
            ['tense' => 'Past Future Perfect Continuous', 'structure' => 'verbal', 'id' => 'Letusan Yellowstone belum akan sedang mengubah iklim', 'en' => 'The Yellowstone eruption would not have been changing the climate'],
            ['tense' => 'Past Future Perfect Continuous', 'structure' => 'nominal', 'id' => 'Pemerintah tidak akan telah sedang berhati - hati.', 'en' => 'The government would not have been being careful'],
            ['tense' => 'Past Future Perfect Continuous', 'structure' => 'passive', 'id' => 'Proyek ini belum akan sedang diajukan', 'en' => 'This project would not have been being proposed'],
            
            // Modal
            ['tense' => 'Modal', 'structure' => 'verbal', 'id' => 'Manusia seharusnya tidak menghancurkan alam.', 'en' => 'Humans should not destroy nature'],
            ['tense' => 'Modal', 'structure' => 'nominal', 'id' => 'teori ini mungkin tidak benar.', 'en' => 'This theory might not be correct'],
            ['tense' => 'Modal', 'structure' => 'passive', 'id' => 'Ekosistem terumbu karang seharusnya tidak dieksploitasi', 'en' => 'Coral reef ecosystems should not be exploited'],
        ];

        foreach ($matrix as $m) {
            GrammarQuestion::create([
                'meeting_number' => 5,
                'section' => 'matrix',
                'question_number' => 0,
                'tense' => $m['tense'],
                'structure' => $m['structure'],
                'question_text' => $m['id'],
                'correct_answer' => $m['en']
            ]);
        }
        $this->info('Created ' . count($matrix) . ' matrix questions');
        
        // 3. PR (Passive Reporting) Questions
        $prQuestions = [
            [
                'id' => 'Para arkeolog tidak menemukan artefak itu sebelum penggalian terakhir.',
                'en' => 'Archaeologists did not find that artifact before the last excavation',
                'tense' => 'Simple Past',
                'example' => 'Columbus tidak menemukan Amerika pada 1491.|Columbus did not discover America in 1491',
                'vocab' => json_encode(['arkeolog' => 'archaeologist', 'menemukan' => 'find', 'artefak' => 'artifact', 'penggalian' => 'excavation'])
            ],
            [
                'id' => 'Ilmuwan tidak sedang meneliti spesies baru di hutan Amazon.',
                'en' => 'Scientists are not researching new species in the Amazon forest',
                'tense' => 'Present Continuous',
                'example' => 'Para peneliti tidak sedang mengamati perilaku hewan.|Researchers are not observing animal behavior',
                'vocab' => json_encode(['ilmuwan' => 'scientist', 'meneliti' => 'research', 'spesies' => 'species', 'hutan' => 'forest'])
            ],
            [
                'id' => 'Teknologi tidak mengalami perkembangan yang stagnan.',
                'en' => 'Technology is not experiencing stagnant development',
                'tense' => 'Simple Present',
                'example' => 'Ekonomi tidak mengalami pertumbuhan yang cepat.|The economy does not experience rapid growth',
                'vocab' => json_encode(['teknologi' => 'technology', 'mengalami' => 'experience', 'perkembangan' => 'development', 'stagnan' => 'stagnant'])
            ],
            [
                'id' => 'Gunung berapi itu tidak pernah meletus sebelum gempa.',
                'en' => 'That volcano had never erupted before the earthquake',
                'tense' => 'Past Perfect',
                'example' => 'Manusia belum pernah melihat fenomena itu sebelumnya.|Humans had never seen that phenomenon before',
                'vocab' => json_encode(['gunung berapi' => 'volcano', 'meletus' => 'erupt', 'gempa' => 'earthquake'])
            ],
            [
                'id' => 'Para astronom tidak sedang mengamati bintang jatuh tadi malam.',
                'en' => 'Astronomers were not observing shooting stars last night',
                'tense' => 'Past Continuous',
                'example' => 'Ilmuwan tidak sedang melakukan eksperimen kemarin.|Scientists were not conducting experiments yesterday',
                'vocab' => json_encode(['astronom' => 'astronomer', 'mengamati' => 'observe', 'bintang jatuh' => 'shooting star'])
            ],
            [
                'id' => 'Ilmuwan tidak pernah menemukan fosil dinosaurus hidup.',
                'en' => 'Scientists have never found living dinosaur fossils',
                'tense' => 'Present Perfect',
                'example' => 'Peneliti belum menemukan bukti kehidupan di Mars.|Researchers have not found evidence of life on Mars',
                'vocab' => json_encode(['ilmuwan' => 'scientist', 'menemukan' => 'find', 'fosil' => 'fossil', 'dinosaurus' => 'dinosaur'])
            ],
            [
                'id' => 'Tim penyelamat tidak sedang mencari korban di lokasi bencana.',
                'en' => 'The rescue team is not searching for victims at the disaster location',
                'tense' => 'Present Continuous',
                'example' => 'Petugas tidak sedang mengevakuasi warga.|Officers are not evacuating residents',
                'vocab' => json_encode(['penyelamat' => 'rescue', 'mencari' => 'search', 'korban' => 'victim', 'bencana' => 'disaster'])
            ],
            [
                'id' => 'Para insinyur tidak sedang menguji mesin baru minggu lalu.',
                'en' => 'Engineers were not testing the new machine last week',
                'tense' => 'Past Continuous',
                'example' => 'Teknisi tidak sedang memperbaiki sistem kemarin.|Technicians were not repairing the system yesterday',
                'vocab' => json_encode(['insinyur' => 'engineer', 'menguji' => 'test', 'mesin' => 'machine'])
            ],
            [
                'id' => 'Pekerja tidak sedang membangun jembatan di kota itu bulan lalu.',
                'en' => 'Workers were not building a bridge in that city last month',
                'tense' => 'Past Continuous',
                'example' => 'Kontraktor tidak sedang merenovasi gedung tahun lalu.|Contractors were not renovating the building last year',
                'vocab' => json_encode(['pekerja' => 'worker', 'membangun' => 'build', 'jembatan' => 'bridge'])
            ],
            [
                'id' => 'Dokter tidak pernah menemukan obat untuk penyakit langka itu sebelumnya.',
                'en' => 'Doctors had never found a cure for that rare disease before',
                'tense' => 'Past Perfect',
                'example' => 'Peneliti belum menemukan vaksin untuk virus itu sebelumnya.|Researchers had not found a vaccine for that virus before',
                'vocab' => json_encode(['dokter' => 'doctor', 'menemukan' => 'find', 'obat' => 'cure', 'penyakit' => 'disease'])
            ],
        ];

        foreach ($prQuestions as $pr) {
            GrammarQuestion::create([
                'meeting_number' => 5,
                'section' => 'pr',
                'question_number' => 0,
                'tense' => $pr['tense'],
                'question_text' => $pr['id'],
                'correct_answer' => $pr['en'],
                'example' => $pr['example'],
                'vocabulary' => $pr['vocab']
            ]);
        }
        $this->info('Created ' . count($prQuestions) . ' PR questions');
        
        // 4. Migrate Vocabularies
        GrammarVocabulary::where('meeting_number', 5)->delete();
        $this->info('Cleared existing vocabularies');
        
        // Comprehensive vocabularies for all tenses and structures
        $vocabularies = [
            // Simple Present
            'Simple Present - verbal' => ['menyelesaikan' => 'solve', 'masalah' => 'problem'],
            'Simple Present - nominal' => ['beruang' => 'bear', 'karnivora' => 'carnivore'],
            'Simple Present - passive' => ['gajah' => 'elephant', 'diburu' => 'hunted'],
            
            // Present Continuous
            'Present Continuous - verbal' => ['ekonomi' => 'economy', 'tumbuh' => 'grow'],
            'Present Continuous - nominal' => ['pemerintah' => 'government', 'berhati-hati' => 'careful'],
            'Present Continuous - passive' => ['konsumsi' => 'consumption', 'dikurangi' => 'reduced'],
            
            // Present Perfect
            'Present Perfect - verbal' => ['negara' => 'country', 'bergabung' => 'join'],
            'Present Perfect - nominal' => ['hukum' => 'law', 'ada' => 'exist'],
            'Present Perfect - passive' => ['air bersih' => 'clean water', 'dinikmati' => 'enjoyed'],
            
            // Present Perfect Continuous
            'Present Perfect Continuous - verbal' => ['mengembangkan' => 'develop', 'teknologi' => 'technology'],
            'Present Perfect Continuous - nominal' => ['pemerintah' => 'government', 'berhati-hati' => 'careful'],
            'Present Perfect Continuous - passive' => ['proyek' => 'project', 'dibangun' => 'built'],
            
            // Simple Past
            'Simple Past - verbal' => ['menyebar' => 'spread', 'luas' => 'widely'],
            'Simple Past - nominal' => ['pantodonta' => 'pantodonta', 'ekosistem' => 'ecosystem'],
            'Simple Past - passive' => ['kehidupan' => 'life', 'dimusnahkan' => 'wiped out'],
            
            // Past Continuous
            'Past Continuous - verbal' => ['manusia' => 'human', 'menjelajahi' => 'explore'],
            'Past Continuous - nominal' => ['pemerintah' => 'government', 'berhati-hati' => 'careful'],
            'Past Continuous - passive' => ['minyak' => 'oil', 'ditambang' => 'mined'],
            
            // Past Perfect
            'Past Perfect - verbal' => ['mengunjungi' => 'visit', 'dataran' => 'mainland'],
            'Past Perfect - nominal' => ['mamalia' => 'mammal', 'ada' => 'exist'],
            'Past Perfect - passive' => ['permafrost' => 'permafrost', 'ditemukan' => 'discovered'],
            
            // Past Perfect Continuous
            'Past Perfect Continuous - verbal' => ['pabrik' => 'factory', 'menerapkan' => 'implement'],
            'Past Perfect Continuous - nominal' => ['pemerintah' => 'government', 'berhati-hati' => 'careful'],
            'Past Perfect Continuous - passive' => ['nuklir' => 'nuclear', 'dikembangkan' => 'developed'],
            
            // Simple Future
            'Simple Future - verbal' => ['menggantikan' => 'replace', 'lapangan pekerjaan' => 'jobs'],
            'Simple Future - nominal' => ['dunia' => 'world', 'sama' => 'same'],
            'Simple Future - passive' => ['hidrogen' => 'hydrogen', 'digunakan' => 'used'],
            
            // Future Continuous
            'Future Continuous - verbal' => ['manusia' => 'human', 'menjelajahi' => 'explore'],
            'Future Continuous - nominal' => ['pemerintah' => 'government', 'berhati-hati' => 'careful'],
            'Future Continuous - passive' => ['asteroid' => 'asteroid', 'dipelajari' => 'studied'],
            
            // Future Perfect
            'Future Perfect - verbal' => ['menemukan' => 'find', 'kehidupan' => 'life'],
            'Future Perfect - nominal' => ['teknologi' => 'technology', 'ada' => 'exist'],
            'Future Perfect - passive' => ['kanker' => 'cancer', 'disembuhkan' => 'cured'],
            
            // Future Perfect Continuous
            'Future Perfect Continuous - verbal' => ['ilmuwan' => 'scientist', 'meneliti' => 'research'],
            'Future Perfect Continuous - nominal' => ['pemerintah' => 'government', 'berhati-hati' => 'careful'],
            'Future Perfect Continuous - passive' => ['proyek' => 'project', 'dibangun' => 'built'],
            
            // Simple Past Future
            'Simple Past Future - verbal' => ['pergi' => 'go', 'akan' => 'would'],
            'Simple Past Future - nominal' => ['ada' => 'be', 'di sana' => 'there'],
            'Simple Past Future - passive' => ['dilakukan' => 'done', 'itu' => 'it'],
            
            // Past Future Continuous
            'Past Future Continuous - verbal' => ['rapat' => 'meeting', 'sedang' => 'be'],
            'Past Future Continuous - nominal' => ['kasar' => 'rude', 'menjadi' => 'being'],
            'Past Future Continuous - passive' => ['mobil' => 'car', 'diperbaiki' => 'fixed'],
            
            // Past Future Perfect
            'Past Future Perfect - verbal' => ['lupa' => 'forget', 'sudah' => 'have'],
            'Past Future Perfect - nominal' => ['ada' => 'be', 'di sana' => 'there'],
            'Past Future Perfect - passive' => ['paket' => 'package', 'dikirim' => 'sent'],
            
            // Past Future Perfect Continuous
            'Past Future Perfect Continuous - verbal' => ['tidur' => 'sleep', 'sedang' => 'be'],
            'Past Future Perfect Continuous - nominal' => ['senang' => 'happy', 'menjadi' => 'being'],
            'Past Future Perfect Continuous - passive' => ['buku' => 'book', 'ditulis' => 'written'],
            
            // Modal
            'Modal - verbal' => ['merokok' => 'smoke', 'boleh' => 'must'],
            'Modal - nominal' => ['sakit' => 'sick', 'mungkin' => 'might'],
            'Modal - passive' => ['pintu' => 'door', 'dibuka' => 'opened'],
            
            // PR (Passive Reporting)
            'PR' => [
                'arkeolog' => 'archaeologist',
                'artefak' => 'artifact',
                'penggalian' => 'excavation',
                'ilmuwan' => 'scientist',
                'meneliti' => 'research',
                'spesies' => 'species',
                'teknologi' => 'technology',
                'perkembangan' => 'development',
                'gunung berapi' => 'volcano',
                'meletus' => 'erupt',
                'astronom' => 'astronomer',
                'mengamati' => 'observe',
                'bintang jatuh' => 'shooting star',
                'fosil' => 'fossil',
                'dinosaurus' => 'dinosaur',
                'penyelamat' => 'rescue',
                'korban' => 'victim',
                'bencana' => 'disaster',
                'insinyur' => 'engineer',
                'menguji' => 'test',
                'mesin' => 'machine',
                'pekerja' => 'worker',
                'membangun' => 'build',
                'jembatan' => 'bridge',
                'dokter' => 'doctor',
                'obat' => 'cure',
                'penyakit' => 'disease',
            ],
        ];
        
        $vocabCount = 0;
        foreach ($vocabularies as $section => $words) {
            foreach ($words as $ind => $eng) {
                GrammarVocabulary::create([
                    'meeting_number' => 5,
                    'section' => $section,
                    'word' => $ind,
                    'translation' => $eng,
                    'pos' => 'general'
                ]);
                $vocabCount++;
            }
        }
        $this->info('Created ' . $vocabCount . ' vocabulary items');
        
        $total = GrammarQuestion::where('meeting_number', 5)->count();
        $this->info("✓ Total Meeting 5 questions: {$total}");
        
        return 0;
    }
}
