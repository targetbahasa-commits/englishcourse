@extends('layouts.admin')

@section('content')
<div class="px-4 py-6 md:px-8 max-w-7xl mx-auto" x-data="chatAdmin()">
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Live Chat</h1>
            <p class="text-sm text-gray-500 mt-1">Kelola pesan dari pengguna</p>
        </div>
        <div>
            <button @click="toggleLiveChat()" 
                    :class="isLiveChatEnabled ? 'bg-green-100 text-green-700 hover:bg-green-200' : 'bg-red-100 text-red-700 hover:bg-red-200'"
                    class="px-4 py-2 rounded-xl text-sm font-semibold transition flex items-center gap-2"
                    :disabled="toggling">
                <div class="w-2 h-2 rounded-full animate-pulse" :class="isLiveChatEnabled ? 'bg-green-500' : 'bg-red-500'"></div>
                <span x-text="isLiveChatEnabled ? 'Live Chat Aktif (Klik untuk Matikan)' : 'Live Chat Nonaktif (Klik untuk Nyalakan)'"></span>
            </button>
        </div>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 flex flex-col md:flex-row overflow-hidden" style="height: 75vh;">
        <!-- Sidebar: Conversations List -->
        <div class="w-full md:w-1/3 border-r border-gray-100 flex flex-col" :class="{ 'hidden md:flex': activeUserId }">
            <div class="p-4 border-b border-gray-100">
                <input type="text" x-model="searchQuery" placeholder="Cari pengguna..." class="w-full bg-gray-50 border-none rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-blue-100">
            </div>

            <div class="flex-1 overflow-y-auto">
                <template x-for="conv in filteredConversations()" :key="conv.user_id">
                    <button @click="selectUser(conv)"
                            class="w-full text-left p-4 border-b border-gray-50 hover:bg-gray-50 transition flex items-start gap-3"
                            :class="{ 'bg-blue-50 border-l-4 border-l-blue-600': activeUserId === conv.user_id }">
                        <div class="w-10 h-10 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center font-bold flex-shrink-0 text-lg">
                            <span x-text="conv.name.charAt(0).toUpperCase()"></span>
                        </div>
                        <div class="flex-1 min-w-0">
                            <div class="flex justify-between items-center mb-0.5">
                                <h4 class="text-sm font-semibold text-gray-900 truncate" x-text="conv.name"></h4>
                                <span class="text-[11px] text-gray-400" x-text="formatTime(conv.last_at)"></span>
                            </div>
                            <p class="text-xs text-gray-500 truncate" x-text="conv.email"></p>
                        </div>
                        <div x-show="conv.unread > 0" class="bg-red-500 text-white text-[10px] font-bold px-2 py-0.5 rounded-full" x-text="conv.unread"></div>
                    </button>
                </template>
                <div x-show="conversations.length === 0" class="p-6 text-center text-gray-500 text-sm">
                    Belum ada percakapan.
                </div>
                <div x-show="conversations.length > 0 && filteredConversations().length === 0" class="p-6 text-center text-gray-500 text-sm">
                    Tidak ada pengguna yang cocok dengan pencarian.
                </div>
            </div>
        </div>

        <!-- Main Chat Area -->
        <div class="flex-1 flex flex-col bg-gray-50/50" :class="{ 'hidden md:flex': !activeUserId }">
            <!-- Header -->
            <div x-show="activeUserId" class="bg-white p-4 border-b border-gray-100 flex items-center gap-3">
                <button @click="activeUserId = null" class="md:hidden text-gray-400 hover:text-gray-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
                </button>
                <div class="w-10 h-10 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center font-bold text-lg">
                    <span x-text="activeUserName.charAt(0).toUpperCase()"></span>
                </div>
                <div>
                    <h3 class="font-bold text-gray-900 leading-tight" x-text="activeUserName"></h3>
                    <p class="text-xs text-green-500 font-medium">Active</p>
                </div>
            </div>

            <!-- Messages List -->
            <div x-show="activeUserId" class="flex-1 overflow-y-auto p-4 space-y-4" id="admin-chat-body">
                <template x-for="msg in messages" :key="msg.id">
                    <div class="flex flex-col max-w-[80%]" :class="msg.from_me ? 'self-end items-end' : 'self-start items-start'">
                        <span x-show="!msg.from_me && msg.sender !== activeUserName" class="text-[11px] font-semibold text-blue-500 mb-0.5" x-text="msg.sender"></span>
                        <div class="px-4 py-2.5 rounded-2xl text-[14px] leading-relaxed shadow-sm"
                             :class="msg.from_me ? 'bg-blue-600 text-white rounded-br-none' : 'bg-white text-gray-800 rounded-bl-none border border-gray-100'"
                             x-html="escapeHtml(msg.content)">
                        </div>
                        <span class="text-[11px] text-gray-400 mt-1" x-text="msg.time"></span>
                    </div>
                </template>
            </div>

            <!-- Empty State -->
            <div x-show="!activeUserId" class="flex-1 flex items-center justify-center flex-col text-gray-400">
                <svg class="w-16 h-16 mb-4 text-gray-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path></svg>
                <p>Pilih percakapan untuk mulai membalas</p>
            </div>

            <!-- Reply Input -->
            <div x-show="activeUserId" class="bg-white p-4 border-t border-gray-100 flex items-end gap-3">
                <textarea x-model="replyText" 
                          @keydown.enter.prevent="sendReply()"
                          placeholder="Ketik balasan..." 
                          rows="1"
                          class="flex-1 bg-gray-50 border border-gray-200 rounded-2xl px-4 py-3 text-sm focus:bg-white focus:ring-2 focus:ring-blue-100 focus:border-blue-300 resize-none max-h-32"></textarea>
                <button @click="sendReply()" 
                        :disabled="!replyText.trim() || sending"
                        class="w-11 h-11 flex-shrink-0 bg-blue-600 hover:bg-blue-700 disabled:bg-gray-300 text-white rounded-full flex items-center justify-center transition-colors">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M2.01 21L23 12 2.01 3 2 10l15 2-15 2z"/></svg>
                </button>
            </div>
        </div>
    </div>
