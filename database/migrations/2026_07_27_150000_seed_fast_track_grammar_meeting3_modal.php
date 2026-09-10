<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        $modalQuestions = [
            1 => ['id' => 'Artefak kuno dapat dilestarikan oleh metode konservasi modern.', 'en' => 'Ancient artifacts can be preserved by modern conservation methods', 'vocab' => ['artefak' => 'artifact', 'kuno' => 'ancient', 'oleh' => 'by', 'metode' => 'method', 'konservasi' => 'conservation', 'modern' => 'modern']],
            2 => ['id' => 'Perubahan iklim mungkin mempercepat pemutihan terumbu karang.', 'en' => 'Climate change may accelerate coral bleaching', 'vocab' => ['perubahan' => 'change', 'iklim' => 'climate', 'mempercepat' => 'accelerate', 'pemutihan' => 'bleaching', 'terumbu karang' => 'coral reef']],
            3 => ['id' => 'Organisasi internasional mungkin adalah penggerak utama aksi iklim dunia.', 'en' => 'International organizations may be the main drivers of global climate action', 'vocab' => ['organisasi' => 'organization', 'internasional' => 'international', 'penggerak' => 'driver', 'utama' => 'main', 'aksi' => 'action', 'dunia' => 'global']],
            4 => ['id' => 'Negara-negara sebaiknya melindungi spesies yang terancam punah.', 'en' => 'Countries should protect endangered species', 'vocab' => ['negara' => 'country', 'melindungi' => 'protect', 'spesies' => 'species', 'terancam punah' => 'endangered']],
            5 => ['id' => 'Hutan tropis harus dilindungi dari deforestasi besar-besaran.', 'en' => 'Tropical forests must be protected from massive deforestation', 'vocab' => ['hutan' => 'forest', 'tropis' => 'tropical', 'dari' => 'from', 'deforestasi' => 'deforestation', 'besar-besaran' => 'massive']],
            6 => ['id' => 'Teknologi baru dapat menghasilkan solusi energi lebih efisien.', 'en' => 'New technology can produce more efficient energy solutions', 'vocab' => ['teknologi' => 'technology', 'baru' => 'new', 'menghasilkan' => 'produce', 'solusi' => 'solution', 'energi' => 'energy', 'lebih' => 'more', 'efisien' => 'efficient']],
            7 => ['id' => 'Kerja sama global harus menjadi prioritas utama.', 'en' => 'Global cooperation must be the top priority', 'vocab' => ['kerja sama' => 'cooperation', 'global' => 'global', 'menjadi' => 'be', 'prioritas' => 'priority', 'utama' => 'top']],
            8 => ['id' => 'Fosil baru mungkin ditemukan di daerah terpencil.', 'en' => 'New fossils may be found in remote areas', 'vocab' => ['fosil' => 'fossil', 'baru' => 'new', 'di' => 'in', 'daerah' => 'area', 'terpencil' => 'remote']],
            9 => ['id' => 'Data ini dapat merupakan bukti evolusi yang signifikan.', 'en' => 'This data can be significant evidence of evolution', 'vocab' => ['data' => 'data', 'ini' => 'this', 'merupakan' => 'be', 'bukti' => 'evidence', 'evolusi' => 'evolution', 'signifikan' => 'significant']],
            10 => ['id' => 'Pemerintah akan menerapkan kebijakan lingkungan baru tahun depan.', 'en' => 'The government will implement new environmental policies next year', 'vocab' => ['pemerintah' => 'government', 'menerapkan' => 'implement', 'kebijakan' => 'policy', 'lingkungan' => 'environmental', 'baru' => 'new', 'tahun depan' => 'next year']],
            11 => ['id' => 'Spesies langka sebaiknya dijaga oleh lembaga resmi.', 'en' => 'Rare species should be protected by official institutions', 'vocab' => ['spesies' => 'species', 'langka' => 'rare', 'oleh' => 'by', 'lembaga' => 'institution', 'resmi' => 'official']],
            12 => ['id' => 'Pendidikan sejak dini sebaiknya adalah kunci keberhasilan konservasi.', 'en' => 'Early education should be the key to conservation success', 'vocab' => ['pendidikan' => 'education', 'sejak dini' => 'early', 'kunci' => 'key', 'keberhasilan' => 'success', 'konservasi' => 'conservation']],
            13 => ['id' => 'Teknologi masa depan mungkin mengurangi polusi udara secara drastis.', 'en' => 'Future technology may reduce air pollution drastically', 'vocab' => ['teknologi' => 'technology', 'masa depan' => 'future', 'mengurangi' => 'reduce', 'polusi' => 'pollution', 'udara' => 'air', 'secara' => 'in a way', 'drastis' => 'drastically']],
            14 => ['id' => 'Bakteri tertentu dapat diuraikan oleh enzim khusus.', 'en' => 'Certain bacteria can be decomposed by special enzymes', 'vocab' => ['bakteri' => 'bacteria', 'tertentu' => 'certain', 'oleh' => 'by', 'enzim' => 'enzyme', 'khusus' => 'special']],
            15 => ['id' => 'Perjanjian ini akan menjadi dasar hukum perlindungan laut internasional.', 'en' => 'This agreement will be the legal basis for international marine protection', 'vocab' => ['perjanjian' => 'agreement', 'ini' => 'this', 'menjadi' => 'be', 'dasar' => 'basis', 'hukum' => 'legal', 'perlindungan' => 'protection', 'laut' => 'marine', 'internasional' => 'international']],
            16 => ['id' => 'Paus dapat dianggap sebagai hewan terbesar di bumi.', 'en' => 'Whales can be considered the largest animals on earth', 'vocab' => ['paus' => 'whale', 'sebagai' => 'as', 'hewan' => 'animal', 'terbesar' => 'largest', 'di' => 'on', 'bumi' => 'earth']],
            17 => ['id' => 'Energi terbarukan dapat menggantikan bahan bakar fosil sebagai sumber energi utama.', 'en' => 'Renewable energy can replace fossil fuels as the main energy source', 'vocab' => ['energi' => 'energy', 'terbarukan' => 'renewable', 'menggantikan' => 'replace', 'bahan bakar' => 'fuel', 'fosil' => 'fossil', 'sebagai' => 'as', 'sumber' => 'source', 'utama' => 'main']],
            18 => ['id' => 'Aturan baru akan diberlakukan di kawasan konservasi.', 'en' => 'New rules will be implemented in conservation areas', 'vocab' => ['aturan' => 'rule', 'baru' => 'new', 'di' => 'in', 'kawasan' => 'area', 'konservasi' => 'conservation']],
            19 => ['id' => 'Arkeolog harus mendokumentasikan penemuan mereka secara akurat.', 'en' => 'Archaeologists must document their findings accurately', 'vocab' => ['arkeolog' => 'archaeologist', 'mendokumentasikan' => 'document', 'penemuan' => 'finding', 'mereka' => 'their', 'secara' => 'in a way', 'akurat' => 'accurately']],
            20 => ['id' => 'Penemuan ini mungkin merupakan titik balik dalam riset medis.', 'en' => 'This discovery may be a turning point in medical research', 'vocab' => ['penemuan' => 'discovery', 'ini' => 'this', 'merupakan' => 'be', 'titik balik' => 'turning point', 'dalam' => 'in', 'riset' => 'research', 'medis' => 'medical']],
            21 => ['id' => 'Mamalia laut seharusnya mampu berkomunikasi melintasi jarak samudra menggunakan suara frekuensi rendah.', 'en' => 'Marine mammals should be able to communicate across ocean distances using low-frequency sounds', 'vocab' => ['mamalia' => 'mammal', 'laut' => 'marine', 'berkomunikasi' => 'communicate', 'melintasi' => 'across', 'jarak' => 'distance', 'samudra' => 'ocean', 'menggunakan' => 'using', 'suara' => 'sound', 'frekuensi' => 'frequency', 'rendah' => 'low']],
            22 => ['id' => 'Komunitas internasional mungkin akan mengadopsi peraturan lebih ketat untuk spesies terancam punah.', 'en' => 'The international community may adopt stricter regulations for endangered species', 'vocab' => ['komunitas' => 'community', 'internasional' => 'international', 'mengadopsi' => 'adopt', 'peraturan' => 'regulation', 'lebih' => 'more', 'ketat' => 'strict', 'untuk' => 'for', 'spesies' => 'species', 'terancam punah' => 'endangered']],
            23 => ['id' => 'Mahasiswa program kedokteran akan seharusnya menyelesaikan pelatihan klinis ekstensif sebelum lulus.', 'en' => 'Medical students will be supposed to complete extensive clinical training before graduation', 'vocab' => ['mahasiswa' => 'student', 'program' => 'program', 'kedokteran' => 'medical', 'menyelesaikan' => 'complete', 'pelatihan' => 'training', 'klinis' => 'clinical', 'ekstensif' => 'extensive', 'sebelum' => 'before', 'lulus' => 'graduation']],
            24 => ['id' => 'Peradaban kuno seharusnya mampu membangun monumen besar tanpa mesin modern.', 'en' => 'Ancient civilizations should have been able to build large monuments without modern machines', 'vocab' => ['peradaban' => 'civilization', 'kuno' => 'ancient', 'membangun' => 'build', 'monumen' => 'monument', 'besar' => 'large', 'tanpa' => 'without', 'mesin' => 'machine', 'modern' => 'modern']],
            25 => ['id' => 'Para peneliti akan meluncurkan satelit pemantau iklim global.', 'en' => 'Researchers will launch global climate monitoring satellites', 'vocab' => ['peneliti' => 'researcher', 'meluncurkan' => 'launch', 'satelit' => 'satellite', 'pemantau' => 'monitoring', 'iklim' => 'climate', 'global' => 'global']],
            26 => ['id' => 'Seluruh petugas laboratorium seharusnya memakai perlengkapan pelindung selama eksperimen.', 'en' => 'All laboratory staff should wear protective equipment during experiments', 'vocab' => ['seluruh' => 'all', 'petugas' => 'staff', 'laboratorium' => 'laboratory', 'memakai' => 'wear', 'perlengkapan' => 'equipment', 'pelindung' => 'protective', 'selama' => 'during', 'eksperimen' => 'experiment']],
            27 => ['id' => 'Tanaman tertentu harus mampu bertahan di lingkungan yang sangat kering.', 'en' => 'Certain plants must be able to survive in very dry environments', 'vocab' => ['tanaman' => 'plant', 'tertentu' => 'certain', 'bertahan' => 'survive', 'di' => 'in', 'lingkungan' => 'environment', 'sangat' => 'very', 'kering' => 'dry']],
            28 => ['id' => 'Pemerintah akan menerapkan kebijakan baru tentang sampah plastik.', 'en' => 'The government will implement new policies about plastic waste', 'vocab' => ['pemerintah' => 'government', 'menerapkan' => 'implement', 'kebijakan' => 'policy', 'baru' => 'new', 'tentang' => 'about', 'sampah' => 'waste', 'plastik' => 'plastic']],
            29 => ['id' => 'Astronaut akan bisa mengikuti protokol ketat selama misi luar angkasa.', 'en' => 'Astronauts will be able to follow strict protocols during space missions', 'vocab' => ['astronaut' => 'astronaut', 'mengikuti' => 'follow', 'protokol' => 'protocol', 'ketat' => 'strict', 'selama' => 'during', 'misi' => 'mission', 'luar angkasa' => 'space']],
            30 => ['id' => 'Manusia purba mampu bermigrasi antar benua.', 'en' => 'Ancient humans were able to migrate between continents', 'vocab' => ['manusia' => 'human', 'purba' => 'ancient', 'bermigrasi' => 'migrate', 'antar' => 'between', 'benua' => 'continent']]
        ];

        DB::table('grammar_questions')->where('meeting_number', 3)->delete();

        foreach ($modalQuestions as $qNum => $q) {
            DB::table('grammar_questions')->insert([
                'meeting_number' => 3,
                'question_number' => $qNum,
                'question_text' => $q['id'],
                'correct_answer' => $q['en'],
                'vocab' => json_encode($q['vocab'] ?? []),
                'tense' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }

    public function down(): void
    {
    }
};
