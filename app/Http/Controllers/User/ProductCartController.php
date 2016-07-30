<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Product, App\Models\ProductCategory, App\Models\ProductPhoto, App\Models\ProductDetail;
use App\Models\Color, App\Models\Size;
use App\Libraries\Xonlib;
use Cart,Input;

class ProductCartController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->data['carts'] = Cart::content();
        $this->data['total'] = Cart::total();
        $this->data['count'] = Cart::count();
        $this->data['seo'] = Xonlib::create_seo('Giỏ hàng của bạn | Hikids');
        return view('user/cart',$this->data);
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
    public function show()
    {
        $product_id = Input::get('product_id');
        $color_id = Input::get('product_color');
        $size_id = Input::get('product_size');
        $product = ProductDetail::where('product_id', '=', $product_id)->where('color_id', '=', $color_id)->where('size_id', '=', $size_id)->first();
        if($product) {
            Cart::add(array('id'=>$product->product_id, 'name'=>$product->product->name,'qty'=>1,'price'=>$product->product->price, 'options'=>array('image'=>$product->product->image_url().'_70x70.png', 'color' => $product->color->title, 'size'=>$product->size->title)));
        }
        $content = Cart::content();
        return redirect('/cart');
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
    public function update()
    {
        $id = Input::get('rowid');
        $qty = Input::get('qty');
        $rowids = array_combine($id,$qty);
        foreach ($rowids as $rowid => $quantity) {
            Cart::update($rowid,$quantity);
        }
        return redirect('/cart');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Cart::Remove($id);
        return redirect('/cart');
    }
}
