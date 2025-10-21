@extends('layouts.app')

@section('content')
    <!-- Hero Section -->
    @include('partials.hero')

    <!-- Search Section -->
    @include('partials.search')

    <!-- Listings Section -->
    <section class="py-12 bg-gray-50">
        <div class="container mx-auto px-4 max-w-7xl">
            <div class="flex justify-between items-center mb-8">
                <h2 class="text-3xl font-bold text-gray-900">Available Positions</h2>
                <span class="text-gray-600">{{ $listings->total() }} jobs found</span>
            </div>

            @if ($listings->isEmpty())
                <div class="text-center py-16 px-4 bg-white rounded-lg shadow-sm">
                    <i class="fas fa-briefcase text-5xl text-gray-400 mb-4"></i>
                    <h3 class="text-xl font-semibold text-gray-900 mb-2">No Listings Found</h3>
                    <p class="text-gray-600 max-w-md mx-auto">
                        We couldn't find any job listings matching your criteria.
                        Try adjusting your search or check back later for new opportunities.
                    </p>
                </div>
            @else
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    @foreach ($listings as $listing)
                        <x-listing-card :listing="$listing" />
                    @endforeach
                </div>

                <div class="mt-8">
                    {{ $listings->links() }}
                </div>
            @endif
        </div>
    </section>
@endsection