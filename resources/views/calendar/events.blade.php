{{-- filepath: c:\laragon\www\nugasyuk_klpk7\resources\views\calendar\events.blade.php --}}
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Google Calendar') }}
        </h2>
    </x-slot>

    <div class="container mx-auto mt-5">

        {{-- Flash Message --}}
        @if (session('success'))
            <div id="flash-success" class="fixed top-5 right-5 z-50 bg-green-500 text-white px-4 py-2 rounded shadow-lg flex items-center gap-2">
                <span>{{ session('success') }}</span>
                <button onclick="document.getElementById('flash-success').remove()" class="ml-2 text-xl leading-none">&times;</button>
            </div>
        @endif
        @if (session('error'))
            <div id="flash-error" class="fixed top-5 right-5 z-50 bg-red-500 text-white px-4 py-2 rounded shadow-lg flex items-center gap-2">
                <span>{{ session('error') }}</span>
                <button onclick="document.getElementById('flash-error').remove()" class="ml-2 text-xl leading-none">&times;</button>
            </div>
        @endif

        <!-- Button Tambah Jadwal -->
        <div class="mb-4 flex justify-end">
            <button id="openAddEventBtn" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition">
                + Tambah Jadwal
            </button>
        </div>

        <!-- FullCalendar Container -->
        <div id="calendar" data-events="{{ json_encode($events) }}"></div>

        <!-- Modal Tambah/Edit Jadwal -->
        <div id="eventModal" class="fixed inset-0 bg-black bg-opacity-40 flex items-center justify-center z-50 hidden">
            <div class="bg-white rounded-lg shadow-lg w-full max-w-md">
                <form id="eventForm" method="POST" class="p-6">
                    @csrf
                    <input type="hidden" name="_method" id="formMethod" value="POST">
                    <input type="hidden" name="event_id" id="event_id">
                    <h2 class="text-lg font-bold mb-4" id="eventModalLabel">Tambah/Edit Jadwal</h2>
                    <div class="mb-3">
                        <label for="title" class="block text-sm font-medium mb-1">Judul</label>
                        <input type="text" class="w-full border rounded px-3 py-2" id="title" name="title" required>
                    </div>
                    <div class="mb-3">
                        <label for="start" class="block text-sm font-medium mb-1">Mulai</label>
                        <input type="datetime-local" class="w-full border rounded px-3 py-2" id="start" name="start" required>
                    </div>
                    <div class="mb-3">
                        <label for="end" class="block text-sm font-medium mb-1">Selesai</label>
                        <input type="datetime-local" class="w-full border rounded px-3 py-2" id="end" name="end" required>
                    </div>
                    <div class="flex justify-between mt-6">
                        <button type="button" class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600" id="deleteEventBtn" style="display:none;">Hapus</button>
                        <div class="flex gap-2">
                            <button type="button" class="bg-gray-300 px-4 py-2 rounded hover:bg-gray-400" id="closeModalBtn">Batal</button>
                            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700" id="saveEventBtn">Simpan</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        {{-- FullCalendar CDN --}}
        <link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.css" rel="stylesheet">
        <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.js"></script>

        <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Inisialisasi FullCalendar
            let calendarEl = document.getElementById('calendar');
            let events = JSON.parse(calendarEl.dataset.events || '[]');
            let calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                events: events.map(ev => ({
                    title: ev.title,
                    start: ev.start,
                    end: ev.end,
                    id: ev.id ?? null
                })),
                selectable: true,
                select: function(info) {
                    showEventModal('Tambah Jadwal', {
                        start: info.startStr,
                        end: info.endStr
                    });
                },
                eventClick: function(info) {
                    showEventModal('Edit Jadwal', {
                        id: info.event.id,
                        title: info.event.title,
                        start: info.event.startStr,
                        end: info.event.endStr
                    });
                }
            });
            calendar.render();

            // Modal logic
            let eventModal = document.getElementById('eventModal');
            let eventForm = document.getElementById('eventForm');
            let deleteBtn = document.getElementById('deleteEventBtn');
            let closeModalBtn = document.getElementById('closeModalBtn');
            let formMethod = document.getElementById('formMethod');

            function showEventModal(title, data = {}) {
                document.getElementById('eventModalLabel').innerText = title;
                eventForm.reset();
                formMethod.value = data.id ? 'PUT' : 'POST';
                document.getElementById('event_id').value = data.id || '';
                document.getElementById('title').value = data.title || '';
                document.getElementById('start').value = data.start ? data.start.replace('Z','').slice(0,16) : '';
                document.getElementById('end').value = data.end ? data.end.replace('Z','').slice(0,16) : '';
                deleteBtn.style.display = data.id ? 'inline-block' : 'none';
                eventModal.classList.remove('hidden');
            }

            closeModalBtn.onclick = function() {
                eventModal.classList.add('hidden');
            };
            eventModal.onclick = function(e) {
                if (e.target === eventModal) eventModal.classList.add('hidden');
            };

            // Submit form (Tambah/Edit)
            eventForm.onsubmit = function(e) {
                e.preventDefault();
                let id = document.getElementById('event_id').value;
                let url = id
                    ? `/google/events/${id}`
                    : `/google/events`;
                let method = id ? 'PUT' : 'POST';

                fetch(url, {
                    method: method,
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({
                        title: document.getElementById('title').value,
                        start: document.getElementById('start').value,
                        end: document.getElementById('end').value
                    })
                })
                .then(res => res.ok ? location.reload() : alert('Gagal menyimpan jadwal!'));
            };

            // Hapus event
            deleteBtn.onclick = function() {
                let id = document.getElementById('event_id').value;
                if (!id) return;
                if (!confirm('Yakin ingin menghapus jadwal ini?')) return;
                fetch(`/google/events/${id}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                })
                .then(res => res.ok ? location.reload() : alert('Gagal menghapus jadwal!'));
            };

            // Tambah: buka modal tambah jadwal saat tombol diklik
            document.getElementById('openAddEventBtn').onclick = function() {
                showEventModal('Tambah Jadwal', {});
            };
        });
        </script>

        <script>
            setTimeout(() => {
                document.getElementById('flash-success')?.remove();
                document.getElementById('flash-error')?.remove();
            }, 5000);
        </script>
    </div>
</x-app-layout>
<x-footer></x-footer>