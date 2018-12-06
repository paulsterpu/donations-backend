<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class AuthController extends Controller
{

    public function login()
    {
        $credentials = request(['email', 'password']);


        if(Auth::attempt($credentials)){
            $user = Auth::user();
            $success['token'] =  $user->createToken('MyApp')-> accessToken;
            return response()->json(['success' => $success], 200);
        }
        else{
            return response()->json(['error'=>'Unauthorised'], 401);
        }

        /*        if (! $token = auth()->attempt($credentials)) {
                    return response()->json(['error' => 'Unauthorized'], 401);
                }

                $user = DB::table('users')
                    ->where('email', '=', $credentials['email'])
                    ->join('role_users', 'role_users.user_id', '=', 'users.id' )
                    ->join('roles', 'roles.id', '=', 'role_users.role_id' )
                    ->first();

                return $this->respondWithToken($token, $user);*/
    }

    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function me()
    {
        return json_encode(array_merge(json_decode(auth()->user(), true), array('role' => auth()->user()->roles()->first()->slug)));
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        auth()->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return $this->respondWithToken(auth()->refresh());
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @param $user
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token, $user)
    {
        return response()->json(array_merge([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => null,
            //'expires_in' => auth()->factory()->getTTL() * 60,
        ], (array) $user));
    }
}