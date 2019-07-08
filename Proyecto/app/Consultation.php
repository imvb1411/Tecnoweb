<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Consultation extends Model
{
    protected $table='clinic_consultations';
    protected $primaryKey='idconsultation';
    protected $fillable=[
        'staffid',
        'historyid',
        'weight',
        'temperature',
        'diagnosis',
        'observation',
        'status'
    ];
    public $timestamps=false;

    public function history(){
        return $this->belongsTo('App\History','historyid','idhistory');
    }

    public function user(){
        return $this->belongsTo('App\User','userid','iduser');
    }

    public function staff(){
        return $this->belongsTo('App\Staff','staffid','idstaff');
    }
}
