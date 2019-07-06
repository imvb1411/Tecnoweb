<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Unit extends Model
{
    protected $table='params_product_units';
    protected $primaryKey='idproductunit';
    protected $fillable=[
        'unitname',
        'unitabbreviation',
        'status'
    ];
    public $timestamps=false;

    public function user(){
        return $this->belongsTo('App\User','userid','iduser');
    }
}
