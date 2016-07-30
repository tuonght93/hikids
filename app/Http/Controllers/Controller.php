<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use App\Models\ProductCategory, App\Models\Slide, App\Models\Page;
use Cart,Auth;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function __construct()
    {
			$categories = new ProductCategory;
			$slides = Slide::all();
			$pages = Page::all();
			// $this->middleware('guest', ['except' => 'logout']);
			$this->data['count'] = Cart::count();
			$this->data['categories'] = $categories;
			$this->data['slides'] = $slides;
			$this->data['pages'] = $pages;
    }
}
