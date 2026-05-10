<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

class UserController extends Controller
{
    public function index()
    {
        $this->requireAdmin();
        $users = User::latest()->get();
        return view('admin.users.index', compact('users'));
    }

    public function create()
    {
        $this->requireAdmin();
        return view('admin.users.create');
    }

    public function store(Request $request)
    {
        $this->requireAdmin();

        $request->validate([
            'name'     => 'required|string|max:100',
            'email'    => 'required|email|unique:users,email',
            'role'     => 'required|in:admin,manager',
            'password' => ['required', 'confirmed', Password::min(8)],
        ]);

        User::create([
            'name'      => $request->name,
            'email'     => $request->email,
            'role'      => $request->role,
            'password'  => Hash::make($request->password),
            'is_active' => true,
        ]);

        return redirect()->route('admin.users.index')
            ->with('success', 'User created successfully.');
    }

    public function edit(User $user)
    {
        $this->requireAdmin();
        return view('admin.users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $this->requireAdmin();

        $request->validate([
            'name'      => 'required|string|max:100',
            'email'     => ['required', 'email', Rule::unique('users')->ignore($user->id)],
            'role'      => 'required|in:admin,manager',
            'password'  => ['nullable', 'confirmed', Password::min(8)],
            'is_active' => 'boolean',
        ]);

        $data = [
            'name'      => $request->name,
            'email'     => $request->email,
            'role'      => $request->role,
            'is_active' => $request->boolean('is_active', true),
        ];

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        // Prevent removing own admin access
        if ($user->id === Auth::id() && $request->role !== 'admin') {
            return back()->withErrors(['role' => 'You cannot change your own role.']);
        }

        $user->update($data);

        return redirect()->route('admin.users.index')
            ->with('success', 'User updated successfully.');
    }

    public function destroy(User $user)
    {
        $this->requireAdmin();

        if ($user->id === Auth::id()) {
            return back()->with('error', 'You cannot delete your own account.');
        }

        $user->delete();
        return redirect()->route('admin.users.index')
            ->with('success', 'User deleted.');
    }

    private function requireAdmin()
    {
        if (!Auth::user()->isAdmin()) {
            abort(403, 'Only admins can manage users.');
        }
    }
}
