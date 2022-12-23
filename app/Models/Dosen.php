<?php

namespace App\Models;

use PHPOpenSourceSaver\JWTAuth\Contracts\JWTSubject;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Model;

class Dosen extends Authenticatable implements JWTSubject
{
    use HasApiTokens, HasFactory, Notifiable;
    /**
     * fillable
     *
     * @var array
     */
    protected $fillable = [
        'nama',
        'email',
        'no_tlp',
        'foto',
        'nip',
        'user_dosen',
        'level'
 
    ];
    protected $hidden = [
        'password',
        'remember_token',
        'created_at',
        'updated_at',
    ];
    
    // set tabel
    protected $table = 'dosen';
    // set alias id to nip
    protected $primaryKey = 'nip';
    
    public function user()
    {  	
    return $this->hasOne(User::class,'user_dosen','nip');
// return $this->hasOne('\Models\User','user_dosen','nip');
// return $this->hasOne(User::class, 'user_id' );
    }
    public function matakuliah(){
        return $this->hasOne('App\Models\Matakuliah', 'user_dosen', 'nip', 'dosen');
    }
    public function dosen(){
        return $this->belongsTo('App\Models\Dosen', 'nip', 'user_dosen', 'dosen');
    }
    // public function  dosen(){
    //     return $this->belongsTo('App\Models\Matakuliah', 'user_dosen', 'nip', 'matakuliah');
    //     // return $this->hasOne('\Models\User','user_dosen','nip');
    // }
    /**
* Get the identifier that will be stored in the subject claim of the JWT.
*
* @return mixed
*/
public function getJWTIdentifier()
{
    return $this->getKey();
}

/**
* Return a key value array, containing any custom claims to be added to the JWT.
*
* @return array
*/
public function getJWTCustomClaims()
{
    return [];
}
}
