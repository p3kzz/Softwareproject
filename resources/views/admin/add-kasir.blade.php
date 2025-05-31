@extends('layouts.admin')
@section('content')
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                <div class="card mb-4">
                    <div class="card-header pb-0">
                        <h6>Register Account Kasir</h6>
                    </div>
                    <form novalidate method="POST" action="{{ route('admin.kasir.store') }}">
                        @csrf
                        <div class="card-body px-4">
                            <div class="mb-3">
                                <label class="form-label text-sm text-capitalize font-weight-bold">Name</label>
                                <input type="text" name="name" class="form-control" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label text-sm text-capitalize font-weight-bold">Email</label>
                                <input type="email" name="email" class="form-control" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label text-sm text-capitalize font-weight-bold">Password</label>
                                <input type="password" name="password" class="form-control" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label text-sm text-capitalize font-weight-bold">Confirm Password</label>
                                <input type="password" name="password_confirmation" class="form-control" required>
                            </div>
                        </div>

                        <div class="card-footer">
                            <button class="btn btn-primary" type="submit">Register</button>
                            <a href="{{ route('admin.kasir.index') }}" class="btn btn-danger">Kembali</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
