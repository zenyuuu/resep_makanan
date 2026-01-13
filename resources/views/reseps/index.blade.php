<x-app-layout>
    <link rel="stylesheet" href="{{ asset('css/reseps.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <div class="reseps-wrapper">
        <div class="container">
            <!-- Header -->
            <div class="reseps-header d-flex justify-content-between align-items-start mb-4">
                <div>
                    <h2><i class="fas fa-utensils"></i> Daftar Resep</h2>
                    <p>Jelajahi koleksi resep lezat dari komunitas kami</p>
                </div>
                @auth
                    <a href="{{ route('reseps.create') }}" class="btn-tambah">
                        <i class="fas fa-plus-circle"></i> Tambah Resep
                    </a>
                @endauth
            </div>

            <!-- Search -->
            <div class="search-wrapper">
                <form action="{{ route('reseps.index') }}" method="GET">
                    <input type="text" name="search" placeholder="Cari resep berdasarkan nama..." value="{{ request('search') }}">
                    <button type="submit" class="btn-search">
                        <i class="fas fa-search"></i> Cari
                    </button>
                </form>
            </div>

            <!-- Reseps Grid -->
            <div class="reseps-grid">
                @forelse ($reseps as $resep)
                    <div class="resep-card">
                        <!-- Image -->
                        <div class="resep-image">
                            @if ($resep->gambar)
                                <img src="{{ Storage::url($resep->gambar) }}" alt="{{ $resep->judul }}">
                            @else
                                <img src="https://via.placeholder.com/300x200?text=No+Image" alt="Tidak ada gambar">
                            @endif

                            <!-- Favorite Star -->
                            @auth
                                <form action="{{ route('reseps.favorite', $resep) }}" method="POST" class="d-inline" style="position: absolute; top: 0; right: 0;">
                                    @csrf
                                    <button type="submit" class="star-favorite-btn {{ $resep->isFavoritedBy(auth()->user()) ? '' : 'empty' }}" title="{{ $resep->isFavoritedBy(auth()->user()) ? 'Hapus dari favorit' : 'Tambah ke favorit' }}">
                                        <i class="fas fa-star"></i>
                                    </button>
                                </form>
                            @endauth
                        </div>

                        <!-- Content -->
                        <div class="resep-content">
                            <h3 class="resep-title">{{ $resep->judul }}</h3>
                            
                            <p class="resep-author">
                                <i class="fas fa-user-circle"></i>
                                {{ $resep->user?->name ?? 'Anonim' }}
                            </p>

                            <p class="resep-description">
                                <i class="fas fa-list" style="color: #f59e0b;"></i>
                                {{ Illuminate\Support\Str::limit($resep->bahan, 100) }}
                            </p>

                            <!-- Actions -->
                            <div class="resep-actions">
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
                            <i class="fas fa-inbox"></i>
                            <h3>Belum ada resep</h3>
                            <p style="color: #999; margin-top: 10px;">Mulai dengan membuat resep pertama Anda atau cari resep dari pengguna lain</p>
                        </div>
                    </div>
                @endforelse
            </div>

            <!-- Pagination -->
            <div class="pagination">
                {{ $reseps->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
