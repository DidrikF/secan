<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\{RegisterFormRequest, LoginFormRequest};
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Exceptions\{JWTException};
use Tymon\JWTAuth\JWTAuth;

class AuthController extends Controller
{
    protected $auth;

    public function __construct(JWTAuth $auth)
    {
        $this->auth = $auth;
    }

    public function login(LoginFormRequest $request)
    {
        try {
            if (!$token = $this->auth->attempt($request->only('email', 'password'))) {
                return response()->json([
                    'errors' => [
                        'root' => 'Could not sign you in with those details.'
                    ]
                ], 401);
            }
        } catch (JWTException $e) {
            return response()->json([
                'errors' => [
                    'root' => 'Failed.'
                ]
            ], $e->getStatusCode());
        }
        
        return response()->json([
            'data' => $request->user(),
            'meta' => [
                'token' => $token
            ]
        ], 200);
        
    }

    public function register(RegisterFormRequest $request)
    {
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'username' => $request->username,
            'password' => bcrypt($request->password),
        ]);

        $token = $this->auth->attempt($request->only('email', 'password')); //loggin the user in

        return response()->json([
            'data' => $user,
            'meta' => [
                'token' => $token   //Returning the token, used for authenticating subsequent requests
            ]
        ], 200);
    }

    public function logout(Request $request)
    {
        //testing hack, JWTAuth's request object does not have the authorization header on it for some unknown reason.
        if(env('APP_ENV') == 'testing') {
            
            $token = trim(str_ireplace('bearer', '', $request->headers->get('authorization')));
            $this->auth->invalidate($token);
            Auth::logout();

            return response(null, 200);
        }

        $this->auth->invalidate($this->auth->getToken());
        Auth::logout();

        return response(null, 200);
    }

    public function user(Request $request)
    {
        return response()->json([
            'user' => $request->user(),
        ]);
    }
}