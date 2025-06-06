@if (!empty($keranjang) && count($keranjang) > 0)
    @foreach ($keranjang as $item)
        <tr>
            <td>{{ $item['nama_menu'] }}</td>
            <td>Rp {{ number_format($item['harga']) }}</td>
            <td class="d-flex align-items-center gap-1">
                <form action="{{ route('menu.decrement', $item['id']) }}" method="POST">
                    @csrf
                    @method('PATCH')
                    <button class="btn btn-sm btn-danger btn-decrement" data-id="{{ $item['id'] }}">-</button>
                </form>

                <span class="mx-2 item-jumlah" id="jumlah-{{ $item['id'] }}">{{ $item['jumlah'] }}</span>

                <form action="{{ route('menu.increment', $item['id']) }}" method="POST">
                    @csrf
                    @method('PATCH')
                    <button class="btn btn-sm btn-success btn-increment" data-id="{{ $item['id'] }}">+</button>
                </form>
            </td>
            <td id="subtotal-{{ $item['id'] }}">Rp {{ number_format($item['subtotal']) }}</td>
            <td>
                <form action="{{ route('pengguna.menu.destroy', $item['id']) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></button>
                </form>
            </td>
        </tr>
    @endforeach
    <tr>
        <td colspan="3"><strong>Total</strong></td>
        <td colspan="2"><strong id="keranjang-total">Rp {{ number_format($total) }}</strong></td>
    </tr>
    <tr>
        <td colspan="5">
            <form action="{{ route('checkout.index') }}" method="GET">
                <button type="submit" class="btn btn-danger btn-checkout">Checkout</button>
            </form>
        </td>
    </tr>
@else
    <tr>
        <td colspan="5">Keranjang kosong.</td>
    </tr>
@endif
