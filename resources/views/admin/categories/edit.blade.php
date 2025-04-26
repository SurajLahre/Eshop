@extends('layouts.admin')

@section('title', 'Edit Category')
@section('header', 'Edit Category')

@section('content')
    <div class="bg-white rounded-lg shadow p-6">
        <form action="{{ route('admin.categories.update', $category->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Category Name</label>
                    <input type="text" name="name" id="name" value="{{ old('name', $category->name) }}" required
                        class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                    @error('name')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="parent_id" class="block text-sm font-medium text-gray-700 mb-1">Parent Category (Optional)</label>
                    <select name="parent_id" id="parent_id"
                        class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                        <option value="">None (Top Level Category)</option>
                        @foreach($categories as $parent)
                            <option value="{{ $parent->id }}" {{ old('parent_id', $category->parent_id) == $parent->id ? 'selected' : '' }}>
                                {{ $parent->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('parent_id')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="md:col-span-2">
                    <label for="description" class="block text-sm font-medium text-gray-700 mb-1">Description (Optional)</label>
                    <textarea name="description" id="description" rows="4"
                        class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent">{{ old('description', $category->description) }}</textarea>
                    @error('description')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="image" class="block text-sm font-medium text-gray-700 mb-1">Category Image (Optional)</label>
                    <input type="file" name="image" id="image" accept="image/*"
                        class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                    <p class="text-gray-500 text-xs mt-1">Leave empty to keep the current image.</p>
                    @error('image')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                    <div class="flex items-center">
                        <input type="checkbox" name="is_active" id="is_active" value="1" {{ old('is_active', $category->is_active) ? 'checked' : '' }}
                            class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded">
                        <label for="is_active" class="ml-2 block text-sm text-gray-700">Active</label>
                    </div>
                </div>

                @if($category->image)
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Current Image</label>
                        @php
                            $imagePath = $category->image;
                            $extension = pathinfo($imagePath, PATHINFO_EXTENSION);
                            $isImage = in_array(strtolower($extension), ['jpg', 'jpeg', 'png', 'gif', 'webp', 'bmp']);
                        @endphp

                        @if($isImage)
                            <img src="{{ asset('storage/' . $imagePath) }}" alt="{{ $category->name }}" class="h-32 w-auto object-cover rounded-md">
                        @else
                            <div class="h-32 w-full bg-gray-200 flex items-center justify-center rounded-md">
                                <span class="text-gray-500">Image File: {{ basename($imagePath) }}</span>
                            </div>
                        @endif
                    </div>
                @endif
            </div>

            <div class="flex justify-end">
                <a href="{{ route('admin.categories.index') }}" class="bg-gray-300 text-gray-700 px-4 py-2 rounded-md mr-2 hover:bg-gray-400">
                    Cancel
                </a>
                <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded-md hover:bg-indigo-700">
                    Update Category
                </button>
            </div>
        </form>
    </div>
@endsection
