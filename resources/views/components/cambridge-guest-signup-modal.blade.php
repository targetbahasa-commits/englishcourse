{{--
    Cambridge Guest Sign-Up Modal
    Shown automatically when $requiresSignup === true (unauthenticated visitor).
    Pure CSS/HTML modal — no Alpine.js dependency so it always renders immediately.
--}}
@if($requiresSignup ?? false)
<style>
    #cambridge-signup-overlay {
        position: fixed;
        inset: 0;
        z-index: 9999;
        display: flex;
        align-items: center;
        justify-content: center;
        background: rgba(15, 23, 42, 0.45);
    }
    #cambridge-signup-card {
        width: 100%;
        max-width: 28rem;
        margin: 1rem;
        background: #ffffff;
        border-radius: 1.5rem;
        box-shadow: 0 25px 50px -12px rgba(0,0,0,0.4);
        overflow: hidden;
        animation: cg-slide-in 0.3s ease-out both;
    }
    @keyframes cg-slide-in {
        from { opacity: 0; transform: scale(0.95) translateY(8px); }
        to   { opacity: 1; transform: scale(1) translateY(0); }
    }
    .cg-input {
        width: 100%;
        border: 1.5px solid #e5e7eb;
        border-radius: 0.75rem;
        padding: 0.75rem 1rem;
        font-size: 0.875rem;
        outline: none;
        transition: border-color 0.15s, box-shadow 0.15s;
        box-sizing: border-box;
    }
    .cg-input:focus {
        border-color: #6366f1;
        box-shadow: 0 0 0 3px rgba(99,102,241,0.15);
    }
    .cg-btn-primary {
        width: 100%;
        background: linear-gradient(135deg, #4f46e5, #7c3aed);
        color: #fff;
        font-weight: 700;
        font-size: 0.95rem;
        padding: 0.85rem 1.5rem;
        border: none;
        border-radius: 0.75rem;
        cursor: pointer;
        transition: opacity 0.15s, transform 0.15s;
        margin-top: 0.5rem;
        letter-spacing: 0.01em;
    }
    .cg-btn-primary:hover { opacity: 0.92; transform: scale(1.01); }
    .cg-btn-secondary {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
        width: 100%;
        border: 1.5px solid #e5e7eb;
        background: #fff;
        color: #374151;
        font-weight: 600;
        font-size: 0.875rem;
        padding: 0.75rem 1.5rem;
        border-radius: 0.75rem;
        text-decoration: none;
        transition: background 0.15s;
        box-sizing: border-box;
    }
    .cg-btn-secondary:hover { background: #f9fafb; }
</style>

<div id="cambridge-signup-overlay">
    <div id="cambridge-signup-card">

        {{-- Gradient top bar --}}
        <div style="height: 5px; background: linear-gradient(90deg, #6366f1, #8b5cf6, #ec4899);"></div>

        <div style="padding: 2rem;">

            {{-- Icon --}}
            <div style="display:flex; justify-content:center; margin-bottom:1.25rem;">
                <div style="width:3.5rem; height:3.5rem; background:linear-gradient(135deg,#eef2ff,#ede9fe); border-radius:1rem; display:flex; align-items:center; justify-content:center;">
                    <svg width="28" height="28" fill="none" stroke="#4f46e5" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                    </svg>
                </div>
            </div>

            {{-- Title --}}
            <h2 style="font-size:1.4rem; font-weight:800; text-align:center; color:#111827; margin:0 0 0.35rem;">
                Akses Tes Gratis Cambridge 🎓
            </h2>
            <p style="text-align:center; color:#6b7280; font-size:0.875rem; margin:0 0 1.5rem; line-height:1.6;">
                Daftar gratis dalam 30 detik untuk mulai mengerjakan soal Cambridge IELTS Mock Test ini.
            </p>

            {{-- Validation errors --}}
            @if($errors->any())
                <div style="margin-bottom:1rem; padding:0.75rem 1rem; background:#fef2f2; border:1px solid #fecaca; border-radius:0.6rem; color:#dc2626; font-size:0.8rem;">
                    @foreach($errors->all() as $err) <div>• {{ $err }}</div> @endforeach
                </div>
            @endif
            @if(session('error'))
                <div style="margin-bottom:1rem; padding:0.75rem 1rem; background:#fef2f2; border:1px solid #fecaca; border-radius:0.6rem; color:#dc2626; font-size:0.8rem;">
                    {{ session('error') }}
                </div>
            @endif

            {{-- Form --}}
            <form method="POST" action="{{ route('cambridge.guest.register') }}">
                @csrf
                <input type="hidden" name="redirect_to" value="{{ url()->current() }}">

                <div style="margin-bottom:0.875rem;">
                    <label style="display:block; font-size:0.8rem; font-weight:600; color:#374151; margin-bottom:0.35rem;" for="cg_name">Nama Lengkap</label>
                    <input id="cg_name" class="cg-input" type="text" name="name" required
                           placeholder="e.g. Budi Santoso" value="{{ old('name') }}">
                </div>

                <div style="margin-bottom:0.875rem;">
                    <label style="display:block; font-size:0.8rem; font-weight:600; color:#374151; margin-bottom:0.35rem;" for="cg_email">Email</label>
                    <input id="cg_email" class="cg-input" type="email" name="email" required
                           placeholder="e.g. budi@email.com" value="{{ old('email') }}">
                </div>

                <div style="margin-bottom:0.5rem;">
                    <label style="display:block; font-size:0.8rem; font-weight:600; color:#374151; margin-bottom:0.35rem;" for="cg_phone">No. WhatsApp</label>
                    <input id="cg_phone" class="cg-input" type="text" name="phone_number" required
                           placeholder="e.g. 0812-xxxx-xxxx" value="{{ old('phone_number') }}">
                </div>

                <div style="margin-bottom:0.875rem;">
                    <!-- Cloudflare Turnstile Widget -->
                    <div class="cf-turnstile" data-sitekey="{{ config('services.turnstile.key') }}" data-theme="light"></div>
                    <script src="https://challenges.cloudflare.com/turnstile/v0/api.js" async defer></script>
                </div>

                <button type="submit" class="cg-btn-primary">🎯 Mulai Tes Gratis Sekarang</button>
            </form>

            {{-- Divider --}}
            <div style="display:flex; align-items:center; gap:0.75rem; margin:1.25rem 0;">
                <div style="flex:1; height:1px; background:#f3f4f6;"></div>
                <span style="font-size:0.75rem; color:#9ca3af; white-space:nowrap;">Sudah punya akun?</span>
                <div style="flex:1; height:1px; background:#f3f4f6;"></div>
            </div>

            {{-- Login link --}}
            <a href="{{ route('login') }}" class="cg-btn-secondary">
                <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"/>
                </svg>
                Masuk dengan Akun yang Ada
            </a>

            <p style="text-align:center; font-size:0.7rem; color:#9ca3af; margin-top:1rem;">
                Gratis · Tidak perlu kartu kredit · Data kamu aman
            </p>

        </div>
    </div>
</div>
@endif
