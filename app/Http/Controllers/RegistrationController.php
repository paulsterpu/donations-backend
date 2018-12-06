<?php

namespace App\Http\Controllers;

use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Sentinel;
use Activation;
use App\User;
use Mail;

class RegistrationController extends Controller
{
    public function postRegister(Request $request)
    {

        try {

            $validatedData = $request->validate([
                'email' => 'required|email|unique:users',
                'password' => 'required|min:6|password',
                'telefon' => 'required',
                'nume' => 'required|min:4'
            ]);

           // dd($validatedData);

            $user = Sentinel::register($request->all());

            $activation = Activation::create($user);

            $role = Sentinel::findRoleBySlug('ordinary_user');

            $role->users()->attach($user);

            $this->sendEmail($user, $activation->code);

            return response()->json($user);

        } catch (QueryException $e) {
            $errorCode = $e->errorInfo[1];
            if ($errorCode == 1062) {
                return response()->json([
                    'error' => 'mail already exists'
                ], 400);
            }
        }

    }

    private function sendEmail($user, $code) {
        Mail::send("activation", [
            "user" => $user,
            "code" => $code
        ], function($message) use ($user) {
            $message->to($user->email);

            $message->subject("Hello $user->nume, activate your account.");
        });
    }
}