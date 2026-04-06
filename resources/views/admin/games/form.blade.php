@extends('layouts.admin')

@section('header', $game->exists ? 'Edit Game' : 'Create Game')

@section('content')
<div class="max-w-3xl mx-auto rounded-lg shadow-sm border border-gray-100 dark:border-gray-700 bg-white dark:bg-gray-800 p-6">
    <form action="{{ $game->exists ? route('admin.games.update', $game) : route('admin.games.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @if($game->exists)
            @method('PUT')
        @endif

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-4">
            <div>
                <label for="title" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Title</label>
                <input type="text" name="title" id="title" value="{{ old('title', $game->title) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm dark:bg-gray-700 dark:border-gray-600 dark:text-white" required>
                @error('title')<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror
            </div>
            
            <div>
                <label for="category_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Category</label>
                <select name="category_id" id="category_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm dark:bg-gray-700 dark:border-gray-600 dark:text-white" required>
                    <option value="">Select Category</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ old('category_id', $game->category_id) == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                    @endforeach
                </select>
                @error('category_id')<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror
            </div>

            <div>
                <label for="price" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Price ($)</label>
                <input type="number" step="0.01" name="price" id="price" value="{{ old('price', $game->price) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm dark:bg-gray-700 dark:border-gray-600 dark:text-white" required>
                @error('price')<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror
            </div>

            <div>
                <label for="platform" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Platform</label>
                <select name="platform" id="platform" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm dark:bg-gray-700 dark:border-gray-600 dark:text-white" required>
                    <option value="PC" {{ old('platform', $game->platform) == 'PC' ? 'selected' : '' }}>PC</option>
                    <option value="PlayStation" {{ old('platform', $game->platform) == 'PlayStation' ? 'selected' : '' }}>PlayStation</option>
                    <option value="Xbox" {{ old('platform', $game->platform) == 'Xbox' ? 'selected' : '' }}>Xbox</option>
                    <option value="Switch" {{ old('platform', $game->platform) == 'Switch' ? 'selected' : '' }}>Switch</option>
                </select>
                @error('platform')<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror
            </div>
        </div>

        <div class="mb-4">
            <label for="description" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Description</label>
            <textarea name="description" id="description" rows="4" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm dark:bg-gray-700 dark:border-gray-600 dark:text-white" required>{{ old('description', $game->description) }}</textarea>
            @error('description')<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror
        </div>

        <div class="mb-4">
            <label for="cover_image" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Cover Image (Optional)</label>
            @if($game->cover_image)
                <div class="mb-2">
                    <img src="{{ Storage::url($game->cover_image) }}" alt="Cover" class="h-20 w-20 object-cover rounded">
                </div>
            @endif
            <input type="file" name="cover_image" id="cover_image" accept="image/*" class="mt-1 block w-full text-sm text-gray-500 border border-gray-300 rounded-md cursor-pointer dark:bg-gray-700 dark:border-gray-600 dark:text-gray-400 focus:outline-none">
            @error('cover_image')<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror
        </div>

        <div class="flex justify-end space-x-3 mt-6">
            <a href="{{ route('admin.games.index') }}" class="py-2 px-4 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm text-sm font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700">Cancel</a>
            <button type="submit" class="py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                {{ $game->exists ? 'Update Game' : 'Create Game' }}
            </button>
        </div>
    </form>
</div>
@endsection
