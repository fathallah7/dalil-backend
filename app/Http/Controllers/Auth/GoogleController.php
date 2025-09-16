<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;

class GoogleController extends Controller
{
    public function loginWithGoogle(Request $request)
    {
        $request->validate([
            'token' => 'required|string',
        ]);

        $googleUser = Socialite::driver('google')->stateless()->userFromToken($request->token);

        $user = User::where('provider', 'google')
                    ->where('provider_id', $googleUser->getId())
                    ->first();

        if (!$user) {
            $user = User::create([
                'name' => $googleUser->getName(),
                'email' => $googleUser->getEmail(),
                'provider' => 'google',
                'avatar' => $googleUser->getAvatar(),
                'provider_id' => $googleUser->getId(),
                'password' => bcrypt(str()->random(16)),
            ]);
        } else {
            $user->update([
                'avatar' => $googleUser->getAvatar(),
            ]);
        }


        $token = $user->createToken('API Token')->plainTextToken;

        return response()->json([
            'user' => $user,
            'token' => $token,
        ]);
    }

}
