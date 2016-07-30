<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\Color;
use Input, Validator;
use App\Libraries\ImageLib, App\Libraries\Xonlib;

class ColorController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$this->data['colors'] = Color::orderBy('id', 'desc')->get();
    	return view('back.color.index', $this->data);
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		$color = new Color;
	    $this->data['color'] = $color;
	    return view('back.color.form', $this->data);
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$input_valid = [
	          'title'    => 'required',
	          'content'  => 'required',
	          'image_upload'    => 'mimes:jpeg,bmp,png',
	      ];
			$validator = Validator::make(
	      Input::all(),$input_valid
	    );
	    if ($validator->fails()) {
	      return back()->withErrors($validator->messages())
	                        ->withInput();
	    }

	    $color = new Color;
	    
	    $color->title = Input::get('title');
	    if(!empty(Input::get('slug'))) {
	    	$slug = str_slug(Input::get('slug'), '-');;
	    	$validator_slug = Validator::make(
		        ['slug' => $slug],
		        ['slug' => "unique:colors,slug"]
		    );
		    if ($validator_slug->fails()) {
		      return back()->withErrors($validator_slug->messages())
	                        ->withInput();
		    } 
	    } else {
		    $slug = str_slug(Input::get('title'), '-');
		    $validator_slug = Validator::make(
		        ['slug' => $slug],
		        ['slug' => "unique:colors,slug"]
		    );
		    if ($validator_slug->fails()) {
		      $slug = $slug.'-'.str_slug(str_random(2));
		    } 
		}
	    $color->slug = $slug;
	    $color->content = Input::get('content');
	    $color->save();

	      // Making counting of uploaded images
	    if (Input::hasFile('image_upload')) { 
	      $key = str_random(6);            
	      $full_item_photo_dir = config('image.image_root').'/colors';
	      $fileName = $color->slug.'_'.$key;
	      ImageLib::upload_image(Input::file('image_upload'), $full_item_photo_dir, $fileName, config('image.images.colors'), 0);        
	      $color->thumbnail = $fileName;
	      $color->save();
	    }
	  	return redirect('/manage/color')->withSuccess('Tạo mới thành công');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$color = Color::find($id);
	    $this->data['color'] = $color;
	    return view('back.color.form', $this->data);
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$color = Color::find($id);
	    $this->data['color'] = $color;
	    return view('back.color.form', $this->data);
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
	          'title'    => 'required',
	          'content'  => 'required',
	          'image_upload'    => 'mimes:jpeg,bmp,png',
	      ];
	    $validator = Validator::make(
	      Input::all(),$input_valid
	    );
	    if ($validator->fails()) {
	      return back()->withErrors($validator->messages())
	                        ->withInput();
	    }

	    $color = Color::find($id);
	    if (!$color) {
	    	return view('error.404');
	    }
	    
	    $color->title = Input::get('title');
	    if(!empty(Input::get('slug'))) {
	    	$slug = str_slug(Input::get('slug'), '-');;
	    	$validator_slug = Validator::make(
		        ['slug' => $slug],
		        ['slug' => "unique:colors,slug,".$id.",id"]
		    );
		    if ($validator_slug->fails()) {
		      return back()->withErrors($validator_slug->messages())
	                        ->withInput();
		    } 
	    } else {
		    $slug = str_slug(Input::get('title'), '-');
		    $validator_slug = Validator::make(
		        ['slug' => $slug],
		        ['slug' => "unique:colors,slug,".$id.",id"]
		    );
		    if ($validator_slug->fails()) {
		      $slug = $slug.'-'.str_slug(str_random(2));
		    } 
		}
	    $color->slug = $slug;
	    $color->content = Input::get('content');
	    $color->save();

	      // Making counting of uploaded images
	    if (Input::hasFile('image_upload')) { 
	      $key = str_random(6);            
	      $full_item_photo_dir = config('image.image_root').'/colors';
	      $fileName = $color->slug.'_'.$key;
	      ImageLib::upload_image(Input::file('image_upload'), $full_item_photo_dir, $fileName, config('image.images.colors'), 0);
	      if (!empty($color->thumbnail)) {
	          ImageLib::delete_image($full_item_photo_dir, $color->thumbnail, config('image.images.colors'));
	      }
	      $color->thumbnail = $fileName;
	      $color->save();
	    }

	    return redirect('/manage/color')->withSuccess('Cập nhật thành công');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		$color = Color::find($id);
	    if ($color) {      
	      //delete photo record      
	      if (!empty($color->thumbnail)) {
	      	$full_item_photo_dir = config('image.image_root').'/colors';
	        ImageLib::delete_image($full_item_photo_dir, $color->thumbnail, config('image.images.colors'));
	      }
	      $color->delete();
	      return redirect('/manage/color')->withSuccess('Xóa thành công');
	    } else {
	      return redirect('/manage/color')->withErrors('Xóa thất bại');
		}
	}

}
