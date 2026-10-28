<?php

namespace App\Services;

class SelfStudyFormulaRenderer
{
    /**
     * Render any sub-lesson formula into a high-contrast, emoji-free, rich HTML card.
     *
     * @param array $sl Sub-lesson array containing formula, name, rules, exercises, etc.
     * @return string Safe HTML string ready for unescaped output {!! !!}
     */
    public static function render(array $sl): string
    {
        $rawFormula = trim((string)($sl['formula'] ?? ''));
        if ($rawFormula === '') {
            return '';
        }

        // Strip disruptive emojis from raw formula
        $cleaned = self::cleanEmojis($rawFormula);

        // If it is already rich HTML crafted with custom layout,
        // ensure color brightness and return directly
        if (str_starts_with(trim($cleaned), '<div') || str_contains($cleaned, 'class="space-y')) {
            return self::normalizeHtmlColors($cleaned);
        }

        // Dynamically build the rich card layout from plain text formula, exercises, and rules
        return self::buildCardHtml($sl, $cleaned);
    }

    /**
     * Build rich HTML card for plain text formula
     */
    public static function buildCardHtml(array $sl, string $formula): string
    {
        $name = trim((string)($sl['name'] ?? ''));
        $conceptTitle = trim((string)($sl['concept_title'] ?? ''));

        // Derive badge and title
        $badgeText = 'POLA SINTAKSIS';
        $titleText = $conceptTitle ?: $name;

        if (str_contains($name, ':')) {
            $parts = explode(':', $name, 2);
            $prefix = strtoupper(trim($parts[0]));
            if (strlen($prefix) <= 45) {
                $badgeText = $prefix;
                $titleText = trim($parts[1]);
            }
        }

        // Resolve Example (English & Indonesian)
        $enSentence = '';
        $idSentence = '';
        if (!empty($sl['exercises'][0])) {
            $ex0 = $sl['exercises'][0];
            $idSentence = $ex0['id_sentence'] ?? '';
            if (isset($ex0['correct_index']) && isset($ex0['options'][$ex0['correct_index']])) {
                $enSentence = $ex0['options'][$ex0['correct_index']];
            } elseif (!empty($ex0['correct'])) {
                $enSentence = $ex0['correct'];
            }
        } elseif (!empty($sl['example']['en'])) {
            $enSentence = $sl['example']['en'];
            $idSentence = $sl['example']['id'] ?? '';
        }

        // Resolve Key Rule
        $keyRule = '';
        if (!empty($sl['rules']) && is_array($sl['rules'])) {
            $keyRule = self::cleanEmojis(trim((string)$sl['rules'][0]));
        }

        // Build Formula Blocks
        $formulaHtml = self::formatFormulaBlocks($formula);

        // Build Example HTML
        $exampleHtml = '';
        if ($enSentence !== '') {
            $exampleHtml .= '<div class="text-xs sm:text-sm text-white font-mono pt-0.5">';
            $exampleHtml .= '<span class="text-emerald-400 font-bold not-italic">Contoh:</span> <span class="italic text-white">' . htmlspecialchars($enSentence, ENT_QUOTES, 'UTF-8') . '</span>';
            $exampleHtml .= '</div>';

            if ($idSentence !== '') {
                $exampleHtml .= '<div class="text-xs text-white pl-3 border-l-2 border-emerald-400">';
                $exampleHtml .= '(' . htmlspecialchars($idSentence, ENT_QUOTES, 'UTF-8') . ')';
                $exampleHtml .= '</div>';
            }
        }

        // Build Rule HTML
        $ruleHtml = '';
        if ($keyRule !== '') {
            $ruleHtml .= '<div class="text-xs text-white pl-3 border-l-2 border-amber-400 bg-amber-950/40 p-2.5 rounded-r-lg">';
            $ruleHtml .= '<strong class="text-amber-300 uppercase">[KAIDAH UTAMA]:</strong> ' . htmlspecialchars($keyRule, ENT_QUOTES, 'UTF-8');
            $ruleHtml .= '</div>';
        }

        // Assemble Final Outer Container
        $html = '<div class="space-y-3 text-left">';
        
        // Header
        $html .= '<div class="flex items-center gap-2 pb-2 border-b border-emerald-500/40 flex-wrap">';
        $html .= '<span class="px-2 py-0.5 rounded text-[11px] font-black bg-emerald-500/25 text-emerald-300 border border-emerald-500/50 font-mono tracking-wider">' . htmlspecialchars($badgeText, ENT_QUOTES, 'UTF-8') . '</span>';
        $html .= '<span class="text-xs sm:text-sm font-extrabold text-white">' . htmlspecialchars($titleText, ENT_QUOTES, 'UTF-8') . '</span>';
        $html .= '</div>';

        // Formula & Example Card
        $html .= '<div class="rounded-xl bg-slate-900/90 p-3 border border-slate-600 space-y-2.5">';
        $html .= $formulaHtml;
        $html .= $exampleHtml;
        $html .= '</div>';

        // Rule Note (if available)
        if ($ruleHtml !== '') {
            $html .= $ruleHtml;
        }

        $html .= '</div>';

        return $html;
    }

