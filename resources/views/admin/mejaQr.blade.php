@extends('layouts.admin')
@section('content')
    <div class="container mt-5">
        <h4>List Meja</h4>
        <a href="{{ route('admin.mejaQr.create') }}" class="btn btn-success mb-3">Tambah Meja</a>
        <table class="table">
            <thead>
                <tr>
                    <th>Nomor Meja</th>
                    <th>QR Token</th>
                    <th>Link</th>
                    <th>QR Code</th> {{-- Tambahkan kolom baru --}}
                </tr>
            </thead>
            <tbody>
                @foreach ($meja as $item)
                    <tr>
                        <td>{{ $item->nomor_meja }}</td>
                        <td>{{ $item->qr_token }}</td>
                        <td><a href="{{ url('/pesanan?token=' . $item->qr_token) }}" target="_blank">Scan Link</a></td>
                        <td>
                            @if ($item->qr_image)
                                <img src="{{ asset($item->qr_image) }}" alt="QR Code" style="width: 100px;">
                            @else
                                <span class="text-muted">Belum ada QR</span>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
