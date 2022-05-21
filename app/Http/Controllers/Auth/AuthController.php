<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Services\Auth\AuthService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class AuthController extends Controller
{
    public function __construct(
        protected AuthService $authService
    )
    {
    }
    public function login(LoginRequest $request)
    {
        $validateRequest = $request->validated();
        return response()->json(
            [
                'data' => $this->authService->login($validateRequest)
            ], Response::HTTP_OK);
    }
}
