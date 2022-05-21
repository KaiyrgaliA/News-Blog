<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class UserService
{
    public function create($attributes)
    {
        if(isset($attributes['avatar']))
        {
            $attributes['avatar'] = Storage::disk('avatars')->putFile('', $attributes['avatar']);
        }
        return User::create(
            [
                'name' => $attributes['name'],
                'email' => $attributes['email'],
                'password' => Hash::make($attributes['password']),
                'avatar' => $attributes['avatar']
            ]
        );
    }
}