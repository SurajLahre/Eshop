@extends('layouts.shop')

@section('title', 'My Profile')

@section('content')
    <div class="flex flex-col md:flex-row gap-8">
        <!-- Sidebar -->
        <div class="w-full md:w-1/4">
            <div class="bg-white rounded-lg shadow overflow-hidden">
                <div class="p-6 bg-indigo-600 text-white">
                    <h2 class="text-xl font-semibold">{{ $user->name }}</h2>
                    <p class="text-indigo-100">{{ $user->email }}</p>
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
                <h1 class="text-2xl font-bold mb-6">My Profile</h1>

                <form action="{{ route('user.profile.update') }}" method="POST">
                    @csrf
                    <div class="mb-4">
                        <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Name</label>
                        <input type="text" name="name" id="name" value="{{ old('name', $user->name) }}" required
                            class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                        @error('name')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-6">
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                        <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}" required
                            class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                        @error('email')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex justify-end">
                        <button type="submit" class="bg-indigo-600 text-white px-6 py-2 rounded-md font-semibold hover:bg-indigo-700">
                            Update Profile
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
