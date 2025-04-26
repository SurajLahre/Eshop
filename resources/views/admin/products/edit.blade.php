@extends('layouts.admin')

@section('title', 'Edit Product')
@section('header', 'Edit Product')

@section('content')
    <div class="bg-white rounded-lg shadow p-6">
        <form action="{{ route('admin.products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Product Name</label>
                    <input type="text" name="name" id="name" value="{{ old('name', $product->name) }}" required
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
                            <option value="{{ $category->id }}" {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                            @foreach($category->children as $child)
                                <option value="{{ $child->id }}" {{ old('category_id', $product->category_id) == $child->id ? 'selected' : '' }}>
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
                        class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent">{{ old('description', $product->description) }}</textarea>
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
                        <input type="number" name="price" id="price" value="{{ old('price', $product->price) }}" step="0.01" min="0" required
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
                        <input type="number" name="sale_price" id="sale_price" value="{{ old('sale_price', $product->sale_price) }}" step="0.01" min="0"
                            class="w-full border border-gray-300 rounded-md pl-7 pr-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                    </div>
                    @error('sale_price')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="quantity" class="block text-sm font-medium text-gray-700 mb-1">Quantity</label>
                    <input type="number" name="quantity" id="quantity" value="{{ old('quantity', $product->quantity) }}" min="0" required
                        class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                    @error('quantity')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="sku" class="block text-sm font-medium text-gray-700 mb-1">SKU</label>
                    <input type="text" name="sku" id="sku" value="{{ old('sku', $product->sku) }}" required
                        class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                    @error('sku')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                    <div class="flex items-center space-x-6">
                        <div class="flex items-center">
                            <input type="checkbox" name="is_active" id="is_active" value="1" {{ old('is_active', $product->is_active) ? 'checked' : '' }}
                                class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded">
                            <label for="is_active" class="ml-2 block text-sm text-gray-700">Active</label>
                        </div>
                        <div class="flex items-center">
                            <input type="checkbox" name="featured" id="featured" value="1" {{ old('featured', $product->featured) ? 'checked' : '' }}
                                class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded">
                            <label for="featured" class="ml-2 block text-sm text-gray-700">Featured</label>
                        </div>
                    </div>
                </div>

                <div class="md:col-span-2">
                    <label for="images" class="block text-sm font-medium text-gray-700 mb-1">Add More Images</label>
                    <input type="file" name="images[]" id="images" multiple accept="image/*"
                        class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                    <p class="text-gray-500 text-xs mt-1">You can select multiple images.</p>
                    @error('images')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                @if($product->images->isNotEmpty())
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Current Images</label>
                        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-4">
                            @foreach($product->images as $image)
                                <div class="relative group">
                                    @php
                                        $imagePath = $image->image;
                                        $extension = pathinfo($imagePath, PATHINFO_EXTENSION);
                                        $isImage = in_array(strtolower($extension), ['jpg', 'jpeg', 'png', 'gif', 'webp', 'bmp']);
                                    @endphp

                                    @if($isImage)
                                        <img src="{{ asset('storage/' . $imagePath) }}" alt="{{ $product->name }}" class="h-32 w-full object-cover rounded-md">
                                    @else
                                        <div class="h-32 w-full bg-gray-200 flex items-center justify-center rounded-md">
                                            <span class="text-gray-500 text-xs">{{ basename($imagePath) }}</span>
                                        </div>
                                    @endif

                                    <div class="absolute inset-0 bg-black bg-opacity-50 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity">
                                        <form action="{{ route('admin.products.delete-image', $image->id) }}" method="POST" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-white bg-red-600 rounded-full p-1 hover:bg-red-700" onclick="return confirm('Are you sure you want to delete this image?')">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                </svg>
                                            </button>
                                        </form>
                                    </div>
                                    @if($image->is_primary)
                                        <div class="absolute top-0 right-0 bg-green-500 text-white text-xs px-2 py-1 rounded-bl-md">
                                            Primary
                                        </div>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>

            <div class="flex justify-end">
                <a href="{{ route('admin.products.index') }}" class="bg-gray-300 text-gray-700 px-4 py-2 rounded-md mr-2 hover:bg-gray-400">
                    Cancel
                </a>
                <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded-md hover:bg-indigo-700">
                    Update Product
                </button>
            </div>
        </form>
    </div>
@endsection
