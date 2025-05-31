@extends('layouts.pengguna')
@section('content')
    <!-- book section -->
    <section class="book_section layout_padding">
        <div class="container">
            <div class="headings_container text-center">
                <h2>Pilih Metode Checkout</h2>
                <p class="text-center">
                    Silahkan Login Untuk Mendapatkan Diskon 10% dari Pesanan Anda
                </p>
            </div>
            <div class="row justify-content-center">
                <div class="col-md-6">
                    <div class="checkout-options">
                        <a href="{{ route('login') }}" class="btn btn-primary mb-3">Login</a>

                        <div class="divider my-3">
                            <span>atau</span>
                        </div>

                        <a href="{{ route('checkout.create') }}" class="btn btn-primary mb-3">Lanjutkan sebagai Tamu</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- end book section -->
@endsection
