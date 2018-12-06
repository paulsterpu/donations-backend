<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Activation;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Sentinel;
use Mail;


class ActivationController extends Controller
{
    public function activate($email, $activationCode) {

        $user = User::whereEmail($email)->first();

        if(Activation::complete($user , $activationCode)) {
            return Redirect::to("http://localhost:3000/login");

        } else {
            return array('response' => 'failed to activate');
        }
    }

    public function resendActivation(Request $request) {

        $email = $request["email"];

        if (isset($email)) {

            $user = DB::table("users")->where("email", $email)->first();

            if(isset($user)) {

                $activation = DB::table("activations")->where("user_id", $user->id)->first();

                if (isset($activation)) {

                    $code = $activation->code;
                    $this->sendEmail($user, $code);

                    return response()->json("success", 200);
                }

            } else {
                return "nope";
            }

        } else {
            return "nope";
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
