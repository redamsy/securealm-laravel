<?php

namespace App\Actions\Fortify;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Laravel\Fortify\Contracts\CreatesNewUsers;
use Illuminate\Support\Facades\Log;

class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules;

    /**
     * Validate and create a newly registered user.
     *
     * @param  array<string, string>  $input
     */
    public function create(array $input): User
    {
        Log::info('app/fortify/CreateNewUserl:', ['input' => $input]);
        Validator::make($input, [
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique(User::class),
            ],
            'password' => $this->passwordRules(),
            'genderId' => [
                'required',
                'integer',
                'max_digits:1',
                'exists:genders,id',
                // 'exists:App\Models\Gender,id'
            ],
            'bloodTypeId' => [
                'required',
                'integer',
                'max_digits:1',
                'exists:blood_types,id',
                // 'exists:App\Models\BloodType,id'
            ],
        ])->validate();

        return User::create([
            'name' => $input['name'],
            'email' => $input['email'],
            'password' => Hash::make($input['password']),
            'gender_id' => $input['genderId'],
            'blood_type_id' => $input['bloodTypeId'],
        ]);
    }
}
