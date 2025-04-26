<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Admin - {{ config('app.name', 'Laravel') }} - @yield('title', 'Dashboard')</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />

    <!-- Styles / Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Fallback if Vite is not available -->
    @if(!app()->environment('local'))
        <link rel="stylesheet" href="{{ asset('build/assets/app-63c600ba.css') }}">
        <script src="{{ asset('build/assets/app-bb8b3db8.js') }}" defer></script>
    @endif
</head>
<body class="bg-gray-100 min-h-screen">
    <div class="flex h-screen bg-gray-100">
        <!-- Sidebar -->
        <div class="bg-gray-800 text-white w-64 flex-shrink-0">
            <div class="p-4">
                <h1 class="text-2xl font-bold">Admin Panel</h1>
            </div>
            <nav class="mt-4">
                <a href="{{ route('admin.dashboard') }}" class="block py-2.5 px-4 rounded transition duration-200 hover:bg-gray-700 {{ request()->routeIs('admin.dashboard') ? 'bg-gray-700' : '' }}">
                    Dashboard
                </a>
                <a href="{{ route('admin.products.index') }}" class="block py-2.5 px-4 rounded transition duration-200 hover:bg-gray-700 {{ request()->routeIs('admin.products.*') ? 'bg-gray-700' : '' }}">
                    Products
                </a>
                <a href="{{ route('admin.categories.index') }}" class="block py-2.5 px-4 rounded transition duration-200 hover:bg-gray-700 {{ request()->routeIs('admin.categories.*') ? 'bg-gray-700' : '' }}">
                    Categories
                </a>
                <a href="{{ route('admin.orders.index') }}" class="block py-2.5 px-4 rounded transition duration-200 hover:bg-gray-700 {{ request()->routeIs('admin.orders.*') ? 'bg-gray-700' : '' }}">
                    Orders
                </a>
                <div class="border-t border-gray-700 my-4"></div>
                <a href="{{ route('home') }}" class="block py-2.5 px-4 rounded transition duration-200 hover:bg-gray-700">
                    Back to Site
                </a>
                <form method="POST" action="{{ route('logout') }}" class="block py-2.5 px-4">
                    @csrf
                    <button type="submit" class="text-white hover:text-gray-300 w-full text-left">Logout</button>
                </form>
            </nav>
        </div>

        <!-- Main Content -->
        <div class="flex-1 flex flex-col overflow-hidden">
            <!-- Top Header -->
            <header class="bg-white shadow">
                <div class="py-4 px-6 flex items-center justify-between">
                    <h2 class="text-xl font-semibold text-gray-800">@yield('header', 'Dashboard')</h2>
                    <div class="flex items-center">
                        <span class="text-gray-700 mr-2">{{ Auth::user()->name }}</span>
                    </div>
                </div>
            </header>

            <!-- Main Content -->
            <main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-100 p-6">
                @if (session('success'))
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                        {{ session('success') }}
                    </div>
                @endif

                @if (session('error'))
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                        {{ session('error') }}
                    </div>
                @endif

                @yield('content')
            </main>
        </div>
    </div>

    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</body>
</html>
