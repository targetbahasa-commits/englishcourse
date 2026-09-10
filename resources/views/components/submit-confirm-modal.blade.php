@once
<!-- SUBMIT CONFIRMATION MODAL COMPONENT -->
<div id="tb-submit-confirm-modal" class="fixed inset-0 z-[99999] flex items-center justify-center p-4 bg-black/60 backdrop-blur-sm transition-opacity duration-300 opacity-0 pointer-events-none" style="display: none;">
    <div class="bg-white rounded-2xl shadow-2xl w-full max-w-md p-6 sm:p-7 text-center transform transition-all duration-300 scale-95 opacity-0 border border-gray-100" id="tb-submit-confirm-card">
        
        <!-- Icon Header -->
        <div class="mx-auto flex items-center justify-center w-16 h-16 rounded-full bg-blue-50 border-4 border-blue-100 mb-5 text-blue-600 shadow-inner">
            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
        </div>

        <!-- Title -->
        <h3 class="text-xl font-bold text-gray-900 mb-2">
            Konfirmasi Pengiriman
        </h3>

        <!-- Status Summary Badge -->
        <div id="tb-confirm-summary-badge" class="my-3 px-4 py-2.5 rounded-xl text-sm font-medium transition-all">
            <!-- Injected dynamically by JS -->
        </div>

        <!-- Description -->
        <p class="text-gray-600 text-sm leading-relaxed mb-6" id="tb-confirm-description">
            Apakah kamu yakin ingin memeriksa dan mengirim semua jawaban sekarang? Setelah dikirim, jawaban kamu akan langsung dinilai oleh sistem.
        </p>

        <!-- Actions -->
        <div class="flex flex-col sm:flex-row gap-3">
            <button type="button" 
                    id="tb-confirm-cancel-btn"
                    class="w-full sm:w-1/2 py-3 px-4 rounded-xl border border-gray-300 text-gray-700 font-semibold text-sm hover:bg-gray-50 active:bg-gray-100 transition-colors focus:outline-none focus:ring-2 focus:ring-gray-300">
                Periksa Kembali
            </button>
            <button type="button" 
                    id="tb-confirm-submit-btn"
                    class="w-full sm:w-1/2 py-3 px-4 rounded-xl bg-blue-600 hover:bg-blue-700 active:bg-blue-800 text-white font-bold text-sm shadow-md hover:shadow-lg transition-all flex items-center justify-center gap-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                <span>Ya, Kirim Sekarang</span>
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                </svg>
            </button>
        </div>

    </div>
</div>

