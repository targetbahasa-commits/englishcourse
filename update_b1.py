import json
import re

md_table = """
| Word           | POS       | Indonesian         |
| -------------- | --------- | ------------------ |
| Achieve        | verb      | Mencapai           |
| Adapt          | verb      | Beradaptasi        |
| Advantage      | noun      | Keuntungan         |
| Analyze        | verb      | Menganalisis       |
| Apply          | verb      | Melamar/Menerapkan |
| Approach       | noun      | Pendekatan         |
| Arrange        | verb      | Mengatur           |
| Attend         | verb      | Menghadiri         |
| Avoid          | verb      | Menghindari        |
| Behavior       | noun      | Perilaku           |
| Benefit        | noun      | Manfaat            |
| Budget         | noun      | Anggaran           |
| Career         | noun      | Karier             |
| Challenge      | noun      | Tantangan          |
| Compare        | verb      | Membandingkan      |
| Complete       | adjective | Lengkap            |
| Concern        | noun      | Kekhawatiran       |
| Confirm        | verb      | Mengonfirmasi      |
| Connect        | verb      | Menghubungkan      |
| Consider       | verb      | Mempertimbangkan   |
| Continue       | verb      | Melanjutkan        |
| Control        | verb      | Mengendalikan      |
| Create         | verb      | Menciptakan        |
| Customer       | noun      | Pelanggan          |
| Decide         | verb      | Memutuskan         |
| Demand         | noun      | Permintaan         |
| Depend         | verb      | Bergantung         |
| Describe       | verb      | Menjelaskan        |
| Develop        | verb      | Mengembangkan      |
| Difference     | noun      | Perbedaan          |
| Discuss        | verb      | Mendiskusikan      |
| Economy        | noun      | Ekonomi            |
| Education      | noun      | Pendidikan         |
| Effective      | adjective | Efektif            |
| Environment    | noun      | Lingkungan         |
| Equipment      | noun      | Peralatan          |
| Establish      | verb      | Mendirikan         |
| Evaluate       | verb      | Mengevaluasi       |
| Experience     | noun      | Pengalaman         |
| Explore        | verb      | Menjelajahi        |
| Feature        | noun      | Fitur              |
| Financial      | adjective | Keuangan           |
| Focus          | verb      | Fokus              |
| Generate       | verb      | Menghasilkan       |
| Global         | adjective | Global             |
| Government     | noun      | Pemerintah         |
| Habit          | noun      | Kebiasaan          |
| Handle         | verb      | Menangani          |
| Improve        | verb      | Meningkatkan       |
| Include        | verb      | Menyertakan        |
| Increase       | verb      | Meningkatkan       |
| Independent    | adjective | Mandiri            |
| Influence      | noun      | Pengaruh           |
| Inform         | verb      | Memberi informasi  |
| Knowledge      | noun      | Pengetahuan        |
| Language       | noun      | Bahasa             |
| Maintain       | verb      | Mempertahankan     |
| Manage         | verb      | Mengelola          |
| Method         | noun      | Metode             |
| Modern         | adjective | Modern             |
| Motivate       | verb      | Memotivasi         |
| Necessary      | adjective | Diperlukan         |
| Network        | noun      | Jaringan           |
| Opportunity    | noun      | Kesempatan         |
| Organize       | verb      | Mengorganisasi     |
| Participate    | verb      | Berpartisipasi     |
| Performance    | noun      | Kinerja            |
| Personal       | adjective | Pribadi            |
| Population     | noun      | Populasi           |
| Practical      | adjective | Praktis            |
| Predict        | verb      | Memprediksi        |
| Prepare        | verb      | Mempersiapkan      |
| Present        | verb      | Menyajikan         |
| Prevent        | verb      | Mencegah           |
| Produce        | verb      | Menghasilkan       |
| Professional   | adjective | Profesional        |
| Project        | noun      | Proyek             |
| Protect        | verb      | Melindungi         |
| Provide        | verb      | Menyediakan        |
| Quality        | noun      | Kualitas           |
| Recommend      | verb      | Merekomendasikan   |
| Reduce         | verb      | Mengurangi         |
| Relationship   | noun      | Hubungan           |
| Require        | verb      | Membutuhkan        |
| Research       | noun      | Penelitian         |
| Resource       | noun      | Sumber daya        |
| Responsibility | noun      | Tanggung jawab     |
| Result         | noun      | Hasil              |
| Review         | verb      | Meninjau           |
| Schedule       | noun      | Jadwal             |
| Solution       | noun      | Solusi             |
| Strategy       | noun      | Strategi           |
| Success        | noun      | Kesuksesan         |
| Support        | verb      | Mendukung          |
| Technology     | noun      | Teknologi          |
| Training       | noun      | Pelatihan          |
| Transportation | noun      | Transportasi       |
| Travel         | noun      | Perjalanan         |
| Typical        | adjective | Khas               |
| Update         | verb      | Memperbarui        |
| Variety        | noun      | Keberagaman        |
"""

new_b1 = []
for line in md_table.strip().split('\n'):
    if not line.startswith('|') or 'Word' in line or '---' in line:
        continue
    parts = [p.strip() for p in line.split('|')]
    if len(parts) >= 4:
        word = parts[1]
        pos = parts[2]
        meaning = parts[3]
        new_b1.append([word, meaning, pos])

json_path = 'storage/app/vocabularies/ielts_vocabularies.json'
with open(json_path, 'r', encoding='utf-8') as f:
    data = json.load(f)

data['B1'] = new_b1

with open(json_path, 'w', encoding='utf-8') as f:
    json.dump(data, f, ensure_ascii=False, indent=4)

print(f"Updated B1 with {len(new_b1)} words.")
