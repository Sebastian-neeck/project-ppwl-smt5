@extends('layouts.app')

@section('content')
<div class="container mx-auto py-8 mt-16">
    <div class="max-w-4xl mx-auto">
        <div class="bg-white shadow-lg rounded-lg overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200">
                <h1 class="text-2xl font-bold text-gray-800">Application Details</h1>
                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                    @if($application->status == 'pending') bg-yellow-100 text-yellow-800
                    @elseif($application->status == 'reviewed') bg-blue-100 text-blue-800
                    @elseif($application->status == 'accepted') bg-green-100 text-green-800
                    @else bg-red-100 text-red-800 @endif">
                    Status: {{ ucfirst($application->status) }}
                </span>
            </div>

            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Job Information</h3>
                        <div class="space-y-3">
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Position</label>
                                <p class="mt-1 text-sm text-gray-900">{{ $application->listing->title }}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Company</label>
                                <p class="mt-1 text-sm text-gray-900">{{ $application->listing->company }}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Location</label>
                                <p class="mt-1 text-sm text-gray-900">{{ $application->listing->location }}</p>
                            </div>
                        </div>
                    </div>

                    <div>
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Application Details</h3>
                        <div class="space-y-3">
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Applied Date</label>
                                <p class="mt-1 text-sm text-gray-900">{{ $application->created_at->format('F j, Y \a\t g:i A') }}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Last Updated</label>
                                <p class="mt-1 text-sm text-gray-900">{{ $application->updated_at->format('F j, Y \a\t g:i A') }}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Resume</label>
                                <a href="{{ route('applications.download-resume', $application) }}" 
                                   class="mt-1 inline-flex items-center text-blue-600 hover:text-blue-800 text-sm">
                                    <i class="fas fa-download mr-2"></i>Download Resume
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Your Cover Letter</label>
                    <div class="bg-gray-50 rounded-lg p-4 border border-gray-200">
                        <p class="text-sm text-gray-900 whitespace-pre-line">{{ $application->cover_letter }}</p>
                    </div>
                </div>

                @if($application->admin_notes)
                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Employer Feedback</label>
                    <div class="bg-blue-50 rounded-lg p-4 border border-blue-200">
                        <p class="text-sm text-gray-900 whitespace-pre-line">{{ $application->admin_notes }}</p>
                    </div>
                </div>
                @endif

                <div class="flex justify-between items-center pt-4 border-t border-gray-200">
                    <a href="{{ route('applications.my-applications') }}" 
                       class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-md text-sm font-medium">
                        Back to Applications
                    </a>
                    
                    <form action="{{ route('applications.destroy', $application) }}" method="POST" class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" 
                                class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-md text-sm font-medium"
                                onclick="return confirm('Are you sure you want to withdraw this application?')">
                            Withdraw Application
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection