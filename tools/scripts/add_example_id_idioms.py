#!/usr/bin/env python3
import json, os

# =============================================================
# Indonesian translations of example sentences
# =============================================================

BASIC_EXAMPLE_ID = {
    "A piece of cake": "Jangan khawatir dengan tesnya; itu akan sangat mudah.",
    "Cost an arm and a leg": "Aku suka mobil itu, tapi harganya sangat mahal.",
    "Break a leg": "Kamu pasti akan tampil luar biasa malam ini. Semoga sukses!",
    "Hit the books": "Aku ada ujian besar besok, jadi aku harus belajar malam ini.",
    "Let the cat out of the bag": "Aku tidak sengaja membocorkan rahasia tentang pesta kejutan itu.",
    "Hit the sack": "Aku sangat lelah setelah bekerja seharian. Aku mau tidur sekarang.",
    "Under the weather": "Aku tidak akan ke sekolah hari ini karena badanku sedikit tidak enak.",
    "Once in a blue moon": "Kakakku tinggal di negara lain, jadi aku hanya melihatnya sangat jarang.",
    "When pigs fly": "Dia akan membersihkan kamarnya kalau sudah ada keajaiban.",
    "To feel blue": "Aku selalu merasa sedih saat liburan sudah berakhir.",
    "Spill the beans": "Jangan bocorkan rahasianya tentang pesta kejutan!",
    "A couch potato": "Kakakku sangat pemalas; dia menonton TV sepanjang hari.",
    "Hold your horses": "Sabar dulu! Mari kita pikirkan ini sebelum mengambil keputusan.",
    "In the same boat": "Kita berdua gugup menghadapi tes; kita berada di situasi yang sama.",
    "Bite your tongue": "Aku ingin memberitahunya bahwa dia salah, tapi aku harus menahan diri.",
    "A blessing in disguise": "Kehilangan pekerjaan itu ternyata membawa berkah; aku menemukan yang jauh lebih baik.",
    "Better late than never": "Aku tahu aku terlambat, tapi lebih baik terlambat daripada tidak sama sekali, kan?",
    "Bite the bullet": "Aku benar-benar tidak mau ke dokter gigi, tapi aku harus hadapi saja.",
    "Call it a day": "Kita sudah bekerja selama sepuluh jam. Ayo berhenti untuk hari ini.",
    "Cut corners": "Tukang bangunan itu mengambil jalan pintas, dan sekarang atapnya bocor.",
    "Easy does it": "Hati-hati! Kotak itu sangat rapuh.",
    "Get out of hand": "Pesta anak-anak itu tidak terkendali saat mereka mulai melempar kue.",
    "Go the extra mile": "Jika kamu ingin lulus ujian, kamu perlu berusaha lebih keras.",
    "Hang in there": "Aku tahu pekerjaannya berat sekarang, tapi tetap semangat!",
    "Make a long story short": "Singkat cerita, penerbangan saya dibatalkan.",
    "No pain, no gain": "Ototku sakit karena olahraga, tapi bersakit-sakit dahulu bersenang-senang kemudian.",
    "On the ball": "Dia tidak sempat minum kopi pagi ini, jadi dia kurang fokus hari ini.",
    "Pull someone's leg": "Aku hanya bercanda saat bilang ujiannya besok.",
    "Time flies": "Waktu berlalu sangat cepat saat kamu sedang bersenang-senang.",
    "A dime a dozen": "Cincin plastik seperti itu sangat umum dan murah.",
    "Out of the blue": "Dia meneleponku tiba-tiba tanpa pemberitahuan setelah lima tahun.",
    "Fish out of water": "Di makan malam mewah itu, aku merasa sangat canggung dan tidak pada tempatnya.",
    "It takes two to tango": "Jangan salahkan dia saja atas pertengkaran itu; kedua belah pihak ikut bertanggung jawab.",
    "Throw in the towel": "Teka-tekinya terlalu sulit, jadi aku menyerah.",
    "See eye to eye": "Bosku dan aku tidak selalu sepakat soal proyek baru ini.",
    "Jump the gun": "Jangan tergesa-gesa; tunggu sampai kita punya semua faktanya sebelum memutuskan.",
    "Know the ropes": "Butuh beberapa minggu bagiku untuk mengetahui seluk-beluk pekerjaan baruku.",
    "Keep an eye on": "Bisakah kamu menjaga tasku sementara aku ke kamar mandi?",
    "Learn the ropes": "Aku masih mempelajari cara kerja di departemen baru ini.",
    "Rule of thumb": "Sebagai patokan umum, kamu sebaiknya minum dua liter air sehari.",
    "Sick and tired": "Aku sudah muak makan makanan yang sama setiap malam.",
    "Sleight of hand": "Keterampilan tangan pesulap itu sangat menakjubkan untuk ditonton.",
    "Take it easy": "Kamu sudah bekerja sepanjang minggu; kamu harus bersantai akhir pekan ini.",
    "Up in the air": "Rencana liburan kami masih belum pasti.",
    "Have butterflies in my stomach": "Aku selalu sangat gugup sebelum memberikan pidato.",
    "Keep your chin up": "Wawancaranya tidak berjalan baik, tapi tetap semangat; kamu pasti akan menemukan pekerjaan lain.",
    "On thin ice": "Kamu dalam situasi berbahaya karena sudah terlambat tiga kali minggu ini.",
    "Out of the woods": "Demamnya mereda, tapi dokter bilang dia belum sepenuhnya keluar dari bahaya.",
    "Put your foot in your mouth": "Aku benar-benar salah bicara saat menanyakan tentang mantan pacarnya.",
    "Read between the lines": "Dia bilang baik-baik saja, tapi kalau kamu baca makna tersiratnya, dia sebenarnya kesal.",
}

