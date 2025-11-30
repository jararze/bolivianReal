<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class UserController extends Controller
{
    /**
     * Display a listing of users
     */
    public function index(Request $request)
    {
        $query = User::with('package')->withCount('properties');

        // Filtro de búsqueda
        if ($request->filled('search')) {
            $query->search($request->search);
        }

        // Filtro por estado
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filtro por rol
        if ($request->filled('role')) {
            $query->where('role', $request->role);
        }

        $users = $query->latest()->paginate(20);

        // Estadísticas
        $stats = [
            'total' => User::count(),
            'active' => User::where('status', 'active')->count(),
            'inactive' => User::where('status', 'inactive')->count(),
            'agents' => User::where('role', 'agent')->count(),
            'admins' => User::where('role', 'admin')->count(),
        ];

        return view('backend.users.index', compact('users', 'stats'));
    }

    /**
     * Show the form for creating a new user
     */
    public function create()
    {
        return view('backend.users.create');
    }

    /**
     * Store a newly created user
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'lastname' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'username' => ['nullable', 'string', 'max:255', 'unique:users'],
            'phone' => ['nullable', 'string', 'max:255'],
            'jobtitle' => ['nullable', 'string', 'max:255'],
            'role' => ['required', 'in:admin,agent,user'],
            'status' => ['required', 'in:active,inactive'],
            'package_id' => ['nullable', 'exists:packages,id'],
        ]);

        $validated['password'] = Hash::make($validated['password']);

        User::create($validated);

        return redirect()->route('backend.users.index')
            ->with('success', 'Usuario creado exitosamente');
    }

    /**
     * Display the specified user
     */
    public function show(User $user)
    {
        $user->load([
            'package',
            'properties' => function($query) {
                $query->withCount('contracts')->latest()->take(10);
            }
        ]);

        // Estadísticas del usuario
        $stats = [
            'properties' => $user->properties()->count(),
            'active_properties' => $user->properties()->where('status', true)->count(),
            'contracts' => $user->properties()->withCount('contracts')->get()->sum('contracts_count'),
            'clients' => $user->createdClients()->count(),
        ];

        return view('backend.users.show', compact('user', 'stats'));
    }

    /**
     * Show the form for editing the specified user
     */
    public function edit(User $user)
    {
        return view('backend.users.edit', compact('user'));
    }

    /**
     * Update the specified user
     */
    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'lastname' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $user->id],
            'password' => ['nullable', 'confirmed', Rules\Password::defaults()],
            'username' => ['nullable', 'string', 'max:255', 'unique:users,username,' . $user->id],
            'phone' => ['nullable', 'string', 'max:255'],
            'jobtitle' => ['nullable', 'string', 'max:255'],
            'role' => ['required', 'in:admin,agent,user'],
            'status' => ['required', 'in:active,inactive'],
            'package_id' => ['nullable', 'exists:packages,id'],
        ]);

        if ($request->filled('password')) {
            $validated['password'] = Hash::make($validated['password']);
        } else {
            unset($validated['password']);
        }

        $user->update($validated);

        return redirect()->route('backend.users.index')
            ->with('success', 'Usuario actualizado exitosamente');
    }

    /**
     * Remove the specified user
     */
    public function destroy(User $user)
    {
        // Verificar si tiene propiedades asociadas
        if ($user->properties()->count() > 0) {
            return back()->with('warning', 'No se puede eliminar el usuario porque tiene propiedades asociadas');
        }

        $user->delete();

        return redirect()->route('backend.users.index')
            ->with('success', 'Usuario eliminado exitosamente');
    }

    /**
     * Toggle user status
     */
    public function toggleStatus(User $user)
    {
        $newStatus = $user->status === 'active' ? 'inactive' : 'active';
        $user->update(['status' => $newStatus]);

        $message = $newStatus === 'active' ? 'Usuario activado' : 'Usuario desactivado';

        return back()->with('success', $message);
    }
}
