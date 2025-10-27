@extends('layouts.app')

@section('content')
    <div class="container mx-auto py-8">
        <div class="flex justify-center">
            <div class="w-full lg:w-10/12">
                <div class="bg-white shadow-lg rounded-lg p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Company Logo Section -->
                        <div class="flex justify-center md:justify-start">
                            <img src="{{ $listing->logo ? asset('storage/' . $listing->logo) : asset('/images/hiring.jfif') }}"
                                class="w-64 h-64 object-cover shadow-md rounded-md" alt="{{ $listing->company }} logo">
                        </div>

                        <!-- Job Details Section -->
                        <div class="flex flex-col h-full">
                            <!-- Header -->
                            <div class="mb-4">
                                <h1 class="text-3xl font-semibold text-gray-800 mb-2">{{ $listing->title }}</h1>
                                <div class="flex flex-wrap gap-2">
                                    <x-listing-tags :tagsCsv="$listing->tags" />
                                </div>
                            </div>

                            <!-- Company Info -->
                            <div class="mb-4">
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                                    <div class="flex items-center text-gray-700">
                                        <i class="fas fa-building text-blue-500 mr-2"></i>
                                        <span>{{ $listing->company }}</span>
                                    </div>
                                    <div class="flex items-center text-gray-700">
                                        <i class="fas fa-map-marker-alt text-blue-500 mr-2"></i>
                                        <span>{{ $listing->location }}</span>
                                    </div>
                                </div>
                            </div>

                            <!-- Job Description -->
                            <div class="mb-6">
                                <h5 class="text-xl font-semibold text-gray-800 mb-2">About This Role</h5>
                                <p class="text-gray-600">{{ $listing->description }}</p>
                            </div>

                            <!-- Action Buttons -->
                            <div class="mt-auto">
                                <div class="flex flex-wrap gap-4">
                                    @auth
                                        @if (!Auth::user()->is_admin)
                                            @if (Auth::user()->hasApplied($listing->id))
                                                <button disabled
                                                        class="bg-green-500 text-white px-4 py-2 rounded-md flex items-center shadow-md opacity-75 cursor-not-allowed">
                                                    <i class="fas fa-check mr-2"></i>Already Applied
                                                </button>
                                            @else
                                                <a href="{{ route('applications.create', $listing) }}"
                                                   class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded-md flex items-center shadow-md transition duration-200">
                                                    <i class="fas fa-paper-plane mr-2"></i>Apply Now
                                                </a>
                                            @endif
                                        @endif
                                    @else
                                        <a href="{{ route('login') }}"
                                           class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded-md flex items-center shadow-md transition duration-200">
                                            <i class="fas fa-sign-in-alt mr-2"></i>Login to Apply
                                        </a>
                                    @endauth
                                    
                                    <a href="mailto:{{ $listing->email }}"
                                       class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-md flex items-center shadow-md transition duration-200">
                                        <i class="fas fa-envelope mr-2"></i>Contact Employer
                                    </a>
                                    <a href="{{ $listing->website }}" target="_blank"
                                       class="border border-blue-500 text-blue-500 hover:bg-blue-50 px-4 py-2 rounded-md flex items-center shadow-md transition duration-200">
                                        <i class="fas fa-globe mr-2"></i>Visit Website
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection