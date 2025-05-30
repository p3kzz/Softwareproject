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
                        <td><a href="{{ url('/order/' . $item->qr_token) }}" target="_blank">Scan Link</a>
                        </td>
                        <td>
                            {{-- Langsung render QR-nya --}}
                            {!! QrCode::size(100)->generate(url('/order/' . $item->qr_token)) !!}

                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
