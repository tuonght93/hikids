<?php namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Moloquent;
  class Order extends Model {

    protected $collection = 'orders';

    public function orderdetail() 
	{
	    return $this->hasMany('App\Models\OrderDetail');
	}

    public function gen_code()
    {
      $code = strtoupper(str_random(6));
      $check = Order::where('code', '=', $code)->first();
      if (!$check) {
        return $code;
      } else {
        Order::gen_code();
      }
    }

}