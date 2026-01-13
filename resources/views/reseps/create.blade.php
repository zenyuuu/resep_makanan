@extends('layouts.app')

@section('content')
<style>
    .create-resep-wrapper {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        min-height: calc(100vh - 70px);
        padding: 40px 0;
    }

    .create-resep-card {
        background: white;
        border-radius: 12px;
        box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
        overflow: hidden;
        max-width: 700px;
        margin: 0 auto;
    }

    .create-resep-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 40px 30px;
        text-align: center;
    }

    .create-resep-header h1 {
        font-size: 2rem;
        font-weight: 700;
        margin: 0;
        margin-bottom: 10px;
    }

    .create-resep-header p {
        margin: 0;
        opacity: 0.9;
        font-size: 0.95rem;
    }

    .create-resep-body {
        padding: 40px;
    }

    .form-group-wrapper {
        margin-bottom: 25px;
    }

    .form-group-wrapper label {
        display: flex;
        align-items: center;
        font-weight: 600;
        color: #333;
        margin-bottom: 8px;
        font-size: 0.95rem;
    }

    .form-group-wrapper label i {
        margin-right: 8px;
        color: #667eea;
        width: 18px;
    }

    .form-group-wrapper input,
    .form-group-wrapper textarea {
        border: 2px solid #e0e0e0;
        border-radius: 8px;
        padding: 12px 15px;
        font-size: 0.95rem;
        transition: all 0.3s ease;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    .form-group-wrapper input:focus,
    .form-group-wrapper textarea:focus {
        border-color: #667eea;
        box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
        outline: none;
    }

    .form-group-wrapper textarea {
        resize: vertical;
        min-height: 100px;
    }

    .file-upload-wrapper {
        position: relative;
        display: inline-block;
        width: 100%;
    }

    .file-upload-wrapper input[type="file"] {
        opacity: 0;
        width: 0;
        height: 0;
    }

    .file-upload-label {
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 30px;
        border: 2px dashed #667eea;
        border-radius: 8px;
        background: #f8f9ff;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .file-upload-label:hover {
        background: #f0f1ff;
        border-color: #764ba2;
    }

    .file-upload-label i {
        margin-right: 10px;
        color: #667eea;
        font-size: 1.5rem;
    }

    .alert-danger {
        background: #fee;
        border: 2px solid #fcc;
        border-radius: 8px;
        color: #c33;
        padding: 15px 20px;
        margin-bottom: 30px;
    }

    .alert-danger ul {
        margin: 0;
        padding-left: 20px;
    }

    .alert-danger li {
        margin-bottom: 5px;
    }

    .form-actions {
        display: flex;
        gap: 12px;
        margin-top: 35px;
    }

    .btn-submit {
        flex: 1;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        border: none;
        padding: 12px 30px;
        border-radius: 8px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        font-size: 0.95rem;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
    }

    .btn-submit:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(102, 126, 234, 0.3);
        color: white;
        text-decoration: none;
    }

    .btn-cancel {
        flex: 1;
        background: #f0f0f0;
        color: #666;
        border: 2px solid #e0e0e0;
        padding: 12px 30px;
        border-radius: 8px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        font-size: 0.95rem;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        text-decoration: none;
    }

    .btn-cancel:hover {
        background: #e8e8e8;
        border-color: #d0d0d0;
        color: #333;
    }
</style>

<div class="create-resep-wrapper">
    <div class="create-resep-card">
        <!-- Header -->
        <div class="create-resep-header">
            <h1><i class="fas fa-plus-circle"></i> Tambah Resep Baru</h1>
            <p>Bagikan resep lezat Anda dengan komunitas</p>
        </div>

        <!-- Body -->
        <div class="create-resep-body">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('reseps.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <!-- Judul Resep -->
                <div class="form-group-wrapper">
                    <label for="judul">
                        <i class="fas fa-book"></i> Judul Resep
                    </label>
                    <input type="text" class="form-control" id="judul" name="judul" placeholder="Contoh: Nasi Goreng Spesial" value="{{ old('judul') }}" required>
                </div>

                <!-- Bahan-bahan -->
                <div class="form-group-wrapper">
                    <label for="bahan">
                        <i class="fas fa-list"></i> Bahan-bahan
                    </label>
                    <textarea class="form-control" id="bahan" name="bahan" placeholder="Tuliskan bahan-bahan yang diperlukan, satu per baris..." required>{{ old('bahan') }}</textarea>
                </div>

                <!-- Langkah-langkah -->
                <div class="form-group-wrapper">
                    <label for="langkah">
                        <i class="fas fa-tasks"></i> Langkah-langkah
                    </label>
                    <textarea class="form-control" id="langkah" name="langkah" placeholder="Tuliskan cara memasak langkah demi langkah..." required>{{ old('langkah') }}</textarea>
                </div>

                <!-- Upload Gambar -->
                <div class="form-group-wrapper">
                    <label for="gambar">
                        <i class="fas fa-image"></i> Upload Gambar
                    </label>
                    <div class="file-upload-wrapper">
                        <input type="file" class="form-control" id="gambar" name="gambar" accept="image/*">
                        <label for="gambar" class="file-upload-label">
                            <i class="fas fa-cloud-upload-alt"></i>
                            <span>Pilih gambar atau drag & drop</span>
                        </label>
                    </div>
                </div>

                <!-- Buttons -->
                <div class="form-actions">
                    <button type="submit" class="btn-submit">
                        <i class="fas fa-check-circle"></i> Simpan Resep
                    </button>
                    <a href="{{ route('reseps.index') }}" class="btn-cancel">
                        <i class="fas fa-times-circle"></i> Batal
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection