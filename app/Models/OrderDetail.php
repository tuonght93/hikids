<?php namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Moloquent;
  class OrderDetail extends Model {

    protected $table = 'orderdetails';

    public function order()
    {
      return $this->belongsTo('App\Models\Order', 'order_id');
    }
    public function product() 
    {
      return $this->belongsTo('App\Models\Product', 'product_id', 'id');
    }

}