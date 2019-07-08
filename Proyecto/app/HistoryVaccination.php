<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class HistoryVaccination extends Model
{
    protected $table='clinic_history_vaccinations';
    protected $primaryKey='idhistoryvaccination';
    protected $fillable=[
        'dosisnumber',
        'status'
    ];
    public $timestamps=false;

    public function history(){
        return $this->belongsTo('App\History','historyid','idhistory');
    }

    public function vaccination(){
        return $this->belongsTo('App\Vaccination','vaccinationid','idvaccination');
    }
}
