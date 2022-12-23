<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Kelas extends Model
{
    use HasFactory;
        /**
     * fillable
     *
     * @var array
     */
    protected $fillable = [
        'nama_kelas',
        'nip',
        'nim',
        'kd_matkul',
        
    ];
    protected $hidden = [
        'password',
        'remember_token',
        'created_at',
        'updated_at',
    ];

    // set tabel
    protected $table = 'kelas';
    // set alias id to nip
    protected $primaryKey = 'kd_kelas';
    
    public function matakuliah(){
        return $this->belongsTo(Matakuliah::class);

    }


}
