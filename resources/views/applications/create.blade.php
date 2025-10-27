@extends('layouts.app')

@section('content')
<div class="container mx-auto py-8 mt-16">
    <div class="max-w-4xl mx-auto">
        <div class="bg-white shadow-lg rounded-lg overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200">
                <h1 class="text-2xl font-bold text-gray-800">Apply for: {{ $listing->title }}</h1>
                <p class="text-gray-600">{{ $listing->company }} - {{ $listing->location }}</p>
            </div>

            <div class="p-6">
                <form action="{{ route('applications.store', $listing) }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="mb-6">
                        <label for="cover_letter" class="block text-sm font-medium text-gray-700 mb-2">
                            Cover Letter *
                        </label>
                        <textarea 
                            name="cover_letter" 
                            id="cover_letter" 
                            rows="8"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                            placeholder="Tell us why you are the right candidate for this position..."
                            required
                        >{{ old('cover_letter') }}</textarea>
                        @error('cover_letter')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                        <p class="mt-1 text-sm text-gray-500">Minimum 100 characters</p>
                    </div>

                    <div class="mb-6">
                        <label for="resume" class="block text-sm font-medium text-gray-700 mb-2">
                            Upload Resume/CV *
                        </label>
                        <input 
                            type="file" 
                            name="resume" 
                            id="resume"
                            accept=".pdf,.doc,.docx"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                            required
                        >
                        @error('resume')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                        <p class="mt-1 text-sm text-gray-500">Accepted formats: PDF, DOC, DOCX (Max: 2MB)</p>
                    </div>

                    <div class="flex justify-end space-x-3">
                        <a href="{{ route('listings.show', $listing) }}" 
                           class="bg-gray-500 hover:bg-gray-600 text-white px-6 py-2 rounded-md text-sm font-medium">
                            Cancel
                        </a>
                        <button type="submit" 
                                class="bg-blue-500 hover:bg-blue-600 text-white px-6 py-2 rounded-md text-sm font-medium">
                            Submit Application
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection