@extends('layouts.app')

@section('title', $category->name)

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
                @if($category->parent)
                    <li>
                        <div class="flex items-center">
                            <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                            </svg>
                            <a href="{{ route('shop.category', $category->parent->slug) }}" class="ml-1 text-gray-700 hover:text-indigo-600 md:ml-2">
                                {{ $category->parent->name }}
                            </a>
                        </div>
                    </li>
                @endif
                <li aria-current="page">
                    <div class="flex items-center">
                        <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                        </svg>
                        <span class="ml-1 text-gray-500 md:ml-2">{{ $category->name }}</span>
                    </div>
                </li>
            </ol>
        </nav>
    </div>

    <div class="flex flex-col md:flex-row">
        <!-- Sidebar -->
        <div class="w-full md:w-1/4 mb-6 md:mb-0 md:pr-6">
            <div class="bg-white rounded-lg shadow p-4">
                <h2 class="text-lg font-semibold mb-4">Categories</h2>
                <ul class="space-y-2">
                    @foreach($categories->where('parent_id', null) as $cat)
                        <li>
                            <a href="{{ route('shop.category', $cat->slug) }}" class="text-gray-700 hover:text-indigo-600 {{ $cat->id == $category->id ? 'font-semibold text-indigo-600' : '' }}">
                                {{ $cat->name }}
                            </a>
                            @if($cat->children->count() > 0)
                                <ul class="ml-4 mt-2 space-y-1">
                                    @foreach($cat->children as $child)
                                        <li>
                                            <a href="{{ route('shop.category', $child->slug) }}" class="text-gray-600 hover:text-indigo-600 {{ $child->id == $category->id ? 'font-semibold text-indigo-600' : '' }}">
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
            <!-- Category Header -->
            <div class="bg-white rounded-lg shadow p-6 mb-6">
                <h1 class="text-2xl font-bold text-gray-800 mb-2">{{ $category->name }}</h1>
                @if($category->description)
                    <p class="text-gray-600">{{ $category->description }}</p>
                @endif
            </div>

            <!-- Products Grid -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse($products as $product)
                    <div class="bg-white rounded-lg shadow overflow-hidden">
                        <a href="{{ route('shop.product', $product->slug) }}">
                            @if($product->images->isNotEmpty())
                            
                                <img src="{{ asset('storage/' . $product->images->where('is_primary', true)->first()->image) }}" 
                                    alt="{{ $product->name }}" yuh3q01                                     class="w-full h-48 object-cover">
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
                            <div class="flex justify-between items-center">
                                <span class="text-gray-800 font-bold">${{ number_format($product->price, 2) }}</span>
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
                        <p class="text-gray-500 text-lg">No products found in this category.</p>
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
