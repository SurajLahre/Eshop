@extends('layouts.shop')

@section('title', 'Order Complete')

@section('content')
    <div class="bg-white rounded-lg shadow p-8 text-center mb-8">
        <div class="bg-green-100 rounded-full w-16 h-16 flex items-center justify-center mx-auto mb-4">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
            </svg>
        </div>
        <h1 class="text-2xl font-bold text-gray-800 mb-2">Thank You for Your Order!</h1>
        <p class="text-gray-600 mb-6">Your order has been placed successfully.</p>
        <div class="text-left inline-block">
            <p class="text-gray-700"><span class="font-semibold">Order Number:</span> {{ $order->order_number }}</p>
            <p class="text-gray-700"><span class="font-semibold">Date:</span> {{ $order->created_at->format('F j, Y') }}</p>
            <p class="text-gray-700"><span class="font-semibold">Total:</span> ₹{{ number_format($order->total_amount, 2) }}</p>
            <p class="text-gray-700"><span class="font-semibold">Payment Method:</span> {{ ucfirst($order->payment_method) }}</p>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow overflow-hidden mb-8">
        <div class="px-6 py-4 border-b border-gray-200">
            <h2 class="text-lg font-semibold">Order Details</h2>
        </div>
        <table class="w-full">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Product</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Price</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Quantity</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @foreach($order->items as $item)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 h-10 w-10">
                                    @if($item->product->images->isNotEmpty())
                                        <img src="{{ asset('storage/' . $item->product->images->where('is_primary', true)->first()->image) }}"
                                            alt="{{ $item->product->name }}"
                                            class="h-10 w-10 object-cover rounded">
                                    @else
                                        <div class="h-10 w-10 bg-gray-200 rounded flex items-center justify-center">
                                            <span class="text-gray-500 text-xs">No image</span>
                                        </div>
                                    @endif
                                </div>
                                <div class="ml-4">
                                    <div class="text-sm font-medium text-gray-900">{{ $item->product->name }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            ₹{{ number_format($item->price, 2) }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ $item->quantity }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            ₹{{ number_format($item->total, 2) }}
                        </td>
                    </tr>
                @endforeach
            </tbody>
            <tfoot class="bg-gray-50">
                <tr>
                    <td colspan="3" class="px-6 py-4 text-right text-sm font-medium text-gray-500">Subtotal</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">₹{{ number_format($order->total_amount, 2) }}</td>
                </tr>
                <tr>
                    <td colspan="3" class="px-6 py-4 text-right text-sm font-medium text-gray-500">Shipping</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">Free</td>
                </tr>
                <tr>
                    <td colspan="3" class="px-6 py-4 text-right text-sm font-medium text-gray-900">Total</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-gray-900">₹{{ number_format($order->total_amount, 2) }}</td>
                </tr>
            </tfoot>
        </table>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-8">
        <div class="bg-white rounded-lg shadow p-6">
            <h2 class="text-lg font-semibold mb-4">Shipping Address</h2>
            <address class="not-italic text-gray-700">
                {{ $order->shipping_address }}<br>
                {{ $order->shipping_city }}, {{ $order->shipping_state }} {{ $order->shipping_zipcode }}<br>
                {{ $order->shipping_country }}<br>
                <br>
                <strong>Phone:</strong> {{ $order->shipping_phone }}<br>
                <strong>Email:</strong> {{ $order->shipping_email }}
            </address>
        </div>
        <div class="bg-white rounded-lg shadow p-6">
            <h2 class="text-lg font-semibold mb-4">Order Status</h2>
            <p class="text-gray-700 mb-2"><strong>Order Status:</strong>
                <span class="inline-block px-2 py-1 text-xs font-semibold rounded-full
                    {{ $order->order_status === 'completed' ? 'bg-green-100 text-green-800' :
                       ($order->order_status === 'cancelled' ? 'bg-red-100 text-red-800' :
                       'bg-yellow-100 text-yellow-800') }}">
                    {{ ucfirst($order->order_status) }}
                </span>
            </p>
            <p class="text-gray-700 mb-4"><strong>Payment Status:</strong>
                <span class="inline-block px-2 py-1 text-xs font-semibold rounded-full
                    {{ $order->payment_status === 'paid' ? 'bg-green-100 text-green-800' :
                       ($order->payment_status === 'failed' ? 'bg-red-100 text-red-800' :
                       'bg-yellow-100 text-yellow-800') }}">
                    {{ ucfirst($order->payment_status) }}
                </span>
            </p>
            @if($order->notes)
                <h3 class="font-semibold mb-2">Order Notes:</h3>
                <p class="text-gray-700">{{ $order->notes }}</p>
            @endif
        </div>
    </div>

    <div class="text-center">
        <a href="{{ route('shop.products') }}" class="bg-indigo-600 text-white px-6 py-3 rounded-md font-semibold hover:bg-indigo-700 inline-block">
            Continue Shopping
        </a>
    </div>
@endsection
