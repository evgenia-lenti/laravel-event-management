<?php

namespace App\Http\Resources;

use App\Models\EventRegistration;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin EventRegistration */
class RegistrationResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'user' => [
                'id' => $this->user->id,
                'name' => $this->user->name,
                'email' => $this->user->email,
            ],
            'event' => [
                'id' => $this->event->id,
                'title' => $this->event->title,
            ],
            'createdAt' => $this->created_at->format('d/m/Y H:i'),
            'can' => [
                'delete' => $request->user()->can('delete', $this->resource),
            ]
        ];
    }
}
