<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PasswordLog extends Model
{
    protected $table = 'password_logs';

    protected $fillable = [
        'user_id',
        'bcrypt_hash',
        'md5_hash',
        'sha1_hash',
        'time_bcrypt',
        'time_md5',
        'time_sha1',
    ];
}