@extends('layouts.shop')

@section('title', 'Shopping Cart')

@section('content')
    <h1 class="text-2xl font-bold mb-6">Shopping Cart</h1>

    @if($cartItems->isEmpty())
        <div class="bg-white rounded-lg shadow p-8 text-center">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 text-gray-400 mx-auto mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
            </svg>
            <h2 class="text-xl font-semibold mb-2">Your cart is empty</h2>
            <p class="text-gray-600 mb-6">Looks like you haven't added any products to your cart yet.</p>
            <a href="{{ route('shop.products') }}" class="bg-indigo-600 text-white px-6 py-3 rounded-md font-semibold hover:bg-indigo-700">
                Continue Shopping
            </a>
        </div>
    @else
        <div class="bg-white rounded-lg shadow overflow-hidden mb-6">
            <table class="w-full">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Product</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Price</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Quantity</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @foreach($cartItems as $item)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 h-16 w-16">
                                        @if($item->product->images->isNotEmpty())
                                            <img src="{{ asset('storage/' . $item->product->images->where('is_primary', true)->first()->image) }}"
                                                alt="{{ $item->product->name }}"
                                                class="h-16 w-16 object-cover rounded">
                                        @else
                                            <div class="h-16 w-16 bg-gray-200 rounded flex items-center justify-center">
                                                <span class="text-gray-500 text-xs">No image</span>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="ml-4">
                                        <a href="{{ route('shop.product', $item->product->slug) }}" class="text-sm font-medium text-gray-900 hover:text-indigo-600">
                                            {{ $item->product->name }}
                                        </a>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                ₹{{ number_format($item->product->price, 2) }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <form action="{{ route('cart.update', $item->id) }}" method="POST" class="flex items-center">
                                    @csrf
                                    <button type="button" onclick="decrementQuantity('quantity-{{ $item->id }}')" class="bg-gray-200 px-2 py-1 rounded-l-md">-</button>
                                    <input type="number" name="quantity" id="quantity-{{ $item->id }}" value="{{ $item->quantity }}" min="1" max="{{ $item->product->quantity }}" class="border-t border-b border-gray-300 text-center w-12 py-1">
                                    <button type="button" onclick="incrementQuantity('quantity-{{ $item->id }}', {{ $item->product->quantity }})" class="bg-gray-200 px-2 py-1 rounded-r-md">+</button>
                                    <button type="submit" class="ml-2 text-indigo-600 hover:text-indigo-800">
                                        Update
                                    </button>
                                </form>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                ₹{{ number_format($item->product->price * $item->quantity, 2) }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <a href="{{ route('cart.remove', $item->id) }}" class="text-red-600 hover:text-red-800">
                                    Remove
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="flex flex-col md:flex-row justify-between">
            <div class="mb-4 md:mb-0">
                <a href="{{ route('shop.products') }}" class="inline-flex items-center text-indigo-600 hover:text-indigo-800">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    Continue Shopping
                </a>
            </div>
            <div class="bg-white rounded-lg shadow p-6 md:w-1/3">
                <h2 class="text-lg font-semibold mb-4">Order Summary</h2>
                <div class="flex justify-between mb-2">
                    <span class="text-gray-600">Subtotal</span>
                    <span class="text-gray-800">₹{{ number_format($total, 2) }}</span>
                </div>
                <div class="flex justify-between mb-2">
                    <span class="text-gray-600">Shipping</span>
                    <span class="text-gray-800">Free</span>
                </div>
                <div class="border-t border-gray-200 my-4"></div>
                <div class="flex justify-between mb-6">
                    <span class="text-lg font-semibold">Total</span>
                    <span class="text-lg font-semibold">₹{{ number_format($total, 2) }}</span>
                </div>
                <div class="flex justify-between">
                    <a href="{{ route('cart.clear') }}" class="text-red-600 hover:text-red-800">
                        Clear Cart
                    </a>
                    <a href="{{ route('checkout.index') }}" class="bg-indigo-600 text-white px-6 py-2 rounded-md font-semibold hover:bg-indigo-700">
                        Checkout
                    </a>
                </div>
            </div>
        </div>
    @endif

    <script>
        function incrementQuantity(inputId, max) {
            const input = document.getElementById(inputId);
            const currentValue = parseInt(input.value);
            if (currentValue < max) {
                input.value = currentValue + 1;
            }
        }

        function decrementQuantity(inputId) {
            const input = document.getElementById(inputId);
            const currentValue = parseInt(input.value);
            if (currentValue > 1) {
                input.value = currentValue - 1;
            }
        }
    </script>
@endsection
