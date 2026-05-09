#!/usr/bin/env python3
import json
import os

# ================================================================
# Indonesian meanings for each idiom
# ================================================================

BASIC_MEANING_ID = {
    "A piece of cake": "Sesuatu yang sangat mudah untuk dilakukan.",
    "Cost an arm and a leg": "Membutuhkan biaya yang sangat mahal.",
    "Break a leg": "Ucapan semoga berhasil (biasanya sebelum tampil di panggung).",
    "Hit the books": "Belajar dengan sungguh-sungguh.",
    "Let the cat out of the bag": "Membocorkan rahasia secara tidak sengaja.",
    "Hit the sack": "Pergi tidur atau beristirahat.",
    "Under the weather": "Merasa sedikit tidak sehat atau sakit.",
    "Once in a blue moon": "Sesuatu yang terjadi sangat jarang.",
    "When pigs fly": "Sesuatu yang mustahil terjadi.",
    "To feel blue": "Merasa sedih atau tertekan.",
    "Spill the beans": "Membocorkan rahasia kepada orang lain.",
    "A couch potato": "Orang yang malas dan terlalu banyak menonton televisi.",
    "Hold your horses": "Bersabar dan menunggu sebentar.",
    "In the same boat": "Berada dalam situasi sulit yang sama dengan orang lain.",
    "Bite your tongue": "Menahan diri agar tidak mengucapkan sesuatu.",
    "A blessing in disguise": "Sesuatu yang terlihat buruk pada awalnya, namun ternyata membawa kebaikan.",
    "Better late than never": "Lebih baik terlambat daripada tidak sama sekali.",
    "Bite the bullet": "Menghadapi situasi sulit atau tidak menyenangkan dengan berani.",
    "Call it a day": "Menghentikan suatu pekerjaan atau kegiatan.",
    "Cut corners": "Melakukan sesuatu dengan cepat dan asal-asalan untuk menghemat waktu atau uang.",
    "Easy does it": "Berhati-hati dan tidak tergesa-gesa.",
    "Get out of hand": "Kehilangan kendali atas suatu situasi.",
    "Go the extra mile": "Mengeluarkan usaha ekstra untuk mencapai sesuatu.",
    "Hang in there": "Jangan menyerah dalam situasi yang sulit.",
    "Make a long story short": "Menceritakan sesuatu secara singkat.",
    "No pain, no gain": "Harus bekerja keras untuk mencapai tujuan.",
    "On the ball": "Waspada, aktif, dan tanggap.",
    "Pull someone's leg": "Bercanda atau menggoda seseorang.",
    "Time flies": "Waktu berlalu dengan sangat cepat.",
    "A dime a dozen": "Sesuatu yang sangat umum dan tidak istimewa.",
    "Out of the blue": "Secara mendadak dan tidak terduga.",
    "Fish out of water": "Merasa tidak nyaman dalam situasi yang tidak familiar.",
    "It takes two to tango": "Kedua belah pihak bertanggung jawab atas situasi yang buruk.",
    "Throw in the towel": "Menyerah dan berhenti berusaha.",
    "See eye to eye": "Sepakat atau memiliki pandangan yang sama dengan seseorang.",
    "Jump the gun": "Bertindak terlalu cepat sebelum waktunya.",
    "Know the ropes": "Memahami cara melakukan suatu pekerjaan atau kegiatan.",
    "Keep an eye on": "Mengawasi atau memantau seseorang atau sesuatu dengan cermat.",
    "Learn the ropes": "Mempelajari cara melakukan pekerjaan atau tugas baru.",
    "Rule of thumb": "Aturan umum yang berdasarkan pengalaman atau praktik.",
    "Sick and tired": "Sangat jengkel dan muak terhadap seseorang atau sesuatu.",
    "Sleight of hand": "Kecepatan dan keterampilan tangan (biasanya dalam sulap).",
    "Take it easy": "Bersantai dan tidak memaksakan diri.",
    "Up in the air": "Belum diputuskan atau masih tidak pasti.",
    "Have butterflies in my stomach": "Merasa sangat gugup atau cemas.",
    "Keep your chin up": "Tetap semangat dan ceria dalam situasi yang sulit.",
    "On thin ice": "Berada dalam situasi yang berisiko atau berbahaya.",
    "Out of the woods": "Keluar dari bahaya atau kesulitan.",
    "Put your foot in your mouth": "Mengatakan sesuatu yang memalukan atau tidak pantas tanpa sengaja.",
    "Read between the lines": "Menemukan makna tersembunyi di balik sesuatu.",
}

