<div class="mt-3 rounded-lg border border-gray-100 bg-white p-4 text-sm text-gray-600">
    <div class="font-semibold text-gray-800 mb-2 flex items-center">
        <span>Aturan pembuatan password</span>
        <span class="ml-2 text-xs text-gray-400" title="Minimal 8 karakter, harus mengandung huruf kapital dan angka. Simbol disarankan.">?</span>
    </div>
    <ul class="space-y-1">
        <li :class="(form && form.password && form.password.length >= 8) ? 'text-green-600' : 'text-gray-500'" class="flex items-center gap-2 rule-item"><span x-text="(form && form.password && form.password.length >= 8) ? '✓' : '•'" class="w-5 inline-block text-sm rule-icon">•</span> Minimal 8 karakter</li>
        <li :class="(form && /[A-Z]/.test(form.password)) ? 'text-green-600' : 'text-gray-500'" class="flex items-center gap-2 rule-item"><span x-text="(form && /[A-Z]/.test(form.password)) ? '✓' : '•'" class="w-5 inline-block text-sm rule-icon">•</span> Mengandung huruf kapital (A-Z)</li>
        <li :class="(form && /[0-9]/.test(form.password)) ? 'text-green-600' : 'text-gray-500'" class="flex items-center gap-2 rule-item"><span x-text="(form && /[0-9]/.test(form.password)) ? '✓' : '•'" class="w-5 inline-block text-sm rule-icon">•</span> Mengandung angka (0-9)</li>
        <li :class="(form && /[^A-Za-z0-9]/.test(form.password)) ? 'text-green-600' : 'text-gray-500'" class="flex items-center gap-2 rule-item"><span x-text="(form && /[^A-Za-z0-9]/.test(form.password)) ? '✓' : '•'" class="w-5 inline-block text-sm rule-icon">•</span> Disarankan memasukkan simbol (mis. !@#)</li>
    </ul>
</div>
