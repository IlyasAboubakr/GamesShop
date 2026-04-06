@extends('layouts.store')

@section('title', 'Browse Games')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
    <div class="flex flex-col lg:flex-row gap-8">
        
        <!-- Sidebar Filters -->
        <aside class="w-full lg:w-64 flex-shrink-0">
            <form action="{{ route('store.browse') }}" method="GET" class="bg-[#0d0d1a] p-6 rounded-2xl border border-white/[0.06] sticky top-24">
                <h3 class="text-white font-bold text-base mb-5 uppercase tracking-widest">Filters</h3>
                
                <div class="mb-5">
                    <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Search</label>
                    <input type="text" name="q" value="{{ request('q') }}" placeholder="Game title..." class="w-full bg-[#050510] border border-white/10 rounded-xl text-white text-sm focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 px-4 py-2.5 placeholder-gray-600">
                </div>

                <div class="mb-5">
                    <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Platform</label>
                    <select name="platform" class="w-full bg-[#050510] border border-white/10 rounded-xl text-white text-sm focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 px-4 py-2.5">
                        <option value="">All Platforms</option>
                        <option value="PC" {{ request('platform') == 'PC' ? 'selected' : '' }}>PC</option>
                        <option value="PlayStation" {{ request('platform') == 'PlayStation' ? 'selected' : '' }}>PlayStation</option>
                        <option value="Xbox" {{ request('platform') == 'Xbox' ? 'selected' : '' }}>Xbox</option>
                        <option value="Switch" {{ request('platform') == 'Switch' ? 'selected' : '' }}>Switch</option>
                    </select>
                </div>

                <div class="mb-6">
                    <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Category</label>
                    <select name="category" class="w-full bg-[#050510] border border-white/10 rounded-xl text-white text-sm focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 px-4 py-2.5">
                        <option value="">All Categories</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>

                <button type="submit" class="w-full bg-indigo-600 hover:bg-indigo-500 text-white font-bold py-2.5 px-4 rounded-xl transition-all text-sm shadow-lg shadow-indigo-600/20">
                    Apply Filters
                </button>
                @if(request()->hasAny(['q', 'platform', 'category']))
                    <a href="{{ route('store.browse') }}" class="block text-center mt-3 text-xs text-gray-500 hover:text-gray-300 transition-colors">Clear all filters</a>
                @endif
            </form>
        </aside>

        <!-- Product Grid -->
        <div class="flex-1 min-w-0">
            <h1 class="text-3xl font-black text-white mb-2 tracking-tight">Game Catalog</h1>
            <p class="text-gray-500 text-sm mb-8">{{ $games->total() }} game(s) found</p>
            
            <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 gap-6">
                @forelse($games as $game)
                    <div class="group flex flex-col bg-[#0d0d1a] rounded-2xl overflow-hidden border border-white/[0.06] hover:border-indigo-500/40 transition-all duration-500 hover:shadow-[0_0_30px_rgba(99,102,241,0.12)] hover:-translate-y-1">
                        <a href="{{ route('store.show', $game) }}" class="relative h-56 overflow-hidden bg-gray-900 shrink-0 block">
                            @if($game->cover_image)
                                <img src="{{ Storage::url($game->cover_image) }}" alt="{{ $game->title }}" class="w-full h-full object-cover group-hover:scale-110 transition duration-700 ease-out">
                            @else
                                <div class="w-full h-full flex items-center justify-center text-gray-700">
                                    <svg class="w-10 h-10" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                                </div>
                            @endif
                            <div class="absolute inset-0 bg-gradient-to-t from-[#0d0d1a] via-transparent to-transparent opacity-70"></div>
                            <div class="absolute top-3 right-3 px-2.5 py-1 bg-black/70 backdrop-blur-md text-[10px] font-bold uppercase tracking-widest text-gray-300 rounded-md border border-white/10">{{ $game->platform }}</div>
                        </a>
                        <div class="p-5 flex-1 flex flex-col">
                            <span class="text-[11px] font-bold uppercase tracking-widest text-indigo-400 mb-1.5">{{ $game->category->name ?? 'Game' }}</span>
                            <a href="{{ route('store.show', $game) }}" class="text-base font-bold text-gray-100 group-hover:text-indigo-300 line-clamp-2 leading-snug transition-colors mb-auto">{{ $game->title }}</a>
                            <div class="flex items-end justify-between mt-4 pt-4 border-t border-white/[0.04] mb-4">
                                <span class="text-xl font-black text-white">${{ number_format($game->price, 2) }}</span>
                                @if($game->stock > 0)
                                    <span class="flex items-center gap-1 text-xs font-bold text-emerald-400"><span class="w-1.5 h-1.5 rounded-full bg-emerald-400"></span> In Stock</span>
                                @else
                                    <span class="text-xs font-bold text-red-400">Sold Out</span>
                                @endif
                            </div>
                            <div class="mt-auto flex items-center justify-between gap-2 border-t border-white/[0.04] pt-4">
                                <a href="{{ route('store.show', $game) }}" class="flex-1 text-center bg-white/5 hover:bg-white/10 border border-white/10 text-white font-bold py-2 rounded-lg text-xs transition-colors">View</a>
                                @auth
                                    @if(Auth::user()->role === 'admin')
                                        <a href="{{ route('admin.games.edit', $game) }}" class="flex-1 text-center bg-amber-600 hover:bg-amber-500 text-white font-bold py-2 rounded-lg text-xs transition-colors">Edit</a>
                                    @elseif($game->stock > 0)
                                        <form action="{{ route('cart.add', $game) }}" method="POST" class="flex-1">
                                            @csrf
                                            <button type="submit" class="w-full text-center bg-indigo-600 hover:bg-indigo-500 text-white font-bold py-2 rounded-lg text-xs overflow-hidden transition-colors">
                                                Add to Cart
                                            </button>
                                        </form>
                                    @endif
                                @else
                                    @if($game->stock > 0)
                                        <form action="{{ route('cart.add', $game) }}" method="POST" class="flex-1">
                                            @csrf
                                            <button type="submit" class="w-full text-center bg-indigo-600 hover:bg-indigo-500 text-white font-bold py-2 rounded-lg text-xs overflow-hidden transition-colors">
                                                Add to Cart
                                            </button>
                                        </form>
                                    @endif
                                @endauth
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full py-20 text-center">
                        <svg class="mx-auto h-14 w-14 text-gray-700 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                        <h3 class="text-lg font-bold text-gray-300 mb-1">No games found</h3>
                        <p class="text-gray-600 text-sm">Try adjusting your filters.</p>
                    </div>
                @endforelse
            </div>

            <div class="mt-10">
                {{ $games->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
