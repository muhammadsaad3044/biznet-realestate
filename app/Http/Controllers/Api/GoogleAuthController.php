<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;

class GoogleAuthController extends Controller
{
    public function redirect()
    {
        return Socialite::driver('google')
            ->scopes(['openid', 'profile', 'email'])
            ->stateless()
            ->redirect();
    }

    public function callbackGoogle()
    {
        try {
            $googleUser = Socialite::driver('google')->stateless()->user();

            $user = User::where('google_id', $googleUser->getId())
                        ->orWhere('email', $googleUser->getEmail())
                        ->first();

            if (!$user) {
                $user = User::create([
                    'name'                  => $googleUser->getName(),
                    'email'                 => $googleUser->getEmail(),
                    'google_id'             => $googleUser->getId(),
                    'image'                 => $googleUser->getAvatar(), // ✅ Image
                    'email_verified_at'     => now(),                   // ✅ Verified
                    'connect_with_google'   => 1,                       // ✅ Google login flag
                    'password'              => bcrypt(Str::random(16)), // fallback

                    'google_token'          => $googleUser->token,
                    'google_refresh_token'  => $googleUser->refreshToken,
                    'google_token_expiry'   => now()->addSeconds($googleUser->expiresIn),
                ]);
            } else {
                $user->update([
                    'google_id'             => $googleUser->getId(),
                    'image'                 => $googleUser->getAvatar(), // ✅ Update image
                    'connect_with_google'   => 1,                       // ✅ Set flag
                    'google_token'          => $googleUser->token,
                    'google_refresh_token'  => $googleUser->refreshToken ?: $user->google_refresh_token,
                    'google_token_expiry'   => now()->addSeconds($googleUser->expiresIn),
                ]);

                if (!$user->email_verified_at) {
                    $user->email_verified_at = now();
                    $user->save();
                }
            }

            Auth::login($user);

            $token = $user->createToken('authToken')->plainTextToken;

            return response()->json([
                'message' => $user->wasRecentlyCreated ? 'User created' : 'User logged in',
                'token'   => $token,
                'user'    => $user,
            ]);
        } catch (\Throwable $e) {
            return response()->json([
                'message' => 'Authentication failed',
                'error'   => $e->getMessage(),
            ], 500);
        }
    }
}
