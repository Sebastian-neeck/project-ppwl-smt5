@extends('layouts.app')

@section('content')
<div class="container mx-auto py-8 mt-16">
    <div class="bg-white shadow-lg rounded-lg overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200">
            <h1 class="text-2xl font-bold text-gray-800">Manage Job Listings</h1>
            <p class="text-gray-600">Approve or reject job postings</p>
        </div>

        {{-- Filter Tabs --}}
        <div class="border-b border-gray-200">
            <nav class="flex -mb-px">
                <a href="{{ route('admin.listings.index') }}" 
                   class="py-4 px-6 text-center border-b-2 font-medium text-sm {{ request('status') == 'all' || !request('status') ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">
                    All Listings ({{ \App\Models\Listing::count() }})
                </a>
                <a href="{{ route('admin.listings.index', ['status' => 'pending']) }}" 
                   class="py-4 px-6 text-center border-b-2 font-medium text-sm {{ request('status') == 'pending' ? 'border-yellow-500 text-yellow-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">
                    Pending ({{ \App\Models\Listing::where('status', 'pending')->count() }})
                </a>
                <a href="{{ route('admin.listings.index', ['status' => 'approved']) }}" 
                   class="py-4 px-6 text-center border-b-2 font-medium text-sm {{ request('status') == 'approved' ? 'border-green-500 text-green-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">
                    Approved ({{ \App\Models\Listing::where('status', 'approved')->count() }})
                </a>
                <a href="{{ route('admin.listings.index', ['status' => 'rejected']) }}" 
                   class="py-4 px-6 text-center border-b-2 font-medium text-sm {{ request('status') == 'rejected' ? 'border-red-500 text-red-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">
                    Rejected ({{ \App\Models\Listing::where('status', 'rejected')->count() }})
                </a>
            </nav>
        </div>

        <div class="p-6">
            @if($listings->isEmpty())
                <div class="text-center py-8">
                    <i class="fas fa-briefcase text-4xl text-gray-400 mb-4"></i>
                    <h3 class="text-lg font-medium text-gray-900 mb-2">No Listings Found</h3>
                    <p class="text-gray-600">There are no job listings matching your criteria.</p>
                </div>
            @else
                <div class="space-y-4">
                    @foreach($listings as $listing)
                        <div class="bg-gray-50 rounded-lg p-4 border border-gray-200">
                            <div class="flex justify-between items-start">
                                <div class="flex-1">
                                    <h3 class="text-lg font-semibold text-gray-900">{{ $listing->title }}</h3>
                                    <div class="flex items-center space-x-4 mt-2 text-sm text-gray-600">
                                        <span class="flex items-center">
                                            <i class="fas fa-building mr-2"></i>
                                            {{ $listing->company }}
                                        </span>
                                        <span class="flex items-center">
                                            <i class="fas fa-map-marker-alt mr-2"></i>
                                            {{ $listing->location }}
                                        </span>
                                        <span class="flex items-center">
                                            <i class="fas fa-user mr-2"></i>
                                            {{ $listing->user->name }}
                                        </span>
                                        <span class="flex items-center">
                                            <i class="fas fa-calendar mr-2"></i>
                                            {{ $listing->created_at->format('M d, Y') }}
                                        </span>
                                    </div>
                                    <div class="mt-2">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                                            @if($listing->status == 'approved') bg-green-100 text-green-800
                                            @elseif($listing->status == 'rejected') bg-red-100 text-red-800
                                            @else bg-yellow-100 text-yellow-800 @endif">
                                            {{ ucfirst($listing->status) }}
                                        </span>
                                    </div>
                                </div>
                                <div class="flex space-x-2 ml-4">
                                    @if($listing->status == 'pending')
                                        <form action="{{ route('admin.listings.approve', $listing) }}" method="POST" class="inline">
                                            @csrf
                                            <button type="submit" class="bg-green-500 hover:bg-green-600 text-white px-3 py-2 rounded text-sm font-medium">
                                                Approve
                                            </button>
                                        </form>
                                        <form action="{{ route('admin.listings.reject', $listing) }}" method="POST" class="inline">
                                            @csrf
                                            <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-3 py-2 rounded text-sm font-medium">
                                                Reject
                                            </button>
                                        </form>
                                    @endif
                                    <form action="{{ route('admin.listings.destroy', $listing) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="bg-gray-500 hover:bg-gray-600 text-white px-3 py-2 rounded text-sm font-medium" 
                                                onclick="return confirm('Are you sure you want to delete this listing?')">
                                            Delete
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="mt-6">
                    {{ $listings->links() }}
                </div>
            @endif
        </div>
    </div>
</div>
@endsection