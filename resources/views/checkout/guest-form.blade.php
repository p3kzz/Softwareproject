@extends('layouts.pengguna')
@section('content')
    <section class="book_section layout_padding">
        <div class="container">
            <div class="headings_container text-center">
                <h2 class="text-center">Biodata Pemesanan</h2>
            </div>
            <div class="row justify-content-center">
                <div class="col-md-6">
                    <div class="form_container mx-auto">
                        <form id="guest-checkout-form">
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
                            <input type="hidden" name="meja_id" value="{{ session('meja_id') }}" required>
                            <div class="btn_box mt-3">
                                <button type="submit" class="btn btn-primary w-100" id="pay-button">Checkout &
                                    Bayar</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('midtrans.client_key') }}">
    </script>

    <script>
        document.getElementById('guest-checkout-form').addEventListener('submit', function(e) {
            e.preventDefault();

            const form = e.target;
            const formData = new FormData(form);

            fetch("{{ route('checkout.store') }}", {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
                    },
                    body: formData
                })
                .then(response => {
                    if (!response.ok) throw new Error("Gagal memproses checkout");
                    return response.json();
                })
                .then(data => {
                    snap.pay(data.snap_token, {
                        onSuccess: function(result) {
                            window.location.href = `/checkout/success/${data.pesanan_id}`;
                        },
                        onPending: function(result) {
                            document.getElementById('result-json').innerHTML += JSON.stringify(
                                result, null, 2);
                        },
                        onError: function(result) {
                            document.getElementById('result-json').innerHTML += JSON.stringify(
                                result, null, 2);
                        }
                    });
                })
                .catch(error => {
                    alert("Terjadi kesalahan: " + error.message);
                });
        });
    </script>
@endsection
