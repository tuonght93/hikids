<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\Slide;
use Input, Validator;
use App\Libraries\ImageLib, App\Libraries\Xonlib;

class SlideController extends Controller {

  /**
   * Display a listing of the resource.
   *
   * @return Response
   */
  public function index()
  {
    $this->data['slides'] = Slide::orderBy('id', 'desc')->get();
      return view('back.slide.index', $this->data);
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return Response
   */
  public function create()
  {
    $slide = new Slide;
      $this->data['slide'] = $slide;
      return view('back.slide.form', $this->data);
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
            'link'  => 'required',
            'image_upload'    => 'mimes:jpeg,bmp,png',
        ];
      $validator = Validator::make(
        Input::all(),$input_valid
      );
      if ($validator->fails()) {
        return back()->withErrors($validator->messages())
                          ->withInput();
      }

      $slide = new Slide;
      
      $slide->title = Input::get('title');
      if(!empty(Input::get('slug'))) {
        $slug = str_slug(Input::get('slug'), '-');;
        $validator_slug = Validator::make(
            ['slug' => $slug],
            ['slug' => "unique:slides,slug"]
        );
        if ($validator_slug->fails()) {
          return back()->withErrors($validator_slug->messages())
                          ->withInput();
        } 
      } else {
        $slug = str_slug(Input::get('title'), '-');
        $validator_slug = Validator::make(
            ['slug' => $slug],
            ['slug' => "unique:slides,slug"]
        );
        if ($validator_slug->fails()) {
          $slug = $slug.'-'.str_slug(str_random(2));
        } 
    }
      $slide->slug = $slug;
      $slide->link = Input::get('link');
      $slide->content = Input::get('content');
      $slide->save();

        // Making counting of uploaded images
      if (Input::hasFile('image_upload')) { 
        $key = str_random(6);            
        $full_item_photo_dir = config('image.image_root').'/slides';
        $fileName = $slide->slug.'_'.$key;
        ImageLib::upload_image(Input::file('image_upload'), $full_item_photo_dir, $fileName, config('image.images.slides'), 0);        
        $slide->thumbnail = $fileName;
        $slide->save();
      }
      return redirect('/manage/slide')->withSuccess('Tạo mới thành công');
  }

  /**
   * Display the specified resource.
   *
   * @param  int  $id
   * @return Response
   */
  public function show($id)
  {
    $slide = Slide::find($id);
      $this->data['slide'] = $slide;
      return view('back.slide.form', $this->data);
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  int  $id
   * @return Response
   */
  public function edit($id)
  {
    $slide = Slide::find($id);
      $this->data['slide'] = $slide;
      return view('back.slide.form', $this->data);
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
            'link'  => 'required',
            'image_upload'    => 'mimes:jpeg,bmp,png',
        ];
      $validator = Validator::make(
        Input::all(),$input_valid
      );
      if ($validator->fails()) {
        return back()->withErrors($validator->messages())
                          ->withInput();
      }

      $slide = Slide::find($id);
      if (!$slide) {
        return view('error.404');
      }
      
      $slide->title = Input::get('title');
      if(!empty(Input::get('slug'))) {
        $slug = str_slug(Input::get('slug'), '-');;
        $validator_slug = Validator::make(
            ['slug' => $slug],
            ['slug' => "unique:slides,slug,".$id.",id"]
        );
        if ($validator_slug->fails()) {
          return back()->withErrors($validator_slug->messages())
                          ->withInput();
        } 
      } else {
        $slug = str_slug(Input::get('title'), '-');
        $validator_slug = Validator::make(
            ['slug' => $slug],
            ['slug' => "unique:slides,slug,".$id.",id"]
        );
        if ($validator_slug->fails()) {
          $slug = $slug.'-'.str_slug(str_random(2));
        } 
    }
      $slide->slug = $slug;
      $slide->link = Input::get('link');
      $slide->content = Input::get('content');
      $slide->save();

        // Making counting of uploaded images
      if (Input::hasFile('image_upload')) { 
        $key = str_random(6);            
        $full_item_photo_dir = config('image.image_root').'/slides';
        $fileName = $slide->slug.'_'.$key;
        ImageLib::upload_image(Input::file('image_upload'), $full_item_photo_dir, $fileName, config('image.images.slides'), 0);
        if (!empty($slide->thumbnail)) {
            ImageLib::delete_image($full_item_photo_dir, $slide->thumbnail, config('image.images.slides'));
        }
        $slide->thumbnail = $fileName;
        $slide->save();
      }

      return redirect('/manage/slide')->withSuccess('Cập nhật thành công');
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  int  $id
   * @return Response
   */
  public function destroy($id)
  {
    $slide = Slide::find($id);
      if ($slide) {      
        //delete photo record      
        if (!empty($slide->thumbnail)) {
          $full_item_photo_dir = config('image.image_root').'/slides';
          ImageLib::delete_image($full_item_photo_dir, $slide->thumbnail, config('image.images.slides'));
        }
        $slide->delete();
        return redirect('/manage/slide')->withSuccess('Xóa thành công');
      } else {
        return redirect('/manage/slide')->withErrors('Xóa thất bại');
    }
  }

}