INTERMEDIATE_EXAMPLE_ID = {
    "Bite the bullet": "Aku benci pergi ke dokter gigi, tapi aku harus hadapi saja.",
    "Call it a day": "Kita sudah mengecat rumah selama 8 jam. Ayo berhenti untuk hari ini.",
    "Get out of hand": "Pesta itu menjadi tidak terkendali, dan polisi harus dipanggil.",
    "Hang in there": "Aku tahu ujiannya berat sekarang, tapi tetap semangat!",
    "Hit the nail on the head": "Kamu tepat sekali saat bilang tim ini kurang komunikasi.",
    "A blessing in disguise": "Kehilangan pekerjaan itu ternyata membawa berkah karena aku menemukan yang lebih baik.",
    "Make a long story short": "Singkat cerita, penerbanganku dibatalkan dan aku tidur di bandara.",
    "Miss the boat": "Kalau kamu tidak beli tiketnya minggu ini, kamu akan kehilangan kesempatan.",
    "Pull someone's leg": "Aku tidak benar-benar menang lotre, aku hanya bercanda.",
    "Under the weather": "Aku merasa sedikit tidak enak badan hari ini, sepertinya aku akan di rumah saja.",
    "Wrap your head around something": "Susah bagiku untuk memahami rumus matematika baru ini.",
    "You can say that again": "Cuacanya panas sekali hari ini! Betul sekali.",
    "By the skin of your teeth": "Aku lulus ujian dengan nilai yang nyaris tidak cukup.",
    "On the ball": "Dia selalu cepat tanggap dalam rapat pagi kita.",
    "Cut corners": "Para pembangun mengambil jalan pintas saat membangun rumah ini, dan sekarang atapnya bocor.",
    "Cross your fingers": "Aku berharap semoga aku mendapat promosi itu.",
    "Give it a whirl": "Aku belum pernah memasak makanan Thailand, tapi aku akan mencobanya.",
    "Go down in flames": "Perusahaan itu hancur total setelah skandalnya terungkap.",
    "Leave no stone unturned": "Kami akan mencoba segala cara dalam pencarian anak yang hilang itu.",
    "Look before you leap": "Jangan investasikan semua uangmu tanpa riset dulu; pikirkan matang-matang sebelum bertindak.",
    "Play it by ear": "Kami belum tahu jadwal pastinya, jadi kita lihat situasinya saja nanti.",
    "Speak of the devil": "Wah, pas sekali! Kita baru saja membicarakanmu, Sarah.",
    "Step up your game": "Kalau kamu ingin masuk tim basket, kamu harus tampil lebih serius.",
    "A penny for your thoughts": "Kamu terlihat sangat diam hari ini. Apa yang sedang kamu pikirkan?",
    "Actions speak louder than words": "Dia bilang mencintaiku, tapi perbuatan lebih berbicara daripada kata-kata.",
    "Add fuel to the fire": "Berdebat dengan pelanggan yang marah hanya memperburuk situasi.",
    "Comparing apples and oranges": "Kamu tidak bisa membandingkan sepeda dengan pesawat. Itu seperti membandingkan dua hal yang sangat berbeda.",
    "Cost an arm and a leg": "Aku ingin membeli rumah di lingkungan itu, tapi harganya sangat mahal.",
    "Elephant in the room": "Semua orang tahu perusahaannya mau bangkrut, tapi tidak ada yang mau membicarakannya.",
    "Fit as a fiddle": "Kakekku sudah 80 tahun, tapi kondisinya sangat sehat.",
    "Get your act together": "Kamu harus lebih serius kalau mau lulus mata kuliah ini.",
    "Go back to the drawing board": "Kampanye pemasaran kita tidak berhasil, jadi kita harus mulai dari awal lagi.",
    "In the heat of the moment": "Aku tidak bermaksud berteriak padamu; aku hanya terbawa suasana saat itu.",
    "Kill two birds with one stone": "Aku menyelesaikan dua hal sekaligus dengan mengerjakan PR sambil mencuci pakaian.",
    "Let the chips fall where they may": "Aku sudah bilang kebenarannya dan terima saja apapun yang terjadi.",
    "No-brainer": "Menerima beasiswa penuh itu sama sekali bukan keputusan yang sulit.",
    "On the fence": "Aku masih bimbang apakah harus membeli mobil biru atau merah.",
    "A picture is worth a thousand words": "Foto kota yang hancur itu menunjukkan tragedi yang sebenarnya. Sebuah gambar bisa menceritakan segalanya.",
    "Piece of cake": "Belajar menggunakan perangkat lunak baru itu sangat mudah.",
    "Rain on someone's parade": "Aku tidak mau merusak rencanamu, tapi kita tidak bisa pergi ke pantai besok.",
    "Spill the beans": "Kita mau buat pesta kejutan untuk Ibu; jangan bocorkan rahasianya!",
    "Take it with a grain of salt": "Kamu sebaiknya tidak terlalu percaya sarannya karena dia cenderung berlebihan.",
    "The ball is in your court": "Aku sudah menawarkan kompromi, jadi sekarang terserah kamu untuk memutuskan.",
    "The best of both worlds": "Bekerja dari rumah menawarkan dua keuntungan sekaligus: menghasilkan uang dan punya waktu bersama keluarga.",
    "Think outside the box": "Untuk memecahkan masalah yang rumit ini, kita perlu berpikir kreatif di luar kebiasaan.",
    "Through thick and thin": "Orang tuaku tetap bersama dalam keadaan apapun selama 40 tahun.",
    "Throw caution to the wind": "Dia memutuskan mengambil risiko dengan meminta kenaikan gaji 30% kepada bosnya.",
    "Under the table": "Dia dibayar secara tidak resmi agar tidak perlu membayar pajak.",
    "Water under the bridge": "Ya, kita bertengkar kemarin, tapi hari ini sudah tidak penting lagi.",
    "Wild goose chase": "Mencari anting yang hilang di pantai yang luas itu adalah pencarian yang sia-sia.",
}

