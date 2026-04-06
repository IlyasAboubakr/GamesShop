@extends('layouts.store')

@section('title', $game->title)

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
    <!-- Breadcrumbs -->
    <nav class="flex mb-8 text-sm text-gray-500 gap-2">
        <a href="{{ route('home') }}" class="hover:text-gray-300 transition-colors">Home</a>
        <span>›</span>
        <a href="{{ route('store.browse') }}" class="hover:text-gray-300 transition-colors">Store</a>
        <span>›</span>
        <span class="text-gray-300">{{ $game->title }}</span>
    </nav>

    <!-- Game Header Card -->
    <div class="bg-[#0d0d1a] rounded-2xl border border-white/[0.06] overflow-hidden shadow-2xl shadow-black/30">
        <div class="lg:flex">
            <!-- Cover Image -->
            <div class="lg:w-2/5 h-80 lg:h-auto relative bg-gray-900 shrink-0">
                @if($game->cover_image)
                    <img src="{{ Storage::url($game->cover_image) }}" alt="{{ $game->title }}" class="w-full h-full object-cover">
                @else
                    <div class="w-full h-full flex items-center justify-center text-gray-700">No Image</div>
                @endif
            </div>

            <!-- Info -->
            <div class="lg:w-3/5 p-8 lg:p-10 flex flex-col">
                <div class="flex flex-wrap items-center gap-2 mb-4">
                    <span class="px-3 py-1 bg-white/5 border border-white/10 rounded-lg text-xs font-bold text-gray-300 uppercase tracking-wider">{{ $game->platform }}</span>
                    <span class="px-3 py-1 bg-indigo-500/10 border border-indigo-500/20 rounded-lg text-xs font-bold text-indigo-400 uppercase tracking-wider">{{ $game->category->name ?? 'Game' }}</span>
                </div>

                <h1 class="text-3xl lg:text-4xl font-black text-white tracking-tight leading-tight mb-4">{{ $game->title }}</h1>
                
                {{-- Star rating --}}
                @php $avgRating = $game->reviews->avg('rating') ?? 0; @endphp
                <div class="flex items-center gap-3 mb-6">
                    <div class="flex gap-0.5">
                        @for($i=1; $i<=5; $i++)
                            <svg class="w-4 h-4 {{ $i <= round($avgRating) ? 'text-yellow-400' : 'text-gray-700' }}" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                        @endfor
                    </div>
                    <span class="text-sm text-gray-500 font-medium">{{ $game->reviews->count() }} review(s)</span>
                </div>

                <div class="flex items-baseline gap-4 mb-6">
                    <span class="text-4xl font-black text-white">${{ number_format($game->price, 2) }}</span>
                    @if($game->stock > 0)
                        <span class="flex items-center gap-1.5 text-sm font-bold text-emerald-400"><span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span> In Stock ({{ $game->stock }})</span>
                    @else
                        <span class="text-sm font-bold text-red-400">Out of Stock</span>
                    @endif
                </div>

                <div class="border-t border-white/[0.06] pt-6 mb-6 flex-1">
                    <h3 class="text-sm font-bold text-gray-400 uppercase tracking-wider mb-3">About this game</h3>
                    <p class="text-gray-400 text-sm leading-relaxed whitespace-pre-line">{{ $game->description }}</p>
                </div>

                @auth
                    @if(Auth::user()->role === 'admin')
                        <a href="{{ route('admin.games.edit', $game) }}" class="w-full bg-amber-600 hover:bg-amber-500 text-white font-bold py-3 px-6 rounded-xl transition-all flex justify-center items-center gap-2 shadow-lg shadow-amber-600/25">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" /></svg>
                            Edit Game
                        </a>
                    @elseif($game->stock > 0)
                        <form action="{{ route('cart.add', $game) }}" method="POST" class="flex gap-3">
                            @csrf
                            <input type="number" name="quantity" value="1" min="1" max="{{ $game->stock }}" class="w-20 bg-[#050510] border border-white/10 rounded-xl text-white text-center py-3 focus:ring-indigo-500 focus:border-indigo-500">
                            <button type="submit" class="flex-1 bg-indigo-600 hover:bg-indigo-500 text-white font-bold py-3 px-6 rounded-xl transition-all flex justify-center items-center gap-2 shadow-lg shadow-indigo-600/25 hover:shadow-indigo-500/40">
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 00-3 3h15.75m-12.75-3h11.218c1.121 0 2.09-.773 2.34-1.865l1.692-7.414A1.125 1.125 0 0015.913 3.75H5.648M7.5 14.25L5.106 5.272M6 20.25a.75.75 0 11-1.5 0 .75.75 0 011.5 0zm12.75 0a.75.75 0 11-1.5 0 .75.75 0 011.5 0z" /></svg>
                                Add to Cart
                            </button>
                        </form>
                    @else
                        <button disabled class="w-full bg-gray-800 text-gray-500 font-bold py-3 px-6 rounded-xl cursor-not-allowed">Sold Out</button>
                    @endif
                @else
                    @if($game->stock > 0)
                        <form action="{{ route('cart.add', $game) }}" method="POST" class="flex gap-3">
                            @csrf
                            <input type="number" name="quantity" value="1" min="1" max="{{ $game->stock }}" class="w-20 bg-[#050510] border border-white/10 rounded-xl text-white text-center py-3 focus:ring-indigo-500 focus:border-indigo-500">
                            <button type="submit" class="flex-1 bg-indigo-600 hover:bg-indigo-500 text-white font-bold py-3 px-6 rounded-xl transition-all flex justify-center items-center gap-2 shadow-lg shadow-indigo-600/25 hover:shadow-indigo-500/40">
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 00-3 3h15.75m-12.75-3h11.218c1.121 0 2.09-.773 2.34-1.865l1.692-7.414A1.125 1.125 0 0015.913 3.75H5.648M7.5 14.25L5.106 5.272M6 20.25a.75.75 0 11-1.5 0 .75.75 0 011.5 0zm12.75 0a.75.75 0 11-1.5 0 .75.75 0 011.5 0z" /></svg>
                                Add to Cart
                            </button>
                        </form>
                    @else
                        <button disabled class="w-full bg-gray-800 text-gray-500 font-bold py-3 px-6 rounded-xl cursor-not-allowed">Sold Out</button>
                    @endif
                @endauth
            </div>
        </div>
    </div>

    <!-- Reviews Section -->
    <div class="mt-12 bg-[#0d0d1a] rounded-2xl border border-white/[0.06] p-8">
        <h2 class="text-xl font-black text-white mb-6 tracking-tight">Customer Reviews</h2>
        
        @auth
            @if(Auth::user()->role === 'client')
                <form action="{{ route('reviews.store', $game) }}" method="POST" class="mb-10 bg-white/[0.02] p-6 rounded-xl border border-white/[0.06]">
                    @csrf
                    <div class="mb-4">
                        <label class="block text-sm font-semibold text-gray-400 mb-3">Your Rating</label>
                        <div class="flex gap-3">
                            @for($i=1; $i<=5; $i++)
                                <label class="cursor-pointer">
                                    <input type="radio" name="rating" value="{{ $i }}" class="sr-only peer" required>
                                    <div class="w-10 h-10 flex items-center justify-center rounded-xl bg-white/5 border border-white/10 peer-checked:bg-indigo-600 peer-checked:border-indigo-500 peer-checked:text-white text-gray-500 hover:bg-white/10 transition-all font-bold text-sm">{{ $i }}</div>
                                </label>
                            @endfor
                        </div>
                    </div>
                    <div class="mb-4">
                        <label for="comment" class="block text-sm font-semibold text-gray-400 mb-2">Comment (optional)</label>
                        <textarea name="comment" id="comment" rows="3" class="w-full bg-[#050510] border border-white/10 rounded-xl text-white px-4 py-3 focus:ring-indigo-500 focus:border-indigo-500 placeholder-gray-600 text-sm" placeholder="Share your thoughts..."></textarea>
                    </div>
                    <button type="submit" class="bg-indigo-600 hover:bg-indigo-500 text-white px-6 py-2.5 rounded-xl text-sm font-bold transition-all">Submit Review</button>
                </form>
            @endif
        @else
            <div class="mb-10 bg-white/[0.02] p-6 rounded-xl border border-white/[0.06] text-center">
                <p class="text-gray-500 text-sm mb-3">Log in to leave a review.</p>
                <a href="{{ route('login') }}" class="inline-flex bg-white/5 hover:bg-white/10 px-5 py-2 rounded-xl text-white text-sm font-bold border border-white/10 transition-all">Log In</a>
            </div>
        @endauth

        <!-- Review List -->
        <div class="space-y-6">
            @forelse($game->reviews as $review)
                <div class="flex gap-4 pb-6 border-b border-white/[0.04] last:border-0 last:pb-0">
                    <div class="h-10 w-10 rounded-full bg-indigo-600 flex items-center justify-center text-white font-bold text-sm flex-shrink-0">
                        {{ strtoupper(substr($review->user->name, 0, 1)) }}
                    </div>
                    <div class="flex-1 min-w-0">
                        <div class="flex items-center justify-between mb-1">
                            <h4 class="font-bold text-gray-200 text-sm">{{ $review->user->name }}</h4>
                            <span class="text-xs text-gray-600">{{ $review->created_at->diffForHumans() }}</span>
                        </div>
                        <div class="flex gap-0.5 mb-2">
                            @for($i=1; $i<=5; $i++)
                                <svg class="w-3.5 h-3.5 {{ $i <= $review->rating ? 'text-yellow-400' : 'text-gray-700' }}" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                            @endfor
                        </div>
                        @if($review->comment)
                            <p class="text-gray-400 text-sm leading-relaxed">{{ $review->comment }}</p>
                        @endif
                    </div>
                </div>
            @empty
                <p class="text-gray-600 text-sm text-center py-6">No reviews yet — be the first!</p>
            @endforelse
        </div>
    </div>
</div>
@endsection
