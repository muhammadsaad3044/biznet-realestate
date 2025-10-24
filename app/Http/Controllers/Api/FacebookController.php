<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Exception;

class FacebookController extends Controller
{
    public function redirectToFacebook()
    {
        return Socialite::driver('facebook')
            ->scopes(['email'])
            ->stateless()->redirect();
    }

    // public function callbackFacebook()
    // {
    //     try {
    //         $facebookUser = Socialite::driver('facebook')->stateless()->user();

    //         // Check if the user already exists
    //         $user = User::where('facebook_id', $facebookUser->getId())->first();

    //         if (!$user) {
    //             // If not, create a new user
    //             $user = User::create([
    //                 'name' => $facebookUser->getName(),
    //                 'email' => $facebookUser->getEmail(),
    //                 'facebook_id' => $facebookUser->getId(),
    //                 'facebook_token' => $facebookUser->token,
    //                 // You might want to set a default password or handle it differently
    //                 'password' => bcrypt(Str::random(16)),
    //             ]);
    //         } else {
    //             // Update the token if the user already exists
    //             $user->update([
    //                 'facebook_token' => $facebookUser->token,
    //             ]);
    //         }

    //         // Log the user in
    //         Auth::login($user);

    //         // Return a response or redirect as needed
    //         return response()->json(['message' => 'Successfully logged in with Facebook', 'user' => $user], 200);
    //     } catch (Exception $e) {
    //         return response()->json(['error' => 'Authentication failed', 'message' => $e->getMessage()], 500);
    //     }
    // }

    public function callbackFacebook()
    {
        try {
            $facebookUser = Socialite::driver('facebook')->stateless()->user();

            $email = $facebookUser->getEmail() ?? $facebookUser->getId() . '@facebook.local';

            $user = User::firstOrCreate(
                ['facebook_id' => $facebookUser->getId()],
                [
                    'name' => $facebookUser->getName(),
                    'email' => $email,
                    'facebook_token' => $facebookUser->token,
                    'password' => bcrypt(Str::random(16)),
                ]
            );

            Auth::login($user);

            return response()->json([
                'message' => 'Successfully logged in with Facebook',
                'user' => $user
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'error' => 'Authentication failed',
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
