<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Order, App\Models\OrderDetail, App\Models\Product, App\Models\City, App\Models\District;
use Input, Validator, Auth, Cart;
use App\Libraries\Xonlib;

class CheckoutController extends Controller
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
        if (Cart::count() > 0) {
            $this->data['cities'] = City::orderBy('name', 'asc')->get();
            $this->data['carts'] = Cart::content();
            $this->data['total'] = Cart::total();
            $this->data['count'] = Cart::count();
            $this->data['seo'] = Xonlib::create_seo('Đặt hàng | Hikids');
            return view('user.checkout',$this->data);
        } else {
            return redirect('/cart')->withErrors("Giỏ hàng của bạn chưa có sản phẩm nào, vì thế bạn không thể tiến hành thanh toán.");
        }
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
              'phone'    => 'required',
              'city'    => 'required',
              'district'    => 'required',
              'address'    => 'required',
              'email'    => 'required',
              'date'    => 'required',
          ]
        );
        if ($validator->fails()) {
          return back()->withErrors($validator->messages())
                            ->withInput();
        }
        $city_id = Input::get('city');
        $city = City::where('id', '=', $city_id)->first();
        $district_id = Input::get('district');
        $district = District::where('id', '=', $district_id)->first();
        $user = Auth::user();
        $items = array();
        $order = new Order;
        $order->code = $order->gen_code();
        $order->name = Input::get('name');
        $order->phone = Input::get('phone');
        $order->email = Input::get('email');
        $order->city_id = Input::get('city');
        $order->district_id = Input::get('district');
        $order->address = Input::get('address');
        $order->date = Input::get('date');
        $order->payments = Input::get('payments');
        if(Input::get('form') == 1 && $district->shippingfast > 0) {
            $order->shipping = $district->shippingfast;
            $order->form = 1;
        } else {
            if(Cart::total() >= $city->freeshipping) {
                $order->shipping = 0;
                $order->form = 0;
            } else {
                $order->shipping = $city->shippingcost;
                $order->form = 0;
            }
        }
        $order->note = Input::get('note');
        $order->total = Cart::total();
        $order->status = 0;
        if(!empty($user)) {
            $order->user_id = $user->id;
        }
        $order->save();
        $items = Cart::content() ;
        foreach ($items as $orders) {
            $orderdetail = new OrderDetail;
            $orderdetail->order_id = $order->id;
            $orderdetail->product_id = $orders->id;
            $orderdetail->color = $orders->options->color;
            $orderdetail->size = $orders->options->size;
            $orderdetail->qty = 0+$orders->qty;
            $orderdetail->price = 0+$orders->price;
            $orderdetail->save();
        }
        Cart::destroy();
        return redirect('/checkout/thankyou/'.$order->code);
    }

    public function thankyou($code)
    {
        $order = Order::where('code', '=', $code)->first();
        if($order) {
            $orderdetails = OrderDetail::where('order_id', '=', $order->id)->get();
            $this->data['order'] = $order;
            $this->data['orderdetails'] = $orderdetails;
            $this->data['seo'] = Xonlib::create_seo('Cảm ơn | Hikids');
            return view('user.thankyou', $this->data);
        } else {
            return redirect('/');
        }
    }

    public function adddistrict()
    {
        $city_id = Input::get('city_id');
        $districts = District::where('city_id', '=', $city_id)->orderBy('name', 'asc')->get();
        $this->data['districts'] = $districts;
        return view('user.districts',$this->data);
    }

    public function addform()
    {
        $districts_id = Input::get('district_id');
        $district = District::where('id', '=', $districts_id)->first();
        if($district) {
            if ($district->shippingfast > 0) {
                return view('user.shippingfast1');
            } else {
                return view('user.shippingfast2');
            }
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
        //
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
