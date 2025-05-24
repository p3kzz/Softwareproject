@extends('layouts.admin')

@section('content')
    <div class="container-fluid py-4 ">
        <div class="row">
            <div class="col-12">
                <div class="card mb-4">
                    <div class="card-header pb-0">
                        <h6>Tambah Kategori</h6>
                    </div>
                    <form action="{{ route('admin.kategori.store') }}" method="POST">
                        @csrf
                        <div class="row px-4">
                            <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
                                <div class="card">
                                    <div class="card-body p-3">
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="name">
                                                    <label
                                                        class="text-sm mb-0 text-capitalize font-weight-bold">Kategori</label>
                                                    <input type="text" class="form-control" name="nama_kategori"
                                                        id="formGroupExampleInput" placeholder="Input" required>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <button class="btn btn-primary" type="submit">Simpan</button>
                            <a href="{{ route('admin.kategori.index') }}" class="btn btn-danger">Kembali</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
