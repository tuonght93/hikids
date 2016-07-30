<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\Size;
use Input, Validator;
use App\Libraries\ImageLib, App\Libraries\Xonlib;

class SizeController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$this->data['sizes'] = Size::orderBy('id', 'desc')->get();
    	return view('back.size.index', $this->data);
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		$size = new Size;
	    $this->data['size'] = $size;
	    return view('back.size.form', $this->data);
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
	      ];
			$validator = Validator::make(
	      Input::all(),$input_valid
	    );
	    if ($validator->fails()) {
	      return back()->withErrors($validator->messages())
	                        ->withInput();
	    }

	    $size = new Size;
	    
	    $size->title = Input::get('title');
	    $size->content = Input::get('content');
	    $size->save();
	  	return redirect('/manage/size')->withSuccess('Tạo mới thành công');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$size = Size::find($id);
	    $this->data['size'] = $size;
	    return view('back.size.form', $this->data);
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$size = Size::find($id);
	    $this->data['size'] = $size;
	    return view('back.size.form', $this->data);
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
	      ];
	    $validator = Validator::make(
	      Input::all(),$input_valid
	    );
	    if ($validator->fails()) {
	      return back()->withErrors($validator->messages())
	                        ->withInput();
	    }

	    $size = Size::find($id);
	    if (!$size) {
	    	return view('error.404');
	    }
	    
	    $size->title = Input::get('title');
	    $size->content = Input::get('content');
	    $size->save();
	    

	    return redirect('/manage/size')->withSuccess('Cập nhật thành công');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		$size = Size::find($id);
	    if ($size) {      
	      $size->delete();
	      return redirect('/manage/size')->withSuccess('Xóa thành công');
	    } else {
	      return redirect('/manage/size')->withErrors('Xóa thất bại');
		}
	}

}
