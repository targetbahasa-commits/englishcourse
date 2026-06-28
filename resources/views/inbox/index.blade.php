@extends('layouts.dashboard')

@section('content')
@php
    $initialTab = request('tab');
    if (!in_array($initialTab, ['notifications', 'messages', 'sent'], true)) {
        $initialTab = 'messages';
    }

    $unreadNotificationCount = $notifications->whereNull('read_at')->count();
    $unreadMessageCount = $inboxMessages->whereNull('read_at')->count();
@endphp

<style>
/* ── Inbox Chatbox Layout ── */
.inbox-chat-shell {
    display: flex;
    height: calc(100vh - 220px);
    min-height: 500px;
    background: #fff;
    border-radius: 18px;
    overflow: hidden;
    box-shadow: 0 2px 20px rgba(0,0,0,0.08);
    border: 1px solid #e9ecef;
}

/* ── Left panel: conversation list ── */
.inbox-conv-panel {
    width: 300px;
    min-width: 260px;
    flex-shrink: 0;
    border-right: 1px solid #f0f2f5;
    display: flex;
    flex-direction: column;
    background: #fafbfc;
}
.inbox-conv-header {
    padding: 18px 16px 14px;
    border-bottom: 1px solid #f0f2f5;
    background: #fff;
}
.inbox-conv-search {
    width: 100%;
    padding: 8px 14px;
    border-radius: 20px;
    border: 1px solid #e2e8f0;
    background: #f8fafc;
    font-size: 13px;
    outline: none;
    transition: border .2s;
}
.inbox-conv-search:focus { border-color: #3b82f6; background: #fff; }
.inbox-conv-list { flex: 1; overflow-y: auto; }
.inbox-conv-list::-webkit-scrollbar { width: 3px; }
.inbox-conv-list::-webkit-scrollbar-thumb { background: rgba(0,0,0,.1); border-radius: 3px; }
.inbox-conv-item {
    display: flex; align-items: center; gap: 12px;
    padding: 14px 16px;
    cursor: pointer;
    border-bottom: 1px solid #f8fafc;
    transition: background .15s;
    position: relative;
}
.inbox-conv-item:hover { background: #f0f4ff; }
.inbox-conv-item.active { background: #eff6ff; border-left: 3px solid #3b82f6; }
.inbox-conv-avatar {
    width: 44px; height: 44px; border-radius: 50%;
    display: flex; align-items: center; justify-content: center;
    font-size: 18px; font-weight: 700; flex-shrink: 0;
    background: #bfdbfe; color: #1d4ed8;
}
.inbox-conv-avatar.admin-type { background: #fecdd3; color: #be123c; }
.inbox-conv-avatar.group-type { background: #fef08a; color: #854d0e; }
.inbox-conv-info { flex: 1; min-width: 0; }
.inbox-conv-name { font-size: 13.5px; font-weight: 600; color: #1e293b; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
.inbox-conv-preview { font-size: 12px; color: #64748b; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; margin-top: 2px; }
.inbox-conv-badge {
    background: #ef4444; color: #fff; font-size: 10px; font-weight: 700;
    min-width: 18px; height: 18px; border-radius: 50px;
    display: flex; align-items: center; justify-content: center;
    padding: 0 4px; flex-shrink: 0;
}

/* ── Right panel: chat thread ── */
.inbox-chat-panel {
    flex: 1; min-width: 0;
    display: flex; flex-direction: column;
    background: #f8fafc;
}
.inbox-chat-topbar {
    background: #fff;
    padding: 14px 20px;
    border-bottom: 1px solid #f0f2f5;
    display: flex; align-items: center; gap: 12px;
    flex-shrink: 0;
}
.inbox-chat-messages {
    flex: 1;
    padding: 20px 16px;
    overflow-y: auto;
    display: flex;
    flex-direction: column;
    gap: 12px;
}
.inbox-chat-messages::-webkit-scrollbar { width: 4px; }
.inbox-chat-messages::-webkit-scrollbar-thumb { background: rgba(0,0,0,.1); border-radius: 4px; }

/* Message bubbles */
.chat-msg { display: flex; flex-direction: column; max-width: 72%; }
.chat-msg.from-me  { align-self: flex-end; align-items: flex-end; }
.chat-msg.from-them { align-self: flex-start; align-items: flex-start; }
.chat-bubble {
    padding: 10px 14px;
    border-radius: 14px;
    font-size: 13.5px;
    line-height: 1.55;
    word-wrap: break-word;
    box-shadow: 0 1px 3px rgba(0,0,0,.08);
}
.from-me  .chat-bubble { background: #3b82f6; color: #fff; border-radius: 14px 2px 14px 14px; }
.from-them .chat-bubble { background: #fff; color: #1e293b; border-radius: 2px 14px 14px 14px; border: 1px solid #e2e8f0; }
.chat-meta { font-size: 11px; color: #94a3b8; margin-top: 4px; }
.chat-sender-label { font-size: 11px; font-weight: 700; color: #3b82f6; margin-bottom: 3px; }

/* Footer input */
.inbox-chat-footer {
    background: #fff;
    border-top: 1px solid #f0f2f5;
    padding: 12px 16px;
    display: flex; align-items: flex-end; gap: 10px;
    flex-shrink: 0;
}
.inbox-msg-input {
    flex: 1; border: 1px solid #e2e8f0; border-radius: 22px;
    padding: 10px 16px; font-size: 13.5px; resize: none;
    outline: none; max-height: 100px; line-height: 1.45;
    font-family: inherit; background: #f8fafc; transition: border .2s;
}
.inbox-msg-input:focus { border-color: #3b82f6; background: #fff; }
.inbox-send-btn {
    width: 42px; height: 42px; border-radius: 50%;
    background: #3b82f6; border: none; cursor: pointer;
    display: flex; align-items: center; justify-content: center;
    flex-shrink: 0; transition: background .2s, transform .15s;
}
.inbox-send-btn:hover { background: #1d4ed8; transform: scale(1.07); }
.inbox-send-btn:disabled { background: #cbd5e1; cursor: default; transform: none; }

/* Empty state */
.inbox-empty-state {
    flex: 1; display: flex; flex-direction: column;
    align-items: center; justify-content: center;
    color: #94a3b8; text-align: center; padding: 40px;
}

@media (max-width: 640px) {
    .inbox-conv-panel { width: 100%; min-width: unset; border-right: none; }
    .inbox-chat-panel { display: none; }
    .inbox-chat-shell.chat-open .inbox-conv-panel { display: none; }
    .inbox-chat-shell.chat-open .inbox-chat-panel { display: flex; }
}
</style>

<div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-9xl mx-auto" x-data="inboxPage()">
    <!-- Header -->
    <div class="mb-6 flex justify-between items-end">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Inbox & Messages</h1>
            <p class="text-gray-500 mt-1">Manage your notifications and direct messages.</p>
        </div>
        <div>
            <button @click="newConversation()" class="px-4 py-2 bg-blue-600 text-white rounded-xl shadow-sm hover:bg-blue-700 font-medium transition flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                {{ $user->role === 'admin' ? 'Send Message' : 'New Message' }}
            </button>
        </div>
    </div>

    @if (session('success'))
        <div class="mb-4 bg-green-50 border-l-4 border-green-500 p-4 rounded-r-xl">
            <p class="text-green-700">{{ session('success') }}</p>
        </div>
    @endif

    <!-- Tabs -->
    <div class="flex flex-wrap gap-6 border-b border-gray-200 mb-6">
        <button @click="activeTab = 'notifications'"
                :class="activeTab === 'notifications' ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700'"
                class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm flex items-center gap-2">
            Notifications
            @if($unreadNotificationCount > 0)
                <span class="bg-red-500 text-white text-xs font-bold px-2 py-0.5 rounded-full">{{ $unreadNotificationCount }}</span>
            @endif
        </button>
        <button @click="activeTab = 'messages'"
                :class="activeTab === 'messages' ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700'"
                class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm flex items-center gap-2">
            Messages
            @if($unreadMessageCount > 0)
                <span class="bg-red-500 text-white text-xs font-bold px-2 py-0.5 rounded-full">{{ $unreadMessageCount }}</span>
            @endif
        </button>
        <button @click="activeTab = 'sent'"
                :class="activeTab === 'sent' ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700'"
                class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">
            Sent Messages
        </button>
    </div>

    <!-- ════════════════════════════════════════
         TAB: NOTIFICATIONS
    ════════════════════════════════════════ -->
    <div x-show="activeTab === 'notifications'" class="space-y-4">
        @forelse($notifications as $item)
            <div class="bg-white p-5 rounded-xl shadow-sm border {{ is_null($item->read_at) ? 'border-blue-200 bg-blue-50/30' : 'border-gray-100' }}">
                <div class="flex justify-between items-start gap-4">
                    <div class="flex gap-4">
                        <div class="w-10 h-10 rounded-full bg-orange-100 text-orange-600 flex items-center justify-center shrink-0">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                        </div>
                        <div>
                            <h3 class="font-bold text-gray-900">{{ $item->data['title'] ?? 'Broadcast Announcement' }}</h3>
                            <p class="text-sm text-gray-600 mt-1 whitespace-pre-wrap">{{ $item->data['content'] ?? '' }}</p>
                            <div class="mt-2 text-xs text-gray-400 font-medium">From: Administrator • {{ $item->created_at->diffForHumans() }}</div>
                        </div>
                    </div>
                    @if(is_null($item->read_at))
                        <form action="{{ route('inbox.read', $item->id) }}" method="POST">
                            @csrf
                            <input type="hidden" name="type" value="notification">
                            <button type="submit" class="text-xs text-blue-600 hover:underline font-semibold bg-white px-3 py-1.5 rounded-lg border border-blue-200">Mark as Read</button>
                        </form>
                    @endif
                </div>
            </div>
        @empty
            <div class="bg-white p-8 rounded-xl shadow-sm border border-gray-100 text-center">
                <svg class="w-12 h-12 text-gray-300 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/></svg>
                <h3 class="text-lg font-medium text-gray-900">No notifications</h3>
                <p class="text-gray-500 text-sm mt-1">You don't have any broadcast notifications.</p>
            </div>
        @endforelse
    </div>

    <!-- ════════════════════════════════════════
         TAB: MESSAGES — Full Chatbox
    ════════════════════════════════════════ -->
    <div x-show="activeTab === 'messages'" :class="activeConvId ? 'chat-open' : ''" class="inbox-chat-shell">

        <!-- LEFT: Conversation List -->
        <div class="inbox-conv-panel">
            <div class="inbox-conv-header">
                <h3 style="font-size:14px;font-weight:700;color:#1e293b;margin-bottom:10px;">Pesan</h3>
                <input type="text" class="inbox-conv-search" placeholder="Cari percakapan..."
                       x-model="searchQuery" @input.debounce.300ms="doSearch()">
            </div>
            <div class="inbox-conv-list">

                <!-- Search results -->
                <template x-if="searchQuery.length >= 2">
                    <div>
                        <div style="padding:8px 14px;font-size:11px;font-weight:700;color:#94a3b8;text-transform:uppercase;letter-spacing:.05em;">Pencarian</div>
                        <template x-for="u in searchResults" :key="u.id">
                            <div class="inbox-conv-item" @click="openConv('user', u.id, u.name)">
                                <div class="inbox-conv-avatar" x-text="u.name.charAt(0).toUpperCase()"></div>
                                <div class="inbox-conv-info">
                                    <div class="inbox-conv-name" x-text="u.name"></div>
                                    <div class="inbox-conv-preview" x-text="u.role"></div>
                                </div>
                            </div>
                        </template>
                        <div x-show="searchResults.length === 0" style="padding:20px;text-align:center;font-size:13px;color:#94a3b8;">
                            Tidak ditemukan.
                        </div>
                    </div>
                </template>

                <!-- Regular conversation list -->
                <template x-if="searchQuery.length < 2">
                    <div>
                        <template x-for="conv in conversations" :key="conv.type + '_' + conv.id">
                            <div class="inbox-conv-item"
                                 :class="activeConvId === conv.id && activeConvType === conv.type ? 'active' : ''"
                                 @click="openConv(conv.type, conv.id, conv.name)">
                                <div class="inbox-conv-avatar"
                                     :class="conv.type === 'admin' ? 'admin-type' : (conv.type === 'group' ? 'group-type' : '')"
                                     x-text="conv.type === 'admin' ? 'S' : (conv.type === 'group' ? 'G' : conv.name.charAt(0).toUpperCase())"></div>
                                <div class="inbox-conv-info">
                                    <div class="inbox-conv-name" x-text="conv.name"></div>
                                    <div class="inbox-conv-preview" x-text="conv.type === 'group' ? 'Grup Kelas' : (conv.email || '')"></div>
                                </div>
                                <div x-show="conv.unread > 0" class="inbox-conv-badge" x-text="conv.unread"></div>
                            </div>
                        </template>
                        <div x-show="conversations.length === 0" style="padding:30px;text-align:center;font-size:13px;color:#94a3b8;">
                            Belum ada percakapan.
                        </div>
                    </div>
                </template>

            </div>
        </div>

        <!-- RIGHT: Chat Thread Panel -->
        <div class="inbox-chat-panel">

            <!-- Top bar (when a conv is selected) -->
            <div x-show="activeConvId" class="inbox-chat-topbar">
                <button @click="activeConvId = null; activeConvType = null;" class="md:hidden text-gray-400 hover:text-gray-600 mr-1" style="background:none;border:none;cursor:pointer;">
                    <svg width="22" height="22" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/></svg>
                </button>
                <div class="inbox-conv-avatar"
                     :class="activeConvType === 'admin' ? 'admin-type' : (activeConvType === 'group' ? 'group-type' : '')"
                     style="width:38px;height:38px;font-size:15px;"
                     x-text="activeConvType === 'admin' ? 'S' : (activeConvType === 'group' ? 'G' : activeConvName.charAt(0).toUpperCase())"></div>
                <div>
                    <h4 style="font-size:15px;font-weight:700;color:#1e293b;margin:0;" x-text="activeConvName"></h4>
                    <p style="font-size:12px;color:#10b981;margin:0;" x-text="activeConvType === 'group' ? 'Grup Kelas' : 'Online'"></p>
                </div>
            </div>

            <!-- Messages area -->
            <div x-show="activeConvId" class="inbox-chat-messages" id="inbox-chat-messages">
                <template x-for="msg in messages" :key="msg.id">
                    <div class="chat-msg" :class="msg.from_me ? 'from-me' : 'from-them'">
                        <div x-show="!msg.from_me && activeConvType === 'group'" class="chat-sender-label" x-text="msg.sender"></div>
                        <div class="chat-bubble" x-html="escHtml(msg.content)"></div>
                        <div class="chat-meta" x-text="msg.time"></div>
                    </div>
                </template>
                <div x-show="messages.length === 0" style="text-align:center;color:#94a3b8;font-size:13px;padding:30px 0;">
                    Belum ada pesan. Mulai percakapan! 👋
                </div>
            </div>

            <!-- Input footer -->
            <div x-show="activeConvId" class="inbox-chat-footer">
                <textarea class="inbox-msg-input" x-model="inputText" x-ref="msgInput"
                          placeholder="Ketik pesan..." rows="1"
                          @keydown.enter.prevent="sendMsg()"></textarea>
                <button class="inbox-send-btn" @click="sendMsg()" :disabled="!inputText.trim() || sending">
                    <svg width="18" height="18" fill="white" viewBox="0 0 24 24"><path d="M2.01 21L23 12 2.01 3 2 10l15 2-15 2z"/></svg>
                </button>
            </div>

            <!-- Empty state (no conv selected) -->
            <div x-show="!activeConvId" class="inbox-empty-state">
                <svg width="64" height="64" fill="none" stroke="#cbd5e1" viewBox="0 0 24 24" stroke-width="1.5" class="mb-4">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                </svg>
                <p style="font-size:15px;font-weight:600;color:#94a3b8;">Pilih percakapan untuk memulai</p>
                <p style="font-size:13px;color:#cbd5e1;margin-top:4px;">Atau klik tombol <strong>New Message</strong> untuk memulai obrolan baru.</p>
            </div>
        </div>
    </div>

    <!-- ════════════════════════════════════════
         TAB: SENT MESSAGES
    ════════════════════════════════════════ -->
    <div x-show="activeTab === 'sent'" class="space-y-4">
        @forelse($sentMessages as $msg)
            <div class="bg-white p-5 rounded-xl shadow-sm border border-gray-100">
                <div class="flex justify-between items-start">
                    <div class="flex gap-4">
                        <div class="w-10 h-10 rounded-full bg-gray-100 text-gray-500 flex items-center justify-center shrink-0">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/></svg>
                        </div>
                        <div>
                            <h3 class="font-bold text-gray-900">{{ $msg->subject }}</h3>
                            <p class="text-sm text-gray-600 mt-1 whitespace-pre-wrap">{{ $msg->content }}</p>
                            <div class="mt-2 text-xs text-gray-400 font-medium">
                                To: <strong class="text-gray-600">{{ $msg->receiver_id ? ($msg->receiver->name ?? 'Unknown') : 'Administrator' }}</strong> • {{ $msg->created_at->diffForHumans() }}
                                @if($msg->read_at)
                                    <span class="ml-2 text-green-500">✓ Read</span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="bg-white p-8 rounded-xl shadow-sm border border-gray-100 text-center">
                <h3 class="text-lg font-medium text-gray-900">No sent messages</h3>
                <p class="text-gray-500 text-sm mt-1">You haven't sent any messages yet.</p>
            </div>
        @endforelse
    </div>

</div>

<!-- New Conversation Modal -->
<div x-data="{ open: false, receiver: '', subject: '' }"
     @open-compose.window="open = true; receiver = $event.detail?.receiver || ''; subject = $event.detail?.replyTo ? 'Re: ' + $event.detail.replyTo : ''"
     x-show="open" class="fixed inset-0 z-50 overflow-y-auto" style="display:none;">
    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <div x-show="open" class="fixed inset-0 bg-gray-500 bg-opacity-75" @click="open = false"></div>
        <div x-show="open" class="inline-block align-bottom bg-white rounded-2xl text-left overflow-hidden shadow-xl transform sm:my-8 sm:align-middle sm:max-w-lg w-full">
            <form action="{{ route('inbox.store') }}" method="POST">
                @csrf
                @if($user->role === 'admin')
                    <input type="hidden" name="receiver_id" x-model="receiver">
                @endif
                <div class="bg-white px-6 pt-6 pb-4">
                    <h3 class="text-lg leading-6 font-bold text-gray-900">{{ $user->role === 'admin' ? 'Send a Message' : 'Contact Administrator' }}</h3>
                    <div class="mt-4 space-y-4">
                        @if($user->role === 'admin')
                            <p class="text-xs text-blue-600 bg-blue-50 p-2 rounded-lg" x-show="receiver">Replying to a specific user.</p>
                        @endif
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Subject</label>
                            <input type="text" name="subject" x-model="subject" required class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 sm:text-sm">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Message</label>
                            <textarea name="content" rows="5" required class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 sm:text-sm"></textarea>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 px-6 py-3 flex flex-row-reverse gap-3 border-t border-gray-100">
                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-xl shadow-sm hover:bg-blue-700 font-medium text-sm transition">Send Message</button>
                    <button type="button" @click="open = false" class="px-4 py-2 bg-white text-gray-700 rounded-xl border border-gray-300 font-medium text-sm hover:bg-gray-50 transition">Cancel</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function inboxPage() {
    return {
        activeTab: @js($initialTab),
        searchQuery: '',
        searchResults: [],

        conversations: [],
        activeConvId: null,
        activeConvType: null,
        activeConvName: '',

        messages: [],
        inputText: '',
        sending: false,

        csrf: document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '',

        init() {
            this.loadConversations();
            // Poll every 5s
            setInterval(() => {
                this.loadConversations();
                if (this.activeConvId) this.pollMessages();
            }, 5000);
        },

        loadConversations() {
            fetch('/api/chat/conversations', { headers: { 'Accept': 'application/json' } })
                .then(r => r.json())
                .then(d => { this.conversations = d.conversations || []; });
        },

        openConv(type, id, name) {
            this.activeConvId   = id;
            this.activeConvType = type;
            this.activeConvName = name;
            this.searchQuery    = '';
            this.messages       = [];

            // Clear unread badge
            const c = this.conversations.find(x => x.type === type && x.id === id);
            if (c) c.unread = 0;

            this.pollMessages();
            this.$nextTick(() => {
                if (this.$refs.msgInput) this.$refs.msgInput.focus();
            });
        },

        pollMessages() {
            if (!this.activeConvId) return;
            let url = `/api/chat/messages?type=${this.activeConvType}`;
            if (this.activeConvId && this.activeConvType !== 'admin') {
                url += `&target_id=${this.activeConvId}`;
            }
            fetch(url, { headers: { 'Accept': 'application/json' } })
                .then(r => r.json())
                .then(d => {
                    const prev = this.messages.length;
                    this.messages = d.messages || [];
                    if (this.messages.length > prev) this.scrollBottom();
                });
        },

        sendMsg() {
            if (!this.inputText.trim() || this.sending) return;
            this.sending = true;
            const text = this.inputText.trim();
            this.inputText = '';

            // Optimistic
            this.messages.push({
                id: Date.now(),
                content: text,
                from_me: true,
                time: new Date().toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' })
            });
            this.scrollBottom();

            const payload = { type: this.activeConvType, content: text };
            if (this.activeConvId && this.activeConvType !== 'admin') {
                payload.target_id = this.activeConvId;
            }

            fetch('/api/chat/send', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': this.csrf, 'Accept': 'application/json' },
                body: JSON.stringify(payload)
            }).finally(() => {
                this.sending = false;
                this.pollMessages();
            });
        },

        doSearch() {
            if (this.searchQuery.length < 2) { this.searchResults = []; return; }
            fetch('/api/chat/search?q=' + encodeURIComponent(this.searchQuery), { headers: { 'Accept': 'application/json' } })
                .then(r => r.json())
                .then(d => { this.searchResults = d.users || []; });
        },

        newConversation() {
            window.dispatchEvent(new CustomEvent('open-compose', { detail: {} }));
        },

        scrollBottom() {
            this.$nextTick(() => {
                const el = document.getElementById('inbox-chat-messages');
                if (el) el.scrollTop = el.scrollHeight;
            });
        },

        escHtml(s) {
            return String(s)
                .replace(/&/g, '&amp;')
                .replace(/</g, '&lt;')
                .replace(/>/g, '&gt;')
                .replace(/\n/g, '<br>');
        }
    };
}
</script>
@endsection
