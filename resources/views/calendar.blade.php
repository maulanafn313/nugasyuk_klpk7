@extends('layouts.calendar')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900">
                <div class="flex justify-between items-center mb-6 gap-4">
                    <h2 class="text-2xl font-bold text-gray-800">Schedule Calendar</h2>
                    <button id="todayBtn" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition-colors duration-200 ml-4">
                        Today
                    </button>
                </div>
                <div id="calendar" class="calendar-container"></div>
            </div>
        </div>
    </div>
</div>

@push('styles')
<link href='https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.css' rel='stylesheet' />
<style>
    .calendar-container {
        margin: 20px 0;
    }
    .fc {
        background: white;
        padding: 20px;
        border-radius: 0.5rem;
    }
    .fc .fc-toolbar {
        margin-bottom: 1.5rem !important;
    }
    .fc .fc-button {
        background-color: #3B82F6 !important;
        border-color: #3B82F6 !important;
        padding: 0.5rem 1rem !important;
        font-weight: 500 !important;
        border-radius: 0.375rem !important;
        transition: all 0.2s !important;
    }
    .fc .fc-button:hover {
        background-color: #2563EB !important;
        border-color: #2563EB !important;
    }
    .fc .fc-button-primary:not(:disabled).fc-button-active {
        background-color: #1D4ED8 !important;
        border-color: #1D4ED8 !important;
    }
    .fc .fc-daygrid-day {
        transition: background-color 0.2s;
    }
    .fc .fc-daygrid-day:hover {
        background-color: #F3F4F6;
    }
    .fc-event {
        cursor: pointer;
        border-radius: 0.25rem;
        padding: 2px 4px;
        font-size: 0.875rem;
        border: none !important;
    }
    .fc-event:hover {
        transform: scale(1.02);
        transition: transform 0.2s;
    }
    .fc-theme-standard td, .fc-theme-standard th {
        border-color: #E5E7EB !important;
    }
    .fc .fc-day-today {
        background-color: #EFF6FF !important;
    }
    .fc .fc-toolbar-title {
        font-size: 1.25rem !important;
        font-weight: 600 !important;
        color: #1F2937 !important;
    }
    /* Modal overlay */
    .custom-modal-overlay {
        position: fixed;
        inset: 0;
        background: rgba(75, 85, 99, 0.3);
        backdrop-filter: blur(4px);
        z-index: 9999;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    /* Modal box */
    .custom-modal-box {
        background: white;
        border-radius: 0.75rem;
        box-shadow: 0 10px 25px rgba(0,0,0,0.1);
        width: 100%;
        max-width: 400px;
        padding: 2rem 1.5rem 1.5rem 1.5rem;
        position: relative;
        text-align: left;
    }

    /* Close button */
    .custom-modal-close {
        position: absolute;
        top: 1rem;
        right: 1rem;
        background: transparent;
        border: none;
        font-size: 1.5rem;
        color: #374151;
        cursor: pointer;
    }
</style>
@endpush

@push('scripts')
<script src='https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.js'></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    var calendarEl = document.getElementById('calendar');
    var calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'dayGridMonth',
        headerToolbar: {
            left: 'prev,next',
            center: 'title',
            right: 'dayGridMonth,timeGridWeek,timeGridDay'
        },
        locale: 'en',
        buttonText: {
            today: 'Today',
            month: 'Month',
            week: 'Week',
            day: 'Day'
        },
        events: @json($events),
        eventClick: function(info) {
            const event = info.event;
            const modal = document.createElement('div');
            modal.className = 'custom-modal-overlay';
            modal.innerHTML = `
                <div class=\"custom-modal-box\">
                    <button class=\"custom-modal-close\" id=\"closeModal\" aria-label=\"Tutup\">&times;</button>
                    <h3 class=\"text-lg font-medium text-gray-900 mb-2\">${event.title}</h3>
                    <div class=\"mb-4\">
                        <p class=\"text-sm text-gray-500\">Mulai: ${event.start.toLocaleString('id-ID')}</p>
                        <p class=\"text-sm text-gray-500\">Selesai: ${event.end.toLocaleString('id-ID')}</p>
                        <p class=\"text-sm text-gray-500\">Deskripsi: ${event.extendedProps.description || '-'}</p>
                    </div>
                </div>
            `;
            document.body.appendChild(modal);
            document.body.style.overflow = 'hidden';
            document.getElementById('closeModal').addEventListener('click', function() {
                document.body.removeChild(modal);
                document.body.style.overflow = '';
            });
        },
        eventColor: '#3B82F6',
        eventTimeFormat: {
            hour: '2-digit',
            minute: '2-digit',
            hour12: false
        },
        height: 'auto',
        contentHeight: 700,
        dayMaxEvents: true,
        eventDisplay: 'block'
    });
    
    calendar.render();
    
    document.getElementById('todayBtn').addEventListener('click', function() {
        calendar.today();
    });
});
</script>
@endpush
<x-footer></x-footer>
@endsection 