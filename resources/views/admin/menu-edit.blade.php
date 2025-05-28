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

    <form action="{{ route('admin.menu.update', $menu->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="card-header">
            <h4>Edit Menu</h4>
        </div>

        <div class="mb-3">
            <label for="nama_menu" class="form-label">Nama Menu</label>
            <input type="text" class="form-control" name="nama_menu" value="{{ $menu->nama_menu }}" required>
        </div>

        <div class="mb-3">
            <label for="kategori_id" class="form-label">Kategori</label>
            <select name="kategori_id" class="form-control" required>
                <option disabled>Pilih Kategori</option>
                @foreach ($kategori as $item)
                    <option value="{{ $item->id }}" {{ $item->id == $menu->kategori_id ? 'selected' : '' }}>
                        {{ $item->nama_kategori }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="deskripsi" class="form-label">Deskripsi</label>
            <input type="text" class="form-control" name="deskripsi" value="{{ $menu->deskripsi }}" required>
        </div>

        <div class="mb-3">
            <label for="stok" class="form-label">Stok</label>
            <input type="number" class="form-control" name="stok" value="{{ $menu->stok }}" required min="0">
        </div>

        <div class="mb-3">
            <label for="harga" class="form-label">Harga</label>
            <input type="number" class="form-control" name="harga" value="{{ $menu->harga }}" required min="0">
        </div>

        <div class="mb-3">
            <label for="gambar" class="form-label">Gambar</label>
            <input type="file" class="form-control" name="gambar" id="image" onchange="previewImage()">
            <img id="imagePreview" src="{{ asset($menu->gambar) }}" alt="Preview Gambar" class="mt-3"
                style="max-height: 150px;">

        </div>

        <div class="card-footer">
            <button class="btn btn-primary" type="submit">Simpan Perubahan</button>
            <a href="{{ route('admin.menu.index') }}" class="btn btn-danger">Batal</a>
        </div>
    </form>

    <script>
        function previewImage() {
            const input = document.getElementById('image');
            const preview = document.getElementById('imagePreview');

            const file = input.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    preview.src = e.target.result;
                    preview.style.display = 'block';
                };
                reader.readAsDataURL(file);
            }
        }
    </script>
@endsection
