<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class AdminUserController extends Controller
{
    public function index(Request $request): View
    {
        $search = $request->input('search');

        $users = User::when($search, function ($query, $search) {
            return $query->where('name', 'like', '%' . $search . '%')
                ->orWhere('email', 'like', '%' . $search . '%');
        })->get();

        return view('admin.users.manage', compact('users', 'search'));
    }

    public function show(User $user): View
    {
        return view('admin.users.show', compact('user'));
    }

    public function edit(User $user): View
    {
        return view('admin.users.edit', compact('user'));
    }

    public function update(Request $request, User $user): RedirectResponse
    {
        $formFields = $request->validate([
            'name' => 'required|string|max:255',
            'email' => ['required', 'email', Rule::unique('users')->ignore($user->id)],
            'password' => 'nullable|string|min:6|confirmed',
            'is_admin' => 'nullable|boolean'
        ]);

        // Check if the password field is filled and hash it if so
        if ($request->filled('password')) {
            $formFields['password'] = Hash::make($formFields['password']);
        } else {
            // Remove password from form fields if not provided
            unset($formFields['password']);
        }

        // Update user with form fields, excluding password if it is not set
        $user->update($formFields);

        return redirect()->route('admin.users.index')->with('message', 'User updated successfully');
    }

    public function destroy(User $user): RedirectResponse
    {
        $user->delete();

        return redirect()->route('admin.users.index')->with('message', 'User deleted successfully');
    }
}
