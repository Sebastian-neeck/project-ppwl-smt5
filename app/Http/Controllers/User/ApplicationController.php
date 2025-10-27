<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Application;
use App\Models\Listing;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ApplicationController extends Controller
{
    // Show form untuk apply job
    public function create(Listing $listing)
    {
        // Cek apakah user sudah apply ke listing ini
        if (Auth::user()->hasApplied($listing->id)) {
            return redirect()->route('listings.show', $listing)
                ->with('error', 'You have already applied to this job.');
        }

        return view('applications.create', compact('listing'));
    }

    // Store application
    public function store(Request $request, Listing $listing)
    {
        // Cek apakah user sudah apply
        if (Auth::user()->hasApplied($listing->id)) {
            return redirect()->route('listings.show', $listing)
                ->with('error', 'You have already applied to this job.');
        }

        $request->validate([
            'cover_letter' => 'required|string|min:100|max:1000',
            'resume' => 'required|file|mimes:pdf,doc,docx|max:2048',
        ]);

        // Upload resume
        $resumePath = $request->file('resume')->store('resumes', 'public');

        // Create application
        Application::create([
            'user_id' => Auth::id(),
            'listing_id' => $listing->id,
            'cover_letter' => $request->cover_letter,
            'resume' => $resumePath,
            'status' => 'pending',
        ]);

        return redirect()->route('applications.my-applications')
            ->with('success', 'Application submitted successfully! We will review your application.');
    }

    // Show user's applications
    public function myApplications()
    {
        $applications = Auth::user()->applications()
            ->with('listing')
            ->latest()
            ->paginate(10);

        return view('applications.index', compact('applications'));
    }

    // Show application details
    public function show(Application $application)
    {
        // Authorization - user hanya bisa lihat application mereka sendiri
        if ($application->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        return view('applications.show', compact('application'));
    }

    // Download resume
    public function downloadResume(Application $application)
    {
        // Authorization
        if ($application->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        return Storage::disk('public')->download($application->resume);
    }

    // Withdraw application
    public function destroy(Application $application)
    {
        // Authorization
        if ($application->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        // Hapus file resume
        Storage::disk('public')->delete($application->resume);
        
        $application->delete();

        return redirect()->route('applications.my-applications')
            ->with('success', 'Application withdrawn successfully.');
    }
}