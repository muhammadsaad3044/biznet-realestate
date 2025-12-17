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
            ->stateless()
            ->redirect();
    }

    public function callbackFacebook()
    {
        try {
            $facebookUser = Socialite::driver('facebook')->stateless()->user();
    
            $email = $facebookUser->getEmail() ?? $facebookUser->getId() . '@facebook.local';
    
            $user = User::where('facebook_id', $facebookUser->getId())->first();
    
            if ($user) {
                $user->update([
                    'facebook_token' => $facebookUser->token,
                ]);
            } else {
                $user = User::create([
                    'name'           => $facebookUser->getName(),
                    'email'          => $email,
                    'facebook_id'    => $facebookUser->getId(),
                    'facebook_token' => $facebookUser->token,
                    'user_role'      => null,
                    'password'       => bcrypt(Str::random(16)),
                ]);
            }
    
            Auth::login($user);
    
            // Generate your API token (Laravel Sanctum / Passport)
            $token = $user->createToken('api-token')->plainTextToken;
    
            // ✅ Encode token to safely pass in URL
            $encodedToken = urlencode($token);
    
            // Send token and user profile data to frontend
            return redirect("http://localhost:3000/?token={$encodedToken}&user_id={$user->id}&email={$user->email}");
    
        } catch (Exception $e) {
            // Redirect with error
            return redirect("http://localhost:3000/?error=" . urlencode($e->getMessage()));
        }
    }

}
