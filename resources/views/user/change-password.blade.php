@extends('layouts.shop')

@section('title', 'Change Password')

@section('content')
    <div class="flex flex-col md:flex-row gap-8">
        <!-- Sidebar -->
        <div class="w-full md:w-1/4">
            <div class="bg-white rounded-lg shadow overflow-hidden">
                <div class="p-6 bg-indigo-600 text-white">
                    <h2 class="text-xl font-semibold">{{ Auth::user()->name }}</h2>
                    <p class="text-indigo-100">{{ Auth::user()->email }}</p>
                </div>
                <nav class="p-4">
                    <a href="{{ route('user.profile') }}" class="block py-2 px-4 rounded {{ request()->routeIs('user.profile') ? 'bg-indigo-100 text-indigo-700' : 'text-gray-700 hover:bg-gray-100' }}">
                        Profile
                    </a>
                    <a href="{{ route('user.orders') }}" class="block py-2 px-4 rounded {{ request()->routeIs('user.orders') ? 'bg-indigo-100 text-indigo-700' : 'text-gray-700 hover:bg-gray-100' }}">
                        My Orders
                    </a>
                    <a href="{{ route('user.change-password') }}" class="block py-2 px-4 rounded {{ request()->routeIs('user.change-password') ? 'bg-indigo-100 text-indigo-700' : 'text-gray-700 hover:bg-gray-100' }}">
                        Change Password
                    </a>
                </nav>
            </div>
        </div>

        <!-- Main Content -->
        <div class="w-full md:w-3/4">
            <div class="bg-white rounded-lg shadow p-6">
                <h1 class="text-2xl font-bold mb-6">Change Password</h1>

                <form action="{{ route('user.update-password') }}" method="POST">
                    @csrf
                    <div class="mb-4">
                        <label for="current_password" class="block text-sm font-medium text-gray-700 mb-1">Current Password</label>
                        <input type="password" name="current_password" id="current_password" required
                            class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                        @error('current_password')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="password" class="block text-sm font-medium text-gray-700 mb-1">New Password</label>
                        <input type="password" name="password" id="password" required
                            class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                        @error('password')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-6">
                        <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-1">Confirm New Password</label>
                        <input type="password" name="password_confirmation" id="password_confirmation" required
                            class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                    </div>

                    <div class="flex justify-end">
                        <button type="submit" class="bg-indigo-600 text-white px-6 py-2 rounded-md font-semibold hover:bg-indigo-700">
                            Update Password
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
