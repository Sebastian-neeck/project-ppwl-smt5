<nav class="bg-white shadow-md fixed top-0 w-full z-50">
    <div class="container mx-auto px-4">
        <div class="flex justify-between h-16">
            <div class="flex items-center">
                <a href="{{ url('/') }}" class="flex items-center">
                    <img src="{{ asset('images/logo.png') }}" alt="{{ config('app.name') }} Logo" class="h-10 w-auto mr-2">
                    {{-- <span class="text-xl font-semibold">{{ config('app.name', 'Laravel') }}</span> --}}
                </a>
            </div>

            <!-- Mobile menu button -->
            <div class="flex items-center md:hidden">
                <button type="button"
                    class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100"
                    @click="open = !open" aria-expanded="false">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>
            </div>

            <!-- Desktop menu -->
            <div class="hidden md:flex md:items-center md:space-x-4">
                <!-- Left Side -->
                @auth
                    <a href="{{ route('listings.index') }}"
                        class="text-gray-600 hover:text-gray-900 px-3 py-2 rounded-md text-sm font-medium">
                        <i class="fa fa-list-alt mr-2"></i>Manage Listings
                    </a>

                    @if (Auth::user()->is_admin)
                        <a href="{{ route('admin.users.index') }}"
                            class="text-gray-600 hover:text-gray-900 px-3 py-2 rounded-md text-sm font-medium">
                            <i class="fas fa-users mr-2"></i>Manage Users
                        </a>
                        <a href="{{ route('admin.dashboard') }}"
                            class="text-gray-600 hover:text-gray-900 px-3 py-2 rounded-md text-sm font-medium">
                            <i class="fas fa-tachometer-alt mr-2"></i>Dashboard
                        </a>
                    @endif
                @endauth

                <!-- Right Side -->
                <div class="flex items-center ml-4">
                    @guest
                        @if (Route::has('login'))
                            <a href="{{ route('login') }}"
                                class="text-gray-600 hover:text-gray-900 px-3 py-2 rounded-md text-sm font-medium">
                                <i class="fas fa-sign-in-alt mr-2"></i>{{ __('Login') }}
                            </a>
                        @endif

                        @if (Route::has('register'))
                            <a href="{{ route('register') }}"
                                class="text-gray-600 hover:text-gray-900 px-3 py-2 rounded-md text-sm font-medium">
                                <i class="fas fa-user-plus mr-2"></i>{{ __('Register') }}
                            </a>
                        @endif
                    @else
                        <div class="relative" x-data="{ open: false }">
                            <button @click="open = !open"
                                class="flex items-center text-gray-600 hover:text-gray-900 px-3 py-2 rounded-md text-sm font-medium">
                                <i class="fas fa-user-circle mr-2"></i>
                                {{ Auth::user()->name }}
                                <svg class="ml-2 h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                        clip-rule="evenodd" />
                                </svg>
                            </button>

                            <div x-show="open" @click.away="open = false"
                                class="absolute right-0 mt-2 w-48 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5">
                                <div class="py-1">
                                    <a href="{{ route('profile.edit') }}"
                                        class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                        <i class="fas fa-user mr-2"></i>{{ __('Profile') }}
                                    </a>
                                    <div class="border-t border-gray-100"></div>
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit"
                                            class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                            <i class="fas fa-sign-out-alt mr-2"></i>{{ __('Logout') }}
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endguest
                </div>
            </div>
        </div>
    </div>
</nav>