<script>
(function() {
    let pendingForm = null;
    let firstEmptyInput = null;

    function getModalElements() {
        return {
            modal: document.getElementById('tb-submit-confirm-modal'),
            card: document.getElementById('tb-submit-confirm-card'),
            badge: document.getElementById('tb-confirm-summary-badge'),
            desc: document.getElementById('tb-confirm-description'),
            cancelBtn: document.getElementById('tb-confirm-cancel-btn'),
            submitBtn: document.getElementById('tb-confirm-submit-btn')
        };
    }

    function openModal(form) {
        pendingForm = form;
        const els = getModalElements();
        if (!els.modal || !els.card) return;

        // Count questions in this form
        const inputs = Array.from(form.querySelectorAll('input[type="text"]:not([readonly]):not([disabled]), textarea:not([readonly]):not([disabled])'))
            .filter(el => el.name && !el.name.startsWith('_') && el.type !== 'hidden');

        const totalCount = inputs.length;
        const filledInputs = inputs.filter(el => el.value && el.value.trim().length > 0);
        const filledCount = filledInputs.length;
        const emptyCount = totalCount - filledCount;

        firstEmptyInput = inputs.find(el => !el.value || el.value.trim().length === 0) || null;

        if (totalCount > 0) {
            if (emptyCount === 0) {
                els.badge.className = 'my-3 px-4 py-2.5 rounded-xl text-sm font-medium bg-emerald-50 text-emerald-800 border border-emerald-200 flex items-center justify-center gap-2';
                els.badge.innerHTML = `<svg class="w-5 h-5 text-emerald-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg> <span><strong>Semua ${totalCount} soal</strong> telah diisi lengkap.</span>`;
                els.desc.textContent = 'Semua jawaban sudah terisi. Apakah kamu siap untuk mengirim dan melihat hasil nilaimu?';
            } else {
                els.badge.className = 'my-3 px-4 py-2.5 rounded-xl text-sm font-medium bg-amber-50 text-amber-800 border border-amber-200 flex items-center justify-center gap-2 text-left sm:text-center';
                els.badge.innerHTML = `<svg class="w-5 h-5 text-amber-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg> <span>Masih ada <strong>${emptyCount} dari ${totalCount} soal</strong> yang belum diisi.</span>`;
                els.desc.textContent = 'Kamu masih memiliki soal yang belum terisi. Kamu tetap bisa mengirimnya sekarang, atau periksa kembali sebelum dinilai.';
            }
            els.badge.style.display = 'flex';
        } else {
            els.badge.style.display = 'none';
            els.desc.textContent = 'Apakah kamu yakin ingin memeriksa dan mengirim semua jawaban sekarang? Setelah dikirim, jawaban akan langsung dinilai.';
        }

        // Reset submit button state
        els.submitBtn.disabled = false;
        els.submitBtn.innerHTML = `<span>Ya, Kirim Sekarang</span><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>`;

        // Show modal with animation
        els.modal.style.display = 'flex';
        requestAnimationFrame(() => {
            els.modal.classList.remove('opacity-0', 'pointer-events-none');
            els.card.classList.remove('scale-95', 'opacity-0');
            els.card.classList.add('scale-100', 'opacity-100');
        });
    }

    function closeModal() {
        const els = getModalElements();
        if (!els.modal || !els.card) return;

        els.modal.classList.add('opacity-0', 'pointer-events-none');
        els.card.classList.remove('scale-100', 'opacity-100');
        els.card.classList.add('scale-95', 'opacity-0');

        setTimeout(() => {
            els.modal.style.display = 'none';
        }, 250);

        pendingForm = null;
    }

    function initConfirmationHandler() {
        const els = getModalElements();
        if (!els.modal) return;

        // Cancel button
        if (els.cancelBtn) {
            els.cancelBtn.onclick = function() {
                const targetToFocus = firstEmptyInput;
                closeModal();
                if (targetToFocus) {
                    setTimeout(() => {
                        targetToFocus.scrollIntoView({ behavior: 'smooth', block: 'center' });
                        targetToFocus.focus();
                    }, 300);
                }
            };
        }

        // Click outside modal card to cancel
        els.modal.onclick = function(e) {
            if (e.target === els.modal) {
                closeModal();
            }
        };

        // ESC key to close
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape' && els.modal.style.display === 'flex') {
                closeModal();
            }
        });

        // Confirm Submit button
        if (els.submitBtn) {
            els.submitBtn.onclick = function() {
                if (!pendingForm) return;

                els.submitBtn.disabled = true;
                els.submitBtn.innerHTML = `<svg class="w-4 h-4 animate-spin" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg> <span>Memproses...</span>`;

                if (window.AutoSave && typeof window.AutoSave.saveAnswers === 'function') {
                    try { window.AutoSave.saveAnswers(); } catch(err) {}
                }

                pendingForm.dataset.tbConfirmed = 'true';
                HTMLFormElement.prototype.submit.call(pendingForm);
            };
        }

        // Global form submit interceptor
        document.addEventListener('submit', function(e) {
            const form = e.target;
            if (!form || !(form instanceof HTMLFormElement)) return;

            // Do not intercept if already confirmed
            if (form.dataset.tbConfirmed === 'true') return;

            // Do not intercept reset or try-again forms
            const action = (form.getAttribute('action') || '').toLowerCase();
            if (action.includes('.reset') || action.includes('/reset')) return;

            // Check if form is an assignment answer form
            const formId = (form.id || '').toLowerCase();
            const submitBtn = form.querySelector('button[type="submit"], input[type="submit"]');
            const submitText = submitBtn ? (submitBtn.innerText || submitBtn.value || '').toLowerCase() : '';

            const isAnswerForm = formId.includes('answer') || 
                                 formId.includes('meeting') ||
                                 action.includes('.submit') ||
                                 action.includes('/submit') ||
                                 submitText.includes('cek') ||
                                 submitText.includes('periksa') ||
                                 submitText.includes('kirim');

            const isResetButton = submitText.includes('ulang') || submitText.includes('coba lagi') || submitText.includes('reset');

            if (isAnswerForm && !isResetButton) {
                // If inputs are already readonly (submitted state), allow standard behavior
                const hasEditableInputs = form.querySelector('input[type="text"]:not([readonly]):not([disabled]), textarea:not([readonly]):not([disabled])');
                if (!hasEditableInputs) return;

                e.preventDefault();
                e.stopImmediatePropagation();
                openModal(form);
            }
        }, true);
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initConfirmationHandler);
    } else {
        initConfirmationHandler();
    }
})();
</script>
@endonce