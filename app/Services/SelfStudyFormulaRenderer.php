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

        // Resolve Examples (Categorized: Statement, Yes/No Question, WH- Question)
        $statementEx = null;
        $yesNoEx = null;
        $whEx = null;

        if (!empty($sl['exercises']) && is_array($sl['exercises'])) {
            foreach ($sl['exercises'] as $ex) {
                $id = $ex['id_sentence'] ?? '';
                $en = '';
                if (isset($ex['correct_index']) && isset($ex['options'][$ex['correct_index']])) {
                    $en = $ex['options'][$ex['correct_index']];
                } elseif (!empty($ex['correct'])) {
                    $en = $ex['correct'];
                }
                if ($en === '') continue;

                $trimmedEn = trim($en);
                $isQuestion = str_ends_with($trimmedEn, '?');

                if ($isQuestion) {
                    if (preg_match('/^(what|where|when|why|how|which|who|whom|whose|to what|under what)\b/i', $trimmedEn)) {
                        if ($whEx === null) $whEx = ['en' => $trimmedEn, 'id' => $id];
                    } else {
                        if ($yesNoEx === null) $yesNoEx = ['en' => $trimmedEn, 'id' => $id];
                    }
                } else {
                    if ($statementEx === null) $statementEx = ['en' => $trimmedEn, 'id' => $id];
                }

                if ($statementEx && $yesNoEx && $whEx) break;
            }
        } elseif (!empty($sl['example']['en'])) {
            $statementEx = [
                'en' => trim($sl['example']['en']),
                'id' => trim($sl['example']['id'] ?? '')
            ];
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
        $formulaLower = strtolower($name . ' ' . $conceptTitle . ' ' . $formula);
        $hasQuestionInPola = str_contains($formulaLower, 'tanya') ||
                             str_contains($formulaLower, 'interogatif') ||
                             str_contains($formulaLower, 'question') ||
                             str_contains($formulaLower, 'wh-') ||
                             str_contains($formulaLower, 'yes/no');

        if ($hasQuestionInPola && ($yesNoEx || $whEx)) {
            // Render statement example if present
            if ($statementEx) {
                $label = str_contains($formulaLower, 'negatif') ? 'Contoh Negatif:' : 'Contoh Kalimat:';
                $color = str_contains($formulaLower, 'negatif') ? 'rose' : 'emerald';
                $exampleHtml .= '<div class="text-xs sm:text-sm text-white font-mono pt-1">';
                $exampleHtml .= '<span class="text-' . $color . '-400 font-bold not-italic">' . $label . '</span> <span class="italic text-white">' . htmlspecialchars($statementEx['en'], ENT_QUOTES, 'UTF-8') . '</span>';
                $exampleHtml .= '</div>';
                if ($statementEx['id']) {
                    $exampleHtml .= '<div class="text-xs text-white pl-3 border-l-2 border-' . $color . '-400">(' . htmlspecialchars($statementEx['id'], ENT_QUOTES, 'UTF-8') . ')</div>';
                }
            }

            // Render Yes/No Question example
            if ($yesNoEx) {
                $exampleHtml .= '<div class="text-xs sm:text-sm text-white font-mono pt-1.5 border-t border-slate-700/60">';
                $exampleHtml .= '<span class="text-sky-400 font-bold not-italic">Contoh Yes/No Question:</span> <span class="italic text-white">' . htmlspecialchars($yesNoEx['en'], ENT_QUOTES, 'UTF-8') . '</span>';
                $exampleHtml .= '</div>';
                if ($yesNoEx['id']) {
                    $exampleHtml .= '<div class="text-xs text-white pl-3 border-l-2 border-sky-400">(' . htmlspecialchars($yesNoEx['id'], ENT_QUOTES, 'UTF-8') . ')</div>';
                }
            }

            // Render WH- Question example
            if ($whEx) {
                $exampleHtml .= '<div class="text-xs sm:text-sm text-white font-mono pt-1.5 border-t border-slate-700/60">';
                $exampleHtml .= '<span class="text-amber-400 font-bold not-italic">Contoh WH- Question:</span> <span class="italic text-white">' . htmlspecialchars($whEx['en'], ENT_QUOTES, 'UTF-8') . '</span>';
                $exampleHtml .= '</div>';
                if ($whEx['id']) {
                    $exampleHtml .= '<div class="text-xs text-white pl-3 border-l-2 border-amber-400">(' . htmlspecialchars($whEx['id'], ENT_QUOTES, 'UTF-8') . ')</div>';
                }
            }
        } else {
            // Standard single primary example
            $primaryEx = $statementEx ?: ($yesNoEx ?: $whEx);
            if ($primaryEx) {
                $exampleHtml .= '<div class="text-xs sm:text-sm text-white font-mono pt-0.5">';
                $exampleHtml .= '<span class="text-emerald-400 font-bold not-italic">Contoh:</span> <span class="italic text-white">' . htmlspecialchars($primaryEx['en'], ENT_QUOTES, 'UTF-8') . '</span>';
                $exampleHtml .= '</div>';

                if ($primaryEx['id'] !== '') {
                    $exampleHtml .= '<div class="text-xs text-white pl-3 border-l-2 border-emerald-400">';
                    $exampleHtml .= '(' . htmlspecialchars($primaryEx['id'], ENT_QUOTES, 'UTF-8') . ')';
                    $exampleHtml .= '</div>';
                }
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
        // Split only top-level clauses (never inside parentheses or brackets)
        $chunks = self::splitTopLevelClauses($formula);

        if (count($chunks) > 1) {
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
                } elseif (preg_match('/^(Subjek\s*"?I"?|Khusus\s*"?I"?)\s*:\s*(.*)/i', $chunk, $m)) {
                    $out .= '<div class="space-y-1">';
                    $out .= '<div class="flex items-center gap-1.5"><span class="w-2 h-2 rounded-full bg-sky-400"></span><span class="text-xs font-black text-sky-300 uppercase tracking-wide">[' . ($idx + 1) . '] KHUSUS SUBJEK "I" (AM)</span></div>';
                    $out .= '<code class="text-xs font-mono font-bold text-sky-300 bg-slate-950 px-2.5 py-1.5 rounded border border-sky-500/40 block break-words">' . htmlspecialchars($m[2], ENT_QUOTES, 'UTF-8') . '</code>';
                    $out .= '</div>';
                } elseif (preg_match('/^(Subjek\s*Jamak|Subjek\s*You\s*\/\s*We\s*\/\s*They)\s*:\s*(.*)/i', $chunk, $m)) {
                    $out .= '<div class="space-y-1">';
                    $out .= '<div class="flex items-center gap-1.5"><span class="w-2 h-2 rounded-full bg-emerald-400"></span><span class="text-xs font-black text-emerald-300 uppercase tracking-wide">[' . ($idx + 1) . '] SUBJEK YOU, WE, THEY &amp; JAMAK (ARE)</span></div>';
                    $out .= '<code class="text-xs font-mono font-bold text-emerald-300 bg-slate-950 px-2.5 py-1.5 rounded border border-emerald-500/40 block break-words">' . htmlspecialchars($m[2], ENT_QUOTES, 'UTF-8') . '</code>';
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
     * Split string by '|' or ' vs ' only when not nested inside parentheses or brackets
     */
    protected static function splitTopLevelClauses(string $formula): array
    {
        if (str_contains($formula, ' vs ')) {
            return array_map('trim', explode(' vs ', $formula));
        }

        if (!str_contains($formula, '|')) {
            return [trim($formula)];
        }

        $chunks = [];
        $current = '';
        $parenDepth = 0;
        $bracketDepth = 0;
        $len = strlen($formula);

        for ($i = 0; $i < $len; $i++) {
            $char = $formula[$i];

            if ($char === '(') {
                $parenDepth++;
            } elseif ($char === ')') {
                if ($parenDepth > 0) $parenDepth--;
            } elseif ($char === '[') {
                $bracketDepth++;
            } elseif ($char === ']') {
                if ($bracketDepth > 0) $bracketDepth--;
            }

            if ($char === '|' && $parenDepth === 0 && $bracketDepth === 0) {
                $trimmed = trim($current);
                if ($trimmed !== '') {
                    $chunks[] = $trimmed;
                }
                $current = '';
            } else {
                $current .= $char;
            }
        }

        $trimmed = trim($current);
        if ($trimmed !== '') {
            $chunks[] = $trimmed;
        }

        return count($chunks) > 1 ? $chunks : [trim($formula)];
    }

    /**
     * Remove emojis and replace known alert markers with clean text badges
     */
    public static function cleanEmojis(string $text): string
    {
        // Protect mathematical/linguistic arrows before emoji stripping
        $text = str_replace(['➔', '→'], ['__ARROW_R__', '__ARROW_R__'], $text);

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

        // Restore arrows
        $cleaned = str_replace('__ARROW_R__', '➔', $cleaned ?? $text);

        return trim($cleaned);
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
