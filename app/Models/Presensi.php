<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Presensi extends Model
{
    use HasFactory;
        /**
     * fillable
     *
     * @var array
     */
    protected $fillable = [
        'kd_kelas',
        'nim',
        'tanggal',
        'kehadiran',
        'sesi',

    ];
    protected $hidden = [
        'password',
        'remember_token',
        'created_at',
        'updated_at',
    ];
    // set tabel
    protected $table = 'presensi';
    // set alias id to nip
    protected $primaryKey = 'kd_presensi';
}
