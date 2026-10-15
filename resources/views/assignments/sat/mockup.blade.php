<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Target Bahasa') }} - Digital SAT Practice Test {{ $practiceNumber }}</title>
    <link rel="icon" type="image/png" href="{{ asset('images/brand/icon.png') }}">

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800&family=merriweather:300,400,700&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script>
        window.MathJax = {
            tex: {
                inlineMath: [['\\(', '\\)'], ['$', '$']],
                displayMath: [['\\[', '\\]'], ['$$', '$$']]
            },
            options: {
                skipHtmlTags: ['script', 'noscript', 'style', 'textarea', 'pre', 'code']
            },
            startup: {
                pageReady: () => {
                    return MathJax.startup.defaultPageReady();
                }
            }
        };
    </script>
    <script id="MathJax-script" async src="https://cdn.jsdelivr.net/npm/mathjax@3/es5/tex-mml-chtml.js"></script>

    <style>
        [x-cloak] { display: none !important; }
        
        /* Scoped Bright & Clean Theme for Digital SAT CBT (Matching Assignment UI) */
        .sat-header {
            background-color: #ffffff !important;
            border-bottom: 2px solid #e2e8f0 !important;
            color: #0f172a !important;
            box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.05) !important;
        }
        .sat-badge {
            background-color: #0284c7 !important;
            color: #ffffff !important;
            font-weight: 800 !important;
            letter-spacing: 0.05em !important;
            padding: 3px 8px !important;
            border-radius: 6px !important;
            font-size: 11px !important;
        }
        .sat-title {
            color: #0f172a !important;
            font-weight: 800 !important;
            font-size: 15px !important;
        }
        .sat-subtitle {
            color: #64748b !important;
            font-size: 12px !important;
            font-weight: 600 !important;
        }
        .sat-btn-nav {
            background-color: #f8fafc !important;
            color: #334155 !important;
            border: 1.5px solid #cbd5e1 !important;
            padding: 6px 12px !important;
            border-radius: 10px !important;
            font-size: 12px !important;
            font-weight: 700 !important;
            display: inline-flex !important;
            align-items: center !important;
            gap: 6px !important;
            transition: all 0.2s ease !important;
        }
        .sat-btn-nav:hover {
            background-color: #f1f5f9 !important;
            color: #0f172a !important;
            border-color: #94a3b8 !important;
        }
        .sat-timer-box {
            background-color: #f8fafc !important;
            border: 1.5px solid #cbd5e1 !important;
            color: #0f172a !important;
            display: inline-flex !important;
            align-items: center !important;
            gap: 8px !important;
            padding: 6px 14px !important;
            border-radius: 12px !important;
            box-shadow: 0 1px 2px rgba(0, 0, 0, 0.04) !important;
        }
        .sat-timer-text {
            color: #0284c7 !important;
            font-family: ui-monospace, SFMono-Regular, Menlo, Monaco, Consolas, monospace !important;
            font-size: 16px !important;
            font-weight: 800 !important;
            letter-spacing: 0.05em !important;
        }
        .sat-score-badge {
            background-color: #ecfdf5 !important;
            border: 2px solid #10b981 !important;
            color: #065f46 !important;
            display: inline-flex !important;
            align-items: center !important;
            gap: 8px !important;
            padding: 6px 16px !important;
            border-radius: 9999px !important;
            box-shadow: 0 1px 3px rgba(16, 185, 129, 0.15) !important;
        }
        .sat-score-badge .sat-score-dot {
            width: 8px !important;
            height: 8px !important;
            border-radius: 50% !important;
            background-color: #10b981 !important;
            flex-shrink: 0 !important;
        }
        .sat-score-badge .sat-score-text {
            font-size: 13px !important;
            font-weight: 800 !important;
            color: #065f46 !important;
            letter-spacing: 0.01em !important;
            white-space: nowrap !important;
        }
        .sat-btn-exit {
            background-color: #fef2f2 !important;
            color: #dc2626 !important;
            border: 1.5px solid #fecaca !important;
            padding: 6px 12px !important;
            border-radius: 10px !important;
            font-size: 12px !important;
            font-weight: 700 !important;
            display: inline-flex !important;
            align-items: center !important;
            gap: 6px !important;
            transition: all 0.2s ease !important;
        }
        .sat-btn-exit:hover {
            background-color: #dc2626 !important;
            color: #ffffff !important;
            border-color: #dc2626 !important;
        }

        /* Layout Full Height */
        .sat-app-layout {
            height: 100vh !important;
            min-height: 100vh !important;
            max-height: 100vh !important;
            display: flex !important;
            flex-direction: column !important;
            overflow: hidden !important;
            background-color: #f1f5f9 !important;
            width: 100% !important;
        }

        .sat-main-body {
            flex: 1 1 0% !important;
            height: calc(100vh - 64px - 64px) !important;
            min-height: 0 !important;
            display: flex !important;
            flex-direction: column !important;
            overflow: hidden !important;
            background-color: #ffffff !important;
            position: relative !important;
            width: 100% !important;
        }

        .sat-question-container {
            display: flex;
            flex-direction: row;
            width: 100% !important;
            height: 100% !important;
            min-height: 100% !important;
            max-height: 100% !important;
            flex: 1 1 0% !important;
            overflow: hidden !important;
        }
        .sat-question-container[style*="display: none"] {
            display: none !important;
        }

        /* Split Pane Styles */
        .sat-passage-pane {
            width: 50% !important;
            height: 100% !important;
            min-height: 100% !important;
            max-height: 100% !important;
            flex: 1 1 0% !important;
            overflow-y: auto !important;
            background-color: #ffffff !important;
            border-right: 2px solid #e2e8f0 !important;
            padding: 32px 40px !important;
            box-sizing: border-box !important;
        }
        .sat-domain-badge {
            color: #1d4ed8 !important;
            font-weight: 800 !important;
            font-size: 12px !important;
            letter-spacing: 0.1em !important;
            text-transform: uppercase !important;
        }
        .sat-passage-text {
            font-family: 'Merriweather', Georgia, serif !important;
            font-size: 16px !important;
            line-height: 1.85 !important;
            color: #1e293b !important;
            text-align: justify !important;
        }

        /* Question Pane Styles */
        .sat-question-pane {
            width: 50% !important;
            height: 100% !important;
            min-height: 100% !important;
            max-height: 100% !important;
            flex: 1 1 0% !important;
            overflow-y: auto !important;
            background-color: #f8fafc !important;
            padding: 32px 40px !important;
            box-sizing: border-box !important;
        }

        /* Single Pane Layout for SAT Math (Official Bluebook Format) */
        .sat-math-single-pane {
            width: 100% !important;
            max-width: 100% !important;
            height: 100% !important;
            min-height: 100% !important;
            max-height: 100% !important;
            flex: 1 1 100% !important;
            overflow-y: auto !important;
            background-color: #f8fafc !important;
            padding: 36px 24px !important;
            box-sizing: border-box !important;
        }

        @media (max-width: 768px) {
            .sat-question-container {
                flex-direction: column !important;
            }
            .sat-passage-pane {
                width: 100% !important;
                height: 45% !important;
                min-height: 45% !important;
                max-height: 45% !important;
                border-right: none !important;
                border-bottom: 2px solid #e2e8f0 !important;
                padding: 18px 16px !important;
            }
            .sat-question-pane {
                width: 100% !important;
                height: 55% !important;
                min-height: 55% !important;
                max-height: 55% !important;
                padding: 18px 16px !important;
            }
            .sat-math-single-pane {
                padding: 20px 16px !important;
            }
        }
        .sat-q-num-badge {
            background-color: #0284c7 !important;
            color: #ffffff !important;
            font-weight: 800 !important;
            border-radius: 10px !important;
            width: 32px !important;
            height: 32px !important;
            display: inline-flex !important;
            align-items: center !important;
            justify-content: center !important;
            font-size: 14px !important;
        }
        .sat-q-prompt {
            font-size: 17px !important;
            font-weight: 800 !important;
            color: #0f172a !important;
            line-height: 1.55 !important;
        }

        /* Options Styles */
        .sat-option-card {
            background-color: #ffffff !important;
            border: 2px solid #cbd5e1 !important;
            border-radius: 16px !important;
            padding: 14px 18px !important;
            cursor: pointer !important;
            transition: all 0.2s ease !important;
            display: flex !important;
            align-items: flex-start !important;
            gap: 14px !important;
            margin-bottom: 12px !important;
        }
        .sat-option-card:hover {
            border-color: #64748b !important;
            background-color: #f1f5f9 !important;
        }
        .sat-option-card.selected {
            border-color: #0284c7 !important;
            background-color: #f0f9ff !important;
            box-shadow: 0 0 0 3px rgba(2, 132, 199, 0.2) !important;
        }
        .sat-option-letter {
            width: 32px !important;
            height: 32px !important;
            border-radius: 50% !important;
            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
            font-weight: 800 !important;
            font-size: 14px !important;
            border: 2px solid #cbd5e1 !important;
            background-color: #ffffff !important;
            color: #334155 !important;
            flex-shrink: 0 !important;
            transition: all 0.2s ease !important;
        }
        .sat-option-card.selected .sat-option-letter {
            background-color: #0284c7 !important;
            color: #ffffff !important;
            border-color: #0284c7 !important;
        }
        .sat-option-text {
            font-size: 15px !important;
            color: #1e293b !important;
            font-weight: 500 !important;
            line-height: 1.45 !important;
            padding-top: 3px !important;
        }
        .sat-option-card.selected .sat-option-text {
            font-weight: 700 !important;
            color: #0369a1 !important;
        }

        /* Bluebook Answer Elimination (Coret Opsi) */
        .sat-option-card.eliminated {
            opacity: 0.45 !important;
            background-color: #f1f5f9 !important;
            border-color: #cbd5e1 !important;
        }
        .sat-option-card.eliminated .sat-option-text {
            text-decoration: line-through !important;
            color: #64748b !important;
        }
        .sat-option-card.eliminated .sat-option-letter {
            background-color: #e2e8f0 !important;
            color: #94a3b8 !important;
            text-decoration: line-through !important;
        }
        .sat-eliminate-btn {
            font-size: 11px !important;
            font-weight: 800 !important;
            padding: 2px 7px !important;
            border-radius: 6px !important;
            border: 1px solid #cbd5e1 !important;
            background-color: #ffffff !important;
            color: #64748b !important;
            transition: all 0.15s ease !important;
            cursor: pointer !important;
            margin-left: auto !important;
            align-self: center !important;
        }
        .sat-eliminate-btn:hover {
            background-color: #f8fafc !important;
            color: #0f172a !important;
            border-color: #94a3b8 !important;
        }
        .sat-eliminate-btn.active {
            background-color: #fee2e2 !important;
            color: #b91c1c !important;
            border-color: #fca5a5 !important;
        }

        /* Passage Highlighter Toolbar & Styles */
        .sat-passage-text ::selection {
            background-color: #fef08a !important;
            color: #713f12 !important;
        }
        /* 2. Styling CSS (Floating Tooltip & Highlight - Official Bluebook) */
        .reading-passage {
            position: relative;
            line-height: 1.8;
            font-size: 16px;
        }

        .annotation-toolbar {
            position: fixed;
            background: #ffffff !important;
            color: #1e293b !important;
            border: 1px solid #cbd5e1 !important;
            padding: 5px 8px !important;
            border-radius: 10px !important;
            display: none !important;
            align-items: center !important;
            gap: 6px !important;
            z-index: 10000 !important;
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.12), 0 8px 10px -6px rgba(0, 0, 0, 0.08), 0 0 0 1px rgba(0, 0, 0, 0.04) !important;
            pointer-events: auto !important;
            user-select: none !important;
        }

        .annotation-toolbar.is-open {
            display: flex !important;
        }

        .annotation-toolbar[style*="display: none"] {
            display: none !important;
        }

        .annotation-toolbar button {
            background: transparent !important;
            border: none !important;
            color: #1e293b !important;
            cursor: pointer !important;
            font-size: 13px !important;
            font-weight: 700 !important;
            padding: 4px 8px !important;
            display: inline-flex !important;
            align-items: center !important;
            gap: 6px !important;
            border-radius: 6px !important;
            transition: all 0.15s ease !important;
        }

        .annotation-toolbar button#btnHapusHighlight[style*="display: none"] {
            display: none !important;
        }

        .annotation-toolbar button:hover {
            background: #f1f5f9 !important;
            color: #0f172a !important;
        }

        .annotation-toolbar button#btnCatatan {
            color: #0066cc !important;
        }

        .annotation-toolbar button#btnCatatan:hover {
            background: #eff6ff !important;
            color: #004d99 !important;
        }

        .annotation-toolbar button#btnUnderline:hover {
            background: #eff6ff !important;
            color: #0066cc !important;
        }

        .annotation-toolbar button#btnHapusHighlight:hover {
            background: #fef2f2 !important;
            color: #dc2626 !important;
        }

        .annotation-toolbar button#btnCloseToolbar:hover {
            background: #f1f5f9 !important;
            color: #0f172a !important;
        }

        /* Style untuk teks yang di-highlight */
        .sat-highlight, .sat-hl-yellow {
            background-color: #fff3a3 !important;
            border-bottom: 2px solid #f1c40f !important;
            color: inherit !important;
            cursor: pointer !important;
            display: inline !important;
            border-radius: 2px !important;
            padding: 0 2px !important;
            transition: background-color 0.15s ease !important;
        }
        .sat-highlight:hover, .sat-hl-yellow:hover {
            background-color: #fde047 !important;
        }
        .sat-highlight.has-note, .sat-hl-yellow.has-note {
            border-bottom: 2px dashed #ca8a04 !important;
            position: relative !important;
        }
        .sat-highlight.has-note::after, .sat-hl-yellow.has-note::after {
            content: '💬';
            font-size: 10px;
            vertical-align: super;
            margin-left: 2px;
        }

        /* Style untuk teks yang di-underline */
        .sat-underline, u.sat-underline {
            text-decoration: underline !important;
            text-decoration-color: #0066cc !important;
            text-decoration-thickness: 2.5px !important;
            text-underline-offset: 3.5px !important;
            color: inherit !important;
            cursor: pointer !important;
            display: inline !important;
            padding: 0 1px !important;
            transition: background-color 0.15s ease !important;
        }
        .sat-underline:hover, u.sat-underline:hover {
            background-color: #eff6ff !important;
        }
        .sat-underline.has-note, u.sat-underline.has-note {
            text-decoration: underline dashed #0066cc !important;
            position: relative !important;
        }
        .sat-underline.has-note::after, u.sat-underline.has-note::after {
            content: '💬';
            font-size: 10px;
            vertical-align: super;
            margin-left: 2px;
        }

        /* Review Mode Option Styles */
        .sat-option-card.admin-peek-highlight {
            border-color: #059669 !important;
            background-color: #ecfdf5 !important;
            box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.25) !important;
        }
        .sat-option-card.admin-peek-highlight .sat-option-letter {
            background-color: #059669 !important;
            color: #ffffff !important;
            border-color: #059669 !important;
        }
        .sat-option-card.admin-peek-highlight .sat-option-text {
            font-weight: 700 !important;
            color: #065f46 !important;
        }
        .sat-option-card.correct {
            border-color: #10b981 !important;
            background-color: #ecfdf5 !important;
            box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.2) !important;
        }
        .sat-option-card.correct .sat-option-letter {
            background-color: #10b981 !important;
            color: #ffffff !important;
            border-color: #10b981 !important;
        }
        .sat-option-card.correct .sat-option-text {
            font-weight: 700 !important;
            color: #065f46 !important;
        }
        .sat-option-card.wrong {
            border-color: #ef4444 !important;
            background-color: #fef2f2 !important;
            box-shadow: 0 0 0 3px rgba(239, 68, 68, 0.2) !important;
        }
        .sat-option-card.wrong .sat-option-letter {
            background-color: #ef4444 !important;
            color: #ffffff !important;
            border-color: #ef4444 !important;
        }
        .sat-option-card.wrong .sat-option-text {
            font-weight: 700 !important;
            color: #991b1b !important;
        }

        /* Bottom Bar */
        .sat-footer {
            background-color: #ffffff !important;
            border-top: 2px solid #cbd5e1 !important;
            box-shadow: 0 -4px 15px rgba(0,0,0,0.06) !important;
            overflow: visible !important;
            position: relative !important;
            z-index: 40 !important;
        }
        .sat-nav-popover {
            position: absolute !important;
            bottom: calc(100% + 12px) !important;
            left: 50% !important;
            transform: translateX(-50%) !important;
            width: 340px !important;
            max-width: 90vw !important;
            background-color: #ffffff !important;
            border: 2px solid #cbd5e1 !important;
            border-radius: 20px !important;
            box-shadow: 0 20px 40px -10px rgba(15, 23, 42, 0.25), 0 0 0 1px rgba(0,0,0,0.05) !important;
            padding: 20px !important;
            z-index: 99999 !important;
        }
        .sat-btn-nav-trigger {
            background-color: #f8fafc !important;
            color: #0f172a !important;
            font-weight: 800 !important;
            border: 2px solid #cbd5e1 !important;
            border-radius: 12px !important;
            padding: 8px 18px !important;
            font-size: 13px !important;
            display: inline-flex !important;
            align-items: center !important;
            gap: 8px !important;
            cursor: pointer !important;
            transition: all 0.2s ease !important;
        }
        .sat-btn-nav-trigger:hover {
            background-color: #f1f5f9 !important;
            border-color: #94a3b8 !important;
        }
        .sat-btn-back {
            background-color: #ffffff !important;
            border: 2px solid #cbd5e1 !important;
            color: #1e293b !important;
            font-weight: 800 !important;
            border-radius: 12px !important;
            padding: 8px 18px !important;
            font-size: 13px !important;
            display: inline-flex !important;
            align-items: center !important;
            gap: 6px !important;
            cursor: pointer !important;
            transition: all 0.2s ease !important;
        }
        .sat-btn-back:hover:not(:disabled) {
            background-color: #f1f5f9 !important;
            border-color: #94a3b8 !important;
        }
        .sat-btn-next {
            background-color: #0284c7 !important;
            color: #ffffff !important;
            font-weight: 800 !important;
            border-radius: 12px !important;
            padding: 8px 24px !important;
            font-size: 13px !important;
            border: none !important;
            box-shadow: 0 2px 6px rgba(2, 132, 199, 0.35) !important;
            display: inline-flex;
            align-items: center !important;
            gap: 6px !important;
            cursor: pointer !important;
            transition: all 0.2s ease !important;
        }
        .sat-btn-next:hover {
            background-color: #0369a1 !important;
        }
        .sat-btn-submit {
            background-color: #059669 !important;
            color: #ffffff !important;
            font-weight: 800 !important;
            border-radius: 12px !important;
            padding: 8px 24px !important;
            font-size: 13px !important;
            border: none !important;
            box-shadow: 0 2px 6px rgba(5, 150, 105, 0.35) !important;
            display: inline-flex;
            align-items: center !important;
            gap: 6px !important;
            cursor: pointer !important;
            transition: all 0.2s ease !important;
        }
        .sat-btn-submit:hover {
            background-color: #047857 !important;
        }
        .sat-btn-next[style*="display: none"],
        .sat-btn-submit[style*="display: none"],
        .sat-btn-next[style*="display:none"],
        .sat-btn-submit[style*="display:none"] {
            display: none !important;
        }

        /* Custom scrollbar for split panes */
        .cbt-scroll::-webkit-scrollbar { width: 6px; }
        .cbt-scroll::-webkit-scrollbar-track { background: #f1f5f9; }
        .cbt-scroll::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 4px; }
        .cbt-scroll::-webkit-scrollbar-thumb:hover { background: #94a3b8; }
    </style>
</head>

@php
    $satRoutePrefix = request()->routeIs('mock-test.*') ? 'mock-test.sat.' : 'assignments.sat.';
    // Distinguishes sessionStorage keys (draft answers, timer, marked
    // questions, highlights) between the two contexts so a student with
    // both an Assignments and a Mock Test attempt open in the same tab
    // doesn't have one overwrite the other's in-progress draft.
    $satStorageContext = request()->routeIs('mock-test.*') ? 'mt_' : '';
    $totalCount = $questions->count();
    $scoreAnswers = $existingScore ? ($existingScore->answers ?? []) : [];
    $isMath = ($sectionType ?? 'reading-writing') === 'math';
    $secTitle = $sectionTitle ?? ($isMath ? 'Section 2: Math' : 'Section 1: Reading & Writing');
    $secSubtitle = $sectionSubtitle ?? ('Practice Test ' . $practiceNumber . ': ' . $meeting->title . ' • ' . $totalCount . ' Questions');
    $durationMin = $durationMinutes ?? ($isMath ? 35 : 32);
    $submitRoute = $isMath ? route($satRoutePrefix . 'math.submit') : route($satRoutePrefix . 'reading-writing.submit');
    $resetRoute = $isMath
        ? route($satRoutePrefix . 'math.practice-test', ['number' => $practiceNumber, 'retry' => 1])
        : route($satRoutePrefix . 'practice-test', ['number' => $practiceNumber, 'retry' => 1]);

    $isAdmin = Auth::check() && (
        Auth::user()->role === 'admin' ||
        Auth::user()->isAdmin() ||
        session()->has('view_as_role') ||
        session()->has('impersonating_admin_id')
    );
@endphp

<body class="h-full font-sans antialiased bg-[#F3F4F6] text-gray-900 select-none overflow-hidden"
      x-data="satCbtMockup()"
      x-init="init()"
      x-cloak>

    <!-- FORM FOR SUBMITTING ANSWERS -->
    <form id="satSubmitForm" action="{{ $submitRoute }}" method="POST" class="hidden">
        @csrf
        <input type="hidden" name="meeting_number" value="{{ $practiceNumber }}">
        <input type="hidden" name="source" value="mockup">
        @if($isMath)
            <input type="hidden" name="type" value="practice">
            <template x-for="(val, qid) in userAnswers" :key="qid">
                <input type="hidden" :name="'answers[' + qid + ']'" :value="val">
            </template>
        @else
            <template x-for="(val, qid) in userAnswers" :key="qid">
                <input type="hidden" :name="'question_' + qid" :value="val">
            </template>
        @endif
    </form>

    <div class="sat-app-layout">

        <!-- ======================================================== -->
        <!-- TOP APP BAR (Solid Dark Bluebook SAT Header) -->
        <!-- ======================================================== -->
        <header class="h-14 sm:h-16 sat-header px-3 sm:px-6 flex items-center justify-between shrink-0 shadow-md relative z-30">
            <!-- Left Info & Directions -->
            <div class="flex items-center gap-2 sm:gap-4 truncate max-w-[38%] sm:max-w-none">
                <div class="flex flex-col truncate">
                    <div class="flex items-center gap-1.5 sm:gap-2">
                        <span class="sat-badge hidden sm:inline" style="{{ $isMath ? 'background-color: #0d9488 !important;' : '' }}">
                            DIGITAL SAT
                        </span>
                        <h1 class="sat-title truncate text-xs sm:text-base">
                            {{ $secTitle }}
                        </h1>
                        @if($practiceNumber == 2)
                            @php
                                $stage = session($isMath ? 'sat_math_stage' : 'sat_rw_stage', 'Hard');
                            @endphp
                            <span class="px-1.5 py-0.5 rounded-full text-[9px] sm:text-[10px] font-black {{ $stage === 'Hard' ? 'bg-purple-100 text-purple-800 border border-purple-300' : 'bg-amber-100 text-amber-800 border border-amber-300' }}">
                                {{ $stage }}
                            </span>
                        @endif
                    </div>
                    <span class="sat-subtitle hidden sm:inline">
                        {{ $secSubtitle }}
                    </span>
                </div>

                <!-- Official Bluebook Directions dropdown button -->
                <button type="button" @click="showDirections = true" 
                        class="sat-btn-nav hidden md:inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg border border-slate-300 hover:bg-slate-100 text-slate-800 text-xs font-bold transition cursor-pointer"
                        title="Lihat petunjuk umum ujian">
                    <span>Directions</span>
                    <svg class="w-3.5 h-3.5 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7"/></svg>
                </button>
            </div>

            <!-- Center: Countdown Timer -->
            <div class="flex items-center gap-1.5 sm:gap-2 shrink-0">
                @if(!$existingScore)
                    <div class="sat-timer-box transition-colors duration-300 py-1 px-2 sm:py-1.5 sm:px-3.5"
                         :class="timerSeconds < 300 && !devMode ? 'bg-rose-50 border-rose-400 text-rose-900 shadow-sm' : ''">
                        <svg class="w-3.5 h-3.5 sm:w-4 sm:h-4 transition-colors shrink-0" :class="timerSeconds < 300 && !devMode ? 'text-rose-600' : 'text-sky-600'" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        
                        <div x-show="timerVisible" class="sat-timer-text text-sm sm:text-base" :class="timerSeconds < 300 && !devMode ? 'text-rose-600 font-black animate-pulse' : ''">
                            <span x-text="formatTime(timerSeconds)">32:00</span>
                        </div>
                        <div x-show="!timerVisible" class="text-xs font-semibold text-slate-500 italic hidden sm:inline">
                            Timer Hidden
                        </div>

                        <button type="button" @click="timerVisible = !timerVisible" class="text-[10px] sm:text-[11px] font-bold hover:underline ml-0.5 sm:ml-1 cursor-pointer" :class="timerSeconds < 300 && !devMode ? 'text-rose-700' : 'text-sky-600'">
                            <span x-text="timerVisible ? 'Hide' : 'Show'"></span>
                        </button>
                    </div>
                @else
                    <!-- Score Status Badge -->
                    <div class="sat-score-badge py-1 px-2.5 sm:py-1.5 sm:px-4" style="background-color: #ecfdf5 !important; border: 2px solid #10b981 !important; color: #065f46 !important; display: inline-flex !important; align-items: center !important; gap: 6px !important; border-radius: 9999px !important; box-shadow: 0 1px 3px rgba(16, 185, 129, 0.15) !important;">
                        <span class="sat-score-dot" style="width: 7px !important; height: 7px !important; border-radius: 50% !important; background-color: #10b981 !important; flex-shrink: 0 !important; display: inline-block !important;"></span>
                        <span class="sat-score-text text-xs sm:text-sm font-extrabold" style="color: #065f46 !important; letter-spacing: 0.01em !important; white-space: nowrap !important; display: inline-block !important;">
                            <span class="hidden sm:inline">Review Mode &bull; </span>Skor: {{ round($existingScore->score) }}%<span class="hidden sm:inline"> ({{ $existingScore->correct_count }}/{{ $existingScore->total_questions }})</span>
                        </span>
                    </div>
                @endif
            </div>

            <!-- Right: Official Bluebook Top Toolbar (Calculator, Reference, More 3-dots, and Exit) -->
            <div class="flex items-center gap-2 sm:gap-4 shrink-0">
                @if($isMath)
                    <!-- Official SAT Calculator (Icon on top of text) -->
                    <button type="button" 
                            @click="showCalculator = !showCalculator" 
                            class="flex flex-col items-center justify-center px-2 py-1 rounded-lg transition cursor-pointer group"
                            :class="showCalculator ? 'bg-teal-100 text-teal-900 font-black' : 'text-slate-700 hover:text-slate-900 hover:bg-slate-100'"
                            title="Buka Desmos Graphing Calculator">
                        <!-- Keypad Calculator SVG -->
                        <svg class="w-6 h-6 stroke-[1.8]" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                            <rect x="4" y="2" width="16" height="20" rx="2" stroke-width="2"/>
                            <rect x="7" y="5" width="10" height="3" rx="0.5" fill="currentColor" fill-opacity="0.15" stroke-width="1.5"/>
                            <circle cx="8" cy="12" r="1" fill="currentColor"/>
                            <circle cx="12" cy="12" r="1" fill="currentColor"/>
                            <circle cx="16" cy="12" r="1" fill="currentColor"/>
                            <circle cx="8" cy="15" r="1" fill="currentColor"/>
                            <circle cx="12" cy="15" r="1" fill="currentColor"/>
                            <circle cx="16" cy="15" r="1" fill="currentColor"/>
                            <circle cx="8" cy="18" r="1" fill="currentColor"/>
                            <circle cx="12" cy="18" r="1" fill="currentColor"/>
                            <circle cx="16" cy="18" r="1" fill="currentColor"/>
                        </svg>
                        <span class="text-[10px] font-bold tracking-tight mt-0.5 leading-none">Calculator</span>
                    </button>

                    <!-- Official SAT Reference (x² Math Icon on top of text) -->
                    <button type="button" 
                            @click="showReference = true" 
                            class="flex flex-col items-center justify-center px-2 py-1 rounded-lg text-slate-700 hover:text-slate-900 hover:bg-slate-100 transition cursor-pointer group"
                            title="Buka Lembar Rumus Resmi (Reference Sheet)">
                        <!-- Math x² icon styled exactly like College Board Bluebook -->
                        <div class="h-6 flex items-center justify-center font-serif text-lg font-black italic tracking-tighter leading-none select-none">
                            <span>x</span><sup class="text-[11px] font-sans not-italic font-black -top-1 ml-0.5">2</sup>
                        </div>
                        <span class="text-[10px] font-bold tracking-tight mt-0.5 leading-none">Reference</span>
                    </button>
                @else
                    <!-- Annotate & Scratchpad Button for RW -->
                    <button type="button" 
                            @click="toggleAnnotateTool()" 
                            class="flex flex-col items-center justify-center px-2 py-1 rounded-lg transition cursor-pointer relative"
                            :class="showScratchpad ? 'bg-amber-100 text-amber-950 font-black ring-2 ring-amber-400' : 'text-slate-700 hover:text-slate-900 hover:bg-slate-100'"
                            title="Buka Catatan & Alat Sorot (Annotate & Scratchpad)">
                        <svg class="w-6 h-6 stroke-[1.8]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/></svg>
                        <span class="text-[10px] font-bold tracking-tight mt-0.5 leading-none">Annotate</span>
                        <template x-if="hasAnnotation(currentIndex)">
                            <span class="absolute top-1 right-1 w-2 h-2 rounded-full bg-amber-500 animate-pulse"></span>
                        </template>
                    </button>
                @endif

                <!-- Official 3-Dots 'More' Menu Trigger -->
                <div class="relative">
                    <button type="button" 
                            @click="showMoreInfo = !showMoreInfo" 
                            class="flex flex-col items-center justify-center px-2 py-1 rounded-lg transition cursor-pointer"
                            :class="showMoreInfo ? 'bg-slate-200 text-slate-950 font-black' : 'text-slate-700 hover:text-slate-900 hover:bg-slate-100'"
                            title="Fitur & Panduan Bluebook (More)">
                        <svg class="w-6 h-6" viewBox="0 0 24 24" fill="currentColor">
                            <circle cx="12" cy="5" r="2"/>
                            <circle cx="12" cy="12" r="2"/>
                            <circle cx="12" cy="19" r="2"/>
                        </svg>
                        <span class="text-[10px] font-bold tracking-tight mt-0.5 leading-none">More</span>
                    </button>
                </div>

                @if($existingScore)
                    @if($testNumber)
                    <a href="{{ route($satRoutePrefix . 'score-report', $testNumber) }}" 
                       class="sat-btn-nav hidden sm:inline-flex items-center gap-1.5" style="background-color: #0284c7 !important; color: #ffffff !important; border-color: #38bdf8 !important;">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
                        <span>Score Report</span>
                    </a>
                    @endif
                    <a href="{{ $resetRoute }}" 
                       onclick="return confirm('Apakah Anda yakin ingin mengulang latihan ini? Jawaban sebelumnya akan direset.')"
                       class="sat-btn-nav hidden sm:inline-flex" style="background-color: #ca8a04 !important; color: #ffffff !important; border-color: #eab308 !important;">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
                        <span>Ulangi Tes</span>
                    </a>
                @endif

                <!-- Header Emergency Exit (Icon Only, Subtle & Clean) -->
                <a href="{{ route(rtrim($satRoutePrefix, '.')) }}" 
                   @if(!$existingScore) onclick="return confirm('Apakah Anda yakin ingin keluar dari tes? Jawaban Anda yang belum disubmit tidak akan tersimpan.')" @endif
                   class="p-2 rounded-xl text-slate-400 hover:text-rose-600 hover:bg-rose-50 transition border border-transparent hover:border-rose-200"
                   title="Keluar dari sesi ujian (Emergency Exit)">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                    </svg>
                </a>
            </div>
        </header>

        <!-- ======================================================== -->
        <!-- MAIN CBT INTERFACE: ADAPTIVE LAYOUT (1 PANE FOR MATH, 2 PANES FOR RW) -->
        <!-- ======================================================== -->
        <main class="sat-main-body">

            @php
                $formatLatex = function ($text) {
                    if (empty($text)) return $text;
                    $trimmed = trim($text);
                    // If already wrapped in \( \) or \[ \], return as is
                    if (str_starts_with($trimmed, '\\(') || str_starts_with($trimmed, '\\[')) {
                        return $trimmed;
                    }
                    // If simple currency like $45 or $480.00, do not treat as LaTeX math
                    if (preg_match('/^\\\?\$[0-9,\.]+(\s*|\b)/', $trimmed) && !str_contains($trimmed, '\\') && !str_contains($trimmed, '^')) {
                        return $trimmed;
                    }
                    // If contains raw TeX commands or math symbols without LaTeX delimiters
                    if (preg_match('/(\\\\(le|ge|frac|sqrt|pm|ne|cdot|times|approx|infty|pi|theta|degree|alpha|beta|sum|int|cases|begin|text)\b|\^|_|(\b[xyzhabcpqkmn]\b\s*[\+\-\*\/\=]))/', $trimmed)) {
                        return '\\(' . $trimmed . '\\)';
                    }
                    return $trimmed;
                };
            @endphp

            @foreach($questions as $index => $q)
            @php
                $userAns = $scoreAnswers[$q->id] ?? null;
                $correctAns = strtoupper(trim((string)$q->correct_answer));
                $isCorrect = $userAns && ($userAns === $correctAns);
                // Only ever reveal the answer key into the live test-mode markup for
                // a real admin (admin-peek dev tool). For everyone else this must be
                // a value that can never match an option letter, otherwise the
                // correct answer leaks into page source / Alpine expressions for
                // every student mid-test, before they've even submitted.
                $correctAnsForPeek = $isAdmin ? $correctAns : '';
            @endphp

            <div x-show="currentIndex === {{ $index }}" 
                 class="sat-question-container"
                 x-transition:enter="transition ease-out duration-150"
                 x-transition:enter-start="opacity-0 translate-x-2"
                 x-transition:enter-end="opacity-100 translate-x-0">

                @if($isMath)
                    <!-- ======================================================== -->
                    <!-- DIGITAL SAT MATH: SINGLE CENTERED PANE (OFFICIAL BLUEBOOK FORMAT) -->
                    <!-- ======================================================== -->
                    <section class="sat-math-single-pane cbt-scroll">
                        <div class="max-w-2xl mx-auto space-y-6">

                            <!-- Item Header & Mark for Review -->
                            <div class="flex items-center justify-between pb-4 border-b border-slate-200">
                                <div class="flex items-center gap-2.5">
                                    <span class="sat-q-num-badge">
                                        {{ $index + 1 }}
                                    </span>
                                    <span class="text-sm font-extrabold text-slate-800 uppercase tracking-wide">
                                        Question {{ $index + 1 }}
                                    </span>
                                    @if(!empty($q->category))
                                        <span class="ml-2 px-2.5 py-0.5 rounded-full text-[11px] font-extrabold bg-teal-50 text-teal-800 border border-teal-200">
                                            {{ $q->category }}
                                        </span>
                                    @endif
                                </div>

                                <div class="flex items-center gap-2">
                                    <!-- Mark for Review Toggle -->
                                    @if(!$existingScore)
                                    <button type="button" @click="toggleMark({{ $index + 1 }})"
                                            class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl text-xs font-extrabold border transition shadow-xs cursor-pointer"
                                            :class="isMarked({{ $index + 1 }}) 
                                                     ? 'bg-amber-100 border-amber-400 text-amber-900 ring-2 ring-amber-300' 
                                                     : 'bg-white border-slate-300 text-slate-700 hover:bg-slate-100'">
                                        <svg class="w-3.5 h-3.5" :class="isMarked({{ $index + 1 }}) ? 'text-amber-600 fill-amber-500' : 'text-slate-400'" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z"/>
                                        </svg>
                                        <span x-text="isMarked({{ $index + 1 }}) ? 'Marked for Review' : 'Mark for Review'"></span>
                                    </button>

                                    <!-- Bluebook ABC Eliminate (Coret) Tool Toggle Icon -->
                                    <button type="button" @click="eliminationMode = !eliminationMode"
                                            class="inline-flex items-center justify-center px-2 py-1.5 rounded-xl text-xs font-black border transition shadow-xs cursor-pointer select-none"
                                            :class="eliminationMode ? 'bg-slate-900 text-white border-slate-900 shadow-sm' : 'bg-white border-slate-300 text-slate-600 hover:bg-slate-100'"
                                            title="Aktifkan / Sembunyikan fitur Coret Opsi Jawaban (Eliminate)">
                                        <span class="tracking-tighter line-through font-serif text-[11px] font-bold">ABC</span>
                                    </button>
                                    @else
                                        @if($isCorrect)
                                            <span class="px-3.5 py-1 rounded-full text-xs font-black bg-emerald-100 text-emerald-800 border-2 border-emerald-300 flex items-center gap-1.5">
                                                <svg class="w-3.5 h-3.5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                                                Jawaban Benar
                                            </span>
                                        @else
                                            <span class="px-3.5 py-1 rounded-full text-xs font-black bg-rose-100 text-rose-800 border-2 border-rose-300 flex items-center gap-1.5">
                                                <svg class="w-3.5 h-3.5 text-rose-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/></svg>
                                                Jawaban Salah
                                            </span>
                                        @endif
                                    @endif
                                </div>
                            </div>

                            <!-- Optional Context / Stimulus (if present) -->
                            @if(!empty($q->passage))
                                <div class="reading-passage sat-passage-text p-4 bg-slate-100/80 rounded-2xl border border-slate-200 text-slate-700 text-sm leading-relaxed font-serif select-text" id="passageText-math-{{ $index }}">
                                    {!! nl2br(e($q->passage)) !!}
                                </div>
                            @endif

                            <!-- Question Prompt -->
                            @if(!empty($q->question_prompt))
                                <div class="sat-q-prompt select-text text-lg leading-relaxed">
                                    {{ $q->question_prompt }}
                                </div>
                            @endif

                            <!-- Multiple Choice Options (A, B, C, D) -->
                            <div class="space-y-3 pt-2">
                                @foreach(['A', 'B', 'C', 'D'] as $opt)
                                @php
                                    $optLower = strtolower($opt);
                                    $optText = $formatLatex($q->{'option_' . $optLower});
                                    $isCorrectOpt = ($correctAns === $opt);
                                    $isUserOpt = ($userAns === $opt);
                                @endphp

                                @if(!empty($optText))
                                    @if(!$existingScore)
                                        <!-- TEST MODE OPTION -->
                                        <label class="sat-option-card group relative"
                                               @click="setAnswer({{ $q->id }}, '{{ $opt }}')"
                                               :class="[
                                                   getAnswer({{ $q->id }}) === '{{ $opt }}' ? 'selected' : '',
                                                   isEliminated({{ $q->id }}, '{{ $opt }}') ? 'eliminated' : '',
                                                   (!studentPreview && adminPeekKey && '{{ $correctAnsForPeek }}' === '{{ $opt }}') ? 'admin-peek-highlight' : ''
                                               ]">
                                            <input type="radio" 
                                                   name="ui_q_{{ $q->id }}" 
                                                   value="{{ $opt }}" 
                                                   :checked="getAnswer({{ $q->id }}) === '{{ $opt }}'"
                                                   class="hidden"
                                                   @change="setAnswer({{ $q->id }}, '{{ $opt }}')">
                                            
                                            <!-- Letter Circle -->
                                            <span class="sat-option-letter">
                                                {{ $opt }}
                                            </span>

                                            <!-- Option Text -->
                                            <div class="sat-option-text flex-1 select-text">
                                                {{ $optText }}
                                            </div>

                                            <!-- Eliminate (Strikethrough) Toggle Button -->
                                            <template x-if="eliminationMode">
                                                <button type="button" 
                                                        @click.stop="toggleEliminate({{ $q->id }}, '{{ $opt }}', $event)"
                                                        class="sat-eliminate-btn shrink-0"
                                                        :class="isEliminated({{ $q->id }}, '{{ $opt }}') ? 'active' : ''"
                                                        title="Coret / eliminasi opsi ini">
                                                    <span x-text="isEliminated({{ $q->id }}, '{{ $opt }}') ? 'Coretan (Batal)' : 'Coret'"></span>
                                                </button>
                                            </template>

                                            <template x-if="!studentPreview && adminPeekKey && '{{ $correctAnsForPeek }}' === '{{ $opt }}'">
                                                <span class="px-2.5 py-1 rounded-full text-xs font-black bg-emerald-100 text-emerald-800 border border-emerald-300 shrink-0">
                                                    ✓ Kunci Jawaban
                                                </span>
                                            </template>
                                        </label>
                                    @else
                                        <!-- REVIEW MODE OPTION -->
                                        @php
                                            $modeClass = '';
                                            if ($isCorrectOpt) {
                                                $modeClass = 'correct';
                                            } elseif ($isUserOpt && !$isCorrectOpt) {
                                                $modeClass = 'wrong';
                                            }
                                        @endphp
                                        <div class="sat-option-card {{ $modeClass }}">
                                            <span class="sat-option-letter">
                                                {{ $opt }}
                                            </span>
                                            <div class="sat-option-text flex-1 select-text">
                                                {{ $optText }}
                                            </div>
                                            @if($isCorrectOpt)
                                                <span class="px-2.5 py-1 rounded-full text-xs font-black bg-emerald-100 text-emerald-800 border border-emerald-300 shrink-0">
                                                    ✓ Kunci Jawaban
                                                </span>
                                            @elseif($isUserOpt)
                                                <span class="px-2.5 py-1 rounded-full text-xs font-black bg-rose-100 text-rose-800 border border-rose-300 shrink-0">
                                                    ✕ Jawaban Anda
                                                </span>
                                            @endif
                                        </div>
                                    @endif
                                @endif
                                @endforeach
                            </div>

                            <!-- EXPLANATION IN REVIEW MODE OR ADMIN PEEK -->
                            @if(!empty($q->explanation))
                            <div x-show="{{ $existingScore ? 'true' : '(!studentPreview && adminPeekKey)' }}" 
                                 class="mt-8 p-6 bg-teal-50 rounded-2xl border-2 border-teal-200 shadow-sm"
                                 style="{{ $existingScore ? '' : 'display: none;' }}">
                                <div class="flex items-center gap-2 mb-3">
                                    <span class="p-1 rounded-md bg-teal-600 text-white">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"/></svg>
                                    </span>
                                    <h4 class="font-extrabold text-sm text-teal-900 uppercase tracking-wider">
                                        Pembahasan Resmi SAT Math:
                                        @if(!$existingScore)
                                            <span class="text-[10px] text-purple-700 bg-purple-100 px-2 py-0.5 rounded-full ml-1">Admin Peek</span>
                                        @endif
                                    </h4>
                                </div>
                                <p class="text-sm text-slate-800 leading-relaxed select-text font-medium">
                                    {!! nl2br(e($q->explanation)) !!}
                                </p>
                            </div>
                            @endif

                            <!-- AI TUTOR EXPLANATION SECTION (DIGITAL SAT MATH) -->
                            <div x-show="{{ $existingScore ? 'true' : '(!studentPreview && adminPeekKey)' }}" 
                                 class="mt-4"
                                 style="{{ $existingScore ? '' : 'display: none;' }}">
                                
                                <!-- Tombol Minta Penjelasan AI (jika belum dimuat) -->
                                <div x-show="!aiExplanations[{{ $q->id }}] && !aiLoading[{{ $q->id }}]" class="pt-2">
                                    <button type="button" 
                                            @click="askAiExplanation({{ $q->id }}, {{ $index + 1 }}, '{{ $userAns ?? '' }}', 'math')"
                                            class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl font-bold text-xs text-white bg-gradient-to-r from-indigo-600 via-purple-600 to-teal-600 hover:from-indigo-700 hover:via-purple-700 hover:to-teal-700 shadow-md hover:shadow-lg transition-all duration-200 transform hover:-translate-y-0.5 cursor-pointer">
                                        <svg class="w-4 h-4 text-amber-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                                        </svg>
                                        <span>Tanya Tutor AI (Penjelasan Rumus & Trik Cepat)</span>
                                    </button>
                                </div>

                                <!-- Loading State -->
                                <div x-show="aiLoading[{{ $q->id }}]" 
                                     style="display: none;"
                                     class="p-5 rounded-2xl bg-gradient-to-r from-indigo-50/70 via-purple-50/70 to-teal-50/70 border border-indigo-200/80 shadow-xs flex items-center gap-3.5">
                                    <div class="w-5 h-5 border-2 border-indigo-600 border-t-transparent rounded-full animate-spin shrink-0"></div>
                                    <div class="space-y-0.5">
                                        <div class="text-xs font-bold text-indigo-950">Tutor AI sedang menganalisis soal & langkah pengerjaan...</div>
                                        <div class="text-[11px] text-indigo-700/80">Menyiapkan rumus, langkah penyelesaian, dan strategi cepat SAT Math.</div>
                                    </div>
                                </div>

                                <!-- AI Explanation Content Card -->
                                <div x-show="aiExplanations[{{ $q->id }}]" 
                                     style="display: none;"
                                     x-transition:enter="transition ease-out duration-200"
                                     x-transition:enter-start="opacity-0 translate-y-1"
                                     x-transition:enter-end="opacity-100 translate-y-0"
                                     class="p-6 rounded-2xl bg-gradient-to-br from-indigo-50/90 via-purple-50/50 to-white border-2 border-indigo-200 shadow-md space-y-4">
                                    
                                    <!-- Header -->
                                    <div class="flex items-center justify-between pb-3 border-b border-indigo-100">
                                        <div class="flex items-center gap-2.5">
                                            <div class="w-7 h-7 rounded-lg bg-gradient-to-tr from-indigo-600 to-teal-600 flex items-center justify-center text-white shadow-xs">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                                            </div>
                                            <div>
                                                <h4 class="font-extrabold text-sm text-indigo-950 tracking-tight flex items-center gap-1.5">
                                                    <span>Penjelasan Tutor AI Target Bahasa</span>
                                                    <span class="text-[10px] font-black uppercase tracking-wider px-2 py-0.5 rounded-full bg-indigo-100 text-indigo-800 border border-indigo-200">AI Powered</span>
                                                </h4>
                                                <span class="text-[10px] text-slate-500 font-medium" x-text="aiSources[{{ $q->id }}] || 'Digital SAT Math AI Expert'"></span>
                                            </div>
                                        </div>
                                        
                                        <button type="button" 
                                                @click="aiExplanations[{{ $q->id }}] = null"
                                                class="text-xs text-slate-400 hover:text-slate-600 px-2 py-1 rounded-lg hover:bg-white/80 transition cursor-pointer"
                                                title="Sembunyikan penjelasan AI">
                                            ✕ Tutup
                                        </button>
                                    </div>

                                    <!-- Body Content -->
                                    <div class="text-sm text-slate-800 leading-relaxed font-sans select-text sat-ai-content space-y-2" 
                                         x-html="renderMarkdown(aiExplanations[{{ $q->id }}])">
                                    </div>

                                    <!-- Footer Action -->
                                    <div class="pt-2 border-t border-indigo-100/60 flex items-center justify-between text-[11px] text-slate-500">
                                        <span class="italic">💡 Tip: Pelajari kembali langkah rumus dan trik eliminasi di atas.</span>
                                        <button type="button" 
                                                @click="askAiExplanation({{ $q->id }}, {{ $index + 1 }}, '{{ $userAns ?? '' }}', 'math', true)"
                                                class="text-indigo-600 hover:text-indigo-800 font-bold hover:underline cursor-pointer">
                                            ↻ Muat Ulang Penjelasan
                                        </button>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </section>

                @else
                    <!-- ======================================================== -->
                    <!-- DIGITAL SAT READING & WRITING: SPLIT 2 PANES (PASSAGE + QUESTION) -->
                    <!-- ======================================================== -->

                    <!-- LEFT PANE: PASSAGE / READING STIMULUS -->
                    <section class="sat-passage-pane cbt-scroll">
                        <div class="max-w-xl mx-auto space-y-4">
                            <!-- Passage Tag / Domain -->
                            <div class="flex items-center justify-between pb-3 border-b border-slate-200">
                                <span class="sat-domain-badge flex items-center gap-2">
                                    <span class="w-2.5 h-2.5 rounded-full bg-blue-600 inline-block"></span>
                                    {{ $q->category ?? 'Digital SAT Reading & Writing' }}
                                </span>
                                <span class="text-xs font-bold text-slate-500">
                                    Item {{ $index + 1 }} of {{ $totalCount }}
                                </span>
                            </div>

                            <!-- Stimulus Content -->
                            @if(!empty($q->passage))
                                <div class="reading-passage sat-passage-text select-text" id="passageText-{{ $index }}">
                                    {!! nl2br(e($q->passage)) !!}
                                </div>
                            @else
                                <div class="p-6 bg-slate-100 rounded-2xl border border-slate-300 text-center text-slate-600 text-sm italic font-semibold">
                                    Soal ini menguji tata bahasa atau sintesis langsung tanpa teks bacaan panjang. Perhatikan instruksi pada kolom kanan.
                                </div>
                            @endif
                        </div>
                    </section>

                    <!-- RIGHT PANE: QUESTION PROMPT & OPTIONS -->
                    <section class="sat-question-pane cbt-scroll">
                        <div class="max-w-xl mx-auto space-y-6">

                            <!-- Item Header & Mark for Review -->
                            <div class="flex items-center justify-between pb-4 border-b border-slate-200">
                                <div class="flex items-center gap-2.5">
                                    <span class="sat-q-num-badge">
                                        {{ $index + 1 }}
                                    </span>
                                    <span class="text-sm font-extrabold text-slate-800 uppercase tracking-wide">
                                        Question {{ $index + 1 }}
                                    </span>
                                </div>

                                <div class="flex items-center gap-2">
                                    <!-- Mark for Review Toggle -->
                                    @if(!$existingScore)
                                    <button type="button" @click="toggleMark({{ $index + 1 }})"
                                            class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl text-xs font-extrabold border transition shadow-xs cursor-pointer"
                                            :class="isMarked({{ $index + 1 }}) 
                                                     ? 'bg-amber-100 border-amber-400 text-amber-900 ring-2 ring-amber-300' 
                                                     : 'bg-white border-slate-300 text-slate-700 hover:bg-slate-100'">
                                        <svg class="w-3.5 h-3.5" :class="isMarked({{ $index + 1 }}) ? 'text-amber-600 fill-amber-500' : 'text-slate-400'" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z"/>
                                        </svg>
                                        <span x-text="isMarked({{ $index + 1 }}) ? 'Marked for Review' : 'Mark for Review'"></span>
                                    </button>

                                    <!-- Bluebook ABC Eliminate (Coret) Tool Toggle Icon -->
                                    <button type="button" @click="eliminationMode = !eliminationMode"
                                            class="inline-flex items-center justify-center px-2 py-1.5 rounded-xl text-xs font-black border transition shadow-xs cursor-pointer select-none"
                                            :class="eliminationMode ? 'bg-slate-900 text-white border-slate-900 shadow-sm' : 'bg-white border-slate-300 text-slate-600 hover:bg-slate-100'"
                                            title="Aktifkan / Sembunyikan fitur Coret Opsi Jawaban (Eliminate)">
                                        <span class="tracking-tighter line-through font-serif text-[11px] font-bold">ABC</span>
                                    </button>
                                    @else
                                        @if($isCorrect)
                                            <span class="px-3.5 py-1 rounded-full text-xs font-black bg-emerald-100 text-emerald-800 border-2 border-emerald-300 flex items-center gap-1.5">
                                                <svg class="w-3.5 h-3.5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                                                Jawaban Benar
                                            </span>
                                        @else
                                            <span class="px-3.5 py-1 rounded-full text-xs font-black bg-rose-100 text-rose-800 border-2 border-rose-300 flex items-center gap-1.5">
                                                <svg class="w-3.5 h-3.5 text-rose-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/></svg>
                                                Jawaban Salah
                                            </span>
                                        @endif
                                    @endif
                                </div>
                            </div>

                            <!-- Question Prompt -->
                            @if(!empty($q->question_prompt))
                                <div class="sat-q-prompt select-text">
                                    {{ $q->question_prompt }}
                                </div>
                            @endif

                            <!-- Multiple Choice Options (A, B, C, D) -->
                            <div class="space-y-3 pt-2">
                                @foreach(['A', 'B', 'C', 'D'] as $opt)
                                @php
                                    $optLower = strtolower($opt);
                                    $optText = $formatLatex($q->{'option_' . $optLower});
                                    $isCorrectOpt = ($correctAns === $opt);
                                    $isUserOpt = ($userAns === $opt);
                                @endphp

                                @if(!empty($optText))
                                    @if(!$existingScore)
                                        <!-- TEST MODE OPTION -->
                                        <label class="sat-option-card group relative"
                                               @click="setAnswer({{ $q->id }}, '{{ $opt }}')"
                                               :class="[
                                                   getAnswer({{ $q->id }}) === '{{ $opt }}' ? 'selected' : '',
                                                   isEliminated({{ $q->id }}, '{{ $opt }}') ? 'eliminated' : '',
                                                   (!studentPreview && adminPeekKey && '{{ $correctAnsForPeek }}' === '{{ $opt }}') ? 'admin-peek-highlight' : ''
                                               ]">
                                            <input type="radio" 
                                                   name="ui_q_{{ $q->id }}" 
                                                   value="{{ $opt }}" 
                                                   :checked="getAnswer({{ $q->id }}) === '{{ $opt }}'"
                                                   class="hidden"
                                                   @change="setAnswer({{ $q->id }}, '{{ $opt }}')">
                                            
                                            <!-- Letter Circle -->
                                            <span class="sat-option-letter">
                                                {{ $opt }}
                                            </span>

                                            <!-- Option Text -->
                                            <div class="sat-option-text flex-1 select-text">
                                                {{ $optText }}
                                            </div>

                                            <!-- Eliminate (Strikethrough) Toggle Button -->
                                            <template x-if="eliminationMode">
                                                <button type="button" 
                                                        @click.stop="toggleEliminate({{ $q->id }}, '{{ $opt }}', $event)"
                                                        class="sat-eliminate-btn shrink-0"
                                                        :class="isEliminated({{ $q->id }}, '{{ $opt }}') ? 'active' : ''"
                                                        title="Coret / eliminasi opsi ini">
                                                    <span x-text="isEliminated({{ $q->id }}, '{{ $opt }}') ? 'Coretan (Batal)' : 'Coret'"></span>
                                                </button>
                                            </template>

                                            <template x-if="!studentPreview && adminPeekKey && '{{ $correctAnsForPeek }}' === '{{ $opt }}'">
                                                <span class="px-2.5 py-1 rounded-full text-xs font-black bg-emerald-100 text-emerald-800 border border-emerald-300 shrink-0">
                                                    ✓ Kunci Jawaban
                                                </span>
                                            </template>
                                        </label>
                                    @else
                                        <!-- REVIEW MODE OPTION -->
                                        @php
                                            $modeClass = '';
                                            if ($isCorrectOpt) {
                                                $modeClass = 'correct';
                                            } elseif ($isUserOpt && !$isCorrectOpt) {
                                                $modeClass = 'wrong';
                                            }
                                        @endphp
                                        <div class="sat-option-card {{ $modeClass }}">
                                            <span class="sat-option-letter">
                                                {{ $opt }}
                                            </span>
                                            <div class="sat-option-text flex-1 select-text">
                                                {{ $optText }}
                                            </div>
                                            @if($isCorrectOpt)
                                                <span class="px-2.5 py-1 rounded-full text-xs font-black bg-emerald-100 text-emerald-800 border border-emerald-300 shrink-0">
                                                    ✓ Kunci Jawaban
                                                </span>
                                            @elseif($isUserOpt)
                                                <span class="px-2.5 py-1 rounded-full text-xs font-black bg-rose-100 text-rose-800 border border-rose-300 shrink-0">
                                                    ✕ Jawaban Anda
                                                </span>
                                            @endif
                                        </div>
                                    @endif
                                @endif
                                @endforeach
                            </div>

                            <!-- EXPLANATION IN REVIEW MODE OR ADMIN PEEK -->
                            @if(!empty($q->explanation))
                            <div x-show="{{ $existingScore ? 'true' : '(!studentPreview && adminPeekKey)' }}" 
                                 class="mt-8 p-6 bg-blue-50 rounded-2xl border-2 border-blue-200 shadow-sm"
                                 style="{{ $existingScore ? '' : 'display: none;' }}">
                                <div class="flex items-center gap-2 mb-3">
                                    <span class="p-1 rounded-md bg-blue-600 text-white">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"/></svg>
                                    </span>
                                    <h4 class="font-extrabold text-sm text-blue-900 uppercase tracking-wider">
                                        Pembahasan Resmi (Princeton Review):
                                        @if(!$existingScore)
                                            <span class="text-[10px] text-purple-700 bg-purple-100 px-2 py-0.5 rounded-full ml-1">Admin Peek</span>
                                        @endif
                                    </h4>
                                </div>
                                <p class="text-sm text-slate-800 leading-relaxed select-text font-medium">
                                    {!! nl2br(e($q->explanation)) !!}
                                </p>
                            </div>
                            @endif

                            <!-- AI TUTOR EXPLANATION SECTION (DIGITAL SAT READING & WRITING) -->
                            <div x-show="{{ $existingScore ? 'true' : '(!studentPreview && adminPeekKey)' }}" 
                                 class="mt-4"
                                 style="{{ $existingScore ? '' : 'display: none;' }}">
                                
                                <!-- Tombol Minta Penjelasan AI (jika belum dimuat) -->
                                <div x-show="!aiExplanations[{{ $q->id }}] && !aiLoading[{{ $q->id }}]" class="pt-2">
                                    <button type="button" 
                                            @click="askAiExplanation({{ $q->id }}, {{ $index + 1 }}, '{{ $userAns ?? '' }}', 'reading_writing')"
                                            class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl font-bold text-xs text-white bg-gradient-to-r from-blue-600 via-indigo-600 to-purple-600 hover:from-blue-700 hover:via-indigo-700 hover:to-purple-700 shadow-md hover:shadow-lg transition-all duration-200 transform hover:-translate-y-0.5 cursor-pointer">
                                        <svg class="w-4 h-4 text-amber-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                                        </svg>
                                        <span>Tanya Tutor AI (Analisis Jebakan & Trik Bacaan)</span>
                                    </button>
                                </div>

                                <!-- Loading State -->
                                <div x-show="aiLoading[{{ $q->id }}]" 
                                     style="display: none;"
                                     class="p-5 rounded-2xl bg-gradient-to-r from-blue-50/70 via-indigo-50/70 to-purple-50/70 border border-blue-200/80 shadow-xs flex items-center gap-3.5">
                                    <div class="w-5 h-5 border-2 border-blue-600 border-t-transparent rounded-full animate-spin shrink-0"></div>
                                    <div class="space-y-0.5">
                                        <div class="text-xs font-bold text-blue-950">Tutor AI sedang menganalisis teks bacaan & pilihan kata...</div>
                                        <div class="text-[11px] text-blue-700/80">Menyiapkan analisis konteks, alasan jawaban benar, dan strategi eliminasi SAT.</div>
                                    </div>
                                </div>

                                <!-- AI Explanation Content Card -->
                                <div x-show="aiExplanations[{{ $q->id }}]" 
                                     style="display: none;"
                                     x-transition:enter="transition ease-out duration-200"
                                     x-transition:enter-start="opacity-0 translate-y-1"
                                     x-transition:enter-end="opacity-100 translate-y-0"
                                     class="p-6 rounded-2xl bg-gradient-to-br from-blue-50/90 via-indigo-50/50 to-white border-2 border-blue-200 shadow-md space-y-4">
                                    
                                    <!-- Header -->
                                    <div class="flex items-center justify-between pb-3 border-b border-blue-100">
                                        <div class="flex items-center gap-2.5">
                                            <div class="w-7 h-7 rounded-lg bg-gradient-to-tr from-blue-600 to-indigo-600 flex items-center justify-center text-white shadow-xs">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                                            </div>
                                            <div>
                                                <h4 class="font-extrabold text-sm text-blue-950 tracking-tight flex items-center gap-1.5">
                                                    <span>Penjelasan Tutor AI Target Bahasa</span>
                                                    <span class="text-[10px] font-black uppercase tracking-wider px-2 py-0.5 rounded-full bg-blue-100 text-blue-800 border border-blue-200">AI Powered</span>
                                                </h4>
                                                <span class="text-[10px] text-slate-500 font-medium" x-text="aiSources[{{ $q->id }}] || 'Digital SAT Reading & Writing AI Expert'"></span>
                                            </div>
                                        </div>
                                        
                                        <button type="button" 
                                                @click="aiExplanations[{{ $q->id }}] = null"
                                                class="text-xs text-slate-400 hover:text-slate-600 px-2 py-1 rounded-lg hover:bg-white/80 transition cursor-pointer"
                                                title="Sembunyikan penjelasan AI">
                                            ✕ Tutup
                                        </button>
                                    </div>

                                    <!-- Body Content -->
                                    <div class="text-sm text-slate-800 leading-relaxed font-sans select-text sat-ai-content space-y-2" 
                                         x-html="renderMarkdown(aiExplanations[{{ $q->id }}])">
                                    </div>

                                    <!-- Footer Action -->
                                    <div class="pt-2 border-t border-blue-100/60 flex items-center justify-between text-[11px] text-slate-500">
                                        <span class="italic">💡 Tip: Perhatikan kata kunci (clues) dan konteks nada bacaan.</span>
                                        <button type="button" 
                                                @click="askAiExplanation({{ $q->id }}, {{ $index + 1 }}, '{{ $userAns ?? '' }}', 'reading_writing', true)"
                                                class="text-blue-600 hover:text-blue-800 font-bold hover:underline cursor-pointer">
                                            ↻ Muat Ulang Penjelasan
                                        </button>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </section>
                @endif

            </div>
            @endforeach

        </main>

        <!-- ======================================================== -->
        <!-- BOTTOM CBT FOOTER BAR -->
        <!-- ======================================================== -->
        <footer class="h-16 sat-footer px-3 sm:px-6 flex items-center justify-between shrink-0 relative z-30">
            <!-- Left Info (Hidden on mobile to give room for navigation) -->
            <div class="hidden md:flex items-center gap-3">
                <div class="text-xs sm:text-sm font-extrabold text-slate-700">
                    Digital SAT {{ $isMath ? 'Math' : 'Reading & Writing' }}
                </div>
            </div>

            <!-- Center Question Navigator Dropdown Button -->
            <div class="relative">
                <button type="button" @click="showNavigator = !showNavigator" class="sat-btn-nav-trigger py-1.5 px-3 sm:py-2 sm:px-4 text-xs sm:text-sm">
                    <span>Question <span x-text="currentIndex + 1">1</span> of {{ $totalCount }}</span>
                    <svg class="w-3.5 h-3.5 sm:w-4 sm:h-4 transition-transform duration-200" :class="showNavigator ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 15l7-7 7 7"/></svg>
                </button>

                <!-- QUESTION NAVIGATOR POPOVER (GRID 1 - 27) -->
                <div x-show="showNavigator" 
                     @click.away="showNavigator = false"
                     class="sat-nav-popover"
                     x-transition:enter="transition ease-out duration-150"
                     x-transition:enter-start="opacity-0 translate-y-2 scale-95"
                     x-transition:enter-end="opacity-100 translate-y-0 scale-100">
                    
                    <div class="flex items-center justify-between pb-3 mb-3 border-b border-slate-200">
                        <h3 class="font-extrabold text-sm text-slate-900">Question Navigator</h3>
                        <span class="text-xs text-slate-500 font-bold">
                            <span x-text="answeredCount()">0</span> of {{ $totalCount }} Answered
                        </span>
                    </div>

                    <!-- Legend -->
                    <div class="flex items-center justify-around gap-2 text-[11px] font-bold text-slate-600 pb-3 mb-3 border-b border-slate-200">
                        <span class="flex items-center gap-1.5">
                            <span class="w-3 h-3 rounded bg-sky-600 inline-block"></span> Terjawab
                        </span>
                        <span class="flex items-center gap-1.5">
                            <span class="w-3 h-3 rounded border-2 border-slate-400 bg-white inline-block"></span> Belum
                        </span>
                        <span class="flex items-center gap-1.5">
                            <span class="w-3 h-3 rounded bg-amber-400 inline-block"></span> Review
                        </span>
                    </div>

                    <!-- Grid of 27 Questions -->
                    <div style="display: grid; grid-template-columns: repeat(7, minmax(0, 1fr)); gap: 8px;" class="max-h-56 overflow-y-auto p-1">
                        @foreach($questions as $index => $q)
                        <button type="button" 
                                @click="goToQuestion({{ $index }})"
                                class="h-9 rounded-xl font-black text-xs relative flex items-center justify-center transition border-2 cursor-pointer"
                                :class="getNavButtonClass({{ $index }}, {{ $q->id }})">
                            {{ $index + 1 }}
                            <!-- Flag icon if marked -->
                            <span x-show="isMarked({{ $index + 1 }})" class="absolute -top-1 -right-1 w-2.5 h-2.5 bg-amber-500 rounded-full border border-white"></span>
                        </button>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Right: Back & Next / Submit Buttons -->
            <div class="flex items-center gap-1.5 sm:gap-3">
                <!-- Back Button -->
                <button type="button" 
                        @click="prevQuestion()" 
                        :disabled="currentIndex === 0"
                        class="sat-btn-back py-1.5 px-3 sm:py-2 sm:px-4 text-xs sm:text-sm disabled:opacity-40 disabled:cursor-not-allowed">
                    <svg class="w-3.5 h-3.5 sm:w-4 sm:h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"/></svg>
                    <span>Back</span>
                </button>

                <!-- Next Button (Questions 0 to totalCount - 2) -->
                <button type="button" 
                        x-show="currentIndex < {{ $totalCount - 1 }}"
                        x-cloak
                        :style="currentIndex < {{ $totalCount - 1 }} ? '' : 'display: none !important;'"
                        @click="nextQuestion()"
                        class="sat-btn-next py-1.5 px-3.5 sm:py-2 sm:px-6 text-xs sm:text-sm">
                    <span>Next</span>
                    <svg class="w-3.5 h-3.5 sm:w-4 sm:h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/></svg>
                </button>

                <!-- Submit / Review Button on Last Question ONLY -->
                @if(!$existingScore)
                <button type="button" 
                        x-show="currentIndex === {{ $totalCount - 1 }}"
                        x-cloak
                        :style="currentIndex === {{ $totalCount - 1 }} ? '' : 'display: none !important;'"
                        style="display: none;"
                        @click="showReviewModal = true"
                        class="sat-btn-submit py-1.5 px-3.5 sm:py-2 sm:px-6 text-xs sm:text-sm">
                    <span>Review &amp; Submit</span>
                    <svg class="w-3.5 h-3.5 sm:w-4 sm:h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                </button>
                @elseif($testNumber)
                <a href="{{ route($satRoutePrefix . 'score-report', $testNumber) }}" 
                   x-show="currentIndex === {{ $totalCount - 1 }}"
                   x-cloak
                   :style="currentIndex === {{ $totalCount - 1 }} ? '' : 'display: none !important;'"
                   style="display: none; background-color: #0284c7 !important;"
                   class="sat-btn-submit py-1.5 px-3.5 sm:py-2 sm:px-6 text-xs sm:text-sm">
                    <span>Lihat Score Report</span>
                    <svg class="w-3.5 h-3.5 sm:w-4 sm:h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
                </a>
                @endif
            </div>
        </footer>

    </div>

    <!-- ======================================================== -->
    <!-- MODAL: DIRECTIONS -->
    <!-- ======================================================== -->
    <div x-show="showDirections" 
         class="fixed inset-0 bg-slate-900/60 backdrop-blur-xs flex items-center justify-center p-4 z-50"
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100">
        <div class="bg-white rounded-3xl max-w-lg w-full p-6 sm:p-8 shadow-2xl border-2 border-slate-200 space-y-4"
             @click.away="showDirections = false">
            <div class="flex items-center justify-between pb-3 border-b border-slate-200">
                <h3 class="font-extrabold text-lg text-slate-900">Digital SAT Directions</h3>
                <button type="button" @click="showDirections = false" class="p-1 rounded-lg text-slate-400 hover:text-slate-600 cursor-pointer">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>
            <div class="text-sm text-slate-700 leading-relaxed space-y-3 font-medium">
                @if($isMath)
                    <p>The questions in this section address key concepts in high school mathematics, including Algebra, Advanced Math, Problem-Solving and Data Analysis, and Geometry and Trigonometry.</p>
                    <p>You may use the built-in <strong>Desmos Graphing Calculator</strong> for all questions in this section, accessible via the Calculator button in the top menu.</p>
                    <p>Common geometric formulas and constants are provided in the <strong>Reference Sheet</strong> button in the top menu.</p>
                    <p>Unless indicated otherwise, all numbers used are real numbers, and drawings are intended to provide useful mathematical information to scale.</p>
                @else
                    <p>The questions in this section address a number of important reading and writing skills. Each question includes one or more passages, which may include a table or a graph.</p>
                    <p>Read each passage and question carefully, and then choose the best answer to the question based on the passage(s).</p>
                    <p>All questions in this section are multiple-choice with four options. There is only one correct answer per question and no penalty for guessing.</p>
                @endif
            </div>
            <div class="pt-3 border-t border-slate-200 text-right">
                <button type="button" @click="showDirections = false" class="px-5 py-2.5 rounded-xl bg-sky-600 text-white font-bold text-sm shadow-sm hover:bg-sky-700 transition cursor-pointer">
                    Tutup Petunjuk
                </button>
            </div>
        </div>
    </div>

    @if($isMath)
    <!-- ======================================================== -->
    <!-- MODAL: OFFICIAL SAT MATH REFERENCE SHEET -->
    <!-- ======================================================== -->
    <div x-show="showReference" 
         class="fixed inset-0 bg-slate-900/60 backdrop-blur-xs flex items-center justify-center p-4 z-50"
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         style="display: none;">
        <div class="bg-white rounded-3xl max-w-2xl w-full p-6 sm:p-8 shadow-2xl border-2 border-slate-200 space-y-4 max-h-[85vh] overflow-y-auto"
             @click.away="showReference = false">
            <div class="flex items-center justify-between pb-3 border-b border-slate-200">
                <div class="flex items-center gap-2">
                    <span class="p-1 rounded-md bg-emerald-600 text-white">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                    </span>
                    <h3 class="font-extrabold text-lg text-slate-900">Official SAT Math Reference Sheet</h3>
                </div>
                <button type="button" @click="showReference = false" class="p-1 rounded-lg text-slate-400 hover:text-slate-600 cursor-pointer">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>

            <!-- Formulas Grid matching Official SAT Reference Sheet -->
            <div class="space-y-4 text-xs text-slate-800">
                <div class="grid grid-cols-2 sm:grid-cols-4 gap-3 p-3 bg-slate-50 rounded-2xl border border-slate-200 text-center font-bold">
                    <div class="p-2 bg-white rounded-xl border border-slate-200 shadow-2xs">
                        <div class="text-slate-500 text-[10px]">Circle Area</div>
                        <div class="text-sm font-black text-slate-900 mt-1">\(A = \pi r^2\)</div>
                    </div>
                    <div class="p-2 bg-white rounded-xl border border-slate-200 shadow-2xs">
                        <div class="text-slate-500 text-[10px]">Circumference</div>
                        <div class="text-sm font-black text-slate-900 mt-1">\(C = 2\pi r\)</div>
                    </div>
                    <div class="p-2 bg-white rounded-xl border border-slate-200 shadow-2xs">
                        <div class="text-slate-500 text-[10px]">Rectangle Area</div>
                        <div class="text-sm font-black text-slate-900 mt-1">\(A = lw\)</div>
                    </div>
                    <div class="p-2 bg-white rounded-xl border border-slate-200 shadow-2xs">
                        <div class="text-slate-500 text-[10px]">Triangle Area</div>
                        <div class="text-sm font-black text-slate-900 mt-1">\(A = \frac{1}{2}bh\)</div>
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 p-3 bg-slate-50 rounded-2xl border border-slate-200">
                    <div class="p-3 bg-white rounded-xl border border-slate-200 space-y-1">
                        <div class="font-extrabold text-teal-800 text-xs">Pythagorean Theorem &amp; Special Right Triangles</div>
                        <div class="text-slate-700 font-medium">
                            &bull; \(a^2 + b^2 = c^2\)<br>
                            &bull; Special \(30^\circ\)-\(60^\circ\)-\(90^\circ\): sides in ratio \(x : x\sqrt{3} : 2x\)<br>
                            &bull; Special \(45^\circ\)-\(45^\circ\)-\(90^\circ\): sides in ratio \(s : s : s\sqrt{2}\)
                        </div>
                    </div>
                    <div class="p-3 bg-white rounded-xl border border-slate-200 space-y-1">
                        <div class="font-extrabold text-teal-800 text-xs">Solid Volumes</div>
                        <div class="text-slate-700 font-medium">
                            &bull; Rectangular Solid: \(V = lwh\)<br>
                            &bull; Right Cylinder: \(V = \pi r^2 h\)<br>
                            &bull; Sphere: \(V = \frac{4}{3}\pi r^3\)<br>
                            &bull; Cone: \(V = \frac{1}{3}\pi r^2 h\)<br>
                            &bull; Pyramid: \(V = \frac{1}{3}Bh\)
                        </div>
                    </div>
                </div>

                <div class="p-3 bg-slate-50 rounded-2xl border border-slate-200 space-y-1 text-slate-600">
                    <div>&bull; The number of degrees of arc in a circle is \(360^\circ\).</div>
                    <div>&bull; The number of radians of arc in a circle is \(2\pi\).</div>
                    <div>&bull; The sum of the measures in degrees of the angles of a triangle is \(180^\circ\).</div>
                </div>
            </div>

            <div class="pt-3 border-t border-slate-200 text-right">
                <button type="button" @click="showReference = false" class="px-5 py-2.5 rounded-xl bg-slate-800 text-white font-bold text-xs hover:bg-slate-900 transition cursor-pointer">
                    Tutup Reference Sheet
                </button>
            </div>
        </div>
    </div>

    <!-- ======================================================== -->
    <!-- FLOATING DESMOS GRAPHING CALCULATOR (OFFICIAL BLUEBOOK FEATURE) -->
    <!-- ======================================================== -->
    <div x-show="showCalculator" 
         class="fixed bg-white rounded-2xl shadow-2xl border-2 border-teal-600 overflow-hidden z-50 select-none flex flex-col transition-[width,height,top,left] duration-75"
         :class="isMaximizedCalc ? '!fixed !inset-4 !w-auto !h-auto !top-4 !left-4 !right-4 !bottom-4' : ''"
         :style="!isMaximizedCalc ? ('top: ' + calcY + 'px; left: ' + calcX + 'px; width: ' + calcW + 'px; height: ' + calcH + 'px;') : ''"
         x-transition:enter="transition ease-out duration-150"
         x-transition:enter-start="opacity-0 scale-95"
         x-transition:enter-end="opacity-100 scale-100"
         style="display: none;">
        
        <!-- Header Bar with Drag Handle, Maximize & Close Button -->
        <div style="background-color: #0f172a !important; color: #ffffff !important; border-bottom: 2px solid #0d9488 !important; padding: 10px 16px !important; display: flex !important; align-items: center !important; justify-content: space-between !important; cursor: move !important; user-select: none !important; flex-shrink: 0 !important;"
             @mousedown="startDragCalc($event)"
             @touchstart="startDragCalc($event)">
            <div style="display: flex !important; align-items: center !important; gap: 10px !important;">
                <div style="background-color: #1e293b !important; color: #2dd4bf !important; padding: 6px !important; border-radius: 8px !important; display: flex !important; align-items: center !important; justify-content: center !important; border: 1px solid #334155 !important;">
                    <svg style="width: 18px !important; height: 18px !important;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"/></svg>
                </div>
                <div style="display: flex !important; flex-direction: column !important;">
                    <span style="color: #ffffff !important; font-weight: 800 !important; font-size: 13px !important; letter-spacing: 0.05em !important; text-transform: uppercase !important; line-height: 1.2 !important;">Desmos Graphing Calculator</span>
                    <span style="color: #94a3b8 !important; font-size: 11px !important; font-weight: 600 !important; line-height: 1.2 !important;">Bisa digeser & diperbesar / di-resize</span>
                </div>
            </div>
            <div style="display: flex !important; align-items: center !important; gap: 6px !important;" @mousedown.stop @touchstart.stop>
                <!-- Maximize / Restore Button -->
                <button type="button" 
                        @click="toggleMaximizeCalc()" 
                        style="background-color: #1e293b !important; color: #ffffff !important; border: 1px solid #475569 !important; padding: 6px !important; border-radius: 8px !important; cursor: pointer !important; display: flex !important; align-items: center !important; justify-content: center !important;"
                        :title="isMaximizedCalc ? 'Perkecil Ukuran' : 'Perbesar Penuh (Maximize)'">
                    <template x-if="!isMaximizedCalc">
                        <svg style="width: 16px !important; height: 16px !important; color: #ffffff !important;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 8V4m0 0h4M4 4l5 5m11-1V4m0 0h-4m4 0l-5 5M4 16v4m0 0h4m-4 0l5-5m11 5l-5-5m5 5v-4m0 4h-4"/></svg>
                    </template>
                    <template x-if="isMaximizedCalc">
                        <svg style="width: 16px !important; height: 16px !important; color: #ffffff !important;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 9L4 4m0 5h5m11 0l-5-5m0 5h5M9 15l-5 5m5 0H4m11 0l5-5m-5 5h5"/></svg>
                    </template>
                </button>
                <!-- Close Button -->
                <button type="button" 
                        @click="showCalculator = false" 
                        style="background-color: #991b1b !important; color: #ffffff !important; border: 1px solid #dc2626 !important; padding: 6px !important; border-radius: 8px !important; cursor: pointer !important; display: flex !important; align-items: center !important; justify-content: center !important;"
                        title="Tutup Kalkulator">
                    <svg style="width: 16px !important; height: 16px !important; color: #ffffff !important;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>
        </div>

        <!-- Calculator Body (iframe with pointer-events disabled during drag/resize) -->
        <div class="w-full flex-1 bg-slate-50 relative overflow-hidden">
            <iframe src="https://www.desmos.com/calculator" 
                    class="w-full h-full border-none"
                    :class="(isDraggingCalc || isResizingCalc) ? 'pointer-events-none' : ''"></iframe>
        </div>

        <!-- Resize Handle (Bottom-Right Corner) -->
        <div x-show="!isMaximizedCalc"
             @mousedown="startResizeCalc($event)"
             @touchstart="startResizeCalc($event)"
             class="absolute bottom-0 right-0 w-6 h-6 cursor-se-resize flex items-end justify-end p-1 select-none z-10 group"
             title="Tarik sudut ini untuk mengubah ukuran kalkulator">
            <svg class="w-4 h-4 text-teal-500/70 group-hover:text-teal-700 transition" viewBox="0 0 24 24" fill="currentColor">
                <path d="M22 22h-2v-2h2v2zm0-4h-2v-2h2v2zm-4 4h-2v-2h2v2zm0-4h-2v-2h2v2zm-4 4h-2v-2h2v2zm8-8h-2v-2h2v2z"/>
            </svg>
        </div>
    </div>
    @endif

    <!-- ======================================================== -->
    <!-- FLOATING TOOLTIP UNTUK ANNOTATE (OFFICIAL BLUEBOOK FEATURE) -->
    <!-- ======================================================== -->
    <div id="annotationToolbar" class="annotation-toolbar" style="display: none;">
        <button type="button" id="btnHighlight" @click.stop.prevent="applyToolbarHighlight()" onclick="window.satApplyHighlight && window.satApplyHighlight(event)" title="Sorot Kuning (Highlight)">
            <span style="display:inline-block; width:12px; height:12px; background-color:#fde047; border: 1px solid #ca8a04; border-radius:2px; pointer-events: none;"></span>
            <span style="pointer-events: none;">Highlight</span>
        </button>
        <button type="button" id="btnUnderline" @click.stop.prevent="applyToolbarUnderline()" onclick="window.satApplyUnderline && window.satApplyUnderline(event)" title="Garis Bawah (Underline)">
            <span style="font-family: serif; font-weight: 900; border-bottom: 2px solid #0066cc; line-height: 1; padding-bottom: 1px; pointer-events: none;">A</span>
            <span style="pointer-events: none;">Underline</span>
        </button>
        <button type="button" id="btnCatatan" @click.stop.prevent="applyToolbarAnnotate()" onclick="window.satApplyAnnotate && window.satApplyAnnotate(event)" title="Buka Catatan (Annotate)">
            <svg style="width:14px; height:14px; color:#0066cc; pointer-events: none;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/></svg>
            <span style="color:#0066cc; font-weight: 700; pointer-events: none;">Annotate</span>
        </button>
        <button type="button" id="btnHapusHighlight" @click.stop.prevent="applyToolbarRemove()" onclick="window.satRemoveHighlight && window.satRemoveHighlight(event)" style="display: none; color: #ef4444;" title="Hapus Format">
            <svg style="width:14px; height:14px; pointer-events: none;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
        </button>
        <button type="button" id="btnCloseToolbar" @click.stop.prevent="closeToolbar()" onclick="window.satCloseToolbar && window.satCloseToolbar(event)" style="color: #64748b; padding: 4px 6px; border-radius: 6px; display: inline-flex; align-items: center; justify-content: center; margin-left: 2px;" title="Tutup Toolbar">
            <svg style="width:14px; height:14px; pointer-events: none;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/></svg>
        </button>
    </div>

    <!-- ======================================================== -->
    <!-- FLOATING ANNOTATE MODAL (OFFICIAL BLUEBOOK SIMPLE WHITE & BLUE) -->
    <!-- ======================================================== -->
    <div x-show="showScratchpad" 
         class="fixed bg-white rounded-2xl shadow-xl border border-slate-300 overflow-hidden z-50 select-none flex flex-col transition-[width,height,top,left] duration-75"
         :style="'top: ' + padY + 'px; left: ' + padX + 'px; width: ' + padW + 'px;'"
         x-transition:enter="transition ease-out duration-150"
         x-transition:enter-start="opacity-0 scale-95"
         x-transition:enter-end="opacity-100 scale-100"
         style="display: none;">
        
        <!-- Header Bar: Clean Centered Title & Drag Handle -->
        <div class="px-4 pt-3 pb-2 flex items-center justify-between border-b border-slate-100 cursor-move select-none"
             @mousedown="startDragPad($event)"
             @touchstart="startDragPad($event)">
            <span class="text-[11px] font-bold text-slate-400">#<span x-text="currentIndex + 1"></span></span>
            <h3 class="font-bold text-slate-800 text-sm tracking-wide">Annotate</h3>
            <button type="button" 
                    @click="showScratchpad = false" 
                    class="text-slate-400 hover:text-slate-600 p-0.5 rounded transition cursor-pointer"
                    title="Tutup">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>

        <!-- Note Body: White Textarea Box & Blue Save Button -->
        <div class="p-3.5 flex-1 flex flex-col bg-white">
            <div class="flex-1 flex flex-col bg-white rounded-xl border border-slate-300 focus-within:border-blue-600 focus-within:ring-1 focus-within:ring-blue-600 p-2.5 transition">
                <textarea id="satScratchpadTextarea"
                          x-model="questionNotes[currentIndex]"
                          @input="saveNotes()"
                          placeholder="Tulis catatan di sini..."
                          class="w-full flex-1 bg-transparent border-0 p-0 text-slate-800 text-sm font-sans focus:outline-none focus:ring-0 resize-none leading-relaxed"
                          style="min-height: 80px;"></textarea>
                <div class="flex items-center justify-between pt-2 border-t border-slate-100 mt-1">
                    <button type="button" 
                            @click="clearCurrentNote()"
                            x-show="hasAnnotation(currentIndex)"
                            class="text-[11px] text-rose-500 hover:text-rose-700 font-semibold hover:underline cursor-pointer">
                        Hapus
                    </button>
                    <span x-show="!hasAnnotation(currentIndex)"></span>
                    <button type="button" 
                            @click="saveNotes(); showScratchpad = false;"
                            class="px-4 py-1.5 bg-[#0066cc] hover:bg-[#0052a3] text-white text-xs font-bold rounded-lg transition shadow-xs cursor-pointer">
                        Save
                    </button>
                </div>
            </div>
        </div>

        <!-- Bottom Action Bar: Yellow Highlighter Box, 'A' Underline Box, Blue Close Button -->
        <div class="px-3.5 py-2.5 bg-slate-50 border-t border-slate-200 flex items-center justify-between">
            <div class="flex items-center gap-2">
                <!-- Highlighter Tool Icon (Yellow box with marker pen) -->
                <button type="button" 
                        @click="triggerHighlightFromPad()"
                        class="w-8 h-8 rounded-lg bg-amber-300 hover:bg-amber-400 flex items-center justify-center text-slate-900 shadow-2xs transition cursor-pointer"
                        title="Highlight teks yang dipilih">
                    <svg class="w-4 h-4" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M15.24 3.76a2.5 2.5 0 0 1 3.53 0l1.47 1.47a2.5 2.5 0 0 1 0 3.53L10.5 18.5H6v-4.5l9.24-10.24ZM5 20h14a1 1 0 1 1 0 2H5a1 1 0 1 1 0-2Z"/>
                    </svg>
                </button>
                <!-- Underline Tool Icon ('A' with underline) -->
                <button type="button" 
                        @click="triggerUnderlineFromPad()"
                        class="w-8 h-8 rounded-lg bg-white hover:bg-slate-100 border border-slate-300 flex items-center justify-center text-slate-900 font-serif font-black text-sm shadow-2xs transition cursor-pointer"
                        title="Underline teks yang dipilih">
                    <span class="border-b-2 border-slate-900 leading-none pb-0.5">A</span>
                </button>
            </div>
            <!-- Blue Close Button -->
            <button type="button" 
                    @click="showScratchpad = false" 
                    class="text-[#0066cc] hover:text-[#004d99] text-xs font-bold px-2 py-1 rounded hover:bg-blue-50 transition cursor-pointer">
                Close
            </button>
        </div>

        <!-- Resize Handle (Bottom-Right Corner) -->
        <div @mousedown="startResizePad($event)"
             @touchstart="startResizePad($event)"
             class="absolute bottom-0 right-0 w-4 h-4 cursor-se-resize flex items-end justify-end p-0.5 select-none z-10 opacity-30 hover:opacity-100"
             title="Ubah ukuran jendela">
            <svg class="w-2.5 h-2.5 text-slate-500" viewBox="0 0 24 24" fill="currentColor">
                <path d="M22 22H20V20H22V22ZM22 16H20V18H22V16ZM16 22H18V20H16V22ZM22 12H20V14H22V12ZM12 22H14V20H12V22ZM18 16H16V18H18V16Z"/>
            </svg>
        </div>
    </div>

    <!-- ======================================================== -->
    <!-- MODAL: REVIEW & SUBMIT CONFIRMATION -->
    <!-- ======================================================== -->
    <div x-show="showReviewModal" 
         class="fixed inset-0 bg-slate-900/60 backdrop-blur-xs flex items-center justify-center p-4 z-50"
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100">
        <div class="bg-white rounded-3xl max-w-lg w-full p-6 sm:p-8 shadow-2xl border-2 border-slate-200 space-y-5"
             @click.away="showReviewModal = false">
            <div class="flex items-center justify-between pb-3 border-b border-slate-200">
                <h3 class="font-extrabold text-xl text-slate-900">Konfirmasi Kirim Ujian</h3>
                <button type="button" @click="showReviewModal = false" class="p-1 rounded-lg text-slate-400 hover:text-slate-600 cursor-pointer">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>

            <!-- Stats -->
            <div class="grid grid-cols-3 gap-3 text-center">
                <div class="p-3 bg-sky-50 rounded-2xl border border-sky-200">
                    <div class="text-2xl font-black text-sky-700" x-text="answeredCount()">0</div>
                    <div class="text-xs font-bold text-sky-900 mt-0.5">Terjawab</div>
                </div>
                <div class="p-3 bg-rose-50 rounded-2xl border border-rose-200">
                    <div class="text-2xl font-black text-rose-700" x-text="unansweredList().length">0</div>
                    <div class="text-xs font-bold text-rose-900 mt-0.5">Kosong</div>
                </div>
                <div class="p-3 bg-amber-50 rounded-2xl border border-amber-200">
                    <div class="text-2xl font-black text-amber-700" x-text="markedCount()">0</div>
                    <div class="text-xs font-bold text-amber-900 mt-0.5">Marked</div>
                </div>
            </div>

            <!-- Bluebook Interactive Question Grid in Review Screen -->
            <div class="border border-slate-200 rounded-2xl p-3 bg-slate-50">
                <div class="flex items-center justify-between pb-2 mb-2 border-b border-slate-200">
                    <span class="text-xs font-black text-slate-700 uppercase tracking-wider">Ringkasan Soal (Klik nomor untuk cek)</span>
                    <span class="text-[11px] font-bold text-slate-500">
                        <span x-text="markedCount()">0</span> Ditandai (Marked)
                    </span>
                </div>
                <div style="display: grid; grid-template-columns: repeat(7, minmax(0, 1fr)); gap: 8px;" class="p-1">
                    @foreach($questions as $index => $q)
                    <button type="button" 
                            @click="goToQuestion({{ $index }}); showReviewModal = false;"
                            class="h-10 rounded-xl font-black text-xs relative flex items-center justify-center transition border-2 cursor-pointer"
                            :class="getNavButtonClass({{ $index }}, {{ $q->id }})"
                            title="Question {{ $index + 1 }}">
                        {{ $index + 1 }}
                        <!-- Flag icon if marked -->
                        <span x-show="isMarked({{ $index + 1 }})" class="absolute -top-1 -right-1 w-3.5 h-3.5 bg-amber-500 rounded-full border-2 border-white flex items-center justify-center text-[7px] text-white font-black">🚩</span>
                    </button>
                    @endforeach
                </div>
            </div>

            <!-- Specific list of unanswered questions or complete confirmation -->
            <div x-show="unansweredList().length > 0" class="p-3 bg-amber-50 rounded-xl border border-amber-300 text-xs text-amber-900 font-bold flex items-start gap-2.5">
                <svg class="w-4 h-4 text-amber-600 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                <div class="flex-1">
                    <div>Perhatian: Anda masih memiliki <span class="text-rose-700 font-black" x-text="unansweredList().length"></span> soal yang belum dijawab:</div>
                    <div class="mt-1.5 flex flex-wrap gap-1.5 items-center">
                        <span class="text-slate-600 font-medium">Nomor kosong:</span>
                        <template x-for="qNum in unansweredList()" :key="qNum">
                            <button type="button" @click="goToQuestion(qNum - 1); showReviewModal = false;" class="px-2 py-0.5 bg-rose-100 hover:bg-rose-200 text-rose-800 rounded-md font-black text-xs border border-rose-300 transition underline cursor-pointer" title="Klik untuk menuju ke soal">
                                Soal <span x-text="qNum"></span>
                            </button>
                        </template>
                    </div>
                </div>
            </div>

            <div x-show="unansweredList().length === 0" class="p-3 bg-emerald-50 rounded-xl border border-emerald-300 text-xs text-emerald-900 font-bold flex items-center gap-2">
                <svg class="w-4 h-4 text-emerald-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                <span>Semua {{ $totalCount }} butir soal telah dijawab lengkap! Siap untuk dikirim.</span>
            </div>

            <p class="text-sm text-slate-700 font-medium">
                Apakah Anda yakin ingin menyelesaikan dan mengirim jawaban simulasi Digital SAT ini? Skor dan pembahasan akan langsung ditampilkan setelah submit.
            </p>

            <div class="pt-3 border-t border-slate-200 flex items-center justify-end gap-3">
                <button type="button" @click="showReviewModal = false" class="px-5 py-2.5 rounded-xl border-2 border-slate-300 text-slate-700 font-bold text-sm hover:bg-slate-100 transition cursor-pointer">
                    Kembali Periksa
                </button>
                <button type="button" 
                        @click="submitTest()" 
                        :disabled="isSubmitting"
                        class="px-6 py-2.5 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-sm shadow-md transition cursor-pointer disabled:opacity-60 disabled:cursor-not-allowed inline-flex items-center gap-2">
                    <svg x-show="isSubmitting" class="animate-spin -ml-1 mr-1 h-4 w-4 text-white" fill="none" viewBox="0 0 24 24" style="display: none;">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z"></path>
                    </svg>
                    <span x-text="isSubmitting ? 'Mengirim Jawaban...' : 'Ya, Submit Jawaban'">Ya, Submit Jawaban</span>
                </button>
            </div>
        </div>
    </div>

    <!-- ======================================================== -->
    <!-- MODAL: OFFICIAL BLUEBOOK 'MORE' (3-DOTS) MENU & SETTINGS -->
    <!-- ======================================================== -->
    <div x-show="showMoreInfo" 
         class="fixed inset-0 bg-slate-900/60 backdrop-blur-xs flex items-center justify-center p-4 z-50 select-none"
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0 scale-95"
         x-transition:enter-end="opacity-100 scale-100"
         style="display: none;">
        <div class="bg-white rounded-3xl max-w-xl w-full p-6 sm:p-8 shadow-2xl border-2 border-slate-200 space-y-5 max-h-[90vh] overflow-y-auto"
             @click.away="showMoreInfo = false">
            <div class="flex items-center justify-between pb-3 border-b border-slate-200">
                <div class="flex items-center gap-2.5">
                    <div class="w-8 h-8 rounded-xl bg-slate-900 text-white flex items-center justify-center font-black">
                        <svg class="w-4 h-4" viewBox="0 0 24 24" fill="currentColor"><circle cx="12" cy="5" r="2"/><circle cx="12" cy="12" r="2"/><circle cx="12" cy="19" r="2"/></svg>
                    </div>
                    <div>
                        <h3 class="font-extrabold text-lg text-slate-900 leading-tight">Pengaturan &amp; Opsi Ujian (More)</h3>
                        <p class="text-xs text-slate-500 font-medium">Fitur resmi Bluebook College Board Digital SAT</p>
                    </div>
                </div>
                <button type="button" @click="showMoreInfo = false" class="p-1 rounded-lg text-slate-400 hover:text-slate-600 cursor-pointer">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>

            <!-- Content Options & Features -->
            <div class="space-y-3.5 text-sm">
                <!-- 1. Help (Bantuan) -->
                <div class="p-4 rounded-2xl bg-sky-50 border border-sky-200/80 space-y-1.5 transition hover:shadow-xs">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-2 text-sky-950 font-extrabold text-sm">
                            <span class="p-1 rounded-lg bg-sky-200 text-sky-800">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            </span>
                            <span>Help (Bantuan)</span>
                        </div>
                        <span class="text-[10px] font-black uppercase tracking-wider text-sky-700 bg-sky-100 px-2 py-0.5 rounded-md">Petunjuk</span>
                    </div>
                    <p class="text-xs text-slate-700 leading-relaxed font-medium">
                        Berisi panduan mengenai cara menggunakan aplikasi tes dan penjelasan fitur-fitur yang tersedia (seperti <em>Directions</em> untuk aturan ujian, <em>Reference Sheet</em> untuk rumus matematika, <em>Desmos Calculator</em> untuk grafik/hitungan, dan <em>Mark for Review</em>).
                    </p>
                </div>

                <!-- 2. Keyboard Shortcuts (Pintasan Keyboard) -->
                <div class="p-4 rounded-2xl bg-indigo-50 border border-indigo-200/80 space-y-2 transition hover:shadow-xs">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-2 text-indigo-950 font-extrabold text-sm">
                            <span class="p-1 rounded-lg bg-indigo-200 text-indigo-800">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"/></svg>
                            </span>
                            <span>Keyboard Shortcuts (Pintasan Keyboard)</span>
                        </div>
                        <span class="text-[10px] font-black uppercase tracking-wider text-indigo-700 bg-indigo-100 px-2 py-0.5 rounded-md">Navigasi</span>
                    </div>
                    <p class="text-xs text-slate-700 leading-relaxed font-medium">
                        Daftar tombol cepat yang bisa digunakan untuk navigasi atau mengaktifkan alat bantu ujian secara instan:
                    </p>
                    <div class="grid grid-cols-2 gap-2 pt-1 text-[11px] font-medium text-slate-700">
                        <div class="flex items-center gap-1.5"><kbd class="px-1.5 py-0.5 bg-white border border-slate-300 rounded shadow-2xs font-mono font-bold text-slate-800">Alt</kbd> + <kbd class="px-1.5 py-0.5 bg-white border border-slate-300 rounded shadow-2xs font-mono font-bold text-slate-800">N</kbd> : Next Soal</div>
                        <div class="flex items-center gap-1.5"><kbd class="px-1.5 py-0.5 bg-white border border-slate-300 rounded shadow-2xs font-mono font-bold text-slate-800">Alt</kbd> + <kbd class="px-1.5 py-0.5 bg-white border border-slate-300 rounded shadow-2xs font-mono font-bold text-slate-800">B</kbd> : Back Soal</div>
                        <div class="flex items-center gap-1.5"><kbd class="px-1.5 py-0.5 bg-white border border-slate-300 rounded shadow-2xs font-mono font-bold text-slate-800">Alt</kbd> + <kbd class="px-1.5 py-0.5 bg-white border border-slate-300 rounded shadow-2xs font-mono font-bold text-slate-800">M</kbd> : Mark Review</div>
                        <div class="flex items-center gap-1.5"><kbd class="px-1.5 py-0.5 bg-white border border-slate-300 rounded shadow-2xs font-mono font-bold text-slate-800">Alt</kbd> + <kbd class="px-1.5 py-0.5 bg-white border border-slate-300 rounded shadow-2xs font-mono font-bold text-slate-800">C</kbd> : Desmos Calc</div>
                    </div>
                </div>

                <!-- 3. Test Details / Information -->
                <div class="p-4 rounded-2xl bg-emerald-50 border border-emerald-200/80 space-y-1.5 transition hover:shadow-xs">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-2 text-emerald-950 font-extrabold text-sm">
                            <span class="p-1 rounded-lg bg-emerald-200 text-emerald-800">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            </span>
                            <span>Test Details / Information</span>
                        </div>
                        <span class="text-[10px] font-black uppercase tracking-wider text-emerald-700 bg-emerald-100 px-2 py-0.5 rounded-md">Status</span>
                    </div>
                    <p class="text-xs text-slate-700 leading-relaxed font-medium">
                        Informasi seputar status tes yang sedang dikerjakan: <strong>{{ $secTitle }} (Modul {{ $practiceNumber }})</strong>, berdurasi {{ $durationMin }} menit dengan {{ $totalCount }} butir soal, algoritma Multistage Adaptive, dan tanpa pengurangan poin bila menebak (*no negative marking*).
                    </p>
                </div>

                <!-- 4. Opsi Keluar Sesi / Unscheduled Break -->
                <div class="p-4 rounded-2xl bg-amber-50 border border-amber-200/80 space-y-2.5 transition hover:shadow-xs">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-2 text-amber-950 font-extrabold text-sm">
                            <span class="p-1 rounded-lg bg-amber-200 text-amber-800">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            </span>
                            <span>Unscheduled Break (Jeda Istirahat Darurat)</span>
                        </div>
                        <span class="text-[10px] font-black uppercase tracking-wider text-amber-800 bg-amber-100 px-2 py-0.5 rounded-md">Darurat</span>
                    </div>
                    <p class="text-xs text-slate-700 leading-relaxed font-medium">
                        Digunakan jika siswa perlu meninggalkan layar (seperti ke toilet) di tengah ujian. Sesuai aturan resmi College Board Bluebook, <strong>timer ujian akan tetap berjalan</strong> selama jeda istirahat darurat ini.
                    </p>
                    <div class="pt-1">
                        <button type="button" 
                                @click="showMoreInfo = false; alert('Mode Unscheduled Break aktif. Silakan kembali mengerjakan soal segera karena timer ujian tetap berjalan.')"
                                class="px-3.5 py-1.5 rounded-xl text-xs font-bold bg-amber-200/80 hover:bg-amber-300 text-amber-950 border border-amber-300 transition cursor-pointer">
                            Ambil Jeda Istirahat (Layar Tetap Aktif)
                        </button>
                    </div>
                </div>
            </div>

            <div class="pt-3 border-t border-slate-200 flex items-center justify-between">
                <a href="{{ route(rtrim($satRoutePrefix, '.')) }}" 
                   @if(!$existingScore) onclick="return confirm('Apakah Anda yakin ingin membatalkan dan keluar dari ujian? Jawaban yang belum disubmit akan hilang.')" @endif
                   class="inline-flex items-center gap-1.5 px-3.5 py-2 rounded-xl text-xs font-bold text-rose-700 bg-rose-50 hover:bg-rose-100 border border-rose-200 transition">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                    <span>Akhiri Tes &amp; Keluar Total</span>
                </a>
                <button type="button" @click="showMoreInfo = false" class="px-5 py-2.5 rounded-xl bg-slate-900 text-white font-bold text-xs hover:bg-slate-800 transition cursor-pointer">
                    Tutup Menu
                </button>
            </div>
        </div>
    </div>

    <!-- ======================================================== -->
    <!-- MODAL: 5-MINUTE TIME REMAINING WARNING (OFFICIAL BLUEBOOK FEATURE) -->
    <!-- ======================================================== -->
    <div x-show="showFiveMinWarning" 
         class="fixed inset-0 bg-slate-900/60 backdrop-blur-xs flex items-center justify-center p-4 z-50"
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0 scale-95"
         x-transition:enter-end="opacity-100 scale-100"
         style="display: none;">
        <div class="bg-white rounded-3xl max-w-md w-full p-6 sm:p-7 shadow-2xl border-2 border-rose-300 text-center space-y-4"
             @click.away="showFiveMinWarning = false">
            <div class="w-14 h-14 bg-rose-100 rounded-full flex items-center justify-center mx-auto text-rose-600">
                <svg class="w-8 h-8 animate-pulse" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </div>
            <div>
                <h3 class="text-lg font-black text-slate-900">Waktu Tersisa 5 Menit!</h3>
                <p class="text-sm text-slate-600 font-medium mt-1">
                    Anda memiliki waktu <strong>5 menit lagi</strong> sebelum modul ini otomatis ditutup dan disubmit. Gunakan waktu yang tersisa untuk memeriksa jawaban atau soal yang ditandai (Marked).
                </p>
            </div>
            <div class="pt-2">
                <button type="button" @click="showFiveMinWarning = false" class="w-full py-2.5 px-4 rounded-xl bg-rose-600 hover:bg-rose-700 text-white font-bold text-sm shadow-md transition cursor-pointer">
                    Saya Mengerti, Lanjutkan Tes
                </button>
            </div>
        </div>
    </div>

    @if($isAdmin)
    <!-- ======================================================== -->
    <!-- FLOATING ADMIN DEV TOOLS CONTAINER (OFFICIAL CBT ADMIN PANEL) -->
    <!-- ======================================================== -->
    <div class="sat-admin-widget select-none"
         style="position: fixed !important; bottom: 85px !important; right: 24px !important; z-index: 99999 !important;">
        <!-- 1. Floating Launcher Pill (Closed State, Hidden when in Student Preview) -->
        <div x-show="!openAdminDrawer && !studentPreview"
             x-transition:enter="transition ease-out duration-200"
             x-transition:enter-start="opacity-0 translate-y-2 scale-95"
             x-transition:enter-end="opacity-100 translate-y-0 scale-100">
            <button type="button" 
                    @click="openAdminDrawer = true"
                    style="background-color: #0f172a !important; color: #ffffff !important; border: 2px solid #a855f7 !important; display: inline-flex !important; align-items: center !important; gap: 8px !important; padding: 10px 18px !important; border-radius: 9999px !important; cursor: pointer !important; box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.4), 0 0 0 2px rgba(168, 85, 247, 0.3) !important;"
                    title="Buka Admin Dev Tools">
                <span class="inline-block" style="width: 8px !important; height: 8px !important; border-radius: 50% !important;" :style="devMode ? 'background-color: #fbbf24 !important;' : 'background-color: #34d399 !important;'"></span>
                <span style="color: #ffffff !important; font-size: 13px !important; font-weight: 800 !important; letter-spacing: 0.02em !important;">Admin Dev Tools</span>
                <span style="font-size: 14px !important; line-height: 1 !important;">⚙️</span>
            </button>
        </div>

        <!-- 2. Minimal Return Badge for Student Preview Mode -->
        <div x-show="studentPreview"
             style="display: none;">
            <button type="button"
                    @click="studentPreview = false; openAdminDrawer = true"
                    class="flex items-center gap-2 px-3.5 py-2 rounded-full bg-purple-700 hover:bg-purple-800 text-white shadow-2xl text-xs font-black cursor-pointer transition border-2 border-purple-300 ring-4 ring-purple-500/20 animate-pulse"
                    title="Klik untuk keluar dari simulasi Tampilan Siswa">
                <svg class="w-4 h-4 text-purple-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                <span>Keluar Mode Siswa</span>
            </button>
        </div>

        <!-- 3. Expanded Floating Panel / Container -->
        <div x-show="openAdminDrawer && !studentPreview"
             @click.away="openAdminDrawer = false"
             x-transition:enter="transition ease-out duration-200"
             x-transition:enter-start="opacity-0 translate-y-4 scale-95"
             x-transition:enter-end="opacity-100 translate-y-0 scale-100"
             class="w-[330px] sm:w-[370px] max-h-[82vh] flex flex-col bg-white rounded-3xl shadow-2xl border-2 border-purple-300 overflow-hidden text-slate-800"
             style="display: none;">
            
            <!-- Floating Container Header -->
            <div class="bg-gradient-to-r from-slate-900 via-purple-950 to-slate-900 text-white px-4 py-3 flex items-center justify-between shrink-0 border-b border-purple-800/50">
                <div class="flex items-center gap-2">
                    <span class="p-1 rounded-lg bg-purple-600/40 text-purple-200">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                    </span>
                    <div>
                        <div class="font-black text-xs uppercase tracking-wider text-purple-200 flex items-center gap-1.5">
                            <span>Admin Dev Tools</span>
                            <span class="px-1.5 py-0.2 rounded bg-purple-500/40 text-purple-300 text-[9px] font-bold">CBT</span>
                        </div>
                        <div class="text-[10px] text-slate-300 font-medium">Pengontrol Ujian &amp; Simulator Adaptif</div>
                    </div>
                </div>
                
                <!-- Close Button -->
                <button type="button" 
                        @click="openAdminDrawer = false" 
                        class="p-1 rounded-lg hover:bg-white/10 text-slate-300 hover:text-white transition cursor-pointer"
                        title="Tutup Panel">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>

            <!-- Scrollable Content Body -->
            <div class="p-4 overflow-y-auto space-y-3.5 text-xs">
                
                @if(session()->has('view_as_role'))
                <!-- Impersonation Notice -->
                <div class="p-3 bg-amber-100 rounded-2xl border border-amber-300 text-amber-950 flex items-center justify-between">
                    <div>
                        <div class="font-extrabold text-xs">Mode Impersonate Aktif</div>
                        <div class="text-[10px] text-amber-800">Melihat sebagai: <strong>{{ session('view_as_role') }}</strong></div>
                    </div>
                    <a href="{{ route('admin.impersonate.stop') }}" class="px-2.5 py-1.5 bg-amber-700 hover:bg-amber-800 text-white rounded-xl text-xs font-black shadow-xs transition">
                        Stop Impersonate
                    </a>
                </div>
                @endif

                <!-- 1. Dev Mode Timer Control -->
                <div class="p-3 bg-amber-50/90 rounded-2xl border border-amber-200 space-y-2">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-2">
                            <span class="w-2.5 h-2.5 rounded-full" :class="devMode ? 'bg-amber-500 animate-pulse' : 'bg-slate-400'"></span>
                            <span class="text-xs font-bold text-amber-950">Dev Mode (Pause Waktu)</span>
                        </div>
                        <button type="button" 
                                @click="toggleDevMode()" 
                                class="px-2.5 py-1 rounded-lg text-xs font-black transition cursor-pointer border shadow-2xs" 
                                :class="devMode ? 'bg-amber-600 text-white border-amber-700' : 'bg-white text-slate-700 border-slate-300 hover:bg-slate-50'">
                            <span x-text="devMode ? 'PAUSED (ON)' : 'BERJALAN'"></span>
                        </button>
                    </div>
                    <div class="flex items-center justify-between pt-1 border-t border-amber-200/70 text-[11px]">
                        <span class="text-amber-800 font-medium">Timer Sekarang: <strong class="font-bold font-mono" x-text="formatTime(timerSeconds)"></strong></span>
                        <button type="button" 
                                @click="resetTimer()" 
                                class="px-2 py-0.5 rounded-md bg-white border border-amber-300 font-bold hover:bg-amber-100 text-amber-900 cursor-pointer shadow-2xs" 
                                title="Reset waktu modul ke awal">
                            Reset Timer
                        </button>
                    </div>
                </div>

                <!-- 2. Intip Kunci Jawaban (Peek Key) -->
                <div class="p-3 bg-slate-50 rounded-2xl border border-slate-200 flex items-center justify-between">
                    <div class="flex flex-col">
                        <span class="text-xs font-bold text-slate-800">Intip Kunci Jawaban</span>
                        <span class="text-[10px] text-slate-500">Highlight jawaban &amp; pembahasan</span>
                    </div>
                    <button type="button" 
                            @click="adminPeekKey = !adminPeekKey" 
                            class="px-3 py-1 rounded-lg text-xs font-black transition cursor-pointer border shadow-2xs" 
                            :class="adminPeekKey ? 'bg-emerald-600 text-white border-emerald-700' : 'bg-white text-slate-700 border-slate-300 hover:bg-slate-50'">
                        <span x-text="adminPeekKey ? 'AKTIF' : 'NONAKTIF'"></span>
                    </button>
                </div>

                @if($existingScore)
                <!-- 3. Mode Status Review & Reset -->
                <div class="p-3 bg-teal-50 rounded-2xl border border-teal-200 flex items-center justify-between">
                    <div class="flex flex-col">
                        <span class="text-xs font-bold text-teal-950">Status: Review Mode</span>
                        <span class="text-[10px] text-teal-700">Skor: {{ round($existingScore->score) }}% ({{ $existingScore->correct_count }}/{{ $existingScore->total_questions }})</span>
                    </div>
                    <a href="{{ $resetRoute }}" 
                       onclick="return confirm('Reset ujian ini dan kembali ke Mode Pengerjaan (Test Mode)?')" 
                       class="px-2.5 py-1.5 rounded-lg text-[11px] font-black bg-teal-600 hover:bg-teal-700 text-white shadow-xs transition">
                        Reset ke Test
                    </a>
                </div>
                @endif

                @if($practiceNumber == 2)
                <!-- 4A. Instant Adaptive Stage Switcher (Khusus Modul 2) -->
                @php
                    $activeCurrentStage = session($isMath ? 'sat_math_stage' : 'sat_rw_stage', 'Hard');
                    $moduleCurrentRoute = $isMath ? 'assignments.sat.math.practice-test' : 'assignments.sat.practice-test';
                @endphp
                <div class="p-3.5 bg-slate-100 rounded-2xl border-2 border-slate-300 space-y-2.5">
                    <div class="flex items-center justify-between">
                        <span class="text-[11px] font-black text-slate-900 uppercase tracking-wider">Saklar Jalur Modul 2:</span>
                        <span class="px-2.5 py-0.5 rounded-full text-[10px] font-black tracking-wide"
                              style="{{ $activeCurrentStage === 'Hard' ? 'background-color: #6b21a8; color: #ffffff;' : 'background-color: #d97706; color: #ffffff;' }}">
                            Aktif: {{ $activeCurrentStage }}
                        </span>
                    </div>
                    <div class="grid grid-cols-2 gap-2">
                        <!-- Tombol Jalur Hard -->
                        <a href="{{ route($moduleCurrentRoute, ['number' => 2, 'stage' => 'Hard']) }}" 
                           class="py-2.5 px-2 rounded-xl text-center font-extrabold text-xs transition block shadow-sm"
                           style="{{ $activeCurrentStage === 'Hard' 
                               ? 'background-color: #581c87 !important; color: #ffffff !important; border: 2px solid #3b0764 !important; box-shadow: 0 0 0 2px #c084fc !important;' 
                               : 'background-color: #ffffff !important; color: #581c87 !important; border: 2px solid #d8b4fe !important;' }}">
                            <span style="font-size: 13px;">🟣</span> <span style="font-weight: 800 !important;">Jalur Hard</span>
                        </a>

                        <!-- Tombol Jalur Easy -->
                        <a href="{{ route($moduleCurrentRoute, ['number' => 2, 'stage' => 'Easy']) }}" 
                           class="py-2.5 px-2 rounded-xl text-center font-extrabold text-xs transition block shadow-sm"
                           style="{{ $activeCurrentStage === 'Easy' 
                               ? 'background-color: #b45309 !important; color: #ffffff !important; border: 2px solid #78350f !important; box-shadow: 0 0 0 2px #fcd34d !important;' 
                               : 'background-color: #ffffff !important; color: #b45309 !important; border: 2px solid #fde68a !important;' }}">
                            <span style="font-size: 13px;">🟡</span> <span style="font-weight: 800 !important;">Jalur Easy</span>
                        </a>
                    </div>
                    <div class="text-[11px] text-slate-700 leading-tight">
                        *Klik untuk langsung beralih ke soal <strong>{{ $activeCurrentStage === 'Hard' ? 'Tingkat Sulit (Hard)' : 'Tingkat Mudah (Easy)' }}</strong>.
                    </div>
                </div>
                @endif

                <!-- 4. Simulasi Multistage Adaptive -->
                <div class="space-y-1.5">
                    <span class="text-[10px] font-black text-slate-500 uppercase tracking-wider block">Simulasi Jawaban Modul 1:</span>
                    <div class="grid grid-cols-2 gap-2">
                        <button type="button" 
                                @click="simulateScore('high')" 
                                class="p-2.5 rounded-xl bg-emerald-50 hover:bg-emerald-100 border border-emerald-300 text-emerald-900 text-left cursor-pointer transition shadow-2xs">
                            <div class="text-[11px] font-black">Skor Tinggi (90%)</div>
                            <div class="text-[10px] text-emerald-700 leading-tight">Uji Modul 2 Jalur Hard</div>
                        </button>
                        <button type="button" 
                                @click="simulateScore('low')" 
                                class="p-2.5 rounded-xl bg-amber-50 hover:bg-amber-100 border border-amber-300 text-amber-900 text-left cursor-pointer transition shadow-2xs">
                            <div class="text-[11px] font-black">Skor Rendah (35%)</div>
                            <div class="text-[10px] text-amber-700 leading-tight">Uji Modul 2 Jalur Easy</div>
                        </button>
                    </div>
                </div>

                <!-- 5. Lompat Langsung ke Tahapan Ujian -->
                <div class="space-y-1.5">
                    <span class="text-[10px] font-black text-slate-500 uppercase tracking-wider block">Lompat Langsung ke Modul:</span>
                    <div class="grid grid-cols-1 gap-1 text-xs font-semibold">
                        <a href="{{ route($satRoutePrefix . 'practice-test', 1) }}" 
                           class="flex items-center justify-between p-2 rounded-xl hover:bg-slate-100 transition border border-transparent hover:border-slate-200 {{ (!$isMath && $practiceNumber == 1) ? 'bg-blue-50 text-blue-700 font-black' : 'text-slate-700' }}">
                            <span>1. Reading &amp; Writing (Modul 1)</span>
                            <span class="text-[10px] px-1.5 py-0.5 rounded bg-blue-100 text-blue-800">27 Soal</span>
                        </a>

                        <a href="{{ route($satRoutePrefix . 'practice-test', 2) }}" 
                           class="flex items-center justify-between p-2 rounded-xl hover:bg-slate-100 transition border border-transparent hover:border-slate-200 {{ (!$isMath && $practiceNumber == 2) ? 'bg-purple-50 text-purple-700 font-black' : 'text-slate-700' }}">
                            <span>2. Reading &amp; Writing (Modul 2)</span>
                            <span class="text-[10px] px-1.5 py-0.5 rounded bg-purple-100 text-purple-800">Adaptif</span>
                        </a>

                        @if($testNumber)
                        <a href="{{ route($satRoutePrefix . 'break', $testNumber) }}" 
                           class="flex items-center justify-between p-2 rounded-xl hover:bg-slate-100 transition border border-transparent hover:border-slate-200 text-slate-700">
                            <span>⏸️ 10-Minute Break Screen</span>
                            <span class="text-[10px] px-1.5 py-0.5 rounded bg-amber-100 text-amber-800">Jeda</span>
                        </a>
                        @endif

                        <a href="{{ route($satRoutePrefix . 'math.practice-test', 1) }}" 
                           class="flex items-center justify-between p-2 rounded-xl hover:bg-slate-100 transition border border-transparent hover:border-slate-200 {{ ($isMath && $practiceNumber == 1) ? 'bg-teal-50 text-teal-700 font-black' : 'text-slate-700' }}">
                            <span>3. Math (Modul 1)</span>
                            <span class="text-[10px] px-1.5 py-0.5 rounded bg-teal-100 text-teal-800">22 Soal</span>
                        </a>

                        <a href="{{ route($satRoutePrefix . 'math.practice-test', 2) }}" 
                           class="flex items-center justify-between p-2 rounded-xl hover:bg-slate-100 transition border border-transparent hover:border-slate-200 {{ ($isMath && $practiceNumber == 2) ? 'bg-emerald-50 text-emerald-700 font-black' : 'text-slate-700' }}">
                            <span>4. Math (Modul 2)</span>
                            <span class="text-[10px] px-1.5 py-0.5 rounded bg-emerald-100 text-emerald-800">Adaptif</span>
                        </a>

                        @if($testNumber)
                        <a href="{{ route($satRoutePrefix . 'score-report', $testNumber) }}" 
                           class="flex items-center justify-between p-2 rounded-xl hover:bg-slate-100 transition border border-transparent hover:border-slate-200 text-slate-700">
                            <span>📊 Final Score Report (400-1600)</span>
                            <span class="text-[10px] px-1.5 py-0.5 rounded bg-indigo-100 text-indigo-800">Laporan</span>
                        </a>
                        @endif
                    </div>
                </div>

                <!-- 6. Student View & Impersonate -->
                <div class="pt-2 border-t border-slate-200 grid grid-cols-2 gap-2">
                    <button type="button" 
                            @click="studentPreview = true; openAdminDrawer = false" 
                            class="py-2 px-2.5 rounded-xl bg-purple-50 hover:bg-purple-100 border border-purple-200 text-purple-900 text-xs font-bold text-center cursor-pointer transition flex items-center justify-center gap-1.5 shadow-2xs">
                        <svg class="w-3.5 h-3.5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                        <span>Tampilan Siswa</span>
                    </button>
                    <a href="{{ route('admin.impersonate', 'student') }}" 
                       class="py-2 px-2.5 rounded-xl bg-emerald-50 hover:bg-emerald-100 border border-emerald-200 text-emerald-900 text-xs font-bold text-center transition flex items-center justify-center gap-1.5 shadow-2xs" 
                       title="Masuk mode siswa di seluruh website">
                        <svg class="w-3.5 h-3.5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                        <span>Login Siswa</span>
                    </a>
                </div>

            </div>
        </div>
    </div>
    @endif

    <!-- ======================================================== -->
    <!-- ALPINE LOGIC -->
    <!-- ======================================================== -->
    <script>
        function satCbtMockup() {
            return {
                currentIndex: 0,
                totalCount: {{ $totalCount }},
                questionIds: @json($questions->pluck('id')->values()),
                userAnswers: @json($existingScore ? ($existingScore->answers ?? []) : []),
                markedQuestions: {},
                showNavigator: false,
                showDirections: false,
                showReviewModal: false,
                showReference: false,
                showCalculator: false,
                showMoreInfo: false,
                isSubmitting: false,
                offlineSubmitPending: false,
                isAdmin: {{ $isAdmin ? 'true' : 'false' }},
                devMode: false,
                adminPeekKey: false,
                studentPreview: false,
                openAdminDrawer: false,
                showScratchpad: false,
                activeHighlightSpan: null,
                lastSelectedRange: null,
                questionNotes: {},
                aiExplanations: {},
                aiLoading: {},
                aiSources: {},
                selectionPopover: {
                    visible: false,
                    x: 0,
                    y: 0,
                    text: '',
                    range: null
                },
                padX: Math.max(10, window.innerWidth - 370),
                padY: 75,
                padW: Math.min(340, window.innerWidth - 30),
                padH: 220,
                isDraggingPad: false,
                isResizingPad: false,
                padDragStartX: 0,
                padDragStartY: 0,
                padInitialX: 0,
                padInitialY: 0,
                padResizeStartX: 0,
                padResizeStartY: 0,
                padInitialW: 0,
                padInitialH: 0,
                calcX: 20,
                calcY: 70,
                calcW: Math.min(680, window.innerWidth - 40),
                calcH: Math.min(540, window.innerHeight - 100),
                isDraggingCalc: false,
                isResizingCalc: false,
                isMaximizedCalc: false,
                calcDragStartX: 0,
                calcDragStartY: 0,
                calcInitialX: 0,
                calcInitialY: 0,
                calcResizeStartX: 0,
                calcResizeStartY: 0,
                calcInitialW: 0,
                calcInitialH: 0,

                toggleMaximizeCalc() {
                    this.isMaximizedCalc = !this.isMaximizedCalc;
                },

                startResizeCalc(e) {
                    if (this.isMaximizedCalc) return;
                    this.isResizingCalc = true;
                    const clientX = e.type.includes('touch') ? e.touches[0].clientX : e.clientX;
                    const clientY = e.type.includes('touch') ? e.touches[0].clientY : e.clientY;
                    this.calcResizeStartX = clientX;
                    this.calcResizeStartY = clientY;
                    this.calcInitialW = this.calcW;
                    this.calcInitialH = this.calcH;

                    const onResizeMove = (moveEvent) => {
                        if (!this.isResizingCalc) return;
                        const curX = moveEvent.type.includes('touch') ? moveEvent.touches[0].clientX : moveEvent.clientX;
                        const curY = moveEvent.type.includes('touch') ? moveEvent.touches[0].clientY : moveEvent.clientY;
                        const deltaW = curX - this.calcResizeStartX;
                        const deltaH = curY - this.calcResizeStartY;

                        let nextW = this.calcInitialW + deltaW;
                        let nextH = this.calcInitialH + deltaH;

                        // Bounds
                        const minW = 400;
                        const maxW = window.innerWidth - this.calcX - 10;
                        const minH = 320;
                        const maxH = window.innerHeight - this.calcY - 10;

                        if (nextW < minW) nextW = minW;
                        if (nextW > maxW) nextW = maxW;
                        if (nextH < minH) nextH = minH;
                        if (nextH > maxH) nextH = maxH;

                        this.calcW = nextW;
                        this.calcH = nextH;
                    };

                    const onResizeUp = () => {
                        this.isResizingCalc = false;
                        window.removeEventListener('mousemove', onResizeMove);
                        window.removeEventListener('mouseup', onResizeUp);
                        window.removeEventListener('touchmove', onResizeMove);
                        window.removeEventListener('touchend', onResizeUp);
                    };

                    window.addEventListener('mousemove', onResizeMove);
                    window.addEventListener('mouseup', onResizeUp);
                    window.addEventListener('touchmove', onResizeMove);
                    window.addEventListener('touchend', onResizeUp);
                },

                startDragCalc(e) {
                    if (this.isMaximizedCalc) return;
                    this.isDraggingCalc = true;
                    const clientX = e.type.includes('touch') ? e.touches[0].clientX : e.clientX;
                    const clientY = e.type.includes('touch') ? e.touches[0].clientY : e.clientY;
                    this.calcDragStartX = clientX;
                    this.calcDragStartY = clientY;
                    this.calcInitialX = this.calcX;
                    this.calcInitialY = this.calcY;

                    const onMove = (moveEvent) => {
                        if (!this.isDraggingCalc) return;
                        const curX = moveEvent.type.includes('touch') ? moveEvent.touches[0].clientX : moveEvent.clientX;
                        const curY = moveEvent.type.includes('touch') ? moveEvent.touches[0].clientY : moveEvent.clientY;
                        const deltaX = curX - this.calcDragStartX;
                        const deltaY = curY - this.calcDragStartY;

                        // Calculate new position bounded to screen
                        let nextX = this.calcInitialX + deltaX;
                        let nextY = this.calcInitialY + deltaY;
                        
                        const maxW = window.innerWidth - Math.min(this.calcW, 200);
                        const maxH = window.innerHeight - 80;
                        if (nextX < 10) nextX = 10;
                        if (nextX > maxW) nextX = maxW;
                        if (nextY < 10) nextY = 10;
                        if (nextY > maxH) nextY = maxH;

                        this.calcX = nextX;
                        this.calcY = nextY;
                    };

                    const onUp = () => {
                        this.isDraggingCalc = false;
                        window.removeEventListener('mousemove', onMove);
                        window.removeEventListener('mouseup', onUp);
                        window.removeEventListener('touchmove', onMove);
                        window.removeEventListener('touchend', onUp);
                    };

                    window.addEventListener('mousemove', onMove);
                    window.addEventListener('mouseup', onUp);
                    window.addEventListener('touchmove', onMove);
                    window.addEventListener('touchend', onUp);
                },

                timerSeconds: {{ $durationMin }} * 60, // 32 minutes for RW, 35 minutes for Math
                timerVisible: true,
                timerInterval: null,
                eliminatedOptions: {},
                eliminationMode: true,
                showFiveMinWarning: false,
                warnedFiveMin: false,

                toggleEliminate(qid, opt, event) {
                    if (event) {
                        event.preventDefault();
                        event.stopPropagation();
                    }
                    if (!this.eliminatedOptions[qid]) {
                        this.eliminatedOptions[qid] = {};
                    }
                    this.eliminatedOptions[qid][opt] = !this.eliminatedOptions[qid][opt];
                    // If option was selected and now eliminated, unselect it
                    if (this.eliminatedOptions[qid][opt] && this.userAnswers[qid] === opt) {
                        const updated = { ...this.userAnswers };
                        delete updated[qid];
                        this.userAnswers = updated;
                        sessionStorage.setItem('sat_mockup_answers_{{ $satStorageContext }}{{ $isMath ? "math_" : "" }}{{ $practiceNumber }}', JSON.stringify(this.userAnswers));
                    }
                },

                isEliminated(qid, opt) {
                    return !!(this.eliminatedOptions[qid] && this.eliminatedOptions[qid][opt]);
                },

                toggleAnnotateTool() {
                    this.showScratchpad = !this.showScratchpad;
                    if (this.showScratchpad && this.questionNotes[this.currentIndex]) {
                        this.questionNotes[this.currentIndex] = this.questionNotes[this.currentIndex]
                            .replace(/\["([^"]+)"\]:\s*/g, '$1\n')
                            .replace(/\["([^"]+)"\]/g, '$1');
                        this.saveNotes();
                    }
                    // Check if user currently has text selected
                    const sel = window.getSelection();
                    if (sel && sel.rangeCount > 0 && !sel.isCollapsed && sel.toString().trim().length > 0) {
                        this.applyHighlight('yellow');
                    }
                },

                triggerHighlightFromPad() {
                    const sel = window.getSelection();
                    const hasSel = (sel && sel.rangeCount > 0 && !sel.isCollapsed && sel.toString().trim().length > 0);
                    if (!hasSel && !window.satLastSelectedRange) {
                        alert('Silakan blok/sorot kata atau kalimat pada bacaan di sebelah kiri terlebih dahulu, lalu klik tombol Highlight.');
                        return;
                    }
                    this.applyHighlight(window.satLastSelectedRange || (hasSel ? sel.getRangeAt(0) : null));
                },

                triggerUnderlineFromPad() {
                    const sel = window.getSelection();
                    const hasSel = (sel && sel.rangeCount > 0 && !sel.isCollapsed && sel.toString().trim().length > 0);
                    if (!hasSel && !window.satLastSelectedRange) {
                        alert('Silakan blok kata atau kalimat pada bacaan di sebelah kiri terlebih dahulu, lalu klik tombol Underline (A).');
                        return;
                    }
                    this.applyUnderline(window.satLastSelectedRange || (hasSel ? sel.getRangeAt(0) : null));
                },

                applyUnderline(targetRange = null) {
                    let range = targetRange;
                    const sel = window.getSelection();
                    if (!range && sel && sel.rangeCount > 0 && !sel.isCollapsed && sel.toString().trim().length > 0) {
                        range = sel.getRangeAt(0);
                    }
                    if (!range && window.satLastSelectedRange) {
                        range = window.satLastSelectedRange;
                    }
                    if (!range || range.collapsed) return;

                    const span = document.createElement('span');
                    span.className = 'sat-underline';
                    try {
                        span.appendChild(range.extractContents());
                        range.insertNode(span);
                    } catch (err) {
                        try { range.surroundContents(span); } catch (e2) {}
                    }

                    span.addEventListener('click', (ev) => {
                        ev.stopPropagation();
                        if (window.showToolbarForHighlight) {
                            window.showToolbarForHighlight(span);
                        }
                    });

                    if (sel) {
                        try { sel.removeAllRanges(); } catch (e) {}
                    }
                    window.satLastSelectedRange = null;
                    this.savePassageHighlights();
                    this.closeToolbar();
                },

                hasAnnotation(qIndex) {
                    return (this.questionNotes[qIndex] && this.questionNotes[qIndex].trim().length > 0);
                },

                clearCurrentNote() {
                    if (confirm('Apakah Anda yakin ingin menghapus catatan untuk soal ini?')) {
                        delete this.questionNotes[this.currentIndex];
                        this.saveNotes();
                    }
                },

                saveNotes() {
                    sessionStorage.setItem('sat_mockup_notes_{{ $satStorageContext }}{{ $isMath ? "math_" : "" }}{{ $practiceNumber }}', JSON.stringify(this.questionNotes));
                },

                startDragPad(e) {
                    this.isDraggingPad = true;
                    const clientX = e.type.includes('touch') ? e.touches[0].clientX : e.clientX;
                    const clientY = e.type.includes('touch') ? e.touches[0].clientY : e.clientY;
                    this.padDragStartX = clientX;
                    this.padDragStartY = clientY;
                    this.padInitialX = this.padX;
                    this.padInitialY = this.padY;

                    const onPadMove = (moveEvent) => {
                        if (!this.isDraggingPad) return;
                        const curX = moveEvent.type.includes('touch') ? moveEvent.touches[0].clientX : moveEvent.clientX;
                        const curY = moveEvent.type.includes('touch') ? moveEvent.touches[0].clientY : moveEvent.clientY;
                        const deltaX = curX - this.padDragStartX;
                        const deltaY = curY - this.padDragStartY;

                        let nextX = this.padInitialX + deltaX;
                        let nextY = this.padInitialY + deltaY;
                        
                        const maxW = window.innerWidth - Math.min(this.padW, 150);
                        const maxH = window.innerHeight - 80;
                        if (nextX < 10) nextX = 10;
                        if (nextX > maxW) nextX = maxW;
                        if (nextY < 10) nextY = 10;
                        if (nextY > maxH) nextY = maxH;

                        this.padX = nextX;
                        this.padY = nextY;
                    };

                    const onPadUp = () => {
                        this.isDraggingPad = false;
                        window.removeEventListener('mousemove', onPadMove);
                        window.removeEventListener('mouseup', onPadUp);
                        window.removeEventListener('touchmove', onPadMove);
                        window.removeEventListener('touchend', onPadUp);
                    };

                    window.addEventListener('mousemove', onPadMove);
                    window.addEventListener('mouseup', onPadUp);
                    window.addEventListener('touchmove', onPadMove);
                    window.addEventListener('touchend', onPadUp);
                },

                startResizePad(e) {
                    this.isResizingPad = true;
                    const clientX = e.type.includes('touch') ? e.touches[0].clientX : e.clientX;
                    const clientY = e.type.includes('touch') ? e.touches[0].clientY : e.clientY;
                    this.padResizeStartX = clientX;
                    this.padResizeStartY = clientY;
                    this.padInitialW = this.padW;
                    this.padInitialH = this.padH;

                    const onPadResizeMove = (moveEvent) => {
                        if (!this.isResizingPad) return;
                        const curX = moveEvent.type.includes('touch') ? moveEvent.touches[0].clientX : moveEvent.clientX;
                        const curY = moveEvent.type.includes('touch') ? moveEvent.touches[0].clientY : moveEvent.clientY;
                        const deltaW = curX - this.padResizeStartX;
                        const deltaH = curY - this.padResizeStartY;

                        let nextW = this.padInitialW + deltaW;
                        let nextH = this.padInitialH + deltaH;

                        if (nextW < 280) nextW = 280;
                        if (nextW > window.innerWidth - this.padX - 10) nextW = window.innerWidth - this.padX - 10;
                        if (nextH < 180) nextH = 180;
                        if (nextH > window.innerHeight - this.padY - 10) nextH = window.innerHeight - this.padY - 10;

                        this.padW = nextW;
                        this.padH = nextH;
                    };

                    const onPadResizeUp = () => {
                        this.isResizingPad = false;
                        window.removeEventListener('mousemove', onPadResizeMove);
                        window.removeEventListener('mouseup', onPadResizeUp);
                        window.removeEventListener('touchmove', onPadResizeMove);
                        window.removeEventListener('touchend', onPadResizeUp);
                    };

                    window.addEventListener('mousemove', onPadResizeMove);
                    window.addEventListener('mouseup', onPadResizeUp);
                    window.addEventListener('touchmove', onPadResizeMove);
                    window.addEventListener('touchend', onPadResizeUp);
                },

                applyHighlight(targetRange = null) {
                    let range = targetRange;
                    const sel = window.getSelection();
                    if (!range && sel && sel.rangeCount > 0 && !sel.isCollapsed && sel.toString().trim().length > 0) {
                        range = sel.getRangeAt(0);
                    }
                    if (!range && window.satLastSelectedRange) {
                        range = window.satLastSelectedRange;
                    }
                    if (!range || range.collapsed) return;

                    const span = document.createElement('span');
                    span.className = 'sat-highlight';
                    try {
                        span.appendChild(range.extractContents());
                        range.insertNode(span);
                    } catch (err) {
                        try {
                            range.surroundContents(span);
                        } catch (e2) {}
                    }

                    span.addEventListener('click', (ev) => {
                        ev.stopPropagation();
                        if (window.showToolbarForHighlight) {
                            window.showToolbarForHighlight(span);
                        }
                    });

                    if (sel) {
                        try { sel.removeAllRanges(); } catch (e) {}
                    }
                    window.satLastSelectedRange = null;
                    this.savePassageHighlights();
                    this.closeToolbar();
                },

                openNoteForSelection() {
                    const sel = window.getSelection();
                    const text = (sel && !sel.isCollapsed ? sel.toString().trim() : '') || window.satLastSelectedText || '';
                    this.applyHighlight();
                    this.showScratchpad = true;
                    if (text && text.length > 0) {
                        let current = this.questionNotes[this.currentIndex] || '';
                        current = current.replace(/\["([^"]+)"\]:\s*/g, '$1\n').replace(/\["([^"]+)"\]/g, '$1');
                        if (!current.includes(text)) {
                            this.questionNotes[this.currentIndex] = (current ? (current + "\n\n") : '') + text;
                            this.saveNotes();
                        } else {
                            this.questionNotes[this.currentIndex] = current;
                            this.saveNotes();
                        }
                    }
                },

                getActivePassageEl(idx = null) {
                    const targetIdx = idx !== null ? idx : this.currentIndex;
                    return document.getElementById(`passageText-${targetIdx}`)
                        || document.getElementById(`passageText-math-${targetIdx}`)
                        || (document.querySelectorAll('.sat-question-container')[targetIdx]?.querySelector('.reading-passage'))
                        || document.querySelector('.sat-question-container:not([style*="display: none"]) .reading-passage')
                        || document.querySelector(`.sat-question-container:nth-child(${targetIdx + 1}) .reading-passage`);
                },

                savePassageHighlights(idx = null) {
                    const targetIdx = idx !== null ? idx : this.currentIndex;
                    const activePassageEl = this.getActivePassageEl(targetIdx);
                    if (activePassageEl) {
                        sessionStorage.setItem(`sat_hl_html_{{ $satStorageContext }}{{ $practiceNumber }}_${targetIdx}`, activePassageEl.innerHTML);
                    }
                },

                loadPassageHighlights(idx = null) {
                    const targetIdx = idx !== null ? idx : this.currentIndex;
                    const savedHtml = sessionStorage.getItem(`sat_hl_html_{{ $satStorageContext }}{{ $practiceNumber }}_${targetIdx}`);
                    const activePassageEl = this.getActivePassageEl(targetIdx);
                    if (savedHtml && activePassageEl) {
                        activePassageEl.innerHTML = savedHtml;
                        // Re-bind click listener on highlighted spans
                        activePassageEl.querySelectorAll('.sat-highlight, .sat-hl-yellow, .sat-underline').forEach(span => {
                            span.addEventListener('click', (ev) => {
                                ev.stopPropagation();
                                if (window.showToolbarForHighlight) {
                                    window.showToolbarForHighlight(span);
                                }
                            });
                        });
                    }
                },

                closeToolbar() {
                    const toolbar = document.getElementById('annotationToolbar');
                    if (toolbar) {
                        toolbar.classList.remove('is-open');
                        toolbar.style.setProperty('display', 'none', 'important');
                    }
                    const btnHapusHighlight = document.getElementById('btnHapusHighlight');
                    if (btnHapusHighlight) {
                        btnHapusHighlight.style.setProperty('display', 'none', 'important');
                    }
                    this.activeHighlightSpan = null;
                    window.satActiveSpan = null;
                    this.lastSelectedRange = null;
                    window.satLastSelectedRange = null;
                    window.satLastSelectedText = null;
                    const sel = window.getSelection();
                    if (sel) {
                        try { sel.removeAllRanges(); } catch (e) {}
                    }
                },

                showToolbarForSpan(span) {
                    const toolbar = document.getElementById('annotationToolbar');
                    // Jika toolbar sedang terbuka untuk span ini, toggle tutup
                    if ((this.activeHighlightSpan === span || window.satActiveSpan === span) && toolbar && toolbar.classList.contains('is-open')) {
                        this.closeToolbar();
                        return;
                    }

                    this.activeHighlightSpan = span;
                    window.satActiveSpan = span;
                    this.lastSelectedRange = null;
                    window.satLastSelectedRange = null;
                    const btnHapusHighlight = document.getElementById('btnHapusHighlight');
                    if (btnHapusHighlight) {
                        btnHapusHighlight.style.setProperty('display', 'inline-flex', 'important');
                    }
                    if (toolbar) {
                        toolbar.classList.add('is-open');
                        toolbar.style.setProperty('display', 'flex', 'important');
                        const rect = span.getBoundingClientRect();
                        const tbWidth = toolbar.offsetWidth || 180;
                        const tbHeight = toolbar.offsetHeight || 38;
                        let top = rect.top - tbHeight - 8;
                        if (top < 10) top = rect.bottom + 8;
                        let left = rect.left + (rect.width / 2) - (tbWidth / 2);
                        if (left < 10) left = 10;
                        if (left + tbWidth > window.innerWidth - 10) left = window.innerWidth - tbWidth - 10;
                        toolbar.style.top = `${top}px`;
                        toolbar.style.left = `${left}px`;
                    }
                },

                applyToolbarHighlight() {
                    try {
                        const targetSpan = this.activeHighlightSpan || window.satActiveSpan;
                        if (targetSpan) {
                            targetSpan.className = 'sat-highlight' + (targetSpan.classList.contains('has-note') ? ' has-note' : '');
                            this.savePassageHighlights();
                            this.closeToolbar();
                            return;
                        }

                        const sel = window.getSelection();
                        let range = null;
                        if (sel && sel.rangeCount > 0 && !sel.isCollapsed && sel.toString().trim().length > 0) {
                            range = sel.getRangeAt(0);
                        } else if (this.lastSelectedRange) {
                            range = this.lastSelectedRange;
                        } else if (window.satLastSelectedRange) {
                            range = window.satLastSelectedRange;
                        }

                        if (range && !range.collapsed) {
                            const span = document.createElement('span');
                            span.className = 'sat-highlight';
                            try {
                                span.appendChild(range.extractContents());
                                range.insertNode(span);
                            } catch (err) {
                                try { range.surroundContents(span); } catch (e2) {}
                            }
                            span.addEventListener('click', (ev) => {
                                ev.stopPropagation();
                                this.showToolbarForSpan(span);
                            });
                            this.savePassageHighlights();
                            if (sel) {
                                try { sel.removeAllRanges(); } catch (err) {}
                            }
                        }
                    } catch (e) {
                        console.error('Error in applyToolbarHighlight:', e);
                    }
                    this.closeToolbar();
                },

                applyToolbarUnderline() {
                    try {
                        const targetSpan = this.activeHighlightSpan || window.satActiveSpan;
                        if (targetSpan) {
                            targetSpan.className = 'sat-underline' + (targetSpan.classList.contains('has-note') ? ' has-note' : '');
                            this.savePassageHighlights();
                            this.closeToolbar();
                            return;
                        }

                        const sel = window.getSelection();
                        let range = null;
                        if (sel && sel.rangeCount > 0 && !sel.isCollapsed && sel.toString().trim().length > 0) {
                            range = sel.getRangeAt(0);
                        } else if (this.lastSelectedRange) {
                            range = this.lastSelectedRange;
                        } else if (window.satLastSelectedRange) {
                            range = window.satLastSelectedRange;
                        }

                        if (range && !range.collapsed) {
                            const span = document.createElement('span');
                            span.className = 'sat-underline';
                            try {
                                span.appendChild(range.extractContents());
                                range.insertNode(span);
                            } catch (err) {
                                try { range.surroundContents(span); } catch (e2) {}
                            }
                            span.addEventListener('click', (ev) => {
                                ev.stopPropagation();
                                this.showToolbarForSpan(span);
                            });
                            this.savePassageHighlights();
                            if (sel) {
                                try { sel.removeAllRanges(); } catch (err) {}
                            }
                        }
                    } catch (e) {
                        console.error('Error in applyToolbarUnderline:', e);
                    }
                    this.closeToolbar();
                },

                applyToolbarAnnotate() {
                    try {
                        let textToQuote = '';
                        let targetSpan = this.activeHighlightSpan || window.satActiveSpan;

                        // 1. Prioritize active highlight/underline span if clicked
                        if (targetSpan && targetSpan.textContent) {
                            textToQuote = targetSpan.textContent.trim();
                            targetSpan.classList.add('has-note');
                        } else {
                            // 2. Otherwise get current text selection
                            const sel = window.getSelection();
                            let range = null;
                            if (sel && sel.rangeCount > 0 && !sel.isCollapsed && sel.toString().trim().length > 0) {
                                textToQuote = sel.toString().trim();
                                range = sel.getRangeAt(0);
                            } else if (this.lastSelectedRange) {
                                range = this.lastSelectedRange;
                                textToQuote = (window.satLastSelectedText || range.toString()).trim();
                            } else if (window.satLastSelectedRange) {
                                range = window.satLastSelectedRange;
                                textToQuote = (window.satLastSelectedText || range.toString()).trim();
                            }

                            if (range && !range.collapsed) {
                                const span = document.createElement('span');
                                span.className = 'sat-highlight has-note';
                                try {
                                    span.appendChild(range.extractContents());
                                    range.insertNode(span);
                                } catch (err) {
                                    try { range.surroundContents(span); } catch (e2) {}
                                }
                                span.addEventListener('click', (ev) => {
                                    ev.stopPropagation();
                                    this.showToolbarForSpan(span);
                                });
                                targetSpan = span;
                            }
                        }

                        // 3. Clear range selections
                        if (window.getSelection()) {
                            try { window.getSelection().removeAllRanges(); } catch (e) {}
                        }
                        this.lastSelectedRange = null;
                        window.satLastSelectedRange = null;
                        window.satLastSelectedText = null;

                        // 4. Save highlights
                        this.savePassageHighlights();

                        // 5. Open scratchpad and insert text into note
                        this.showScratchpad = true;
                        if (textToQuote && textToQuote.length > 0) {
                            let current = (this.questionNotes && this.questionNotes[this.currentIndex]) ? String(this.questionNotes[this.currentIndex]) : '';
                            current = current.replace(/\["([^"]+)"\]:\s*/g, '$1\n').replace(/\["([^"]+)"\]/g, '$1').trim();
                            if (!current.includes(textToQuote)) {
                                const newNote = current ? (current + "\n\n" + textToQuote) : textToQuote;
                                this.questionNotes = {
                                    ...this.questionNotes,
                                    [this.currentIndex]: newNote
                                };
                            } else {
                                this.questionNotes = {
                                    ...this.questionNotes,
                                    [this.currentIndex]: current
                                };
                            }
                            this.saveNotes();
                        }

                        // 6. Focus textarea & scroll
                        this.$nextTick(() => {
                            const ta = document.getElementById('satScratchpadTextarea') || document.querySelector('div[x-show="showScratchpad"] textarea');
                            if (ta) {
                                ta.focus();
                                ta.scrollTop = ta.scrollHeight;
                            }
                        });

                        // 7. Hide floating toolbar
                        this.closeToolbar();
                    } catch (e) {
                        console.error('Error in applyToolbarAnnotate:', e);
                        this.closeToolbar();
                    }
                },

                applyToolbarRemove() {
                    try {
                        const targetSpan = this.activeHighlightSpan || window.satActiveSpan;
                        if (targetSpan && targetSpan.parentNode) {
                            const spanText = targetSpan.textContent ? targetSpan.textContent.trim() : '';
                            const parent = targetSpan.parentNode;
                            while (targetSpan.firstChild) {
                                parent.insertBefore(targetSpan.firstChild, targetSpan);
                            }
                            parent.removeChild(targetSpan);
                            this.activeHighlightSpan = null;
                            window.satActiveSpan = null;

                            // Jika isi catatan sama dengan teks yang dihapus, otomatis hapus catatannya
                            if (spanText && this.questionNotes && this.questionNotes[this.currentIndex]) {
                                let note = String(this.questionNotes[this.currentIndex]).trim();
                                if (note === spanText) {
                                    delete this.questionNotes[this.currentIndex];
                                    this.saveNotes();
                                }
                            }
                        } else {
                            // Jika ada teks terseleksi yang berada di atas highlight/underline
                            const sel = window.getSelection();
                            const passage = this.getActivePassageEl();
                            if (passage && sel && sel.rangeCount > 0 && !sel.isCollapsed) {
                                const highlights = passage.querySelectorAll('.sat-highlight, .sat-hl-yellow, .sat-underline');
                                highlights.forEach(h => {
                                    if (sel.containsNode(h, true)) {
                                        const p = h.parentNode;
                                        while (h.firstChild) {
                                            p.insertBefore(h.firstChild, h);
                                        }
                                        p.removeChild(h);
                                    }
                                });
                            }
                        }
                        this.savePassageHighlights();
                    } catch (e) {
                        console.error('Error in applyToolbarRemove:', e);
                    }
                    this.closeToolbar();
                },

                simulateScore(level) {
                    const keys = Object.keys(this.correctAnswersMap);
                    const total = keys.length;
                    if (total === 0) return;
                    const targetCorrect = level === 'high' ? Math.round(total * 0.9) : Math.round(total * 0.35);
                    keys.forEach((qid, idx) => {
                        if (idx < targetCorrect) {
                            this.userAnswers[qid] = this.correctAnswersMap[qid];
                        } else {
                            const options = ['A', 'B', 'C', 'D'];
                            const correct = this.correctAnswersMap[qid];
                            const wrong = options.filter(o => o !== correct);
                            this.userAnswers[qid] = wrong[0] || 'A';
                        }
                    });
                    sessionStorage.setItem('sat_mockup_answers_{{ $satStorageContext }}{{ $isMath ? "math_" : "" }}{{ $practiceNumber }}', JSON.stringify(this.userAnswers));
                    const percentage = level === 'high' ? '90%' : '35%';
                    alert('Simulasi ' + (level === 'high' ? 'Skor Tinggi' : 'Skor Rendah') + ' (' + percentage + ' benar) berhasil diterapkan ke ' + total + ' soal! Anda dapat langsung menekan tombol Selesai & Kirim untuk menguji modul berikutnya.');
                },

                askAiExplanation(questionId, qNum, userAns, sectionType, forceReload = false) {
                    if (this.aiExplanations[questionId] && !forceReload) return;
                    this.aiLoading = { ...this.aiLoading, [questionId]: true };
                    
                    fetch('{{ route("assignments.sat.ai-explain") }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Accept': 'application/json'
                        },
                        body: JSON.stringify({
                            question_id: questionId,
                            section_type: sectionType,
                            user_answer: userAns || (this.userAnswers && this.userAnswers[questionId]) || '',
                            question_number: qNum
                        })
                    })
                    .then(res => res.json())
                    .then(data => {
                        this.aiLoading = { ...this.aiLoading, [questionId]: false };
                        if (data.success && data.explanation) {
                            this.aiExplanations = { ...this.aiExplanations, [questionId]: data.explanation };
                            this.aiSources = { ...this.aiSources, [questionId]: data.source || 'SAT AI Tutor' };
                            this.$nextTick(() => {
                                this.renderMath();
                            });
                        } else {
                            alert(data.message || 'Gagal memuat penjelasan AI. Silakan coba lagi.');
                        }
                    })
                    .catch(err => {
                        this.aiLoading = { ...this.aiLoading, [questionId]: false };
                        console.error('AI Explain Error:', err);
                        alert('Terjadi kendala jaringan saat menghubungi Tutor AI.');
                    });
                },

                renderMarkdown(text) {
                    if (!text) return '';
                    let html = text
                        .replace(/&/g, '&amp;')
                        .replace(/</g, '&lt;')
                        .replace(/>/g, '&gt;')
                        // Headers
                        .replace(/^### (.*$)/gim, '<h5 class="font-extrabold text-indigo-950 text-sm mt-3 mb-1">$1</h5>')
                        .replace(/^## (.*$)/gim, '<h4 class="font-black text-indigo-950 text-base mt-4 mb-2">$1</h4>')
                        // Bold & Italic
                        .replace(/\*\*(.*?)\*\*/g, '<strong class="font-bold text-indigo-950">$1</strong>')
                        .replace(/\*(.*?)\*/g, '<em class="italic">$1</em>')
                        // Bullet points
                        .replace(/^\s*[\-\*]\s+(.*$)/gim, '<li class="ml-4 list-disc text-slate-800">$1</li>')
                        // Numbered lists
                        .replace(/^\s*(\d+)\.\s+(.*$)/gim, '<li class="ml-4 list-decimal text-slate-800"><strong>$1.</strong> $2</li>')
                        // Line breaks
                        .replace(/\n\n/g, '<div class="h-2"></div>')
                        .replace(/\n/g, '<br>');
                    return html;
                },

                renderMath() {
                    this.$nextTick(() => {
                        if (window.MathJax && window.MathJax.typesetPromise) {
                            window.MathJax.typesetPromise().catch(function (err) {
                                console.warn('MathJax typeset failed: ', err);
                            });
                        }
                    });
                },

                init() {
                    if (window.innerWidth < 640) {
                        this.isMaximizedCalc = true;
                    }
                    this.renderMath();
                    this.$watch('currentIndex', () => {
                        this.renderMath();
                    });
                    this.$watch('adminPeekKey', () => {
                        this.renderMath();
                    });
                    this.$watch('studentPreview', (val) => {
                        if (val) {
                            this.openAdminDrawer = false;
                        }
                        this.renderMath();
                    });

                    // Load saved question notes from session storage
                    const savedNotes = sessionStorage.getItem('sat_mockup_notes_{{ $satStorageContext }}{{ $isMath ? "math_" : "" }}{{ $practiceNumber }}');
                    if (savedNotes) {
                        try { 
                            this.questionNotes = JSON.parse(savedNotes); 
                            // Otomatis bersihkan format lama ["..."]: menjadi teks biasa
                            for (const k in this.questionNotes) {
                                if (typeof this.questionNotes[k] === 'string') {
                                    this.questionNotes[k] = this.questionNotes[k]
                                        .replace(/\["([^"]+)"\]:\s*/g, '$1\n')
                                        .replace(/\["([^"]+)"\]/g, '$1');
                                }
                            }
                            this.saveNotes();
                        } catch(e) {}
                    }

                    // Expose Alpine helper methods to window for annotation toolbar
                    window.satSavePassageHighlights = () => this.savePassageHighlights();
                    window.satOpenScratchpad = (quoteText) => {
                        this.showScratchpad = true;
                        if (quoteText && quoteText.length > 0) {
                            let current = this.questionNotes[this.currentIndex] || '';
                            // Bersihkan format lama jika ada
                            current = current.replace(/\["([^"]+)"\]:\s*/g, '$1\n').replace(/\["([^"]+)"\]/g, '$1');
                            if (!current.includes(quoteText)) {
                                this.questionNotes[this.currentIndex] = (current ? (current + "\n\n") : '') + quoteText;
                                this.saveNotes();
                            } else {
                                this.questionNotes[this.currentIndex] = current;
                                this.saveNotes();
                            }
                        } else if (this.questionNotes[this.currentIndex]) {
                            this.questionNotes[this.currentIndex] = this.questionNotes[this.currentIndex]
                                .replace(/\["([^"]+)"\]:\s*/g, '$1\n')
                                .replace(/\["([^"]+)"\]/g, '$1');
                            this.saveNotes();
                        }
                    };

                    this.loadPassageHighlights(this.currentIndex);
                    this.$watch('currentIndex', (newVal, oldVal) => {
                        if (oldVal !== undefined) {
                            this.savePassageHighlights(oldVal);
                        }
                        this.closeToolbar();
                        this.$nextTick(() => {
                            this.loadPassageHighlights(newVal);
                        });
                    });

                    // Setup Official Bluebook Selection API Toolbar
                    const toolbar = document.getElementById('annotationToolbar');
                    const btnHapusHighlight = document.getElementById('btnHapusHighlight');
                    const btnCloseToolbar = document.getElementById('btnCloseToolbar');

                    window.showToolbarForHighlight = (span) => this.showToolbarForSpan(span);
                    window.satApplyHighlight = (e) => {
                        if (e) { if (e.preventDefault) e.preventDefault(); if (e.stopPropagation) e.stopPropagation(); }
                        this.applyToolbarHighlight();
                    };
                    window.satApplyUnderline = (e) => {
                        if (e) { if (e.preventDefault) e.preventDefault(); if (e.stopPropagation) e.stopPropagation(); }
                        this.applyToolbarUnderline();
                    };
                    window.satApplyAnnotate = (e) => {
                        if (e) { if (e.preventDefault) e.preventDefault(); if (e.stopPropagation) e.stopPropagation(); }
                        this.applyToolbarAnnotate();
                    };
                    window.satRemoveHighlight = (e) => {
                        if (e) { if (e.preventDefault) e.preventDefault(); if (e.stopPropagation) e.stopPropagation(); }
                        this.applyToolbarRemove();
                    };
                    window.satCloseToolbar = (e) => {
                        if (e) { if (e.preventDefault) e.preventDefault(); if (e.stopPropagation) e.stopPropagation(); }
                        this.closeToolbar();
                    };

                    if (btnHapusHighlight) {
                        btnHapusHighlight.addEventListener('click', (ev) => {
                            ev.preventDefault();
                            ev.stopPropagation();
                            this.applyToolbarRemove();
                        });
                    }

                    if (btnCloseToolbar) {
                        btnCloseToolbar.addEventListener('click', (ev) => {
                            ev.preventDefault();
                            ev.stopPropagation();
                            this.closeToolbar();
                        });
                    }

                    // Event delegation untuk klik pada teks yang disorot / digarisbawahi
                    document.addEventListener('click', (e) => {
                        const hlSpan = e.target.closest('.sat-highlight, .sat-hl-yellow, .sat-underline');
                        if (hlSpan && (!toolbar || !toolbar.contains(e.target))) {
                            e.stopPropagation();
                            this.showToolbarForSpan(hlSpan);
                        }
                    });

                    // Deteksi saat teks selesai diblok (mouseup & touchend)
                    const handleSelection = (e) => {
                        if (toolbar && toolbar.contains(e.target)) return;

                        // Jika klik langsung pada highlight span yang sudah ada, biarkan click listener yang menangani
                        if (e.target && (e.target.closest('.sat-highlight') || e.target.closest('.sat-hl-yellow') || e.target.closest('.sat-underline'))) {
                            return;
                        }

                        // Cek apakah klik/seleksi berada di dalam passage
                        const clickInPassage = e.target && (
                            e.target.closest('.reading-passage') || 
                            e.target.closest('.sat-passage-pane') || 
                            e.target.closest('.sat-passage-text') || 
                            e.target.closest('.sat-math-single-pane')
                        );

                        // Jika klik di luar passage sama sekali, tutup toolbar dan reset selection
                        if (!clickInPassage) {
                            this.closeToolbar();
                            return;
                        }

                        const selection = window.getSelection();
                        const selectedText = selection ? selection.toString().trim() : '';

                        if (selectedText.length > 0 && selection.rangeCount > 0) {
                            const range = selection.getRangeAt(0);
                            const container = range.commonAncestorContainer;
                            const targetEl = container.nodeType === 3 ? container.parentElement : container;

                            const passage = targetEl.closest('.reading-passage') 
                                         || targetEl.closest('.sat-passage-pane')
                                         || targetEl.closest('.sat-passage-text')
                                         || targetEl.closest('.sat-math-single-pane');

                            if (passage) {
                                this.lastSelectedRange = range.cloneRange();
                                window.satLastSelectedRange = range.cloneRange();
                                window.satLastSelectedText = selectedText;
                                this.activeHighlightSpan = null;
                                window.satActiveSpan = null;
                                if (btnHapusHighlight) {
                                    btnHapusHighlight.style.setProperty('display', 'none', 'important');
                                }

                                toolbar.classList.add('is-open');
                                toolbar.style.setProperty('display', 'flex', 'important');
                                const rect = range.getBoundingClientRect();
                                const tbWidth = toolbar.offsetWidth || 180;
                                const tbHeight = toolbar.offsetHeight || 38;

                                // Posisikan toolbar tepat di atas teks yang diblok
                                let top = rect.top - tbHeight - 8;
                                if (top < 10) top = rect.bottom + 8;
                                let left = rect.left + (rect.width / 2) - (tbWidth / 2);
                                if (left < 10) left = 10;
                                if (left + tbWidth > window.innerWidth - 10) left = window.innerWidth - tbWidth - 10;

                                toolbar.style.top = `${top}px`;
                                toolbar.style.left = `${left}px`;
                                return;
                            }
                        }

                        // Jika pengguna klik di dalam passage tapi tidak memblok teks (hanya klik biasa), tutup toolbar
                        this.closeToolbar();
                    };

                    document.addEventListener('mouseup', handleSelection);
                    document.addEventListener('touchend', handleSelection);

                    // Sembunyikan toolbar jika mousedown/touchstart di luar toolbar dan di luar span yang disorot
                    const onOutsidePointer = (e) => {
                        if (toolbar && !toolbar.contains(e.target) && !e.target.closest('.sat-highlight') && !e.target.closest('.sat-hl-yellow') && !e.target.closest('.sat-underline')) {
                            this.closeToolbar();
                        }
                    };
                    document.addEventListener('mousedown', onOutsidePointer);
                    document.addEventListener('touchstart', onOutsidePointer, { passive: true });

                    // Tutup toolbar jika menekan tombol Escape di keyboard
                    document.addEventListener('keydown', (e) => {
                        if (e.key === 'Escape') {
                            this.closeToolbar();
                        }
                    });

                    // Sembunyikan toolbar jika pengguna melakukan scroll di window atau container passage
                    window.addEventListener('scroll', () => {
                        this.closeToolbar();
                    }, { passive: true });
                    document.querySelectorAll('.sat-passage-pane, .sat-math-single-pane, .cbt-scroll').forEach(el => {
                        el.addEventListener('scroll', () => {
                            this.closeToolbar();
                        }, { passive: true });
                    });

                    // Listener koneksi online untuk melanjutkan submit tertunda
                    window.addEventListener('online', () => {
                        if (this.offlineSubmitPending && !this.isSubmitting) {
                            this.offlineSubmitPending = false;
                            alert('Koneksi internet telah terhubung kembali! Sistem akan melanjutkan pengiriman jawaban Anda...');
                            this.submitTest();
                        }
                    });

                    @if($existingScore)
                        // Ujian telah berhasil terkirim dan dinilai oleh server:
                        // Bersihkan draf sessionStorage agar tidak menumpuk
                        sessionStorage.removeItem('sat_mockup_answers_{{ $satStorageContext }}{{ $isMath ? "math_" : "" }}{{ $practiceNumber }}');
                        sessionStorage.removeItem('sat_mockup_marked_{{ $satStorageContext }}{{ $isMath ? "math_" : "" }}{{ $practiceNumber }}');
                        sessionStorage.removeItem('sat_mockup_timer_{{ $satStorageContext }}{{ $isMath ? "math_" : "" }}{{ $practiceNumber }}');
                    @else
                        // Load devMode preference if admin
                        if (this.isAdmin) {
                            const savedDev = localStorage.getItem('sat_dev_mode');
                            if (savedDev !== null) {
                                this.devMode = savedDev === 'true';
                            }
                        } else {
                            this.devMode = false;
                        }

                        // If user retried test, ensure sessionStorage answers & timer are wiped
                        @if(session('info') || request('retry'))
                            sessionStorage.removeItem('sat_mockup_answers_{{ $satStorageContext }}{{ $isMath ? "math_" : "" }}{{ $practiceNumber }}');
                            sessionStorage.removeItem('sat_mockup_marked_{{ $satStorageContext }}{{ $isMath ? "math_" : "" }}{{ $practiceNumber }}');
                            sessionStorage.removeItem('sat_mockup_timer_{{ $satStorageContext }}{{ $isMath ? "math_" : "" }}{{ $practiceNumber }}');
                        @endif

                        // Load cached answers from session storage if available
                        const saved = sessionStorage.getItem('sat_mockup_answers_{{ $satStorageContext }}{{ $isMath ? "math_" : "" }}{{ $practiceNumber }}');
                        if (saved) {
                            try { this.userAnswers = JSON.parse(saved); } catch(e) {}
                        }

                        // Load cached marked questions from session storage if available
                        const savedMarked = sessionStorage.getItem('sat_mockup_marked_{{ $satStorageContext }}{{ $isMath ? "math_" : "" }}{{ $practiceNumber }}');
                        if (savedMarked) {
                            try { this.markedQuestions = JSON.parse(savedMarked); } catch(e) {}
                        }

                        // Load timer
                        const savedTimer = sessionStorage.getItem('sat_mockup_timer_{{ $satStorageContext }}{{ $isMath ? "math_" : "" }}{{ $practiceNumber }}');
                        if (savedTimer && !isNaN(savedTimer) && Number(savedTimer) > 0) {
                            this.timerSeconds = Number(savedTimer);
                        } else if (this.devMode) {
                            this.timerSeconds = {{ $durationMin }} * 60;
                        }

                        this.startTimer();
                    @endif
                },

                toggleDevMode() {
                    if (!this.isAdmin) return;
                    this.devMode = !this.devMode;
                    localStorage.setItem('sat_dev_mode', this.devMode ? 'true' : 'false');
                    if (this.devMode && this.timerSeconds <= 0) {
                        this.timerSeconds = {{ $durationMin }} * 60;
                        sessionStorage.setItem('sat_mockup_timer_{{ $satStorageContext }}{{ $isMath ? "math_" : "" }}{{ $practiceNumber }}', this.timerSeconds);
                    }
                },

                resetTimer() {
                    if (!this.isAdmin) return;
                    this.timerSeconds = {{ $durationMin }} * 60;
                    sessionStorage.setItem('sat_mockup_timer_{{ $satStorageContext }}{{ $isMath ? "math_" : "" }}{{ $practiceNumber }}', this.timerSeconds);
                },

                startTimer() {
                    if (this.timerInterval) clearInterval(this.timerInterval);
                    this.timerInterval = setInterval(() => {
                        // In development mode for admin, timer is paused and does not tick down
                        if (this.devMode) {
                            return;
                        }

                        if (this.timerSeconds > 0) {
                            this.timerSeconds--;
                            sessionStorage.setItem('sat_mockup_timer_{{ $satStorageContext }}{{ $isMath ? "math_" : "" }}{{ $practiceNumber }}', this.timerSeconds);
                            
                            // Bluebook 5-minute remaining alert
                            if (this.timerSeconds === 300 && !this.warnedFiveMin) {
                                this.warnedFiveMin = true;
                                this.showFiveMinWarning = true;
                                this.timerVisible = true; // Ensure timer is visible when under 5 minutes
                            }
                        } else {
                            clearInterval(this.timerInterval);
                            this.timerSeconds = 0;
                            if (typeof navigator !== 'undefined' && !navigator.onLine) {
                                this.offlineSubmitPending = true;
                                alert('Waktu ujian telah habis! Namun koneksi internet Anda saat ini sedang terputus.\n\nSeluruh jawaban Anda tersimpan AMAN di browser ini. Mohon sambungkan kembali koneksi internet Anda, lalu kirim jawaban.');
                                this.showReviewModal = true;
                                return;
                            }
                            alert('Waktu ujian telah habis! Jawaban Anda akan otomatis dikirimkan.');
                            this.submitTest();
                        }
                    }, 1000);
                },

                formatTime(seconds) {
                    const m = Math.floor(seconds / 60);
                    const s = seconds % 60;
                    return (m < 10 ? '0' : '') + m + ':' + (s < 10 ? '0' : '') + s;
                },

                setAnswer(questionId, option) {
                    this.userAnswers = { ...this.userAnswers, [questionId]: option };
                    sessionStorage.setItem('sat_mockup_answers_{{ $satStorageContext }}{{ $isMath ? "math_" : "" }}{{ $practiceNumber }}', JSON.stringify(this.userAnswers));
                },

                getAnswer(questionId) {
                    return this.userAnswers[questionId] || null;
                },

                toggleMark(questionNumber) {
                    const newMarked = { ...this.markedQuestions };
                    if (newMarked[questionNumber]) {
                        delete newMarked[questionNumber];
                    } else {
                        newMarked[questionNumber] = true;
                    }
                    this.markedQuestions = newMarked;
                    sessionStorage.setItem('sat_mockup_marked_{{ $satStorageContext }}{{ $isMath ? "math_" : "" }}{{ $practiceNumber }}', JSON.stringify(this.markedQuestions));
                },

                isMarked(questionNumber) {
                    return !!this.markedQuestions[questionNumber];
                },

                markedCount() {
                    return Object.keys(this.markedQuestions).length;
                },

                answeredCount() {
                    if (this.questionIds && this.questionIds.length > 0) {
                        return this.questionIds.filter(qid => {
                            const a = this.userAnswers[qid];
                            return a !== null && a !== undefined && a !== '';
                        }).length;
                    }
                    return Object.keys(this.userAnswers).filter(k => this.userAnswers[k] !== null && this.userAnswers[k] !== '').length;
                },

                unansweredList() {
                    const list = [];
                    if (this.questionIds && this.questionIds.length > 0) {
                        this.questionIds.forEach((qid, index) => {
                            const a = this.userAnswers[qid];
                            if (a === null || a === undefined || a === '') {
                                list.push(index + 1);
                            }
                        });
                    }
                    return list;
                },

                goToQuestion(index) {
                    this.currentIndex = index;
                    this.showNavigator = false;
                },

                nextQuestion() {
                    if (this.currentIndex < this.totalCount - 1) {
                        this.currentIndex++;
                    }
                },

                prevQuestion() {
                    if (this.currentIndex > 0) {
                        this.currentIndex--;
                    }
                },

                correctAnswersMap: @json(($existingScore || $isAdmin) ? $questions->pluck('correct_answer', 'id')->map(fn($a) => strtoupper(trim((string)$a))) : (object)[]),

                isQuestionCorrect(qid) {
                    const user = (this.userAnswers[qid] || '').toUpperCase().trim();
                    const correct = (this.correctAnswersMap[qid] || '').toUpperCase().trim();
                    return user !== '' && user === correct;
                },

                getNavButtonClass(index, qid) {
                    const isCurrent = this.currentIndex === index;
                    const hasAns = this.userAnswers[qid] !== null && this.userAnswers[qid] !== undefined && this.userAnswers[qid] !== '';

                    @if($existingScore)
                        // In review mode: show correct/wrong
                        const isCorrect = this.isQuestionCorrect(qid);
                        if (isCorrect) {
                            return isCurrent 
                                ? 'bg-emerald-600 text-white border-slate-900 ring-4 ring-emerald-300 font-black shadow-md' 
                                : 'bg-emerald-100 text-emerald-900 border-emerald-400 font-bold';
                        } else {
                            return isCurrent 
                                ? 'bg-rose-600 text-white border-slate-900 ring-4 ring-rose-300 font-black shadow-md' 
                                : 'bg-rose-100 text-rose-900 border-rose-400 font-bold';
                        }
                    @else
                        if (isCurrent) {
                            if (hasAns) {
                                return 'bg-sky-600 text-white border-slate-900 ring-4 ring-sky-300 font-black shadow-md';
                            } else {
                                return 'border-sky-600 bg-sky-100 text-sky-950 ring-4 ring-sky-300 font-black shadow-xs';
                            }
                        }
                        if (hasAns) {
                            return 'bg-sky-600 text-white border-sky-600 font-bold';
                        }
                        return 'bg-white text-slate-800 border-slate-300 hover:bg-slate-100 font-medium';
                    @endif
                },

                submitTest() {
                    if (this.isSubmitting) return;

                    // Proteksi jika koneksi offline saat menekan submit
                    if (typeof navigator !== 'undefined' && !navigator.onLine) {
                        this.offlineSubmitPending = true;
                        alert('Perhatian: Koneksi internet Anda sedang terputus!\n\nSeluruh jawaban Anda tetap tersimpan AMAN di perangkat ini. Harap periksa jaringan internet Anda dan coba kembali saat sudah terhubung.');
                        this.isSubmitting = false;
                        return;
                    }

                    this.isSubmitting = true;
                    if (this.timerInterval) clearInterval(this.timerInterval);

                    // PENTING: Draf di sessionStorage sengaja TIDAK dihapus di sini!
                    // Draf baru dibersihkan setelah server sukses memproses jawaban dan menampilkan halaman review ($existingScore).
                    // Dengan begitu, jika koneksi mendadak putus di tengah request submit atau terjadi timeout,
                    // siswa tidak akan kehilangan jawaban saat reload halaman.
                    const form = document.getElementById('satSubmitForm');
                    if (form) {
                        form.submit();
                    }
                }
            }
        }
    </script>
</body>
</html>
