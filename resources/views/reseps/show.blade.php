@extends('layouts.app')

@section('content')
<style>
    .show-resep-wrapper {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        min-height: calc(100vh - 70px);
        padding: 40px 0;
    }

    .show-resep-container {
        max-width: 900px;
        margin: 0 auto;
    }

    .resep-header {
        background: white;
        border-radius: 12px;
        padding: 40px;
        margin-bottom: 30px;
        box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
    }

    .resep-title {
        font-size: 2.5rem;
        font-weight: 700;
        color: #333;
        margin: 0 0 15px 0;
    }

    .resep-meta {
        display: flex;
        align-items: center;
        gap: 15px;
        font-size: 0.95rem;
        color: #666;
        flex-wrap: wrap;
    }

    .resep-meta i {
        color: #667eea;
        font-size: 1.1rem;
    }

    .resep-image-section {
        background: white;
        border-radius: 12px;
        padding: 30px;
        margin-bottom: 30px;
        box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
        text-align: center;
    }

    .resep-image {
        width: 100%;
        max-width: 500px;
        height: auto;
        border-radius: 12px;
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
        display: block;
        margin: 0 auto;
    }

    .resep-content {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 30px;
        margin-bottom: 30px;
    }

    .content-section {
        background: white;
        border-radius: 12px;
        padding: 30px;
        box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
    }

    .section-title {
        display: flex;
        align-items: center;
        font-size: 1.3rem;
        font-weight: 700;
        color: #333;
        margin: 0 0 20px 0;
        padding-bottom: 15px;
        border-bottom: 2px solid #667eea;
    }

    .section-title i {
        margin-right: 10px;
        color: #667eea;
        font-size: 1.4rem;
    }

    .section-content {
        color: #555;
        line-height: 1.8;
        font-size: 0.95rem;
        white-space: pre-wrap;
        word-wrap: break-word;
    }

    .action-buttons {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(140px, 1fr));
        gap: 15px;
        background: white;
        border-radius: 12px;
        padding: 30px;
        box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
    }

    .action-btn {
        padding: 12px 20px;
        border: none;
        border-radius: 8px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        text-decoration: none;
        font-size: 0.9rem;
    }

    .btn-kembali {
        background: #f0f0f0;
        color: #333;
    }

    .btn-kembali:hover {
        background: #333;
        color: white;
        transform: translateY(-2px);
    }

    .btn-edit {
        background: #fff4e6;
        color: #ff9900;
    }

    .btn-edit:hover {
        background: #ff9900;
        color: white;
        transform: translateY(-2px);
    }

    .btn-hapus {
        background: #ffe7e7;
        color: #dc3545;
    }

    .btn-hapus:hover {
        background: #dc3545;
        color: white;
        transform: translateY(-2px);
    }

    .show-star-favorite-btn {
        background: white;
        border: 2px solid #ffd700;
        color: #ffd700;
        padding: 12px 20px;
        border-radius: 8px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        font-size: 0.9rem;
    }

    .show-star-favorite-btn:hover {
        background: #ffd700;
        color: white;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(255, 215, 0, 0.3);
    }

    .show-star-favorite-btn i {
        font-size: 1.1rem;
    }

    @media (max-width: 768px) {
        .resep-content {
            grid-template-columns: 1fr;
            gap: 20px;
        }

        .resep-title {
            font-size: 1.8rem;
        }

        .resep-header {
            padding: 25px;
        }

        .content-section {
            padding: 20px;
        }

        .action-buttons {
            grid-template-columns: repeat(2, 1fr);
        }
    }
</style>

<div class="show-resep-wrapper">
    <div class="show-resep-container">
        <!-- Header -->
        <div class="resep-header">
            <h1 class="resep-title">{{ $resep->judul }}</h1>
            <div class="resep-meta">
                <i class="fas fa-user-circle"></i>
                <span>Ditambahkan oleh <strong>{{ $resep->user->name ?? 'Anonim' }}</strong></span>
            </div>
        </div>

        <!-- Image -->
        @if ($resep->gambar)
            <div class="resep-image-section">
                <img src="{{ Storage::url($resep->gambar) }}" alt="{{ $resep->judul }}" class="resep-image">
            </div>
        @endif

        <!-- Content -->
        <div class="resep-content">
            <!-- Bahan -->
            <div class="content-section">
                <h2 class="section-title">
                    <i class="fas fa-list-ul"></i> Bahan-bahan
                </h2>
                <div class="section-content">{!! nl2br(e($resep->bahan)) !!}</div>
            </div>

            <!-- Langkah -->
            <div class="content-section">
                <h2 class="section-title">
                    <i class="fas fa-tasks"></i> Langkah-langkah
                </h2>
                <div class="section-content">{!! nl2br(e($resep->langkah)) !!}</div>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="action-buttons">
            <a href="{{ route('reseps.index') }}" class="action-btn btn-kembali">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>

            @can('update', $resep)
                <a href="{{ route('reseps.edit', $resep) }}" class="action-btn btn-edit">
                    <i class="fas fa-edit"></i> Edit
                </a>
            @endcan

            @can('delete', $resep)
                <form action="{{ route('reseps.destroy', $resep) }}" method="POST" class="d-inline" style="width: 100%;" onsubmit="return confirm('Yakin ingin menghapus resep ini?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="action-btn btn-hapus" style="width: 100%; margin: 0;">
                        <i class="fas fa-trash"></i> Hapus
                    </button>
                </form>
            @endcan

            @auth
                <form action="{{ route('reseps.favorite', $resep) }}" method="POST" class="d-inline" style="width: 100%;">
                    @csrf
                    <button type="submit" class="show-star-favorite-btn">
                        <i class="fas fa-star"></i>
                        {{ $resep->isFavoritedBy(auth()->user()) ? 'Di Favorit' : 'Tambah Favorit' }}
                    </button>
                </form>
            @endauth
        </div>
    </div>
</div>
@endsection