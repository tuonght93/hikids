<?php

/*
|--------------------------------------------------------------------------
| Routes File
|--------------------------------------------------------------------------
|
| Here is where you will register all of the routes in an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| This route group applies the "web" middleware group to every route
| it contains. The "web" middleware group is defined in your HTTP
| kernel and includes session state, CSRF protection, and more.
|
*/


Route::group(['middleware' => 'web'], function(){

  Route::get('/test', 'User\HomeController@test');

  Route::get('/', 'User\HomeController@index');

  //Search
  Route::get('search', 'User\HomeController@search');

  //Product
  Route::get('product/{slug}', 'User\ProductController@show');
  Route::post('product/addsize', 'User\ProductController@addsize');

  //Page
  Route::get('page/{slug}', 'User\PageController@show');

  //Product Category

  Route::get('category/{one?}/{two?}', 'User\ProductCategoryController@show');
  Route::get('categories/{slug}', 'User\ProductCategoryController@categoryShow');

  //Add product cart

  Route::get('cart', 'User\ProductCartController@index');
  Route::post('cart', 'User\ProductCartController@show');
  Route::get('cart/destroy/{id}', 'User\ProductCartController@destroy');
  Route::post('cart/update', 'User\ProductCartController@update');

  //Checkout
  Route::get('checkout', 'User\CheckoutController@create');
  Route::post('checkout', 'User\CheckoutController@store');
  Route::get('checkout/thankyou/{code}', 'User\CheckoutController@thankyou');
  Route::post('checkout/adddistrict', 'User\CheckoutController@adddistrict');
  Route::post('checkout/addform', 'User\CheckoutController@addform');

  //login fb
  Route::get('facebook', 'User\UserController@facebook_redirect');
     // Get back to redirect url
  Route::get('account/facebook', 'User\UserController@facebook');

  Route::post('user/loginCallback', 'User\UserController@loginCallback');

  //User
  Route::group(['prefix' => 'user'], function()
  {
    //Login
    Route::get('/login', 'User\UserController@getLogin');
    Route::post('/login', 'User\UserController@postLogin');
    //Register
    Route::get('/register', 'User\UserController@getRegister');
    Route::post('/register', 'User\UserController@postRegister');
    Route::get('/forgetPassword', 'User\UserController@getForgetPassword');
    Route::post('/forgetPassword', 'User\UserController@postForgetPassword');
    Route::get('/passwordEmailReset', 'User\UserController@getPasswordEmailReset');
    Route::post('/passwordEmailReset', 'User\UserController@postPasswordEmailReset');
    Route::get('/activeAccount','User\UserController@getActiveAccount');
    Route::get('/logout', function (){
      Auth::logout();
      return redirect('/');
    });
  });




	Route::group(['prefix' => 'manage'], function()
  {
    Route::get('/login', function (){
      if (Auth::check()) {
        return redirect('/manage');
      }
        return view('auth.login');
      
    });
    Route::get('/logout', function (){
      Auth::logout();
      return redirect('/manage/login');
    });
    Route::post('/login', 'Auth\AuthController@postLogin');
    Route::group(['middleware' => 'auth'], function()
    {
      Route::group(['middleware' => 'admin'], function()
      {
        //Dashboard
        Route::get('/', 'DashboardController@index2');

        //User
        Route::post('/user/search', 'Admin\UserController@search');
        Route::get('/user/search', 'Admin\UserController@search');
        Route::post('/user/{id}/updateStatus', 'Admin\UserController@updateStatus');
        Route::post('/user/{id}/destroy', 'Admin\UserController@destroy');
        Route::resource('user', 'Admin\UserController');

        //Product
        Route::post('/product/search', 'ProductController@search');
        Route::get('/product/search', 'ProductController@search');
        Route::post('/product/{id}/updateStatus', 'ProductController@updateStatus');
        Route::post('/product/{id}/destroy', 'ProductController@destroy');
        Route::resource('product', 'ProductController');

        //ProductCategory
        Route::post('/productCategory/{id}/destroy', 'ProductCategoryController@destroy');
        Route::resource('productCategory', 'ProductCategoryController');
        //Brand
        Route::post('/brand/{id}/destroy', 'BrandController@destroy');
        Route::resource('brand', 'BrandController');
        //Color
        Route::post('/color/{id}/destroy', 'ColorController@destroy');
        Route::resource('color', 'ColorController');
        //Page
        Route::post('/page/{id}/destroy', 'PageController@destroy');
        Route::resource('page', 'PageController');

        //City
        Route::post('/city/{id}/destroy', 'CityController@destroy');
        Route::resource('city', 'CityController');

        //District
        Route::post('/district/{id}/destroy', 'DistrictController@destroy');
        Route::resource('district', 'DistrictController');

        //Size
        Route::post('/size/{id}/destroy', 'SizeController@destroy');
        Route::resource('size', 'SizeController');

        //Slide
        Route::post('/slide/{id}/destroy', 'SlideController@destroy');
        Route::resource('slide', 'SlideController');
        //Order
        Route::post('/order/search', 'OrderController@search');
        Route::get('/order/search', 'OrderController@search');
        Route::get('/order/ajaxSearch', 'OrderController@ajaxSearch');
        Route::post('/order/ajaxSearch', 'OrderController@ajaxSearch');
        Route::post('/order/{id}/updateOrder', 'OrderController@updateOrder');
        Route::post('/order/{id}/destroy', 'OrderController@destroy');
        Route::resource('order', 'OrderController');

        Route::resource('productPhoto', 'ProductPhotoController');
      });
    });
  });

	
  
});