INTERMEDIATE_MEANING_ID = {
    "Bite the bullet": "Memaksa diri menghadapi sesuatu yang sulit atau tidak menyenangkan.",
    "Call it a day": "Menghentikan pekerjaan atau kegiatan hari ini.",
    "Get out of hand": "Kehilangan kendali atas suatu situasi.",
    "Hang in there": "Jangan menyerah.",
    "Hit the nail on the head": "Melakukan atau mengatakan sesuatu dengan tepat dan benar.",
    "A blessing in disguise": "Sesuatu yang telihat buruk namun ternyata membawa kebaikan.",
    "Make a long story short": "Menceritakan sesuatu secara singkat dan ringkas.",
    "Miss the boat": "Melewatkan kesempatan yang tidak bisa datang lagi.",
    "Pull someone's leg": "Bercanda dengan membuat seseorang percaya pada sesuatu yang tidak benar.",
    "Under the weather": "Merasa tidak enak badan.",
    "Wrap your head around something": "Memahami sesuatu yang rumit atau membingungkan.",
    "You can say that again": "Itu benar, saya setuju.",
    "By the skin of your teeth": "Hampir gagal atau nyaris tidak berhasil.",
    "On the ball": "Waspada dan cepat memahami serta bereaksi.",
    "Cut corners": "Melakukan sesuatu dengan cepat dan murah untuk menghemat waktu atau uang.",
    "Cross your fingers": "Berharap sesuatu terjadi sesuai keinginan.",
    "Give it a whirl": "Mencoba sesuatu yang baru.",
    "Go down in flames": "Gagal total dan mendadak.",
    "Leave no stone unturned": "Mencari atau mencoba segala cara untuk menemukan sesuatu.",
    "Look before you leap": "Pertimbangkan akibatnya sebelum bertindak.",
    "Play it by ear": "Memutuskan cara menghadapi situasi seiring berjalannya waktu.",
    "Speak of the devil": "Diucapkan ketika seseorang muncul tepat setelah dibicarakan.",
    "Step up your game": "Mulai tampil lebih baik dan lebih serius.",
    "A penny for your thoughts": "Cara bertanya apa yang sedang dipikirkan seseorang.",
    "Actions speak louder than words": "Perbuatan seseorang lebih mencerminkan niatnya daripada ucapannya.",
    "Add fuel to the fire": "Memperburuk situasi yang sudah buruk.",
    "Comparing apples and oranges": "Membandingkan dua hal yang tidak bisa dibandingkan.",
    "Cost an arm and a leg": "Membutuhkan biaya yang sangat mahal.",
    "Elephant in the room": "Masalah nyata yang semua orang tidak mau membicarakannya.",
    "Fit as a fiddle": "Berada dalam kondisi kesehatan yang baik.",
    "Get your act together": "Mulai melakukan sesuatu dengan benar dan sungguh-sungguh.",
    "Go back to the drawing board": "Memulai dari awal karena rencana sebelumnya gagal.",
    "In the heat of the moment": "Saat terlibat dalam situasi emosional yang intens.",
    "Kill two birds with one stone": "Menyelesaikan dua hal sekaligus dengan satu tindakan.",
    "Let the chips fall where they may": "Membiarkan sesuatu terjadi tanpa peduli akibatnya.",
    "No-brainer": "Keputusan yang sangat mudah dibuat.",
    "On the fence": "Tidak bisa mengambil keputusan atau berpihak.",
    "A picture is worth a thousand words": "Sebuah gambar bisa menceritakan lebih banyak daripada kata-kata.",
    "Piece of cake": "Tugas yang dapat diselesaikan dengan sangat mudah.",
    "Rain on someone's parade": "Merusak momen bahagia atau rencana seseorang.",
    "Spill the beans": "Membocorkan rahasia kepada orang lain.",
    "Take it with a grain of salt": "Tidak sepenuhnya percaya pada apa yang diceritakan.",
    "The ball is in your court": "Sekarang giliran Anda untuk membuat keputusan atau mengambil tindakan.",
    "The best of both worlds": "Situasi di mana Anda bisa menikmati keuntungan dari dua hal berbeda.",
    "Think outside the box": "Berpikir kreatif dengan ide-ide baru di luar cara konvensional.",
    "Through thick and thin": "Mendukung seseorang dalam keadaan baik maupun buruk.",
    "Throw caution to the wind": "Mengambil risiko besar setelah sebelumnya berusaha menghindarinya.",
    "Under the table": "Dilakukan secara rahasia dan tidak resmi (biasanya menyangkut uang).",
    "Water under the bridge": "Masalah di masa lalu yang sudah tidak penting lagi.",
    "Wild goose chase": "Pencarian yang sia-sia untuk sesuatu yang tidak mungkin ditemukan.",
}

