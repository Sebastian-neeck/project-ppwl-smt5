@extends('layouts.app')

@section('content')
<div class="container mx-auto py-8 mt-16">
    <div class="bg-white shadow-lg rounded-lg overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200">
            <h1 class="text-2xl font-bold text-gray-800">My Job Applications</h1>
            <p class="text-gray-600">Track your job application progress</p>
        </div>

        <div class="p-6">
            @if($applications->isEmpty())
                <div class="text-center py-8">
                    <i class="fas fa-file-alt text-4xl text-gray-400 mb-4"></i>
                    <h3 class="text-lg font-medium text-gray-900 mb-2">No Applications Yet</h3>
                    <p class="text-gray-600 mb-4">You haven't applied to any jobs yet.</p>
                    <a href="{{ route('home') }}" 
                       class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-md text-sm font-medium">
                        Browse Jobs
                    </a>
                </div>
            @else
                <div class="space-y-4">
                    @foreach($applications as $application)
                        <div class="bg-gray-50 rounded-lg p-4 border border-gray-200">
                            <div class="flex justify-between items-start">
                                <div class="flex-1">
                                    <h3 class="text-lg font-semibold text-gray-900">
                                        <a href="{{ route('listings.show', $application->listing) }}" 
                                           class="hover:text-blue-600">
                                            {{ $application->listing->title }}
                                        </a>
                                    </h3>
                                    <div class="flex items-center space-x-4 mt-2 text-sm text-gray-600">
                                        <span class="flex items-center">
                                            <i class="fas fa-building mr-2"></i>
                                            {{ $application->listing->company }}
                                        </span>
                                        <span class="flex items-center">
                                            <i class="fas fa-map-marker-alt mr-2"></i>
                                            {{ $application->listing->location }}
                                        </span>
                                        <span class="flex items-center">
                                            <i class="fas fa-calendar mr-2"></i>
                                            Applied {{ $application->created_at->format('M d, Y') }}
                                        </span>
                                    </div>
                                    <div class="mt-2 flex items-center space-x-4">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                                            @if($application->status == 'pending') bg-yellow-100 text-yellow-800
                                            @elseif($application->status == 'reviewed') bg-blue-100 text-blue-800
                                            @elseif($application->status == 'accepted') bg-green-100 text-green-800
                                            @else bg-red-100 text-red-800 @endif">
                                            {{ ucfirst($application->status) }}
                                        </span>
                                        
                                        @if($application->admin_notes)
                                            <span class="text-sm text-gray-600">
                                                <i class="fas fa-comment mr-1"></i> Employer responded
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="flex space-x-2 ml-4">
                                    <a href="{{ route('applications.show', $application) }}" 
                                       class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-2 rounded text-sm font-medium">
                                        View Details
                                    </a>
                                    <form action="{{ route('applications.destroy', $application) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" 
                                                class="bg-red-500 hover:bg-red-600 text-white px-3 py-2 rounded text-sm font-medium"
                                                onclick="return confirm('Are you sure you want to withdraw this application?')">
                                            Withdraw
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="mt-6">
                    {{ $applications->links() }}
                </div>
            @endif
        </div>
    </div>
</div>
@endsection