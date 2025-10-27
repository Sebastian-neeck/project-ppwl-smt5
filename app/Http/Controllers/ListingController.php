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
        
        // Only show approved listings to public
        $listings = Listing::where('status', 'approved')
            ->latest()
            ->filter(request(['tag', 'search']))
            ->paginate(6);

        return view('listings.index', [
            'listings' => $listings,
            'search' => $search
        ]);
    }

    // Display the specified resource
    public function show($id)
    {
        // Only show approved listings to public
        $listing = Listing::where('status', 'approved')->findOrFail($id);

        return view('listings.show', compact('listing'));
    }
}