<form action="{{ route('checkout.store') }}" method="POST">
    @csrf
    <input type="text" name="nama" placeholder="Nama" required>
    <input type="text" name="no_hp" placeholder="No HP" required>
    <input type="text" value="{{ session('nomor_meja') }}" disabled>
    <input type="hidden" name="meja_id" value="{{ session('meja_id') }}" required>

    <button type="submit">Checkout</button>
</form>
