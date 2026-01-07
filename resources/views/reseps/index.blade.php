@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>Daftar Resep</h2>
        @auth
            <a href="{{ route('reseps.create') }}" class="btn btn-primary">+ Tambah Resep</a>
        @endauth
    </div>

    <div class="row">
        @forelse ($reseps as $resep)
            <div class="col-md-4 mb-4">
                <div class="card h-100">
                    @if ($resep->gambar)
                        <img src="{{ Storage::url($resep->gambar) }}" class="card-img-top" style="height:200px;object-fit:cover;">
                    @else
                        <img src="https://via.placeholder.com/300x200?text=No+Image" class="card-img-top" alt="Tidak ada gambar">
                    @endif
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title">{{ $resep->judul }}</h5>
                        <p class="text-muted small mb-2">{{ $resep->user->name ?? 'Anonim' }}</p>
                        <p class="card-text">{{ Illuminate\Support\Str::limit($resep->bahan, 120) }}</p>
                        <div class="mt-auto">
                            <a href="{{ route('reseps.show', $resep) }}" class="btn btn-sm btn-outline-primary">Lihat</a>

                            @can('update', $resep)
                                <a href="{{ route('reseps.edit', $resep) }}" class="btn btn-sm btn-warning">Edit</a>
                            @endcan

                            @can('delete', $resep)
                                <form action="{{ route('reseps.destroy', $resep) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus resep ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-danger">Hapus</button>
                                </form>
                            @endcan
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="alert alert-info">Belum ada resep yang ditambahkan.</div>
            </div>
        @endforelse
    </div>

    <div class="d-flex justify-content-center mt-4">
        {{ $reseps->links() }}
    </div>
</div>
@endsection