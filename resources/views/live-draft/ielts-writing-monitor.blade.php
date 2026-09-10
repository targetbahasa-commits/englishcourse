@extends('layouts.admin')

@section('content')
<div class="max-w-6xl mx-auto p-6">
    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-5 mb-4">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-3">
            <div>
                <h1 class="text-2xl font-bold text-slate-900">Live Draft Monitor</h1>
                <p class="text-sm text-slate-600 mt-1">
                    Monitoring <strong>{{ $targetUser->name }}</strong> - IELTS Writing Task {{ $task }} - Meeting {{ $meeting->meeting_number }}
                </p>
            </div>
            <div class="text-sm text-slate-600">
                Room: <span class="font-mono text-xs bg-slate-100 px-2 py-1 rounded">{{ $roomId }}</span>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-5">
        <div class="flex items-center justify-between mb-3">
            <h2 class="text-lg font-semibold text-slate-900">Student Essay (Read Only)</h2>
            @if($wsUrl)
                <div id="crdtMonitorStatus" class="text-xs font-semibold px-2 py-1 rounded bg-amber-100 text-amber-700">Connecting...</div>
            @endif
        </div>
        @if($wsUrl)
            <textarea id="crdtMonitorEssay" readonly class="w-full min-h-[560px] p-4 rounded-xl border border-slate-200 bg-slate-50 text-slate-800 leading-relaxed resize-y"></textarea>
        @else
            <div class="p-4 rounded-xl border border-amber-200 bg-amber-50 text-amber-800 text-sm">
                Live monitor is currently disabled - it isn't connected to an
                external server yet, and won't be until this app's own
                private relay is configured (CRDT_WS_URL and CRDT_RELAY_SECRET).
            </div>
        @endif
    </div>
</div>

@if($wsUrl)
<script type="module">
    // ?deps=yjs@13.6.18 pins y-websocket's OWN internal yjs dependency to
    // the exact same module instance imported below - see the matching
    // comment in assignments/ielts/writing/meeting.blade.php for why this
    // matters (https://github.com/yjs/yjs/issues/438). Without it, this
    // monitor would silently never actually receive the student's edits.
    import * as Y from 'https://esm.sh/yjs@13.6.18';
    import { WebsocketProvider } from 'https://esm.sh/y-websocket@1.5.3?deps=yjs@13.6.18';

    const wsUrl = @json($wsUrl);
    const roomId = @json($roomId);
    const token = @json($token);
    const statusEl = document.getElementById('crdtMonitorStatus');
    const essayEl = document.getElementById('crdtMonitorEssay');

    const doc = new Y.Doc();
    const provider = new WebsocketProvider(wsUrl, roomId, doc, { connect: true, params: { token } });
    const yEssay = doc.getText('essay');

    const setStatus = (text, css) => {
        statusEl.textContent = text;
        statusEl.className = `text-xs font-semibold px-2 py-1 rounded ${css}`;
    };

    provider.on('status', (event) => {
        if (event.status === 'connected') {
            setStatus('Live', 'bg-emerald-100 text-emerald-700');
        } else {
            setStatus('Reconnecting...', 'bg-amber-100 text-amber-700');
        }
    });

    const applyText = () => {
        essayEl.value = yEssay.toString();
    };

    yEssay.observe(applyText);
    applyText();

    window.addEventListener('beforeunload', () => {
        provider.destroy();
        doc.destroy();
    });
</script>
@endif
@endsection
