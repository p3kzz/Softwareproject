<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MenuModel extends Model
{
    protected $table = 'menu';
    protected $fillable = [
        'nama_menu',
        'deskripsi',
        'harga',
        'gambar',
        'stok',
        'kategori_id'
    ];

    public function kategori()
    {
        return $this->belongsTo(KategoriModel::class, 'kategori_id', 'id');
    }
}