    /**
     * Parse and format formula strings (handles single formula or multi-part pipes)
     */
    protected static function formatFormulaBlocks(string $formula): string
    {
        // Check if formula has pipe separated clauses or multiple distinct statements
        if (str_contains($formula, '|') || str_contains($formula, ' vs ')) {
            $separator = str_contains($formula, '|') ? '|' : ' vs ';
            $chunks = array_map('trim', explode($separator, $formula));
            $out = '<div class="space-y-2">';
            foreach ($chunks as $idx => $chunk) {
                if ($chunk === '') continue;

                if (preg_match('/^BENAR\s*:\s*(.*)/i', $chunk, $m)) {
                    $out .= '<div class="flex items-start gap-2 flex-wrap">';
                    $out .= '<span class="px-2 py-0.5 rounded text-[10px] font-black bg-emerald-500/30 text-emerald-300 border border-emerald-500/50 uppercase shrink-0 font-mono">[BENAR]</span>';
                    $out .= '<code class="text-xs font-mono font-bold text-emerald-300 bg-slate-950 px-2.5 py-1 rounded border border-emerald-500/40 block flex-1 break-words">' . htmlspecialchars($m[1], ENT_QUOTES, 'UTF-8') . '</code>';
                    $out .= '</div>';
                } elseif (preg_match('/^(SALAH|SALAH MUTLAK|LARANGAN|DILARANG)\s*:\s*(.*)/i', $chunk, $m)) {
                    $out .= '<div class="flex items-start gap-2 flex-wrap">';
                    $out .= '<span class="px-2 py-0.5 rounded text-[10px] font-black bg-rose-500/30 text-rose-300 border border-rose-500/50 uppercase shrink-0 font-mono">[SALAH MUTLAK]</span>';
                    $out .= '<code class="text-xs font-mono font-bold text-rose-300 bg-slate-950 px-2.5 py-1 rounded border border-rose-500/40 block flex-1 break-words line-through">' . htmlspecialchars($m[2], ENT_QUOTES, 'UTF-8') . '</code>';
                    $out .= '</div>';
                } elseif (preg_match('/^Verbal\s*:\s*(.*)/i', $chunk, $m)) {
                    $out .= '<div class="space-y-1">';
                    $out .= '<div class="flex items-center gap-1.5"><span class="w-2 h-2 rounded-full bg-amber-400"></span><span class="text-xs font-black text-amber-300 uppercase tracking-wide">[' . ($idx + 1) . '] POLA VERBAL</span></div>';
                    $out .= '<code class="text-xs font-mono font-bold text-amber-300 bg-slate-950 px-2.5 py-1.5 rounded border border-amber-500/40 block break-words">' . htmlspecialchars($m[1], ENT_QUOTES, 'UTF-8') . '</code>';
                    $out .= '</div>';
                } elseif (preg_match('/^Nominal\s*:\s*(.*)/i', $chunk, $m)) {
                    $out .= '<div class="space-y-1">';
                    $out .= '<div class="flex items-center gap-1.5"><span class="w-2 h-2 rounded-full bg-sky-400"></span><span class="text-xs font-black text-sky-300 uppercase tracking-wide">[' . ($idx + 1) . '] POLA NOMINAL</span></div>';
                    $out .= '<code class="text-xs font-mono font-bold text-sky-300 bg-slate-950 px-2.5 py-1.5 rounded border border-sky-500/40 block break-words">' . htmlspecialchars($m[1], ENT_QUOTES, 'UTF-8') . '</code>';
                    $out .= '</div>';
                } elseif (preg_match('/^(Passive|Pasif)\s*:\s*(.*)/i', $chunk, $m)) {
                    $out .= '<div class="space-y-1">';
                    $out .= '<div class="flex items-center gap-1.5"><span class="w-2 h-2 rounded-full bg-emerald-400"></span><span class="text-xs font-black text-emerald-300 uppercase tracking-wide">[' . ($idx + 1) . '] POLA PASIF</span></div>';
                    $out .= '<code class="text-xs font-mono font-bold text-emerald-300 bg-slate-950 px-2.5 py-1.5 rounded border border-emerald-500/40 block break-words">' . htmlspecialchars($m[2], ENT_QUOTES, 'UTF-8') . '</code>';
                    $out .= '</div>';
                } elseif (preg_match('/^Negatif\s*:\s*(.*)/i', $chunk, $m)) {
                    $out .= '<div class="space-y-1">';
                    $out .= '<div class="flex items-center gap-1.5"><span class="w-2 h-2 rounded-full bg-rose-400"></span><span class="text-xs font-black text-rose-300 uppercase tracking-wide">[' . ($idx + 1) . '] BENTUK NEGATIF</span></div>';
                    $out .= '<code class="text-xs font-mono font-bold text-rose-300 bg-slate-950 px-2.5 py-1.5 rounded border border-rose-500/40 block break-words">' . htmlspecialchars($m[1], ENT_QUOTES, 'UTF-8') . '</code>';
                    $out .= '</div>';
                } elseif (preg_match('/^(Tanya|Interogatif)\s*:\s*(.*)/i', $chunk, $m)) {
                    $out .= '<div class="space-y-1">';
                    $out .= '<div class="flex items-center gap-1.5"><span class="w-2 h-2 rounded-full bg-sky-400"></span><span class="text-xs font-black text-sky-300 uppercase tracking-wide">[' . ($idx + 1) . '] BENTUK INTEROGATIF (TANYA)</span></div>';
                    $out .= '<code class="text-xs font-mono font-bold text-sky-300 bg-slate-950 px-2.5 py-1.5 rounded border border-sky-500/40 block break-words">' . htmlspecialchars($m[2], ENT_QUOTES, 'UTF-8') . '</code>';
                    $out .= '</div>';
                } else {
                    $out .= '<div><code class="text-xs font-mono font-bold text-emerald-300 bg-slate-950 px-2.5 py-1.5 rounded border border-emerald-500/40 block break-words">' . htmlspecialchars($chunk, ENT_QUOTES, 'UTF-8') . '</code></div>';
                }
            }
            $out .= '</div>';
            return $out;
        }

        // Single formula
        return '<div class="space-y-1.5">' .
               '<div class="flex items-center justify-between gap-2 flex-wrap">' .
               '<span class="text-xs font-black text-amber-300 uppercase tracking-wide">Rumus Dasar:</span>' .
               '</div>' .
               '<code class="text-xs sm:text-sm font-mono font-bold text-emerald-300 bg-slate-950 px-3 py-2 rounded-lg border border-emerald-500/40 block w-full break-words leading-relaxed">' .
               htmlspecialchars($formula, ENT_QUOTES, 'UTF-8') .
               '</code>' .
               '</div>';
    }

