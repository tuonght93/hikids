<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Product, App\Models\ProductCategory, App\Models\ProductPhoto, App\Models\Color, App\Models\Size, App\Models\ProductDetail, App\Models\Brand;

use Input, Validator, Auth;
use App\Libraries\ImageLib, App\Libraries\Xonlib;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      // $detail = Product::find('56e29b04b83c5e441500002a')->productdetails()->get();
      // dd($detail);
      $categories = ProductCategory::get_categories_tree('',0,'---', '---');

      $this->data['categories'] = $categories;
      $this->data['category_id'] = Input::get('category_id');
      return view('back.products.index', $this->data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function search()
  {
    $requestData= $_REQUEST;

    $columns = array( 
      0 => 'id', 
      1 => 'name',
      2 => 'old_price',
      3 => 'price',
      4 => 'created_at'
    );

    $start = isset($requestData['start']) ? $requestData['start'] : 0 ;
    $sort = isset($requestData['order'][0]['dir']) && $requestData['order'][0]['dir'] == 'asc' ? 'asc' : 'desc';

    $total= Product::count();
    $search = isset($requestData['search']['value']) ? $requestData['search']['value'] : '';
    $category_id = $requestData['category_id'];
    $keyword = $requestData['search']['value'];
    if (empty($search)) {
      if($category_id == '') {
        $totalFilter = Product::count();
        $products = Product::orderBy($columns[$requestData['order'][0]['column']], $sort)->orderBy('id', 'desc')->get();
      } else {
        $totalFilter = Product::where('category_id', '=', $category_id)->count();
        $products = Product::where('category_id', '=', $category_id)->orderBy($columns[$requestData['order'][0]['column']], $sort)->orderBy('id', 'desc')->get();
      }
    } else {
    $totalFilter = Product::where(function($query) use($category_id) {
                                    if ($category_id != '') {
                                      return $query->where('category_id', '=', $category_id);
                                    }
                              })
                            ->where(function($query) use($keyword) {
                                return $query->where('name', 'like', '%'.$keyword.'%')
                                            ->orWhere('slug', 'like', '%'.$keyword.'%')
                                            ->orWhere('type', 'like', '%'.$keyword.'%');
                            })->count();
    $products = Product::where(function($query) use($category_id) {
                                    if ($category_id != '') {
                                      return $query->where('category_id', '=', $category_id);
                                    }
                              })
                            ->where(function($query) use($keyword) {
                                return $query->where('name', 'like', '%'.$keyword.'%')
                                            ->orWhere('slug', 'like', '%'.$keyword.'%')
                                            ->orWhere('type', 'like', '%'.$keyword.'%');
                            })->skip($start)->take($requestData['length'])->orderBy($columns[$requestData['order'][0]['column']], $sort)->orderBy('_id', 'desc')->get();
    }
    $data = array();
    $i = 1+$start;
    foreach ($products as $product) {
      $nestedData=array();
      $nestedData[] = $i;
      if ($product->image_url()) {
        $nestedData[] = '<a href="'.url('/manage/product/'.$product->id.'/edit').'"><img src="'.config('image.image_url').'/products/'.$product->image_url().'_70x70.png" /></a>';
      } else {
        $nestedData[] = '<a href="'.url('/manage/product/'.$product->id.'/edit').'"><img src="'.config('image.image_url_admin').'/default_70x70.png" /></a>';
      }
      $nestedData[] = '<a href="'.url('/manage/product/'.$product->id.'/edit').'">'.$product->name.'</a>';
      $nestedData[] = $product->old_price;  
      $nestedData[] = $product->price; 
      $nestedData[] = 0+$product->view_count;
      $nestedData[] = date('d-m-Y H:i:s', strtotime($product->created_at));
      $action = '<a class="btn btn-primary btn-xs" user-id="'.$product->id.'" href="'.url('/manage/product/'.$product->id.'/edit').'" data-original-title="Edit" data-toggle="tooltip"><i class="fa fa-pencil"></i></a>';
      $action = $action.'<button data-toggle="modal" data-target="#mod-error" class="delete_user btn btn-danger btn-xs" product-id="'.$product->id.'"  ><i class="fa fa-times"></i></button>';
      $nestedData[] = $action;
      
      $data[] = $nestedData;
      $i++;
    }

    $json_data = array(
                "draw"            => intval( $_REQUEST['draw'] ),
                "recordsTotal"    => $total,
                "recordsFiltered" => $totalFilter,
                "data"            => $data
            );

    return response()->json($json_data);
  }
    public function create()
    {
      $colors = Color::get();
      $sizes = Size::get();
      $this->data['colors'] = $colors;
      $this->data['sizes'] = $sizes;
      $this->data['product'] = new Product;
      $categories = ProductCategory::get_categories_tree('',0,'-', '--');
      $this->data['brands'] = Brand::all();
      $this->data['categories'] = $categories;
      return view('back.products.form', $this->data);
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
              'price'     => 'required',
              'color'  => 'required',
              'size' => 'required',
          ]
        );
        if ($validator->fails()) {
          return back()->withErrors($validator->messages())
                            ->withInput();
        }

        $product = new Product;
        if (!$product) {
          return view('errors.404');
        } else {
          $product->name = Input::get('name');
          $slug = str_slug(Input::get('name'), '-');
          $validator_slug = Validator::make(
              ['slug' => $slug],
              ['slug' => "unique:products"]
          );
          if ($validator_slug->fails()) {
            $slug = $slug.'-'.str_slug(str_random(2));
          } 
          $product->slug = $slug;

          $product->detail = Input::get('detail');
          $product->old_price = 0+Input::get('old_price');
          $product->price = 0+Input::get('price');
          $product->number = 0+Input::get('number');
          $product->madein = Input::get('madein');
          $product->selling = 0+Input::get('selling');
          $product->introduce = Input::get('introduce');
          $product->detail = Input::get('detail');
          $product->category_id = Input::get('category');
          $product->brand_id = Input::get('brand');
          // $product->skintype_ids = $skintype_ids;
          $product->image_thumb = Input::get('image_thumb');
          $product->status = 1;
          $product->type = 'hikids';
          $product->save();

          $colors = Input::get('color');
          $sizes = Input::get('size');
          foreach ($colors as $color) {
            foreach ($sizes as $size) {
              $lists = explode('-', $size);
              if($color == $lists['0']) {
                $qty = Input::get($size);
                if(!empty($qty)) {
                  $productdetail = new ProductDetail;
                  $productdetail->product_id = $product->id;
                  $productdetail->color_id = $lists['0'];
                  $productdetail->size_id = $lists['1'];
                  $productdetail->qty = 0+$qty;
                  $productdetail->save();
                }
              }
            }
          }
          $checkproductdetail = ProductDetail::where('product_id', '=', $product->id)->count();
          if($checkproductdetail == 0) {
            $product->delete();
            return back()->withErrors('Sản phẩm chưa có thông số nào?')
                            ->withInput();
          } 

          $files = Input::file('image_upload');
            // Making counting of uploaded images
          if (!empty($files)) {
            $i = 1;
              foreach($files as $file) {
                if (empty($file)) continue;
                $key = str_random(6);
                $name = substr($file->getClientOriginalName(),0, -4);
                $fileName = str_slug($name, '-').'-'.$key;
                $date_dir_name = md5(date_format($product->created_at, 'm-Y'));
                $full_item_photo_dir = config('image.image_root').'/products/'.$date_dir_name.'/'.$product->id;

                ImageLib::upload_image($file,$full_item_photo_dir,$fileName, config('image.images.products'), $crop = 0);
                if ($i == 1 && $product->image_thumb == '') {
                  $product->image_thumb = $fileName;
                  $product->save();
                }
                $product_photo = new ProductPhoto;
                $product_photo->image =  $fileName;
                $product_photo->product_id =  $product->id;
                $product_photo->save();
                $i++;
              }
        }
          return redirect('/manage/product')->withSuccess('Thêm sản phẩm thành công');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
      $productdetails = ProductDetail::where('product_id', '=', $id)->get();
      $this->data['productdetails'] = $productdetails;
      $colors = Color::get();
      $this->data['colors'] = $colors;
      $sizes = Size::get();
      $this->data['sizes'] = $sizes;
      $product = Product::find($id);
      if (!$product) {
        return view('errors.404');
      } else {
        $categories = ProductCategory::get_categories_tree('',0,'-', '--');
        $this->data['brands'] = Brand::all();
        $this->data['categories'] = $categories;
        $this->data['product'] = $product;
        $this->data['product'] = $product;
        return view('back.products.form', $this->data);
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
      $productdetails = ProductDetail::where('product_id', '=', $id)->get();
      $this->data['productdetails'] = $productdetails;
      $colors = Color::get();
      $this->data['colors'] = $colors;
      $sizes = Size::get();
      $this->data['sizes'] = $sizes;
      $product = Product::find($id);
      if (!$product) {
        return view('errors.404');
      } else {
        $categories = ProductCategory::get_categories_tree('',0,'-', '--');
        $this->data['categories'] = $categories;
        $this->data['brands'] = Brand::all();
        $this->data['product'] = $product;
        $this->data['product'] = $product;
        return view('back.products.form', $this->data);
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
          'price'     => 'required',
          'color'  => 'required',
          'size' => 'required',
      ]
    );
    if ($validator->fails()) {
      return back()->withErrors($validator->messages())
                        ->withInput();
    }

    $product = Product::find($id);
    if (!$product) {
      return view('error.404');
    } else {
      $product->name = Input::get('name');
      $slug = str_slug(Input::get('name'), '-');
      $validator_slug = Validator::make(
          ['slug' => $slug],
          ['slug' => "unique:products,slug,".$id.",id"]
      );
      if ($validator_slug->fails()) {
        $slug = $slug.'-'.str_slug(str_random(2));
      } 
      $product->slug = $slug;

      $product->detail = Input::get('detail');
      $product->old_price = 0+Input::get('old_price');
      $product->price = 0+Input::get('price');
      $product->number = 0+Input::get('number');
      $product->madein = Input::get('madein');
      $product->selling = 0+Input::get('selling');
      $product->introduce = Input::get('introduce');
      $product->category_id = Input::get('category');
      $product->brand_id = Input::get('brand');
      // $product->skintype_ids = $skintype_ids;
      $product->image_thumb = Input::get('image_thumb');
      $product->save();
      ProductDetail::where('product_id', '=', $id)->delete();
      $colors = Input::get('color');
      $sizes = Input::get('size');
      foreach ($colors as $color) {
        foreach ($sizes as $size) {
          $lists = explode('-', $size);
          if($color == $lists['0']) {
            $qty = Input::get($size);
            if(!empty($qty)) {
              $productdetail = new ProductDetail;
              $productdetail->product_id = $product->id;
              $productdetail->color_id = $lists['0'];
              $productdetail->size_id = $lists['1'];
              $productdetail->qty = 0+$qty;
              $productdetail->save();
            }
          }
        }
      }
      $checkproductdetail = ProductDetail::where('product_id', '=', $product->id)->count();
      if($checkproductdetail == 0) {
        $product->delete();
        return back()->withErrors('Sản phẩm chưa có thông số nào?')
                        ->withInput();
      } 

      $files = Input::file('image_upload');
        // Making counting of uploaded images
      if (!empty($files)) {
        $i = 1;
          foreach($files as $file) {
            if (empty($file)) continue;
            $key = str_random(6);
            $name = substr($file->getClientOriginalName(),0, -4);
            $fileName = str_slug($name, '-').'-'.$key;
            $date_dir_name = md5(date_format($product->created_at, 'm-Y'));
            $full_item_photo_dir = config('image.image_root').'/products/'.$date_dir_name.'/'.$product->id;

            ImageLib::upload_image($file,$full_item_photo_dir,$fileName, config('image.images.products'), $crop = 0);
            if ($i == 1 && $product->image_thumb == '') {
              $product->image_thumb = $fileName;
              $product->save();
            }
            $product_photo = new ProductPhoto;
            $product_photo->image =  $fileName;
            $product_photo->product_id =  $product->id;
            $product_photo->save();
            $i++;
          }
      }
      return back()->withSuccess('Cập nhật thành công');
      
    }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
      $product = Product::find($id);
      if ($product) {
        ProductDetail::where('product_id', '=', $id)->delete();
        $date_dir_name = md5(date_format($product->created_at, 'm-Y'));
        $full_item_photo_dir = config('image.image_root').'/products/'.$date_dir_name.'/'.$product->id;    
        ImageLib::delete_folder($full_item_photo_dir);
        $product->delete();
        return redirect('/manage/product')->withSuccess('Xóa thành công');
      } else {
        return redirect('/manage/product')->withErors('Xóa thất bại');
      }
    }
}
