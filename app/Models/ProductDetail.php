<?php namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Moloquent;
  class ProductDetail extends Model {

    protected $table = 'productdetails';

    public function product() 
	  {
	    return $this->belongsTo('App\Models\Product', 'product_id', 'id');
	  }

	  public function color() 
	  {
	    return $this->belongsTo('App\Models\Color', 'color_id', 'id');
	  }

	  public function size() 
	  {
	    return $this->belongsTo('App\Models\Size', 'size_id', 'id');
	  }

}