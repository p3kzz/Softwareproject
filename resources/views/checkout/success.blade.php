@extends('layouts.pengguna')
@section('content')
    <div class="container py-5">
        <div class="headings_container text-center">
            <h1>Pembayaran Berhasil</h1>
            <p>Terima kasih telah melakukan pemesanan. Berikut detail dan riwayat pesanan Anda:</p>
        </div>
        <div class="text-center">
            <h2>Riwayat Pesanan Anda</h2>
        </div>
        @if ($riwayat->isEmpty())
            <p>Tidak ada pesanan yang ditemukan.</p>
        @else
            <div class="row justify-content-center">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Order ID</th>
                            <th>Jam/Tanggal</th>
                            <th>menu</th>
                            <th>Total Harga</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($riwayat as $item)
                            <tr>
                                <td>{{ $item->order_id }}</td>
                                <td>{{ $item->created_at->format('H:i - d-m-Y') }}</td>
                                <td>
                                    @foreach ($item->detail_pesanan as $detail)
                                        {{ $detail->menu->nama_menu }} ({{ $detail->jumlah }})
                                    @endforeach
                                </td>
                                <td>Rp {{ number_format($item->total_harga, 0, ',', '.') }}</td>
                                <td>{{ ucfirst($item->status) }}</td>
                            </tr>
                        @endforeach

                    </tbody>
                </table>
            </div>
        @endif

    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    @if (session('success'))
        <script>
            Swal.fire({
                title: 'Berhasil!',
                text: '{{ session('success') }}',
                icon: 'success',
                confirmButtonText: 'OK'
            });
        </script>
    @endif

    @if (session('error'))
        <script>
            Swal.fire({
                title: 'Gagal!',
                text: '{{ session('error') }}',
                icon: 'error',
                confirmButtonText: 'OK'
            });
        </script>
    @endif
@endsection
