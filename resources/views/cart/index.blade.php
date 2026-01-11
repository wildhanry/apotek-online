@extends('layouts.app')

@section('title', 'Keranjang Belanja')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <h1 class="text-3xl font-bold text-gray-900 mb-6">Keranjang Belanja</h1>

    @if(!empty($cart) && count($cart) > 0)
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Cart Items -->
            <div class="lg:col-span-2">
                <div class="bg-white rounded-lg shadow overflow-hidden">
                    @foreach($cart as $id => $item)
                        <div class="p-6 border-b border-gray-200 last:border-0">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 h-24 w-24 bg-gray-200 rounded-lg flex items-center justify-center">
                                    @if($item['image'])
                                        <img src="{{ asset('storage/' . $item['image']) }}" alt="{{ $item['name'] }}" class="h-full w-full object-cover rounded-lg">
                                    @else
                                        <svg class="h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                        </svg>
                                    @endif
                                </div>

                                <div class="ml-6 flex-1">
                                    <h3 class="text-lg font-semibold text-gray-900">{{ $item['name'] }}</h3>
                                    <p class="text-gray-600 mt-1">Rp {{ number_format($item['price'], 0, ',', '.') }}</p>

                                    <div class="flex items-center mt-3 space-x-4">
                                        <form action="{{ route('cart.update', $id) }}" method="POST" class="flex items-center">
                                            @csrf
                                            @method('PATCH')
                                            <label for="quantity-{{ $id }}" class="text-sm text-gray-600 mr-2">Jumlah:</label>
                                            <input type="number" name="quantity" id="quantity-{{ $id }}" value="{{ $item['quantity'] }}" min="1" class="w-20 rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500">
                                            <button type="submit" class="ml-2 text-sm text-green-600 hover:text-green-700 font-medium">Update</button>
                                        </form>

                                        <form action="{{ route('cart.remove', $id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-sm text-red-600 hover:text-red-700 font-medium">Hapus</button>
                                        </form>
                                    </div>
                                </div>

                                <div class="text-right">
                                    <p class="text-lg font-semibold text-gray-900">
                                        Rp {{ number_format($item['price'] * $item['quantity'], 0, ',', '.') }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="mt-4">
                    <form action="{{ route('cart.clear') }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-red-600 hover:text-red-700 font-medium" onclick="return confirm('Yakin ingin mengosongkan keranjang?')">
                            Kosongkan Keranjang
                        </button>
                    </form>
                </div>
            </div>

            <!-- Order Summary -->
            <div class="lg:col-span-1">
                <div class="bg-white rounded-lg shadow p-6 sticky top-6">
                    <h2 class="text-xl font-bold text-gray-900 mb-4">Ringkasan Pesanan</h2>

                    <div class="border-t border-gray-200 pt-4">
                        <div class="flex justify-between mb-2">
                            <span class="text-gray-600">Subtotal</span>
                            <span class="font-semibold">Rp {{ number_format($total, 0, ',', '.') }}</span>
                        </div>
                        <div class="flex justify-between mb-4 pb-4 border-b border-gray-200">
                            <span class="text-gray-600">Biaya Admin</span>
                            <span class="font-semibold">Rp 0</span>
                        </div>
                        <div class="flex justify-between mb-6">
                            <span class="text-lg font-bold text-gray-900">Total</span>
                            <span class="text-lg font-bold text-green-600">Rp {{ number_format($total, 0, ',', '.') }}</span>
                        </div>

                        <a href="{{ route('checkout') }}" class="block w-full bg-green-600 hover:bg-green-700 text-white text-center font-medium py-3 px-4 rounded-md transition duration-150">
                            Lanjut ke Pembayaran
                        </a>
                        <a href="{{ route('products.index') }}" class="block w-full mt-3 bg-gray-200 hover:bg-gray-300 text-gray-700 text-center font-medium py-3 px-4 rounded-md transition duration-150">
                            Lanjut Belanja
                        </a>
                    </div>
                </div>
            </div>
        </div>
    @else
        <div class="bg-white rounded-lg shadow p-12 text-center">
            <svg class="mx-auto h-24 w-24 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
            </svg>
            <h3 class="text-xl font-semibold text-gray-700 mb-2">Keranjang Anda Kosong</h3>
            <p class="text-gray-500 mb-6">Belum ada produk yang ditambahkan ke keranjang</p>
            <a href="{{ route('products.index') }}" class="inline-block bg-green-600 hover:bg-green-700 text-white font-medium py-2 px-6 rounded-md transition duration-150">
                Mulai Belanja
            </a>
        </div>
    @endif
</div>
@endsection
