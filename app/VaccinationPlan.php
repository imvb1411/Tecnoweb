<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class VaccinationPlan extends Model
{
    protected $table='params_vaccination_plans';
    protected $primaryKey='idvaccinationplan';
    protected $fillable=[
        'dosisnumber',
        'daysnumber',
        'status'
    ];
    public $timestamps=false;

    public function vaccination(){
        return $this->belongsTo('App\Vaccination','vaccinationid','idvaccination');
    }
}
