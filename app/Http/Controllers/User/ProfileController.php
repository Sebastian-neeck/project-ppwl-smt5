<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function edit()
    {
        $user = auth()->user(); // Get the currently authenticated user
        return view('profile.edit', compact('user'));
    }

    public function update(Request $request): RedirectResponse
    {
        $user = auth()->user();

        $formFields = $request->validate([
            'name' => 'required|string|max:255',
            'email' => ['required', 'email', Rule::unique('users')->ignore($user->id)],
            'password' => 'nullable|string|min:6|confirmed',
        ]);

        // Only hash and set the password if it's filled
        if ($request->filled('password')) {
            $formFields['password'] = Hash::make($formFields['password']);
        } else {
            // Do not include password in the update array if not filled
            unset($formFields['password']);
        }

        $user->update($formFields);

        return redirect()->route('profile.edit')->with('message', 'Profile updated successfully');
    }

    public function destroy(): RedirectResponse
    {
        $user = auth()->user();
        auth()->logout();
        $user->delete();

        return redirect('/')->with('message', 'Your account has been deleted');
    }
}
