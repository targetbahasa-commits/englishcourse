# TOEFL Listening CLI Guide

Panduan ini dipakai ketika kamu ingin set audio/transcript TOEFL Listening tanpa upload lewat UI.

## Lokasi Folder

Semua aset harus berada di:

`public/audio/toefl/listening/meeting-{meeting}/set-{set}`

Contoh Meeting 3 Set 2:

`public/audio/toefl/listening/meeting-3/set-2`

## Script Utama (Disarankan)

Gunakan script gabungan:

`link_toefl_listening_set_assets.php`

Atau gunakan shortcut wrapper yang lebih singkat:

`./tools/toefl-set`

Format:

```bash
php link_toefl_listening_set_assets.php <meeting> <set> [--audio <file>] [--transcript-en <file>] [--transcript-id <file>]
```

Format shortcut:

```bash
./tools/toefl-set <meeting> <set> [--audio <file>] [--transcript-en <file>] [--transcript-id <file>]
```

Contoh:

```bash
# Audio saja
php link_toefl_listening_set_assets.php 3 2 --audio ~/Downloads/m3s2.mp3

# Audio saja (shortcut)
./tools/toefl-set 3 2 --audio ~/Downloads/m3s2.mp3

# Audio + transcript EN
php link_toefl_listening_set_assets.php 3 2 --audio ~/Downloads/m3s2.mp3 --transcript-en ~/Downloads/en.srt

# Transcript EN + ID
php link_toefl_listening_set_assets.php 3 2 --transcript-en ~/Downloads/en.srt --transcript-id ~/Downloads/id.srt
```

## Script Terpisah (Opsional)

1) Audio saja:

```bash
php link_toefl_listening_audio.php <meeting> <set> <filename-atau-source-path>
```

2) Transcript saja:

```bash
php link_toefl_listening_transcript.php <meeting> <set> <en|id> <filename-atau-source-path>
```

## Bantuan Cepat

```bash
php link_toefl_listening_audio.php --help
php link_toefl_listening_transcript.php --help
php link_toefl_listening_set_assets.php --help
```

## Alias Global (Opsional)

Jika kamu menambahkan alias zsh:

`alias toefl-set="/Applications/MAMP/htdocs/TargetBahasaCourse/tools/toefl-set"`

Maka command bisa dipakai dari folder mana pun:

```bash
toefl-set 3 2 --audio ~/Downloads/m3s2.mp3 --transcript-en ~/Downloads/en.srt
```

## Import Batch Dari Folder Source

Karena nama file Source tidak selalu memuat nomor meeting/set, gunakan mapping TSV agar aman.

1) Duplikasi template:

```bash
cp tools/toefl-batch-template.tsv tools/toefl-batch.tsv
```

2) Edit file `tools/toefl-batch.tsv` lalu isi kolom:

- `meeting`
- `set`
- `audio_source`
- `transcript_en_source`
- `transcript_id_source`

3) Cek dulu tanpa eksekusi:

```bash
./tools/toefl-batch-apply tools/toefl-batch.tsv --dry-run
```

4) Jalankan import batch:

```bash
./tools/toefl-batch-apply tools/toefl-batch.tsv --apply
```

## Catatan Penting

1. Script akan update semua row soal pada meeting/set target.
2. Audio file yang didukung: `mp3`, `wav`, `ogg`, `m4a`.
3. Source transcript boleh berekstensi `srt` atau `txt` (mis. `*.srt.txt`).
4. Transcript akan disimpan sebagai:
   - `transcript-en.srt`
   - `transcript-id.srt`
5. Isi transcript di database akan disimpan dalam format parse (JSON blok timestamp) bila format SRT valid.