@extends('layouts.app')

@section('content')
<div class="container mx-auto py-8 mt-16">
    <div class="bg-white shadow-lg rounded-lg overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center">
            <div>
                <h1 class="text-2xl font-bold text-gray-800">Manage Job Applications</h1>
                <p class="text-gray-600">View and manage job applications from users</p>
            </div>
            <div>
                <a href="{{ route('admin.listings.create') }}" 
                   class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg font-medium flex items-center">
                    <i class="fas fa-plus mr-2"></i>
                    Post New Job
                </a>
            </div>
        </div>

        <div class="p-6">
            {{-- PASTIKAN: Cek $applications --}}
            @if($applications->isEmpty())
                <div class="text-center py-12">
                    <i class="fas fa-file-alt text-5xl text-gray-300 mb-4"></i>
                    <h3 class="text-xl font-medium text-gray-900 mb-2">No Applications Yet</h3>
                    <p class="text-gray-600 mb-6">Users haven't applied to any jobs yet.</p>
                    <a href="{{ route('admin.listings.create') }}" 
                       class="bg-blue-500 hover:bg-blue-600 text-white px-6 py-3 rounded-lg font-medium inline-flex items-center">
                        <i class="fas fa-plus mr-2"></i>
                        Post a Job to Get Applications
                    </a>
                </div>
            @else
                <div class="space-y-6">
                    {{-- PASTIKAN: Loop $applications --}}
                    @foreach($applications as $application)
                        <div class="border border-gray-200 rounded-lg p-6 hover:shadow-md transition-shadow">
                            <div class="flex justify-between items-start">
                                <div class="flex-1">
                                    <!-- Applicant Info -->
                                    <div class="mb-4">
                                        <h3 class="text-lg font-semibold text-gray-900 mb-1">
                                            {{ $application->user->name }}
                                        </h3>
                                        <p class="text-gray-600 mb-2">{{ $application->user->email }}</p>
                                        <p class="text-sm text-gray-500">
                                            Applied on {{ $application->created_at->format('F d, Y') }}
                                        </p>
                                    </div>

                                    <!-- Job Info -->
                                    <div class="bg-gray-50 rounded-lg p-4">
                                        <h4 class="font-medium text-gray-900 mb-2">Applied for:</h4>
                                        <p class="text-lg text-blue-600 font-semibold">{{ $application->listing->title }}</p>
                                        <div class="flex items-center space-x-4 mt-2 text-sm text-gray-600">
                                            <span class="flex items-center">
                                                <i class="fas fa-building mr-2"></i>
                                                {{ $application->listing->company }}
                                            </span>
                                            <span class="flex items-center">
                                                <i class="fas fa-map-marker-alt mr-2"></i>
                                                {{ $application->listing->location }}
                                            </span>
                                        </div>
                                    </div>

                                    <!-- Application Status -->
                                    <div class="mt-4">
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium 
                                            @if($application->status == 'accepted') bg-green-100 text-green-800
                                            @elseif($application->status == 'rejected') bg-red-100 text-red-800
                                            @else bg-yellow-100 text-yellow-800 @endif">
                                            Status: {{ ucfirst($application->status) }}
                                        </span>
                                    </div>
                                </div>

                                <!-- Action Buttons -->
                                <div class="flex flex-col space-y-3 ml-6">
                                    <!-- View Button -->
                                    <a href="{{ route('admin.listings.application-show', $application) }}" 
                                       class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded text-sm font-medium text-center flex items-center justify-center">
                                        <i class="fas fa-eye mr-2"></i> View Details
                                    </a>

                                    <!-- Accept/Reject Buttons -->
                                    <div class="flex space-x-2">
                                        @if($application->status != 'accepted')
                                            <form action="{{ route('admin.applications.accept', $application) }}" method="POST" class="flex-1">
                                                @csrf
                                                <button type="submit" class="w-full bg-green-500 hover:bg-green-600 text-white px-3 py-2 rounded text-sm font-medium">
                                                    Accept
                                                </button>
                                            </form>
                                        @endif
                                        @if($application->status != 'rejected')
                                            <form action="{{ route('admin.applications.reject', $application) }}" method="POST" class="flex-1">
                                                @csrf
                                                <button type="submit" class="w-full bg-red-500 hover:bg-red-600 text-white px-3 py-2 rounded text-sm font-medium">
                                                    Reject
                                                </button>
                                            </form>
                                        @endif
                                    </div>

                                    <!-- Delete Button -->
                                    <form action="{{ route('admin.applications.destroy', $application) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="w-full bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded text-sm font-medium" 
                                                onclick="return confirm('Are you sure you want to delete this application?')">
                                            <i class="fas fa-trash mr-1"></i> Delete
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