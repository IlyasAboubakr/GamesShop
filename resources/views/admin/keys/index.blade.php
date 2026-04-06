@extends('layouts.admin')

@section('header', 'Game Keys')

@section('content')
<div class="mb-6 flex justify-between items-center">
    <h2 class="text-xl font-medium text-gray-900 dark:text-gray-100">Manage Keys</h2>
    <a href="{{ route('admin.keys.create') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded">
        Add Keys
    </a>
</div>

<div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-100 dark:border-gray-700 overflow-x-auto">
    <table class="w-full text-left">
        <thead class="bg-gray-50 dark:bg-gray-700/50">
            <tr>
                <th class="px-6 py-3 text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">ID</th>
                <th class="px-6 py-3 text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Game</th>
                <th class="px-6 py-3 text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Key Code</th>
                <th class="px-6 py-3 text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Status</th>
                <th class="px-6 py-3 text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Order ID</th>
                <th class="px-6 py-3 text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Actions</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
            @forelse($keys as $key)
            <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50">
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white">{{ $key->id }}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white">{{ $key->game->title }}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm font-mono text-gray-500 dark:text-gray-400">{{ $key->key_code }}</td>
                <td class="px-6 py-4 whitespace-nowrap">
                    @if($key->is_used)
                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">Used</span>
                    @else
                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Available</span>
                    @endif
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                    {{ $key->order_id ? '#'.$key->order_id : '-' }}
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                    @if(!$key->is_used)
                    <form action="{{ route('admin.keys.destroy', $key) }}" method="POST" onsubmit="return confirm('Delete this key?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-300">Delete</button>
                    </form>
                    @endif
                </td>
            </tr>
            @empty
            <tr><td colspan="6" class="px-6 py-4 text-center text-sm text-gray-500">No keys found.</td></tr>
            @endforelse
        </tbody>
    </table>
    <div class="p-4">
        {{ $keys->links() }}
    </div>
</div>
@endsection
