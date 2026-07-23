(function () {
    function checkRules(value) {
        return {
            length: value.length >= 8,
            uppercase: /[A-Z]/.test(value),
            number: /[0-9]/.test(value),
            symbol: /[^A-Za-z0-9]/.test(value)
        };
    }

    function applyToUi(res) {
        const items = document.querySelectorAll('.rule-item');
        const icons = document.querySelectorAll('.rule-icon');
        if (!items.length || !icons.length) return;
        const checks = [res.length, res.uppercase, res.number, res.symbol];
        checks.forEach((ok, i) => {
            items[i].classList.toggle('text-green-600', !!ok);
            icons[i].textContent = ok ? '✓' : '•';
            icons[i].classList.toggle('text-green-600', !!ok);
        });
    }

    function findPasswordInput() {
        return document.querySelector('input#password') || document.querySelector('input[name="password"]') || Array.from(document.querySelectorAll('input[type="password"]')).find(el => el.offsetParent !== null);
    }

    document.addEventListener('DOMContentLoaded', function () {
        const pwd = findPasswordInput();
        if (!pwd) return;

        // initial state
        applyToUi(checkRules(pwd.value || ''));

        pwd.addEventListener('input', function (e) {
            applyToUi(checkRules(e.target.value || ''));
        });

        const form = pwd.closest('form');
        if (form) {
            form.addEventListener('submit', function (e) {
                if (pwd.value === '' && !pwd.required) {
                    return; // Skip validation if empty and not required (e.g. updating profile)
                }
                
                const res = checkRules(pwd.value || '');
                if (!res.length || !res.number) {
                    e.preventDefault();
                    pwd.focus();
                    alert('Password harus memenuhi aturan: minimal 8 karakter dan mengandung angka.');
                }
            });
        }
    });
})();
