<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class pesanan extends Model
{
    use HasFactory;
    protected $table = 'pesanan';
    protected $fillable = [
        'order_id',
        'users_id',
        'pelanggan_id',
        'meja_id',
        'total_harga',
        'status',
        'snap_token',
    ];

    // Relasi ke Pelanggan
    public function pelanggan()
    {
        return $this->belongsTo(Pelanggan::class);
    }

    // Relasi ke User (jika user login)
    public function user()
    {
        return $this->belongsTo(User::class, 'users_id');
    }

    // Relasi ke Meja
    public function meja()
    {
        return $this->belongsTo(mejaQr::class);
    }

    // Relasi ke DetailPesanan
    public function detailPesanans()
    {
        return $this->hasMany(detail_pesanan::class);
    }
}
