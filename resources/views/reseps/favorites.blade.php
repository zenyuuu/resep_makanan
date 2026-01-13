<x-app-layout>
    <link rel="stylesheet" href="{{ asset('css/reseps.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <div class="favorites-wrapper">
        <div class="container">
            <!-- Header -->
            <div class="favorites-header d-flex justify-content-between align-items-start mb-4">
                <div>
                    <h2><i class="fas fa-star"></i> Resep Favorit Saya</h2>
                    <p>Koleksi resep yang sudah kamu favoritkan</p>
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
                                {{ $resep->user?->name ?? 'Anonim' }}
                            </p>

                            <p class="favorite-description">
                                <i class="fas fa-list" style="color: #f59e0b;"></i>
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
                            <p style="color: #9ca3af; margin-top: 10px;">
                                Mulai dengan menambahkan resep favorit Anda atau 
                                <a href="{{ route('reseps.index') }}" style="color: #f59e0b; text-decoration: none; font-weight: 700;">lihat semua resep</a>
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
