<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{
    protected $table='inv_purchases';
    protected $primaryKey='idpurchase';
    protected $fillable=[
        'date',
        'total',
        'status'
    ];
    public $timestamps=false;

    public function products(){
        return $this->belongsToMany('App\Product','inv_product_purchase','purchaseid','productid')->withPivot(['idproduct_purchase','cost','quantity']);
    }

}
