<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use App\Http\Requests\LoginRequest;
use App\Support\Exceptions\OAuthException;
use App\Support\Traits\Authenticatable;
use Illuminate\Auth\Authenticatable as AuthAuthenticatable;
use Illuminate\Http\JsonResponse;


class AuthController extends Controller
{

    use AuthAuthenticatable;


    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login', 'register',]]);
    }


    public function register(Request $request)
    {
        // Validation logic here

        $user = User::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => bcrypt($request->input('password')),
        ]);

        $token = JWTAuth::fromUser($user);
        
        return response()->json(compact('token'));
    }

    public function getUserId(Request $request)
    {
        $email = $request->query('email');
        $user = User::where('email', $email)->first();
    
        if (!$user) {
            return response()->json(['error' => 'User not found'], 404);
        }
    
        return response()->json(compact('user'));
    }


    protected function createNewToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => 144000,
            'user' => auth()->user()
        ]);
    }

    public function login(Request $request)
    {
        // Validation logic here

        $credentials = $request->only('email', 'password');

        $user = User::where('email', $credentials['email'])->first();

        if (!$user || !Hash::check($credentials['password'], $user->password)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $token = JWTAuth::fromUser($user);

        return response()->json(compact('token'));
    }

    public function logout()
    {
        // logout using json web tokens
        JWTAuth::invalidate(JWTAuth::getToken());
    }
    // function to check if the user is authenticated

    public function checkAuth()
    {
        try {
            if (!$user = JWTAuth::parseToken()->authenticate()) {
                return response()->json(['user_not_found'], 404);
            }
        } catch (TokenExpiredException $e) {
            return response()->json(['token_expired'], $e->getCode());
        } catch (TokenInvalidException $e) {
            return response()->json(['token_invalid'], $e->getCode());
        } catch (JWTException $e) {
            return response()->json(['token_absent'], $e->getCode());
        }

        return response()->json(compact('user'));
    }
}
