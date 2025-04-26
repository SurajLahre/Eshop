@extends('layouts.admin')

@section('title', $product->name)
@section('header', 'Product Details')

@section('content')
    <div class="mb-6 flex justify-between items-center">
        <h1 class="text-2xl font-bold">{{ $product->name }}</h1>
        <div>
            <a href="{{ route('admin.products.edit', $product->id) }}" class="bg-indigo-600 text-white px-4 py-2 rounded-md hover:bg-indigo-700 mr-2">
                Edit
            </a>
            <form action="{{ route('admin.products.destroy', $product->id) }}" method="POST" class="inline">
                @csrf
                @method('DELETE')
                <button type="submit" class="bg-red-600 text-white px-4 py-2 rounded-md hover:bg-red-700" onclick="return confirm('Are you sure you want to delete this product?')">
                    Delete
                </button>
            </form>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <!-- Product Images -->
        <div class="md:col-span-1">
            <div class="bg-white rounded-lg shadow p-6">
                <h2 class="text-lg font-semibold mb-4">Product Images</h2>
                @if($product->images->isNotEmpty())
                    <div class="grid grid-cols-1 gap-4">
                        @foreach($product->images as $image)
                            @php
                                $imagePath = $image->image;
                                $extension = pathinfo($imagePath, PATHINFO_EXTENSION);
                                $isImage = in_array(strtolower($extension), ['jpg', 'jpeg', 'png', 'gif', 'webp', 'bmp']);
                            @endphp

                            <div class="relative">
                                @if($isImage)
                                    <img src="{{ asset('storage/' . $imagePath) }}" alt="{{ $product->name }}" class="w-full h-auto rounded-md">
                                @else
                                    <div class="w-full h-32 bg-gray-200 rounded-md flex items-center justify-center">
                                        <span class="text-gray-500">Image File: {{ basename($imagePath) }}</span>
                                    </div>
                                @endif

                                @if($image->is_primary)
                                    <div class="absolute top-0 right-0 bg-green-500 text-white text-xs px-2 py-1 rounded-bl-md">
                                        Primary
                                    </div>
                                @endif
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="bg-gray-200 rounded-md p-4 text-center">
                        <p class="text-gray-500">No images available</p>
                    </div>
                @endif
            </div>
        </div>

        <!-- Product Details -->
        <div class="md:col-span-2">
            <div class="bg-white rounded-lg shadow p-6">
                <h2 class="text-lg font-semibold mb-4">Product Information</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <p class="text-gray-600 text-sm">SKU</p>
                        <p class="font-medium">{{ $product->sku }}</p>
                    </div>
                    <div>
                        <p class="text-gray-600 text-sm">Category</p>
                        <p class="font-medium">{{ $product->category->name }}</p>
                    </div>
                    <div>
                        <p class="text-gray-600 text-sm">Price</p>
                        <p class="font-medium">₹{{ number_format($product->price, 2) }}</p>
                    </div>
                    <div>
                        <p class="text-gray-600 text-sm">Sale Price</p>
                        <p class="font-medium">{{ $product->sale_price ? '₹' . number_format($product->sale_price, 2) : 'N/A' }}</p>
                    </div>
                    <div>
                        <p class="text-gray-600 text-sm">Quantity</p>
                        <p class="font-medium">{{ $product->quantity }}</p>
                    </div>
                    <div>
                        <p class="text-gray-600 text-sm">Status</p>
                        <div>
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $product->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                {{ $product->is_active ? 'Active' : 'Inactive' }}
                            </span>
                            @if($product->featured)
                                <span class="ml-1 px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-indigo-100 text-indigo-800">
                                    Featured
                                </span>
                            @endif
                        </div>
                    </div>
                    <div class="md:col-span-2">
                        <p class="text-gray-600 text-sm">Description</p>
                        <p class="font-medium">{{ $product->description ?: 'No description available' }}</p>
                    </div>
                    <div>
                        <p class="text-gray-600 text-sm">Created At</p>
                        <p class="font-medium">{{ $product->created_at->format('M d, Y H:i') }}</p>
                    </div>
                    <div>
                        <p class="text-gray-600 text-sm">Last Updated</p>
                        <p class="font-medium">{{ $product->updated_at->format('M d, Y H:i') }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
