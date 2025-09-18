<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;

class GoogleController extends Controller
{


    public function loginWithGoogle(Request $request)
    {
        $request->validate([
            'token' => 'required|string',
        ]);

        $resp = Http::get('https://oauth2.googleapis.com/tokeninfo', [
            'id_token' => $request->token,
        ]);

        if (!$resp->ok()) {
            return response()->json(['message' => 'Invalid Google token'], 401);
        }

        $googleUser = $resp->json(); // 'sub', 'email', 'name', 'picture'

        $user = User::updateOrCreate(
            ['provider' => 'google', 'provider_id' => $googleUser['sub']],
            [
                'name' => $googleUser['name'] ?? null,
                'email' => $googleUser['email'] ?? null,
                'password' => bcrypt(Str::random(16)),
                // 'avatar' => $googleUser['picture'] ?? null,
            ]
        );

        $token = $user->createToken('API Token')->plainTextToken;

        return response()->json([
            'user' => $user,
            'token' => $token,
        ]);
    }
}
