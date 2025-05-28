<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class mejaQr extends Model
{
    protected $table = 'meja_qr';
    protected $fillable = ['nomor_meja', 'qr_token'];
}
