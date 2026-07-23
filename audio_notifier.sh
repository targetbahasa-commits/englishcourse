#!/bin/bash
notified_1000=0
notified_2000=0
notified_2700=0

while true; do
    count=$(ls -1 public/storage/kokoro-tts/*.mp3 2>/dev/null | wc -l)
    
    if [ "$count" -ge 1000 ] && [ "$notified_1000" -eq 0 ]; then
        osascript -e 'display notification "Telah mencapai 1000 file audio!" with title "Target Bahasa TTS"'
        notified_1000=1
    fi
    
    if [ "$count" -ge 2000 ] && [ "$notified_2000" -eq 0 ]; then
        osascript -e 'display notification "Telah mencapai 2000 file audio!" with title "Target Bahasa TTS"'
        notified_2000=1
    fi
    
    if [ "$count" -ge 2650 ] && [ "$notified_2700" -eq 0 ]; then
        osascript -e 'display notification "Semua file audio sudah selesai dibuat!" with title "Target Bahasa TTS"'
        notified_2700=1
        break
    fi
    
    sleep 60
done
