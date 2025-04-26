@extends('layouts.shop')

@section('title', $product->name)

@section('content')
    <!-- Breadcrumbs -->
    <div class="mb-6">
        <nav class="flex" aria-label="Breadcrumb">
            <ol class="inline-flex items-center space-x-1 md:space-x-3">
                <li class="inline-flex items-center">
                    <a href="{{ route('home') }}" class="text-gray-700 hover:text-indigo-600">
                        Home
                    </a>
                </li>
                <li>
                    <div class="flex items-center">
                        <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                        </svg>
                        <a href="{{ route('shop.products') }}" class="ml-1 text-gray-700 hover:text-indigo-600 md:ml-2">
                            Shop
                        </a>
                    </div>
                </li>
                <li>
                    <div class="flex items-center">
                        <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                        </svg>
                        <a href="{{ route('shop.category', $product->category->slug) }}" class="ml-1 text-gray-700 hover:text-indigo-600 md:ml-2">
                            {{ $product->category->name }}
                        </a>
                    </div>
                </li>
                <li aria-current="page">
                    <div class="flex items-center">
                        <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                        </svg>
                        <span class="ml-1 text-gray-500 md:ml-2">{{ $product->name }}</span>
                    </div>
                </li>
            </ol>
        </nav>
    </div>

    <!-- Product Details -->
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 p-6">
            <!-- Product Images -->
            <div>
                <div class="mb-4">
                    @if($product->images->isNotEmpty())
                        @php
                            $imagePath = $product->images->where('is_primary', true)->first()->image;
                            $extension = pathinfo($imagePath, PATHINFO_EXTENSION);
                            $isImage = in_array(strtolower($extension), ['jpg', 'jpeg', 'png', 'gif', 'webp', 'bmp']);
                        @endphp

                        @if($isImage)
                            <img src="{{ asset('storage/' . $imagePath) }}"
                                alt="{{ $product->name }}"
                                class="w-full h-80 object-cover rounded-lg"
                                id="main-image">
                        @else
                            <div class="w-full h-80 bg-gray-200 flex items-center justify-center rounded-lg">
                                <span class="text-gray-500">Product Image</span>
                            </div>
                        @endif
                    @else
                        <div class="w-full h-80 bg-gray-200 flex items-center justify-center rounded-lg">
                            <span class="text-gray-500">No image</span>
                        </div>
                    @endif
                </div>
                @if($product->images->count() > 1)
                    <div class="grid grid-cols-4 gap-2">
                        @foreach($product->images as $image)
                            @php
                                $imagePath = $image->image;
                                $extension = pathinfo($imagePath, PATHINFO_EXTENSION);
                                $isImage = in_array(strtolower($extension), ['jpg', 'jpeg', 'png', 'gif', 'webp', 'bmp']);
                            @endphp

                            @if($isImage)
                                <img src="{{ asset('storage/' . $imagePath) }}"
                                    alt="{{ $product->name }}"
                                    class="w-full h-20 object-cover rounded-lg cursor-pointer hover:opacity-75 {{ $image->is_primary ? 'border-2 border-indigo-600' : '' }}"
                                    onclick="document.getElementById('main-image').src = this.src">
                            @else
                                <div class="w-full h-20 bg-gray-200 flex items-center justify-center rounded-lg {{ $image->is_primary ? 'border-2 border-indigo-600' : '' }}">
                                    <span class="text-gray-500 text-xs">Image</span>
                                </div>
                            @endif
                        @endforeach
                    </div>
                @endif
            </div>

            <!-- Product Info -->
            <div>
                <h1 class="text-2xl font-bold text-gray-800 mb-2">{{ $product->name }}</h1>
                @if($product->category)
                <div class="flex items-center mb-4">
                    <span class="text-gray-600 mr-2">Category:</span>
                    <a href="{{ route('shop.category', $product->category->slug) }}" class="text-indigo-600 hover:underline">
                        {{ $product->category->name }}
                    </a>
                </div>
                @endif
                <div class="text-2xl font-bold text-gray-800 mb-4">₹{{ number_format($product->price, 2) }}</div>

                @if($product->quantity > 0)
                    <div class="text-green-600 mb-4">In Stock ({{ $product->quantity }} available)</div>
                @else
                    <div class="text-red-600 mb-4">Out of Stock</div>
                @endif

                <div class="mb-6">
                    <h2 class="text-lg font-semibold mb-2">Description</h2>
                    <p class="text-gray-700">{{ $product->description }}</p>
                </div>

                @if($product->quantity > 0)
                    <form action="{{ route('cart.add') }}" method="POST" class="mb-6">
                        @csrf
                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                        <div class="flex items-center mb-4">
                            <label for="quantity" class="mr-4 text-gray-700">Quantity:</label>
                            <div class="flex items-center">
                                <button type="button" onclick="decrementQuantity()" class="bg-gray-200 px-3 py-1 rounded-l-md">-</button>
                                <input type="number" name="quantity" id="quantity" value="1" min="1" max="{{ $product->quantity }}" class="border-t border-b border-gray-300 text-center w-16 py-1">
                                <button type="button" onclick="incrementQuantity()" class="bg-gray-200 px-3 py-1 rounded-r-md">+</button>
                            </div>
                        </div>
                        <button type="submit" class="bg-indigo-600 text-white px-6 py-3 rounded-md font-semibold hover:bg-indigo-700 w-full">
                            Add to Cart
                        </button>
                    </form>
                @endif

                <div class="border-t border-gray-200 pt-4">
                    <div class="flex items-center mb-2">
                        <span class="text-gray-600 mr-2">SKU:</span>
                        <span class="text-gray-800">{{ $product->sku }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Related Products -->
    @if($relatedProducts->isNotEmpty())
        <div class="mt-12">
            <h2 class="text-2xl font-bold mb-6">Related Products</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                @foreach($relatedProducts as $relatedProduct)
                    <div class="bg-white rounded-lg shadow overflow-hidden">
                        <a href="{{ route('shop.product', $relatedProduct->slug) }}">
                            @if($relatedProduct->images->isNotEmpty())
                                @php
                                    $imagePath = $relatedProduct->images->where('is_primary', true)->first()->image;
                                    $extension = pathinfo($imagePath, PATHINFO_EXTENSION);
                                    $isImage = in_array(strtolower($extension), ['jpg', 'jpeg', 'png', 'gif', 'webp', 'bmp']);
                                @endphp

                                @if($isImage)
                                    <img src="{{ asset('storage/' . $imagePath) }}"
                                        alt="{{ $relatedProduct->name }}"
                                        class="w-full h-48 object-cover">
                                @else
                                    <div class="w-full h-48 bg-gray-200 flex items-center justify-center">
                                        <span class="text-gray-500">Product Image</span>
                                    </div>
                                @endif
                            @else
                                <div class="w-full h-48 bg-gray-200 flex items-center justify-center">
                                    <span class="text-gray-500">No image</span>
                                </div>
                            @endif
                        </a>
                        <div class="p-4">
                            <h3 class="text-lg font-semibold mb-2">
                                <a href="{{ route('shop.product', $relatedProduct->slug) }}" class="text-gray-800 hover:text-indigo-600">
                                    {{ $relatedProduct->name }}
                                </a>
                            </h3>
                            <div class="flex justify-between items-center">
                                <span class="text-gray-800 font-bold">₹{{ number_format($relatedProduct->price, 2) }}</span>
                                <form action="{{ route('cart.add') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="product_id" value="{{ $relatedProduct->id }}">
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
    @endif

    <script>
        function incrementQuantity() {
            const input = document.getElementById('quantity');
            const max = parseInt(input.getAttribute('max'));
            const currentValue = parseInt(input.value);
            if (currentValue < max) {
                input.value = currentValue + 1;
            }
        }

        function decrementQuantity() {
            const input = document.getElementById('quantity');
            const currentValue = parseInt(input.value);
            if (currentValue > 1) {
                input.value = currentValue - 1;
            }
        }
    </script>
@endsection
