<?php

namespace App\Exports;

use App\Models\EventRegistration;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;

class RegistrationsExport implements FromCollection
{
    public function collection(): Collection
    {
        return EventRegistration::with(['user', 'event'])
            ->whereHas('event')
            ->get()
            ->map(function ($registration) {
                return [
                    'User' => $registration->user->name,
                    'Event' => $registration->event->title,
                    'Registration Date' => $registration->created_at->format('d/m/Y H:i'),
                ];
            });
    }

    public function headings(): array
    {
        return [
            'User',
            'Event',
            'Registration Date',
        ];
    }
}
