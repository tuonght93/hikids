<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Product, App\Models\ProductCategory, App\Models\ProductPhoto, App\Models\Color, App\Models\Size, App\Models\ProductDetail;
use Input, Validator, Auth;
use App\Libraries\ImageLib, App\Libraries\Xonlib;

class ProductCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($parent_slug = '', $slug = '')
    {
      if (!$slug) {
        $slug = $parent_slug;
      }
      $list = array();
      $category = ProductCategory::where('slug', '=', $slug)->first();
      if($category) {
        $list[] = $category->id;
        $categories = ProductCategory::get_categories_tree($category->id,0);
        foreach ($categories as $listcate) {
          $list[] = $listcate->id;
        }
        $products = Product::whereIn('category_id', $list)->paginate(64);
        $this->data['total_products'] = Product::whereIn('category_id', $list)->count();
        $this->data['seo'] = Xonlib::create_seo($category->name.' | Hikids');
        $this->data['min_price'] = Product::whereIn('category_id', $list)->min('price');
        $this->data['max_price'] = Product::whereIn('category_id', $list)->max('price');
        $this->data['min_price_get'] = Product::whereIn('category_id', $list)->min('price');
        $this->data['max_price_get'] = Product::whereIn('category_id', $list)->max('price');
        $this->data['colors'] = Color::orderBy('title', 'asc')->get();
        $this->data['color_selected'] = array();
        $this->data['sizes'] = Size::orderBy('title', 'asc')->get();
        $this->data['size_selected'] = array();
        $this->data['category'] = $category;
        $this->data['products'] = $products;
        return view('user/list-product',$this->data);
      } else {
        return redirect('/');
      }
    }

    public function categoryShow( $slug )
    {
      $category = ProductCategory::where('slug', '=', $slug)->first();
      if (!$category) {
        return redirect('/');
      }
      $list = array();
      $category = ProductCategory::where('slug', '=', $slug)->first();
      $list[] = $category->id;
      $categories = ProductCategory::get_categories_tree($category->id,0);
      foreach ($categories as $listcate) {
        $list[] = $listcate->id;
      }
      $this->data['min_price_get'] = Product::whereIn('category_id', $list)->min('price');
      $this->data['max_price_get'] = Product::whereIn('category_id', $list)->max('price');
      $min_price = 0+Input::get('min_price');
      $max_price = 0+Input::get('max_price');
      $color_ids = Input::get('color_ids');
      $size_ids = Input::get('size_ids');
      $products = Product::whereIn('category_id', $list)->where('price', '>=', $min_price)->where('price', '<=', $max_price)->get();
      $product_ids = array();
      foreach ($products as $product) {
        $product_ids[] = $product->id;
      }
      $list_products = ProductDetail::where(function($query) use($product_ids){
                                return $query->whereIn('product_id', $product_ids);
                              })
                              ->where(function($query) use($color_ids){
                                if (!empty($color_ids)) {
                                  return $query->whereIn('color_id', $color_ids);
                                }
                              })
                              ->where(function($query) use($size_ids){
                                if (!empty($size_ids)) {
                                  return $query->whereIn('size_id', $size_ids);
                                }
                              })
                              ->get();
      $list_id = array();
      foreach ($list_products as $list) {
        $list_id[] = $list->product_id;
      }
      $list_productids = array_unique($list_id);
      $this->data['products'] = Product::whereIn('id', $list_productids)->paginate(64);
      $this->data['total_products'] = Product::whereIn('id', $list_productids)->count();
      $this->data['seo'] = Xonlib::create_seo($category->name.' | Hikids');
      $this->data['min_price'] = $min_price;
      $this->data['max_price'] = $max_price;
      $this->data['colors'] = Color::orderBy('title', 'asc')->get();
      $this->data['color_selected'] = $color_ids ? $color_ids : array('');
      $this->data['sizes'] = Size::orderBy('title', 'asc')->get();
      $this->data['size_selected'] = $size_ids ? $size_ids : array('');
      $this->data['category'] = $category;
      return view('user/list-product',$this->data);

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
