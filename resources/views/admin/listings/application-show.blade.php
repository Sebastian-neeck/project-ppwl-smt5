@extends('layouts.app')

@section('content')
<div class="container mx-auto py-8 mt-16">
    <div class="max-w-4xl mx-auto">
        <div class="bg-white shadow-lg rounded-lg overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200 bg-gradient-to-r from-blue-500 to-blue-600 text-white">
                <h1 class="text-2xl font-bold">Application Details</h1>
                <p class="text-blue-100">View applicant information</p>
            </div>

            <div class="p-6">
                <!-- Applicant Information -->
                <div class="mb-8">
                    <h2 class="text-xl font-semibold text-gray-800 mb-4">Applicant Information</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Full Name</label>
                            <p class="mt-1 text-lg text-gray-900">{{ $application->user->name }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Email</label>
                            <p class="mt-1 text-lg text-gray-900">{{ $application->user->email }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Application Date</label>
                            <p class="mt-1 text-lg text-gray-900">{{ $application->created_at->format('F d, Y') }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Status</label>
                            <span class="mt-1 inline-flex items-center px-3 py-1 rounded-full text-sm font-medium 
                                @if($application->status == 'accepted') bg-green-100 text-green-800
                                @elseif($application->status == 'rejected') bg-red-100 text-red-800
                                @else bg-yellow-100 text-yellow-800 @endif">
                                {{ ucfirst($application->status) }}
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Job Information -->
                <div class="mb-8">
                    <h2 class="text-xl font-semibold text-gray-800 mb-4">Job Information</h2>
                    <div class="bg-gray-50 rounded-lg p-4">
                        <h3 class="text-lg font-semibold text-blue-600 mb-2">{{ $application->listing->title }}</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm text-gray-600">
                            <div class="flex items-center">
                                <i class="fas fa-building mr-2"></i>
                                {{ $application->listing->company }}
                            </div>
                            <div class="flex items-center">
                                <i class="fas fa-map-marker-alt mr-2"></i>
                                {{ $application->listing->location }}
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Cover Letter -->
                <div class="mb-8">
                    <h2 class="text-xl font-semibold text-gray-800 mb-4">Cover Letter</h2>
                    <div class="bg-gray-50 rounded-lg p-4">
                        <p class="text-gray-700 whitespace-pre-line">{{ $application->cover_letter }}</p>
                    </div>
                </div>

                <!-- Resume Section - ✅ PERBAIKAN: GUNAKAN ROUTE YANG BENAR -->
                <div class="mb-8">
                    <h2 class="text-xl font-semibold text-gray-800 mb-4">Resume</h2>
                    <div class="bg-gray-50 rounded-lg p-4">
                        @if($application->resume)
                            <div class="flex flex-col space-y-3">
                                <div class="flex items-center space-x-3">
                                    <!-- ✅ PERBAIKAN: GUNAKAN ROUTE admin.listings.download-resume -->
                                    <a href="{{ route('admin.listings.download-resume', $application) }}" 
                                       class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg font-medium inline-flex items-center transition duration-200">
                                        <i class="fas fa-download mr-2"></i>
                                        Download Resume
                                    </a>
                                    <span class="text-sm text-gray-600 bg-white px-3 py-1 rounded border">
                                        <i class="fas fa-file mr-1"></i>
                                        {{ basename($application->resume) }}
                                    </span>
                                </div>
                                <p class="text-xs text-gray-500">
                                    <i class="fas fa-info-circle mr-1"></i>
                                    File akan didownload dengan nama: CV_{{ $application->user->name }}_{{ $application->listing->title }}.{{ pathinfo($application->resume, PATHINFO_EXTENSION) }}
                                </p>
                            </div>
                        @else
                            <p class="text-red-500 flex items-center">
                                <i class="fas fa-exclamation-triangle mr-2"></i>
                                No resume uploaded by the applicant.
                            </p>
                        @endif
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="flex justify-end space-x-3 pt-6 border-t border-gray-200">
                    <a href="{{ route('admin.listings.index') }}" 
                       class="bg-gray-500 hover:bg-gray-600 text-white px-6 py-2 rounded-lg font-medium">
                        Back to Applications
                    </a>
                    @if($application->status != 'accepted')
                        <form action="{{ route('admin.applications.accept', $application) }}" method="POST">
                            @csrf
                            <button type="submit" class="bg-green-500 hover:bg-green-600 text-white px-6 py-2 rounded-lg font-medium">
                                Accept Application
                            </button>
                        </form>
                    @endif
                    @if($application->status != 'rejected')
                        <form action="{{ route('admin.applications.reject', $application) }}" method="POST">
                            @csrf
                            <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-6 py-2 rounded-lg font-medium">
                                Reject Application
                            </button>
                        </form>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection