<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Person extends Model
{
    protected $table = 'params_people';
    protected $primaryKey = 'idperson';
    protected $fillable = [
        'firstname',
        'lastname',
        'phone',
        'people_type',
        'status'
    ];
    public $timestamps=false;
}
