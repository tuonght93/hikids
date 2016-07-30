<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\Page;
use Input, Validator;
use App\Libraries\ImageLib, App\Libraries\Xonlib;

class PageController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$this->data['pages'] = Page::orderBy('id', 'desc')->get();
    	return view('back.page.index', $this->data);
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		$page = new Page;
	    $this->data['page'] = $page;
	    return view('back.page.form', $this->data);
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

	    $page = new Page;
	    
	    $page->title = Input::get('title');
	    if(!empty(Input::get('slug'))) {
	    	$slug = str_slug(Input::get('slug'), '-');;
	    	$validator_slug = Validator::make(
		        ['slug' => $slug],
		        ['slug' => "unique:pages,slug"]
		    );
		    if ($validator_slug->fails()) {
		      return back()->withErrors($validator_slug->messages())
	                        ->withInput();
		    } 
	    } else {
		    $slug = str_slug(Input::get('title'), '-');
		    $validator_slug = Validator::make(
		        ['slug' => $slug],
		        ['slug' => "unique:pages,slug"]
		    );
		    if ($validator_slug->fails()) {
		      $slug = $slug.'-'.str_slug(str_random(2));
		    } 
		}
	    $page->slug = $slug;
	    $page->content = Input::get('content');
	    $page->save();

	      // Making counting of uploaded images
	    if (Input::hasFile('image_upload')) { 
	      $key = str_random(6);            
	      $full_item_photo_dir = config('image.image_root').'/pages';
	      $fileName = $page->slug.'_'.$key;
	      ImageLib::upload_image(Input::file('image_upload'), $full_item_photo_dir, $fileName, config('image.images.pages'), 0);        
	      $page->thumbnail = $fileName;
	      $page->save();
	    }
	  	return redirect('/manage/page')->withSuccess('Tạo mới thành công');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$page = Page::find($id);
	    $this->data['page'] = $page;
	    return view('back.page.form', $this->data);
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$page = Page::find($id);
	    $this->data['page'] = $page;
	    return view('back.page.form', $this->data);
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

	    $page = Page::find($id);
	    if (!$page) {
	    	return view('error.404');
	    }
	    
	    $page->title = Input::get('title');
	    if(!empty(Input::get('slug'))) {
	    	$slug = str_slug(Input::get('slug'), '-');;
	    	$validator_slug = Validator::make(
		        ['slug' => $slug],
		        ['slug' => "unique:pages,slug,".$id.",id"]
		    );
		    if ($validator_slug->fails()) {
		      return back()->withErrors($validator_slug->messages())
	                        ->withInput();
		    } 
	    } else {
		    $slug = str_slug(Input::get('title'), '-');
		    $validator_slug = Validator::make(
		        ['slug' => $slug],
		        ['slug' => "unique:pages,slug,".$id.",id"]
		    );
		    if ($validator_slug->fails()) {
		      $slug = $slug.'-'.str_slug(str_random(2));
		    } 
		}
	    $page->slug = $slug;
	    $page->content = Input::get('content');
	    $page->save();

	      // Making counting of uploaded images
	    if (Input::hasFile('image_upload')) { 
	      $key = str_random(6);            
	      $full_item_photo_dir = config('image.image_root').'/pages';
	      $fileName = $page->slug.'_'.$key;
	      ImageLib::upload_image(Input::file('image_upload'), $full_item_photo_dir, $fileName, config('image.images.pages'), 0);
	      if (!empty($page->thumbnail)) {
	          ImageLib::delete_image($full_item_photo_dir, $page->thumbnail, config('image.images.pages'));
	      }
	      $page->thumbnail = $fileName;
	      $page->save();
	    }

	    return redirect('/manage/page')->withSuccess('Cập nhật thành công');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		$page = Page::find($id);
	    if ($page) {      
	      //delete photo record      
	      if (!empty($page->thumbnail)) {
	      	$full_item_photo_dir = config('image.image_root').'/pages';
	        ImageLib::delete_image($full_item_photo_dir, $page->thumbnail, config('image.images.pages'));
	      }
	      $page->delete();
	      return redirect('/manage/page')->withSuccess('Xóa thành công');
	    } else {
	      return redirect('/manage/page')->withErrors('Xóa thất bại');
		}
	}

}
