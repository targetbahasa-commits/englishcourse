<div x-data="academicCalendar('{{ route('api.scholarships.calendar-events') }}')" class="w-full">
    
    <div class="w-full">
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
            <div class="space-y-2 max-h-48 overflow-y-auto pr-1 custom-scrollbar">
                <template x-for="event in selectedDateEvents" :key="event.id + event.type">
                    <a :href="event.url" class="block p-3 rounded-xl border transition-colors hover:shadow-sm"
                       :class="event.type === 'opening' ? 'bg-emerald-50 border-emerald-100 hover:border-emerald-200' : 'bg-red-50 border-red-100 hover:border-red-200'">
                        <div class="flex items-start gap-2">
                            <div class="text-sm mt-0.5 shrink-0" x-text="event.type === 'opening' ? '🟢' : '🔴'"></div>
                            <div>
                                <p class="text-sm font-bold text-gray-900 leading-snug w-full">
                                    <span x-text="event.title.replace('Open: ', '').replace('Deadline: ', '')"></span>
                                    <span :class="event.type === 'opening' ? 'text-emerald-600' : 'text-red-600'" x-text="event.type === 'opening' ? ' Opens' : ' Deadline'"></span>
                                </p>
                            </div>
                        </div>
                    </a>
                </template>
            </div>
        </div>
        
        <div x-show="selectedDateEvents.length === 0 && selectedDateObj" class="mt-4 pt-4 border-t border-gray-100 text-center text-sm text-gray-500 py-2">
            No events on this date.
        </div>
    </div>
</div>
