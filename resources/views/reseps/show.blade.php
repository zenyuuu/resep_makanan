@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">{{ $resep->judul }}</h1>

    <p><strong>Ditambahkan oleh:</strong> {{ $resep->user->name ?? 'Anonim' }}</p>

    @if ($resep->gambar)
        <div class="mb-4">
            <img src="{{ asset('storage/' . $resep->gambar) }}" width="300" class="img-fluid rounded">
        </div>
    @endif

    <div class="mb-3">
        <h5>Bahan-bahan:</h5>
        <p>{{ $resep->bahan }}</p>
    </div>

    <div class="mb-3">
        <h5>Langkah-langkah:</h5>
        <p>{{ $resep->langkah }}</p>
    </div>

    <a href="{{ route('reseps.index') }}" class="btn btn-secondary">Kembali ke Daftar</a>
    <a href="{{ route('reseps.edit', $resep->id) }}" class="btn btn-warning">Edit Resep</a>
@endsection
