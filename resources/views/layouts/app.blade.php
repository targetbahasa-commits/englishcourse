<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>
        <link rel="icon" type="image/png" href="{{ asset('images/brand/icon.png') }}">

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <style>
            textarea.auto-expand-answer {
                field-sizing: content;
                height: auto;
                width: 100%;
                resize: none;
                overflow: hidden;
            }
            textarea.auto-expand-answer[rows="1"] {
                min-block-size: 2.75rem;
                min-height: 2.75rem;
            }
            textarea.auto-expand-answer[rows="2"] {
                min-height: 4.25rem;
            }
            textarea.auto-expand-answer[rows="3"] {
                min-height: 5.75rem;
            }
            textarea.auto-expand-answer[rows="4"] {
                min-height: 7.25rem;
            }
            textarea.auto-expand-answer:not([rows="1"]):not([rows="2"]):not([rows="3"]):not([rows="4"]) {
                min-block-size: 8lh;
                min-height: 9rem;
            }
        </style>
    </head>
    <body class="font-sans antialiased">
    @include('components.impersonation-banner')
        <div class="min-h-screen bg-gray-100">
            @include('layouts.navigation')

            <!-- Page Heading -->
            @isset($header)
                <header class="bg-white shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endisset

            <!-- Page Content -->
            <main>
                {{ $slot }}
            </main>
        </div>
        @include('components.student-broadcaster')
        @include('components.floating-wa-button')
        @stack('scripts')
        <script>
            (function () {
                const resizeEl = function (el) {
                    if (!el || el.tagName !== 'TEXTAREA' || !el.classList.contains('auto-expand-answer')) return;
                    el.style.height = 'auto';
                    if (el.scrollHeight > 0) {
                        el.style.height = el.scrollHeight + 'px';
                    }
                };
                const resizeAll = function (root) {
                    (root || document).querySelectorAll('textarea.auto-expand-answer').forEach(resizeEl);
                };
                window.resizeAutoExpandTextarea = resizeEl;
                window.resizeAutoExpandTextareas = resizeAll;
                document.addEventListener('input', function (e) {
                    if (e.target && e.target.matches && e.target.matches('textarea.auto-expand-answer')) {
                        resizeEl(e.target);
                    }
                });
                window.addEventListener('resize', function () { resizeAll(); });
                if (document.readyState === 'loading') {
                    document.addEventListener('DOMContentLoaded', function () {
                        resizeAll();
                        setTimeout(resizeAll, 150);
                        setTimeout(resizeAll, 600);
                    });
                } else {
                    resizeAll();
                    setTimeout(resizeAll, 150);
                    setTimeout(resizeAll, 600);
                }
                window.addEventListener('load', function () { resizeAll(); });
            })();
        </script>
    </body>
</html>
