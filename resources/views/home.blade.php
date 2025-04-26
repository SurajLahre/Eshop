@extends('layouts.shop')

@section('title', 'Home')

@section('content')
    <!-- Hero Section -->
    <div class="bg-indigo-600 text-white py-16 rounded-lg mb-8">
        <div class="container mx-auto px-4 text-center">
            <h1 class="text-4xl font-bold mb-4">Welcome to {{ config('app.name', 'E-Shop') }}</h1>
            <p class="text-xl mb-8">Your one-stop shop for all your needs</p>
            <a href="{{ route('shop.products') }}" class="bg-white text-indigo-600 px-6 py-3 rounded-md font-semibold hover:bg-gray-100">
                Shop Now
            </a>
        </div>
    </div>

    <!-- Featured Products -->
    <div class="mb-12">
        <h2 class="text-2xl font-bold mb-6">Featured Products</h2>
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
            @foreach($featuredProducts as $product)
                <div class="bg-white rounded-lg shadow overflow-hidden">
                    <a href="{{ route('shop.product', $product->slug) }}">
                        @if($product->images->isNotEmpty())
                            <img src="{{ asset('storage/' . $product->images->where('is_primary', true)->first()->image) }}"
                                alt="{{ $product->name }}"
                                class="w-full h-48 object-cover">
                        @else
                            <div class="w-full h-48 bg-gray-200 flex items-center justify-center">
                                <span class="text-gray-500">No image</span>
                            </div>
                        @endif
                    </a>
                    <div class="p-4">
                        <h3 class="text-lg font-semibold mb-2">
                            <a href="{{ route('shop.product', $product->slug) }}" class="text-gray-800 hover:text-indigo-600">
                                {{ $product->name }}
                            </a>
                        </h3>
                        <div class="flex justify-between items-center">
                            <span class="text-gray-800 font-bold">₹{{ number_format($product->price, 2) }}</span>
                            <form action="{{ route('cart.add') }}" method="POST">
                                @csrf
                                <input type="hidden" name="product_id" value="{{ $product->id }}">
                                <input type="hidden" name="quantity" value="1">
                                <button type="submit" class="bg-indigo-600 text-white px-3 py-1 rounded-md text-sm hover:bg-indigo-700">
                                    Add to Cart
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <!-- Categories -->
    <div class="mb-12">
        <h2 class="text-2xl font-bold mb-6">Shop by Category</h2>
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
            @foreach($categories as $category)
                <a href="{{ route('shop.category', $category->slug) }}" class="block group">
                    <div class="bg-white rounded-lg shadow overflow-hidden relative h-40">
                        @if($category->image)
                            <img src="{{ asset('storage/' . $category->image) }}"
                                alt="{{ $category->name }}"
                                class="w-full h-full object-cover group-hover:opacity-90 transition-opacity">
                        @else
                            <div class="w-full h-full bg-gray-200 group-hover:bg-gray-300 transition-colors"></div>
                        @endif
                        <div class="absolute inset-0 bg-black bg-opacity-40 flex items-center justify-center">
                            <h3 class="text-white text-xl font-bold">{{ $category->name }}</h3>
                        </div>
                    </div>
                </a>
            @endforeach
        </div>
    </div>

    <!-- Why Choose Us -->
    <div class="bg-white rounded-lg shadow p-8 mb-12">
        <h2 class="text-2xl font-bold mb-6 text-center">Why Choose Us</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <div class="text-center">
                <div class="bg-indigo-100 rounded-full w-16 h-16 flex items-center justify-center mx-auto mb-4">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                </div>
                <h3 class="text-lg font-semibold mb-2">Quality Products</h3>
                <p class="text-gray-600">We ensure that all our products meet the highest quality standards.</p>
            </div>
            <div class="text-center">
                <div class="bg-indigo-100 rounded-full w-16 h-16 flex items-center justify-center mx-auto mb-4">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <h3 class="text-lg font-semibold mb-2">Fast Delivery</h3>
                <p class="text-gray-600">We deliver your orders as quickly as possible, right to your doorstep.</p>
            </div>
            <div class="text-center">
                <div class="bg-indigo-100 rounded-full w-16 h-16 flex items-center justify-center mx-auto mb-4">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                    </svg>
                </div>
                <h3 class="text-lg font-semibold mb-2">Secure Payment</h3>
                <p class="text-gray-600">Your payment information is always secure with our encrypted payment system.</p>
            </div>
        </div>
    </div>
@endsection
