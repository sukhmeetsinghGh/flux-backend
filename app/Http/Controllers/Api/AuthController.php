<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterRequest;
use App\Http\Requests\LoginRequest;
use App\Models\User;
use App\Traits\ApiResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Response;

class AuthController extends Controller
{
    use ApiResponse;

    public function register(RegisterRequest $request)
    {
        // Create a new user
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        // Return response with token
       return $this->sendResponse(
            $user,
            'User registered successfully.',
            Response::HTTP_CREATED
        );
    }

    public function login(LoginRequest $request)
    {
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            $user = Auth::user();
            $token = $user->createToken('YourAppName')->plainTextToken;

            return $this->sendResponse(
                $user,
                'User logged in successfully.',
                Response::HTTP_OK
            )->header('Authorization', 'Bearer ' . $token);
        }

        return $this->sendError(
            'Unauthorized',
            ['error' => 'Invalid credentials.'],
            401
        );
    }
}
