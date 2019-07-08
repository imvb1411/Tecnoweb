<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class View extends Model
{
    protected $table='system_views';
    protected $primaryKey='idview';
    protected $fillable=[
        'viewname',
        'views'
    ];
    public $timestamps=false;
}
