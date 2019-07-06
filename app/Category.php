<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $table='params_product_categories';
    protected $primaryKey='idproductcategory';
    protected $fillable=[
        'categoryname',
        'status'
    ];
    public $timestamps=false;

    public function user(){
        return $this->belongsTo('App\User','userid','iduser');
    }
}
