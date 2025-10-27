@extends('layouts.app')

@section('content')
<div class="container mx-auto py-8 mt-16">
    <div class="bg-white shadow-lg rounded-lg overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200">
            <h1 class="text-2xl font-bold text-gray-800">Listing Details</h1>
            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                @if($listing->status == 'approved') bg-green-100 text-green-800
                @elseif($listing->status == 'rejected') bg-red-100 text-red-800
                @else bg-yellow-100 text-yellow-800 @endif">
                {{ ucfirst($listing->status) }}
            </span>
        </div>

        <div class="p-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Job Information</h3>
                    <div class="space-y-3">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Title</label>
                            <p class="mt-1 text-sm text-gray-900">{{ $listing->title }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Company</label>
                            <p class="mt-1 text-sm text-gray-900">{{ $listing->company }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Location</label>
                            <p class="mt-1 text-sm text-gray-900">{{ $listing->location }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Tags</label>
                            <p class="mt-1 text-sm text-gray-900">{{ $listing->tags }}</p>
                        </div>
                    </div>
                </div>

                <div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Contact Information</h3>
                    <div class="space-y-3">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Email</label>
                            <p class="mt-1 text-sm text-gray-900">{{ $listing->email }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Website</label>
                            <p class="mt-1 text-sm text-gray-900">
                                <a href="{{ $listing->website }}" target="_blank" class="text-blue-600 hover:text-blue-800">
                                    {{ $listing->website }}
                                </a>
                            </p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Posted By</label>
                            <p class="mt-1 text-sm text-gray-900">{{ $listing->user->name }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Posted Date</label>
                            <p class="mt-1 text-sm text-gray-900">{{ $listing->created_at->format('F j, Y') }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mt-6">
                <label class="block text-sm font-medium text-gray-700">Description</label>
                <p class="mt-2 text-sm text-gray-900 whitespace-pre-line">{{ $listing->description }}</p>
            </div>

            @if($listing->logo)
            <div class="mt-6">
                <label class="block text-sm font-medium text-gray-700">Company Logo</label>
                <img src="{{ asset('storage/' . $listing->logo) }}" alt="{{ $listing->company }} logo" class="mt-2 h-20 w-auto">
            </div>
            @endif
        </div>

        <div class="px-6 py-4 bg-gray-50 border-t border-gray-200">
            <div class="flex space-x-3">
                @if($listing->status == 'pending')
                <form action="{{ route('admin.listings.approve', $listing) }}" method="POST" class="inline">
                    @csrf
                    <button type="submit" class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded text-sm font-medium">
                        Approve Listing
                    </button>
                </form>
                <form action="{{ route('admin.listings.reject', $listing) }}" method="POST" class="inline">
                    @csrf
                    <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded text-sm font-medium">
                        Reject Listing
                    </button>
                </form>
                @endif
                <form action="{{ route('admin.listings.destroy', $listing) }}" method="POST" class="inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded text-sm font-medium" 
                            onclick="return confirm('Are you sure you want to delete this listing?')">
                        Delete Listing
                    </button>
                </form>
                <a href="{{ route('admin.listings.index') }}" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded text-sm font-medium">
                    Back to Listings
                </a>
            </div>
        </div>
    </div>
</div>
@endsection