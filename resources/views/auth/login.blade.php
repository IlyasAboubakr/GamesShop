<x-guest-layout>
    <!-- Page Title -->
    <h2 class="text-2xl font-bold text-white mb-1">Welcome back</h2>
    <p class="text-sm text-gray-400 mb-6">Sign in to your account to continue</p>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />

            <x-text-input id="password" class="block mt-1 w-full"
                            type="password"
                            name="password"
                            required autocomplete="current-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Remember Me -->
        <div class="block mt-4">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox" class="rounded bg-white/5 border-white/20 text-indigo-500 shadow-sm focus:ring-indigo-500 focus:ring-offset-0" name="remember">
                <span class="ms-2 text-sm text-gray-400">{{ __('Remember me') }}</span>
            </label>
        </div>

        <div class="flex items-center justify-between mt-6">
            @if (Route::has('password.request'))
                <a class="text-sm text-indigo-400 hover:text-indigo-300 transition-colors font-medium" href="{{ route('password.request') }}">
                    {{ __('Forgot password?') }}
                </a>
            @endif

            <button type="submit" class="inline-flex items-center bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-500 hover:to-purple-500 text-white px-6 py-2.5 rounded-xl text-sm font-bold transition-all shadow-lg shadow-indigo-500/25 hover:shadow-indigo-500/50 hover:-translate-y-0.5">
                {{ __('Log in') }}
            </button>
        </div>
    </form>

    <!-- Register link -->
    <div class="mt-6 pt-6 border-t border-white/[0.08] text-center">
        <p class="text-sm text-gray-500">Don't have an account?
            <a href="{{ route('register') }}" class="text-indigo-400 hover:text-indigo-300 font-semibold transition-colors">Sign up</a>
        </p>
    </div>
</x-guest-layout>
