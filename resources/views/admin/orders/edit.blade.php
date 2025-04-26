@extends('layouts.admin')

@section('title', 'Edit Order')
@section('header', 'Edit Order')

@section('content')
    <div class="mb-6 flex justify-between items-center">
        <h1 class="text-2xl font-bold">Order #{{ $order->order_number }}</h1>
        <a href="{{ route('admin.orders.show', $order->id) }}" class="text-indigo-600 hover:text-indigo-800">
            &larr; Back to Order Details
        </a>
    </div>

    <div class="bg-white rounded-lg shadow p-6">
        <form action="{{ route('admin.orders.update', $order->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <div>
                    <label for="order_status" class="block text-sm font-medium text-gray-700 mb-1">Order Status</label>
                    <select name="order_status" id="order_status" required
                        class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                        <option value="pending" {{ old('order_status', $order->order_status) === 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="processing" {{ old('order_status', $order->order_status) === 'processing' ? 'selected' : '' }}>Processing</option>
                        <option value="completed" {{ old('order_status', $order->order_status) === 'completed' ? 'selected' : '' }}>Completed</option>
                        <option value="cancelled" {{ old('order_status', $order->order_status) === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                    </select>
                    @error('order_status')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
                
                <div>
                    <label for="payment_status" class="block text-sm font-medium text-gray-700 mb-1">Payment Status</label>
                    <select name="payment_status" id="payment_status" required
                        class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                        <option value="pending" {{ old('payment_status', $order->payment_status) === 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="paid" {{ old('payment_status', $order->payment_status) === 'paid' ? 'selected' : '' }}>Paid</option>
                        <option value="failed" {{ old('payment_status', $order->payment_status) === 'failed' ? 'selected' : '' }}>Failed</option>
                        <option value="refunded" {{ old('payment_status', $order->payment_status) === 'refunded' ? 'selected' : '' }}>Refunded</option>
                    </select>
                    @error('payment_status')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>
            
            <div class="flex justify-end">
                <a href="{{ route('admin.orders.show', $order->id) }}" class="bg-gray-300 text-gray-700 px-4 py-2 rounded-md mr-2 hover:bg-gray-400">
                    Cancel
                </a>
                <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded-md hover:bg-indigo-700">
                    Update Order
                </button>
            </div>
        </form>
    </div>

    <!-- Order Information (Read-only) -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">
        <div class="bg-white rounded-lg shadow p-6">
            <h2 class="text-lg font-semibold mb-4">Order Information</h2>
            <div class="grid grid-cols-1 gap-4">
                <div>
                    <p class="text-gray-600 text-sm">Order Number</p>
                    <p class="font-medium">{{ $order->order_number }}</p>
                </div>
                <div>
                    <p class="text-gray-600 text-sm">Date</p>
                    <p class="font-medium">{{ $order->created_at->format('F j, Y h:i A') }}</p>
                </div>
                <div>
                    <p class="text-gray-600 text-sm">Customer</p>
                    <p class="font-medium">{{ $order->user->name }} ({{ $order->user->email }})</p>
                </div>
                <div>
                    <p class="text-gray-600 text-sm">Payment Method</p>
                    <p class="font-medium">{{ ucfirst($order->payment_method) }}</p>
                </div>
                <div>
                    <p class="text-gray-600 text-sm">Total Amount</p>
                    <p class="font-medium">${{ number_format($order->total_amount, 2) }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <h2 class="text-lg font-semibold mb-4">Shipping Information</h2>
            <div class="grid grid-cols-1 gap-4">
                <div>
                    <p class="text-gray-600 text-sm">Address</p>
                    <p class="font-medium">{{ $order->shipping_address }}</p>
                </div>
                <div>
                    <p class="text-gray-600 text-sm">City, State, Zip</p>
                    <p class="font-medium">{{ $order->shipping_city }}, {{ $order->shipping_state }} {{ $order->shipping_zipcode }}</p>
                </div>
                <div>
                    <p class="text-gray-600 text-sm">Country</p>
                    <p class="font-medium">{{ $order->shipping_country }}</p>
                </div>
                <div>
                    <p class="text-gray-600 text-sm">Phone</p>
                    <p class="font-medium">{{ $order->shipping_phone }}</p>
                </div>
                <div>
                    <p class="text-gray-600 text-sm">Email</p>
                    <p class="font-medium">{{ $order->shipping_email }}</p>
                </div>
            </div>
        </div>
    </div>
@endsection
