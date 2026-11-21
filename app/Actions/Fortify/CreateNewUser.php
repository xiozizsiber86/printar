<?php

namespace App\Actions\Fortify;

use App\Models\User;
use App\Models\MerchantProfile;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;
use Laravel\Fortify\Contracts\CreatesNewUsers;

class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules;

    public function create(array $input): User
    {
        Validator::make($input, [
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique(User::class),
            ],
            'role' => [
                'required',
                Rule::in(['customer', 'merchant']),
            ],
            'phone' => [
                'required_if:role,merchant',
                'nullable',
                'string',
                'max:20',
            ],
            'password' => $this->passwordRules(),
        ])->validate();

        return DB::transaction(function () use ($input) {
            $user = new User();

            $user->name = $input['name'];
            $user->email = $input['email'];
            $user->password = Hash::make($input['password']);
            $user->role = $input['role'];
            $user->is_active = true;

            $user->save();

            if ($user->role === 'merchant') {
                MerchantProfile::create([
                    'user_id' => $user->id,
                    'phone' => $input['phone'],
                    'verification_status' => 'pending',
                ]);
            }

            return $user;
        });
    }
}
