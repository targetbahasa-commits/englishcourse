"""
Sync corrected kokoro-tts audio to the folder that is ACTUALLY served in production.

Production serves audio from public/storage/kokoro-tts (a real directory, not a
symlink to storage/app/public). Regenerating audio locally does NOT reach the
live site until this script (or an equivalent upload) runs. Run this after any
batch of audio regeneration under storage/app/public/kokoro-tts.

Usage:
    python3 sync_kokoro_audio.py            # sync everything under kokoro-tts
    python3 sync_kokoro_audio.py --dry-run  # show what would change, upload nothing
    python3 sync_kokoro_audio.py listening-highlight-correct-summary  # limit to one subfolder
"""
import ftplib
import os
import sys

FTP_HOST = "153.92.9.128"
FTP_USER = "u822472458"
FTP_PASS = "@Dreamer19"
REMOTE_ROOT = "/domains/targetbahasa.com/public_html/public/storage/kokoro-tts"
LOCAL_ROOT = "/Applications/MAMP/htdocs/TargetBahasaCourse/storage/app/public/kokoro-tts"


def build_local_index(root):
    idx = {}
    for dirpath, _dirnames, filenames in os.walk(root):
        for fn in filenames:
            if fn in (".DS_Store", ".gitignore"):
                continue
            full = os.path.join(dirpath, fn)
            rel = os.path.relpath(full, root).replace(os.sep, "/")
            idx[rel] = os.path.getsize(full)
    return idx


def build_remote_index(ftp, root):
    idx = {}

    def walk(path, relprefix):
        try:
            entries = list(ftp.mlsd(path, facts=["size", "type"]))
        except ftplib.error_perm:
            return
        for name, facts in entries:
            if name in (".", ".."):
                continue
            rel = f"{relprefix}/{name}" if relprefix else name
            if facts.get("type") == "dir":
                walk(f"{path}/{name}", rel)
            elif facts.get("type") == "file":
                sz = facts.get("size")
                idx[rel] = int(sz) if sz is not None else None

    walk(root, "")
    return idx


def ensure_remote_dirs(ftp, remote_dir):
    parts = remote_dir.split("/")
    path = ""
    for part in parts:
        if not part:
            continue
        path += "/" + part
        try:
            ftp.mkd(path)
        except ftplib.error_perm:
            pass  # already exists


def new_connection():
    ftp = ftplib.FTP(FTP_HOST, timeout=30)
    ftp.login(user=FTP_USER, passwd=FTP_PASS)
    ftp.voidcmd("TYPE I")
    return ftp


def main():
    args = [a for a in sys.argv[1:] if not a.startswith("--")]
    dry_run = "--dry-run" in sys.argv
    subfolder = args[0] if args else None

    local_root = os.path.join(LOCAL_ROOT, subfolder) if subfolder else LOCAL_ROOT
    remote_root = f"{REMOTE_ROOT}/{subfolder}" if subfolder else REMOTE_ROOT

    print(f"Local:  {local_root}")
    print(f"Remote: {remote_root}")

    print("Indexing local files...")
    local_idx = build_local_index(local_root)
    print(f"  {len(local_idx)} local files")

    print("Connecting to FTP and indexing remote files...")
    ftp = ftplib.FTP(FTP_HOST, timeout=30)
    ftp.login(user=FTP_USER, passwd=FTP_PASS)
    remote_idx = build_remote_index(ftp, remote_root)
    print(f"  {len(remote_idx)} remote files")

    to_upload = []
    for rel, lsize in local_idx.items():
        rsize = remote_idx.get(rel)
        if rsize is None or rsize != lsize:
            to_upload.append(rel)

    print(f"\n{len(to_upload)} file(s) need uploading (new or changed).")
    if dry_run:
        for rel in to_upload:
            print(f"  would upload: {rel}")
        ftp.quit()
        return

    ftp.voidcmd("TYPE I")
    uploaded, failed = 0, []
    for i, rel in enumerate(to_upload, 1):
        local_path = os.path.join(local_root, rel)
        remote_path = f"{remote_root}/{rel}"
        remote_dir = remote_path.rsplit("/", 1)[0]

        for attempt in range(3):
            try:
                ensure_remote_dirs(ftp, remote_dir)
                with open(local_path, "rb") as f:
                    ftp.storbinary(f"STOR {remote_path}", f)
                uploaded += 1
                if i % 25 == 0 or i == len(to_upload):
                    print(f"  [{i}/{len(to_upload)}] uploaded {rel}")
                break
            except Exception as e:
                if attempt == 2:
                    failed.append((rel, str(e)))
                    print(f"  [{i}/{len(to_upload)}] FAILED {rel} after 3 attempts: {e}")
                else:
                    print(f"  [{i}/{len(to_upload)}] retry {rel} after error: {e}")
                    try:
                        ftp.quit()
                    except Exception:
                        pass
                    ftp = new_connection()

    try:
        ftp.quit()
    except Exception:
        pass
    print(f"\nDone. Uploaded {uploaded}/{len(to_upload)}.")
    if failed:
        print(f"{len(failed)} failure(s):")
        for rel, err in failed:
            print(f"  {rel}: {err}")


if __name__ == "__main__":
    main()
