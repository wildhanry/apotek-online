@extends('layouts.app')

@section('title', 'Edit Profile')

@section('content')
<div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
    <h1 class="text-3xl font-bold text-gray-900 mb-6">Profile</h1>

    <div class="bg-white rounded-lg shadow p-6">
        <form method="POST" action="{{ route('profile.update') }}">
            @csrf
            @method('PATCH')

            <div class="mb-4">
                <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Nama</label>
                <input id="name" type="text" name="name" value="{{ old('name', $user->name) }}" required class="w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500 @error('name') border-red-500 @enderror">
                @error('name')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-6">
                <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                <input id="email" type="email" name="email" value="{{ old('email', $user->email) }}" required class="w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500 @error('email') border-red-500 @enderror">
                @error('email')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex items-center justify-end">
                <button type="submit" class="bg-green-600 hover:bg-green-700 text-white font-medium py-2 px-6 rounded-md transition duration-150">
                    Simpan
                </button>
            </div>

            @if (session('status') === 'profile-updated')
                <p class="text-sm text-green-600 mt-2">Saved.</p>
            @endif
        </form>
    </div>
</div>
@endsection
