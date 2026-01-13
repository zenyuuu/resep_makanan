@extends('layouts.app')

@section('content')
<link rel="stylesheet" href="{{ asset('css/home.css') }}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<!-- Hero Section -->
<section class="hero-section">
    <div class="hero-content">
        <h1>Selamat Datang di <span class="highlight">MauMasakApa</span></h1>
        <p>Jelajahi koleksi resep lezat, berbagi kreasi Anda, dan temukan inspirasi kuliner dari seluruh dunia!</p>
        <div class="hero-buttons">
            @guest
                <a href="{{ route('login') }}" class="btn btn-primary">
                    <i class="fas fa-sign-in-alt"></i> Login Sekarang
                </a>
                <a href="{{ route('register') }}" class="btn btn-secondary">
                    <i class="fas fa-user-plus"></i> Daftar Gratis
                </a>
            @endguest

            @auth
                <a href="{{ route('reseps.index') }}" class="btn btn-primary">
                    <i class="fas fa-book"></i> Jelajahi Resep
                </a>
                <a href="{{ route('reseps.create') }}" class="btn btn-secondary">
                    <i class="fas fa-plus"></i> Buat Resep Baru
                </a>
            @endauth
        </div>
    </div>
</section>

<!-- Features Section -->
<section class="features-section">
    <div class="section-title">
        <h2>Mengapa Memilih Kami?</h2>
        <p>Fitur lengkap untuk memaksimalkan pengalaman memasak Anda</p>
    </div>

    <div class="features-grid">
        <div class="feature-card">
            <div class="feature-icon">🔍</div>
            <h3>Cari Resep Mudah</h3>
            <p>Temukan ribuan resep berdasarkan bahan, waktu, atau kesulitan memasak. Pencarian cepat dan akurat.</p>
        </div>

        <div class="feature-card">
            <div class="feature-icon">✍️</div>
            <h3>Bagikan Kreasi</h3>
            <p>Tambahkan resep favorit Anda dan bagikan dengan komunitas global. Bangun reputasi sebagai chef!</p>
        </div>

        <div class="feature-card">
            <div class="feature-icon">❤️</div>
            <h3>Simpan Favorit</h3>
            <p>Tandai resep favorit untuk akses instan. Kelola koleksi pribadi Anda dengan mudah.</p>
        </div>

        <div class="feature-card">
            <div class="feature-icon">👥</div>
            <h3>Komunitas Aktif</h3>
            <p>Terhubung dengan chef lain, berbagi tips, dan belajar teknik memasak baru bersama.</p>
        </div>

        <div class="feature-card">
            <div class="feature-icon">📱</div>
            <h3>Akses Dimana Saja</h3>
            <p>Akses resep Anda di smartphone, tablet, atau desktop. Sinkronisasi otomatis di semua perangkat.</p>
        </div>

        <div class="feature-card">
            <div class="feature-icon">🎓</div>
            <h3>Tips & Panduan</h3>
            <p>Pelajari teknik memasak profesional dan tips ahli untuk hasil sempurna setiap kali.</p>
        </div>
    </div>
</section>

<!-- Stats Section -->
<section class="stats-section">
    <div class="stats-grid">
        <div class="stat-item">
            <div class="stat-number">{{ \App\Models\Resep::count() ?? 0 }}</div>
            <div class="stat-label">Resep Tersedia</div>
        </div>
        <div class="stat-item">
            <div class="stat-number">{{ \App\Models\User::count() ?? 0 }}</div>
            <div class="stat-label">Chef Terdaftar</div>
        </div>
        <div class="stat-item">
            <div class="stat-number">5★</div>
            <div class="stat-label">Rating Kepuasan</div>
        </div>
        <div class="stat-item">
            <div class="stat-number">24/7</div>
            <div class="stat-label">Dukungan</div>
        </div>
    </div>
</section>

