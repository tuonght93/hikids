<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Validator;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;

use Input, Auth;

class AuthController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Registration & Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users, as well as the
    | authentication of existing users. By default, this controller uses
    | a simple trait to add these behaviors. Why don't you explore it?
    |
    */

    use AuthenticatesAndRegistersUsers, ThrottlesLogins;

    /**
     * Where to redirect users after login / registration.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new authentication controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest', ['except' => 'logout']);
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|confirmed|min:6',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
        ]);
    }

    public function postLogin()
    {
      $username = Input::get('username');
      $password = Input::get('password');
      $credentials = ['username' => $username, 'password' => $password ];
      if (Auth::attempt($credentials, Input::has('remember')))
      {
        $user = Auth::user();
        if ($user->isAdmin()) {
          return redirect()->to('/manage');
        } else {
          return redirect()->to('/');
        }
      }
      return redirect('/manage/login')->withErrors("Tài khoản hoặc mật khẩu không đúng!");
    }

    public function getRegister()
    {
      return view('auth.register');
    }

    public function postRegister()
    {
      
    }

    // public function getLogin()
    // {
    //   if (Auth::check()) {
    //     return redirect('/');
    //   } else {
    //     $user = User::where('username', '=', 'admin')->first();
    //     if (!$user) {
    //         $user = new User;
    //         $user->username = 'admin';
    //         $user->password = bcrypt('123456');
    //         $user->email = 'admin@gmail.com';
    //         $user->save();
    //     }
    //     return view('auth.login');
    //   }      
    // }

    // public function getLogout()
    // {
    //     echo 'abc';die;
    //   Auth::logout();
    //   return redirect('/login');
    // }
}
