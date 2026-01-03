@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">Daftar Resep</h1>

    <a href="{{ route('reseps.create') }}" class="btn btn-primary mb-4">+ Tambah Resep</a>

    <div class="row">
        @forelse ($reseps as $resep)
            <div class="col-md-4 mb-4">
                <div class="card h-100">
                    @if ($resep->gambar)
                        <img src="{{ asset('storage/' . $resep->gambar) }}" class="card-img-top" alt="{{ $resep->judul }}">
                    @else
                        <img src="https://via.placeholder.com/300x200?text=No+Image" class="card-img-top" alt="Tidak ada gambar">
                    @endif
                    <div class="card-body">
                        <h5 class="card-title">{{ $resep->judul }}</h5>
                        <p class="card-text"><small>Oleh: {{ $resep->user->name ?? 'Anonim' }}</small></p>
                    </div>
                    <div class="card-footer text-center">
                        <a href="{{ route('reseps.show', $resep->id) }}" class="btn btn-sm btn-info">Lihat</a>
                        <a href="{{ route('reseps.edit', $resep->id) }}" class="btn btn-sm btn-warning">Edit</a>
                        <form action="{{ route('reseps.destroy', $resep->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin hapus?')">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-danger">Hapus</button>
                        </form>
                    </div>
                </div>
            </div>
        @empty
            <p class="text-center">Belum ada resep yang ditambahkan.</p>
        @endforelse
    </div>
</div>
@endsection