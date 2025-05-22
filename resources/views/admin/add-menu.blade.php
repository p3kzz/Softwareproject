@extends('layouts.admin')
@section('content')
    <div class="container-fluid py-4 ">
        <div class="row">
            <div class="col-12">
                <div class="card mb-4">
                    <div class="card-header pb-0">
                        <h6>Tambah Menu</h6>
                    </div>
                    <form class="" novalidate="novalidate" method="POST" action="">
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
                                                    <input type="file" class="form-control" name=""
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
                                                    <label class="text-sm mb-0 text-capitalize font-weight-bold">Nama
                                                        Menu</label>
                                                    <input type="text" class="form-control" name=""
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
                                                        class="text-sm mb-0 text-capitalize font-weight-bold">Kategori</label>
                                                    <input type="text" class="form-control" name=""
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
                                                        class="text-sm mb-0 text-capitalize font-weight-bold">Deskripsi</label>
                                                    <input type="text" class="form-control" name=""
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
                                                    <input type="text" class="form-control" name=""
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
                                                        class="text-sm mb-0 text-capitalize font-weight-bold">Harga</label>
                                                    <input type="text" class="form-control" name=""
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
                            <a href="" class="btn btn-danger">Kembali</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
