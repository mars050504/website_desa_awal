<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Surat extends Model
{
    protected $table = 'surat';

    public $timestamps = false; // ⬅️ PENTING

    protected $fillable = [
        'user_id',
        'nama',
        'tanggal',
        'jenis',
        'dok_ktp',
        'dok_kk',
        'dok_pengantar',
    ];
}
