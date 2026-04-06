#!/usr/bin/env python3
"""
Convert SQLite database to MySQL-compatible SQL dump.
Run: python3 export_to_mysql.py
Output: database_mysql_export.sql
"""

import sqlite3
import re
import datetime

SQLITE_FILE = 'database/database.sqlite'
OUTPUT_FILE = 'database_mysql_export.sql'

# Tables to skip (runtime/session tables, recreated by migrations)
SKIP_TABLES = {
    'migrations', 'sessions', 'cache', 'cache_locks',
    'jobs', 'job_batches', 'failed_jobs', 'password_reset_tokens',
    'otps', 'notifications', 'broadcast_messages',
}

def escape_value(val):
    if val is None:
        return 'NULL'
    if isinstance(val, bool):
        return '1' if val else '0'
    if isinstance(val, int):
        return str(val)
    if isinstance(val, float):
        return str(val)
    # String: escape backslash, single quotes, and special chars
    val = str(val)
    val = val.replace('\\', '\\\\')
    val = val.replace("'", "\\'")
    val = val.replace('\0', '')
    return f"'{val}'"

def get_tables(conn):
    rows = conn.execute(
        "SELECT name FROM sqlite_master WHERE type='table' AND name NOT LIKE 'sqlite_%' ORDER BY name"
    ).fetchall()
    return [r[0] for r in rows]

def export_table(conn, table, out):
    rows = conn.execute(f'SELECT * FROM "{table}"').fetchall()
    if not rows:
        out.write(f'-- Table `{table}`: empty, skipped\n\n')
        return

    # Get column names
    cursor = conn.execute(f'SELECT * FROM "{table}" LIMIT 0')
    cols = [desc[0] for desc in cursor.description]
    col_list = ', '.join(f'`{c}`' for c in cols)

    out.write(f'-- Table: {table} ({len(rows)} rows)\n')
    out.write(f'DELETE FROM `{table}`;\n')

    chunk_size = 100
    for i in range(0, len(rows), chunk_size):
        chunk = rows[i:i+chunk_size]
        values_list = []
        for row in chunk:
            values = ', '.join(escape_value(v) for v in row)
            values_list.append(f'({values})')
        out.write(f'INSERT INTO `{table}` ({col_list}) VALUES\n')
        out.write(',\n'.join(values_list))
        out.write(';\n')

    out.write('\n')

def main():
    conn = sqlite3.connect(SQLITE_FILE)
    tables = get_tables(conn)

    with open(OUTPUT_FILE, 'w', encoding='utf-8') as out:
        out.write(f'-- MySQL Data Export from SQLite\n')
        out.write(f'-- Generated: {datetime.datetime.now()}\n')
        out.write(f'-- Run AFTER php artisan migrate on production\n\n')
        out.write('SET FOREIGN_KEY_CHECKS=0;\n')
        out.write('SET NAMES utf8mb4;\n\n')

        for table in tables:
            if table in SKIP_TABLES:
                print(f'  SKIP: {table}')
                continue
            count = conn.execute(f'SELECT COUNT(*) FROM "{table}"').fetchone()[0]
            print(f'  Exporting: {table} ({count} rows)')
            export_table(conn, table, out)

        out.write('SET FOREIGN_KEY_CHECKS=1;\n')

    conn.close()
    print(f'\nExport selesai: {OUTPUT_FILE}')

if __name__ == '__main__':
    main()
