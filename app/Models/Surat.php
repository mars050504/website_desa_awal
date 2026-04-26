<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Surat extends Model
{
    protected $table = 'surat';

    protected $fillable = [
        'user_id',
        'nama',
        'tanggal',
        'jenis',
        'status',
        'keterangan',
        'isi_surat'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
