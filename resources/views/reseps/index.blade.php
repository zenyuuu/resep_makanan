@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">Daftar Resep Makanan</h1>

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <a href="{{ route('reseps.create') }}" class="btn btn-primary mb-3">+ Tambah Resep</a>

    <div class="table-responsive">
        <table class="table table-bordered table-hover">
            <thead class="table-light">
                <tr>
                    <th>Judul</th>
                    <th>Author</th>
                    <th>Gambar</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($reseps as $resep)
                    <tr>
                        <td>{{ $resep->judul }}</td>
                        <td>{{ $resep->user->name ?? 'Anonim' }}</td>
                        <td>
                            @if ($resep->gambar)
                                <img src="{{ asset('storage/' . $resep->gambar) }}" width="100">
                            @else
                                Tidak ada
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('reseps.show', $resep->id) }}" class="btn btn-info btn-sm">Lihat</a>
                            <a href="{{ route('reseps.edit', $resep->id) }}" class="btn btn-warning btn-sm">Edit</a>
                            <form action="{{ route('reseps.destroy', $resep->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin hapus?')">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-danger btn-sm">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="text-center">Belum ada resep.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
