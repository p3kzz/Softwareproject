<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class detail_pesanan extends Model
{
    use HasFactory;
    protected $table = 'detail_pesanan';
    protected $fillable = [
        'pesanan_id',
        'menu_id',
        'harga',
        'jumlah',
    ];

    // Relasi ke Pesanan
    public function pesanan()
    {
        return $this->belongsTo(pesanan::class);
    }

    // Relasi ke Menu
    public function menu()
    {
        return $this->belongsTo(MenuModel::class);
    }
}
