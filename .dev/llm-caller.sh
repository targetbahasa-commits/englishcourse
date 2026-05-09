#!/bin/bash
# Fungsi untuk memanggil model lokal secara konsol
call-local-llm() {
    echo "🚀 Connecting to LMStudio at: $LLM_URL"
    curl -X POST "${LLM_URL}" \
       -H "Authorization: Bearer ${OPENAI_API_KEY:-sk-dummy}}" \
       -H "Content-Type: application/json" \
       -d '{
           "messages": [
               { "role": "user", "content": "${1:Message from CLI}" }
           ],
           "model": "claude-3-opus-mini", 
           "temperature": 0.8,
           "max_tokens": 200
       }' \
       -H "Authorization: Bearer ${OPENAI_API_KEY:-sk-dummy}}"
}
