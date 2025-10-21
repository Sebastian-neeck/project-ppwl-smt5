@extends('layouts.app')

@section('content')
        <div class="container mx-auto px-4">
            <div class="flex justify-center">
                <div class="w-full lg:w-3/4 xl:w-2/3">
                    <!-- Main Card -->
                    <div class="bg-white shadow-lg rounded-lg overflow-hidden">
                        <!-- Gradient Header -->
                        <div class="bg-gradient-to-r from-indigo-500 to-blue-600 text-white text-center p-8">
                            <h1 class="text-3xl font-semibold">Update Job Listing</h1>
                        </div>

                        <!-- Form Section -->
                        <div class="p-6">
                            <form action="/listings/{{ $listing->id }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')

                                <!-- Company Section -->
                                <div class="mb-6">
                                    <div class="flex items-center space-x-3 mb-4">
                                        <span class="text-indigo-600">
                                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                                            </svg>
                                        </span>
                                        <h2 class="text-lg font-medium text-indigo-600">Company Details</h2>
                                    </div>

                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                        <div class="flex flex-col">
                                            <label class="text-gray-700 font-medium">Company Name</label>
                                            <input type="text" name="company" placeholder="Enter your company name"
                                                class="mt-2 p-3 border border-gray-300 rounded-md focus:ring-indigo-500 focus:border-indigo-500"
                                                value="{{ $listing->company }}">
                                        </div>
                                        <div class="flex flex-col">
                                            <label class="text-gray-700 font-medium">Company Logo</label>
                                            <div class="mt-2 flex items-center space-x-4">
                                                <img src="{{ $listing->logo ? asset('storage/' . $listing->logo) : asset('/images/hiring.jfif') }}"
                                                    alt="Company Logo" class="w-24 h-24 object-cover rounded-md border">
                                                <input type="file" name="logo" accept="image/*"
                                                    class="p-2 border border-gray-300 rounded-md">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Contact Section -->
                                <div class="mb-6">
                                    <div class="flex items-center space-x-3 mb-4">
                                        <span class="text-indigo-600">
                                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z">
                                                </path>
                                            </svg>
                                        </span>
                                        <h2 class="text-lg font-medium text-indigo-600">Contact Information</h2>
                                    </div>
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                        <div>
                                            <label class="text-gray-700 font-medium">Email Address</label>
                                            <input type="email" name="email" placeholder="contact@company.com"
                                                class="mt-2 p-3 border border-gray-300 rounded-md focus:ring-indigo-500 focus:border-indigo-500"
                                                value="{{ $listing->email }}">
                                        </div>
                                        <div>
                                            <label class="text-gray-700 font-medium">Company Website</label>
                                            <input type="url" name="website" placeholder="https://company.com"
                                                class="mt-2 p-3 border border-gray-300 rounded-md focus:ring-indigo-500 focus:border-indigo-500"
                                                value="{{ $listing->website }}">
                                        </div>
                                        <div class="col-span-2">
                                            <label class="text-gray-700 font-medium">Location</label>
                                            <input type="text" name="location" placeholder="City, Country or Remote"
                                                class="mt-2 p-3 border border-gray-300 rounded-md focus:ring-indigo-500 focus:border-indigo-500"
                                                value="{{ $listing->location }}">
                                        </div>
                                    </div>
                                </div>

                                <!-- Job Details Section -->
                                <div class="mb-6">
                                    <div class="flex items-center space-x-3 mb-4">
                                        <span class="text-indigo-600">
                                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <rect x="2" y="7" width="20" height="14" rx="2"
                                                    ry="2"></rect>
                                                <path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"></path>
                                            </svg>
                                        </span>
                                        <h2 class="text-lg font-medium text-indigo-600">Job Details</h2>
                                    </div>
                                    <div>
                                        <label class="text-gray-700 font-medium">Job Title</label>
                                        <input type="text" name="title" placeholder="e.g. Senior Software Engineer"
                                            class="mt-2 p-3 w-full border border-gray-300 rounded-md focus:ring-indigo-500 focus:border-indigo-500"
                                            value="{{ $listing->title }}">
                                    </div>
                                    <div class="mt-4">
                                        <label class="text-gray-700 font-medium">Skills & Tags</label>
                                        <input type="text" name="tags" placeholder="e.g. React, Node.js, Remote"
                                            class="mt-2 p-3 w-full border border-gray-300 rounded-md focus:ring-indigo-500 focus:border-indigo-500"
                                            value="{{ $listing->tags }}">
                                        <p class="text-gray-500 text-sm">Separate tags with commas</p>
                                    </div>
                                    <div class="mt-4">
                                        <label class="text-gray-700 font-medium">Job Description</label>
                                        <textarea name="description" rows="6"
                                            placeholder="Describe the role, responsibilities, requirements, and benefits..."
                                            class="mt-2 p-3 w-full border border-gray-300 rounded-md focus:ring-indigo-500 focus:border-indigo-500">{{ $listing->description }}</textarea>
                                    </div>
                                </div>

                                <!-- Submit Button -->
                                <div class="text-center mt-6">
                                    <button type="submit"
                                        class="bg-indigo-600 hover:bg-indigo-700 text-white py-2 px-6 rounded-md font-semibold inline-flex items-center">
                                        Update Job Listing
                                        <span class="ml-2 loader hidden"></span>
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
@endsection
