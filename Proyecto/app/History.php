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

    public function consultations(){
        return $this->hasMany('App\Consultation','historyid','idhistory');
    }

    public function vaccinations(){
        return $this->hasMany('App\HistoryVaccination','historyid','idhistory');
    }
}
