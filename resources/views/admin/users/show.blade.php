@extends('layouts.app')

@section('content')
    <div class="min-h-screen bg-gray-50 py-8">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Profile Card -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100">
                <!-- Profile Header -->
                <div class="px-6 py-8 border-b border-gray-100">
                    <div class="flex items-center space-x-6">
                        <!-- Avatar -->
                        <div class="h-20 w-20 rounded-full bg-indigo-600 flex items-center justify-center">
                            <span class="text-2xl font-semibold text-white">
                                {{ strtoupper(substr($user->name, 0, 2)) }}
                            </span>
                        </div>
                        <!-- User Info -->
                        <div>
                            <h1 class="text-2xl font-bold text-gray-900">{{ $user->name }}</h1>
                            <p class="text-gray-500 mt-1">{{ $user->email }}</p>
                        </div>
                    </div>
                </div>

                <!-- Content Grid -->
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <!-- Account Information -->
                        <div class="md:col-span-2">
                            <div class="bg-gray-50 rounded-xl p-6">
                                <h2 class="text-lg font-semibold text-gray-900 mb-4">Account Information</h2>

                                <!-- Status -->
                                <div class="space-y-4">
                                    <div class="flex items-center justify-between">
                                        <span class="text-gray-600">Status</span>
                                        <span
                                            class="px-3 py-1 rounded-full text-sm font-medium {{ $user->is_admin ? 'bg-indigo-100 text-indigo-800' : 'bg-green-100 text-green-800' }}">
                                            {{ $user->is_admin ? 'Administrator' : 'Regular User' }}
                                        </span>
                                    </div>

                                    <!-- Member Since -->
                                    <div class="flex items-center justify-between">
                                        <span class="text-gray-600">Member Since</span>
                                        <span class="text-gray-900">{{ $user->created_at->format('F d, Y') }}</span>
                                    </div>

                                    <!-- Last Updated -->
                                    <div class="flex items-center justify-between">
                                        <span class="text-gray-600">Last Updated</span>
                                        <span class="text-gray-900">{{ $user->updated_at->format('F d, Y') }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Actions -->
                        <div>
                            <div class="bg-gray-50 rounded-xl p-6">
                                <h2 class="text-lg font-semibold text-gray-900 mb-4">Actions</h2>
                                <div class="space-y-3">
                                    <a href="{{ route('admin.users.edit', $user) }}"
                                        class="w-full inline-flex items-center justify-center px-4 py-2 border border-transparent rounded-lg text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                        </svg>
                                        Edit Profile
                                    </a>

                                    <button type="button" onclick="toggleModal()"
                                        class="w-full inline-flex items-center justify-center px-4 py-2 border border-transparent rounded-lg text-sm font-medium text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition-colors">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                        Delete Account
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Tailwind Modal -->
    <div id="deleteModal" class="fixed inset-0 z-50 hidden overflow-y-auto" aria-labelledby="modal-title" role="dialog"
        aria-modal="true">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <!-- Background overlay -->
            <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>

            <!-- Modal panel -->
            <div
                class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="sm:flex sm:items-start">
                        <div
                            class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10">
                            <svg class="h-6 w-6 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                            </svg>
                        </div>
                        <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                            <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">
                                Confirm Deletion
                            </h3>
                            <div class="mt-2">
                                <p class="text-sm text-gray-500">
                                    {{ $user->id == auth()->id()
                                        ? 'Are you sure you want to delete your own account? This action cannot be undone.'
                                        : 'Are you sure you want to delete this user? This action cannot be undone.' }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                    <form action="{{ route('admin.users.destroy', $user) }}" method="POST" class="inline-flex">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                            class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-red-600 text-base font-medium text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:ml-3 sm:w-auto sm:text-sm">
                            Delete Account
                        </button>
                    </form>
                    <button type="button" onclick="toggleModal()"
                        class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                        Cancel
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Toggle Script -->
    <script>
        function toggleModal() {
            const modal = document.getElementById('deleteModal');
            const currentState = modal.style.display;
            modal.classList.toggle('hidden');

            // Handle escape key
            document.addEventListener('keydown', function(event) {
                if (event.key === 'Escape' && !modal.classList.contains('hidden')) {
                    toggleModal();
                }
            });

            // Handle click outside modal
            modal.addEventListener('click', function(event) {
                if (event.target === modal) {
                    toggleModal();
                }
            });
        }
    </script>
@endsection
