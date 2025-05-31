@extends('layouts.admin')

@section('content')
    <h2>Daftar Kasir</h2>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <a href="{{ route('admin.kasir.create') }}" class="btn btn-primary mb-3">Tambah Kasir</a>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama</th>
                <th>Email</th>
                <th>Dibuat Pada</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($kasirs as $index => $kasir)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $kasir->name }}</td>
                    <td>{{ $kasir->email }}</td>
                    <td>{{ $kasir->created_at->format('d M Y') }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" class="text-center">Belum ada kasir.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
@endsection
