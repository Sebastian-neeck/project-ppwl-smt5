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
        
        {{-- ✅ PERBAIKAN: Tombol Contact Employer --}}
        <button onclick="openContactModal()"
                class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-md flex items-center shadow-md transition duration-200">
            <i class="fas fa-address-card mr-2"></i>Contact Info
        </button>
        
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

    {{-- ✅ PERBAIKAN MODAL: Tampilkan semua informasi kontak --}}
<div id="contactModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden z-50">
    <div class="bg-white rounded-lg p-6 max-w-md w-full mx-4">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-xl font-semibold text-gray-800">Contact Information - {{ $listing->company }}</h3>
            <button onclick="closeContactModal()" class="text-gray-500 hover:text-gray-700">
                <i class="fas fa-times"></i>
            </button>
        </div>
        
        <div class="space-y-4">
            {{-- Contact Person --}}
            @if($listing->contact_person)
            <div class="flex items-start">
                <i class="fas fa-user text-blue-500 mt-1 mr-3"></i>
                <div>
                    <p class="font-medium text-gray-700">Contact Person</p>
                    <p class="text-gray-600">{{ $listing->contact_person }}</p>
                </div>
            </div>
            @endif
            
            {{-- Email --}}
            <div class="flex items-start">
                <i class="fas fa-envelope text-blue-500 mt-1 mr-3"></i>
                <div>
                    <p class="font-medium text-gray-700">Email</p>
                    <a href="mailto:{{ $listing->email }}" class="text-blue-600 hover:text-blue-800 break-all">
                        {{ $listing->email }}
                    </a>
                </div>
            </div>
            
            {{-- Phone --}}
            @if($listing->phone)
            <div class="flex items-start">
                <i class="fas fa-phone text-blue-500 mt-1 mr-3"></i>
                <div>
                    <p class="font-medium text-gray-700">Phone Number</p>
                    <a href="tel:{{ $listing->phone }}" class="text-blue-600 hover:text-blue-800">
                        <i class="fas fa-phone-alt mr-1"></i>{{ $listing->phone }}
                    </a>
                </div>
            </div>
            @else
            <div class="flex items-start">
                <i class="fas fa-phone text-blue-500 mt-1 mr-3"></i>
                <div>
                    <p class="font-medium text-gray-700">WhatsApp</p>
                    <p class="text-gray-500 text-sm">+62 838-3081-9410</p>
                </div>
            </div>
            @endif
            
            {{-- Address --}}
            @if($listing->address)
            <div class="flex items-start">
                <i class="fas fa-map-marker-alt text-blue-500 mt-1 mr-3"></i>
                <div>
                    <p class="font-medium text-gray-700">Company Address</p>
                    <p class="text-gray-600">{{ $listing->address }}</p>
                </div>
            </div>
            @endif
            
            {{-- Location --}}
            <div class="flex items-start">
                <i class="fas fa-location-dot text-blue-500 mt-1 mr-3"></i>
                <div>
                    <p class="font-medium text-gray-700">Job Location</p>
                    <p class="text-gray-600">{{ $listing->location }}</p>
                </div>
            </div>
        </div>
        
        <div class="mt-6 flex justify-end space-x-3">
            {{-- Tombol WhatsApp jika ada nomor telepon --}}
            @if($listing->phone)
            <a href="https://web.whatsapp.com/{{ preg_replace('/[^0-9]/', '', $listing->phone) }}?text=Hello%20{{ $listing->company }}%2C%20I%20am%20interested%20in%20the%20{{ $listing->title }}%20position"
               target="_blank"
               class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded-md flex items-center">
                <i class="fab fa-whatsapp mr-2"></i> WhatsApp
            </a>
            @endif
            
            <button onclick="closeContactModal()" 
                    class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-md">
                Close
            </button>
        </div>
    </div>
</div>

    {{-- ✅ TAMBAHKAN SCRIPT UNTUK MODAL --}}
    <script>
    function openContactModal() {
        document.getElementById('contactModal').classList.remove('hidden');
        document.body.style.overflow = 'hidden';
    }

    function closeContactModal() {
        document.getElementById('contactModal').classList.add('hidden');
        document.body.style.overflow = 'auto';
    }

    // Close modal when clicking outside
    document.getElementById('contactModal').addEventListener('click', function(e) {
        if (e.target.id === 'contactModal') {
            closeContactModal();
        }
    });

    // Close modal with Escape key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            closeContactModal();
        }
    });
    </script>
@endsection