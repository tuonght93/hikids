<?php namespace App\Http\Controllers\Admin;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\User, App\Models\Role, App\Models\City;
use Input, Validator, Auth;
use App\Libraries\ImageLib, App\Libraries\Xonlib;

class UserController extends Controller {

  /**
   * Display a listing of the resource.
   *
   * @return Response
   */
  protected $per_page = 50;

  public function __construct()
  {
    $this->data = array();
  }

  public function index()
  {
    $this->data['admin_count'] = User::where('role_id', '=', 1)->count();
    $this->data['editor_count'] = User::where('role_id', '=', 2)->count();
    $this->data['user_count'] = User::where('role_id', '=', 3)->count();
    $this->data['disable_count'] = User::where('status', '=', 0)->count();
    $this->data['total'] = User::count();
    return view('back.users.index', $this->data);
  }

  public function search()
  {
    $requestData= $_REQUEST;

    $columns = array( 
      0 => 'id', 
      1 => 'username',
      2 => 'email',
      3 => 'role_id',
      4 => 'created_at'
    );

    $start = isset($requestData['start']) ? $requestData['start'] : 0 ;
    $sort = isset($requestData['order'][0]['dir']) && $requestData['order'][0]['dir'] == 'asc' ? 'asc' : 'desc';

    $total= User::count();
    $search = isset($requestData['search']['value']) ? $requestData['search']['value'] : '';
    if (empty($search)) {
        $totalFilter = User::count();
        $users = User::orderBy($columns[$requestData['order'][0]['column']], $sort)->orderBy('id', 'desc')->get();
    } else {
    $totalFilter = User::where('username', 'like', '%'.$requestData['search']['value'].'%')->count();
    $users = User::where('username', 'like', '%'.$requestData['search']['value'].'%')->orWhere('email', 'like', '%'.$requestData['search']['value'].'%')->orWhere('full_name', 'like', '%'.$requestData['search']['value'].'%')->skip($start)->take($requestData['length'])->orderBy($columns[$requestData['order'][0]['column']], $sort)->orderBy('id', 'desc')->get();
    }
    $data = array();
    $i = 1+$start;
    foreach ($users as $user) {
      $nestedData=array();
      $nestedData[] = $i;
      if (empty($user->avatar)) {
        $img = '<img alt="'.$user->full_name.'" src="/images/user.png">';
      } else {
        $img = '<img alt="'.$user->full_name.'" src="'.config('image.image_url').'/avatars/'.$user->avatar.'_40x40.png">';
      }
      $nestedData[] = '<div class="row"><div class="col-sm-3">'.$img.'</div><div class="col-sm-6"> <strong>'.$user->username.'</strong><br/>'.$user->full_name.'</div></div>';
      $nestedData[] = $user->email;     
      $nestedData[] = $user->role->name;
      switch ($user->finish_status) {
        case 1:
          $status = 'Đã gửi';
          break;
        case 2:
          $status = 'Đang cập nhật';
          break;     
        default:
          $status = 'Chưa nhập';
          break;
      }
      $nestedData[] = $status;
      if (is_null($user->status) || $user->status == 1) {
        $action = '<a class="btn btn-primary btn-xs" user-id="'.$user->id.'" href="'.url('/manage/user/'.$user->id.'/edit').'" data-original-title="Edit" data-toggle="tooltip"><i class="fa fa-pencil"></i></a> <button data-toggle="modal" data-target="#mod-error" class="lock_user btn btn-success btn-xs" user-id="'.$user->id.'" user-status="1" ><i class="fa fa-unlock"></i></button>';
        $action = $action.'<button data-toggle="modal" data-target="#mod-error" class="delete_user btn btn-danger btn-xs" user-id="'.$user->id.'"  ><i class="fa fa-times"></i></button>';
        $nestedData[] = $action;
      } else {
        $action = '<a class="btn btn-primary btn-xs" user-id="'.$user->id.'" href="'.url('/manage/user/'.$user->id.'/edit').'" data-original-title="Edit" data-toggle="tooltip"><i class="fa fa-pencil"></i></a> <button data-toggle="modal" data-target="#mod-error" class="lock_user btn btn-danger btn-xs" user-id="'.$user->id.'" user-status="0" ><i class="fa fa-lock"></i></button>';
        $action = $action.'<button data-toggle="modal" data-target="#mod-error" class="delete_user btn btn-danger btn-xs" user-id="'.$user->id.'"  ><i class="fa fa-times"></i></button>';
        $nestedData[] = $action;
      }
      
      $data[] = $nestedData;
      $i++;
    }

    $json_data = array(
                "draw"            => intval( $_REQUEST['draw'] ),
                "recordsTotal"    => $total,
                "recordsFiltered" => $totalFilter,
                "data"            => $data
            );

    return response()->json($json_data);
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return Response
   */
  public function create()
  {
    $this->data['roles'] = Role::all();
    $this->data['user'] = new User;
    $this->data['cities'] = City::orderBy('name', 'asc')->get();
    return view('back.users.form', $this->data);
  }

  /**
   * Store a newly created resource in storage.
   *
   * @return Response
   */
  public function store()
  {
    $object_validator = [
                          'username'    => 'required|unique:users,username|min:4',
                          'email'     => 'required|unique:users,email|email',
                          'password'     => 'required|confirmed|min:4',
                      ];    
    $validator = Validator::make(
      Input::all(),
      $object_validator
    );
    if ($validator->fails()) {
      return back()->withErrors($validator->messages())
                        ->withInput();
    }

    $user = new User;
    $user->username = Input::get('username');
    $user->password = bcrypt(Input::get('password'));
    $user->email = Input::get('email');
    $user->role_id = 0+Input::get('role');
    $user->status = 1;
    $user->city = Input::get('city');
    $user->save();

    return redirect('/manage/user')->withSuccess('Tạo mới thành công');
  }

  /**
   * Display the specified resource.
   *
   * @param  int  $id
   * @return Response
   */
  public function show($id)
  {
    $user = User::find($id);
    if (!$user) {
      return view('errors.404');
    } else {
      $this->data['roles'] = Role::all();
      $this->data['cities'] = City::orderBy('name', 'asc')->get();
      $this->data['user'] = $user;
      return view('back.users.form', $this->data);
    }  
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  int  $id
   * @return Response
   */
  public function edit($id)
  {
    $user = User::find($id);
    if (!$user) {
      return view('errors.404');
    } else {
      $this->data['roles'] = Role::all();
      $this->data['cities'] = City::orderBy('name', 'asc')->get();
      $this->data['user'] = $user;
      return view('back.users.form', $this->data);
    }  
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  int  $id
   * @return Response
   */
  public function update($id)
  {
    $password = Input::get('password');
    $object_validator = [
                          'email'     => 'required|unique:users,email,'.$id.',id|email',
                          'username' => "required|unique:users,username,".$id.",id",
                      ];
                      
    if (!empty($password)) {
      $object_validator['password'] = 'required|confirmed|min:4';
    }
   
    $validator = Validator::make(Input::all(), $object_validator);
   
    if ($validator->fails()) {
      return back()->withErrors($validator->messages())
                        ->withInput();
    }
    $user = User::find($id);
    if (!$user) {
      return view('errors.404');
    } else {
      if (!empty($password)) {
        $user->password = bcrypt(Input::get('password'));
      }
      $user->username = Input::get('username');
      $user->email = Input::get('email');
      $user->role_id = 0+Input::get('role');
      $user->city = Input::get('city');
      $user->save();
      return redirect('/manage/user')->withSuccess('Cập nhật thành công');
    }
    
  }

  public function updateStatus($id)
  {
    $user = User::find($id);
    if (!$user) {
      return view('errors.404');
    } else {
      if (is_null($user->status) || $user->status == 1)   {
        $user->status = 0;
      } else {
        $user->status = 1;
      }
      $user->save();
      return redirect('/manage/user')->withSuccess('Cập nhật thành công');
    }
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  int  $id
   * @return Response
   */
  public function destroy($id)
  {
    $user = User::find($id);
    if ($user) {
      if (!empty($user->avatar)) {
        $full_item_photo_dir = config('image.image_root').'/avatars';
        ImageLib::delete_image($full_item_photo_dir, $user->avatar, config('image.images.avatars'));
      }
      $user->delete();
      return redirect('/manage/user')->withSuccess('Xóa thành công');
    } else {
      return redirect('/manage/user')->withErrors('Xóa thất bại');
    }
  }

}
