<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{

    public function __construct()
    {
    }

    public function login(Request $request)
    {
        try {
            $credentials = $request->only('email', 'password');
            $data['email'] = $credentials['email'];
            $data['password'] = $credentials['password'];

            if (!$token = JWTAuth::attempt([
                'email' => $data['email'],
                'password' => $data['password']
            ])) {
                return response()->json(['error' => 'Unauthorized'], 401);
            }

            return response()->json(['status' => 'success', 'token' => $this->respondWithToken($token)], 200)->header('Authorization', $token)
                ->withCookie(
                    'token',
                    $token,
                    // config('jwt.ttl'),
                    '/'
                );
        } catch (\Throwable $th) {
            return  response()->error([$th->getMessage(), $th->getFile(), $th->getLine()]);
        }
    }

    public function register()
    {
        $validador = Validator::make(request()->all(), [
            'nombres' => 'required|string|max:255',
            'apellidos' => 'required|string|max:255',
            'password' => 'required|string|min:6',
        ]);

        if ($validador->fails()) {
            return response()->json($validador->errors()->toJson(), 400);
        }

        $usuario = User::create([
            'nombres' => request('nombres'),
            'apellidos' => request('apellidos'),
            'identificacion' => request('identificacion'),
            'usuario' => request('identificacion'),
            'password' => bcrypt(request('password')),
        ]);

        $usuario->save();

        $token = $this->guard()->login($usuario);

        return response()->json(['message' => 'User created successfully', 'token' => $token], 201);
    }

    /**
     * Logout usuario
     *
     * @return void
     */

    public function logout()
    {
        auth()->logout();
        return response()->json([
            'status' => 'success',
            'message' => 'Logged out Successfully.'
        ], 200);
    }

    /**
     * Obtener el usuario autenticado
     *
     * @return User
     */


    /**
     * Refrescar el token por uno nuevo
     *
     * @return token
     */

    public function me()
    {
        // return response()->json(
        //     Patient::firstWhere('identifier',  auth()->user()->usuario)
        // );
    }

    public function refresh()
    {
        if ($token = $this->guard()->refresh()) {
            return response()->json()
                ->json(['status' => 'successs'], 200)
                ->header('Authorization', $token);
        }
        return response()->json(['error' => 'refresh_token_error'], 401);
    }

    public function renew()
    {
        try {

            if (!$token = $this->guard()->refresh()) {
                return response()->json(['error' => 'refresh_token_error'], 401);
            }

            $user = auth()->user();

            $user = User::with(
                [
                    'person' => function ($q) {
                        $q->select('*');
                    },
                    'permissions' => function ($q) {
                        $q->select('*');
                    }
                ]
            )->find($user->id);

            return response()
                ->json(['status' => 'successs', 'token' => $token, 'user' => $user], 200)
                ->header('Authorization', $token);
        } catch (\Throwable $th) {

            return response()->json(['error' => 'refresh_token_error' . $th->getMessage()], 401);
        }
    }

    /**
     * Retornar el guard
     *
     * @return Guard
     */
    private function guard()
    {
        return Auth::guard();
    }


    protected function respondWithToken($token)
    {
        auth()->factory()->getTTL() * 60;

        return $token;
    }
    public function changePassword()
    {
        if (!auth()->user()) {
            return response()->json(['error' => 'refresh_token_error'], 401);
        }

        $user = User::find(auth()->user()->id);
        $user->password = Hash::make(Request()->get('newPassword'));
        $user->change_password = 0;
        $user->save();
        return Response()->json(['status' => 'successs', 200]);
    }
}
