@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">Edit Resep: {{ $resep->judul }}</h1>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('reseps.update', $resep->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="judul" class="form-label">Judul Resep</label>
            <input type="text" class="form-control" id="judul" name="judul" value="{{ old('judul', $resep->judul) }}" required>
        </div>

        <div class="mb-3">
            <label for="bahan" class="form-label">Bahan-bahan</label>
            <textarea class="form-control" id="bahan" name="bahan" rows="4" required>{{ old('bahan', $resep->bahan) }}</textarea>
        </div>

        <div class="mb-3">
            <label for="langkah" class="form-label">Langkah-langkah</label>
            <textarea class="form-control" id="langkah" name="langkah" rows="5" required>{{ old('langkah', $resep->langkah) }}</textarea>
        </div>

        <div class="mb-3">
            <label for="gambar" class="form-label">Ganti Gambar</label><br>
            @if ($resep->gambar)
                <img src="{{ Storage::url($resep->gambar) }}" width="120" class="mb-2 d-block">
            @endif
            <input type="file" class="form-control" id="gambar" name="gambar" accept="image/*">
        </div>

        <button type="submit" class="btn btn-primary">Update</button>
        <a href="{{ route('reseps.index') }}" class="btn btn-secondary">Batal</a>
    </form>
</div>
@endsection