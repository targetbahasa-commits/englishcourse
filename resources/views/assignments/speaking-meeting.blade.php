<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'SchoolHub') }} - {{ $trackData['title'] }} - Meeting {{ $meetingNumber }}</title>
    <link rel="icon" type="image/png" href="{{ asset('images/brand/icon.png') }}">

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800,900&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    {{-- $games arrives as a real view variable from SpeakingAdminController::speakingMeeting()
         (already normalized into a list + filtered for per-student game visibility) --}}
    <script>
        window.speakingMeetingApp = function speakingMeetingApp() {
            return {
                activeTab: 'materi',
                // Which subtopic block is active in the Materi tab and which
                // game is active in the Game Speaking tab - lifted to root
                // scope (rather than tab-local) so switching one can keep
                // the other in sync for meetings with multiple subtopics.
                activeMateriIndex: 0,
                activeGameIndex: 0,
                showAllPartneringEn: false,
                showTranscript: true,
                isPlaying: false,
                speechRate: 1.0,
                availableVoices: [],

                // Global game sub-tab tracking for floating admin dock
                weddingGameTab: 'worksheet',
                kitchenActiveStudent: 'A',
                kitchenShowAnswers: false,
                touristTab: 'map',
                touristSheet: 'sheet_a',
                selectedGroupPreview: null,
                // Generic pair/group slot for any future game mechanic that
                // doesn't have its own bespoke admin bar branch yet - see
                // setGenericSlot() below.
                genericActiveSlot: null,

                init() {
                    this.preloadVoices();
                    if ('speechSynthesis' in window) {
                        window.speechSynthesis.onvoiceschanged = () => {
                            this.preloadVoices();
                        };
                    }
                    window.addEventListener('wedding-tab-updated', (e) => {
                        if (e.detail) this.weddingGameTab = e.detail;
                    });
                    window.addEventListener('kitchen-student-updated', (e) => {
                        if (e.detail) this.kitchenActiveStudent = e.detail;
                    });
                    window.addEventListener('kitchen-answers-updated', (e) => {
                        this.kitchenShowAnswers = !!e.detail;
                    });
                    window.addEventListener('tourist-view-updated', (e) => {
                        if (e.detail) {
                            if (e.detail.tab) this.touristTab = e.detail.tab;
                            if (e.detail.sheet) this.touristSheet = e.detail.sheet;
                        }
                    });
                },

                setWeddingGameTab(tab, groupId = null) {
                    this.weddingGameTab = tab;
                    if (groupId !== null) {
                        this.selectedGroupPreview = (this.selectedGroupPreview === groupId) ? null : groupId;
                    } else {
                        this.selectedGroupPreview = null;
                    }
                    this.activeTab = 'game';
                    window.dispatchEvent(new CustomEvent('set-wedding-tab', { detail: tab }));
                },

                setKitchenGameTab(slot, groupId = null) {
                    this.kitchenActiveStudent = slot;
                    if (groupId !== null) {
                        this.selectedGroupPreview = (this.selectedGroupPreview === groupId) ? null : groupId;
                    } else {
                        this.selectedGroupPreview = null;
                    }
                    this.activeTab = 'game';
                    window.dispatchEvent(new CustomEvent('set-kitchen-student', { detail: slot }));
                },

                toggleKitchenAnswers() {
                    this.kitchenShowAnswers = !this.kitchenShowAnswers;
                    window.dispatchEvent(new CustomEvent('toggle-kitchen-answers', { detail: this.kitchenShowAnswers }));
                },

                setTouristTab(tab, sheet = 'sheet_a', groupId = null) {
                    this.touristTab = tab;
                    if (sheet) this.touristSheet = sheet;
                    if (groupId !== null) {
                        this.selectedGroupPreview = (this.selectedGroupPreview === groupId) ? null : groupId;
                    } else {
                        this.selectedGroupPreview = null;
                    }
                    this.activeTab = 'game';
                    window.dispatchEvent(new CustomEvent('set-tourist-view', { detail: { tab, sheet: this.touristSheet } }));
                },

                /**
                 * Generic pair/group slot switcher for any game mechanic
                 * without its own bespoke admin bar branch (wedding_photos,
                 * how_many_kitchen and tourist_in_town each have their own
                 * setXxxTab() above since their worksheet content needs
                 * mechanic-specific state). A future mechanic can listen for
                 * 'generic-slot-updated' the same way the existing branches
                 * listen for their own set-*-tab events.
                 */
                setGenericSlot(slot, groupId = null) {
                    this.genericActiveSlot = slot;
                    if (groupId !== null) {
                        this.selectedGroupPreview = (this.selectedGroupPreview === groupId) ? null : groupId;
                    } else {
                        this.selectedGroupPreview = null;
                    }
                    this.activeTab = 'game';
                    window.dispatchEvent(new CustomEvent('generic-slot-updated', { detail: slot }));
                },

                preloadVoices() {
                    if (!('speechSynthesis' in window)) return;
                    const v = window.speechSynthesis.getVoices();
                    if (v && v.length > 0) {
                        this.availableVoices = v;
                    }
                },

                getBestVoice(gender = 'male') {
                    const voices = this.availableVoices.length > 0 ? this.availableVoices : (('speechSynthesis' in window) ? window.speechSynthesis.getVoices() : []);
                    if (!voices || voices.length === 0) return null;

                    const maleIdentifiers = [
                        'google uk english male',
                        'guy',
                        'daniel',
                        'david',
                        'christopher',
                        'eric',
                        'george',
                        'oliver',
                        'tom',
                        'james',
                        'alex',
                        'rishi',
                        'arthur',
                        'mark',
                        'richard',
                        'fred'
                    ];

                    const femaleIdentifiers = [
                        'google us english',
                        'google uk english female',
                        'jenny',
                        'samantha',
                        'ava',
                        'aria',
                        'karen',
                        'moira',
                        'victoria',
                        'serena',
                        'kate',
                        'siri'
                    ];

                    if (gender === 'male') {
                        // 1. Check for specific male voice names
                        for (const name of maleIdentifiers) {
                            const found = voices.find(v => v.name.toLowerCase().includes(name) && (v.lang.startsWith('en-US') || v.lang.startsWith('en-GB') || v.lang.startsWith('en')));
                            if (found) return found;
                        }
                        // 2. Check if voice name doesn't contain female names and is en
                        const nonFemale = voices.find(v => v.lang.startsWith('en') && !femaleIdentifiers.some(fn => v.name.toLowerCase().includes(fn)));
                        if (nonFemale) return nonFemale;
                    } else {
                        // Female voice lookup
                        for (const name of femaleIdentifiers) {
                            const found = voices.find(v => v.name.toLowerCase().includes(name) && (v.lang.startsWith('en-US') || v.lang.startsWith('en-GB') || v.lang.startsWith('en')));
                            if (found) return found;
                        }
                    }

                    // Fallback to standard English
                    return voices.find(v => v.lang.startsWith('en-US') || v.lang.startsWith('en-GB') || v.lang.startsWith('en')) || null;
                },

                stopAllAudio() {
                    if ('speechSynthesis' in window) {
                        window.speechSynthesis.cancel();
                    }
                    this.isPlaying = false;
                },

                setSpeed(speed) {
                    this.speechRate = speed;
                    this.stopAllAudio();
                },

                prepareSpeechText(text) {
                    if (!text) return '';
                    let clean = text.replace(/\[.*?\]/g, '').replace(/["“”]/g, '').trim();

                    // Convert any letter spelling pattern like "W. R. I. G. H. T" or "W.R.I.G.H.T" or "W-R-I-G-H-T"
                    // into comma-separated letters: "W, R, I, G, H, T." so the browser speech engine pauses on every single letter!
                    clean = clean.replace(/\b([A-Za-z](?:[\.\-\s]+[A-Za-z])+)\b/g, (match) => {
                        // Skip common 2-letter English words like "is", "in", "to", "on", "at", "it", "he", "we", "as", "an", "am", "or", "by", "my", "me", "do", "go", "so", "no", "up", "if"
                        const letters = match.replace(/[^A-Za-z]/g, '');
                        if (match.includes('.') || match.includes('-') || (match.includes(' ') && letters.length >= 2 && letters === letters.toUpperCase())) {
                            const chars = letters.split('');
                            if (chars.length >= 2) {
                                return chars.map(l => l.toUpperCase()).join(', ') + '.';
                            }
                        }
                        return match;
                    });

                    return clean;
                },

                speakText(text, gender = 'male') {
                    this.stopAllAudio();
                    if (!text || !('speechSynthesis' in window)) return;

                    const cleanText = this.prepareSpeechText(text);
                    if (!cleanText) return;

                    window.speechSynthesis.cancel();
                    const utterance = new SpeechSynthesisUtterance(cleanText);
                    utterance.lang = 'en-US';
                    utterance.rate = this.speechRate * 0.90;
                    utterance.pitch = (gender === 'male') ? 0.94 : 1.08;

                    const voice = this.getBestVoice(gender);
                    if (voice) {
                        utterance.voice = voice;
                    }

                    utterance.onstart = () => { this.isPlaying = true; };
                    utterance.onend = () => { this.isPlaying = false; };
                    utterance.onerror = () => { this.isPlaying = false; };

                    window.speechSynthesis.speak(utterance);
                },

                togglePlayAudio(scriptText, gender = 'male') {
                    if (this.isPlaying) {
                        this.stopAllAudio();
                        return;
                    }

                    this.stopAllAudio();
                    if (!scriptText || !('speechSynthesis' in window)) return;

                    const cleanText = this.prepareSpeechText(scriptText);
                    if (!cleanText) return;

                    // Cleanly split transcript into sentences
                    const sentences = cleanText.match(/[^.!?\n]+[.!?\n]*/g) || [cleanText];
                    let sentenceIdx = 0;
                    this.isPlaying = true;

                    const playNextSentence = () => {
                        if (!this.isPlaying || sentenceIdx >= sentences.length) {
                            this.isPlaying = false;
                            return;
                        }

                        const currentSentence = sentences[sentenceIdx].trim();
                        sentenceIdx++;
                        if (!currentSentence) {
                            playNextSentence();
                            return;
                        }

                        window.speechSynthesis.cancel();
                        const utterance = new SpeechSynthesisUtterance(currentSentence);
                        utterance.lang = 'en-US';
                        utterance.rate = this.speechRate * 0.90;
                        utterance.pitch = (gender === 'male') ? 0.94 : 1.08;

                        const voice = this.getBestVoice(gender);
                        if (voice) {
                            utterance.voice = voice;
                        }

                        utterance.onend = () => {
                            if (this.isPlaying) {
                                setTimeout(playNextSentence, 220); // Natural human breathing pause
                            }
                        };
                        utterance.onerror = () => {
                            if (this.isPlaying) {
                                playNextSentence();
                            }
                        };

                        window.speechSynthesis.speak(utterance);
                    };

                    playNextSentence();
                },

                playFullDialogue() {
                    if (this.isPlaying) {
                        this.stopAllAudio();
                        return;
                    }
                    this.stopAllAudio();

                    const dialogues = @js($meetingData['dialogue'] ?? []);
                    if (!dialogues || dialogues.length === 0 || !('speechSynthesis' in window)) return;

                    let idx = 0;
                    this.isPlaying = true;

                    const playNextTurn = () => {
                        if (!this.isPlaying || idx >= dialogues.length) {
                            this.isPlaying = false;
                            return;
                        }

                        const current = dialogues[idx];
                        idx++;
                        const rawText = current.en || current.text || '';
                        const cleanText = this.prepareSpeechText(rawText);
                        if (!cleanText) {
                            playNextTurn();
                            return;
                        }

                        const speaker = (current.speaker || '').toLowerCase();
                        const femaleKeywords = ['sarah', 'woman', 'girl', 'anna', 'linda', 'mary', 'jane', 'speaker b', 'student b', 'receptionist'];
                        const gender = femaleKeywords.some(k => speaker.includes(k)) ? 'female' : 'male';

                        window.speechSynthesis.cancel();
                        const utterance = new SpeechSynthesisUtterance(cleanText);
                        utterance.lang = 'en-US';
                        utterance.rate = this.speechRate * 0.90;
                        utterance.pitch = (gender === 'male') ? 0.94 : 1.08;

                        const voice = this.getBestVoice(gender);
                        if (voice) {
                            utterance.voice = voice;
                        }

                        utterance.onend = () => {
                            if (this.isPlaying) {
                                setTimeout(playNextTurn, 350); // Natural pause between speakers
                            }
                        };
                        utterance.onerror = () => {
                            if (this.isPlaying) {
                                playNextTurn();
                            }
                        };

                        window.speechSynthesis.speak(utterance);
                    };

                    playNextTurn();
                },

                playListeningDialogue(rawScript) {
                    if (this.isPlaying) {
                        this.stopAllAudio();
                        return;
                    }
                    this.stopAllAudio();
                    if (!rawScript || !('speechSynthesis' in window)) return;

                    // Detect dialogue speaker tags
                    const hasDialoguePattern = /(?:Receptionist|Attendee|Student A|Student B|Speaker 1|Speaker 2|Interviewer|Candidate|Person A|Person B):/i.test(rawScript);
                    let turns = [];

                    if (hasDialoguePattern) {
                        const pattern = /(?=(?:Receptionist|Attendee|Student A|Student B|Speaker 1|Speaker 2|Interviewer|Candidate|Person A|Person B):\s*)/i;
                        turns = rawScript.split(pattern).filter(t => t.trim().length > 0);
                    } else {
                        turns = rawScript.split(/\n+/).filter(t => t.trim().length > 0);
                    }

                    if (turns.length === 0) return;

                    let turnIdx = 0;
                    this.isPlaying = true;

                    const playNextTurn = () => {
                        if (!this.isPlaying || turnIdx >= turns.length) {
                            this.isPlaying = false;
                            return;
                        }

                        const rawTurn = turns[turnIdx].trim();
                        turnIdx++;
                        if (!rawTurn) {
                            playNextTurn();
                            return;
                        }

                        const parts = rawTurn.split(/:\s*(.+)/s);
                        let speaker = '';
                        let spokenText = rawTurn;

                        if (parts.length >= 2) {
                            speaker = parts[0].trim().toLowerCase();
                            spokenText = parts[1].trim();
                        }

                        // Clean text: strip role name and format spelled letters like W-R-I-G-H-T to W. R. I. G. H. T.
                        const cleanText = this.prepareSpeechText(spokenText);
                        if (!cleanText) {
                            playNextTurn();
                            return;
                        }

                        // Determine voice gender: Receptionist / Female / Woman -> female; Attendee / Male -> male
                        const isFemale = ['receptionist', 'female', 'woman', 'sophia', 'sarah', 'linda', 'mary', 'student b'].some(k => speaker.includes(k));
                        const gender = isFemale ? 'female' : 'male';

                        window.speechSynthesis.cancel();
                        const utterance = new SpeechSynthesisUtterance(cleanText);
                        utterance.lang = 'en-US';
                        utterance.rate = this.speechRate * 0.90;
                        utterance.pitch = (gender === 'male') ? 0.94 : 1.08;

                        const voice = this.getBestVoice(gender);
                        if (voice) {
                            utterance.voice = voice;
                        }

                        utterance.onend = () => {
                            if (this.isPlaying) {
                                setTimeout(playNextTurn, 320); // Natural conversation pause
                            }
                        };
                        utterance.onerror = () => {
                            if (this.isPlaying) {
                                playNextTurn();
                            }
                        };

                        window.speechSynthesis.speak(utterance);
                    };

                    playNextTurn();
                },

                // Alphabet & Spelling Drills
                spellWordAloud(word) {
                    if (!word) return;
                    const cleanWord = word.trim().toUpperCase();
                    const letters = cleanWord.split('').filter(char => /[A-Z]/.test(char));
                    if (letters.length === 0) return;
                    const spellingText = letters.join('. ') + '. ' + cleanWord;
                    this.speakText(spellingText, 'female');
                },

                // Classroom Game State (Worksheet 1b)
                gameCards: @js($games[0]['cards'] ?? []),
                selectedStudentCard: null,
                gameViewMode: 'student',
                isDrawing: false,
                surveyNameInput: '',
                surveyAnswerInput: '',
                surveyResponses: [],

                drawRandomCard() {
                    this.isDrawing = true;
                    setTimeout(() => {
                        if (this.gameCards && this.gameCards.length > 0) {
                            const randomIndex = Math.floor(Math.random() * this.gameCards.length);
                            this.selectedStudentCard = this.gameCards[randomIndex];
                        }
                        this.isDrawing = false;
                        this.gameViewMode = 'student';
                    }, 350);
                },

                selectCardById(id) {
                    this.selectedStudentCard = this.gameCards.find(c => c.id === parseInt(id)) || null;
                    this.gameViewMode = 'student';
                },

                addSurveyResponse() {
                    if (!this.surveyNameInput.trim() || !this.surveyAnswerInput.trim()) {
                        alert('Harap masukkan Nama Teman dan Jawabannya.');
                        return;
                    }
                    this.surveyResponses.push({
                        id: Date.now(),
                        name: this.surveyNameInput.trim(),
                        answer: this.surveyAnswerInput.trim()
                    });
                    this.surveyNameInput = '';
                    this.surveyAnswerInput = '';
                },

                removeSurveyResponse(id) {
                    this.surveyResponses = this.surveyResponses.filter(r => r.id !== id);
                },

                getReportText() {
                    if (!this.selectedStudentCard) return 'Pilih atau acak kartu misi Anda terlebih dahulu.';
                    if (this.surveyResponses.length === 0) {
                        return "In our class, my mission is: " + this.selectedStudentCard.title + " I am surveying my classmates right now.";
                    }
                    const summary = this.surveyResponses.map(r => r.name + ' answered ' + r.answer).join(', ');
                    return "In our group, I asked " + this.surveyResponses.length + " classmates about " + this.selectedStudentCard.badge + ". " + summary + ". Based on my survey, " + this.surveyResponses[0].answer + " is a popular answer!";
                },

                // AI Voice Interview State
                aiQuestions: @js($meetingData['ai_interview'] ?? [
                    [
                        'id' => 1,
                        'question' => "Hello! Welcome to your speaking practice session. Let's start with an introduction: What is your full name, and what should I call you?",
                        'hint' => "Answer: 'Hello! My full name is [Name], and you can call me [Nickname].'",
                    ],
                    [
                        'id' => 2,
                        'question' => "Nice to meet you! Where are you originally from, and where do you live right now?",
                        'hint' => "Answer: 'I am from [City/Country], and I currently live in [City].'",
                    ],
                    [
                        'id' => 3,
                        'question' => "Great! What is your current job or daily activity? Are you a student or are you working?",
                        'hint' => "Answer: 'I am a student at [School/University] / I work as a [Job].'",
                    ],
                    [
                        'id' => 4,
                        'question' => "Interesting! What do you usually like doing in your free time or on weekends?",
                        'hint' => "Answer: 'In my free time, I really enjoy [reading / playing sports / watching movies].'",
                    ],
                    [
                        'id' => 5,
                        'question' => "Wonderful! Why do you want to learn and improve your English speaking skills?",
                        'hint' => "Answer: 'I want to improve my English because [for my career / study / travel abroad].'",
                    ],
                ]),
                currentAiQIdx: 0,
                aiState: 'idle', // 'idle', 'speaking', 'listening', 'finished'
                showQuestionText: false,
                userSpokenText: '',
                recognitionInstance: null,

                // Admin-only "Edit Pertanyaan" modal state (see the modal
                // markup further down this file). aiEditDraft is a working
                // copy - aiQuestions itself (what the interview actually
                // reads from) is only replaced once a save succeeds.
                showAiEditModal: false,
                aiEditDraft: [],
                aiEditSaving: false,
                aiEditError: '',

                openAiEditModal() {
                    this.aiEditDraft = JSON.parse(JSON.stringify(this.aiQuestions));
                    this.aiEditError = '';
                    this.showAiEditModal = true;
                },

                saveAiInterviewQuestions() {
                    const cleaned = this.aiEditDraft
                        .map(q => ({ question: (q.question || '').trim(), hint: (q.hint || '').trim() }))
                        .filter(q => q.question !== '');

                    if (cleaned.length === 0) {
                        this.aiEditError = 'Minimal harus ada 1 pertanyaan dengan teks yang diisi.';
                        return;
                    }

                    this.aiEditSaving = true;
                    this.aiEditError = '';

                    fetch('{{ route('admin.speaking.ai-interview.update', ['level' => $level, 'meeting' => $meetingNumber]) }}', {
                        method: 'PUT',
                        headers: {
                            'Content-Type': 'application/json',
                            'Accept': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '',
                            'X-Requested-With': 'XMLHttpRequest',
                        },
                        body: JSON.stringify({ questions: cleaned }),
                    })
                    .then(res => res.json().then(data => ({ ok: res.ok, data })))
                    .then(({ ok, data }) => {
                        if (!ok || !data.success) {
                            throw new Error(data.message || 'Gagal menyimpan pertanyaan.');
                        }
                        this.aiQuestions = data.questions;
                        this.currentAiQIdx = 0;
                        this.showAiEditModal = false;
                    })
                    .catch(err => {
                        this.aiEditError = err.message || 'Gagal menyimpan pertanyaan.';
                    })
                    .finally(() => {
                        this.aiEditSaving = false;
                    });
                },

                resetAiInterviewQuestionsToDefault() {
                    if (!confirm('Kembalikan pertanyaan AI Interview meeting ini ke versi default?')) return;

                    this.aiEditSaving = true;
                    this.aiEditError = '';

                    fetch('{{ route('admin.speaking.ai-interview.reset', ['level' => $level, 'meeting' => $meetingNumber]) }}', {
                        method: 'DELETE',
                        headers: {
                            'Accept': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '',
                            'X-Requested-With': 'XMLHttpRequest',
                        },
                    })
                    .then(res => res.json().then(data => ({ ok: res.ok, data })))
                    .then(({ ok, data }) => {
                        if (!ok || !data.success) {
                            throw new Error('Gagal mereset pertanyaan.');
                        }
                        // Simplest reliable way to show the true default
                        // content again - it's only ever computed
                        // server-side at initial render, not duplicated in
                        // this Alpine state as a separate fallback value.
                        window.location.reload();
                    })
                    .catch(err => {
                        this.aiEditSaving = false;
                        this.aiEditError = err.message || 'Gagal mereset pertanyaan.';
                    });
                },

                get currentAiQuestion() {
                    return this.aiQuestions[this.currentAiQIdx] || null;
                },

                startAiInterview() {
                    this.currentAiQIdx = 0;
                    this.userSpokenText = '';
                    this.askCurrentAiQuestion();
                },

                toggleAiInteraction() {
                    if (this.aiState === 'idle') {
                        this.startAiInterview();
                    } else if (this.aiState === 'speaking') {
                        this.stopAllAudio();
                        this.aiState = 'listening';
                        this.startSpeechRecognition();
                    } else if (this.aiState === 'listening') {
                        this.stopSpeechRecognition();
                        this.nextAiQuestion();
                    } else if (this.aiState === 'finished') {
                        this.restartAiInterview();
                    }
                },

                askCurrentAiQuestion() {
                    const qObj = this.currentAiQuestion;
                    if (!qObj) {
                        this.aiState = 'finished';
                        this.speakText("Thank you so much! You did an outstanding job in this interview. Keep practicing your English speaking every day!", 'female');
                        return;
                    }

                    this.aiState = 'speaking';
                    this.userSpokenText = '';
                    this.stopAllAudio();

                    if ('speechSynthesis' in window) {
                        window.speechSynthesis.cancel();
                        const utterance = new SpeechSynthesisUtterance(qObj.question);
                        utterance.lang = 'en-US';
                        utterance.rate = this.speechRate * 0.92;
                        utterance.pitch = 1.05;

                        const voice = this.getBestVoice('female');
                        if (voice) {
                            utterance.voice = voice;
                        }

                        utterance.onend = () => {
                            if (this.aiState === 'speaking') {
                                this.aiState = 'listening';
                                this.startSpeechRecognition();
                            }
                        };
                        utterance.onerror = () => {
                            this.aiState = 'listening';
                        };

                        window.speechSynthesis.speak(utterance);
                    }
                },

                replayAiQuestion() {
                    this.askCurrentAiQuestion();
                },

                toggleUserMic() {
                    if (this.aiState === 'listening') {
                        this.stopSpeechRecognition();
                        this.aiState = 'idle';
                    } else {
                        this.stopAllAudio();
                        this.aiState = 'listening';
                        this.startSpeechRecognition();
                    }
                },

                startSpeechRecognition() {
                    const SpeechRecognition = window.SpeechRecognition || window.webkitSpeechRecognition;
                    if (!SpeechRecognition) return;

                    try {
                        if (this.recognitionInstance) {
                            this.recognitionInstance.stop();
                        }
                        this.recognitionInstance = new SpeechRecognition();
                        this.recognitionInstance.lang = 'en-US';
                        this.recognitionInstance.interimResults = true;
                        this.recognitionInstance.continuous = false;

                        this.recognitionInstance.onresult = (event) => {
                            const transcript = Array.from(event.results)
                                .map(result => result[0].transcript)
                                .join('');
                            this.userSpokenText = transcript;
                        };

                        this.recognitionInstance.onerror = (event) => {
                            console.log('Speech recognition notice:', event.error);
                        };

                        this.recognitionInstance.start();
                    } catch (e) {
                        console.log('Speech recognition not available:', e);
                    }
                },

                stopSpeechRecognition() {
                    if (this.recognitionInstance) {
                        try {
                            this.recognitionInstance.stop();
                        } catch (e) {}
                    }
                },

                nextAiQuestion() {
                    this.stopSpeechRecognition();
                    this.stopAllAudio();
                    if (this.currentAiQIdx < this.aiQuestions.length - 1) {
                        this.currentAiQIdx++;
                        this.askCurrentAiQuestion();
                    } else {
                        this.aiState = 'finished';
                        this.speakText("Congratulations! You have completed all the interview questions for this meeting. Wonderful job!", 'female');
                    }
                },

                restartAiInterview() {
                    this.stopSpeechRecognition();
                    this.stopAllAudio();
                    this.currentAiQIdx = 0;
                    this.userSpokenText = '';
                    this.aiState = 'idle';
                },

                // Recorder properties
                isRecording: false,
                mediaRecorder: null,
                audioChunks: [],
                audioUrl: null,
                recordingDuration: 0,
                timerInterval: null,

                async startRecording() {
                    try {
                        const stream = await navigator.mediaDevices.getUserMedia({ audio: true });
                        this.mediaRecorder = new MediaRecorder(stream);
                        this.audioChunks = [];
                        this.recordingDuration = 0;

                        this.mediaRecorder.ondataavailable = (event) => {
                            if (event.data.size > 0) {
                                this.audioChunks.push(event.data);
                            }
                        };

                        this.mediaRecorder.onstop = () => {
                            const audioBlob = new Blob(this.audioChunks, { type: 'audio/webm' });
                            this.audioUrl = URL.createObjectURL(audioBlob);
                        };

                        this.mediaRecorder.start();
                        this.isRecording = true;

                        this.timerInterval = setInterval(() => {
                            this.recordingDuration++;
                        }, 1000);
                    } catch (err) {
                        alert('Izin mikrofon diperlukan untuk merekam suara: ' + err.message);
                    }
                },

                stopRecording() {
                    if (this.mediaRecorder && this.isRecording) {
                        this.mediaRecorder.stop();
                        this.isRecording = false;
                        clearInterval(this.timerInterval);
                    }
                }
            };
        };

        window.weddingPhotosGame = function weddingPhotosGame() {
            return {
                gameTab: 'worksheet', // 'worksheet', 'student_a', 'student_b', 'phrases', 'guide'
                selectedGroupPreview: null, // group id whose members are currently revealed in the admin bar
                photoMode: 'color', // 'color', 'sketch'
                activeModal: null,
                inputs: {
                    // Bride's side (Family A)
                    joe: '',
                    elsie: '',
                    tom: '',
                    jess: '',
                    pete: '',
                    sue: '',
                    sam: '',
                    mike: '',
                    // Groom's side (Family B)
                    jim: '',
                    betty: '',
                    al: '',
                    jane: '',
                    ben: '',
                    liz: '',
                    beth: '',
                    john: ''
                },
                solution: {
                    joe: 'Joe',
                    elsie: 'Elsie',
                    tom: 'Tom',
                    jess: 'Jess',
                    pete: 'Pete',
                    sue: 'Sue',
                    sam: 'Sam',
                    mike: 'Mike',
                    jim: 'Jim',
                    betty: 'Betty',
                    al: 'Al',
                    jane: 'Jane',
                    ben: 'Ben',
                    liz: 'Liz',
                    beth: 'Beth',
                    john: 'John'
                },
                isSubmitted: false,
                score: 0,
                showSolutions: false,
                channel: null,
                pollTimer: null,
                saveDebounceTimer: null,
                
                init() {
                    // 1. Load initial answers from localStorage
                    try {
                        const saved = localStorage.getItem('TB_WEDDING_PHOTOS_M5');
                        if (saved) {
                            const parsed = JSON.parse(saved);
                            Object.keys(this.inputs).forEach(k => {
                                if (parsed[k] !== undefined && parsed[k] !== '') this.inputs[k] = parsed[k];
                            });
                        }
                    } catch(e) {}

                    // 2. Real-time instant BroadcastChannel across tabs/windows (0ms latency)
                    try {
                        if (typeof window !== 'undefined' && 'BroadcastChannel' in window) {
                            this.channel = new BroadcastChannel('TB_WEDDING_PHOTOS_M5');
                            this.channel.onmessage = (event) => {
                                if (event.data) {
                                    if (event.data.type === 'RESET') {
                                        Object.keys(this.inputs).forEach(k => this.inputs[k] = '');
                                        this.isSubmitted = false;
                                        this.score = 0;
                                    } else if (event.data.inputs) {
                                        this.mergeInputs(event.data.inputs);
                                    }
                                }
                            };
                        }
                    } catch(e) {}

                    // 3. Fallback cross-tab storage listener
                    window.addEventListener('storage', (e) => {
                        if (e.key === 'TB_WEDDING_PHOTOS_M5' && e.newValue) {
                            try {
                                const parsed = JSON.parse(e.newValue);
                                this.mergeInputs(parsed);
                            } catch(err) {}
                        }
                    });

                    // 4. Server-side sync for cross-device / paired student synchronization
                    this.fetchServerDraft();
                    this.pollTimer = setInterval(() => {
                        this.fetchServerDraft();
                    }, 2000);

                    // 5. Bi-directional sync with global floating bar dock
                    window.addEventListener('set-wedding-tab', (e) => {
                        if (e.detail) {
                            this.gameTab = e.detail;
                        }
                    });
                    if (this.$watch) {
                        this.$watch('gameTab', (val) => {
                            window.dispatchEvent(new CustomEvent('wedding-tab-updated', { detail: val }));
                        });
                    }
                },

                mergeInputs(newInputs) {
                    if (!newInputs || typeof newInputs !== 'object') return;
                    const activeEl = document.activeElement;
                    Object.keys(this.inputs).forEach(k => {
                        if (newInputs[k] !== undefined) {
                            // Avoid overwriting the field the user is currently actively typing in
                            const isFocused = activeEl && activeEl.getAttribute('x-model') === `inputs.${k}`;
                            if (!isFocused && newInputs[k] !== this.inputs[k]) {
                                this.inputs[k] = newInputs[k];
                            }
                        }
                    });
                },

                saveToStorage() {
                    // 1. Save to local storage
                    try {
                        localStorage.setItem('TB_WEDDING_PHOTOS_M5', JSON.stringify(this.inputs));
                    } catch(e) {}

                    // 2. Broadcast immediately to Student B / other tabs
                    try {
                        if (this.channel) {
                            this.channel.postMessage({ type: 'INPUT_UPDATE', inputs: this.inputs });
                        }
                    } catch(e) {}

                    // 3. Debounced server autosave
                    clearTimeout(this.saveDebounceTimer);
                    this.saveDebounceTimer = setTimeout(() => {
                        this.saveServerDraft();
                    }, 400);
                },

                saveServerDraft() {
                    try {
                        const url = '{{ route("assignments.speaking.meeting.draft", ["level" => $level, "meeting" => $meetingNumber]) }}';
                        const token = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '{{ csrf_token() }}';
                        fetch(url, {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': token,
                                'Accept': 'application/json'
                            },
                            body: JSON.stringify({ inputs: this.inputs })
                        }).catch(() => {});
                    } catch(e) {}
                },

                fetchServerDraft() {
                    try {
                        const url = '{{ route("assignments.speaking.meeting.draft.get", ["level" => $level, "meeting" => $meetingNumber]) }}';
                        fetch(url, {
                            headers: { 'Accept': 'application/json' }
                        })
                        .then(res => res.json())
                        .then(data => {
                            if (data && data.success && data.answers && typeof data.answers === 'object') {
                                this.mergeInputs(data.answers);
                                try {
                                    localStorage.setItem('TB_WEDDING_PHOTOS_M5', JSON.stringify(this.inputs));
                                } catch(e) {}
                            }
                        })
                        .catch(() => {});
                    } catch(e) {}
                },

                checkAnswers() {
                    this.isSubmitted = true;
                    let correctCount = 0;
                    let total = Object.keys(this.solution).length;
                    
                    Object.keys(this.solution).forEach(k => {
                        let userVal = (this.inputs[k] || '').trim().toLowerCase();
                        let solVal = this.solution[k].toLowerCase();
                        if (userVal === solVal) {
                            correctCount++;
                        }
                    });
                    
                    this.score = Math.round((correctCount / total) * 100);
                    this.playFeedbackAudio(this.score >= 70);
                },
                resetWorksheet() {
                    if (confirm('Apakah Anda yakin ingin mengosongkan semua isian nama?')) {
                        Object.keys(this.inputs).forEach(k => this.inputs[k] = '');
                        this.isSubmitted = false;
                        this.score = 0;
                        this.showSolutions = false;
                        this.saveToStorage();
                        try {
                            if (this.channel) {
                                this.channel.postMessage({ type: 'RESET' });
                            }
                        } catch(e) {}
                    }
                },
                isFieldCorrect(field) {
                    if (!this.isSubmitted) return null;
                    let userVal = (this.inputs[field] || '').trim().toLowerCase();
                    let solVal = this.solution[field].toLowerCase();
                    return userVal === solVal;
                },
                playFeedbackAudio(isGood) {
                    try {
                        const ctx = new (window.AudioContext || window.webkitAudioContext)();
                        const osc = ctx.createOscillator();
                        const gain = ctx.createGain();
                        osc.connect(gain);
                        gain.connect(ctx.destination);
                        
                        if (isGood) {
                            osc.frequency.setValueAtTime(523.25, ctx.currentTime); // C5
                            osc.frequency.setValueAtTime(659.25, ctx.currentTime + 0.1); // E5
                            osc.frequency.setValueAtTime(783.99, ctx.currentTime + 0.2); // G5
                            gain.gain.setValueAtTime(0.2, ctx.currentTime);
                            gain.gain.exponentialRampToValueAtTime(0.01, ctx.currentTime + 0.45);
                            osc.start(ctx.currentTime);
                            osc.stop(ctx.currentTime + 0.45);
                        } else {
                            osc.frequency.setValueAtTime(220, ctx.currentTime);
                            osc.frequency.setValueAtTime(180, ctx.currentTime + 0.12);
                            gain.gain.setValueAtTime(0.25, ctx.currentTime);
                            gain.gain.exponentialRampToValueAtTime(0.01, ctx.currentTime + 0.4);
                            osc.start(ctx.currentTime);
                            osc.stop(ctx.currentTime + 0.4);
                        }
                    } catch(e) {}
                }
            };
        };
    </script>
</head>
<body class="font-sans antialiased bg-slate-100 text-slate-900 min-h-screen relative overflow-x-hidden" x-data="speakingMeetingApp()">
    <!-- Ambient Background Lighting -->
    <div class="fixed inset-0 pointer-events-none -z-10 overflow-hidden">
        <div class="absolute -top-32 -left-32 w-[36rem] h-[36rem] bg-blue-400/20 rounded-full blur-3xl filter"></div>
        <div class="absolute top-1/3 -right-32 w-[32rem] h-[32rem] bg-indigo-300/20 rounded-full blur-3xl filter"></div>
        <div class="absolute -bottom-32 left-1/3 w-[36rem] h-[36rem] bg-lime-300/15 rounded-full blur-3xl filter"></div>
        <div class="absolute inset-0 bg-[radial-gradient(#cbd5e1_1px,transparent_1px)] [background-size:28px_28px] opacity-40"></div>
    </div>

    @include('components.impersonation-banner')
    <div class="flex min-h-screen">
        @if(Auth::user()?->isAdmin())
            @include('components.sidebar-admin')
        @elseif(Auth::user()?->isTeacher())
            @include('components.sidebar-teacher')
        @else
            @include('components.sidebar-student')
        @endif

        <main class="flex-1 min-w-0 md:ml-64 p-4 sm:p-6 lg:p-8 w-full transition-all duration-200">
            <div class="max-w-6xl mx-auto w-full space-y-6">

                <!-- TOP HEADER CARD (Clean & Compact) -->
                <div class="bg-white rounded-3xl p-5 sm:p-6 shadow-sm border border-slate-200/90 relative overflow-hidden">
                    <div class="relative z-10 flex flex-col md:flex-row md:items-center justify-between gap-4">
                        <div class="flex items-center gap-3.5">
                            <div style="background-color: #29a8f5 !important;" class="p-3 text-white rounded-2xl shadow-md shadow-sky-500/20 shrink-0">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11a7 7 0 01-7 7m0 0a7 7 0 01-7-7m7 7v4m0 0H8m4 0h4m-4-8a3 3 0 01-3-3V5a3 3 0 116 0v6a3 3 0 01-3 3z"></path>
                                </svg>
                            </div>
                            <div>
                                <div class="flex items-center gap-2 mb-1">
                                    <span style="background-color: #29a8f5 !important;" class="px-2.5 py-0.5 rounded-full text-xs font-black text-white">
                                        {{ $trackData['title'] }}
                                    </span>
                                    <span style="background-color: #ff9800 !important;" class="px-2.5 py-0.5 rounded-full text-xs font-black text-white">
                                        Meeting {{ $meetingNumber }} of {{ $totalMeetings }}
                                    </span>
                                </div>
                                <h1 class="text-xl sm:text-2xl font-black text-slate-900 tracking-tight">
                                    Meeting {{ $meetingNumber }}: {{ $meetingData['topic'] }}
                                </h1>
                            </div>
                        </div>

                        <div class="flex items-center gap-3 self-start md:self-auto flex-wrap">
                            <!-- Audio Speed Controls (Pill Style) -->
                            <div class="flex items-center gap-1 bg-slate-50 p-1 rounded-xl border border-slate-200 shadow-2xs text-xs font-bold text-slate-700">
                                <span class="text-slate-400 px-2 font-medium">Speed:</span>
                                <button @click="setSpeed(0.8)" :style="speechRate === 0.8 ? 'background-color: #29a8f5 !important; color: white !important;' : ''" :class="speechRate === 0.8 ? 'shadow-xs' : 'text-slate-600 hover:bg-slate-200'" class="px-2 py-0.5 rounded-lg transition">0.8x</button>
                                <button @click="setSpeed(1.0)" :style="speechRate === 1.0 ? 'background-color: #29a8f5 !important; color: white !important;' : ''" :class="speechRate === 1.0 ? 'shadow-xs' : 'text-slate-600 hover:bg-slate-200'" class="px-2 py-0.5 rounded-lg transition">1.0x</button>
                                <button @click="setSpeed(1.2)" :style="speechRate === 1.2 ? 'background-color: #29a8f5 !important; color: white !important;' : ''" :class="speechRate === 1.2 ? 'shadow-xs' : 'text-slate-600 hover:bg-slate-200'" class="px-2 py-0.5 rounded-lg transition">1.2x</button>
                            </div>

                            <a href="{{ route('assignments.speaking.level', $level) }}"
                                class="inline-flex items-center gap-2 px-3.5 py-1.5 bg-white text-slate-700 rounded-xl hover:bg-sky-50 hover:text-sky-600 border border-slate-200 transition font-bold text-xs sm:text-sm shadow-sm group shrink-0">
                                <svg class="w-4 h-4 text-slate-400 group-hover:text-sky-600 group-hover:-translate-x-0.5 transition-all" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                                </svg>
                                <span>Daftar Meeting</span>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- 7-TAB NAVIGATION CONTROLS (Alternating Blue & Orange Reference Style) -->
                <div class="bg-white p-2 rounded-[1.75rem] border border-slate-200 shadow-sm flex flex-wrap items-center gap-1.5 sm:gap-2">
                    <!-- Tab 1: Materi -->
                    <button @click="activeTab = 'materi'" :style="activeTab === 'materi' ? 'background-color: #29a8f5 !important; color: white !important;' : ''" :class="activeTab === 'materi' ? 'shadow-md font-black' : 'text-slate-600 hover:text-sky-600 hover:bg-sky-50 font-bold'" class="px-4 py-2.5 rounded-2xl text-xs sm:text-sm transition-all duration-200 shrink-0 flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                        <span>Materi</span>
                    </button>

                    <!-- Tab 2: Short Listening -->
                    <button @click="activeTab = 'listening'" :style="activeTab === 'listening' ? 'background-color: #ff9800 !important; color: white !important;' : ''" :class="activeTab === 'listening' ? 'shadow-md font-black' : 'text-slate-600 hover:text-orange-600 hover:bg-orange-50 font-bold'" class="px-4 py-2.5 rounded-2xl text-xs sm:text-sm transition-all duration-200 shrink-0 flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.536 8.464a5 5 0 010 7.072m2.828-9.9a9 9 0 010 12.728M5.586 15H4a1 1 0 01-1-1v-4a1 1 0 011-1h1.586l4.707-4.707C10.923 3.663 12 4.109 12 5v14c0 .891-1.077 1.337-1.707.707L5.586 15z"></path></svg>
                        <span>Short Listening</span>
                    </button>

                    <!-- Tab 3: Practice (Shadowing) -->
                    <button @click="activeTab = 'shadowing'" :style="activeTab === 'shadowing' ? 'background-color: #29a8f5 !important; color: white !important;' : ''" :class="activeTab === 'shadowing' ? 'shadow-md font-black' : 'text-slate-600 hover:text-sky-600 hover:bg-sky-50 font-bold'" class="px-4 py-2.5 rounded-2xl text-xs sm:text-sm transition-all duration-200 shrink-0 flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg>
                        <span>Practice (Shadowing)</span>
                    </button>

                    <!-- Tab 4: Practice (Partnering) -->
                    <button @click="activeTab = 'partnering'" :style="activeTab === 'partnering' ? 'background-color: #ff9800 !important; color: white !important;' : ''" :class="activeTab === 'partnering' ? 'shadow-md font-black' : 'text-slate-600 hover:text-orange-600 hover:bg-orange-50 font-bold'" class="px-4 py-2.5 rounded-2xl text-xs sm:text-sm transition-all duration-200 shrink-0 flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                        <span>Practice (Partnering)</span>
                    </button>

                    <!-- Tab 5: Kosa Kata (di kiri Game Speaking) -->
                    <button @click="activeTab = 'vocabulary'" :style="activeTab === 'vocabulary' ? 'background-color: #29a8f5 !important; color: white !important;' : ''" :class="activeTab === 'vocabulary' ? 'shadow-md font-black' : 'text-slate-600 hover:text-sky-600 hover:bg-sky-50 font-bold'" class="px-4 py-2.5 rounded-2xl text-xs sm:text-sm transition-all duration-200 shrink-0 flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                        <span>Kosa Kata</span>
                    </button>

                    <!-- Tab 6: Game Speaking -->
                    <button @click="activeTab = 'game'" :style="activeTab === 'game' ? 'background-color: #ff9800 !important; color: white !important;' : ''" :class="activeTab === 'game' ? 'shadow-md font-black' : 'text-slate-600 hover:text-orange-600 hover:bg-orange-50 font-bold'" class="px-4 py-2.5 rounded-2xl text-xs sm:text-sm transition-all duration-200 shrink-0 flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        <span>Game Speaking</span>
                    </button>

                    <!-- Tab 7: AI Interview -->
                    <button @click="activeTab = 'extended'" :style="activeTab === 'extended' ? 'background-color: #29a8f5 !important; color: white !important;' : ''" :class="activeTab === 'extended' ? 'shadow-md font-black' : 'text-slate-600 hover:text-sky-600 hover:bg-sky-50 font-bold'" class="px-4 py-2.5 rounded-2xl text-xs sm:text-sm transition-all duration-200 shrink-0 flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11a7 7 0 01-7 7m0 0a7 7 0 01-7-7m7 7v4m0 0H8m4 0h4m-4-8a3 3 0 01-3-3V5a3 3 0 116 0v6a3 3 0 01-3 3z"></path></svg>
                        <span>AI Interview</span>
                    </button>
                </div>

                <!-- ========================================== -->
                <!-- TAB 1: MATERI (LESSON MATERIAL)         -->
                <!-- ========================================== -->
                @if(count($materiBlocks) > 1)
                    <div x-show="activeTab === 'materi'" class="flex flex-wrap gap-2 mb-4">
                        @foreach($materiBlocks as $mi => $mb)
                            <button @click="activeMateriIndex = {{ $mi }}; @if($mi < count($games))activeGameIndex = {{ $mi }};@endif" type="button"
                                :class="activeMateriIndex === {{ $mi }} ? 'bg-sky-500 text-white shadow-md' : 'bg-white text-slate-600 border border-slate-200 hover:bg-sky-50'"
                                class="px-4 py-2 rounded-2xl text-xs sm:text-sm font-black transition-all">
                                {{ $mb['title'] ?? $mb['topic'] ?? ('Materi ' . ($mi + 1)) }}
                            </button>
                        @endforeach
                    </div>
                @endif
                @foreach($materiBlocks as $mi => $materiBlockData)
                <div x-show="activeTab === 'materi' && activeMateriIndex === {{ $mi }}" class="space-y-8">
                    @if(isset($materiBlockData['alphabet_groups']))
                        <!-- ==================================================== -->
                        <!-- MEETING 2: ALPHABET PHONETICS & JOBS OCCUPATIONS     -->
                        <!-- ==================================================== -->
                        
                        <!-- Section 1: SIGNATURE HERO SHOWCASE BOX (Alphabet Phonetics) -->
                        <div style="background-color: #29a8f5 !important;" class="rounded-[2.5rem] p-6 sm:p-10 text-white shadow-xl relative overflow-hidden">
                            <div class="relative z-10 mb-8 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                                <div>
                                    <span class="px-3 py-1 rounded-full bg-white/15 backdrop-blur-md text-xs font-extrabold uppercase tracking-wider text-blue-100">Modul 02 • Alphabet Phonetics</span>
                                    <h2 class="text-2xl sm:text-3xl font-black tracking-tight mt-1 text-white">English Alphabet Phonetics (A - Z)</h2>
                                    <p class="text-xs sm:text-sm text-blue-100 font-medium mt-0.5">Panduan lengkap simbol fonetik (IPA), cara pengucapan, dan contoh kosakata dari huruf A hingga Z.</p>
                                </div>
                                <button @click="speakText('A, B, C, D, E, F, G, H, I, J, K, L, M, N, O, P, Q, R, S, T, U, V, W, X, Y, Z')" type="button" class="px-5 py-2.5 rounded-2xl bg-amber-400 hover:bg-amber-300 text-slate-950 font-black text-xs sm:text-sm shadow-md transition flex items-center gap-2 shrink-0">
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M3 9v6h4l5 5V4L7 9H3zm13.5 3c0-1.77-1.02-3.29-2.5-4.03v8.05c1.48-.73 2.5-2.25 2.5-4.02z"/></svg>
                                    <span>Lafalkan Seluruh Abjad (A-Z)</span>
                                </button>
                            </div>

                            <!-- Single Unified White Card Collection -->
                            <div class="bg-white rounded-3xl p-6 sm:p-8 text-slate-900 shadow-md relative z-10 border border-slate-100">
                                @php
                                    $allLetters = $materiBlockData['alphabet_list'] ?? [];
                                    if (empty($allLetters) && !empty($materiBlockData['alphabet_groups'])) {
                                        foreach ($materiBlockData['alphabet_groups'] as $grp) {
                                            foreach ($grp['letters'] ?? [] as $lt) {
                                                $allLetters[] = $lt;
                                            }
                                        }
                                    }
                                    // Ensure strict alphabetical sorting A-Z
                                    usort($allLetters, function($a, $b) {
                                        return strcmp($a['letter'] ?? '', $b['letter'] ?? '');
                                    });
                                @endphp

                                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-3.5">
                                    @foreach($allLetters as $l)
                                        <div class="p-3 rounded-2xl bg-slate-50 border border-slate-200/80 hover:border-sky-300 hover:bg-sky-50/40 transition flex items-center justify-between gap-2.5 shadow-2xs group">
                                            <div class="flex items-center gap-3">
                                                <span class="w-10 h-10 rounded-xl bg-white border-2 border-slate-200 text-slate-900 font-black text-xl flex items-center justify-center shadow-xs group-hover:border-sky-400 group-hover:text-sky-600 transition">
                                                    {{ $l['letter'] }}
                                                </span>
                                                <div>
                                                    <div class="flex items-center gap-1.5">
                                                        <span class="font-mono font-bold text-sky-700 text-xs">/{{ $l['ipa'] }}/</span>
                                                        <span class="text-[11px] font-bold text-slate-400">({{ $l['id_sound'] }})</span>
                                                    </div>
                                                    <p class="text-[11px] text-slate-600 font-semibold mt-0.5 leading-tight">{{ $l['example'] }}</p>
                                                </div>
                                            </div>
                                            <button @click="speakText('Letter ' + @js($l['letter']) + '. ' + @js($l['example']))" class="w-8 h-8 rounded-full bg-white hover:bg-sky-600 hover:text-white text-slate-600 border border-slate-200 shadow-2xs transition flex items-center justify-center shrink-0" title="Listen Letter Sound">
                                                <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 24 24"><path d="M3 9v6h4l5 5V4L7 9H3zm13.5 3c0-1.77-1.02-3.29-2.5-4.03v8.05c1.48-.73 2.5-2.25 2.5-4.02z"/></svg>
                                            </button>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>

                        <!-- Section 2: Interactive Real-Time Spell-Aloud Station -->
                        <div class="bg-white rounded-[2rem] p-6 sm:p-8 shadow-sm border border-slate-200/90" x-data="{ spellInput: '', sampleWords: ['ACTOR', 'CARPENTER', 'DENTIST', 'ARCHITECT', 'JOURNALIST', 'TRAFFIC WARDEN', 'SECRETARY', 'LIBRARIAN'] }">
                            <div class="flex items-center gap-3 pb-4 mb-6 border-b border-slate-100">
                                <span style="background-color: #ff9800 !important;" class="w-8 h-8 rounded-xl text-white font-black text-xs flex items-center justify-center shadow-md shadow-amber-500/20">02</span>
                                <div>
                                    <h2 class="text-xl font-black text-slate-900 tracking-tight">Interactive Real-Time Spelling Station</h2>
                                    <p class="text-xs text-slate-500 font-medium">Ketik nama atau kata apa saja untuk mendengarkan ejaan huruf demi huruf secara presisi.</p>
                                </div>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 items-center">
                                <div class="p-6 rounded-3xl bg-slate-50 border-2 border-slate-200/80">
                                    <label class="block text-xs font-black text-slate-700 uppercase tracking-wider mb-2">Ketik Kata / Nama untuk Dieja:</label>
                                    <div class="flex items-center gap-2 mb-3">
                                        <input type="text" x-model="spellInput" placeholder="Ketik kata (misal: ARCHITECT)..." class="flex-1 px-4 py-3 rounded-2xl border border-slate-300 font-mono font-bold text-sm focus:ring-2 focus:ring-sky-500 focus:outline-none uppercase">
                                        <button @click="spellWordAloud(spellInput || 'ARCHITECT')" type="button" style="background-color: #29a8f5 !important;" class="px-5 py-3 rounded-2xl hover:bg-sky-600 text-white font-black text-xs shadow-md transition flex items-center gap-2 shrink-0">
                                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M3 9v6h4l5 5V4L7 9H3zm13.5 3c0-1.77-1.02-3.29-2.5-4.03v8.05c1.48-.73 2.5-2.25 2.5-4.02z"/></svg>
                                            <span>Eja Suara</span>
                                        </button>
                                    </div>
                                    <div class="flex items-center gap-1.5 flex-wrap">
                                        <span class="text-[11px] font-bold text-slate-400">Contoh Kata Cepat:</span>
                                        <template x-for="w in sampleWords" :key="w">
                                            <button @click="spellInput = w; spellWordAloud(w)" type="button" class="px-2.5 py-1 rounded-xl bg-white border border-slate-200 hover:border-sky-400 hover:text-sky-600 text-[10px] font-bold text-slate-700 transition shadow-2xs font-mono" x-text="w"></button>
                                        </template>
                                    </div>
                                </div>

                                <div class="p-6 rounded-3xl bg-amber-50/50 border-2 border-amber-200/80">
                                    <h4 class="text-xs font-black text-amber-950 uppercase tracking-wider mb-2.5 flex items-center gap-2">
                                        <span class="w-2.5 h-2.5 rounded-full bg-amber-500"></span>
                                        <span>3 Pola Percakapan Mengeja (Spelling Formulas)</span>
                                    </h4>
                                    <div class="space-y-2 text-xs font-medium text-amber-950">
                                        @foreach($materiBlockData['spelling_rules'] ?? [] as $sr)
                                            <div class="p-2.5 rounded-2xl bg-white border border-amber-100 shadow-2xs">
                                                <span class="font-bold text-amber-800 text-[11px] block">{{ $sr['label'] }}:</span>
                                                <p class="font-mono font-bold text-slate-900 text-xs">{{ $sr['pattern'] }}</p>
                                                <p class="text-[11px] text-slate-500 italic mt-0.5">{{ $sr['example'] }}</p>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>



                    @elseif(isset($materiBlockData['cardinal_numbers']))
                        <!-- ==================================================== -->
                        <!-- MEETING 3: TELLING NUMBERS & DATES                   -->
                        <!-- ==================================================== -->
                        
                        <!-- Section 1: SIGNATURE HERO SHOWCASE BOX (Numbers & Dates Mastery) -->
                        <div style="background-color: #29a8f5 !important;" class="rounded-[2.5rem] p-6 sm:p-10 text-white shadow-xl relative overflow-hidden">
                            <div class="relative z-10 mb-8 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                                <div>
                                    <span class="px-3.5 py-1 rounded-full bg-white/20 text-xs font-black uppercase tracking-wider text-white">Modul 03 • Numbers &amp; Dates Mastery</span>
                                    <h2 class="text-2xl sm:text-3xl font-black tracking-tight mt-2 text-white">Telling Numbers &amp; Dates</h2>
                                    <p class="text-xs sm:text-sm text-sky-100 font-medium mt-1">Panduan lengkap Cardinal &amp; Ordinal Numbers (0 s.d. 45 Miliar+), Kalender (12 Bulan &amp; 7 Hari), Cara Membaca Tahun &amp; Era (BC/AD), serta Preposisi Penanggalan (IN &amp; ON).</p>
                                </div>
                                <button @click="speakText('Telling numbers and dates. Cardinal numbers: zero, one, two, three, four, five. Ordinal numbers: first, second, third, fourth, fifth. When is your birthday? It is in January, on the twenty-ninth of January.')" type="button" class="px-5 py-2.5 rounded-2xl bg-amber-400 hover:bg-amber-300 text-slate-950 font-black text-xs sm:text-sm shadow-md transition flex items-center gap-2 shrink-0">
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M3 9v6h4l5 5V4L7 9H3zm13.5 3c0-1.77-1.02-3.29-2.5-4.03v8.05c1.48-.73 2.5-2.25 2.5-4.02z"/></svg>
                                    <span>Putar Ringkasan Materi</span>
                                </button>
                            </div>

                            <!-- 3 Mini Metric Cards inside Hero -->
                            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 relative z-10">
                                <div class="bg-white/15 p-4 rounded-2xl border border-white/25">
                                    <span class="text-xs font-bold text-sky-100 block uppercase tracking-wider">1. Numbers Matrix</span>
                                    <h3 class="text-lg font-black text-white mt-0.5">Cardinal &amp; Ordinal</h3>
                                    <p class="text-[11px] text-sky-100 mt-1">0 s.d. 45 Miliar+ dan angka tingkatan 1st - 1,000,000th.</p>
                                </div>
                                <div class="bg-white/15 p-4 rounded-2xl border border-white/25">
                                    <span class="text-xs font-bold text-sky-100 block uppercase tracking-wider">2. Calendar &amp; Dates</span>
                                    <h3 class="text-lg font-black text-white mt-0.5">Months, Days &amp; Years</h3>
                                    <p class="text-[11px] text-sky-100 mt-1">12 Bulan, 7 Hari, Cara Membaca Tahun, dan Era BC/AD.</p>
                                </div>
                                <div class="bg-white/15 p-4 rounded-2xl border border-white/25">
                                    <span class="text-xs font-bold text-sky-100 block uppercase tracking-wider">3. Date Prepositions</span>
                                    <h3 class="text-lg font-black text-white mt-0.5">IN &amp; ON (Q&amp;A)</h3>
                                    <p class="text-[11px] text-sky-100 mt-1">Penggunaan In vs On untuk tanggal, bulan, tahun &amp; ulang tahun.</p>
                                </div>
                            </div>
                        </div>

                        <!-- Section 1: CARDINAL & ORDINAL NUMBERS MATRIX -->
                        <div class="bg-white rounded-[2rem] p-6 sm:p-8 shadow-sm border border-slate-200/90" x-data="{ numCategory: 'all', searchNum: '' }">
                            <div class="flex flex-col sm:flex-row sm:items-center justify-between pb-4 mb-6 border-b border-slate-100 gap-4">
                                <div class="flex items-center gap-3">
                                    <span style="background-color: #29a8f5 !important;" class="w-8 h-8 rounded-xl text-white font-black text-xs flex items-center justify-center shadow-md shadow-sky-500/20">01</span>
                                    <div>
                                        <h2 class="text-xl font-black text-slate-900 tracking-tight">Cardinal &amp; Ordinal Numbers Matrix</h2>
                                        <p class="text-xs text-slate-500 font-medium">Perbedaan angka jumlah (Cardinal) vs angka urutan/peringkat/tanggal (Ordinal) dari 0 s.d. Ratusan, Ribuan, dan Jutaan/Miliaran.</p>
                                    </div>
                                </div>

                                <div class="flex items-center bg-slate-100 p-1 rounded-2xl border border-slate-200 text-xs font-bold shrink-0 flex-wrap gap-1">
                                    <button @click="numCategory = 'all'" :style="numCategory === 'all' ? 'background-color: #0f172a !important; color: white !important;' : ''" :class="numCategory === 'all' ? 'shadow-xs font-black' : 'text-slate-600 hover:text-slate-900'" class="px-3 py-1.5 rounded-xl transition">
                                        Semua Angka
                                    </button>
                                    <button @click="numCategory = 'basic'" :style="numCategory === 'basic' ? 'background-color: #29a8f5 !important; color: white !important;' : ''" :class="numCategory === 'basic' ? 'shadow-xs font-black' : 'text-slate-600 hover:text-slate-900'" class="px-3 py-1.5 rounded-xl transition">
                                        0 - 20 (Dasar)
                                    </button>
                                    <button @click="numCategory = 'tens'" :style="numCategory === 'tens' ? 'background-color: #ff9800 !important; color: white !important;' : ''" :class="numCategory === 'tens' ? 'shadow-xs font-black' : 'text-slate-600 hover:text-slate-900'" class="px-3 py-1.5 rounded-xl transition">
                                        21 - 99 (Puluhan)
                                    </button>
                                    <button @click="numCategory = 'hundreds'" :style="numCategory === 'hundreds' ? 'background-color: #10b981 !important; color: white !important;' : ''" :class="numCategory === 'hundreds' ? 'shadow-xs font-black' : 'text-slate-600 hover:text-slate-900'" class="px-3 py-1.5 rounded-xl transition">
                                        Ratusan (100 - 999)
                                    </button>
                                    <button @click="numCategory = 'thousands'" :style="numCategory === 'thousands' ? 'background-color: #0284c7 !important; color: white !important;' : ''" :class="numCategory === 'thousands' ? 'shadow-xs font-black' : 'text-slate-600 hover:text-slate-900'" class="px-3 py-1.5 rounded-xl transition">
                                        Ribuan (1.000 - 999.999)
                                    </button>
                                    <button @click="numCategory = 'millions'" :style="numCategory === 'millions' ? 'background-color: #8b5cf6 !important; color: white !important;' : ''" :class="numCategory === 'millions' ? 'shadow-xs font-black' : 'text-slate-600 hover:text-slate-900'" class="px-3 py-1.5 rounded-xl transition">
                                        Jutaan &amp; Miliaran (1M - 45B)
                                    </button>
                                </div>
                            </div>

                            @php
                                $cardinals = $materiBlockData['cardinal_numbers'] ?? [];
                                $ordinals = $materiBlockData['ordinal_numbers'] ?? [];
                                $ordMap = [];
                                foreach ($ordinals as $ord) {
                                    $rawKey = preg_replace('/[^0-9]/', '', $ord['num']);
                                    if ($rawKey) $ordMap[$rawKey] = $ord;
                                }
                            @endphp

                            <!-- Numbers Display Table -->
                            <div class="overflow-x-auto rounded-2xl border border-slate-200 shadow-2xs w-full">
                                <table class="w-full text-left border-collapse text-xs sm:text-sm">
                                    <thead>
                                        <tr class="bg-slate-900 text-white font-black text-[11px] sm:text-xs uppercase tracking-wider">
                                            <th class="p-3.5 sm:p-4 text-center w-28">ANGKA &amp; KATEGORI</th>
                                            <th class="p-3.5 sm:p-4">CARDINAL NUMBER (JUMLAH &amp; ARTI)</th>
                                            <th class="p-3.5 sm:p-4 font-mono">PRONUNCIATION / IPA</th>
                                            <th class="p-3.5 sm:p-4">ORDINAL NUMBER (URUTAN &amp; ARTI)</th>
                                            <th class="p-3.5 sm:p-4 text-center w-44">AUDIO / LAFALKAN</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-slate-100 font-medium text-slate-800">
                                        @foreach($cardinals as $idx => $cn)
                                            @php
                                                $cleanNum = preg_replace('/[^0-9]/', '', $cn['num']);
                                                $intVal = (int) $cleanNum;
                                                $cat = 'basic';
                                                $catBadge = '0 - 20';
                                                $catBadgeStyle = 'bg-slate-100 text-slate-700';

                                                if ($intVal > 20 && $intVal < 100) {
                                                    $cat = 'tens';
                                                    $catBadge = 'Puluhan';
                                                    $catBadgeStyle = 'bg-amber-100 text-amber-800';
                                                } elseif ($intVal >= 100 && $intVal < 1000) {
                                                    $cat = 'hundreds';
                                                    $catBadge = 'Ratusan';
                                                    $catBadgeStyle = 'bg-emerald-100 text-emerald-800';
                                                } elseif ($intVal >= 1000 && $intVal < 1000000) {
                                                    $cat = 'thousands';
                                                    $catBadge = 'Ribuan';
                                                    $catBadgeStyle = 'bg-sky-100 text-sky-800';
                                                } elseif ($intVal >= 1000000) {
                                                    $cat = 'millions';
                                                    $catBadge = 'Jutaan / M';
                                                    $catBadgeStyle = 'bg-purple-100 text-purple-800';
                                                }

                                                $matchingOrd = $ordMap[$cleanNum] ?? null;
                                            @endphp
                                            <tr x-show="numCategory === 'all' || numCategory === '{{ $cat }}'" class="hover:bg-sky-50/50 transition">
                                                <td class="p-3.5 sm:p-4 text-center">
                                                    <span class="inline-block px-3 py-1 rounded-xl bg-slate-900 text-white font-mono font-black text-xs sm:text-sm shadow-2xs">
                                                        {{ $cn['num'] }}
                                                    </span>
                                                    <span class="block mt-1 text-[10px] font-bold px-2 py-0.5 rounded-md {{ $catBadgeStyle }}">
                                                        {{ $catBadge }}
                                                    </span>
                                                </td>
                                                <td class="p-3.5 sm:p-4">
                                                    <span class="font-black text-slate-900 text-sm sm:text-base capitalize block">
                                                        {{ $cn['words'] }}
                                                    </span>
                                                    @if(!empty($cn['id']))
                                                        <span class="text-xs text-slate-500 font-semibold block mt-0.5">
                                                            🇮🇩 {{ $cn['id'] }}
                                                        </span>
                                                    @endif
                                                </td>
                                                <td class="p-3.5 sm:p-4 font-mono text-xs text-indigo-700">
                                                    <span class="px-2.5 py-1 rounded-lg bg-indigo-50 border border-indigo-100 font-bold inline-block">
                                                        {{ $cn['ipa'] }}
                                                    </span>
                                                </td>
                                                <td class="p-3.5 sm:p-4">
                                                    @if($matchingOrd)
                                                        <div>
                                                            <span class="font-black text-amber-950 bg-amber-50 px-2.5 py-0.5 rounded-lg border border-amber-200 text-xs sm:text-sm inline-block">
                                                                {{ $matchingOrd['num'] }} - {{ $matchingOrd['words'] }}
                                                            </span>
                                                            @if(!empty($matchingOrd['id']))
                                                                <span class="text-xs text-amber-800 font-semibold block mt-0.5">
                                                                    🇮🇩 {{ $matchingOrd['id'] }}
                                                                </span>
                                                            @endif
                                                        </div>
                                                    @else
                                                        <span class="text-slate-400 text-xs italic">-</span>
                                                    @endif
                                                </td>
                                                <td class="p-3.5 sm:p-4 text-center">
                                                    <div class="flex items-center justify-center gap-2">
                                                        <button @click="speakText(@js($cn['words']))" class="px-3 py-1.5 rounded-xl bg-sky-50 hover:bg-sky-600 hover:text-white text-sky-700 font-bold text-xs border border-sky-200 transition flex items-center gap-1 shadow-2xs" title="Lafalkan Cardinal">
                                                            <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 24 24"><path d="M3 9v6h4l5 5V4L7 9H3zm13.5 3c0-1.77-1.02-3.29-2.5-4.03v8.05c1.48-.73 2.5-2.25 2.5-4.02z"/></svg>
                                                            <span>Cardinal</span>
                                                        </button>
                                                        @if($matchingOrd)
                                                            <button @click="speakText(@js($matchingOrd['words']))" class="px-3 py-1.5 rounded-xl bg-amber-50 hover:bg-amber-600 hover:text-white text-amber-700 font-bold text-xs border border-amber-200 transition flex items-center gap-1 shadow-2xs" title="Lafalkan Ordinal">
                                                                <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 24 24"><path d="M3 9v6h4l5 5V4L7 9H3zm13.5 3c0-1.77-1.02-3.29-2.5-4.03v8.05c1.48-.73 2.5-2.25 2.5-4.02z"/></svg>
                                                                <span>Ordinal</span>
                                                            </button>
                                                        @endif
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <!-- Section 2: CALENDAR, DATES, YEARS & ERAS (BC/AD) -->
                        <div class="bg-white rounded-[2rem] p-6 sm:p-8 shadow-sm border border-slate-200/90">
                            <div class="flex items-center gap-3 pb-4 mb-6 border-b border-slate-100">
                                <span style="background-color: #ff9800 !important;" class="w-8 h-8 rounded-xl text-white font-black text-xs flex items-center justify-center shadow-md shadow-amber-500/20">02</span>
                                <div>
                                    <h2 class="text-xl font-black text-slate-900 tracking-tight">Calendar, Dates, Years &amp; Eras (BC/AD)</h2>
                                    <p class="text-xs text-slate-500 font-medium">Bulan, Hari, Cara Membaca Tahun, Format Tanggal British vs American, dan Era Sejarah.</p>
                                </div>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                                <!-- 12 Months of the Year -->
                                <div class="p-5 rounded-3xl bg-slate-50 border-2 border-slate-200/80">
                                    <div class="flex items-center justify-between mb-3 pb-2 border-b border-slate-200">
                                        <h4 class="font-black text-sm text-slate-900 flex items-center gap-1.5">
                                            <span>📅 12 Months (Bulan)</span>
                                        </h4>
                                        <button @click="speakText('January, February, March, April, May, June, July, August, September, October, November, December')" class="text-xs font-bold text-sky-600 hover:text-sky-800 flex items-center gap-1">
                                            <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 24 24"><path d="M3 9v6h4l5 5V4L7 9H3zm13.5 3c0-1.77-1.02-3.29-2.5-4.03v8.05c1.48-.73 2.5-2.25 2.5-4.02z"/></svg>
                                            <span>Putar Semua</span>
                                        </button>
                                    </div>
                                    <div class="grid grid-cols-2 gap-2 text-xs">
                                        @foreach($materiBlockData['telling_date']['months'] ?? [] as $m)
                                            <button @click="speakText(@js($m['en']))" class="p-2 rounded-xl bg-white border border-slate-200 hover:border-sky-400 text-left transition flex items-center justify-between group shadow-2xs">
                                                <div>
                                                    <span class="font-black text-slate-900 block">{{ $m['en'] }}</span>
                                                    <span class="text-[10px] text-slate-400">{{ $m['id'] }}</span>
                                                </div>
                                                <span class="text-slate-300 group-hover:text-sky-600 text-xs">🔊</span>
                                            </button>
                                        @endforeach
                                    </div>
                                </div>

                                <!-- 7 Days of the Week -->
                                <div class="p-5 rounded-3xl bg-slate-50 border-2 border-slate-200/80 flex flex-col justify-between">
                                    <div>
                                        <div class="flex items-center justify-between mb-3 pb-2 border-b border-slate-200">
                                            <h4 class="font-black text-sm text-slate-900 flex items-center gap-1.5">
                                                <span>🗓️ 7 Days of the Week (Hari)</span>
                                            </h4>
                                            <button @click="speakText('Sunday, Monday, Tuesday, Wednesday, Thursday, Friday, Saturday')" class="text-xs font-bold text-orange-600 hover:text-orange-800 flex items-center gap-1">
                                                <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 24 24"><path d="M3 9v6h4l5 5V4L7 9H3zm13.5 3c0-1.77-1.02-3.29-2.5-4.03v8.05c1.48-.73 2.5-2.25 2.5-4.02z"/></svg>
                                                <span>Putar Semua</span>
                                            </button>
                                        </div>
                                        <div class="space-y-1.5 text-xs">
                                            @foreach($materiBlockData['telling_date']['days'] ?? [] as $d)
                                                <button @click="speakText(@js($d['en']))" class="w-full p-2 rounded-xl bg-white border border-slate-200 hover:border-orange-400 text-left transition flex items-center justify-between group shadow-2xs">
                                                    <div class="flex items-center gap-2">
                                                        <span class="w-2 h-2 rounded-full bg-orange-400"></span>
                                                        <span class="font-black text-slate-900">{{ $d['en'] }}</span>
                                                    </div>
                                                    <span class="text-xs text-slate-400 font-semibold">{{ $d['id'] }}</span>
                                                </button>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>

                                <!-- Years, Eras & Date Formats -->
                                <div class="p-5 rounded-3xl bg-slate-50 border-2 border-slate-200/80 space-y-4">
                                    <div>
                                        <h4 class="font-black text-sm text-slate-900 mb-2 pb-1 border-b border-slate-200">
                                            ⏳ Cara Membaca Tahun (Years)
                                        </h4>
                                        <div class="space-y-2 text-xs">
                                            @foreach($materiBlockData['telling_date']['years'] ?? [] as $yr)
                                                <div class="p-2 rounded-xl bg-white border border-slate-200 shadow-2xs flex items-center justify-between">
                                                    <div>
                                                        <span class="font-black font-mono text-slate-900">{{ $yr['year'] }}</span>
                                                        <span class="text-slate-600 block text-[11px] font-medium">&rarr; "{{ $yr['read'] }}"</span>
                                                    </div>
                                                    <button @click="speakText(@js($yr['read']))" class="text-xs text-sky-600 hover:text-sky-800 font-bold p-1">🔊</button>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>

                                    <div>
                                        <h4 class="font-black text-sm text-slate-900 mb-2 pb-1 border-b border-slate-200">
                                            🏛️ Era Sejarah (BC vs AD)
                                        </h4>
                                        <div class="space-y-1.5 text-xs">
                                            <div class="p-2 rounded-xl bg-white border border-slate-200 shadow-2xs">
                                                <span class="font-black text-slate-900">BC = Before Christ</span> (Sebelum Masehi, misal: 400 BC)
                                            </div>
                                            <div class="p-2 rounded-xl bg-white border border-slate-200 shadow-2xs">
                                                <span class="font-black text-slate-900">AD = Anno Domini</span> (Setelah Masehi / Tahun Masehi)
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Section 3: PREPOSITIONS OF DATES (IN & ON) & Q&A -->
                        <div class="bg-white rounded-[2rem] p-6 sm:p-8 shadow-sm border border-slate-200/90">
                            <div class="flex items-center gap-3 pb-4 mb-6 border-b border-slate-100">
                                <span style="background-color: #10b981 !important;" class="w-8 h-8 rounded-xl text-white font-black text-xs flex items-center justify-center shadow-md shadow-emerald-500/20">03</span>
                                <div>
                                    <h2 class="text-xl font-black text-slate-900 tracking-tight">Prepositions of Dates: IN &amp; ON (Penanggalan &amp; Q&amp;A)</h2>
                                    <p class="text-xs text-slate-500 font-medium">Kunci menggunakan preposisi waktu (IN &amp; ON) untuk bulan, tahun, hari, tanggal kalender, dan ulang tahun.</p>
                                </div>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-5 mb-6">
                                <!-- IN -->
                                <div class="p-5 rounded-3xl bg-blue-50/60 border-2 border-blue-200 shadow-2xs">
                                    <span class="text-xs font-black px-3 py-1 rounded-full bg-blue-600 text-white uppercase tracking-wider inline-block mb-2">IN (Bulan, Tahun, Abad, Musim)</span>
                                    <h3 class="font-bold text-slate-900 text-xs mb-2">Digunakan untuk rentang waktu luas: Month, Year, Decade, Seasons.</h3>
                                    <div class="bg-white p-3 rounded-2xl border border-blue-200 text-xs space-y-1 font-mono">
                                        <p class="text-blue-950 font-bold">&bull; in January / in August</p>
                                        <p class="text-blue-950 font-bold">&bull; in 1999 / in 2024</p>
                                        <p class="text-blue-950 font-bold">&bull; in the 21st century</p>
                                    </div>
                                    <button @click="speakText('I was born in January, in nineteen ninety-nine.')" class="mt-3 text-xs font-bold text-blue-600 hover:text-blue-800 flex items-center gap-1">
                                        <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 24 24"><path d="M3 9v6h4l5 5V4L7 9H3zm13.5 3c0-1.77-1.02-3.29-2.5-4.03v8.05c1.48-.73 2.5-2.25 2.5-4.02z"/></svg>
                                        <span>Putar Contoh</span>
                                    </button>
                                </div>

                                <!-- ON -->
                                <div class="p-5 rounded-3xl bg-amber-50/60 border-2 border-amber-200 shadow-2xs">
                                    <span class="text-xs font-black px-3 py-1 rounded-full bg-amber-600 text-white uppercase tracking-wider inline-block mb-2">ON (Hari, Tanggal Spesifik &amp; Ulang Tahun)</span>
                                    <h3 class="font-bold text-slate-900 text-xs mb-2">Digunakan untuk hari tertentu dan tanggal kalender spesifik.</h3>
                                    <div class="bg-white p-3 rounded-2xl border border-amber-200 text-xs space-y-1 font-mono">
                                        <p class="text-amber-950 font-bold">&bull; on Monday / on Friday</p>
                                        <p class="text-amber-950 font-bold">&bull; on the 29th of January</p>
                                        <p class="text-amber-950 font-bold">&bull; on my birthday</p>
                                    </div>
                                    <button @click="speakText('My birthday party is on Monday, on the twenty-ninth of January.')" class="mt-3 text-xs font-bold text-amber-700 hover:text-amber-900 flex items-center gap-1">
                                        <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 24 24"><path d="M3 9v6h4l5 5V4L7 9H3zm13.5 3c0-1.77-1.02-3.29-2.5-4.03v8.05c1.48-.73 2.5-2.25 2.5-4.02z"/></svg>
                                        <span>Putar Contoh</span>
                                    </button>
                                </div>
                            </div>

                            <!-- Q&A Section -->
                            <div class="p-5 rounded-3xl bg-slate-50 border border-slate-200">
                                <h4 class="font-black text-sm text-slate-900 mb-3 flex items-center gap-2">
                                    <span class="w-2.5 h-2.5 rounded-full bg-blue-600"></span>
                                    <span>Pola Tanya-Jawab Tanggal &amp; Ulang Tahun (Conversation Q&amp;A)</span>
                                </h4>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-xs">
                                    <div class="p-3.5 rounded-2xl bg-white border border-slate-200 shadow-2xs">
                                        <span class="font-bold text-slate-400 block mb-1">Tanya Ulang Tahun:</span>
                                        <p class="font-black text-slate-900">&ldquo;When is your birthday?&rdquo;</p>
                                        <p class="font-bold text-sky-700 mt-1">&rarr; &ldquo;It is in January.&rdquo; / &ldquo;It is on the 29th of January.&rdquo;</p>
                                        <button @click="speakText('When is your birthday? It is in January. It is on the twenty-ninth of January.')" class="mt-2 text-[11px] font-bold text-sky-600 hover:text-sky-800 flex items-center gap-1">
                                            <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 24 24"><path d="M3 9v6h4l5 5V4L7 9H3zm13.5 3c0-1.77-1.02-3.29-2.5-4.03v8.05c1.48-.73 2.5-2.25 2.5-4.02z"/></svg>
                                            <span>Putar Audio</span>
                                        </button>
                                    </div>

                                    <div class="p-3.5 rounded-2xl bg-white border border-slate-200 shadow-2xs">
                                        <span class="font-bold text-slate-400 block mb-1">Tanya Tanggal &amp; Tahun Berdiri:</span>
                                        <p class="font-black text-slate-900">&ldquo;When was your company founded?&rdquo;</p>
                                        <p class="font-bold text-emerald-700 mt-1">&rarr; &ldquo;It was founded in 1995.&rdquo;</p>
                                        <button @click="speakText('When was your company founded? It was founded in nineteen ninety-five.')" class="mt-2 text-[11px] font-bold text-emerald-600 hover:text-emerald-800 flex items-center gap-1">
                                            <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 24 24"><path d="M3 9v6h4l5 5V4L7 9H3zm13.5 3c0-1.77-1.02-3.29-2.5-4.03v8.05c1.48-.73 2.5-2.25 2.5-4.02z"/></svg>
                                            <span>Putar Audio</span>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>

                    @elseif(isset($materiBlockData['telling_time']))
                        <!-- ==================================================== -->
                        <!-- MEETING 4: TELLING TIME & DAILY SCHEDULES            -->
                        <!-- ==================================================== -->
                        
                        <!-- Section 1: SIGNATURE HERO SHOWCASE BOX (Telling Time Mastery) -->
                        <div style="background-color: #29a8f5 !important;" class="rounded-[2.5rem] p-6 sm:p-10 text-white shadow-xl relative overflow-hidden">
                            <div class="relative z-10 mb-8 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                                <div>
                                    <span class="px-3.5 py-1 rounded-full bg-white/20 text-xs font-black uppercase tracking-wider text-white">Modul 04 • Time &amp; Schedules Mastery</span>
                                    <h2 class="text-2xl sm:text-3xl font-black tracking-tight mt-2 text-white">Telling Time &amp; Daily Schedules</h2>
                                    <p class="text-xs sm:text-sm text-sky-100 font-medium mt-1">Panduan lengkap membaca jam (British Style &amp; American Style), International 24-Hour / Sharp, Preposisi Jam (AT, FROM...TO, UNTIL), dan Jadwal Keberangkatan Transportasi.</p>
                                </div>
                                <button @click="speakText('Telling time and daily schedules. British style: a quarter past four, half past six, a quarter to five. American style: seven thirty AM, seven thirty PM. What time is it? It is four o\'clock sharp.')" type="button" class="px-5 py-2.5 rounded-2xl bg-amber-400 hover:bg-amber-300 text-slate-950 font-black text-xs sm:text-sm shadow-md transition flex items-center gap-2 shrink-0">
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M3 9v6h4l5 5V4L7 9H3zm13.5 3c0-1.77-1.02-3.29-2.5-4.03v8.05c1.48-.73 2.5-2.25 2.5-4.02z"/></svg>
                                    <span>Putar Ringkasan Materi</span>
                                </button>
                            </div>

                            <!-- 3 Mini Metric Cards inside Hero -->
                            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 relative z-10">
                                <div class="bg-white/15 p-4 rounded-2xl border border-white/25">
                                    <span class="text-xs font-bold text-sky-100 block uppercase tracking-wider">1. British Style</span>
                                    <h3 class="text-lg font-black text-white mt-0.5">Past &amp; To</h3>
                                    <p class="text-[11px] text-sky-100 mt-1">Quarter past/to, Half past, O'clock (Menit terlebih dahulu).</p>
                                </div>
                                <div class="bg-white/15 p-4 rounded-2xl border border-white/25">
                                    <span class="text-xs font-bold text-sky-100 block uppercase tracking-wider">2. American Style</span>
                                    <h3 class="text-lg font-black text-white mt-0.5">AM, PM &amp; Digital</h3>
                                    <p class="text-[11px] text-sky-100 mt-1">Jam + Menit langsung, AM (Pagi) &amp; PM (Siang/Malam).</p>
                                </div>
                                <div class="bg-white/15 p-4 rounded-2xl border border-white/25">
                                    <span class="text-xs font-bold text-sky-100 block uppercase tracking-wider">3. Schedules &amp; Prepositions</span>
                                    <h3 class="text-lg font-black text-white mt-0.5">AT, FROM...TO, Sharp</h3>
                                    <p class="text-[11px] text-sky-100 mt-1">Preposisi jam presisi, jadwal penerbangan &amp; kereta.</p>
                                </div>
                            </div>
                        </div>

                        <!-- Section 1: TELLING TIME MASTERCLASS (BRITISH VS AMERICAN) -->
                        <div class="bg-white rounded-[2rem] p-6 sm:p-8 shadow-sm border border-slate-200/90" x-data="{ timeTab: 'british' }">
                            <div class="flex flex-col sm:flex-row sm:items-center justify-between pb-4 mb-6 border-b border-slate-100 gap-4">
                                <div class="flex items-center gap-3">
                                    <span style="background-color: #29a8f5 !important;" class="w-8 h-8 rounded-xl text-white font-black text-xs flex items-center justify-center shadow-md shadow-sky-500/20">01</span>
                                    <div>
                                        <h2 class="text-xl font-black text-slate-900 tracking-tight">Telling Time Masterclass (Membaca Jam)</h2>
                                        <p class="text-xs text-slate-500 font-medium">Pelajari perbedaan membaca jam dalam format British, American, dan International 24-Hour.</p>
                                    </div>
                                </div>

                                <div class="flex items-center bg-slate-100 p-1 rounded-2xl border border-slate-200 text-xs font-bold shrink-0">
                                    <button @click="timeTab = 'british'" :style="timeTab === 'british' ? 'background-color: #29a8f5 !important; color: white !important;' : ''" :class="timeTab === 'british' ? 'shadow-xs font-black' : 'text-slate-600 hover:text-slate-900'" class="px-4 py-2 rounded-xl transition">
                                        🇬🇧 British Style
                                    </button>
                                    <button @click="timeTab = 'american'" :style="timeTab === 'american' ? 'background-color: #ff9800 !important; color: white !important;' : ''" :class="timeTab === 'american' ? 'shadow-xs font-black' : 'text-slate-600 hover:text-slate-900'" class="px-4 py-2 rounded-xl transition">
                                        🇺🇸 American Style
                                    </button>
                                    <button @click="timeTab = 'other'" :style="timeTab === 'other' ? 'background-color: #10b981 !important; color: white !important;' : ''" :class="timeTab === 'other' ? 'shadow-xs font-black' : 'text-slate-600 hover:text-slate-900'" class="px-4 py-2 rounded-xl transition">
                                        🌐 International / Sharp
                                    </button>
                                </div>
                            </div>

                            <!-- British Style Grid -->
                            <div x-show="timeTab === 'british'" x-transition class="space-y-4">
                                <div class="p-4 rounded-2xl bg-sky-50 border border-sky-200 text-xs text-sky-950 font-medium">
                                    <p><strong>💡 Rumus British:</strong> Mengucapkan menit terlebih dahulu, baru diikuti jam. Gunakan <span class="font-bold text-sky-700">"past"</span> untuk menit 1 s.d. 30 (lebih), dan <span class="font-bold text-orange-700">"to"</span> untuk menit 31 s.d. 59 (kurang menuju jam berikutnya).</p>
                                </div>
                                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                                    <div class="p-5 rounded-3xl bg-white border-2 border-sky-100 hover:border-sky-400 transition shadow-2xs flex flex-col justify-between">
                                        <div>
                                            <span class="text-[10px] font-black uppercase text-sky-700 bg-sky-100 px-2 py-0.5 rounded-md">Lebih 15 Menit</span>
                                            <h3 class="text-base font-black text-slate-900 mt-2">A quarter past _____</h3>
                                            <p class="text-xs text-slate-500 font-semibold mt-0.5">Jam _____ lebih seperempat</p>
                                            <div class="mt-3 p-2.5 rounded-xl bg-slate-50 border border-slate-100 font-mono text-xs">
                                                <span class="font-black text-sky-800">04:15</span> &rarr; "A quarter past four"
                                            </div>
                                        </div>
                                        <button @click="speakText('04:15. It is a quarter past four.')" class="mt-3 w-full py-1.5 rounded-xl bg-sky-600 hover:bg-sky-700 text-white font-bold text-xs transition flex items-center justify-center gap-1.5 shadow-xs">
                                            <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 24 24"><path d="M3 9v6h4l5 5V4L7 9H3zm13.5 3c0-1.77-1.02-3.29-2.5-4.03v8.05c1.48-.73 2.5-2.25 2.5-4.02z"/></svg>
                                            <span>Putar Audio</span>
                                        </button>
                                    </div>

                                    <div class="p-5 rounded-3xl bg-white border-2 border-orange-100 hover:border-orange-400 transition shadow-2xs flex flex-col justify-between">
                                        <div>
                                            <span class="text-[10px] font-black uppercase text-orange-700 bg-orange-100 px-2 py-0.5 rounded-md">Kurang 15 Menit</span>
                                            <h3 class="text-base font-black text-slate-900 mt-2">A quarter to _____</h3>
                                            <p class="text-xs text-slate-500 font-semibold mt-0.5">Jam _____ kurang seperempat</p>
                                            <div class="mt-3 p-2.5 rounded-xl bg-slate-50 border border-slate-100 font-mono text-xs">
                                                <span class="font-black text-orange-800">04:45</span> &rarr; "A quarter to five"
                                            </div>
                                        </div>
                                        <button @click="speakText('04:45. It is a quarter to five.')" class="mt-3 w-full py-1.5 rounded-xl bg-orange-600 hover:bg-orange-700 text-white font-bold text-xs transition flex items-center justify-center gap-1.5 shadow-xs">
                                            <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 24 24"><path d="M3 9v6h4l5 5V4L7 9H3zm13.5 3c0-1.77-1.02-3.29-2.5-4.03v8.05c1.48-.73 2.5-2.25 2.5-4.02z"/></svg>
                                            <span>Putar Audio</span>
                                        </button>
                                    </div>

                                    <div class="p-5 rounded-3xl bg-white border-2 border-emerald-100 hover:border-emerald-400 transition shadow-2xs flex flex-col justify-between">
                                        <div>
                                            <span class="text-[10px] font-black uppercase text-emerald-700 bg-emerald-100 px-2 py-0.5 rounded-md">Lebih 30 Menit</span>
                                            <h3 class="text-base font-black text-slate-900 mt-2">Half past _____</h3>
                                            <p class="text-xs text-slate-500 font-semibold mt-0.5">Jam setengah _____ (lebih 30 mnt)</p>
                                            <div class="mt-3 p-2.5 rounded-xl bg-slate-50 border border-slate-100 font-mono text-xs">
                                                <span class="font-black text-emerald-800">06:30</span> &rarr; "Half past six"
                                            </div>
                                        </div>
                                        <button @click="speakText('06:30. It is half past six.')" class="mt-3 w-full py-1.5 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs transition flex items-center justify-center gap-1.5 shadow-xs">
                                            <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 24 24"><path d="M3 9v6h4l5 5V4L7 9H3zm13.5 3c0-1.77-1.02-3.29-2.5-4.03v8.05c1.48-.73 2.5-2.25 2.5-4.02z"/></svg>
                                            <span>Putar Audio</span>
                                        </button>
                                    </div>

                                    <div class="p-5 rounded-3xl bg-white border-2 border-indigo-100 hover:border-indigo-400 transition shadow-2xs flex flex-col justify-between">
                                        <div>
                                            <span class="text-[10px] font-black uppercase text-indigo-700 bg-indigo-100 px-2 py-0.5 rounded-md">Jam Tepat (00 Mnt)</span>
                                            <h3 class="text-base font-black text-slate-900 mt-2">_____ O'clock</h3>
                                            <p class="text-xs text-slate-500 font-semibold mt-0.5">Jam _____ tepat</p>
                                            <div class="mt-3 p-2.5 rounded-xl bg-slate-50 border border-slate-100 font-mono text-xs">
                                                <span class="font-black text-indigo-800">07:00</span> &rarr; "Seven o'clock"
                                            </div>
                                        </div>
                                        <button @click="speakText('07:00. It is seven o\'clock.')" class="mt-3 w-full py-1.5 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white font-bold text-xs transition flex items-center justify-center gap-1.5 shadow-xs">
                                            <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 24 24"><path d="M3 9v6h4l5 5V4L7 9H3zm13.5 3c0-1.77-1.02-3.29-2.5-4.03v8.05c1.48-.73 2.5-2.25 2.5-4.02z"/></svg>
                                            <span>Putar Audio</span>
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <!-- American Style Grid -->
                            <div x-show="timeTab === 'american'" x-transition class="space-y-4">
                                <div class="p-4 rounded-2xl bg-amber-50 border border-amber-200 text-xs text-amber-950 font-medium">
                                    <p><strong>💡 Rumus American:</strong> Membaca jam lalu menit secara langsung (*Digital Direct Form*), dan menggunakan sistem 12 jam dengan penanda <span class="font-bold text-amber-800">AM</span> dan <span class="font-bold text-amber-800">PM</span>.</p>
                                </div>
                                <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
                                    <div class="p-5 rounded-3xl bg-white border-2 border-sky-100 hover:border-sky-300 transition shadow-2xs">
                                        <div class="flex items-center justify-between mb-2">
                                            <span class="text-xs font-black uppercase text-sky-800 bg-sky-100 px-2.5 py-0.5 rounded-lg">AM (Ante Meridiem)</span>
                                            <span class="text-xs font-bold text-slate-400">Pagi Hari</span>
                                        </div>
                                        <h4 class="text-sm font-black text-slate-900 mt-1">12:00 Tengah Malam – 11:59 Siang</h4>
                                        <p class="text-xs text-slate-600 mt-1 font-medium">Digunakan untuk menyatakan waktu dari tengah malam (00:00) sampai sebelum jam 12 siang.</p>
                                        <div class="mt-3 p-3 rounded-2xl bg-slate-50 border border-slate-100 font-mono text-xs">
                                            <p class="font-bold text-slate-800">07:30 AM &rarr; "Seven thirty in the morning"</p>
                                        </div>
                                        <button @click="speakText('07:30 AM. It is seven thirty in the morning.')" class="mt-3 text-xs font-bold text-sky-600 hover:text-sky-800 flex items-center gap-1">
                                            <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 24 24"><path d="M3 9v6h4l5 5V4L7 9H3zm13.5 3c0-1.77-1.02-3.29-2.5-4.03v8.05c1.48-.73 2.5-2.25 2.5-4.02z"/></svg>
                                            <span>Putar Audio</span>
                                        </button>
                                    </div>

                                    <div class="p-5 rounded-3xl bg-white border-2 border-orange-100 hover:border-orange-300 transition shadow-2xs">
                                        <div class="flex items-center justify-between mb-2">
                                            <span class="text-xs font-black uppercase text-orange-800 bg-orange-100 px-2.5 py-0.5 rounded-lg">PM (Post Meridiem)</span>
                                            <span class="text-xs font-bold text-slate-400">Siang / Malam</span>
                                        </div>
                                        <h4 class="text-sm font-black text-slate-900 mt-1">12:00 Siang – 11:59 Malam</h4>
                                        <p class="text-xs text-slate-600 mt-1 font-medium">Digunakan untuk menyatakan waktu dari jam 12 siang sampai sebelum tengah malam.</p>
                                        <div class="mt-3 p-3 rounded-2xl bg-slate-50 border border-slate-100 font-mono text-xs">
                                            <p class="font-bold text-slate-800">07:30 PM &rarr; "Seven thirty in the evening"</p>
                                        </div>
                                        <button @click="speakText('07:30 PM. It is seven thirty in the evening.')" class="mt-3 text-xs font-bold text-orange-600 hover:text-orange-800 flex items-center gap-1">
                                            <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 24 24"><path d="M3 9v6h4l5 5V4L7 9H3zm13.5 3c0-1.77-1.02-3.29-2.5-4.03v8.05c1.48-.73 2.5-2.25 2.5-4.02z"/></svg>
                                            <span>Putar Audio</span>
                                        </button>
                                    </div>

                                    <div class="p-5 rounded-3xl bg-white border-2 border-indigo-100 hover:border-indigo-300 transition shadow-2xs">
                                        <div class="flex items-center justify-between mb-2">
                                            <span class="text-xs font-black uppercase text-indigo-800 bg-indigo-100 px-2.5 py-0.5 rounded-lg">Digital Direct Format</span>
                                            <span class="text-xs font-bold text-slate-400">Jam + Menit</span>
                                        </div>
                                        <h4 class="text-sm font-black text-slate-900 mt-1">Sebut Angka Jam lalu Menit</h4>
                                        <p class="text-xs text-slate-600 mt-1 font-medium">Cara paling praktis dan umum digunakan dalam percakapan kasual Amerika.</p>
                                        <div class="mt-3 p-3 rounded-2xl bg-slate-50 border border-slate-100 font-mono text-xs space-y-1">
                                            <p class="font-bold text-slate-800">04:15 &rarr; "Four fifteen"</p>
                                            <p class="font-bold text-slate-800">04:45 &rarr; "Four forty-five"</p>
                                            <p class="font-bold text-slate-800">06:30 &rarr; "Six thirty"</p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Other Formats Grid -->
                            <div x-show="timeTab === 'other'" x-transition class="space-y-4">
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                                    <div class="p-5 rounded-3xl bg-white border-2 border-slate-200 hover:border-emerald-400 transition shadow-2xs">
                                        <span class="text-xs font-black uppercase text-emerald-800 bg-emerald-100 px-2.5 py-0.5 rounded-lg">Sharp (Tepat Waktu)</span>
                                        <h4 class="text-base font-black text-slate-900 mt-2">Kata "Sharp" untuk Waktu Presisi</h4>
                                        <p class="text-xs text-slate-600 mt-1">Digunakan untuk menegaskan bahwa acara atau pertemuan dimulai tepat waktu tanpa kompromi keterlambatan.</p>
                                        <div class="mt-3 p-3 rounded-2xl bg-slate-50 border border-slate-100 font-mono text-xs">
                                            <p class="font-black text-emerald-900">"The meeting starts at 4 sharp." (Tepat jam 4.00)</p>
                                        </div>
                                        <button @click="speakText('The meeting starts at four sharp. Please do not be late.')" class="mt-3 text-xs font-bold text-emerald-600 hover:text-emerald-800 flex items-center gap-1">
                                            <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 24 24"><path d="M3 9v6h4l5 5V4L7 9H3zm13.5 3c0-1.77-1.02-3.29-2.5-4.03v8.05c1.48-.73 2.5-2.25 2.5-4.02z"/></svg>
                                            <span>Putar Audio</span>
                                        </button>
                                    </div>

                                    <div class="p-5 rounded-3xl bg-white border-2 border-slate-200 hover:border-blue-400 transition shadow-2xs">
                                        <span class="text-xs font-black uppercase text-blue-800 bg-blue-100 px-2.5 py-0.5 rounded-lg">Hundred (24-Hour Military / Flight)</span>
                                        <h4 class="text-base font-black text-slate-900 mt-2">Format 24 Jam Internasional</h4>
                                        <p class="text-xs text-slate-600 mt-1">Biasa digunakan di bandara, penerbangan, pelayaran, dan militer internasional.</p>
                                        <div class="mt-3 p-3 rounded-2xl bg-slate-50 border border-slate-100 font-mono text-xs space-y-1">
                                            <p class="font-black text-blue-900">13:00 &rarr; "Thirteen hundred" (Jam 1 Siang)</p>
                                            <p class="font-black text-blue-900">14:00 &rarr; "Fourteen hundred" (Jam 2 Siang)</p>
                                        </div>
                                        <button @click="speakText('Flight departure is at fourteen hundred hours.')" class="mt-3 text-xs font-bold text-blue-600 hover:text-blue-800 flex items-center gap-1">
                                            <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 24 24"><path d="M3 9v6h4l5 5V4L7 9H3zm13.5 3c0-1.77-1.02-3.29-2.5-4.03v8.05c1.48-.73 2.5-2.25 2.5-4.02z"/></svg>
                                            <span>Putar Audio</span>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Section 2: PREPOSITIONS OF CLOCK TIME (AT, FROM...TO, UNTIL) & Q&A -->
                        <div class="bg-white rounded-[2rem] p-6 sm:p-8 shadow-sm border border-slate-200/90">
                            <div class="flex items-center gap-3 pb-4 mb-6 border-b border-slate-100">
                                <span style="background-color: #ff9800 !important;" class="w-8 h-8 rounded-xl text-white font-black text-xs flex items-center justify-center shadow-md shadow-amber-500/20">02</span>
                                <div>
                                    <h2 class="text-xl font-black text-slate-900 tracking-tight">Prepositions of Clock Time &amp; Asking The Time (Q&amp;A)</h2>
                                    <p class="text-xs text-slate-500 font-medium">Preposisi jam (AT, FROM...TO, UNTIL) dan pola percakapan menanyakan jam serta jadwal keberangkatan.</p>
                                </div>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-5 mb-6">
                                <!-- AT -->
                                <div class="p-5 rounded-3xl bg-emerald-50/60 border-2 border-emerald-200 shadow-2xs">
                                    <span class="text-xs font-black px-3 py-1 rounded-full bg-emerald-600 text-white uppercase tracking-wider inline-block mb-2">AT (Jam Spesifik &amp; Titik Waktu)</span>
                                    <h3 class="font-bold text-slate-900 text-xs mb-2">Digunakan untuk jam presisi dan momen tertentu.</h3>
                                    <div class="bg-white p-3 rounded-2xl border border-emerald-200 text-xs space-y-1 font-mono">
                                        <p class="text-emerald-950 font-bold">&bull; at 4 o'clock / at 4:00 sharp</p>
                                        <p class="text-emerald-950 font-bold">&bull; at half past six (06:30)</p>
                                        <p class="text-emerald-950 font-bold">&bull; at noon / at midnight</p>
                                    </div>
                                    <button @click="speakText('The meeting starts at four o\'clock sharp.')" class="mt-3 text-xs font-bold text-emerald-700 hover:text-emerald-900 flex items-center gap-1">
                                        <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 24 24"><path d="M3 9v6h4l5 5V4L7 9H3zm13.5 3c0-1.77-1.02-3.29-2.5-4.03v8.05c1.48-.73 2.5-2.25 2.5-4.02z"/></svg>
                                        <span>Putar Contoh</span>
                                    </button>
                                </div>

                                <!-- FROM ... TO / UNTIL -->
                                <div class="p-5 rounded-3xl bg-blue-50/60 border-2 border-blue-200 shadow-2xs">
                                    <span class="text-xs font-black px-3 py-1 rounded-full bg-blue-600 text-white uppercase tracking-wider inline-block mb-2">FROM...TO &amp; UNTIL (Rentang Jam)</span>
                                    <h3 class="font-bold text-slate-900 text-xs mb-2">Digunakan untuk durasi kerja, jadwal buka/tutup toko, dan event.</h3>
                                    <div class="bg-white p-3 rounded-2xl border border-blue-200 text-xs space-y-1 font-mono">
                                        <p class="text-blue-950 font-bold">&bull; from 9:00 AM to 5:00 PM</p>
                                        <p class="text-blue-950 font-bold">&bull; until 10:00 PM</p>
                                        <p class="text-blue-950 font-bold">&bull; around 7 o'clock</p>
                                    </div>
                                    <button @click="speakText('The office is open from nine AM to five PM.')" class="mt-3 text-xs font-bold text-blue-600 hover:text-blue-800 flex items-center gap-1">
                                        <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 24 24"><path d="M3 9v6h4l5 5V4L7 9H3zm13.5 3c0-1.77-1.02-3.29-2.5-4.03v8.05c1.48-.73 2.5-2.25 2.5-4.02z"/></svg>
                                        <span>Putar Contoh</span>
                                    </button>
                                </div>
                            </div>

                            <!-- Asking The Time Q&A Section -->
                            <div class="p-5 rounded-3xl bg-slate-50 border border-slate-200">
                                <h4 class="font-black text-sm text-slate-900 mb-3 flex items-center gap-2">
                                    <span class="w-2.5 h-2.5 rounded-full bg-blue-600"></span>
                                    <span>Pola Percakapan Menanyakan Jam &amp; Jadwal (Time &amp; Schedule Q&amp;A)</span>
                                </h4>
                                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-xs">
                                    <div class="p-3.5 rounded-2xl bg-white border border-slate-200 shadow-2xs">
                                        <span class="font-bold text-slate-400 block mb-1">Tanya Jam Saat Ini:</span>
                                        <p class="font-black text-slate-900">&ldquo;What time is it?&rdquo;</p>
                                        <p class="font-bold text-sky-700 mt-1">&rarr; &ldquo;It is half past six (06:30).&rdquo;</p>
                                        <button @click="speakText('What time is it? It is half past six.')" class="mt-2 text-[11px] font-bold text-sky-600 hover:text-sky-800 flex items-center gap-1">
                                            <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 24 24"><path d="M3 9v6h4l5 5V4L7 9H3zm13.5 3c0-1.77-1.02-3.29-2.5-4.03v8.05c1.48-.73 2.5-2.25 2.5-4.02z"/></svg>
                                            <span>Putar Audio</span>
                                        </button>
                                    </div>

                                    <div class="p-3.5 rounded-2xl bg-white border border-slate-200 shadow-2xs">
                                        <span class="font-bold text-slate-400 block mb-1">Tanya Jadwal Keberangkatan:</span>
                                        <p class="font-black text-slate-900">&ldquo;What time does the flight leave?&rdquo;</p>
                                        <p class="font-bold text-orange-700 mt-1">&rarr; &ldquo;It departs at fourteen hundred hours (02:00 PM).&rdquo;</p>
                                        <button @click="speakText('What time does the flight leave? It departs at fourteen hundred hours.')" class="mt-2 text-[11px] font-bold text-orange-600 hover:text-orange-800 flex items-center gap-1">
                                            <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 24 24"><path d="M3 9v6h4l5 5V4L7 9H3zm13.5 3c0-1.77-1.02-3.29-2.5-4.03v8.05c1.48-.73 2.5-2.25 2.5-4.02z"/></svg>
                                            <span>Putar Audio</span>
                                        </button>
                                    </div>

                                    <div class="p-3.5 rounded-2xl bg-white border border-slate-200 shadow-2xs">
                                        <span class="font-bold text-slate-400 block mb-1">Tanya Rutinitas Harian:</span>
                                        <p class="font-black text-slate-900">&ldquo;What time do you wake up?&rdquo;</p>
                                        <p class="font-bold text-emerald-700 mt-1">&rarr; &ldquo;I usually wake up at 6:00 AM sharp.&rdquo;</p>
                                        <button @click="speakText('What time do you usually wake up? I usually wake up at six AM sharp.')" class="mt-2 text-[11px] font-bold text-emerald-600 hover:text-emerald-800 flex items-center gap-1">
                                            <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 24 24"><path d="M3 9v6h4l5 5V4L7 9H3zm13.5 3c0-1.77-1.02-3.29-2.5-4.03v8.05c1.48-.73 2.5-2.25 2.5-4.02z"/></svg>
                                            <span>Putar Audio</span>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>

                    @elseif(isset($materiBlockData['greetings']))
                        <!-- ==================================================== -->
                        <!-- MEETING 1: GREETINGS & SELF-INTRODUCTION             -->
                        <!-- ==================================================== -->
                        
                        <!-- Section 1: SIGNATURE ELECTRIC BLUE SHOWCASE BOX (Reference Style) -->
                        <div style="background-color: #29a8f5 !important;" class="rounded-[2.5rem] p-6 sm:p-10 text-white shadow-xl relative overflow-hidden">
                            <div class="relative z-10 mb-8 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                                <div>
                                    <span class="px-3 py-1 rounded-full bg-white/15 backdrop-blur-md text-xs font-extrabold uppercase tracking-wider text-blue-100">Modul 01</span>
                                    <h2 class="text-2xl sm:text-3xl font-black tracking-tight mt-1 text-white">Greetings &amp; Farewells</h2>
                                    <p class="text-xs sm:text-sm text-blue-100 font-medium mt-0.5">Ungkapan salam formal, informal, dan salam perpisahan dalam bahasa Inggris.</p>
                                </div>
                            </div>

                            <!-- 3 White Clip Cards Grid (Reference Style) -->
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-5 relative z-10">
                                
                                <!-- Formal Greetings Card -->
                                <div class="bg-white rounded-3xl p-5 text-slate-900 shadow-md relative overflow-hidden flex flex-col justify-between border border-slate-100">
                                    <div class="absolute top-2.5 right-4 text-slate-300">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"></path></svg>
                                    </div>
                                    <div>
                                        <div class="flex items-center gap-2 mb-4">
                                            <span class="w-2.5 h-2.5 rounded-full bg-blue-600"></span>
                                            <h3 class="font-black text-slate-900 text-sm">Formal Greetings</h3>
                                            <span class="text-[10px] font-extrabold px-2 py-0.5 bg-blue-50 text-blue-700 rounded-full">Resmi</span>
                                        </div>
                                        <div class="space-y-2.5">
                                            @foreach($materiBlockData['greetings']['formal'] ?? [] as $g)
                                                <div class="p-3 rounded-2xl bg-slate-50 border border-slate-200/70 flex items-center justify-between gap-2 hover:bg-blue-50/50 hover:border-blue-200 transition">
                                                    <div>
                                                        <p class="font-bold text-slate-900 text-xs sm:text-sm">{{ $g['en'] }}</p>
                                                        <p class="text-[11px] text-slate-500 font-medium mt-0.5">{{ $g['id'] }}</p>
                                                    </div>
                                                    <button @click="speakText(@js($g['en']))" class="w-7 h-7 rounded-full bg-white hover:bg-blue-600 hover:text-white text-slate-600 border border-slate-200 shadow-2xs transition flex items-center justify-center shrink-0" title="Listen">
                                                        <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 24 24"><path d="M3 9v6h4l5 5V4L7 9H3zm13.5 3c0-1.77-1.02-3.29-2.5-4.03v8.05c1.48-.73 2.5-2.25 2.5-4.02z"/></svg>
                                                    </button>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>

                                <!-- Informal Greetings Card -->
                                <div class="bg-white rounded-3xl p-5 text-slate-900 shadow-md relative overflow-hidden flex flex-col justify-between border border-slate-100">
                                    <div class="absolute top-2.5 right-4 text-slate-300">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"></path></svg>
                                    </div>
                                    <div>
                                        <div class="flex items-center gap-2 mb-4">
                                            <span class="w-2.5 h-2.5 rounded-full bg-amber-500"></span>
                                            <h3 class="font-black text-slate-900 text-sm">Informal Greetings</h3>
                                            <span class="text-[10px] font-extrabold px-2 py-0.5 bg-amber-50 text-amber-700 rounded-full">Santai</span>
                                        </div>
                                        <div class="space-y-2.5">
                                            @foreach($materiBlockData['greetings']['informal'] ?? [] as $g)
                                                <div class="p-3 rounded-2xl bg-slate-50 border border-slate-200/70 flex items-center justify-between gap-2 hover:bg-amber-50/50 hover:border-amber-200 transition">
                                                    <div>
                                                        <p class="font-bold text-slate-900 text-xs sm:text-sm">{{ $g['en'] }}</p>
                                                        <p class="text-[11px] text-slate-500 font-medium mt-0.5">{{ $g['id'] }}</p>
                                                    </div>
                                                    <button @click="speakText(@js($g['en']))" class="w-7 h-7 rounded-full bg-white hover:bg-amber-500 hover:text-white text-slate-600 border border-slate-200 shadow-2xs transition flex items-center justify-center shrink-0" title="Listen">
                                                        <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 24 24"><path d="M3 9v6h4l5 5V4L7 9H3zm13.5 3c0-1.77-1.02-3.29-2.5-4.03v8.05c1.48-.73 2.5-2.25 2.5-4.02z"/></svg>
                                                    </button>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>

                                <!-- Closing & Farewells Card -->
                                <div class="bg-white rounded-3xl p-5 text-slate-900 shadow-md relative overflow-hidden flex flex-col justify-between border border-slate-100">
                                    <div class="absolute top-2.5 right-4 text-slate-300">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"></path></svg>
                                    </div>
                                    <div>
                                        <div class="flex items-center gap-2 mb-4">
                                            <span class="w-2.5 h-2.5 rounded-full bg-emerald-500"></span>
                                            <h3 class="font-black text-slate-900 text-sm">Closing &amp; Farewells</h3>
                                            <span class="text-[10px] font-extrabold px-2 py-0.5 bg-emerald-50 text-emerald-700 rounded-full">Perpisahan</span>
                                        </div>
                                        <div class="space-y-2.5">
                                            @foreach($materiBlockData['greetings']['closing'] ?? [] as $g)
                                                <div class="p-3 rounded-2xl bg-slate-50 border border-slate-200/70 flex items-center justify-between gap-2 hover:bg-emerald-50/50 hover:border-emerald-200 transition">
                                                    <div>
                                                        <p class="font-bold text-slate-900 text-xs sm:text-sm">{{ $g['en'] }}</p>
                                                        <p class="text-[11px] text-slate-500 font-medium mt-0.5">{{ $g['id'] }}</p>
                                                    </div>
                                                    <button @click="speakText(@js($g['en']))" class="w-7 h-7 rounded-full bg-white hover:bg-emerald-500 hover:text-white text-slate-600 border border-slate-200 shadow-2xs transition flex items-center justify-center shrink-0" title="Listen">
                                                        <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 24 24"><path d="M3 9v6h4l5 5V4L7 9H3zm13.5 3c0-1.77-1.02-3.29-2.5-4.03v8.05c1.48-.73 2.5-2.25 2.5-4.02z"/></svg>
                                                    </button>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>

                        <!-- Section 2: Self-Introduction (Basic Templates) -->
                        <div class="bg-white rounded-[2rem] p-6 sm:p-8 shadow-sm border border-slate-200/90">
                            <div class="flex items-center gap-3 pb-4 mb-6 border-b border-slate-100">
                                <span class="w-8 h-8 rounded-xl bg-blue-600 text-white font-black text-xs flex items-center justify-center shadow-md shadow-blue-500/20">02</span>
                                <div>
                                    <h2 class="text-xl font-black text-slate-900 tracking-tight">Self-Introduction (Basic Templates)</h2>
                                    <p class="text-xs text-slate-500 font-medium">4 pilar dasar dalam memperkenalkan identitas diri secara terstruktur dan percaya diri.</p>
                                </div>
                            </div>

                            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                                @php
                                    $templateThemes = [
                                        0 => ['tag' => 'NAME', 'badge' => 'bg-[#29a8f5] text-white', 'btn' => 'bg-[#29a8f5] hover:bg-[#1e88e5] text-white', 'card' => 'bg-sky-50/40 border-sky-200 hover:border-sky-400', 'textColor' => 'text-sky-950'],
                                        1 => ['tag' => 'AGE', 'badge' => 'bg-[#ff9800] text-white', 'btn' => 'bg-[#ff9800] hover:bg-[#f57c00] text-white', 'card' => 'bg-orange-50/40 border-orange-200 hover:border-orange-400', 'textColor' => 'text-orange-950'],
                                        2 => ['tag' => 'ORIGIN', 'badge' => 'bg-[#29a8f5] text-white', 'btn' => 'bg-[#29a8f5] hover:bg-[#1e88e5] text-white', 'card' => 'bg-sky-50/40 border-sky-200 hover:border-sky-400', 'textColor' => 'text-sky-950'],
                                        3 => ['tag' => 'PROFESSION', 'badge' => 'bg-[#ff9800] text-white', 'btn' => 'bg-[#ff9800] hover:bg-[#f57c00] text-white', 'card' => 'bg-orange-50/40 border-orange-200 hover:border-orange-400', 'textColor' => 'text-orange-950'],
                                    ];
                                @endphp
                                @foreach($materiBlockData['self_intro_templates'] ?? [] as $tIdx => $t)
                                    @php $th = $templateThemes[$tIdx % 4]; @endphp
                                    <div class="p-5 rounded-3xl border {{ $th['card'] }} flex flex-col justify-between hover:shadow-md transition-all duration-200 bg-white">
                                        <div>
                                            <span class="text-[10px] font-black px-2.5 py-0.5 rounded-full {{ $th['badge'] }} uppercase tracking-wider inline-block mb-3 shadow-2xs">{{ $th['tag'] }}</span>
                                            <p class="font-mono font-bold text-slate-900 text-xs bg-slate-50 p-3 rounded-2xl border border-slate-200/80 shadow-2xs mb-2">{{ $t['pattern'] }}</p>
                                            <p class="text-xs font-semibold mt-1 {{ $th['textColor'] }}"><span class="text-slate-400 font-normal">Contoh:</span> {{ $t['example'] }}</p>
                                        </div>
                                        <button @click="speakText(@js($t['example']))" class="mt-4 w-full py-2 px-3 rounded-2xl {{ $th['btn'] }} text-xs font-bold transition flex items-center justify-center gap-1.5 shadow-sm">
                                            <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 24 24"><path d="M3 9v6h4l5 5V4L7 9H3zm13.5 3c0-1.77-1.02-3.29-2.5-4.03v8.05c1.48-.73 2.5-2.25 2.5-4.02z"/></svg>
                                            <span>Dengarkan Audio</span>
                                        </button>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <!-- Section 3 & 4: Grammar Basics & Likes/Hobbies -->
                        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                            <!-- Grammar Basics: Personal Pronouns & To Be -->
                            <div class="bg-white rounded-[2rem] p-6 sm:p-8 shadow-sm border border-slate-200/90">
                                <div class="flex items-center gap-3 pb-4 mb-5 border-b border-slate-100">
                                    <span style="background-color: #29a8f5 !important;" class="w-8 h-8 rounded-xl text-white font-black text-xs flex items-center justify-center shadow-md shadow-sky-500/20">03</span>
                                    <div>
                                        <h2 class="text-lg font-black text-slate-900 tracking-tight">Grammar: Pronouns &amp; "To Be"</h2>
                                        <p class="text-xs text-slate-500 font-medium">Subject Pronouns &amp; Verb 'To Be' (Present Simple)</p>
                                    </div>
                                </div>

                                <div class="overflow-x-auto rounded-2xl border border-slate-200">
                                    <table class="w-full text-left text-xs">
                                        <thead>
                                            <tr class="bg-slate-50 text-slate-700 font-bold uppercase text-[10px] border-b border-slate-200">
                                                <th class="py-3 px-3.5">Subject</th>
                                                <th class="py-3 px-3.5">To Be</th>
                                                <th class="py-3 px-3.5">Contraction</th>
                                                <th class="py-3 px-3.5">Example</th>
                                            </tr>
                                        </thead>
                                        <tbody class="divide-y divide-slate-100 font-medium bg-white">
                                            @foreach($materiBlockData['grammar_basics']['to_be_conjugations'] ?? [] as $tb)
                                                @php
                                                    if ($tb['to_be'] === 'am') {
                                                        $subjClass = 'bg-sky-50 text-sky-800 border-sky-200';
                                                        $toBeClass = 'bg-[#29a8f5] text-white';
                                                        $textClass = 'text-sky-950';
                                                    } elseif ($tb['to_be'] === 'is') {
                                                        $subjClass = 'bg-orange-50 text-orange-800 border-orange-200';
                                                        $toBeClass = 'bg-[#ff9800] text-white';
                                                        $textClass = 'text-orange-950';
                                                    } else {
                                                        $subjClass = 'bg-sky-50 text-sky-800 border-sky-200';
                                                        $toBeClass = 'bg-[#29a8f5] text-white';
                                                        $textClass = 'text-sky-950';
                                                    }
                                                @endphp
                                                <tr class="hover:bg-slate-50 transition">
                                                    <td class="py-2.5 px-3.5 font-black">
                                                        <span class="px-2.5 py-0.5 rounded-lg border {{ $subjClass }} shadow-2xs">{{ $tb['subject'] }}</span>
                                                    </td>
                                                    <td class="py-2.5 px-3.5">
                                                        <span class="px-2.5 py-0.5 rounded-lg font-black shadow-2xs {{ $toBeClass }}">
                                                             {{ $tb['to_be'] }}
                                                        </span>
                                                    </td>
                                                    <td class="py-2.5 px-3.5 font-mono font-black {{ $textClass }}">{{ $tb['contraction'] }}</td>
                                                    <td class="py-2.5 px-3.5 flex items-center justify-between gap-1">
                                                        <span class="font-bold {{ $textClass }}">{{ $tb['example'] }}</span>
                                                        <button @click="speakText(@js($tb['example']))" class="w-6 h-6 rounded-full bg-slate-100 hover:bg-[#29a8f5] hover:text-white text-slate-600 p-1 transition flex items-center justify-center shrink-0 shadow-2xs" title="Play">
                                                            <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 24 24"><path d="M3 9v6h4l5 5V4L7 9H3zm13.5 3c0-1.77-1.02-3.29-2.5-4.03v8.05c1.48-.73 2.5-2.25 2.5-4.02z"/></svg>
                                                        </button>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <!-- Likes & Hobbies (A2 Focus) -->
                            <div class="bg-white rounded-[2rem] p-6 sm:p-8 shadow-sm border border-slate-200/90">
                                <div class="flex items-center gap-3 pb-4 mb-5 border-b border-slate-100">
                                    <span style="background-color: #ff9800 !important;" class="w-8 h-8 rounded-xl text-white font-black text-xs flex items-center justify-center shadow-md shadow-orange-500/20">04</span>
                                    <div>
                                        <h2 class="text-lg font-black text-slate-900 tracking-tight">Likes &amp; Hobbies (A2 Focus)</h2>
                                        <p class="text-xs text-slate-500 font-medium">Mengekspresikan kesukaan dan aktivitas favorit</p>
                                    </div>
                                </div>

                                <div class="p-4 rounded-2xl bg-slate-50 border border-slate-200 mb-4">
                                    <p class="text-[10px] font-black text-slate-600 uppercase tracking-wider mb-2.5">Pola Kalimat Utama:</p>
                                    <div class="space-y-2 text-xs font-bold font-mono">
                                        <p class="bg-sky-50/90 px-3.5 py-2 rounded-xl border border-sky-200 text-sky-950 shadow-2xs">
                                            • <span class="text-sky-700 font-black">I like</span> + <span class="px-2 py-0.5 rounded-lg bg-sky-100 text-sky-900 border border-sky-300 font-mono font-bold">[Noun / V-ing]</span>
                                        </p>
                                        <p class="bg-orange-50/90 px-3.5 py-2 rounded-xl border border-orange-200 text-orange-950 shadow-2xs">
                                            • <span class="text-orange-700 font-black">I don't like</span> + <span class="px-2 py-0.5 rounded-lg bg-orange-100 text-orange-900 border border-orange-300 font-mono font-bold">[Noun / V-ing]</span>
                                        </p>
                                        <p class="bg-sky-50/90 px-3.5 py-2 rounded-xl border border-sky-200 text-sky-950 shadow-2xs">
                                            • <span class="text-sky-700 font-black">I enjoy</span> + <span class="px-2 py-0.5 rounded-lg bg-sky-100 text-sky-900 border border-sky-300 font-mono font-bold">[V-ing]</span>
                                        </p>
                                    </div>
                                </div>

                                <div class="space-y-2.5">
                                    @php
                                        $hobbyThemes = [
                                            0 => ['card' => 'bg-sky-50/40 border-sky-200 hover:bg-sky-50/80', 'title' => 'text-sky-950', 'id' => 'text-sky-700', 'btn' => 'hover:bg-[#29a8f5] hover:text-white text-sky-700 border-sky-200'],
                                            1 => ['card' => 'bg-orange-50/40 border-orange-200 hover:bg-orange-50/80', 'title' => 'text-orange-950', 'id' => 'text-orange-700', 'btn' => 'hover:bg-[#ff9800] hover:text-white text-orange-700 border-orange-200'],
                                            2 => ['card' => 'bg-sky-50/40 border-sky-200 hover:bg-sky-50/80', 'title' => 'text-sky-950', 'id' => 'text-sky-700', 'btn' => 'hover:bg-[#29a8f5] hover:text-white text-sky-700 border-sky-200'],
                                        ];
                                    @endphp
                                    @foreach($materiBlockData['likes_hobbies']['examples'] ?? [] as $exIdx => $ex)
                                        @php $hth = $hobbyThemes[$exIdx % 3]; @endphp
                                        <div class="p-3.5 rounded-2xl border {{ $hth['card'] }} flex items-center justify-between gap-2 transition bg-white shadow-2xs">
                                            <div>
                                                <p class="font-black {{ $hth['title'] }} text-xs sm:text-sm">{{ $ex['en'] }}</p>
                                                <p class="text-xs {{ $hth['id'] }} font-semibold italic mt-0.5">{{ $ex['id'] }}</p>
                                            </div>
                                            <button @click="speakText(@js($ex['en']))" class="w-7 h-7 rounded-full bg-white {{ $hth['btn'] }} border transition flex items-center justify-center shrink-0 shadow-2xs" title="Listen">
                                                <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 24 24"><path d="M3 9v6h4l5 5V4L7 9H3zm13.5 3c0-1.77-1.02-3.29-2.5-4.03v8.05c1.48-.73 2.5-2.25 2.5-4.02z"/></svg>
                                            </button>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>

                        <!-- Section 5: Complete Self-Introduction Example (Template & Example) -->
                        <div class="bg-white rounded-[2rem] p-6 sm:p-8 shadow-sm border border-slate-200/90">
                            <div class="flex items-center gap-3 pb-4 mb-6 border-b border-slate-100">
                                <span style="background-color: #29a8f5 !important;" class="w-8 h-8 rounded-xl text-white font-black text-xs flex items-center justify-center shadow-md shadow-sky-500/20">05</span>
                                <div>
                                    <h2 class="text-xl font-black text-slate-900 tracking-tight">Complete Self-Introduction Formula</h2>
                                    <p class="text-xs text-slate-500 font-medium">Template lengkap &amp; studi kasus perkenalan diri komprehensif.</p>
                                </div>
                            </div>

                            @php
                                $templateFormatted = e($materiBlockData['template'] ?? '');
                                $templateFormatted = str_replace(
                                    ['[Full Name]', '[Age]', '[Nick Name]', '[City/Country]', '[Profession]', '[Hobbies/Likes]'],
                                    [
                                        '<span class="px-2 py-0.5 rounded-lg bg-sky-100 text-sky-900 border border-sky-300 font-bold">[Full Name]</span>',
                                        '<span class="px-2 py-0.5 rounded-lg bg-orange-100 text-orange-900 border border-orange-300 font-bold">[Age]</span>',
                                        '<span class="px-2 py-0.5 rounded-lg bg-sky-100 text-sky-900 border border-sky-300 font-bold">[Nick Name]</span>',
                                        '<span class="px-2 py-0.5 rounded-lg bg-orange-100 text-orange-900 border border-orange-300 font-bold">[City/Country]</span>',
                                        '<span class="px-2 py-0.5 rounded-lg bg-sky-100 text-sky-900 border border-sky-300 font-bold">[Profession]</span>',
                                        '<span class="px-2 py-0.5 rounded-lg bg-orange-100 text-orange-900 border border-orange-300 font-bold">[Hobbies/Likes]</span>',
                                    ],
                                    $templateFormatted
                                );

                                $exampleFormatted = e($materiBlockData['example'] ?? '');
                                $exampleFormatted = str_replace(
                                    ['Budi Sugeng', '20 years old', 'Budi', 'Jakarta, Indonesia', 'an English teacher', 'reading books and playing football'],
                                    [
                                        '<span class="px-2 py-0.5 rounded-lg bg-sky-100 text-sky-900 border border-sky-200 font-bold">Budi Sugeng</span>',
                                        '<span class="px-2 py-0.5 rounded-lg bg-orange-100 text-orange-900 border border-orange-200 font-bold">20 years old</span>',
                                        '<span class="px-2 py-0.5 rounded-lg bg-sky-100 text-sky-900 border border-sky-200 font-bold">Budi</span>',
                                        '<span class="px-2 py-0.5 rounded-lg bg-orange-100 text-orange-900 border border-orange-200 font-bold">Jakarta, Indonesia</span>',
                                        '<span class="px-2 py-0.5 rounded-lg bg-sky-100 text-sky-900 border border-sky-200 font-bold">an English teacher</span>',
                                        '<span class="px-2 py-0.5 rounded-lg bg-orange-100 text-orange-900 border border-orange-200 font-bold">reading books and playing football</span>',
                                    ],
                                    $exampleFormatted
                                );
                            @endphp

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <!-- Template Box (Blue Theme) -->
                                <div class="p-6 sm:p-7 rounded-3xl bg-sky-50/50 border-2 border-sky-200 shadow-sm flex flex-col justify-between">
                                    <div>
                                        <div class="flex items-center justify-between mb-4 pb-3 border-b border-sky-200/80">
                                            <div class="flex items-center gap-2">
                                                <span class="text-xs font-black text-sky-950 uppercase tracking-wider">Template Formula</span>
                                            </div>
                                            <span style="background-color: #29a8f5 !important;" class="text-[11px] font-black font-mono text-white px-3 py-1 rounded-full shadow-xs">Blueprint</span>
                                        </div>
                                        <div class="bg-white p-5 rounded-2xl border border-sky-100 shadow-xs">
                                            <p class="text-xs sm:text-sm text-sky-950 leading-relaxed font-mono whitespace-pre-line font-medium">
{!! nl2br($templateFormatted) !!}
                                            </p>
                                        </div>
                                    </div>
                                    <div class="mt-4 pt-3 border-t border-sky-200/60 flex items-center justify-between text-[11px] font-bold text-sky-700">
                                        <span>Kerangka dasar yang bisa diisi informasi pribadimu</span>
                                    </div>
                                </div>

                                <!-- Example Box (Orange Theme) -->
                                <div class="p-6 sm:p-7 rounded-3xl bg-orange-50/50 border-2 border-orange-200 shadow-sm flex flex-col justify-between">
                                    <div>
                                        <div class="flex items-center justify-between mb-4 pb-3 border-b border-orange-200/80">
                                            <div class="flex items-center gap-2">
                                                <span class="text-xs font-black text-orange-950 uppercase tracking-wider">Studi Kasus Nyata</span>
                                            </div>
                                            <span style="background-color: #ff9800 !important;" class="px-3 py-1 rounded-full text-xs font-black text-white shadow-xs">Budi Sugeng</span>
                                        </div>
                                        <div class="bg-white p-5 rounded-2xl border border-orange-100 shadow-xs">
                                            <p class="text-xs sm:text-sm text-slate-900 leading-relaxed font-semibold whitespace-pre-line">
{!! nl2br($exampleFormatted) !!}
                                            </p>
                                        </div>
                                    </div>

                                    <div class="mt-5">
                                        <button @click="togglePlayAudio(@js($materiBlockData['example']), 'male')"
                                            type="button"
                                            class="w-full py-3.5 px-5 rounded-2xl font-black text-sm shadow-md transition flex items-center justify-center gap-2.5 text-white"
                                            :class="isPlaying ? 'bg-red-600 hover:bg-red-700 animate-pulse shadow-red-500/30' : 'bg-teal-600 hover:bg-teal-700 shadow-teal-500/25 hover:scale-[1.01]'">
                                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M8 5v14l11-7z"/></svg>
                                            <span x-text="isPlaying ? 'Stop Audio' : 'Dengarkan Contoh Audio (Budi Sugeng)'"></span>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @elseif(isset($materiBlockData['pronouns_mastery']))
                        <!-- ==================================================== -->
                        <!-- MEETING 5: PRONOUNS MASTERY (ALL 5 CATEGORIES)       -->
                        <!-- ==================================================== -->
                        <div class="space-y-8" x-data="{ pronounSubTab: 'matrix', activeRowIdx: null }">
                            
                            <!-- 1. SIGNATURE HERO SHOWCASE BOX -->
                            <div style="background-color: #29a8f5 !important;" class="rounded-[2.5rem] p-6 sm:p-10 text-white shadow-xl relative overflow-hidden">
                                <div class="relative z-10 mb-8 flex flex-col md:flex-row md:items-center justify-between gap-4">
                                    <div>
                                        <div class="flex items-center gap-2 flex-wrap mb-1">
                                            <span class="px-3.5 py-1 rounded-full bg-white/20 text-xs font-black uppercase tracking-wider text-white backdrop-blur-md">
                                                Modul 05 • Pronouns Masterclass
                                            </span>
                                            <span class="px-3 py-1 rounded-full bg-amber-400 text-slate-950 text-xs font-black uppercase">
                                                5 Core Forms
                                            </span>
                                        </div>
                                        <h2 class="text-2xl sm:text-4xl font-black tracking-tight mt-1 text-white">English Pronouns Mastery (Kata Ganti)</h2>
                                        <p class="text-xs sm:text-sm text-sky-100 font-medium mt-1 max-w-3xl leading-relaxed">
                                            {{ $materiBlockData['overview'] ?? 'Kuasai 5 bentuk kata ganti bahasa Inggris (Subject, Object, Possessive Adjective, Possessive Pronoun, & Reflexive) untuk percakapan alami, akurat, dan bebas pengulangan.' }}
                                        </p>
                                    </div>
                                    <button @click="speakText('I, me, my, mine, myself. You, you, your, yours, yourself. He, him, his, his, himself. She, her, her, hers, herself. It, it, its, itself. We, us, our, ours, ourselves. They, them, their, theirs, themselves.')"
                                        type="button" class="px-5 py-3 rounded-2xl bg-amber-400 hover:bg-amber-300 text-slate-950 font-black text-xs sm:text-sm shadow-md transition flex items-center gap-2 shrink-0 self-start md:self-auto">
                                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M3 9v6h4l5 5V4L7 9H3zm13.5 3c0-1.77-1.02-3.29-2.5-4.03v8.05c1.48-.73 2.5-2.25 2.5-4.02z"/></svg>
                                        <span>Lafalkan Semua Pronoun</span>
                                    </button>
                                </div>

                                <!-- Sub-Tab Navigation Switcher inside Hero -->
                                <div class="relative z-10 flex flex-wrap items-center gap-2 bg-white/15 backdrop-blur-md p-2 rounded-2xl border border-white/25">
                                    <button @click="pronounSubTab = 'matrix'"
                                        :class="pronounSubTab === 'matrix' ? 'bg-white text-slate-900 font-black shadow-md' : 'text-white hover:bg-white/15 font-bold'"
                                        class="px-4 py-2 rounded-xl text-xs sm:text-sm transition flex items-center gap-1.5">
                                        <span>📊</span> <span>1. Master Matrix Chart</span>
                                    </button>
                                    <button @click="pronounSubTab = 'categories'"
                                        :class="pronounSubTab === 'categories' ? 'bg-white text-slate-900 font-black shadow-md' : 'text-white hover:bg-white/15 font-bold'"
                                        class="px-4 py-2 rounded-xl text-xs sm:text-sm transition flex items-center gap-1.5">
                                        <span>🗂️</span> <span>2. 5 Kategori Deep-Dive</span>
                                    </button>
                                    <button @click="pronounSubTab = 'pitfalls'"
                                        :class="pronounSubTab === 'pitfalls' ? 'bg-white text-slate-900 font-black shadow-md' : 'text-white hover:bg-white/15 font-bold'"
                                        class="px-4 py-2 rounded-xl text-xs sm:text-sm transition flex items-center gap-1.5">
                                        <span>⚡</span> <span>3. Top 5 Jebakan Percakapan</span>
                                    </button>
                                    <button @click="pronounSubTab = 'demonstratives'"
                                        :class="pronounSubTab === 'demonstratives' ? 'bg-white text-slate-900 font-black shadow-md' : 'text-white hover:bg-white/15 font-bold'"
                                        class="px-4 py-2 rounded-xl text-xs sm:text-sm transition flex items-center gap-1.5">
                                        <span>👉</span> <span>4. Demonstratives (This/That)</span>
                                    </button>
                                </div>
                            </div>

                            <!-- SUB-TAB 1: MASTER MATRIX TABLE -->
                            <div x-show="pronounSubTab === 'matrix'" class="space-y-6">
                                <div class="bg-white rounded-[2rem] p-6 sm:p-8 shadow-sm border border-slate-200/90 overflow-hidden">
                                    <div class="flex flex-col sm:flex-row sm:items-center justify-between pb-6 mb-6 border-b border-slate-100 gap-3">
                                        <div>
                                            <div class="flex items-center gap-2 mb-1">
                                                <span class="px-2.5 py-0.5 rounded-full bg-blue-100 text-blue-700 text-xs font-black">Interactive Chart</span>
                                                <span class="text-xs text-slate-400 font-medium">• Klik icon 🔊 pada setiap kata untuk mendengar pelafalannya</span>
                                            </div>
                                            <h3 class="text-xl sm:text-2xl font-black text-slate-900">Tabel Komparasi Master Pronoun (7 Orang / Persons)</h3>
                                        </div>
                                    </div>

                                    <!-- Table Container (Horizontal Scroll on Mobile) -->
                                    <div class="overflow-x-auto rounded-2xl border border-slate-200">
                                        <table class="w-full text-left border-collapse min-w-[760px]">
                                            <thead>
                                                <tr class="bg-slate-900 text-white text-xs font-black uppercase tracking-wider">
                                                    <th class="p-4 border-r border-slate-800">Person / Pelaku</th>
                                                    <th class="p-4 border-r border-slate-800 bg-indigo-950/80 text-indigo-200">
                                                        <div class="flex flex-col">
                                                            <span>Subject</span>
                                                            <span class="text-[10px] text-indigo-300 font-normal lowercase">(sebelum verb)</span>
                                                        </div>
                                                    </th>
                                                    <th class="p-4 border-r border-slate-800 bg-emerald-950/80 text-emerald-200">
                                                        <div class="flex flex-col">
                                                            <span>Object</span>
                                                            <span class="text-[10px] text-emerald-300 font-normal lowercase">(setelah verb/prep)</span>
                                                        </div>
                                                    </th>
                                                    <th class="p-4 border-r border-slate-800 bg-amber-950/80 text-amber-200">
                                                        <div class="flex flex-col">
                                                            <span>Possessive Adj</span>
                                                            <span class="text-[10px] text-amber-300 font-normal lowercase">(+ NOUN wajib)</span>
                                                        </div>
                                                    </th>
                                                    <th class="p-4 border-r border-slate-800 bg-purple-950/80 text-purple-200">
                                                        <div class="flex flex-col">
                                                            <span>Possessive Pronoun</span>
                                                            <span class="text-[10px] text-purple-300 font-normal lowercase">(tanpa NOUN)</span>
                                                        </div>
                                                    </th>
                                                    <th class="p-4 bg-rose-950/80 text-rose-200">
                                                        <div class="flex flex-col">
                                                            <span>Reflexive</span>
                                                            <span class="text-[10px] text-rose-300 font-normal lowercase">(diri sendiri)</span>
                                                        </div>
                                                    </th>
                                                </tr>
                                            </thead>
                                            <tbody class="divide-y divide-slate-100 text-xs sm:text-sm font-semibold text-slate-700">
                                                @foreach($materiBlockData['matrix'] ?? [] as $mIdx => $row)
                                                    <tr class="hover:bg-blue-50/50 transition" :class="activeRowIdx === {{ $mIdx }} ? 'bg-blue-50/80' : ''" @mouseenter="activeRowIdx = {{ $mIdx }}" @mouseleave="activeRowIdx = null">
                                                        <!-- Person Column -->
                                                        <td class="p-4 border-r border-slate-100 font-black text-slate-900 bg-slate-50/80">
                                                            <div class="flex items-center justify-between gap-2">
                                                                <span>{{ $row['person'] }}</span>
                                                                <button @click="speakText('{{ $row['subject']['word'] }}, {{ $row['object']['word'] }}, {{ $row['possessive_adj']['word'] }}, {{ $row['possessive_pro']['word'] }}, {{ $row['reflexive']['word'] }}')" 
                                                                    class="p-1 rounded-lg bg-blue-100 hover:bg-blue-600 hover:text-white text-blue-700 transition" title="Lafalkan sebaris">
                                                                    <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 24 24"><path d="M3 9v6h4l5 5V4L7 9H3zm13.5 3c0-1.77-1.02-3.29-2.5-4.03v8.05c1.48-.73 2.5-2.25 2.5-4.02z"/></svg>
                                                                </button>
                                                            </div>
                                                        </td>

                                                        <!-- Subject -->
                                                        <td class="p-4 border-r border-slate-100 bg-indigo-50/30">
                                                            <div class="flex items-center justify-between gap-2">
                                                                <div>
                                                                    <span class="font-black text-indigo-700 text-base">{{ $row['subject']['word'] }}</span>
                                                                    <span class="text-[11px] font-mono text-slate-400 block">{{ $row['subject']['ipa'] }}</span>
                                                                </div>
                                                                <button @click="speakText(@js($row['subject']['example']))" class="p-1.5 rounded-lg bg-indigo-100 hover:bg-indigo-600 hover:text-white text-indigo-700 transition" title="Dengarkan contoh kalimat">
                                                                    <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 24 24"><path d="M3 9v6h4l5 5V4L7 9H3zm13.5 3c0-1.77-1.02-3.29-2.5-4.03v8.05c1.48-.73 2.5-2.25 2.5-4.02z"/></svg>
                                                                </button>
                                                            </div>
                                                        </td>

                                                        <!-- Object -->
                                                        <td class="p-4 border-r border-slate-100 bg-emerald-50/30">
                                                            <div class="flex items-center justify-between gap-2">
                                                                <div>
                                                                    <span class="font-black text-emerald-700 text-base">{{ $row['object']['word'] }}</span>
                                                                    <span class="text-[11px] font-mono text-slate-400 block">{{ $row['object']['ipa'] }}</span>
                                                                </div>
                                                                <button @click="speakText(@js($row['object']['example']))" class="p-1.5 rounded-lg bg-emerald-100 hover:bg-emerald-600 hover:text-white text-emerald-700 transition" title="Dengarkan contoh kalimat">
                                                                    <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 24 24"><path d="M3 9v6h4l5 5V4L7 9H3zm13.5 3c0-1.77-1.02-3.29-2.5-4.03v8.05c1.48-.73 2.5-2.25 2.5-4.02z"/></svg>
                                                                </button>
                                                            </div>
                                                        </td>

                                                        <!-- Possessive Adj -->
                                                        <td class="p-4 border-r border-slate-100 bg-amber-50/30">
                                                            <div class="flex items-center justify-between gap-2">
                                                                <div>
                                                                    <span class="font-black text-amber-700 text-base">{{ $row['possessive_adj']['word'] }}</span>
                                                                    <span class="text-[11px] font-mono text-slate-400 block">{{ $row['possessive_adj']['ipa'] }}</span>
                                                                </div>
                                                                <button @click="speakText(@js($row['possessive_adj']['example']))" class="p-1.5 rounded-lg bg-amber-100 hover:bg-amber-600 hover:text-white text-amber-700 transition" title="Dengarkan contoh kalimat">
                                                                    <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 24 24"><path d="M3 9v6h4l5 5V4L7 9H3zm13.5 3c0-1.77-1.02-3.29-2.5-4.03v8.05c1.48-.73 2.5-2.25 2.5-4.02z"/></svg>
                                                                </button>
                                                            </div>
                                                        </td>

                                                        <!-- Possessive Pronoun -->
                                                        <td class="p-4 border-r border-slate-100 bg-purple-50/30">
                                                            <div class="flex items-center justify-between gap-2">
                                                                <div>
                                                                    <span class="font-black text-purple-700 text-base">{{ $row['possessive_pro']['word'] }}</span>
                                                                    <span class="text-[11px] font-mono text-slate-400 block">{{ $row['possessive_pro']['ipa'] }}</span>
                                                                </div>
                                                                <button @click="speakText(@js($row['possessive_pro']['example']))" class="p-1.5 rounded-lg bg-purple-100 hover:bg-purple-600 hover:text-white text-purple-700 transition" title="Dengarkan contoh kalimat">
                                                                    <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 24 24"><path d="M3 9v6h4l5 5V4L7 9H3zm13.5 3c0-1.77-1.02-3.29-2.5-4.03v8.05c1.48-.73 2.5-2.25 2.5-4.02z"/></svg>
                                                                </button>
                                                            </div>
                                                        </td>

                                                        <!-- Reflexive -->
                                                        <td class="p-4 bg-rose-50/30">
                                                            <div class="flex items-center justify-between gap-2">
                                                                <div>
                                                                    <span class="font-black text-rose-700 text-base">{{ $row['reflexive']['word'] }}</span>
                                                                    <span class="text-[11px] font-mono text-slate-400 block">{{ $row['reflexive']['ipa'] }}</span>
                                                                </div>
                                                                <button @click="speakText(@js($row['reflexive']['example']))" class="p-1.5 rounded-lg bg-rose-100 hover:bg-rose-600 hover:text-white text-rose-700 transition" title="Dengarkan contoh kalimat">
                                                                    <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 24 24"><path d="M3 9v6h4l5 5V4L7 9H3zm13.5 3c0-1.77-1.02-3.29-2.5-4.03v8.05c1.48-.73 2.5-2.25 2.5-4.02z"/></svg>
                                                                </button>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>

                                    <!-- Quick Summary Formula Banner -->
                                    <div class="mt-6 p-5 rounded-2xl bg-gradient-to-r from-blue-50 to-indigo-50 border border-blue-200 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                                        <div class="flex items-center gap-3">
                                            <span class="text-2xl">💡</span>
                                            <div class="text-xs sm:text-sm text-slate-700">
                                                <strong>Rumus Cepat:</strong> <em>Subject</em> melakukan tindakan, <em>Object</em> menerima tindakan, <em>Possessive Adj</em> menempel di depan benda (my bag), <em>Possessive Pronoun</em> menggantikan benda (the bag is mine), dan <em>Reflexive</em> merujuk ke diri sendiri (myself).
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- SUB-TAB 2: 5 CATEGORIES DEEP DIVE -->
                            <div x-show="pronounSubTab === 'categories'" class="space-y-6">
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    @foreach($materiBlockData['categories'] ?? [] as $cat)
                                        @php
                                            $borderClr = match($cat['color'] ?? 'blue') {
                                                'indigo' => 'border-indigo-200 hover:border-indigo-400 bg-indigo-50/20',
                                                'emerald' => 'border-emerald-200 hover:border-emerald-400 bg-emerald-50/20',
                                                'amber' => 'border-amber-200 hover:border-amber-400 bg-amber-50/20',
                                                'purple' => 'border-purple-200 hover:border-purple-400 bg-purple-50/20',
                                                'rose' => 'border-rose-200 hover:border-rose-400 bg-rose-50/20',
                                                default => 'border-slate-200 hover:border-blue-400 bg-white'
                                            };
                                            $badgeClr = match($cat['color'] ?? 'blue') {
                                                'indigo' => 'bg-indigo-600 text-white',
                                                'emerald' => 'bg-emerald-600 text-white',
                                                'amber' => 'bg-amber-500 text-white',
                                                'purple' => 'bg-purple-600 text-white',
                                                'rose' => 'bg-rose-600 text-white',
                                                default => 'bg-blue-600 text-white'
                                            };
                                        @endphp
                                        <div class="rounded-3xl p-6 sm:p-7 border-2 {{ $borderClr }} shadow-sm bg-white transition flex flex-col justify-between space-y-4">
                                            <div>
                                                <div class="flex items-center justify-between gap-2 mb-2">
                                                    <span class="px-3 py-1 rounded-full text-xs font-black {{ $badgeClr }}">
                                                        {{ $cat['badge'] }}
                                                    </span>
                                                    <span class="text-xs font-bold text-slate-500">{{ $cat['tagline'] }}</span>
                                                </div>
                                                <h3 class="text-lg sm:text-xl font-black text-slate-900 mt-2">{{ $cat['title'] }}</h3>
                                                <p class="text-xs sm:text-sm text-slate-600 mt-2 leading-relaxed">{{ $cat['explanation'] }}</p>

                                                <!-- Formula Box -->
                                                <div class="mt-4 p-3 rounded-xl bg-slate-900 text-amber-300 font-mono text-xs font-bold shadow-inner">
                                                    {{ $cat['formula'] }}
                                                </div>

                                                <!-- Items Pill List -->
                                                <div class="mt-3 flex flex-wrap gap-1.5">
                                                    @foreach($cat['items'] ?? [] as $itm)
                                                        <span class="px-2.5 py-1 rounded-lg bg-slate-100 text-slate-800 font-black text-xs">
                                                            {{ $itm }}
                                                        </span>
                                                    @endforeach
                                                </div>

                                                <!-- Examples List -->
                                                <div class="mt-4 space-y-2">
                                                    <div class="text-[11px] font-black uppercase tracking-wider text-slate-400">Contoh Kalimat:</div>
                                                    @foreach($cat['examples'] ?? [] as $ex)
                                                        <div class="p-2.5 rounded-xl bg-slate-50 border border-slate-100 flex items-start justify-between gap-2">
                                                            <div>
                                                                <div class="text-xs sm:text-sm font-bold text-slate-900">{{ $ex['en'] }}</div>
                                                                <div class="text-xs text-slate-500 mt-0.5">{{ $ex['id'] }}</div>
                                                            </div>
                                                            <button @click="speakText(@js($ex['en']))" class="p-1 rounded-lg bg-white border border-slate-200 text-slate-600 hover:text-blue-600 hover:border-blue-300 transition shrink-0">
                                                                <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 24 24"><path d="M3 9v6h4l5 5V4L7 9H3zm13.5 3c0-1.77-1.02-3.29-2.5-4.03v8.05c1.48-.73 2.5-2.25 2.5-4.02z"/></svg>
                                                            </button>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>

                                            <!-- Golden Rule Footer -->
                                            <div class="pt-3 border-t border-slate-100 text-[11px] sm:text-xs font-semibold text-slate-600 flex items-start gap-2">
                                                <span class="text-amber-500 font-bold shrink-0">📌 Note:</span>
                                                <span>{{ $cat['rule'] }}</span>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>

                            <!-- SUB-TAB 3: TOP 5 SPOKEN PITFALLS -->
                            <div x-show="pronounSubTab === 'pitfalls'" class="space-y-6">
                                <div class="bg-white rounded-[2rem] p-6 sm:p-8 shadow-sm border border-slate-200/90">
                                    <div class="pb-6 mb-6 border-b border-slate-100">
                                        <span class="px-3 py-1 rounded-full bg-rose-100 text-rose-700 text-xs font-black uppercase">Spoken Pitfalls</span>
                                        <h3 class="text-xl sm:text-2xl font-black text-slate-900 mt-2">5 Kesalahan Percakapan Pronoun yang Paling Sering Terjadi</h3>
                                        <p class="text-xs sm:text-sm text-slate-500 font-medium mt-1">Hindari kekeliruan ini agar kemampuan berbicara bahasa Inggris Anda terdengar profesional dan natural.</p>
                                    </div>

                                    <div class="space-y-4">
                                        @foreach($materiBlockData['pitfalls'] ?? [] as $pIdx => $pitfall)
                                            <div class="p-5 rounded-2xl bg-slate-50 border border-slate-200 hover:border-blue-300 transition space-y-3">
                                                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2">
                                                    <div class="flex items-center gap-2">
                                                        <span class="w-6 h-6 rounded-full bg-slate-900 text-white font-black text-xs flex items-center justify-center">{{ $pIdx + 1 }}</span>
                                                        <h4 class="font-black text-slate-900 text-base">{!! $pitfall['title'] !!}</h4>
                                                    </div>
                                                    <span class="px-2.5 py-0.5 rounded-full bg-amber-100 text-amber-800 text-[10px] font-extrabold uppercase self-start sm:self-auto">{{ $pitfall['badge'] }}</span>
                                                </div>
                                                <p class="text-xs sm:text-sm text-slate-600 leading-relaxed">{!! $pitfall['desc'] !!}</p>

                                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 pt-1">
                                                    <!-- Wrong Box -->
                                                    <div class="p-3 rounded-xl bg-red-50 border border-red-200 flex items-start gap-2">
                                                        <span class="text-red-600 font-black text-base shrink-0">❌</span>
                                                        <div>
                                                            <div class="text-[10px] font-black uppercase text-red-600 tracking-wider">Kurang Tepat / Salah:</div>
                                                            <div class="text-xs sm:text-sm font-semibold text-red-950 line-through decoration-red-500">{{ $pitfall['wrong'] }}</div>
                                                        </div>
                                                    </div>

                                                    <!-- Correct Box -->
                                                    <div class="p-3 rounded-xl bg-emerald-50 border border-emerald-200 flex items-start justify-between gap-2">
                                                        <div class="flex items-start gap-2">
                                                            <span class="text-emerald-600 font-black text-base shrink-0">✅</span>
                                                            <div>
                                                                <div class="text-[10px] font-black uppercase text-emerald-700 tracking-wider">Tepat / Alami:</div>
                                                                <div class="text-xs sm:text-sm font-bold text-emerald-950">{{ $pitfall['correct'] }}</div>
                                                            </div>
                                                        </div>
                                                        <button @click="speakText(@js($pitfall['correct']))" class="p-1.5 rounded-lg bg-white border border-emerald-300 text-emerald-700 hover:bg-emerald-600 hover:text-white transition shrink-0" title="Dengarkan pengucapan yang benar">
                                                            <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 24 24"><path d="M3 9v6h4l5 5V4L7 9H3zm13.5 3c0-1.77-1.02-3.29-2.5-4.03v8.05c1.48-.73 2.5-2.25 2.5-4.02z"/></svg>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>

                            <!-- SUB-TAB 4: DEMONSTRATIVE PRONOUNS -->
                            <div x-show="pronounSubTab === 'demonstratives'" class="space-y-6">
                                <div class="bg-white rounded-[2rem] p-6 sm:p-8 shadow-sm border border-slate-200/90">
                                    <div class="pb-6 mb-6 border-b border-slate-100 flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                                        <div>
                                            <span class="px-3 py-1 rounded-full bg-indigo-100 text-indigo-700 text-xs font-black uppercase">Bonus Topic</span>
                                            <h3 class="text-xl sm:text-2xl font-black text-slate-900 mt-2">Demonstratives (This, That, These, Those)</h3>
                                            <p class="text-xs sm:text-sm text-slate-500 font-medium mt-1">Kata penunjuk jarak fisik/waktu (Dekat vs Jauh) dan jumlah benda (Tunggal vs Jamak).</p>
                                        </div>
                                    </div>

                                    <!-- 2x2 Matrix Grid for Demonstratives -->
                                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                                        @foreach($materiBlockData['demonstratives']['items'] ?? [] as $dem)
                                            <div class="p-6 rounded-3xl bg-slate-50 border-2 border-slate-200 hover:border-indigo-400 hover:shadow-md transition space-y-3">
                                                <div class="flex items-center justify-between gap-2">
                                                    <div class="flex items-center gap-2">
                                                        <h4 class="text-2xl font-black text-indigo-700">{{ $dem['word'] }}</h4>
                                                        <span class="text-xs font-mono font-bold text-slate-400">{{ $dem['ipa'] }}</span>
                                                    </div>
                                                    <span class="px-3 py-1 rounded-full bg-indigo-100 text-indigo-800 text-xs font-extrabold">{{ $dem['type'] }}</span>
                                                </div>
                                                <div class="text-sm font-bold text-slate-800">{{ $dem['meaning'] }}</div>
                                                <div class="p-3 rounded-xl bg-white border border-slate-200 flex items-center justify-between gap-2">
                                                    <div class="text-xs sm:text-sm font-semibold text-slate-700 italic">"{{ $dem['example'] }}"</div>
                                                    <button @click="speakText(@js($dem['example']))" class="p-1.5 rounded-lg bg-indigo-50 hover:bg-indigo-600 hover:text-white text-indigo-700 transition shrink-0">
                                                        <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 24 24"><path d="M3 9v6h4l5 5V4L7 9H3zm13.5 3c0-1.77-1.02-3.29-2.5-4.03v8.05c1.48-.73 2.5-2.25 2.5-4.02z"/></svg>
                                                    </button>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="p-6 rounded-3xl bg-white border border-slate-200 text-center">
                            <p class="text-slate-600 font-medium">Materi pembelajaran interaktif tersedia pada meeting ini.</p>
                        </div>
                    @endif
                </div>
                @endforeach

                <!-- ========================================== -->
                <!-- TAB 2: SHORT LISTENING & QUIZ           -->
                <!-- ========================================== -->
                <div x-show="activeTab === 'listening'" class="space-y-6">
                    <div class="bg-white rounded-[2rem] p-6 sm:p-8 shadow-sm border border-slate-200/90">
                        <div class="flex flex-col md:flex-row md:items-center justify-between pb-6 mb-6 border-b border-slate-100 gap-4">
                            <div>
                                <div class="flex items-center gap-2 mb-1">
                                    <span class="px-3 py-0.5 rounded-full text-xs font-black bg-blue-600 text-white shadow-2xs">
                                        Short Listening Practice
                                    </span>
                                </div>
                                <h2 class="text-xl sm:text-2xl font-black text-slate-900 tracking-tight mt-1">
                                    {{ $meetingData['listening']['title'] ?? 'Listening Audio Practice' }}
                                </h2>
                                <p class="text-xs sm:text-sm text-slate-500 font-medium mt-1">Dengarkan audio penutur asli berikut, lalu ikuti pelafalannya untuk melatih pendengaran dan intonasi.</p>
                            </div>

                            <!-- Big Audio Player Button -->
                            <div class="flex items-center gap-3">
                                <button @click="playListeningDialogue(@js($meetingData['listening']['audio_script'] ?? ''))"
                                    type="button"
                                    class="px-6 py-3 rounded-2xl font-bold text-sm shadow-md transition flex items-center gap-2.5 text-white"
                                    :class="isPlaying ? 'bg-red-600 hover:bg-red-700 animate-pulse' : 'bg-blue-600 hover:bg-blue-700 shadow-blue-500/25'">
                                    <span x-show="!isPlaying">
                                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M8 5v14l11-7z"/></svg>
                                    </span>
                                    <span x-show="isPlaying">
                                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M6 19h4V5H6v14zm8-14v14h4V5h-4z"/></svg>
                                    </span>
                                    <span x-text="isPlaying ? 'Stop Audio' : 'Putar Audio Listening'"></span>
                                </button>
                            </div>
                        </div>

                        <!-- Audio Wave & Transcript Box -->
                        @php
                            $rawScript = $meetingData['listening']['audio_script'] ?? '';
                            
                            // Split transcript by double newlines or by dialogue speaker patterns
                            $hasDialoguePattern = preg_match('/(?:Receptionist|Attendee|Student A|Student B|Speaker 1|Speaker 2|Interviewer|Candidate|Person A|Person B):/i', $rawScript);
                            
                            if ($hasDialoguePattern) {
                                // Split on speaker name prefixes
                                $pattern = '/(?=(?:Receptionist|Attendee|Student A|Student B|Speaker 1|Speaker 2|Interviewer|Candidate|Person A|Person B):\s*)/i';
                                $scriptTurns = preg_split($pattern, $rawScript, -1, PREG_SPLIT_NO_EMPTY);
                            } else {
                                $scriptTurns = array_filter(explode("\n", $rawScript));
                            }
                        @endphp
                        <div class="p-6 rounded-2xl bg-blue-50/60 border border-blue-200 mb-6">
                            <div class="flex items-center justify-between mb-4">
                                <div class="flex items-center gap-2">
                                    <span class="w-2.5 h-2.5 rounded-full bg-blue-600" :class="isPlaying ? 'animate-ping' : ''"></span>
                                    <h4 class="font-black text-xs text-blue-950 uppercase tracking-wider">Audio Transcript &amp; Shadowing Text</h4>
                                </div>
                                <button @click="showTranscript = !showTranscript" class="text-xs font-bold text-blue-600 hover:text-blue-800 underline">
                                    <span x-text="showTranscript ? 'Sembunyikan Naskah' : 'Tampilkan Naskah'"></span>
                                </button>
                            </div>

                            <div x-show="showTranscript" x-transition class="space-y-3">
                                @if(!empty($scriptTurns) && (count($scriptTurns) > 1 || $hasDialoguePattern))
                                    @foreach($scriptTurns as $tIdx => $turn)
                                        @php
                                            $turn = trim($turn);
                                            if (empty($turn)) continue;
                                            
                                            // Check if turn starts with "Speaker:"
                                            $parts = explode(':', $turn, 2);
                                            $hasSpeaker = count($parts) === 2 && strlen($parts[0]) <= 25;
                                            $speaker = $hasSpeaker ? trim($parts[0]) : '';
                                            $dialogueText = $hasSpeaker ? trim($parts[1]) : $turn;
                                            
                                            $speakerLower = strtolower($speaker);
                                            $isFemaleSpeaker = in_array($speakerLower, ['receptionist', 'female', 'woman', 'sophia', 'sarah', 'mary', 'linda', 'student b']);
                                            $turnGender = $isFemaleSpeaker ? 'female' : 'male';
                                            
                                            $badgeBg = $isFemaleSpeaker ? 'bg-sky-600 text-white' : 'bg-amber-500 text-white';
                                        @endphp
                                        <div class="p-4 rounded-2xl bg-white border border-blue-100/90 shadow-2xs hover:border-blue-200 transition flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                                            <div class="flex items-start gap-3 flex-1">
                                                @if($hasSpeaker)
                                                    <span class="px-3 py-1 rounded-xl {{ $badgeBg }} text-xs font-black shrink-0 shadow-2xs">
                                                        {{ $speaker }}
                                                    </span>
                                                @else
                                                    <span class="w-6 h-6 rounded-lg bg-sky-100 text-sky-800 text-xs font-bold flex items-center justify-center shrink-0">
                                                        {{ $tIdx + 1 }}
                                                    </span>
                                                @endif
                                                <p class="text-sm sm:text-base text-slate-900 font-bold leading-relaxed">
                                                    {{ $dialogueText }}
                                                </p>
                                            </div>
                                            <button @click="speakText(@js($dialogueText), @js($turnGender))" type="button" class="self-end sm:self-center w-8 h-8 rounded-full bg-slate-50 hover:bg-blue-600 hover:text-white text-blue-600 border border-blue-200 shadow-2xs transition flex items-center justify-center shrink-0" title="Listen Line">
                                                <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 24 24"><path d="M3 9v6h4l5 5V4L7 9H3zm13.5 3c0-1.77-1.02-3.29-2.5-4.03v8.05c1.48-.73 2.5-2.25 2.5-4.02z"/></svg>
                                            </button>
                                        </div>
                                    @endforeach
                                @else
                                    <div class="bg-white p-5 rounded-2xl border border-blue-100 shadow-2xs">
                                        <p class="text-sm sm:text-base text-slate-800 leading-relaxed font-semibold whitespace-pre-line">
                                            {{ $rawScript }}
                                        </p>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <!-- Listening Comprehension Questions -->
                        <div>
                            <div class="flex items-center gap-2 mb-3">
                                <span class="w-6 h-6 rounded-lg bg-blue-600 text-white font-bold text-xs flex items-center justify-center shadow-2xs">Q</span>
                                <h3 class="font-bold text-base text-slate-900">Listening Comprehension Questions</h3>
                            </div>
                            <p class="text-xs text-slate-500 mb-4">Pilih jawaban yang paling tepat berdasarkan rekaman audio yang Anda dengarkan:</p>

                            <div class="space-y-4">
                                @php
                                    $qColorBadges = [
                                        0 => 'bg-blue-600',
                                        1 => 'bg-emerald-600',
                                        2 => 'bg-purple-600',
                                        3 => 'bg-rose-600',
                                    ];
                                @endphp
                                @foreach($meetingData['listening']['questions'] ?? [] as $qIdx => $lq)
                                    <div class="p-5 rounded-2xl bg-slate-50 border border-slate-200 shadow-2xs" x-data="{ selectedOpt: null, correctOpt: @js($lq['answer']) }">
                                        <p class="font-bold text-slate-900 text-sm sm:text-base mb-3 flex items-center gap-2">
                                            <span class="w-5 h-5 rounded-full {{ $qColorBadges[$qIdx % 4] }} text-white text-[11px] font-black flex items-center justify-center shrink-0">{{ $qIdx + 1 }}</span>
                                            <span>{{ $lq['q'] }}</span>
                                        </p>
                                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                                            @foreach($lq['options'] as $opt)
                                                <button @click="selectedOpt = @js($opt)"
                                                    type="button"
                                                    :class="{
                                                        'bg-blue-50 border-blue-500 text-blue-900 font-bold': selectedOpt === @js($opt) && selectedOpt !== correctOpt,
                                                        'bg-emerald-50 border-emerald-500 text-emerald-900 font-bold ring-2 ring-emerald-400': selectedOpt && @js($opt) === correctOpt,
                                                        'bg-white border-slate-200 text-slate-700 hover:bg-slate-100': selectedOpt !== @js($opt)
                                                    }"
                                                    class="p-3 rounded-xl border text-left text-xs sm:text-sm font-semibold transition flex items-center justify-between">
                                                    <span>{{ $opt }}</span>
                                                    <span x-show="selectedOpt && @js($opt) === correctOpt" class="text-emerald-600 font-bold text-xs">✓ Benar</span>
                                                </button>
                                            @endforeach
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>

                <!-- ========================================== -->
                <!-- TAB 3: PRACTICE SPEAKING (SHADOWING)     -->
                <!-- ========================================== -->
                <div x-show="activeTab === 'shadowing'" class="space-y-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Shadowing Part 1 (Blue Accent - Persiapan Ronde 1 Partnering) -->
                        <div class="bg-white rounded-[2rem] p-6 sm:p-8 shadow-sm border border-slate-200/90">
                            <div class="flex items-center justify-between pb-4 mb-4 border-b border-slate-100">
                                <div class="flex items-center gap-2.5">
                                    <span style="background-color: #29a8f5 !important;" class="w-7 h-7 rounded-xl text-white font-black text-xs flex items-center justify-center shadow-2xs">1</span>
                                    <div>
                                        <h2 class="text-base font-bold text-slate-900">{{ $meetingData['drilling1_title'] ?? 'Drilling: Persiapan Ronde 1' }}</h2>
                                        <p class="text-[11px] text-sky-700 font-bold">{{ $meetingData['drilling1_subtitle'] ?? 'Latihan Pelafalan Kalimat Praktis' }}</p>
                                    </div>
                                </div>
                                <span class="text-xs font-bold px-2.5 py-0.5 rounded-full bg-sky-100 text-sky-800 border border-sky-200">Persiapan Ronde 1</span>
                            </div>
                            <p class="text-xs text-slate-500 mb-4 font-medium">{{ $meetingData['drilling1_desc'] ?? 'Latih pelafalan kalimat sebelum masuk ke sesi dialog berpasangan:' }}</p>
                            <div class="space-y-3">
                                @foreach($meetingData['drilling1'] ?? [] as $drill)
                                    @php
                                        $drillEn = e($drill['en']);
                                        $drillEn = preg_replace('/\[(.*?)\]/', '<span class="inline-block px-2 py-0.5 rounded-md bg-amber-300 text-slate-950 font-black text-xs shadow-2xs">[$1]</span>', $drillEn);
                                        $drillId = e($drill['id']);
                                        $drillId = preg_replace('/\[(.*?)\]/', '<span class="inline-block px-2 py-0.5 rounded-md bg-amber-300 text-slate-950 font-black text-xs shadow-2xs">[$1]</span>', $drillId);
                                    @endphp
                                    <div class="p-3.5 rounded-2xl bg-sky-50/30 border border-sky-200/80 hover:bg-sky-50/70 hover:border-sky-300 transition flex items-start justify-between gap-3 shadow-2xs">
                                        <div>
                                            <p class="font-black text-sky-950 text-sm leading-snug">
                                                • {!! $drillEn !!}
                                            </p>
                                            <p class="text-xs text-sky-700 mt-0.5 font-semibold italic">
                                                ({!! $drillId !!})
                                            </p>
                                        </div>
                                        <button @click="speakText(@js($drill['en']))" type="button" class="w-8 h-8 rounded-full bg-white hover:bg-[#29a8f5] hover:text-white text-[#29a8f5] border border-sky-200 shadow-2xs transition flex items-center justify-center shrink-0" title="Listen">
                                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M3 9v6h4l5 5V4L7 9H3zm13.5 3c0-1.77-1.02-3.29-2.5-4.03v8.05c1.48-.73 2.5-2.25 2.5-4.02z"/></svg>
                                        </button>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <!-- Shadowing Part 2 (Orange Accent - Persiapan Ronde 2 Partnering) -->
                        <div class="bg-white rounded-[2rem] p-6 sm:p-8 shadow-sm border border-slate-200/90">
                            <div class="flex items-center justify-between pb-4 mb-4 border-b border-slate-100">
                                <div class="flex items-center gap-2.5">
                                    <span style="background-color: #ff9800 !important;" class="w-7 h-7 rounded-xl text-white font-black text-xs flex items-center justify-center shadow-2xs">2</span>
                                    <div>
                                        <h2 class="text-base font-bold text-slate-900">{{ $meetingData['drilling2_title'] ?? 'Drilling: Persiapan Ronde 2' }}</h2>
                                        <p class="text-[11px] text-orange-700 font-bold">{{ $meetingData['drilling2_subtitle'] ?? 'Latihan Pelafalan & Variasi Kalimat' }}</p>
                                    </div>
                                </div>
                                <span class="text-xs font-bold px-2.5 py-0.5 rounded-full bg-orange-100 text-orange-800 border border-orange-200">Persiapan Ronde 2</span>
                            </div>
                            <p class="text-xs text-slate-500 mb-4 font-medium">{{ $meetingData['drilling2_desc'] ?? 'Latih pelafalan kalimat untuk persiapan tukar peran:' }}</p>
                            <div class="space-y-3">
                                @foreach($meetingData['drilling2'] ?? [] as $drill)
                                    @php
                                        $drillEn = e($drill['en']);
                                        $drillEn = preg_replace('/\[(.*?)\]/', '<span class="inline-block px-2 py-0.5 rounded-md bg-amber-300 text-slate-950 font-black text-xs shadow-2xs">[$1]</span>', $drillEn);
                                        $drillId = e($drill['id']);
                                        $drillId = preg_replace('/\[(.*?)\]/', '<span class="inline-block px-2 py-0.5 rounded-md bg-amber-300 text-slate-950 font-black text-xs shadow-2xs">[$1]</span>', $drillId);
                                    @endphp
                                    <div class="p-3.5 rounded-2xl bg-orange-50/30 border border-orange-200/80 hover:bg-orange-50/70 hover:border-orange-300 transition flex items-start justify-between gap-3 shadow-2xs">
                                        <div>
                                            <p class="font-black text-orange-950 text-sm leading-snug">
                                                • {!! $drillEn !!}
                                            </p>
                                            <p class="text-xs text-orange-700 mt-0.5 font-semibold italic">
                                                ({!! $drillId !!})
                                            </p>
                                        </div>
                                        <button @click="speakText(@js($drill['en']))" type="button" class="w-8 h-8 rounded-full bg-white hover:bg-[#ff9800] hover:text-white text-[#ff9800] border border-orange-200 shadow-2xs transition flex items-center justify-center shrink-0" title="Listen">
                                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M3 9v6h4l5 5V4L7 9H3zm13.5 3c0-1.77-1.02-3.29-2.5-4.03v8.05c1.48-.73 2.5-2.25 2.5-4.02z"/></svg>
                                        </button>
                                    </div>
                                @endforeach
                            </div>

                            @if(!empty($meetingData['grammar_note']))
                                <div class="mt-4 p-3.5 rounded-2xl bg-amber-50 border border-amber-200 flex items-center gap-2.5">
                                    <span class="text-xs font-black text-amber-900 uppercase tracking-wide px-2 py-0.5 bg-amber-100 rounded-md">Catatan:</span>
                                    <p class="text-xs text-amber-950 font-bold">{{ $meetingData['grammar_note'] }}</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- ========================================== -->
                <!-- TAB 4: PRACTICE (PARTNERING)             -->
                <!-- ========================================== -->
                <div x-show="activeTab === 'partnering'" class="space-y-6">
                    <div class="bg-white rounded-[2rem] p-6 sm:p-8 shadow-sm border border-slate-200/90">
                        <div class="flex flex-col sm:flex-row sm:items-center justify-between pb-5 mb-6 border-b border-slate-100 gap-4">
                            <div>
                                <div class="flex items-center gap-2 mb-1">
                                    <span style="background-color: #29a8f5 !important;" class="px-2.5 py-0.5 rounded-full text-xs font-black text-white shadow-2xs">
                                        Translate &amp; Roleplay Practice
                                    </span>
                                </div>
                                <h2 class="text-xl sm:text-2xl font-black text-slate-900 tracking-tight">Partnering Dialogue Practice</h2>
                                @if(!empty($meetingData['dialogue_setting']))
                                    <p class="text-xs sm:text-sm text-slate-600 font-semibold mt-1"><strong>Skenario:</strong> {{ $meetingData['dialogue_setting'] }}</p>
                                @endif
                                <p class="text-xs text-sky-900 font-bold mt-1 bg-sky-50 px-3 py-1.5 rounded-xl border border-sky-200 inline-block">
                                    Instruksi: Baca kalimat Bahasa Indonesia di bawah, terjemahkan dan ucapkan ke teman pasanganmu dalam Bahasa Inggris. Buka kunci jawaban &amp; dengarkan audio untuk memeriksa pelafalan!
                                </p>
                            </div>

                            <!-- Header Controls (Toggle All & Play Full) -->
                            <div class="flex flex-wrap items-center gap-2.5 self-start sm:self-auto shrink-0">
                                <button @click="showAllPartneringEn = !showAllPartneringEn" type="button" class="px-4 py-2.5 rounded-2xl bg-slate-100 hover:bg-slate-200 text-slate-800 font-bold text-xs border border-slate-200 transition flex items-center gap-2">
                                    <svg class="w-4 h-4 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                    <span x-text="showAllPartneringEn ? 'Sembunyikan Semua English' : 'Tampilkan Semua English'"></span>
                                </button>

                                <button @click="playFullDialogue()" type="button" style="background-color: #29a8f5 !important;" class="px-5 py-2.5 rounded-2xl hover:opacity-90 text-white font-bold text-xs shadow-md shadow-sky-500/25 transition flex items-center gap-2">
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M8 5v14l11-7z"/></svg>
                                    <span>Putar Seluruh Percakapan</span>
                                </button>
                            </div>
                        </div>

                        <div class="space-y-7 max-w-3xl mx-auto">
                            @foreach($meetingData['dialogue'] ?? [] as $index => $d)
                                @if(!empty($d['section_badge']))
                                    <div style="background-color: #29a8f5 !important;" class="my-6 p-4 rounded-2xl text-white shadow-md flex items-center justify-between gap-3 border border-white/20">
                                        <div class="flex items-center gap-2.5">
                                            <span class="w-8 h-8 rounded-xl bg-white/20 text-white font-black text-xs flex items-center justify-center shadow-xs">🔄</span>
                                            <div>
                                                <span class="text-[10px] font-bold text-sky-100 block uppercase tracking-wider">Roleplay Practice • Target Bahasa</span>
                                                <h4 class="font-black text-xs sm:text-sm tracking-wide text-white">{{ $d['section_badge'] }}</h4>
                                            </div>
                                        </div>
                                        <span class="px-3 py-1 rounded-full bg-white/20 text-[10px] font-black uppercase tracking-wider text-white shrink-0">Switch Roles</span>
                                    </div>
                                @endif

                                @php
                                    $isSpeakerA = (isset($d['speaker']) && $d['speaker'] === 'Student A');
                                    $speakerName = $isSpeakerA ? 'STUDENT A' : 'STUDENT B';
                                    $gender = $isSpeakerA ? 'male' : 'female';
                                    $bubbleBg = $isSpeakerA ? '#29a8f5' : '#ff9800';
                                    
                                    // Main text is pure white for all bubbles
                                    $mainTextColor = '#ffffff';
                                    $labelColor = 'text-white/80';
                                    $subtextColor = 'text-white/90';
                                    
                                    // Student A text/badge is Red, Student B text/badge is Pink
                                    $badgeTextColor = $isSpeakerA ? '#ff2a2a' : '#ff2d78';
                                    $badgeStyle = 'background-color: #ffffff; color: ' . $badgeTextColor . ';';
                                    $borderClass = 'border-white/30';
                                    $counterClass = 'bg-black/20 text-white border border-white/30';

                                    // Replace Student A with Red text and Student B with Pink text
                                    $idSentence = e($d['id'] ?? $d['text'] ?? $d['en']);
                                    $idSentence = str_replace(
                                        ['Student A', 'Student B'],
                                        [
                                            '<span style="color: #ff2a2a !important; font-weight: 900;">Student A</span>',
                                            '<span style="color: #ff2d78 !important; font-weight: 900;">Student B</span>'
                                        ],
                                        $idSentence
                                    );
                                    $idSentence = preg_replace('/\[(.*?)\]/', '<span class="inline-block px-2.5 py-0.5 mx-1 rounded-lg bg-amber-300 text-slate-950 font-black text-xs sm:text-sm tracking-wide shadow-xs border border-amber-400/80">[$1]</span>', $idSentence);

                                    $enSentence = e($d['en'] ?? $d['text']);
                                    $enSentence = str_replace(
                                        ['Student A', 'Student B'],
                                        [
                                            '<span style="color: #ff2a2a !important; font-weight: 900;">Student A</span>',
                                            '<span style="color: #ff2d78 !important; font-weight: 900;">Student B</span>'
                                        ],
                                        $enSentence
                                    );
                                    $enSentence = preg_replace('/\[(.*?)\]/', '<span class="inline-block px-2.5 py-0.5 mx-1 rounded-lg bg-amber-300 text-slate-950 font-black text-xs sm:text-sm tracking-wide shadow-xs border border-amber-400/80">[$1]</span>', $enSentence);
                                @endphp
                                <div x-data="{ showEn: false }" class="flex items-start gap-4 {{ $isSpeakerA ? '' : 'flex-row-reverse' }}">
                                    <!-- Avatar (Round Bubble Avatar: A for Student A, B for Student B) -->
                                    <div style="background-color: {{ $bubbleBg }} !important;" class="w-12 h-12 rounded-full flex items-center justify-center font-black text-lg text-white shrink-0 shadow-lg border-2 border-white">
                                        {{ $isSpeakerA ? 'A' : 'B' }}
                                    </div>

                                    <!-- Dialogue Chat Bubble Container (Organic Rounded Speech Bubble - Blue / Orange) -->
                                    <div style="background-color: {{ $bubbleBg }} !important;" class="relative w-full sm:max-w-[85%] rounded-[2.5rem] p-6 sm:p-7 shadow-xl {{ $isSpeakerA ? 'rounded-tl-sm text-white' : 'rounded-tr-sm text-white' }}">
                                        <!-- Speech Bubble Tail Pointer -->
                                        @if($isSpeakerA)
                                            <div style="background-color: {{ $bubbleBg }} !important;" class="absolute -left-2 top-5 w-4 h-4 transform rotate-45 rounded-xs pointer-events-none"></div>
                                        @else
                                            <div style="background-color: {{ $bubbleBg }} !important;" class="absolute -right-2 top-5 w-4 h-4 transform rotate-45 rounded-xs pointer-events-none"></div>
                                        @endif

                                        <!-- Card Header: Speaker Name Badge (STUDENT A in RED / STUDENT B in PINK) -->
                                        <div class="relative z-10 flex items-center justify-between gap-4 mb-3 pb-2.5 border-b {{ $borderClass }}">
                                            <div class="flex items-center gap-2 flex-wrap">
                                                <span style="{{ $badgeStyle }}" class="px-3.5 py-1 rounded-full text-xs font-black uppercase tracking-wider shadow-xs">
                                                    {{ $speakerName }}
                                                </span>
                                                <span class="text-xs font-bold {{ $subtextColor }}">
                                                    ({{ !empty($d['role_label']) ? $d['role_label'] : ($isSpeakerA ? 'Peran Siswa A' : 'Peran Siswa B') }})
                                                </span>
                                            </div>
                                            <span class="text-[10px] font-black px-3 py-0.5 rounded-full {{ $counterClass }}">
                                                Kalimat #{{ $index + 1 }}
                                            </span>
                                        </div>

                                        <!-- MAIN SENTENCE: BAHASA INDONESIA (Pure White text with Red Student A & Pink Student B) -->
                                        <div class="relative z-10 mb-4">
                                            <span class="text-[10px] font-black uppercase tracking-wider {{ $labelColor }} block mb-1">
                                                Kalimat Utama (Bahasa Indonesia):
                                            </span>
                                            <p style="color: {{ $mainTextColor }} !important;" class="text-base sm:text-lg font-black leading-relaxed">
                                                &ldquo;{!! $idSentence !!}&rdquo;
                                            </p>
                                        </div>

                                        <!-- ACTION BUTTONS ROW: Toggle English -->
                                        <div class="relative z-10 flex flex-wrap items-center gap-2 pt-2.5 border-t {{ $borderClass }}">
                                            <!-- Button: Toggle English Translation -->
                                            <button @click="showEn = !showEn" type="button"
                                                class="px-4 py-2 rounded-full text-xs font-black transition flex items-center gap-1.5 shadow-sm {{ $isSpeakerA ? 'text-sky-700' : 'text-orange-700' }}"
                                                :class="(showEn || showAllPartneringEn) ? 'bg-emerald-500 hover:bg-emerald-600 text-white' : 'bg-white hover:bg-slate-50'">
                                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5h12M9 3v2m1.048 9.5A18.022 18.022 0 016.412 9m6.088 9h7M11 21l5-10 5 10M12.751 5C11.783 10.77 8.07 15.61 3 18.129"/></svg>
                                                <span x-text="(showEn || showAllPartneringEn) ? 'Sembunyikan Kunci Jawaban' : 'Tampilkan Jawaban English'"></span>
                                            </button>
                                        </div>

                                        <!-- REVEALED TARGET ENGLISH BOX (Audio Button is inside here) -->
                                        <div x-show="showEn || showAllPartneringEn" x-transition class="relative z-10 mt-4 p-5 rounded-[2rem] bg-white text-slate-900 border-2 {{ $isSpeakerA ? 'border-sky-300' : 'border-orange-300' }} shadow-xl">
                                            <div class="flex items-center justify-between mb-2 pb-1.5 border-b {{ $isSpeakerA ? 'border-sky-100' : 'border-orange-100' }}">
                                                <span class="text-[10px] font-black uppercase {{ $isSpeakerA ? 'text-sky-700' : 'text-orange-700' }} tracking-wider flex items-center gap-1">
                                                    <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path></svg>
                                                    Kunci Jawaban Bahasa Inggris:
                                                </span>
                                                <span class="text-[10px] font-bold px-2.5 py-0.5 rounded-full {{ $isSpeakerA ? 'bg-sky-100 text-sky-800' : 'bg-orange-100 text-orange-800' }}">English Target</span>
                                            </div>
                                            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 pt-1">
                                                <p class="text-sm sm:text-base font-black text-slate-900 leading-relaxed">
                                                    &ldquo;{!! $enSentence !!}&rdquo;
                                                </p>
                                                <!-- Audio Button Revealed with English Target -->
                                                <button @click="speakText(@js($d['en'] ?? $d['text']), '{{ $gender }}')" type="button"
                                                    style="background-color: {{ $bubbleBg }} !important; color: #ffffff !important;"
                                                    class="px-4 py-2.5 rounded-2xl text-white text-xs font-black shadow-md transition flex items-center justify-center gap-2 shrink-0 hover:opacity-95 hover:scale-105 border border-white/20">
                                                    <svg class="w-4 h-4 text-white shrink-0" fill="currentColor" viewBox="0 0 24 24"><path d="M3 9v6h4l5 5V4L7 9H3zm13.5 3c0-1.77-1.02-3.29-2.5-4.03v8.05c1.48-.73 2.5-2.25 2.5-4.02z"/></svg>
                                                    <span class="text-white font-black tracking-wide">Dengarkan Audio</span>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <!-- ========================================== -->
                <!-- TAB 5: KOSA KATA (VOCABULARY & SPELLING) -->
                <!-- ========================================== -->
                <div x-show="activeTab === 'vocabulary'" class="space-y-6" 
                     x-data="{ 
                         vocabFilter: 'all', 
                         vocabSearch: '',
                         playAllVocab(jobsList) {
                             if (!jobsList || jobsList.length === 0) return;
                             let words = jobsList.map(j => j.job);
                             this.speakText(words.join(', '), 'female');
                         }
                     }">
                    
                    @php
                        $jobsGroupA = $meetingData['materi']['jobs_group_a'] ?? [];
                        $jobsGroupB = $meetingData['materi']['jobs_group_b'] ?? [];
                        
                        $allJobsWithGroup = [];
                        foreach ($jobsGroupA as $idx => $j) {
                            $allJobsWithGroup[] = array_merge($j, ['group' => 'A', 'group_label' => 'Group A', 'color' => 'sky', 'index' => $idx + 1]);
                        }
                        foreach ($jobsGroupB as $idx => $j) {
                            $allJobsWithGroup[] = array_merge($j, ['group' => 'B', 'group_label' => 'Group B', 'color' => 'orange', 'index' => $idx + 1]);
                        }
                    @endphp

                    @if(!empty($allJobsWithGroup))
                        <!-- 1. SIGNATURE HERO SHOWCASE BOX (Jobs & Occupations) -->
                        <div style="background-color: #29a8f5 !important;" class="rounded-[2.5rem] p-6 sm:p-10 text-white shadow-xl relative overflow-hidden">
                            <div class="relative z-10 mb-8 flex flex-col md:flex-row md:items-center justify-between gap-4">
                                <div>
                                    <span class="px-3 py-1 rounded-full bg-white/15 backdrop-blur-md text-xs font-extrabold uppercase tracking-wider text-blue-100">Modul 02 • Vocabulary &amp; Spelling</span>
                                    <h2 class="text-2xl sm:text-3xl font-black tracking-tight mt-1 text-white">22 Kosakata Profesi (Jobs &amp; Occupations)</h2>
                                    <p class="text-xs sm:text-sm text-blue-100 font-medium mt-0.5">Panduan pelafalan simbol fonetik (IPA), terjemahan Bahasa Indonesia, definisi Bahasa Inggris, dan latihan ejaan abjad.</p>
                                </div>
                                <button @click="playAllVocab(@js($allJobsWithGroup))" type="button" class="px-5 py-2.5 rounded-2xl bg-amber-400 hover:bg-amber-300 text-slate-950 font-black text-xs sm:text-sm shadow-md transition flex items-center gap-2 shrink-0">
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M3 9v6h4l5 5V4L7 9H3zm13.5 3c0-1.77-1.02-3.29-2.5-4.03v8.05c1.48-.73 2.5-2.25 2.5-4.02z"/></svg>
                                    <span>Lafalkan Semua 22 Profesi</span>
                                </button>
                            </div>

                            <!-- Filter & Search Controls Bar inside Hero -->
                            <div class="relative z-10 flex flex-col sm:flex-row sm:items-center justify-between gap-3 bg-white/10 backdrop-blur-md p-3 rounded-2xl border border-white/20">
                                <div class="flex items-center gap-1.5 overflow-x-auto scrollbar-none">
                                    <button @click="vocabFilter = 'all'" 
                                            :class="vocabFilter === 'all' ? 'bg-white text-blue-900 font-black shadow-sm' : 'text-blue-100 hover:bg-white/10 font-bold'" 
                                            class="px-3.5 py-1.5 rounded-xl text-xs transition">
                                        Semua (22 Profesi)
                                    </button>
                                    <button @click="vocabFilter = 'A'" 
                                            :class="vocabFilter === 'A' ? 'bg-white text-sky-900 font-black shadow-sm' : 'text-blue-100 hover:bg-white/10 font-bold'" 
                                            class="px-3.5 py-1.5 rounded-xl text-xs transition flex items-center gap-1">
                                        <span class="w-2 h-2 rounded-full bg-sky-400"></span>
                                        <span>Group A (11)</span>
                                    </button>
                                    <button @click="vocabFilter = 'B'" 
                                            :class="vocabFilter === 'B' ? 'bg-white text-orange-900 font-black shadow-sm' : 'text-blue-100 hover:bg-white/10 font-bold'" 
                                            class="px-3.5 py-1.5 rounded-xl text-xs transition flex items-center gap-1">
                                        <span class="w-2 h-2 rounded-full bg-orange-400"></span>
                                        <span>Group B (11)</span>
                                    </button>
                                </div>

                                <div class="relative min-w-[220px]">
                                    <input type="text" 
                                           x-model="vocabSearch" 
                                           placeholder="Cari profesi atau arti..." 
                                           class="w-full pl-8 pr-3 py-1.5 text-xs rounded-xl bg-white text-slate-900 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-amber-400 border-0">
                                    <svg class="w-3.5 h-3.5 text-slate-400 absolute left-2.5 top-2.5 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                                </div>
                            </div>
                        </div>

                        <!-- 2. 22 VOCABULARY CARDS GRID -->
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">
                            @foreach($allJobsWithGroup as $j)
                                @php
                                    $jobName = ucwords($j['job']);
                                    $isGroupA = ($j['group'] === 'A');
                                    $themeBorder = $isGroupA ? 'border-sky-100 hover:border-sky-400' : 'border-orange-100 hover:border-orange-400';
                                    $themeBadge = $isGroupA ? 'bg-sky-100 text-sky-800 border-sky-200' : 'bg-orange-100 text-orange-800 border-orange-200';
                                    $spellingSpaced = strtoupper(implode(' - ', str_split(str_replace(' ', '', $j['job']))));
                                @endphp
                                <div x-show="(vocabFilter === 'all' || vocabFilter === '{{ $j['group'] }}') && (!vocabSearch || '{{ strtolower($j['job']) }}'.includes(vocabSearch.toLowerCase()) || '{{ strtolower($j['id']) }}'.includes(vocabSearch.toLowerCase()))"
                                     class="bg-white rounded-3xl p-6 shadow-sm border-2 {{ $themeBorder }} transition duration-200 flex flex-col justify-between hover:shadow-md">
                                    <div>
                                        <!-- Top Header: Group Badge & Word -->
                                        <div class="flex items-center justify-between gap-2 mb-3">
                                            <span class="px-2.5 py-0.5 rounded-lg text-[10px] font-black uppercase tracking-wider border {{ $themeBadge }}">
                                                {{ $j['group_label'] }} #{{ $j['index'] }}
                                            </span>
                                            <span class="font-mono text-xs font-bold text-indigo-600 bg-indigo-50 px-2 py-0.5 rounded-lg border border-indigo-100">
                                                {{ $j['ipa'] }}
                                            </span>
                                        </div>

                                        <div class="mb-3">
                                            <h3 class="text-xl sm:text-2xl font-black text-slate-900 tracking-tight capitalize">{{ $j['job'] }}</h3>
                                            <p class="text-xs sm:text-sm font-bold text-slate-700 mt-0.5 flex items-start gap-1">
                                                <span class="text-slate-400 font-semibold shrink-0">Arti:</span>
                                                <span>{{ $j['id'] }}</span>
                                            </p>
                                        </div>

                                        <!-- English Definition Box -->
                                        <div class="p-3 rounded-2xl bg-slate-50 border border-slate-100 text-xs text-slate-600 mb-4">
                                            <span class="text-[10px] font-bold text-slate-400 block mb-0.5 uppercase tracking-wider">Definisi Bahasa Inggris:</span>
                                            <p class="font-medium italic leading-relaxed text-slate-800">
                                                "{{ $j['definition'] }}"
                                            </p>
                                        </div>

                                        <!-- Spelling Section -->
                                        <div class="p-2.5 rounded-2xl bg-amber-50/60 border border-amber-200/80 mb-4">
                                            <div class="flex items-center justify-between mb-1">
                                                <span class="text-[10px] font-black uppercase text-amber-900 tracking-wider">🔤 Ejaan (Spelling):</span>
                                                <button @click.stop="spellWordAloud('{{ $j['job'] }}')" type="button" class="text-[10px] font-black text-amber-800 hover:text-amber-950 flex items-center gap-1 bg-white px-2 py-0.5 rounded-md border border-amber-300 shadow-2xs">
                                                    <svg class="w-3 h-3 text-amber-600" fill="currentColor" viewBox="0 0 24 24"><path d="M3 9v6h4l5 5V4L7 9H3zm13.5 3c0-1.77-1.02-3.29-2.5-4.03v8.05c1.48-.73 2.5-2.25 2.5-4.02z"/></svg>
                                                    <span>Eja Huruf</span>
                                                </button>
                                            </div>
                                            <p class="font-mono font-black text-xs text-amber-950 tracking-wider">{{ $spellingSpaced }}</p>
                                        </div>
                                    </div>

                                    <!-- Action Audio Buttons -->
                                    <div class="pt-3 border-t border-slate-100 flex items-center justify-between gap-2">
                                        <button @click.stop="speakText('{{ $j['job'] }}')" type="button" 
                                                style="background-color: #29a8f5 !important;"
                                                class="flex-1 py-2 px-3 rounded-xl text-white font-bold text-xs shadow-sm hover:opacity-90 transition flex items-center justify-center gap-1.5">
                                            <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 24 24"><path d="M3 9v6h4l5 5V4L7 9H3zm13.5 3c0-1.77-1.02-3.29-2.5-4.03v8.05c1.48-.73 2.5-2.25 2.5-4.02z"/></svg>
                                            <span>Lafalkan Kata</span>
                                        </button>

                                        <button @click.stop="speakText('{{ $j['job'] }}: {{ addslashes($j['definition']) }}')" type="button" 
                                                class="py-2 px-3 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-xs border border-slate-200 transition flex items-center gap-1"
                                                title="Dengarkan Definisi">
                                            <svg class="w-3.5 h-3.5 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                                            <span>Definisi</span>
                                        </button>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <!-- 3. USEFUL PATTERNS FOR SPEAKING & CLUES -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-8">
                            <!-- Clue Patterns Box -->
                            <div class="bg-white rounded-3xl p-6 sm:p-7 shadow-sm border border-slate-200">
                                <div class="flex items-center gap-2 mb-4 pb-3 border-b border-slate-100">
                                    <span class="w-7 h-7 rounded-xl bg-blue-100 text-blue-600 font-black text-xs flex items-center justify-center">💡</span>
                                    <h4 class="font-black text-base text-slate-900">Pola Menjelaskan Profesi (How to Describe Jobs)</h4>
                                </div>
                                <div class="space-y-3">
                                    <div class="p-3.5 rounded-2xl bg-sky-50/60 border border-sky-100">
                                        <span class="text-[10px] font-black uppercase text-sky-800 tracking-wider block mb-1">Pola 1: "A person who [verb+s]..."</span>
                                        <p class="text-xs sm:text-sm font-black text-slate-900 leading-relaxed">"A person who treats sick animals." &rarr; <span class="text-sky-700">Vet</span></p>
                                        <button @click="speakText('A person who treats sick and injured animals is a vet.')" class="mt-2 text-[11px] font-bold text-sky-600 hover:text-sky-800 flex items-center gap-1">
                                            <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 24 24"><path d="M3 9v6h4l5 5V4L7 9H3zm13.5 3c0-1.77-1.02-3.29-2.5-4.03v8.05c1.48-.73 2.5-2.25 2.5-4.02z"/></svg>
                                            <span>Putar Contoh Audio</span>
                                        </button>
                                    </div>

                                    <div class="p-3.5 rounded-2xl bg-orange-50/60 border border-orange-100">
                                        <span class="text-[10px] font-black uppercase text-orange-800 tracking-wider block mb-1">Pola 2: "Someone whose job is [verb-ing]..."</span>
                                        <p class="text-xs sm:text-sm font-black text-slate-900 leading-relaxed">"Someone whose job is cutting and selling meat." &rarr; <span class="text-orange-700">Butcher</span></p>
                                        <button @click="speakText('Someone whose job is cutting and selling meat is a butcher.')" class="mt-2 text-[11px] font-bold text-orange-600 hover:text-orange-800 flex items-center gap-1">
                                            <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 24 24"><path d="M3 9v6h4l5 5V4L7 9H3zm13.5 3c0-1.77-1.02-3.29-2.5-4.03v8.05c1.48-.73 2.5-2.25 2.5-4.02z"/></svg>
                                            <span>Putar Contoh Audio</span>
                                        </button>
                                    </div>

                                    <div class="p-3.5 rounded-2xl bg-emerald-50/60 border border-emerald-100">
                                        <span class="text-[10px] font-black uppercase text-emerald-800 tracking-wider block mb-1">Pola 3: "They work in a [place] and [verb]..."</span>
                                        <p class="text-xs sm:text-sm font-black text-slate-900 leading-relaxed">"They work in a library and help people find books." &rarr; <span class="text-emerald-700">Librarian</span></p>
                                        <button @click="speakText('They work in a library and help people find books. They are a librarian.')" class="mt-2 text-[11px] font-bold text-emerald-600 hover:text-emerald-800 flex items-center gap-1">
                                            <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 24 24"><path d="M3 9v6h4l5 5V4L7 9H3zm13.5 3c0-1.77-1.02-3.29-2.5-4.03v8.05c1.48-.73 2.5-2.25 2.5-4.02z"/></svg>
                                            <span>Putar Contoh Audio</span>
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <!-- Spelling Rules Box -->
                            <div class="bg-white rounded-3xl p-6 sm:p-7 shadow-sm border border-slate-200">
                                <div class="flex items-center gap-2 mb-4 pb-3 border-b border-slate-100">
                                    <span class="w-7 h-7 rounded-xl bg-amber-100 text-amber-700 font-black text-xs flex items-center justify-center">🔤</span>
                                    <h4 class="font-black text-base text-slate-900">Aturan &amp; Pola Tanya Jawab Pengejaan (Spelling Rules)</h4>
                                </div>
                                <div class="space-y-3">
                                    <div class="p-3.5 rounded-2xl bg-slate-50 border border-slate-200">
                                        <span class="text-[10px] font-black uppercase text-slate-500 tracking-wider block mb-1">1. Menanyakan Ejaan (Ask for Spelling)</span>
                                        <p class="text-xs sm:text-sm font-black text-slate-900">&ldquo;How do you spell your job / name?&rdquo;</p>
                                        <p class="text-xs text-slate-600 font-semibold mt-1">&rarr; &ldquo;It is D - O - C - T - O - R.&rdquo;</p>
                                        <button @click="speakText('How do you spell your job? It is D. O. C. T. O. R.')" class="mt-2 text-[11px] font-bold text-slate-700 hover:text-slate-950 flex items-center gap-1">
                                            <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 24 24"><path d="M3 9v6h4l5 5V4L7 9H3zm13.5 3c0-1.77-1.02-3.29-2.5-4.03v8.05c1.48-.73 2.5-2.25 2.5-4.02z"/></svg>
                                            <span>Putar Audio</span>
                                        </button>
                                    </div>

                                    <div class="p-3.5 rounded-2xl bg-slate-50 border border-slate-200">
                                        <span class="text-[10px] font-black uppercase text-slate-500 tracking-wider block mb-1">2. Mengonfirmasi Huruf Mirip (Clarify &amp; Confirm)</span>
                                        <p class="text-xs sm:text-sm font-black text-slate-900">&ldquo;Did you say B as in Baker, or V as in Vet?&rdquo;</p>
                                        <p class="text-xs text-slate-600 font-semibold mt-1">&rarr; &ldquo;I said B as in Baker.&rdquo;</p>
                                        <button @click="speakText('Did you say B as in Baker, or V as in Vet? I said B as in Baker.')" class="mt-2 text-[11px] font-bold text-slate-700 hover:text-slate-950 flex items-center gap-1">
                                            <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 24 24"><path d="M3 9v6h4l5 5V4L7 9H3zm13.5 3c0-1.77-1.02-3.29-2.5-4.03v8.05c1.48-.73 2.5-2.25 2.5-4.02z"/></svg>
                                            <span>Putar Audio</span>
                                        </button>
                                    </div>

                                    <div class="p-3.5 rounded-2xl bg-slate-50 border border-slate-200">
                                        <span class="text-[10px] font-black uppercase text-slate-500 tracking-wider block mb-1">3. Huruf Kembar (Double Letters)</span>
                                        <p class="text-xs sm:text-sm font-black text-slate-900">&ldquo;H - A - I - R - D - R - E - Double S - E - R&rdquo;</p>
                                        <p class="text-xs text-slate-600 font-semibold mt-1">&rarr; <span class="font-bold text-slate-900">Hairdresser</span></p>
                                        <button @click="speakText('H. A. I. R. D. R. E. Double S. E. R. Hairdresser.')" class="mt-2 text-[11px] font-bold text-slate-700 hover:text-slate-950 flex items-center gap-1">
                                            <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 24 24"><path d="M3 9v6h4l5 5V4L7 9H3zm13.5 3c0-1.77-1.02-3.29-2.5-4.03v8.05c1.48-.73 2.5-2.25 2.5-4.02z"/></svg>
                                            <span>Putar Audio</span>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @elseif(isset($meetingData['materi']['cardinal_numbers']))
                        <!-- ==================================================== -->
                        <!-- MEETING 3: VOCABULARY NUMBERS & DATES                -->
                        <!-- ==================================================== -->
                        <div class="space-y-6" x-data="{ numVocabFilter: 'all', searchVocab: '' }">
                            <!-- Hero Box for Numbers Vocab -->
                            <div style="background-color: #29a8f5 !important;" class="rounded-[2.5rem] p-6 sm:p-10 text-white shadow-xl relative overflow-hidden">
                                <div class="relative z-10 mb-6 flex flex-col md:flex-row md:items-center justify-between gap-4">
                                    <div>
                                        <span class="px-3.5 py-1 rounded-full bg-white/20 text-xs font-black uppercase tracking-wider text-white">Modul 03 • Vocabulary Bank</span>
                                        <h2 class="text-2xl sm:text-3xl font-black tracking-tight mt-2 text-white">Kosakata Angka &amp; Kalender (Numbers &amp; Dates)</h2>
                                        <p class="text-xs sm:text-sm text-sky-100 font-medium mt-1">Koleksi lengkap kosakata Cardinal Numbers, Ordinal Numbers, Istilah Penanggalan, Hari, Bulan &amp; Era Sejarah.</p>
                                    </div>
                                </div>

                                <!-- Filter Buttons Bar -->
                                <div class="relative z-10 flex flex-col sm:flex-row sm:items-center justify-between gap-3 bg-white/15 p-2.5 rounded-2xl border border-white/25">
                                    <div class="flex items-center gap-1.5 overflow-x-auto scrollbar-none flex-wrap">
                                        <button @click="numVocabFilter = 'all'" :class="numVocabFilter === 'all' ? 'bg-white text-slate-900 font-black shadow-xs' : 'text-white hover:bg-white/15 font-bold'" class="px-3.5 py-1.5 rounded-xl text-xs transition">
                                            Semua
                                        </button>
                                        <button @click="numVocabFilter = 'cardinal'" :class="numVocabFilter === 'cardinal' ? 'bg-white text-slate-900 font-black shadow-xs' : 'text-white hover:bg-white/15 font-bold'" class="px-3.5 py-1.5 rounded-xl text-xs transition">
                                            🔢 Cardinal Numbers
                                        </button>
                                        <button @click="numVocabFilter = 'ordinal'" :class="numVocabFilter === 'ordinal' ? 'bg-white text-slate-900 font-black shadow-xs' : 'text-white hover:bg-white/15 font-bold'" class="px-3.5 py-1.5 rounded-xl text-xs transition">
                                            🥇 Ordinal Numbers
                                        </button>
                                        <button @click="numVocabFilter = 'calendar'" :class="numVocabFilter === 'calendar' ? 'bg-white text-slate-900 font-black shadow-xs' : 'text-white hover:bg-white/15 font-bold'" class="px-3.5 py-1.5 rounded-xl text-xs transition">
                                            📅 Months &amp; Days
                                        </button>
                                        <button @click="numVocabFilter = 'era'" :class="numVocabFilter === 'era' ? 'bg-white text-slate-900 font-black shadow-xs' : 'text-white hover:bg-white/15 font-bold'" class="px-3.5 py-1.5 rounded-xl text-xs transition">
                                            🏛️ Eras &amp; Time Units
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <!-- Vocabulary Grid for Meeting 3 -->
                            @php
                                $calendarTerms = [
                                    ['word' => 'BC (Before Christ)', 'ipa' => '/ˌbiː ˈsiː/', 'meaning' => 'Sebelum Masehi', 'context' => '400 BC -> 400 tahun sebelum masehi', 'category' => 'era'],
                                    ['word' => 'AD (Anno Domini)', 'ipa' => '/ˌeɪ ˈdiː/', 'meaning' => 'Setelah Masehi / Tahun Masehi', 'context' => '1492 AD -> Tahun 1492 Masehi', 'category' => 'era'],
                                    ['word' => 'Decade', 'ipa' => '/ˈdek.eɪd/', 'meaning' => 'Dekade (Periode 10 tahun)', 'context' => 'The 1990s was a great decade', 'category' => 'era'],
                                    ['word' => 'Century', 'ipa' => '/ˈsen.tʃər.i/', 'meaning' => 'Abad (Periode 100 tahun)', 'context' => 'We are living in the 21st century', 'category' => 'era'],
                                    ['word' => 'Millennium', 'ipa' => '/mɪˈlen.i.əm/', 'meaning' => 'Milenium (Periode 1000 tahun)', 'context' => 'The start of a new millennium', 'category' => 'era'],
                                    ['word' => 'Leap Year', 'ipa' => '/ˈliːp ˌjɪər/', 'meaning' => 'Tahun Kabisat (Februari 29 hari)', 'context' => '2024 is a leap year with 366 days', 'category' => 'era'],
                                    ['word' => 'Date of Birth', 'ipa' => '/deɪt əv bɜːθ/', 'meaning' => 'Tanggal Lahir', 'context' => 'My date of birth is January 29th', 'category' => 'calendar'],
                                    ['word' => 'Calendar', 'ipa' => '/ˈkæl.ən.dər/', 'meaning' => 'Kalender / Penanggalan', 'context' => 'Check the calendar on the wall', 'category' => 'calendar'],
                                ];
                            @endphp

                            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4">
                                <!-- Calendar & Era terms -->
                                @foreach($calendarTerms as $tt)
                                    <div x-show="numVocabFilter === 'all' || numVocabFilter === '{{ $tt['category'] }}'"
                                         class="p-5 rounded-3xl bg-white border-2 border-slate-100 hover:border-sky-300 hover:shadow-md transition flex flex-col justify-between">
                                        <div>
                                            <div class="flex items-center justify-between gap-2 mb-2">
                                                <span class="text-[10px] font-black uppercase px-2 py-0.5 rounded-md {{ $tt['category'] === 'calendar' ? 'bg-sky-100 text-sky-800' : 'bg-purple-100 text-purple-800' }}">{{ $tt['category'] === 'calendar' ? 'Calendar' : 'Eras' }}</span>
                                                <span class="text-[10px] font-mono font-bold text-slate-500">{{ $tt['ipa'] }}</span>
                                            </div>
                                            <h3 class="text-base font-black text-slate-900 mt-1">{{ $tt['word'] }}</h3>
                                            <p class="text-xs font-bold text-slate-600 mt-0.5">{{ $tt['meaning'] }}</p>
                                            <div class="mt-2.5 p-2 rounded-xl bg-slate-50 border border-slate-100 font-mono text-[11px] text-slate-800">
                                                {{ $tt['context'] }}
                                            </div>
                                        </div>
                                        <button @click="speakText(@js($tt['word'] . '. ' . $tt['context']))" class="mt-3 w-full py-1.5 rounded-xl bg-slate-100 hover:bg-sky-600 hover:text-white text-slate-700 font-bold text-xs transition flex items-center justify-center gap-1.5 shadow-2xs">
                                            <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 24 24"><path d="M3 9v6h4l5 5V4L7 9H3zm13.5 3c0-1.77-1.02-3.29-2.5-4.03v8.05c1.48-.73 2.5-2.25 2.5-4.02z"/></svg>
                                            <span>Lafalkan</span>
                                        </button>
                                    </div>
                                @endforeach

                                <!-- Cardinal & Ordinal Numbers from Materi -->
                                @foreach($meetingData['materi']['cardinal_numbers'] ?? [] as $cn)
                                    <div x-show="numVocabFilter === 'all' || numVocabFilter === 'cardinal'"
                                         class="p-5 rounded-3xl bg-white border-2 border-slate-100 hover:border-blue-300 hover:shadow-md transition flex flex-col justify-between">
                                        <div>
                                            <div class="flex items-center justify-between gap-2 mb-2">
                                                <span class="text-xs font-black font-mono px-2.5 py-0.5 rounded-md bg-blue-600 text-white">{{ $cn['num'] }}</span>
                                                <span class="text-[10px] font-mono font-bold text-slate-500">{{ $cn['ipa'] }}</span>
                                            </div>
                                            <h3 class="text-base font-black text-slate-900 mt-1 capitalize">{{ $cn['words'] }}</h3>
                                            <p class="text-xs font-semibold text-slate-500 mt-0.5">Cardinal Number (Jumlah)</p>
                                        </div>
                                        <button @click="speakText(@js($cn['words']))" class="mt-3 w-full py-1.5 rounded-xl bg-blue-50 hover:bg-blue-600 hover:text-white text-blue-700 font-bold text-xs transition flex items-center justify-center gap-1.5 shadow-2xs">
                                            <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 24 24"><path d="M3 9v6h4l5 5V4L7 9H3zm13.5 3c0-1.77-1.02-3.29-2.5-4.03v8.05c1.48-.73 2.5-2.25 2.5-4.02z"/></svg>
                                            <span>Lafalkan</span>
                                        </button>
                                    </div>
                                @endforeach

                                @foreach($meetingData['materi']['ordinal_numbers'] ?? [] as $ord)
                                    <div x-show="numVocabFilter === 'all' || numVocabFilter === 'ordinal'"
                                         class="p-5 rounded-3xl bg-white border-2 border-slate-100 hover:border-amber-300 hover:shadow-md transition flex flex-col justify-between">
                                        <div>
                                            <div class="flex items-center justify-between gap-2 mb-2">
                                                <span class="text-xs font-black font-mono px-2.5 py-0.5 rounded-md bg-amber-500 text-white">{{ $ord['num'] }}</span>
                                                <span class="text-[10px] font-mono font-bold text-slate-500">{{ $ord['ipa'] }}</span>
                                            </div>
                                            <h3 class="text-base font-black text-slate-900 mt-1 capitalize">{{ $ord['words'] }}</h3>
                                            <p class="text-xs font-semibold text-amber-700 mt-0.5">Ordinal Number (Urutan/Tanggal)</p>
                                        </div>
                                        <button @click="speakText(@js($ord['words']))" class="mt-3 w-full py-1.5 rounded-xl bg-amber-50 hover:bg-amber-600 hover:text-white text-amber-800 font-bold text-xs transition flex items-center justify-center gap-1.5 shadow-2xs">
                                            <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 24 24"><path d="M3 9v6h4l5 5V4L7 9H3zm13.5 3c0-1.77-1.02-3.29-2.5-4.03v8.05c1.48-.73 2.5-2.25 2.5-4.02z"/></svg>
                                            <span>Lafalkan</span>
                                        </button>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                    @elseif(isset($meetingData['materi']['telling_time']))
                        <!-- ==================================================== -->
                        <!-- MEETING 4: VOCABULARY TIME & DAILY SCHEDULES         -->
                        <!-- ==================================================== -->
                        <div class="space-y-6" x-data="{ timeVocabFilter: 'all', searchVocab: '' }">
                            <!-- Hero Box for Time Vocab -->
                            <div style="background-color: #29a8f5 !important;" class="rounded-[2.5rem] p-6 sm:p-10 text-white shadow-xl relative overflow-hidden">
                                <div class="relative z-10 mb-6 flex flex-col md:flex-row md:items-center justify-between gap-4">
                                    <div>
                                        <span class="px-3.5 py-1 rounded-full bg-white/20 text-xs font-black uppercase tracking-wider text-white">Modul 04 • Vocabulary Bank</span>
                                        <h2 class="text-2xl sm:text-3xl font-black tracking-tight mt-2 text-white">Kosakata Jam, Jadwal &amp; Rutinitas (Time &amp; Schedules)</h2>
                                        <p class="text-xs sm:text-sm text-sky-100 font-medium mt-1">Koleksi lengkap istilah membaca jam, penanda waktu, jadwal transportasi, serta aktivitas rutinitas harian.</p>
                                    </div>
                                </div>

                                <!-- Filter Buttons Bar -->
                                <div class="relative z-10 flex flex-col sm:flex-row sm:items-center justify-between gap-3 bg-white/15 p-2.5 rounded-2xl border border-white/25">
                                    <div class="flex items-center gap-1.5 overflow-x-auto scrollbar-none flex-wrap">
                                        <button @click="timeVocabFilter = 'all'" :class="timeVocabFilter === 'all' ? 'bg-white text-slate-900 font-black shadow-xs' : 'text-white hover:bg-white/15 font-bold'" class="px-3.5 py-1.5 rounded-xl text-xs transition">
                                            Semua
                                        </button>
                                        <button @click="timeVocabFilter = 'clock'" :class="timeVocabFilter === 'clock' ? 'bg-white text-slate-900 font-black shadow-xs' : 'text-white hover:bg-white/15 font-bold'" class="px-3.5 py-1.5 rounded-xl text-xs transition">
                                            ⏰ Clock Expressions
                                        </button>
                                        <button @click="timeVocabFilter = 'schedules'" :class="timeVocabFilter === 'schedules' ? 'bg-white text-slate-900 font-black shadow-xs' : 'text-white hover:bg-white/15 font-bold'" class="px-3.5 py-1.5 rounded-xl text-xs transition">
                                            ✈️ Schedules &amp; Transport
                                        </button>
                                        <button @click="timeVocabFilter = 'routines'" :class="timeVocabFilter === 'routines' ? 'bg-white text-slate-900 font-black shadow-xs' : 'text-white hover:bg-white/15 font-bold'" class="px-3.5 py-1.5 rounded-xl text-xs transition">
                                            🏃 Daily Routines
                                        </button>
                                    </div>
                                </div>
                            </div>

                            @php
                                $meeting4Vocab = [
                                    // Clock Expressions
                                    ['word' => 'A quarter past', 'ipa' => '/ə ˈkwɔː.tər pɑːst/', 'meaning' => 'Lebih 15 menit', 'context' => '04:15 -> A quarter past four', 'category' => 'clock'],
                                    ['word' => 'A quarter to', 'ipa' => '/ə ˈkwɔː.tər tuː/', 'meaning' => 'Kurang 15 menit', 'context' => '04:45 -> A quarter to five', 'category' => 'clock'],
                                    ['word' => 'Half past', 'ipa' => '/hɑːf pɑːst/', 'meaning' => 'Lebih 30 menit (setengah)', 'context' => '06:30 -> Half past six', 'category' => 'clock'],
                                    ['word' => "O'clock", 'ipa' => '/əˈklɒk/', 'meaning' => 'Tepat (tanpa menit)', 'context' => "07:00 -> Seven o'clock", 'category' => 'clock'],
                                    ['word' => 'AM (Ante Meridiem)', 'ipa' => '/ˌeɪ ˈem/', 'meaning' => 'Pagi (12:00 malam - 11:59 siang)', 'context' => '07:30 AM -> In the morning', 'category' => 'clock'],
                                    ['word' => 'PM (Post Meridiem)', 'ipa' => '/ˌpiː ˈem/', 'meaning' => 'Siang / Malam (12:00 siang - 11:59 malam)', 'context' => '07:30 PM -> In the evening', 'category' => 'clock'],
                                    ['word' => 'Sharp', 'ipa' => '/ʃɑːp/', 'meaning' => 'Tepat waktu tanpa toleransi', 'context' => 'The flight leaves at 4 sharp', 'category' => 'clock'],
                                    ['word' => 'Hundred (Time)', 'ipa' => '/ˈhʌn.drəd/', 'meaning' => 'Format 24 jam internasional', 'context' => '14:00 -> Fourteen hundred', 'category' => 'clock'],
                                    ['word' => 'Noon / Midday', 'ipa' => '/nuːn/', 'meaning' => 'Jam 12 siang tepat', 'context' => 'Let us meet at noon (12:00 PM)', 'category' => 'clock'],
                                    ['word' => 'Midnight', 'ipa' => '/ˈmɪd.naɪt/', 'meaning' => 'Jam 12 tengah malam', 'context' => 'The clock struck midnight (12:00 AM)', 'category' => 'clock'],
                                    ['word' => 'Dawn / Sunrise', 'ipa' => '/dɔːn/', 'meaning' => 'Fajar / Subuh', 'context' => 'We wake up at dawn around 5 AM', 'category' => 'clock'],
                                    ['word' => 'Dusk / Sunset', 'ipa' => '/dʌsk/', 'meaning' => 'Senja / Petang', 'context' => 'The sun sets at dusk around 6 PM', 'category' => 'clock'],

                                    // Schedules & Transport
                                    ['word' => 'Departure', 'ipa' => '/dɪˈpɑː.tʃər/', 'meaning' => 'Keberangkatan', 'context' => 'Flight departure is at 08:15 AM', 'category' => 'schedules'],
                                    ['word' => 'Arrival', 'ipa' => '/əˈraɪ.vəl/', 'meaning' => 'Kedatangan', 'context' => 'Estimated arrival time is 11:45 PM', 'category' => 'schedules'],
                                    ['word' => 'Timetable / Schedule', 'ipa' => '/ˈtaɪmˌteɪ.bəl/', 'meaning' => 'Jadwal perjalanan / waktu', 'context' => 'Please check the train timetable', 'category' => 'schedules'],
                                    ['word' => 'On time', 'ipa' => '/ɒn taɪm/', 'meaning' => 'Tepat waktu sesuai jadwal', 'context' => 'The train arrived exactly on time', 'category' => 'schedules'],
                                    ['word' => 'Delayed', 'ipa' => '/dɪˈleɪd/', 'meaning' => 'Tertunda / Terlambat', 'context' => 'Flight GA-402 is delayed by 30 minutes', 'category' => 'schedules'],
                                    ['word' => 'Boarding Time', 'ipa' => '/ˈbɔː.dɪŋ taɪm/', 'meaning' => 'Waktu naik ke pesawat / kapal', 'context' => 'Boarding starts at 07:45 AM at Gate 4', 'category' => 'schedules'],

                                    // Daily Routines
                                    ['word' => 'Wake up', 'ipa' => '/weɪk ʌp/', 'meaning' => 'Bangun tidur', 'context' => 'I usually wake up at 6:00 AM sharp', 'category' => 'routines'],
                                    ['word' => 'Have breakfast', 'ipa' => '/hæv ˈbrek.fəst/', 'meaning' => 'Sarapan pagi', 'context' => 'I have breakfast at 7:00 AM every morning', 'category' => 'routines'],
                                    ['word' => 'Commute to work', 'ipa' => '/kəˈmjuːt tuː wɜːk/', 'meaning' => 'Berangkat perjalanan kerja', 'context' => 'It takes 45 minutes to commute to work', 'category' => 'routines'],
                                    ['word' => 'Lunch break', 'ipa' => '/lʌntʃ breɪk/', 'meaning' => 'Istirahat makan siang', 'context' => 'Lunch break is from 12:00 to 1:00 PM', 'category' => 'routines'],
                                    ['word' => 'Finish work', 'ipa' => '/ˈfɪn.ɪʃ wɜːk/', 'meaning' => 'Selesai / Pulang kerja', 'context' => 'I finish work at 5:00 PM', 'category' => 'routines'],
                                    ['word' => 'Go to bed', 'ipa' => '/ɡəʊ tuː bed/', 'meaning' => 'Pergi tidur', 'context' => 'I go to bed at half past ten at night', 'category' => 'routines'],
                                ];
                            @endphp

                            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4">
                                @foreach($meeting4Vocab as $mv)
                                    @php
                                        $catColorMap = [
                                            'clock' => 'bg-emerald-100 text-emerald-800',
                                            'schedules' => 'bg-sky-100 text-sky-800',
                                            'routines' => 'bg-amber-100 text-amber-800',
                                        ];
                                        $catBadgeText = [
                                            'clock' => 'Clock Time',
                                            'schedules' => 'Schedule',
                                            'routines' => 'Daily Routine',
                                        ];
                                    @endphp
                                    <div x-show="timeVocabFilter === 'all' || timeVocabFilter === '{{ $mv['category'] }}'"
                                         class="p-5 rounded-3xl bg-white border-2 border-slate-100 hover:border-sky-300 hover:shadow-md transition flex flex-col justify-between">
                                        <div>
                                            <div class="flex items-center justify-between gap-2 mb-2">
                                                <span class="text-[10px] font-black uppercase px-2 py-0.5 rounded-md {{ $catColorMap[$mv['category']] ?? 'bg-slate-100 text-slate-800' }}">{{ $catBadgeText[$mv['category']] ?? 'Vocab' }}</span>
                                                <span class="text-[10px] font-mono font-bold text-slate-500">{{ $mv['ipa'] }}</span>
                                            </div>
                                            <h3 class="text-base font-black text-slate-900 mt-1">{{ $mv['word'] }}</h3>
                                            <p class="text-xs font-bold text-slate-600 mt-0.5">{{ $mv['meaning'] }}</p>
                                            <div class="mt-2.5 p-2 rounded-xl bg-slate-50 border border-slate-100 font-mono text-[11px] text-slate-800">
                                                {{ $mv['context'] }}
                                            </div>
                                        </div>
                                        <button @click="speakText(@js($mv['word'] . '. ' . $mv['context']))" class="mt-3 w-full py-1.5 rounded-xl bg-slate-100 hover:bg-sky-600 hover:text-white text-slate-700 font-bold text-xs transition flex items-center justify-center gap-1.5 shadow-2xs">
                                            <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 24 24"><path d="M3 9v6h4l5 5V4L7 9H3zm13.5 3c0-1.77-1.02-3.29-2.5-4.03v8.05c1.48-.73 2.5-2.25 2.5-4.02z"/></svg>
                                            <span>Lafalkan</span>
                                        </button>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @elseif(isset($meetingData['materi']['pronouns_mastery']))
                        <!-- ==================================================== -->
                        <!-- MEETING 5: VOCABULARY BANK PRONOUNS (FLASHCARDS)     -->
                        <!-- ==================================================== -->
                        <div class="space-y-6" x-data="{ pronounFilter: 'all', searchVocab: '' }">
                            <!-- Hero Box for Pronouns Vocab -->
                            <div style="background-color: #29a8f5 !important;" class="rounded-[2.5rem] p-6 sm:p-10 text-white shadow-xl relative overflow-hidden">
                                <div class="relative z-10 mb-6 flex flex-col md:flex-row md:items-center justify-between gap-4">
                                    <div>
                                        <div class="flex items-center gap-2 mb-1">
                                            <span class="px-3.5 py-1 rounded-full bg-white/20 text-xs font-black uppercase tracking-wider text-white backdrop-blur-md">
                                                Modul 05 • Flashcard Bank
                                            </span>
                                            <span class="px-3 py-1 rounded-full bg-amber-400 text-slate-950 text-xs font-black uppercase">
                                                {{ count($meetingData['vocabulary'] ?? []) }} Cards
                                            </span>
                                        </div>
                                        <h2 class="text-2xl sm:text-3xl font-black tracking-tight mt-2 text-white">Bank Kosakata Lengkap Pronouns &amp; Demonstratives</h2>
                                        <p class="text-xs sm:text-sm text-sky-100 font-medium mt-1">Kartu kosakata interaktif dengan fonetik IPA, fungsi tata bahasa, arti Bahasa Indonesia, dan contoh kalimat percakapan.</p>
                                    </div>
                                    <button @click="speakText('I, Me, My, Mine, Myself, You, Your, Yours, Yourself, Yourselves, He, Him, His, Himself, She, Her, Hers, Herself, It, Its, Itself, We, Us, Our, Ours, Ourselves, They, Them, Their, Theirs, Themselves')"
                                        type="button" class="px-5 py-2.5 rounded-2xl bg-amber-400 hover:bg-amber-300 text-slate-950 font-black text-xs sm:text-sm shadow-md transition flex items-center gap-2 shrink-0 self-start md:self-auto">
                                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M3 9v6h4l5 5V4L7 9H3zm13.5 3c0-1.77-1.02-3.29-2.5-4.03v8.05c1.48-.73 2.5-2.25 2.5-4.02z"/></svg>
                                        <span>Lafalkan Semua Kartu</span>
                                    </button>
                                </div>

                                <!-- Filter Buttons Bar -->
                                <div class="relative z-10 flex flex-col sm:flex-row sm:items-center justify-between gap-3 bg-white/15 p-2.5 rounded-2xl border border-white/25">
                                    <div class="flex items-center gap-1.5 overflow-x-auto scrollbar-none flex-wrap">
                                        <button @click="pronounFilter = 'all'" :class="pronounFilter === 'all' ? 'bg-white text-slate-900 font-black shadow-xs' : 'text-white hover:bg-white/15 font-bold'" class="px-3.5 py-1.5 rounded-xl text-xs transition">
                                            Semua ({{ count($meetingData['vocabulary'] ?? []) }})
                                        </button>
                                        <button @click="pronounFilter = 'subject'" :class="pronounFilter === 'subject' ? 'bg-white text-indigo-900 font-black shadow-xs' : 'text-white hover:bg-white/15 font-bold'" class="px-3.5 py-1.5 rounded-xl text-xs transition">
                                            🔵 Subject
                                        </button>
                                        <button @click="pronounFilter = 'object'" :class="pronounFilter === 'object' ? 'bg-white text-emerald-900 font-black shadow-xs' : 'text-white hover:bg-white/15 font-bold'" class="px-3.5 py-1.5 rounded-xl text-xs transition">
                                            🟢 Object
                                        </button>
                                        <button @click="pronounFilter = 'possessive_adj'" :class="pronounFilter === 'possessive_adj' ? 'bg-white text-amber-900 font-black shadow-xs' : 'text-white hover:bg-white/15 font-bold'" class="px-3.5 py-1.5 rounded-xl text-xs transition">
                                            🟡 Possessive Adj
                                        </button>
                                        <button @click="pronounFilter = 'possessive_pro'" :class="pronounFilter === 'possessive_pro' ? 'bg-white text-purple-900 font-black shadow-xs' : 'text-white hover:bg-white/15 font-bold'" class="px-3.5 py-1.5 rounded-xl text-xs transition">
                                            🟣 Possessive Pro
                                        </button>
                                        <button @click="pronounFilter = 'reflexive'" :class="pronounFilter === 'reflexive' ? 'bg-white text-rose-900 font-black shadow-xs' : 'text-white hover:bg-white/15 font-bold'" class="px-3.5 py-1.5 rounded-xl text-xs transition">
                                            🔴 Reflexive
                                        </button>
                                    </div>
                                    <div class="relative min-w-[200px]">
                                        <input type="text" x-model="searchVocab" placeholder="Cari kata pronoun..." class="w-full pl-8 pr-3 py-1.5 rounded-xl bg-white/20 border border-white/30 text-white placeholder:text-white/60 text-xs focus:outline-none focus:bg-white focus:text-slate-900 focus:placeholder:text-slate-400 transition">
                                        <svg class="w-3.5 h-3.5 absolute left-2.5 top-1/2 -translate-y-1/2 text-white/70" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                                    </div>
                                </div>
                            </div>

                            <!-- Vocabulary Cards Grid -->
                            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                                @foreach($meetingData['vocabulary'] ?? [] as $v)
                                    @php
                                        $typeLower = strtolower($v['type'] ?? '');
                                        $catTag = 'other';
                                        if (str_contains($typeLower, 'subject')) $catTag = 'subject';
                                        elseif (str_contains($typeLower, 'object') && !str_contains($typeLower, 'possessive')) $catTag = 'object';
                                        elseif (str_contains($typeLower, 'adjective')) $catTag = 'possessive_adj';
                                        elseif (str_contains($typeLower, 'possessive pronoun') || str_contains($typeLower, 'mandiri')) $catTag = 'possessive_pro';
                                        elseif (str_contains($typeLower, 'reflexive')) $catTag = 'reflexive';

                                        $cardBadgeBg = match($catTag) {
                                            'subject' => 'bg-indigo-100 text-indigo-700',
                                            'object' => 'bg-emerald-100 text-emerald-700',
                                            'possessive_adj' => 'bg-amber-100 text-amber-800',
                                            'possessive_pro' => 'bg-purple-100 text-purple-700',
                                            'reflexive' => 'bg-rose-100 text-rose-700',
                                            default => 'bg-slate-100 text-slate-700'
                                        };
                                    @endphp
                                    <div x-show="(pronounFilter === 'all' || pronounFilter === '{{ $catTag }}') && (searchVocab === '' || '{{ strtolower($v['word']) }}'.includes(searchVocab.toLowerCase()) || '{{ strtolower($v['meaning']) }}'.includes(searchVocab.toLowerCase()))"
                                         class="p-5 rounded-3xl bg-white border border-slate-200/90 hover:border-blue-400 hover:shadow-md transition flex flex-col justify-between space-y-3">
                                        <div>
                                            <div class="flex items-center justify-between gap-2 mb-1">
                                                <span class="text-xs font-black px-2.5 py-0.5 rounded-full {{ $cardBadgeBg }}">{{ $v['type'] }}</span>
                                                <span class="text-[11px] font-mono font-bold text-slate-400">{{ $v['ipa'] }}</span>
                                            </div>
                                            <h3 class="text-xl font-black text-slate-900 mt-1">{{ $v['word'] }}</h3>
                                            <p class="text-xs font-bold text-slate-600 mt-0.5">{{ $v['meaning'] }}</p>
                                            <div class="mt-2.5 p-2.5 rounded-xl bg-slate-50 border border-slate-100 text-xs text-slate-700 italic">
                                                "{{ $v['example'] }}"
                                            </div>
                                        </div>
                                        <button @click="speakText(@js($v['word'] . '. ' . $v['example']))" class="w-full py-2 rounded-xl bg-slate-100 hover:bg-blue-600 hover:text-white text-slate-700 font-bold text-xs transition flex items-center justify-center gap-1.5 shadow-2xs">
                                            <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 24 24"><path d="M3 9v6h4l5 5V4L7 9H3zm13.5 3c0-1.77-1.02-3.29-2.5-4.03v8.05c1.48-.73 2.5-2.25 2.5-4.02z"/></svg>
                                            <span>Lafalkan Kata &amp; Contoh</span>
                                        </button>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @else
                        <!-- Generic Vocabulary Fallback for Other Meetings -->
                        <div class="bg-white rounded-[2rem] p-6 sm:p-8 shadow-sm border border-slate-200">
                            <h3 class="text-xl font-black text-slate-900 mb-2">Meeting Vocabulary</h3>
                            <p class="text-sm text-slate-600 font-medium">{{ $meetingData['vocabulary'] ?? 'Kosakata untuk topik meeting ini.' }}</p>
                        </div>
                    @endif
                </div>

                <!-- ========================================== -->
                <!-- TAB 6: GAME SPEAKING (CLASSROOM GAME) -->
                <!-- ========================================== -->
                <div x-show="activeTab === 'game'" class="space-y-6">
                    <div>
                        @if(count($games) > 1)
                            <div class="flex flex-wrap gap-2 mb-4">
                                @foreach($games as $i => $g)
                                    <button @click="activeGameIndex = {{ $i }}; @if($i < count($materiBlocks))activeMateriIndex = {{ $i }};@endif" type="button"
                                        :class="activeGameIndex === {{ $i }} ? 'bg-orange-500 text-white shadow-md' : 'bg-white text-slate-600 border border-slate-200 hover:bg-orange-50'"
                                        class="px-4 py-2 rounded-2xl text-xs sm:text-sm font-black transition-all">
                                        {{ $g['title'] ?? ('Game ' . ($i + 1)) }}
                                    </button>
                                @endforeach
                            </div>
                        @endif
                        @foreach($games as $i => $gameData)
                            <div x-show="activeGameIndex === {{ $i }}">
                                @php
                                    $gameStudentGroups = $meetingStudentGroups->filter(fn ($grp) => $grp->game_index === null || $grp->game_index === $i)->values();
                                    $participationBadge = match($gameData['participation_type'] ?? 'pair') {
                                        'individual' => ['icon' => '🧍', 'label' => 'Individu'],
                                        'group' => ['icon' => '👨‍👩‍👧‍👦', 'label' => 'Berkelompok'],
                                        default => ['icon' => '👥', 'label' => 'Berpasangan (Student A & B)'],
                                    };
                                @endphp

                    @if(isset($gameData['type']) && $gameData['type'] === 'half_a_crossword')
                        <!-- ==================================================== -->
                        <!-- MEETING 2: HALF A CROSSWORD (JOBS & OCCUPATIONS)     -->
                        <!-- ==================================================== -->
                        <div class="bg-white rounded-[2rem] p-6 sm:p-8 shadow-sm border border-slate-200/90 relative overflow-hidden" 
                             x-data="{ 
                                 crosswordTab: 'A', 
                                 sideTab: 'missing', 
                                 gridInputs: {}, 
                                 lastDir: 'down',
                                 activeWordKey: null,
                                 wordMap: @js($gameData['words'] ?? []),
                                 cellToWords: {},
                                 init() {
                                     let mapping = {};
                                     for (let wKey in this.wordMap) {
                                         let cells = this.wordMap[wKey].cells || [];
                                         cells.forEach(cKey => {
                                             if (!mapping[cKey]) mapping[cKey] = [];
                                             mapping[cKey].push(wKey);
                                         });
                                     }
                                     this.cellToWords = mapping;
                                 },
                                 isCellHighlighted(r, c) {
                                     if (!this.activeWordKey || !this.wordMap[this.activeWordKey]) return false;
                                     let cKey = r + '_' + c;
                                     return (this.wordMap[this.activeWordKey].cells || []).includes(cKey);
                                 },
                                 selectWord(wKey, focusFirst = true) {
                                     if (!this.wordMap[wKey]) return;
                                     this.activeWordKey = wKey;
                                     this.lastDir = this.wordMap[wKey].dir;
                                     if (focusFirst) {
                                         let cells = this.wordMap[wKey].cells || [];
                                         let targetEl = null;
                                         for (let cKey of cells) {
                                             let el = document.getElementById('input_' + cKey);
                                             if (el && !this.gridInputs[cKey]) {
                                                 targetEl = el;
                                                 break;
                                             }
                                         }
                                         if (!targetEl && cells.length > 0) {
                                             for (let cKey of cells) {
                                                 let el = document.getElementById('input_' + cKey);
                                                 if (el) { targetEl = el; break; }
                                             }
                                         }
                                         if (targetEl) {
                                             targetEl.focus();
                                             targetEl.select();
                                         }
                                     }
                                 },
                                 onCellClick(r, c, num = null) {
                                     let key = r + '_' + c;
                                     let words = this.cellToWords[key] || [];
                                     if (words.length === 0) return;
                                     if (num) {
                                         let match = words.find(w => this.wordMap[w] && this.wordMap[w].num == num);
                                         if (match) {
                                             if (this.activeWordKey === match && words.length > 1) {
                                                 let other = words.find(w => w !== match);
                                                 this.selectWord(other, true);
                                             } else {
                                                 this.selectWord(match, true);
                                             }
                                             return;
                                         }
                                     }
                                     if (words.length > 1 && words.includes(this.activeWordKey)) {
                                         let other = words.find(w => w !== this.activeWordKey);
                                         this.selectWord(other, false);
                                     } else {
                                         this.selectWord(words[0], false);
                                     }
                                 },
                                 onCellFocus(r, c) {
                                     let key = r + '_' + c;
                                     let words = this.cellToWords[key] || [];
                                     if (words.length === 0) return;
                                     if (!this.activeWordKey || !words.includes(this.activeWordKey)) {
                                         let match = words.find(w => this.wordMap[w] && this.wordMap[w].dir === this.lastDir);
                                         this.selectWord(match || words[0], false);
                                     }
                                 },
                                 handleCellInput(e, r, c) {
                                     let val = e.target.value.toUpperCase();
                                     this.gridInputs[r + '_' + c] = val;
                                     if (val) {
                                         this.moveNext(r, c);
                                     }
                                 },
                                 handleCellKeydown(e, r, c) {
                                     if (e.key === 'ArrowDown') {
                                         e.preventDefault();
                                         this.focusCell(r + 1, c, 'down');
                                     } else if (e.key === 'ArrowUp') {
                                         e.preventDefault();
                                         this.focusCell(r - 1, c, 'up');
                                     } else if (e.key === 'ArrowRight') {
                                         e.preventDefault();
                                         this.focusCell(r, c + 1, 'across');
                                     } else if (e.key === 'ArrowLeft') {
                                         e.preventDefault();
                                         this.focusCell(r, c - 1, 'left');
                                     } else if (e.key === 'Enter') {
                                         e.preventDefault();
                                         this.moveNext(r, c);
                                     } else if (e.key === ' ' || e.code === 'Space') {
                                         e.preventDefault();
                                         let key = r + '_' + c;
                                         let words = this.cellToWords[key] || [];
                                         if (words.length > 1) {
                                             let other = words.find(w => w !== this.activeWordKey);
                                             if (other) this.selectWord(other, false);
                                         } else {
                                             this.lastDir = (this.lastDir === 'down' ? 'across' : 'down');
                                         }
                                     } else if (e.key === 'Backspace') {
                                         if (!e.target.value) {
                                             e.preventDefault();
                                             this.movePrev(r, c);
                                         }
                                     }
                                 },
                                 detectDir(r, c) {
                                     if (this.activeWordKey && this.wordMap[this.activeWordKey]) {
                                         return this.wordMap[this.activeWordKey].dir;
                                     }
                                     let hasV = this.hasNeighbor(r + 1, c) || this.hasNeighbor(r - 1, c);
                                     let hasH = this.hasNeighbor(r, c + 1) || this.hasNeighbor(r, c - 1);
                                     if (hasV && !hasH) return 'down';
                                     if (hasH && !hasV) return 'across';
                                     return this.lastDir || 'down';
                                 },
                                 hasNeighbor(r, c) {
                                     return !!document.getElementById('cell_' + r + '_' + c);
                                 },
                                 moveNext(r, c) {
                                     let dir = this.detectDir(r, c);
                                     this.lastDir = dir;
                                     if (dir === 'down') {
                                         for (let nr = r + 1; nr < 20; nr++) {
                                             let el = document.getElementById('input_' + nr + '_' + c);
                                             if (el) { el.focus(); el.select(); return; }
                                             if (!document.getElementById('cell_' + nr + '_' + c)) break;
                                         }
                                     } else {
                                         for (let nc = c + 1; nc < 21; nc++) {
                                             let el = document.getElementById('input_' + r + '_' + nc);
                                             if (el) { el.focus(); el.select(); return; }
                                             if (!document.getElementById('cell_' + r + '_' + nc)) break;
                                         }
                                     }
                                 },
                                 movePrev(r, c) {
                                     let dir = this.detectDir(r, c);
                                     this.lastDir = dir;
                                     if (dir === 'down') {
                                         for (let pr = r - 1; pr >= 0; pr--) {
                                             let el = document.getElementById('input_' + pr + '_' + c);
                                             if (el) { el.focus(); el.select(); return; }
                                             if (!document.getElementById('cell_' + pr + '_' + c)) break;
                                         }
                                     } else {
                                         for (let pc = c - 1; pc >= 0; pc--) {
                                             let el = document.getElementById('input_' + r + '_' + pc);
                                             if (el) { el.focus(); el.select(); return; }
                                             if (!document.getElementById('cell_' + r + '_' + pc)) break;
                                         }
                                     }
                                 },
                                 focusCell(r, c, dir) {
                                     this.lastDir = (dir === 'up' || dir === 'down') ? 'down' : 'across';
                                     let el = document.getElementById('input_' + r + '_' + c);
                                     if (el) { el.focus(); el.select(); }
                                 }
                             }">
                            <div class="absolute -top-10 -right-10 w-48 h-48 bg-sky-200/30 rounded-full blur-2xl pointer-events-none"></div>

                            <div class="relative z-10 flex flex-col lg:flex-row lg:items-center justify-between pb-6 mb-6 border-b border-slate-100 gap-6">
                                <div>
                                    <div class="flex items-center gap-2 mb-2.5 flex-wrap">
                                        <span style="background-color: #29a8f5 !important;" class="px-3.5 py-1 rounded-full text-xs font-black text-white shadow-xs">
                                            33 HALF A CROSSWORD
                                        </span>
                                        <span style="background-color: #ff9800 !important;" class="px-3.5 py-1 rounded-full text-xs font-black text-white shadow-xs">
                                            Waktu: {{ $gameData['time'] ?? '20-25 Menit' }}
                                        </span>
                                        <span style="background-color: #f0f9ff !important; color: #0284c7 !important; border: 1px solid #bae6fd !important;" class="px-3 py-1 rounded-full text-xs font-black">
                                            {{ $participationBadge['icon'] }} {{ $participationBadge['label'] }}
                                        </span>
                                    </div>
                                    <h2 class="text-2xl sm:text-3xl font-black text-slate-900 tracking-tight">
                                        Half a Crossword: Jobs and Occupations
                                    </h2>
                                    <p class="text-xs sm:text-sm text-slate-600 font-semibold mt-1">
                                        <strong style="color: #29a8f5;">AIM:</strong> {{ $gameData['aim'] ?? 'To complete the crossword puzzle by describing and asking for missing job words without saying the target words.' }}
                                    </p>
                                </div>

                                <!-- Group Selector Switcher -->
                                <div class="flex items-center bg-slate-100 p-1.5 rounded-2xl border border-slate-200 text-xs font-bold shrink-0 shadow-2xs">
                                    <button @click="crosswordTab = 'A'" :style="crosswordTab === 'A' ? 'background-color: #29a8f5 !important; color: #ffffff !important;' : ''" :class="crosswordTab === 'A' ? 'shadow-md font-black' : 'text-slate-600 hover:text-slate-900'" class="px-5 py-2.5 rounded-xl transition flex items-center gap-2">
                                        <span>Player A (Group A Sheet)</span>
                                    </button>
                                    <button @click="crosswordTab = 'B'" :style="crosswordTab === 'B' ? 'background-color: #ff9800 !important; color: #ffffff !important;' : ''" :class="crosswordTab === 'B' ? 'shadow-md font-black' : 'text-slate-600 hover:text-slate-900'" class="px-5 py-2.5 rounded-xl transition flex items-center gap-2">
                                        <span>Player B (Group B Sheet)</span>
                                    </button>
                                </div>
                            </div>

                            <!-- Dedicated Practice (Game Shadowing & Drilling Khusus Game) -->
                            <div class="bg-sky-50 border-2 border-sky-200/90 rounded-[2rem] p-6 sm:p-7 mb-8 shadow-sm">
                                <div class="flex flex-col sm:flex-row sm:items-center justify-between pb-4 mb-4 border-b border-sky-200/60 gap-3">
                                    <div class="flex items-center gap-2.5">
                                        <span class="w-8 h-8 rounded-xl bg-blue-600 text-white font-black text-xs flex items-center justify-center shadow-xs">🎯</span>
                                        <div>
                                            <div class="flex items-center gap-2">
                                                <span class="px-2.5 py-0.5 rounded-full text-[10px] font-black uppercase tracking-wider bg-blue-600 text-white shadow-2xs">Khusus Game Crossword</span>
                                                <h3 class="text-sm sm:text-base font-black text-slate-900">Practice (Game Shadowing &amp; Clue Drilling)</h3>
                                            </div>
                                            <p class="text-xs text-slate-600 font-semibold mt-0.5">Latihlah kalimat tanya-jawab posisi puzzle dan pemberian petunjuk profesi berikut sebelum memainkan game:</p>
                                        </div>
                                    </div>
                                </div>

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-3.5">
                                    @foreach($meetingData['games']['drilling_game'] ?? [] as $gDrill)
                                        <div class="p-3.5 rounded-2xl bg-white border border-sky-100/90 hover:border-sky-300 shadow-2xs transition flex items-start justify-between gap-3">
                                            <div>
                                                @if(!empty($gDrill['category']))
                                                    <span class="text-[10px] font-black text-blue-700 uppercase tracking-wide block mb-1">{{ $gDrill['category'] }}</span>
                                                @endif
                                                <p class="font-black text-slate-900 text-xs sm:text-sm leading-snug">
                                                    • {{ $gDrill['en'] }}
                                                </p>
                                                <p class="text-xs text-slate-600 mt-0.5 font-semibold italic">
                                                    ({{ $gDrill['id'] }})
                                                </p>
                                            </div>
                                            <button @click="speakText(@js($gDrill['en']))" type="button" class="w-8 h-8 rounded-full bg-sky-50 hover:bg-blue-600 hover:text-white text-blue-600 border border-sky-200 shadow-2xs transition flex items-center justify-center shrink-0" title="Listen">
                                                <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 24 24"><path d="M3 9v6h4l5 5V4L7 9H3zm13.5 3c0-1.77-1.02-3.29-2.5-4.03v8.05c1.48-.73 2.5-2.25 2.5-4.02z"/></svg>
                                            </button>
                                        </div>
                                    @endforeach
                                </div>
                            </div>

                            <!-- Game Instructions Box (Dual Role Instructions) -->
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-5 mb-8">
                                <div style="background-color: #f0f9ff !important; border-color: #bae6fd !important;" class="p-6 rounded-[2rem] border-2 flex flex-col justify-between shadow-xs">
                                    <div>
                                        <div class="flex items-center gap-2 mb-2">
                                            <span style="background-color: #29a8f5 !important;" class="w-6 h-6 rounded-lg text-white font-black text-xs flex items-center justify-center shadow-2xs">A</span>
                                            <h4 style="color: #0284c7 !important;" class="text-xs font-black uppercase tracking-wider">Aturan Main Pemain A (Group A)</h4>
                                        </div>
                                        <p class="text-xs text-sky-950 font-medium leading-relaxed mb-3">
                                             Anda memiliki <strong>Lembar Crossword A</strong> yang sudah terisi 11 profesi (<em>actor, carpenter, dentist, hairdresser, vet, baker, chef, doctor, librarian, waiter, butcher</em>). Tugas Anda: jelaskan profesi tersebut saat pasangan Anda bertanya!
                                        </p>
                                    </div>
                                    <div class="p-3 bg-white rounded-2xl border border-sky-200 text-xs font-bold text-sky-800">
                                        Tanya Pasangan: <em>"What's 3 across in your puzzle?"</em>
                                    </div>
                                </div>

                                <div style="background-color: #fff7ed !important; border-color: #fed7aa !important;" class="p-6 rounded-[2rem] border-2 flex flex-col justify-between shadow-xs">
                                    <div>
                                        <div class="flex items-center gap-2 mb-2">
                                            <span style="background-color: #ff9800 !important;" class="w-6 h-6 rounded-lg text-white font-black text-xs flex items-center justify-center shadow-2xs">B</span>
                                            <h4 style="color: #c2410c !important;" class="text-xs font-black uppercase tracking-wider">Aturan Main Pemain B (Group B)</h4>
                                        </div>
                                        <p class="text-xs text-orange-950 font-medium leading-relaxed mb-3">
                                            Anda memiliki <strong>Lembar Crossword B</strong> yang sudah terisi 11 profesi (<em>architect, farmer, miner, pilot, secretary, barber, journalist, nurse, salesman, traffic warden, dustman</em>). Jelaskan definisinya tanpa menyebutkan kata kuncinya!
                                        </p>
                                    </div>
                                    <div class="p-3 bg-white rounded-2xl border border-orange-200 text-xs font-bold text-orange-800">
                                        Tanya Pasangan: <em>"What's 4 across in your puzzle?"</em>
                                    </div>
                                </div>
                            </div>

                            <!-- Dedicated Crossword Gameplay Dialogue Guide -->
                            <div class="bg-sky-50 border-2 border-sky-200/80 rounded-3xl p-6 mb-8 shadow-xs">
                                <div class="flex flex-col sm:flex-row sm:items-center justify-between pb-3 mb-4 border-b border-blue-200/60 gap-3">
                                    <div class="flex items-center gap-2.5">
                                        <span class="w-8 h-8 rounded-xl bg-blue-600 text-white font-black text-xs flex items-center justify-center shadow-xs">💬</span>
                                        <div>
                                            <h3 class="text-sm sm:text-base font-black text-slate-900">Panduan Dialog Percakapan Saat Memainkan Game (Gameplay Dialogue)</h3>
                                            <p class="text-[11px] text-slate-600 font-medium">Gunakan alur dialog 4 langkah berikut secara bergiliran untuk mengisi kotak-kotak yang kosong:</p>
                                        </div>
                                    </div>
                                    <button @click="speakText('Student A: What is 3 across? Student B: 3 across is farmer. Student A: How do you spell it? Student B: It is F. A. R. M. E. R. Student B: What is 8 down? Student A: 8 down is waiter. Student B: How do you spell it? Student A: It is W. A. I. T. E. R.')" type="button" class="px-4 py-2 rounded-xl bg-blue-600 hover:bg-blue-700 text-white font-bold text-xs shadow-xs transition flex items-center gap-1.5 shrink-0">
                                        <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 24 24"><path d="M3 9v6h4l5 5V4L7 9H3zm13.5 3c0-1.77-1.02-3.29-2.5-4.03v8.05c1.48-.73 2.5-2.25 2.5-4.02z"/></svg>
                                        <span>Dengarkan Contoh Dialog Lengkap</span>
                                    </button>
                                </div>

                                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-3.5">
                                    <div class="p-4 bg-white rounded-2xl border border-blue-100 shadow-2xs flex flex-col justify-between">
                                        <div>
                                            <span class="text-[10px] font-black px-2.5 py-0.5 rounded-md bg-blue-100 text-blue-800 uppercase">Langkah 1 • Tanya Nomor Kosong</span>
                                            <p class="text-xs sm:text-sm font-black text-slate-900 mt-2">"What is [3 across / 8 down]?"</p>
                                        </div>
                                        <p class="text-[11px] text-slate-500 mt-2 italic font-medium">(Pemain menanyakan nomor kotak yang masih kosong di lembarnya)</p>
                                    </div>

                                    <div class="p-4 bg-white rounded-2xl border border-blue-100 shadow-2xs flex flex-col justify-between">
                                        <div>
                                            <span class="text-[10px] font-black px-2.5 py-0.5 rounded-md bg-amber-100 text-amber-800 uppercase">Langkah 2 • Jawab Nama Profesi</span>
                                            <p class="text-xs sm:text-sm font-black text-slate-900 mt-2">"[3 across] is [farmer / waiter]."</p>
                                        </div>
                                        <p class="text-[11px] text-slate-500 mt-2 italic font-medium">(Partner yang punya kuncinya langsung menjawab nama profesinya)</p>
                                    </div>

                                    <div class="p-4 bg-white rounded-2xl border border-blue-100 shadow-2xs flex flex-col justify-between">
                                        <div>
                                            <span class="text-[10px] font-black px-2.5 py-0.5 rounded-md bg-purple-100 text-purple-800 uppercase">Langkah 3 • Minta Ejaan</span>
                                            <p class="text-xs sm:text-sm font-black text-slate-900 mt-2">"How do you spell it?"</p>
                                        </div>
                                        <p class="text-[11px] text-slate-500 mt-2 italic font-medium">(Meminta dieja huruf demi huruf agar bisa ditulis di kotak silang)</p>
                                    </div>

                                    <div class="p-4 bg-white rounded-2xl border border-blue-100 shadow-2xs flex flex-col justify-between">
                                        <div>
                                            <span class="text-[10px] font-black px-2.5 py-0.5 rounded-md bg-emerald-100 text-emerald-800 uppercase">Langkah 4 • Eja &amp; Tulis</span>
                                            <p class="text-xs sm:text-sm font-black text-slate-900 mt-2">"It is [W. A. I. T. E. R. / F. A. R. M. E. R.]"</p>
                                        </div>
                                        <p class="text-[11px] text-slate-500 mt-2 italic font-medium">(Eja huruf demi huruf dengan jelas dan tulis ke dalam kotak puzzle)</p>
                                    </div>
                                </div>
                            </div>

                            <!-- 1. FULL-WIDTH DIGITAL CROSSWORD BOARD CONTAINER -->
                            <div class="w-full bg-white p-4 sm:p-8 rounded-3xl border-2 border-sky-100 shadow-md flex flex-col items-center mb-8">
                                <div class="flex flex-col sm:flex-row sm:items-center justify-between w-full mb-6 pb-4 border-b border-slate-100 gap-3">
                                    <div>
                                        <div class="flex items-center gap-2">
                                            <span class="w-3.5 h-3.5 rounded-full" :class="crosswordTab === 'A' ? 'bg-sky-500' : 'bg-amber-500'"></span>
                                            <h4 class="font-black text-base sm:text-lg text-slate-900" x-text="crosswordTab === 'A' ? '33 HALF A CROSSWORD: GROUP A' : '33 HALF A CROSSWORD: GROUP B'"></h4>
                                        </div>
                                        <p class="text-xs text-slate-500 font-medium mt-0.5">Ketik huruf langsung di kotak teka-teki silang di bawah ini:</p>
                                    </div>

                                    <!-- Actions & Reset -->
                                    <div class="flex items-center gap-2">
                                        <button @click="gridInputs = {}" type="button" class="px-4 py-2 bg-slate-100 hover:bg-rose-50 text-rose-600 border border-slate-200 rounded-xl font-bold text-xs shadow-2xs transition flex items-center gap-1.5">
                                            <span>🔄 Reset Grid</span>
                                        </button>
                                    </div>
                                </div>

                                <!-- 2D DIGITAL CROSSWORD PUZZLE BOARD -->
                                <div class="w-full overflow-x-auto overflow-y-hidden pb-4 pt-1 flex justify-center rounded-3xl p-4 sm:p-7 shadow-inner" style="background-color: #dbeafe; border: 2px solid #93c5fd;">
                                    <div class="inline-block select-none" style="min-width: 620px; max-width: 860px; width: 100%;">
                                        @php
                                            $rows = $gameData['grid_rows'] ?? 20;
                                            $cols = $gameData['grid_cols'] ?? 21;
                                            $cells = $gameData['grid_cells'] ?? [];
                                        @endphp
                                        <div style="display: grid; grid-template-columns: repeat({{ $cols }}, minmax(0, 1fr)); background-color: transparent;" class="w-full">
                                            @for($r = 0; $r < $rows; $r++)
                                                @for($c = 0; $c < $cols; $c++)
                                                    @php
                                                        $cellKey = "{$r}_{$c}";
                                                        $cell = $cells[$cellKey] ?? null;
                                                    @endphp
                                                    @if($cell)
                                                        @php
                                                            $num = $cell['num'] ?? null;
                                                            $char = strtoupper($cell['char']);
                                                            $groups = $cell['groups'] ?? [];
                                                            $isGroupA = in_array('A', $groups);
                                                            $isGroupB = in_array('B', $groups);
                                                        @endphp
                                                        <div id="cell_{{ $r }}_{{ $c }}" 
                                                             @click="onCellClick({{ $r }}, {{ $c }}, {{ $num ?? 'null' }})"
                                                             :class="isCellHighlighted({{ $r }}, {{ $c }}) ? 'bg-amber-300 border-2 border-amber-600 ring-2 ring-amber-400/80 z-10 shadow-md' : 'bg-white border-2 border-slate-700 shadow-2xs'"
                                                             class="aspect-square relative flex items-center justify-center p-0 transition cursor-pointer rounded-[3px]">
                                                            @if($num)
                                                                <span @click.stop="onCellClick({{ $r }}, {{ $c }}, {{ $num }})" 
                                                                      :class="isCellHighlighted({{ $r }}, {{ $c }}) ? 'text-amber-950 font-black scale-110' : 'text-slate-700 font-extrabold'"
                                                                      class="absolute top-0.5 left-0.5 text-[7px] sm:text-[9px] leading-none z-20 select-none cursor-pointer hover:text-amber-700 hover:scale-125 transition">{{ $num }}</span>
                                                            @endif

                                                            <!-- Pre-filled Letter for Group A -->
                                                            <template x-if="crosswordTab === 'A' && @js($isGroupA)">
                                                                <span :class="isCellHighlighted({{ $r }}, {{ $c }}) ? 'text-amber-950 font-black' : 'text-slate-950 font-black'" 
                                                                      class="font-mono text-xs sm:text-base uppercase select-none leading-none pt-2 sm:pt-2.5">{{ $char }}</span>
                                                            </template>

                                                            <!-- Empty Editable Input for Group A -->
                                                            <template x-if="crosswordTab === 'A' && !@js($isGroupA)">
                                                                <input type="text" 
                                                                       id="input_{{ $r }}_{{ $c }}"
                                                                       maxlength="1" 
                                                                       x-model="gridInputs['{{ $cellKey }}']" 
                                                                       @focus="onCellFocus({{ $r }}, {{ $c }})"
                                                                       @input="handleCellInput($event, {{ $r }}, {{ $c }})"
                                                                       @keydown="handleCellKeydown($event, {{ $r }}, {{ $c }})"
                                                                       :class="gridInputs['{{ $cellKey }}'] ? (gridInputs['{{ $cellKey }}'] === '{{ $char }}' ? 'bg-emerald-200 text-emerald-950 font-black' : 'bg-sky-200 text-sky-950 font-black') : (isCellHighlighted({{ $r }}, {{ $c }}) ? 'bg-amber-300 text-amber-950 font-black' : 'bg-white text-slate-950')"
                                                                       class="crossword-cell-input w-full h-full text-center font-mono font-black text-xs sm:text-base uppercase focus:outline-none focus:ring-2 focus:ring-amber-500 p-0 border-0 rounded-none leading-none pt-2 sm:pt-2.5">
                                                            </template>

                                                            <!-- Pre-filled Letter for Group B -->
                                                            <template x-if="crosswordTab === 'B' && @js($isGroupB)">
                                                                <span :class="isCellHighlighted({{ $r }}, {{ $c }}) ? 'text-amber-950 font-black' : 'text-slate-950 font-black'" 
                                                                      class="font-mono text-xs sm:text-base uppercase select-none leading-none pt-2 sm:pt-2.5">{{ $char }}</span>
                                                            </template>

                                                            <!-- Empty Editable Input for Group B -->
                                                            <template x-if="crosswordTab === 'B' && !@js($isGroupB)">
                                                                <input type="text" 
                                                                       id="input_{{ $r }}_{{ $c }}"
                                                                       maxlength="1" 
                                                                       x-model="gridInputs['{{ $cellKey }}']" 
                                                                       @focus="onCellFocus({{ $r }}, {{ $c }})"
                                                                       @input="handleCellInput($event, {{ $r }}, {{ $c }})"
                                                                       @keydown="handleCellKeydown($event, {{ $r }}, {{ $c }})"
                                                                       :class="gridInputs['{{ $cellKey }}'] ? (gridInputs['{{ $cellKey }}'] === '{{ $char }}' ? 'bg-emerald-200 text-emerald-950 font-black' : 'bg-orange-200 text-orange-950 font-black') : (isCellHighlighted({{ $r }}, {{ $c }}) ? 'bg-amber-300 text-amber-950 font-black' : 'bg-white text-slate-950')"
                                                                       class="crossword-cell-input w-full h-full text-center font-mono font-black text-xs sm:text-base uppercase focus:outline-none focus:ring-2 focus:ring-amber-500 p-0 border-0 rounded-none leading-none pt-2 sm:pt-2.5">
                                                            </template>
                                                        </div>
                                                    @else
                                                        <div class="aspect-square bg-transparent"></div>
                                                    @endif
                                                @endfor
                                            @endfor
                                        </div>
                                    </div>
                                </div>
                                <p class="text-xs text-slate-500 font-medium text-center mt-3">
                                    Kotak putih yang kosong adalah huruf yang harus Anda tanyakan ke pasangan Anda!
                                </p>
                            </div>

                            <!-- 2. FULL-WIDTH QUESTIONS & ANSWERS CONTAINER (UNDER CROSSWORD) -->
                            <div class="w-full bg-white p-6 sm:p-8 rounded-3xl border-2 border-slate-200 shadow-sm mb-8">
                                <!-- Sub-Tab Header Switcher -->
                                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6 pb-4 border-b border-slate-100">
                                    <div>
                                        <h3 class="text-base sm:text-lg font-black text-slate-900">Bantuan Tanya-Jawab Soal Teka-Teki Silang</h3>
                                        <p class="text-xs text-slate-500 font-medium">Pilih tab di bawah untuk melihat daftar nomor yang perlu ditanyakan atau kunci jawaban Anda:</p>
                                    </div>

                                    <div class="flex items-center bg-slate-100 p-1.5 rounded-2xl border border-slate-200 text-xs font-bold shadow-2xs shrink-0">
                                        <button @click="sideTab = 'missing'" 
                                                :style="sideTab === 'missing' ? 'background-color: #29a8f5 !important; color: #ffffff !important;' : ''" 
                                                :class="sideTab === 'missing' ? 'shadow-md font-black' : 'text-slate-600 hover:text-slate-900'" 
                                                class="px-4 py-2 rounded-xl transition flex items-center gap-1.5">
                                            <span>❓ 11 Kotak Kosong Ditanyakan</span>
                                        </button>
                                        <button @click="sideTab = 'answers'" 
                                                :style="sideTab === 'answers' ? 'background-color: #ff9800 !important; color: #ffffff !important;' : ''" 
                                                :class="sideTab === 'answers' ? 'shadow-md font-black' : 'text-slate-600 hover:text-slate-900'" 
                                                class="px-4 py-2 rounded-xl transition flex items-center gap-1.5">
                                            <span>💡 Jawaban di Lembar</span>
                                        </button>
                                    </div>
                                </div>

                                <!-- Sub-Tab 1: 11 Missing Boxes to Ask (Kotak Kosong yang Harus Ditanyakan) -->
                                <div x-show="sideTab === 'missing'">
                                    <div class="flex items-center justify-between pb-3 mb-4 border-b border-slate-100">
                                        <div>
                                            <h4 class="font-black text-sm text-slate-900" x-text="crosswordTab === 'A' ? '11 Kotak Kosong (Ditanyakan Player A ke B):' : '11 Kotak Kosong (Ditanyakan Player B ke A):'"></h4>
                                            <p class="text-xs text-slate-500 font-medium">Tanyakan nomor-nomor ini ke pasanganmu untuk mengisi teka-teki silangmu:</p>
                                        </div>
                                        <span style="background-color: #29a8f5 !important;" class="px-3 py-1 rounded-full text-white text-xs font-black shrink-0">11 Soal</span>
                                    </div>

                                    <!-- Group A Missing Boxes Grid -->
                                    <div x-show="crosswordTab === 'A'" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                                        @foreach($gameData['group_a_missing'] ?? [] as $m)
                                            <div class="p-4 rounded-2xl border-2 transition flex flex-col justify-between shadow-2xs cursor-pointer"
                                                 :class="activeWordKey === @js($m['id'] ?? '') ? 'border-amber-400 bg-amber-50/90 ring-2 ring-amber-300 shadow-md' : 'border-sky-100 bg-sky-50/40 hover:border-sky-400 hover:bg-white'"
                                                 x-data="{ showEnglish: false }"
                                                 @click="selectWord(@js($m['id'] ?? '')); showEnglish = !showEnglish">
                                                <div>
                                                    <div class="flex items-center justify-between mb-2">
                                                        <span class="text-xs font-black font-mono text-sky-900 bg-sky-100 px-2.5 py-0.5 rounded-lg">{{ $m['number'] }}</span>
                                                        <span class="text-[10px] font-bold text-sky-700 bg-white px-2 py-0.5 rounded-md border border-sky-200">Kotak Kosong Anda</span>
                                                    </div>

                                                    <!-- Indonesian Question (Default) -->
                                                    <div class="space-y-1">
                                                        <p class="text-xs sm:text-sm font-bold text-slate-800">
                                                            "Apa profesi di no. <span class="font-mono text-sky-700 font-black">{{ $m['number'] }}</span>? Dan bagaimana cara mengejanya?"
                                                        </p>
                                                        <p class="text-[11px] text-slate-500 italic">
                                                            (Tanyakan ke partner untuk mengisi kotak kosong Anda)
                                                        </p>
                                                    </div>

                                                    <!-- English Revealed on Click -->
                                                    <div x-show="showEnglish" x-transition class="mt-3 pt-3 border-t border-sky-200/80 bg-sky-100/40 p-2.5 rounded-xl">
                                                        <div class="flex items-center justify-between mb-1">
                                                            <span class="text-[10px] font-black uppercase tracking-wider text-sky-800">🇬🇧 Kalimat Bahasa Inggris:</span>
                                                            <button @click.stop="speakText(@js($m['question']))" type="button" class="text-[11px] font-bold text-sky-600 hover:text-sky-900 flex items-center gap-1 bg-white px-2 py-0.5 rounded-md border border-sky-200 shadow-2xs">
                                                                <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 24 24"><path d="M3 9v6h4l5 5V4L7 9H3zm13.5 3c0-1.77-1.02-3.29-2.5-4.03v8.05c1.48-.73 2.5-2.25 2.5-4.02z"/></svg>
                                                                <span>Putar Audio</span>
                                                            </button>
                                                        </div>
                                                        <p class="text-xs sm:text-sm font-black text-sky-950">"{{ $m['question'] }}"</p>
                                                    </div>
                                                </div>

                                                <!-- Bottom Hint / Toggle Prompt -->
                                                <div class="mt-3 pt-2.5 border-t border-sky-100 flex items-center justify-between">
                                                    <span class="text-[10px] text-slate-400 font-semibold font-mono">Kunci: {{ $m['target_word'] }}</span>
                                                    <span class="text-[11px] font-bold text-sky-600 flex items-center gap-1" x-text="showEnglish ? '▲ Tutup' : '▼ Lihat Bahasa Inggris'"></span>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>

                                    <!-- Group B Missing Boxes Grid -->
                                    <div x-show="crosswordTab === 'B'" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                                        @foreach($gameData['group_b_missing'] ?? [] as $m)
                                            <div class="p-4 rounded-2xl border-2 transition flex flex-col justify-between shadow-2xs cursor-pointer"
                                                 :class="activeWordKey === @js($m['id'] ?? '') ? 'border-amber-400 bg-amber-50/90 ring-2 ring-amber-300 shadow-md' : 'border-orange-100 bg-orange-50/40 hover:border-orange-400 hover:bg-white'"
                                                 x-data="{ showEnglish: false }"
                                                 @click="selectWord(@js($m['id'] ?? '')); showEnglish = !showEnglish">
                                                <div>
                                                    <div class="flex items-center justify-between mb-2">
                                                        <span class="text-xs font-black font-mono text-orange-900 bg-orange-100 px-2.5 py-0.5 rounded-lg">{{ $m['number'] }}</span>
                                                        <span class="text-[10px] font-bold text-orange-700 bg-white px-2 py-0.5 rounded-md border border-orange-200">Kotak Kosong Anda</span>
                                                    </div>

                                                    <!-- Indonesian Question (Default) -->
                                                    <div class="space-y-1">
                                                        <p class="text-xs sm:text-sm font-bold text-slate-800">
                                                            "Apa profesi di no. <span class="font-mono text-orange-700 font-black">{{ $m['number'] }}</span>? Dan bagaimana cara mengejanya?"
                                                        </p>
                                                        <p class="text-[11px] text-slate-500 italic">
                                                            (Tanyakan ke partner untuk mengisi kotak kosong Anda)
                                                        </p>
                                                    </div>

                                                    <!-- English Revealed on Click -->
                                                    <div x-show="showEnglish" x-transition class="mt-3 pt-3 border-t border-orange-200/80 bg-orange-100/40 p-2.5 rounded-xl">
                                                        <div class="flex items-center justify-between mb-1">
                                                            <span class="text-[10px] font-black uppercase tracking-wider text-orange-800">🇬🇧 Kalimat Bahasa Inggris:</span>
                                                            <button @click.stop="speakText(@js($m['question']))" type="button" class="text-[11px] font-bold text-orange-600 hover:text-orange-900 flex items-center gap-1 bg-white px-2 py-0.5 rounded-md border border-orange-200 shadow-2xs">
                                                                <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 24 24"><path d="M3 9v6h4l5 5V4L7 9H3zm13.5 3c0-1.77-1.02-3.29-2.5-4.03v8.05c1.48-.73 2.5-2.25 2.5-4.02z"/></svg>
                                                                <span>Putar Audio</span>
                                                            </button>
                                                        </div>
                                                        <p class="text-xs sm:text-sm font-black text-orange-950">"{{ $m['question'] }}"</p>
                                                    </div>
                                                </div>

                                                <!-- Bottom Hint / Toggle Prompt -->
                                                <div class="mt-3 pt-2.5 border-t border-orange-100 flex items-center justify-between">
                                                    <span class="text-[10px] text-slate-400 font-semibold font-mono">Kunci: {{ $m['target_word'] }}</span>
                                                    <span class="text-[11px] font-bold text-orange-600 flex items-center gap-1" x-text="showEnglish ? '▲ Tutup' : '▼ Lihat Bahasa Inggris'"></span>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>

                                <!-- Sub-Tab 2: Words to Answer (Kata yang Sudah Terisi di Lembarmu) -->
                                <div x-show="sideTab === 'answers'">
                                    <div class="flex items-center justify-between pb-3 mb-4 border-b border-slate-100">
                                        <div>
                                            <h4 class="font-black text-sm text-slate-900" x-text="crosswordTab === 'A' ? 'Jawaban di Lembar A (Untuk Menjawab Player B):' : 'Jawaban di Lembar B (Untuk Menjawab Player A):'"></h4>
                                            <p class="text-xs text-slate-500 font-medium">Gunakan ini saat pasanganmu bertanya nomor yang ada di lembarmu:</p>
                                        </div>
                                        <span style="background-color: #ff9800 !important;" class="px-3 py-1 rounded-full text-white text-xs font-black shrink-0">11 Kunci</span>
                                    </div>

                                    <!-- Group A Filled Words Grid -->
                                    <div x-show="crosswordTab === 'A'" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                                        @foreach(array_slice($gameData['cards'] ?? [], 0, 11) as $c)
                                            <div class="p-4 rounded-2xl border-2 transition flex flex-col justify-between shadow-2xs cursor-pointer"
                                                 :class="activeWordKey === @js($c['id'] ?? '') ? 'border-amber-400 bg-amber-50/90 ring-2 ring-amber-300 shadow-md' : 'border-sky-100 bg-sky-50/40 hover:border-sky-400 hover:bg-white'"
                                                 @click="selectWord(@js($c['id'] ?? ''))">
                                                <div>
                                                    <div class="flex items-center justify-between mb-2">
                                                        <span class="text-xs font-black font-mono text-sky-900 bg-sky-100 px-2.5 py-0.5 rounded-lg">{{ $c['number'] }}</span>
                                                        <span class="font-mono font-black text-xs text-sky-700 uppercase bg-white px-2 py-0.5 rounded-md border border-sky-200">{{ $c['word'] }}</span>
                                                    </div>
                                                    <p class="text-xs sm:text-sm text-slate-800 font-medium leading-relaxed">Jawaban: "{{ $c['number'] }} is {{ strtolower($c['word']) }}. It is {{ $c['spelling'] }}."</p>
                                                </div>
                                                <div class="mt-3 pt-2.5 border-t border-sky-100/60 flex items-center justify-between">
                                                    <span class="font-mono text-[10px] font-bold text-slate-400">{{ $c['spelling'] }}</span>
                                                    <button @click.stop="speakText(@js($c['number']) + ' is ' + @js($c['word']) + '. It is spelled ' + @js($c['spelling']))" class="text-xs font-bold text-sky-600 hover:text-sky-800 flex items-center gap-1">
                                                        <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 24 24"><path d="M3 9v6h4l5 5V4L7 9H3zm13.5 3c0-1.77-1.02-3.29-2.5-4.03v8.05c1.48-.73 2.5-2.25 2.5-4.02z"/></svg>
                                                        <span>Putar Jawaban</span>
                                                    </button>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>

                                    <!-- Group B Filled Words Grid -->
                                    <div x-show="crosswordTab === 'B'" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                                        @foreach(array_slice($gameData['cards'] ?? [], 11, 11) as $c)
                                            <div class="p-4 rounded-2xl border-2 transition flex flex-col justify-between shadow-2xs cursor-pointer"
                                                 :class="activeWordKey === @js($c['id'] ?? '') ? 'border-amber-400 bg-amber-50/90 ring-2 ring-amber-300 shadow-md' : 'border-orange-100 bg-orange-50/40 hover:border-orange-400 hover:bg-white'"
                                                 @click="selectWord(@js($c['id'] ?? ''))">
                                                <div>
                                                    <div class="flex items-center justify-between mb-2">
                                                        <span class="text-xs font-black font-mono text-orange-900 bg-orange-100 px-2.5 py-0.5 rounded-lg">{{ $c['number'] }}</span>
                                                        <span class="font-mono font-black text-xs text-orange-700 uppercase bg-white px-2 py-0.5 rounded-md border border-orange-200">{{ $c['word'] }}</span>
                                                    </div>
                                                    <p class="text-xs sm:text-sm text-slate-800 font-medium leading-relaxed">Jawaban: "{{ $c['number'] }} is {{ strtolower($c['word']) }}. It is {{ $c['spelling'] }}."</p>
                                                </div>
                                                <div class="mt-3 pt-2.5 border-t border-orange-100/60 flex items-center justify-between">
                                                    <span class="font-mono text-[10px] font-bold text-slate-400">{{ $c['spelling'] }}</span>
                                                    <button @click.stop="speakText(@js($c['number']) + ' is ' + @js($c['word']) + '. It is spelled ' + @js($c['spelling']))" class="text-xs font-bold text-orange-600 hover:text-orange-800 flex items-center gap-1">
                                                        <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 24 24"><path d="M3 9v6h4l5 5V4L7 9H3zm13.5 3c0-1.77-1.02-3.29-2.5-4.03v8.05c1.48-.73 2.5-2.25 2.5-4.02z"/></svg>
                                                        <span>Putar Jawaban</span>
                                                    </button>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>

                            <!-- INTERACTIVE CROSSWORD SOLVER & LOGGING PAD -->
                            <div class="bg-gradient-to-br from-slate-900 via-slate-800 to-indigo-950 rounded-3xl p-6 sm:p-8 text-white shadow-xl relative overflow-hidden">
                                <div class="flex items-center justify-between pb-4 mb-4 border-b border-white/15 flex-wrap gap-3">
                                    <div>
                                        <span class="text-[10px] font-black uppercase tracking-wider px-2.5 py-0.5 rounded-full bg-amber-400 text-slate-900 inline-block mb-1">Live Crossword Solver</span>
                                        <h3 class="text-xl font-black text-white">Catat Kata yang Berhasil Kamu Tebak dari Pasanganmu</h3>
                                    </div>
                                    <span class="px-4 py-1.5 rounded-full bg-white/10 border border-white/20 text-xs font-bold text-sky-200" x-text="'Tebakan Terjawab: ' + solvedWords.length + ' / 11 Kata'"></span>
                                </div>

                                <form @submit.prevent="if(guessInput.trim()) { solvedWords.push({ id: Date.now(), number: numberInput || 'Across / Down', word: guessInput.trim().toUpperCase() }); guessInput = ''; }" class="flex flex-col sm:flex-row items-center gap-3 mb-4">
                                    <input type="text" x-model="numberInput" placeholder="No (misal: 3 Across)" class="w-full sm:w-1/4 px-4 py-2.5 rounded-xl bg-white/10 border border-white/20 text-white placeholder-white/50 text-xs sm:text-sm font-bold focus:outline-none focus:ring-2 focus:ring-amber-400">
                                    <input type="text" x-model="guessInput" placeholder="Jawaban Tebakanmu (misal: FARMER)" class="w-full sm:flex-1 px-4 py-2.5 rounded-xl bg-white/10 border border-white/20 text-white placeholder-white/50 text-xs sm:text-sm font-bold focus:outline-none focus:ring-2 focus:ring-amber-400 uppercase font-mono">
                                    <button type="submit" style="background-color: #ff9800 !important;" class="w-full sm:w-auto px-6 py-2.5 rounded-xl hover:bg-amber-500 text-white font-black text-xs sm:text-sm shadow-md transition shrink-0">
                                        + Simpan Jawaban
                                    </button>
                                </form>

                                <div x-show="solvedWords.length > 0" class="flex items-center gap-2 flex-wrap pt-3 border-t border-white/10">
                                    <template x-for="sw in solvedWords" :key="sw.id">
                                        <div class="px-3 py-1 rounded-xl bg-white/15 border border-white/20 text-xs font-bold flex items-center gap-2 text-white">
                                            <span class="text-amber-300" x-text="sw.number + ':'"></span>
                                            <span class="font-mono font-black" x-text="sw.word"></span>
                                            <button @click="spellWordAloud(sw.word)" class="text-sky-300 hover:text-white" title="Spell Aloud">
                                                <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 24 24"><path d="M3 9v6h4l5 5V4L7 9H3zm13.5 3c0-1.77-1.02-3.29-2.5-4.03v8.05c1.48-.73 2.5-2.25 2.5-4.02z"/></svg>
                                            </button>
                                            <button @click="solvedWords = solvedWords.filter(w => w.id !== sw.id)" class="text-white/40 hover:text-red-400 ml-1 font-bold">&times;</button>
                                        </div>
                                    </template>
                                </div>
                            </div>
                        </div>
                    @elseif(isset($gameData['type']) && $gameData['type'] === 'how_many_kitchen')
                        <!-- ==================================================== -->
                        <!-- MEETING 3: HOW MANY? (KITCHEN OBJECTS & SPIDER GAME) -->
                        <!-- ==================================================== -->
                        <div class="space-y-6 w-full" x-data="{
                            activeStudent: 'A',
                            selectedGroupPreview: null,
                            showAnswers: false,
                            isZoomModalOpen: false,
                            countsA: {},
                            countsB: {},
                            itemsList: @js($gameData['items'] ?? []),
                            questionsList: @js($gameData['questions'] ?? []),
                            init() {
                                window.addEventListener('set-kitchen-student', (e) => {
                                    if (e.detail) this.activeStudent = e.detail;
                                });
                                window.addEventListener('toggle-kitchen-answers', (e) => {
                                    this.showAnswers = e.detail;
                                });
                                if (this.$watch) {
                                    this.$watch('activeStudent', val => {
                                        window.dispatchEvent(new CustomEvent('kitchen-student-updated', { detail: val }));
                                    });
                                    this.$watch('showAnswers', val => {
                                        window.dispatchEvent(new CustomEvent('kitchen-answers-updated', { detail: val }));
                                    });
                                }
                            },
                            getTotalA() {
                                let total = 0;
                                this.itemsList.forEach(it => {
                                    if (it.key !== 'spiders') {
                                        total += parseInt(this.countsA[it.key] || 0);
                                    }
                                });
                                return total;
                            },
                            getTotalB() {
                                let total = 0;
                                this.itemsList.forEach(it => {
                                    if (it.key !== 'spiders') {
                                        total += parseInt(this.countsB[it.key] || 0);
                                    }
                                });
                                return total;
                            },
                            fillAutoAnswers() {
                                this.itemsList.forEach(it => {
                                    this.countsA[it.key] = it.count_a;
                                    this.countsB[it.key] = it.count_b;
                                });
                            },
                            resetCounts() {
                                this.countsA = {};
                                this.countsB = {};
                            }
                        }">

                            <!-- Hero Game Showcase Box -->
                            <div style="background-color: #29a8f5 !important;" class="rounded-[2.5rem] p-6 sm:p-10 text-white shadow-xl relative overflow-hidden w-full">
                                <div class="relative z-10 flex flex-col lg:flex-row lg:items-center justify-between gap-6">
                                    <div class="max-w-2xl">
                                        <div class="flex items-center gap-2 mb-2.5 flex-wrap">
                                            <span class="px-3 py-1 rounded-full bg-white/20 text-xs font-black uppercase tracking-wider text-white">{{ $participationBadge['icon'] }} {{ $participationBadge['label'] }} • Information Gap</span>
                                            <span class="px-3.5 py-1 rounded-full text-xs font-black text-slate-950 shadow-xs" style="background-color: #fbbf24 !important;">Counting Game (1 - 20+)</span>
                                            <span class="px-3.5 py-1 rounded-full text-xs font-black text-white shadow-xs" style="background-color: #10b981 !important;">Find Who Has The Most!</span>
                                        </div>
                                        <h2 class="text-2xl sm:text-3xl font-black text-white tracking-tight">How many? (Kitchen Objects &amp; Spiders)</h2>
                                        <p class="text-xs sm:text-sm text-sky-100 font-medium mt-1 leading-relaxed">
                                            Game berbicara berpasangan (2 orang). <strong>Siswa A memegang Dapur A</strong> dan <strong>Siswa B memegang Dapur B</strong>. Jangan saling memperlihatkan gambar—saling bertanyalah dalam bahasa Inggris untuk mengisi tabel hitungan dan mencari tahu siapa pemilik barang terbanyak!
                                        </p>
                                    </div>

                                    <!-- Student A / Student B Switcher -->
                                    <div class="bg-white/20 p-2 rounded-3xl border border-white/30 shrink-0 flex flex-col gap-2 shadow-xs">
                                        <span class="text-[11px] font-black uppercase tracking-wider text-white px-2 text-center">Pilih Peran Belajar Anda:</span>
                                        <div class="flex items-center gap-2">
                                            <button @click="activeStudent = 'A'" 
                                                    :class="activeStudent === 'A' ? 'bg-white text-blue-900 font-black shadow-lg scale-105 ring-2 ring-sky-200' : 'text-white hover:bg-white/10 font-bold'" 
                                                    class="px-4 py-2.5 rounded-2xl transition flex items-center gap-2 text-xs sm:text-sm">
                                                <span class="w-2.5 h-2.5 rounded-full" :class="activeStudent === 'A' ? 'bg-sky-500' : 'bg-white'"></span>
                                                <span>Saya Siswa A (Dapur A)</span>
                                            </button>
                                            <button @click="activeStudent = 'B'" 
                                                    :class="activeStudent === 'B' ? 'bg-white text-orange-950 font-black shadow-lg scale-105 ring-2 ring-amber-200' : 'text-white hover:bg-white/10 font-bold'" 
                                                    class="px-4 py-2.5 rounded-2xl transition flex items-center gap-2 text-xs sm:text-sm">
                                                <span class="w-2.5 h-2.5 rounded-full" :class="activeStudent === 'B' ? 'bg-orange-500' : 'bg-white'"></span>
                                                <span>Saya Siswa B (Dapur B)</span>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Target Speaking Formula & Step-by-Step Instructions -->
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 w-full">
                                <div class="p-4 sm:p-5 rounded-2xl bg-sky-50 border-2 border-sky-200 text-sky-950 text-xs">
                                    <div class="flex items-center gap-2 mb-1.5">
                                        <span class="w-6 h-6 rounded-lg bg-sky-600 text-white font-black text-xs flex items-center justify-center">1</span>
                                        <span class="font-black text-sky-900 uppercase tracking-wider text-xs">Pola Bertanya (Ask Your Partner):</span>
                                    </div>
                                    <p class="font-mono font-black text-sm text-slate-900 bg-white p-2.5 rounded-xl border border-sky-200">
                                        &ldquo;How many <span class="text-sky-700">[objects]</span> are there in your kitchen?&rdquo;
                                    </p>
                                    <p class="text-[11px] text-slate-600 mt-2 font-medium">Contoh: <em>"How many teapots / cups / plates / spiders are there?"</em></p>
                                </div>
                                <div class="p-4 sm:p-5 rounded-2xl bg-amber-50 border-2 border-amber-200 text-amber-950 text-xs">
                                    <div class="flex items-center gap-2 mb-1.5">
                                        <span class="w-6 h-6 rounded-lg bg-amber-600 text-white font-black text-xs flex items-center justify-center">2</span>
                                        <span class="font-black text-amber-900 uppercase tracking-wider text-xs">Pola Menjawab (Answer Your Partner):</span>
                                    </div>
                                    <p class="font-mono font-black text-sm text-slate-900 bg-white p-2.5 rounded-xl border border-amber-200">
                                        &ldquo;There is one <span class="text-amber-700">[singular]</span>... / There are <span class="text-amber-700">[number] [plural]</span>...&rdquo;
                                    </p>
                                    <p class="text-[11px] text-slate-600 mt-2 font-medium">Contoh: <em>"There is one teapot." / "There are ten cups on the shelf."</em></p>
                                </div>
                            </div>

                            <!-- ==================================================== -->
                            <!-- SECTION 1: PROMINENT LARGE KITCHEN PICTURE DISPLAY   -->
                            <!-- ==================================================== -->
                            <div class="bg-white rounded-[2rem] p-5 sm:p-7 shadow-sm border border-slate-200/90 w-full">
                                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 pb-4 mb-4 border-b border-slate-100">
                                    <div class="flex items-center gap-3">
                                        <span class="px-4 py-2 rounded-2xl text-xs sm:text-sm font-black text-white shadow-sm flex items-center gap-2"
                                              :class="activeStudent === 'A' ? 'bg-sky-600' : 'bg-orange-600'">
                                            <span class="w-2.5 h-2.5 rounded-full bg-white animate-pulse"></span>
                                            <span x-text="activeStudent === 'A' ? '🖼️ Gambar Dapur Anda: DAPUR A (Siswa A)' : '🖼️ Gambar Dapur Anda: DAPUR B (Siswa B)'"></span>
                                        </span>
                                        <span class="text-xs text-slate-500 font-bold hidden sm:inline">• Hitung teko, panci, garpu, pisau, sendok, cangkir, tatakan, gelas, piring, mangkuk, &amp; laba-laba!</span>
                                    </div>
                                    <div class="flex items-center gap-2">
                                        <button @click="speakText(activeStudent === 'A' ? 'This is Kitchen Picture A for Student A. Count your teapots, pans, cups, plates, glasses, and spiders.' : 'This is Kitchen Picture B for Student B. Count your teapots, pans, cups, plates, glasses, and spiders.')" class="px-3 py-1.5 rounded-xl bg-sky-50 hover:bg-sky-100 text-sky-700 font-bold text-xs border border-sky-200 transition flex items-center gap-1">
                                            <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 24 24"><path d="M3 9v6h4l5 5V4L7 9H3zm13.5 3c0-1.77-1.02-3.29-2.5-4.03v8.05c1.48-.73 2.5-2.25 2.5-4.02z"/></svg>
                                            <span>Instruksi Audio</span>
                                        </button>
                                        <button @click="isZoomModalOpen = true" type="button" class="px-3.5 py-1.5 rounded-xl bg-slate-900 hover:bg-slate-800 text-white font-black text-xs transition flex items-center gap-1.5 shadow-2xs">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v3m0 0v3m0-3h3m-3 0H7"></path></svg>
                                            <span>Zoom Layar Penuh</span>
                                        </button>
                                    </div>
                                </div>

                                <!-- Massive Kitchen Illustration Container -->
                                <div @click="isZoomModalOpen = true" class="bg-slate-50 p-3 sm:p-5 rounded-3xl border-2 border-slate-200/90 overflow-hidden flex items-center justify-center w-full cursor-zoom-in group relative shadow-inner">
                                    <div class="absolute inset-0 bg-slate-900/0 group-hover:bg-slate-900/10 transition flex items-center justify-center pointer-events-none z-10">
                                        <span class="opacity-0 group-hover:opacity-100 transition bg-black/80 text-white text-xs font-black px-4 py-2 rounded-xl shadow-xl flex items-center gap-2">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v3m0 0v3m0-3h3m-3 0H7"></path></svg>
                                            <span>Klik untuk Zoom Layar Penuh HD</span>
                                        </span>
                                    </div>
                                    <img x-show="activeStudent === 'A'" 
                                         src="{{ asset('images/speaking/worksheet3/picture_a_kitchen.png') }}" 
                                         alt="Kitchen Picture A (Student A)" 
                                         class="w-full max-w-4xl h-auto object-contain rounded-2xl shadow-sm transition duration-300 group-hover:scale-[1.01] block">
                                    <img x-show="activeStudent === 'B'" 
                                         src="{{ asset('images/speaking/worksheet3/picture_b_kitchen.png') }}" 
                                         alt="Kitchen Picture B (Student B)" 
                                         class="w-full max-w-4xl h-auto object-contain rounded-2xl shadow-sm transition duration-300 group-hover:scale-[1.01] block">
                                </div>

                                <div class="mt-4 p-4 rounded-2xl border text-xs font-semibold flex items-center justify-between gap-3"
                                     :class="activeStudent === 'A' ? 'bg-sky-50/70 border-sky-200 text-sky-950' : 'bg-orange-50/70 border-orange-200 text-orange-950'">
                                    <div class="flex items-center gap-2.5">
                                        <span class="text-xl">🔒</span>
                                        <div>
                                            <span class="font-black text-sm block" x-text="activeStudent === 'A' ? 'Gambar Dapur A adalah RAHASIA Anda!' : 'Gambar Dapur B adalah RAHASIA Anda!'"></span>
                                            <p class="text-xs text-slate-600 mt-0.5" x-text="activeStudent === 'A' ? 'Hitung barang dapur A di atas, lalu tanyakan jumlah barang di dapur B kepada Siswa B dalam bahasa Inggris.' : 'Hitung barang dapur B di atas, lalu tanyakan jumlah barang di dapur A kepada Siswa A dalam bahasa Inggris.'"></p>
                                        </div>
                                    </div>
                                    <button @click="isZoomModalOpen = true" type="button" class="text-xs font-black underline shrink-0"
                                            :class="activeStudent === 'A' ? 'text-sky-700 hover:text-sky-900' : 'text-orange-700 hover:text-orange-900'">
                                        Buka Modal Zoom ↗
                                    </button>
                                </div>
                            </div>

                            <!-- ==================================================== -->
                            <!-- SECTION 2: INFORMATION GAP INVENTORY COUNT SHEET     -->
                            <!-- ==================================================== -->
                            <div class="bg-white rounded-[2rem] p-5 sm:p-7 shadow-sm border border-slate-200/90 w-full">
                                <div class="flex flex-col sm:flex-row sm:items-center justify-between pb-4 mb-4 border-b border-slate-100 gap-3">
                                    <div>
                                        <div class="flex items-center gap-2 mb-1">
                                            <span class="px-3 py-0.5 rounded-full text-xs font-black text-white"
                                                  :class="activeStudent === 'A' ? 'bg-sky-600' : 'bg-orange-600'"
                                                  x-text="activeStudent === 'A' ? 'Lembar Catatan: SISWA A' : 'Lembar Catatan: SISWA B'"></span>
                                            <h3 class="text-lg sm:text-xl font-black text-slate-900">
                                                Lembar Catatan Hitungan (Count Sheet)
                                            </h3>
                                        </div>
                                        <p class="text-xs text-slate-500 font-medium" x-text="activeStudent === 'A' ? 'Hitung Dapur A milikmu sendiri, lalu tanyakan Dapur B kepada Siswa B dengan klik tombol tanya 🗣️!' : 'Hitung Dapur B milikmu sendiri, lalu tanyakan Dapur A kepada Siswa A dengan klik tombol tanya 🗣️!'"></p>
                                    </div>
                                    <div class="flex items-center gap-2">
                                        <button @click="showAnswers = !showAnswers" type="button" class="px-3.5 py-2 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-xs border border-slate-200 transition shadow-2xs">
                                            <span x-text="showAnswers ? 'Sembunyikan Kunci' : 'Kunci Jawaban 👁️'"></span>
                                        </button>
                                        <button @click="fillAutoAnswers()" type="button" class="px-3.5 py-2 rounded-xl bg-sky-50 hover:bg-sky-100 text-sky-700 font-bold text-xs border border-sky-200 transition shadow-2xs">
                                            Isi Kunci Otomatis
                                        </button>
                                    </div>
                                </div>

                                <!-- Responsive Count Table with Dynamic Roles -->
                                <div class="overflow-x-auto rounded-2xl border border-slate-200 shadow-2xs w-full">
                                    <table class="w-full text-left border-collapse text-xs sm:text-sm">
                                        <thead>
                                            <tr class="bg-slate-900 text-white font-black text-[11px] sm:text-xs uppercase tracking-wider">
                                                <th class="p-3 sm:p-4">KITCHEN OBJECT</th>
                                                <th class="p-3 sm:p-4 text-center bg-sky-900 text-sky-100 whitespace-nowrap">
                                                    <div class="flex flex-col items-center">
                                                        <span>DAPUR A (KITCHEN A)</span>
                                                        <span class="text-[10px] font-bold mt-0.5 px-2 py-0.5 rounded-full"
                                                              :class="activeStudent === 'A' ? 'bg-sky-500 text-white' : 'bg-sky-950 text-sky-200'"
                                                              x-text="activeStudent === 'A' ? '👁️ Dapur Saya (Siswa A)' : '🗣️ Dapur Partner (Tanyakan)'"></span>
                                                    </div>
                                                </th>
                                                <th class="p-3 sm:p-4 text-center bg-orange-900 text-orange-100 whitespace-nowrap">
                                                    <div class="flex flex-col items-center">
                                                        <span>DAPUR B (KITCHEN B)</span>
                                                        <span class="text-[10px] font-bold mt-0.5 px-2 py-0.5 rounded-full"
                                                              :class="activeStudent === 'B' ? 'bg-amber-500 text-white' : 'bg-orange-950 text-orange-200'"
                                                              x-text="activeStudent === 'B' ? '👁️ Dapur Saya (Siswa B)' : '🗣️ Dapur Partner (Tanyakan)'"></span>
                                                    </div>
                                                </th>
                                                <th class="p-3 sm:p-4 text-right whitespace-nowrap">LEBIH BANYAK DI...</th>
                                            </tr>
                                        </thead>
                                        <tbody class="divide-y divide-slate-100 font-semibold text-slate-800">
                                            <template x-for="item in itemsList" :key="item.key">
                                                <tr class="hover:bg-slate-50 transition" :class="item.key === 'spiders' ? 'bg-amber-50/70 font-black' : ''">
                                                    <td class="p-3 sm:p-4">
                                                        <div class="flex items-center justify-between gap-2">
                                                            <div class="flex items-center gap-2.5">
                                                                <span class="text-lg" x-text="item.icon"></span>
                                                                <div>
                                                                    <span class="font-black text-slate-900 text-xs sm:text-sm block" x-text="item.name"></span>
                                                                    <span x-show="showAnswers" class="text-[10px] sm:text-xs text-slate-500 font-normal italic block" x-text="item.note"></span>
                                                                </div>
                                                            </div>
                                                            <!-- Quick Practice Audio Question Button -->
                                                            <button @click="speakText('How many ' + item.key + ' are there in your kitchen?')" type="button" class="p-1.5 rounded-lg bg-slate-100 hover:bg-sky-100 text-slate-600 hover:text-sky-700 transition" title="Latih tanya ini ke teman">
                                                                <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 24 24"><path d="M3 9v6h4l5 5V4L7 9H3zm13.5 3c0-1.77-1.02-3.29-2.5-4.03v8.05c1.48-.73 2.5-2.25 2.5-4.02z"/></svg>
                                                            </button>
                                                        </div>
                                                    </td>
                                                    <td class="p-3 sm:p-4 text-center">
                                                        <input type="number" min="0" max="99" 
                                                               x-model="countsA[item.key]" 
                                                               :placeholder="showAnswers ? item.count_a : '0'"
                                                               class="w-16 text-center py-1.5 rounded-xl border-2 font-mono font-black text-sm text-sky-950 bg-sky-50/60 border-sky-200 focus:outline-none focus:ring-2 focus:ring-sky-400">
                                                    </td>
                                                    <td class="p-3 sm:p-4 text-center">
                                                        <input type="number" min="0" max="99" 
                                                               x-model="countsB[item.key]" 
                                                               :placeholder="showAnswers ? item.count_b : '0'"
                                                               class="w-16 text-center py-1.5 rounded-xl border-2 font-mono font-black text-sm text-orange-950 bg-orange-50/60 border-orange-200 focus:outline-none focus:ring-2 focus:ring-orange-400">
                                                    </td>
                                                    <td class="p-3 sm:p-4 text-right font-black text-xs whitespace-nowrap">
                                                        <template x-if="(countsA[item.key] || 0) > (countsB[item.key] || 0)">
                                                            <span class="px-2.5 py-1 rounded-lg bg-sky-100 text-sky-800">Dapur A &gt;</span>
                                                        </template>
                                                        <template x-if="(countsB[item.key] || 0) > (countsA[item.key] || 0)">
                                                            <span class="px-2.5 py-1 rounded-lg bg-orange-100 text-orange-800">&lt; Dapur B</span>
                                                        </template>
                                                        <template x-if="(countsA[item.key] || 0) == (countsB[item.key] || 0) && (countsA[item.key] !== undefined || countsB[item.key] !== undefined)">
                                                            <span class="px-2.5 py-1 rounded-lg bg-slate-100 text-slate-600">Sama (=)</span>
                                                        </template>
                                                    </td>
                                                </tr>
                                            </template>
                                        </tbody>
                                        <tfoot>
                                            <tr class="bg-slate-100 font-black text-xs sm:text-sm text-slate-900 border-t-2 border-slate-300">
                                                <td class="p-3.5 sm:p-4 uppercase">TOTAL BARANG DAPUR (KITCHEN OBJECTS):</td>
                                                <td class="p-3.5 sm:p-4 text-center font-mono text-base text-sky-700" x-text="getTotalA()"></td>
                                                <td class="p-3.5 sm:p-4 text-center font-mono text-base text-orange-700" x-text="getTotalB()"></td>
                                                <td class="p-3.5 sm:p-4 text-right whitespace-nowrap">
                                                    <template x-if="getTotalA() > getTotalB()">
                                                        <span class="px-3 py-1.5 rounded-xl bg-sky-600 text-white font-black text-xs shadow-xs">Pemenang: Dapur A!</span>
                                                    </template>
                                                    <template x-if="getTotalB() > getTotalA()">
                                                        <span class="px-3 py-1.5 rounded-xl bg-orange-600 text-white font-black text-xs shadow-xs">Pemenang: Dapur B!</span>
                                                    </template>
                                                    <template x-if="getTotalA() == getTotalB() && getTotalA() > 0">
                                                        <span class="px-3 py-1.5 rounded-xl bg-emerald-600 text-white font-black text-xs shadow-xs">Hasil Sama (Tie)!</span>
                                                    </template>
                                                </td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>

                                <!-- Summary Comparison Winner Box -->
                                <div class="mt-4 p-4 rounded-2xl border-2"
                                     :class="getTotalB() > getTotalA() ? 'bg-orange-50 border-orange-200 text-orange-950' : (getTotalA() > getTotalB() ? 'bg-sky-50 border-sky-200 text-sky-950' : 'bg-slate-50 border-slate-200 text-slate-800')">
                                    <div class="flex items-center justify-between flex-wrap gap-2">
                                        <div class="flex items-center gap-3">
                                            <span class="text-2xl">🏆</span>
                                            <div>
                                                <span class="font-black text-xs uppercase tracking-wider block">Hasil Akhir Permainan:</span>
                                                <p class="font-black text-sm" x-text="getTotalB() > getTotalA() ? 'Dapur B memiliki total barang terbanyak (' + getTotalB() + ' items vs ' + getTotalA() + ' items)!' : (getTotalA() > getTotalB() ? 'Dapur A memiliki total barang terbanyak (' + getTotalA() + ' items vs ' + getTotalB() + ' items)!' : 'Masukkan semua hitungan untuk menentukan pemenang!')"></p>
                                            </div>
                                        </div>
                                        <button @click="resetCounts()" class="text-xs font-bold text-slate-500 hover:text-slate-800 underline">
                                            Reset Hitungan
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <!-- Speaking Questions Practice & Audio Helpers -->
                            <div class="bg-white rounded-[2rem] p-6 sm:p-8 shadow-sm border border-slate-200 w-full">
                                <div class="pb-4 mb-6 border-b border-slate-100 flex items-center gap-2">
                                    <span class="w-8 h-8 rounded-xl bg-blue-100 text-blue-700 font-black text-xs flex items-center justify-center">💬</span>
                                    <div>
                                        <h3 class="text-xl font-black text-slate-900">Pola Tanya Jawab Percakapan (Speaking Drill &amp; Audio)</h3>
                                        <p class="text-xs text-slate-500 font-medium">Gunakan kalimat tanya berikut saat berlatih berpasangan di kelas.</p>
                                    </div>
                                </div>

                                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                                    <template x-for="(qItem, qIdx) in questionsList" :key="qIdx">
                                        <div class="p-4 rounded-2xl bg-slate-50 border border-slate-200 flex flex-col justify-between hover:border-sky-300 transition shadow-2xs">
                                            <div>
                                                <span class="text-[10px] font-black uppercase text-slate-400 block mb-1" x-text="'Pola #' + (qIdx + 1)"></span>
                                                <p class="font-black text-slate-900 text-xs sm:text-sm leading-snug" x-text="qItem.q"></p>
                                                <p class="text-xs font-semibold text-sky-700 mt-2" x-text="'Contoh Respon: ' + qItem.a"></p>
                                            </div>
                                            <button @click="speakText(qItem.audio)" class="mt-3 w-full py-1.5 rounded-xl bg-white hover:bg-sky-600 hover:text-white text-slate-700 font-bold text-xs border border-slate-200 transition flex items-center justify-center gap-1.5 shadow-2xs">
                                                <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 24 24"><path d="M3 9v6h4l5 5V4L7 9H3zm13.5 3c0-1.77-1.02-3.29-2.5-4.03v8.05c1.48-.73 2.5-2.25 2.5-4.02z"/></svg>
                                                <span>Dengarkan Audio</span>
                                            </button>
                                        </div>
                                    </template>
                                </div>
                            </div>

                            <!-- Fullscreen High-Definition Zoom Modal (Lightbox) -->
                            <div x-show="isZoomModalOpen" 
                                 x-transition:enter="transition ease-out duration-200"
                                 x-transition:enter-start="opacity-0"
                                 x-transition:enter-end="opacity-100"
                                 x-transition:leave="transition ease-in duration-150"
                                 x-transition:leave-start="opacity-100"
                                 x-transition:leave-end="opacity-0"
                                 @keydown.escape.window="isZoomModalOpen = false"
                                 @click.self="isZoomModalOpen = false"
                                 class="fixed inset-0 z-[99999] bg-slate-950/90 backdrop-blur-md flex flex-col items-center justify-center p-3 sm:p-6"
                                 style="display: none;">
                                <div class="w-full max-w-5xl bg-white rounded-3xl overflow-hidden shadow-2xl flex flex-col max-h-[92vh] border border-white/20">
                                    <!-- Modal Header -->
                                    <div class="px-6 py-4 bg-slate-900 text-white flex items-center justify-between gap-4 border-b border-slate-800">
                                        <div class="flex items-center gap-3">
                                            <span class="px-3 py-1 rounded-xl text-xs font-black uppercase tracking-wider"
                                                  :class="activeStudent === 'A' ? 'bg-sky-600 text-white' : 'bg-orange-600 text-white'"
                                                  x-text="activeStudent === 'A' ? 'Gambar Dapur A (Student A)' : 'Gambar Dapur B (Student B)'"></span>
                                            <span class="text-xs text-slate-300 font-bold hidden sm:inline">Mode Zoom Layar Penuh HD</span>
                                        </div>
                                        <div class="flex items-center gap-2">
                                            <button @click="activeStudent = (activeStudent === 'A' ? 'B' : 'A')" type="button" class="px-3 py-1.5 rounded-xl bg-white/10 hover:bg-white/20 text-white text-xs font-bold transition">
                                                Ganti ke Dapur <span x-text="activeStudent === 'A' ? 'B' : 'A'"></span>
                                            </button>
                                            <button @click="isZoomModalOpen = false" type="button" class="w-8 h-8 rounded-xl bg-white/10 hover:bg-red-500 text-white flex items-center justify-center text-base font-bold transition">
                                                &times;
                                            </button>
                                        </div>
                                    </div>

                                    <!-- Modal Image Body (Scrollable & Super High Res) -->
                                    <div class="p-4 sm:p-6 overflow-auto flex items-center justify-center bg-slate-100 flex-1">
                                        <img x-show="activeStudent === 'A'" 
                                             src="{{ asset('images/speaking/worksheet3/picture_a_kitchen.png') }}" 
                                             alt="Zoomed Kitchen A" 
                                             class="max-w-full h-auto max-h-[78vh] object-contain rounded-2xl shadow-md border-2 border-slate-300">
                                        <img x-show="activeStudent === 'B'" 
                                             src="{{ asset('images/speaking/worksheet3/picture_b_kitchen.png') }}" 
                                             alt="Zoomed Kitchen B" 
                                             class="max-w-full h-auto max-h-[78vh] object-contain rounded-2xl shadow-md border-2 border-slate-300">
                                    </div>

                                    <!-- Modal Footer Controls -->
                                    <div class="px-6 py-3 bg-white border-t border-slate-200 flex items-center justify-between text-xs text-slate-600 font-bold">
                                        <span>Gunakan scroll mouse untuk melihat detail laba-laba, piring, cangkir, dan sendok.</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @elseif(isset($gameData['type']) && $gameData['type'] === 'tourist_in_town')
                        <!-- ==================================================== -->
                        <!-- MEETING 4: TOURIST IN TOWN (WORKSHEET 4 GAME)        -->
                        <!-- ==================================================== -->
                        <div class="space-y-6" x-data="{
                            activeTab: 'map', // 'map', 'desks', 'sheets', 'calculator', 'dialogues', 'guide'
                            selectedGroupPreview: null,
                            mapMode: '3d', // '3d', 'bw'
                            selectedDesk: 'tourist_office', // 'tourist_office', 'bank', 'hotel', 'station'
                            selectedSheet: 'sheet_a', // 'sheet_a', 'sheet_b', 'sheet_c' ...
                            selectedLandmark: 1,
                            hoveredPin: null,
                            activeModal: null, // 'map', 'desks', 'sheet_a', 'sheet_b', 'sheet_c', ...
                            revealedSolutions: {},
                            init() {
                                window.addEventListener('set-tourist-view', (e) => {
                                    if (e.detail) {
                                        if (e.detail.tab) this.activeTab = e.detail.tab;
                                        if (e.detail.sheet) this.selectedSheet = e.detail.sheet;
                                    }
                                });
                                if (this.$watch) {
                                    this.$watch('activeTab', val => {
                                        window.dispatchEvent(new CustomEvent('tourist-view-updated', { detail: { tab: val, sheet: this.selectedSheet } }));
                                    });
                                    this.$watch('selectedSheet', val => {
                                        window.dispatchEvent(new CustomEvent('tourist-view-updated', { detail: { tab: this.activeTab, sheet: val } }));
                                    });
                                }
                            },
                            userAnswers: (function() {
                                try {
                                    return JSON.parse(localStorage.getItem('tb_wandering_answers') || '{}');
                                } catch(e) {
                                    return {};
                                }
                            })(),
                            saveUserAnswer(id, val) {
                                this.userAnswers[id] = val;
                                try {
                                    localStorage.setItem('tb_wandering_answers', JSON.stringify(this.userAnswers));
                                } catch(e) {}
                            },
                            converter: {
                                currency: 'francs',
                                rates: {
                                    francs: 10.00,
                                    marks: 4.50,
                                    lire: 2300,
                                    pesetas: 200,
                                    dollars: 1.50,
                                    yen: 400
                                },
                                foreignAmount: 250,
                                get gbp() {
                                    const r = this.rates[this.currency] || 1;
                                    return (this.foreignAmount / r).toFixed(2);
                                }
                            },
                            hotelCalc: {
                                roomRate: 14,
                                roomName: 'Single room (with shower)',
                                nights: 2,
                                get total() {
                                    return (this.roomRate * this.nights);
                                }
                            },
                            trainCalc: {
                                dest: 'Liverpool',
                                ticketType: 'return',
                                fares: {
                                    'London': { single: 12, return: 20, times: ['9.00', '14.30', '17.15', '18.40'] },
                                    'Liverpool': { single: 20, return: 35, times: ['6.00', '15.35', '19.50', '21.17'] },
                                    'York': { single: 17, return: 30, times: ['10.00', '13.25', '15.30', '20.45'] },
                                    'Manchester': { single: 15, return: 25, times: ['10.05', '12.45', '15.27', '18.55'] },
                                    'Bristol': { single: 7, return: 12, times: ['11.00', '16.40', '22.10', '23.57'] }
                                },
                                get currentFare() {
                                    const d = this.fares[this.dest] || { single: 0, return: 0 };
                                    return this.ticketType === 'return' ? d.return : d.single;
                                }
                            },
                            toggleSolution(id) {
                                this.revealedSolutions[id] = !this.revealedSolutions[id];
                            }
                        }">

                            <!-- Top Hero Box for Worksheet 4 Game -->
                            <div style="background-color: #29a8f5 !important;" class="rounded-[2.5rem] p-6 sm:p-10 text-white shadow-xl relative overflow-hidden">
                                <div class="relative z-10 flex flex-col lg:flex-row lg:items-center justify-between gap-6">
                                    <div class="max-w-3xl">
                                        <div class="flex items-center gap-2 mb-2.5 flex-wrap">
                                            <span class="px-3.5 py-1 rounded-full bg-white/20 text-xs font-black uppercase tracking-wider text-white">Worksheet 4 Game</span>
                                            <span style="background-color: #ff9800 !important;" class="px-3 py-1 rounded-full text-white text-xs font-black shadow-xs">Waktu: {{ $gameData['time'] ?? '20-25 Menit' }}</span>
                                            <span class="px-3 py-1 rounded-full bg-emerald-400 text-slate-950 text-xs font-black">{{ $participationBadge['icon'] }} {{ $participationBadge['label'] }}</span>
                                            <span class="px-3 py-1 rounded-full bg-white/20 text-xs font-bold text-white">4 Info Desks &bull; 7 Tourist Sheets (A–G)</span>
                                        </div>
                                        <h2 class="text-2xl sm:text-4xl font-black tracking-tight text-white">
                                            {{ $gameData['title'] ?? 'Tourist in Town (Asking for Information)' }}
                                        </h2>
                                        <p class="text-xs sm:text-sm text-sky-100 font-medium mt-2 leading-relaxed">
                                            <strong class="text-amber-200">AIM:</strong> {{ $gameData['aim'] ?? 'To practice asking for and giving directions, opening times, hotel room rates, currency exchange, and train times/fares in English.' }}
                                        </p>
                                        
                                        <!-- Prominent Button: Panduan & Cara Main Game -->
                                        <div class="mt-4 flex flex-wrap items-center gap-2">
                                            <button type="button" @click="activeTab = 'guide'" class="px-4 py-2 rounded-2xl bg-amber-400 hover:bg-amber-300 text-slate-950 font-black text-xs sm:text-sm flex items-center gap-2 shadow-md hover:shadow-lg transition-all border border-amber-300 transform hover:-translate-y-0.5">
                                                <span>📖</span> <span>Cara Main &amp; Aturan Game (Bahasa Indonesia)</span>
                                            </button>
                                        </div>
                                    </div>

                                    <!-- Quick Modal View Buttons -->
                                    <div class="flex flex-wrap lg:flex-col gap-2 shrink-0">
                                        <div class="text-[11px] font-bold text-sky-100 uppercase tracking-wider mb-1">Authentic Worksheets:</div>
                                        <div class="flex flex-wrap gap-1.5 max-w-xs">
                                            <button type="button" @click="activeModal = 'map'" class="px-2.5 py-1.5 rounded-xl bg-white/15 hover:bg-white/25 border border-white/25 text-xs font-bold text-white transition-all flex items-center gap-1 shadow-xs">
                                                <span>🗺️</span> <span>Map</span>
                                            </button>
                                            <button type="button" @click="activeModal = 'desks'" class="px-2.5 py-1.5 rounded-xl bg-white/15 hover:bg-white/25 border border-white/25 text-xs font-bold text-white transition-all flex items-center gap-1 shadow-xs">
                                                <span>🏢</span> <span>4 Desks</span>
                                            </button>
                                            <button type="button" @click="activeModal = 'sheet_a'" class="px-2.5 py-1.5 rounded-xl bg-white/15 hover:bg-white/25 border border-white/25 text-xs font-bold text-white transition-all flex items-center gap-1 shadow-xs">
                                                <span>🎒</span> <span>Sheet A</span>
                                            </button>
                                            <button type="button" @click="activeModal = 'sheet_b'" class="px-2.5 py-1.5 rounded-xl bg-white/15 hover:bg-white/25 border border-white/25 text-xs font-bold text-white transition-all flex items-center gap-1 shadow-xs">
                                                <span>🎒</span> <span>Sheet B</span>
                                            </button>
                                            <button type="button" @click="activeModal = 'sheet_c'" class="px-2.5 py-1.5 rounded-xl bg-white/15 hover:bg-white/25 border border-white/25 text-xs font-bold text-white transition-all flex items-center gap-1 shadow-xs">
                                                <span>🎒</span> <span>Sheet C</span>
                                            </button>
                                            <button type="button" @click="activeModal = 'sheet_d'" class="px-2.5 py-1.5 rounded-xl bg-white/15 hover:bg-white/25 border border-white/25 text-xs font-bold text-white transition-all flex items-center gap-1 shadow-xs">
                                                <span>🎒</span> <span>Sheet D</span>
                                            </button>
                                            <button type="button" @click="activeModal = 'sheet_e'" class="px-2.5 py-1.5 rounded-xl bg-white/15 hover:bg-white/25 border border-white/25 text-xs font-bold text-white transition-all flex items-center gap-1 shadow-xs">
                                                <span>🎒</span> <span>Sheet E</span>
                                            </button>
                                            <button type="button" @click="activeModal = 'sheet_f'" class="px-2.5 py-1.5 rounded-xl bg-white/15 hover:bg-white/25 border border-white/25 text-xs font-bold text-white transition-all flex items-center gap-1 shadow-xs">
                                                <span>🎒</span> <span>Sheet F</span>
                                            </button>
                                            <button type="button" @click="activeModal = 'sheet_g'" class="px-2.5 py-1.5 rounded-xl bg-white/15 hover:bg-white/25 border border-white/25 text-xs font-bold text-white transition-all flex items-center gap-1 shadow-xs">
                                                <span>🎒</span> <span>Sheet G</span>
                                            </button>
                                            <button type="button" @click="activeModal = 'teacher_rules_1'" class="px-2.5 py-1.5 rounded-xl bg-amber-400 hover:bg-amber-300 border border-amber-300 text-xs font-black text-slate-950 transition-all flex items-center gap-1 shadow-xs">
                                                <span>📖</span> <span>Rules 1</span>
                                            </button>
                                            <button type="button" @click="activeModal = 'teacher_rules_2'" class="px-2.5 py-1.5 rounded-xl bg-amber-400 hover:bg-amber-300 border border-amber-300 text-xs font-black text-slate-950 transition-all flex items-center gap-1 shadow-xs">
                                                <span>📖</span> <span>Rules 2</span>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Main Interactive Navigation Tabs -->
                            <div class="flex items-center gap-2 p-1.5 bg-slate-100 rounded-2xl border border-slate-200 overflow-x-auto">
                                <button type="button" @click="activeTab = 'map'"
                                    :class="activeTab === 'map' ? 'bg-white text-sky-600 shadow-sm font-black' : 'text-slate-600 font-semibold hover:text-slate-900'"
                                    class="px-4 py-2.5 rounded-xl text-xs sm:text-sm whitespace-nowrap transition-all flex items-center gap-2">
                                    <span>🗺️</span> <span>Town Map &amp; 8 Landmarks</span>
                                </button>
                                <button type="button" @click="activeTab = 'guide'"
                                    :class="activeTab === 'guide' ? 'bg-amber-400 text-slate-950 shadow-sm font-black' : 'bg-white/70 text-amber-900 font-black hover:bg-white'"
                                    class="px-4 py-2.5 rounded-xl text-xs sm:text-sm whitespace-nowrap transition-all flex items-center gap-2 border border-amber-300">
                                    <span>📖</span> <span>Cara Bermain &amp; Aturan Game</span>
                                </button>
                                <button type="button" @click="activeTab = 'desks'"
                                    :class="activeTab === 'desks' ? 'bg-white text-sky-600 shadow-sm font-black' : 'text-slate-600 font-semibold hover:text-slate-900'"
                                    class="px-4 py-2.5 rounded-xl text-xs sm:text-sm whitespace-nowrap transition-all flex items-center gap-2">
                                    <span>🏢</span> <span>4 Information Desks</span>
                                </button>
                                <button type="button" @click="activeTab = 'sheets'"
                                    :class="activeTab === 'sheets' ? 'bg-white text-sky-600 shadow-sm font-black' : 'text-slate-600 font-semibold hover:text-slate-900'"
                                    class="px-4 py-2.5 rounded-xl text-xs sm:text-sm whitespace-nowrap transition-all flex items-center gap-2">
                                    <span>🎒</span> <span>Tourist Roleplays (Sheets A–G)</span>
                                </button>
                                <button type="button" @click="activeTab = 'calculator'"
                                    :class="activeTab === 'calculator' ? 'bg-white text-sky-600 shadow-sm font-black' : 'text-slate-600 font-semibold hover:text-slate-900'"
                                    class="px-4 py-2.5 rounded-xl text-xs sm:text-sm whitespace-nowrap transition-all flex items-center gap-2">
                                    <span>🧮</span> <span>Travel Tools &amp; Calculators</span>
                                </button>
                                <button type="button" @click="activeTab = 'dialogues'"
                                    :class="activeTab === 'dialogues' ? 'bg-white text-sky-600 shadow-sm font-black' : 'text-slate-600 font-semibold hover:text-slate-900'"
                                    class="px-4 py-2.5 rounded-xl text-xs sm:text-sm whitespace-nowrap transition-all flex items-center gap-2">
                                    <span>💬</span> <span>Speaking Phrases</span>
                                </button>
                            </div>

                            <!-- TAB 1: TOWN MAP & 8 LANDMARKS -->
                            <div x-show="activeTab === 'map'" class="space-y-6">
                                <!-- Quick Game Instructions Banner on Tab 1 -->
                                <div class="p-4 rounded-2xl bg-gradient-to-r from-sky-50 via-indigo-50 to-amber-50 border border-sky-200/80 flex flex-col sm:flex-row sm:items-center justify-between gap-3 shadow-xs">
                                    <div class="flex items-center gap-3">
                                        <span class="text-3xl shrink-0">🎮</span>
                                        <div>
                                            <div class="font-black text-slate-900 text-xs sm:text-sm flex items-center gap-2 flex-wrap">
                                                <span>Cara Main Cepat (Wandering Tourists):</span>
                                                <span class="px-2 py-0.5 rounded-full bg-amber-400 text-slate-950 text-[10px] font-black uppercase">Simulasi Kelas</span>
                                            </div>
                                            <p class="text-[11px] sm:text-xs text-slate-600 mt-0.5 leading-relaxed">
                                                Siswa dibagi menjadi <strong>4 Meja Informasi</strong> &amp; <strong>Turis Berkeliling (Sheets A–G)</strong>. Turis wajib bertanya arah ke teman di jalan, menandai peta, lalu mendatangi meja info untuk menyelesaikan 7 misi berurutan.
                                            </p>
                                        </div>
                                    </div>
                                    <button type="button" @click="activeTab = 'guide'" class="px-3.5 py-2 rounded-xl bg-sky-600 hover:bg-sky-700 text-white text-xs font-black transition-all flex items-center gap-1.5 shrink-0 shadow-sm self-start sm:self-auto">
                                        <span>📖</span> <span>Baca Panduan Lengkap</span>
                                    </button>
                                </div>
                                <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-start">
                                    <!-- Left Column: Map Viewer Card -->
                                    <div class="lg:col-span-7 bg-white rounded-3xl p-5 sm:p-6 border border-slate-200/80 shadow-md space-y-4">
                                        <div class="flex flex-col sm:flex-row sm:items-center justify-between pb-3 border-b border-slate-100 gap-3">
                                            <div>
                                                <h3 class="font-black text-slate-900 text-base sm:text-lg flex items-center gap-2">
                                                    <span>🗺️</span> <span>Interactive Town Map</span>
                                                </h3>
                                                <p class="text-xs text-slate-500">Klik pin atau landmark untuk mendengar nama dan audio petunjuk</p>
                                            </div>
                                            
                                            <!-- View Mode Toggle: 3D Vibrant vs Authentic B&W -->
                                            <div class="flex items-center gap-2 bg-slate-100 p-1 rounded-2xl self-start sm:self-auto border border-slate-200">
                                                <button type="button" @click="mapMode = '3d'" 
                                                    :class="mapMode === '3d' ? 'bg-white text-sky-700 shadow-xs font-black' : 'text-slate-600 hover:text-slate-900 font-bold'"
                                                    class="px-3 py-1.5 rounded-xl text-xs transition-all flex items-center gap-1.5">
                                                    <span>✨ 3D Vibrant</span>
                                                </button>
                                                <button type="button" @click="mapMode = 'bw'" 
                                                    :class="mapMode === 'bw' ? 'bg-white text-slate-900 shadow-xs font-black' : 'text-slate-600 hover:text-slate-900 font-bold'"
                                                    class="px-3 py-1.5 rounded-xl text-xs transition-all flex items-center gap-1.5">
                                                    <span>📄 Authentic B&amp;W</span>
                                                </button>
                                                <button type="button" @click="activeModal = 'map'" class="p-1.5 rounded-xl bg-sky-50 text-sky-700 hover:bg-sky-100 transition-all text-xs font-bold" title="Zoom Map">
                                                    🔍
                                                </button>
                                            </div>
                                        </div>

                                        <!-- Map Image Container with Interactive 3D Landmark Pins -->
                                        <div class="relative rounded-2xl overflow-hidden border-2 border-slate-200 bg-slate-950 shadow-inner select-none group">
                                            <!-- 3D Vibrant Map Image -->
                                            <img x-show="mapMode === '3d'" src="{{ asset('images/speaking/worksheet4/town_map_3d_vibrant.png') }}" alt="3D Town Map" class="w-full h-auto block object-cover transition-transform duration-500 group-hover:scale-[1.02] cursor-pointer" @click="activeModal = 'map'">
                                            
                                            <!-- B&W Authentic Map Image -->
                                            <img x-show="mapMode === 'bw'" src="{{ asset('images/speaking/worksheet4/town_map_bw.png') }}" alt="Authentic B&W Town Map" class="w-full h-auto block object-cover transition-transform duration-500 group-hover:scale-[1.02] cursor-pointer" @click="activeModal = 'map'">

                                            <!-- "YOU ARE HERE" Pointer Box (Authentic Box with Arrow) -->
                                            <div class="absolute z-30 pointer-events-none drop-shadow-2xl select-none transition-all duration-500"
                                                :style="{
                                                    'sheet_a': 'top: 24%; left: 2%;',
                                                    'sheet_b': 'top: 4%; left: 42%;',
                                                    'sheet_c': 'top: 24%; left: 74%;',
                                                    'sheet_d': 'top: 4%; left: 74%;',
                                                    'sheet_e': 'top: 4%; left: 4%;',
                                                    'sheet_f': 'top: 55%; left: 2%;',
                                                    'sheet_g': 'top: 36%; left: 24%;'
                                                }[selectedSheet] || 'top: 24%; left: 2%;'">
                                                <div class="bg-white border-2 sm:border-[3px] border-slate-900 rounded-xl px-2 sm:px-3 py-1 sm:py-1.5 shadow-2xl -rotate-12 flex flex-col items-center ring-2 ring-rose-500/40">
                                                    <span class="font-black text-slate-900 text-[9px] sm:text-[11px] tracking-wider uppercase leading-tight font-sans">YOU ARE</span>
                                                    <span class="font-black text-rose-600 text-[11px] sm:text-xs tracking-wider uppercase leading-none mt-0.5">HERE</span>
                                                    <!-- Arrow pointing to the street -->
                                                    <svg class="w-4 h-4 sm:w-5 sm:h-5 text-slate-900 mt-0.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3.5" stroke-linecap="round" stroke-linejoin="round">
                                                        <line x1="7" y1="7" x2="17" y2="17"></line>
                                                        <polyline points="17 7 17 17 7 17"></polyline>
                                                    </svg>
                                                </div>
                                            </div>

                                            <!-- Interactive 3D Pins Overlay (Visible on 3D Map) -->
                                            <template x-if="mapMode === '3d'">
                                                <div class="absolute inset-0 pointer-events-none">
                                                    <!-- Pin 1: Museum -->
                                                    <button type="button" @click.stop="selectedLandmark = 1; speakText('Number 1: Museum on Museum Street and Queen Street')"
                                                        @mouseenter="hoveredPin = 1" @mouseleave="hoveredPin = null"
                                                        style="top: 48%; left: 14%;"
                                                        class="absolute -translate-x-1/2 -translate-y-1/2 pointer-events-auto group/pin transition-transform hover:scale-125 focus:outline-none z-20">
                                                        <span class="relative flex h-7 w-7 items-center justify-center">
                                                            <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-rose-400 opacity-75" :class="selectedLandmark === 1 ? 'block' : 'hidden'"></span>
                                                            <span class="relative inline-flex items-center justify-center rounded-full h-7 w-7 bg-rose-600 text-white font-black text-xs shadow-lg border-2 border-white">1</span>
                                                        </span>
                                                    </button>

                                                    <!-- Pin 2: Shopping Centre -->
                                                    <button type="button" @click.stop="selectedLandmark = 2; speakText('Number 2: Shopping Centre on North Street and Market Street')"
                                                        @mouseenter="hoveredPin = 2" @mouseleave="hoveredPin = null"
                                                        style="top: 38%; left: 63%;"
                                                        class="absolute -translate-x-1/2 -translate-y-1/2 pointer-events-auto group/pin transition-transform hover:scale-125 focus:outline-none z-20">
                                                        <span class="relative flex h-7 w-7 items-center justify-center">
                                                            <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-amber-400 opacity-75" :class="selectedLandmark === 2 ? 'block' : 'hidden'"></span>
                                                            <span class="relative inline-flex items-center justify-center rounded-full h-7 w-7 bg-amber-500 text-white font-black text-xs shadow-lg border-2 border-white">2</span>
                                                        </span>
                                                    </button>

                                                    <!-- Pin 3: Art Gallery -->
                                                    <button type="button" @click.stop="selectedLandmark = 3; speakText('Number 3: Art Gallery on West Street and London Road')"
                                                        @mouseenter="hoveredPin = 3" @mouseleave="hoveredPin = null"
                                                        style="top: 70%; left: 36%;"
                                                        class="absolute -translate-x-1/2 -translate-y-1/2 pointer-events-auto group/pin transition-transform hover:scale-125 focus:outline-none z-20">
                                                        <span class="relative flex h-7 w-7 items-center justify-center">
                                                            <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-purple-400 opacity-75" :class="selectedLandmark === 3 ? 'block' : 'hidden'"></span>
                                                            <span class="relative inline-flex items-center justify-center rounded-full h-7 w-7 bg-purple-600 text-white font-black text-xs shadow-lg border-2 border-white">3</span>
                                                        </span>
                                                    </button>

                                                    <!-- Pin 4: Cathedral -->
                                                    <button type="button" @click.stop="selectedLandmark = 4; speakText('Number 4: Cathedral on Church Street and London Road')"
                                                        @mouseenter="hoveredPin = 4" @mouseleave="hoveredPin = null"
                                                        style="top: 50%; left: 38%;"
                                                        class="absolute -translate-x-1/2 -translate-y-1/2 pointer-events-auto group/pin transition-transform hover:scale-125 focus:outline-none z-20">
                                                        <span class="relative flex h-7 w-7 items-center justify-center">
                                                            <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-blue-400 opacity-75" :class="selectedLandmark === 4 ? 'block' : 'hidden'"></span>
                                                            <span class="relative inline-flex items-center justify-center rounded-full h-7 w-7 bg-blue-600 text-white font-black text-xs shadow-lg border-2 border-white">4</span>
                                                        </span>
                                                    </button>

                                                    <!-- Pin 5: Aquarium -->
                                                    <button type="button" @click.stop="selectedLandmark = 5; speakText('Number 5: Aquarium on High Street and Marine Drive')"
                                                        @mouseenter="hoveredPin = 5" @mouseleave="hoveredPin = null"
                                                        style="top: 70%; left: 64%;"
                                                        class="absolute -translate-x-1/2 -translate-y-1/2 pointer-events-auto group/pin transition-transform hover:scale-125 focus:outline-none z-20">
                                                        <span class="relative flex h-7 w-7 items-center justify-center">
                                                            <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-cyan-400 opacity-75" :class="selectedLandmark === 5 ? 'block' : 'hidden'"></span>
                                                            <span class="relative inline-flex items-center justify-center rounded-full h-7 w-7 bg-cyan-600 text-white font-black text-xs shadow-lg border-2 border-white">5</span>
                                                        </span>
                                                    </button>

                                                    <!-- Pin 6: Castle -->
                                                    <button type="button" @click.stop="selectedLandmark = 6; speakText('Number 6: Castle on Park Road')"
                                                        @mouseenter="hoveredPin = 6" @mouseleave="hoveredPin = null"
                                                        style="top: 13%; left: 13%;"
                                                        class="absolute -translate-x-1/2 -translate-y-1/2 pointer-events-auto group/pin transition-transform hover:scale-125 focus:outline-none z-20">
                                                        <span class="relative flex h-7 w-7 items-center justify-center">
                                                            <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75" :class="selectedLandmark === 6 ? 'block' : 'hidden'"></span>
                                                            <span class="relative inline-flex items-center justify-center rounded-full h-7 w-7 bg-emerald-600 text-white font-black text-xs shadow-lg border-2 border-white">6</span>
                                                        </span>
                                                    </button>

                                                    <!-- Pin 7: Abbey -->
                                                    <button type="button" @click.stop="selectedLandmark = 7; speakText('Number 7: Abbey on Abbey Road and Park Road')"
                                                        @mouseenter="hoveredPin = 7" @mouseleave="hoveredPin = null"
                                                        style="top: 16%; left: 27%;"
                                                        class="absolute -translate-x-1/2 -translate-y-1/2 pointer-events-auto group/pin transition-transform hover:scale-125 focus:outline-none z-20">
                                                        <span class="relative flex h-7 w-7 items-center justify-center">
                                                            <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-teal-400 opacity-75" :class="selectedLandmark === 7 ? 'block' : 'hidden'"></span>
                                                            <span class="relative inline-flex items-center justify-center rounded-full h-7 w-7 bg-teal-600 text-white font-black text-xs shadow-lg border-2 border-white">7</span>
                                                        </span>
                                                    </button>

                                                    <!-- Pin 8: Zoo -->
                                                    <button type="button" @click.stop="selectedLandmark = 8; speakText('Number 8: Zoo on King Street')"
                                                        @mouseenter="hoveredPin = 8" @mouseleave="hoveredPin = null"
                                                        style="top: 8%; left: 88%;"
                                                        class="absolute -translate-x-1/2 -translate-y-1/2 pointer-events-auto group/pin transition-transform hover:scale-125 focus:outline-none z-20">
                                                        <span class="relative flex h-7 w-7 items-center justify-center">
                                                            <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-lime-400 opacity-75" :class="selectedLandmark === 8 ? 'block' : 'hidden'"></span>
                                                            <span class="relative inline-flex items-center justify-center rounded-full h-7 w-7 bg-lime-600 text-white font-black text-xs shadow-lg border-2 border-white">8</span>
                                                        </span>
                                                    </button>

                                                    <!-- Service Pin: Railway Station -->
                                                    <button type="button" @click.stop="selectedDesk = 'station'; activeTab = 'desks'; speakText('Railway Station on North Street')"
                                                        style="top: 16%; left: 59%;"
                                                        class="absolute -translate-x-1/2 -translate-y-1/2 pointer-events-auto group/pin transition-transform hover:scale-110 focus:outline-none z-10">
                                                        <span class="px-2 py-0.5 rounded-md bg-slate-900/90 text-white font-black text-[10px] shadow-md border border-white/80 flex items-center gap-1 backdrop-blur-xs">
                                                            <span>🚆</span> <span>Station</span>
                                                        </span>
                                                    </button>

                                                    <!-- Service Pin: Tourist Office -->
                                                    <button type="button" @click.stop="selectedDesk = 'tourist_office'; activeTab = 'desks'; speakText('Tourist Office on High Street and East Street')"
                                                        style="top: 36%; left: 80%;"
                                                        class="absolute -translate-x-1/2 -translate-y-1/2 pointer-events-auto group/pin transition-transform hover:scale-110 focus:outline-none z-10">
                                                        <span class="px-2 py-0.5 rounded-md bg-emerald-700/95 text-white font-black text-[10px] shadow-md border border-white/80 flex items-center gap-1 backdrop-blur-xs">
                                                            <span>ℹ️</span> <span>Tourist Office</span>
                                                        </span>
                                                    </button>

                                                    <!-- Service Pin: Bank -->
                                                    <button type="button" @click.stop="selectedDesk = 'bank'; activeTab = 'desks'; speakText('Bank on West Street and Marine Drive')"
                                                        style="top: 68%; left: 6%;"
                                                        class="absolute -translate-x-1/2 -translate-y-1/2 pointer-events-auto group/pin transition-transform hover:scale-110 focus:outline-none z-10">
                                                        <span class="px-2 py-0.5 rounded-md bg-amber-600/95 text-white font-black text-[10px] shadow-md border border-white/80 flex items-center gap-1 backdrop-blur-xs">
                                                            <span>🏦</span> <span>Bank</span>
                                                        </span>
                                                    </button>

                                                    <!-- Service Pin: Seaview Hotel -->
                                                    <button type="button" @click.stop="selectedDesk = 'hotel'; activeTab = 'desks'; speakText('Seaview Hotel on Marine Drive and East Street')"
                                                        style="top: 63%; left: 88%;"
                                                        class="absolute -translate-x-1/2 -translate-y-1/2 pointer-events-auto group/pin transition-transform hover:scale-110 focus:outline-none z-10">
                                                        <span class="px-2 py-0.5 rounded-md bg-sky-700/95 text-white font-black text-[10px] shadow-md border border-white/80 flex items-center gap-1 backdrop-blur-xs">
                                                            <span>🏨</span> <span>Hotel</span>
                                                        </span>
                                                    </button>
                                                </div>
                                            </template>

                                            <!-- Bottom Info Overlay Pill -->
                                            <div class="absolute bottom-3 right-3 bg-black/75 backdrop-blur-md px-3 py-1.5 rounded-xl text-white text-xs font-semibold flex items-center gap-2 pointer-events-none">
                                                <span x-text="mapMode === '3d' ? '✨ 3D Mode Aktif &bull; Klik pin atau buka modal zoom' : '📄 B&amp;W Scan Aktif &bull; Klik untuk zoom resolusi tinggi'"></span>
                                            </div>
                                        </div>

                                        <!-- AUTHENTIC 2-COLUMN TASK QUESTIONS DIRECTLY BENEATH MAP -->
                                        <div class="p-4 sm:p-5 rounded-2xl bg-white border-2 border-slate-200 shadow-sm space-y-4 min-w-0 overflow-hidden">
                                            <div class="flex flex-col sm:flex-row sm:items-center justify-between pb-3 border-b border-slate-200 gap-2 min-w-0">
                                                <div class="flex items-center gap-2 flex-wrap min-w-0">
                                                    <span class="px-2.5 py-0.5 rounded-full bg-sky-100 text-sky-900 font-black text-[11px] uppercase shrink-0" x-text="selectedSheet.toUpperCase().replace('_', ' ')"></span>
                                                    <h4 class="font-black text-slate-900 text-xs sm:text-sm truncate">Missions &amp; Tasks (Lembar Soal Turis)</h4>
                                                </div>
                                                
                                                <!-- Sheet Switcher Mini Pills -->
                                                <div class="flex items-center gap-1 self-start sm:self-auto overflow-x-auto max-w-full pb-1 sm:pb-0">
                                                    <span class="text-[11px] font-bold text-slate-500 mr-1 shrink-0">Sheet:</span>
                                                    @foreach(['sheet_a'=>'A', 'sheet_b'=>'B', 'sheet_c'=>'C', 'sheet_d'=>'D', 'sheet_e'=>'E', 'sheet_f'=>'F', 'sheet_g'=>'G'] as $sKey => $sLabel)
                                                        <button type="button" @click="selectedSheet = '{{ $sKey }}'"
                                                            :class="selectedSheet === '{{ $sKey }}' ? 'bg-sky-600 text-white font-black shadow-xs ring-2 ring-sky-300' : 'bg-slate-100 text-slate-700 hover:bg-slate-200 font-bold'"
                                                            class="w-6 h-6 rounded-lg text-xs flex items-center justify-center transition-all shrink-0">
                                                            {{ $sLabel }}
                                                        </button>
                                                    @endforeach
                                                </div>
                                            </div>

                                            <!-- 2-Column Tasks List (Left: Steps 1-3, Right: Steps 4-7) -->
                                            @foreach(($gameData['student_sheets'] ?? []) as $sKey => $sheetData)
                                                <div x-show="selectedSheet === '{{ $sKey }}'" class="grid grid-cols-1 sm:grid-cols-2 gap-3 text-xs text-slate-800 font-medium min-w-0">
                                                    <!-- Left Column: Steps 1, 2, 3 -->
                                                    <div class="space-y-3 min-w-0">
                                                        @foreach(array_slice($sheetData['tasks'], 0, 3) as $task)
                                                            @php $taskSubId = 'sheet_' . $sKey . '_task_' . $task['step']; @endphp
                                                            <div class="p-3 rounded-xl bg-slate-50/80 border border-slate-200/90 space-y-2 hover:bg-sky-50/40 hover:border-sky-200 transition-all min-w-0 overflow-hidden">
                                                                <div class="flex items-start gap-2 min-w-0">
                                                                    <span style="background-color: #29a8f5 !important;" class="w-5 h-5 rounded-full text-white text-[10px] font-black flex items-center justify-center shrink-0 shadow-xs mt-0.5">
                                                                        {{ $task['step'] }}
                                                                    </span>
                                                                    <div class="flex-1 space-y-1.5 min-w-0">
                                                                        <div class="font-bold text-slate-900 text-xs leading-snug break-words min-w-0">
                                                                            {{ $task['action'] }}
                                                                        </div>
                                                                        
                                                                        @if(!empty($task['question']) && $task['question'] !== 'Mark it on your map.')
                                                                            <div class="text-sky-900 text-[11px] font-semibold italic flex items-start justify-between gap-1.5 min-w-0">
                                                                                <span class="break-words min-w-0 flex-1 leading-tight">{{ $task['question'] }}</span>
                                                                                <button type="button" @click="speakText(@js($task['inquiry']))" class="p-1 rounded-md bg-white text-sky-700 border border-sky-200 hover:bg-sky-100 text-[10px] shrink-0" title="Dengar Audio">🔊</button>
                                                                            </div>
                                                                            <!-- Interactive Input for typing answers -->
                                                                            <div class="pt-0.5 space-y-1 min-w-0">
                                                                                <input type="text"
                                                                                    x-model="userAnswers['{{ $taskSubId }}']"
                                                                                    @input="saveUserAnswer('{{ $taskSubId }}', $event.target.value)"
                                                                                    placeholder="Ketik jawaban di sini (misal: £28)..."
                                                                                    class="w-full px-2.5 py-1 text-xs font-bold rounded-lg border border-slate-300 bg-white focus:bg-sky-50/60 focus:border-sky-500 focus:ring-2 focus:ring-sky-200 outline-none text-slate-900 transition placeholder:text-slate-400 placeholder:font-normal placeholder:italic">
                                                                            </div>
                                                                        @endif

                                                                        <div class="flex items-center justify-between pt-1 border-t border-slate-200/60 min-w-0 gap-2 flex-wrap">
                                                                            <span class="text-[10px] text-slate-500 font-semibold truncate min-w-0">Tujuan: <strong class="text-slate-700">{{ $task['target_place'] }}</strong></span>
                                                                            <button type="button" @click="toggleSolution('{{ $taskSubId }}')" class="text-[10px] font-bold text-amber-700 hover:text-amber-800 shrink-0">
                                                                                <span x-text="revealedSolutions['{{ $taskSubId }}'] ? '🔒 Tutup Kunci' : '🔑 Kunci'"></span>
                                                                            </button>
                                                                        </div>

                                                                        <div x-show="revealedSolutions['{{ $taskSubId }}']" x-collapse class="p-2 rounded-lg bg-amber-50 border border-amber-200 text-[11px] text-amber-900 font-bold break-words min-w-0">
                                                                            ✅ {{ $task['answer'] }}
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        @endforeach
                                                    </div>

                                                    <!-- Right Column: Steps 4, 5, 6, 7 -->
                                                    <div class="space-y-3 min-w-0">
                                                        @foreach(array_slice($sheetData['tasks'], 3) as $task)
                                                            @php $taskSubId = 'sheet_' . $sKey . '_task_' . $task['step']; @endphp
                                                            <div class="p-3 rounded-xl bg-slate-50/80 border border-slate-200/90 space-y-2 hover:bg-sky-50/40 hover:border-sky-200 transition-all min-w-0 overflow-hidden">
                                                                <div class="flex items-start gap-2 min-w-0">
                                                                    <span style="background-color: #29a8f5 !important;" class="w-5 h-5 rounded-full text-white text-[10px] font-black flex items-center justify-center shrink-0 shadow-xs mt-0.5">
                                                                        {{ $task['step'] }}
                                                                    </span>
                                                                    <div class="flex-1 space-y-1.5 min-w-0">
                                                                        <div class="font-bold text-slate-900 text-xs leading-snug break-words min-w-0">
                                                                            {{ $task['action'] }}
                                                                        </div>
                                                                        
                                                                        @if(!empty($task['question']) && $task['question'] !== 'Mark it on your map.')
                                                                            <div class="text-sky-900 text-[11px] font-semibold italic flex items-start justify-between gap-1.5 min-w-0">
                                                                                <span class="break-words min-w-0 flex-1 leading-tight">{{ $task['question'] }}</span>
                                                                                <button type="button" @click="speakText(@js($task['inquiry']))" class="p-1 rounded-md bg-white text-sky-700 border border-sky-200 hover:bg-sky-100 text-[10px] shrink-0" title="Dengar Audio">🔊</button>
                                                                            </div>
                                                                            <!-- Interactive Input for typing answers -->
                                                                            <div class="pt-0.5 space-y-1 min-w-0">
                                                                                <input type="text"
                                                                                    x-model="userAnswers['{{ $taskSubId }}']"
                                                                                    @input="saveUserAnswer('{{ $taskSubId }}', $event.target.value)"
                                                                                    placeholder="Ketik jawaban di sini (misal: £28)..."
                                                                                    class="w-full px-2.5 py-1 text-xs font-bold rounded-lg border border-slate-300 bg-white focus:bg-sky-50/60 focus:border-sky-500 focus:ring-2 focus:ring-sky-200 outline-none text-slate-900 transition placeholder:text-slate-400 placeholder:font-normal placeholder:italic">
                                                                            </div>
                                                                        @endif

                                                                        <div class="flex items-center justify-between pt-1 border-t border-slate-200/60 min-w-0 gap-2 flex-wrap">
                                                                            <span class="text-[10px] text-slate-500 font-semibold truncate min-w-0">Tujuan: <strong class="text-slate-700">{{ $task['target_place'] }}</strong></span>
                                                                            <button type="button" @click="toggleSolution('{{ $taskSubId }}')" class="text-[10px] font-bold text-amber-700 hover:text-amber-800 shrink-0">
                                                                                <span x-text="revealedSolutions['{{ $taskSubId }}'] ? '🔒 Tutup Kunci' : '🔑 Kunci'"></span>
                                                                            </button>
                                                                        </div>

                                                                        <div x-show="revealedSolutions['{{ $taskSubId }}']" x-collapse class="p-2 rounded-lg bg-amber-50 border border-amber-200 text-[11px] text-amber-900 font-bold break-words min-w-0">
                                                                            ✅ {{ $task['answer'] }}
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>

                                        <!-- Streets List / Legend -->
                                        <div class="p-4 rounded-2xl bg-slate-50 border border-slate-200/80 space-y-2 min-w-0 overflow-hidden">
                                            <div class="text-xs font-black text-slate-700 uppercase tracking-wider flex items-center justify-between">
                                                <span>Street Directory &amp; Coordinates:</span>
                                                <span class="text-[11px] text-sky-600 font-bold">10 Major Streets</span>
                                            </div>
                                            <div class="grid grid-cols-2 sm:grid-cols-3 gap-2 text-xs font-medium text-slate-600 min-w-0">
                                                <div class="p-2 bg-white rounded-xl border border-slate-200/60 hover:border-sky-300 transition-colors min-w-0 break-words leading-tight"><strong>North St:</strong> Railway Station</div>
                                                <div class="p-2 bg-white rounded-xl border border-slate-200/60 hover:border-sky-300 transition-colors min-w-0 break-words leading-tight"><strong>Station Rd:</strong> Station to West St</div>
                                                <div class="p-2 bg-white rounded-xl border border-slate-200/60 hover:border-sky-300 transition-colors min-w-0 break-words leading-tight"><strong>West St:</strong> Bank &amp; Art Gallery</div>
                                                <div class="p-2 bg-white rounded-xl border border-slate-200/60 hover:border-sky-300 transition-colors min-w-0 break-words leading-tight"><strong>London Rd:</strong> Art Gallery / Cathedral</div>
                                                <div class="p-2 bg-white rounded-xl border border-slate-200/60 hover:border-sky-300 transition-colors min-w-0 break-words leading-tight"><strong>High St:</strong> Tourist Office &amp; Aquarium</div>
                                                <div class="p-2 bg-white rounded-xl border border-slate-200/60 hover:border-sky-300 transition-colors min-w-0 break-words leading-tight"><strong>Marine Dr:</strong> Seaview Hotel / Beach</div>
                                                <div class="p-2 bg-white rounded-xl border border-slate-200/60 hover:border-sky-300 transition-colors min-w-0 break-words leading-tight"><strong>East St:</strong> Tourist Office &amp; Hotel</div>
                                                <div class="p-2 bg-white rounded-xl border border-slate-200/60 hover:border-sky-300 transition-colors min-w-0 break-words leading-tight"><strong>Queen St:</strong> Cathedral &amp; Museum</div>
                                                <div class="p-2 bg-white rounded-xl border border-slate-200/60 hover:border-sky-300 transition-colors min-w-0 break-words leading-tight"><strong>Museum St:</strong> (1) Museum / Start</div>
                                                <div class="p-2 bg-white rounded-xl border border-slate-200/60 hover:border-sky-300 transition-colors min-w-0 break-words leading-tight"><strong>Park Rd:</strong> (6) Castle &amp; (7) Abbey</div>
                                                <div class="p-2 bg-white rounded-xl border border-slate-200/60 hover:border-sky-300 transition-colors min-w-0 break-words leading-tight"><strong>King St:</strong> (8) Zoo</div>
                                                <div class="p-2 bg-white rounded-xl border border-slate-200/60 hover:border-sky-300 transition-colors min-w-0 break-words leading-tight"><strong>Market St:</strong> (2) Shopping Centre</div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Right Column: 8 Numbered Landmarks & Key Buildings -->
                                    <div class="lg:col-span-5 space-y-4">
                                        <!-- Key Buildings Box -->
                                        <div class="bg-white rounded-3xl p-5 border border-slate-200/80 shadow-md space-y-3">
                                            <div class="flex items-center justify-between">
                                                <h4 class="font-black text-slate-900 text-sm uppercase tracking-wider flex items-center gap-2">
                                                    <span>🏢</span> <span>4 Major Services on Map</span>
                                                </h4>
                                                <span class="px-2.5 py-0.5 rounded-full bg-sky-100 text-sky-800 text-[11px] font-bold">Roleplay Hubs</span>
                                            </div>
                                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-2.5">
                                                @foreach(($gameData['main_buildings'] ?? []) as $bKey => $building)
                                                    <div class="p-3 rounded-2xl bg-sky-50/50 border border-sky-100 space-y-1 hover:shadow-xs transition-all cursor-pointer" @click="selectedDesk = '{{ $bKey }}'; activeTab = 'desks'; speakText(@js($building['audio']))">
                                                        <div class="flex items-center justify-between">
                                                            <div class="font-bold text-xs text-sky-950 flex items-center gap-1.5">
                                                                <span>{{ $building['icon'] ?? '🏢' }}</span>
                                                                <span>{{ $building['name'] }}</span>
                                                            </div>
                                                            <button type="button" @click.stop="speakText(@js($building['audio']))" class="p-1 rounded-lg bg-sky-200/70 hover:bg-sky-300 text-sky-900 transition-all text-xs" title="Listen Location">
                                                                🔊
                                                            </button>
                                                        </div>
                                                        <div class="text-[11px] font-semibold text-slate-600">📍 {{ $building['street'] }}</div>
                                                        <div class="text-[11px] text-slate-500 leading-tight">{{ $building['desc'] }}</div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>

                                        <!-- 8 Sights & Opening Times Box -->
                                        <div class="bg-white rounded-3xl p-5 border border-slate-200/80 shadow-md space-y-3">
                                            <div class="flex items-center justify-between">
                                                <h4 class="font-black text-slate-900 text-sm uppercase tracking-wider flex items-center gap-2">
                                                    <span>🏛️</span> <span>8 Numbered Town Landmarks</span>
                                                </h4>
                                                <span class="px-2.5 py-0.5 rounded-full bg-amber-100 text-amber-800 text-[11px] font-bold">1 &ndash; 8 on Map</span>
                                            </div>

                                            <div class="space-y-2 max-h-[480px] overflow-y-auto pr-1">
                                                @foreach(($gameData['map_landmarks'] ?? []) as $num => $landmark)
                                                    <div class="p-3 rounded-2xl border transition-all cursor-pointer"
                                                        @click="selectedLandmark = {{ $num }}; speakText(@js($landmark['audio']))"
                                                        :class="selectedLandmark === {{ $num }} ? 'bg-sky-50 border-sky-300 shadow-sm ring-2 ring-sky-400/30' : 'bg-slate-50/70 border-slate-200/80 hover:bg-slate-50'">
                                                        <div class="flex items-start justify-between gap-2">
                                                            <div class="flex items-start gap-2.5">
                                                                <span style="background-color: #29a8f5 !important;" class="w-6 h-6 rounded-full text-white text-xs font-black flex items-center justify-center shrink-0 shadow-xs">
                                                                    {{ $landmark['id'] }}
                                                                </span>
                                                                <div>
                                                                    <div class="font-black text-xs text-slate-900 flex items-center gap-1.5">
                                                                        <span>{{ $landmark['icon'] }}</span>
                                                                        <span>{{ $landmark['name'] }}</span>
                                                                    </div>
                                                                    <div class="text-[11px] font-semibold text-slate-600 mt-0.5">
                                                                        📍 {{ $landmark['street'] }}
                                                                    </div>
                                                                    <div class="flex items-center gap-2 mt-1 text-[11px]">
                                                                        <span class="px-2 py-0.5 rounded-md bg-emerald-100 text-emerald-800 font-bold">
                                                                            🕒 {{ $landmark['open'] }}
                                                                        </span>
                                                                        <span class="px-2 py-0.5 rounded-md bg-rose-100 text-rose-800 font-semibold">
                                                                            {{ $landmark['closed'] }}
                                                                        </span>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <button type="button" @click.stop="selectedLandmark = {{ $num }}; speakText(@js($landmark['audio']))" class="p-1.5 rounded-xl bg-sky-100 hover:bg-sky-200 text-sky-800 transition-all text-xs shrink-0" title="Listen Audio">
                                                                🔊
                                                            </button>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- TAB 2: 4 INFORMATION DESKS -->
                            <div x-show="activeTab === 'desks'" class="space-y-6">
                                <!-- Desk Selector Pills -->
                                <div class="grid grid-cols-2 sm:grid-cols-4 gap-3">
                                    <button type="button" @click="selectedDesk = 'tourist_office'"
                                        :class="selectedDesk === 'tourist_office' ? 'bg-sky-500 text-white shadow-md border-sky-600' : 'bg-white text-slate-700 border-slate-200 hover:bg-slate-50'"
                                        class="p-4 rounded-2xl border text-left transition-all space-y-1">
                                        <div class="text-2xl">ℹ️</div>
                                        <div class="font-black text-sm">Tourist Office</div>
                                        <div class="text-[11px] opacity-80">Opening Times (8 Places)</div>
                                    </button>

                                    <button type="button" @click="selectedDesk = 'bank'"
                                        :class="selectedDesk === 'bank' ? 'bg-sky-500 text-white shadow-md border-sky-600' : 'bg-white text-slate-700 border-slate-200 hover:bg-slate-50'"
                                        class="p-4 rounded-2xl border text-left transition-all space-y-1">
                                        <div class="text-2xl">🏦</div>
                                        <div class="font-black text-sm">Bank</div>
                                        <div class="text-[11px] opacity-80">Exchange Rates (£)</div>
                                    </button>

                                    <button type="button" @click="selectedDesk = 'hotel'"
                                        :class="selectedDesk === 'hotel' ? 'bg-sky-500 text-white shadow-md border-sky-600' : 'bg-white text-slate-700 border-slate-200 hover:bg-slate-50'"
                                        class="p-4 rounded-2xl border text-left transition-all space-y-1">
                                        <div class="text-2xl">🏨</div>
                                        <div class="font-black text-sm">Seaview Hotel</div>
                                        <div class="text-[11px] opacity-80">Room Tariffs (1-4 Nights)</div>
                                    </button>

                                    <button type="button" @click="selectedDesk = 'station'"
                                        :class="selectedDesk === 'station' ? 'bg-sky-500 text-white shadow-md border-sky-600' : 'bg-white text-slate-700 border-slate-200 hover:bg-slate-50'"
                                        class="p-4 rounded-2xl border text-left transition-all space-y-1">
                                        <div class="text-2xl">🚆</div>
                                        <div class="font-black text-sm">Railway Station</div>
                                        <div class="text-[11px] opacity-80">Timetable &amp; Fares</div>
                                    </button>
                                </div>

                                <!-- Desk 1: Tourist Office Details -->
                                <div x-show="selectedDesk === 'tourist_office'" class="bg-white rounded-3xl p-6 sm:p-8 border border-slate-200/80 shadow-sm space-y-6">
                                    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pb-4 border-b border-slate-100">
                                        <div>
                                            <div class="flex items-center gap-2">
                                                <span class="text-2xl">ℹ️</span>
                                                <h3 class="font-black text-slate-900 text-xl">Tourist Office Desk</h3>
                                            </div>
                                            <p class="text-xs text-slate-500 mt-1">Official Opening Times of Places of Interest in Town</p>
                                        </div>
                                        <button type="button" @click="speakText('Welcome to the Tourist Information Office! How can I help you find sights and opening times today?')" class="px-4 py-2 rounded-xl bg-sky-50 hover:bg-sky-100 text-sky-700 border border-sky-200 text-xs font-bold transition-all flex items-center gap-1.5 self-start sm:self-auto">
                                            🔊 <span>Play Greeting</span>
                                        </button>
                                    </div>

                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                        @foreach(($gameData['desks']['tourist_office']['places'] ?? []) as $place)
                                            <div class="p-4 rounded-2xl bg-slate-50/80 border border-slate-200/80 flex items-center justify-between gap-3 hover:bg-sky-50/50 hover:border-sky-200 transition-all">
                                                <div class="flex items-center gap-3">
                                                    <span style="background-color: #29a8f5 !important;" class="w-8 h-8 rounded-full text-white text-sm font-black flex items-center justify-center shrink-0 shadow-xs">
                                                        {{ $place['num'] }}
                                                    </span>
                                                    <div>
                                                        <div class="font-black text-sm text-slate-900">{{ $place['name'] }}</div>
                                                        <div class="text-xs text-slate-600 mt-0.5">
                                                            <strong class="text-emerald-700">Open:</strong> {{ $place['open'] }} &bull; <span class="text-rose-600 font-semibold">{{ $place['note'] }}</span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <button type="button" @click="speakText(@js($place['audio']))" class="p-2 rounded-xl bg-white hover:bg-sky-100 text-sky-700 border border-slate-200 transition-all text-xs" title="Listen Audio">
                                                    🔊
                                                </button>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>

                                <!-- Desk 2: Bank (Foreign Exchange) Details -->
                                <div x-show="selectedDesk === 'bank'" class="bg-white rounded-3xl p-6 sm:p-8 border border-slate-200/80 shadow-sm space-y-6">
                                    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pb-4 border-b border-slate-100">
                                        <div>
                                            <div class="flex items-center gap-2">
                                                <span class="text-2xl">🏦</span>
                                                <h3 class="font-black text-slate-900 text-xl">Bank (Foreign Exchange Desk)</h3>
                                            </div>
                                            <p class="text-xs text-slate-500 mt-1">Rates of Exchange for Pounds (&pound; sterling)</p>
                                        </div>
                                        <button type="button" @click="speakText('Good morning, this is the Foreign Exchange counter. We convert foreign currencies into British Pounds.')" class="px-4 py-2 rounded-xl bg-sky-50 hover:bg-sky-100 text-sky-700 border border-sky-200 text-xs font-bold transition-all flex items-center gap-1.5 self-start sm:self-auto">
                                            🔊 <span>Play Greeting</span>
                                        </button>
                                    </div>

                                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                                        @foreach(($gameData['desks']['bank']['currencies'] ?? []) as $curr)
                                            <div class="p-4 rounded-2xl bg-amber-50/50 border border-amber-200/70 space-y-2 hover:bg-amber-50 transition-all">
                                                <div class="flex items-center justify-between">
                                                    <span class="font-black text-sm text-slate-900">{{ $curr['currency'] }}</span>
                                                    <button type="button" @click="speakText(@js($curr['audio']))" class="p-1.5 rounded-lg bg-white text-amber-700 border border-amber-200 hover:bg-amber-100 transition-all text-xs" title="Listen Rate">
                                                        🔊
                                                    </button>
                                                </div>
                                                <div class="text-xs font-bold text-amber-900 bg-white p-2 rounded-xl border border-amber-200">
                                                    Rate: {{ $curr['rate_desc'] }}
                                                </div>
                                                <div class="text-[11px] text-slate-600">
                                                    <em>e.g. {{ $curr['example'] }}</em>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>

                                <!-- Desk 3: Seaview Hotel Details -->
                                <div x-show="selectedDesk === 'hotel'" class="bg-white rounded-3xl p-6 sm:p-8 border border-slate-200/80 shadow-sm space-y-6">
                                    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pb-4 border-b border-slate-100">
                                        <div>
                                            <div class="flex items-center gap-2">
                                                <span class="text-2xl">🏨</span>
                                                <h3 class="font-black text-slate-900 text-xl">Seaview Hotel Reception</h3>
                                            </div>
                                            <p class="text-xs text-slate-500 mt-1">Official Room Price List &amp; Booking Rates per Night</p>
                                        </div>
                                        <button type="button" @click="speakText('Welcome to the Seaview Hotel! We offer comfortable single and double rooms by the sea.')" class="px-4 py-2 rounded-xl bg-sky-50 hover:bg-sky-100 text-sky-700 border border-sky-200 text-xs font-bold transition-all flex items-center gap-1.5 self-start sm:self-auto">
                                            🔊 <span>Play Greeting</span>
                                        </button>
                                    </div>

                                    <div class="overflow-x-auto">
                                        <table class="w-full text-left border-collapse">
                                            <thead>
                                                <tr class="border-b border-slate-200 bg-slate-50/75 text-xs font-black text-slate-700 uppercase tracking-wider">
                                                    <th class="p-3.5">Room Type</th>
                                                    <th class="p-3.5">Bathroom Spec</th>
                                                    <th class="p-3.5 text-center">Tariff / Night</th>
                                                    <th class="p-3.5 text-center">Audio</th>
                                                </tr>
                                            </thead>
                                            <tbody class="divide-y divide-slate-100 text-xs font-medium text-slate-700">
                                                @foreach(($gameData['desks']['hotel']['rooms'] ?? []) as $room)
                                                    <tr class="hover:bg-sky-50/40 transition-colors">
                                                        <td class="p-3.5 font-bold text-slate-900">{{ $room['type'] }}</td>
                                                        <td class="p-3.5">
                                                            <span class="px-2.5 py-1 rounded-lg {{ $room['feature'] === 'Standard' ? 'bg-slate-100 text-slate-700' : ($room['feature'] === 'With shower' ? 'bg-blue-100 text-blue-800' : 'bg-purple-100 text-purple-800') }} font-semibold">
                                                                {{ $room['feature'] }}
                                                            </span>
                                                        </td>
                                                        <td class="p-3.5 text-center font-black text-sm text-emerald-700">{{ $room['price'] }}</td>
                                                        <td class="p-3.5 text-center">
                                                            <button type="button" @click="speakText(@js($room['audio']))" class="p-1.5 rounded-lg bg-slate-100 hover:bg-sky-100 text-sky-700 transition-all text-xs" title="Listen Audio">
                                                                🔊
                                                            </button>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                                <!-- Desk 4: Railway Station Details -->
                                <div x-show="selectedDesk === 'station'" class="bg-white rounded-3xl p-6 sm:p-8 border border-slate-200/80 shadow-sm space-y-6">
                                    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pb-4 border-b border-slate-100">
                                        <div>
                                            <div class="flex items-center gap-2">
                                                <span class="text-2xl">🚆</span>
                                                <h3 class="font-black text-slate-900 text-xl">Railway Station Ticket Office</h3>
                                            </div>
                                            <p class="text-xs text-slate-500 mt-1">Train Timetable &amp; Single / Return Fares</p>
                                        </div>
                                        <button type="button" @click="speakText('Good day from the Railway Station! Trains are running on schedule to London, Liverpool, York, Manchester, and Bristol.')" class="px-4 py-2 rounded-xl bg-sky-50 hover:bg-sky-100 text-sky-700 border border-sky-200 text-xs font-bold transition-all flex items-center gap-1.5 self-start sm:self-auto">
                                            🔊 <span>Play Greeting</span>
                                        </button>
                                    </div>

                                    <div class="overflow-x-auto">
                                        <table class="w-full text-left border-collapse">
                                            <thead>
                                                <tr class="border-b border-slate-200 bg-slate-50/75 text-xs font-black text-slate-700 uppercase tracking-wider">
                                                    <th class="p-3.5">Destination</th>
                                                    <th class="p-3.5">Departure Times</th>
                                                    <th class="p-3.5 text-center">Single Fare</th>
                                                    <th class="p-3.5 text-center">Return Fare</th>
                                                    <th class="p-3.5 text-center">Listen</th>
                                                </tr>
                                            </thead>
                                            <tbody class="divide-y divide-slate-100 text-xs font-medium text-slate-700">
                                                @foreach(($gameData['desks']['station']['trains'] ?? []) as $train)
                                                    <tr class="hover:bg-sky-50/40 transition-colors">
                                                        <td class="p-3.5 font-bold text-slate-900 flex items-center gap-2">
                                                            <span>🚄</span> <span>{{ $train['dest'] }}</span>
                                                        </td>
                                                        <td class="p-3.5">
                                                            <div class="flex flex-wrap gap-1.5">
                                                                @foreach($train['dep'] as $dTime)
                                                                    <span class="px-2 py-0.5 rounded-md bg-slate-100 text-slate-800 font-mono font-bold text-[11px] border border-slate-200/60">
                                                                        {{ $dTime }}
                                                                    </span>
                                                                @endforeach
                                                            </div>
                                                        </td>
                                                        <td class="p-3.5 text-center font-bold text-slate-800">{{ $train['single'] }}</td>
                                                        <td class="p-3.5 text-center font-black text-emerald-700">{{ $train['return'] }}</td>
                                                        <td class="p-3.5 text-center">
                                                            <button type="button" @click="speakText(@js($train['audio']))" class="p-1.5 rounded-lg bg-slate-100 hover:bg-sky-100 text-sky-700 transition-all text-xs" title="Listen Timetable">
                                                                🔊
                                                            </button>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>

                            <!-- TAB 3: TOURIST ROLEPLAYS (SHEETS A THROUGH G) -->
                            <div x-show="activeTab === 'sheets'" class="space-y-6">
                                <!-- Sheet Selector Buttons (Grid A-G) -->
                                <div class="grid grid-cols-2 sm:grid-cols-4 lg:grid-cols-7 gap-2.5">
                                    @foreach(($gameData['student_sheets'] ?? []) as $sKey => $sVal)
                                        <button type="button" @click="selectedSheet = '{{ $sKey }}'"
                                            :class="selectedSheet === '{{ $sKey }}' ? 'bg-sky-500 text-white shadow-md border-sky-600 font-black' : 'bg-white text-slate-700 border-slate-200 hover:bg-slate-50'"
                                            class="p-3 rounded-2xl border text-left transition-all space-y-1">
                                            <div class="flex items-center justify-between">
                                                <span class="px-2 py-0.5 rounded-full text-[9px] font-black uppercase tracking-wider" :class="selectedSheet === '{{ $sKey }}' ? 'bg-white/20 text-white' : 'bg-sky-100 text-sky-800'">{{ $sVal['badge'] }}</span>
                                                <span class="text-[10px] font-bold opacity-80">7 Tasks</span>
                                            </div>
                                            <div class="font-black text-xs sm:text-sm truncate">{{ $sVal['title'] }}</div>
                                            <div class="text-[10px] opacity-80 line-clamp-1 truncate">📍 {{ $sVal['start'] }}</div>
                                        </button>
                                    @endforeach
                                </div>

                                <!-- Sheet Content Viewers -->
                                @foreach(($gameData['student_sheets'] ?? []) as $sheetKey => $sheet)
                                    <div x-show="selectedSheet === '{{ $sheetKey }}'" class="bg-white rounded-3xl p-6 sm:p-8 border border-slate-200/80 shadow-sm space-y-6">
                                        <!-- Sheet Header -->
                                        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pb-4 border-b border-slate-100">
                                            <div>
                                                <div class="flex items-center gap-2">
                                                    <span class="px-3 py-1 rounded-full bg-sky-100 text-sky-800 text-xs font-black">{{ $sheet['badge'] }}</span>
                                                    <h3 class="font-black text-slate-900 text-xl">{{ $sheet['title'] }}</h3>
                                                </div>
                                                <p class="text-xs text-slate-500 mt-1">
                                                    📍 <strong>Starting Location:</strong> {{ $sheet['start'] }}
                                                </p>
                                            </div>

                                            <div class="flex items-center gap-2">
                                                <button type="button" @click="activeModal = '{{ $sheetKey }}'" class="px-3.5 py-2 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-800 text-xs font-bold transition-all flex items-center gap-1.5">
                                                    <span>📄</span> <span>Lihat Lembar Asli</span>
                                                </button>
                                            </div>
                                        </div>

                                        <!-- 7 Missions Cards Grid -->
                                        <div class="space-y-4">
                                            @foreach($sheet['tasks'] as $task)
                                                @php $taskId = $sheetKey . '_task_' . $task['step']; @endphp
                                                <div class="p-5 rounded-2xl border transition-all bg-slate-50/60 border-slate-200/80 hover:bg-white hover:shadow-sm">
                                                    <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-4">
                                                        <div class="space-y-2 flex-1">
                                                            <div class="flex items-center gap-2 flex-wrap">
                                                                <span style="background-color: #29a8f5 !important;" class="w-6 h-6 rounded-full text-white text-xs font-black flex items-center justify-center shrink-0 shadow-xs">
                                                                    {{ $task['step'] }}
                                                                </span>
                                                                <span class="px-2.5 py-0.5 rounded-full bg-slate-200 text-slate-800 text-[11px] font-bold">
                                                                    Destination: {{ $task['target_place'] }}
                                                                </span>
                                                            </div>
                                                            <div class="font-bold text-xs sm:text-sm text-slate-900">
                                                                {{ $task['action'] }}
                                                            </div>
                                                            <div class="text-xs font-semibold text-sky-700">
                                                                📝 <em>{{ $task['question'] }}</em>
                                                            </div>

                                                            <!-- Speaking Dialogue Box -->
                                                            <div class="p-3 rounded-xl bg-sky-50/70 border border-sky-100 space-y-1.5 text-xs text-slate-800">
                                                                <div class="flex items-start justify-between gap-2">
                                                                    <div>
                                                                        <strong class="text-sky-900">Tourist:</strong> "{{ $task['inquiry'] }}"
                                                                    </div>
                                                                    <button type="button" @click="speakText(@js($task['inquiry']))" class="p-1 rounded-md bg-sky-200/60 hover:bg-sky-300 text-sky-900 transition-all text-xs shrink-0" title="Play Inquiry">
                                                                        🔊
                                                                    </button>
                                                                </div>
                                                                <div class="flex items-start justify-between gap-2 pt-1 border-t border-sky-100">
                                                                    <div>
                                                                        <strong class="text-emerald-900">Desk Clerk:</strong> "{{ $task['desk_reply'] }}"
                                                                    </div>
                                                                    <button type="button" @click="speakText(@js($task['desk_reply']))" class="p-1 rounded-md bg-emerald-200/60 hover:bg-emerald-300 text-emerald-900 transition-all text-xs shrink-0" title="Play Reply">
                                                                        🔊
                                                                    </button>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <!-- Solution Box & Toggle -->
                                                        <div class="lg:w-72 shrink-0 flex flex-col justify-between gap-2.5">
                                                            <!-- Interactive student input field -->
                                                            <div class="space-y-1">
                                                                <div class="text-[10px] font-bold text-slate-500 flex items-center justify-between">
                                                                    <span>✍️ Catatan / Jawaban Anda:</span>
                                                                    <span x-show="userAnswers['{{ $taskId }}']" class="text-emerald-600 font-extrabold text-[9px]">Tersimpan</span>
                                                                </div>
                                                                <input type="text"
                                                                    x-model="userAnswers['{{ $taskId }}']"
                                                                    @input="saveUserAnswer('{{ $taskId }}', $event.target.value)"
                                                                    placeholder="Ketik jawaban di sini..."
                                                                    class="w-full px-3 py-1.5 text-xs font-bold rounded-xl border border-slate-300 bg-white focus:bg-sky-50/60 focus:border-sky-500 focus:ring-2 focus:ring-sky-200 outline-none text-slate-900 transition placeholder:text-slate-400 placeholder:font-normal placeholder:italic">
                                                            </div>

                                                            <button type="button" @click="toggleSolution('{{ $taskId }}')"
                                                                class="w-full px-4 py-2 rounded-xl text-xs font-black transition-all flex items-center justify-center gap-2 border"
                                                                :class="revealedSolutions['{{ $taskId }}'] ? 'bg-amber-100 border-amber-300 text-amber-900' : 'bg-white border-slate-300 text-slate-700 hover:bg-slate-100'">
                                                                <span x-text="revealedSolutions['{{ $taskId }}'] ? '🔒 Sembunyikan Kunci' : '🔑 Buka Kunci Jawaban'"></span>
                                                            </button>

                                                            <div x-show="revealedSolutions['{{ $taskId }}']" x-collapse class="p-3 rounded-xl bg-amber-50 border border-amber-200 space-y-1 text-xs">
                                                                <div class="font-black text-amber-900 flex items-center gap-1">
                                                                    <span>✅</span> <span>Kunci: {{ $task['answer'] }}</span>
                                                                </div>
                                                                <div class="text-[11px] text-amber-800 leading-tight">
                                                                    {{ $task['calc'] }}
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            <!-- TAB 4: INTERACTIVE TRAVEL TOOLS & CALCULATORS -->
                            <div x-show="activeTab === 'calculator'" class="space-y-6">
                                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                                    <!-- Tool 1: Live Foreign Exchange Converter -->
                                    <div class="bg-white rounded-3xl p-6 border border-slate-200/80 shadow-sm space-y-5 flex flex-col justify-between">
                                        <div class="space-y-4">
                                            <div class="flex items-center gap-2 pb-3 border-b border-slate-100">
                                                <span class="text-2xl">💱</span>
                                                <div>
                                                    <h4 class="font-black text-slate-900 text-base">Bank Currency Converter</h4>
                                                    <p class="text-xs text-slate-500">Live conversion to &pound; Sterling</p>
                                                </div>
                                            </div>

                                            <div class="space-y-3 text-xs">
                                                <div>
                                                    <label class="block font-bold text-slate-700 mb-1">Pilih Mata Uang Asing:</label>
                                                    <select x-model="converter.currency" class="w-full px-3 py-2 rounded-xl bg-slate-50 border border-slate-200 font-bold text-slate-800 focus:outline-none focus:ring-2 focus:ring-sky-500">
                                                        <option value="francs">French Francs (10.00 = &pound;1)</option>
                                                        <option value="marks">German Marks (4.50 = &pound;1)</option>
                                                        <option value="lire">Italian Lire (2,300 = &pound;1)</option>
                                                        <option value="pesetas">Spanish Pesetas (200 = &pound;1)</option>
                                                        <option value="dollars">US Dollars ($1.50 = &pound;1)</option>
                                                        <option value="yen">Japanese Yen (400 = &pound;1)</option>
                                                    </select>
                                                </div>

                                                <div>
                                                    <label class="block font-bold text-slate-700 mb-1">Jumlah Uang Asing:</label>
                                                    <input type="number" x-model="converter.foreignAmount" class="w-full px-3 py-2 rounded-xl bg-slate-50 border border-slate-200 font-bold text-slate-800 focus:outline-none focus:ring-2 focus:ring-sky-500">
                                                </div>

                                                <!-- Preset Buttons for Quick Roleplay -->
                                                <div>
                                                    <label class="block font-bold text-slate-500 text-[11px] mb-1">Contoh Soal Roleplay (Sheets A–G):</label>
                                                    <div class="flex flex-wrap gap-1.5">
                                                        <button type="button" @click="converter.currency = 'francs'; converter.foreignAmount = 250" class="px-2 py-1 rounded-lg bg-slate-100 hover:bg-sky-100 text-[11px] font-bold text-slate-700">A: 250 Francs</button>
                                                        <button type="button" @click="converter.currency = 'lire'; converter.foreignAmount = 23000" class="px-2 py-1 rounded-lg bg-slate-100 hover:bg-sky-100 text-[11px] font-bold text-slate-700">B: 23,000 Lire</button>
                                                        <button type="button" @click="converter.currency = 'yen'; converter.foreignAmount = 4000" class="px-2 py-1 rounded-lg bg-slate-100 hover:bg-sky-100 text-[11px] font-bold text-slate-700">C: 4,000 Yen</button>
                                                        <button type="button" @click="converter.currency = 'pesetas'; converter.foreignAmount = 5000" class="px-2 py-1 rounded-lg bg-slate-100 hover:bg-sky-100 text-[11px] font-bold text-slate-700">D: 5,000 Pesetas</button>
                                                        <button type="button" @click="converter.currency = 'marks'; converter.foreignAmount = 225" class="px-2 py-1 rounded-lg bg-slate-100 hover:bg-sky-100 text-[11px] font-bold text-slate-700">E: £50 &rarr; 225 Marks</button>
                                                        <button type="button" @click="converter.currency = 'pesetas'; converter.foreignAmount = 10000" class="px-2 py-1 rounded-lg bg-slate-100 hover:bg-sky-100 text-[11px] font-bold text-slate-700">F: 10,000 Pesetas</button>
                                                        <button type="button" @click="converter.currency = 'dollars'; converter.foreignAmount = 50" class="px-2 py-1 rounded-lg bg-slate-100 hover:bg-sky-100 text-[11px] font-bold text-slate-700">G: $50 Dollars</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Output Result Card -->
                                        <div class="p-4 rounded-2xl bg-emerald-50 border border-emerald-200 text-center space-y-1">
                                            <div class="text-[11px] font-bold text-emerald-800 uppercase tracking-wider">Hasil Tukar Uang:</div>
                                            <div class="text-2xl font-black text-emerald-700 font-mono">
                                                &pound;<span x-text="converter.gbp"></span>
                                            </div>
                                            <div class="text-[11px] text-emerald-800">
                                                Formula: <span x-text="converter.foreignAmount"></span> &divide; <span x-text="converter.rates[converter.currency]"></span> = &pound;<span x-text="converter.gbp"></span>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Tool 2: Hotel Room Tariff Calculator -->
                                    <div class="bg-white rounded-3xl p-6 border border-slate-200/80 shadow-sm space-y-5 flex flex-col justify-between">
                                        <div class="space-y-4">
                                            <div class="flex items-center gap-2 pb-3 border-b border-slate-100">
                                                <span class="text-2xl">🏨</span>
                                                <div>
                                                    <h4 class="font-black text-slate-900 text-base">Hotel Cost Estimator</h4>
                                                    <p class="text-xs text-slate-500">Seaview Hotel room calculation</p>
                                                </div>
                                            </div>

                                            <div class="space-y-3 text-xs">
                                                <div>
                                                    <label class="block font-bold text-slate-700 mb-1">Pilih Tipe Kamar &amp; Fasilitas:</label>
                                                    <select x-model.number="hotelCalc.roomRate" class="w-full px-3 py-2 rounded-xl bg-slate-50 border border-slate-200 font-bold text-slate-800 focus:outline-none focus:ring-2 focus:ring-sky-500">
                                                        <option value="12">Single Room (Standard) - &pound;12/night</option>
                                                        <option value="14">Single Room (With Shower) - &pound;14/night</option>
                                                        <option value="15">Single Room (With Bath) - &pound;15/night</option>
                                                        <option value="20">Double Room (Standard) - &pound;20/night</option>
                                                        <option value="22">Double Room (With Shower) - &pound;22/night</option>
                                                        <option value="25">Double Room (With Bath) - &pound;25/night</option>
                                                    </select>
                                                </div>

                                                <div>
                                                    <label class="block font-bold text-slate-700 mb-1">Lama Menginap (Nights):</label>
                                                    <input type="number" min="1" max="30" x-model.number="hotelCalc.nights" class="w-full px-3 py-2 rounded-xl bg-slate-50 border border-slate-200 font-bold text-slate-800 focus:outline-none focus:ring-2 focus:ring-sky-500">
                                                </div>

                                                <!-- Preset Buttons for Quick Roleplay -->
                                                <div>
                                                    <label class="block font-bold text-slate-500 text-[11px] mb-1">Contoh Soal Roleplay (Sheets A–G):</label>
                                                    <div class="flex flex-wrap gap-1.5">
                                                        <button type="button" @click="hotelCalc.roomRate = 14; hotelCalc.nights = 2" class="px-2 py-1 rounded-lg bg-slate-100 hover:bg-sky-100 text-[11px] font-bold text-slate-700">A: Single+Shower (2 Nts)</button>
                                                        <button type="button" @click="hotelCalc.roomRate = 20; hotelCalc.nights = 1" class="px-2 py-1 rounded-lg bg-slate-100 hover:bg-sky-100 text-[11px] font-bold text-slate-700">B: Double Std (1 Nt)</button>
                                                        <button type="button" @click="hotelCalc.roomRate = 14; hotelCalc.nights = 4" class="px-2 py-1 rounded-lg bg-slate-100 hover:bg-sky-100 text-[11px] font-bold text-slate-700">C: Single+Shower (4 Nts)</button>
                                                        <button type="button" @click="hotelCalc.roomRate = 22; hotelCalc.nights = 3" class="px-2 py-1 rounded-lg bg-slate-100 hover:bg-sky-100 text-[11px] font-bold text-slate-700">D: Double+Shower (3 Nts)</button>
                                                        <button type="button" @click="hotelCalc.roomRate = 15; hotelCalc.nights = 2" class="px-2 py-1 rounded-lg bg-slate-100 hover:bg-sky-100 text-[11px] font-bold text-slate-700">E: Single+Bath (2 Nts)</button>
                                                        <button type="button" @click="hotelCalc.roomRate = 12; hotelCalc.nights = 3" class="px-2 py-1 rounded-lg bg-slate-100 hover:bg-sky-100 text-[11px] font-bold text-slate-700">F: Single Std (3 Nts)</button>
                                                        <button type="button" @click="hotelCalc.roomRate = 25; hotelCalc.nights = 2" class="px-2 py-1 rounded-lg bg-slate-100 hover:bg-sky-100 text-[11px] font-bold text-slate-700">G: Double+Bath (2 Nts)</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Output Result Card -->
                                        <div class="p-4 rounded-2xl bg-sky-50 border border-sky-200 text-center space-y-1">
                                            <div class="text-[11px] font-bold text-sky-800 uppercase tracking-wider">Total Biaya Menginap:</div>
                                            <div class="text-2xl font-black text-sky-700 font-mono">
                                                &pound;<span x-text="hotelCalc.total"></span>
                                            </div>
                                            <div class="text-[11px] text-sky-800">
                                                Formula: <span x-text="hotelCalc.nights"></span> malam &times; &pound;<span x-text="hotelCalc.roomRate"></span> = &pound;<span x-text="hotelCalc.total"></span>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Tool 3: Train Timetable & Fare Board -->
                                    <div class="bg-white rounded-3xl p-6 border border-slate-200/80 shadow-sm space-y-5 flex flex-col justify-between">
                                        <div class="space-y-4">
                                            <div class="flex items-center gap-2 pb-3 border-b border-slate-100">
                                                <span class="text-2xl">🚆</span>
                                                <div>
                                                    <h4 class="font-black text-slate-900 text-base">Train Board &amp; Fares</h4>
                                                    <p class="text-xs text-slate-500">Check departure times &amp; tickets</p>
                                                </div>
                                            </div>

                                            <div class="space-y-3 text-xs">
                                                <div>
                                                    <label class="block font-bold text-slate-700 mb-1">Pilih Kota Tujuan (Destination):</label>
                                                    <select x-model="trainCalc.dest" class="w-full px-3 py-2 rounded-xl bg-slate-50 border border-slate-200 font-bold text-slate-800 focus:outline-none focus:ring-2 focus:ring-sky-500">
                                                        <option value="London">London</option>
                                                        <option value="Liverpool">Liverpool</option>
                                                        <option value="York">York</option>
                                                        <option value="Manchester">Manchester</option>
                                                        <option value="Bristol">Bristol</option>
                                                    </select>
                                                </div>

                                                <div>
                                                    <label class="block font-bold text-slate-700 mb-1">Jenis Tiket:</label>
                                                    <div class="grid grid-cols-2 gap-2">
                                                        <button type="button" @click="trainCalc.ticketType = 'single'"
                                                            :class="trainCalc.ticketType === 'single' ? 'bg-sky-500 text-white font-bold' : 'bg-slate-100 text-slate-700'"
                                                            class="p-2 rounded-xl text-xs transition-all">Single Ticket</button>
                                                        <button type="button" @click="trainCalc.ticketType = 'return'"
                                                            :class="trainCalc.ticketType === 'return' ? 'bg-sky-500 text-white font-bold' : 'bg-slate-100 text-slate-700'"
                                                            class="p-2 rounded-xl text-xs transition-all">Return Ticket</button>
                                                    </div>
                                                </div>

                                                <!-- Departures List -->
                                                <div>
                                                    <label class="block font-bold text-slate-700 mb-1">Jadwal Keberangkatan Kereta:</label>
                                                    <div class="flex flex-wrap gap-1.5">
                                                        <template x-for="time in (trainCalc.fares[trainCalc.dest]?.times || [])" :key="time">
                                                            <span class="px-2.5 py-1 rounded-lg bg-slate-100 border border-slate-200 font-mono font-bold text-slate-800 text-xs" x-text="time"></span>
                                                        </template>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Output Result Card -->
                                        <div class="p-4 rounded-2xl bg-purple-50 border border-purple-200 text-center space-y-1">
                                            <div class="text-[11px] font-bold text-purple-800 uppercase tracking-wider">Harga Tiket Kereta:</div>
                                            <div class="text-2xl font-black text-purple-700 font-mono">
                                                &pound;<span x-text="trainCalc.currentFare"></span>
                                            </div>
                                            <div class="text-[11px] text-purple-800">
                                                <span x-text="trainCalc.dest"></span> &bull; <span x-text="trainCalc.ticketType === 'return' ? 'Tiket Pulang-Pergi (Return)' : 'Tiket Sekali Jalan (Single)'"></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- TAB 5: KEY SPEAKING PATTERNS & DIALOGUES -->
                            <div x-show="activeTab === 'dialogues'" class="space-y-6">
                                <div class="bg-white rounded-3xl p-6 sm:p-8 border border-slate-200/80 shadow-sm space-y-6">
                                    <div class="pb-4 border-b border-slate-100">
                                        <h3 class="font-black text-slate-900 text-xl flex items-center gap-2">
                                            <span>💬</span> <span>Target Speaking Exponents &amp; Roleplay Phrases</span>
                                        </h3>
                                        <p class="text-xs text-slate-500 mt-1">Gunakan pola kalimat berikut saat simulasi di 4 meja informasi</p>
                                    </div>

                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                        @foreach(($gameData['exponents'] ?? []) as $idx => $exp)
                                            <div class="p-4 rounded-2xl bg-sky-50/50 border border-sky-100 flex items-start justify-between gap-3 hover:bg-sky-50 transition-all">
                                                <div class="space-y-1">
                                                    <span class="px-2 py-0.5 rounded-full bg-sky-200/80 text-sky-900 text-[10px] font-black uppercase tracking-wider">Pattern {{ $idx + 1 }}</span>
                                                    <div class="font-bold text-xs sm:text-sm text-slate-900 leading-snug">
                                                        "{{ $exp }}"
                                                    </div>
                                                </div>
                                                <button type="button" @click="speakText(@js($exp))" class="p-2 rounded-xl bg-white text-sky-700 border border-sky-200 hover:bg-sky-100 transition-all text-xs shrink-0" title="Listen Audio">
                                                    🔊
                                                </button>
                                            </div>
                                        @endforeach
                                    </div>

                                    <!-- Sample Connected Roleplay Script -->
                                    <div class="p-5 rounded-2xl bg-slate-50 border border-slate-200 space-y-3">
                                        <div class="font-black text-xs text-slate-800 uppercase tracking-wider flex items-center gap-1.5">
                                            <span>🎭</span> <span>Contoh Percakapan Lengkap (Dialogue Demonstration)</span>
                                        </div>
                                        <div class="space-y-2 text-xs text-slate-700 leading-relaxed">
                                            <p><strong>Tourist:</strong> "Excuse me, could you tell me where the bank is?"</p>
                                            <p><strong>Local Resident:</strong> "Yes, walk straight along West Street, and it is on your left opposite Marine Drive."</p>
                                            <p><strong>Tourist:</strong> "Thank you! And what time does the castle open?"</p>
                                            <p><strong>Tourist Office:</strong> "The castle is building number 6 on Park Road. It is open every day from 10am to 5pm."</p>
                                            <p><strong>Tourist:</strong> "Great. I'd also like to book a single room with a shower for two nights at the Seaview Hotel. How much is that?"</p>
                                            <p><strong>Hotel Clerk:</strong> "That will be &pound;28 in total (&pound;14 per night)."</p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- TAB 6: TEACHER GUIDE & AUTHENTIC RULES (WANDERING TOURISTS) -->
                            <div x-show="activeTab === 'guide'" class="space-y-6">
                                <div class="bg-white rounded-3xl p-6 sm:p-8 border border-slate-200/80 shadow-sm space-y-6">
                                    <!-- Guide Header -->
                                    <div class="flex flex-col sm:flex-row sm:items-center justify-between pb-4 border-b border-slate-100 gap-4">
                                        <div>
                                            <div class="flex items-center gap-2">
                                                <span class="text-2xl">👩‍🏫</span>
                                                <h3 class="font-black text-slate-900 text-xl">Teacher's Lesson Plan &amp; Rules • Wandering Tourists</h3>
                                            </div>
                                            <p class="text-xs text-slate-500 mt-1">Official Game Guide &amp; Classroom Simulation Methodology</p>
                                        </div>

                                        <div class="flex items-center gap-2">
                                            <button type="button" @click="activeModal = 'teacher_rules_1'" class="px-3.5 py-2 rounded-xl bg-amber-100 hover:bg-amber-200 text-amber-900 text-xs font-black transition-all flex items-center gap-1.5 shadow-xs">
                                                <span>📖</span> <span>Rules Scan Hal 1</span>
                                            </button>
                                            <button type="button" @click="activeModal = 'teacher_rules_2'" class="px-3.5 py-2 rounded-xl bg-amber-100 hover:bg-amber-200 text-amber-900 text-xs font-black transition-all flex items-center gap-1.5 shadow-xs">
                                                <span>📖</span> <span>Rules Scan Hal 2</span>
                                            </button>
                                        </div>
                                    </div>

                                    <!-- Quick Summary Badges Grid -->
                                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-3 text-xs">
                                        <div class="p-3.5 rounded-2xl bg-sky-50/70 border border-sky-100">
                                            <span class="text-[10px] font-bold text-sky-700 uppercase tracking-wider block">Type of Activity</span>
                                            <strong class="font-black text-slate-900 text-sm">Whole Class Simulation</strong>
                                            <span class="text-[11px] text-slate-500 block mt-0.5">Min. 8 Siswa (4 Meja Info + Turis)</span>
                                        </div>
                                        <div class="p-3.5 rounded-2xl bg-emerald-50/70 border border-emerald-100">
                                            <span class="text-[10px] font-bold text-emerald-700 uppercase tracking-wider block">Function Practised</span>
                                            <strong class="font-black text-slate-900 text-sm">Asking for Tourist Info</strong>
                                            <span class="text-[11px] text-slate-500 block mt-0.5">Directions, Times, Fares, Hotels &amp; Currency</span>
                                        </div>
                                        <div class="p-3.5 rounded-2xl bg-purple-50/70 border border-purple-100">
                                            <span class="text-[10px] font-bold text-purple-700 uppercase tracking-wider block">Lexical Areas</span>
                                            <strong class="font-black text-slate-900 text-sm">City &amp; Travel Vocabulary</strong>
                                            <span class="text-[11px] text-slate-500 block mt-0.5">Directions, Public Buildings, Banks, Hotels</span>
                                        </div>
                                    </div>

                                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                                        <!-- Classroom Organization & Procedures -->
                                        <div class="p-5 rounded-2xl bg-slate-50 border border-slate-200/80 space-y-3">
                                            <div class="flex items-center gap-2">
                                                <span class="w-3 h-3 rounded-full bg-sky-500"></span>
                                                <h4 class="font-black text-slate-900 text-sm uppercase tracking-wider">Classroom Setup &amp; Game Rules</h4>
                                            </div>
                                            <ul class="space-y-2 text-xs font-medium text-slate-800">
                                                <li class="p-3 rounded-xl bg-white border border-slate-200/70 space-y-1">
                                                    <div class="font-black text-sky-950 flex items-center gap-1.5">
                                                        <span>🏢</span> <span>1. Setup 4 Information Desks</span>
                                                    </div>
                                                    <p class="text-slate-600">Kosongkan ruang tengah kelas. Tempatkan 4 meja di 4 sudut ruangan berbeda untuk mewakili: <strong>Tourist Office</strong>, <strong>Bank</strong>, <strong>Railway Station</strong>, dan <strong>Seaview Hotel</strong>. Tunjuk 4 siswa memegang kartu master masing-masing meja. *(Jika ada 15-16 siswa, tempatkan 2 siswa per meja untuk melayani antrean)*.</p>
                                                </li>
                                                <li class="p-3 rounded-xl bg-white border border-slate-200/70 space-y-1">
                                                    <div class="font-black text-sky-950 flex items-center gap-1.5">
                                                        <span>🎒</span> <span>2. Distribute Tourist Sheets &amp; Maps</span>
                                                    </div>
                                                    <p class="text-slate-600">Siswa yang tersisa berperan sebagai <strong>Wandering Tourists</strong>. Bagikan lembar tugas (Sheets A s.d. G) beserta Peta Kota (Town Map) kepada masing-masing turis.</p>
                                                </li>
                                                <li class="p-3 rounded-xl bg-amber-50 border border-amber-200 space-y-1">
                                                    <div class="font-black text-amber-950 flex items-center gap-1.5">
                                                        <span>⚠️</span> <span>3. Core Rule: Follow Exact Order of Tasks</span>
                                                    </div>
                                                    <p class="text-amber-900 font-semibold">Tujuan permainan adalah siswa harus menyelesaikan instruksi misi <strong>sesuai urutan langkah yang tertulis di lembar tugas (Step 1 s.d. 7)</strong>.</p>
                                                </li>
                                                <li class="p-3 rounded-xl bg-emerald-50 border border-emerald-200 space-y-1">
                                                    <div class="font-black text-emerald-950 flex items-center gap-1.5">
                                                        <span>🗺️</span> <span>4. Core Rule: Ask &amp; Mark Before Visiting</span>
                                                    </div>
                                                    <p class="text-emerald-900 font-semibold">Turis harus bertanya kepada orang di jalan (sesama siswa) mengenai lokasi Bank, Hotel, Tourist Office, dan Stasiun, lalu <strong>menandai posisinya di peta terlebih dahulu</strong> sebelum mendatangi meja informasi tersebut.</p>
                                                </li>
                                            </ul>
                                        </div>

                                        <!-- Pedagogical Background & Target Vocabulary -->
                                        <div class="space-y-4">
                                            <!-- How to Use / Pedagogical Background -->
                                            <div class="p-5 rounded-2xl bg-sky-50/60 border border-sky-100 space-y-2.5">
                                                <div class="font-black text-xs text-sky-950 uppercase tracking-wider flex items-center gap-1.5">
                                                    <span>💡</span> <span>How to Use the Game (Pedagogical Context)</span>
                                                </div>
                                                <p class="text-xs text-slate-700 leading-relaxed font-medium">
                                                    Simulasi dasar (*elementary simulation*) ini dirancang untuk memantapkan dan mengintegrasikan 5 keterampilan komunikasi praktis yang telah dipelajari siswa:
                                                </p>
                                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-2 text-[11px] font-bold text-sky-900">
                                                    <div class="p-2 bg-white rounded-lg border border-sky-100">&bull; <strong>Visiting friends:</strong> Directions</div>
                                                    <div class="p-2 bg-white rounded-lg border border-sky-100">&bull; <strong>Planning a day out:</strong> Opening/closing times</div>
                                                    <div class="p-2 bg-white rounded-lg border border-sky-100">&bull; <strong>Getting there on time:</strong> Travel info &amp; trains</div>
                                                    <div class="p-2 bg-white rounded-lg border border-sky-100">&bull; <strong>Shopping around:</strong> Prices &amp; exchange rates</div>
                                                    <div class="p-2 bg-white rounded-lg border border-sky-100 sm:col-span-2">&bull; <strong>Finding a hotel:</strong> Reserving a room &amp; room tariffs</div>
                                                </div>
                                            </div>

                                            <!-- Essential Vocabulary -->
                                            <div class="p-5 rounded-2xl bg-amber-50/60 border border-amber-100 space-y-2.5">
                                                <div class="font-black text-xs text-amber-950 uppercase tracking-wider flex items-center gap-1.5">
                                                    <span>📚</span> <span>Essential Vocabulary &amp; Sights</span>
                                                </div>
                                                <div class="p-3 rounded-xl bg-white border border-amber-100 text-xs text-slate-700 leading-relaxed space-y-1">
                                                    <p><strong>Places &amp; Sights:</strong> bank, station, tourist office, museum, hotel, art gallery, shopping centre, zoo, abbey, castle, aquarium.</p>
                                                    <p><strong>Hotel &amp; Train Terms:</strong> single room, double room, shower, bath, nights, rate of exchange, pounds, francs, marks, lire, pesetas, dollars, yen, single ticket, return ticket.</p>
                                                    <p><strong>Core Expressions:</strong> times, prices, directions (turn left/right, walk straight, opposite, at the corner of).</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- HIGH RESOLUTION MODAL VIEWER FOR ORIGINAL WORKSHEETS & TEACHER RULES -->
                            <div x-show="activeModal" x-cloak class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/80 backdrop-blur-sm" @click.self="activeModal = null">
                                <div class="bg-white rounded-3xl max-w-4xl w-full max-h-[90vh] flex flex-col shadow-2xl overflow-hidden">
                                    <!-- Modal Header -->
                                    <div class="px-6 py-4 border-b border-slate-200 flex items-center justify-between bg-slate-50">
                                        <div class="font-black text-slate-900 text-sm sm:text-base flex items-center gap-2">
                                            <span>📄</span>
                                            <span x-text="{
                                                'map': 'Town Map (Authentic Worksheet)',
                                                'desks': 'Information Desks Master Sheet',
                                                'sheet_a': 'Tourist Sheet A (Route 1)',
                                                'sheet_b': 'Tourist Sheet B (Route 2)',
                                                'sheet_c': 'Tourist Sheet C (Route 3)',
                                                'sheet_d': 'Tourist Sheet D (Route 4)',
                                                'sheet_e': 'Tourist Sheet E (Route 5)',
                                                'sheet_f': 'Tourist Sheet F (Route 6)',
                                                'sheet_g': 'Tourist Sheet G (Route 7)',
                                                'teacher_rules_1': 'Teacher\'s Book Rules (Page 1) • Wandering Tourists',
                                                'teacher_rules_2': 'Teacher\'s Book Rules (Page 2) • Wandering Tourists'
                                            }[activeModal] || 'Worksheet Viewer'"></span>
                                        </div>
                                        <button type="button" @click="activeModal = null" class="w-8 h-8 rounded-full bg-slate-200 hover:bg-slate-300 text-slate-700 font-bold flex items-center justify-center text-sm transition-all">
                                            ✕
                                        </button>
                                    </div>

                                    <!-- Modal Image Body -->
                                    <div class="p-4 overflow-y-auto flex items-center justify-center bg-slate-900">
                                        <template x-if="activeModal === 'map'">
                                            <div class="space-y-4 w-full flex flex-col items-center">
                                                <div class="flex items-center gap-2 bg-slate-800 p-1.5 rounded-2xl border border-slate-700">
                                                    <button type="button" @click="mapMode = '3d'" 
                                                        :class="mapMode === '3d' ? 'bg-sky-500 text-white font-black shadow-sm' : 'text-slate-300 hover:text-white font-bold'"
                                                        class="px-4 py-1.5 rounded-xl text-xs transition-all flex items-center gap-1.5">
                                                        <span>✨ 3D Vibrant Map</span>
                                                    </button>
                                                    <button type="button" @click="mapMode = 'bw'" 
                                                        :class="mapMode === 'bw' ? 'bg-sky-500 text-white font-black shadow-sm' : 'text-slate-300 hover:text-white font-bold'"
                                                        class="px-4 py-1.5 rounded-xl text-xs transition-all flex items-center gap-1.5">
                                                        <span>📄 Authentic B&amp;W Map</span>
                                                    </button>
                                                </div>
                                                <img :src="mapMode === '3d' ? '{{ asset('images/speaking/worksheet4/town_map_3d_vibrant.png') }}' : '{{ asset('images/speaking/worksheet4/town_map_bw.png') }}'" class="max-w-full max-h-[70vh] object-contain rounded-2xl shadow-2xl border border-slate-700">
                                            </div>
                                        </template>
                                        <template x-if="activeModal === 'desks'">
                                            <img src="{{ asset('images/speaking/worksheet4/information_desks.png') }}" class="max-w-full max-h-[75vh] object-contain rounded-xl shadow-md">
                                        </template>
                                        <template x-if="activeModal === 'sheet_a'">
                                            <img src="{{ asset('images/speaking/worksheet4/student_sheet_a.png') }}" class="max-w-full max-h-[75vh] object-contain rounded-xl shadow-md">
                                        </template>
                                        <template x-if="activeModal === 'sheet_b'">
                                            <img src="{{ asset('images/speaking/worksheet4/student_sheet_b.png') }}" class="max-w-full max-h-[75vh] object-contain rounded-xl shadow-md">
                                        </template>
                                        <template x-if="activeModal === 'sheet_c'">
                                            <img src="{{ asset('images/speaking/worksheet4/student_sheet_c.png') }}" class="max-w-full max-h-[75vh] object-contain rounded-xl shadow-md">
                                        </template>
                                        <template x-if="activeModal === 'sheet_d'">
                                            <img src="{{ asset('images/speaking/worksheet4/student_sheet_d.png') }}" class="max-w-full max-h-[75vh] object-contain rounded-xl shadow-md">
                                        </template>
                                        <template x-if="activeModal === 'sheet_e'">
                                            <img src="{{ asset('images/speaking/worksheet4/student_sheet_e.png') }}" class="max-w-full max-h-[75vh] object-contain rounded-xl shadow-md">
                                        </template>
                                        <template x-if="activeModal === 'sheet_f'">
                                            <img src="{{ asset('images/speaking/worksheet4/student_sheet_f.png') }}" class="max-w-full max-h-[75vh] object-contain rounded-xl shadow-md">
                                        </template>
                                        <template x-if="activeModal === 'sheet_g'">
                                            <img src="{{ asset('images/speaking/worksheet4/student_sheet_g.png') }}" class="max-w-full max-h-[75vh] object-contain rounded-xl shadow-md">
                                        </template>
                                        <template x-if="activeModal === 'teacher_rules_1'">
                                            <img src="{{ asset('images/speaking/worksheet4/teacher_rules_page1.png') }}" class="max-w-full max-h-[75vh] object-contain rounded-xl shadow-md">
                                        </template>
                                        <template x-if="activeModal === 'teacher_rules_2'">
                                            <img src="{{ asset('images/speaking/worksheet4/teacher_rules_page2.png') }}" class="max-w-full max-h-[75vh] object-contain rounded-xl shadow-md">
                                        </template>
                                    </div>

                                    <!-- Modal Footer -->
                                    <div class="px-6 py-3 bg-white border-t border-slate-200 flex items-center justify-between text-xs text-slate-500 font-bold">
                                        <span>Gunakan zoom browser untuk membaca teks dengan lebih detail.</span>
                                        <button type="button" @click="activeModal = null" class="px-4 py-1.5 rounded-xl bg-sky-500 text-white font-black hover:bg-sky-600 transition-all">
                                            Tutup
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @elseif(isset($gameData['type']) && $gameData['type'] === 'wedding_photos')
                        <!-- ==================================================== -->
                        <!-- MEETING 5: WORKSHEET 6 WEDDING PHOTOS (PAIRWORK)     -->
                        <!-- ==================================================== -->
                        <div class="space-y-6" x-data="weddingPhotosGame()">

                            <!-- 1. SIGNATURE HERO SHOWCASE HEADER -->
                            <div style="background-color: #29a8f5 !important;" class="rounded-[2.5rem] p-6 sm:p-10 text-white shadow-xl relative overflow-hidden">
                                <div class="relative z-10 mb-6 flex flex-col md:flex-row md:items-center justify-between gap-4">
                                    <div>
                                        <div class="flex items-center gap-2 mb-1 flex-wrap">
                                            <span class="px-3.5 py-1 rounded-full bg-white/20 text-xs font-black uppercase tracking-wider text-white backdrop-blur-md">
                                                Worksheet 6 Game • Pairwork Speaking
                                            </span>
                                            <span class="px-3 py-1 rounded-full bg-amber-400 text-slate-950 text-xs font-black uppercase">
                                                Information Gap
                                            </span>
                                            <span class="px-3 py-1 rounded-full bg-emerald-400 text-slate-950 text-xs font-black uppercase">
                                                {{ $participationBadge['icon'] }} {{ $participationBadge['label'] }}
                                            </span>
                                        </div>
                                        <h2 class="text-2xl sm:text-4xl font-black tracking-tight mt-1 text-white">Wedding Photos (Foto Pernikahan)</h2>
                                        <p class="text-xs sm:text-sm text-sky-100 font-medium mt-1 max-w-3xl leading-relaxed">
                                            Saudara perempuan Siswa A (<strong>Ann</strong>) menikah dengan saudara laki-laki Siswa B (<strong>Tim</strong>). Tanyakan <em>"Who's that?"</em> dan jawab <em>"That's... She's/He's my..."</em> untuk melengkapi seluruh nama keluarga pada foto pernikahan!
                                        </p>
                                    </div>
                                    
                                    <button @click="activeModal = 'photo_full'" type="button" class="px-5 py-3 rounded-2xl bg-amber-400 hover:bg-amber-300 text-slate-950 font-black text-xs sm:text-sm shadow-md transition flex items-center gap-2 shrink-0 self-start md:self-auto">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v6m3-3H7"/></svg>
                                        <span>Perbesar Foto Pernikahan</span>
                                    </button>
                                </div>

                                <!-- Sub-Navigation Buttons Bar inside Hero -->
                                <div class="relative z-10 flex flex-wrap items-center gap-2 bg-white/15 backdrop-blur-md p-2 rounded-2xl border border-white/25">
                                    <button @click="gameTab = 'worksheet'"
                                        :class="gameTab === 'worksheet' ? 'bg-white text-slate-900 font-black shadow-md' : 'text-white hover:bg-white/15 font-bold'"
                                        class="px-4 py-2 rounded-xl text-xs sm:text-sm transition flex items-center gap-1.5">
                                        <span>🖼️</span> <span>1. Lembar Foto &amp; Isi Nama</span>
                                    </button>
                                    <button @click="gameTab = 'student_a'"
                                        :class="gameTab === 'student_a' ? 'bg-white text-indigo-900 font-black shadow-md' : 'text-white hover:bg-white/15 font-bold'"
                                        class="px-4 py-2 rounded-xl text-xs sm:text-sm transition flex items-center gap-1.5">
                                        <span>👰</span> <span>2. Kartu Siswa A (Bride's Tree)</span>
                                    </button>
                                    <button @click="gameTab = 'student_b'"
                                        :class="gameTab === 'student_b' ? 'bg-white text-orange-900 font-black shadow-md' : 'text-white hover:bg-white/15 font-bold'"
                                        class="px-4 py-2 rounded-xl text-xs sm:text-sm transition flex items-center gap-1.5">
                                        <span>🤵</span> <span>3. Kartu Siswa B (Groom's Tree)</span>
                                    </button>
                                    <button @click="gameTab = 'phrases'"
                                        :class="gameTab === 'phrases' ? 'bg-white text-slate-900 font-black shadow-md' : 'text-white hover:bg-white/15 font-bold'"
                                        class="px-4 py-2 rounded-xl text-xs sm:text-sm transition flex items-center gap-1.5">
                                        <span>💬</span> <span>4. Pola Percakapan &amp; Audio</span>
                                    </button>
                                    <button @click="gameTab = 'guide'"
                                        :class="gameTab === 'guide' ? 'bg-white text-slate-900 font-black shadow-md' : 'text-white hover:bg-white/15 font-bold'"
                                        class="px-4 py-2 rounded-xl text-xs sm:text-sm transition flex items-center gap-1.5">
                                        <span>📖</span> <span>5. Panduan Tutor / Guru</span>
                                    </button>
                                </div>
                            </div>

                            <!-- ==================================================== -->
                            <!-- TAB 1: INTERACTIVE WEDDING PHOTO & NAME FILLING     -->
                            <!-- ==================================================== -->
                            <div x-show="gameTab === 'worksheet'" class="space-y-6 w-full">
                                
                                <!-- Quick Instruction Banner -->
                                <div class="p-4 rounded-2xl bg-gradient-to-r from-sky-50 via-indigo-50 to-amber-50 border border-sky-200/80 flex flex-col sm:flex-row sm:items-center justify-between gap-3 shadow-sm">
                                    <div class="flex items-center gap-3">
                                        <span class="text-3xl shrink-0">🎯</span>
                                        <div>
                                            <div class="font-black text-slate-900 text-xs sm:text-sm flex items-center gap-2 flex-wrap">
                                                <span>Misi Game (Wedding Photo Identification):</span>
                                                <span class="px-2 py-0.5 rounded-full bg-amber-400 text-slate-950 text-[10px] font-black uppercase">Pairwork Gap</span>
                                            </div>
                                            <p class="text-[11px] sm:text-xs text-slate-600 mt-0.5 leading-relaxed">
                                                Tanyakan anggota keluarga lawan bicaramu menggunakan frasa: <em>"Who's that (man with moustache / woman in hat)?"</em>. Lawan bicaramu akan menjawab <em>"That's [Name]. She's/He's my [Relation]."</em> Lalu ketikkan namanya di kotak yang tersedia di bawah!
                                            </p>
                                        </div>
                                    </div>
                                    <div class="flex items-center gap-2 self-start sm:self-auto shrink-0">
                                        <button type="button" @click="activeModal = 'photo_full'" class="px-3.5 py-2 rounded-xl bg-sky-600 hover:bg-sky-700 text-white text-xs font-black transition flex items-center gap-1.5 shadow-sm">
                                            <span>🔍</span> <span>Lihat Foto Full</span>
                                        </button>
                                        <button type="button" @click="activeModal = 'trees_full'" class="px-3.5 py-2 rounded-xl bg-slate-900 hover:bg-slate-800 text-white text-xs font-black transition flex items-center gap-1.5 shadow-sm">
                                            <span>🌳</span> <span>Lihat Pohon Keluarga</span>
                                        </button>
                                    </div>
                                </div>

                                <!-- 📸 BIG FULL-WIDTH WEDDING PHOTO SHOWCASE -->
                                <div class="w-full bg-white rounded-3xl p-5 sm:p-7 border border-slate-200 shadow-md space-y-4">
                                    <!-- Photo Header with Toggle Buttons -->
                                    <div class="flex flex-col sm:flex-row sm:items-center justify-between pb-4 border-b border-slate-100 gap-3">
                                        <div>
                                            <div class="flex items-center gap-2">
                                                <h3 class="font-black text-slate-900 text-lg sm:text-xl flex items-center gap-2">
                                                    <span>📸</span> <span>The Big Wedding Photograph</span>
                                                </h3>
                                                <span class="px-3 py-0.5 rounded-full bg-blue-100 text-blue-700 text-xs font-black">16 Karakter</span>
                                            </div>
                                            <p class="text-xs text-slate-500 mt-0.5">Foto pernikahan keluarga besar pengantin wanita (Ann) &amp; pengantin pria (Tim)</p>
                                        </div>

                                        <!-- Color / Sketch Mode Switcher -->
                                        <div class="flex items-center gap-2 flex-wrap">
                                            <div class="bg-slate-100 p-1 rounded-2xl flex items-center gap-1 border border-slate-200 text-xs">
                                                <button type="button" @click="photoMode = 'color'"
                                                    :class="photoMode === 'color' ? 'bg-gradient-to-r from-pink-500 to-indigo-600 text-white font-black shadow-sm' : 'text-slate-600 hover:text-slate-900 font-bold'"
                                                    class="px-3 py-1.5 rounded-xl transition flex items-center gap-1">
                                                    <span>🎨</span> <span>Foto Berwarna HD</span>
                                                </button>
                                                <button type="button" @click="photoMode = 'sketch'"
                                                    :class="photoMode === 'sketch' ? 'bg-slate-900 text-white font-black shadow-sm' : 'text-slate-600 hover:text-slate-900 font-bold'"
                                                    class="px-3 py-1.5 rounded-xl transition flex items-center gap-1">
                                                    <span>✏️</span> <span>Sketsa Hitam Putih</span>
                                                </button>
                                            </div>
                                            <button type="button" @click="activeModal = 'photo_full'" class="px-3.5 py-2 rounded-xl bg-amber-400 hover:bg-amber-300 text-slate-950 text-xs font-black transition flex items-center gap-1 shadow-sm">
                                                <span>🔍</span> <span>Zoom</span>
                                            </button>
                                        </div>
                                    </div>

                                    <!-- Main Large Image Container with Interactive Input Overlays -->
                                    <div class="relative w-full max-w-5xl mx-auto rounded-3xl overflow-hidden border-2 sm:border-4 border-slate-700 bg-slate-900 shadow-2xl select-none">
                                        <!-- Colored Image -->
                                        <img x-show="photoMode === 'color'"
                                             src="{{ asset('images/speaking/wedding_photos/wedding_photo_hd.jpg?v=14') }}"
                                             alt="Colored Wedding Photo"
                                             class="w-full h-auto block select-none pointer-events-none">
                                        
                                        <!-- Classic Sketch Image -->
                                        <img x-show="photoMode === 'sketch'"
                                             src="{{ asset('images/speaking/wedding_photos/wedding_photo_upright.png') }}"
                                             alt="Sketch Wedding Photo"
                                             class="w-full h-auto block select-none pointer-events-none">

                                                            <!-- Interactive Overlay Layer -->
                    <div class="absolute inset-0 w-full h-full pointer-events-auto">
                        
                        <!-- SISI KIRI: BRIDE'S FAMILY (ANN'S SIDE) -->
                        <!-- 1. Joe (Grandfather - Wall Far Left) -->
                        <input type="text" x-model="inputs.joe" @input="saveToStorage()" placeholder="?" title="1. Kakek Joe (Grandfather)"
                            :class="{
                                'border-emerald-500 bg-emerald-100 text-emerald-950 font-black ring-1 sm:ring-2 ring-emerald-400': isFieldCorrect('joe') === true,
                                'border-rose-500 bg-rose-100 text-rose-950 font-black ring-1 sm:ring-2 ring-rose-400': isFieldCorrect('joe') === false,
                                'border-amber-800/60 bg-amber-100/90 hover:bg-white focus:bg-white text-slate-900': isFieldCorrect('joe') === null
                            }"
                            class="absolute text-center font-black uppercase text-[7px] sm:text-[10px] md:text-xs px-0.5 rounded sm:rounded-md border shadow-xs focus:ring-2 focus:ring-blue-500 focus:outline-none transition z-10"
                            style="top: 16.3%; left: 3.6%; width: 5.5%; height: 3.8%;">

                        <!-- 2. Pete (Uncle - Wall Top Left 2) -->
                        <input type="text" x-model="inputs.pete" @input="saveToStorage()" placeholder="?" title="5. Paman Pete (Uncle)"
                            :class="{
                                'border-emerald-500 bg-emerald-100 text-emerald-950 font-black ring-1 sm:ring-2 ring-emerald-400': isFieldCorrect('pete') === true,
                                'border-rose-500 bg-rose-100 text-rose-950 font-black ring-1 sm:ring-2 ring-rose-400': isFieldCorrect('pete') === false,
                                'border-amber-800/60 bg-amber-100/90 hover:bg-white focus:bg-white text-slate-900': isFieldCorrect('pete') === null
                            }"
                            class="absolute text-center font-black uppercase text-[7px] sm:text-[10px] md:text-xs px-0.5 rounded sm:rounded-md border shadow-xs focus:ring-2 focus:ring-blue-500 focus:outline-none transition z-10"
                            style="top: 14.5%; left: 13.8%; width: 5.5%; height: 3.8%;">

                        <!-- 3. Jess (Mother - Wall Above Jess) -->
                        <input type="text" x-model="inputs.jess" @input="saveToStorage()" placeholder="?" title="4. Ibu Jess (Mother)"
                            :class="{
                                'border-emerald-500 bg-emerald-100 text-emerald-950 font-black ring-1 sm:ring-2 ring-emerald-400': isFieldCorrect('jess') === true,
                                'border-rose-500 bg-rose-100 text-rose-950 font-black ring-1 sm:ring-2 ring-rose-400': isFieldCorrect('jess') === false,
                                'border-amber-800/60 bg-amber-100/90 hover:bg-white focus:bg-white text-slate-900': isFieldCorrect('jess') === null
                            }"
                            class="absolute text-center font-black uppercase text-[7px] sm:text-[10px] md:text-xs px-0.5 rounded sm:rounded-md border shadow-xs focus:ring-2 focus:ring-blue-500 focus:outline-none transition z-10"
                            style="top: 28.2%; left: 21.8%; width: 5.2%; height: 3.8%;">

                        <!-- 4. Tom (Father - Wall Near Arch) -->
                        <input type="text" x-model="inputs.tom" @input="saveToStorage()" placeholder="?" title="3. Ayah Tom (Father)"
                            :class="{
                                'border-emerald-500 bg-emerald-100 text-emerald-950 font-black ring-1 sm:ring-2 ring-emerald-400': isFieldCorrect('tom') === true,
                                'border-rose-500 bg-rose-100 text-rose-950 font-black ring-1 sm:ring-2 ring-rose-400': isFieldCorrect('tom') === false,
                                'border-amber-800/60 bg-amber-100/90 hover:bg-white focus:bg-white text-slate-900': isFieldCorrect('tom') === null
                            }"
                            class="absolute text-center font-black uppercase text-[7px] sm:text-[10px] md:text-xs px-0.5 rounded sm:rounded-md border shadow-xs focus:ring-2 focus:ring-blue-500 focus:outline-none transition z-10"
                            style="top: 25.1%; left: 27.9%; width: 5.2%; height: 3.8%;">

                        <!-- 5. Elsie (Grandmother - Floor Far Left) -->
                        <input type="text" x-model="inputs.elsie" @input="saveToStorage()" placeholder="?" title="2. Nenek Elsie (Grandmother)"
                            :class="{
                                'border-emerald-500 bg-emerald-100 text-emerald-950 font-black ring-1 sm:ring-2 ring-emerald-400': isFieldCorrect('elsie') === true,
                                'border-rose-500 bg-rose-100 text-rose-950 font-black ring-1 sm:ring-2 ring-rose-400': isFieldCorrect('elsie') === false,
                                'border-amber-800/60 bg-amber-100/90 hover:bg-white focus:bg-white text-slate-900': isFieldCorrect('elsie') === null
                            }"
                            class="absolute text-center font-black uppercase text-[7px] sm:text-[10px] md:text-xs px-0.5 rounded sm:rounded-md border shadow-xs focus:ring-2 focus:ring-blue-500 focus:outline-none transition z-10"
                            style="top: 92.0%; left: 3.4%; width: 5.5%; height: 3.8%;">

                        <!-- 6. Sue (Aunt - Floor Left 2) -->
                        <input type="text" x-model="inputs.sue" @input="saveToStorage()" placeholder="?" title="6. Bibi Sue (Aunt)"
                            :class="{
                                'border-emerald-500 bg-emerald-100 text-emerald-950 font-black ring-1 sm:ring-2 ring-emerald-400': isFieldCorrect('sue') === true,
                                'border-rose-500 bg-rose-100 text-rose-950 font-black ring-1 sm:ring-2 ring-rose-400': isFieldCorrect('sue') === false,
                                'border-amber-800/60 bg-amber-100/90 hover:bg-white focus:bg-white text-slate-900': isFieldCorrect('sue') === null
                            }"
                            class="absolute text-center font-black uppercase text-[7px] sm:text-[10px] md:text-xs px-0.5 rounded sm:rounded-md border shadow-xs focus:ring-2 focus:ring-blue-500 focus:outline-none transition z-10"
                            style="top: 92.2%; left: 10.8%; width: 5.8%; height: 3.8%;">

                        <!-- 7. Sam (Flower Girl / Sister - Floor Left 3) -->
                        <input type="text" x-model="inputs.sam" @input="saveToStorage()" placeholder="?" title="7. Saudara Sam (Flower Girl)"
                            :class="{
                                'border-emerald-500 bg-emerald-100 text-emerald-950 font-black ring-1 sm:ring-2 ring-emerald-400': isFieldCorrect('sam') === true,
                                'border-rose-500 bg-rose-100 text-rose-950 font-black ring-1 sm:ring-2 ring-rose-400': isFieldCorrect('sam') === false,
                                'border-amber-800/60 bg-amber-100/90 hover:bg-white focus:bg-white text-slate-900': isFieldCorrect('sam') === null
                            }"
                            class="absolute text-center font-black uppercase text-[7px] sm:text-[10px] md:text-xs px-0.5 rounded sm:rounded-md border shadow-xs focus:ring-2 focus:ring-blue-500 focus:outline-none transition z-10"
                            style="top: 93.6%; left: 20.8%; width: 5.6%; height: 3.8%;">

                        <!-- 8. Mike (Cousin - Floor Left 4) -->
                        <input type="text" x-model="inputs.mike" @input="saveToStorage()" placeholder="?" title="8. Sepupu Mike (Cousin)"
                            :class="{
                                'border-emerald-500 bg-emerald-100 text-emerald-950 font-black ring-1 sm:ring-2 ring-emerald-400': isFieldCorrect('mike') === true,
                                'border-rose-500 bg-rose-100 text-rose-950 font-black ring-1 sm:ring-2 ring-rose-400': isFieldCorrect('mike') === false,
                                'border-amber-800/60 bg-amber-100/90 hover:bg-white focus:bg-white text-slate-900': isFieldCorrect('mike') === null
                            }"
                            class="absolute text-center font-black uppercase text-[7px] sm:text-[10px] md:text-xs px-0.5 rounded sm:rounded-md border shadow-xs focus:ring-2 focus:ring-blue-500 focus:outline-none transition z-10"
                            style="top: 91.7%; left: 34.6%; width: 5.8%; height: 3.8%;">

                        <!-- SISI KANAN: GROOM'S FAMILY (TIM'S SIDE) -->
                        <!-- 9. Betty (Grandmother - Wall Near Arch Right) -->
                        <input type="text" x-model="inputs.betty" @input="saveToStorage()" placeholder="?" title="2. Nenek Betty (Grandmother)"
                            :class="{
                                'border-emerald-500 bg-emerald-100 text-emerald-950 font-black ring-1 sm:ring-2 ring-emerald-400': isFieldCorrect('betty') === true,
                                'border-rose-500 bg-rose-100 text-rose-950 font-black ring-1 sm:ring-2 ring-rose-400': isFieldCorrect('betty') === false,
                                'border-amber-800/60 bg-amber-100/90 hover:bg-white focus:bg-white text-slate-900': isFieldCorrect('betty') === null
                            }"
                            class="absolute text-center font-black uppercase text-[7px] sm:text-[10px] md:text-xs px-0.5 rounded sm:rounded-md border shadow-xs focus:ring-2 focus:ring-blue-500 focus:outline-none transition z-10"
                            style="top: 23.8%; left: 63.6%; width: 5.2%; height: 3.8%;">

                        <!-- 10. Jim (Grandfather - Wall Notice Board Right) -->
                        <input type="text" x-model="inputs.jim" @input="saveToStorage()" placeholder="?" title="1. Kakek Jim (Grandfather)"
                            :class="{
                                'border-emerald-500 bg-emerald-100 text-emerald-950 font-black ring-1 sm:ring-2 ring-emerald-400': isFieldCorrect('jim') === true,
                                'border-rose-500 bg-rose-100 text-rose-950 font-black ring-1 sm:ring-2 ring-rose-400': isFieldCorrect('jim') === false,
                                'border-amber-800/60 bg-amber-100/90 hover:bg-white focus:bg-white text-slate-900': isFieldCorrect('jim') === null
                            }"
                            class="absolute text-center font-black uppercase text-[7px] sm:text-[10px] md:text-xs px-0.5 rounded sm:rounded-md border shadow-xs focus:ring-2 focus:ring-blue-500 focus:outline-none transition z-10"
                            style="top: 16.6%; left: 74.9%; width: 5.6%; height: 3.8%;">

                        <!-- 11. Al (Father - Wall Top Right 2) -->
                        <input type="text" x-model="inputs.al" @input="saveToStorage()" placeholder="?" title="3. Ayah Al (Father)"
                            :class="{
                                'border-emerald-500 bg-emerald-100 text-emerald-950 font-black ring-1 sm:ring-2 ring-emerald-400': isFieldCorrect('al') === true,
                                'border-rose-500 bg-rose-100 text-rose-950 font-black ring-1 sm:ring-2 ring-rose-400': isFieldCorrect('al') === false,
                                'border-amber-800/60 bg-amber-100/90 hover:bg-white focus:bg-white text-slate-900': isFieldCorrect('al') === null
                            }"
                            class="absolute text-center font-black uppercase text-[7px] sm:text-[10px] md:text-xs px-0.5 rounded sm:rounded-md border shadow-xs focus:ring-2 focus:ring-blue-500 focus:outline-none transition z-10"
                            style="top: 20.2%; left: 84.6%; width: 5.6%; height: 3.8%;">

                        <!-- 12. Jane (Mother - Wall Top Far Right) -->
                        <input type="text" x-model="inputs.jane" @input="saveToStorage()" placeholder="?" title="4. Ibu Jane (Mother)"
                            :class="{
                                'border-emerald-500 bg-emerald-100 text-emerald-950 font-black ring-1 sm:ring-2 ring-emerald-400': isFieldCorrect('jane') === true,
                                'border-rose-500 bg-rose-100 text-rose-950 font-black ring-1 sm:ring-2 ring-rose-400': isFieldCorrect('jane') === false,
                                'border-amber-800/60 bg-amber-100/90 hover:bg-white focus:bg-white text-slate-900': isFieldCorrect('jane') === null
                            }"
                            class="absolute text-center font-black uppercase text-[7px] sm:text-[10px] md:text-xs px-0.5 rounded sm:rounded-md border shadow-xs focus:ring-2 focus:ring-blue-500 focus:outline-none transition z-10"
                            style="top: 27.9%; left: 92.0%; width: 5.6%; height: 3.8%;">

                        <!-- 13. John (Page Boy / Cousin - Floor Center Right) -->
                        <input type="text" x-model="inputs.john" @input="saveToStorage()" placeholder="?" title="8. Sepupu John (Page Boy)"
                            :class="{
                                'border-emerald-500 bg-emerald-100 text-emerald-950 font-black ring-1 sm:ring-2 ring-emerald-400': isFieldCorrect('john') === true,
                                'border-rose-500 bg-rose-100 text-rose-950 font-black ring-1 sm:ring-2 ring-rose-400': isFieldCorrect('john') === false,
                                'border-amber-800/60 bg-amber-100/90 hover:bg-white focus:bg-white text-slate-900': isFieldCorrect('john') === null
                            }"
                            class="absolute text-center font-black uppercase text-[7px] sm:text-[10px] md:text-xs px-0.5 rounded sm:rounded-md border shadow-xs focus:ring-2 focus:ring-blue-500 focus:outline-none transition z-10"
                            style="top: 94.1%; left: 60.3%; width: 5.6%; height: 3.8%;">

                        <!-- 14. Ben (Uncle - Floor Right 1) -->
                        <input type="text" x-model="inputs.ben" @input="saveToStorage()" placeholder="?" title="5. Paman Ben (Uncle)"
                            :class="{
                                'border-emerald-500 bg-emerald-100 text-emerald-950 font-black ring-1 sm:ring-2 ring-emerald-400': isFieldCorrect('ben') === true,
                                'border-rose-500 bg-rose-100 text-rose-950 font-black ring-1 sm:ring-2 ring-rose-400': isFieldCorrect('ben') === false,
                                'border-amber-800/60 bg-amber-100/90 hover:bg-white focus:bg-white text-slate-900': isFieldCorrect('ben') === null
                            }"
                            class="absolute text-center font-black uppercase text-[7px] sm:text-[10px] md:text-xs px-0.5 rounded sm:rounded-md border shadow-xs focus:ring-2 focus:ring-blue-500 focus:outline-none transition z-10"
                            style="top: 86.9%; left: 69.7%; width: 5.6%; height: 3.8%;">

                        <!-- 15. Liz (Aunt - Floor Right 2) -->
                        <input type="text" x-model="inputs.liz" @input="saveToStorage()" placeholder="?" title="6. Bibi Liz (Aunt)"
                            :class="{
                                'border-emerald-500 bg-emerald-100 text-emerald-950 font-black ring-1 sm:ring-2 ring-emerald-400': isFieldCorrect('liz') === true,
                                'border-rose-500 bg-rose-100 text-rose-950 font-black ring-1 sm:ring-2 ring-rose-400': isFieldCorrect('liz') === false,
                                'border-amber-800/60 bg-amber-100/90 hover:bg-white focus:bg-white text-slate-900': isFieldCorrect('liz') === null
                            }"
                            class="absolute text-center font-black uppercase text-[7px] sm:text-[10px] md:text-xs px-0.5 rounded sm:rounded-md border shadow-xs focus:ring-2 focus:ring-blue-500 focus:outline-none transition z-10"
                            style="top: 88.6%; left: 76.6%; width: 5.4%; height: 3.8%;">

                        <!-- 16. Beth (Sister - Floor Right 3) -->
                        <input type="text" x-model="inputs.beth" @input="saveToStorage()" placeholder="?" title="7. Saudara Beth (Sister)"
                            :class="{
                                'border-emerald-500 bg-emerald-100 text-emerald-950 font-black ring-1 sm:ring-2 ring-emerald-400': isFieldCorrect('beth') === true,
                                'border-rose-500 bg-rose-100 text-rose-950 font-black ring-1 sm:ring-2 ring-rose-400': isFieldCorrect('beth') === false,
                                'border-amber-800/60 bg-amber-100/90 hover:bg-white focus:bg-white text-slate-900': isFieldCorrect('beth') === null
                            }"
                            class="absolute text-center font-black uppercase text-[7px] sm:text-[10px] md:text-xs px-0.5 rounded sm:rounded-md border shadow-xs focus:ring-2 focus:ring-blue-500 focus:outline-none transition z-10"
                            style="top: 93.1%; left: 84.4%; width: 5.8%; height: 3.8%;">
                    </div>
                </div>
                            </div>

                            <!-- 🌳 2-COLUMN FAMILY TREES (BRIDE'S SIDE VS GROOM'S SIDE) -->
                                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 items-stretch w-full">
                                    
                                    <!-- Column 1: Family Tree A (Bride's Family - Ann's Side) -->
                                    <div class="w-full bg-white rounded-3xl p-5 sm:p-6 border-2 border-indigo-200 shadow-sm flex flex-col justify-between space-y-4">
                                        <div class="flex items-center justify-between pb-3 border-b border-indigo-100 gap-2">
                                            <div class="flex items-center gap-2.5">
                                                <span class="w-8 h-8 rounded-xl bg-indigo-600 text-white font-black text-sm flex items-center justify-center shrink-0">A</span>
                                                <div>
                                                    <h4 class="font-black text-slate-900 text-sm sm:text-base">Pohon Keluarga A (Bride - Ann's Side)</h4>
                                                    <p class="text-[11px] text-indigo-700 font-semibold">Keluarga Siswa A • Gunakan untuk menjawab Siswa B</p>
                                                </div>
                                            </div>
                                            <button type="button" @click="activeModal = 'tree_a_full'" class="px-3 py-1.5 rounded-xl bg-indigo-50 hover:bg-indigo-600 hover:text-white text-indigo-700 text-xs font-black transition flex items-center gap-1 shadow-2xs shrink-0">
                                                <span>🔍</span> <span>Perbesar Pohon A</span>
                                            </button>
                                        </div>

                                        <!-- Image Container Tree A -->
                                        <div class="bg-indigo-50/40 rounded-2xl p-3 sm:p-4 border border-indigo-100 flex items-center justify-center cursor-pointer hover:border-indigo-400 transition group flex-1 min-h-[360px]" @click="activeModal = 'tree_a_full'">
                                            <img x-show="photoMode === 'color'"
                                                 src="{{ asset('images/speaking/wedding_photos/family_tree_a_hd.jpg?v=13') }}"
                                                 alt="Family Tree A (Bride's Family)"
                                                 class="max-h-[440px] w-auto max-w-full object-contain rounded-xl group-hover:scale-[1.01] transition-transform duration-200 shadow-xs">
                                            <img x-show="photoMode === 'sketch'"
                                                 src="{{ asset('images/speaking/wedding_photos/family_tree_a.png') }}"
                                                 alt="Family Tree A (Bride's Family)"
                                                 class="max-h-[440px] w-auto max-w-full object-contain rounded-xl group-hover:scale-[1.01] transition-transform duration-200 shadow-xs">
                                        </div>

                                        <!-- Quick Info Footer A -->
                                        <div class="p-3 rounded-2xl bg-indigo-50/80 border border-indigo-200 text-xs text-indigo-950 flex items-center justify-between">
                                            <div class="flex items-center gap-2">
                                                <span>👰</span>
                                                <span class="font-bold">Anggota: Joe, Elsie, Tom, Jess, Pete, Sue, Sam, Mike, Ann</span>
                                            </div>
                                            <button type="button" @click="gameTab = 'student_a'" class="text-xs font-black text-indigo-600 hover:underline shrink-0">
                                                Latihan Audio →
                                            </button>
                                        </div>
                                    </div>

                                    <!-- Column 2: Family Tree B (Groom's Family - Tim's Side) -->
                                    <div class="w-full bg-white rounded-3xl p-5 sm:p-6 border-2 border-orange-200 shadow-sm flex flex-col justify-between space-y-4">
                                        <div class="flex items-center justify-between pb-3 border-b border-orange-100 gap-2">
                                            <div class="flex items-center gap-2.5">
                                                <span class="w-8 h-8 rounded-xl bg-orange-600 text-white font-black text-sm flex items-center justify-center shrink-0">B</span>
                                                <div>
                                                    <h4 class="font-black text-slate-900 text-sm sm:text-base">Pohon Keluarga B (Groom - Tim's Side)</h4>
                                                    <p class="text-[11px] text-orange-700 font-semibold">Keluarga Siswa B • Gunakan untuk menjawab Siswa A</p>
                                                </div>
                                            </div>
                                            <button type="button" @click="activeModal = 'tree_b_full'" class="px-3 py-1.5 rounded-xl bg-orange-50 hover:bg-orange-600 hover:text-white text-orange-700 text-xs font-black transition flex items-center gap-1 shadow-2xs shrink-0">
                                                <span>🔍</span> <span>Perbesar Pohon B</span>
                                            </button>
                                        </div>

                                        <!-- Image Container Tree B -->
                                        <div class="bg-orange-50/40 rounded-2xl p-3 sm:p-4 border border-orange-100 flex items-center justify-center cursor-pointer hover:border-orange-400 transition group flex-1 min-h-[360px]" @click="activeModal = 'tree_b_full'">
                                            <img x-show="photoMode === 'color'"
                                                 src="{{ asset('images/speaking/wedding_photos/family_tree_b_hd.jpg?v=14') }}"
                                                 alt="Family Tree B (Groom's Family)"
                                                 class="max-h-[440px] w-auto max-w-full object-contain rounded-xl group-hover:scale-[1.01] transition-transform duration-200 shadow-xs">
                                            <img x-show="photoMode === 'sketch'"
                                                 src="{{ asset('images/speaking/wedding_photos/family_tree_b.png') }}"
                                                 alt="Family Tree B (Groom's Family)"
                                                 class="max-h-[440px] w-auto max-w-full object-contain rounded-xl group-hover:scale-[1.01] transition-transform duration-200 shadow-xs">
                                        </div>

                                        <!-- Quick Info Footer B -->
                                        <div class="p-3 rounded-2xl bg-orange-50/80 border border-orange-200 text-xs text-orange-950 flex items-center justify-between">
                                            <div class="flex items-center gap-2">
                                                <span>🤵</span>
                                                <span class="font-bold">Anggota: Jim, Betty, Al, Jane, Ben, Liz, Tim, Beth, John</span>
                                            </div>
                                            <button type="button" @click="gameTab = 'student_b'" class="text-xs font-black text-orange-600 hover:underline shrink-0">
                                                Latihan Audio →
                                            </button>
                                        </div>
                                    </div>
                                </div>

                                <!-- Score & Status Card (Shown if submitted) -->
                                <div x-show="isSubmitted" class="p-5 rounded-3xl transition-all shadow-md flex items-center justify-between"
                                     :class="score >= 70 ? 'bg-gradient-to-r from-emerald-500 to-teal-600 text-white' : 'bg-gradient-to-r from-amber-500 to-orange-600 text-white'">
                                    <div class="flex items-center gap-3">
                                        <span class="text-3xl" x-text="score >= 70 ? '🏆' : '📝'"></span>
                                        <div>
                                            <div class="font-black text-lg sm:text-xl" x-text="score >= 70 ? 'Bagus Sekali!' : 'Terus Berlatih!'"></div>
                                            <div class="text-xs opacity-90">Skor Anda: <span class="font-black text-sm" x-text="score + '%'"></span> (<span x-text="correctCount"></span>/15 benar)</div>
                                        </div>
                                    </div>
                                    <button type="button" @click="showSolutions = !showSolutions" class="px-4 py-2 rounded-xl bg-white/20 hover:bg-white/30 text-white font-black text-xs transition">
                                        <span x-text="showSolutions ? 'Sembunyikan Kunci' : 'Lihat Kunci'"></span>
                                    </button>
                                </div>

                                <!-- Action Buttons Bar -->
                                <div class="flex items-center justify-between gap-3 pt-2">
                                    <button @click="resetWorksheet()" type="button" class="px-5 py-3 rounded-2xl bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-xs transition">
                                        Kosongkan Isian
                                    </button>
                                    <div class="flex items-center gap-2">
                                        <button @click="checkAnswers()" type="button" class="px-7 py-3 rounded-2xl bg-orange-500 hover:bg-orange-600 text-white font-black text-xs sm:text-sm shadow-md transition flex items-center gap-2">
                                            <span>✓</span> <span>Periksa Jawaban Saya</span>
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <!-- ==================================================== -->
                            <!-- TAB 2: STUDENT A CARD (BRIDE'S FAMILY TREE)          -->
                            <!-- ==================================================== -->
                            <div x-show="gameTab === 'student_a'" class="space-y-6">
                                <div class="bg-white rounded-[2rem] p-6 sm:p-8 shadow-sm border-2 border-indigo-200 relative overflow-hidden space-y-6">
                                    
                                    <!-- Secret Card Header -->
                                    <div class="flex flex-col sm:flex-row sm:items-center justify-between pb-4 border-b border-indigo-100 gap-3">
                                        <div class="flex items-center gap-3">
                                            <span class="text-4xl">👰</span>
                                            <div>
                                                <div class="flex items-center gap-2 flex-wrap">
                                                    <span class="px-3 py-0.5 rounded-full bg-indigo-600 text-white text-xs font-black uppercase">
                                                        Role Card • Student A
                                                    </span>
                                                    <span class="px-3 py-0.5 rounded-full bg-amber-400 text-slate-950 text-xs font-black uppercase">
                                                        Bride's Family (Ann's Side)
                                                    </span>
                                                </div>
                                                <h3 class="text-xl sm:text-2xl font-black text-slate-900 mt-1">Family Tree A (Pohon Keluarga Pengantin Wanita)</h3>
                                                <p class="text-xs text-indigo-700 font-semibold mt-0.5">
                                                    🔒 Anda adalah saudara/saudari dari <strong>Ann</strong>! Gunakan pohon keluarga ini untuk menjawab pertanyaan Siswa B.
                                                </p>
                                            </div>
                                        </div>
                                        <button @click="activeModal = 'tree_a_full'" type="button" class="px-4 py-2.5 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white font-black text-xs transition flex items-center gap-1.5 self-start sm:self-auto shadow-sm">
                                            <span>🔍</span> <span>Perbesar Gambar Pohon A</span>
                                        </button>
                                    </div>

                                    <!-- Role Mission Alert Box for Student A -->
                                    <div class="p-4 rounded-2xl bg-indigo-50/80 border-2 border-indigo-200 flex flex-col md:flex-row md:items-center justify-between gap-3 text-xs">
                                        <div class="flex items-start gap-3">
                                            <span class="text-2xl shrink-0">🎯</span>
                                            <div>
                                                <div class="font-black text-indigo-950 text-sm">Instruksi Permainan Siswa A:</div>
                                                <ol class="list-decimal list-inside text-indigo-900 space-y-1 mt-1 font-medium leading-relaxed">
                                                    <li><strong>Jawab Pertanyaan Siswa B:</strong> Saat Siswa B bertanya <em>"Who's that?"</em>, lihat pohon keluarga A di bawah dan jawab <em>"That's [Nama]. She's/He's my [Hubungan]."</em></li>
                                                    <li><strong>Tanyakan Keluarga Siswa B:</strong> Tunjuk orang di sisi kanan foto pernikahan (Keluarga Tim) dan tanyakan <em>"Who's that?"</em> ke Siswa B, lalu isi namanya di <button type="button" @click="gameTab = 'worksheet'" class="text-indigo-700 font-black underline">Lembar Foto (Tab 1)</button>!</li>
                                                </ol>
                                            </div>
                                        </div>
                                        <button @click="gameTab = 'worksheet'" type="button" class="px-4 py-2 rounded-xl bg-white text-indigo-900 font-black border border-indigo-300 hover:bg-indigo-600 hover:text-white transition shrink-0 self-start md:self-auto shadow-xs">
                                            Ke Lembar Foto →
                                        </button>
                                    </div>

                                    <!-- 📸 BIG FULL-WIDTH WEDDING PHOTO SHOWCASE -->
                                <div class="w-full bg-white rounded-3xl p-5 sm:p-7 border border-slate-200 shadow-md space-y-4">
                                    <!-- Photo Header with Toggle Buttons -->
                                    <div class="flex flex-col sm:flex-row sm:items-center justify-between pb-4 border-b border-slate-100 gap-3">
                                        <div>
                                            <div class="flex items-center gap-2">
                                                <h3 class="font-black text-slate-900 text-lg sm:text-xl flex items-center gap-2">
                                                    <span>📸</span> <span>The Big Wedding Photograph</span>
                                                </h3>
                                                <span class="px-3 py-0.5 rounded-full bg-blue-100 text-blue-700 text-xs font-black">16 Karakter</span>
                                            </div>
                                            <p class="text-xs text-slate-500 mt-0.5">Foto pernikahan keluarga besar pengantin wanita (Ann) &amp; pengantin pria (Tim)</p>
                                        </div>

                                        <!-- Color / Sketch Mode Switcher -->
                                        <div class="flex items-center gap-2 flex-wrap">
                                            <div class="bg-slate-100 p-1 rounded-2xl flex items-center gap-1 border border-slate-200 text-xs">
                                                <button type="button" @click="photoMode = 'color'"
                                                    :class="photoMode === 'color' ? 'bg-gradient-to-r from-pink-500 to-indigo-600 text-white font-black shadow-sm' : 'text-slate-600 hover:text-slate-900 font-bold'"
                                                    class="px-3 py-1.5 rounded-xl transition flex items-center gap-1">
                                                    <span>🎨</span> <span>Foto Berwarna HD</span>
                                                </button>
                                                <button type="button" @click="photoMode = 'sketch'"
                                                    :class="photoMode === 'sketch' ? 'bg-slate-900 text-white font-black shadow-sm' : 'text-slate-600 hover:text-slate-900 font-bold'"
                                                    class="px-3 py-1.5 rounded-xl transition flex items-center gap-1">
                                                    <span>✏️</span> <span>Sketsa Hitam Putih</span>
                                                </button>
                                            </div>
                                            <button type="button" @click="activeModal = 'photo_full'" class="px-3.5 py-2 rounded-xl bg-amber-400 hover:bg-amber-300 text-slate-950 text-xs font-black transition flex items-center gap-1 shadow-sm">
                                                <span>🔍</span> <span>Zoom</span>
                                            </button>
                                        </div>
                                    </div>

                                    <!-- Main Large Image Container with Interactive Input Overlays -->
                                    <div class="relative w-full max-w-5xl mx-auto rounded-3xl overflow-hidden border-2 sm:border-4 border-slate-700 bg-slate-900 shadow-2xl select-none">
                                        <!-- Colored Image -->
                                        <img x-show="photoMode === 'color'"
                                             src="{{ asset('images/speaking/wedding_photos/wedding_photo_hd.jpg?v=14') }}"
                                             alt="Colored Wedding Photo"
                                             class="w-full h-auto block select-none pointer-events-none">
                                        
                                        <!-- Classic Sketch Image -->
                                        <img x-show="photoMode === 'sketch'"
                                             src="{{ asset('images/speaking/wedding_photos/wedding_photo_upright.png') }}"
                                             alt="Sketch Wedding Photo"
                                             class="w-full h-auto block select-none pointer-events-none">

                                                            <!-- Interactive Overlay Layer -->
                    <div class="absolute inset-0 w-full h-full pointer-events-auto">
                        
                        <!-- SISI KIRI: BRIDE'S FAMILY (ANN'S SIDE) -->
                        <!-- 1. Joe (Grandfather - Wall Far Left) -->
                        <input type="text" x-model="inputs.joe" @input="saveToStorage()" placeholder="?" title="1. Kakek Joe (Grandfather)"
                            :class="{
                                'border-emerald-500 bg-emerald-100 text-emerald-950 font-black ring-1 sm:ring-2 ring-emerald-400': isFieldCorrect('joe') === true,
                                'border-rose-500 bg-rose-100 text-rose-950 font-black ring-1 sm:ring-2 ring-rose-400': isFieldCorrect('joe') === false,
                                'border-amber-800/60 bg-amber-100/90 hover:bg-white focus:bg-white text-slate-900': isFieldCorrect('joe') === null
                            }"
                            class="absolute text-center font-black uppercase text-[7px] sm:text-[10px] md:text-xs px-0.5 rounded sm:rounded-md border shadow-xs focus:ring-2 focus:ring-blue-500 focus:outline-none transition z-10"
                            style="top: 16.3%; left: 3.6%; width: 5.5%; height: 3.8%;">

                        <!-- 2. Pete (Uncle - Wall Top Left 2) -->
                        <input type="text" x-model="inputs.pete" @input="saveToStorage()" placeholder="?" title="5. Paman Pete (Uncle)"
                            :class="{
                                'border-emerald-500 bg-emerald-100 text-emerald-950 font-black ring-1 sm:ring-2 ring-emerald-400': isFieldCorrect('pete') === true,
                                'border-rose-500 bg-rose-100 text-rose-950 font-black ring-1 sm:ring-2 ring-rose-400': isFieldCorrect('pete') === false,
                                'border-amber-800/60 bg-amber-100/90 hover:bg-white focus:bg-white text-slate-900': isFieldCorrect('pete') === null
                            }"
                            class="absolute text-center font-black uppercase text-[7px] sm:text-[10px] md:text-xs px-0.5 rounded sm:rounded-md border shadow-xs focus:ring-2 focus:ring-blue-500 focus:outline-none transition z-10"
                            style="top: 14.5%; left: 13.8%; width: 5.5%; height: 3.8%;">

                        <!-- 3. Jess (Mother - Wall Above Jess) -->
                        <input type="text" x-model="inputs.jess" @input="saveToStorage()" placeholder="?" title="4. Ibu Jess (Mother)"
                            :class="{
                                'border-emerald-500 bg-emerald-100 text-emerald-950 font-black ring-1 sm:ring-2 ring-emerald-400': isFieldCorrect('jess') === true,
                                'border-rose-500 bg-rose-100 text-rose-950 font-black ring-1 sm:ring-2 ring-rose-400': isFieldCorrect('jess') === false,
                                'border-amber-800/60 bg-amber-100/90 hover:bg-white focus:bg-white text-slate-900': isFieldCorrect('jess') === null
                            }"
                            class="absolute text-center font-black uppercase text-[7px] sm:text-[10px] md:text-xs px-0.5 rounded sm:rounded-md border shadow-xs focus:ring-2 focus:ring-blue-500 focus:outline-none transition z-10"
                            style="top: 28.2%; left: 21.8%; width: 5.2%; height: 3.8%;">

                        <!-- 4. Tom (Father - Wall Near Arch) -->
                        <input type="text" x-model="inputs.tom" @input="saveToStorage()" placeholder="?" title="3. Ayah Tom (Father)"
                            :class="{
                                'border-emerald-500 bg-emerald-100 text-emerald-950 font-black ring-1 sm:ring-2 ring-emerald-400': isFieldCorrect('tom') === true,
                                'border-rose-500 bg-rose-100 text-rose-950 font-black ring-1 sm:ring-2 ring-rose-400': isFieldCorrect('tom') === false,
                                'border-amber-800/60 bg-amber-100/90 hover:bg-white focus:bg-white text-slate-900': isFieldCorrect('tom') === null
                            }"
                            class="absolute text-center font-black uppercase text-[7px] sm:text-[10px] md:text-xs px-0.5 rounded sm:rounded-md border shadow-xs focus:ring-2 focus:ring-blue-500 focus:outline-none transition z-10"
                            style="top: 25.1%; left: 27.9%; width: 5.2%; height: 3.8%;">

                        <!-- 5. Elsie (Grandmother - Floor Far Left) -->
                        <input type="text" x-model="inputs.elsie" @input="saveToStorage()" placeholder="?" title="2. Nenek Elsie (Grandmother)"
                            :class="{
                                'border-emerald-500 bg-emerald-100 text-emerald-950 font-black ring-1 sm:ring-2 ring-emerald-400': isFieldCorrect('elsie') === true,
                                'border-rose-500 bg-rose-100 text-rose-950 font-black ring-1 sm:ring-2 ring-rose-400': isFieldCorrect('elsie') === false,
                                'border-amber-800/60 bg-amber-100/90 hover:bg-white focus:bg-white text-slate-900': isFieldCorrect('elsie') === null
                            }"
                            class="absolute text-center font-black uppercase text-[7px] sm:text-[10px] md:text-xs px-0.5 rounded sm:rounded-md border shadow-xs focus:ring-2 focus:ring-blue-500 focus:outline-none transition z-10"
                            style="top: 92.0%; left: 3.4%; width: 5.5%; height: 3.8%;">

                        <!-- 6. Sue (Aunt - Floor Left 2) -->
                        <input type="text" x-model="inputs.sue" @input="saveToStorage()" placeholder="?" title="6. Bibi Sue (Aunt)"
                            :class="{
                                'border-emerald-500 bg-emerald-100 text-emerald-950 font-black ring-1 sm:ring-2 ring-emerald-400': isFieldCorrect('sue') === true,
                                'border-rose-500 bg-rose-100 text-rose-950 font-black ring-1 sm:ring-2 ring-rose-400': isFieldCorrect('sue') === false,
                                'border-amber-800/60 bg-amber-100/90 hover:bg-white focus:bg-white text-slate-900': isFieldCorrect('sue') === null
                            }"
                            class="absolute text-center font-black uppercase text-[7px] sm:text-[10px] md:text-xs px-0.5 rounded sm:rounded-md border shadow-xs focus:ring-2 focus:ring-blue-500 focus:outline-none transition z-10"
                            style="top: 92.2%; left: 10.8%; width: 5.8%; height: 3.8%;">

                        <!-- 7. Sam (Flower Girl / Sister - Floor Left 3) -->
                        <input type="text" x-model="inputs.sam" @input="saveToStorage()" placeholder="?" title="7. Saudara Sam (Flower Girl)"
                            :class="{
                                'border-emerald-500 bg-emerald-100 text-emerald-950 font-black ring-1 sm:ring-2 ring-emerald-400': isFieldCorrect('sam') === true,
                                'border-rose-500 bg-rose-100 text-rose-950 font-black ring-1 sm:ring-2 ring-rose-400': isFieldCorrect('sam') === false,
                                'border-amber-800/60 bg-amber-100/90 hover:bg-white focus:bg-white text-slate-900': isFieldCorrect('sam') === null
                            }"
                            class="absolute text-center font-black uppercase text-[7px] sm:text-[10px] md:text-xs px-0.5 rounded sm:rounded-md border shadow-xs focus:ring-2 focus:ring-blue-500 focus:outline-none transition z-10"
                            style="top: 93.6%; left: 20.8%; width: 5.6%; height: 3.8%;">

                        <!-- 8. Mike (Cousin - Floor Left 4) -->
                        <input type="text" x-model="inputs.mike" @input="saveToStorage()" placeholder="?" title="8. Sepupu Mike (Cousin)"
                            :class="{
                                'border-emerald-500 bg-emerald-100 text-emerald-950 font-black ring-1 sm:ring-2 ring-emerald-400': isFieldCorrect('mike') === true,
                                'border-rose-500 bg-rose-100 text-rose-950 font-black ring-1 sm:ring-2 ring-rose-400': isFieldCorrect('mike') === false,
                                'border-amber-800/60 bg-amber-100/90 hover:bg-white focus:bg-white text-slate-900': isFieldCorrect('mike') === null
                            }"
                            class="absolute text-center font-black uppercase text-[7px] sm:text-[10px] md:text-xs px-0.5 rounded sm:rounded-md border shadow-xs focus:ring-2 focus:ring-blue-500 focus:outline-none transition z-10"
                            style="top: 91.7%; left: 34.6%; width: 5.8%; height: 3.8%;">

                        <!-- SISI KANAN: GROOM'S FAMILY (TIM'S SIDE) -->
                        <!-- 9. Betty (Grandmother - Wall Near Arch Right) -->
                        <input type="text" x-model="inputs.betty" @input="saveToStorage()" placeholder="?" title="2. Nenek Betty (Grandmother)"
                            :class="{
                                'border-emerald-500 bg-emerald-100 text-emerald-950 font-black ring-1 sm:ring-2 ring-emerald-400': isFieldCorrect('betty') === true,
                                'border-rose-500 bg-rose-100 text-rose-950 font-black ring-1 sm:ring-2 ring-rose-400': isFieldCorrect('betty') === false,
                                'border-amber-800/60 bg-amber-100/90 hover:bg-white focus:bg-white text-slate-900': isFieldCorrect('betty') === null
                            }"
                            class="absolute text-center font-black uppercase text-[7px] sm:text-[10px] md:text-xs px-0.5 rounded sm:rounded-md border shadow-xs focus:ring-2 focus:ring-blue-500 focus:outline-none transition z-10"
                            style="top: 23.8%; left: 63.6%; width: 5.2%; height: 3.8%;">

                        <!-- 10. Jim (Grandfather - Wall Notice Board Right) -->
                        <input type="text" x-model="inputs.jim" @input="saveToStorage()" placeholder="?" title="1. Kakek Jim (Grandfather)"
                            :class="{
                                'border-emerald-500 bg-emerald-100 text-emerald-950 font-black ring-1 sm:ring-2 ring-emerald-400': isFieldCorrect('jim') === true,
                                'border-rose-500 bg-rose-100 text-rose-950 font-black ring-1 sm:ring-2 ring-rose-400': isFieldCorrect('jim') === false,
                                'border-amber-800/60 bg-amber-100/90 hover:bg-white focus:bg-white text-slate-900': isFieldCorrect('jim') === null
                            }"
                            class="absolute text-center font-black uppercase text-[7px] sm:text-[10px] md:text-xs px-0.5 rounded sm:rounded-md border shadow-xs focus:ring-2 focus:ring-blue-500 focus:outline-none transition z-10"
                            style="top: 16.6%; left: 74.9%; width: 5.6%; height: 3.8%;">

                        <!-- 11. Al (Father - Wall Top Right 2) -->
                        <input type="text" x-model="inputs.al" @input="saveToStorage()" placeholder="?" title="3. Ayah Al (Father)"
                            :class="{
                                'border-emerald-500 bg-emerald-100 text-emerald-950 font-black ring-1 sm:ring-2 ring-emerald-400': isFieldCorrect('al') === true,
                                'border-rose-500 bg-rose-100 text-rose-950 font-black ring-1 sm:ring-2 ring-rose-400': isFieldCorrect('al') === false,
                                'border-amber-800/60 bg-amber-100/90 hover:bg-white focus:bg-white text-slate-900': isFieldCorrect('al') === null
                            }"
                            class="absolute text-center font-black uppercase text-[7px] sm:text-[10px] md:text-xs px-0.5 rounded sm:rounded-md border shadow-xs focus:ring-2 focus:ring-blue-500 focus:outline-none transition z-10"
                            style="top: 20.2%; left: 84.6%; width: 5.6%; height: 3.8%;">

                        <!-- 12. Jane (Mother - Wall Top Far Right) -->
                        <input type="text" x-model="inputs.jane" @input="saveToStorage()" placeholder="?" title="4. Ibu Jane (Mother)"
                            :class="{
                                'border-emerald-500 bg-emerald-100 text-emerald-950 font-black ring-1 sm:ring-2 ring-emerald-400': isFieldCorrect('jane') === true,
                                'border-rose-500 bg-rose-100 text-rose-950 font-black ring-1 sm:ring-2 ring-rose-400': isFieldCorrect('jane') === false,
                                'border-amber-800/60 bg-amber-100/90 hover:bg-white focus:bg-white text-slate-900': isFieldCorrect('jane') === null
                            }"
                            class="absolute text-center font-black uppercase text-[7px] sm:text-[10px] md:text-xs px-0.5 rounded sm:rounded-md border shadow-xs focus:ring-2 focus:ring-blue-500 focus:outline-none transition z-10"
                            style="top: 27.9%; left: 92.0%; width: 5.6%; height: 3.8%;">

                        <!-- 13. John (Page Boy / Cousin - Floor Center Right) -->
                        <input type="text" x-model="inputs.john" @input="saveToStorage()" placeholder="?" title="8. Sepupu John (Page Boy)"
                            :class="{
                                'border-emerald-500 bg-emerald-100 text-emerald-950 font-black ring-1 sm:ring-2 ring-emerald-400': isFieldCorrect('john') === true,
                                'border-rose-500 bg-rose-100 text-rose-950 font-black ring-1 sm:ring-2 ring-rose-400': isFieldCorrect('john') === false,
                                'border-amber-800/60 bg-amber-100/90 hover:bg-white focus:bg-white text-slate-900': isFieldCorrect('john') === null
                            }"
                            class="absolute text-center font-black uppercase text-[7px] sm:text-[10px] md:text-xs px-0.5 rounded sm:rounded-md border shadow-xs focus:ring-2 focus:ring-blue-500 focus:outline-none transition z-10"
                            style="top: 94.1%; left: 60.3%; width: 5.6%; height: 3.8%;">

                        <!-- 14. Ben (Uncle - Floor Right 1) -->
                        <input type="text" x-model="inputs.ben" @input="saveToStorage()" placeholder="?" title="5. Paman Ben (Uncle)"
                            :class="{
                                'border-emerald-500 bg-emerald-100 text-emerald-950 font-black ring-1 sm:ring-2 ring-emerald-400': isFieldCorrect('ben') === true,
                                'border-rose-500 bg-rose-100 text-rose-950 font-black ring-1 sm:ring-2 ring-rose-400': isFieldCorrect('ben') === false,
                                'border-amber-800/60 bg-amber-100/90 hover:bg-white focus:bg-white text-slate-900': isFieldCorrect('ben') === null
                            }"
                            class="absolute text-center font-black uppercase text-[7px] sm:text-[10px] md:text-xs px-0.5 rounded sm:rounded-md border shadow-xs focus:ring-2 focus:ring-blue-500 focus:outline-none transition z-10"
                            style="top: 86.9%; left: 69.7%; width: 5.6%; height: 3.8%;">

                        <!-- 15. Liz (Aunt - Floor Right 2) -->
                        <input type="text" x-model="inputs.liz" @input="saveToStorage()" placeholder="?" title="6. Bibi Liz (Aunt)"
                            :class="{
                                'border-emerald-500 bg-emerald-100 text-emerald-950 font-black ring-1 sm:ring-2 ring-emerald-400': isFieldCorrect('liz') === true,
                                'border-rose-500 bg-rose-100 text-rose-950 font-black ring-1 sm:ring-2 ring-rose-400': isFieldCorrect('liz') === false,
                                'border-amber-800/60 bg-amber-100/90 hover:bg-white focus:bg-white text-slate-900': isFieldCorrect('liz') === null
                            }"
                            class="absolute text-center font-black uppercase text-[7px] sm:text-[10px] md:text-xs px-0.5 rounded sm:rounded-md border shadow-xs focus:ring-2 focus:ring-blue-500 focus:outline-none transition z-10"
                            style="top: 88.6%; left: 76.6%; width: 5.4%; height: 3.8%;">

                        <!-- 16. Beth (Sister - Floor Right 3) -->
                        <input type="text" x-model="inputs.beth" @input="saveToStorage()" placeholder="?" title="7. Saudara Beth (Sister)"
                            :class="{
                                'border-emerald-500 bg-emerald-100 text-emerald-950 font-black ring-1 sm:ring-2 ring-emerald-400': isFieldCorrect('beth') === true,
                                'border-rose-500 bg-rose-100 text-rose-950 font-black ring-1 sm:ring-2 ring-rose-400': isFieldCorrect('beth') === false,
                                'border-amber-800/60 bg-amber-100/90 hover:bg-white focus:bg-white text-slate-900': isFieldCorrect('beth') === null
                            }"
                            class="absolute text-center font-black uppercase text-[7px] sm:text-[10px] md:text-xs px-0.5 rounded sm:rounded-md border shadow-xs focus:ring-2 focus:ring-blue-500 focus:outline-none transition z-10"
                            style="top: 93.1%; left: 84.4%; width: 5.8%; height: 3.8%;">
                    </div>
                </div>
                            </div>

                                    <!-- Visual Authentic Family Tree A Image -->
                                    <div class="bg-indigo-50/40 rounded-3xl p-4 sm:p-6 border-2 border-indigo-100 space-y-3">
                                        <div class="flex items-center justify-between">
                                            <div class="font-black text-slate-800 text-xs sm:text-sm flex items-center gap-2">
                                                <span>🖼️</span> <span>Gambar Pohon Keluarga A (Keluarga Anda):</span>
                                            </div>
                                            <span class="text-[11px] text-slate-400 font-bold">Klik gambar untuk layar penuh</span>
                                        </div>

                                        <div class="bg-white rounded-2xl p-3 sm:p-6 border border-indigo-200 flex items-center justify-center shadow-inner cursor-pointer hover:border-indigo-400 transition group" @click="activeModal = 'tree_a_full'">
                                            <img x-show="photoMode === 'color'"
                                                 src="{{ asset('images/speaking/wedding_photos/family_tree_a_hd.jpg?v=13') }}"
                                                 alt="Family Tree A"
                                                 class="max-h-[460px] w-auto max-w-full object-contain rounded-xl group-hover:scale-[1.01] transition-transform duration-200">
                                            <img x-show="photoMode === 'sketch'"
                                                 src="{{ asset('images/speaking/wedding_photos/family_tree_a.png') }}"
                                                 alt="Family Tree A"
                                                 class="max-h-[460px] w-auto max-w-full object-contain rounded-xl group-hover:scale-[1.01] transition-transform duration-200">
                                        </div>
                                    </div>

                                    <!-- Interactive Spoken Answers List for Siswa A -->
                                    <div class="space-y-3 pt-2">
                                        <div class="flex items-center justify-between">
                                            <div class="font-black text-slate-900 text-sm flex items-center gap-2">
                                                <span>🗣️</span> <span>Contoh Jawaban Lisan Siswa A (Klik untuk mendengar audio):</span>
                                            </div>
                                            <span class="text-xs text-slate-400 font-bold">Tekan 🔊 untuk melafalkan</span>
                                        </div>
                                        
                                        <div class="grid grid-cols-1 md:grid-cols-2 gap-3 text-xs">
                                            @foreach($gameData['family_a']['members'] ?? [] as $m)
                                                 <div class="p-3.5 rounded-2xl bg-slate-50 border border-slate-200 hover:border-indigo-400 transition flex items-center justify-between gap-3">
                                                     <div>
                                                         <div class="font-black text-slate-900 text-sm">{{ $m['name'] }} <span class="text-xs font-semibold text-indigo-600">({{ $m['relation_en'] }} / {{ $m['relation_id'] }})</span></div>
                                                         <div class="text-slate-600 font-medium italic mt-0.5">"{{ $m['spoken_answer'] }}"</div>
                                                     </div>
                                                     <button @click="speakText(@js($m['spoken_answer']))" type="button" class="p-2 rounded-xl bg-indigo-100 hover:bg-indigo-600 hover:text-white text-indigo-700 transition shrink-0" title="Dengarkan Audio">
                                                         <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M3 9v6h4l5 5V4L7 9H3zm13.5 3c0-1.77-1.02-3.29-2.5-4.03v8.05c1.48-.73 2.5-2.25 2.5-4.02z"/></svg>
                                                     </button>
                                                 </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- ==================================================== -->
                            <!-- TAB 3: STUDENT B CARD (GROOM'S FAMILY TREE)          -->
                            <!-- ==================================================== -->
                            <div x-show="gameTab === 'student_b'" class="space-y-6">
                                <div class="bg-white rounded-[2rem] p-6 sm:p-8 shadow-sm border-2 border-orange-200 relative overflow-hidden space-y-6">
                                    
                                    <!-- Secret Card Header -->
                                    <div class="flex flex-col sm:flex-row sm:items-center justify-between pb-4 border-b border-orange-100 gap-3">
                                        <div class="flex items-center gap-3">
                                            <span class="text-4xl">🤵</span>
                                            <div>
                                                <div class="flex items-center gap-2 flex-wrap">
                                                    <span class="px-3 py-0.5 rounded-full bg-orange-600 text-white text-xs font-black uppercase">
                                                        Role Card • Student B
                                                    </span>
                                                    <span class="px-3 py-0.5 rounded-full bg-amber-400 text-slate-950 text-xs font-black uppercase">
                                                        Groom's Family (Tim's Side)
                                                    </span>
                                                </div>
                                                <h3 class="text-xl sm:text-2xl font-black text-slate-900 mt-1">Family Tree B (Pohon Keluarga Pengantin Pria)</h3>
                                                <p class="text-xs text-orange-700 font-semibold mt-0.5">
                                                    🔒 Anda adalah saudara/saudari dari <strong>Tim</strong>! Gunakan pohon keluarga ini untuk menjawab pertanyaan Siswa A.
                                                </p>
                                            </div>
                                        </div>
                                        <button @click="activeModal = 'tree_b_full'" type="button" class="px-4 py-2.5 rounded-xl bg-orange-600 hover:bg-orange-700 text-white font-black text-xs transition flex items-center gap-1.5 self-start sm:self-auto shadow-sm">
                                            <span>🔍</span> <span>Perbesar Gambar Pohon B</span>
                                        </button>
                                    </div>

                                    <!-- Role Mission Alert Box for Student B -->
                                    <div class="p-4 rounded-2xl bg-orange-50/80 border-2 border-orange-200 flex flex-col md:flex-row md:items-center justify-between gap-3 text-xs">
                                        <div class="flex items-start gap-3">
                                            <span class="text-2xl shrink-0">🎯</span>
                                            <div>
                                                <div class="font-black text-orange-950 text-sm">Instruksi Permainan Siswa B:</div>
                                                <ol class="list-decimal list-inside text-orange-900 space-y-1 mt-1 font-medium leading-relaxed">
                                                    <li><strong>Jawab Pertanyaan Siswa A:</strong> Saat Siswa A bertanya <em>"Who's that?"</em>, lihat pohon keluarga B di bawah dan jawab <em>"That's [Nama]. She's/He's my [Hubungan]."</em></li>
                                                    <li><strong>Tanyakan Keluarga Siswa A:</strong> Tunjuk orang di sisi kiri foto pernikahan (Keluarga Ann) dan tanyakan <em>"Who's that?"</em> ke Siswa A, lalu isi namanya di <button type="button" @click="gameTab = 'worksheet'" class="text-orange-700 font-black underline">Lembar Foto (Tab 1)</button>!</li>
                                                </ol>
                                            </div>
                                        </div>
                                        <button @click="gameTab = 'worksheet'" type="button" class="px-4 py-2 rounded-xl bg-white text-orange-900 font-black border border-orange-300 hover:bg-orange-600 hover:text-white transition shrink-0 self-start md:self-auto shadow-xs">
                                            Ke Lembar Foto →
                                        </button>
                                    </div>

                                    <!-- 📸 BIG FULL-WIDTH WEDDING PHOTO SHOWCASE -->
                                <div class="w-full bg-white rounded-3xl p-5 sm:p-7 border border-slate-200 shadow-md space-y-4">
                                    <!-- Photo Header with Toggle Buttons -->
                                    <div class="flex flex-col sm:flex-row sm:items-center justify-between pb-4 border-b border-slate-100 gap-3">
                                        <div>
                                            <div class="flex items-center gap-2">
                                                <h3 class="font-black text-slate-900 text-lg sm:text-xl flex items-center gap-2">
                                                    <span>📸</span> <span>The Big Wedding Photograph</span>
                                                </h3>
                                                <span class="px-3 py-0.5 rounded-full bg-blue-100 text-blue-700 text-xs font-black">16 Karakter</span>
                                            </div>
                                            <p class="text-xs text-slate-500 mt-0.5">Foto pernikahan keluarga besar pengantin wanita (Ann) &amp; pengantin pria (Tim)</p>
                                        </div>

                                        <!-- Color / Sketch Mode Switcher -->
                                        <div class="flex items-center gap-2 flex-wrap">
                                            <div class="bg-slate-100 p-1 rounded-2xl flex items-center gap-1 border border-slate-200 text-xs">
                                                <button type="button" @click="photoMode = 'color'"
                                                    :class="photoMode === 'color' ? 'bg-gradient-to-r from-pink-500 to-indigo-600 text-white font-black shadow-sm' : 'text-slate-600 hover:text-slate-900 font-bold'"
                                                    class="px-3 py-1.5 rounded-xl transition flex items-center gap-1">
                                                    <span>🎨</span> <span>Foto Berwarna HD</span>
                                                </button>
                                                <button type="button" @click="photoMode = 'sketch'"
                                                    :class="photoMode === 'sketch' ? 'bg-slate-900 text-white font-black shadow-sm' : 'text-slate-600 hover:text-slate-900 font-bold'"
                                                    class="px-3 py-1.5 rounded-xl transition flex items-center gap-1">
                                                    <span>✏️</span> <span>Sketsa Hitam Putih</span>
                                                </button>
                                            </div>
                                            <button type="button" @click="activeModal = 'photo_full'" class="px-3.5 py-2 rounded-xl bg-amber-400 hover:bg-amber-300 text-slate-950 text-xs font-black transition flex items-center gap-1 shadow-sm">
                                                <span>🔍</span> <span>Zoom</span>
                                            </button>
                                        </div>
                                    </div>

                                    <!-- Main Large Image Container with Interactive Input Overlays -->
                                    <div class="relative w-full max-w-5xl mx-auto rounded-3xl overflow-hidden border-2 sm:border-4 border-slate-700 bg-slate-900 shadow-2xl select-none">
                                        <!-- Colored Image -->
                                        <img x-show="photoMode === 'color'"
                                             src="{{ asset('images/speaking/wedding_photos/wedding_photo_hd.jpg?v=14') }}"
                                             alt="Colored Wedding Photo"
                                             class="w-full h-auto block select-none pointer-events-none">
                                        
                                        <!-- Classic Sketch Image -->
                                        <img x-show="photoMode === 'sketch'"
                                             src="{{ asset('images/speaking/wedding_photos/wedding_photo_upright.png') }}"
                                             alt="Sketch Wedding Photo"
                                             class="w-full h-auto block select-none pointer-events-none">

                                                            <!-- Interactive Overlay Layer -->
                    <div class="absolute inset-0 w-full h-full pointer-events-auto">
                        
                        <!-- SISI KIRI: BRIDE'S FAMILY (ANN'S SIDE) -->
                        <!-- 1. Joe (Grandfather - Wall Far Left) -->
                        <input type="text" x-model="inputs.joe" @input="saveToStorage()" placeholder="?" title="1. Kakek Joe (Grandfather)"
                            :class="{
                                'border-emerald-500 bg-emerald-100 text-emerald-950 font-black ring-1 sm:ring-2 ring-emerald-400': isFieldCorrect('joe') === true,
                                'border-rose-500 bg-rose-100 text-rose-950 font-black ring-1 sm:ring-2 ring-rose-400': isFieldCorrect('joe') === false,
                                'border-amber-800/60 bg-amber-100/90 hover:bg-white focus:bg-white text-slate-900': isFieldCorrect('joe') === null
                            }"
                            class="absolute text-center font-black uppercase text-[7px] sm:text-[10px] md:text-xs px-0.5 rounded sm:rounded-md border shadow-xs focus:ring-2 focus:ring-blue-500 focus:outline-none transition z-10"
                            style="top: 16.3%; left: 3.6%; width: 5.5%; height: 3.8%;">

                        <!-- 2. Pete (Uncle - Wall Top Left 2) -->
                        <input type="text" x-model="inputs.pete" @input="saveToStorage()" placeholder="?" title="5. Paman Pete (Uncle)"
                            :class="{
                                'border-emerald-500 bg-emerald-100 text-emerald-950 font-black ring-1 sm:ring-2 ring-emerald-400': isFieldCorrect('pete') === true,
                                'border-rose-500 bg-rose-100 text-rose-950 font-black ring-1 sm:ring-2 ring-rose-400': isFieldCorrect('pete') === false,
                                'border-amber-800/60 bg-amber-100/90 hover:bg-white focus:bg-white text-slate-900': isFieldCorrect('pete') === null
                            }"
                            class="absolute text-center font-black uppercase text-[7px] sm:text-[10px] md:text-xs px-0.5 rounded sm:rounded-md border shadow-xs focus:ring-2 focus:ring-blue-500 focus:outline-none transition z-10"
                            style="top: 14.5%; left: 13.8%; width: 5.5%; height: 3.8%;">

                        <!-- 3. Jess (Mother - Wall Above Jess) -->
                        <input type="text" x-model="inputs.jess" @input="saveToStorage()" placeholder="?" title="4. Ibu Jess (Mother)"
                            :class="{
                                'border-emerald-500 bg-emerald-100 text-emerald-950 font-black ring-1 sm:ring-2 ring-emerald-400': isFieldCorrect('jess') === true,
                                'border-rose-500 bg-rose-100 text-rose-950 font-black ring-1 sm:ring-2 ring-rose-400': isFieldCorrect('jess') === false,
                                'border-amber-800/60 bg-amber-100/90 hover:bg-white focus:bg-white text-slate-900': isFieldCorrect('jess') === null
                            }"
                            class="absolute text-center font-black uppercase text-[7px] sm:text-[10px] md:text-xs px-0.5 rounded sm:rounded-md border shadow-xs focus:ring-2 focus:ring-blue-500 focus:outline-none transition z-10"
                            style="top: 28.2%; left: 21.8%; width: 5.2%; height: 3.8%;">

                        <!-- 4. Tom (Father - Wall Near Arch) -->
                        <input type="text" x-model="inputs.tom" @input="saveToStorage()" placeholder="?" title="3. Ayah Tom (Father)"
                            :class="{
                                'border-emerald-500 bg-emerald-100 text-emerald-950 font-black ring-1 sm:ring-2 ring-emerald-400': isFieldCorrect('tom') === true,
                                'border-rose-500 bg-rose-100 text-rose-950 font-black ring-1 sm:ring-2 ring-rose-400': isFieldCorrect('tom') === false,
                                'border-amber-800/60 bg-amber-100/90 hover:bg-white focus:bg-white text-slate-900': isFieldCorrect('tom') === null
                            }"
                            class="absolute text-center font-black uppercase text-[7px] sm:text-[10px] md:text-xs px-0.5 rounded sm:rounded-md border shadow-xs focus:ring-2 focus:ring-blue-500 focus:outline-none transition z-10"
                            style="top: 25.1%; left: 27.9%; width: 5.2%; height: 3.8%;">

                        <!-- 5. Elsie (Grandmother - Floor Far Left) -->
                        <input type="text" x-model="inputs.elsie" @input="saveToStorage()" placeholder="?" title="2. Nenek Elsie (Grandmother)"
                            :class="{
                                'border-emerald-500 bg-emerald-100 text-emerald-950 font-black ring-1 sm:ring-2 ring-emerald-400': isFieldCorrect('elsie') === true,
                                'border-rose-500 bg-rose-100 text-rose-950 font-black ring-1 sm:ring-2 ring-rose-400': isFieldCorrect('elsie') === false,
                                'border-amber-800/60 bg-amber-100/90 hover:bg-white focus:bg-white text-slate-900': isFieldCorrect('elsie') === null
                            }"
                            class="absolute text-center font-black uppercase text-[7px] sm:text-[10px] md:text-xs px-0.5 rounded sm:rounded-md border shadow-xs focus:ring-2 focus:ring-blue-500 focus:outline-none transition z-10"
                            style="top: 92.0%; left: 3.4%; width: 5.5%; height: 3.8%;">

                        <!-- 6. Sue (Aunt - Floor Left 2) -->
                        <input type="text" x-model="inputs.sue" @input="saveToStorage()" placeholder="?" title="6. Bibi Sue (Aunt)"
                            :class="{
                                'border-emerald-500 bg-emerald-100 text-emerald-950 font-black ring-1 sm:ring-2 ring-emerald-400': isFieldCorrect('sue') === true,
                                'border-rose-500 bg-rose-100 text-rose-950 font-black ring-1 sm:ring-2 ring-rose-400': isFieldCorrect('sue') === false,
                                'border-amber-800/60 bg-amber-100/90 hover:bg-white focus:bg-white text-slate-900': isFieldCorrect('sue') === null
                            }"
                            class="absolute text-center font-black uppercase text-[7px] sm:text-[10px] md:text-xs px-0.5 rounded sm:rounded-md border shadow-xs focus:ring-2 focus:ring-blue-500 focus:outline-none transition z-10"
                            style="top: 92.2%; left: 10.8%; width: 5.8%; height: 3.8%;">

                        <!-- 7. Sam (Flower Girl / Sister - Floor Left 3) -->
                        <input type="text" x-model="inputs.sam" @input="saveToStorage()" placeholder="?" title="7. Saudara Sam (Flower Girl)"
                            :class="{
                                'border-emerald-500 bg-emerald-100 text-emerald-950 font-black ring-1 sm:ring-2 ring-emerald-400': isFieldCorrect('sam') === true,
                                'border-rose-500 bg-rose-100 text-rose-950 font-black ring-1 sm:ring-2 ring-rose-400': isFieldCorrect('sam') === false,
                                'border-amber-800/60 bg-amber-100/90 hover:bg-white focus:bg-white text-slate-900': isFieldCorrect('sam') === null
                            }"
                            class="absolute text-center font-black uppercase text-[7px] sm:text-[10px] md:text-xs px-0.5 rounded sm:rounded-md border shadow-xs focus:ring-2 focus:ring-blue-500 focus:outline-none transition z-10"
                            style="top: 93.6%; left: 20.8%; width: 5.6%; height: 3.8%;">

                        <!-- 8. Mike (Cousin - Floor Left 4) -->
                        <input type="text" x-model="inputs.mike" @input="saveToStorage()" placeholder="?" title="8. Sepupu Mike (Cousin)"
                            :class="{
                                'border-emerald-500 bg-emerald-100 text-emerald-950 font-black ring-1 sm:ring-2 ring-emerald-400': isFieldCorrect('mike') === true,
                                'border-rose-500 bg-rose-100 text-rose-950 font-black ring-1 sm:ring-2 ring-rose-400': isFieldCorrect('mike') === false,
                                'border-amber-800/60 bg-amber-100/90 hover:bg-white focus:bg-white text-slate-900': isFieldCorrect('mike') === null
                            }"
                            class="absolute text-center font-black uppercase text-[7px] sm:text-[10px] md:text-xs px-0.5 rounded sm:rounded-md border shadow-xs focus:ring-2 focus:ring-blue-500 focus:outline-none transition z-10"
                            style="top: 91.7%; left: 34.6%; width: 5.8%; height: 3.8%;">

                        <!-- SISI KANAN: GROOM'S FAMILY (TIM'S SIDE) -->
                        <!-- 9. Betty (Grandmother - Wall Near Arch Right) -->
                        <input type="text" x-model="inputs.betty" @input="saveToStorage()" placeholder="?" title="2. Nenek Betty (Grandmother)"
                            :class="{
                                'border-emerald-500 bg-emerald-100 text-emerald-950 font-black ring-1 sm:ring-2 ring-emerald-400': isFieldCorrect('betty') === true,
                                'border-rose-500 bg-rose-100 text-rose-950 font-black ring-1 sm:ring-2 ring-rose-400': isFieldCorrect('betty') === false,
                                'border-amber-800/60 bg-amber-100/90 hover:bg-white focus:bg-white text-slate-900': isFieldCorrect('betty') === null
                            }"
                            class="absolute text-center font-black uppercase text-[7px] sm:text-[10px] md:text-xs px-0.5 rounded sm:rounded-md border shadow-xs focus:ring-2 focus:ring-blue-500 focus:outline-none transition z-10"
                            style="top: 23.8%; left: 63.6%; width: 5.2%; height: 3.8%;">

                        <!-- 10. Jim (Grandfather - Wall Notice Board Right) -->
                        <input type="text" x-model="inputs.jim" @input="saveToStorage()" placeholder="?" title="1. Kakek Jim (Grandfather)"
                            :class="{
                                'border-emerald-500 bg-emerald-100 text-emerald-950 font-black ring-1 sm:ring-2 ring-emerald-400': isFieldCorrect('jim') === true,
                                'border-rose-500 bg-rose-100 text-rose-950 font-black ring-1 sm:ring-2 ring-rose-400': isFieldCorrect('jim') === false,
                                'border-amber-800/60 bg-amber-100/90 hover:bg-white focus:bg-white text-slate-900': isFieldCorrect('jim') === null
                            }"
                            class="absolute text-center font-black uppercase text-[7px] sm:text-[10px] md:text-xs px-0.5 rounded sm:rounded-md border shadow-xs focus:ring-2 focus:ring-blue-500 focus:outline-none transition z-10"
                            style="top: 16.6%; left: 74.9%; width: 5.6%; height: 3.8%;">

                        <!-- 11. Al (Father - Wall Top Right 2) -->
                        <input type="text" x-model="inputs.al" @input="saveToStorage()" placeholder="?" title="3. Ayah Al (Father)"
                            :class="{
                                'border-emerald-500 bg-emerald-100 text-emerald-950 font-black ring-1 sm:ring-2 ring-emerald-400': isFieldCorrect('al') === true,
                                'border-rose-500 bg-rose-100 text-rose-950 font-black ring-1 sm:ring-2 ring-rose-400': isFieldCorrect('al') === false,
                                'border-amber-800/60 bg-amber-100/90 hover:bg-white focus:bg-white text-slate-900': isFieldCorrect('al') === null
                            }"
                            class="absolute text-center font-black uppercase text-[7px] sm:text-[10px] md:text-xs px-0.5 rounded sm:rounded-md border shadow-xs focus:ring-2 focus:ring-blue-500 focus:outline-none transition z-10"
                            style="top: 20.2%; left: 84.6%; width: 5.6%; height: 3.8%;">

                        <!-- 12. Jane (Mother - Wall Top Far Right) -->
                        <input type="text" x-model="inputs.jane" @input="saveToStorage()" placeholder="?" title="4. Ibu Jane (Mother)"
                            :class="{
                                'border-emerald-500 bg-emerald-100 text-emerald-950 font-black ring-1 sm:ring-2 ring-emerald-400': isFieldCorrect('jane') === true,
                                'border-rose-500 bg-rose-100 text-rose-950 font-black ring-1 sm:ring-2 ring-rose-400': isFieldCorrect('jane') === false,
                                'border-amber-800/60 bg-amber-100/90 hover:bg-white focus:bg-white text-slate-900': isFieldCorrect('jane') === null
                            }"
                            class="absolute text-center font-black uppercase text-[7px] sm:text-[10px] md:text-xs px-0.5 rounded sm:rounded-md border shadow-xs focus:ring-2 focus:ring-blue-500 focus:outline-none transition z-10"
                            style="top: 27.9%; left: 92.0%; width: 5.6%; height: 3.8%;">

                        <!-- 13. John (Page Boy / Cousin - Floor Center Right) -->
                        <input type="text" x-model="inputs.john" @input="saveToStorage()" placeholder="?" title="8. Sepupu John (Page Boy)"
                            :class="{
                                'border-emerald-500 bg-emerald-100 text-emerald-950 font-black ring-1 sm:ring-2 ring-emerald-400': isFieldCorrect('john') === true,
                                'border-rose-500 bg-rose-100 text-rose-950 font-black ring-1 sm:ring-2 ring-rose-400': isFieldCorrect('john') === false,
                                'border-amber-800/60 bg-amber-100/90 hover:bg-white focus:bg-white text-slate-900': isFieldCorrect('john') === null
                            }"
                            class="absolute text-center font-black uppercase text-[7px] sm:text-[10px] md:text-xs px-0.5 rounded sm:rounded-md border shadow-xs focus:ring-2 focus:ring-blue-500 focus:outline-none transition z-10"
                            style="top: 94.1%; left: 60.3%; width: 5.6%; height: 3.8%;">

                        <!-- 14. Ben (Uncle - Floor Right 1) -->
                        <input type="text" x-model="inputs.ben" @input="saveToStorage()" placeholder="?" title="5. Paman Ben (Uncle)"
                            :class="{
                                'border-emerald-500 bg-emerald-100 text-emerald-950 font-black ring-1 sm:ring-2 ring-emerald-400': isFieldCorrect('ben') === true,
                                'border-rose-500 bg-rose-100 text-rose-950 font-black ring-1 sm:ring-2 ring-rose-400': isFieldCorrect('ben') === false,
                                'border-amber-800/60 bg-amber-100/90 hover:bg-white focus:bg-white text-slate-900': isFieldCorrect('ben') === null
                            }"
                            class="absolute text-center font-black uppercase text-[7px] sm:text-[10px] md:text-xs px-0.5 rounded sm:rounded-md border shadow-xs focus:ring-2 focus:ring-blue-500 focus:outline-none transition z-10"
                            style="top: 86.9%; left: 69.7%; width: 5.6%; height: 3.8%;">

                        <!-- 15. Liz (Aunt - Floor Right 2) -->
                        <input type="text" x-model="inputs.liz" @input="saveToStorage()" placeholder="?" title="6. Bibi Liz (Aunt)"
                            :class="{
                                'border-emerald-500 bg-emerald-100 text-emerald-950 font-black ring-1 sm:ring-2 ring-emerald-400': isFieldCorrect('liz') === true,
                                'border-rose-500 bg-rose-100 text-rose-950 font-black ring-1 sm:ring-2 ring-rose-400': isFieldCorrect('liz') === false,
                                'border-amber-800/60 bg-amber-100/90 hover:bg-white focus:bg-white text-slate-900': isFieldCorrect('liz') === null
                            }"
                            class="absolute text-center font-black uppercase text-[7px] sm:text-[10px] md:text-xs px-0.5 rounded sm:rounded-md border shadow-xs focus:ring-2 focus:ring-blue-500 focus:outline-none transition z-10"
                            style="top: 88.6%; left: 76.6%; width: 5.4%; height: 3.8%;">

                        <!-- 16. Beth (Sister - Floor Right 3) -->
                        <input type="text" x-model="inputs.beth" @input="saveToStorage()" placeholder="?" title="7. Saudara Beth (Sister)"
                            :class="{
                                'border-emerald-500 bg-emerald-100 text-emerald-950 font-black ring-1 sm:ring-2 ring-emerald-400': isFieldCorrect('beth') === true,
                                'border-rose-500 bg-rose-100 text-rose-950 font-black ring-1 sm:ring-2 ring-rose-400': isFieldCorrect('beth') === false,
                                'border-amber-800/60 bg-amber-100/90 hover:bg-white focus:bg-white text-slate-900': isFieldCorrect('beth') === null
                            }"
                            class="absolute text-center font-black uppercase text-[7px] sm:text-[10px] md:text-xs px-0.5 rounded sm:rounded-md border shadow-xs focus:ring-2 focus:ring-blue-500 focus:outline-none transition z-10"
                            style="top: 93.1%; left: 84.4%; width: 5.8%; height: 3.8%;">
                    </div>
                </div>
                            </div>

                                    <!-- Visual Authentic Family Tree B Image -->
                                    <div class="bg-orange-50/40 rounded-3xl p-4 sm:p-6 border-2 border-orange-100 space-y-3">
                                        <div class="flex items-center justify-between">
                                            <div class="font-black text-slate-800 text-xs sm:text-sm flex items-center gap-2">
                                                <span>🖼️</span> <span>Gambar Pohon Keluarga B (Keluarga Anda):</span>
                                            </div>
                                            <span class="text-[11px] text-slate-400 font-bold">Klik gambar untuk layar penuh</span>
                                        </div>

                                        <div class="bg-white rounded-2xl p-3 sm:p-6 border border-orange-200 flex items-center justify-center shadow-inner cursor-pointer hover:border-orange-400 transition group" @click="activeModal = 'tree_b_full'">
                                            <img x-show="photoMode === 'color'"
                                                 src="{{ asset('images/speaking/wedding_photos/family_tree_b_hd.jpg?v=14') }}"
                                                 alt="Family Tree B"
                                                 class="max-h-[460px] w-auto max-w-full object-contain rounded-xl group-hover:scale-[1.01] transition-transform duration-200">
                                            <img x-show="photoMode === 'sketch'"
                                                 src="{{ asset('images/speaking/wedding_photos/family_tree_b.png') }}"
                                                 alt="Family Tree B"
                                                 class="max-h-[460px] w-auto max-w-full object-contain rounded-xl group-hover:scale-[1.01] transition-transform duration-200">
                                        </div>
                                    </div>

                                    <!-- Interactive Spoken Answers List for Siswa B -->
                                    <div class="space-y-3 pt-2">
                                        <div class="flex items-center justify-between">
                                            <div class="font-black text-slate-900 text-sm flex items-center gap-2">
                                                <span>🗣️</span> <span>Contoh Jawaban Lisan Siswa B (Klik untuk mendengar audio):</span>
                                            </div>
                                            <span class="text-xs text-slate-400 font-bold">Tekan 🔊 untuk melafalkan</span>
                                        </div>
                                        
                                        <div class="grid grid-cols-1 md:grid-cols-2 gap-3 text-xs">
                                            @foreach($gameData['family_b']['members'] ?? [] as $m)
                                                 <div class="p-3.5 rounded-2xl bg-slate-50 border border-slate-200 hover:border-orange-400 transition flex items-center justify-between gap-3">
                                                     <div>
                                                         <div class="font-black text-slate-900 text-sm">{{ $m['name'] }} <span class="text-xs font-semibold text-orange-600">({{ $m['relation_en'] }} / {{ $m['relation_id'] }})</span></div>
                                                         <div class="text-slate-600 font-medium italic mt-0.5">"{{ $m['spoken_answer'] }}"</div>
                                                     </div>
                                                     <button @click="speakText(@js($m['spoken_answer']))" type="button" class="p-2 rounded-xl bg-orange-100 hover:bg-orange-600 hover:text-white text-orange-700 transition shrink-0" title="Dengarkan Audio">
                                                         <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M3 9v6h4l5 5V4L7 9H3zm13.5 3c0-1.77-1.02-3.29-2.5-4.03v8.05c1.48-.73 2.5-2.25 2.5-4.02z"/></svg>
                                                     </button>
                                                 </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- ==================================================== -->
                            <!-- TAB 4: SPEAKING PHRASES & INTERACTIVE DIALOGUES     -->
                            <!-- ==================================================== -->
                            <div x-show="gameTab === 'phrases'" class="space-y-6">
                                <div class="bg-white rounded-[2rem] p-6 sm:p-8 shadow-sm border border-slate-200/90 space-y-6">
                                    <div class="pb-4 border-b border-slate-100">
                                        <span class="px-3 py-1 rounded-full bg-blue-100 text-blue-700 text-xs font-black uppercase">Speaking Exponents</span>
                                        <h3 class="text-xl sm:text-2xl font-black text-slate-900 mt-2">Pola Kalimat Tanya &amp; Jawab Identitas Anggota Keluarga</h3>
                                        <p class="text-xs sm:text-sm text-slate-500 font-medium mt-1">Gunakan struktur kalimat ini untuk melatih kelancaran percakapan berpasangan.</p>
                                    </div>

                                    <!-- Key Structures Formula Box -->
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                        <div class="p-5 rounded-2xl bg-indigo-50/70 border border-indigo-200 space-y-2">
                                            <div class="text-xs font-black uppercase text-indigo-900">1. Pola Menanyakan (Asking):</div>
                                            <div class="p-3 rounded-xl bg-white border border-indigo-200 font-mono text-xs font-black text-indigo-950">
                                                "Who's this / that?"<br>
                                                "Who's the man with the glasses / moustache?"<br>
                                                "Who's the woman next to Ann / Tim?"
                                            </div>
                                        </div>
                                        <div class="p-5 rounded-2xl bg-emerald-50/70 border border-emerald-200 space-y-2">
                                            <div class="text-xs font-black uppercase text-emerald-900">2. Pola Menjawab (Answering):</div>
                                            <div class="p-3 rounded-xl bg-white border border-emerald-200 font-mono text-xs font-black text-emerald-950">
                                                "This is / That's [Name]."<br>
                                                "She's / He's my [mother / father / brother / aunt / uncle / cousin / grandfather / grandmother]."
                                            </div>
                                        </div>
                                    </div>

                                    <!-- 4 Rounds of Interactive Speaking Dialogues -->
                                    <div class="space-y-3 pt-2">
                                        <div class="font-black text-slate-900 text-sm">Contoh Simulasi Percakapan 4 Ronde:</div>
                                        @foreach($gameData['sample_dialogues'] ?? [] as $d)
                                            <div class="p-4 rounded-2xl bg-slate-50 border border-slate-200 hover:border-blue-300 transition space-y-3">
                                                <div class="flex items-center justify-between">
                                                    <span class="px-2.5 py-0.5 rounded-full bg-slate-900 text-white text-[10px] font-black uppercase">Ronde {{ $d['step'] }}</span>
                                                    <span class="text-xs font-bold text-slate-500">Target: {{ $d['target'] }}</span>
                                                </div>
                                                
                                                <div class="grid grid-cols-1 md:grid-cols-2 gap-3 text-xs">
                                                    <!-- Question -->
                                                    <div class="p-3 rounded-xl bg-white border border-indigo-100 flex items-start justify-between gap-2">
                                                        <div>
                                                            <div class="font-black text-indigo-700">{{ $d['asker'] }}</div>
                                                            <div class="text-slate-900 font-bold mt-1 text-sm">"{{ $d['question_en'] }}"</div>
                                                            <div class="text-slate-500 mt-0.5">{{ $d['question_id'] }}</div>
                                                        </div>
                                                        <button @click="speakText(@js($d['question_en']))" class="p-1.5 rounded-lg bg-indigo-50 text-indigo-700 hover:bg-indigo-600 hover:text-white transition shrink-0">
                                                            <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 24 24"><path d="M3 9v6h4l5 5V4L7 9H3zm13.5 3c0-1.77-1.02-3.29-2.5-4.03v8.05c1.48-.73 2.5-2.25 2.5-4.02z"/></svg>
                                                        </button>
                                                    </div>

                                                    <!-- Answer -->
                                                    <div class="p-3 rounded-xl bg-white border border-emerald-100 flex items-start justify-between gap-2">
                                                        <div>
                                                            <div class="font-black text-emerald-700">{{ $d['answerer'] }}</div>
                                                            <div class="text-slate-900 font-bold mt-1 text-sm">"{{ $d['answer_en'] }}"</div>
                                                            <div class="text-slate-500 mt-0.5">{{ $d['answer_id'] }}</div>
                                                        </div>
                                                        <button @click="speakText(@js($d['answer_en']))" class="p-1.5 rounded-lg bg-emerald-50 text-emerald-700 hover:bg-emerald-600 hover:text-white transition shrink-0">
                                                            <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 24 24"><path d="M3 9v6h4l5 5V4L7 9H3zm13.5 3c0-1.77-1.02-3.29-2.5-4.03v8.05c1.48-.73 2.5-2.25 2.5-4.02z"/></svg>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>

                            <!-- ==================================================== -->
                            <!-- TAB 5: TEACHER'S LESSON PLAN & CLASSROOM LANGUAGE    -->
                            <!-- ==================================================== -->
                            <div x-show="gameTab === 'guide'" class="space-y-6">
                                <div class="bg-white rounded-[2rem] p-6 sm:p-8 shadow-sm border border-slate-200/90 space-y-6">
                                    <div class="pb-4 border-b border-slate-100 flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                                        <div>
                                            <span class="px-3 py-1 rounded-full bg-slate-900 text-white text-xs font-black uppercase">Teacher's Guide</span>
                                            <h3 class="text-xl sm:text-2xl font-black text-slate-900 mt-2">Panduan Aktivitas Kelas (Lesson Plan &amp; Classroom Language)</h3>
                                            <p class="text-xs sm:text-sm text-slate-500 font-medium mt-1">Panduan lengkap instruksi untuk tutor memimpin simulasi berpasangan di Zoom atau tatap muka.</p>
                                        </div>
                                        <div class="flex items-center gap-2">
                                            <button @click="activeModal = 'guide1_full'" class="px-3.5 py-2 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-800 font-black text-xs transition">
                                                Scan Panduan 1 📄
                                            </button>
                                            <button @click="activeModal = 'guide2_full'" class="px-3.5 py-2 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-800 font-black text-xs transition">
                                                Scan Panduan 2 📄
                                            </button>
                                        </div>
                                    </div>

                                    <!-- 4 Step Implementation Flow -->
                                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                                        <div class="p-4 rounded-2xl bg-slate-50 border border-slate-200 space-y-2">
                                            <div class="w-7 h-7 rounded-xl bg-blue-600 text-white font-black text-xs flex items-center justify-center">1</div>
                                            <div class="font-black text-slate-900 text-sm">Bagi Menjadi Pasangan (A &amp; B)</div>
                                            <p class="text-xs text-slate-600">Bagi kelas berpasangan (Siswa A dan Siswa B). Berikan foto pernikahan kepada keduanya.</p>
                                        </div>
                                        <div class="p-4 rounded-2xl bg-slate-50 border border-slate-200 space-y-2">
                                            <div class="w-7 h-7 rounded-xl bg-indigo-600 text-white font-black text-xs flex items-center justify-center">2</div>
                                            <div class="font-black text-slate-900 text-sm">Bagikan Silsilah Rahasia</div>
                                            <p class="text-xs text-slate-600">Berikan Family Tree A ke Siswa A, dan Family Tree B ke Siswa B. Masing-masing menjaga kerahasiaan pohonnya.</p>
                                        </div>
                                        <div class="p-4 rounded-2xl bg-slate-50 border border-slate-200 space-y-2">
                                            <div class="w-7 h-7 rounded-xl bg-amber-600 text-white font-black text-xs flex items-center justify-center">3</div>
                                            <div class="font-black text-slate-900 text-sm">Tanya &amp; Jawab Bergantian</div>
                                            <p class="text-xs text-slate-600">Siswa saling bertanya <em>"Who's that?"</em> dan menjawab <em>"That's... She's/He's my..."</em>.</p>
                                        </div>
                                        <div class="p-4 rounded-2xl bg-slate-50 border border-slate-200 space-y-2">
                                            <div class="w-7 h-7 rounded-xl bg-emerald-600 text-white font-black text-xs flex items-center justify-center">4</div>
                                            <div class="font-black text-slate-900 text-sm">Tulis Nama &amp; Verifikasi</div>
                                            <p class="text-xs text-slate-600">Setiap siswa mengetikkan nama di foto pernikahan dan menekan tombol periksa jawaban.</p>
                                        </div>
                                    </div>

                                    <!-- Classroom Language Box -->
                                    <div class="p-5 rounded-2xl bg-blue-50/60 border border-blue-200 space-y-3">
                                        <div class="flex items-center justify-between">
                                            <div class="font-black text-blue-950 text-sm flex items-center gap-2">
                                                <span>🎙️</span> <span>Authentic Classroom Language Script (Bahasa Instruksi Tutor):</span>
                                            </div>
                                            <button @click="speakText('Listen. A, B, you two work together. Look, here is a wedding photo. A, this is your sister Ann. B, this is your brother Tim. Ann is marrying Tim. This is your family tree A, keep it secret. This is your family tree B, keep it secret. Ask each other: Who is that? and write the names on the photo.')"
                                                class="px-3 py-1 rounded-xl bg-blue-600 text-white font-bold text-xs hover:bg-blue-700 transition flex items-center gap-1">
                                                <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 24 24"><path d="M3 9v6h4l5 5V4L7 9H3zm13.5 3c0-1.77-1.02-3.29-2.5-4.03v8.05c1.48-.73 2.5-2.25 2.5-4.02z"/></svg>
                                                <span>Putar Audio Instruksi</span>
                                            </button>
                                        </div>
                                        <div class="p-4 rounded-xl bg-white border border-blue-200 text-xs leading-relaxed text-slate-700 font-mono space-y-1">
                                            <div>"Listen. A, B, you two work together."</div>
                                            <div>"Look. Here is a wedding photo. Who is A? Raise your hand. This is your sister Ann."</div>
                                            <div>"Who is B? Raise your hand. This is your brother Tim."</div>
                                            <div>"A's sister is marrying B's brother. A's family is on one side, and B's family is on the other side."</div>
                                            <div>"Don't show your family tree to your partner! Ask each other: 'Who's that?' and answer: 'That's Jane. She's my mother.'"</div>
                                            <div>"Then write all the names on your photo worksheet. OK? Let's work together!"</div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- ==================================================== -->
                            <!-- POPUP MODALS (FULL IMAGE VIEWERS)                   -->
                            <!-- ==================================================== -->
                            <div x-show="activeModal !== null" x-cloak
                                 class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-950/80 backdrop-blur-sm"
                                 @keydown.escape.window="activeModal = null">
                                
                                <div class="bg-white rounded-3xl max-w-5xl w-full max-h-[92vh] overflow-hidden shadow-2xl flex flex-col" @click.outside="activeModal = null">
                                    <!-- Modal Header -->
                                    <div class="px-6 py-4 bg-slate-900 text-white flex items-center justify-between">
                                        <div class="font-black text-sm sm:text-base flex items-center gap-2">
                                            <span x-show="activeModal === 'photo_full'">📸 The Big Wedding Photograph</span>
                                            <span x-show="activeModal === 'tree_a_full'">👰 Family Tree A (Bride's Family - Ann's Side)</span>
                                            <span x-show="activeModal === 'tree_b_full'">🤵 Family Tree B (Groom's Family - Tim's Side)</span>
                                            <span x-show="activeModal === 'trees_full'">🌳 Family Trees (A &amp; B)</span>
                                            <span x-show="activeModal === 'guide1_full'">📄 Teacher's Guide Page 1</span>
                                            <span x-show="activeModal === 'guide2_full'">📄 Teacher's Guide Page 2 (Classroom Language)</span>
                                        </div>
                                        <div class="flex items-center gap-2">
                                            <template x-if="activeModal === 'photo_full'">
                                                <div class="bg-white/10 p-0.5 rounded-xl flex items-center text-xs">
                                                    <button type="button" @click="photoMode = 'color'"
                                                        :class="photoMode === 'color' ? 'bg-indigo-600 text-white font-black shadow-xs' : 'text-slate-300 hover:text-white'"
                                                        class="px-2.5 py-1 rounded-lg transition">
                                                        Warna
                                                    </button>
                                                    <button type="button" @click="photoMode = 'sketch'"
                                                        :class="photoMode === 'sketch' ? 'bg-white text-slate-900 font-black shadow-xs' : 'text-slate-300 hover:text-white'"
                                                        class="px-2.5 py-1 rounded-lg transition">
                                                        Sketsa
                                                    </button>
                                                </div>
                                            </template>
                                            <button @click="activeModal = null" class="p-1.5 rounded-xl bg-white/10 hover:bg-white/20 text-white transition">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                                            </button>
                                        </div>
                                    </div>

                                    <!-- Modal Image Body -->
                                    <div class="p-4 overflow-y-auto flex-1 flex items-center justify-center bg-slate-900/10">
                                        <template x-if="activeModal === 'photo_full'">
                                            <div>
                                                <img x-show="photoMode === 'color'" src="{{ asset('images/speaking/wedding_photos/wedding_photo_hd.jpg?v=14') }}" class="max-w-full max-h-[78vh] object-contain rounded-xl shadow-lg">
                                                <img x-show="photoMode === 'sketch'" src="{{ asset('images/speaking/wedding_photos/wedding_photo_upright.png') }}" class="max-w-full max-h-[78vh] object-contain rounded-xl shadow-lg">
                                            </div>
                                        </template>
                                        <template x-if="activeModal === 'tree_a_full'">
                                            <div>
                                                <img x-show="photoMode === 'color'" src="{{ asset('images/speaking/wedding_photos/family_tree_a_hd.jpg?v=13') }}" class="max-w-full max-h-[78vh] object-contain rounded-xl shadow-md">
                                                <img x-show="photoMode === 'sketch'" src="{{ asset('images/speaking/wedding_photos/family_tree_a.png') }}" class="max-w-full max-h-[78vh] object-contain rounded-xl shadow-md">
                                            </div>
                                        </template>
                                        <template x-if="activeModal === 'tree_b_full'">
                                            <div>
                                                <img x-show="photoMode === 'color'" src="{{ asset('images/speaking/wedding_photos/family_tree_b_hd.jpg?v=14') }}" class="max-w-full max-h-[78vh] object-contain rounded-xl shadow-md">
                                                <img x-show="photoMode === 'sketch'" src="{{ asset('images/speaking/wedding_photos/family_tree_b.png') }}" class="max-w-full max-h-[78vh] object-contain rounded-xl shadow-md">
                                            </div>
                                        </template>
                                        <template x-if="activeModal === 'trees_full'">
                                            <img src="{{ asset('images/speaking/wedding_photos/family_trees.png') }}" class="max-w-full max-h-[78vh] object-contain rounded-xl shadow-md">
                                        </template>
                                        <template x-if="activeModal === 'guide1_full'">
                                            <img src="{{ asset('images/speaking/wedding_photos/teacher_guide_1.png') }}" class="max-w-full max-h-[78vh] object-contain rounded-xl shadow-md">
                                        </template>
                                        <template x-if="activeModal === 'guide2_full'">
                                            <img src="{{ asset('images/speaking/wedding_photos/teacher_guide_2.png') }}" class="max-w-full max-h-[78vh] object-contain rounded-xl shadow-md">
                                        </template>
                                    </div>

                                    <!-- Modal Footer -->
                                    <div class="px-6 py-3 bg-white border-t border-slate-200 flex items-center justify-between text-xs text-slate-500 font-bold">
                                        <span>Gunakan zoom browser untuk membaca detail gambar.</span>
                                        <button type="button" @click="activeModal = null" class="px-5 py-2 rounded-xl bg-slate-900 text-white font-black hover:bg-slate-800 transition">
                                            Tutup
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @else
                        <!-- Main Game Header & Mode Controls -->
                        <div class="bg-white rounded-[2rem] p-6 sm:p-8 shadow-sm border border-slate-200/90 relative overflow-hidden">
                            <div class="absolute -top-10 -right-10 w-48 h-48 bg-sky-200/30 rounded-full blur-2xl pointer-events-none"></div>

                        <div class="relative z-10 flex flex-col lg:flex-row lg:items-center justify-between pb-6 mb-6 border-b border-slate-100 gap-6">
                            <div>
                                <div class="flex items-center gap-2 mb-2.5 flex-wrap">
                                    <span style="background-color: #29a8f5 !important;" class="px-3.5 py-1 rounded-full text-xs font-black text-white shadow-xs">
                                        {{ $gameData['title'] ?? 'Zoom Speaking Game' }}
                                    </span>
                                    <span style="background-color: #ff9800 !important;" class="px-3 py-1 rounded-full text-xs font-black text-white shadow-xs">
                                        Waktu: {{ $gameData['time'] ?? '15-20 Menit' }}
                                    </span>
                                    <span style="background-color: #f0f9ff !important; color: #0284c7 !important; border: 1px solid #bae6fd !important;" class="px-3 py-1 rounded-full text-xs font-black">
                                        {{ count($gameData['cards'] ?? []) }} Siswa di Kelas
                                    </span>
                                    <span class="px-3 py-1 rounded-full bg-emerald-400 text-slate-950 text-xs font-black uppercase">
                                        {{ $participationBadge['icon'] }} {{ $participationBadge['label'] }}
                                    </span>
                                </div>
                                <h2 class="text-2xl sm:text-3xl font-black text-slate-900 tracking-tight">
                                    {{ $gameData['title'] ?? 'Zoom Speaking Game: Class Ice-Breaker Survey' }}
                                </h2>
                                <p class="text-xs sm:text-sm text-slate-600 font-semibold mt-1">
                                    <strong style="color: #29a8f5;">AIM:</strong> {{ $gameData['aim'] ?? 'To find out information about members of the class by asking and answering questions.' }}
                                </p>
                            </div>

                            <!-- Random Card Drawer Button & Mode Toggle -->
                            <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-3 shrink-0">
                                <button @click="drawRandomCard()" type="button" style="background-color: #29a8f5 !important;" class="px-6 py-3.5 rounded-2xl hover:bg-sky-600 text-white font-black text-sm shadow-lg shadow-sky-400/25 transition flex items-center justify-center gap-2.5 hover:scale-105">
                                    <svg class="w-4 h-4" :class="isDrawing ? 'animate-spin inline-block' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg>
                                    <span x-text="selectedStudentCard ? 'Ganti / Acak Ulang Kartu' : 'Ambil Kartu Misi Acak Saya'"></span>
                                </button>

                                <div class="flex items-center bg-slate-100 p-1 rounded-2xl border border-slate-200 text-xs font-bold">
                                    <button @click="gameViewMode = 'student'" :style="gameViewMode === 'student' ? 'background-color: #29a8f5 !important; color: #ffffff !important;' : ''" :class="gameViewMode === 'student' ? 'shadow-xs font-black' : 'text-slate-600 hover:text-slate-900'" class="px-3.5 py-2 rounded-xl transition">
                                        Misi Saya
                                    </button>
                                    <button @click="gameViewMode = 'all'" :style="gameViewMode === 'all' ? 'background-color: #ff9800 !important; color: #ffffff !important;' : ''" :class="gameViewMode === 'all' ? 'shadow-xs font-black' : 'text-slate-600 hover:text-slate-900'" class="px-3.5 py-2 rounded-xl transition">
                                        Semua {{ count($gameData['cards'] ?? []) }} Kartu
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Game Procedures & Rules Grid (Teacher Management vs Student Gameplay - Blue & Orange Theme) -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5 mb-6">
                            <!-- Left: Grammar & Vocab Focus (Blue Container Theme) -->
                            <div style="background-color: #f0f9ff !important; border-color: #bae6fd !important;" class="p-6 rounded-[2rem] border-2 flex flex-col justify-between shadow-xs">
                                <div>
                                    <div class="flex items-center gap-2 mb-2.5">
                                        <span style="background-color: #29a8f5 !important;" class="w-6 h-6 rounded-lg text-white font-black text-xs flex items-center justify-center shadow-2xs">G</span>
                                        <h4 style="color: #0284c7 !important;" class="text-xs font-black uppercase tracking-wider">Grammar &amp; Vocabulary Focus</h4>
                                    </div>
                                    <p class="text-xs sm:text-sm text-sky-950 font-semibold leading-relaxed mb-3">
                                        <strong style="color: #0284c7;">Grammar:</strong> WH-Questions (<em>what, who, when, where, how</em>) &amp; Auxiliary verbs.<br>
                                        <strong style="color: #0284c7;">Vocabulary:</strong> Personal information, routines, hobbies, travel, &amp; daily habits.
                                    </p>
                                </div>
                                <div style="background-color: #ffffff !important; border-color: #7dd3fc !important; color: #0369a1 !important;" class="p-3 rounded-2xl border text-[11px] font-black flex items-center gap-1.5 shadow-2xs">
                                    <svg class="w-4 h-4 text-sky-500 shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                                    <span>Target: Melatih kelancaran bertanya dan merespons secara spontan.</span>
                                </div>
                            </div>

                            <!-- Right: Role-Based Rules Switcher (Orange Container Theme) -->
                            <div style="background-color: #fff7ed !important; border-color: #fed7aa !important;" class="p-6 rounded-[2rem] border-2 flex flex-col justify-between shadow-xs" x-data="{ roleRuleTab: '{{ (auth()->user()?->role ?? '') === 'student' ? 'student' : 'teacher' }}' }">
                                <div>
                                    <div class="flex items-center justify-between gap-2 pb-3 mb-3 border-b border-orange-200">
                                        <div class="flex items-center gap-2">
                                            <span style="background-color: #ff9800 !important;" class="w-6 h-6 rounded-lg text-white font-black text-xs flex items-center justify-center shadow-2xs">R</span>
                                            <h4 style="color: #c2410c !important;" class="text-xs font-black uppercase tracking-wider">Panduan &amp; Aturan Main</h4>
                                        </div>

                                        <!-- Role Switcher Pills -->
                                        <div class="flex items-center bg-white p-0.5 rounded-xl border border-orange-200 text-[11px] font-bold shadow-2xs">
                                            <button @click="roleRuleTab = 'teacher'" :style="roleRuleTab === 'teacher' ? 'background-color: #ff9800 !important; color: #ffffff !important;' : ''" :class="roleRuleTab === 'teacher' ? 'shadow-2xs font-black' : 'text-slate-600 hover:text-orange-600'" class="px-2.5 py-1 rounded-lg transition">
                                                Guru / Admin
                                            </button>
                                            <button @click="roleRuleTab = 'student'" :style="roleRuleTab === 'student' ? 'background-color: #29a8f5 !important; color: #ffffff !important;' : ''" :class="roleRuleTab === 'student' ? 'shadow-2xs font-black' : 'text-slate-600 hover:text-sky-600'" class="px-2.5 py-1 rounded-lg transition">
                                                Siswa
                                            </button>
                                        </div>
                                    </div>

                                    <!-- TEACHER / ADMIN FACILITATION GUIDE (Tata Kelola Permainan di Kelas) -->
                                    <div x-show="roleRuleTab === 'teacher'" x-transition class="space-y-2">
                                        <div class="flex items-center gap-1.5 text-xs font-bold text-orange-950 mb-1">
                                            <span style="background-color: #ffedd5 !important; color: #c2410c !important;" class="px-2 py-0.5 rounded-md text-[10px] font-black uppercase">Tata Kelola Guru</span>
                                            <span>Langkah Pengelolaan Kelas:</span>
                                        </div>
                                        <ol class="text-xs text-orange-950 space-y-1.5 font-medium list-decimal list-inside leading-relaxed">
                                            <li><strong>Distribusi Kartu:</strong> Pastikan tiap siswa mengambil 1 nomor kartu misi acak (tersedia {{ count($gameData['cards'] ?? []) }} kartu).</li>
                                            <li><strong>Aktivitas Interaksi:</strong> Arahkan siswa untuk saling mewawancarai teman di Kelas / Kelompok.</li>
                                            <li><strong>Follow-Up Prompt:</strong> Ingatkan siswa melontarkan pertanyaan lanjutan (misal: <em>"Where did you go?" &rarr; "Did you like it?"</em>).</li>
                                            <li><strong>Sesi Report Back:</strong> Minta tiap siswa membacakan laporan kesimpulan hasil surveinya ke seluruh kelas.</li>
                                        </ol>
                                    </div>

                                    <!-- STUDENT GAMEPLAY RULES (Cara Main Siswa) -->
                                    <div x-show="roleRuleTab === 'student'" x-transition class="space-y-2">
                                        <div class="flex items-center gap-1.5 text-xs font-bold text-sky-950 mb-1">
                                            <span style="background-color: #e0f2fe !important; color: #0369a1 !important;" class="px-2 py-0.5 rounded-md text-[10px] font-black uppercase">Petunjuk Siswa</span>
                                            <span>Cara Main di Kelas:</span>
                                        </div>
                                        <ol class="text-xs text-sky-950 space-y-1.5 font-medium list-decimal list-inside leading-relaxed">
                                            <li><strong>Ambil Kartu Misi:</strong> Klik tombol <em>"Ambil Kartu Misi Acak Saya"</em> untuk mendapatkan misi investigasimu.</li>
                                            <li><strong>Tanya Teman di Kelas:</strong> Nyalakan mikrofon, ajukan pertanyaan di kartumu ke setiap teman sekelas.</li>
                                            <li><strong>Catat di Survey Pad:</strong> Masukkan nama teman dan jawabannya pada formulir survey interaktif di bawah.</li>
                                            <li><strong>Bacakan Laporan:</strong> Tekan tombol audio untuk berlatih, lalu sampaikan temuanmu ke guru dan kelas!</li>
                                        </ol>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- STUDENT ACTIVE MISSION SPOTLIGHT (When card is selected) -->
                        <template x-if="selectedStudentCard">
                            <div style="background-color: #29a8f5 !important;" class="mb-8 p-6 sm:p-8 rounded-3xl text-white shadow-xl relative overflow-hidden">
                                <div class="absolute inset-0 bg-[radial-gradient(#ffffff_1px,transparent_1px)] [background-size:24px_24px] opacity-10 pointer-events-none"></div>

                                <div class="relative z-10">
                                    <div class="flex items-center justify-between gap-4 pb-4 mb-5 border-b border-white/25 flex-wrap">
                                        <div class="flex items-center gap-2.5">
                                            <span class="w-8 h-8 rounded-full bg-white text-sky-600 font-black text-sm flex items-center justify-center shadow-md" x-text="selectedStudentCard.id"></span>
                                            <span style="background-color: #ff9800 !important; color: #ffffff !important;" class="px-3.5 py-1 rounded-full font-black text-xs uppercase shadow-xs" x-text="selectedStudentCard.badge"></span>
                                            <span class="text-xs font-bold text-sky-100">Kartu Misi Terpilih Anda</span>
                                        </div>

                                        <!-- Quick Student Number Selector Dropdown -->
                                        <div class="flex items-center gap-2 text-xs">
                                            <span class="text-white font-semibold">Ganti No Siswa:</span>
                                            <select @change="selectCardById($event.target.value)" class="bg-white/20 border border-white/40 text-white rounded-xl px-2.5 py-1 text-xs font-bold focus:outline-none">
                                                <template x-for="c in gameCards" :key="c.id">
                                                    <option :value="c.id" :selected="c.id === selectedStudentCard.id" class="text-slate-900" x-text="'Student #' + c.id + ' (' + c.badge + ')'"></option>
                                                </template>
                                            </select>
                                        </div>
                                    </div>

                                    <h3 class="text-2xl sm:text-3xl font-black text-white mb-2 leading-snug" x-text="'&ldquo;' + selectedStudentCard.title + '&rdquo;'"></h3>

                                    <!-- 1. FULL WIDTH CARD IMAGE (100% Bleed) -->
                                    <div class="my-6 w-full rounded-2xl sm:rounded-3xl shadow-2xl overflow-hidden bg-white border-2 border-white/90">
                                        <img :src="selectedStudentCard.image" :alt="selectedStudentCard.title" class="w-full h-auto object-contain block">
                                    </div>

                                    <!-- 2. QUESTION & ANSWER HELPERS (BELOW THE CARD) -->
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                                        <!-- Question Box -->
                                        <div class="p-5 sm:p-6 rounded-2xl bg-white text-slate-900 shadow-md border-2 border-sky-200 flex flex-col justify-between">
                                            <div>
                                                <div class="flex items-center justify-between mb-2">
                                                    <span style="color: #29a8f5 !important;" class="text-[10px] sm:text-xs font-black uppercase tracking-wider">Pertanyaan yang Harus Kamu Tanyakan di Kelas:</span>
                                                    <button @click="speakText(selectedStudentCard.question)" style="color: #29a8f5 !important;" class="hover:text-sky-700 p-1 flex items-center gap-1 text-xs font-black" title="Listen Question">
                                                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M3 9v6h4l5 5V4L7 9H3zm13.5 3c0-1.77-1.02-3.29-2.5-4.03v8.05c1.48-.73 2.5-2.25 2.5-4.02z"/></svg>
                                                        <span>Listen</span>
                                                    </button>
                                                </div>
                                                <p class="text-base sm:text-xl font-black text-slate-900 leading-snug" x-text="'&ldquo;' + selectedStudentCard.question + '&rdquo;'"></p>
                                            </div>
                                        </div>

                                        <!-- Answer Target Box -->
                                        <div style="background-color: rgba(255, 255, 255, 0.18) !important; border: 2px solid rgba(255, 255, 255, 0.45) !important;" class="p-5 sm:p-6 rounded-2xl text-white flex flex-col justify-between backdrop-blur-md">
                                            <div>
                                                <span class="text-[10px] sm:text-xs font-black uppercase tracking-wider block mb-2 text-white/90">Contoh Pola Jawaban Teman:</span>
                                                <p class="text-sm sm:text-base font-bold text-white leading-relaxed" x-text="selectedStudentCard.sample_answer"></p>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- LIVE SURVEY PAD: LOG CLASSMATES ANSWERS -->
                                    <div class="bg-white rounded-3xl p-6 text-slate-900 shadow-lg border-2 border-sky-100">
                                        <div class="flex items-center justify-between pb-4 mb-4 border-b border-slate-100">
                                            <div class="flex items-center gap-2">
                                                <h4 class="font-black text-base text-slate-900">Catatan Temuan Tanya Jawab di Kelas</h4>
                                            </div>
                                            <span style="background-color: #f0f9ff !important; color: #0284c7 !important; border: 1px solid #bae6fd !important;" class="px-3 py-1 rounded-full font-black text-xs" x-text="'Total Teman: ' + surveyResponses.length + ' Siswa'"></span>
                                        </div>

                                        <!-- Add Friend Response Form -->
                                        <form @submit.prevent="addSurveyResponse()" class="flex flex-col sm:flex-row items-center gap-3 mb-5">
                                            <input type="text" x-model="surveyNameInput" placeholder="Nama Teman (e.g. Student A)" class="w-full sm:w-1/3 px-4 py-2.5 rounded-xl border border-slate-300 text-xs sm:text-sm font-medium focus:ring-2 focus:ring-sky-500 focus:outline-none">
                                            <input type="text" x-model="surveyAnswerInput" placeholder="Jawaban Teman (e.g. Reading books / Jakarta / 20 years old)" class="w-full sm:flex-1 px-4 py-2.5 rounded-xl border border-slate-300 text-xs sm:text-sm font-medium focus:ring-2 focus:ring-sky-500 focus:outline-none">
                                            <button type="submit" style="background-color: #29a8f5 !important;" class="w-full sm:w-auto px-5 py-2.5 rounded-xl hover:bg-sky-600 text-white font-black text-xs sm:text-sm shadow-md transition shrink-0">
                                                + Catat Teman
                                            </button>
                                        </form>

                                        <!-- Survey Response Table / Badges -->
                                        <template x-if="surveyResponses.length > 0">
                                            <div class="space-y-2 mb-4 max-h-48 overflow-y-auto pr-1">
                                                <template x-for="(resp, idx) in surveyResponses" :key="resp.id">
                                                    <div class="p-3 rounded-xl bg-slate-50 border border-slate-200/80 flex items-center justify-between gap-3 text-xs sm:text-sm">
                                                        <div class="flex items-center gap-2">
                                                            <span style="background-color: #29a8f5 !important;" class="w-5 h-5 rounded-full text-white text-[11px] font-black flex items-center justify-center shadow-xs" x-text="idx + 1"></span>
                                                            <span class="font-black text-slate-900" x-text="resp.name + ':'"></span>
                                                            <span class="font-semibold text-sky-950" x-text="resp.answer"></span>
                                                        </div>
                                                        <button @click="removeSurveyResponse(resp.id)" class="text-slate-400 hover:text-red-600 text-xs font-bold">Hapus</button>
                                                    </div>
                                                </template>
                                            </div>
                                        </template>

                                        <!-- Generated Report Preview -->
                                        <div style="background-color: #fff7ed !important; border: 1.5px solid #fed7aa !important;" class="p-4 rounded-2xl">
                                            <div class="flex items-center justify-between mb-1.5">
                                                <span style="color: #c2410c !important;" class="text-[10px] font-black uppercase tracking-wider">Laporan Hasil Anda ke Kelas (Report Back):</span>
                                                <button @click="speakText(getReportText())" type="button" style="color: #ea580c !important;" class="text-xs font-black hover:underline flex items-center gap-1">
                                                    <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 24 24"><path d="M3 9v6h4l5 5V4L7 9H3zm13.5 3c0-1.77-1.02-3.29-2.5-4.03v8.05c1.48-.73 2.5-2.25 2.5-4.02z"/></svg>
                                                    <span>Latih Baca Laporan</span>
                                                </button>
                                            </div>
                                            <p class="text-xs sm:text-sm font-black text-orange-950 leading-relaxed" x-text="getReportText()"></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </template>

                        <!-- PROMPT IF NO CARD DRAWN YET IN STUDENT MODE -->
                        <template x-if="!selectedStudentCard && gameViewMode === 'student'">
                            <div style="background-color: #f8fafc !important; border: 2px dashed #bae6fd !important;" class="p-8 sm:p-12 rounded-3xl text-center mb-8">
                                <div style="background-color: #29a8f5 !important;" class="w-16 h-16 rounded-3xl text-white flex items-center justify-center mx-auto shadow-lg shadow-sky-400/30 mb-4"><svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg></div>
                                <h3 class="text-xl font-black text-slate-900 mb-2">Belum Mengambil Kartu Misi</h3>
                                <p class="text-xs sm:text-sm text-slate-600 max-w-md mx-auto mb-6 font-medium">
                                    Klik tombol di bawah untuk mendapatkan 1 dari {{ count($gameData['cards'] ?? []) }} kartu investigasi secara acak untuk ditanyakan ke teman-teman di kelas!
                                </p>
                                <button @click="drawRandomCard()" type="button" style="background-color: #29a8f5 !important;" class="px-8 py-3.5 rounded-full text-white font-black text-sm shadow-xl shadow-sky-400/30 transition hover:scale-105 hover:bg-sky-600">
                                    Ambil Kartu Misi Acak Saya Sekarang
                                </button>
                            </div>
                        </template>

                        <!-- 14 FIND OUT MISSION CARDS GRID (Visible in All Cards Mode or below) -->
                        <div x-show="gameViewMode === 'all'" x-transition>
                            <div class="flex items-center justify-between mb-4">
                                <div class="flex items-center gap-2">
                                    <span style="background-color: #29a8f5 !important;" class="w-6 h-6 rounded-lg text-white font-black text-xs flex items-center justify-center shadow-2xs">{{ count($gameData['cards'] ?? []) }}</span>
                                    <h3 class="font-black text-lg text-slate-900">Daftar Lengkap {{ count($gameData['cards'] ?? []) }} Kartu Misi (Worksheet 1b)</h3>
                                </div>
                                <span class="text-xs font-bold text-slate-500">Pilih salah satu kartu untuk mulai investigasi</span>
                            </div>

                            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                                @foreach($gameData['cards'] ?? [] as $cIdx => $card)
                                    @php
                                        $isCardBlue = ($cIdx % 2 === 0);
                                        $cardThemeColor = $isCardBlue ? '#29a8f5' : '#ff9800';
                                        $cardBgColor = $isCardBlue ? '#f0f9ff' : '#fff7ed';
                                        $cardBorderColor = $isCardBlue ? '#bae6fd' : '#fed7aa';
                                        $cardTextColor = $isCardBlue ? '#0369a1' : '#c2410c';
                                    @endphp
                                    <div class="bg-white rounded-2xl p-5 border-2 border-slate-200 shadow-sm hover:shadow-md hover:border-sky-300 transition-all duration-200 flex flex-col justify-between group relative overflow-hidden">
                                        <!-- Paperclip Icon Decor -->
                                        <div class="absolute top-2.5 right-3.5 text-slate-300 group-hover:text-sky-500 transition-colors">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"></path></svg>
                                        </div>

                                        <div>
                                            <div class="flex items-center gap-2 mb-3">
                                                <span style="background-color: {{ $cardThemeColor }} !important;" class="w-6 h-6 rounded-full text-white text-xs font-black flex items-center justify-center shadow-2xs shrink-0">
                                                    {{ $card['id'] }}
                                                </span>
                                                <span class="text-[10px] font-extrabold uppercase px-2.5 py-0.5 rounded-full bg-slate-100 text-slate-700">
                                                    {{ $card['badge'] }}
                                                </span>
                                            </div>

                                            <!-- Card Illustration Visual (Full-Bleed HD) -->
                                            <div class="mb-3 rounded-xl overflow-hidden bg-white border border-slate-300 shadow-sm">
                                                <img src="{{ asset($card['image']) }}" alt="{{ $card['title'] }}" class="w-full h-auto object-contain block">
                                            </div>

                                            <div class="space-y-2 mb-3">
                                                <div style="background-color: {{ $cardBgColor }} !important; border: 1px solid {{ $cardBorderColor }} !important;" class="p-2.5 rounded-xl">
                                                    <p style="color: {{ $cardTextColor }} !important;" class="text-[10px] font-black uppercase tracking-wider">Tanyakan ke Teman:</p>
                                                    <p class="text-xs font-black text-slate-900 mt-0.5">"{{ $card['question'] }}"</p>
                                                </div>

                                                <div class="p-2.5 rounded-xl bg-slate-50 border border-slate-200/70">
                                                    <p class="text-[10px] font-extrabold uppercase tracking-wider text-slate-500">Pola Jawaban:</p>
                                                    <p class="text-xs font-medium text-slate-700 mt-0.5">{{ $card['sample_answer'] }}</p>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="pt-3 border-t border-slate-100 flex items-center justify-between gap-2">
                                            <button @click="selectCardById({{ $card['id'] }}); gameViewMode = 'student'" type="button" style="background-color: {{ $cardThemeColor }} !important;" class="w-full py-2.5 px-3 rounded-xl text-white text-xs font-black transition flex items-center justify-center gap-1.5 shadow-2xs hover:opacity-90">
                                                <span>Pilih Kartu Misi Ini</span>
                                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                                            </button>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <!-- Follow-up & Reporting Presentation Box (Vibrant High-Contrast Card) -->
                        <div class="mt-8 p-6 sm:p-8 rounded-3xl bg-gradient-to-br from-sky-50 via-orange-50/40 to-white border-2 border-sky-200/90 text-slate-900 shadow-sm relative overflow-hidden">
                            <div class="flex items-center gap-2.5 mb-2">
                                <span style="background-color: #29a8f5 !important;" class="px-3 py-1 rounded-full text-white font-black text-xs shadow-2xs">FOLLOW-UP</span>
                                <h3 class="font-black text-lg sm:text-xl text-slate-900 tracking-tight">Contoh Format Laporan Hasil Temuan ke Kelas</h3>
                            </div>
                            <p class="text-xs sm:text-sm text-slate-600 mb-5 font-medium">Setelah berkeliling menanyai teman-teman di kelas, presentasikan hasil temuanmu dengan pola kalimat berikut:</p>

                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3.5">
                                @php
                                    $reportThemes = [
                                        0 => ['card' => 'bg-sky-50/50 border-sky-200 hover:border-sky-400 text-sky-950', 'btn' => 'bg-[#29a8f5] hover:bg-[#1e88e5] text-white'],
                                        1 => ['card' => 'bg-orange-50/50 border-orange-200 hover:border-orange-400 text-orange-950', 'btn' => 'bg-[#ff9800] hover:bg-[#f57c00] text-white'],
                                        2 => ['card' => 'bg-sky-50/50 border-sky-200 hover:border-sky-400 text-sky-950', 'btn' => 'bg-[#29a8f5] hover:bg-[#1e88e5] text-white'],
                                        3 => ['card' => 'bg-orange-50/50 border-orange-200 hover:border-orange-400 text-orange-950', 'btn' => 'bg-[#ff9800] hover:bg-[#f57c00] text-white'],
                                    ];
                                @endphp
                                @foreach($gameData['report_examples'] ?? [] as $repIdx => $rep)
                                    @php $rth = $reportThemes[$repIdx % 4]; @endphp
                                    <div class="p-4 rounded-2xl border {{ $rth['card'] }} shadow-xs flex items-center justify-between gap-3 hover:shadow-md transition group bg-white">
                                        <p class="text-xs sm:text-sm font-black {{ $rth['card'] }} leading-snug">
                                            "{!! $rep !!}"
                                        </p>
                                        <button @click="speakText(@js($rep))" class="w-8 h-8 rounded-full {{ $rth['btn'] }} shadow-2xs transition flex items-center justify-center shrink-0 group-hover:scale-105" title="Listen Audio">
                                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M3 9v6h4l5 5V4L7 9H3zm13.5 3c0-1.77-1.02-3.29-2.5-4.03v8.05c1.48-.73 2.5-2.25 2.5-4.02z"/></svg>
                                        </button>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    @endif
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- ========================================== -->
                <div x-show="activeTab === 'extended'" class="space-y-6">
                    <!-- Vibrant Bright Blue & Orange AI Voice Canvas (Extra Tall Vertical Canvas) -->
                    <div style="background-color: #29a8f5 !important; border-radius: 2.5rem !important; min-height: 80vh !important;" class="w-full p-8 sm:p-14 py-24 sm:py-36 text-white shadow-2xl border-4 border-sky-300/40 relative overflow-hidden flex flex-col items-center justify-center min-h-[850px] sm:min-h-[950px]">
                        
                        <!-- Ambient Aura Glows in Brand Orange (#ff9800) & Radiant White -->
                        <div class="absolute -top-24 -left-24 w-96 h-96 rounded-full bg-white/20 blur-3xl pointer-events-none"></div>
                        <div class="absolute -bottom-24 -right-24 w-96 h-96 rounded-full bg-[#ff9800]/30 blur-3xl pointer-events-none"></div>
                        <div class="absolute inset-0 bg-[radial-gradient(#ffffff_1px,transparent_1px)] [background-size:32px_32px] opacity-15 pointer-events-none"></div>

                        <!-- CENTER HERO: Pulsing Target Bahasa Logo Orb (Perfect Dead Center) -->
                        <div class="relative z-10 flex flex-col items-center justify-center text-center my-auto py-8">
                            
                            <!-- Animated Concentric Sound Wave Rings (Perfect Circles) -->
                            <div class="relative flex items-center justify-center">
                                <!-- Outer Pulsing Aura -->
                                <div x-show="aiState === 'speaking'" style="width: 23rem !important; height: 23rem !important; border-radius: 9999px !important;" class="absolute aspect-square rounded-full border-4 border-white/60 animate-ping pointer-events-none"></div>
                                <div x-show="aiState === 'speaking'" style="width: 19rem !important; height: 19rem !important; border-radius: 9999px !important;" class="absolute aspect-square rounded-full bg-white/20 animate-pulse pointer-events-none"></div>
                                
                                <div x-show="aiState === 'listening'" style="width: 23rem !important; height: 23rem !important; border-radius: 9999px !important;" class="absolute aspect-square rounded-full border-4 border-[#ff9800] animate-ping pointer-events-none"></div>
                                <div x-show="aiState === 'listening'" style="width: 19rem !important; height: 19rem !important; border-radius: 9999px !important;" class="absolute aspect-square rounded-full bg-[#ff9800]/30 animate-pulse pointer-events-none"></div>

                                <!-- Idle Soft Glow -->
                                <div x-show="aiState === 'idle'" style="width: 18rem !important; height: 18rem !important; border-radius: 9999px !important;" class="absolute aspect-square rounded-full bg-white/20 animate-pulse pointer-events-none"></div>

                                <!-- Central White Circle with Target Bahasa Logo (Perfect 1:1 Circle) -->
                                <button @click="toggleAiInteraction()" 
                                    style="width: 15rem !important; height: 15rem !important; min-width: 15rem !important; min-height: 15rem !important; border-radius: 9999px !important;"
                                    class="aspect-square shrink-0 rounded-full bg-white shadow-[0_0_80px_rgba(255,255,255,0.85)] hover:shadow-[0_0_100px_rgba(255,152,0,0.9)] flex items-center justify-center p-8 sm:p-9 relative z-10 transition-all duration-500 hover:scale-105 active:scale-95 border-4 sm:border-8 border-white"
                                    :class="aiState === 'speaking' ? 'border-[#29a8f5] shadow-[0_0_90px_rgba(255,255,255,1)]' : (aiState === 'listening' ? 'border-[#ff9800] shadow-[0_0_90px_rgba(255,152,0,1)]' : 'border-white')">
                                    <img src="{{ asset('images/brand/icon.png') }}" alt="Target Bahasa Logo" style="width: 100% !important; height: 100% !important; object-fit: contain !important;" class="select-none pointer-events-none drop-shadow-md">
                                </button>
                            </div>

                            <!-- Live Status Pill (High Contrast & Generous Clean Spacing) -->
                            <div style="margin-top: 5.5rem !important;" class="flex items-center justify-center">
                                <template x-if="aiState === 'idle'">
                                    <span style="background-color: #ff9800 !important; color: #ffffff !important; border: 2px solid #ffffff !important;" class="inline-flex items-center gap-2 px-5 py-2 rounded-full text-xs font-black shadow-lg backdrop-blur-md">
                                        <span class="w-2.5 h-2.5 rounded-full bg-white animate-pulse"></span>
                                        <span>Klik Lingkaran Logo untuk Mulai Wawancara</span>
                                    </span>
                                </template>
                                <template x-if="aiState === 'speaking'">
                                    <span style="background-color: #0f172a !important; color: #ffffff !important; border: 2px solid #38bdf8 !important;" class="inline-flex items-center gap-2 px-5 py-2 rounded-full text-xs font-black shadow-xl backdrop-blur-md animate-pulse">
                                        <span style="background-color: #38bdf8 !important;" class="w-2.5 h-2.5 rounded-full"></span>
                                        <span>AI Examiner sedang berbicara...</span>
                                    </span>
                                </template>
                                <template x-if="aiState === 'listening'">
                                    <span style="background-color: #ff9800 !important; color: #ffffff !important; border: 2px solid #ffffff !important;" class="inline-flex items-center gap-2 px-5 py-2 rounded-full text-xs font-black shadow-lg backdrop-blur-md animate-pulse">
                                        <span class="w-2.5 h-2.5 rounded-full bg-white"></span>
                                        <span>Giliran Anda: Silakan bicara ke mikrofon...</span>
                                    </span>
                                </template>
                                <template x-if="aiState === 'finished'">
                                    <span style="background-color: #15803d !important; color: #ffffff !important; border: 2px solid #ffffff !important;" class="inline-flex items-center gap-2 px-5 py-2 rounded-full text-xs font-black shadow-lg backdrop-blur-md">
                                        <span class="w-2.5 h-2.5 rounded-full bg-white"></span>
                                        <span>Sesi Wawancara Selesai! Kerja yang luar biasa 🎉</span>
                                    </span>
                                </template>
                            </div>

                            <!-- Optional Toggle Button to Peek Text -->
                            <div class="mt-5 flex items-center justify-center gap-2">
                                <button @click="showQuestionText = !showQuestionText" type="button" class="inline-flex items-center gap-1.5 px-4 py-1.5 rounded-full bg-white/15 hover:bg-white/25 text-white text-xs font-bold backdrop-blur-md transition border border-white/25 shadow-xs">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                    </svg>
                                    <span x-text="showQuestionText ? 'Sembunyikan Teks Pertanyaan' : 'Tampilkan Teks Pertanyaan (Bantuan)'"></span>
                                </button>
                                {{-- Admin-only - "khusus admin" per the request, deliberately
                                     NOT shown to teachers even though they otherwise share
                                     access with admins elsewhere on this page. --}}
                                @if(Auth::user()?->isAdmin())
                                <button @click="openAiEditModal()" type="button" class="inline-flex items-center gap-1.5 px-4 py-1.5 rounded-full bg-amber-400/90 hover:bg-amber-400 text-slate-900 text-xs font-bold backdrop-blur-md transition border border-white/40 shadow-xs">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                    </svg>
                                    <span>Edit Pertanyaan (Admin)</span>
                                </button>
                                @endif
                            </div>

                            <!-- Question Card (Visible only when toggled on) -->
                            <div x-show="showQuestionText" x-transition class="mt-4 w-full max-w-2xl p-6 sm:p-8 rounded-3xl backdrop-blur-xl shadow-2xl" style="background-color: rgba(255, 255, 255, 0.18) !important; border: 2px solid rgba(255, 255, 255, 0.45) !important;">
                                <template x-if="currentAiQuestion">
                                    <div>
                                        <div class="flex items-center justify-center mb-2">
                                            <span style="background-color: #ff9800 !important; color: white !important;" class="px-3 py-0.5 rounded-full text-[10px] sm:text-xs font-black uppercase tracking-wider shadow-2xs">Pertanyaan AI Examiner</span>
                                        </div>
                                        <p class="text-base sm:text-xl font-black text-white leading-relaxed" x-text="'&ldquo;' + currentAiQuestion.question + '&rdquo;'"></p>
                                        <p x-show="currentAiQuestion.hint" style="background-color: rgba(0, 0, 0, 0.2) !important;" class="text-xs text-amber-200 mt-3 font-semibold p-2.5 rounded-xl border border-white/20" x-text="'💡 Petunjuk: ' + currentAiQuestion.hint"></p>
                                    </div>
                                </template>
                            </div>

                            <!-- User Live Spoken Transcript Feedback -->
                            <div x-show="userSpokenText" style="background-color: rgba(255, 152, 0, 0.3) !important; border: 2px solid rgba(255, 255, 255, 0.4) !important;" class="mt-3 w-full max-w-2xl p-4 rounded-2xl text-white text-xs sm:text-sm font-bold backdrop-blur-md">
                                <span class="text-amber-200 font-black">Suara Anda:</span> &ldquo;<span x-text="userSpokenText"></span>&rdquo;
                            </div>
                        </div>
                    </div>
                </div>

                @if(Auth::user()?->isAdmin())
                {{-- =========================================================
                     AI INTERVIEW QUESTIONS - ADMIN EDIT MODAL
                     Fixed overlay, admin-only (server-gated by this @if AND
                     the route's own role:admin middleware - see
                     SpeakingAdminController::updateAiInterviewQuestions()).
                     aiEditDraft is a working copy edited here; aiQuestions
                     (the array the interview itself reads from) is only
                     replaced once a save actually succeeds - Cancel/closing
                     this modal discards aiEditDraft with no other effect.
                     ========================================================= --}}
                {{-- class="flex items-center justify-center" (not inline
                     style) for the shown-state display is deliberate:
                     Alpine's x-show only ever writes `display:none` via
                     inline style and, when toggling back to shown, restores
                     whatever display the element would have from its
                     stylesheet/class rules - a plain `style="display:flex"`
                     gets silently lost that way (this exact bug already hit
                     - and was fixed the same way - in live-drawing.blade.php
                     earlier). A static class survives regardless of what
                     x-show does to the inline style attribute. --}}
                <div x-show="showAiEditModal" x-transition class="flex items-center justify-center" style="position:fixed; inset:0; z-index:999999; background:rgba(15,23,42,0.6); padding:1rem;" @click.self="showAiEditModal = false">
                    <div class="bg-white rounded-3xl shadow-2xl w-full max-w-2xl max-h-[85vh] flex flex-col overflow-hidden">
                        <div class="flex items-center justify-between px-6 py-4 border-b border-slate-200 shrink-0">
                            <h3 class="font-black text-slate-800 text-lg">Edit Pertanyaan AI Interview</h3>
                            <button @click="showAiEditModal = false" type="button" class="text-slate-400 hover:text-slate-600 text-2xl leading-none">&times;</button>
                        </div>

                        <div class="px-6 py-4 overflow-y-auto space-y-4 grow">
                            <p x-show="aiEditError" x-text="aiEditError" class="text-sm font-semibold text-rose-600 bg-rose-50 border border-rose-200 rounded-xl px-3 py-2"></p>

                            <template x-for="(q, idx) in aiEditDraft" :key="idx">
                                <div class="border border-slate-200 rounded-2xl p-4 space-y-2 relative">
                                    <div class="flex items-center justify-between">
                                        <span class="text-xs font-black uppercase tracking-wide text-slate-400" x-text="'Pertanyaan ' + (idx + 1)"></span>
                                        <button @click="aiEditDraft.splice(idx, 1)" type="button" x-show="aiEditDraft.length > 1" class="text-xs font-bold text-rose-500 hover:text-rose-700">Hapus</button>
                                    </div>
                                    <textarea x-model="q.question" rows="2" placeholder="Teks pertanyaan..." class="w-full text-sm rounded-xl border border-slate-300 p-2.5 focus:ring-2 focus:ring-sky-400 focus:border-sky-400"></textarea>
                                    <textarea x-model="q.hint" rows="2" placeholder="Petunjuk jawaban (opsional)..." class="w-full text-xs rounded-xl border border-slate-200 bg-slate-50 p-2.5 focus:ring-2 focus:ring-sky-400 focus:border-sky-400"></textarea>
                                </div>
                            </template>

                            <button @click="aiEditDraft.push({ question: '', hint: '' })" type="button" class="w-full text-sm font-bold text-sky-700 bg-sky-50 hover:bg-sky-100 border-2 border-dashed border-sky-300 rounded-2xl py-2.5 transition">
                                + Tambah Pertanyaan
                            </button>
                        </div>

                        <div class="flex items-center justify-between gap-3 px-6 py-4 border-t border-slate-200 shrink-0">
                            <button @click="resetAiInterviewQuestionsToDefault()" type="button" :disabled="aiEditSaving" class="text-xs font-bold text-slate-500 hover:text-rose-600 transition">
                                Reset ke Default
                            </button>
                            <div class="flex items-center gap-2">
                                <button @click="showAiEditModal = false" type="button" :disabled="aiEditSaving" class="px-4 py-2 rounded-xl text-sm font-bold text-slate-600 bg-slate-100 hover:bg-slate-200 transition">
                                    Batal
                                </button>
                                <button @click="saveAiInterviewQuestions()" type="button" :disabled="aiEditSaving" class="px-5 py-2 rounded-xl text-sm font-bold text-white bg-sky-600 hover:bg-sky-700 disabled:opacity-60 transition" x-text="aiEditSaving ? 'Menyimpan...' : 'Simpan'">
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                @endif
            </div>

            @if(Auth::user()?->isAdmin() || Auth::user()?->isTeacher())
                @php
                    $primaryGame = $games[0] ?? null;
                    $primaryGameType = $primaryGame['type'] ?? 'default';
                    $primaryParticipationType = $primaryGame['participation_type'] ?? 'pair';
                    $knownBespokeGameTypes = ['wedding_photos', 'how_many_kitchen', 'tourist_in_town'];
                    $currentMeetingGroups = $meetingStudentGroups->filter(fn ($grp) => $grp->game_index === null || $grp->game_index === 0)->values();
                @endphp
                <!-- 👑 GLOBAL FLOATING ADMIN ROLE CONTROLLER BAR (ALL TABS EXCEPT AI INTERVIEW) -->
                <div x-show="activeTab !== 'extended'" 
                     x-transition:enter="transition ease-out duration-200" 
                     x-transition:enter-start="opacity-0 translate-y-4" 
                     x-transition:enter-end="opacity-100 translate-y-0" 
                     x-transition:leave="transition ease-in duration-150" 
                     x-transition:leave-start="opacity-100 translate-y-0" 
                     x-transition:leave-end="opacity-0 translate-y-4" 
                     x-cloak
                     class="fixed bottom-6 left-1/2 -translate-x-1/2 z-50 max-w-[98vw] sm:max-w-max transition-all duration-300 shadow-2xl">
                    <div style="background-color: #0f172a !important; border-color: #f59e0b !important;"
                         class="border-2 text-white rounded-full px-3 py-2 sm:px-4 sm:py-2.5 shadow-2xl flex items-center gap-1.5 sm:gap-2 ring-4 ring-black/30">
                        <!-- Crown Admin Badge -->
                        <div class="flex items-center gap-1.5 pl-1 pr-1.5 shrink-0">
                            <span class="w-7 h-7 rounded-full bg-amber-400 text-slate-950 font-black text-xs flex items-center justify-center shadow-xs">👑</span>
                            <span class="text-xs font-black uppercase text-amber-400 hidden md:inline tracking-wider">ADMIN:</span>
                        </div>

                        <div class="h-5 w-px bg-slate-700 hidden md:block"></div>

                        <!-- Switcher Buttons depending on Game Type -->
                        <div class="flex items-center gap-1.5 overflow-x-auto no-scrollbar">
                            @if($primaryGameType === 'wedding_photos')
                                <!-- Main / Foto -->
                                <button @click="setWeddingGameTab('worksheet')" type="button"
                                    :style="weddingGameTab === 'worksheet' && activeTab === 'game' ? 'background-color: #f59e0b !important; color: #0f172a !important;' : 'background-color: #1e293b !important; color: #ffffff !important; border-color: #334155 !important;'"
                                    class="px-3 py-1.5 rounded-full text-xs font-black border transition whitespace-nowrap flex items-center gap-1 shadow-sm hover:brightness-110">
                                    <span>🖼️</span> <span>Main / Foto</span>
                                </button>
                                
                                @if($currentMeetingGroups->isEmpty())
                                    <!-- Student A -->
                                    <button @click="setWeddingGameTab('student_a')" type="button"
                                        :style="weddingGameTab === 'student_a' && activeTab === 'game' ? 'background-color: #4f46e5 !important; color: #ffffff !important; border-color: #818cf8 !important;' : 'background-color: #1e293b !important; color: #ffffff !important; border-color: #334155 !important;'"
                                        class="px-3 py-1.5 rounded-full text-xs font-black border transition whitespace-nowrap flex items-center gap-1 shadow-sm hover:brightness-110">
                                        <span>👰</span> <span>Student A</span>
                                    </button>

                                    <!-- Student B -->
                                    <button @click="setWeddingGameTab('student_b')" type="button"
                                        :style="weddingGameTab === 'student_b' && activeTab === 'game' ? 'background-color: #ea580c !important; color: #ffffff !important; border-color: #fb923c !important;' : 'background-color: #1e293b !important; color: #ffffff !important; border-color: #334155 !important;'"
                                        class="px-3 py-1.5 rounded-full text-xs font-black border transition whitespace-nowrap flex items-center gap-1 shadow-sm hover:brightness-110">
                                        <span>🤵</span> <span>Student B</span>
                                    </button>
                                @else
                                    <!-- Real kelompok drive the slots: 1st group = Student A, 2nd group = Student B -->
                                    @foreach($currentMeetingGroups->take(2) as $index => $group)
                                        @php $slotValue = $index === 0 ? 'student_a' : 'student_b'; @endphp
                                        <button @click="setWeddingGameTab('{{ $slotValue }}', {{ $group->id }})" type="button"
                                            :style="weddingGameTab === '{{ $slotValue }}' && activeTab === 'game' ? '{{ $index === 0 ? 'background-color: #4f46e5 !important; color: #ffffff !important; border-color: #818cf8 !important;' : 'background-color: #ea580c !important; color: #ffffff !important; border-color: #fb923c !important;' }}' : 'background-color: #1e293b !important; color: #ffffff !important; border-color: #334155 !important;'"
                                            class="px-3 py-1.5 rounded-full text-xs font-black border transition whitespace-nowrap flex items-center gap-1 shadow-sm hover:brightness-110">
                                            <span>{{ $index === 0 ? '👰' : '🤵' }}</span> <span>{{ $group->name }}</span>
                                        </button>
                                    @endforeach
                                @endif

                                <!-- Phrases -->
                                <button @click="setWeddingGameTab('phrases')" type="button"
                                    :style="weddingGameTab === 'phrases' && activeTab === 'game' ? 'background-color: #0284c7 !important; color: #ffffff !important; border-color: #38bdf8 !important;' : 'background-color: #1e293b !important; color: #ffffff !important; border-color: #334155 !important;'"
                                    class="px-3 py-1.5 rounded-full text-xs font-black border transition whitespace-nowrap flex items-center gap-1 shadow-sm hover:brightness-110">
                                    <span>💬</span> <span>Pola Percakapan</span>
                                </button>
                                
                                <!-- Guide -->
                                <button @click="setWeddingGameTab('guide')" type="button"
                                    :style="weddingGameTab === 'guide' && activeTab === 'game' ? 'background-color: #059669 !important; color: #ffffff !important; border-color: #34d399 !important;' : 'background-color: #1e293b !important; color: #ffffff !important; border-color: #334155 !important;'"
                                    class="px-3 py-1.5 rounded-full text-xs font-black border transition whitespace-nowrap flex items-center gap-1 shadow-sm hover:brightness-110">
                                    <span>📖</span> <span>Panduan Guru</span>
                                </button>

                            @elseif($primaryGameType === 'how_many_kitchen')
                                @if($currentMeetingGroups->isEmpty())
                                    <button @click="setKitchenGameTab('A')" type="button"
                                        :style="kitchenActiveStudent === 'A' && activeTab === 'game' ? 'background-color: #0284c7 !important; color: #ffffff !important; border-color: #38bdf8 !important;' : 'background-color: #1e293b !important; color: #ffffff !important; border-color: #334155 !important;'"
                                        class="px-3 py-1.5 rounded-full text-xs font-black border transition whitespace-nowrap flex items-center gap-1 shadow-sm hover:brightness-110">
                                        <span>🍳</span> <span>Student A (Kitchen A)</span>
                                    </button>
                                    <button @click="setKitchenGameTab('B')" type="button"
                                        :style="kitchenActiveStudent === 'B' && activeTab === 'game' ? 'background-color: #ea580c !important; color: #ffffff !important; border-color: #fb923c !important;' : 'background-color: #1e293b !important; color: #ffffff !important; border-color: #334155 !important;'"
                                        class="px-3 py-1.5 rounded-full text-xs font-black border transition whitespace-nowrap flex items-center gap-1 shadow-sm hover:brightness-110">
                                        <span>🍽️</span> <span>Student B (Kitchen B)</span>
                                    </button>
                                @else
                                    @foreach($currentMeetingGroups->take(2) as $index => $group)
                                        @php $slotValue = $index === 0 ? 'A' : 'B'; @endphp
                                        <button @click="setKitchenGameTab('{{ $slotValue }}', {{ $group->id }})" type="button"
                                            :style="kitchenActiveStudent === '{{ $slotValue }}' && activeTab === 'game' ? '{{ $index === 0 ? 'background-color: #0284c7 !important; color: #ffffff !important; border-color: #38bdf8 !important;' : 'background-color: #ea580c !important; color: #ffffff !important; border-color: #fb923c !important;' }}' : 'background-color: #1e293b !important; color: #ffffff !important; border-color: #334155 !important;'"
                                            class="px-3 py-1.5 rounded-full text-xs font-black border transition whitespace-nowrap flex items-center gap-1 shadow-sm hover:brightness-110">
                                            <span>{{ $index === 0 ? '🍳' : '🍽️' }}</span> <span>{{ $group->name }}</span>
                                        </button>
                                    @endforeach
                                @endif
                                <button @click="toggleKitchenAnswers()" type="button"
                                    :style="kitchenShowAnswers ? 'background-color: #f59e0b !important; color: #0f172a !important;' : 'background-color: #1e293b !important; color: #ffffff !important; border-color: #334155 !important;'"
                                    class="px-3 py-1.5 rounded-full text-xs font-black border transition whitespace-nowrap flex items-center gap-1 shadow-sm hover:brightness-110">
                                    <span>🔑</span> <span x-text="kitchenShowAnswers ? 'Sembunyikan Kunci' : 'Kunci Jawaban'"></span>
                                </button>

                            @elseif($primaryGameType === 'tourist_in_town')
                                <button @click="setTouristTab('map')" type="button"
                                    :style="touristTab === 'map' && activeTab === 'game' ? 'background-color: #f59e0b !important; color: #0f172a !important;' : 'background-color: #1e293b !important; color: #ffffff !important; border-color: #334155 !important;'"
                                    class="px-2.5 py-1.5 rounded-full text-xs font-black border transition whitespace-nowrap flex items-center gap-1 shadow-sm hover:brightness-110">
                                    <span>🗺️</span> <span>Peta Master</span>
                                </button>
                                @if($currentMeetingGroups->isEmpty())
                                    @foreach(['a','b','c','d','e','f','g'] as $letter)
                                        <button @click="setTouristTab('sheets', 'sheet_{{ $letter }}')" type="button"
                                            :style="touristTab === 'sheets' && touristSheet === 'sheet_{{ $letter }}' && activeTab === 'game' ? 'background-color: #4f46e5 !important; color: #ffffff !important; border-color: #818cf8 !important;' : 'background-color: #1e293b !important; color: #ffffff !important; border-color: #334155 !important;'"
                                            class="px-2.5 py-1.5 rounded-full text-xs font-black border transition whitespace-nowrap flex items-center gap-1 shadow-sm hover:brightness-110">
                                            <span>🎒</span> <span>{{ strtoupper($letter) }}</span>
                                        </button>
                                    @endforeach
                                @else
                                    @foreach($currentMeetingGroups->take(7) as $index => $group)
                                        @php $slotValue = 'sheet_' . chr(97 + $index); @endphp
                                        <button @click="setTouristTab('sheets', '{{ $slotValue }}', {{ $group->id }})" type="button"
                                            :style="touristTab === 'sheets' && touristSheet === '{{ $slotValue }}' && activeTab === 'game' ? 'background-color: #4f46e5 !important; color: #ffffff !important; border-color: #818cf8 !important;' : 'background-color: #1e293b !important; color: #ffffff !important; border-color: #334155 !important;'"
                                            class="px-2.5 py-1.5 rounded-full text-xs font-black border transition whitespace-nowrap flex items-center gap-1 shadow-sm hover:brightness-110">
                                            <span>🎒</span> <span>{{ $group->name }}</span>
                                        </button>
                                    @endforeach
                                @endif
                                <button @click="setTouristTab('desks')" type="button"
                                    :style="touristTab === 'desks' && activeTab === 'game' ? 'background-color: #059669 !important; color: #ffffff !important; border-color: #34d399 !important;' : 'background-color: #1e293b !important; color: #ffffff !important; border-color: #334155 !important;'"
                                    class="px-2.5 py-1.5 rounded-full text-xs font-black border transition whitespace-nowrap flex items-center gap-1 shadow-sm hover:brightness-110">
                                    <span>🏢</span> <span>4 Desks</span>
                                </button>
                                <button @click="setTouristTab('guide')" type="button"
                                    :style="touristTab === 'guide' && activeTab === 'game' ? 'background-color: #f59e0b !important; color: #0f172a !important;' : 'background-color: #1e293b !important; color: #ffffff !important; border-color: #334155 !important;'"
                                    class="px-2.5 py-1.5 rounded-full text-xs font-black border transition whitespace-nowrap flex items-center gap-1 shadow-sm hover:brightness-110">
                                    <span>📖</span> <span>Panduan</span>
                                </button>

                            @elseif(!in_array($primaryGameType, $knownBespokeGameTypes) && $primaryParticipationType === 'pair')
                                <!-- Generic 2-slot Student A/B bar for any future pair-type mechanic
                                     without its own bespoke branch above. -->
                                @if($currentMeetingGroups->isEmpty())
                                    <button @click="setGenericSlot('student_a')" type="button"
                                        :style="genericActiveSlot === 'student_a' && activeTab === 'game' ? 'background-color: #4f46e5 !important; color: #ffffff !important; border-color: #818cf8 !important;' : 'background-color: #1e293b !important; color: #ffffff !important; border-color: #334155 !important;'"
                                        class="px-3 py-1.5 rounded-full text-xs font-black border transition whitespace-nowrap flex items-center gap-1 shadow-sm hover:brightness-110">
                                        <span>🧑</span> <span>Student A</span>
                                    </button>
                                    <button @click="setGenericSlot('student_b')" type="button"
                                        :style="genericActiveSlot === 'student_b' && activeTab === 'game' ? 'background-color: #ea580c !important; color: #ffffff !important; border-color: #fb923c !important;' : 'background-color: #1e293b !important; color: #ffffff !important; border-color: #334155 !important;'"
                                        class="px-3 py-1.5 rounded-full text-xs font-black border transition whitespace-nowrap flex items-center gap-1 shadow-sm hover:brightness-110">
                                        <span>🧑</span> <span>Student B</span>
                                    </button>
                                @else
                                    @foreach($currentMeetingGroups->take(2) as $index => $group)
                                        @php $slotValue = $index === 0 ? 'student_a' : 'student_b'; @endphp
                                        <button @click="setGenericSlot('{{ $slotValue }}', {{ $group->id }})" type="button"
                                            :style="genericActiveSlot === '{{ $slotValue }}' && activeTab === 'game' ? '{{ $index === 0 ? 'background-color: #4f46e5 !important; color: #ffffff !important; border-color: #818cf8 !important;' : 'background-color: #ea580c !important; color: #ffffff !important; border-color: #fb923c !important;' }}' : 'background-color: #1e293b !important; color: #ffffff !important; border-color: #334155 !important;'"
                                            class="px-3 py-1.5 rounded-full text-xs font-black border transition whitespace-nowrap flex items-center gap-1 shadow-sm hover:brightness-110">
                                            <span>🧑</span> <span>{{ $group->name }}</span>
                                        </button>
                                    @endforeach
                                @endif

                            @elseif(!in_array($primaryGameType, $knownBespokeGameTypes) && $primaryParticipationType === 'group')
                                <!-- Generic N-slot Kelompok bar (up to 7, matching the Kelompok modal's
                                     own group-count ceiling) for any future group-type mechanic without
                                     its own bespoke branch above. -->
                                @if($currentMeetingGroups->isEmpty())
                                    @foreach(range(1, 4) as $slotNumber)
                                        <button @click="setGenericSlot('group_{{ $slotNumber }}')" type="button"
                                            :style="genericActiveSlot === 'group_{{ $slotNumber }}' && activeTab === 'game' ? 'background-color: #4f46e5 !important; color: #ffffff !important; border-color: #818cf8 !important;' : 'background-color: #1e293b !important; color: #ffffff !important; border-color: #334155 !important;'"
                                            class="px-2.5 py-1.5 rounded-full text-xs font-black border transition whitespace-nowrap flex items-center gap-1 shadow-sm hover:brightness-110">
                                            <span>👥</span> <span>Kelompok {{ $slotNumber }}</span>
                                        </button>
                                    @endforeach
                                @else
                                    @foreach($currentMeetingGroups->take(7) as $index => $group)
                                        @php $slotValue = 'group_' . ($index + 1); @endphp
                                        <button @click="setGenericSlot('{{ $slotValue }}', {{ $group->id }})" type="button"
                                            :style="genericActiveSlot === '{{ $slotValue }}' && activeTab === 'game' ? 'background-color: #4f46e5 !important; color: #ffffff !important; border-color: #818cf8 !important;' : 'background-color: #1e293b !important; color: #ffffff !important; border-color: #334155 !important;'"
                                            class="px-2.5 py-1.5 rounded-full text-xs font-black border transition whitespace-nowrap flex items-center gap-1 shadow-sm hover:brightness-110">
                                            <span>👥</span> <span>{{ $group->name }}</span>
                                        </button>
                                    @endforeach
                                @endif
                            @endif

                            <!-- Kelompok Modal (Always accessible from any tab) -->
                            <button @click="$dispatch('open-modal', 'kelompok-meeting')" type="button"
                                style="background-color: #1e293b !important; color: #ffffff !important; border-color: #334155 !important;"
                                class="px-3 py-1.5 rounded-full text-xs font-black border transition whitespace-nowrap flex items-center gap-1 shadow-sm hover:brightness-110">
                                <span>👥</span> <span>Kelompok</span>
                            </button>
                        </div>
                    </div>

                    <!-- Member-reveal popovers, one per group -->
                    @foreach($currentMeetingGroups as $group)
                        <div x-show="selectedGroupPreview === {{ $group->id }}" x-transition x-cloak
                             class="absolute bottom-full left-1/2 -translate-x-1/2 mb-3 bg-white text-slate-900 rounded-2xl shadow-xl px-4 py-3 whitespace-nowrap border-2 border-teal-400 z-10">
                            <p class="text-[10px] font-black text-teal-700 uppercase tracking-wide mb-1">{{ $group->name }}</p>
                            <p class="text-sm font-bold text-slate-900">
                                @forelse($group->members as $member)
                                    {{ $member->name }}{{ !$loop->last ? ' & ' : '' }}
                                @empty
                                    <span class="text-slate-400 font-normal">Belum ada anggota</span>
                                @endforelse
                            </p>
                        </div>
                    @endforeach
                </div>
            @endif
        </main>
    </div>

    

    @if(Auth::user()?->isAdmin() || Auth::user()?->isTeacher())
        <x-modal name="kelompok-meeting" focusable max-width="2xl">
            <div class="p-6" x-data="{
                activeGroupTab: 'auto_pair',
                roster: {{ json_encode($meetingRosterStudents->map(fn($s) => ['id' => $s->id, 'name' => $s->name, 'selected' => true])->values()) }},
                namePrefix: 'Pair',
                oddHandling: 'trio',
                previewPairs: [],
                groupCount: Math.max(2, Math.ceil({{ max(1, $meetingRosterStudents->count()) }} / 2)),
                bulkAssignments: {},

                init() {
                    this.generatePreview();
                },

                getSelectedCount() {
                    return this.roster.filter(s => s.selected).length;
                },

                toggleAll(val) {
                    this.roster.forEach(s => s.selected = val);
                    this.generatePreview();
                },

                generatePreview() {
                    let selected = this.roster.filter(s => s.selected).map(s => ({ id: s.id, name: s.name }));
                    for (let i = selected.length - 1; i > 0; i--) {
                        const j = Math.floor(Math.random() * (i + 1));
                        [selected[i], selected[j]] = [selected[j], selected[i]];
                    }
                    
                    let pairs = [];
                    let total = selected.length;
                    if (total === 0) {
                        this.previewPairs = [];
                        return;
                    }

                    for (let i = 0; i < total; i += 2) {
                        pairs.push(selected.slice(i, i + 2));
                    }

                    if (this.oddHandling === 'trio' && pairs.length > 1 && pairs[pairs.length - 1].length === 1) {
                        let lastSingle = pairs.pop();
                        pairs[pairs.length - 1].push(lastSingle[0]);
                    }

                    this.previewPairs = pairs;
                },

                randomizeBulk() {
                    let count = parseInt(this.groupCount) || 2;
                    let students = [...this.roster];
                    for (let i = students.length - 1; i > 0; i--) {
                        const j = Math.floor(Math.random() * (i + 1));
                        [students[i], students[j]] = [students[j], students[i]];
                    }
                    let assignments = {};
                    students.forEach((s, idx) => {
                        assignments[s.id] = (idx % count) + 1;
                    });
                    this.bulkAssignments = assignments;
                },

                setPairBulk() {
                    let students = [...this.roster];
                    for (let i = students.length - 1; i > 0; i--) {
                        const j = Math.floor(Math.random() * (i + 1));
                        [students[i], students[j]] = [students[j], students[i]];
                    }
                    let count = Math.max(1, Math.ceil(students.length / 2));
                    this.groupCount = count;
                    let assignments = {};
                    students.forEach((s, idx) => {
                        let groupNum = Math.floor(idx / 2) + 1;
                        assignments[s.id] = groupNum;
                    });
                    this.bulkAssignments = assignments;
                },

                resetBulk() {
                    this.bulkAssignments = {};
                }
            }">
                <!-- Header -->
                <div class="flex items-center justify-between pb-4 border-b border-slate-100 mb-5">
                    <div>
                        <div class="flex items-center gap-2 mb-1">
                            <span class="px-2.5 py-0.5 rounded-full text-[10px] font-black uppercase tracking-wider bg-indigo-50 text-indigo-700 border border-indigo-100">
                                Pairwork & Kelompok Speaking
                            </span>
                            @if($dbMeeting)
                                <span class="px-2.5 py-0.5 rounded-full text-[10px] font-extrabold bg-purple-50 text-purple-700">
                                    Meeting {{ $dbMeeting->meeting_number }}
                                </span>
                            @endif
                        </div>
                        <h2 class="text-xl font-black text-slate-900 tracking-tight">
                            Kelompok & Pasangan Siswa
                        </h2>
                        @if($selectedClassPeriod)
                            <p class="text-xs text-slate-500 font-medium mt-0.5">Batch: <span class="font-bold text-slate-700">{{ $selectedClassPeriod->name }}</span> ({{ $meetingRosterStudents->count() }} Siswa)</p>
                        @endif
                    </div>
                    <button @click="$dispatch('close')" type="button" class="w-8 h-8 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-500 flex items-center justify-center transition text-lg font-bold">
                        &times;
                    </button>
                </div>

                @if(!$selectedClassPeriod)
                    <div class="p-6 text-center bg-amber-50 rounded-2xl border border-amber-200 text-amber-800 text-sm">
                        Belum ada batch aktif untuk program ini. Pilih batch aktif dulu di halaman Speaking Track sebelum mengatur kelompok.
                    </div>
                @else
                    <!-- Navigation Tabs inside Modal -->
                    <div class="flex items-center gap-1.5 p-1 bg-slate-100 rounded-2xl mb-5 text-xs font-black overflow-x-auto">
                        <button @click="activeGroupTab = 'auto_pair'" type="button"
                            :class="activeGroupTab === 'auto_pair' ? 'bg-white text-indigo-600 shadow-xs' : 'text-slate-600 hover:text-slate-900'"
                            class="px-3.5 py-2 rounded-xl transition flex items-center gap-1.5 shrink-0">
                            <span>🎲</span> <span>Pasangkan Acak (2 Siswa)</span>
                        </button>
                        <button @click="activeGroupTab = 'bulk'" type="button"
                            :class="activeGroupTab === 'bulk' ? 'bg-white text-indigo-600 shadow-xs' : 'text-slate-600 hover:text-slate-900'"
                            class="px-3.5 py-2 rounded-xl transition flex items-center gap-1.5 shrink-0">
                            <span>📋</span> <span>Bagi Banyak Kelompok</span>
                        </button>
                        <button @click="activeGroupTab = 'manual'" type="button"
                            :class="activeGroupTab === 'manual' ? 'bg-white text-indigo-600 shadow-xs' : 'text-slate-600 hover:text-slate-900'"
                            class="px-3.5 py-2 rounded-xl transition flex items-center gap-1.5 shrink-0">
                            <span>➕</span> <span>Buat Manual</span>
                        </button>
                        <button @click="activeGroupTab = 'list'" type="button"
                            :class="activeGroupTab === 'list' ? 'bg-white text-indigo-600 shadow-xs' : 'text-slate-600 hover:text-slate-900'"
                            class="px-3.5 py-2 rounded-xl transition flex items-center gap-1.5 shrink-0">
                            <span>👥</span> <span>Kelompok Aktif ({{ $meetingStudentGroups->count() }})</span>
                        </button>
                    </div>

                    <!-- TAB 1: 🎲 AUTO-PAIR (PEMBUATAN PASANGAN ACAK 2 SISWA) -->
                    <div x-show="activeGroupTab === 'auto_pair'" class="space-y-5">
                        <div class="p-4 rounded-2xl bg-gradient-to-br from-indigo-50/80 to-sky-50/80 border border-indigo-100/80 flex items-start gap-3">
                            <div class="w-8 h-8 rounded-xl bg-indigo-600 text-white flex items-center justify-center font-bold text-sm shrink-0 shadow-xs">
                                🎲
                            </div>
                            <div class="text-xs text-slate-600 leading-relaxed">
                                <span class="font-extrabold text-indigo-900 block text-sm mb-0.5">Pembuat Pasangan Acak Otomatis (2 Siswa / Kelompok)</span>
                                Sistem akan mengacak siswa yang hadir dan otomatis membentuk kelompok berpasangan (Pair 1, Pair 2, dst.). Sangat praktis untuk sesi latihan pairwork & game speaking.
                            </div>
                        </div>

                        <form method="POST" action="{{ route('class-periods.groups.auto-pair', $selectedClassPeriod) }}">
                            @csrf
                            
                            <!-- Student Selection -->
                            <div class="space-y-2 mb-4">
                                <div class="flex items-center justify-between">
                                    <label class="text-xs font-extrabold text-slate-700 uppercase tracking-wider">
                                        Pilih Siswa yang Hadir (<span x-text="getSelectedCount()"></span>/{{ $meetingRosterStudents->count() }})
                                    </label>
                                    <div class="flex items-center gap-2">
                                        <button @click="toggleAll(true)" type="button" class="text-[11px] font-bold text-indigo-600 hover:underline">Pilih Semua</button>
                                        <span class="text-slate-300">•</span>
                                        <button @click="toggleAll(false)" type="button" class="text-[11px] font-bold text-slate-500 hover:underline">Hapus Pilihan</button>
                                    </div>
                                </div>

                                <div class="max-h-44 overflow-y-auto border border-slate-200 rounded-2xl p-2 bg-slate-50/50 grid grid-cols-1 sm:grid-cols-2 gap-1.5">
                                    <template x-for="(s, idx) in roster" :key="s.id">
                                        <label class="flex items-center gap-2.5 p-2 rounded-xl bg-white border border-slate-200/80 hover:border-indigo-300 cursor-pointer text-xs font-semibold text-slate-800 transition">
                                            <input type="checkbox" :name="'user_ids[]'" :value="s.id" x-model="s.selected" @change="generatePreview()" class="rounded border-slate-300 text-indigo-600 shadow-xs focus:ring-indigo-500">
                                            <span class="truncate" x-text="s.name"></span>
                                        </label>
                                    </template>
                                </div>
                            </div>

                            <!-- Pairing Settings -->
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 p-3.5 bg-slate-50 rounded-2xl border border-slate-200 mb-4 text-xs">
                                <div>
                                    <label class="font-bold text-slate-700 block mb-1">Format Penamaan</label>
                                    <select name="name_prefix" x-model="namePrefix" class="w-full text-xs border-slate-200 rounded-xl font-medium shadow-xs">
                                        <option value="Pair">Pair 1, Pair 2, ...</option>
                                        <option value="Pasangan">Pasangan 1, Pasangan 2, ...</option>
                                        <option value="Kelompok">Kelompok 1, Kelompok 2, ...</option>
                                        <option value="Group">Group 1, Group 2, ...</option>
                                    </select>
                                </div>
                                <div>
                                    <label class="font-bold text-slate-700 block mb-1">Jika Siswa Ganjil (Sisa 1)</label>
                                    <select name="odd_handling" x-model="oddHandling" @change="generatePreview()" class="w-full text-xs border-slate-200 rounded-xl font-medium shadow-xs">
                                        <option value="trio">Gabung ke pair terakhir (Trio / 3 orang)</option>
                                        <option value="single">Buat kelompok sendiri (1 orang)</option>
                                    </select>
                                </div>
                            </div>

                            <!-- Options: Replace Existing & Scope -->
                            <div class="space-y-2 mb-4 text-xs text-slate-600 font-medium">
                                <label class="flex items-center gap-2 cursor-pointer">
                                    <input type="checkbox" name="replace_existing" value="1" checked class="rounded border-slate-300 text-indigo-600 shadow-xs focus:ring-indigo-500">
                                    <span>Hapus / timpa kelompok & pasangan sebelumnya untuk meeting ini</span>
                                </label>
                                <input type="hidden" name="meeting_id" id="auto_pair_meeting_id_input" value="{{ $dbMeeting->id ?? '' }}">
                                <label class="flex items-center gap-2 cursor-pointer">
                                    <input type="checkbox" onchange="document.getElementById('auto_pair_meeting_id_input').value = this.checked ? '' : '{{ $dbMeeting->id ?? '' }}'" class="rounded border-slate-300 text-indigo-600 shadow-xs focus:ring-indigo-500">
                                    <span>Berlaku untuk semua meeting di batch ini (bukan hanya meeting ini)</span>
                                </label>
                            </div>

                            @if(count($games) > 1)
                                <div class="mb-4">
                                    <label class="text-xs font-bold text-slate-700 block mb-1">Berlaku untuk game</label>
                                    <select name="game_index" class="text-xs border-slate-200 rounded-xl shadow-xs block w-full">
                                        <option value="">Semua Game</option>
                                        @foreach ($games as $i => $g)
                                            <option value="{{ $i }}">{{ $g['title'] ?? ('Game ' . ($i + 1)) }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            @endif

                            <!-- LIVE PREVIEW OF RANDOM PAIRS -->
                            <div class="p-3.5 rounded-2xl bg-indigo-50/50 border border-indigo-200/80 mb-5">
                                <div class="flex items-center justify-between mb-2.5">
                                    <div class="flex items-center gap-1.5">
                                        <span class="text-xs font-black text-indigo-950 uppercase tracking-wide">Hasil Acakan Pasangan</span>
                                        <span class="px-2 py-0.5 rounded-full bg-indigo-600 text-white text-[10px] font-black" x-text="previewPairs.length + ' Pasangan'"></span>
                                    </div>
                                    <button @click="generatePreview()" type="button" class="px-2.5 py-1 rounded-lg bg-white border border-indigo-200 text-indigo-700 hover:bg-indigo-600 hover:text-white font-extrabold text-[11px] transition flex items-center gap-1 shadow-2xs">
                                        <span>🎲</span> <span>Acak Ulang Kombinasi</span>
                                    </button>
                                </div>

                                <template x-if="previewPairs.length === 0">
                                    <p class="text-xs text-slate-400 py-2 text-center">Pilih minimal 2 siswa di atas untuk melihat preview pasangan.</p>
                                </template>

                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-2 max-h-48 overflow-y-auto">
                                    <template x-for="(pair, pIdx) in previewPairs" :key="pIdx">
                                        <div class="p-2.5 rounded-xl bg-white border border-indigo-100 shadow-2xs space-y-1">
                                            <div class="flex items-center justify-between">
                                                <span class="text-[11px] font-black text-indigo-700" x-text="namePrefix + ' ' + (pIdx + 1)"></span>
                                                <span class="text-[10px] font-bold text-slate-400" x-text="pair.length + ' siswa'"></span>
                                            </div>
                                            <div class="text-xs font-semibold text-slate-800 flex flex-wrap items-center gap-1">
                                                <template x-for="(m, mIdx) in pair" :key="m.id">
                                                    <span class="inline-flex items-center">
                                                        <span x-text="m.name"></span>
                                                        <span x-show="mIdx < pair.length - 1" class="mx-1 text-indigo-400 font-bold">&bull;</span>
                                                    </span>
                                                </template>
                                            </div>
                                        </div>
                                    </template>
                                </div>
                            </div>

                            <div class="flex justify-end gap-2">
                                <button type="button" @click="$dispatch('close')" class="px-4 py-2.5 rounded-xl border border-slate-200 text-slate-700 hover:bg-slate-50 font-bold text-xs transition">
                                    Batal
                                </button>
                                <button type="submit" :disabled="getSelectedCount() < 2"
                                    class="px-5 py-2.5 rounded-xl bg-indigo-600 hover:bg-indigo-700 disabled:opacity-50 disabled:cursor-not-allowed text-white font-black text-xs shadow-md transition flex items-center gap-1.5">
                                    <span>🚀</span> <span>Simpan & Bentuk Pasangan</span>
                                </button>
                            </div>
                        </form>
                    </div>

                    <!-- TAB 2: 📋 BULK GROUP ASSIGN WITH RANDOMIZE SHUFFLE -->
                    <div x-show="activeGroupTab === 'bulk'" class="space-y-4">
                        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2 pb-3 border-b border-slate-100">
                            <div>
                                <h4 class="text-sm font-extrabold text-slate-900">Bagi Siswa ke Beberapa Kelompok</h4>
                                <p class="text-xs text-slate-500">Tentukan jumlah kelompok lalu acak atau atur manual tiap siswa.</p>
                            </div>
                            <div class="flex items-center gap-1.5 flex-wrap">
                                <button @click="randomizeBulk()" type="button" class="px-2.5 py-1.5 rounded-lg bg-amber-50 border border-amber-200 text-amber-900 hover:bg-amber-100 text-xs font-bold transition flex items-center gap-1 shadow-2xs">
                                    <span>🎲</span> <span>Acak (Shuffle)</span>
                                </button>
                                <button @click="setPairBulk()" type="button" class="px-2.5 py-1.5 rounded-lg bg-indigo-50 border border-indigo-200 text-indigo-800 hover:bg-indigo-100 text-xs font-bold transition flex items-center gap-1 shadow-2xs">
                                    <span>👥</span> <span>Set Pasangan (2/Grup)</span>
                                </button>
                                <button @click="resetBulk()" type="button" class="px-2.5 py-1.5 rounded-lg bg-slate-100 text-slate-600 hover:bg-slate-200 text-xs font-bold transition">
                                    Reset
                                </button>
                            </div>
                        </div>

                        <form method="POST" action="{{ route('class-periods.groups.bulk-store', $selectedClassPeriod) }}">
                            @csrf
                            <div class="flex items-center gap-2 mb-3">
                                <label class="text-xs font-bold text-slate-700">Jumlah Kelompok</label>
                                <input type="number" name="group_count" x-model.number="groupCount" min="2" max="{{ max(2, $meetingRosterStudents->count()) }}" class="w-20 text-xs border-slate-200 rounded-xl shadow-xs">
                            </div>

                            <div class="max-h-52 overflow-y-auto border border-slate-200 rounded-2xl divide-y divide-slate-100 mb-3 bg-white">
                                @foreach ($meetingRosterStudents as $student)
                                    <div class="flex items-center justify-between gap-2 px-3 py-2 text-xs">
                                        <span class="truncate font-semibold text-slate-800">{{ $student->name }}</span>
                                        <select name="assignments[{{ $student->id }}]" x-model="bulkAssignments[{{ $student->id }}]" class="text-xs border-slate-200 rounded-xl shadow-xs shrink-0 py-1 font-medium">
                                            <option value="">Tidak ikut</option>
                                            <template x-for="n in groupCount" :key="n">
                                                <option :value="n" x-text="'Kelompok ' + n"></option>
                                            </template>
                                        </select>
                                    </div>
                                @endforeach
                            </div>

                            <input type="hidden" name="meeting_id" id="kelompok_bulk_meeting_id_input" value="{{ $dbMeeting->id ?? '' }}">
                            <label class="flex items-center gap-2 text-xs text-slate-600 mb-2">
                                <input type="checkbox" onchange="document.getElementById('kelompok_bulk_meeting_id_input').value = this.checked ? '' : '{{ $dbMeeting->id ?? '' }}'" class="rounded border-slate-300 text-indigo-600 shadow-xs focus:ring-indigo-500">
                                <span>Berlaku untuk semua meeting di batch ini (bukan hanya meeting ini)</span>
                            </label>

                            @if(count($games) > 1)
                                <div class="mb-3">
                                    <label class="text-xs font-bold text-slate-700 block mb-1">Berlaku untuk game</label>
                                    <select name="game_index" class="text-xs border-slate-200 rounded-xl shadow-xs block w-full">
                                        <option value="">Semua Game</option>
                                        @foreach ($games as $i => $g)
                                            <option value="{{ $i }}">{{ $g['title'] ?? ('Game ' . ($i + 1)) }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            @endif

                            <div class="flex justify-end gap-2 pt-2">
                                <button type="button" @click="$dispatch('close')" class="px-4 py-2 rounded-xl border border-slate-200 text-slate-700 hover:bg-slate-50 font-bold text-xs transition">Batal</button>
                                <button type="submit" class="px-5 py-2 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white font-black text-xs shadow-md transition">Bagikan ke Kelompok</button>
                            </div>
                        </form>
                    </div>

                    <!-- TAB 3: ➕ BUAT KELOMPOK MANUAL -->
                    <div x-show="activeGroupTab === 'manual'" class="space-y-4">
                        <form method="POST" action="{{ route('class-periods.groups.store', $selectedClassPeriod) }}">
                            @csrf
                            <div>
                                <label class="text-xs font-bold text-slate-700 block mb-1">Nama Kelompok (Opsional)</label>
                                <input type="text" name="name" class="text-xs border-slate-200 rounded-xl shadow-xs block w-full mb-3" placeholder="Contoh: Pair A, Kelompok 1, dsb.">
                            </div>

                            <div class="mb-3">
                                <label class="text-xs font-bold text-slate-700 block mb-1">Pilih Anggota</label>
                                <div class="max-h-44 overflow-y-auto border border-slate-200 rounded-2xl divide-y divide-slate-100 bg-white">
                                    @forelse ($meetingRosterStudents as $student)
                                        <label class="flex items-center gap-2 px-3 py-2 text-xs hover:bg-slate-50 cursor-pointer font-semibold text-slate-800">
                                            <input type="checkbox" name="user_ids[]" value="{{ $student->id }}" class="rounded border-slate-300 text-indigo-600 shadow-xs focus:ring-indigo-500">
                                            <span>{{ $student->name }}</span>
                                        </label>
                                    @empty
                                        <p class="px-3 py-2 text-xs text-slate-400">Belum ada student di batch ini.</p>
                                    @endforelse
                                </div>
                            </div>

                            <input type="hidden" name="meeting_id" id="kelompok_meeting_id_input" value="{{ $dbMeeting->id ?? '' }}">
                            <label class="flex items-center gap-2 text-xs text-slate-600 mb-3">
                                <input type="checkbox" onchange="document.getElementById('kelompok_meeting_id_input').value = this.checked ? '' : '{{ $dbMeeting->id ?? '' }}'" class="rounded border-slate-300 text-indigo-600 shadow-xs focus:ring-indigo-500">
                                <span>Berlaku untuk semua meeting di batch ini (bukan hanya meeting ini)</span>
                            </label>

                            @if(count($games) > 1)
                                <div class="mb-3">
                                    <label class="text-xs font-bold text-slate-700 block mb-1">Berlaku untuk game</label>
                                    <select name="game_index" class="text-xs border-slate-200 rounded-xl shadow-xs block w-full">
                                        <option value="">Semua Game</option>
                                        @foreach ($games as $i => $g)
                                            <option value="{{ $i }}">{{ $g['title'] ?? ('Game ' . ($i + 1)) }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            @endif

                            <div class="flex justify-end gap-2 pt-2">
                                <button type="button" @click="$dispatch('close')" class="px-4 py-2 rounded-xl border border-slate-200 text-slate-700 hover:bg-slate-50 font-bold text-xs transition">Batal</button>
                                <button type="submit" class="px-5 py-2 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white font-black text-xs shadow-md transition">Buat Kelompok</button>
                            </div>
                        </form>
                    </div>

                    <!-- TAB 4: 👥 DAFTAR KELOMPOK AKTIF -->
                    <div x-show="activeGroupTab === 'list'" class="space-y-3">
                        <div class="flex items-center justify-between pb-2 border-b border-slate-100">
                            <span class="text-xs font-bold text-slate-500">Total: {{ $meetingStudentGroups->count() }} Kelompok / Pasangan</span>
                            @if($meetingStudentGroups->isNotEmpty())
                                <form action="{{ route('class-periods.groups.destroy-all', $selectedClassPeriod) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus SEMUA kelompok untuk meeting ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <input type="hidden" name="meeting_id" value="{{ $dbMeeting->id ?? '' }}">
                                    <button type="submit" class="text-red-600 hover:text-red-800 text-xs font-bold flex items-center gap-1 transition">
                                        <span>🗑️</span> <span>Hapus Semua Kelompok Meeting Ini</span>
                                    </button>
                                </form>
                            @endif
                        </div>

                        <div class="space-y-2.5 max-h-72 overflow-y-auto pr-1">
                            @forelse ($meetingStudentGroups as $group)
                                <div class="border border-slate-200 rounded-2xl p-3 bg-white shadow-2xs">
                                    <div class="flex justify-between items-start mb-2">
                                        <div>
                                            <h4 class="font-black text-slate-900 text-xs sm:text-sm">{{ $group->name }}</h4>
                                            <div class="flex items-center gap-1 mt-0.5">
                                                @if($group->meeting_id)
                                                    <span class="px-2 py-0.5 rounded-full bg-purple-50 text-purple-700 text-[10px] font-bold uppercase tracking-wide">Meeting Ini</span>
                                                @else
                                                    <span class="px-2 py-0.5 rounded-full bg-slate-100 text-slate-600 text-[10px] font-bold uppercase tracking-wide">Semua Meeting</span>
                                                @endif
                                                @if(count($games) > 1)
                                                    @if($group->game_index !== null)
                                                        <span class="px-2 py-0.5 rounded-full bg-orange-50 text-orange-700 text-[10px] font-bold uppercase tracking-wide">{{ $games[$group->game_index]['title'] ?? ('Game ' . ($group->game_index + 1)) }}</span>
                                                    @else
                                                        <span class="px-2 py-0.5 rounded-full bg-slate-100 text-slate-600 text-[10px] font-bold uppercase tracking-wide">Semua Game</span>
                                                    @endif
                                                @endif
                                            </div>
                                        </div>
                                        <form action="{{ route('class-periods.groups.destroy', [$selectedClassPeriod, $group]) }}" method="POST" onsubmit="return confirm('Hapus kelompok ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-900 text-xs font-bold shrink-0">Hapus</button>
                                        </form>
                                    </div>

                                    <div class="flex flex-wrap gap-1.5 mb-2">
                                        @forelse ($group->members as $member)
                                            <span class="inline-flex items-center gap-1 pl-2.5 pr-1.5 py-1 rounded-full bg-indigo-50 text-indigo-700 text-xs font-semibold">
                                                {{ $member->name }}
                                                <form action="{{ route('class-periods.groups.remove-member', [$selectedClassPeriod, $group, $member]) }}" method="POST" class="inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" title="Hapus dari kelompok" class="w-3.5 h-3.5 rounded-full bg-indigo-200 hover:bg-indigo-300 text-indigo-700 inline-flex items-center justify-center leading-none text-[10px]">&times;</button>
                                                </form>
                                            </span>
                                        @empty
                                            <span class="text-xs text-slate-400">Belum ada anggota.</span>
                                        @endforelse
                                    </div>

                                    @php
                                        $availableForGroup = $meetingRosterStudents->whereNotIn('id', $group->members->pluck('id'));
                                    @endphp
                                    @if($availableForGroup->isNotEmpty())
                                        <form action="{{ route('class-periods.groups.add-member', [$selectedClassPeriod, $group]) }}" method="POST" class="flex gap-2 pt-1 border-t border-slate-100">
                                            @csrf
                                            <select name="user_id" class="text-xs border-slate-200 rounded-xl shadow-xs flex-1 py-1 font-medium" required>
                                                <option value="">+ Tambah anggota...</option>
                                                @foreach ($availableForGroup as $student)
                                                    <option value="{{ $student->id }}">{{ $student->name }}</option>
                                                @endforeach
                                            </select>
                                            <button type="submit" class="px-3 py-1 bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-bold rounded-xl transition">Tambah</button>
                                        </form>
                                    @endif
                                </div>
                            @empty
                                <div class="text-center py-6 bg-slate-50 rounded-2xl border border-slate-200">
                                    <p class="text-xs text-slate-500 font-medium">Belum ada kelompok/pasangan untuk meeting ini.</p>
                                    <button @click="activeGroupTab = 'auto_pair'" type="button" class="mt-2 px-3 py-1.5 rounded-xl bg-indigo-600 text-white text-xs font-bold shadow-xs">
                                        🎲 Buat Pasangan Acak Sekarang
                                    </button>
                                </div>
                            @endforelse
                        </div>
                    </div>
                @endif
            </div>
        </x-modal>
    @endif

    @include('components.student-broadcaster')
    @include('components.floating-wa-button')
</body>
</html>
