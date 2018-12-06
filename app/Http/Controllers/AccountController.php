<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class AccountController extends Controller
{
    public function base64ProfilePicture(Request $request) {

        $user = Auth::user();

        if ($request->has('profile_picture')) {

            $image = $request->file('profile_picture');

            Storage::disk('local')->put($user["id"], base64_encode(File::get($image)));

            return 'success';
        }
    }

    public function getBase64ProfilePicture() {

        //Base64 implementation

        $user_id = Auth::user()["id"];

        if (Storage::disk("local")->exists($user_id)) {

            return new Response(Storage::disk("local")->get($user_id), 200);
        }
    }

    public function profilePicture(Request $request) {

        $user = Auth::user();

        if ($request->has('profile_picture')) {

            $image = $request->file('profile_picture');

            Storage::disk('local')->put($user["id"], File::get($image));

            return 'success';
        }
    }

    public function getProfilePicture() {

        $user_id = Auth::user()["id"];
        $response = base64_encode(File::get(storage_path('app') . "/" . $user_id));

        return new Response($response, 200);
    }

    public function accountDetails()
    {
        $user = Auth::user();

        $user = DB::table('users')
            ->where('email', '=', $user['email'])
            ->join('role_users', 'role_users.user_id', '=', 'users.id' )
            ->join('roles', 'roles.id', '=', 'role_users.role_id' )
            ->first();

        return response()->json($user, 200);
    }
}
