<?php namespace App\Repositories;

use App\Models\User, App\Models\Role;
use File, Auth, Image, Input, Str, Mail, Validator;
use App\Libraries\ImageLib;
use App\Libraries\Xonlib;
use Agent;


class UserRepository extends BaseRepository{

  /**
   * The Role instance.
   *
   * @var App\Models\Role
   */ 
  protected $role;

  /**
   * Create a new UserRepository instance.
   *
     * @param  App\Models\User $user
   * @param  App\Models\Role $role
   * @return void
   */
  public function __construct(
    User $user, 
    Role $role)
  {
    $this->model = $user;
    $this->role = $role;
  }

  /**
   * Save the User.
   *
   * @param  App\Models\User $user
   * @param  Array  $inputs
   * @return void
   */
    private function save($user, $inputs)
  {   
    if(isset($inputs['seen'])) 
    {
      $user->seen = $inputs['seen'] == 'true';    
    } else {
      $confirmation_code = str_random(30);
      $user->username = $inputs['username'];
      $user->email = strtolower($inputs['email']);
      $user->full_name = $inputs['full_name'];
      $user->city = $inputs['city'];
      $user->telephone = $inputs['telephone'];
      $user->confirmation_code = $confirmation_code;
    }

    $user->save();
    
    //Mail::send('emails.auth.activeAccount', array('confirmation_code' => $confirmation_code), function($message) {
    //        $message->to('nguyentientntn1@gmail.com', 'Tien Nguyen')
    //            ->subject('Verify your email address');
    //});
    //Flash::message('Thanks for signing up! Please check your email.');

  }

  /**
   * Get users collection.
   *
   * @param  int  $n
   * @param  string  $role
   * @return Illuminate\Support\Collection
   */
  public function index($n, $role)
  {
    if($role != 'total')
    {
      return $this->model
      ->with('role')
      ->whereHas('role', function($q) use($role) {
        $q->whereSlug($role);
      })    
      ->oldest('seen')
      ->latest()
      ->paginate($n);     
    }

    return $this->model
    ->with('role')    
    ->oldest('seen')
    ->latest()
    ->paginate($n);
  }

  /**
   * Count the users.
   *
   * @param  string  $role
   * @return int
   */
  public function count($role = null)
  {
    if($role)
    {
      return $this->model
      ->whereHas('role', function($q) use($role) {
        $q->whereSlug($role);
      })->count();      
    }

    return $this->model->count();
  }

  /**
   * Count the users.
   *
   * @param  string  $role
   * @return int
   */
  public function counts()
  {
    $counts = [
      'admin' => $this->count('admin'),
      'redac' => $this->count('redac'),
      'user' => $this->count('user')
    ];

    $counts['total'] = array_sum($counts);

    return $counts;
  }

  /**
   * Get a user collection.
   *
   * @return Illuminate\Support\Collection
   */
  public function create()
  {
    $select = $this->role->all()->lists('title', 'id');

    return compact('select');
  }

  /**
   * Create a user.
   *
   * @param  array  $inputs
   * @param  int    $user_id
   * @return App\Models\User 
   */
  public function store($inputs)
  {
    $user = new $this->model;

    $user->password = bcrypt($inputs['password']);
    $user->role_id = 3;

    if (Agent::isAndroidOS()) {
      $app_id = 3;
    } elseif (Agent::is('iPhone')) {
      $app_id = 2;
    } else {
      $app_id = 1;
    }
    $devices['app_id'] = $app_id;
    $devices['device'] = Agent::device();
    $devices['platform'] = Agent::platform();
    $devices['browser'] = Agent::browser();
    $user->devices = $devices;
    $user->rank_score = $user->rank_score+5;
    $user->is_rank_up = 1;


    $this->save($user, $inputs);

    return $user;
  }

  /**
   * Get user collection.
   *
   * @param  string  $slug
   * @return Illuminate\Support\Collection
   */
  public function show($id)
  {
    $user = $this->model->with('role')->findOrFail($id);

    return compact('user');
  }

  /**
   * Get user collection.
   *
   * @param  int  $id
   * @return Illuminate\Support\Collection
   */
  public function edit($id)
  {
    $user = $this->getById($id);

    $select = $this->role->all()->lists('title', 'id');

    return compact('user', 'select');
  }

  /**
   * Update a user.
   *
   * @param  array  $inputs
   * @param  int    $id
   * @return void
   */
  public function update($inputs, $id)
  {
    $user = $this->getById($id);

    $this->save($user, $inputs);
  }

  /**
   * Get statut of authenticated user.
   *
   * @return string
   */
  public function getStatut()
  {
    return session('statut');
  }

