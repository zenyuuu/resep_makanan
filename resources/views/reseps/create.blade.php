@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">Tambah Resep Baru</h1>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('reseps.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="mb-3">
            <label for="judul" class="form-label">Judul Resep</label>
            <input type="text" class="form-control" id="judul" name="judul" value="{{ old('judul') }}" required>
        </div>

        <div class="mb-3">
            <label for="bahan" class="form-label">Bahan-bahan</label>
            <textarea class="form-control" id="bahan" name="bahan" rows="4" required>{{ old('bahan') }}</textarea>
        </div>

        <div class="mb-3">
            <label for="langkah" class="form-label">Langkah-langkah</label>
            <textarea class="form-control" id="langkah" name="langkah" rows="5" required>{{ old('langkah') }}</textarea>
        </div>

        <div class="mb-3">
            <label for="gambar" class="form-label">Gambar (opsional)</label>
            <input type="file" class="form-control" id="gambar" name="gambar" accept="image/*">
        </div>

        <button type="submit" class="btn btn-success">Simpan Resep</button>
        <a href="{{ route('reseps.index') }}" class="btn btn-secondary">Batal</a>
    </form>
</div>
@endsection