    /**
     * Remove emojis and replace known alert markers with clean text badges
     */
    public static function cleanEmojis(string $text): string
    {
        // Replace common warning emojis with text tags
        $replacements = [
            '⛔ LARANGAN FATAL:' => '[LARANGAN FATAL]:',
            '⛔' => '[PERHATIAN]',
            '⚠️ PERHATIAN:' => '[PERHATIAN]:',
            '⚠️' => '[PERHATIAN]',
            '🚫' => '[DILARANG]',
            '⚖️' => '[ATURAN]',
            '📌' => '[CATATAN]',
            '💡' => '[TIPS]',
            '🔥' => '',
            '✅' => '✓ Benar:',
            '❌' => '✗ Salah:',
        ];
        $text = str_replace(array_keys($replacements), array_values($replacements), $text);

        // Strip remaining unicode emojis
        $pattern = '/[\x{1F600}-\x{1F64F}\x{1F300}-\x{1F5FF}\x{1F680}-\x{1F6FF}\x{2600}-\x{26FF}\x{2700}-\x{27BF}\x{1F900}-\x{1F9FF}\x{1F1E0}-\x{1F1FF}]/u';
        $cleaned = preg_replace($pattern, '', $text);

        return trim($cleaned ?? $text);
    }

    /**
     * Replace any dark/muted text colors with high-contrast bright text
     */
    public static function normalizeHtmlColors(string $html): string
    {
        // Replace dark/dim text classes that are hard to read on dark backgrounds
        $dimClasses = [
            'text-slate-400' => 'text-white',
            'text-slate-500' => 'text-slate-200',
            'text-gray-400' => 'text-white',
            'text-gray-500' => 'text-gray-200',
            'text-neutral-400' => 'text-white',
            'text-zinc-400' => 'text-white',
        ];

        return str_replace(array_keys($dimClasses), array_values($dimClasses), $html);
    }
}
