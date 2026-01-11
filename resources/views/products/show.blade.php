@extends('layouts.app')

@section('title', $product->name)

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="bg-white rounded-lg shadow-lg overflow-hidden">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 p-8">
            <!-- Product Image -->
            <div class="flex items-center justify-center bg-gray-100 rounded-lg p-8">
                @if($product->image)
                    <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="max-h-96 w-auto object-contain">
                @else
                    <svg class="h-64 w-64 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"/>
                    </svg>
                @endif
            </div>

            <!-- Product Info -->
            <div>
                <span class="inline-block bg-green-100 text-green-800 text-sm px-3 py-1 rounded-full mb-3">
                    {{ $product->category }}
                </span>
                <h1 class="text-3xl font-bold text-gray-900 mb-4">{{ $product->name }}</h1>
                
                <div class="mb-6">
                    <span class="text-4xl font-bold text-green-600">Rp {{ number_format($product->price, 0, ',', '.') }}</span>
                </div>

                <div class="mb-6">
                    <span class="text-gray-700 font-medium">Stok Tersedia: </span>
                    <span class="text-lg font-semibold {{ $product->stock > 10 ? 'text-green-600' : 'text-orange-600' }}">
                        {{ $product->stock }} unit
                    </span>
                </div>

                @if($product->description)
                    <div class="mb-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-2">Deskripsi</h3>
                        <p class="text-gray-700 leading-relaxed">{{ $product->description }}</p>
                    </div>
                @endif

                @auth
                    @if(auth()->user()->role === 'customer')
                        @if($product->stock > 0)
                            <form action="{{ route('cart.add', $product) }}" method="POST" class="space-y-4">
                                @csrf
                                <div>
                                    <label for="quantity" class="block text-sm font-medium text-gray-700 mb-2">Jumlah</label>
                                    <input type="number" name="quantity" id="quantity" min="1" max="{{ $product->stock }}" value="1" class="w-32 rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500">
                                    @error('quantity')
                                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                                <button type="submit" class="w-full bg-green-600 hover:bg-green-700 text-white font-medium py-3 px-6 rounded-md transition duration-150 flex items-center justify-center">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
                                    </svg>
                                    Tambah ke Keranjang
                                </button>
                            </form>
                        @else
                            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
                                Produk ini sedang habis
                            </div>
                        @endif
                    @endif
                @else
                    <div class="bg-yellow-100 border border-yellow-400 text-yellow-700 px-4 py-3 rounded">
                        <a href="{{ route('login') }}" class="font-medium underline">Login</a> untuk membeli produk ini
                    </div>
                @endauth

                <div class="mt-6">
                    <a href="{{ route('products.index') }}" class="text-green-600 hover:text-green-700 font-medium">
                        ← Kembali ke Katalog
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
