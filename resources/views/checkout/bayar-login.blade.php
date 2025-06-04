@extends('layouts.pengguna')

@section('content')
    <div class="container text-center my-5">
        <h2>Konfirmasi Pembayaran</h2>
        <p>Silakan selesaikan pembayaran Anda melalui Midtrans.</p>

        <div id="snap-container" class="my-4"></div>
    </div>

    <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('midtrans.client_key') }}">
    </script>
    <script>
        snap.pay('{{ $snapToken }}', {
            onSuccess: function(result) {
                window.location.href = "{{ route('checkout.success', $pesanan->id) }}";
            },
            onPending: function(result) {
                alert("Pembayaran sedang diproses.");
            },
            onError: function(result) {
                alert("Terjadi kesalahan.");
            }
        });
    </script>
@endsection
