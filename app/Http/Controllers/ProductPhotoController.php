<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\ProductPhoto;
use Input, Validator;
use App\Libraries\ImageLib, App\Libraries\Xonlib;

class ProductPhotoController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		//
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		//
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		//
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		//
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		//
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		//
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		$productPhoto = ProductPhoto::find($id);
    if ($productPhoto) {
      $productPhoto->delete();
      $data['status'] = 200;
    } else {
      $data['status'] = 1;
    }
    $product = $productPhoto->product;
    $date_dir_name = md5(date_format($product->created_at, 'm-Y'));
    $full_item_photo_dir = config('image.image_root').'/products/'.$date_dir_name.'/'.$product->_id;
    ImageLib::delete_image($full_item_photo_dir, $productPhoto->image, config('image.images.products'));
    return response()->json($data);
	}

}
