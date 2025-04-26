@extends('layouts.admin')

@section('title', 'Categories')
@section('header', 'Categories')

@section('content')
    <div class="mb-6 flex justify-between items-center">
        <h1 class="text-2xl font-bold">All Categories</h1>
        <a href="{{ route('admin.categories.create') }}" class="bg-indigo-600 text-white px-4 py-2 rounded-md hover:bg-indigo-700">
            Add New Category
        </a>
    </div>

    <div class="bg-white rounded-lg shadow overflow-hidden">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Category
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Parent
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
                @foreach($categories as $category)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 h-10 w-10">
                                    @if($category->image)
                                    @php
                                        $imagePath = $category->image;
                                        $extension = pathinfo($imagePath, PATHINFO_EXTENSION);
                                        $isImage = in_array(strtolower($extension), ['jpg', 'jpeg', 'png', 'gif', 'webp', 'bmp']);
                                    @endphp

                                    @if($isImage)
                                        <img src="{{ asset('storage/' . $imagePath) }}"
                                            alt="{{ $category->name }}"
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
                                    <div class="text-sm font-medium text-gray-900">{{ $category->name }}</div>
                                    <div class="text-sm text-gray-500">{{ $category->slug }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900">
                                {{ $category->parent ? $category->parent->name : 'None' }}
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $category->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                {{ $category->is_active ? 'Active' : 'Inactive' }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <a href="{{ route('admin.categories.edit', $category->id) }}" class="text-indigo-600 hover:text-indigo-900 mr-3">
                                Edit
                            </a>
                            <form action="{{ route('admin.categories.destroy', $category->id) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-900" onclick="return confirm('Are you sure you want to delete this category?')">
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
        {{ $categories->links() }}
    </div>
@endsection
