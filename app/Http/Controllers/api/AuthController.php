<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use App\HTTP\Requests\api\LoginUserRequest;
use App\HTTP\Requests\api\RegisterUserRequest;
use Illuminate\Support\Facades\Auth;
use App\Traits\ApiResponses;

class AuthController extends Controller
{
    use ApiResponses;

    public function register(RegisterUserRequest $request)
    {
        $user = new User();
        $user->password = bcrypt($request['password']);
        $user->email = $request["email"];
        $user->name = $request["name"];
        $user->phone = $request["phone"];
        $user->save();

        $token = $user->createToken('API token for '.$user->email)->plainTextToken;

        return $this->ok('User Registered.', [
            'token' => $token,
            'user' => $user
        ]);
//        return $this->ok("User Registered.");
    }

    public function login(LoginUserRequest $request)
    {
        $request->validated($request->all());

        if (!Auth::attempt($request->only('email', 'password'))){
            return $this->error("Invalid Credentials.", 401);
        }

        $user = User::firstWhere('email', $request->email);

        return $this->ok(
          'Authenticated.', [
              'Token' => $user->createToken(
                  'API token for '.$user->email,
                  ['*'],
                  now()->addWeek()
              )->plainTextToken
            ]
        );
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return $this->ok("");
    }
}
