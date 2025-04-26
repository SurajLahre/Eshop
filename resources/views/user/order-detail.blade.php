@extends('layouts.shop')

@section('title', 'Order Details')

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
                    <a href="{{ route('user.orders') }}" class="block py-2 px-4 rounded {{ request()->routeIs('user.orders') || request()->routeIs('user.orders.show') ? 'bg-indigo-100 text-indigo-700' : 'text-gray-700 hover:bg-gray-100' }}">
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
            <div class="bg-white rounded-lg shadow p-6 mb-6">
                <div class="flex justify-between items-center mb-6">
                    <h1 class="text-2xl font-bold">Order Details</h1>
                    <a href="{{ route('user.orders') }}" class="text-indigo-600 hover:text-indigo-800">
                        &larr; Back to Orders
                    </a>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <div>
                        <h2 class="text-lg font-semibold mb-2">Order Information</h2>
                        <p class="text-gray-700"><span class="font-medium">Order Number:</span> {{ $order->order_number }}</p>
                        <p class="text-gray-700"><span class="font-medium">Date:</span> {{ $order->created_at->format('F j, Y') }}</p>
                        <p class="text-gray-700"><span class="font-medium">Status:</span>
                            <span class="inline-block px-2 py-1 text-xs font-semibold rounded-full
                                {{ $order->order_status === 'completed' ? 'bg-green-100 text-green-800' :
                                   ($order->order_status === 'cancelled' ? 'bg-red-100 text-red-800' :
                                   'bg-yellow-100 text-yellow-800') }}">
                                {{ ucfirst($order->order_status) }}
                            </span>
                        </p>
                        <p class="text-gray-700"><span class="font-medium">Payment Method:</span> {{ ucfirst($order->payment_method) }}</p>
                        <p class="text-gray-700"><span class="font-medium">Payment Status:</span>
                            <span class="inline-block px-2 py-1 text-xs font-semibold rounded-full
                                {{ $order->payment_status === 'paid' ? 'bg-green-100 text-green-800' :
                                   ($order->payment_status === 'failed' ? 'bg-red-100 text-red-800' :
                                   'bg-yellow-100 text-yellow-800') }}">
                                {{ ucfirst($order->payment_status) }}
                            </span>
                        </p>
                    </div>
                    <div>
                        <h2 class="text-lg font-semibold mb-2">Shipping Address</h2>
                        <address class="not-italic text-gray-700">
                            {{ $order->shipping_address }}<br>
                            {{ $order->shipping_city }}, {{ $order->shipping_state }} {{ $order->shipping_zipcode }}<br>
                            {{ $order->shipping_country }}<br>
                            <br>
                            <span class="font-medium">Phone:</span> {{ $order->shipping_phone }}<br>
                            <span class="font-medium">Email:</span> {{ $order->shipping_email }}
                        </address>
                    </div>
                </div>

                @if($order->notes)
                    <div class="mb-6">
                        <h2 class="text-lg font-semibold mb-2">Order Notes</h2>
                        <p class="text-gray-700">{{ $order->notes }}</p>
                    </div>
                @endif
            </div>

            <div class="bg-white rounded-lg shadow overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h2 class="text-lg font-semibold">Order Items</h2>
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
                                            @if($item->product && $item->product->images->isNotEmpty())
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
                                            <div class="text-sm font-medium text-gray-900">
                                                @if($item->product)
                                                    <a href="{{ route('shop.product', $item->product->slug) }}" class="hover:text-indigo-600">
                                                        {{ $item->product->name }}
                                                    </a>
                                                @else
                                                    <span>Product no longer available</span>
                                                @endif
                                            </div>
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
        </div>
    </div>
@endsection
