<?php
// app/Http/Controllers/ProfileController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class ProfileController extends Controller
{
    public function show()
    {
        $user = Auth::user()->load('roles');
        return view('gestion.usuarios.profile', compact('user'));
    }

    public function edit()
    {
        $user = Auth::user();
        return view('gestion.usuarios.profile-edit', compact('user'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();
        $validated = $request->validate([
            'first_name' => 'required|string|max:100',
            'last_name' => 'required|string|max:100',
            'email' => ['required', 'email', Rule::unique('users')->ignore($user->id)],
            'position' => 'nullable|string|max:150',
            'gender' => 'nullable|in:male,female,other',
        ], [
            'first_name.required' => 'El nombre es obligatorio.',
            'last_name.required' => 'El apellido es obligatorio.',
            'email.required' => 'El correo electrónico es obligatorio.',
            'email.email' => 'El correo electrónico no es válido.',
            'email.unique' => 'Este correo electrónico ya está registrado.',
            'gender.in' => 'El género seleccionado no es válido.',
            '*.max' => 'El campo supera la longitud permitida.',
        ]);

        $user->update($validated);

        return redirect()->route('profile.overview')
            ->with('success', 'Perfil actualizado correctamente.');
    }

    public function password()
    {
        return view('gestion.usuarios.profile-password');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required|string',
            'password' => 'required|string|min:8|confirmed',
        ], [
            'current_password.required' => 'Ingrese su contraseña actual.',
            'password.required' => 'Ingrese la nueva contraseña.',
            'password.min' => 'La nueva contraseña debe tener al menos 8 caracteres.',
            'password.confirmed' => 'La confirmación no coincide con la nueva contraseña.',
        ]);

        $user = Auth::user();

        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'La contraseña actual no coincide.']);
        }

        $user->update([
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('profile.overview')
            ->with('success', 'Contraseña actualizada correctamente.');
    }
}
