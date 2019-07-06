<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table='inv_products';
    protected $primaryKey='idproduct';
    protected $fillable=[
        'productname',
        'currentstock',
        'price',
        'cost',
        'status'
    ];
    public $timestamps=false;

    public function user(){
        return $this->belongsTo('App\User','userid','iduser');
    }

    public function category(){
        return $this->belongsTo('App\Category','categoryid','idproductcategory');
    }

    public function unit(){
        return $this->belongsTo('App\Unit','unitid','idproductunit');
    }
}
