<?php

namespace App\Http\Controllers;

use Illuminate\View\View;
use App\Http\Requests\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class AuthController extends Controller
{
    /**
     * Show login view.
     */
    public function loginView(): View
    {
        return view('login.main', [
            'layout' => 'base'
        ]);
    }

    /**
     * Authenticate login user.
     */
    public function login(LoginRequest $request)
    {
        // Buscar usuario por email
        $user = User::where('email', $request->email)->first();

        // Verificar si existe y está activo
        if (!$user || !$user->active) {
            return response()->json([
                'message' => 'Esta cuenta no está activa o no existe.'
            ], 401);
        }

        // Intentar autenticar
        if (Auth::attempt([
            'email' => $request->email,
            'password' => $request->password
        ])) {
            $request->session()->regenerate();
            return response()->json(['message' => 'Success'], 200);
        }

        return response()->json([
            'message' => 'Correo o contraseña incorrectos.'
        ], 401);
    }

    /**
     * Logout user.
     */
    public function logout(): RedirectResponse
    {
        Auth::logout();
        session()->invalidate();
        session()->regenerateToken();
        return redirect()->route('login');
    }
}