</div>

<script>
function chatAdmin() {
    return {
        conversations: [],
        messages: [],
        activeUserId: null,
        activeUserName: '',
        replyText: '',
        sending: false,
        toggling: false,
        searchQuery: '',
        isLiveChatEnabled: {{ isset($isLiveChatEnabled) && $isLiveChatEnabled ? 'true' : 'false' }},
        pollInterval: null,
        csrf: document.querySelector('meta[name="csrf-token"]').getAttribute('content'),

        filteredConversations() {
            const q = this.searchQuery.trim().toLowerCase();
            if (!q) return this.conversations;
            return this.conversations.filter(c =>
                (c.name || '').toLowerCase().includes(q) || (c.email || '').toLowerCase().includes(q)
            );
        },

        init() {
            this.loadConversations();
            // Poll for new conversations & unread counts
            setInterval(() => this.loadConversations(), 5000);
        },

        loadConversations() {
            fetch('/api/chat/conversations', { headers: {'Accept':'application/json'} })
                .then(r => r.json())
                .then(data => {
                    this.conversations = data.conversations || [];
                });
            
            if (this.activeUserId) {
                this.loadMessages();
            }
        },

        selectUser(conv) {
            this.activeUserId = conv.user_id;
            this.activeUserName = conv.name;
            this.messages = [];
            this.loadMessages();
            
            // Clear unread badge optimistically
            const c = this.conversations.find(x => x.user_id === conv.user_id);
            if(c) c.unread = 0;
        },

        loadMessages() {
            if(!this.activeUserId) return;
            fetch(`/api/chat/messages?user_id=${this.activeUserId}`, { headers: {'Accept':'application/json'} })
                .then(r => r.json())
                .then(data => {
                    const oldLen = this.messages.length;
                    this.messages = data.messages || [];
                    if (this.messages.length > oldLen) {
                        this.scrollToBottom();
                    }
                });
        },

        sendReply() {
            if(!this.replyText.trim() || this.sending || !this.activeUserId) return;
            this.sending = true;

            // Optimistic update - tagged with a temp id so we can find & flag it if the send fails.
            const tempId = 'temp-' + Date.now();
            const sentText = this.replyText;
            this.messages.push({
                id: tempId,
                content: sentText,
                from_me: true,
                sender: 'Anda',
                time: new Date().toLocaleTimeString([], {hour: '2-digit', minute:'2-digit'})
            });
            const payload = {
                receiver_id: this.activeUserId,
                content: sentText
            };
            this.replyText = '';
            this.scrollToBottom();

            fetch('/api/chat/reply', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': this.csrf,
                    'Accept': 'application/json'
                },
                body: JSON.stringify(payload)
            }).then(r => {
                if (!r.ok) throw new Error('Send failed');
                return r.json();
            }).then(() => {
                this.loadConversations(); // refresh to get real ID
            }).catch(() => {
                // The optimistic bubble would otherwise be silently wiped by the next
                // poll's fresh message list without the admin ever knowing it never
                // actually sent - remove it and restore the text so they can retry.
                this.messages = this.messages.filter(m => m.id !== tempId);
                this.replyText = sentText;
                alert('Gagal mengirim pesan. Silakan coba lagi.');
            }).finally(() => {
                this.sending = false;
            });
        },

        scrollToBottom() {
            setTimeout(() => {
                const b = document.getElementById('admin-chat-body');
                if(b) b.scrollTop = b.scrollHeight;
            }, 50);
        },

        formatTime(dateStr) {
            if(!dateStr) return '';
            const d = new Date(dateStr);
            return d.toLocaleTimeString([], {hour: '2-digit', minute:'2-digit'});
        },
        
        escapeHtml(s) {
            return String(s).replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;').replace(/\n/g,'<br>');
        },

        toggleLiveChat() {
            if(this.toggling) return;
            this.toggling = true;
            fetch('{{ route('admin.chat.toggle') }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': this.csrf,
                    'Accept': 'application/json'
                }
            })
            .then(r => r.json())
            .then(data => {
                this.isLiveChatEnabled = data.enabled;
                window.location.reload(); // Force reload to update Blade components
            })
            .finally(() => {
                this.toggling = false;
            });
        }
    }
}
</script>
@endsection
