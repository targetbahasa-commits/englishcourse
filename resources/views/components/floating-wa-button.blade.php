@if(setting('live_chat_enabled', '1') === '1')
@auth
<style>
/* ===== MULTI-CHANNEL IN-APP CHAT WIDGET ===== */
#tb-chat-wrapper {
    position: fixed;
    bottom: 90px;
    right: 24px;
    width: 350px;
    height: 500px;
    z-index: 10000;
    pointer-events: none;
}
.tb-chat-panel {
    position: absolute;
    bottom: 0;
    right: 0;
    width: 100%;
    height: 100%;
    background: #fff;
    border-radius: 18px;
    overflow: hidden;
    box-shadow: 0 16px 50px rgba(0,0,0,0.22);
    font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
    display: flex;
    flex-direction: column;
    pointer-events: auto;
    transition: transform 0.3s cubic-bezier(.34,1.56,.64,1), opacity 0.3s ease;
}
.tb-panel-hidden {
    opacity: 0;
    pointer-events: none;
    transform: translateY(20px) scale(0.95);
}
.tb-panel-visible {
    opacity: 1;
    pointer-events: auto;
    transform: translateY(0) scale(1);
}

/* Header */
.tb-chat-header {
    background: linear-gradient(135deg,#1e40af,#3b82f6);
    padding: 14px 16px;
    display: flex;
    align-items: center;
    gap: 11px;
    color: white;
    flex-shrink: 0;
}
.tb-back-btn {
    background: none; border: none; color: white; cursor: pointer;
    display: flex; align-items: center; justify-content: center;
    padding: 4px; border-radius: 50%; transition: background 0.2s;
    margin-left: -8px;
}
.tb-back-btn:hover { background: rgba(255,255,255,0.2); }

/* Body Areas */
.tb-chat-body {
    flex: 1;
    background: #f8fafc;
    overflow-y: auto;
    display: flex;
    flex-direction: column;
}
.tb-chat-body::-webkit-scrollbar { width:4px; }
.tb-chat-body::-webkit-scrollbar-thumb { background:rgba(0,0,0,0.15); border-radius:4px; }

/* Contact List Items */
.tb-contact-item {
    display: flex; align-items: center; gap: 12px;
    padding: 12px 16px; border-bottom: 1px solid #f1f5f9;
    cursor: pointer; transition: background 0.2s;
    background: #fff;
}
.tb-contact-item:hover { background: #f8fafc; }
.tb-avatar {
    width: 42px; height: 42px; border-radius: 50%;
    background: #bfdbfe; color: #1e40af;
    display: flex; align-items: center; justify-content: center;
    font-size: 18px; font-weight: bold; flex-shrink: 0;
}
.tb-avatar.group { background: #fef08a; color: #854d0e; }
.tb-avatar.admin { background: #fecdd3; color: #be123c; }

/* Messages */
.tb-message-area {
    padding: 14px 12px;
    display: flex;
    flex-direction: column;
    gap: 10px;
}
.tb-msg { display:flex; flex-direction:column; max-width:82%; }
.tb-msg.from-me { align-self:flex-end; }
.tb-msg.from-them  { align-self:flex-start; }
.tb-bubble-inner {
    padding: 9px 13px;
    border-radius: 12px;
    font-size: 13.5px;
    line-height: 1.5;
    box-shadow: 0 1px 3px rgba(0,0,0,0.1);
    word-wrap: break-word;
}
.from-them .tb-bubble-inner {
    background:#fff; color:#1e293b;
    border-radius: 0 12px 12px 12px;
}
.from-me .tb-bubble-inner {
    background:#3b82f6; color:#fff;
    border-radius: 12px 0 12px 12px;
}
.tb-msg-time { font-size:11px; color:#94a3b8; margin-top:3px; }
.from-them .tb-msg-time { text-align:left; padding-left:2px; }
.from-me  .tb-msg-time { text-align:right; padding-right:2px; }

/* Footer Input */
.tb-chat-footer {
    background:#fff;
    padding:10px 12px;
    display:flex;
    gap:8px;
    align-items:flex-end;
    border-top:1px solid #e2e8f0;
}
.tb-message-input {
    flex:1; border:1px solid #e2e8f0; border-radius:22px;
    padding:9px 14px; font-size:13.5px;
    resize:none; outline:none; max-height:90px;
    line-height:1.4; background:#f8fafc;
    font-family:inherit; transition:border .2s;
}
.tb-message-input:focus { border-color:#3b82f6; background:#fff; }
.tb-send-btn {
    width:40px;height:40px;border-radius:50%;
    background:#3b82f6; border:none; cursor:pointer;
    display:flex;align-items:center;justify-content:center;
    flex-shrink:0; transition:background .2s, transform .15s;
}
.tb-send-btn:hover { background:#1d4ed8; transform:scale(1.08); }
.tb-send-btn:disabled { background:#94a3b8; cursor:default; transform:none; }

/* Floating toggle button */
#tb-float-btn {
    position:fixed; bottom:24px; right:24px; z-index:10001;
    width:58px; height:58px; border-radius:50%;
    background:linear-gradient(135deg,#1e40af,#3b82f6); border:none; cursor:pointer;
    display:flex; align-items:center; justify-content:center;
    box-shadow:0 4px 22px rgba(59,130,246,0.5);
    transition:all .3s ease;
}
#tb-float-btn:hover { transform:scale(1.1); box-shadow:0 6px 28px rgba(59,130,246,0.6); }
#tb-badge {
    position:absolute; top:-3px; right:-3px;
    min-width:18px; height:18px; background:#ef4444;
    border-radius:50px; border:2px solid #fff;
    font-size:10px; font-weight:800; color:#fff;
    display:flex; align-items:center; justify-content:center;
    padding: 0 4px;
}
</style>

<div x-data="tbChatWidget()" x-init="initWidget()">
    
    <!-- Floating Chat Button -->
    <button id="tb-float-btn" @click="toggleOpen()" title="Pesan">
        <span id="tb-badge" x-show="totalUnread > 0" x-text="totalUnread" style="display:none;"></span>
        <svg x-show="!isOpen" width="26" height="26" fill="none" viewBox="0 0 24 24">
            <path fill="white" d="M20 2H4C2.9 2 2 2.9 2 4v18l4-4h14c1.1 0 2-.9 2-2V4c0-1.1-.9-2-2-2zm-2 12H6v-2h12v2zm0-3H6V9h12v2zm0-3H6V6h12v2z"/>
        </svg>
        <svg x-show="isOpen" width="22" height="22" fill="none" viewBox="0 0 24 24" style="display:none;">
            <path stroke="white" stroke-width="2.5" stroke-linecap="round" d="M18 6L6 18M6 6l12 12"/>
        </svg>
    </button>

    <!-- Chat Wrapper -->
    <div id="tb-chat-wrapper">
        
        <!-- PANEL 1: Conversations & Search List -->
        <div class="tb-chat-panel" :class="isOpen && view === 'list' ? 'tb-panel-visible' : 'tb-panel-hidden'">
            <div class="tb-chat-header" style="justify-content: space-between;">
                <h4 style="font-weight:700; margin:0; font-size:16px;">Pesan</h4>
                <button @click="toggleOpen()" style="background:none;border:none;color:white;cursor:pointer;font-size:20px;line-height:1;">✕</button>
            </div>
            
            <!-- Search Bar -->
            <div style="padding:10px; background:#fff; border-bottom:1px solid #f1f5f9;">
                <input type="text" x-model="searchQuery" @input.debounce.300ms="doSearch()" placeholder="Cari teman atau guru..." 
                    style="width:100%; padding:8px 14px; border-radius:20px; border:1px solid #e2e8f0; font-size:13px; background:#f8fafc; outline:none;">
            </div>

            <div class="tb-chat-body">
                <!-- Search Results -->
                <div x-show="searchQuery.length > 0">
                    <div style="padding:8px 12px; font-size:11px; font-weight:bold; color:#94a3b8; text-transform:uppercase;">Hasil Pencarian</div>
                    <template x-for="user in searchResults" :key="user.id">
                        <div class="tb-contact-item" @click="openChat('user', user.id, user.name)">
                            <div class="tb-avatar" x-text="user.name.charAt(0).toUpperCase()"></div>
                            <div style="flex:1; min-width:0;">
                                <div style="font-size:14px; font-weight:600; color:#1e293b; white-space:nowrap; overflow:hidden; text-overflow:ellipsis;" x-text="user.name"></div>
                                <div style="font-size:12px; color:#64748b;" x-text="user.role"></div>
                            </div>
                        </div>
                    </template>
                    <div x-show="searchResults.length === 0" style="padding:20px; text-align:center; color:#94a3b8; font-size:13px;">Tidak ditemukan.</div>
                </div>

                <!-- Recent Conversations -->
                <div x-show="searchQuery.length === 0">
                    <template x-for="conv in conversations" :key="conv.type + '_' + conv.id">
                        <div class="tb-contact-item" @click="openChat(conv.type, conv.id, conv.name)">
                            <div class="tb-avatar" :class="conv.type" x-text="conv.type === 'admin' ? 'A' : (conv.type === 'group' ? 'G' : conv.name.charAt(0).toUpperCase())"></div>
                            <div style="flex:1; min-width:0;">
                                <div style="display:flex; justify-content:space-between; align-items:center;">
                                    <div style="font-size:14px; font-weight:600; color:#1e293b; white-space:nowrap; overflow:hidden; text-overflow:ellipsis;" x-text="conv.name"></div>
                                    <div x-show="conv.unread > 0" style="background:#ef4444; color:white; font-size:10px; font-weight:bold; padding:2px 6px; border-radius:10px;" x-text="conv.unread"></div>
                                </div>
                                <div style="font-size:12px; color:#64748b; white-space:nowrap; overflow:hidden; text-overflow:ellipsis;" x-text="conv.email || (conv.type === 'group' ? 'Grup Kelas' : '')"></div>
                            </div>
                        </div>
                    </template>
                    <div x-show="conversations.length === 0" style="padding:30px; text-align:center; color:#94a3b8; font-size:13px;">
                        Memuat percakapan...
                    </div>
                </div>
            </div>
        </div>

        <!-- PANEL 2: Active Chat Room -->
        <div class="tb-chat-panel" :class="isOpen && view === 'chat' ? 'tb-panel-visible' : 'tb-panel-hidden'">
            <div class="tb-chat-header">
                <button class="tb-back-btn" @click="goBack()">
                    <svg width="24" height="24" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/></svg>
                </button>
                <div class="tb-avatar" :class="activeType" style="width:34px;height:34px;font-size:15px;" x-text="activeType === 'admin' ? 'A' : (activeType === 'group' ? 'G' : activeName.charAt(0).toUpperCase())"></div>
                <div style="flex:1; min-width:0;">
                    <h4 style="font-size:15px; font-weight:700; margin:0; white-space:nowrap; overflow:hidden; text-overflow:ellipsis;" x-text="activeName"></h4>
                    <p style="font-size:11px; color:rgba(255,255,255,0.8); margin:0;" x-text="activeType === 'group' ? 'Grup Kelas' : 'Active'"></p>
                </div>
            </div>

            <div class="tb-chat-body tb-message-area" id="tb-message-area">
                <template x-for="msg in messages" :key="msg.id">
                    <div class="tb-msg" :class="msg.from_me ? 'from-me' : 'from-them'">
                        <div class="tb-bubble-inner">
                            <!-- Show sender name in group chats if not from me -->
                            <div x-show="!msg.from_me && activeType === 'group'" style="font-size:11px; font-weight:bold; color:#3b82f6; margin-bottom:2px;" x-text="msg.sender"></div>
                            <span x-html="escapeHtml(msg.content)"></span>
                        </div>
                        <div class="tb-msg-time" x-text="msg.time"></div>
                    </div>
                </template>
                <div x-show="messages.length === 0" style="text-align:center; color:#94a3b8; font-size:13px; padding:30px 0;">Belum ada pesan. Mulai obrolan! 👋</div>
            </div>

            <div class="tb-chat-footer">
                <textarea class="tb-message-input" x-model="inputText" placeholder="Ketik pesan..." rows="1"
                    @keydown.enter.prevent="sendMessage()" x-ref="msgInput"></textarea>
                <button class="tb-send-btn" @click="sendMessage()" :disabled="!inputText.trim() || sending">
                    <svg width="18" height="18" fill="white" viewBox="0 0 24 24">
                        <path d="M2.01 21L23 12 2.01 3 2 10l15 2-15 2z"/>
                    </svg>
                </button>
            </div>
        </div>

    </div>
</div>

<script>
function tbChatWidget() {
    return {
        isOpen: false,
        view: 'list', // 'list' or 'chat'
        
        conversations: [],
        searchResults: [],
        searchQuery: '',
        
        activeType: null,
        activeId: null,
        activeName: '',
        
        messages: [],
        inputText: '',
        sending: false,
        pollInterval: null,
        
        csrf: document.querySelector('meta[name="csrf-token"]') ? document.querySelector('meta[name="csrf-token"]').getAttribute('content') : '',

        get totalUnread() {
            return this.conversations.reduce((sum, c) => sum + (c.unread || 0), 0);
        },

        initWidget() {
            this.loadConversations();
            // Background polling for notifications
            setInterval(() => {
                if (!this.isOpen || this.view === 'list') {
                    this.loadConversations();
                } else if (this.isOpen && this.view === 'chat') {
                    this.pollMessages();
                }
            }, 5000);
        },

        toggleOpen() {
            this.isOpen = !this.isOpen;
            if (this.isOpen) {
                this.loadConversations();
                if (this.view === 'chat') this.pollMessages();
            }
        },

        goBack() {
            this.view = 'list';
            this.activeType = null;
            this.activeId = null;
            this.loadConversations();
        },

        loadConversations() {
            fetch('/api/chat/conversations', { headers:{'Accept':'application/json'} })
                .then(r => r.json())
                .then(data => {
                    this.conversations = data.conversations || [];
                }).catch(()=>{});
        },

        doSearch() {
            if (this.searchQuery.length < 2) {
                this.searchResults = [];
                return;
            }
            fetch('/api/chat/search?q=' + encodeURIComponent(this.searchQuery), { headers:{'Accept':'application/json'} })
                .then(r => r.json())
                .then(data => {
                    this.searchResults = data.users || [];
                }).catch(()=>{});
        },

        openChat(type, id, name) {
            this.activeType = type;
            this.activeId = id;
            this.activeName = name;
            this.view = 'chat';
            this.messages = [];
            this.searchQuery = '';
            
            // Clear badge optimistically
            const c = this.conversations.find(x => x.type === type && x.id === id);
            if(c) c.unread = 0;

            this.pollMessages();
            setTimeout(() => {
                if(this.$refs.msgInput) this.$refs.msgInput.focus();
            }, 300);
        },

        pollMessages() {
            if(!this.activeType) return;
            let url = `/api/chat/messages?type=${this.activeType}`;
            if (this.activeId && this.activeType !== 'admin') url += `&target_id=${this.activeId}`;
            
            fetch(url, { headers:{'Accept':'application/json'} })
                .then(r => r.json())
                .then(data => {
                    const oldLen = this.messages.length;
                    this.messages = data.messages || [];
                    if (this.messages.length > oldLen) {
                        this.scrollToBottom();
                    }
                }).catch(()=>{});
        },

        sendMessage() {
            if (!this.inputText.trim() || this.sending) return;
            this.sending = true;

            const text = this.inputText.trim();
            this.inputText = '';

            // Optimistic update
            this.messages.push({
                id: Date.now(),
                content: text,
                from_me: true,
                time: new Date().toLocaleTimeString([], {hour: '2-digit', minute:'2-digit'})
            });
            this.scrollToBottom();

            const payload = {
                type: this.activeType,
                content: text
            };
            if (this.activeId && this.activeType !== 'admin') {
                payload.target_id = this.activeId;
            }

            fetch('/api/chat/send', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': this.csrf,
                    'Accept': 'application/json'
                },
                body: JSON.stringify(payload)
            }).finally(() => {
                this.sending = false;
                this.pollMessages();
            });
        },

        scrollToBottom() {
            setTimeout(() => {
                const b = document.getElementById('tb-message-area');
                if(b) b.scrollTop = b.scrollHeight;
            }, 50);
        },

        escapeHtml(s) {
            return String(s).replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;').replace(/\n/g,'<br>');
        }
    }
}
</script>
@endauth
@endif
