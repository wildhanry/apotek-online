@extends('layouts.app')

@section('title', 'Checkout')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
    <h1 class="text-3xl font-bold text-gray-900 mb-6">Checkout</h1>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Order Items -->
        <div class="lg:col-span-2">
            <div class="bg-white rounded-lg shadow p-6 mb-6">
                <h2 class="text-xl font-bold text-gray-900 mb-4">Informasi Pembeli</h2>
                <div class="space-y-2">
                    <p class="text-gray-700"><span class="font-semibold">Nama:</span> {{ auth()->user()->name }}</p>
                    <p class="text-gray-700"><span class="font-semibold">Email:</span> {{ auth()->user()->email }}</p>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow p-6">
                <h2 class="text-xl font-bold text-gray-900 mb-4">Item Pesanan</h2>
                <div class="space-y-4">
                    @foreach($cart as $id => $item)
                        <div class="flex justify-between items-center pb-4 border-b border-gray-200 last:border-0">
                            <div class="flex items-center">
                                <div class="h-16 w-16 bg-gray-200 rounded flex items-center justify-center flex-shrink-0">
                                    @if($item['image'])
                                        <img src="{{ asset('storage/' . $item['image']) }}" alt="{{ $item['name'] }}" class="h-full w-full object-cover rounded">
                                    @else
                                        <svg class="h-8 w-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                        </svg>
                                    @endif
                                </div>
                                <div class="ml-4">
                                    <h3 class="font-semibold text-gray-900">{{ $item['name'] }}</h3>
                                    <p class="text-sm text-gray-600">Jumlah: {{ $item['quantity'] }}</p>
                                </div>
                            </div>
                            <div class="text-right">
                                <p class="font-semibold text-gray-900">Rp {{ number_format($item['price'] * $item['quantity'], 0, ',', '.') }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Order Summary -->
        <div class="lg:col-span-1">
            <div class="bg-white rounded-lg shadow p-6 sticky top-6">
                <h2 class="text-xl font-bold text-gray-900 mb-4">Ringkasan Pembayaran</h2>

                <div class="space-y-3 mb-6">
                    <div class="flex justify-between">
                        <span class="text-gray-600">Subtotal</span>
                        <span class="font-semibold">Rp {{ number_format($total, 0, ',', '.') }}</span>
                    </div>
                    <div class="flex justify-between pb-3 border-b border-gray-200">
                        <span class="text-gray-600">Biaya Admin</span>
                        <span class="font-semibold">Rp 0</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-lg font-bold text-gray-900">Total Bayar</span>
                        <span class="text-lg font-bold text-green-600">Rp {{ number_format($total, 0, ',', '.') }}</span>
                    </div>
                </div>

                <form action="{{ route('orders.store') }}" method="POST">
                    @csrf
                    <button type="submit" class="w-full bg-green-600 hover:bg-green-700 text-white font-medium py-3 px-4 rounded-md transition duration-150 mb-3">
                        Konfirmasi Pesanan
                    </button>
                </form>

                <a href="{{ route('cart.index') }}" class="block w-full bg-gray-200 hover:bg-gray-300 text-gray-700 text-center font-medium py-3 px-4 rounded-md transition duration-150">
                    Kembali ke Keranjang
                </a>

                <div class="mt-6 p-4 bg-yellow-50 border border-yellow-200 rounded-md">
                    <p class="text-sm text-yellow-800">
                        <strong>Catatan:</strong> Pesanan akan diproses setelah konfirmasi pembayaran.
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
