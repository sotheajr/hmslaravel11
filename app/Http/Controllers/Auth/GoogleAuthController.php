<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Session;

class GoogleAuthController extends Controller
{
    // Redirect to Google OAuth
    public function redirect()
    {
        return Socialite::driver('google')->redirect();
    }

    // Callback from Google
    public function callback()
    {
        try {
            $googleUser = Socialite::driver('google')->stateless()->user();

            if (empty($googleUser->email)) {
                return redirect()->route('login')->withErrors('No email returned from Google account.');
            }

            // Check if user exists by google_id or email
            $user = User::where('provider_id', $googleUser->id)
                        ->orWhere('email', $googleUser->email)
                        ->first();

            if (!$user) {
                // Create new user
                $user = User::create([
                    'name'      => $googleUser->name,
                    'email'     => $googleUser->email,
                    'provider_id' => $googleUser->id,
                    'provider'  => 'google',
                    'avatar'    => $googleUser->avatar, // Google URL
                    'password'  => bcrypt(Str::random(24)),
                    'role_name' => 'User',
                    'status'    => 'Active',
                    'join_date' => now(),
                ]);
            } else {
                // Always update google info and avatar
                $user->update([
                    'provider_id' => $googleUser->id,
                    'provider'  => 'google',
                    'avatar'    => $googleUser->avatar,
                    'last_login'=> now(),
                ]);
            }

            // Login the user
            Auth::login($user);

            // Set session
            Session::put([
                'name'    => $user->name,
                'avatar'  => $user->avatar,
                'user_id' => $user->id,
            ]);

            return redirect()->route('home');

        } catch (\Exception $e) {
            \Log::error('Google OAuth Error', [
                'message' => $e->getMessage(),
            ]);

            return redirect()->route('login')->withErrors('Authentication failed. Please try again.');
        }
    }
}
