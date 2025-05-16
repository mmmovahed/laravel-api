<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use App\HTTP\Requests\api\LoginUserRequest;
use Illuminate\Support\Facades\Auth;
use App\Traits\ApiResponses;

class AuthController extends Controller
{
    use ApiResponses;

    public function login(LoginUserRequest $request)
    {
        $request->validated($request->all());

        if (!Auth::attempt($request->only('email', 'password'))){
            return $this->error("Invalid Credentials.", 401);
        }

        $user = User::firstWhere('email', $request->email);

        return $this->ok(
          'Authenticated.', [
              'Token' => $user->createToken('API token for '.$user->email)->plainTextToken
            ]
        );
    }
}
