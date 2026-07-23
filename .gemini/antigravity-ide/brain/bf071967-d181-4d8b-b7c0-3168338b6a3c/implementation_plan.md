# Implementasi Round-Robin dan Dedicated Groq API Keys

Kami akan merombak cara sistem membaca dan menggunakan API key Groq, agar mendukung rotasi acak (Round-Robin) untuk menghindari limit, dan pemisahan per-fitur (Separation of Concern) agar limit satu fitur tidak memengaruhi fitur lainnya.

## User Review Required
> [!IMPORTANT]
> **Format Penulisan Key**: Karena kita menggunakan fitur round-robin, pengisian API key di halaman AI Management nantinya bisa diisi lebih dari 1 key, yang dipisahkan dengan koma (`,`). Contoh pengisian: `gsk_key123...,gsk_key456...`. Apakah format pemisah dengan koma ini cocok dengan alur kerja Anda?

## Proposed Changes

### Core System (Helper & Config)

#### [NEW] [GroqHelper.php](file:///Applications/MAMP/htdocs/TargetBahasaCourse/app/Helpers/GroqHelper.php)
Kita akan membuat helper class baru khusus untuk mengelola Groq API keys. Fungsi utama:
1. Menerima request untuk fitur spesifik (`writing`, `speaking`, `listening`, atau `general`).
2. Mencari *environment variable* yang cocok: `GROQ_API_KEYS_WRITING`, dsb.
3. Jika key khusus fitur tersebut kosong, otomatis menggunakan *fallback* ke `GROQ_API_KEYS_GENERAL`.
4. Memecah string berdasarkan tanda koma (`,`) dan memilih satu key secara acak menggunakan fungsi bawaan `Arr::random()`.

---

### Integrasi Controller

Semua penggunaan *hardcoded* `env('GROQ_API_KEY')` dan `config('services.groq.key')` akan diganti dengan `GroqHelper::getRandomKey('nama_fitur')`.

#### [MODIFY] [PromoTestController.php](file:///Applications/MAMP/htdocs/TargetBahasaCourse/app/Http/Controllers/PromoTestController.php)
- Akan menggunakan `GroqHelper::getRandomKey('writing')` saat mengevaluasi skor Writing Task 2.

#### [MODIFY] [AiController.php](file:///Applications/MAMP/htdocs/TargetBahasaCourse/app/Http/Controllers/AiController.php)
- Akan menggunakan `GroqHelper::getRandomKey('general')` untuk chat, collocations, grammar check.
- Akan menggunakan `GroqHelper::getRandomKey('speaking')` untuk fallback evaluasi speaking.

#### [MODIFY] [AdminListeningMachineController.php](file:///Applications/MAMP/htdocs/TargetBahasaCourse/app/Http/Controllers/Admin/AdminListeningMachineController.php)
- Akan menggunakan `GroqHelper::getRandomKey('listening')` untuk proses *humanisation* naskah dan *generate questions*.

#### [MODIFY] [WhisperTranscriptionService.php](file:///Applications/MAMP/htdocs/TargetBahasaCourse/app/Services/WhisperTranscriptionService.php)
- Akan menggunakan `GroqHelper::getRandomKey('listening')` untuk transkripsi audio STT (Speech-to-Text).

#### [MODIFY] [IeltsWritingAiSupport.php](file:///Applications/MAMP/htdocs/TargetBahasaCourse/app/Application/IeltsWriting/IeltsWritingAiSupport.php)
- Akan menggunakan `GroqHelper::getRandomKey('writing')`.

---

### Pembaruan UI & Dashboard

#### [MODIFY] [AiManagementController.php](file:///Applications/MAMP/htdocs/TargetBahasaCourse/app/Http/Controllers/Admin/AiManagementController.php)
- Akan memisahkan form pengelolaan key Groq di Dasbor menjadi beberapa input berdasarkan fungsinya:
  1. Groq (General/Default) -> `GROQ_API_KEYS_GENERAL`
  2. Groq (Writing) -> `GROQ_API_KEYS_WRITING`
  3. Groq (Speaking) -> `GROQ_API_KEYS_SPEAKING`
  4. Groq (Listening) -> `GROQ_API_KEYS_LISTENING`
- Menambahkan validasi `AllowedKeys` untuk mendukung kunci-kunci baru ini.

#### [MODIFY] [index.blade.php](file:///Applications/MAMP/htdocs/TargetBahasaCourse/resources/views/admin/ai-management/index.blade.php)
- Akan menyesuaikan tampilan untuk mendukung penjelasan kepada pengguna bahwa input Groq mendukung format "comma separated keys" (`gsk_key1, gsk_key2, gsk_key3`) untuk rotasi round-robin.

## Verification Plan

### Automated Tests
- Menjalankan testing syntax dengan PHP lint untuk semua file yang dimodifikasi.
- Mengecek apakah fungsi helper dapat melakukan *fallback* dengan sukses jika key khusus fitur (contoh: *writing*) kosong, ia kembali menggunakan *general* key.

### Manual Verification
- Cek halaman *AI Management* untuk memastikan konfigurasi 4 kategori API Key Groq bisa disimpan dan ditampilkan dengan benar.
- Lakukan dummy simulasi untuk mendapatkan AI prompt (misal dari menu Chat atau Evaluasi) dan verifikasi API key acak mana yang terselip dalam *headers* request ke URL API Groq.
