@extends('layouts.app')

@section('title', 'Dashboard Apoteker')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <h1 class="text-3xl font-bold text-gray-900 mb-6">Dashboard Apoteker</h1>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-yellow-100 text-yellow-600">
                    <svg class="h-8 w-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Pesanan Pending</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $stats['pending_orders'] }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-blue-100 text-blue-600">
                    <svg class="h-8 w-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Sedang Diproses</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $stats['processing_orders'] }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-green-100 text-green-600">
                    <svg class="h-8 w-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Selesai Hari Ini</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $stats['completed_today'] }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-red-100 text-red-600">
                    <svg class="h-8 w-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Stok Menipis</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $stats['low_stock_products'] }}</p>
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <!-- Pending Orders -->
        <div class="bg-white rounded-lg shadow">
            <div class="p-6 border-b border-gray-200">
                <h2 class="text-xl font-bold text-gray-900">Pesanan Menunggu Proses</h2>
            </div>
            <div class="p-6">
                @if($pending_orders->count() > 0)
                    <div class="space-y-4">
                        @foreach($pending_orders as $order)
                            <div class="pb-4 border-b border-gray-200 last:border-0">
                                <div class="flex justify-between items-start mb-2">
                                    <div>
                                        <p class="font-semibold text-gray-900">#{{ $order->id }} - {{ $order->user->name }}</p>
                                        <p class="text-sm text-gray-600">{{ $order->created_at->diffForHumans() }}</p>
                                    </div>
                                    <div class="text-right">
                                        <p class="font-semibold text-gray-900">Rp {{ number_format($order->total_price, 0, ',', '.') }}</p>
                                    </div>
                                </div>
                                <div class="flex space-x-2 mt-2">
                                    <form action="{{ route('admin.orders.updateStatus', $order) }}" method="POST">
                                        @csrf
                                        @method('PATCH')
                                        <input type="hidden" name="status" value="processing">
                                        <button type="submit" class="text-xs bg-blue-100 text-blue-800 px-3 py-1 rounded hover:bg-blue-200">
                                            Proses
                                        </button>
                                    </form>
                                    <a href="{{ route('orders.show', $order) }}" class="text-xs bg-gray-100 text-gray-800 px-3 py-1 rounded hover:bg-gray-200">
                                        Detail
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <div class="mt-4">
                        <a href="{{ route('admin.orders.index') }}" class="text-green-600 hover:text-green-700 font-medium text-sm">
                            Lihat Semua Pesanan →
                        </a>
                    </div>
                @else
                    <p class="text-gray-500 text-center py-4">Tidak ada pesanan pending</p>
                @endif
            </div>
        </div>

        <!-- Low Stock Products -->
        <div class="bg-white rounded-lg shadow">
            <div class="p-6 border-b border-gray-200">
                <h2 class="text-xl font-bold text-gray-900">Produk Stok Menipis</h2>
            </div>
            <div class="p-6">
                @if($low_stock_products->count() > 0)
                    <div class="space-y-4">
                        @foreach($low_stock_products as $product)
                            <div class="flex justify-between items-center pb-4 border-b border-gray-200 last:border-0">
                                <div>
                                    <p class="font-semibold text-gray-900">{{ $product->name }}</p>
                                    <p class="text-sm text-gray-600">{{ $product->category }}</p>
                                </div>
                                <div class="text-right">
                                    <span class="text-red-600 font-semibold">{{ $product->stock }} unit</span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-gray-500 text-center py-4">Semua produk stoknya mencukupi</p>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
