import './bootstrap';
import Alpine from 'alpinejs';

window.Alpine = Alpine;

// ============================================================
// Alpine.data Component: Academic Calendar
// Reads calendar events URL from window.calendarEventsUrl
// (set via a Blade inline script in the view).
// ============================================================
Alpine.data('academicCalendar', (apiUrl) => ({
    isOpen: false,
    month: '',
    year: '',
    no_of_days: [],
    blankdays: [],
    days: ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'],
    monthNames: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
    events: [],
    isLoading: false,
    selectedDateObj: null,
    selectedDateEvents: [],

    init() {
        let today = new Date();
        this.month = today.getMonth();
        this.year = today.getFullYear();
        this.getNoOfDays();
        this.fetchEvents();
    },

    isToday(date) {
        const today = new Date();
        const d = new Date(this.year, this.month, date);
        return today.toDateString() === d.toDateString();
    },

    isPast(date) {
        const today = new Date();
        today.setHours(0, 0, 0, 0);
        const d = new Date(this.year, this.month, date);
        return d < today;
    },

    getNoOfDays() {
        let daysInMonth = new Date(this.year, this.month + 1, 0).getDate();
        let dayOfWeek = new Date(this.year, this.month).getDay();
        let blankdaysArray = [];
        for (var i = 1; i <= dayOfWeek; i++) { blankdaysArray.push(i); }
        let daysArray = [];
        for (var i = 1; i <= daysInMonth; i++) { daysArray.push(i); }
        this.blankdays = blankdaysArray;
        this.no_of_days = daysArray;
    },

    nextMonth() {
        this.month++;
        if (this.month > 11) { this.month = 0; this.year++; }
        this.getNoOfDays();
        this.selectedDateObj = null;
        this.selectedDateEvents = [];
    },

    prevMonth() {
        this.month--;
        if (this.month < 0) { this.month = 11; this.year--; }
        this.getNoOfDays();
        this.selectedDateObj = null;
        this.selectedDateEvents = [];
    },

    fetchEvents() {
        const url = apiUrl || window.calendarEventsUrl || '/api/scholarships/calendar-events';
        this.isLoading = true;
        fetch(url)
            .then(response => response.json())
            .then(data => {
                this.events = data;
                this.isLoading = false;
            })
            .catch(error => {
                console.error('Error fetching calendar events:', error);
                this.isLoading = false;
            });
    },

    getEventsForDate(date) {
        if (!this.events.length) return [];
        const checkDateStr = `${this.year}-${String(this.month + 1).padStart(2, '0')}-${String(date).padStart(2, '0')}`;
        return this.events.filter(e => e.date === checkDateStr);
    },

    selectDate(date) {
        const checkDateStr = `${this.year}-${String(this.month + 1).padStart(2, '0')}-${String(date).padStart(2, '0')}`;
        this.selectedDateEvents = this.events.filter(e => e.date === checkDateStr);
        this.selectedDateObj = new Date(this.year, this.month, date);
    }
}));

// ============================================================
// Alpine.data Component: Countdown Timer
// Usage: x-data="countdown('2024-12-31 23:59:59')"
// ============================================================
Alpine.data('countdown', (deadlineStr) => ({
    days: '00',
    hours: '00',
    minutes: '00',
    expired: false,
    init() {
        if (!deadlineStr) return;
        const target = new Date(deadlineStr).getTime();
        const updateTimer = () => {
            const now = new Date().getTime();
            const distance = target - now;
            if (distance < 0) {
                this.expired = true;
                return;
            }
            this.days = Math.floor(distance / (1000 * 60 * 60 * 24)).toString().padStart(2, '0');
            this.hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60)).toString().padStart(2, '0');
            this.minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60)).toString().padStart(2, '0');
        };
        updateTimer();
        setInterval(updateTimer, 60000);
    }
}));

// ============================================================
// Alpine.data Component: TOEFL Reading Practice Page
// Usage: x-data="readingPracticePage(answerKey, totalQuestions)"
// ============================================================
Alpine.data('readingPracticePage', (answerKey, totalQuestions) => ({
    answers: {},
    submitted: false,
    answerKey: answerKey,
    totalQuestions: totalQuestions,
    answeredCount() {
        return Object.values(this.answers).filter(Boolean).length;
    },
    remainingCount() {
        return this.totalQuestions - this.answeredCount();
    },
    score() {
        return Object.entries(this.answerKey).reduce((total, [questionNumber, correctAnswer]) => {
            return total + (this.answers[questionNumber] === correctAnswer ? 1 : 0);
        }, 0);
    },
    setAnswer(questionNumber, optionLetter) {
        this.answers[questionNumber] = optionLetter;
    },
    percentage() {
        if (this.totalQuestions === 0) {
            return 0;
        }
        return Math.round((this.score() / this.totalQuestions) * 100);
    },
    optionClass(questionNumber, optionLetter) {
        if (!this.submitted) {
            return '';
        }
        if (this.answerKey[questionNumber] === optionLetter) {
            return 'reading-correct';
        }
        if (this.answers[questionNumber] === optionLetter) {
            return 'reading-wrong';
        }
        return 'reading-muted';
    },
    submitPractice() {
        this.submitted = true;
        const questionPanel = document.getElementById('questions-panel');
        if (questionPanel) {
            questionPanel.scrollTo({ top: 0, behavior: 'smooth' });
        }
    },
    resetPractice() {
        this.answers = {};
        this.submitted = false;
        const passagePanel = document.getElementById('passages-panel');
        const questionPanel = document.getElementById('questions-panel');
        if (passagePanel) {
            passagePanel.scrollTo({ top: 0, behavior: 'smooth' });
        }
        if (questionPanel) {
            questionPanel.scrollTo({ top: 0, behavior: 'smooth' });
        }
    },
}));

Alpine.start();

import './password-rules';

// ============================================================
// Auto-Expanding Answer Textarea Helper
// Ensures all textarea.auto-expand-answer elements expand
// vertically downward as text grows or is restored.
// ============================================================
(function initAutoExpandAnswerHelper() {
    function resizeTextarea(el) {
        if (!el || el.tagName !== 'TEXTAREA') return;
        el.style.height = 'auto';
        if (el.scrollHeight > 0) {
            el.style.height = `${el.scrollHeight}px`;
        }
    }

    function resizeAllAutoExpandTextareas(root = document) {
        root.querySelectorAll('textarea.auto-expand-answer').forEach(resizeTextarea);
    }

    window.resizeAutoExpandTextarea = resizeTextarea;
    window.resizeAutoExpandTextareas = resizeAllAutoExpandTextareas;

    document.addEventListener('input', (e) => {
        if (e.target && e.target.matches && e.target.matches('textarea.auto-expand-answer')) {
            resizeTextarea(e.target);
        }
    });

    window.addEventListener('resize', () => resizeAllAutoExpandTextareas());
    document.addEventListener('DOMContentLoaded', () => {
        resizeAllAutoExpandTextareas();
        setTimeout(() => resizeAllAutoExpandTextareas(), 150);
        setTimeout(() => resizeAllAutoExpandTextareas(), 500);
        setTimeout(() => resizeAllAutoExpandTextareas(), 1200);
    });
    window.addEventListener('load', () => resizeAllAutoExpandTextareas());
})();

