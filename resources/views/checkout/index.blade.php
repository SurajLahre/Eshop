@extends('layouts.shop')

@section('title', 'Checkout')

@section('content')
    <h1 class="text-2xl font-bold mb-6">Checkout</h1>

    <div class="flex flex-col lg:flex-row gap-8">
        <!-- Checkout Form -->
        <div class="lg:w-2/3">
            <div class="bg-white rounded-lg shadow p-6 mb-6">
                <h2 class="text-lg font-semibold mb-4">Shipping Information</h2>

                <form action="{{ route('checkout.process') }}" method="POST">
                    @csrf
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                        <div>
                            <label for="shipping_address" class="block text-sm font-medium text-gray-700 mb-1">Address</label>
                            <input type="text" name="shipping_address" id="shipping_address" value="{{ old('shipping_address') }}" required
                                class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                            @error('shipping_address')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label for="shipping_city" class="block text-sm font-medium text-gray-700 mb-1">City</label>
                            <input type="text" name="shipping_city" id="shipping_city" value="{{ old('shipping_city') }}" required
                                class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                            @error('shipping_city')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label for="shipping_state" class="block text-sm font-medium text-gray-700 mb-1">State/Province</label>
                            <input type="text" name="shipping_state" id="shipping_state" value="{{ old('shipping_state') }}" required
                                class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                            @error('shipping_state')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label for="shipping_zipcode" class="block text-sm font-medium text-gray-700 mb-1">ZIP/Postal Code</label>
                            <input type="text" name="shipping_zipcode" id="shipping_zipcode" value="{{ old('shipping_zipcode') }}" required
                                class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                            @error('shipping_zipcode')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label for="shipping_country" class="block text-sm font-medium text-gray-700 mb-1">Country</label>
                            <input type="text" name="shipping_country" id="shipping_country" value="{{ old('shipping_country') }}" required
                                class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                            @error('shipping_country')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label for="shipping_phone" class="block text-sm font-medium text-gray-700 mb-1">Phone</label>
                            <input type="text" name="shipping_phone" id="shipping_phone" value="{{ old('shipping_phone') }}" required
                                class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                            @error('shipping_phone')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label for="shipping_email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                            <input type="email" name="shipping_email" id="shipping_email" value="{{ old('shipping_email', auth()->user()->email ?? '') }}" required
                                class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                            @error('shipping_email')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-6">
                        <h2 class="text-lg font-semibold mb-4">Payment Method</h2>
                        <div class="space-y-3">
                            <div class="flex items-center">
                                <input type="radio" name="payment_method" id="credit_card" value="credit_card" checked
                                    class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300">
                                <label for="credit_card" class="ml-2 block text-sm text-gray-700">
                                    Credit Card
                                </label>
                            </div>
                            <div class="flex items-center">
                                <input type="radio" name="payment_method" id="paypal" value="paypal"
                                    class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300">
                                <label for="paypal" class="ml-2 block text-sm text-gray-700">
                                    PayPal
                                </label>
                            </div>
                        </div>
                        @error('payment_method')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-6">
                        <label for="notes" class="block text-sm font-medium text-gray-700 mb-1">Order Notes (Optional)</label>
                        <textarea name="notes" id="notes" rows="3"
                            class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent">{{ old('notes') }}</textarea>
                    </div>

                    <div class="flex justify-between">
                        <a href="{{ route('cart.index') }}" class="inline-flex items-center text-indigo-600 hover:text-indigo-800">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                            </svg>
                            Back to Cart
                        </a>
                        <button type="submit" class="bg-indigo-600 text-white px-6 py-2 rounded-md font-semibold hover:bg-indigo-700">
                            Place Order
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Order Summary -->
        <div class="lg:w-1/3">
            <div class="bg-white rounded-lg shadow p-6 sticky top-6">
                <h2 class="text-lg font-semibold mb-4">Order Summary</h2>

                <div class="space-y-4 mb-6">
                    @foreach($cartItems as $item)
                        <div class="flex items-start">
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
                            <div class="ml-4 flex-1">
                                <h3 class="text-sm font-medium text-gray-900">{{ $item->product->name }}</h3>
                                <p class="text-sm text-gray-500">Qty: {{ $item->quantity }}</p>
                                <p class="text-sm font-medium text-gray-900">₹{{ number_format($item->product->price * $item->quantity, 2) }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="border-t border-gray-200 pt-4">
                    <div class="flex justify-between mb-2">
                        <span class="text-gray-600">Subtotal</span>
                        <span class="text-gray-800">₹{{ number_format($total, 2) }}</span>
                    </div>
                    <div class="flex justify-between mb-2">
                        <span class="text-gray-600">Shipping</span>
                        <span class="text-gray-800">Free</span>
                    </div>
                    <div class="border-t border-gray-200 my-4"></div>
                    <div class="flex justify-between">
                        <span class="text-lg font-semibold">Total</span>
                        <span class="text-lg font-semibold">₹{{ number_format($total, 2) }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
