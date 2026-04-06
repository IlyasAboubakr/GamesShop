<x-guest-layout>
    <h2 class="text-2xl font-bold text-white mb-1">Forgot password?</h2>
    <p class="text-sm text-gray-400 mb-6">{{ __('No problem. Enter your email and we\'ll send you a reset link.') }}</p>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('password.email') }}">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div class="mt-6">
            <button type="submit" class="w-full inline-flex items-center justify-center bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-500 hover:to-purple-500 text-white px-6 py-2.5 rounded-xl text-sm font-bold transition-all shadow-lg shadow-indigo-500/25 hover:shadow-indigo-500/50 hover:-translate-y-0.5">
                {{ __('Email Password Reset Link') }}
            </button>
        </div>
    </form>

    <div class="mt-6 pt-6 border-t border-white/[0.08] text-center">
        <p class="text-sm text-gray-500">Remember your password?
            <a href="{{ route('login') }}" class="text-indigo-400 hover:text-indigo-300 font-semibold transition-colors">Sign in</a>
        </p>
    </div>
</x-guest-layout>
