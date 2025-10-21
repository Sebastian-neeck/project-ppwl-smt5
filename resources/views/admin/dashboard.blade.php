@extends('layouts.app')

@section('content')
    <div class="bg-gray-100 min-h-screen">
        <div class="dashboard-header bg-gray-800 py-4">
            <div class="container mx-auto flex items-center justify-between">
                <h1 class="text-white text-2xl font-semibold flex items-center">
                    <i class="fas fa-tachometer-alt mr-2"></i>
                    Admin Dashboard
                </h1>
            </div>
        </div>

        <div class="container mx-auto py-8">
            <!-- Stats Cards -->
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-6">
                <div class="bg-white rounded-lg shadow-md transition-transform transform hover:scale-105 p-6">
                    <div class="flex items-center justify-between mb-4">
                        <div class="bg-blue-100 p-3 rounded-full">
                            <i class="fas fa-users text-blue-600 text-2xl"></i>
                        </div>
                        <div class="flex items-center text-green-500">
                            <i class="fas fa-arrow-up mr-1"></i>
                            <span class="text-sm">12%</span>
                        </div>
                    </div>
                    <h6 class="text-gray-700 font-medium">Total Users</h6>
                    <div class="text-3xl font-bold text-gray-900">{{ number_format($usersCount) }}</div>
                    <small class="text-gray-500">+128 this month</small>
                </div>

                <div class="bg-white rounded-lg shadow-md transition-transform transform hover:scale-105 p-6">
                    <div class="flex items-center justify-between mb-4">
                        <div class="bg-green-100 p-3 rounded-full">
                            <i class="fas fa-list-alt text-green-600 text-2xl"></i>
                        </div>
                        <div class="flex items-center text-green-500">
                            <i class="fas fa-arrow-up mr-1"></i>
                            <span class="text-sm">8%</span>
                        </div>
                    </div>
                    <h6 class="text-gray-700 font-medium">Total Listings</h6>
                    <div class="text-3xl font-bold text-gray-900">{{ number_format($listingsCount) }}</div>
                    <small class="text-gray-500">+50 this month</small>
                </div>
            </div>
        </div>
    </div>
@endsection
