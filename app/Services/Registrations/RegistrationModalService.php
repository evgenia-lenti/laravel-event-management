<?php

namespace App\Services\Registrations;

use App\Models\Event;
use App\Models\User;

class RegistrationModalService
{
    public function getUsers()
    {
        return User::select('id', 'name', 'email')->orderBy('name')->get();
    }

    public function getEvents()
    {
        return Event::select('id', 'title')->get();
    }
}
