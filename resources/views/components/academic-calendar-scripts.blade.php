{{-- 
    Academic Calendar Alpine.js component data registration.
    Include this INSIDE a document.addEventListener('alpine:init', ...) block.
    Usage: @include('components.academic-calendar-scripts')
--}}
        Alpine.data('academicCalendar', () => ({
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
                today.setHours(0,0,0,0);
                const d = new Date(this.year, this.month, date);
                return d < today;
            },
            
            getNoOfDays() {
                let daysInMonth = new Date(this.year, this.month + 1, 0).getDate();
                let dayOfWeek = new Date(this.year, this.month).getDay();
                let blankdaysArray = [];
                for (var i = 1; i <= dayOfWeek; i++) {
                    blankdaysArray.push(i);
                }
                let daysArray = [];
                for (var i = 1; i <= daysInMonth; i++) {
                    daysArray.push(i);
                }
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
                this.isLoading = true;
                fetch('{{ route("api.scholarships.calendar-events") }}')
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
