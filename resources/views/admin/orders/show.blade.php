@extends('layouts.admin')

@section('title', 'Order Details')
@section('header', 'Order Details')

@section('content')
    <div class="mb-6 flex justify-between items-center">
        <h1 class="text-2xl font-bold">Order #{{ $order->order_number }}</h1>
        <div>
            <a href="{{ route('admin.orders.edit', $order->id) }}" class="bg-indigo-600 text-white px-4 py-2 rounded-md hover:bg-indigo-700 mr-2">
                Edit
            </a>
            <form action="{{ route('admin.orders.destroy', $order->id) }}" method="POST" class="inline">
                @csrf
                @method('DELETE')
                <button type="submit" class="bg-red-600 text-white px-4 py-2 rounded-md hover:bg-red-700" onclick="return confirm('Are you sure you want to cancel this order?')">
                    Cancel Order
                </button>
            </form>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
        <!-- Order Information -->
        <div class="bg-white rounded-lg shadow p-6">
            <h2 class="text-lg font-semibold mb-4">Order Information</h2>
            <div class="space-y-3">
                <div>
                    <p class="text-gray-600 text-sm">Order Number</p>
                    <p class="font-medium">{{ $order->order_number }}</p>
                </div>
                <div>
                    <p class="text-gray-600 text-sm">Date</p>
                    <p class="font-medium">{{ $order->created_at->format('F j, Y') }}</p>
                </div>
                <div>
                    <p class="text-gray-600 text-sm">Time</p>
                    <p class="font-medium">{{ $order->created_at->format('h:i A') }}</p>
                </div>
                <div>
                    <p class="text-gray-600 text-sm">Payment Method</p>
                    <p class="font-medium">{{ ucfirst($order->payment_method) }}</p>
                </div>
                <div>
                    <p class="text-gray-600 text-sm">Order Status</p>
                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                        {{ $order->order_status === 'completed' ? 'bg-green-100 text-green-800' :
                           ($order->order_status === 'cancelled' ? 'bg-red-100 text-red-800' :
                           'bg-yellow-100 text-yellow-800') }}">
                        {{ ucfirst($order->order_status) }}
                    </span>
                </div>
                <div>
                    <p class="text-gray-600 text-sm">Payment Status</p>
                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                        {{ $order->payment_status === 'paid' ? 'bg-green-100 text-green-800' :
                           ($order->payment_status === 'failed' ? 'bg-red-100 text-red-800' :
                           'bg-yellow-100 text-yellow-800') }}">
                        {{ ucfirst($order->payment_status) }}
                    </span>
                </div>
            </div>
        </div>

        <!-- Customer Information -->
        <div class="bg-white rounded-lg shadow p-6">
            <h2 class="text-lg font-semibold mb-4">Customer Information</h2>
            <div class="space-y-3">
                <div>
                    <p class="text-gray-600 text-sm">Name</p>
                    <p class="font-medium">{{ $order->user->name }}</p>
                </div>
                <div>
                    <p class="text-gray-600 text-sm">Email</p>
                    <p class="font-medium">{{ $order->user->email }}</p>
                </div>
                <div>
                    <p class="text-gray-600 text-sm">Phone</p>
                    <p class="font-medium">{{ $order->shipping_phone }}</p>
                </div>
                <div>
                    <p class="text-gray-600 text-sm">Customer Since</p>
                    <p class="font-medium">{{ $order->user->created_at->format('F j, Y') }}</p>
                </div>
            </div>
        </div>

        <!-- Shipping Information -->
        <div class="bg-white rounded-lg shadow p-6">
            <h2 class="text-lg font-semibold mb-4">Shipping Information</h2>
            <div class="space-y-3">
                <div>
                    <p class="text-gray-600 text-sm">Address</p>
                    <p class="font-medium">{{ $order->shipping_address }}</p>
                </div>
                <div>
                    <p class="text-gray-600 text-sm">City</p>
                    <p class="font-medium">{{ $order->shipping_city }}</p>
                </div>
                <div>
                    <p class="text-gray-600 text-sm">State</p>
                    <p class="font-medium">{{ $order->shipping_state }}</p>
                </div>
                <div>
                    <p class="text-gray-600 text-sm">Zip Code</p>
                    <p class="font-medium">{{ $order->shipping_zipcode }}</p>
                </div>
                <div>
                    <p class="text-gray-600 text-sm">Country</p>
                    <p class="font-medium">{{ $order->shipping_country }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Order Items -->
    <div class="bg-white rounded-lg shadow overflow-hidden mb-6">
        <div class="px-6 py-4 border-b border-gray-200">
            <h2 class="text-lg font-semibold">Order Items</h2>
        </div>
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Product</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Price</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Quantity</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
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
                                            <a href="{{ route('admin.products.show', $item->product->id) }}" class="hover:text-indigo-600">
                                                {{ $item->product->name }}
                                            </a>
                                        @else
                                            <span>Product no longer available</span>
                                        @endif
                                    </div>
                                    @if($item->product)
                                        <div class="text-sm text-gray-500">SKU: {{ $item->product->sku }}</div>
                                    @endif
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

    <!-- Order Notes -->
    @if($order->notes)
        <div class="bg-white rounded-lg shadow p-6">
            <h2 class="text-lg font-semibold mb-4">Order Notes</h2>
            <p class="text-gray-700">{{ $order->notes }}</p>
        </div>
    @endif
@endsection
