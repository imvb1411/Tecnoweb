<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Staff extends Model
{
    protected $table='params_people_staffs';
    protected $primaryKey='idstaff';
    protected $fillable=[
        'occupation',
        'status'
    ];
    public $timestamps=false;

    public function person(){
        return $this->belongsTo('App\Person','personid','idperson');
    }
}
