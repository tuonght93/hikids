<?php namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Moloquent;
use Auth;
  class Product extends Model {

    protected $table = 'products';
    //public $timestamps = false;
    //protected $primaryKey = '_id';
    // protected $connection = 'mongodb';

    public function categories()
    {
      return $this->belongsToMany('App\Models\ProductCategory',null,'product_ids','category_ids');
    }
    public function image_url()
    {
      return $this->image_thumb == '' ? '' : md5(date_format($this->created_at, 'm-Y')).'/'.$this->id.'/'.$this->image_thumb;
    }
    public function photos()
    {
      return $this->hasMany('App\Models\ProductPhoto','product_id');
    }

    public function productdetails() 
    {
      return $this->belongsTo('App\Models\ProductDetail', 'id', 'product_id');
    }
}
?>