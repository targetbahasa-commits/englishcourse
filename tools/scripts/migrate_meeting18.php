<?php

use App\Models\GrammarQuestion;
use Illuminate\Support\Facades\DB;

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$questions = [
    // Reducing - Active
    1 => [
        'id' => 'Archaebacteria adalah kelompok bakteri yang termasuk prokariot yang tinggal di lingkungan ekstrim seperti gunung berapi atau danau asin.',
        'en' => 'Archaebacteria is a bacteria group including prokaryotic bacteria living in extreme environments such as volcanoes or salt water lakes',
        'example' => ['id' => 'Plankton adalah kelompok organisme yang termasuk autotrof yang melayang di perairan dangkal seperti muara sungai atau teluk terlindung.', 'en' => 'Plankton is an organism group including autotrophs floating in shallow waters such as river estuaries or sheltered bays.'],
        'vocab' => [
            'Bacteria group' => ['id' => 'Kelompok bakteri', 'pos' => '(n)'],
            'Include' => ['id' => 'Termasuk', 'pos' => '(v)'],
            'Extreme environment' => ['id' => 'Lingkungan ekstrim', 'pos' => '(n)'],
            'Volcano' => ['id' => 'Gunung berapi', 'pos' => '(n)'],
            'Salt water lake' => ['id' => 'Danau asin', 'pos' => '(n)']
        ]
    ],
    2 => [
        'id' => 'Selain memiliki kombinasi yang unik dari gen, spesies mungkin juga memiliki variasi dalam bentuk dan komposisi dari kromosom yang membawa gen.',
        'en' => 'Besides having a unique combination of genes, species may also have variations in the form and composition of chromosomes carrying genes',
        'example' => ['id' => 'Selain memiliki desain yang inovatif dari arsitektur, gedung mungkin juga memiliki keunikan dalam gaya dan material dari fondasi yang menopang struktur.', 'en' => 'Besides having an innovative design of architecture, buildings may also have uniqueness in the style and material of foundations supporting structures.'],
        'vocab' => [
            'Unique combination' => ['id' => 'Kombinasi unik', 'pos' => '(n)'],
            'Gene' => ['id' => 'Gen', 'pos' => '(n)'],
            'Variation' => ['id' => 'Variasi', 'pos' => '(n)'],
            'Composition' => ['id' => 'Komposisi', 'pos' => '(n)'],
            'Chromosome' => ['id' => 'Kromosom', 'pos' => '(n)'],
            'Carry' => ['id' => 'Membawa', 'pos' => '(v)']
        ]
    ],
    3 => [
        'id' => 'Dam-dam yang dibangun untuk pengendali banjir bisa memberikan orang-orang yang tinggal di hilir dari dam sebuah rasa keamanan palsu.',
        'en' => 'Dams built for flood control can give people living downstream from the dam a false sense of security',
        'example' => ['id' => 'Jalan-jalan yang dibangun untuk transportasi umum bisa memberikan pengendara-pengendara yang berkendara di jalur dari jalan sebuah akses mobilitas lancar.', 'en' => 'Roads built for public transportation can give drivers driving in the lanes from the road an access to smooth mobility.'],
        'vocab' => [
            'Flood control' => ['id' => 'Pengendali banjir', 'pos' => '(n)'],
            'Downstream' => ['id' => 'Hilir', 'pos' => '(n)'],
            'False sense' => ['id' => 'Rasa palsu', 'pos' => '(n)'],
            'Security' => ['id' => 'Keamanan', 'pos' => '(n)']
        ]
    ],
    4 => [
        'id' => 'Charles Darwin adalah ilmuwan yang mengembangkan teori evolusi melalui seleksi alam.',
        'en' => 'Charles Darwin is a scientist developing the theory of evolution through natural selection',
        'example' => ['id' => 'Marie Curie adalah peneliti yang menemukan unsur radium melalui eksperimen kimia.', 'en' => 'Marie Curie is a researcher discovering the element radium through chemical experiments.'],
        'vocab' => [
            'Scientist' => ['id' => 'Ilmuwan', 'pos' => '(n)'],
            'Develop' => ['id' => 'Mengembangkan', 'pos' => '(v)'],
            'Theory of evolution' => ['id' => 'Teori evolusi', 'pos' => '(n)'],
            'Natural selection' => ['id' => 'Seleksi alam', 'pos' => '(n)']
        ]
    ],
    5 => [
        'id' => 'Pemanasan global yang disebabkan oleh meningkatnya jumlah karbon di atmosfer merupakan akibat langsung dari revolusi industri.',
        'en' => 'Global warming caused by increasing amounts of carbon in the atmosphere is a direct result of the industrial revolution',
        'example' => ['id' => 'Urbanisasi yang disebabkan oleh meningkatnya migrasi penduduk di kota merupakan tantangan langsung terhadap infrastruktur publik.', 'en' => 'Urbanization caused by increasing population migration in cities is a direct challenge to public infrastructure.'],
        'vocab' => [
            'Global warming' => ['id' => 'Pemanasan global', 'pos' => '(n)'],
            'Cause' => ['id' => 'Menyebabkan', 'pos' => '(v)'],
            'Increase' => ['id' => 'Meningkat', 'pos' => '(v)'],
            'Amount' => ['id' => 'Jumlah', 'pos' => '(n)'],
            'Atmosphere' => ['id' => 'Atmosfer', 'pos' => '(n)'],
            'Direct result' => ['id' => 'Akibat langsung', 'pos' => '(n)'],
            'Industrial revolution' => ['id' => 'Revolusi industri', 'pos' => '(n)']
        ]
    ],
    6 => [
        'id' => 'Revolusi Industri adalah periode sejarah yang mengubah struktur ekonomi dan sosial di Eropa.',
        'en' => 'The Industrial Revolution is a historical period changing economic and social structures in Europe',
        'example' => ['id' => 'Pencerahan adalah zaman intelektual yang mengubah pemikiran politik dan ilmiah di Prancis.', 'en' => 'The Enlightenment is an intellectual age changing political and scientific thinking in France.'],
        'vocab' => [
            'Historical period' => ['id' => 'Periode sejarah', 'pos' => '(n)'],
            'Change' => ['id' => 'Mengubah', 'pos' => '(v)'],
            'Economic structure' => ['id' => 'Struktur ekonomi', 'pos' => '(n)'],
            'Social structure' => ['id' => 'Struktur sosial', 'pos' => '(n)']
        ]
    ],
    7 => [
        'id' => 'Pertumbuhan per capita Cina yang berata-rata 8.7 percent pada tahun 1990-2005 adalah salah satu pertumbuhan ekonomi tercepat di Dunia.',
        'en' => 'China\'s per capita growth averaging 8.7 percent in 1990-2005 is one of the fastest economic growths in the World',
        'example' => ['id' => 'Investasi per kapita Singapura yang berata-rata 7.5 persen pada tahun 2015-2025 adalah salah satu pertumbuhan modal terkuat di dunia.', 'en' => 'Singapore\'s per capita investment averaging 7.5 percent in 2015-2025 is one of the strongest capital growths in the world.'],
        'vocab' => [
            'Per capita growth' => ['id' => 'Pertumbuhan per kapita', 'pos' => '(n)'],
            'Average' => ['id' => 'Berata-rata', 'pos' => '(v)'],
            'Fastest' => ['id' => 'Tercepat', 'pos' => '(adj)'],
            'Economic growth' => ['id' => 'Pertumbuhan ekonomi', 'pos' => '(n)']
        ]
    ],
    8 => [
        'id' => 'Ekosistem hutan hujan yang telah menjadi sumber oxygen dunia sedang terancam oleh penebangan pohon liar.',
        'en' => 'Rainforest ecosystems having become the world\'s oxygen source are being threatened by illegal logging',
        'example' => ['id' => 'Ekosistem padang rumput yang telah menjadi tempat hidup mamalia besar sedang terancam oleh perubahan iklim ekstrem.', 'en' => 'Grassland ecosystems having become large mammal habitats are being threatened by extreme climate change.'],
        'vocab' => [
            'Rainforest ecosystem' => ['id' => 'Ekosistem hutan hujan', 'pos' => '(n)'],
            'Oxygen source' => ['id' => 'Sumber oksigen', 'pos' => '(n)'],
            'Threaten' => ['id' => 'Mengancam', 'pos' => '(v)'],
            'Illegal logging' => ['id' => 'Penebangan liar', 'pos' => '(n)']
        ]
    ],
    9 => [
        'id' => 'Banyak sumber air di dataran tinggi berasal dari glasier yang mencair di musim semi.',
        'en' => 'Many water sources in the highlands come from glaciers melting in spring',
        'example' => ['id' => 'Banyak cadangan minyak di laut dalam berasal dari endapan organik yang mengeras di era purba.', 'en' => 'Many oil reserves in the deep sea come from organic sediments hardening in ancient eras.'],
        'vocab' => [
            'Water source' => ['id' => 'Sumber air', 'pos' => '(n)'],
            'Highlands' => ['id' => 'Dataran tinggi', 'pos' => '(n)'],
            'Glacier' => ['id' => 'Glasier', 'pos' => '(n)'],
            'Melt' => ['id' => 'Mencair', 'pos' => '(v)'],
            'Spring' => ['id' => 'Musim semi', 'pos' => '(n)']
        ]
    ],
    10 => [
        'id' => 'Berbeda dengan glasiasi Phanerozoic, glasisasi Hirnantian bertahan kurang dari 1 juta tahun dengan kondisi glasiasi penuh yang bertahan 200.000 tahun.',
        'en' => 'Unlike Phanerozoic glaciation, Hirnantian glaciation lasted less than 1 million years with full glaciation conditions lasting 200,000 years',
        'example' => ['id' => 'Berbeda dengan dinasti Ming, dinasti Qing berkuasa lebih dari 250 tahun dengan sistem pemerintahan monarki yang berlangsung 200 tahun.', 'en' => 'Unlike the Ming dynasty, the Qing dynasty ruled more than 250 years with a monarchy government system lasting 200 years.'],
        'vocab' => [
            'Unlike' => ['id' => 'Berbeda dengan', 'pos' => '(prep)'],
            'Glaciation' => ['id' => 'Glasiasi', 'pos' => '(n)'],
            'Last' => ['id' => 'Bertahan', 'pos' => '(v)'],
            'Condition' => ['id' => 'Kondisi', 'pos' => '(n)']
        ]
    ],
    
    // Reducing - Passive
    11 => [
        'id' => 'Penggunaan pestisida sintetis meningkatkan ketergantungan kita pada pestisida dalam proses yang disebut "pesticide treadmill".',
        'en' => 'The use of synthetic pesticide improves our dependency on pesticide in a process called "pesticide treadmill"',
        'example' => ['id' => 'Penggunaan energi terbarukan meningkatkan keberlanjutan kita pada lingkungan dalam pendekatan yang disebut "green economy".', 'en' => 'The use of renewable energy improves our sustainability on the environment in an approach called "green economy".'],
        'vocab' => [
            'Synthetic pesticide' => ['id' => 'Pestisida sintetis', 'pos' => '(n)'],
            'Improve' => ['id' => 'Meningkatkan', 'pos' => '(v)'],
            'Dependency' => ['id' => 'Ketergantungan', 'pos' => '(n)'],
            'Process' => ['id' => 'Proses', 'pos' => '(n)']
        ]
    ],
    12 => [
        'id' => 'Iklim juga mempengaruhi aktivitas manusia, seperti pertanian yang dipengaruhi oleh lama dari musim tanam, jumlah, dan distribusi dari hutan hujan dan temperatur.',
        'en' => 'Climate also affects human activities, such as agriculture affected by the length of the growing season, amount, and distribution of rainfall and temperature',
        'example' => ['id' => 'Teknologi juga mempengaruhi gaya hidup modern, seperti komunikasi yang dipengaruhi oleh kecepatan dari jaringan internet, bandwidth, dan distribusi dari sinyal dan konektivitas.', 'en' => 'Technology also affects modern lifestyles, such as communication affected by the speed of internet networks, bandwidth, and distribution of signals and connectivity.'],
        'vocab' => [
            'Climate' => ['id' => 'Iklim', 'pos' => '(n)'],
            'Affect' => ['id' => 'Mempengaruhi', 'pos' => '(v)'],
            'Agriculture' => ['id' => 'Pertanian', 'pos' => '(n)'],
            'Growing season' => ['id' => 'Musim tanam', 'pos' => '(n)'],
            'Rainfall' => ['id' => 'Curah hujan', 'pos' => '(n)'],
            'Temperature' => ['id' => 'Temperatur', 'pos' => '(n)']
        ]
    ],
    13 => [
        'id' => 'Ekonomi dari Gulf Cooperation Council (GCC) bergantung sepenuhnya pada produksi dari minyak dan semua sektor ekonomi yang berkutat pada keuntungan yang dihasilkan oleh ekspor minyak.',
        'en' => 'The economy of the Gulf Cooperation Council (GCC) depends entirely on oil production and all economic sectors revolving around profits generated by oil exports',
        'example' => ['id' => 'Pendidikan dari negara-negara Skandinavia bergantung sebagian pada investasi dari pemerintah dan semua program sosial yang berfokus pada kesejahteraan yang dihasilkan oleh kebijakan publik.', 'en' => 'Education of Scandinavian countries depends partially on government investment and all social programs focusing on welfare generated by public policies.'],
        'vocab' => [
            'Economy' => ['id' => 'Ekonomi', 'pos' => '(n)'],
            'Depend entirely' => ['id' => 'Bergantung sepenuhnya', 'pos' => '(v)'],
            'Oil production' => ['id' => 'Produksi minyak', 'pos' => '(n)'],
            'Revolve around' => ['id' => 'Berkutat pada', 'pos' => '(v)'],
            'Profit' => ['id' => 'Keuntungan', 'pos' => '(n)'],
            'Generate' => ['id' => 'Dihasilkan', 'pos' => '(v)'],
            'Oil export' => ['id' => 'Ekspor minyak', 'pos' => '(n)']
        ]
    ],
    14 => [
        'id' => 'Dengan menghancurkan bebatuan, lichen melepaskan ke kolam, danau, dan sungai komponen fosfat dan nitrat yang diperlukan oleh organisme, oleh karena itu menghasilkan nutrisi untuk mikroba tanah dan akar-akar tanaman.',
        'en' => 'By destroying rocks, lichen releases into pools, lakes, and rivers phosphate and nitrate components required by organisms, therefore producing nutrients for soil microbes and plant roots',
        'example' => ['id' => 'Dengan memproses limbah organik, tanaman melepaskan ke udara, tanah, dan air komponen metana dan amonia yang dibutuhkan oleh mikroba, oleh karena itu menghasilkan kompos untuk kebun dan ladang.', 'en' => 'By processing organic waste, plants release into the air, soil, and water methane and ammonia components needed by microbes, therefore producing compost for gardens and fields.'],
        'vocab' => [
            'Destroy' => ['id' => 'Menghancurkan', 'pos' => '(v)'],
            'Rock' => ['id' => 'Bebatuan', 'pos' => '(n)'],
            'Release' => ['id' => 'Melepaskan', 'pos' => '(v)'],
            'Component' => ['id' => 'Komponen', 'pos' => '(n)'],
            'Require' => ['id' => 'Diperlukan', 'pos' => '(v)'],
            'Produce' => ['id' => 'Menghasilkan', 'pos' => '(v)'],
            'Nutrient' => ['id' => 'Nutrisi', 'pos' => '(n)']
        ]
    ],
    15 => [
        'id' => 'Fosil-fosil yang ditemukan dari ikan paus purba menunjukkan bahwa mereka masih memiliki kaki belakang 40.000 juta tahun yang lalu.',
        'en' => 'Fossils found from ancient whales show that they still had hind legs 40,000 million years ago',
        'example' => ['id' => 'Manuskrip-manuskrip yang ditemukan dari perpustakaan Alexandria menunjukkan bahwa mereka sudah memiliki pengetahuan matematika 2.000 tahun yang lalu.', 'en' => 'Manuscripts found from the Alexandria library show that they already had mathematical knowledge 2,000 years ago.'],
        'vocab' => [
            'Fossil' => ['id' => 'Fosil', 'pos' => '(n)'],
            'Ancient whale' => ['id' => 'Ikan paus purba', 'pos' => '(n)'],
            'Show' => ['id' => 'Menunjukkan', 'pos' => '(v)'],
            'Hind leg' => ['id' => 'Kaki belakang', 'pos' => '(n)']
        ]
    ],
    16 => [
        'id' => 'Penelitian yang dilakukan di dalam laboratorium biologi molekuler telah menunjukkan bahwa sejumlah besar spesies memiliki variasi genetik yang rendah yang disebabkan oleh pengurangan ukuran populasi.',
        'en' => 'Research conducted in molecular biology laboratories has shown that a large number of species have low genetic variation caused by population size reduction',
        'example' => ['id' => 'Studi yang dilakukan di dalam pusat penelitian antariksa telah menunjukkan bahwa sejumlah besar planet memiliki atmosfer tipis yang disebabkan oleh radiasi matahari.', 'en' => 'Studies conducted in space research centers have shown that a large number of planets have thin atmospheres caused by solar radiation.'],
        'vocab' => [
            'Research' => ['id' => 'Penelitian', 'pos' => '(n)'],
            'Conduct' => ['id' => 'Dilakukan', 'pos' => '(v)'],
            'Molecular biology' => ['id' => 'Biologi molekuler', 'pos' => '(n)'],
            'Genetic variation' => ['id' => 'Variasi genetik', 'pos' => '(n)'],
            'Reduction' => ['id' => 'Pengurangan', 'pos' => '(n)']
        ]
    ],
    17 => [
        'id' => 'Hypsodont terdiri dari serangkaian laminae tipis yang terbentuk dari enamel yang dikelilingi oleh dentine dengan cementun diantara tiap lamina.',
        'en' => 'Hypsodont consists of a series of thin laminae formed from enamel surrounded by dentine with cementum between each lamina',
        'example' => ['id' => 'Mesin terdiri dari serangkaian komponen mekanis yang terbuat dari logam yang dihubungkan oleh baut dengan pelumas diantara tiap bagian.', 'en' => 'Machines consist of a series of mechanical components made from metal connected by bolts with lubricant between each part.'],
        'vocab' => [
            'Consist of' => ['id' => 'Terdiri dari', 'pos' => '(v)'],
            'Series' => ['id' => 'Serangkaian', 'pos' => '(n)'],
            'Form' => ['id' => 'Terbentuk', 'pos' => '(v)'],
            'Surround' => ['id' => 'Dikelilingi', 'pos' => '(v)'],
            'Between' => ['id' => 'Diantara', 'pos' => '(prep)']
        ]
    ],
    18 => [
        'id' => 'Karena properti intelektual adalah dalam jangkauan nasional, level dari perlindungan yang disediakan oleh instrumen semacam ini bisa bervariasi di seluruh negara.',
        'en' => 'Because intellectual property is within national reach, the level of protection provided by such instruments can vary across countries',
        'example' => ['id' => 'Karena paten adalah dalam jangkauan global, standar dari lisensi yang disediakan oleh organisasi semacam ini bisa berbeda di seluruh wilayah.', 'en' => 'Because patents are within global reach, the standard of licensing provided by such organizations can differ across regions.'],
        'vocab' => [
            'Intellectual property' => ['id' => 'Properti intelektual', 'pos' => '(n)'],
            'National scope' => ['id' => 'Jangkauan nasional', 'pos' => '(n)'],
            'Protection' => ['id' => 'Perlindungan', 'pos' => '(n)'],
            'Provide' => ['id' => 'Disediakan', 'pos' => '(v)'],
            'Vary' => ['id' => 'Bervariasi', 'pos' => '(v)']
        ]
    ],
    19 => [
        'id' => 'Sebuah joint venture adalah sebuah mekanisme bisnis untuk menggabungkan aset komplementer yang dimiliki oleh perusahaan yang berbeda.',
        'en' => 'A joint venture is a business mechanism for combining complementary assets owned by different companies',
        'example' => ['id' => 'Sebuah kemitraan strategis adalah sebuah pendekatan kolaboratif untuk mengintegrasikan sumber daya spesifik yang dimiliki oleh organisasi yang berbeda.', 'en' => 'A strategic partnership is a collaborative approach for integrating specific resources owned by different organizations.'],
        'vocab' => [
            'Joint venture' => ['id' => 'Usaha patungan', 'pos' => '(n)'],
            'Mechanism' => ['id' => 'Mekanisme', 'pos' => '(n)'],
            'Combine' => ['id' => 'Menggabungkan', 'pos' => '(v)'],
            'Complementary asset' => ['id' => 'Aset komplementer', 'pos' => '(n)'],
            'Own' => ['id' => 'Dimiliki', 'pos' => '(v)']
        ]
    ],
    20 => [
        'id' => 'Akhir dari periode Permian yang ditandai dengan kepunahan dari banyak kelompok organisme yang telah mendominasi lingkungan laut dan darat selama ratusan juta tahun membukakan jalan bagi ekspansi dari fauna modern saat ini.',
        'en' => 'The end of the Permian period marked by the extinction of many groups of organisms having dominated marine and terrestrial environments for hundreds of millions of years paved the way for the expansion of modern fauna today',
        'example' => ['id' => 'Awal dari era digital yang ditandai dengan kemunculan dari banyak platform teknologi yang telah mengubah cara komunikasi dan bisnis selama puluhan tahun membuka peluang bagi pertumbuhan dari ekonomi digital saat ini.', 'en' => 'The beginning of the digital era marked by the emergence of many technology platforms having changed communication and business methods for decades opened opportunities for the growth of the digital economy today.'],
        'vocab' => [
            'Mark' => ['id' => 'Ditandai', 'pos' => '(v)'],
            'Extinction' => ['id' => 'Kepunahan', 'pos' => '(n)'],
            'Dominate' => ['id' => 'Mendominasi', 'pos' => '(v)'],
            'Marine' => ['id' => 'Laut', 'pos' => '(adj)'],
            'Terrestrial' => ['id' => 'Darat', 'pos' => '(adj)'],
            'Pave the way' => ['id' => 'Membukakan jalan', 'pos' => '(v)'],
            'Expansion' => ['id' => 'Ekspansi', 'pos' => '(n)']
        ]
    ],
    
    // Present Participle
    21 => [
        'id' => 'Para ilmuwan menemukan spesies living di hutan tropis terpencil.',
        'en' => 'Scientists discover species living in remote tropical forests',
        'example' => ['id' => 'Para peneliti mengamati mikroba thriving di mata air panas yang terisolasi.', 'en' => 'Researchers observe microbes thriving in isolated hot springs.'],
        'vocab' => [
            'Discover' => ['id' => 'Menemukan', 'pos' => '(v)'],
            'Species' => ['id' => 'Spesies', 'pos' => '(n)'],
            'Remote' => ['id' => 'Terpencil', 'pos' => '(adj)'],
            'Tropical forest' => ['id' => 'Hutan tropis', 'pos' => '(n)']
        ]
    ],
    22 => [
        'id' => 'Kota besar memiliki sistem transportasi connecting berbagai wilayah secara efisien.',
        'en' => 'Big cities have transportation systems connecting various regions efficiently',
        'example' => ['id' => 'Negara maju membangun jaringan komunikasi linking berbagai pulau secara cepat.', 'en' => 'Developed countries build communication networks linking various islands quickly.'],
        'vocab' => [
            'Transportation system' => ['id' => 'Sistem transportasi', 'pos' => '(n)'],
            'Connect' => ['id' => 'Menghubungkan', 'pos' => '(v)'],
            'Various' => ['id' => 'Berbagai', 'pos' => '(adj)'],
            'Region' => ['id' => 'Wilayah', 'pos' => '(n)'],
            'Efficiently' => ['id' => 'Secara efisien', 'pos' => '(adv)']
        ]
    ],
    23 => [
        'id' => 'Peneliti menerbitkan artikel tentang teknologi improving kualitas energi terbarukan.',
        'en' => 'Researchers publish articles about technology improving renewable energy quality',
        'example' => ['id' => 'Insinyur mengembangkan inovasi tentang perangkat enhancing efisiensi panel surya.', 'en' => 'Engineers develop innovations about devices enhancing solar panel efficiency.'],
        'vocab' => [
            'Researcher' => ['id' => 'Peneliti', 'pos' => '(n)'],
            'Publish' => ['id' => 'Menerbitkan', 'pos' => '(v)'],
            'Article' => ['id' => 'Artikel', 'pos' => '(n)'],
            'Improve' => ['id' => 'Meningkatkan', 'pos' => '(v)'],
            'Renewable energy' => ['id' => 'Energi terbarukan', 'pos' => '(n)'],
            'Quality' => ['id' => 'Kualitas', 'pos' => '(n)']
        ]
    ],
    24 => [
        'id' => 'Perusahaan meluncurkan perangkat containing fitur keamanan digital terbaru.',
        'en' => 'Companies launch devices containing the latest digital security features',
        'example' => ['id' => 'Produsen merilis aplikasi offering sistem navigasi pintar terkini.', 'en' => 'Producers release applications offering the latest smart navigation systems.'],
        'vocab' => [
            'Launch' => ['id' => 'Meluncurkan', 'pos' => '(v)'],
            'Device' => ['id' => 'Perangkat', 'pos' => '(n)'],
            'Contain' => ['id' => 'Berisi', 'pos' => '(v)'],
            'Feature' => ['id' => 'Fitur', 'pos' => '(n)'],
            'Security' => ['id' => 'Keamanan', 'pos' => '(n)'],
            'Latest' => ['id' => 'Terbaru', 'pos' => '(adj)']
        ]
    ],
    25 => [
        'id' => 'Sungai panjang itu mendukung masyarakat depending pada air untuk pertanian.',
        'en' => 'The long river supports communities depending on water for agriculture',
        'example' => ['id' => 'Danau besar itu menciptakan ekosistem relying pada oksigen untuk kehidupan akuatik.', 'en' => 'The large lake creates ecosystems relying on oxygen for aquatic life.'],
        'vocab' => [
            'Support' => ['id' => 'Mendukung', 'pos' => '(v)'],
            'Community' => ['id' => 'Masyarakat', 'pos' => '(n)'],
            'Depend on' => ['id' => 'Bergantung pada', 'pos' => '(v)'],
            'Agriculture' => ['id' => 'Pertanian', 'pos' => '(n)']
        ]
    ],
    
    // Past Participle
    26 => [
        'id' => 'Kota kuno itu ditemukan dengan sisa bangunan built pada abad ke-5 sebelum masehi.',
        'en' => 'The ancient city was found with building remains built in the 5th century BC',
        'example' => ['id' => 'Benteng bersejarah itu ditemukan dengan struktur pertahanan constructed pada abad ke-12 masehi.', 'en' => 'The historical fortress was found with defense structures constructed in the 12th century AD.'],
        'vocab' => [
            'Ancient city' => ['id' => 'Kota kuno', 'pos' => '(n)'],
            'Found' => ['id' => 'Ditemukan', 'pos' => '(v)'],
            'Remains' => ['id' => 'Sisa', 'pos' => '(n)'],
            'Built' => ['id' => 'Dibangun', 'pos' => '(v)'],
            'Century' => ['id' => 'Abad', 'pos' => '(n)'],
            'BC' => ['id' => 'Sebelum Masehi', 'pos' => '(n)']
        ]
    ],
    27 => [
        'id' => 'Para ilmuwan meneliti fosil preserved di dalam lapisan batuan sedimen.',
        'en' => 'Scientists study fossils preserved in sedimentary rock layers',
        'example' => ['id' => 'Para arkeolog mempelajari artefak stored di dalam ruang penyimpanan museum.', 'en' => 'Archaeologists study artifacts stored in museum storage rooms.'],
        'vocab' => [
            'Study' => ['id' => 'Meneliti', 'pos' => '(v)'],
            'Fossil' => ['id' => 'Fosil', 'pos' => '(n)'],
            'Preserved' => ['id' => 'Diawetkan', 'pos' => '(v)'],
            'Layer' => ['id' => 'Lapisan', 'pos' => '(n)'],
            'Sedimentary rock' => ['id' => 'Batuan sedimen', 'pos' => '(n)']
        ]
    ],
    28 => [
        'id' => 'Museum nasional menampilkan manuskrip written dalam bahasa Sanskerta.',
        'en' => 'The national museum displays manuscripts written in Sanskrit',
        'example' => ['id' => 'Galeri seni memamerkan lukisan created dalam gaya Renaisans.', 'en' => 'The art gallery exhibits paintings created in Renaissance style.'],
        'vocab' => [
            'Display' => ['id' => 'Menampilkan', 'pos' => '(v)'],
            'Manuscript' => ['id' => 'Manuskrip', 'pos' => '(n)'],
            'Written' => ['id' => 'Ditulis', 'pos' => '(v)'],
            'Sanskrit' => ['id' => 'Sanskerta', 'pos' => '(n)']
        ]
    ],
    29 => [
        'id' => 'Observatorium astronomi menggunakan teleskop designed untuk mendeteksi gelombang radio.',
        'en' => 'The astronomical observatory uses telescopes designed to detect radio waves',
        'example' => ['id' => 'Laboratorium fisika mengoperasikan akselerator engineered untuk menghasilkan partikel subatomik.', 'en' => 'The physics laboratory operates accelerators engineered to produce subatomic particles.'],
        'vocab' => [
            'Observatory' => ['id' => 'Observatorium', 'pos' => '(n)'],
            'Telescope' => ['id' => 'Teleskop', 'pos' => '(n)'],
            'Designed' => ['id' => 'Dirancang', 'pos' => '(v)'],
            'Detect' => ['id' => 'Mendeteksi', 'pos' => '(v)'],
            'Radio wave' => ['id' => 'Gelombang radio', 'pos' => '(n)']
        ]
    ],
    30 => [
        'id' => 'Universitas internasional memiliki arsip collected dari berbagai penelitian global.',
        'en' => 'International universities have archives collected from various global research',
        'example' => ['id' => 'Perpustakaan digital menyimpan database compiled dari berbagai publikasi akademik.', 'en' => 'Digital libraries store databases compiled from various academic publications.'],
        'vocab' => [
            'Archive' => ['id' => 'Arsip', 'pos' => '(n)'],
            'Collected' => ['id' => 'Dikumpulkan', 'pos' => '(v)'],
            'Various' => ['id' => 'Berbagai', 'pos' => '(adj)'],
            'Research' => ['id' => 'Penelitian', 'pos' => '(n)']
        ]
    ]
];