ADVANCED_MEANING_ID = {
    "Barking up the wrong tree": "Membuat pilihan yang salah atau mengejar petunjuk yang keliru.",
    "Beat around the bush": "Menghindari topik utama dengan berbicara hal yang tidak relevan.",
    "Bite off more than you can chew": "Mengambil tugas atau tanggung jawab yang melebihi kemampuan.",
    "Burn the midnight oil": "Bekerja atau belajar hingga larut malam.",
    "Caught between a rock and a hard place": "Menghadapi pilihan antara dua situasi yang sama-sama tidak menyenangkan.",
    "Cross that bridge when you come to it": "Menangani masalah hanya ketika masalah itu benar-benar terjadi.",
    "Don't count your chickens before they hatch": "Jangan bergantung pada sesuatu sebelum kamu yakin itu akan terjadi.",
    "Give the benefit of the doubt": "Mempercayai pernyataan seseorang meski tanpa bukti.",
    "Jump on the bandwagon": "Ikut-ikutan tren atau kegiatan populer.",
    "Kill two birds with one stone": "Menyelesaikan dua hal berbeda dalam satu tindakan.",
    "Let sleeping dogs lie": "Membiarkan masalah lama tidak diungkit agar tidak memperburuk keadaan.",
    "Steal someone's thunder": "Mengalihkan perhatian dari seseorang, biasanya demi keuntungan sendiri.",
    "Take it with a grain of salt": "Tidak menganggap sesuatu terlalu serius atau memandangnya dengan skeptis.",
    "Through thick and thin": "Tetap setia apapun yang terjadi.",
    "A drop in the ocean": "Jumlah yang sangat kecil dibandingkan dengan yang dibutuhkan.",
    "A taste of your own medicine": "Diperlakukan buruk dengan cara yang sama seperti kamu memperlakukan orang lain.",
    "Add insult to injury": "Memperburuk situasi yang sudah tidak menguntungkan.",
    "All in the same boat": "Ketika semua orang menghadapi tantangan yang sama.",
    "Bite the dust": "Mati, gagal, atau dikalahkan.",
    "Blow off steam": "Melakukan atau mengatakan sesuatu untuk melepaskan perasaan atau energi yang kuat.",
    "Break the ice": "Memulai percakapan dalam situasi yang kaku atau canggung.",
    "By the book": "Dilakukan secara ketat sesuai aturan.",
    "Cry wolf": "Meminta bantuan padahal tidak benar-benar membutuhkannya, sehingga orang tidak mempercayai Anda.",
    "Cut to the chase": "Langsung menuju pokok permasalahan.",
    "Devil's advocate": "Mengajukan argumen tandingan hanya untuk memancing diskusi atau menguji kekuatan argumen awal.",
    "Drive someone up the wall": "Membuat seseorang sangat marah atau frustrasi.",
    "Every cloud has a silver lining": "Setiap situasi negatif berpotensi menghasilkan atau mengandung sesuatu yang positif.",
    "Fair-weather friend": "Teman yang tidak bisa diandalkan saat menghadapi kesulitan.",
    "Go wild": "Bertindak dengan cara yang sangat bersemangat dan tidak terkendali.",
    "In the fast lane": "Menjalani hidup yang penuh dengan kegembiraan, bahaya, dan uang.",
    "It's not rocket science": "Digunakan untuk menyatakan bahwa sesuatu tidak terlalu sulit dilakukan atau dipahami.",
    "Just around the corner": "Akan segera terjadi atau datang.",
    "Keep your ear to the ground": "Memperhatikan apa yang sedang terjadi di sekitar Anda.",
    "Leave someone high and dry": "Meninggalkan seseorang dalam situasi sulit tanpa bantuan apapun.",
    "Make ends meet": "Memiliki uang yang cukup untuk memenuhi kebutuhan dasar.",
    "Method to the madness": "Meski pendekatannya tampak acak, sebenarnya ada strukturnya.",
    "Off the top of my head": "Dari ingatan atau pengetahuan yang ada di benak Anda.",
    "On the back burner": "Memiliki prioritas rendah; ditunda untuk sementara.",
    "Out of the blue": "Sama sekali tidak terduga.",
    "Pull yourself together": "Tenangkan diri dan bersikap normal kembali.",
    "Put all your eggs in one basket": "Mempertaruhkan segalanya pada satu usaha saja.",
    "See eye to eye": "Sepenuhnya sepakat.",
    "Take someone under your wing": "Membantu dan melindungi seseorang yang lebih muda atau kurang berpengalaman.",
    "The tip of the iceberg": "Bagian kecil yang terlihat dari suatu masalah, padahal ukuran sebenarnya jauh lebih besar.",
    "Throw someone under the bus": "Menyalahkan orang lain untuk menyelamatkan diri sendiri.",
    "Under the table": "Secara rahasia dan tidak resmi.",
    "Up in the air": "Tidak pasti; bisa berubah sewaktu-waktu.",
    "Water under the bridge": "Hal-hal dari masa lalu yang tidak lagi penting atau signifikan.",
    "When pigs fly": "Sesuatu yang tidak akan pernah terjadi.",
    "Wild goose chase": "Pengejaran yang sia-sia dan tanpa harapan terhadap sesuatu yang tidak bisa dicapai.",
}

