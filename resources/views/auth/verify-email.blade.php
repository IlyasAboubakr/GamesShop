<x-guest-layout>
    <h2 class="text-2xl font-bold text-white mb-1">Verify your email</h2>
    <p class="text-sm text-gray-400 mb-6">{{ __('Thanks for signing up! Please verify your email address by clicking the link we just sent you. If you didn\'t receive it, we\'ll gladly send another.') }}</p>

    @if (session('status') == 'verification-link-sent')
        <div class="mb-4 font-medium text-sm text-emerald-400 bg-emerald-500/10 border border-emerald-500/20 rounded-xl px-4 py-3">
            {{ __('A new verification link has been sent to your email address.') }}
        </div>
    @endif

    <div class="flex items-center justify-between">
        <form method="POST" action="{{ route('verification.send') }}">
            @csrf
            <button type="submit" class="inline-flex items-center bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-500 hover:to-purple-500 text-white px-5 py-2.5 rounded-xl text-sm font-bold transition-all shadow-lg shadow-indigo-500/25 hover:shadow-indigo-500/50 hover:-translate-y-0.5">
                {{ __('Resend Verification Email') }}
            </button>
        </form>

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="text-sm text-gray-400 hover:text-indigo-400 font-medium transition-colors">
                {{ __('Log Out') }}
            </button>
        </form>
    </div>
</x-guest-layout>
