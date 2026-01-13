<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="MauMasakApa - Platform resep makanan terbaik untuk menemukan inspirasi kuliner">
    <title>MauMasakApa - Temukan Resep Impian Anda</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/home.css') }}">
    <style>
        .welcome-nav {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            padding: 1rem 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            color: white;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        .welcome-nav .logo {
            font-size: 1.8rem;
            font-weight: 800;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .welcome-nav .nav-links {
            display: flex;
            gap: 1.5rem;
            align-items: center;
        }

        .welcome-nav a {
            color: white;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s ease;
            padding: 0.5rem 1rem;
            border-radius: 6px;
        }

        .welcome-nav a:hover {
            background: rgba(255, 255, 255, 0.2);
            transform: translateY(-2px);
        }

        .welcome-nav .btn-login {
            background: white;
            color: #667eea;
            padding: 0.6rem 1.2rem;
            border-radius: 6px;
        }

        .welcome-nav .btn-login:hover {
            background: rgba(255, 255, 255, 0.9);
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
        }

        @media (max-width: 768px) {
            .welcome-nav {
                flex-direction: column;
                gap: 1rem;
            }

            .welcome-nav .nav-links {
                flex-direction: column;
                width: 100%;
                text-align: center;
            }

            .welcome-nav a {
                display: block;
                width: 100%;
            }

            .welcome-nav .btn-login {
                width: 100%;
                text-align: center;
            }
        }
    </style>
</head>
<body>
    <!-- Navigation -->
    <nav class="welcome-nav">
        <div class="logo">
            <i class="fas fa-utensils"></i>
            MauMasakApa
        </div>
        <div class="nav-links">
            <a href="#features"><i class="fas fa-star"></i> Fitur</a>
            <a href="#about"><i class="fas fa-info-circle"></i> Tentang</a>
            <a href="{{ route('login') }}" class="btn-login">
                <i class="fas fa-sign-in-alt"></i> Login
            </a>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero-section">
        <div class="hero-content">
            <h1><span class="highlight">MauMasakApa?</span> Kami Punya Jawabannya!</h1>
            <p>Platform resep makanan terlengkap dengan ribuan pilihan. Jelajahi, belajar, dan bagikan resep favorit Anda bersama komunitas global.</p>
            <div class="hero-buttons">
                <a href="{{ route('register') }}" class="btn btn-primary">
                    <i class="fas fa-user-plus"></i> Daftar Sekarang - Gratis!
                </a>
                <a href="{{ route('login') }}" class="btn btn-secondary">
                    <i class="fas fa-sign-in-alt"></i> Sudah Punya Akun
                </a>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="features-section" id="features">
        <div class="section-title">
            <h2>Fitur MauMasakApa</h2>
            <p>Semua yang Anda butuhkan untuk menjadi master chef</p>
        </div>

        <div class="features-grid">
            <div class="feature-card">
                <div class="feature-icon">🔍</div>
                <h3>Database Resep Lengkap</h3>
                <p>Lebih dari 10.000 resep dari berbagai belahan dunia. Cari berdasarkan bahan, waktu, atau tingkat kesulitan.</p>
            </div>

            <div class="feature-card">
                <div class="feature-icon">👨‍🍳</div>
                <h3>Komunitas Chef Profesional</h3>
                <p>Belajar dari chef berpengalaman dan bagikan kreasi kuliner Anda dengan jutaan pengguna aktif.</p>
            </div>

            <div class="feature-card">
                <div class="feature-icon">❤️</div>
                <h3>Koleksi Favorit Personal</h3>
                <p>Simpan resep pilihan Anda dalam satu tempat. Akses kapan saja, di mana saja, dan di semua perangkat.</p>
            </div>

            <div class="feature-card">
                <div class="feature-icon">📱</div>
                <h3>Akses Mobile & Desktop</h3>
                <p>Buka di smartphone, tablet, atau komputer. Sinkronisasi otomatis memastikan data Anda selalu terbaru.</p>
            </div>

            <div class="feature-card">
                <div class="feature-icon">💡</div>
                <h3>Tips & Trik Memasak</h3>
                <p>Dapatkan saran ahli untuk menghemat waktu, biaya, dan meningkatkan kualitas hidangan Anda.</p>
            </div>

            <div class="feature-card">
                <div class="feature-icon">🏆</div>
                <h3>Rating & Review</h3>
                <p>Baca ulasan dari pengguna lain dan bagikan pengalaman Anda. Temukan resep terbaik dengan mudah.</p>
            </div>
        </div>
    </section>

    <!-- Stats Section -->
    <section class="stats-section">
        <div class="stats-grid">
            <div class="stat-item">
                <div class="stat-number">10K+</div>
                <div class="stat-label">Resep Tersedia</div>
            </div>
            <div class="stat-item">
                <div class="stat-number">50K+</div>
                <div class="stat-label">Pengguna Aktif</div>
            </div>
            <div class="stat-item">
                <div class="stat-number">100K+</div>
                <div class="stat-label">Rating Positif</div>
            </div>
            <div class="stat-item">
                <div class="stat-number">24/7</div>
                <div class="stat-label">Support Team</div>
            </div>
        </div>
    </section>

    <!-- About Section -->
    <section class="features-section" id="about">
        <div class="section-title">
            <h2>Tentang MauMasakApa</h2>
            <p>Misi kami adalah membuat memasak mudah, menyenangkan, dan dapat diakses oleh semua orang</p>
        </div>

        <div style="max-width: 1000px; margin: 0 auto; background: white; padding: 2rem; border-radius: 12px; box-shadow: 0 8px 24px rgba(0, 0, 0, 0.1);">
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 2rem;">
                <div>
                    <h3 style="color: #667eea; font-size: 1.3rem; margin-bottom: 1rem;">🎯 Misi Kami</h3>
                    <p style="color: #666; line-height: 1.6;">Memberdayakan setiap orang untuk memasak makanan lezat dan sehat dengan menyediakan akses ke resep berkualitas tinggi dan komunitas yang mendukung.</p>
                </div>
                <div>
                    <h3 style="color: #667eea; font-size: 1.3rem; margin-bottom: 1rem;">🌟 Visi Kami</h3>
                    <p style="color: #666; line-height: 1.6;">Menjadi platform resep terpercaya di Asia dengan teknologi terdepan dan komunitas pengguna terbesar yang saling berbagi passion kuliner.</p>
                </div>
                <div>
                    <h3 style="color: #667eea; font-size: 1.3rem; margin-bottom: 1rem;">💪 Komitmen Kami</h3>
                    <p style="color: #666; line-height: 1.6;">Terus berinovasi dan memberikan pengalaman terbaik kepada pengguna dengan dukungan customer yang responsif dan fitur yang user-friendly.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="cta-section">
        <div class="cta-content">
            <h2>Mulai Petualangan Kuliner Anda Hari Ini!</h2>
            <p>Bergabunglah dengan puluhan ribu pengguna yang telah menemukan passion memasak mereka di MauMasakApa.</p>
            <div class="cta-buttons">
                <a href="{{ route('register') }}" class="btn-cta btn-cta-primary">
                    <i class="fas fa-user-plus"></i> Daftar Gratis Sekarang
                </a>
                <a href="{{ route('login') }}" class="btn-cta btn-cta-secondary">
                    <i class="fas fa-sign-in-alt"></i> Login
                </a>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="home-footer">
        <div style="max-width: 1200px; margin: 0 auto; padding: 0 2rem;">
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 2rem; margin-bottom: 2rem; text-align: left;">
                <div>
                    <h4 style="margin-bottom: 1rem; color: #ffc107;"><i class="fas fa-utensils"></i> MauMasakApa</h4>
                    <p>Platform resep online terlengkap untuk mengeksplorasi, belajar, dan berbagi resep dengan komunitas global.</p>
                </div>
                <div>
                    <h4 style="margin-bottom: 1rem;">Menu</h4>
                    <p><a href="{{ route('register') }}" style="color: #ddd; text-decoration: none;">Daftar</a></p>
                    <p><a href="{{ route('login') }}" style="color: #ddd; text-decoration: none;">Login</a></p>
                </div>
                <div>
                    <h4 style="margin-bottom: 1rem;">Hubungi Kami yach</h4>
                    <p><i class="fas fa-envelope"></i> Iyah@maumasakapa.com</p>
                    <p><i class="fas fa-phone"></i> +62 821 1234 5678</p>
                </div>
            </div>
            <div style="border-top: 1px solid rgba(255, 255, 255, 0.2); padding-top: 2rem; text-align: center;">
                <p>&copy; 2026 MauMasakApa. Semua hak dilindungi. | Dibuat dengan ❤️ untuk pecinta kuliner</p>
            </div>
        </div>
    </footer>
</body>
</html>
