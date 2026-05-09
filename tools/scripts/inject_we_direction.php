<?php
$file = __DIR__ . '/resources/views/assignments/toefl-itp/mockup.blade.php';
$content = file_get_contents($file);

$weCard = <<<'WECARD'

        {{-- Written Expression Direction Card (between Q15 and Q16) --}}
        <div x-cloak x-show="showWrittenDir" class="bg-white rounded-2xl shadow-lg p-8 md:p-12 max-w-4xl mx-auto border border-gray-200" style="width:100%;">
            <div style="background-color:#d1a82e; border-radius:9999px; padding:10px 28px; margin-bottom:28px; display:inline-block;">
                <h2 style="font-size:1.5rem; font-weight:800; color:#111; margin:0; font-family:'Arial Narrow',Arial,sans-serif;">Written Expression</h2>
            </div>
            <p style="font-size:1.05rem; color:#222; line-height:1.7; margin:0 0 24px 0;">
                <strong style="font-weight:800;">Directions:</strong> In questions 16&ndash;40, each sentence has four underlined words or phrases. The four underlined parts are marked (A), (B), (C) and (D). Identify the <strong style="font-weight:800;">one</strong> underlined word or phrase that must be changed for the sentence to be correct.
            </p>
            <div style="margin-bottom:28px; border:1px solid #e5e7eb; border-radius:12px; padding:20px 24px;">
                <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:14px;">
                    <h4 style="font-size:1rem; font-weight:800; color:#111; margin:0;">Example I</h4>
                    <div style="text-align:center;">
                        <p style="font-weight:800; color:#111; font-size:0.85rem; margin:0 0 6px 0;">Sample Answer</p>
                        <div style="display:flex; align-items:center; gap:5px; justify-content:center;">
                            <div style="width:22px;height:22px;border-radius:50%;background:#dc2626;display:flex;align-items:center;justify-content:center;font-size:0.65rem;font-weight:700;color:#fff;">A</div>
                            <div style="width:22px;height:22px;border-radius:50%;border:2px solid #9ca3af;display:flex;align-items:center;justify-content:center;font-size:0.65rem;font-weight:700;color:#374151;">B</div>
                            <div style="width:22px;height:22px;border-radius:50%;border:2px solid #9ca3af;display:flex;align-items:center;justify-content:center;font-size:0.65rem;font-weight:700;color:#374151;">C</div>
                            <div style="width:22px;height:22px;border-radius:50%;border:2px solid #9ca3af;display:flex;align-items:center;justify-content:center;font-size:0.65rem;font-weight:700;color:#374151;">D</div>
                        </div>
                    </div>
                </div>
                <p style="font-size:1.05rem; line-height:3.2; color:#222; margin:0 0 8px 0;">
                    Guppies are sometimes
                    <span style="display:inline-flex;flex-direction:column;align-items:center;margin:0 4px;vertical-align:top;line-height:1.3;"><span style="border-bottom:2px solid #1f2937;padding:0 3px 1px;">call</span><span style="display:inline-flex;align-items:center;justify-content:center;width:22px;height:22px;border-radius:50%;background:#dc2626;font-size:0.7rem;font-weight:700;color:#fff;margin-top:2px;">A</span></span>
                    rainbow
                    <span style="display:inline-flex;flex-direction:column;align-items:center;margin:0 4px;vertical-align:top;line-height:1.3;"><span style="border-bottom:2px solid #1f2937;padding:0 3px 1px;">fish</span><span style="display:inline-flex;align-items:center;justify-content:center;width:22px;height:22px;border-radius:50%;border:2px solid #9ca3af;font-size:0.7rem;font-weight:700;color:#374151;margin-top:2px;">B</span></span>
                    <span style="display:inline-flex;flex-direction:column;align-items:center;margin:0 4px;vertical-align:top;line-height:1.3;"><span style="border-bottom:2px solid #1f2937;padding:0 3px 1px;">because of</span><span style="display:inline-flex;align-items:center;justify-content:center;width:22px;height:22px;border-radius:50%;border:2px solid #9ca3af;font-size:0.7rem;font-weight:700;color:#374151;margin-top:2px;">C</span></span>
                    the males'
                    <span style="display:inline-flex;flex-direction:column;align-items:center;margin:0 4px;vertical-align:top;line-height:1.3;"><span style="border-bottom:2px solid #1f2937;padding:0 3px 1px;">bright</span><span style="display:inline-flex;align-items:center;justify-content:center;width:22px;height:22px;border-radius:50%;border:2px solid #9ca3af;font-size:0.7rem;font-weight:700;color:#374151;margin-top:2px;">D</span></span>
                    colors.
                </p>
                <p style="font-size:1rem; color:#374151; line-height:1.6; margin:0;">
                    The sentence should read, &ldquo;Guppies are sometimes <em>called</em> rainbow fish because of the males&rsquo; bright colors.&rdquo; Therefore, you should choose (A).
                </p>
            </div>
            <p style="font-size:1.1rem; font-weight:800; color:#d1a82e; text-align:center; margin:0 0 28px 0;">Now begin work on the questions.</p>
            <div style="display:flex; justify-content:space-between; align-items:center; border-top:1px solid #e5e7eb; padding-top:20px;">
                <button type="button" @click="showWrittenDir = false; window.scrollTo(0,0)" class="px-6 py-3 rounded-xl border-2 border-gray-300 text-gray-700 font-bold hover:bg-gray-50 transition flex items-center gap-2 bg-white shadow-sm">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
                    Back to Q15
                </button>
                <button type="button" @click="showWrittenDir = false; currentStructureIndex = 15; window.scrollTo(0,0)" class="px-8 py-3 rounded-xl bg-teal-800 text-white font-bold hover:bg-teal-900 transition shadow-lg flex items-center gap-2">
                    Start Written Expression
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                </button>
            </div>
        </div>
WECARD;

// Find the marker: the </form> that closes the section-2 questions form
// It appears right before "    </div>" that ends the section-2 questions wrapper
// We look for the unique pattern of the @endforeach + </form> + </div> sequence

$marker = "            @endforeach\r\n        </form>\r\n    </div>";
$replacement = "            @endforeach\r\n        </form>\r\n" . $weCard . "\r\n    </div>";

if (strpos($content, $marker) !== false) {
    $newContent = str_replace($marker, $replacement, $content);
    file_put_contents($file, $newContent);
    echo "SUCCESS: Written Expression direction card injected.\n";
} else {
    // Try with LF only
    $marker2 = "            @endforeach\n        </form>\n    </div>";
    if (strpos($content, $marker2) !== false) {
        $replacement2 = "            @endforeach\n        </form>\n" . $weCard . "\n    </div>";
        $newContent = str_replace($marker2, $replacement2, $content);
        file_put_contents($file, $newContent);
        echo "SUCCESS (LF): Written Expression direction card injected.\n";
    } else {
        echo "ERROR: Marker not found. Dumping nearby content...\n";
        // Find @endforeach occurrences
        preg_match_all('/(@endforeach.{0,50}form.{0,50}div)/s', $content, $m);
        print_r($m[0]);
    }
}
