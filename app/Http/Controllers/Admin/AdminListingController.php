<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Listing;
use Illuminate\Http\Request;

class AdminListingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $status = $request->get('status', 'all');
        
        $query = Listing::with('user');
        
        switch ($status) {
            case 'pending':
                $query->where('status', 'pending');
                break;
            case 'approved':
                $query->where('status', 'approved');
                break;
            case 'rejected':
                $query->where('status', 'rejected');
                break;
        }
        
        $listings = $query->latest()->paginate(10);
        
        return view('admin.listings.index', compact('listings', 'status'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Listing $listing)
    {
        return view('admin.listings.show', compact('listing'));
    }

    /**
     * Approve the specified listing.
     */
    public function approve(Listing $listing)
    {
        $listing->update(['status' => 'approved']);

        return redirect()->route('admin.listings.index')
            ->with('success', 'Listing approved successfully.');
    }

    /**
     * Reject the specified listing.
     */
    public function reject(Listing $listing)
    {
        $listing->update(['status' => 'rejected']);

        return redirect()->route('admin.listings.index')
            ->with('success', 'Listing rejected successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Listing $listing)
    {
        $listing->delete();

        return redirect()->route('admin.listings.index')
            ->with('success', 'Listing deleted successfully.');
    }
}