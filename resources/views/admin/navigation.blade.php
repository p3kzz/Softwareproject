@extends('layouts.admin')

@section('content')

    <body class="bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100">

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16 items-center">
                <!-- Logo -->
                <div class="flex items-center">
                    <a href="{{ route('admin') }}">
                        <img src="{{ asset('logo.png') }}" alt="Logo" class="h-9 w-auto">
                    </a>
                    <a href="{{ route('admin') }}"
                        class="ml-6 text-sm font-medium text-gray-700 dark:text-gray-300 hover:text-gray-900 dark:hover:text-white">
                        Admin Dashboard
                    </a>
                </div>

                <!-- User Dropdown -->
                <div class="hidden sm:flex sm:items-center">
                    <div class="relative">
                        <button @click="open = !open"
                            class="flex items-center text-sm font-medium text-gray-600 dark:text-gray-300 hover:text-gray-800 dark:hover:text-white focus:outline-none">
                            <span>{{ Auth::user()->name }}</span>
                            <svg class="ml-1 h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>

                        <!-- Dropdown Menu -->
                        <div x-show="open" @click.away="open = false"
                            class="absolute right-0 mt-2 w-48 bg-white dark:bg-gray-700 rounded-md shadow-lg py-1 z-20">
                            <a href="{{ route('profile.edit') }}"
                                class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-600">
                                Profile
                            </a>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit"
                                    class="w-full text-left block px-4 py-2 text-sm text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-600">
                                    Log Out
                                </button>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Hamburger Menu (Mobile) -->
                <div class="sm:hidden">
                    <button @click="open = !open"
                        class="text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-white focus:outline-none">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path :class="{ 'hidden': open, 'inline-flex': !open }" class="inline-flex"
                                stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 6h16M4 12h16M4 18h16" />
                            <path :class="{ 'hidden': !open, 'inline-flex': open }" class="hidden" stroke-linecap="round"
                                stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        <!-- Mobile Menu -->
        <div :class="{ 'block': open, 'hidden': !open }" class="sm:hidden hidden px-4 pb-4">
            <a href="{{ route('admin') }}" class="block py-2 text-sm text-gray-700 dark:text-gray-200 hover:underline">
                Admin Dashboard
            </a>
            <div class="border-t border-gray-200 dark:border-gray-600 mt-2 pt-2">
                <div class="text-sm text-gray-700 dark:text-gray-300">
                    {{ Auth::user()->name }}<br>
                    <span class="text-xs text-gray-500">{{ Auth::user()->email }}</span>
                </div>
                <a href="{{ route('profile.edit') }}"
                    class="block mt-2 text-sm text-gray-700 dark:text-gray-200 hover:underline">
                    Profile
                </a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit"
                        class="block w-full text-left mt-2 text-sm text-gray-700 dark:text-gray-200 hover:underline">
                        Log Out
                    </button>
                </form>
            </div>
        </div>

    </body>
@endsection
