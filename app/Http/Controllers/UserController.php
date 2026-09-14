<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Spatie\Permission\Models\Role as SpatieRole;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class UserController extends Controller
{
    /**
     * Display a listing of users.
     */
    public function index(): View
    {
        $users = User::with('roles')->paginate(15);
        return view('gestion.usuarios.index', compact('users'));
    }

    /**
     * Show the form for creating a new user.
     */
    public function create(): View
    {
        $roles = SpatieRole::all();
        return view('gestion.usuarios.create', compact('roles'));
    }

    /**
     * Store a newly created user.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'first_name' => 'required|string|max:100',
            'last_name' => 'required|string|max:100',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8|confirmed',
            'position' => 'nullable|string|max:150',
            'gender' => 'nullable|in:male,female,other',
            'active' => 'boolean',
            'roles' => 'array|exists:roles,id',
        ]);

        $user = User::create([
            'first_name' => $validated['first_name'],
            'last_name' => $validated['last_name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'position' => $validated['position'] ?? null,
            'gender' => $validated['gender'] ?? null,
            'active' => $validated['active'] ?? true,
        ]);

        if (!empty($validated['roles'])) {
            // Obtener nombres de roles a partir de los IDs
            $roleNames = SpatieRole::whereIn('id', $validated['roles'])->pluck('name')->toArray();
            $user->syncRoles($roleNames);
        }

        return redirect()->route('gestion.usuarios.index')
            ->with('success', 'Usuario creado exitosamente.');
    }

    /**
     * Display the specified user.
     */
    public function show(User $user): View
    {
        $user->load('roles');
        return view('gestion.usuarios.show', compact('user'));
    }

    /**
     * Show the form for editing the specified user.
     */
    public function edit(User $user): View
    {
        $roles = SpatieRole::all();
        $userRoles = $user->roles->pluck('id')->toArray();
        return view('gestion.usuarios.edit', compact('user', 'roles', 'userRoles'));
    }

    /**
     * Update the specified user.
     */
    public function update(Request $request, User $user): RedirectResponse
    {
        $validated = $request->validate([
            'first_name' => 'required|string|max:100',
            'last_name' => 'required|string|max:100',
            'email' => ['required', 'email', Rule::unique('users')->ignore($user->id)],
            'password' => 'nullable|min:8|confirmed',
            'position' => 'nullable|string|max:150',
            'gender' => 'nullable|in:male,female,other',
            'active' => 'boolean',
            'roles' => 'array|exists:roles,id',
        ]);

        $data = [
            'first_name' => $validated['first_name'],
            'last_name' => $validated['last_name'],
            'email' => $validated['email'],
            'position' => $validated['position'] ?? null,
            'gender' => $validated['gender'] ?? null,
            'active' => $validated['active'] ?? true,
        ];

        if (!empty($validated['password'])) {
            $data['password'] = Hash::make($validated['password']);
        }

        $user->update($data);

        if (!empty($validated['roles'])) {
            $roleNames = SpatieRole::whereIn('id', $validated['roles'])->pluck('name')->toArray();
            $user->syncRoles($roleNames);
        } else {
            $user->syncRoles([]); // Si no se selecciona ningún rol, remover todos
        }

        return redirect()->route('gestion.usuarios.index')
            ->with('success', 'Usuario actualizado exitosamente.');
    }

    /**
     * Remove the specified user.
     */
    public function destroy(User $user): RedirectResponse
    {
        // Prevent deleting yourself
        if ($user->id === auth()->id()) {
            return redirect()->route('gestion.usuarios.index')
                ->with('error', 'No puedes eliminar tu propia cuenta.');
        }

        $user->delete();

        return redirect()->route('gestion.usuarios.index')
            ->with('success', 'Usuario eliminado correctamente.');
    }
}
