<!-- HEADER-TOP START -->
<div class="header-top">
<?php $user = Auth::user(); ?>
	<div class="container">
		<div class="row">
			<!-- HEADER-LEFT-MENU START -->
			<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
				<div class="header-left-menu">
					@if($user)
					<div class="welcome-info">
						Xin chào <span>{{ !empty($user->fullname) ? $user->fullname : $user->username }}</span>
					</div>
					@endif
				</div>
			</div>
			<!-- HEADER-LEFT-MENU END -->
			<!-- HEADER-RIGHT-MENU START -->
			<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
				<div class="header-right-menu">
					<nav>
						<ul class="list-inline">
							<li><a href="{{ url('/checkout') }}">Thanh toán</a></li>
							<li><a href="#">Tài khoản</a></li>
							<li><a href="{{ url('/cart') }}">Giỏ hàng</a></li>
							@if($user)
								<li><a href="{{ url('/user/logout') }}">Đăng xuất</a></li>
							@else
								<li><a href="{{ url('/user/login') }}">Đăng nhập</a></li>
							@endif
						</ul>									
					</nav>
				</div>
			</div>
			<!-- HEADER-RIGHT-MENU END -->
		</div>
	</div>
</div>
<!-- HEADER-TOP END -->
<!-- HEADER-MIDDLE START -->
<section class="header-middle">
	<div class="container">
		<div class="row">
			<div class="col-sm-12">
				<!-- LOGO START -->
				<div class="logo">
					<a href="{{ url('/') }}"><img src="{{url('/images/logo.png')}}" alt="" width="91px" height="91px" /></a>
				</div>
				<!-- LOGO END -->
				<!-- HEADER-RIGHT-CALLUS START -->
				<div class="header-right-callus">
					<h3>Gọi chúng tôi</h3>
					<span>0911-331-616</span>
				</div>
				<!-- HEADER-RIGHT-CALLUS END -->
				<!-- CATEGORYS-PRODUCT-SEARCH START -->
				<div class="categorys-product-search">
					<form action="/search" method="get" class="search-form-cat">
						<div class="search-product form-group">
							<input style="width: 478px;" type="text" class="form-control search-form" name="keyword" id="txtkey" placeholder="Bố mẹ tìm gì cho bé hôm nay? " />
							<button class="search-button" type="submit">
								<i class="fa fa-search"></i>
							</button>							 
						</div>
					</form>
				</div>
				<!-- CATEGORYS-PRODUCT-SEARCH END -->
			</div>
		</div>
	</div>
</section>
<!-- HEADER-MIDDLE END -->
