<?php

namespace App\Http\Requests;

use App\Enums\EventStatus;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class EventRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'event_date' => ['required', 'date'],
            'location' => ['required', 'string', 'max:255'],
            'capacity' => ['required', 'integer', 'min:1', 'max:10000'],
            'status' => ['required', Rule::in(EventStatus::values())]
        ];
    }

    public function messages(): array
    {
        return [
            'title.required' => 'Το πεδίο τίτλος είναι υποχρεωτικό.',
            'title.string' => 'Ο τίτλος πρέπει να είναι κείμενο.',
            'title.max' => 'Ο τίτλος δεν μπορεί να ξεπερνά τους 255 χαρακτήρες.',

            'description.string' => 'Η περιγραφή πρέπει να είναι κείμενο.',

            'event_date.required' => 'Η ημερομηνία του event είναι υποχρεωτική.',
            'event_date.date' => 'Η ημερομηνία του event πρέπει να είναι έγκυρη.',

            'location.required' => 'Η τοποθεσία είναι υποχρεωτική.',
            'location.string' => 'Η τοποθεσία πρέπει να είναι κείμενο.',
            'location.max' => 'Η τοποθεσία δεν μπορεί να ξεπερνά τους 255 χαρακτήρες.',

            'capacity.required' => 'Η χωρητικότητα είναι υποχρεωτική.',
            'capacity.integer' => 'Η χωρητικότητα πρέπει να είναι ακέραιος αριθμός.',
            'capacity.min' => 'Η χωρητικότητα πρέπει να είναι τουλάχιστον 1.',
            'capacity.max' => 'Η χωρητικότητα πρέπει να είναι μέχρι 10000.',

            'status.required' => 'Η κατάσταση του event είναι υποχρεωτική.',
            'status.in' => 'Η κατάσταση που επιλέχθηκε δεν είναι έγκυρη.'
        ];
    }
}
