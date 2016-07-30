<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Product, App\Models\ProductCategory;
use Input, Session;
use App\Libraries\Xonlib;

class HomeController extends Controller
{
    public function index()
    {
    	// //List menu
    	// $categories = new ProductCategory;
    	// $data['categories'] = $categories;

    	//Product selling
    	$productsellings = Product::where('selling', '=', 1)->orderBy('position', 'asc')->take(4)->get();
    	$this->data['productsellings'] = $productsellings;
      
      $this->data['seo'] = Xonlib::create_seo('Trang chủ | Hikids', 'Quần áo trẻ em bán tại Hikids.vn với nhiều mẫu quần áo đẹp, giá rẻ cho bé. Mua sắm đồ trẻ em tại shop, các mẹ sẽ có nhiều lựa chọn những bộ thời trang trẻ em cực xinh, an toàn cho em bé yêu nhà mình. Hikids giao hàng toàn quốc, thu tiền tận nơi.', '', 'thoi trang tre em, mua quan ao tre em, bán quần áo trẻ em, mua quan ao em be, quần áo con nít, quan ao cho be, do tre em');
    	return view('user.index', $this->data);
    }

    public function search()
    {
        $keyword = Input::get('keyword');
        if (!$keyword) {
          return redirect('/');
        } else {
          $slug = str_slug($keyword, '-');
          $products = Product::where('slug', 'like', '%'.$slug.'%')->paginate(16);
          $this->data['keyword'] = $keyword;
          $this->data['products'] = $products;
          $this->data['seo'] = Xonlib::create_seo('Kết quả tìm kiếm | Happy Skin');
          return view('user.search', $this->data);
        }
    }
    public function test()
    {
      $productsellings = Product::where('selling', '=', 1)->orderBy('position', 'asc')->take(4)->get();
      $this->data['productsellings'] = $productsellings;


      return view('user.thankyou', $this->data);
    }
}
