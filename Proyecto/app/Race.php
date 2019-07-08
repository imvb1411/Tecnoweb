<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Race extends Model
{
    protected $table='params_pet_races';
    protected $primaryKey='idrace';
    protected $fillable=[
        'racename',
        'status'
    ];
    public $timestamps=false;

    public function user(){
        return $this->belongsTo('App\User','userid','iduser');
    }

    public function specie(){
        return $this->belongsTo('App\Specie','specieid','idspecie');
    }
}
