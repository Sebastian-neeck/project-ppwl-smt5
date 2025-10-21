@extends('layouts.app')

@section('content')
<div class="flex justify-center items-center">
    <div class="w-full max-w-md">
      <div class="bg-white shadow-md rounded-lg overflow-hidden">
        <div class="bg-blue-500 py-4 px-6">
          <h1 class="text-white text-2xl font-bold">Welcome Back</h1>
        </div>
        <div class="p-6">
          <form method="POST" action="{{ route('login') }}">
            @csrf
  
            <div class="mb-4">
              <label for="email" class="block text-gray-700 font-bold mb-2">Email Address</label>
              <input type="email" id="email" name="email" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('email') border-red-500 @enderror" placeholder="name@example.com" value="{{ old('email') }}" required autocomplete="email" autofocus>
              @error('email')
                <p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>
              @enderror
            </div>
  
            <div class="mb-4">
              <label for="password" class="block text-gray-700 font-bold mb-2">Password</label>
              <input type="password" id="password" name="password" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('password') border-red-500 @enderror" placeholder="Password" required autocomplete="current-password">
              @error('password')
                <p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>
              @enderror
            </div>
  
            <div class="flex items-center justify-between">
              <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                Sign In
              </button>
              <a href="{{ route('register') }}" class="inline-block align-baseline font-bold text-sm text-blue-500 hover:text-blue-800">
                Don't have an account? Sign Up
              </a>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
@endsection
