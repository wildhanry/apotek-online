@extends('layouts.app')

@section('title', 'Edit Produk')

@section('content')
<div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="mb-6">
        <h1 class="text-3xl font-bold text-gray-900">Edit Produk</h1>
    </div>

    <div class="bg-white rounded-lg shadow p-6">
        <form action="{{ route('admin.products.update', $product) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Nama Produk *</label>
                <input type="text" name="name" id="name" value="{{ old('name', $product->name) }}" required class="w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500 @error('name') border-red-500 @enderror">
                @error('name')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="category" class="block text-sm font-medium text-gray-700 mb-2">Kategori *</label>
                <input type="text" name="category" id="category" value="{{ old('category', $product->category) }}" required class="w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500 @error('category') border-red-500 @enderror">
                @error('category')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="grid grid-cols-2 gap-4 mb-4">
                <div>
                    <label for="price" class="block text-sm font-medium text-gray-700 mb-2">Harga (Rp) *</label>
                    <input type="number" name="price" id="price" value="{{ old('price', $product->price) }}" min="0" required class="w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500 @error('price') border-red-500 @enderror">
                    @error('price')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="stock" class="block text-sm font-medium text-gray-700 mb-2">Stok *</label>
                    <input type="number" name="stock" id="stock" value="{{ old('stock', $product->stock) }}" min="0" required class="w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500 @error('stock') border-red-500 @enderror">
                    @error('stock')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="mb-4">
                <label for="description" class="block text-sm font-medium text-gray-700 mb-2">Deskripsi</label>
                <textarea name="description" id="description" rows="4" class="w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500 @error('description') border-red-500 @enderror">{{ old('description', $product->description) }}</textarea>
                @error('description')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-6">
                <label for="image" class="block text-sm font-medium text-gray-700 mb-2">Gambar Produk</label>
                @if($product->image)
                    <div class="mb-2">
                        <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="h-32 w-32 object-cover rounded">
                    </div>
                @endif
                <input type="file" name="image" id="image" accept="image/*" class="w-full @error('image') border-red-500 @enderror">
                <p class="text-sm text-gray-500 mt-1">Format: JPG, PNG, GIF. Maksimal 2MB. Kosongkan jika tidak ingin mengubah gambar.</p>
                @error('image')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex justify-end space-x-3">
                <a href="{{ route('admin.products.index') }}" class="bg-gray-200 hover:bg-gray-300 text-gray-700 font-medium py-2 px-4 rounded-md transition duration-150">
                    Batal
                </a>
                <button type="submit" class="bg-green-600 hover:bg-green-700 text-white font-medium py-2 px-4 rounded-md transition duration-150">
                    Update Produk
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
