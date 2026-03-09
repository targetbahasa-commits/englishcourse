<div x-data="academicCalendar('{{ route('api.scholarships.calendar-events') }}')" 
     class="relative"
     @click.away="isOpen = false">
    
    <!-- Widget Button -->
    <button @click="isOpen = !isOpen" 
            class="bg-white border rounded-xl shadow-sm p-3 w-full flex items-center gap-3 hover:bg-gray-50 transition min-w-[200px] md:min-w-[250px] text-left">
        <div class="w-10 h-10 md:w-12 md:h-12 rounded-full bg-blue-50 text-blue-600 flex items-center justify-center flex-shrink-0">
            <svg class="w-5 h-5 md:w-6 md:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
        </div>
        <div>
            <p class="text-xs md:text-sm text-gray-500 font-bold uppercase tracking-wider">Academic Calendar</p>
            <p class="text-sm md:text-lg font-bold text-gray-800" x-text="monthNames[month] + ' ' + year"></p>
        </div>
        <svg class="w-5 h-5 ml-auto text-gray-400 transition-transform" :class="{'rotate-180': isOpen}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
    </button>

    <!-- Calendar Dropdown -->
    <div x-show="isOpen" 
         x-transition
         x-cloak
         class="absolute z-50 right-0 mt-2 w-80 lg:w-96 bg-white rounded-2xl shadow-xl border border-gray-100 p-4">
        
        <!-- Calendar Header -->
        <div class="flex items-center justify-between mb-4 pb-4 border-b border-gray-100">
            <button @click="prevMonth" class="p-2 hover:bg-gray-100 rounded-lg transition">
                <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
            </button>
            <h3 class="text-lg font-bold text-gray-800" x-text="monthNames[month] + ' ' + year"></h3>
            <button @click="nextMonth" class="p-2 hover:bg-gray-100 rounded-lg transition">
                <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
            </button>
        </div>

        <!-- Legend -->
        <div class="flex items-center justify-center gap-4 mb-4 text-xs font-medium text-gray-500">
            <div class="flex items-center gap-1.5"><div class="w-2.5 h-2.5 rounded-full bg-blue-500"></div>Today</div>
            <div class="flex items-center gap-1.5"><div class="w-2.5 h-2.5 rounded-full bg-emerald-500"></div>Open</div>
            <div class="flex items-center gap-1.5"><div class="w-2.5 h-2.5 rounded-full bg-red-500"></div>Deadline</div>
        </div>

        <!-- Days Header -->
        <div class="grid grid-cols-7 gap-1 mb-2">
            <template x-for="day in days" :key="day">
                <div class="text-center text-xs font-bold text-gray-400 uppercase" x-text="day"></div>
            </template>
        </div>

        <!-- Dates Grid -->
        <div class="grid grid-cols-7 gap-1">
            <!-- Blank days for start of month -->
            <template x-for="blank in blankdays">
                <div class="text-center p-2 text-sm border border-transparent"></div>
            </template>
            
            <!-- Actual days -->
            <template x-for="(date, dateIndex) in no_of_days" :key="dateIndex">
                <button @click="selectDate(date)" 
                        class="relative flex items-center justify-center h-10 w-full rounded-lg text-sm font-medium transition-all hover:bg-gray-50"
                        :class="{'text-gray-400': isPast(date), 'text-gray-800 font-bold': !isPast(date), 'bg-blue-50 text-blue-700 font-black ring-1 ring-blue-200': isToday(date)}">
                    
                    <span x-text="date"></span>
                    
                    <!-- Event Indicators -->
                    <div class="absolute bottom-1 flex gap-0.5 justify-center w-full">
                        <template x-for="event in getEventsForDate(date)">
                            <div class="w-1.5 h-1.5 rounded-full"
                                 :class="{'bg-emerald-500': event.type === 'opening', 'bg-red-500': event.type === 'deadline'}">
                            </div>
                        </template>
                    </div>
                </button>
            </template>
        </div>

        <!-- Selected Date Events List -->
        <div x-show="selectedDateEvents.length > 0" class="mt-4 pt-4 border-t border-gray-100">
            <h4 class="text-sm font-bold text-gray-800 mb-2" x-text="'Events on ' + selectedDateObj.toLocaleDateString()"></h4>
            <div class="space-y-2 max-h-48 overflow-y-auto">
                <template x-for="event in selectedDateEvents" :key="event.id + event.type">
                    <a :href="event.url" class="block p-3 rounded-xl border transition-colors hover:shadow-sm"
                       :class="event.type === 'opening' ? 'bg-emerald-50 border-emerald-100 hover:border-emerald-200' : 'bg-red-50 border-red-100 hover:border-red-200'">
                        <div class="flex items-start gap-2">
                            <div class="w-2 h-2 rounded-full mt-1.5 shrink-0" :class="event.type === 'opening' ? 'bg-emerald-500' : 'bg-red-500'"></div>
                            <div>
                                <p class="text-xs font-bold uppercase tracking-wider mb-0.5" 
                                   :class="event.type === 'opening' ? 'text-emerald-700' : 'text-red-700'"
                                   x-text="event.type === 'opening' ? 'Registration Opens' : 'Application Deadline'"></p>
                                <p class="text-sm font-semibold text-gray-900 line-clamp-2" x-text="event.title.replace('Open: ', '').replace('Deadline: ', '')"></p>
                            </div>
                        </div>
                    </a>
                </template>
            </div>
        </div>
        
        <div x-show="selectedDateEvents.length === 0 && selectedDateObj" class="mt-4 pt-4 border-t border-gray-100 text-center text-sm text-gray-500 py-2">
            No events on this date.
        </div>
        
        <!-- Loading State -->
        <div x-show="isLoading" class="absolute inset-0 bg-white/80 backdrop-blur-sm rounded-2xl flex items-center justify-center">
            <svg class="animate-spin h-8 w-8 text-blue-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
        </div>

    </div>
</div>
