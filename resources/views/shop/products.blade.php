@extends('layouts.app')

@section('title', 'Shop')

@section('content')
    <div class="flex flex-col md:flex-row">
        <!-- Sidebar -->
        <div class="w-full md:w-1/4 mb-6 md:mb-0 md:pr-6">
            <div class="bg-white rounded-lg shadow p-4">
                <h2 class="text-lg font-semibold mb-4">Categories</h2>
                <ul class="space-y-2">
                    @foreach($categories->where('parent_id', null) as $category)
                        <li>
                            <a href="{{ route('shop.category', $category->slug) }}" class="text-gray-700 hover:text-indigo-600 {{ request()->is('shop/category/'.$category->slug) ? 'font-semibold text-indigo-600' : '' }}">
                                {{ $category->name }}
                            </a>
                            @if($category->children->count() > 0)
                                <ul class="ml-4 mt-2 space-y-1">
                                    @foreach($category->children as $child)
                                        <li>
                                            <a href="{{ route('shop.category', $child->slug) }}" class="text-gray-600 hover:text-indigo-600 {{ request()->is('shop/category/'.$child->slug) ? 'font-semibold text-indigo-600' : '' }}">
                                                {{ $child->name }}
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            @endif
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>

        <!-- Main Content -->
        <div class="w-full md:w-3/4">
            <!-- Filters and Search -->
            <div class="bg-white rounded-lg shadow p-4 mb-6">
                <div class="flex flex-col md:flex-row md:items-center md:justify-between">
                    <div class="mb-4 md:mb-0">
                        <form action="{{ route('shop.products') }}" method="GET" class="flex">
                            <input type="text" name="search" value="{{ request('search') }}" placeholder="Search products..." class="border border-gray-300 rounded-l-md px-4 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                            <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded-r-md hover:bg-indigo-700">
                                Search
                            </button>
                        </form>
                    </div>
                    <div>
                        <form action="{{ route('shop.products') }}" method="GET" class="flex items-center">
                            <label for="sort" class="mr-2 text-gray-700">Sort by:</label>
                            <select name="sort" id="sort" onchange="this.form.submit()" class="border border-gray-300 rounded-md px-4 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                                <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>Newest</option>
                                <option value="price_low" {{ request('sort') == 'price_low' ? 'selected' : '' }}>Price: Low to High</option>
                                <option value="price_high" {{ request('sort') == 'price_high' ? 'selected' : '' }}>Price: High to Low</option>
                                <option value="name" {{ request('sort') == 'name' ? 'selected' : '' }}>Name</option>
                            </select>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Products Grid -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse($products as $product)
                    <div class="bg-white rounded-lg shadow overflow-hidden">
                        <a href="{{ route('shop.product', $product->slug) }}">
                            @if($product->images->isNotEmpty())
                                <img src="{{ asset('storage/' . $product->images->where('is_primary', true)->first()->image) }}"
                                    alt="{{ $product->name }}"
                                    class="w-full h-48 object-cover">
                            @else
                                <div class="w-full h-48 bg-gray-200 flex items-center justify-center">
                                    <span class="text-gray-500">No image</span>
                                </div>
                            @endif
                        </a>
                        <div class="p-4">
                            <h3 class="text-lg font-semibold mb-2">
                                <a href="{{ route('shop.product', $product->slug) }}" class="text-gray-800 hover:text-indigo-600">
                                    {{ $product->name }}
                                </a>
                            </h3>
                            <p class="text-sm text-gray-600 mb-2">{{ $product->category ? $product->category->name : 'Uncategorized' }}</p>
                            <div class="flex justify-between items-center">
                                <span class="text-gray-800 font-bold">₹{{ number_format($product->price, 2) }}</span>
                                <form action="{{ route('cart.add') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                                    <input type="hidden" name="quantity" value="1">
                                    <button type="submit" class="bg-indigo-600 text-white px-3 py-1 rounded-md text-sm hover:bg-indigo-700">
                                        Add to Cart
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full text-center py-12">
                        <p class="text-gray-500 text-lg">No products found.</p>
                    </div>
                @endforelse
            </div>

            <!-- Pagination -->
            <div class="mt-8">
                {{ $products->links() }}
            </div>
        </div>
    </div>
@endsection
