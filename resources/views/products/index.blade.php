@extends('layouts.app')

@section('title', 'Katalog Produk')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <!-- Hero Section -->
    <div class="bg-gradient-to-r from-green-500 to-green-600 rounded-lg shadow-lg p-8 mb-8 text-white">
        <h1 class="text-4xl font-bold mb-2">Apotek Online</h1>
        <p class="text-lg">Belanja obat dan produk kesehatan dengan mudah dan aman</p>
    </div>

    <!-- Search and Filter -->
    <div class="bg-white rounded-lg shadow p-6 mb-8">
        <form action="{{ route('products.index') }}" method="GET" class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div class="md:col-span-2">
                <label for="search" class="block text-sm font-medium text-gray-700 mb-2">Cari Produk</label>
                <input type="text" name="search" id="search" value="{{ request('search') }}" placeholder="Nama produk atau deskripsi..." class="w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500">
            </div>
            <div>
                <label for="category" class="block text-sm font-medium text-gray-700 mb-2">Kategori</label>
                <select name="category" id="category" class="w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500">
                    <option value="">Semua Kategori</option>
                    @foreach($categories as $category)
                        <option value="{{ $category }}" {{ request('category') == $category ? 'selected' : '' }}>
                            {{ $category }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="md:col-span-3">
                <button type="submit" class="w-full md:w-auto bg-green-600 hover:bg-green-700 text-white font-medium py-2 px-6 rounded-md transition duration-150">
                    Cari
                </button>
                <a href="{{ route('products.index') }}" class="inline-block ml-2 bg-gray-200 hover:bg-gray-300 text-gray-700 font-medium py-2 px-6 rounded-md transition duration-150">
                    Reset
                </a>
            </div>
        </form>
    </div>

    <!-- Products Grid -->
    @if($products->count() > 0)
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6 mb-8">
            @foreach($products as $product)
                <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-xl transition duration-300 flex flex-col h-full">
                    <div class="h-48 bg-gray-200 flex items-center justify-center flex-shrink-0">
                        @if($product->image)
                            <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="h-full w-full object-cover">
                        @else
                            <svg class="h-20 w-20 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"/>
                            </svg>
                        @endif
                    </div>
                    <div class="p-4 flex flex-col flex-grow">
                        <span class="inline-block bg-green-100 text-green-800 text-xs px-2 py-1 rounded-full mb-2 w-fit">
                            {{ $product->category }}
                        </span>
                        <h3 class="font-semibold text-lg text-gray-800 mb-2 min-h-[3.5rem]">{{ $product->name }}</h3>
                        <p class="text-gray-600 text-sm mb-3 flex-grow" style="min-height: 2.5rem; max-height: 3rem; overflow: hidden; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical;">{{ $product->description ?? 'Tidak ada deskripsi' }}</p>
                        <div class="flex justify-between items-center mb-3">
                            <span class="text-2xl font-bold text-green-600">Rp {{ number_format($product->price, 0, ',', '.') }}</span>
                            <span class="text-sm text-gray-500">Stok: {{ $product->stock }}</span>
                        </div>
                        <a href="{{ route('products.show', $product) }}" class="block w-full bg-green-600 hover:bg-green-700 text-white text-center font-medium py-2 px-4 rounded-md transition duration-150">
                            Lihat Detail
                        </a>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Pagination -->
        <div class="mb-8">
            {{ $products->links() }}
        </div>
    @else
        <div class="bg-white rounded-lg shadow p-12 text-center">
            <svg class="mx-auto h-24 w-24 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <h3 class="text-xl font-semibold text-gray-700 mb-2">Produk tidak ditemukan</h3>
            <p class="text-gray-500">Coba gunakan kata kunci pencarian yang berbeda</p>
        </div>
    @endif
</div>
@endsection
