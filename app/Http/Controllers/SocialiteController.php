<?php

namespace App\Http\Controllers;

use App\Models\User;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;



class SocialiteController extends Controller
{


    public function redirect()
    {
        return Socialite::driver('google')

        //  ->with(['prompt' => 'select_account'])
        ->redirect();
    }
    public function callback()
    {

        try{
            $user = Socialite::driver('google')->user();

            dd($user);
        }catch(\Exception $e){
            dd($e);
        }

//   $provider = Socialite::driver('google')->user();
//  dd('test',$provider);

//         // $user = Socialite::driver('google')->user();

//         //         $user = User::updateOrCreate([
//         //             'google_id' => $user->id,
//         //         ], [
//         //             'first_name' => $user->user["given_name"] ?? '',
//         //             'last_name' => $user->user["family_name"]?? '',
//         //             'email' => $user->email,
//         //             'github_token' => $user->token,
//         //             'github_refresh_token' => $user->refreshToken,
//         //         ]);

//         // Auth::login($user);


    }
}
