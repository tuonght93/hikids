<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Product, App\Models\ProductCategory;
use Input, Validator;
use App\Libraries\ImageLib, App\Libraries\Xonlib;
use MessageBag;

class ProductCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->data['categories'] = ProductCategory::get_categories_tree( '',0,'----', '----');
        return view('back.productCategories.index', $this->data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $category = new ProductCategory;
        $categories = ProductCategory::get_categories_tree( '',0,'--', '--');
        $this->data['categories'] = $categories;
        $this->data['category'] = $category;
        return view('back.productCategories.form', $this->data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make(
      Input::all(),
      [
          'name'    => 'required',
      ]
    );
    if ($validator->fails()) {
      return back()->withErrors($validator->messages())
                        ->withInput();
    }

    $category = new ProductCategory;
    if (!$category) {
      echo 1;die;
    } else {
      $category->name = Input::get('name');
      $slug = str_slug(Input::get('name'), '-');
      $validator_slug = Validator::make(
          ['slug' => $slug],
          ['slug' => "unique:productCategories,slug"]
      );
      if ($validator_slug->fails()) {
        $slug = $slug.'-'.str_slug(str_random(2));
      } 
      $category->slug = $slug;
      $parent_id = Input::get('parent');
      $category->parent_id = $parent_id;
      $category->description = Input::get('description');
      $category->position = 0+Input::get('position');
      $category->type = 'category';
      $category->save();

        // Making counting of uploaded images
      if (Input::hasFile('image_upload')) { 
        $key = str_random(6);            
        $full_item_photo_dir = config('image.image_root').'/productCategories';
        $fileName = $category->slug.'_'.$key;
        ImageLib::upload_image(Input::file('image_upload'), $full_item_photo_dir, $fileName, config('image.images.productCategories'), 0);        
        $category->thumbnail = $fileName;
        $category->save();
      }

    }
    return redirect('/manage/productCategory')->withSuccess('Tạo mới thành công');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $category = ProductCategory::find($id);
        if (!$category) {
          return view('errors.404');
        } else {
          $categories = ProductCategory::get_categories_tree_except( '',0,'--', '--', $id);
          $this->data['categories'] = $categories;
          $this->data['created'] = false;
          $this->data['category'] = $category;

          return view('back.productCategories.form', $this->data);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $category = ProductCategory::find($id);
        if (!$category) {
          return view('errors.404');
        } else {
          $categories = ProductCategory::get_categories_tree_except( '',0,'--', '--', $id);
          $this->data['categories'] = $categories;
          $this->data['created'] = false;
          $this->data['category'] = $category;

          return view('back.productCategories.form', $this->data);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make(
      Input::all(),
      [
          'name'    => 'required',
      ]
    );
    if ($validator->fails()) {
          return back()->withErrors($validator->messages())
                            ->withInput();
        }

        $category = ProductCategory::find($id);
        if (!$category) {
          return view('errors.404');
        } else {
          $category->name = Input::get('name');
          $slug = str_slug(Input::get('name'), '-');
          $validator_slug = Validator::make(
              ['slug' => $slug],
              ['slug' => "unique:productCategories,slug,".$id.",id"]
          );
          if ($validator_slug->fails()) {
            $slug = $slug.'-'.str_slug(str_random(2));
          } 
          $category->slug = $slug;
          $parent_id = Input::get('parent');
         // $category->parent_id = $category->parent_id == $parent_id ? '' : $parent_id;
          $category->parent_id =  $parent_id;
          $category->description = Input::get('description');
          $category->position = 0+Input::get('position');
          $category->save();

            // Making counting of uploaded images
          if (Input::hasFile('image_upload')) { 
            $key = str_random(6);            
            $full_item_photo_dir = config('image.image_root').'/productCategories';
            $fileName = $category->slug.'_'.$key;
            ImageLib::upload_image(Input::file('image_upload'), $full_item_photo_dir, $fileName, config('image.images.productCategories'), 0);
            if (!empty($category->thumbnail)) {
              ImageLib::delete_image($full_item_photo_dir, $category->thumbnail, config('image.images.productCategories'));
            }
            $category->thumbnail = $fileName;
            $category->save();
          }
        }
        return back()->withSuccess('Cập nhật thành công');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $category = ProductCategory::find($id);
        if ($category) {
          
          $childs = $category->childs()->get();
          if (count($childs)>0) {
            return redirect('/manage/productCategory')->withErrors('Bạn phải xóa các chuyên mục con trước');
          }
          //delete photo record      
          if (!empty($category->thumbnail)) {
            $full_item_photo_dir = config('image.image_root').'/productCategories';
            ImageLib::delete_image($full_item_photo_dir, $category->thumbnail, config('image.images.productCategories'));
          }
          $category->delete();
          return redirect('/manage/productCategory')->withSuccess('Xóa thành công');
        } else {
          return redirect('/manage/productCategory')->withErrors('Xóa thất bại');
        }
    
  
    }
}
