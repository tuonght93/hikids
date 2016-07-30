<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Product, App\Models\ProductCategory, App\Models\ProductPhoto, App\Models\ProductDetail;
use App\Models\Color, App\Models\Size;
use App\Libraries\Xonlib;
use Input, Session;

class ProductController extends Controller
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
    public function show(Request $request, $slug)
    {
      $lists = new ProductDetail;
      $product = Product::where('slug', '=', $slug)->first();
      if($product) {
          $productphotos = ProductPhoto::where('product_id' , '=', $product->id)->whereNotIn('image', [$product->image_thumb])->get();
          $productdetails = ProductDetail::where('product_id', '=', $product->id)->get();
          $vieweds = array();
          $vieweds = Session::get('vieweds');
          $vieweds[$slug] = $product;
          Session::put('vieweds', $vieweds);
          $this->data['vieweds'] = $vieweds;
          $this->data['seo'] = Xonlib::create_seo( $product->name.' | Hikids' );
          $this->data['lists'] = $lists;
          $this->data['product'] = $product;
          $this->data['productphotos'] = $productphotos;
          $this->data['productdetails'] = $productdetails;
          return view('user.single-product',$this->data);
      } else {
        return redirect('/');
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

    public function addsize()
    {
        $product_id = Input::get('product_id');
        $color_id = Input::get('color_id');
        $sizes = ProductDetail::where('product_id', '=', $product_id)->where('color_id', '=', $color_id)->get();
        $this->data['sizes'] = $sizes;
        return view('user.sizes',$this->data);
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
