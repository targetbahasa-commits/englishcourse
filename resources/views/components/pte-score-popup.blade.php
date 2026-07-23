<!-- PTE-style score report popup. Include once near the end of a practice.blade.php body,
     then call PTEScorePopup.show({ skill: 'Speaking'|'Writing'|'Listening'|'Reading', score: <raw>, max: <raw>, breakdown: {...}, feedback: '...' }) -->
<div id="pteScorePopupOverlay" class="hidden" style="position:fixed;inset:0;z-index:9999;background:rgba(17,24,39,0.55);display:none;align-items:center;justify-content:center;padding:16px;">
    <div style="background:#fff;border-radius:16px;max-width:420px;width:100%;max-height:90vh;overflow-y:auto;box-shadow:0 20px 50px rgba(0,0,0,0.25);">
        <div style="background:linear-gradient(135deg,#00c5b5,#0891b2);padding:16px 20px;display:flex;align-items:center;justify-content:space-between;">
            <div style="color:#fff;font-weight:700;font-size:15px;" id="pteScorePopupTitle">PTE Academic Practice &middot; Score Report</div>
            <button onclick="PTEScorePopup.hide()" style="background:transparent;border:none;color:#fff;font-size:20px;line-height:1;cursor:pointer;padding:0 4px;">&times;</button>
        </div>
        <div style="padding:24px 20px;text-align:center;">
            <div id="pteScorePopupCircle" style="width:100px;height:100px;border-radius:50%;border:6px solid #e5e7eb;display:flex;align-items:center;justify-content:center;margin:0 auto 12px;">
                <span id="pteScorePopupNumber" style="font-size:34px;font-weight:800;color:#111827;">--</span>
            </div>
            <div id="pteScorePopupSkill" style="font-weight:700;font-size:16px;color:#111827;margin-bottom:2px;">Listening</div>
            <div style="font-size:12px;color:#6b7280;margin-bottom:16px;">Estimated PTE Score (10&ndash;90 scale)</div>

            {{-- Standard Progress Bar --}}
            <div id="pteScorePopupStandardBar" style="background:#f9fafb;border-radius:10px;padding:12px 16px;margin-bottom:16px;">
                <div style="display:flex;justify-content:space-between;font-size:13px;color:#374151;margin-bottom:6px;">
                    <span id="pteScorePopupSkillLabel">Listening</span>
                    <span id="pteScorePopupRaw">0 / 0</span>
                </div>
                <div style="height:8px;background:#e5e7eb;border-radius:4px;overflow:hidden;">
                    <div id="pteScorePopupBar" style="height:100%;width:0%;border-radius:4px;transition:width 0.6s ease;"></div>
                </div>
            </div>

            {{-- Detailed Breakdown Container --}}
            <div id="pteScorePopupBreakdown" style="display:none;background:#f8fafc;border-radius:12px;padding:14px 16px;margin-bottom:16px;border:1px solid #e2e8f0;text-align:left;">
                <div style="font-weight:700;font-size:12px;color:#475569;text-transform:uppercase;letter-spacing:0.05em;margin-bottom:8px;">Evaluasi AI Detail</div>
                <div id="pteScorePopupBreakdownItems" style="display:flex;flex-direction:column;gap:6px;font-size:13px;"></div>
                <div id="pteScorePopupFeedbackContainer" style="margin-top:10px;padding-top:10px;border-top:1px solid #e2e8f0;font-size:12px;color:#475569;display:none;">
                    <span style="font-weight:700;color:#1e293b;">Catatan AI / Feedback:</span>
                    <p id="pteScorePopupFeedback" style="margin-top:4px;font-style:italic;line-height:1.5;color:#334155;"></p>
                </div>
            </div>

            <button onclick="PTEScorePopup.hide()" style="background:#111827;color:#fff;font-weight:600;font-size:14px;padding:10px 28px;border:none;border-radius:9999px;cursor:pointer;">Close</button>
        </div>
    </div>
</div>

<script>
    window.PTEScorePopup = (function() {
        const SKILL_COLORS = {
            Listening: '#1e3a5f',
            Reading: '#9caf00',
            Speaking: '#ea580c',
            Writing: '#a3227e',
        };

        function computeScaledScore(score, max) {
            if (!max || max <= 0) return 10;
            let ratio = Math.max(0, Math.min(1, score / max));
            return Math.round(10 + ratio * 80);
        }

        function show(opts) {
            const skill = opts.skill || 'Listening';
            const score = Math.max(0, opts.score || 0);
            const max = Math.max(1, opts.max || 1);
            const scaled = (max === 90) ? score : computeScaledScore(score, max);
            const color = SKILL_COLORS[skill] || '#00c5b5';

            document.getElementById('pteScorePopupNumber').textContent = scaled;
            document.getElementById('pteScorePopupCircle').style.borderColor = color;
            document.getElementById('pteScorePopupNumber').style.color = color;
            document.getElementById('pteScorePopupSkill').textContent = skill;
            document.getElementById('pteScorePopupSkillLabel').textContent = skill;
            document.getElementById('pteScorePopupRaw').textContent = score + ' / ' + max + (max === 90 ? ' points' : ' correct');
            document.getElementById('pteScorePopupBar').style.width = Math.round((score / max) * 100) + '%';
            document.getElementById('pteScorePopupBar').style.background = color;

            // Breakdown
            const bdContainer = document.getElementById('pteScorePopupBreakdown');
            const bdItems = document.getElementById('pteScorePopupBreakdownItems');
            const fbContainer = document.getElementById('pteScorePopupFeedbackContainer');
            const fbText = document.getElementById('pteScorePopupFeedback');

            if (opts.breakdown && typeof opts.breakdown === 'object') {
                bdItems.innerHTML = '';
                for (const [key, val] of Object.entries(opts.breakdown)) {
                    const label = key.replace(/_/g, ' ').replace(/\b\w/g, l => l.toUpperCase());
                    const item = document.createElement('div');
                    item.style.cssText = 'display:flex;justify-content:space-between;align-items:center;color:#334155;';
                    item.innerHTML = `<span>${label}</span><span style="font-weight:700;color:#0f172a;">${val} / 90</span>`;
                    bdItems.appendChild(item);
                }
                bdContainer.style.display = 'block';

                if (opts.feedback) {
                    fbText.textContent = opts.feedback;
                    fbContainer.style.display = 'block';
                } else {
                    fbContainer.style.display = 'none';
                }
            } else {
                bdContainer.style.display = 'none';
            }

            const overlay = document.getElementById('pteScorePopupOverlay');
            overlay.style.display = 'flex';
            overlay.classList.remove('hidden');
        }

        function hide() {
            const overlay = document.getElementById('pteScorePopupOverlay');
            overlay.style.display = 'none';
            overlay.classList.add('hidden');
        }

        return { show, hide, computeScaledScore };
    })();
</script>
