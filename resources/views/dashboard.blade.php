<x-app-layout>
    @push('styles')
        <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    @endpush

    <div class="dashboard-wrapper">
        <div class="dashboard-container">
            <!-- Sidebar Navigation -->
            <aside class="dashboard-sidebar">
                <h3><i class="fas fa-bars"></i> Menu</h3>
                <nav class="sidebar-nav">
                    <button type="button" onclick="window.location='{{ route('home') }}'" class="sidebar-nav-item">
                        <i class="fas fa-home"></i>
                        <span>Home</span>
                    </button>
                    <button type="button" onclick="window.location='{{ route('reseps.index') }}'" class="sidebar-nav-item">
                        <i class="fas fa-book"></i>
                        <span>Daftar Resep</span>
                    </button>
                    <button type="button" onclick="window.location='{{ route('reseps.favorites') }}'" class="sidebar-nav-item">
                        <i class="fas fa-star"></i>
                        <span>Favorit Saya</span>
                    </button>
                    <button type="button" onclick="window.location='{{ route('reseps.create') }}'" class="sidebar-nav-item">
                        <i class="fas fa-plus-circle"></i>
                        <span>Tambah Resep</span>
                    </button>
                    <button type="button" onclick="window.location='{{ route('profile.edit') }}'" class="sidebar-nav-item">
                        <i class="fas fa-user-circle"></i>
                        <span>Profile</span>
                    </button>
                    <form method="POST" action="{{ route('logout') }}" style="margin: 0;">
                        @csrf
                        <button type="submit" class="sidebar-nav-item logout">
                            <i class="fas fa-sign-out-alt"></i>
                            <span>Logout</span>
                        </button>
                    </form>
                </nav>
            </aside>

            <!-- Main Content -->
            <main class="dashboard-main">
                <!-- Welcome Card -->
                <div class="card welcome-card">
                    <div class="dashboard-header">
                        <div class="dashboard-header-left">
                            <h2>Selamat Datang, {{ auth()->user()->name }}! 👋</h2>
                            <p>Kelola resep Anda dan temukan inspirasi kuliner yang menakjubkan</p>
                        </div>
                        <div class="dashboard-header-right">
                            <button type="button" onclick="window.location='{{ route('reseps.create') }}'" class="btn-header btn-primary">
                                <i class="fas fa-plus"></i> Buat Resep
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Stats Section -->
                <div class="dashboard-stats">
                    <div class="stat-box">
                        <p class="stat-number">{{ auth()->user()->reseps()->count() ?? 0 }}</p>
                        <p class="stat-label">Resep Saya</p>
                    </div>
                    <div class="stat-box">
                        <p class="stat-number">{{ auth()->user()->favorites()->count() ?? 0 }}</p>
                        <p class="stat-label">Favorit</p>
                    </div>
                    <div class="stat-box">
                        <p class="stat-number">5</p>
                        <p class="stat-label">Rating</p>
                    </div>
                </div>

                <!-- Content Cards -->
                <div class="dashboard-cards">
                    <!-- Card 1: My Recipes -->
                    <div class="card">
                        <div class="card-icon">
                            <i class="fas fa-utensils"></i>
                        </div>
                        <h3>Resep Saya</h3>
                        <p>Kelola semua resep yang telah Anda buat. Tambah, edit, atau hapus resep sesuai kebutuhan.</p>
                        <div class="card-footer">
                            <a href="{{ route('reseps.index') }}" class="card-link">
                                <span>Lihat Semua</span>
                                <i class="fas fa-arrow-right"></i>
                            </a>
                            <span class="card-badge">{{ auth()->user()->reseps()->count() ?? 0 }}</span>
                        </div>
                    </div>

                    <!-- Card 2: My Favorites -->
                    <div class="card">
                        <div class="card-icon" style="background: linear-gradient(135deg, #ffd700 0%, #ffed4e 100%);">
                            <i class="fas fa-star"></i>
                        </div>
                        <h3>Favorit Saya</h3>
                        <p>Kumpulkan resep-resep favorit Anda dari seluruh koleksi yang tersedia.</p>
                        <div class="card-footer">
                            <a href="{{ route('reseps.favorites') }}" class="card-link">
                                <span>Lihat Favorit</span>
                                <i class="fas fa-arrow-right"></i>
                            </a>
                            <span class="card-badge" style="background: #ffd700; color: #333;">{{ auth()->user()->favorites()->count() ?? 0 }}</span>
                        </div>
                    </div>

                    <!-- Card 3: Profile -->
                    <div class="card">
                        <div class="card-icon" style="background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);">
                            <i class="fas fa-user"></i>
                        </div>
                        <h3>Profile Saya</h3>
                        <p>Perbarui informasi profil, email, dan password akun Anda di sini.</p>
                        <div class="card-footer">
                            <a href="{{ route('profile.edit') }}" class="card-link">
                                <span>Edit Profile</span>
                                <i class="fas fa-arrow-right"></i>
                            </a>
                            <span class="card-badge" style="background: #00f2fe; color: #333;">Atur</span>
                        </div>
                    </div>

                    <!-- Card 4: Explore -->
                    <div class="card">
                        <div class="card-icon" style="background: linear-gradient(135deg, #fa709a 0%, #fee140 100%);">
                            <i class="fas fa-search"></i>
                        </div>
                        <h3>Jelajahi Resep</h3>
                        <p>Temukan dan jelajahi berbagai resep menarik dari pengguna lain.</p>
                        <div class="card-footer">
                            <a href="{{ route('reseps.index') }}" class="card-link">
                                <span>Cari Resep</span>
                                <i class="fas fa-arrow-right"></i>
                            </a>
                            <span class="card-badge" style="background: #fee140; color: #333;">Baru</span>
                        </div>
                    </div>

                    <!-- Card 5: Quick Tips -->
                    <div class="card">
                        <div class="card-icon" style="background: linear-gradient(135deg, #a8edea 0%, #fed6e3 100%);">
                            <i class="fas fa-lightbulb"></i>
                        </div>
                        <h3>Tips & Trik</h3>
                        <p>Dapatkan tips menarik untuk memasak yang lebih baik dan hasil yang lebih maksimal.</p>
                        <div class="card-footer">
                            <a href="{{ route('home') }}" class="card-link">
                                <span>Baca Tips</span>
                                <i class="fas fa-arrow-right"></i>
                            </a>
                            <span class="card-badge" style="background: #fed6e3; color: #333;">Hot</span>
                        </div>
                    </div>

                    <!-- Card 6: Help & Support -->
                    <div class="card">
                        <div class="card-icon" style="background: linear-gradient(135deg, #ffecd2 0%, #fcb69f 100%);">
                            <i class="fas fa-question-circle"></i>
                        </div>
                        <h3>Bantuan & Dukungan</h3>
                        <p>Butuh bantuan? Hubungi tim support kami untuk menjawab pertanyaan Anda.</p>
                        <div class="card-footer">
                            <a href="#" class="card-link">
                                <span>Hubungi Kami</span>
                                <i class="fas fa-arrow-right"></i>
                            </a>
                            <span class="card-badge" style="background: #fcb69f; color: #333;">Help</span>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>
</x-app-layout>
