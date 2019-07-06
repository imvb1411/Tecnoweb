<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class History extends Model
{
    protected $table='clinic_medical_history';
    protected $primaryKey='idhistory';
    protected $fillable=[
        'status'
    ];
    public $timestamps=false;

    public function pet(){
        return $this->belongsTo('App\Pet','petid','idpet');
    }
}
