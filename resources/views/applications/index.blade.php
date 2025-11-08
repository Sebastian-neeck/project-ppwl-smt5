@extends('layouts.app')

@section('content')
<div class="container mx-auto py-8">
    <div class="bg-white shadow-lg rounded-lg overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200 bg-gradient-to-r from-blue-500 to-blue-600 text-white">
            <h1 class="text-2xl font-bold">My Applications</h1>
            <p class="text-blue-100">Track your job applications</p>
        </div>

        <div class="p-6">
            @if($applications->isEmpty())
                <div class="text-center py-8">
                    <i class="fas fa-file-alt text-4xl text-gray-400 mb-4"></i>
                    <h3 class="text-lg font-medium text-gray-900 mb-2">No Applications Yet</h3>
                    <p class="text-gray-600">You haven't applied to any jobs yet.</p>
                    <a href="{{ route('home') }}" 
                       class="mt-4 inline-flex items-center px-4 py-2 bg-blue-500 hover:bg-blue-600 text-white rounded-lg">
                        <i class="fas fa-search mr-2"></i>
                        Browse Jobs
                    </a>
                </div>
            @else
                <div class="space-y-4">
                    @foreach($applications as $application)
                        <div class="border border-gray-200 rounded-lg p-4 hover:bg-gray-50">
                            <div class="flex justify-between items-start">
                                <div class="flex-1">
                                    <h3 class="text-lg font-semibold text-gray-900">
                                        {{ $application->listing->title }}
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
                                            {{ $application->created_at->format('M d, Y') }}
                                        </span>
                                    </div>
                                    <div class="mt-2">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                                            @if($application->status == 'accepted') bg-green-100 text-green-800
                                            @elseif($application->status == 'rejected') bg-red-100 text-red-800
                                            @else bg-yellow-100 text-yellow-800 @endif">
                                            {{ ucfirst($application->status) }}
                                        </span>
                                    </div>
                                </div>
                                <div class="flex space-x-2 ml-4">
                                    <a href="{{ route('applications.show', $application) }}" 
                                       class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-2 rounded text-sm font-medium">
                                        View
                                    </a>
                                    <form action="{{ route('applications.destroy', $application) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-3 py-2 rounded text-sm font-medium" 
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