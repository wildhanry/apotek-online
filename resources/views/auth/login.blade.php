<x-guest-layout>
    <form method="POST" action="{{ route('login') }}">
        @csrf

        <div class="mb-6 text-center">
            <h2 class="text-2xl font-bold text-gray-900">Login</h2>
            <p class="text-sm text-gray-600 mt-1">Masuk ke akun Anda</p>
        </div>

        <!-- Email Address -->
        <div class="mb-4">
            <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Email</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username" class="w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500 @error('email') border-red-500 @enderror">
            @error('email')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Password -->
        <div class="mb-4">
            <label for="password" class="block text-sm font-medium text-gray-700 mb-2">Password</label>
            <input id="password" type="password" name="password" required autocomplete="current-password" class="w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500 @error('password') border-red-500 @enderror">
            @error('password')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Remember Me -->
        <div class="mb-4">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox" name="remember" class="rounded border-gray-300 text-green-600 shadow-sm focus:ring-green-500">
                <span class="ml-2 text-sm text-gray-600">Remember me</span>
            </label>
        </div>

        <div class="flex items-center justify-between">
            <a href="{{ route('register') }}" class="text-sm text-green-600 hover:text-green-700">
                Belum punya akun?
            </a>

            <button type="submit" class="bg-green-600 hover:bg-green-700 text-white font-medium py-2 px-6 rounded-md transition duration-150">
                Login
            </button>
        </div>
    </form>
</x-guest-layout>
