<?php namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Moloquent;
  class Role extends Model {

    protected $collection = 'roles';

    public function users() 
    {
      return $this->hasMany('App\Models\User');
    }

}