$paragraph = [
    'id' => 'Penelitian yang dilakukan oleh para ilmuwan menunjukkan bahwa ekosistem laut yang terancam oleh polusi plastik memerlukan tindakan segera. Spesies living di terumbu karang mengalami penurunan populasi yang signifikan. Teknologi cleaning ocean yang dikembangkan oleh perusahaan internasional mulai diimplementasikan di berbagai negara. Data collected dari satelit membantu peneliti memahami pola migrasi hewan laut. Solusi yang diusulkan oleh komunitas ilmiah mencakup pengurangan penggunaan plastik sekali pakai dan peningkatan program daur ulang.',
    'en' => 'Research conducted by scientists shows that marine ecosystems threatened by plastic pollution require immediate action. Species living in coral reefs experience significant population decline. Ocean cleaning technology developed by international companies is beginning to be implemented in various countries. Data collected from satellites helps researchers understand marine animal migration patterns. Solutions proposed by the scientific community include reducing single-use plastic and increasing recycling programs.',
    'vocab' => [
        'Conduct' => ['id' => 'Melakukan', 'pos' => '(v)'],
        'Marine ecosystem' => ['id' => 'Ekosistem laut', 'pos' => '(n)'],
        'Threaten' => ['id' => 'Mengancam', 'pos' => '(v)'],
        'Pollution' => ['id' => 'Polusi', 'pos' => '(n)'],
        'Immediate action' => ['id' => 'Tindakan segera', 'pos' => '(n)'],
        'Coral reef' => ['id' => 'Terumbu karang', 'pos' => '(n)'],
        'Population decline' => ['id' => 'Penurunan populasi', 'pos' => '(n)'],
        'Implement' => ['id' => 'Mengimplementasikan', 'pos' => '(v)'],
        'Satellite' => ['id' => 'Satelit', 'pos' => '(n)'],
        'Migration pattern' => ['id' => 'Pola migrasi', 'pos' => '(n)'],
        'Propose' => ['id' => 'Mengusulkan', 'pos' => '(v)'],
        'Single-use plastic' => ['id' => 'Plastik sekali pakai', 'pos' => '(n)'],
        'Recycling program' => ['id' => 'Program daur ulang', 'pos' => '(n)']
    ]
];

// Check existing data
$existing = GrammarQuestion::where('meeting_number', 18)->count();
if ($existing > 0) {
    echo "Deleting existing data for Meeting 18 to re-seed...\n";
    GrammarQuestion::where('meeting_number', 18)->delete();
}

// Insert Questions
foreach ($questions as $num => $q) {
    GrammarQuestion::create([
        'meeting_number' => 18,
        'question_number' => $num,
        'question_text' => $q['id'],
        'correct_answer' => $q['en'],
        'vocab' => $q['vocab'],
        'example_id' => $q['example']['id'],
        'example_en' => $q['example']['en'],
    ]);
}
echo "Inserted " . count($questions) . " questions.\n";

// Insert Paragraph
GrammarQuestion::create([
    'meeting_number' => 18,
    'question_number' => 100,
    'section' => 'paragraph',
    'question_type' => 'paragraph',
    'question_text' => $paragraph['id'],
    'correct_answer' => $paragraph['en'],
    'vocab' => $paragraph['vocab'],
]);
echo "Inserted paragraph for Meeting 18.\n";
