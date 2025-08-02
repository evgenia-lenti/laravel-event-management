<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegistrationRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'event_id' => ['nullable', 'integer', 'exists:events,id'],
            'user_id'  => ['nullable', 'integer', 'exists:users,id'],
        ];
    }

    public function messages(): array
    {
        return [
            'event_id.integer' => 'Το event ID πρέπει να είναι ακέραιος αριθμός.',
            'event_id.exists'  => 'Το επιλεγμένο event δεν υπάρχει.',
            'user_id.integer'  => 'Το user ID πρέπει να είναι ακέραιος αριθμός.',
            'user_id.exists'   => 'Ο επιλεγμένος χρήστης δεν υπάρχει.',
        ];
    }
}
