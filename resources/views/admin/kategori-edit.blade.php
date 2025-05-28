@extends('layouts.admin')

@section('content')
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <form action="{{ route('admin.kategori.update', $kategori->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="card-header">
            <h4>Edit Kategori</h4>
        </div>

        <div class="mb-3">
            <label for="nama_kategori" class="form-label">Nama Kategori</label>
            <input type="text" class="form-control" value="{{ $kategori->nama_kategori }}" id="nama_kategori"
                placeholder="Masukkan nama kategori" name="nama_kategori" required>
        </div>

        <div class="card-footer">
            <button class="btn btn-primary" type="submit">Simpan Perubahan</button>
            <a href="{{ route('admin.kategori.index') }}" class="btn btn-danger">Batal</a>
        </div>
    </form>
@endsection
