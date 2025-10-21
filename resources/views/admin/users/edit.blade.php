@extends('layouts.app')

@section('content')
    <div class="container mx-auto py-5">
        <div class="flex justify-center">
            <div class="w-full max-w-lg bg-white rounded-lg shadow-lg">
                <div class="bg-blue-600 text-white text-lg font-semibold rounded-t-lg p-4 flex items-center">
                    <i class="fas fa-user-edit mr-2"></i>Edit User
                </div>
                <div class="p-6">
                    <div class="text-center mb-4">
                        <div
                            class="w-24 h-24 bg-blue-200 text-blue-600 font-bold rounded-full flex items-center justify-center mx-auto text-4xl">
                            {{ strtoupper(substr($user->name, 0, 2)) }}
                        </div>
                    </div>

                    <form action="{{ route('admin.users.update', $user) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-4">
                            <label for="name" class="block text-gray-700 font-semibold mb-1">Full Name</label>
                            <div class="relative">
                                <input type="text"
                                    class="border border-gray-300 rounded-lg w-full py-2 px-3 @error('name') border-red-500 @enderror"
                                    id="name" name="name" value="{{ old('name', $user->name) }}" required>
                                @error('name')
                                    <span class="text-red-500 text-sm">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-4">
                            <label for="email" class="block text-gray-700 font-semibold mb-1">Email Address</label>
                            <div class="relative">
                                <input type="email"
                                    class="border border-gray-300 rounded-lg w-full py-2 px-3 @error('email') border-red-500 @enderror"
                                    id="email" name="email" value="{{ old('email', $user->email) }}" required>
                                @error('email')
                                    <span class="text-red-500 text-sm">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-4">
                            <label for="password" class="block text-gray-700 font-semibold mb-1">Password</label>
                            <div class="relative">
                                <input type="password"
                                    class="border border-gray-300 rounded-lg w-full py-2 px-3 @error('password') border-red-500 @enderror"
                                    id="password" name="password">
                                <div class="text-gray-500 text-sm">Leave blank to keep current password</div>
                                @error('password')
                                    <span class="text-red-500 text-sm">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-4">
                            <label for="password_confirmation" class="block text-gray-700 font-semibold mb-1">Confirm
                                Password</label>
                            <div class="relative">
                                <input type="password" class="border border-gray-300 rounded-lg w-full py-2 px-3"
                                    id="password_confirmation" name="password_confirmation">
                            </div>
                        </div>

                        <div class="mb-5 flex items-center">
                            <input class="mr-2" type="checkbox" id="is_admin" name="is_admin" value="1"
                                {{ $user->is_admin ? 'checked' : '' }}>
                            <label class="text-gray-700" for="is_admin">Admin privileges</label>
                        </div>

                        <div class="flex justify-between items-center">
                            <button type="submit"
                                class="bg-blue-600 text-white py-2 px-4 rounded-lg shadow hover:bg-blue-700 transition duration-200">
                                <i class="fas fa-save mr-2"></i>Update User
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
