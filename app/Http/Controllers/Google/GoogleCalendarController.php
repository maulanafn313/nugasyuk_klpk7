<?php

namespace App\Http\Controllers\Google;

use Google\Service\Calendar;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\GoogleCalendarService;

class GoogleCalendarController extends Controller
{
    protected $googleCalendarService;

    public function __construct(GoogleCalendarService $googleCalendarService)
    {
        $this->googleCalendarService = $googleCalendarService;
    }

    public function authorize(Request $request)
    {
        $client = $this->googleCalendarService->getClient();
        $client->addScope(Calendar::CALENDAR); // Tambahkan scope yang Anda butuhkan

        $authUrl = $client->createAuthUrl();
        return redirect()->away($authUrl);
    }

    public function callback(Request $request)
    {
        $client = $this->googleCalendarService->getClient();
        $client->addScope(Calendar::CALENDAR);

        if ($request->has('code')) {
            $token = $client->fetchAccessTokenWithAuthCode($request->input('code'));

            // Simpan token untuk pengguna (misalnya, di database)
            $request->session()->put('google_calendar_token', $token);

            return redirect('/dashboard')->with('success', 'Berhasil terhubung ke Google Calendar!');
        } else {
            return redirect('/')->with('error', 'Gagal terhubung ke Google Calendar.');
        }
    }

    public function listEvents()
    {
        $token = session('google_calendar_token');
        if (!$token) {
            return redirect('/google/authorize');
        }

        $client = $this->googleCalendarService->getClient();
        $client->setAccessToken($token);
        $service = $this->googleCalendarService->getService();

        $calendarId = 'primary';
        $optParams = [
            'maxResults' => 50,
            'orderBy' => 'startTime',
            'singleEvents' => true,
            'timeMin' => now()->toRfc3339String(),
        ];
        $events = $service->events->listEvents($calendarId, $optParams);

        $formattedEvents = [];
        foreach ($events->getItems() as $event) {
            $formattedEvents[] = [
                'id'    => $event['id'],
                'title' => $event['summary'] ?? 'No Title',
                'start' => $event['start']['dateTime'] ?? $event['start']['date'],
                'end'   => $event['end']['dateTime'] ?? $event['end']['date'],
            ];
        }

        return view('calendar.events', ['events' => $formattedEvents]);
    }

    // CREATE EVENT
    public function createEvent(Request $request)
    {
        $request->validate([
            'title' => 'required|string',
            'start' => 'required|date',
            'end' => 'required|date|after_or_equal:start',
        ]);

        $token = session('google_calendar_token');
        if (!$token) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $client = $this->googleCalendarService->getClient();
        $client->setAccessToken($token);
        $service = $this->googleCalendarService->getService();

        $event = new \Google\Service\Calendar\Event([
            'summary' => $request->title,
            'start' => ['dateTime' => date(DATE_RFC3339, strtotime($request->start)), 'timeZone' => 'Asia/Jakarta'],
            'end' => ['dateTime' => date(DATE_RFC3339, strtotime($request->end)), 'timeZone' => 'Asia/Jakarta'],
        ]);

        $createdEvent = $service->events->insert('primary', $event);

        // Kembalikan response JSON agar fetch() di frontend tidak error
        return response()->json(['success' => true, 'message' => 'Event berhasil ditambahkan ke Google Calendar!']);
    }

    // UPDATE EVENT
    public function updateEvent(Request $request, $eventId)
    {
        $request->validate([
            'title' => 'required|string',
            'start' => 'required|date',
            'end' => 'required|date|after_or_equal:start',
        ]);

        $token = session('google_calendar_token');
        if (!$token) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $client = $this->googleCalendarService->getClient();
        $client->setAccessToken($token);
        $service = $this->googleCalendarService->getService();

        $event = $service->events->get('primary', $eventId);
        $event->setSummary($request->title);
        $start = new \Google\Service\Calendar\EventDateTime();
        $start->setDateTime(date(DATE_RFC3339, strtotime($request->start)));
        $start->setTimeZone('Asia/Jakarta');
        $event->setStart($start);

        $end = new \Google\Service\Calendar\EventDateTime();
        $end->setDateTime(date(DATE_RFC3339, strtotime($request->end)));
        $end->setTimeZone('Asia/Jakarta');
        $event->setEnd($end);

        $updatedEvent = $service->events->update('primary', $eventId, $event);

        return response()->json(['success' => true, 'message' => 'Event berhasil diupdate!']);
    }

    // DELETE EVENT
    public function deleteEvent($eventId)
    {
        $token = session('google_calendar_token');
        if (!$token) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $client = $this->googleCalendarService->getClient();
        $client->setAccessToken($token);
        $service = $this->googleCalendarService->getService();

        $service->events->delete('primary', $eventId);

        return response()->json(['success' => true, 'message' => 'Event berhasil dihapus!']);
    }
}
