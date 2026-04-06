@extends('layouts.admin')

@section('header', 'Add Game Keys')

@section('content')
<div class="max-w-2xl mx-auto rounded-lg shadow-sm border border-gray-100 dark:border-gray-700 bg-white dark:bg-gray-800 p-6">
    <form action="{{ route('admin.keys.store') }}" method="POST">
        @csrf

        <div class="mb-4">
            <label for="game_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Select Game</label>
            <select name="game_id" id="game_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm dark:bg-gray-700 dark:border-gray-600 dark:text-white" required>
                <option value="">Choose a game...</option>
                @foreach($games as $game)
                    <option value="{{ $game->id }}" {{ old('game_id') == $game->id ? 'selected' : '' }}>{{ $game->title }} ({{ $game->platform }})</option>
                @endforeach
            </select>
            @error('game_id')<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror
        </div>

        <div class="mb-4">
            <label for="keys" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Key Codes</label>
            <p class="text-xs text-gray-500 dark:text-gray-400 mb-2">Paste game keys separated by commas, spaces, or new lines.</p>
            <textarea name="keys" id="keys" rows="6" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm dark:bg-gray-700 dark:border-gray-600 dark:text-white font-mono placeholder-gray-400" required placeholder="XXXX-XXXX-XXXX&#10;YYYY-YYYY-YYYY">{{ old('keys') }}</textarea>
            @error('keys')<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror
        </div>

        <div class="flex justify-end space-x-3 mt-6">
            <a href="{{ route('admin.keys.index') }}" class="py-2 px-4 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm text-sm font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700">Cancel</a>
            <button type="submit" class="py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700">Add Keys</button>
        </div>
    </form>
</div>
@endsection
