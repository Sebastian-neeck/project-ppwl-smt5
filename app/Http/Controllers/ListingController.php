<?php

namespace App\Http\Controllers;

use App\Models\Listing;
use Illuminate\Http\Request;

class ListingController extends Controller
{
    // Display a listing of the resource
    public function index()
    {
        $search = request('search');
        $listings = Listing::latest()->filter(request(['tag', 'search']))->paginate(6);

        return view('listings.index', [
            'listings' => $listings, // This should be the paginator instance
            'search' => $search
        ]);
    }


    // Display the specified resource
    public function show($id)
    {
        // Find the listing by ID
        $listing = Listing::findOrFail($id);

        // Return a view with the listing
        return view('listings.show', compact('listing'));
    }
}
