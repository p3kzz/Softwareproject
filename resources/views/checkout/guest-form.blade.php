@extends('layouts.pengguna')
@section('content')
    <!-- book section -->
    <section class="book_section layout_padding">
        <div class="container">
            <div class="headings_container text-center">
                <h2 class="text-center">
                    Biodata Pemesanan
                </h2>
            </div>
            <div class="row justify-content-center">
                <div class="col-md-6">
                    <div class="form_container mx-auto">
                        <form action="{{ route('checkout.store') }}" method="POST">
                            @csrf
                            <div>
                                <label for="">Nama</label>
                                <input type="text" class="form-control" name="nama" placeholder="Nama" required />
                            </div>
                            <div>
                                <label for="">No Handphone</label>
                                <input type="text" class="form-control" name="no_hp" placeholder="No HP" required />
                            </div>
                            <div>
                                <label for="">Meja</label>
                                <input type="text" class="form-control" value="{{ session('nomor_meja') }}" disabled />
                            </div>
                            <div>
                                <input type="hidden" name="meja_id" value="{{ session('meja_id') }}" required>
                            </div>
                            <div class="btn_box">
                                   <button type="submit">Checkout</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- end book section -->
@endsection