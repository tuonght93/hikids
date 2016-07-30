<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\City;
use Input, Validator;
use App\Libraries\ImageLib, App\Libraries\Xonlib;

class CityController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$this->data['citys'] = City::orderBy('id', 'desc')->get();
    	return view('back.city.index', $this->data);
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		$city = new City;
	    $this->data['city'] = $city;
	    return view('back.city.form', $this->data);
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$input_valid = [
	          'name'    => 'required',
	          'freeshipping'    => 'required',
	          'shippingcost'    => 'required',
	      ];
			$validator = Validator::make(
	      Input::all(),$input_valid
	    );
	    if ($validator->fails()) {
	      return back()->withErrors($validator->messages())
	                        ->withInput();
	    }

	    $city = new City;
	    
	    $city->name = Input::get('name');
	    if(!empty(Input::get('slug'))) {
	    	$slug = str_slug(Input::get('slug'), '-');;
	    	$validator_slug = Validator::make(
		        ['slug' => $slug],
		        ['slug' => "unique:cities,slug"]
		    );
		    if ($validator_slug->fails()) {
		      return back()->withErrors($validator_slug->messages())
	                        ->withInput();
		    } 
	    } else {
		    $slug = str_slug(Input::get('name'), '-');
		    $validator_slug = Validator::make(
		        ['slug' => $slug],
		        ['slug' => "unique:cities,slug"]
		    );
		    if ($validator_slug->fails()) {
		      $slug = $slug.'-'.str_slug(str_random(2));
		    } 
		}
	    $city->slug = $slug;
	    $city->freeshipping = 0+Input::get('freeshipping');
	    $city->shippingcost = 0+Input::get('shippingcost');
	    $city->save();
	  	return redirect('/manage/city')->withSuccess('Tạo mới thành công');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$city = City::find($id);
	    $this->data['city'] = $city;
	    return view('back.city.form', $this->data);
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$city = City::find($id);
	    $this->data['city'] = $city;
	    return view('back.city.form', $this->data);
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$input_valid = [
	          'name'    => 'required',
	          'freeshipping'    => 'required',
	          'shippingcost'    => 'required',
	      ];
	    $validator = Validator::make(
	      Input::all(),$input_valid
	    );
	    if ($validator->fails()) {
	      return back()->withErrors($validator->messages())
	                        ->withInput();
	    }

	    $city = City::find($id);
	    if (!$city) {
	    	return view('error.404');
	    }
	    
	    $city->name = Input::get('name');
	    if(!empty(Input::get('slug'))) {
	    	$slug = str_slug(Input::get('slug'), '-');;
	    	$validator_slug = Validator::make(
		        ['slug' => $slug],
		        ['slug' => "unique:cities,slug,".$id.",id"]
		    );
		    if ($validator_slug->fails()) {
		      return back()->withErrors($validator_slug->messages())
	                        ->withInput();
		    } 
	    } else {
		    $slug = str_slug(Input::get('name'), '-');
		    $validator_slug = Validator::make(
		        ['slug' => $slug],
		        ['slug' => "unique:cities,slug,".$id.",id"]
		    );
		    if ($validator_slug->fails()) {
		      $slug = $slug.'-'.str_slug(str_random(2));
		    } 
		}
	    $city->slug = $slug;
	    $city->freeshipping = 0+Input::get('freeshipping');
	    $city->shippingcost = 0+Input::get('shippingcost');
	    $city->save();

	    return redirect('/manage/city')->withSuccess('Cập nhật thành công');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		$city = City::find($id);
	    if ($city) {
	      $city->delete();
	      return redirect('/manage/city')->withSuccess('Xóa thành công');
	    } else {
	      return redirect('/manage/city')->withErrors('Xóa thất bại');
		}
	}

}
