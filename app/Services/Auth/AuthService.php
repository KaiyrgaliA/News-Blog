<?php

namespace App\Services\Auth;

use App\Exceptions\ParametersErrorException;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class AuthService
{
    protected User $userModel;

    public function __construct(User $userModel)
    {
        $this->userModel = $userModel;
    }
    public function login($attributes)
    {
        $user = $this->userModel
            ->query()
            ->where('email', $attributes['email'])
            ->first();

        if(!$user)
        {
            throw new ParametersErrorException('Не правильный логин');
        }

        if(!$user->checkPassword($attributes['password']))
        {
            throw new ParametersErrorException('Не правильный пароль');
        }

        $response = [
            'token' => $user->createToken($attributes['email'])->plainTextToken,
        ];

        return $response;
    }

    public function logout()
    {
        if(Auth::check()) {
            $user = $this->userModel->find(Auth::id());
            $user->token()->delete();
        } else abort(401);
    }
}