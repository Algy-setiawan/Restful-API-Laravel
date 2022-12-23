<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Matakuliah extends Model
{
    use HasFactory;
        /**
     * fillable
     *
     * @var array
     */
    protected $fillable = [
        'nama_matkul',
        'user_dosen'
        
    ];
    // set tabel
    protected $table = 'matakuliah';
    // set alias id to nip
    protected $primaryKey = 'kd_matkul';
    
    public function  dosen(){
        return $this->belongsTo('App\Models\Dosen', 'user_dosen', 'nip', 'dosen');
        // return $this->hasOne('\Models\User','user_dosen','nip');
    }
  
    public function  matakuliah(){
        return $this->hasMany('App\Models\Matakuliah', 'user_dosen', 'nip', 'matakuliah');
        // return $this->hasOne('\Models\User','user_dosen','nip');
    }
  

    public function kelas(){
        return $this->hasMany(Kelas::class);
    }
}
