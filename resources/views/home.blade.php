@extends('layouts.app')

@section('content')
<div class="bg-gradient-to-r from-indigo-600 to-pink-500 text-white py-20">
    <div class="max-w-4xl mx-auto px-4 text-center">
        <h1 class="text-4xl font-extrabold mb-4">Selamat Datang di <span class="underline decoration-white/30">Resep Makanan</span></h1>
        <p class="text-lg mb-6">Temukan dan bagikan resep makanan favoritmu!</p>

        <div class="flex justify-center gap-4">
            @guest
                <a href="{{ route('login') }}" class="px-5 py-3 bg-white text-indigo-600 rounded-lg font-semibold shadow hover:opacity-90">Login</a>
                <a href="{{ route('register') }}" class="px-5 py-3 bg-white/20 border border-white/30 text-white rounded-lg font-semibold hover:bg-white/10">Register</a>
            @endguest

            @auth
                <a href="{{ route('reseps.index') }}" class="px-5 py-3 bg-white text-indigo-600 rounded-lg font-semibold shadow hover:opacity-90">Lihat Semua Resep</a>
            @endauth
        </div>
    </div>
</div>

<div class="max-w-6xl mx-auto px-4 py-12">
    <div class="grid md:grid-cols-3 gap-6">
        <div class="p-6 bg-white rounded-lg shadow">
            <h3 class="text-xl font-semibold mb-2">Cari Resep</h3>
            <p class="text-sm text-gray-600">Jelajahi koleksi resep berdasarkan kategori, bahan, atau nama masakan.</p>
        </div>

        <div class="p-6 bg-white rounded-lg shadow">
            <h3 class="text-xl font-semibold mb-2">Bagikan Kreasi</h3>
            <p class="text-sm text-gray-600">Tambahkan resepmu sendiri dan bantu komunitas menemukan masakan baru.</p>
        </div>

        <div class="p-6 bg-white rounded-lg shadow">
            <h3 class="text-xl font-semibold mb-2">Simpan Favorit</h3>
            <p class="text-sm text-gray-600">Simpan resep favorit untuk akses cepat kapan saja.</p>
        </div>
    </div>
</div>

@endsection