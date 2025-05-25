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
            'maxResults' => 10,
            'orderBy' => 'startTime',
            'singleEvents' => true,
            'timeMin' => now()->toRfc3339String(),
        ];
        $events = $service->events->listEvents($calendarId, $optParams);

        $formattedEvents = [];
        foreach ($events->getItems() as $event) {
            $formattedEvents[] = [
                'title' => $event['summary'] ?? 'No Title',
                'start' => $event['start']['dateTime'] ?? $event['start']['date'],
                'end' => $event['end']['dateTime'] ?? $event['end']['date'],
            ];
        }

        return view('calendar.events', ['events' => $formattedEvents]);
    }
}
