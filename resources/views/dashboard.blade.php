<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    @if (Auth::user()->role === 'admin')
                        <h1>Selamat Datang Admin</h1>
                        @elseif (Auth::user()->role === 'kasir')
                        <h1>Selamat Datang Kasir</h1>
                        @elseif (Auth::user()-> role === 'pengguna')
                        <h1>Selamat datang Pengguna</h1>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
