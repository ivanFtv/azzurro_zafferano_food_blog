<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\User;
use Illuminate\Contracts\Encryption\Encrypter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;


class SocialController extends Controller
{
    public function redirectFacebook() {
         return Socialite::driver('facebook')->fields([
            'first_name',
            'last_name',
            'email',
            'id'
         ])->redirect();
    }

    public function callbackFacebook() {
        try {
            $facebookUser = Socialite::driver('facebook')->user();
            $findUser = User::where('fb_id', $facebookUser->id)->first();

            if($findUser) {
                auth::login($findUser);
                return redirect()->intended('home');
            } else {
                // dd($facebookUser->user['first_name']);
                $newUser = User::create([
                    'name' => $facebookUser->user['first_name'],
                    'lastname' => $facebookUser->user['last_name'],
                    'email' => $facebookUser->email,
                    'avatar' => 'default.png',
                    'fb_id' => $facebookUser->id,
                    'password' => '00000000',
                ]);
               
                Auth::login($newUser);
                $loginSocial = true;
                return redirect()->route('home');
            }
        } catch (Exception $e) {
            dd($e->getMessage());
        }
    }
}
