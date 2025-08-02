<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class EventResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'description' => $this->description,
            'eventDate' => $this->event_date->format('d/m/Y H:i'),
            'location' => $this->location,
            'capacity' => $this->capacity,
            'status' => EventStatusResource::make($this->status),
            'currentRegistrationsCount' => $this->current_registrations_count,
            'can' => [
                'update' => $request->user()->can('update', $this->resource),
                'delete' => $request->user()->can('delete', $this->resource),
            ],
        ];
    }
}
