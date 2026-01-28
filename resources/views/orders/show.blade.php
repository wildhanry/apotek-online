@extends('layouts.app')

@section('title', 'Detail Pesanan #' . $order->id)

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="mb-6">
        <a href="{{ auth()->user()->role === 'customer' ? route('orders.index') : route('admin.orders.index') }}" class="text-green-600 hover:text-green-700 font-medium">
            ← Kembali
        </a>
    </div>

    <div class="bg-white rounded-lg shadow-lg overflow-hidden">
        <!-- Order Header -->
        <div class="bg-gradient-to-r from-green-500 to-green-600 p-6 text-white">
            <div class="flex justify-between items-start">
                <div>
                    <h1 class="text-2xl font-bold mb-2">Pesanan #{{ $order->id }}</h1>
                    <p class="text-green-100">{{ $order->created_at->format('d F Y, H:i') }}</p>
                </div>
                <span class="px-3 py-1 text-sm rounded-full font-semibold bg-white
                    @if($order->status === 'pending') text-yellow-600
                    @elseif($order->status === 'processing') text-blue-600
                    @elseif($order->status === 'completed') text-green-600
                    @else text-red-600
                    @endif">
                    @if($order->status === 'pending') Menunggu Konfirmasi
                    @elseif($order->status === 'processing') Sedang Diproses
                    @elseif($order->status === 'completed') Selesai
                    @else Dibatalkan
                    @endif
                </span>
            </div>
        </div>

        <div class="p-6">
            <!-- Customer Info -->
            <div class="mb-6 pb-6 border-b border-gray-200">
                <h2 class="text-lg font-semibold text-gray-900 mb-3">Informasi Pembeli</h2>
                <div class="bg-gray-50 rounded-lg p-4">
                    <p class="text-gray-700"><span class="font-semibold">Nama:</span> {{ $order->user->name }}</p>
                    <p class="text-gray-700"><span class="font-semibold">Email:</span> {{ $order->user->email }}</p>
                </div>
            </div>

            <!-- Order Items -->
            <div class="mb-6">
                <h2 class="text-lg font-semibold text-gray-900 mb-3">Detail Produk</h2>
                <div class="space-y-4">
                    @foreach($order->orderItems as $item)
                        <div class="flex justify-between items-center pb-4 border-b border-gray-200 last:border-0">
                            <div class="flex items-center flex-1">
                                <div class="h-16 w-16 bg-gray-200 rounded flex items-center justify-center flex-shrink-0">
                                    @if($item->product->image)
                                        <img src="{{ asset('storage/' . $item->product->image) }}" alt="{{ $item->product->name }}" class="h-full w-full object-cover rounded">
                                    @else
                                        <svg class="h-8 w-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                        </svg>
                                    @endif
                                </div>
                                <div class="ml-4">
                                    <h3 class="font-semibold text-gray-900">{{ $item->product->name }}</h3>
                                    <p class="text-sm text-gray-600">{{ $item->quantity }} x Rp {{ number_format($item->price, 0, ',', '.') }}</p>
                                </div>
                            </div>
                            <div class="text-right">
                                <p class="font-semibold text-gray-900">Rp {{ number_format($item->price * $item->quantity, 0, ',', '.') }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Order Summary -->
            <div class="bg-gray-50 rounded-lg p-4">
                <div class="flex justify-between mb-2">
                    <span class="text-gray-600">Subtotal</span>
                    <span class="font-semibold">Rp {{ number_format($order->total_price, 0, ',', '.') }}</span>
                </div>
                <div class="flex justify-between mb-2 pb-2 border-b border-gray-300">
                    <span class="text-gray-600">Biaya Admin</span>
                    <span class="font-semibold">Rp 0</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-lg font-bold text-gray-900">Total</span>
                    <span class="text-lg font-bold text-green-600">Rp {{ number_format($order->total_price, 0, ',', '.') }}</span>
                </div>
            </div>

            <!-- Prescription Image Section -->
            @if($order->prescription_image)
                <div class="mt-6 pt-6 border-t border-gray-200">
                    <h2 class="text-lg font-semibold text-gray-900 mb-3">Resep Dokter</h2>
                    <div class="bg-gray-50 rounded-lg p-4">
                        <img src="{{ asset('storage/' . $order->prescription_image) }}" 
                             alt="Resep Dokter" 
                             class="max-w-full h-auto rounded-lg shadow-md cursor-pointer hover:opacity-90 transition"
                             onclick="window.open(this.src, '_blank')">
                        <p class="mt-2 text-sm text-gray-600">Klik gambar untuk memperbesar</p>
                    </div>
                </div>
            @endif

            <!-- Admin/Apoteker Actions -->
            @if(auth()->user()->role === 'admin' || auth()->user()->role === 'apoteker')
                <div class="mt-6 pt-6 border-t border-gray-200">
                    <h2 class="text-lg font-semibold text-gray-900 mb-3">
                        @if($order->prescription_image && $order->status === 'pending')
                            Validasi Resep
                        @else
                            Ubah Status Pesanan
                        @endif
                    </h2>
                    
                    @if($order->prescription_image && $order->status === 'pending')
                        <!-- Quick Prescription Validation Buttons -->
                        <div class="flex space-x-3 mb-4">
                            <form action="{{ route('admin.orders.updateStatus', $order) }}" method="POST" class="flex-1">
                                @csrf
                                @method('PATCH')
                                <input type="hidden" name="status" value="processing">
                                <button type="submit" class="w-full bg-green-600 hover:bg-green-700 text-white font-medium py-3 px-4 rounded-md transition duration-150 flex items-center justify-center">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                    </svg>
                                    Terima Resep
                                </button>
                            </form>
                            <form action="{{ route('admin.orders.updateStatus', $order) }}" method="POST" class="flex-1">
                                @csrf
                                @method('PATCH')
                                <input type="hidden" name="status" value="cancelled">
                                <button type="submit" class="w-full bg-red-600 hover:bg-red-700 text-white font-medium py-3 px-4 rounded-md transition duration-150 flex items-center justify-center"
                                        onclick="return confirm('Yakin ingin menolak resep ini?')">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                    </svg>
                                    Tolak Resep
                                </button>
                            </form>
                        </div>
                    @endif
                    
                    <!-- Manual Status Update Form -->
                    <form action="{{ route('admin.orders.updateStatus', $order) }}" method="POST" class="flex space-x-2">
                        @csrf
                        @method('PATCH')
                        <select name="status" class="flex-1 rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500">
                            <option value="pending" {{ $order->status === 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="processing" {{ $order->status === 'processing' ? 'selected' : '' }}>Processing</option>
                            <option value="completed" {{ $order->status === 'completed' ? 'selected' : '' }}>Completed</option>
                            <option value="cancelled" {{ $order->status === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                        </select>
                        <button type="submit" class="bg-gray-600 hover:bg-gray-700 text-white font-medium py-2 px-6 rounded-md transition duration-150">
                            Update Status
                        </button>
                    </form>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
