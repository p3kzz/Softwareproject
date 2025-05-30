@extends('layouts.pengguna')

@section('content')
    <div class="container py-5">
        <h2>Keranjang</h2>

        @if (count($keranjang) > 0)
            <table class="table">
                <thead>
                    <tr>
                        <th>Menu</th>
                        <th>Harga</th>
                        <th>Jumlah</th>
                        <th>Total</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($keranjang as $item)
                        <tr>
                            <td>{{ $item['nama_menu'] }}</td>
                            <td>Rp {{ number_format($item['harga']) }}</td>
                            <td class="d-flex align-items-center gap-1">
                                <form action="{{ route('keranjang.decrement', $item['id']) }}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="btn btn-sm btn-danger">-</button>
                                </form>

                                <span class="mx-2">{{ $item['jumlah'] }}</span>

                                <form action="{{ route('keranjang.increment', $item['id']) }}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="btn btn-sm btn-success">+</button>
                                </form>
                            </td>
                            <td>Rp {{ number_format($item['harga'] * $item['jumlah']) }}</td>
                            <td>
                                <form action="{{ route('keranjang.destroy', $item['id']) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-danger btn-sm">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                    <tr>
                        <td colspan="3"><strong>Total</strong></td>
                        <td colspan="2"><strong>Rp {{ number_format($total) }}</strong></td>
                    </tr>
                </tbody>
            </table>
        @else
            <p>Keranjang kosong.</p>
        @endif
    </div>
@endsection
