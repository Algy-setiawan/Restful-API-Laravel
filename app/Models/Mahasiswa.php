<?php

namespace App\Models;

use PHPOpenSourceSaver\JWTAuth\Contracts\JWTSubject;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Model;

class Mahasiswa extends Authenticatable implements JWTSubject
{
    use HasFactory;
        /**
     * fillable
     *
     * @var array
     */
    protected $fillable = [
        'nim',
        'nama',
        'foto',
        'email',
        'no_tlp',
        'jurusan',
        'jk',
        'user_mahasiswa',
        'password',
   
    ];
    protected $hidden = [
        'password',
        'remember_token',
        'created_at',
        'updated_at',
    ];
    // set tabel
    protected $table = 'mahasiswa';
    // set alias id to nip
    protected $primaryKey = 'nim';

    // One to one
    public function user()
    {  	
    return $this->hasOne(User::class,'user_mahasiswa','nim');
    }

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
{
    return [];
}
}
