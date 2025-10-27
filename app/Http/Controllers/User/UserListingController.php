<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Listing;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;

class UserListingController extends Controller
{
    // HAPUS method index() - User tidak bisa manage listings

    // Show form to create a new listing
    public function create()
    {
        return view('listings.create');
    }

    // Store new listing dengan status pending
    public function store(Request $request)
    {
        $formFields = $request->validate([
            'title' => 'required',
            'company' => ['required', Rule::unique('listings', 'company')],
            'location' => 'required',
            'website' => 'required',
            'email' => ['required', 'email'],
            'tags' => 'required',
            'description' => 'required',
        ]);

        if ($request->hasFile('logo')) {
            $formFields['logo'] = $request->file('logo')->store('logos', 'public');
        }

        // Tambahkan user_id dan status pending
        $formFields['user_id'] = auth()->id();
        $formFields['status'] = 'pending'; // Otomatis pending butuh approval admin

        Listing::create($formFields);

        return redirect('/')->with('message', 'Listing created successfully! Waiting for admin approval.');
    }

    // HAPUS method edit() - User tidak bisa edit listing

    // HAPUS method update() - User tidak bisa update listing

    // HAPUS method destroy() - User tidak bisa delete listing
}