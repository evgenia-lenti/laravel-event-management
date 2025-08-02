<?php

namespace App\Http\Requests;

use App\Enums\UserRole;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UserRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique('users')->ignore($this->user) // ignore this user for update
            ],
            'password' => [
                $this->isMethod('post') ? 'required' : 'sometimes', // not obligatory for update
                'nullable',
                'string',
                'min:8'
            ],
            'role' => ['required', Rule::in(UserRole::values())],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Το όνομα είναι υποχρεωτικό.',
            'name.string'   => 'Το όνομα πρέπει να είναι κείμενο.',
            'name.max'      => 'Το όνομα δεν μπορεί να ξεπερνά τους 255 χαρακτήρες.',

            'email.required' => 'Το email είναι υποχρεωτικό.',
            'email.string'   => 'Το email πρέπει να είναι κείμενο.',
            'email.email'    => 'Το email πρέπει να είναι έγκυρη διεύθυνση.',
            'email.max'      => 'Το email δεν μπορεί να ξεπερνά τους 255 χαρακτήρες.',
            'email.unique'   => 'Αυτό το email χρησιμοποιείται ήδη.',

            'password.required' => 'Ο κωδικός είναι υποχρεωτικός για νέους χρήστες.',
            'password.string'   => 'Ο κωδικός πρέπει να είναι κείμενο.',
            'password.min'      => 'Ο κωδικός πρέπει να έχει τουλάχιστον 8 χαρακτήρες.',

            'role.required' => 'Ο ρόλος είναι υποχρεωτικός.',
            'role.in'       => 'Ο ρόλος που επιλέχθηκε δεν είναι έγκυρος.',
        ];
    }
}