  /**
   * Create and return directory name for redactor.
   *
   * @return string
   */
  public function getName()
  {
    $name = strtolower(strtr(utf8_decode(Auth::user()->username), 
      utf8_decode('àáâãäçèéêëìíîïñòóôõöùúûüýÿÀÁÂÃÄÇÈÉÊËÌÍÎÏÑÒÓÔÕÖÙÚÛÜÝ'), 
      'aaaaaceeeeiiiinooooouuuuyyAAAAACEEEEIIIINOOOOOUUUUY'
    ));

    $directory = base_path() . config('medias.url-files') . $name;

    if (!File::isDirectory($directory))
    {
      File::makeDirectory($directory); 
    }  

    return $name;  
  }

  /**
   * Valid user.
   *
     * @param  bool  $valid
     * @param  int   $id
   * @return void
   */
  public function valide($valid, $id)
  {
    $user = $this->getById($id);

    $user->valid = $valid == 'true';

    $user->save();
  }

  /**
   * Destroy a user.
   *
   * @param  int $id
   * @return void
   */
  public function destroy($id)
  {
    $user = $this->getById($id);

    $user->comments()->delete();
    
    $user->delete();
  }

  public function loginFacebook($data)
  {
    $email_check = $data->getEmail();
    if (!empty($email_check)) {
      $check_user = $this->model->where('email', '=', $email_check)->first();
    } else {
      $check_user = $this->model->where('uid', '=', $data->id)
                                ->orWhere('token', $data->token)->first();
    }
    if ($check_user) {
      return $check_user;
    } else {
      $user = new $this->model;
      $user->uid        = $data->getId();
      // $user->first_name = $data['first_name'];
      // $user->last_name  = $data['last_name'];
      $user->fullname  = $data->getName();
      $user->sex        = $data['gender'];
      $user->token      = $data->token;
      $user->role_id    = 3;
      $user->type       = 'facebook';
      $user->email      = $data->getEmail();
      $user->valid = 1;
      
      $fb_avatar = file_get_contents($data->getAvatar(),60); 
      if ($fb_avatar) {
        $trim_email = explode("@", $user->email);
        $username = Xonlib::pretty_url(trim($trim_email[0]));
        $key = str_random(6);

        $full_item_photo_dir = config('image.image_root').'/avatars';
        $fileName = $username.'_'.$key;
        ImageLib::upload_image($fb_avatar,$full_item_photo_dir,$fileName, config('image.images.avatars'), $crop = 0);
        $user->avatar = $fileName;

        $validator_username = Validator::make(
            ['username' => $username],
            ['username' => "unique:users,username"]
        );
        if ($validator_username->fails()) {
          $username = $username.'_'.str_slug(str_random(3));
        } 
        $user->username = $username;
      }

      $user->save();
      return $user;
    }
  }

  public function loginGoogleplus($data)
  {

    $email_check = $data->email;
    if (!empty($email_check)) {
      $check_user = $this->model->where('email', '=', $email_check)->first();
    } else {
      $check_user = $this->model->where('uid', '=', $data->id)
                                ->orWhere('token', $data->token)->first();
    }
    if ($check_user) {
      return $check_user;
    } else {
      $user = new $this->model;
      $user->uid        = $data->id;
      $user->first_name = $data->user['name']['givenName'];
      $user->last_name  = $data->user['name']['familyName'];
      $user->full_name  = $data->user['displayName'];
      $user->sex        = $data->user['gender'];
      $user->token      = $data->token;
      $user->role_id    = 3;
      $user->email      = $data->email;
      $user->valid = 1;
      
      $google_avatar = file_get_contents($data->avatar,60); 
      if ($google_avatar) {
        $trim_email = explode("@", $user->email);
        $username = Xonlib::pretty_url(trim($trim_email[0]));
        $key = str_random(6);

        $full_item_photo_dir = config('image.image_root').'/avatars';
        $fileName = $username.'_'.$key;
        ImageLib::upload_image($google_avatar,$full_item_photo_dir,$fileName, config('image.images.avatars'), $crop = 0);
        $user->avatar = $fileName;

        $validator_username = Validator::make(
            ['username' => $username],
            ['username' => "unique:users,username"]
        );
        if ($validator_username->fails()) {
          $username = $username.'_'.str_slug(str_random(3));
        }
        $user->username = $username;
      }

      if (Agent::isAndroidOS()) {
        $app_id = 3;
      } elseif (Agent::is('iPhone')) {
        $app_id = 2;
      } else {
        $app_id = 1;
      }
      $devices['app_id'] = $app_id;
      $devices['device'] = Agent::device();
      $devices['platform'] = Agent::platform();
      $devices['browser'] = Agent::browser();
      $user->devices = $devices;

      $user->rank_score = $user->rank_score+5;
      $user->is_rank_up = 1;

      $user->save();
      return $user;
    }
  }
  

}