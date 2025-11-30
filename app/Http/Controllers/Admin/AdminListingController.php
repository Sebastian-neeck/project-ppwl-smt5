<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Application;
use App\Models\Listing;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdminListingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Ambil semua applications dengan relasi user dan listing
        $applications = Application::with(['user', 'listing'])
            ->latest()
            ->paginate(10);
        
        return view('admin.listings.index', compact('applications'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.listings.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validasi data
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'company' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'email' => 'required|email',
            'website' => 'nullable|url',
            'tags' => 'required|string',
            'description' => 'required|string',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Handle logo upload
        $logoPath = null;
        if ($request->hasFile('logo')) {
            $logoPath = $request->file('logo')->store('logos', 'public');
        }

        // Create listing dengan status approved langsung (karena admin)
        $listing = Listing::create([
            'title' => $validated['title'],
            'company' => $validated['company'],
            'location' => $validated['location'],
            'email' => $validated['email'],
            'website' => $validated['website'],
            'tags' => $validated['tags'],
            'description' => $validated['description'],
            'logo' => $logoPath,
            'status' => 'approved', // Langsung approved karena dibuat admin
            'user_id' => auth()->id(),
        ]);

        return redirect()->route('admin.listings.index')
            ->with('success', 'Job listing created successfully!');
    }

    /**
     * Display the specified application.
     */
    public function showApplication(Application $application)
    {
        return view('admin.listings.application-show', compact('application'));
    }

    /**
     * ✅ TAMBAHKAN METHOD downloadResume INI
     * Download resume for admin
     */
    public function downloadResume(Application $application)
    {
        // Check if resume exists
        if (!$application->resume) {
            return redirect()->back()->with('error', 'No resume file found for this application.');
        }

        // Check if file exists in storage
        if (!Storage::disk('public')->exists($application->resume)) {
            return redirect()->back()->with('error', 'Resume file not found on server. Path: ' . $application->resume);
        }

        // Get file extension and create download name
        $extension = pathinfo($application->resume, PATHINFO_EXTENSION);
        $fileName = 'CV_' . $application->user->name . '_' . $application->listing->title . '.' . $extension;
        
        // Clean filename from special characters
        $fileName = preg_replace('/[^A-Za-z0-9_.]/', '_', $fileName);

        // Download the file
        return Storage::disk('public')->download($application->resume, $fileName);
    }

    /**
     * Accept application
     */
    public function acceptApplication(Application $application)
    {
        $application->update([
            'status' => 'accepted',
            'admin_notes' => 'Application accepted by admin'
        ]);

        return redirect()->route('admin.listings.index')
            ->with('success', 'Application accepted successfully.');
    }

    /**
     * Reject application
     */
    public function rejectApplication(Application $application)
    {
        $application->update([
            'status' => 'rejected',
            'admin_notes' => 'Application rejected by admin'
        ]);

        return redirect()->route('admin.listings.index')
            ->with('success', 'Application rejected successfully.');
    }

    /**
     * Delete application
     */
    public function destroyApplication(Application $application)
    {
        // Hapus file resume jika ada
        if ($application->resume && Storage::disk('public')->exists($application->resume)) {
            Storage::disk('public')->delete($application->resume);
        }

        $application->delete();

        return redirect()->route('admin.listings.index')
            ->with('success', 'Application deleted successfully.');
    }
}