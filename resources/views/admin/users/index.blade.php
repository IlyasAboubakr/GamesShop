@extends('layouts.admin')

@section('header', 'Users')

@section('content')
<div class="bg-[#0d0d1a] rounded-2xl border border-white/[0.06] overflow-x-auto">
    <table class="w-full text-left">
        <thead class="bg-white/[0.02]">
            <tr>
                <th class="px-6 py-3 text-xs font-bold text-gray-500 uppercase tracking-wider">ID</th>
                <th class="px-6 py-3 text-xs font-bold text-gray-500 uppercase tracking-wider">Name</th>
                <th class="px-6 py-3 text-xs font-bold text-gray-500 uppercase tracking-wider">Email</th>
                <th class="px-6 py-3 text-xs font-bold text-gray-500 uppercase tracking-wider">Role</th>
                <th class="px-6 py-3 text-xs font-bold text-gray-500 uppercase tracking-wider">Registered At</th>
                <th class="px-6 py-3 text-xs font-bold text-gray-500 uppercase tracking-wider">Actions</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-white/[0.04]">
            @forelse($users as $user)
            <tr class="hover:bg-white/[0.02] transition-colors">
                <td class="px-6 py-4 whitespace-nowrap text-sm text-white">{{ $user->id }}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-white font-bold">{{ $user->name }}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-400">{{ $user->email }}</td>
                <td class="px-6 py-4 whitespace-nowrap">
                    @if($user->role === 'admin')
                        <span class="px-2.5 py-0.5 inline-flex text-xs leading-5 font-bold rounded-full bg-purple-500/20 text-purple-400 border border-purple-500/20">Admin</span>
                    @else
                        <span class="px-2.5 py-0.5 inline-flex text-xs leading-5 font-bold rounded-full bg-indigo-500/20 text-indigo-400 border border-indigo-500/20">Client</span>
                    @endif
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $user->created_at->format('Y-m-d') }}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                    @if($user->role !== 'admin')
                    <form action="{{ route('admin.users.destroy', $user) }}" method="POST" onsubmit="return confirm('Delete this user?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-300">Delete</button>
                    </form>
                    @endif
                </td>
            </tr>
            @empty
            <tr><td colspan="6" class="px-6 py-4 text-center text-sm text-gray-500">No users found.</td></tr>
            @endforelse
        </tbody>
    </table>
    <div class="p-4">
        {{ $users->links() }}
    </div>
</div>
@endsection
