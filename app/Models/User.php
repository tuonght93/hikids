<?php namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;

use Auth, Cache;

  class User extends Model implements AuthenticatableContract, CanResetPasswordContract {
//class User extends Model implements AuthenticatableContract, CanResetPasswordContract {

  use Authenticatable, CanResetPassword;

  /**
   * The database table used by the model.
   *
   * @var string
   */
 // protected $table = 'users';

protected $table = 'users';
  /**
   * The attributes excluded from the model's JSON form.
   *
   * @var array
   */
  protected $hidden = ['password', 'remember_token'];


  /**
   * One to Many relation
   *
   * @return Illuminate\Database\Eloquent\Relations\BelongsTo
   */
  public function role() 
  {
    return $this->belongsTo('App\Models\Role', 'role_id', 'type');
  }

  public function citie()
  {
    return $this->belongsTo('App\Models\City', 'city', 'slug');
  }

  public function getCity()
  {
    if (Cache::has('City_'.$this->city)) {
      return Cache::get('City_'.$this->city);
    } else {
      $city = $this->citie;
      Cache::forever('City_'.$this->city, $city);
      return $city;
    }
  }

  public function isAdmin()
  {
    return $this->role_id == 1;
  }

  public function isEditor()
  {
    return $this->role_id == 2;
  }

  public function isUser()
  {
    return $this->role_id == 3;
  }

  /**
   * Check not user role
   *
   * @return bool
   */
  public function isNotUser()
  {
    return $this->role_id != 4;
  }

  public function set_sex($sex)
  {
    $gender = 0;
    if ($sex == 'male') {
      $gender = 1;
    }
    if ($sex == 'female') {
      $gender = 2;
    }
    $this->set_attribute('sex', $gender);
  }


}
