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
                            <th>Menu</th>
                            <th>Total Harga</th>
                            <th>Status</th>
                            <th>Rating</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($riwayat as $item)
                            <tr>
                                <td>{{ $item->order_id }}</td>
                                <td>{{ $item->created_at->format('H:i - d-m-Y') }}</td>
                                <td>
                                    <ul>
                                        @foreach ($item->detail_pesanan as $detail)
                                            <li>{{ $detail->menu->nama_menu }} ({{ $detail->jumlah }})</li>
                                        @endforeach
                                    </ul>
                                </td>
                                <td>Rp {{ number_format($item->total_harga, 0, ',', '.') }}</td>
                                <td>{{ ucfirst($item->status) }}</td>
                                <td>
                                    @if ($item->status === 'selesai')
                                        @foreach ($item->detail_pesanan as $detail)
                                            @php
                                                $existingRating = \App\Models\Rating::where('pesanan_id', $item->id)
                                                    ->where('menu_id', $detail->menu_id)
                                                    ->first();
                                            @endphp
                                            <div class="mb-2">
                                                @if (!$existingRating)
                                                    <button class="btn btn-sm btn-outline-primary mt-1"
                                                        onclick="openRatingModal({{ $item->id }}, {{ $detail->menu_id }}, '{{ $detail->menu->nama_menu }}')">
                                                        Beri Rating - {{ $detail->menu->nama_menu }}
                                                    </button>
                                                @else
                                                    <span class="text-success">Sudah dirating</span>
                                                @endif
                                            </div>
                                        @endforeach
                                    @else
                                        <span class="text-muted">Belum bisa rating</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>

    {{-- Script --}}
    <script>
        function openRatingModal(pesananId, menuId) {
            Swal.fire({
                title: 'Beri Rating',
                html: `
                <div class="mb-3">
                    <label for="rating" class="form-label">Pilih Rating:</label><br>
                    <div id="rating-stars" style="font-size: 1.5rem;">
                        ${[1,2,3,4,5].map(star => `
                                                    <i class="fa fa-star-o" id="star-${star}" onclick="selectStar(${star})" style="cursor: pointer;"></i>
                                                `).join('')}
                    </div>
                </div>
                <div class="form-group mt-3">
                    <label for="komentar">Komentar:</label>
                    <textarea id="komentar" class="form-control" rows="3" placeholder="Tulis komentarmu..."></textarea>
                </div>
                <input type="hidden" id="selectedRating" value="0">
            `,
                showCancelButton: true,
                confirmButtonText: 'Kirim',
                cancelButtonText: 'Batal',
                preConfirm: () => {
                    const rating = parseInt(document.getElementById('selectedRating').value);
                    const komentar = document.getElementById('komentar').value;

                    if (!rating || rating < 1) {
                        Swal.showValidationMessage('Pilih minimal 1 bintang');
                        return false;
                    }

                    return {
                        rating,
                        komentar
                    };
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    const {
                        rating,
                        komentar
                    } = result.value;

                    const data = {
                        rating,
                        komentar,
                        pesanan_id: pesananId,
                        menu_id: menuId,
                        user_id: "{{ auth()->check() ? auth()->id() : null }}",
                        pelanggan_id: "{{ session('pelanggan_id') ?? null }}"
                    };

                    console.log('Kirim data rating:', data); // Debug

                    fetch("{{ route('rating.store') }}", {
                            method: "POST",
                            headers: {
                                "Content-Type": "application/json",
                                "X-CSRF-TOKEN": "{{ csrf_token() }}"
                            },
                            body: JSON.stringify(data)
                        })
                        .then(response => {
                            return response.json().then(json => {
                                if (!response.ok) {
                                    throw new Error(json.message || 'Terjadi kesalahan');
                                }
                                return json;
                            });
                        })
                        .then(data => {
                            Swal.fire('Terima kasih!', 'Rating berhasil dikirim.', 'success')
                                .then(() => location.reload());
                        })
                        .catch(error => {
                            console.error('Error:', error); // Debug
                            Swal.fire('Oops!', error.message || 'Gagal mengirim rating.', 'error');
                        });
                }
            });
        }

        function selectStar(star) {
            document.getElementById('selectedRating').value = star;
            for (let i = 1; i <= 5; i++) {
                const starEl = document.getElementById(`star-${i}`);
                starEl.classList.remove('fa-star', 'fa-star-o');
                starEl.classList.add(i <= star ? 'fa-star' : 'fa-star-o');
            }
        }
    </script>


    {{-- Flash Message --}}
    @if (session('success'))
        <script>
            Swal.fire('Berhasil!', '{{ session('success') }}', 'success');
        </script>
    @endif

    @if (session('error'))
        <script>
            Swal.fire('Gagal!', '{{ session('error') }}', 'error');
        </script>
    @endif
@endsection
