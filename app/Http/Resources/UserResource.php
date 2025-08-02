<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'createdAt' => $this->created_at->format('d/m/Y H:i'),
            'updatedAt' => $this->updated_at->format('d/m/Y H:i'),
            'role' => UserRoleResource::make($this->role),
            'registeredEventsCount' => $this->registered_events_count ?? 0,
            'registeredEvents' => $this->when(
                $request->routeIs('admin.users.show'),
                EventResource::collection($this->registeredEvents)
            ),
            'can' => [
                'update' => $request->user()->can('update', $this->resource),
                'delete' => $request->user()->can('delete', $this->resource),
            ]
        ];
    }
}