<!-- Categories Section -->
@if(\App\Models\Resep::count() > 0)
<section class="categories-section">
    <div class="section-title">
        <h2>Kategori Populer</h2>
        <p>Jelajahi resep berdasarkan jenis makanan favorit Anda</p>
    </div>

    <div class="categories-grid">
        <div class="category-item">
            <div class="category-icon">🍜</div>
            <div class="category-name">Mie & Pasta</div>
        </div>
        <div class="category-item">
            <div class="category-icon">🍲</div>
            <div class="category-name">Sup & Kuah</div>
        </div>
        <div class="category-item">
            <div class="category-icon">🍗</div>
            <div class="category-name">Ayam</div>
        </div>
        <div class="category-item">
            <div class="category-icon">🥘</div>
            <div class="category-name">Tumisan</div>
        </div>
        <div class="category-item">
            <div class="category-icon">🍛</div>
            <div class="category-name">Kari</div>
        </div>
        <div class="category-item">
            <div class="category-icon">🥗</div>
            <div class="category-name">Salad</div>
        </div>
        <div class="category-item">
            <div class="category-icon">🍪</div>
            <div class="category-name">Kue</div>
        </div>
        <div class="category-item">
            <div class="category-icon">🍱</div>
            <div class="category-name">Makanan Cepat</div>
        </div>
    </div>
</section>
@endif

<!-- Popular Recipes Section -->
@if(isset($latestRecipes) && $latestRecipes->count() > 0)
<section class="recipes-section">
    <div class="section-title">
        <h2>Resep Terbaru</h2>
        <p>Koleksi resep segar yang baru ditambahkan oleh komunitas kami</p>
    </div>

    <div class="recipes-grid">
        @foreach($latestRecipes as $resep)
            <div class="recipe-card">
                @if($resep->gambar)
                    <img src="{{ \Illuminate\Support\Facades\Storage::url($resep->gambar) }}" alt="{{ $resep->judul }}" class="recipe-image">
                @else
                    <div class="recipe-image" style="display: flex; align-items: center; justify-content: center; background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%); color: white;">
                        <i class="fas fa-utensils" style="font-size: 3rem;"></i>
                    </div>
                @endif

                <div class="recipe-content">
                    <h3 class="recipe-title">{{ Illuminate\Support\Str::limit($resep->judul, 50) }}</h3>
                    <p class="recipe-author">
                        <i class="fas fa-user-circle"></i> {{ $resep->user?->name ?? 'Anonim' }}
                    </p>
                    <p class="recipe-desc">{{ Illuminate\Support\Str::limit($resep->bahan, 80) }}</p>
                    <div class="recipe-footer">
                        <a href="{{ route('reseps.show', $resep) }}" class="recipe-link">
                            <span>Lihat Resep</span>
                            <i class="fas fa-arrow-right"></i>
                        </a>
                        <span class="recipe-badge">Baru</span>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    @guest
    @else
        <div style="text-align: center; margin-top: 3rem;">
            <a href="{{ route('reseps.index') }}" class="btn btn-primary">
                <i class="fas fa-eye"></i> Lihat Semua Resep
            </a>
        </div>
    @endguest
</section>
@endif

<!-- CTA Section -->
<section class="cta-section">
    <div class="cta-content">
        <h2>Siap untuk Mulai Memasak?</h2>
        <p>Bergabunglah dengan ribuan pengguna yang telah menemukan resep impian mereka di platform kami.</p>
        <div class="cta-buttons">
            @guest
                <a href="{{ route('register') }}" class="btn-cta btn-cta-primary">
                    <i class="fas fa-user-plus"></i> Daftar Sekarang
                </a>
                <a href="{{ route('login') }}" class="btn-cta btn-cta-secondary">
                    <i class="fas fa-sign-in-alt"></i> Sudah Punya Akun? Login
                </a>
            @endguest

            @auth
                <a href="{{ route('reseps.create') }}" class="btn-cta btn-cta-primary">
                    <i class="fas fa-plus-circle"></i> Buat Resep Sekarang
                </a>
                <a href="{{ route('reseps.favorites') }}" class="btn-cta btn-cta-secondary">
                    <i class="fas fa-star"></i> Lihat Favorit Saya
                </a>
            @endauth
        </div>
    </div>
</section>

<!-- Footer -->
<footer class="home-footer">
    <p>&copy; 2026 MauMasakApa. Dibuat dengan ❤️ untuk pecinta kuliner. Semua hak dilindungi.</p>
</footer>

@endsection