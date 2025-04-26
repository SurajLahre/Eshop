@extends('layouts.admin')

@section('title', $category->name)
@section('header', 'Category Details')

@section('content')
    <div class="mb-6 flex justify-between items-center">
        <h1 class="text-2xl font-bold">{{ $category->name }}</h1>
        <div>
            <a href="{{ route('admin.categories.edit', $category->id) }}" class="bg-indigo-600 text-white px-4 py-2 rounded-md hover:bg-indigo-700 mr-2">
                Edit
            </a>
            <form action="{{ route('admin.categories.destroy', $category->id) }}" method="POST" class="inline">
                @csrf
                @method('DELETE')
                <button type="submit" class="bg-red-600 text-white px-4 py-2 rounded-md hover:bg-red-700" onclick="return confirm('Are you sure you want to delete this category?')">
                    Delete
                </button>
            </form>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <!-- Category Image -->
        <div class="md:col-span-1">
            <div class="bg-white rounded-lg shadow p-6">
                <h2 class="text-lg font-semibold mb-4">Category Image</h2>
                @if($category->image)
                    @php
                        $imagePath = $category->image;
                        $extension = pathinfo($imagePath, PATHINFO_EXTENSION);
                        $isImage = in_array(strtolower($extension), ['jpg', 'jpeg', 'png', 'gif', 'webp', 'bmp']);
                    @endphp

                    @if($isImage)
                        <img src="{{ asset('storage/' . $imagePath) }}" alt="{{ $category->name }}" class="w-full h-auto rounded-md">
                    @else
                        <div class="w-full h-32 bg-gray-200 rounded-md flex items-center justify-center">
                            <span class="text-gray-500">Image File: {{ basename($imagePath) }}</span>
                        </div>
                    @endif
                @else
                    <div class="bg-gray-200 rounded-md p-4 text-center">
                        <p class="text-gray-500">No image available</p>
                    </div>
                @endif
            </div>
        </div>

        <!-- Category Details -->
        <div class="md:col-span-2">
            <div class="bg-white rounded-lg shadow p-6">
                <h2 class="text-lg font-semibold mb-4">Category Information</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <p class="text-gray-600 text-sm">Slug</p>
                        <p class="font-medium">{{ $category->slug }}</p>
                    </div>
                    <div>
                        <p class="text-gray-600 text-sm">Parent Category</p>
                        <p class="font-medium">{{ $category->parent ? $category->parent->name : 'None (Top Level)' }}</p>
                    </div>
                    <div>
                        <p class="text-gray-600 text-sm">Status</p>
                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $category->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                            {{ $category->is_active ? 'Active' : 'Inactive' }}
                        </span>
                    </div>
                    <div>
                        <p class="text-gray-600 text-sm">Products Count</p>
                        <p class="font-medium">{{ $category->products->count() }}</p>
                    </div>
                    <div class="md:col-span-2">
                        <p class="text-gray-600 text-sm">Description</p>
                        <p class="font-medium">{{ $category->description ?: 'No description available' }}</p>
                    </div>
                    <div>
                        <p class="text-gray-600 text-sm">Created At</p>
                        <p class="font-medium">{{ $category->created_at->format('M d, Y H:i') }}</p>
                    </div>
                    <div>
                        <p class="text-gray-600 text-sm">Last Updated</p>
                        <p class="font-medium">{{ $category->updated_at->format('M d, Y H:i') }}</p>
                    </div>
                </div>
            </div>

            @if($category->children->isNotEmpty())
                <div class="bg-white rounded-lg shadow p-6 mt-6">
                    <h2 class="text-lg font-semibold mb-4">Subcategories</h2>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Products</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($category->children as $child)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm font-medium text-gray-900">{{ $child->name }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $child->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                                {{ $child->is_active ? 'Active' : 'Inactive' }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ $child->products->count() }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                            <a href="{{ route('admin.categories.show', $child->id) }}" class="text-indigo-600 hover:text-indigo-900 mr-3">View</a>
                                            <a href="{{ route('admin.categories.edit', $child->id) }}" class="text-indigo-600 hover:text-indigo-900">Edit</a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            @endif

            @if($category->products->isNotEmpty())
                <div class="bg-white rounded-lg shadow p-6 mt-6">
                    <h2 class="text-lg font-semibold mb-4">Products in this Category</h2>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Product</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Price</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($category->products as $product)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center">
                                                <div class="flex-shrink-0 h-10 w-10">
                                                    @if($product->images->isNotEmpty())
                                                        <img src="{{ asset('storage/' . $product->images->where('is_primary', true)->first()->image) }}"
                                                            alt="{{ $product->name }}"
                                                            class="h-10 w-10 object-cover rounded">
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
                                            <div class="text-sm text-gray-900">${{ number_format($product->price, 2) }}</div>
                                            @if($product->sale_price)
                                                <div class="text-sm text-red-600">${{ number_format($product->sale_price, 2) }}</div>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $product->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                                {{ $product->is_active ? 'Active' : 'Inactive' }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                            <a href="{{ route('admin.products.show', $product->id) }}" class="text-indigo-600 hover:text-indigo-900 mr-3">View</a>
                                            <a href="{{ route('admin.products.edit', $product->id) }}" class="text-indigo-600 hover:text-indigo-900">Edit</a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection
