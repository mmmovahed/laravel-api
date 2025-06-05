<?php
//
//namespace App\Http\Controllers\api;
//
//use App\Http\Controllers\Controller;
//use App\Models\User;
//use Illuminate\Http\Request;
//use App\Http\Requests\api\LoginUserRequest;
//use App\Http\Requests\api\RegisterUserRequest;
//use Illuminate\Support\Facades\Auth;
//use App\Traits\ApiResponses;
//
//class AuthController extends Controller
//{
//    use ApiResponses;
//
//    public function register(RegisterUserRequest $request)
//    {
//        $user = new User();
//        $user->password = bcrypt($request['password']);
//        $user->email = $request["email"];
//        $user->name = $request["name"];
//        $user->phone = $request["phone"];
//        $user->save();
//
//        $token = $user->createToken('API token for '.$user->email)->plainTextToken;
//
//        return $this->ok('User Registered.', [
//            'token' => $token,
//            'user' => $user
//        ]);
////        return $this->ok("User Registered.");
//    }
//
//    public function login(LoginUserRequest $request)
//    {
//        $request->validated($request->all());
//
//        if (!Auth::attempt($request->only('email', 'password'))){
//            return $this->error("Invalid Credentials.", 401);
//        }
//
//        $user = User::firstWhere('email', $request->email);
//
//        return $this->ok(
//          'Authenticated.', [
//              'Token' => $user->createToken(
//                  'API token for '.$user->email,
//                  ['*'],
//                  now()->addWeek()
//              )->plainTextToken
//            ]
//        );
//    }
//
//    public function logout(Request $request)
//    {
//        $request->user()->currentAccessToken()->delete();
//
//        return $this->ok("");
//    }
//}

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\api\LoginUserRequest;
use App\Http\Requests\api\RegisterUserRequest;
use Illuminate\Support\Facades\Auth;
use App\Traits\ApiResponses;
use Exception;
use Illuminate\Database\QueryException;

class AuthController extends Controller
{
    use ApiResponses;

    public function register(RegisterUserRequest $request)
    {
        try {
            if (User::where('email', $request->email)->exists()) {
                return $this->error('Email is already registered.', 409);
            }

            if (User::where('phone', $request->phone)->exists()) {
                return $this->error('Phone number is already registered.', 409);
            }

            $user = new User();
            $user->password = bcrypt($request['password']);
            $user->email = $request["email"];
            $user->name = $request["name"];
            $user->phone = $request["phone"];
            $user->save();

            $token = $user->createToken('API token for ' . $user->email)->plainTextToken;

            return $this->ok('User Registered.', [
                'token' => $token,
                'user' => $user
            ]);
        } catch (QueryException $e) {
            return $this->error('Database error during registration.', 500, [
                'error' => $e->getMessage()
            ]);
        } catch (Exception $e) {
            return $this->error('Unexpected server error during registration.', 500, [
                'error' => $e->getMessage()
            ]);
        }
    }

    public function login(LoginUserRequest $request)
    {
        try {
            if (!Auth::attempt($request->only('email', 'password'))) {
                return $this->error("Invalid Credentials.", 401);
            }

            $user = User::firstWhere('email', $request->email);

            return $this->ok('Authenticated.', [
                'Token' => $user->createToken(
                    'API token for ' . $user->email,
                    ['*'],
                    now()->addWeek()
                )->plainTextToken
            ]);
        } catch (QueryException $e) {
            return $this->error('Database error during login.', 500, [
                'error' => $e->getMessage()
            ]);
        } catch (Exception $e) {
            return $this->error('Unexpected server error during login.', 500, [
                'error' => $e->getMessage()
            ]);
        }
    }

    public function logout(Request $request)
    {
        try {
            $request->user()->currentAccessToken()->delete();
            return $this->ok('Logged out successfully.');
        } catch (Exception $e) {
            return $this->error('Error while logging out.', 500, [
                'error' => $e->getMessage()
            ]);
        }
    }
}
