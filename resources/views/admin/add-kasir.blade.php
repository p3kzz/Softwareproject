@extends('layouts.admin')
@section('content')
    <div class="container-fluid py-4 ">
        <div class="row">
            <div class="col-12">
                <div class="card mb-4">
                    <div class="card-header pb-0">
                        <h6>Register Account Kasir</h6>
                    </div>
                    <form class="" novalidate="novalidate" method="POST" action="{{ route('admin.kasir.store') }}">
                        @csrf
                        <div class="row px-4">
                            <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
                                <div class="card">
                                    <div class="card-body p-3">
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="name">
                                                    <label
                                                        class="text-sm mb-0 text-capitalize font-weight-bold">Name</label>
                                                    <input type="text" name="name" required>
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
                                                        class="text-sm mb-0 text-capitalize font-weight-bold">Email</label>
                                                    <input type="email" name="email" required>
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
                                                        class="text-sm mb-0 text-capitalize font-weight-bold">Password</label>
                                                    <input type="password" name="password" required>
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
                                                    <label class="text-sm mb-0 text-capitalize font-weight-bold">Confirm
                                                        Password</label>
                                                    <input type="password" name="password_confirmation" required>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
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
