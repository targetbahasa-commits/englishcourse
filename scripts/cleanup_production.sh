#!/usr/bin/env bash
# Jalankan di SERVER PRODUKSI, di dalam folder public_html (docroot).
# Menghapus file debug/utility berbahaya. Tinjau dulu sebelum menjalankan.
set -e
FILES=(
  db_import.php db_debug.php drop_constraints.php add_column.php
  phpinfo.php opcache_reset.php get_laravel_log.php debug_storage.php
  debug_error.php debug_student_js.php clear-cache.php clear_cache.php
  clear_view.php check_file.php test.php test_admin_json.php test_admin_json2.php
  test_autosave_check.php test_draft_direct.php test_js_error.php test_log.php
  test_render_meeting3.php test_session.php test_vite_check.php test_vocab_web.php
)
for f in "${FILES[@]}"; do
  if [ -f "$f" ]; then rm -f "$f" && echo "dihapus: $f"; fi
done
# Hapus juga file config/log/sql yang tidak boleh ada di docroot:
for f in live.env .env data_import_with_cols.sql laravel.log production.log; do
  [ -f "$f" ] && echo "PERINGATAN: ada $f di docroot — pindahkan ke luar public_html!"
done
echo "Selesai. Pastikan docroot mengarah ke folder public/ Laravel, bukan root project."
