<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    @yield('title')
    <link href="http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,400italic,700,800" rel="stylesheet" type="text/css">
    <link href="http://fonts.googleapis.com/css?family=Raleway:300,200,100" rel="stylesheet" type="text/css">
    <link href="http://fonts.googleapis.com/css?family=Open+Sans+Condensed:300,700" rel="stylesheet" type="text/css">
    <script src="/js/jquery.js"></script>
   
    <!-- Bootstrap core CSS -->
    <link href="/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/css/font-awesome.min.css">
   
   <link rel="stylesheet" type="text/css" href="/css/nanoscroller.css">
    <!-- Plugins Includes -->
    
    <!-- General Plugins Instances -->
    @yield('css')
   
    <!-- Template Style -->
    <link href="/css/style.css" rel="stylesheet">
    <link href="/css/extra.css" rel="stylesheet">
  </head>

  <body>
    <div id="head-nav" class="navbar navbar-default navbar-fixed-top">
      <div class="container-fluid">
        <div class="navbar-header">

        </div>
        <div class="navbar-collapse collapse">
          <ul class="nav navbar-nav">
            <li class="active"><a href="/manage">Manage</a></li>
           
          </ul>
          <ul class="nav navbar-nav navbar-right user-nav">
            <?php $user = Auth::user();
            ?>
            <li class="dropdown profile_menu">
              <a href="#" data-toggle="dropdown" class="dropdown-toggle">
                @if (empty($user->avatar))
                    <img alt="{{$user->full_name}}" src="/images/user.png">
                @else
                    <img alt="{{$user->full_name}}" src="{{ config('image.image_url').'/avatars/'.$user->avatar.'_40x40.png' }} " width="32" height="32">
                @endif
                <span>{{ $user->full_name != '' ? $user->full_name : $user->username }}</span><b class="caret"></b>
              </a>
              <ul class="dropdown-menu">
                <li>
                  {!! link_to('/manage/logout', trans('back/action.logout'), array()) !!}
                </li>
              </ul>
            </li>
          </ul>
     
          <ul class="nav navbar-nav navbar-right not-nav">
            
                
          </ul>
     
        </div>
      </div>
    </div>
    <div id="cl-wrapper">
            <!--Sidebar item function-->
            <!--Sidebar sub-item function-->
            <div class="cl-sidebar">
              <div class="cl-toggle"><i class="fa fa-bars"></i></div>
              <div class="cl-navblock">
                <div class="menu-space">
                  <div class="content">

                    <ul class="cl-vnavigation">

                        @if (Auth::user()->isAdmin())
                          <li><a href="#"><i class="fa fa-home"></i><span>Trang chủ</span></a></li>
                          <li class="nav-header">PRODUCTS</li>
                          <li>
                           <a href="#"><i class="fa fa-file"></i><span>Sản phẩm</span></a>
                            <ul class="sub-menu">
                              <li class="<?php echo (Request::segment(2) == 'product' && Request::segment(3) == '' ? 'active' : '') ?>"><a href="{{ url('/manage/product') }}">Tất cả</a>
                              </li>
                              <li class="<?php echo (Request::segment(2) == 'product' && Request::segment(3) == 'create' ? 'active' : '') ?>"><a href="{{ url('/manage/product/create') }}">Thêm mới</a>
                              </li>
                            </ul>
                          </li>

                          <li>
                           <a href="#"><i class="fa fa-book"></i><span>Chuyên mục</span></a>
                            <ul class="sub-menu">
                              <li class="<?php echo (Request::segment(2) == 'productCategory' && Request::segment(3) == '' ? 'active' : '') ?>"><a href="{{ url('/manage/productCategory') }}">Tất cả</a>
                              </li>
                              <li class="<?php echo (Request::segment(2) == 'productCategory' && Request::segment(3) == 'create' ? 'active' : '') ?>"><a href="{{ url('/manage/productCategory/create') }}">Thêm mới</a>
                              </li>
                            </ul>
                          </li>

                          <li>
                           <a href="#"><i class="fa fa-credit-card"></i><span>Thương hiệu</span></a>
                            <ul class="sub-menu">
                              <li class="<?php echo (Request::segment(2) == 'brand' && Request::segment(3) == '' ? 'active' : '') ?>"><a href="{{ url('/manage/brand') }}">Tất cả</a>
                              </li>
                              <li class="<?php echo (Request::segment(2) == 'brand' && Request::segment(3) == 'create' ? 'active' : '') ?>"><a href="{{ url('/manage/brand/create') }}">Thêm mới</a>
                              </li>
                            </ul>
                          </li>

                          <li>
                           <a href="#"><i class="fa fa-align-justify"></i><span>Màu sắc</span></a>
                            <ul class="sub-menu">
                              <li class="<?php echo (Request::segment(2) == 'color' && Request::segment(3) == '' ? 'active' : '') ?>"><a href="{{ url('/manage/color') }}">Tất cả</a>
                              </li>
                              <li class="<?php echo (Request::segment(2) == 'color' && Request::segment(3) == 'create' ? 'active' : '') ?>"><a href="{{ url('/manage/color/create') }}">Thêm mới</a>
                              </li>
                            </ul>
                          </li>

                          <li>
                           <a href="#"><i class="fa fa-align-justify"></i><span>Kích cỡ</span></a>
                            <ul class="sub-menu">
                              <li class="<?php echo (Request::segment(2) == 'size' && Request::segment(3) == '' ? 'active' : '') ?>"><a href="{{ url('/manage/size') }}">Tất cả</a>
                              </li>
                              <li class="<?php echo (Request::segment(2) == 'size' && Request::segment(3) == 'create' ? 'active' : '') ?>"><a href="{{ url('/manage/size/create') }}">Thêm mới</a>
                              </li>
                            </ul>
                          </li>
                          <li class="nav-header">ORDER</li>
                          <li>
                          <a href="{{ url('/manage/order') }}"><i class="fa fa-shopping-cart"></i><span>Hóa đơn</span></a>
                          </li>
                          <li class="nav-header">CẤU HÌNH HỆ THỐNG</li>
                          <li>
                           <a href="#"><i class="fa fa-align-justify"></i><span>Slide</span></a>
                            <ul class="sub-menu">
                              <li class="<?php echo (Request::segment(2) == 'slide' && Request::segment(3) == '' ? 'active' : '') ?>"><a href="{{ url('/manage/slide') }}">Tất cả</a>
                              </li>
                              <li class="<?php echo (Request::segment(2) == 'slide' && Request::segment(3) == 'create' ? 'active' : '') ?>"><a href="{{ url('/manage/slide/create') }}">Thêm mới</a>
                              </li>
                            </ul>
                          </li>
                          <li>
                           <a href="#"><i class="fa fa-file"></i><span>Page</span></a>
                            <ul class="sub-menu">
                              <li class="<?php echo (Request::segment(2) == 'page' && Request::segment(3) == '' ? 'active' : '') ?>"><a href="{{ url('/manage/page') }}">Tất cả</a>
                              </li>
                              <li class="<?php echo (Request::segment(2) == 'page' && Request::segment(3) == 'create' ? 'active' : '') ?>"><a href="{{ url('/manage/page/create') }}">Thêm mới</a>
                              </li>
                            </ul>
                          </li>
                          <li class="nav-header">CITYS</li>
                          <li>
                           <a href="#"><i class="fa fa-flag"></i><span>City</span></a>
                            <ul class="sub-menu">
                              <li class="<?php echo (Request::segment(2) == 'city' && Request::segment(3) == '' ? 'active' : '') ?>"><a href="{{ url('/manage/city') }}">Tất cả</a>
                              </li>
                              <li class="<?php echo (Request::segment(2) == 'city' && Request::segment(3) == 'create' ? 'active' : '') ?>"><a href="{{ url('/manage/city/create') }}">Thêm mới</a>
                              </li>
                            </ul>
                          </li>
                          <li>
                           <a href="#"><i class="fa fa-flag"></i><span>District</span></a>
                            <ul class="sub-menu">
                              <li class="<?php echo (Request::segment(2) == 'district' && Request::segment(3) == '' ? 'active' : '') ?>"><a href="{{ url('/manage/district') }}">Tất cả</a>
                              </li>
                              <li class="<?php echo (Request::segment(2) == 'district' && Request::segment(3) == 'create' ? 'active' : '') ?>"><a href="{{ url('/manage/district/create') }}">Thêm mới</a>
                              </li>
                            </ul>
                          </li>
                          <li class="nav-header">USERS</li>

                          <li>
                           <a href="#"><i class="fa fa-users"></i><span>{{ trans('back/template.user') }}</span></a>
                            <ul class="sub-menu">
                              <li class="<?php echo (Request::segment(2) == 'user' && Request::segment(3) == '' ? 'active' : '') ?>"><a href="{{ url('/manage/user') }}">{{ trans('back/noun.all') }}</a>
                              </li>
                              <li class="<?php echo (Request::segment(2) == 'user' && Request::segment(3) == 'create' ? 'active' : '') ?>"><a href="{{ url('/manage/user/create') }}">{{ trans('back/action.add_new') }}</a>
                              </li>
                            </ul>
                          </li>

                        @endif
                    </ul>
                  </div>
                </div>
                <div class="search-field collapse-button">                  
                  <button type="submit" id="sidebar-collapse" class="btn btn-default"><i class="fa fa-angle-left"></i>
                  </button>
                </div>
              </div>
            </div>
      <div id="pcont" class="container-fluid">
        
        @yield('content')
        <br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/>
        <br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/>
        <div class="footer-customer-admin">
          <a href="http://techup.vn">© {!! date('Y') !!} Power by Hikids</a>
        </div>
      </div>
    </div>

    <script type="text/javascript" src="/js/jquery.nanoscroller.js"></script>
    <script type="text/javascript" src="/js/cleanzone.js"></script>
    <script src="/js/bootstrap.min.js"></script>

    @yield('script')

    <script type="text/javascript">
      $(document).ready(function(){
        //initialize the javascript
        App.init();
      });
      
    </script>
    @yield('scriptend')

  </body>
</html>