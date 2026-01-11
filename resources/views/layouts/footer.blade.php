<footer class="bg-gray-800 text-white mt-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <div>
                <h3 class="text-lg font-semibold mb-4">Apotek Online</h3>
                <p class="text-gray-300 text-sm">
                    Sistem informasi apotek online untuk memudahkan pembelian obat dan produk kesehatan.
                </p>
            </div>
            <div>
                <h3 class="text-lg font-semibold mb-4">Link Cepat</h3>
                <ul class="space-y-2 text-sm">
                    <li><a href="{{ route('home') }}" class="text-gray-300 hover:text-white">Produk</a></li>
                    @auth
                        <li><a href="{{ route('dashboard') }}" class="text-gray-300 hover:text-white">Dashboard</a></li>
                        @if(auth()->user()->role === 'customer')
                            <li><a href="{{ route('orders.index') }}" class="text-gray-300 hover:text-white">Pesanan Saya</a></li>
                        @endif
                    @endauth
                </ul>
            </div>
            <div>
                <h3 class="text-lg font-semibold mb-4">Kontak</h3>
                <ul class="space-y-2 text-sm text-gray-300">
                    <li>Email: info@apotekonline.com</li>
                    <li>Telepon: (021) 1234-5678</li>
                    <li>Alamat: Jakarta, Indonesia</li>
                </ul>
            </div>
        </div>
        <div class="border-t border-gray-700 mt-8 pt-6 text-center text-sm text-gray-400">
            <p>&copy; {{ date('Y') }} Apotek Online. All rights reserved. | University Project</p>
        </div>
    </div>
</footer>
