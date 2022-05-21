<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateUserRequest;
use App\Services\UserService;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function __construct(
        protected UserService $userService
    )
    {      
    }
    public function create(CreateUserRequest $request)
    {
        $validatedRequest = $request->validated();
        $this->userService->create($validatedRequest);
        return 'success';
    }
}
