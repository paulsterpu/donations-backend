<?php

namespace App\Http\Controllers;

use App\User;
use Carbon\Carbon;
use GuzzleHttp\RequestOptions;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use Lcobucci\JWT\Parser;
use Sentinel;
use Illuminate\Http\Request;
use Cartalyst\Sentinel\Checkpoints\ThrottlingException;
use Cartalyst\Sentinel\Checkpoints\NotActivatedException;


class LoginController extends Controller
{

    public function postLogin(Request $request) {

        $credentials = request(['email', 'password']);

        //this method releases bearer tokens, with a modifiable ttl
        $request = Request::create('localhost:80/oauth/token', 'POST', [
            "client_id" => "2",
            "client_secret" => "oeCzFxwCNEN7GupeXwqVDIhEud7E6EGpBPoFYRq0",
            "grant_type" => "password",
            "username" => $credentials['email'],
            "password" => $credentials['password']
        ]);

        try {
            if (Sentinel::authenticate($credentials)){
                $response = app()->handle($request);

                if (!array_key_exists("error", json_decode($response->getContent(), true))) {
                    $user = DB::table("users")
                        ->where("email", $credentials["email"])
                        ->first();
                    $response = array_merge(json_decode($response->getContent(), true), (array)$user);
                }
                return $response;

            } else {

                return array('error' => 'Unauthorized');
            }

        } catch (ThrottlingException $e) {
            $delay = $e->getDelay();

            return array('error' => "You are banned for $delay seconds");

        } catch (NotActivatedException $e) {

            return response()->json(array('error' => "Your account has not been activated yet"), 401);
        }

       /*
        //this approach releases personal access tokens, which have unlimited ttl
        if(Sentinel::authenticate($request->all())){
            $user =  User::where('email', '=', $credentials['email'])->first();

            $success['token'] =  $user->createToken('MyApp')-> accessToken;

            return response()->json(['success' => $success], 200);
        }
        else{
            return response()->json(['error'=>'Unauthorised'], 401);
        }*/

/*
            //i was using this for jtw approach
            $credentials = request(['email', 'password']);

            if (! $token = auth()->attempt($credentials)) {
                return response()->json(['error' => 'Unauthorized'], 401);
            }

            return $this->respondWithToken($token);*/

/*        try {
            if (Sentinel::authenticate($request->all())) {
                return Sentinel::check();

            } else {

                return array('error' => 'Wrong credentials');
            }

        } catch (ThrottlingException $e) {
            $delay = $e->getDelay();

            return array('error' => "You are banned for $delay seconds");

        } catch (NotActivatedException $e) {

            return array('error' => "Your account has not been activated yet");
        }*/
    }

    public function logout(Request $request) {

        Auth::user()->token()->revoke();
        Auth::user()->token()->delete();

        return json_encode(Sentinel::logout());
    }

}
