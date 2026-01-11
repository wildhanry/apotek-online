@extends('layouts.app')

@section('title', 'Riwayat Pesanan')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <h1 class="text-3xl font-bold text-gray-900 mb-6">Riwayat Pesanan</h1>

    @if($orders->count() > 0)
        <div class="space-y-4">
            @foreach($orders as $order)
                <div class="bg-white rounded-lg shadow hover:shadow-md transition duration-300">
                    <div class="p-6">
                        <div class="flex justify-between items-start mb-4">
                            <div>
                                <h3 class="text-lg font-semibold text-gray-900">Pesanan #{{ $order->id }}</h3>
                                <p class="text-sm text-gray-600">{{ $order->created_at->format('d M Y, H:i') }}</p>
                            </div>
                            <span class="px-3 py-1 text-sm rounded-full font-semibold
                                @if($order->status === 'pending') bg-yellow-100 text-yellow-800
                                @elseif($order->status === 'processing') bg-blue-100 text-blue-800
                                @elseif($order->status === 'completed') bg-green-100 text-green-800
                                @else bg-red-100 text-red-800
                                @endif">
                                @if($order->status === 'pending') Menunggu Konfirmasi
                                @elseif($order->status === 'processing') Sedang Diproses
                                @elseif($order->status === 'completed') Selesai
                                @else Dibatalkan
                                @endif
                            </span>
                        </div>

                        <div class="border-t border-gray-200 pt-4">
                            <div class="flex justify-between items-center">
                                <div>
                                    <p class="text-sm text-gray-600">{{ $order->orderItems->count() }} item</p>
                                    <p class="text-lg font-bold text-gray-900 mt-1">Rp {{ number_format($order->total_price, 0, ',', '.') }}</p>
                                </div>
                                <a href="{{ route('orders.show', $order) }}" class="bg-green-600 hover:bg-green-700 text-white font-medium py-2 px-4 rounded-md transition duration-150">
                                    Lihat Detail
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="mt-6">
            {{ $orders->links() }}
        </div>
    @else
        <div class="bg-white rounded-lg shadow p-12 text-center">
            <svg class="mx-auto h-24 w-24 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
            </svg>
            <h3 class="text-xl font-semibold text-gray-700 mb-2">Belum Ada Pesanan</h3>
            <p class="text-gray-500 mb-6">Anda belum melakukan pemesanan</p>
            <a href="{{ route('products.index') }}" class="inline-block bg-green-600 hover:bg-green-700 text-white font-medium py-2 px-6 rounded-md transition duration-150">
                Mulai Belanja
            </a>
        </div>
    @endif
</div>
@endsection
