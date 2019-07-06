<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Vaccination extends Model
{
    protected $table='params_clinic_vaccinations';
    protected $primaryKey='idvaccination';
    protected $fillable=[
      'vaccinationname',
        'price',
        'status'
    ];
    public $timestamps=false;

    public function user(){
        return $this->belongsTo('App\User','userid','iduser');
    }

    public function plans(){
        return $this->hasMany('App\VaccinationPlan','vaccinationid','idvaccination');
    }
}
