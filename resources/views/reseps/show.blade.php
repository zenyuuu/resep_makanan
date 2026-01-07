@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="card">
        <div class="card-body">
            <h1 class="card-title mb-2">{{ $resep->judul }}</h1>
            <p class="text-muted mb-3">Ditambahkan oleh: {{ $resep->user->name ?? 'Anonim' }}</p>

            @if ($resep->gambar)
                <div class="mb-3">
                    <img src="{{ Storage::url($resep->gambar) }}" class="img-fluid rounded" style="max-width:400px;">
                </div>
            @endif

            <div class="mb-3">
                <h5><strong>Bahan-bahan:</strong></h5>
                <p>{!! nl2br(e($resep->bahan)) !!}</p>
            </div>

            <div class="mb-3">
                <h5><strong>Langkah-langkah:</strong></h5>
                <p>{!! nl2br(e($resep->langkah)) !!}</p>
            </div>

            <a href="{{ route('reseps.index') }}" class="btn btn-secondary">Kembali</a>

            @can('update', $resep)
                <a href="{{ route('reseps.edit', $resep) }}" class="btn btn-warning">Edit</a>
            @endcan

            @can('delete', $resep)
                <form action="{{ route('reseps.destroy', $resep) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus resep ini?');">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-danger">Hapus</button>
                </form>
            @endcan
        </div>
    </div>
</div>
@endsection