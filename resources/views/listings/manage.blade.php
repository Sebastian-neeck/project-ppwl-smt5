@extends('layouts.app')

@section('content')
    <div class="container mx-auto py-8">
        <div class="bg-white shadow-lg rounded-lg overflow-hidden">
            <div class="px-8 py-6 border-b bg-gradient-to-r from-blue-500 to-indigo-600 text-white">
                <div class="flex justify-between items-center">
                    <h3 class="text-2xl font-semibold">
                        <i class="fas fa-list-alt mr-2"></i> Manage Listings
                    </h3>
                    <a href="{{ route('listings.create') }}"
                        class="bg-yellow-400 hover:bg-yellow-500 text-gray-800 font-bold py-2 px-5 rounded-lg shadow">
                        <i class="fas fa-plus mr-2"></i> Create
                    </a>
                </div>
            </div>
            <div class="p-8">
                <div class="mb-6">
                    <form action="{{ route('listings.index') }}" method="GET" class="flex items-center">
                        <input type="text" name="search"
                            class="form-input w-full rounded-l-lg px-4 py-3 border-t border-l border-b border-gray-300"
                            placeholder="Search listings..." value="{{ request('search') }}">
                        <button type="submit"
                            class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-6 rounded-r-lg border-t border-r border-b border-blue-600">
                            <i class="fas fa-search mr-2"></i>
                        </button>
                    </form>
                </div>
                @if ($listings->isEmpty())
                    <div class="flex flex-col items-center justify-center py-12 text-center">
                        <i class="fas fa-list-slash text-6xl text-gray-300 mb-4"></i>
                        <h4 class="text-gray-600 font-semibold text-lg">No Listings Found</h4>
                        <p class="text-gray-500">Try adjusting your search criteria</p>
                    </div>
                @else
                    <div class="overflow-x-auto">
                        <table class="min-w-full bg-white rounded-lg shadow-md">
                            <thead class="bg-gray-200">
                                <tr>
                                    <th class="px-6 py-4 text-left text-gray-700 font-medium">Title</th>
                                    <th class="px-6 py-4 text-left text-gray-700 font-medium">Company</th>
                                    <th class="px-6 py-4 text-left text-gray-700 font-medium">Location</th>
                                    @if (auth()->user() && auth()->user()->isAdmin())
                                        <th class="px-6 py-4 text-left text-gray-700 font-medium">Posted By</th>
                                    @endif
                                    <th class="px-6 py-4 text-left text-gray-700 font-medium">Created</th>
                                    <th class="px-6 py-4 text-left text-gray-700 font-medium">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="text-gray-600">
                                @foreach ($listings as $listing)
                                    <tr class="border-b hover:bg-gray-50 transition duration-150 ease-in-out">
                                        <td class="px-6 py-4">{{ $listing->title }}</td>
                                        <td class="px-6 py-4">{{ $listing->company }}</td>
                                        <td class="px-6 py-4">{{ $listing->location }}</td>
                                        @if (auth()->user() && auth()->user()->isAdmin())
                                            <td class="px-6 py-4">{{ $listing->user->name }}</td>
                                        @endif
                                        <td class="px-6 py-4">{{ $listing->created_at->format('M d, Y') }}</td>
                                        <td class="px-6 py-4">
                                            <div class="flex space-x-2">
                                                <a href="/listings/{{ $listing->id }}"
                                                    class="bg-blue-500 hover:bg-blue-600 text-white py-2 px-3 rounded-lg shadow"
                                                    title="View Details">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <a href="/listings/{{ $listing->id }}/edit"
                                                    class="bg-yellow-400 hover:bg-yellow-500 text-gray-800 py-2 px-3 rounded-lg shadow"
                                                    title="Edit Listing">
                                                    <i class="fas fa-pencil-alt"></i>
                                                </a>
                                                <button
                                                    onclick="openDeleteModal('{{ route('listings.destroy', $listing->id) }}')"
                                                    class="bg-red-500 hover:bg-red-600 text-white py-2 px-3 rounded-lg shadow"
                                                    title="Delete Listing">
                                                    <i class="fas fa-trash-alt"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    {{-- <div class="mt-8 flex justify-center">
                        {{ $listings->links('vendor.pagination.tailwind') }}
                    </div> --}}
                @endif
            </div>
        </div>
    </div>

    @include('components.delete-modal') 
@endsection
