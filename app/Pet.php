<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pet extends Model
{
    protected $table='params_pets';
    protected $primaryKey='idpet';
    protected $fillable=[
        'petname',
        'birthdate',
        'color',
        'status'
    ];
    public $timestamps=false;

    public function user(){
        return $this->belongsTo('App\User','userid','iduser');
    }

    public function race(){
        return $this->belongsTo('App\Race','raceid','idrace');
    }

    public function owner(){
        return $this->belongsTo('App\Person','ownerid','idperson');
    }
}
