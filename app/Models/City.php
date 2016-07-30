<?php namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Moloquent;
use Cache;
class City extends Model {

    protected $table = 'cities';
    
    public function role() 
	  {
	    return $this->belongsTo('App\Models\District', 'city_id', 'id');
	  }

}
