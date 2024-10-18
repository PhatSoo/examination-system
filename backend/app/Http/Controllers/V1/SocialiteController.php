<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Laravel\Socialite\Facades\Socialite;

use App\Models\User;

class SocialiteController extends Controller
{
    public function redirectToGoogle() {
        return Socialite::driver('google')->redirect();
    }

    public function callbackFromGoogle() {
        $googleUser = Socialite::driver('google')->user();
        dd($googleUser);

        // Tìm người dùng theo email
        $user = User::where('email', $googleUser->email)->first();

        // Nếu không có người dùng, tạo mới
        if (!$user) {

            $credentials = [
                'name' => $googleUser->name,
                'email' => $googleUser->email,
                'password' => 'asdasdasd'
            ];

            $user = User::create($credentials);
        }

        // $token = $user->createToken('Google Token')->accessToken;
        $token = $googleUser->token;

        return $this->sendResponse(message: 'Login success!', data: [
            'token' => $token
        ]);
    }

}