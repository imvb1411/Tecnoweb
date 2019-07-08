<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    protected $table= 'system_security_users';
    protected $primaryKey='iduser';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nick', 'password','role', 'status',
    ];
    public $timestamps=false;

    public function person(){
        return $this->belongsTo('App\Person','personid','idperson');
    }
}
