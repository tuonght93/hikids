<?php use Illuminate\Support\Str as Str; 
    use Illuminate\Support\Facades\Session as Session;
 ?>
@extends('user.template')
@section('title')
    @if (empty($seo['title']))
        <title>Giỏ hàng của bạn | Hikids</title>
    @else
        <title>{{ $seo['title'] }}</title>
    @endif
@stop
@section('main')
<!-- MAIN-CONTENT-SECTION START -->
<section class="main-content-section">
	<div class="container">
		<div class="row">
			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
				<!-- BSTORE-BREADCRUMB START -->
				<div class="bstore-breadcrumb">
					<div style="float: left;" itemscope="" itemtype="http://data-vocabulary.org/Breadcrumb">
						<a href="{{ url('/') }}" itemprop="url">Trang chủ</a>
					</div>
					<div style="float: left;" itemscope="" itemtype="http://data-vocabulary.org/Breadcrumb">
						<span><i class="fa fa-caret-right"></i></span>
						<span itemprop="title">Giỏ hàng</span>
					</div>
				</div>
				<!-- BSTORE-BREADCRUMB END -->
			</div>
		</div>
		<div class="row">
			@if($count > 0)
			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
				<!-- SHOPPING-CART SUMMARY START -->
				<h2><span class="shop-pro-item">Giỏ hàng của bạn chứa {{ $count }} sản phẩm</span></h2>
				<!-- SHOPPING-CART SUMMARY END -->
			</div>	
			
			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
				<!-- CART TABLE_BLOCK START -->
				<div class="table-responsive">
					<!-- TABLE START -->
					<form action="{{ url('/cart/update') }}" method="post">
					<input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
					<table class="table table-bordered" id="cart-summary">
						<!-- TABLE HEADER START -->
						<thead>
							<tr>
								<th class="cart-product">Hình ảnh</th>
								<th class="cart-description">Mô tả</th>
								<th class="cart-unit text-right">Giá bán</th>
								<th class="cart_quantity text-center">Số lượng</th>
								<th class="cart-delete">&nbsp;</th>
								<th class="cart-total text-right">Tổng tiền</th>
							</tr>
						</thead>
						<!-- TABLE HEADER END -->
						<!-- TABLE BODY START -->
						<tbody>	
							<!-- SINGLE CART_ITEM START -->
							@foreach ($carts as $cart)
							<tr>
								<input type="hidden" name="rowid[]" value="{{ $cart->rowid }}" />
								<td class="cart-product">
									<img alt="Blouse" src="{{ config('image.image_url').'/products/'.$cart['options']['image'] }}">
								</td>
								<td class="cart-description">
									<p class="product-name"><a href="#">{{ $cart->name }}</a></p>
									<small>Color : {{ $cart->options->color }}</small>
									<small>Size : {{ $cart->options->size }}</small>
								</td>
								<td class="cart-unit">
									<ul class="price text-right">
										<li class="price">{{ number_format($cart->price,0,",",".") }} đ</li>
									</ul>
								</td>
								<td class="cart_quantity text-center">
									<div class="cart-plus-minus-button">
										<input class="cart-plus-minus" type="text" name="qty[]" value="{{ $cart->qty }}">
									</div>
								</td>
								<td class="cart-delete text-center">
									<span>
										<a href="{{ url('/cart/destroy/'.$cart->rowid) }}" class="cart_quantity_delete" title="Delete" onClick="return confirm('Bạn có chắc muốn xóa sản phẩm này!')"><i class="fa fa-trash-o"></i></a>
									</span>
								</td>
								<td class="cart-total">
									<span class="price">{{ number_format($cart->price*$cart->qty,0,",",".") }} đ</span>
								</td>
							</tr>
							@endforeach
							<!-- SINGLE CART_ITEM END -->
						</tbody>
						<!-- TABLE BODY END -->
						<!-- TABLE FOOTER START -->
						<tfoot>		
							<tr>
								<td class="total-price-container text-right" colspan="5">
									<span>Tổng thanh toán</span>
								</td>
								<td id="total-price-container" class="price" colspan="1">
									<span id="total-price">{{ number_format($total,0,",",".") }} đ</span>
								</td>
							</tr>
						</tfoot>		
						<!-- TABLE FOOTER END -->									
					</table>
					<!-- TABLE END -->
				</div>
				<!-- CART TABLE_BLOCK END -->
			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
				<button class="btn btn-warning" style="float: right; margin-bottom: 20px;" type="submit">Tính lại</button>
			</div>
			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
				<!-- RETURNE-CONTINUE-SHOP START -->
				<div class="returne-continue-shop">
					<a href="{{ url('/') }}" class="continueshoping"><i class="fa fa-chevron-left"></i>Tiếp tục mua hàng</a>
					<a href="{{ url('/checkout') }}" class="procedtocheckout">Thanh toán<i class="fa fa-chevron-right"></i></a>
				</div>	
				<!-- RETURNE-CONTINUE-SHOP END -->						
			</div>
			</form>
			@else
			@if(Session::has('errors'))
			  <div class="alert alert-danger alert-white rounded">
			    <button type="button" data-dismiss="alert" aria-hidden="true" class="close">×</button>
			    <div class="icon" data-dismiss="alert" aria-hidden="true" class="close"></div>
			      <strong>Giỏ hàng trống!</strong>
			      @foreach ($errors->all() as $error)
			          {{ $error }}<br/>
			      @endforeach
			</div>
			 @endif
			<div class="span16 main-content-grid">
			    <p class="ty-no-items">Giỏ hàng trống</p>
			    <div class="buttons-container wrap">
			    <a href="{{ url('/') }}" class="ty-btn ty-btn__secondary ">Quay về trang chủ</a>
			    </div>
			</div>
			@endif
		</div>
	</div>
</section>
<!-- MAIN-CONTENT-SECTION END -->
@stop