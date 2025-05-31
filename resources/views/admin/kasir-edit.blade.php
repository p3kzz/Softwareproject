@extends('layouts.admin')
@section('content')
    <div class="container">
        <h2>Edit Kasir</h2>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin.kasir.update', $kasir->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label for="name" class="form-label">Nama</label>
                <input type="text" name="name" class="form-control" value="{{ old('name', $kasir->name) }}" required>
            </div>

            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" name="email" class="form-control" value="{{ old('email', $kasir->email) }}" required>
            </div>

            <div class="mb-3">
                <label for="password" class="form-label">Password Baru (opsional)</label>
                <input type="password" name="password" class="form-control">
            </div>

            <div class="mb-3">
                <label for="password_confirmation" class="form-label">Konfirmasi Password</label>
                <input type="password" name="password_confirmation" class="form-control">
            </div>

            <button type="submit" class="btn btn-success">Update</button>
            <a href="{{ route('admin.kasir.index') }}" class="btn btn-secondary">Batal</a>
        </form>
    </div>
@endsection
