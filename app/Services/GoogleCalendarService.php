<?php

namespace App\Services;

use Google\Client;
use Google\Service\Calendar;
use Google\Service\Calendar\Event;

class GoogleCalendarService
{
    protected $client;
    protected $service;

    public function __construct()
    {
        $client = new Client();
        $client->setClientId(config('services.google.calendar.client_id'));
        $client->setClientSecret(config('services.google.calendar.client_secret'));
        $client->setRedirectUri(config('services.google.calendar.redirect'));
        $client->setAccessType('offline'); // Penting untuk mendapatkan refresh token

        $this->client = $client;
    }

    public function getClient()
    {
        return $this->client;
    }

    public function getService()
    {
        if (!$this->service) {
            $this->service = new Calendar($this->client);
        }
        return $this->service;
    }

    // Tambahkan fungsi-fungsi lain untuk berinteraksi dengan Google Calendar API di sini
    public function createEvent(array $data): Event
    {
        $event = new Event($data);
        return $this->getService()->events->insert(
            config('services.google.calendar_id', 'primary'),
            $event
        );
    }

    public function updateEvent(string $eventId, array $data): Event
    {
        $event = new Event($data);
        return $this->getService()->events->update(
            config('services.google.calendar_id', 'primary'),
            $eventId,
            $event
        );
    }

    public function deleteEvent(string $eventId): void
    {
        $this->getService()->events->delete(
            config('services.google.calendar_id', 'primary'),
            $eventId
        );
    }
}