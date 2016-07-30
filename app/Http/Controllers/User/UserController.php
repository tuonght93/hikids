<?php

namespace App\Http\Controllers\User;

use App\Models\User;
use Validator, Session;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
use Illuminate\Contracts\Auth\Guard;
use App\Repositories\UserRepository;
use Socialite, Redirect;
use App\Models\ProductCategory;
use Cart;
use Input, Auth,Image,Mail;

use App\Libraries\ImageLib, App\Libraries\Xonlib;

class UserController extends Controller
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
    public function __construct(Guard $auth)
    {
      parent::__construct();
      $this->auth = $auth;
      $this->middleware('guest', ['except' => 'getLogout']);
    }

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

    public function getLogin()
    {
      $this->data['seo'] = Xonlib::create_seo('Đăng nhập | Hikids');
      return view('user.login', $this->data);
    }

    public function postLogin()
    {
      $username = Input::get('username');
      $password = Input::get('password');
      $credentials = ['username' => $username, 'password' => $password ];
      if (Auth::attempt($credentials))
      {
        $user = Auth::user();
        if($user->status == 1)
        {
          if ($user->isUser()) {
            return redirect()->to('/');
          } else {
            Auth::logout();
            return redirect('/user/login')->withErrors("Tài khoản hoặc mật khẩu không đúng!");
          }
        } else {
          Auth::logout();
          return redirect('/user/login')->withErrors("Tài khoản của bạn chưa được kích hoạt!");
        }
         
      }
      return redirect('/user/login')->withErrors("Tài khoản hoặc mật khẩu không đúng!");
    }

    public function getRegister()
    {

      // $params = [
      //             'title' => 'Kích hoạt tài khoản',
      //             'intro' => 'Chào bạnShopxxx gửi bạn đường dẫn kích hoạt tài khoản',
      //             'expire' =>'Xin vui lòng truy cập vào đường dẫn trên để kích hoạt tài khoản của bạn.<br/> Xin cảm ơn!',
      //             'link' => ''
      //   ];
      //   Mail::queue('emails.auth.registerActive', $params, function($message) {
      //           $message->to('tuonghttt52@gmail.com', 'Happy skin')
      //               ->subject('Kích hoạt tài khoản');
      //   });


      //   die;
      $this->data['seo'] = Xonlib::create_seo('Đăng ký | Hikids');
      return view('user.register', $this->data);
    }

    public function postRegister()
    {
      $object_validator = [
                            'username'    => 'required|unique:users,username|min:4',
                            'email'     => 'required|unique:users,email|email',
                            'password'     => 'required|confirmed|min:4',
                            'fullname'     => 'required',
                        ];    
      $validator = Validator::make(
        Input::all(),
        $object_validator
      );
      if ($validator->fails()) {
        return back()->withErrors($validator->messages())
                          ->withInput();
      }      
        $user=new User;
        $confirmation_code = str_random(30);
        $user->username = Input::get('username');
        $user->email=Input::get('email');
        $user->phone=Input::get('phone');
        $user->password = bcrypt(Input::get('password'));
        $user->fullname = Input::get('fullname');
        $user->city = Input::get('city');
        $user->role_id=3;
        $user->status=0;
        $user->avatar = '';
        $user->confirmation_code=$confirmation_code;
        $user->save();
        $active_link = env('HOME_URL').'user/activeAccount?key='.base64_encode($user->email.'|'.$user->confirmation_code);
        $name = $user->fullname !=''? $user->fullname : $user->username;
        $params = [
                  'title' => 'Kích hoạt tài khoản',
                  'intro' => 'Chào bạn '.$name.'!.<br/>Hikids.vn gửi bạn đường dẫn kích hoạt tài khoản '.$user->username.':',
                  'expire' =>'Xin vui lòng truy cập vào đường dẫn trên để kích hoạt tài khoản của bạn.<br/> Xin cảm ơn!',
                  'link' => $active_link
        ];
        Mail::queue('emails.auth.registerActive', $params, function($message) {
                $message->to(Input::get('email'), 'Hikids')
                    ->subject('Kích hoạt tài khoản');
        });
        return back()->withSuccess('Đăng ký thành công, vui lòng vào email xác nhận tài khoản');

    }

    
    public function getForgetPassword()
    {
      $this->data['seo'] = Xonlib::create_seo('Quên mật khẩu | Hikids');
      return view('user.forgetpassword', $this->data);
    }

    public function postForgetPassword()
    {
      $email = Input::get('email');

      $user = User::where('email','=',$email)->first();

      if(!$user){
        return redirect()->back()->withErrors('Email không tồn tại');
      }

      if($user->confirmation_code != '')
      {
        return redirect()->back()->withErrors('Tài khoản của bạn chưa được kích hoạt, vui lòng vào email để kích hoạt tài khoản');
      }

      $hash=bcrypt('secret');
      $user->password_reset_hash = $hash;
      $user->save();
      $forgot_link = env('HOME_URL').'user/passwordEmailReset?key='.base64_encode($email.'|'.$hash);
      $params = [
          'title' => 'Khôi phục mật khẩu',
          'intro' => 'Hikids gửi đường dẫn khôi phục mật khẩu',
          'expire' => 'Xin vui lòng truy cập đường link trên để khôi phục mật khẩu',
          'link' => $forgot_link
      ];
      Mail::queue('emails.auth.forgetPassword',$params, function($message){
        $message->to(Input::get('email'), 'Hikids')->subject('khoi phuc mat khau');

      });
      return redirect()->back()->withSuccess('Hikids đã gửi email khôi phục tài khoản vào địa chỉ email '.$email.'. Bạn hãy vào email của mình để khôi phục lại mật khẩu. Xin cảm ơn!');
    }

    public function getPasswordEmailReset()
    {
      $hash_key = Input::get('key');
      if($hash_key){
        $hkey_decode = base64_decode($hash_key);
        $harr = explode('|', $hkey_decode);
        if(count($harr)==2){
          list($email, $hash) = $harr;
          if(!empty($email) && !empty($hash)){
            $user = User::where('email','=',$email)->first();
            $date = date('Y-m-d h:i:s');
            $date_bebor_24h = strtotime($user->updated_at.' +1day');
            if($date_bebor_24h > strtotime($date)){
              if($user && $user->password_reset_hash==$hash){
                $this->data['hash_key']=$hash_key;
                $this->data['seo'] = Xonlib::create_seo('Khôi phục mật khẩu | Hikids');
                return view('user.emailresetpassword',$this->data);
              }
            }
          }
        }
        return redirect('/');
      }
      return redirect('/');
    }

    public function postPasswordEmailReset()
    {
      $rules = array(
            'hash_key'=>'required',
            'password'=>'required|confirmed|min:6',
          );
      $validation = Validator::make(Input::all(), $rules);
      if ($validation->fails())
      {
        return redirect()->back()->withErrors('Vui lòng nhập đúng mật khẩu');
      }
      $hkey_decode = base64_decode(Input::get('hash_key'));
      $harr = explode('|', $hkey_decode);
      if(count($harr)==2)
      {
        list($email, $hash) = $harr;
        if(!empty($email) && !empty($hash)){
          $user = User::where('email','=',$email)->first();
          $date = date('Y-m-d h:i:s');
          $date_befor_24h = strtotime($user->updated_at.' +1day');
              if ($date_befor_24h > strtotime($date)) {   
                if($user && $user->password_reset_hash==$hash) {                    
                    $user->password = bcrypt(Input::get('password'));
                    $user->password_reset_hash = '';
                    $user->save();
                    //$credentials = array('email' => $user->email, 'password' => Input::get('password'));
                    return redirect('/user/login')->withSuccess('Đổi mật khẩu thành công, vui lòng đăng nhập lại để kết nối với chúng tôi');;
                }
              }
        }
      }
    }

    public function getActiveAccount()
    {
      $hash_key = Input::get('key');
      if($hash_key) {
        // decode hash
        $hkey_decode =  base64_decode($hash_key);
        $harr = explode("|", $hkey_decode);
        if(count($harr)==2) {
          list($email, $hash) = $harr;
          if(!empty($email) && !empty($hash)) {
            $user = User::where('email', '=' , $email)->first();

            if($user && $user->confirmation_code==$hash) {
              $user->confirmation_code = '';
              $user->status = 1;
              $user->save();
              
              Auth::login( $user );
              return redirect('/');
            }

          }
        }
      }
      return redirect('/');
    }

    public function facebook_redirect() {
      return Socialite::driver('facebook')->redirect();
    }

    public function facebook(UserRepository $user_gestion) {
      $data = Socialite::driver('facebook')->user();
      $user = $user_gestion->loginFacebook($data);
      $this->auth->login($user);
      return redirect('/');
    }

    public function loginCallback()
    {
      // $cities = City::arrayCity();
      // $cities['0'] = 'Tỉnh/Thành phố';
      $data['name'] = 'Đăng nhập';
      $data['cities'] = $cities;
      //$data['url_callback'] = Input::get('url_callback');
      //$data['callback_content'] = Input::get('callback_content');
      $data['seo'] = Xonlib::create_seo('Đăng nhập | Happy Skin');
      
      Session::put('url_callback', Input::get('url_callback'));
      Session::put('callback_tab', Input::get('callback_tab'));
      Session::put('content_callback', Input::get('callback_content'));
      return view('auth.login', $data);
    }
}
