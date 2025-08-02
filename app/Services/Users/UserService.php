<?php

namespace App\Services\Users;

use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserService
{
    public function createUser(array $data): User
    {
        $data = $this->transformUserData($data);

        return User::create($data);
    }

    public function updateUser(User $user, array $data): User
    {
        $data = $this->transformUserData($data, $user);

        $user->update($data);

        return $user;
    }

    public function deleteUser(User $user): void
    {
        $user->delete();
    }

    private function transformUserData(array $data, ?User $user = null): array
    {
        // add the password to the request in case this is a new user or a new password was given
        if (isset($data['password']) && !empty($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        } else {
            // remove the password from the request in order not to be updated. maintains the existing one
            unset($data['password']);
        }

        return $data;
    }
}
