<x-app-layout>
    <style>
        .favorites-wrapper {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: calc(100vh - 70px);
            padding: 40px 0;
        }

        .favorites-header {
            margin-bottom: 40px;
            color: white;
        }

        .favorites-header h2 {
            font-size: 2.5rem;
            font-weight: 700;
            margin: 0 0 10px 0;
        }

        .favorites-header p {
            margin: 0;
            opacity: 0.9;
            font-size: 1rem;
        }

        .search-wrapper {
            margin-bottom: 40px;
        }

        .search-wrapper form {
            display: flex;
            gap: 10px;
            align-items: center;
        }

        .search-wrapper input {
            flex: 1;
            padding: 12px 20px;
            border: 2px solid white;
            border-radius: 50px;
            font-size: 0.95rem;
            background: white;
        }

        .search-wrapper input:focus {
            outline: none;
            box-shadow: 0 0 0 3px rgba(255, 255, 255, 0.3);
        }

        .btn-search {
            background: white;
            color: #667eea;
            border: none;
            padding: 12px 30px;
            border-radius: 50px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .btn-search:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
        }

        .btn-kembali-fav {
            background: white;
            color: #667eea;
            border: none;
            padding: 12px 30px;
            border-radius: 8px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            font-size: 0.95rem;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            text-decoration: none;
        }

        .btn-kembali-fav:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
            color: #667eea;
        }

        .favorites-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            gap: 25px;
            margin-bottom: 40px;
        }

        .favorite-card {
            background: white;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
            display: flex;
            flex-direction: column;
        }

        .favorite-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 12px 30px rgba(0, 0, 0, 0.15);
        }

        .favorite-image {
            position: relative;
            width: 100%;
            height: 200px;
            overflow: hidden;
            background: #f0f0f0;
        }

        .favorite-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.3s ease;
        }

        .favorite-card:hover .favorite-image img {
            transform: scale(1.05);
        }

        .star-favorite-btn-list {
            position: absolute;
            top: 15px;
            right: 15px;
            background: transparent;
            border: none;
            cursor: pointer;
            padding: 0;
            margin: 0;
            font-size: 2rem;
            color: #ffd700;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
            transition: all 0.3s ease;
            z-index: 10;
        }

        .star-favorite-btn-list:hover {
            transform: scale(1.2) rotate(20deg);
            filter: brightness(1.2);
        }

        .favorite-content {
            padding: 20px;
            flex: 1;
            display: flex;
            flex-direction: column;
        }

        .favorite-title {
            font-size: 1.1rem;
            font-weight: 700;
            color: #333;
            margin: 0 0 8px 0;
            line-height: 1.4;
        }

        .favorite-author {
            font-size: 0.85rem;
            color: #999;
            margin: 0 0 12px 0;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .favorite-author i {
            color: #667eea;
        }

        .favorite-description {
            font-size: 0.85rem;
            color: #666;
            line-height: 1.5;
            margin: 0 0 15px 0;
            flex: 1;
        }

        .favorite-actions {
            display: flex;
            gap: 8px;
            margin-top: auto;
            flex-wrap: wrap;
        }

        .action-btn {
            flex: 1;
            min-width: 70px;
            padding: 8px 10px;
            border: none;
            border-radius: 6px;
            font-size: 0.8rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 4px;
            text-decoration: none;
        }

        .btn-lihat {
            background: #e7f5ff;
            color: #0066cc;
        }

        .btn-lihat:hover {
            background: #0066cc;
            color: white;
        }

        .btn-edit {
            background: #fff4e6;
            color: #ff9900;
        }

        .btn-edit:hover {
            background: #ff9900;
            color: white;
        }

        .btn-hapus {
            background: #ffe7e7;
            color: #dc3545;
        }

        .btn-hapus:hover {
            background: #dc3545;
            color: white;
        }

        .empty-state {
            background: white;
            border-radius: 12px;
            padding: 60px 30px;
            text-align: center;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }

        .empty-state i {
            font-size: 4rem;
            color: #ddd;
            margin-bottom: 20px;
        }

        .empty-state h3 {
            color: #666;
            font-weight: 600;
        }

        .empty-state a {
            color: #667eea;
            text-decoration: none;
            font-weight: 600;
        }

        .pagination {
            justify-content: center;
            margin-top: 40px;
        }
    </style>

    <div class="favorites-wrapper">
        <div class="container">
            <!-- Header -->
            <div class="favorites-header d-flex justify-content-between align-items-start mb-4">
                <div>
                    <h2><i class="fas fa-star"></i> Resep Favorit Saya</h2>
                    <p>Koleksi resep pilihan Anda</p>
                </div>
                <a href="{{ route('reseps.index') }}" class="btn-kembali-fav">
                    <i class="fas fa-arrow-left"></i> Kembali
                </a>
            </div>

            <!-- Search -->
            <div class="search-wrapper">
                <form action="{{ route('reseps.favorites') }}" method="GET">
                    <input type="text" name="search" placeholder="Cari resep favorit..." value="{{ request('search') }}">
                    <button type="submit" class="btn-search">
                        <i class="fas fa-search"></i> Cari
                    </button>
                </form>
            </div>

            <!-- Favorites Grid -->
            <div class="favorites-grid">
                @forelse ($favorites as $resep)
                    <div class="favorite-card">
                        <!-- Image -->
                        <div class="favorite-image">
                            @if ($resep->gambar)
                                <img src="{{ Storage::url($resep->gambar) }}" alt="{{ $resep->judul }}">
                            @else
                                <img src="https://via.placeholder.com/300x200?text=No+Image" alt="Tidak ada gambar">
                            @endif

                            <!-- Remove Favorite Button -->
                            <form action="{{ route('reseps.favorite', $resep) }}" method="POST" class="d-inline" style="position: absolute; top: 0; right: 0;">
                                @csrf
                                <button type="submit" class="star-favorite-btn-list" title="Hapus dari favorit">
                                    <i class="fas fa-star"></i>
                                </button>
                            </form>
                        </div>

                        <!-- Content -->
                        <div class="favorite-content">
                            <h3 class="favorite-title">{{ $resep->judul }}</h3>
                            
                            <p class="favorite-author">
                                <i class="fas fa-user-circle"></i>
                                {{ $resep->user->name ?? 'Anonim' }}
                            </p>

                            <p class="favorite-description">
                                <i class="fas fa-list" style="color: #667eea;"></i>
                                {{ Illuminate\Support\Str::limit($resep->bahan, 100) }}
                            </p>

                            <!-- Actions -->
                            <div class="favorite-actions">
                                <a href="{{ route('reseps.show', $resep) }}" class="action-btn btn-lihat">
                                    <i class="fas fa-eye"></i> Lihat
                                </a>

                                @can('update', $resep)
                                    <a href="{{ route('reseps.edit', $resep) }}" class="action-btn btn-edit">
                                        <i class="fas fa-edit"></i> Edit
                                    </a>
                                @endcan

                                @can('delete', $resep)
                                    <form action="{{ route('reseps.destroy', $resep) }}" method="POST" class="d-inline" style="flex: 1; min-width: 70px;" onsubmit="return confirm('Yakin ingin menghapus resep ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="action-btn btn-hapus" style="width: 100%; margin: 0;">
                                            <i class="fas fa-trash"></i> Hapus
                                        </button>
                                    </form>
                                @endcan
                            </div>
                        </div>
                    </div>
                @empty
                    <div style="grid-column: 1 / -1;">
                        <div class="empty-state">
                            <i class="fas fa-star"></i>
                            <h3>Belum ada resep favorit</h3>
                            <p style="color: #999; margin-top: 10px;">
                                Mulai dengan menambahkan resep favorit Anda atau 
                                <a href="{{ route('reseps.index') }}">lihat semua resep</a>
                            </p>
                        </div>
                    </div>
                @endforelse
            </div>

            <!-- Pagination -->
            <div class="pagination">
                {{ $favorites->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