def add_meaning_id_to_file(filepath, mapping):
    with open(filepath, 'r', encoding='utf-8') as f:
        data = json.load(f)
    
    updated = 0
    for item in data:
        idiom = item.get('idiom', '')
        if idiom in mapping:
            item['meaning_id'] = mapping[idiom]
            updated += 1
        elif 'meaning_id' not in item:
            item['meaning_id'] = item.get('meaning', '')  # fallback
    
    with open(filepath, 'w', encoding='utf-8') as f:
        json.dump(data, f, ensure_ascii=False, indent=4)
    
    print(f"  Updated {updated}/{len(data)} idioms in {os.path.basename(filepath)}")
    return data

base_dir = os.path.dirname(os.path.abspath(__file__))

print("Adding meaning_id to idiom JSON files...")

add_meaning_id_to_file(
    os.path.join(base_dir, 'storage/app/basic_idioms.json'),
    BASIC_MEANING_ID
)
add_meaning_id_to_file(
    os.path.join(base_dir, 'storage/app/intermediate_idioms.json'),
    INTERMEDIATE_MEANING_ID
)
add_meaning_id_to_file(
    os.path.join(base_dir, 'storage/app/advanced_idioms.json'),
    ADVANCED_MEANING_ID
)

print("\nDone! All files updated with meaning_id.")
