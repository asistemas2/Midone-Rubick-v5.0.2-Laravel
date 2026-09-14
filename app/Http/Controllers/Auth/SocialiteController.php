<?php
// app/Http/Controllers/Auth/SocialiteController.php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Str;

class SocialiteController extends Controller
{
    public function redirectToProvider($provider)
    {
        return Socialite::driver($provider)->redirect();
    }

    public function handleProviderCallback($provider)
    {
        try {
            $socialUser = Socialite::driver($provider)->user();
        } catch (\Exception $e) {
            return redirect('/login')->with('error', 'Error al autenticar con ' . ucfirst($provider));
        }

        // Buscar usuario por provider_id o email
        $user = User::where('provider_id', $socialUser->id)
                    ->orWhere('email', $socialUser->email)
                    ->first();

        if ($user) {
            // Actualizar datos si es necesario
            $user->update([
                'provider' => $provider,
                'provider_id' => $socialUser->id,
                'avatar' => $socialUser->avatar,
                'email_verified_at' => now(),
            ]);
        } else {
            // Crear nuevo usuario
            $user = User::create([
                'first_name' => $socialUser->user['given_name'] ?? $socialUser->name,
                'last_name' => $socialUser->user['family_name'] ?? '',
                'name' => $socialUser->name,
                'email' => $socialUser->email,
                'password' => bcrypt(Str::random(24)),
                'provider' => $provider,
                'provider_id' => $socialUser->id,
                'avatar' => $socialUser->avatar,
                'email_verified_at' => now(),
                'active' => 1,
            ]);

            // Asignar rol por defecto
            $user->assignRole('Usuario');
        }

        Auth::login($user, true);

        return redirect()->intended('/dashboard');
    }
}