ADVANCED_EXAMPLE_ID = {
    "Barking up the wrong tree": "Kalau kamu pikir aku yang mencuri pensilmu, kamu salah orang.",
    "Beat around the bush": "Jangan bertele-tele dan jawab pertanyaanku langsung.",
    "Bite off more than you can chew": "Dengan mengambil empat mata kuliah sekaligus sambil bekerja penuh waktu, dia mengambil beban melebihi kemampuannya.",
    "Burn the midnight oil": "Aku harus begadang untuk menyelesaikan esaiku tepat waktu.",
    "Caught between a rock and a hard place": "Aku terpojok dalam situasi serba salah; aku bisa bayar sewa terlambat atau tidak belanja kebutuhan.",
    "Cross that bridge when you come to it": "Kita mungkin tidak punya cukup uang untuk perjalanan itu, tapi kita pikirkan saat masalahnya datang.",
    "Don't count your chickens before they hatch": "Dia beli mobil sebelum dapat pekerjaan. Jangan menghitung hasil sebelum sesuatu benar-benar terjadi!",
    "Give the benefit of the doubt": "Dia bilang terlambat karena macet, jadi aku percaya saja.",
    "Jump on the bandwagon": "Ketika makanan organik menjadi populer, banyak supermarket ikut-ikutan tren itu.",
    "Kill two birds with one stone": "Aku menggabungkan dua manfaat sekaligus dengan mendengarkan podcast bahasa Inggris sambil jogging.",
    "Let sleeping dogs lie": "Mereka akhirnya berhenti bertengkar, jadi sebaiknya kita biarkan saja dan tidak mengungkitnya lagi.",
    "Steal someone's thunder": "Kakakku bertunangan, tapi aku tidak mau mengalihkan perhatiannya dengan mengumumkan kehamilanku di hari yang sama.",
    "Take it with a grain of salt": "Dia suka membesar-besarkan ceritanya, jadi jangan terlalu dipercaya.",
    "Through thick and thin": "Sahabatku selalu ada untukku dalam keadaan apapun saat aku sakit.",
    "A drop in the ocean": "Sepuluh dolar hanyalah jumlah yang sangat kecil dibandingkan ribuan yang kita butuhkan untuk membeli rumah.",
    "A taste of your own medicine": "Sekarang kamu merasakan bagaimana rasanya diabaikan; itulah balasan atas perbuatanmu sendiri.",
    "Add insult to injury": "Pertama, basement banjir, lalu memperparah keadaan, pipa di dapur juga bocor.",
    "All in the same boat": "Kita tidak bisa saling menyalahkan; kita semua menghadapi pemangkasan anggaran yang sama.",
    "Bite the dust": "Mesin cuci lamaku akhirnya rusak setelah 15 tahun.",
    "Blow off steam": "Hubungi aku kapan saja kalau kamu butuh meluapkan perasaan.",
    "Break the ice": "Ada yang menyarankan kita bermain permainan pesta untuk mencairkan suasana.",
    "By the book": "Pengacara itu melakukan segalanya secara ketat sesuai aturan.",
    "Cry wolf": "Kalau kamu terlalu sering meminta pertolongan tanpa perlu, orang-orang akan berhenti mempercayaimu.",
    "Cut to the chase": "Waktuku tidak banyak, jadi aku langsung ke intinya dan bertanya apakah aku dapat pekerjaannya.",
    "Devil's advocate": "Aku akan memainkan peran pihak yang menentang dan bertanya mengapa proyek ini benar-benar diperlukan.",
    "Drive someone up the wall": "Musik keras itu membuatku sangat frustrasi.",
    "Every cloud has a silver lining": "Aku kehilangan pekerjaan, tapi ada hikmahnya: aku kini punya waktu untuk menulis bukuku.",
    "Fair-weather friend": "Aku pikir dia sahabat terbaikku, tapi ternyata dia hanya teman yang ada saat keadaan baik-baik saja.",
    "Go wild": "Penonton menjadi sangat antusias dan tidak terkendali saat band naik ke panggung.",
    "In the fast lane": "Dia menjalani hidup yang penuh gaya dan keseruan sejak memenangkan lotre.",
    "It's not rocket science": "Pelatihku selalu bilang, 'Basket bukan ilmu roket. Ini soal memasukkan bola ke dalam keranjang.'",
    "Just around the corner": "Natal sudah mau tiba.",
    "Keep your ear to the ground": "Perhatikan sekitarmu agar kamu tahu kapan manajer sedang membuka lowongan.",
    "Leave someone high and dry": "Dia meninggalkanku dalam kesulitan dengan pindah ke departemen lain tanpa memberitahu siapapun.",
    "Make ends meet": "Susah untuk memenuhi kebutuhan sehari-hari hanya dengan gaji minimum.",
    "Method to the madness": "Mejanya terlihat berantakan tapi sebenarnya ada sistem yang tersembunyi di baliknya.",
    "Off the top of my head": "Dari perkiraanku saja, dia mungkin sekitar 30 tahun.",
    "On the back burner": "Proyek itu ditunda karena ada masalah yang lebih mendesak.",
    "Out of the blue": "Suatu hari, tanpa diduga sama sekali, dia mengumumkan bahwa dia akan pergi.",
    "Pull yourself together": "Berhenti menangis dan kendalikan dirimu!",
    "Put all your eggs in one basket": "Aku melamar ke beberapa pekerjaan karena aku tidak mau mempertaruhkan semuanya pada satu pilihan saja.",
    "See eye to eye": "Ayahku dan aku tidak selalu sepakat soal politik.",
    "Take someone under your wing": "Manajer itu membimbing dan melindungi karyawan baru itu.",
    "The tip of the iceberg": "Protes lokal kecil ini hanyalah sebagian kecil dari gambaran masalah yang sebenarnya jauh lebih besar.",
    "Throw someone under the bus": "Aku tidak akan menyalahkan timku hanya untuk melindungi reputasiku sendiri.",
    "Under the table": "Dia menerima sebagian gajinya secara tidak resmi.",
    "Up in the air": "Masa depan perusahaan itu masih belum pasti.",
    "Water under the bridge": "Kita pernah bertengkar soal itu, tapi itu sudah berlalu dan tidak perlu dipermasalahkan lagi.",
    "When pigs fly": "Dia akan mengembalikan uangku kalau ada keajaiban (tidak akan pernah).",
    "Wild goose chase": "Mencari kunci yang hilang di pantai itu adalah pencarian yang sia-sia.",
}

def add_example_id(filepath, mapping):
    with open(filepath, 'r', encoding='utf-8') as f:
        data = json.load(f)

    updated = 0
    for item in data:
        idiom = item.get('idiom', '')
        if idiom in mapping:
            item['example_id'] = mapping[idiom]
            updated += 1

    with open(filepath, 'w', encoding='utf-8') as f:
        json.dump(data, f, ensure_ascii=False, indent=4)

    print(f"  {os.path.basename(filepath)}: {updated}/{len(data)} updated")
    return data

base = os.path.dirname(os.path.abspath(__file__))

print("Adding example_id to idiom JSON files...")
add_example_id(os.path.join(base, 'storage/app/basic_idioms.json'), BASIC_EXAMPLE_ID)
add_example_id(os.path.join(base, 'storage/app/intermediate_idioms.json'), INTERMEDIATE_EXAMPLE_ID)
add_example_id(os.path.join(base, 'storage/app/advanced_idioms.json'), ADVANCED_EXAMPLE_ID)
print("Done!")
