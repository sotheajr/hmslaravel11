<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Str;
use Exception;

class GithubAuthController extends Controller
{
    /**
     * បញ្ជូន User ទៅកាន់ទំព័រ Login របស់ GitHub
     */
    public function redirect()
    {
        // បន្ថែម scopes ដើម្បីសុំសិទ្ធិមើល email ប្រសិនបើ user កំណត់ private
        return Socialite::driver('github')->scopes(['user:email'])->redirect();
    }

    /**
     * ទទួលទិន្នន័យត្រឡប់មកវិញពី GitHub
     */
    public function callback()
{
    try {
        $githubUser = Socialite::driver('github')->stateless()->user();

        // ១. ឆែកមើលថាមាន User នេះក្នុង System នៅ? (ឆែកតាម provider_id មុនគេ)
        $user = User::where('provider_id', $githubUser->id)->first();

        // ២. បើមិនឃើញតាម ID ទេ ឆែកតាម Email (បើ GitHub បោះ Email មកឱ្យ)
        if (!$user && $githubUser->email) {
            $user = User::where('email', $githubUser->email)->first();
        }

        if (!$user) {
            // បង្កើត user_id ថ្មី (ឧទាហរណ៍៖ KH-0004)
            $lastUser = User::orderBy('id', 'desc')->first();
            $nextId = 'KH-' . str_pad(($lastUser ? $lastUser->id + 1 : 1), 4, '0', STR_PAD_LEFT);

            // បង្កើត User ថ្មី
            $user = User::create([
                'user_id'     => $nextId, // បន្ថែមដើម្បីកុំឱ្យជាប់ error database
                'name'        => $githubUser->name ?? $githubUser->nickname,
                'email'       => $githubUser->email ?? ($githubUser->nickname . '@github.com'), // ការពារករណីគ្មាន email
                'provider_id' => $githubUser->id,
                'provider'    => 'github',
                'avatar'      => $githubUser->avatar,
                'password'    => bcrypt(Str::random(24)),
                'role_name'   => 'Employee', // កំណត់តាម database របស់អ្នក
                'status'      => 'Active',
                'join_date'   => now(),
                'last_login'  => now(),
            ]);
        } else {
            // Update ព័ត៌មានខ្លះៗ
            $user->update([
                'provider_id' => $githubUser->id,
                'provider'    => 'github',
                'last_login'  => now(),
            ]);
        }

        Auth::login($user);
        
        session([
            'name'    => $user->name,
            'avatar'  => $user->avatar,
            'user_id' => $user->id,
        ]);

        return redirect()->route('home');

    } catch (\Exception $e) {
        // ប្រសិនបើនៅតែចេញ "Bad credentials" គឺមកពី Client Secret ក្នុង .env ខុស ១០០%
        dd("Error: " . $e->getMessage());
    }
}
}