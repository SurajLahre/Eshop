@extends('layouts.admin')

@section('title', 'Products')
@section('header', 'Products')

@section('content')
    <div class="mb-6 flex justify-between items-center">
        <h1 class="text-2xl font-bold">All Products</h1>
        <a href="{{ route('admin.products.create') }}" class="bg-indigo-600 text-white px-4 py-2 rounded-md hover:bg-indigo-700">
            Add New Product
        </a>
    </div>

    <div class="bg-white rounded-lg shadow overflow-hidden">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Product
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Category
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Price
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Stock
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Status
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Actions
                    </th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @foreach($products as $product)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 h-10 w-10">
                                    @if($product->images->isNotEmpty())
                                    @php
                                        $imagePath = $product->images->where('is_primary', true)->first()->image;
                                        $extension = pathinfo($imagePath, PATHINFO_EXTENSION);
                                        $isImage = in_array(strtolower($extension), ['jpg', 'jpeg', 'png', 'gif', 'webp', 'bmp']);
                                    @endphp

                                    @if($isImage)
                                        <img src="{{ asset('storage/' . $imagePath) }}"
                                            alt="{{ $product->name }}"
                                            class="h-10 w-10 object-cover rounded">
                                    @else
                                        <div class="h-10 w-10 bg-gray-200 rounded flex items-center justify-center">
                                            <span class="text-gray-500 text-xs">Image</span>
                                        </div>
                                    @endif
                                @else
                                    <div class="h-10 w-10 bg-gray-200 rounded flex items-center justify-center">
                                        <span class="text-gray-500 text-xs">No image</span>
                                    </div>
                                @endif
                                </div>
                                <div class="ml-4">
                                    <div class="text-sm font-medium text-gray-900">{{ $product->name }}</div>
                                    <div class="text-sm text-gray-500">SKU: {{ $product->sku }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900">{{ $product->category->name }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900">₹{{ number_format($product->price, 2) }}</div>
                            @if($product->sale_price)
                                <div class="text-sm text-red-600">₹{{ number_format($product->sale_price, 2) }}</div>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900">{{ $product->quantity }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $product->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                {{ $product->is_active ? 'Active' : 'Inactive' }}
                            </span>
                            @if($product->featured)
                                <span class="ml-1 px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-indigo-100 text-indigo-800">
                                    Featured
                                </span>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <a href="{{ route('admin.products.edit', $product->id) }}" class="text-indigo-600 hover:text-indigo-900 mr-3">
                                Edit
                            </a>
                            <form action="{{ route('admin.products.destroy', $product->id) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-900" onclick="return confirm('Are you sure you want to delete this product?')">
                                    Delete
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="mt-6">
        {{ $products->links() }}
    </div>
@endsection
