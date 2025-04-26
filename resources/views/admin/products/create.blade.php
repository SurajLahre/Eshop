@extends('layouts.admin')

@section('title', 'Add Product')
@section('header', 'Add New Product')

@section('content')
    <div class="bg-white rounded-lg shadow p-6">
        <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Product Name</label>
                    <input type="text" name="name" id="name" value="{{ old('name') }}" required
                        class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                    @error('name')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="category_id" class="block text-sm font-medium text-gray-700 mb-1">Category</label>
                    <select name="category_id" id="category_id" required
                        class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                        <option value="">Select Category</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                            @foreach($category->children as $child)
                                <option value="{{ $child->id }}" {{ old('category_id') == $child->id ? 'selected' : '' }}>
                                    -- {{ $child->name }}
                                </option>
                            @endforeach
                        @endforeach
                    </select>
                    @error('category_id')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="md:col-span-2">
                    <label for="description" class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                    <textarea name="description" id="description" rows="4"
                        class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent">{{ old('description') }}</textarea>
                    @error('description')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="price" class="block text-sm font-medium text-gray-700 mb-1">Price</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <span class="text-gray-500 sm:text-sm">₹</span>
                        </div>
                        <input type="number" name="price" id="price" value="{{ old('price') }}" step="0.01" min="0" required
                            class="w-full border border-gray-300 rounded-md pl-7 pr-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                    </div>
                    @error('price')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="sale_price" class="block text-sm font-medium text-gray-700 mb-1">Sale Price (Optional)</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <span class="text-gray-500 sm:text-sm">₹</span>
                        </div>
                        <input type="number" name="sale_price" id="sale_price" value="{{ old('sale_price') }}" step="0.01" min="0"
                            class="w-full border border-gray-300 rounded-md pl-7 pr-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                    </div>
                    @error('sale_price')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="quantity" class="block text-sm font-medium text-gray-700 mb-1">Quantity</label>
                    <input type="number" name="quantity" id="quantity" value="{{ old('quantity', 0) }}" min="0" required
                        class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                    @error('quantity')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="sku" class="block text-sm font-medium text-gray-700 mb-1">SKU</label>
                    <input type="text" name="sku" id="sku" value="{{ old('sku') }}" required
                        class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                    @error('sku')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                    <div class="flex items-center space-x-6">
                        <div class="flex items-center">
                            <input type="checkbox" name="is_active" id="is_active" value="1" {{ old('is_active') ? 'checked' : '' }}
                                class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded">
                            <label for="is_active" class="ml-2 block text-sm text-gray-700">Active</label>
                        </div>
                        <div class="flex items-center">
                            <input type="checkbox" name="featured" id="featured" value="1" {{ old('featured') ? 'checked' : '' }}
                                class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded">
                            <label for="featured" class="ml-2 block text-sm text-gray-700">Featured</label>
                        </div>
                    </div>
                </div>

                <div class="md:col-span-2">
                    <label for="images" class="block text-sm font-medium text-gray-700 mb-1">Product Images</label>
                    <input type="file" name="images[]" id="images" multiple accept="image/*"
                        class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                    <p class="text-gray-500 text-xs mt-1">You can select multiple images. The first image will be the primary image.</p>
                    @error('images')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="flex justify-end">
                <a href="{{ route('admin.products.index') }}" class="bg-gray-300 text-gray-700 px-4 py-2 rounded-md mr-2 hover:bg-gray-400">
                    Cancel
                </a>
                <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded-md hover:bg-indigo-700">
                    Create Product
                </button>
            </div>
        </form>
    </div>
@endsection
