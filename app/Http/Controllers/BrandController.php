<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\Brand;
use Input, Validator;
use App\Libraries\ImageLib, App\Libraries\Xonlib;

class BrandController extends Controller {

  /**
   * Display a listing of the resource.
   *
   * @return Response
   */
  public function index()
  {
    $this->data['brands'] = Brand::orderBy('id', 'desc')->get();
      return view('back.brand.index', $this->data);
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return Response
   */
  public function create()
  {
    $brand = new Brand;
      $this->data['brand'] = $brand;
      return view('back.brand.form', $this->data);
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

      $brand = new Brand;
      
      $brand->title = Input::get('title');
      if(!empty(Input::get('slug'))) {
        $slug = str_slug(Input::get('slug'), '-');;
        $validator_slug = Validator::make(
            ['slug' => $slug],
            ['slug' => "unique:brands,slug"]
        );
        if ($validator_slug->fails()) {
          return back()->withErrors($validator_slug->messages())
                          ->withInput();
        } 
      } else {
        $slug = str_slug(Input::get('title'), '-');
        $validator_slug = Validator::make(
            ['slug' => $slug],
            ['slug' => "unique:brands,slug"]
        );
        if ($validator_slug->fails()) {
          $slug = $slug.'-'.str_slug(str_random(2));
        } 
    }
      $brand->slug = $slug;
      $brand->content = Input::get('content');
      $brand->save();

        // Making counting of uploaded images
      if (Input::hasFile('image_upload')) { 
        $key = str_random(6);            
        $full_item_photo_dir = config('image.image_root').'/brands';
        $fileName = $brand->slug.'_'.$key;
        ImageLib::upload_image(Input::file('image_upload'), $full_item_photo_dir, $fileName, config('image.images.brands'), 0);        
        $brand->thumbnail = $fileName;
        $brand->save();
      }
      return redirect('/manage/brand')->withSuccess('Tạo mới thành công');
  }

  /**
   * Display the specified resource.
   *
   * @param  int  $id
   * @return Response
   */
  public function show($id)
  {
    $brand = Brand::find($id);
      $this->data['brand'] = $brand;
      return view('back.brand.form', $this->data);
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  int  $id
   * @return Response
   */
  public function edit($id)
  {
    $brand = Brand::find($id);
      $this->data['brand'] = $brand;
      return view('back.brand.form', $this->data);
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

      $brand = Brand::find($id);
      if (!$brand) {
        return view('error.404');
      }
      
      $brand->title = Input::get('title');
      if(!empty(Input::get('slug'))) {
        $slug = str_slug(Input::get('slug'), '-');;
        $validator_slug = Validator::make(
            ['slug' => $slug],
            ['slug' => "unique:brands,slug,".$id.",id"]
        );
        if ($validator_slug->fails()) {
          return back()->withErrors($validator_slug->messages())
                          ->withInput();
        } 
      } else {
        $slug = str_slug(Input::get('title'), '-');
        $validator_slug = Validator::make(
            ['slug' => $slug],
            ['slug' => "unique:brands,slug,".$id.",id"]
        );
        if ($validator_slug->fails()) {
          $slug = $slug.'-'.str_slug(str_random(2));
        } 
    }
      $brand->slug = $slug;
      $brand->content = Input::get('content');
      $brand->save();

        // Making counting of uploaded images
      if (Input::hasFile('image_upload')) { 
        $key = str_random(6);            
        $full_item_photo_dir = config('image.image_root').'/brands';
        $fileName = $brand->slug.'_'.$key;
        ImageLib::upload_image(Input::file('image_upload'), $full_item_photo_dir, $fileName, config('image.images.brands'), 0);
        if (!empty($brand->thumbnail)) {
            ImageLib::delete_image($full_item_photo_dir, $brand->thumbnail, config('image.images.brands'));
        }
        $brand->thumbnail = $fileName;
        $brand->save();
      }

      return redirect('/manage/brand')->withSuccess('Cập nhật thành công');
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  int  $id
   * @return Response
   */
  public function destroy($id)
  {
    $brand = Brand::find($id);
      if ($brand) {      
        //delete photo record      
        if (!empty($brand->thumbnail)) {
          $full_item_photo_dir = config('image.image_root').'/brands';
          ImageLib::delete_image($full_item_photo_dir, $brand->thumbnail, config('image.images.brands'));
        }
        $brand->delete();
        return redirect('/manage/brand')->withSuccess('Xóa thành công');
      } else {
        return redirect('/manage/brand')->withErrors('Xóa thất bại');
    }
  }

}
