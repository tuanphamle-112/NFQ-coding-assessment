<?php

namespace App\Http\Controllers;

use App\Constants\Message;
use App\Constants\Status;
use App\Http\Requests\LoginRequest;
use Illuminate\Support\Facades\Auth;

class AuthController extends InitialController
{
    public function login(LoginRequest $request)
    {
        if (!Auth::attempt($request->only('email', 'password'))) {
            return $this->jsonResponse(Status::STATUS_UNAUTHENTICATED, Message::AUTHENTICATION_UNAUTHENTICATED, null);
        }

        $user = Auth::user();
        $token = $user->createToken('API Token')->plainTextToken;

        return $this->jsonResponse(
            Status::STATUS_SUCCESS,
            Message::AUTHENTICATION_TOKEN_FETCH_SUCCESSFULLY,
            [
                'token' => $token,
                'user' => $user,
            ]
        );
    }
}
