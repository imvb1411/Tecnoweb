<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Specie extends Model
{
    protected $table='params_pet_species';
    protected $primaryKey='idspecie';
    protected $fillable=[
        'speciename',
        'status'
    ];
    public $timestamps=false;

    public function user(){
        return $this->belongsTo('App\User','userid','iduser');
    }
}
