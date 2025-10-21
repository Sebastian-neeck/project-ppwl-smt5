<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Listing;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
class UserListingController extends Controller
{
    // Show all listings for the user
    public function index()
    {
        $search = request('search');
        $listings = Auth::user()->listings()->latest()->filter(request(['tag', 'search']))->get();
        
        return view('listings.manage', [
            'listings' => $listings,
            'search' => $search
        ]);
    }

    // Show form to create a new listing
    public function create()
    {
        return view('listings.create');
    }

    // Store new listing
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

        $formFields['user_id'] = auth()->id();
        Listing::create($formFields);

        return redirect()->route('listings.index')->with('message', 'Listing created successfully');
    }

    // Show edit form for a listing
    public function edit(Listing $listing)
    {
        $this->authorize('update', $listing);
        return view('listings.edit', compact('listing'));
    }

    // Update a listing
    public function update(Request $request, Listing $listing)
    {
        $this->authorize('update', $listing);

        $formFields = $request->validate([
            'title' => 'required',
            'company' => ['required'],
            'location' => 'required',
            'website' => 'required',
            'email' => ['required', 'email'],
            'tags' => 'required',
            'description' => 'required',
        ]);

        if ($request->hasFile('logo')) {
            $formFields['logo'] = $request->file('logo')->store('logos', 'public');
        }

        $listing->update($formFields);
        return redirect()->route('listings.index')->with('message', 'Listing updated successfully');
    }

    // Delete a listing
    public function destroy(Listing $listing)
    {
        $this->authorize('delete', $listing);
        $listing->delete();

        return redirect()->route('listings.index')->with('message', 'Listing deleted successfully');
    }
}
