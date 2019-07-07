<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    protected $table='params_clinic_services';
    protected $primaryKey='idservice';
    protected $fillable=[
        'servicename',
        'price'
    ];
    public $timestamps=false;
}
