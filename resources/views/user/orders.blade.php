@extends('layouts.shop')

@section('title', 'My Orders')

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
                <h1 class="text-2xl font-bold mb-6">My Orders</h1>

                @if($orders->isEmpty())
                    <div class="text-center py-8">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 text-gray-400 mx-auto mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                        </svg>
                        <h2 class="text-xl font-semibold mb-2">No orders yet</h2>
                        <p class="text-gray-600 mb-6">You haven't placed any orders yet.</p>
                        <a href="{{ route('shop.products') }}" class="bg-indigo-600 text-white px-6 py-2 rounded-md font-semibold hover:bg-indigo-700">
                            Start Shopping
                        </a>
                    </div>
                @else
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Order #
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Date
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Status
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Total
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Actions
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($orders as $order)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                            {{ $order->order_number }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ $order->created_at->format('M d, Y') }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                                {{ $order->order_status === 'completed' ? 'bg-green-100 text-green-800' :
                                                   ($order->order_status === 'cancelled' ? 'bg-red-100 text-red-800' :
                                                   'bg-yellow-100 text-yellow-800') }}">
                                                {{ ucfirst($order->order_status) }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            ₹{{ number_format($order->total_amount, 2) }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                            <a href="{{ route('user.orders.show', $order->id) }}" class="text-indigo-600 hover:text-indigo-900">
                                                View
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-6">
                        {{ $orders->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
