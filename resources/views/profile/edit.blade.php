@extends('layouts.store')

@section('title', 'Profile')

@section('content')
<div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <div class="mb-8">
        <h1 class="text-3xl font-black text-white tracking-tight">My Profile</h1>
        <p class="text-gray-500 text-sm mt-1">Manage your account settings.</p>
    </div>

    <div class="space-y-6">
        {{-- Update Profile Information --}}
        <div class="bg-[#0d0d1a] rounded-2xl border border-white/[0.06] p-6 sm:p-8">
            <div class="max-w-xl">
                @include('profile.partials.update-profile-information-form')
            </div>
        </div>

        {{-- Update Password --}}
        <div class="bg-[#0d0d1a] rounded-2xl border border-white/[0.06] p-6 sm:p-8">
            <div class="max-w-xl">
                @include('profile.partials.update-password-form')
            </div>
        </div>

        {{-- Delete Account (hidden for admins) --}}
        @if(auth()->user()->role !== 'admin')
        <div class="bg-[#0d0d1a] rounded-2xl border border-red-500/10 p-6 sm:p-8">
            <div class="max-w-xl">
                @include('profile.partials.delete-user-form')
            </div>
        </div>
        @endif
    </div>
</div>
@endsection
