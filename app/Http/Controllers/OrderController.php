<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Order, App\Models\OrderDetail;
use Input,Validator;
use Image,File,Mail;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $order = new Order;
        $orders = $order->get();
        return view ('back.order.index',['order'=>$orders]);
    }

    public function search()
    {
        $requestData= $_REQUEST;

        $columns = array( 
          0 => 'id', 
          1 => 'name',
          2 => 'email',
          3 => 'phone',
          4 => 'address',
          5 => 'created_at'
        );
        $start = isset($requestData['start']) ? $requestData['start'] : 0 ;
        $sort = isset($requestData['order'][0]['dir']) && $requestData['order'][0]['dir'] == 'asc' ? 'asc' : 'desc';
        $total= Order::count();
        $search = isset($requestData['search']['value']) ? $requestData['search']['value'] : '';
        if (empty($search)) {
            $totalFilter = Order::count();
            $orders = Order::orderBy($columns[$requestData['order'][0]['column']], $sort)->orderBy('id', 'desc')->get();
        } else {
            $totalFilter = Order::where('username', 'like', '%'.$requestData['search']['value'].'%')->orWhere('email', 'like', '%'.$requestData['search']['value'].'%')->orWhere('address', 'like', '%'.$requestData['search']['value'].'%')->count();
            $orders = Order::where('username', 'like', '%'.$requestData['search']['value'].'%')->orWhere('email', 'like', '%'.$requestData['search']['value'].'%')->orWhere('address', 'like', '%'.$requestData['search']['value'].'%')->skip($start)->take($requestData['length'])->orderBy($columns[$requestData['order'][0]['column']], $sort)->orderBy('id', 'desc')->get();
              }
        $data = array();
        $i = 1+$start;
        foreach ($orders as $order) {
            $nestedData=array();
            $nestedData[] = $i;
            $nestedData[] = $order->name;
            $nestedData[] = $order->phone;     
            $nestedData[] = $order->email;
            $nestedData[] = $order->address;
            if ($order->status == 0) {
              $nestedData[] = 'Vừa được đặt';
            } elseif ($order->status == 1) {
              $nestedData[] = 'Đã xác nhận';
            } elseif ($order->status == 2) {
              $nestedData[] = 'Đang vận chuyển';
            } elseif ($order->status == 3) {
              $nestedData[] = 'Đã thanh toán';
            } else {
              $nestedData[] = 'Hoàn thành';
            }
            $action = '<a class="btn btn-primary btn-xs" user-id="'.$order->id.'" href="'.url('/manage/order/'.$order->id.'/edit').'" data-original-title="Edit" data-toggle="tooltip"><i class="fa fa-pencil"></i></a> ';
            $action = $action.'<button data-toggle="modal" data-target="#mod-error" class="delete_user btn btn-danger btn-xs" user-id="'.$order->id.'"  ><i class="fa fa-times"></i></button>';
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


    public function ajaxSearch()
    {
        $requestData= $_REQUEST;
        $orderid = $requestData['order_id'];
        $keyword = $requestData['search']['value'];
        $order = Order::find($orderid);
        $totalprice = 0;
        $columns = array( 
          0 => 'id', 
          1 => 'name',
          2 => 'price',
        );
        $start = isset($requestData['start']) ? $requestData['start'] : 0 ;
        $sort = isset($requestData['order'][0]['dir']) && $requestData['order'][0]['dir'] == 'asc' ? 'asc' : 'desc';
        $total= OrderDetail::where('order_id', $orderid)->count();
        $totalFilter = OrderDetail::where('order_id', $orderid)->orderBy($columns[$requestData['order'][0]['column']], $sort)->orderBy('id', 'desc')->count();
        $orderdetails = OrderDetail::where('order_id', $orderid)->orderBy($columns[$requestData['order'][0]['column']], $sort)->orderBy('id', 'desc')->get();
        $data = array();
        $i = 1+$start;
        foreach ($orderdetails as $orderdetail) {
            $nestedData=array();
            $nestedData[] = $i;
            $nestedData[] = $orderdetail->product->name;
            $nestedData[] = $orderdetail->qty;     
            $nestedData[] = $orderdetail->color;
            $nestedData[] = $orderdetail->size;
            $nestedData[] = number_format($orderdetail->price*$orderdetail->qty,0,",",".").'đ';
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

    function updateOrder($id)
    {
        $order = Order::find($id);
        $datas = Input::get('data');
        $total = 0;
        foreach ($datas as $data) {
            $orderdetail = OrderDetail::where('id', $data['itemid'])->first();
            $orderdetail->price = 0+$data['price'];
            $orderdetail->save();
            $total = $total + $orderdetail->price;
        }
        $order->total = $total;
        $order->status = 1;
        $order->save();
        $order_link = env('HOME_URL').'member/listOrder?orderid='.$order->id;
        $name = $order->fullname !=''? $order->fullname : $order->username;
        $email = $order->email;
        $params = [
                  'title' => 'Báo giá đơn hàng',
                  'intro' => 'Chào bạn '.$name.'!.<br/>HappySkin gửi báo giá cho đơn hàng '.$id.':',
                  'expire' =>'Xin vui lòng truy cập vào đường dẫn trên để xem chi tiết.<br/> Xin cảm ơn!',
                  'link' => $order_link
        ];
        Mail::queue('emails.auth.registerActive', $params, function($message) use ($email) {
                $message->to($email, 'Happy Skin')
                    ->subject('Báo giá đơn hàng');
        });
        // return redirect('/manage/orderDetail/search');
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
    public function show($id)
    {
        $order = Order::find($id);
        if (!$order) {
          return view('errors.404');
        }
        else {
            $this->data['order'] = $order;
            return view('back.order.form',$this->data);
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
        $order = Order::find($id);
        if (!$order) {
          return view('errors.404');
        }
        else {
            $this->data['order'] = $order;
            return view('back.order.form',$this->data);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update($id)
    {
        $order = Order::find($id);
        if (!$order) {
          return view('errors.404');
        } else {
          $order->status = Input::get('status');
          $order->save();
          return redirect('manage/order')->withSuccess('Cập nhật thành công');
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
        $order = Order::find($id);
        if ($order) {
          $order->delete();
          return redirect('/manage/order')->withSuccess('Xóa thành công');
        } else {
          return redirect('/manage/order')->withErrors('Xóa thất bại');
        }
    }
}
