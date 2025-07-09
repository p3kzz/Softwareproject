<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rating extends Model
{
    use HasFactory;
    protected $table = 'rating';
    protected $fillable = [
        'user_id',
        'pelanggan_id',
        'pesanan_id',
        'menu_id',
        'rating',
        'komentar',
    ];

    public function pesanan()
    {
        return $this->belongsTo(pesanan::class);
    }

    // Relasi ke model Menu
    public function menu()
    {
        return $this->belongsTo(MenuModel::class);
    }

    // Relasi ke User (jika login)
    public function user()
    {
        return $this->belongsTo(User::class,  'user_id');
    }

    // Relasi ke Pelanggan (jika guest)
    public function pelanggan()
    {
        return $this->belongsTo(Pelanggan::class, 'pelanggan_id');
    }
}
