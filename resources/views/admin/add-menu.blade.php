@extends('layouts.admin')
@section('content')
    <div class="container-fluid py-4 ">
        <div class="row">
            <div class="col-12">
                <div class="card mb-4">
                    <div class="card-header pb-0">
                        <h6>Tambah Menu</h6>
                    </div>
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
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
                    <form action="{{ route('admin.menu.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row px-4">
                            <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
                                <div class="card">
                                    <div class="card-body p-3">
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="name">
                                                    <label
                                                        class="text-sm mb-0 text-capitalize font-weight-bold">Gambar</label>
                                                    <input type="file" class="form-control" name="gambar" id="image"
                                                        onchange="previewImage()" required>
                                                    <img id="imagePreview" src="#" alt="Preview Gambar"
                                                        class="mt-3" style="display: none; max-height: 150px;">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
                                <div class="card">
                                    <div class="card-body p-3">
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="name">
                                                    <label class="text-sm mb-0 text-capitalize font-weight-bold">Nama
                                                        Menu</label>
                                                    <input type="text" class="form-control" name="nama_menu"
                                                        id="formGroupExampleInput" placeholder="Input" required>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
                                <div class="card">
                                    <div class="card-body p-3">
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="name">
                                                    <label for="kategori">Kategori</label>
                                                    <select name="kategori_id" id="kategori_id" class="form-control"
                                                        required>
                                                        <option value="" disabled selected>Pilih Kategori</option>
                                                        @foreach ($kategori as $item)
                                                            <option value="{{ $item->id }}">{{ $item->nama_kategori }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
                                <div class="card">
                                    <div class="card-body p-3">
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="name">
                                                    <label
                                                        class="text-sm mb-0 text-capitalize font-weight-bold">Deskripsi</label>
                                                    <input type="text" class="form-control" name="deskripsi"
                                                        id="formGroupExampleInput" placeholder="Input" required>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
                                <div class="card">
                                    <div class="card-body p-3">
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="name">
                                                    <label
                                                        class="text-sm mb-0 text-capitalize font-weight-bold">Stok</label>
                                                    <input type="number" class="form-control" name="stok"
                                                        id="formGroupExampleInput" step="1" min="0"
                                                        placeholder="Input" required>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
                                <div class="card">
                                    <div class="card-body p-3">
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="name">
                                                    <label
                                                        class="text-sm mb-0 text-capitalize font-weight-bold">Harga</label>
                                                    <input type="number" class="form-control" name="harga"
                                                        id="formGroupExampleInput" step="0.01" min="0"
                                                        placeholder="Input" required>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <button class="btn btn-primary" type="submit">Simpan</button>
                            <a href="{{ route('admin.menu.index') }}" class="btn btn-danger">Kembali</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
