<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\District, App\Models\City;
use Input, Validator;
use App\Libraries\ImageLib, App\Libraries\Xonlib;

class DistrictController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$this->data['cities'] = City::all();
		$this->data['districts'] = District::orderBy('id', 'desc')->get();
    	return view('back.district.index', $this->data);
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		$this->data['cities'] = City::all();
		$district = new District;
	    $this->data['district'] = $district;
	    return view('back.district.form', $this->data);
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
	      ];
			$validator = Validator::make(
	      Input::all(),$input_valid
	    );
	    if ($validator->fails()) {
	      return back()->withErrors($validator->messages())
	                        ->withInput();
	    }

	    $district = new District;
	    
	    $district->name = Input::get('name');
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
		        ['slug' => "unique:districts,slug"]
		    );
		    if ($validator_slug->fails()) {
		      $slug = $slug.'-'.str_slug(str_random(2));
		    } 
		}
	    $district->slug = $slug;
	    $district->city_id = Input::get('city');
	    $district->shippingfast = 0+Input::get('shippingfast');
	    $district->save();
	  	return redirect('/manage/district')->withSuccess('Tạo mới thành công');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$this->data['cities'] = City::all();
		$district = District::find($id);
	    $this->data['district'] = $district;
	    return view('back.district.form', $this->data);
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$this->data['cities'] = City::all();
		$district = District::find($id);
	    $this->data['district'] = $district;
	    return view('back.district.form', $this->data);
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
	      ];
	    $validator = Validator::make(
	      Input::all(),$input_valid
	    );
	    if ($validator->fails()) {
	      return back()->withErrors($validator->messages())
	                        ->withInput();
	    }

	    $district = District::find($id);
	    if (!$district) {
	    	return view('error.404');
	    }
	    
	    $district->name = Input::get('name');
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
		        ['slug' => "unique:districts,slug,".$id.",id"]
		    );
		    if ($validator_slug->fails()) {
		      $slug = $slug.'-'.str_slug(str_random(2));
		    } 
		}
	    $district->slug = $slug;
	    $district->city_id = Input::get('city');
	    $district->shippingfast = 0+Input::get('shippingfast');
	    $district->save();

	    return redirect('/manage/district')->withSuccess('Cập nhật thành công');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		$district = District::find($id);
	    if ($district) {
	      $district->delete();
	      return redirect('/manage/district')->withSuccess('Xóa thành công');
	    } else {
	      return redirect('/manage/district')->withErrors('Xóa thất bại');
		}
	}

}
