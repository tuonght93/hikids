<?php namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Moloquent;
  class Brand extends Model {

    protected $collection = 'brands';
    //public $timestamps = false;
    //protected $primaryKey = '_id';
    // protected $connection = 'mongodb';

    public function products()
    {
      return $this->hasMany('App\Models\Product','brand_id');
    }
    
  }
?>