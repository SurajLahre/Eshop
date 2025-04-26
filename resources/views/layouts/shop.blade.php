<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }} - @yield('title', 'E-Commerce')</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />

    <!-- Styles / Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100 min-h-screen">
    <header class="bg-white shadow">
        <div class="container mx-auto px-4 py-4">
            <div class="flex justify-between items-center">
                <!-- Logo -->
                <a href="{{ route('home') }}" class="text-2xl font-bold text-indigo-600">
                    {{ config('app.name', 'E-Shop') }}
                </a>

                <!-- Navigation -->
                <nav class="flex items-center space-x-6">
                    <a href="{{ route('home') }}" class="text-gray-700 hover:text-indigo-600">Home</a>
                    <a href="{{ route('shop.products') }}" class="text-gray-700 hover:text-indigo-600">Shop</a>
                    
                    <!-- Cart -->
                    <a href="{{ route('cart.index') }}" class="text-gray-700 hover:text-indigo-600 relative">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                        <span id="cart-count" class="absolute -top-2 -right-2 bg-red-500 text-white rounded-full text-xs w-5 h-5 flex items-center justify-center">
                            @php
                                $cartCount = 0;
                                if (auth()->check()) {
                                    $cartCount = \App\Models\Cart::where('user_id', auth()->id())->sum('quantity');
                                } else {
                                    $cartCount = \App\Models\Cart::where('session_id', session()->getId())->sum('quantity');
                                }
                            @endphp
                            {{ $cartCount }}
                        </span>
                    </a>

                    <!-- Authentication -->
                    @guest
                        <a href="{{ route('login') }}" class="text-gray-700 hover:text-indigo-600">Login</a>
                        <a href="{{ route('register') }}" class="bg-indigo-600 text-white px-4 py-2 rounded-md hover:bg-indigo-700">Register</a>
                    @else
                        <div class="relative" x-data="{ open: false }">
                            <button @click="open = !open" class="flex items-center text-gray-700 hover:text-indigo-600">
                                {{ Auth::user()->name }}
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                </svg>
                            </button>
                            <div x-show="open" @click.away="open = false" class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 z-50">
                                @if (Auth::user()->email === 'admin@example.com')
                                    <a href="{{ route('admin.dashboard') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Admin Dashboard</a>
                                @endif
                                <a href="{{ route('user.profile') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Profile</a>
                                <a href="{{ route('user.orders') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">My Orders</a>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Logout</button>
                                </form>
                            </div>
                        </div>
                    @endguest
                </nav>
            </div>
        </div>
    </header>

    <main class="container mx-auto px-4 py-8">
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

    <footer class="bg-gray-800 text-white py-8">
        <div class="container mx-auto px-4">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div>
                    <h3 class="text-lg font-semibold mb-4">{{ config('app.name', 'E-Shop') }}</h3>
                    <p class="text-gray-400">Your one-stop shop for all your needs.</p>
                </div>
                <div>
                    <h3 class="text-lg font-semibold mb-4">Quick Links</h3>
                    <ul class="space-y-2">
                        <li><a href="{{ route('home') }}" class="text-gray-400 hover:text-white">Home</a></li>
                        <li><a href="{{ route('shop.products') }}" class="text-gray-400 hover:text-white">Shop</a></li>
                        <li><a href="{{ route('cart.index') }}" class="text-gray-400 hover:text-white">Cart</a></li>
                    </ul>
                </div>
                <div>
                    <h3 class="text-lg font-semibold mb-4">Contact Us</h3>
                    <p class="text-gray-400">Email: info@eshop.com</p>
                    <p class="text-gray-400">Phone: +1 234 567 890</p>
                </div>
            </div>
            <div class="border-t border-gray-700 mt-8 pt-8 text-center text-gray-400">
                <p>&copy; {{ date('Y') }} {{ config('app.name', 'E-Shop') }}. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</body>
</html>
