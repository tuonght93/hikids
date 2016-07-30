<?php use Illuminate\Support\Str as Str; 
    use Illuminate\Support\Facades\Session as Session;
 ?>
@extends('user.template')
@section('title')
    @if (empty($seo['title']))
        <title>Đặt hàng | hikids</title>
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
						<span itemprop="title">Thanh toán</span>
					</div>
				</div>
				<!-- BSTORE-BREADCRUMB END -->
			</div>
		</div>
		<br/>
		<div class="row">
			<div class="col-lg-7 col-md-7 col-sm-7 col-xs-12">
				<!-- CREATE-NEW-ACCOUNT START -->
				<div class="create-new-account">
					<form class="new-account-box primari-box" id="create-new-account" method="post" action="" data-parsley-validate>
						<input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
						<h3 class="box-subheading">Điền thông tin thanh toán</h3>
						<div class="form-content">
							<p>Vui lòng điền đầy đủ thông tin để chúng tôi giao hàng tận nơi</p>
							@if(Session::has('errors'))
								@foreach ($errors->all() as $error)
					          <p style="color:red">{{ $error }}</p>
						      @endforeach
						    @endif
							<div class="form-group primary-form-group">
								<label for="email">Họ và tên *</label>
								{!! Form::text('name', Input::old('name',''), array('placeholder' => 'Họ tên', 'class' => 'form-control input-feild', 'id' => 'name', 'required' => '""', 'data-parsley-required-message'=> 'Phiền bạn nhập họ và tên')) !!}
							</div>
							<div class="form-group primary-form-group">
								<label for="email">Điện thoại *</label>
								{!! Form::text('phone', Input::old('phone',''), array('placeholder' => 'Điện thoai', 'class' => 'form-control input-feild', 'id' => 'phone', 'required' => '""', 'data-parsley-length'=> '[10, 11]', 'data-parsley-type' =>'number', 'data-parsley-required-message'=> 'Phiền bạn nhập số điện thoại', 'data-parsley-type-message'=> 'Trường này phải nhập số', 'data-parsley-length-message'=> 'Số điện thoại phải 10 hoặc 11 số')) !!}
							</div>
							<div class="form-group primary-form-group">
								<label for="email">Tỉnh / Thành phố</label>
			                        <?php 
			                            $data_cities = array();
			                            $data_cities[''] = 'Chọn Tỉnh / Thành phố';
			                        ?>
			                        @foreach($cities as $city)
			                          <?php
			                            $data_cities[''.$city->id] = $city->name;
			                          ?>             
			                        @endforeach
			                        {!! Form::select('city', $data_cities, Input::old('city',''),  array('id' => 'city', 'class' => 'form-control input-feild','style' => 'max-width:271px;', 'required' => '""', 'data-parsley-required-message'=> 'Phiền bạn nhập tỉnh / thành phố ')) !!}
							</div>
							<div class="form-group primary-form-group">
								<label for="email">Chọn Quận/Huyện</label>
									<?php 
			                            $data_districts = array();
			                            $data_districts[''] = 'Chọn Quận / Huyện';
			                        ?>
			                        {!! Form::select('district', $data_districts ,Input::old('district',''),  array('id' => 'district', 'class' => 'form-control input-feild','style' => 'max-width:271px;', 'required' => '""', 'data-parsley-required-message'=> 'Phiền bạn nhập quận / huyện ')) !!}
							</div>
							<div class="form-group primary-form-group" id="form">
							<div style="display: none;">
							<input type="checkbox" name="form" value="1" /> Bạn có muốn chuyển hàng nhanh (<a style="text-decoration: underline;" href="{{ url('/page/chinh-sach-giao-hang') }}">xem chi tiết</a>)
							</div>
							</div>
							<div class="form-group primary-form-group">
								<label for="email">Địa chỉ *</label>
								{!! Form::text('address', Input::old('address',''), array('placeholder' => 'Địa chỉ', 'class' => 'form-control input-feild', 'id' => 'address', 'required' => '""', 'data-parsley-required-message'=> 'Phiền bạn nhập địa chỉ')) !!}
							</div>
							<div class="form-group primary-form-group">
								<label for="email">Email address *</label>
								{!! Form::text('email', Input::old('email',''), array('placeholder' => 'Email', 'class' => 'form-control input-feild', 'id' => 'email', 'required' => '""', 'data-parsley-type'=> 'email', 'data-parsley-required-message'=> 'Phiền bạn nhập email', 'data-parsley-type-message'=> 'Không đúng định dạng email')) !!}
							</div>
							<div class="form-group primary-form-group">
								<label for="date">Ngày nhận *</label>
								{!! Form::text('date', Input::old('date',''), array('placeholder' => 'Ngày nhận','readonly' , 'class' => 'form-control input-feild', 'id' => 'date', 'required' => '""', 'data-parsley-required-message'=> 'Phiền bạn chọn ngày nhận')) !!}
							</div>
							<div class="form-group primary-form-group">
								<label for="shipping">Hình thức thanh toán(<a style="text-decoration: underline;" href="{{ url('/page/phuong-thuc-thanh-toan') }}">xem chi tiết</a>)</label><br/>
								  <input type="radio" name="payments" id="inlineRadio1" value="1" checked=""> Thanh toán sau khi nhận hàng(COD) <br/>
								  <input type="radio" name="payments" id="inlineRadio2" value="2"> Thanh toán trước khi nhận hàng
							</div>
							<div class="form-group primary-form-group">
								<label for="note">Ghi chú</label>
								<textarea name="note" id="note" style="height: 200px" class="form-control input-feild"></textarea>
							</div>
							<div class="submit-button">
								<button type="submit" id="SubmitCreate" class="btn main-btn">
									<span>
										Thanh toán
									</span>											
								</button>
							</div>
						</div>
					</form>							
				</div>
				<!-- CREATE-NEW-ACCOUNT END -->
			</div>
			<div class="col-lg-5 col-md-5 col-sm-5 col-xs-12">
				<div id="checkout_order_info_42_wrap"><!--checkout_order_info_42_wrap--></div><div class="ty-sidebox checkout-products">
			        <h2 class="ty-sidebox__title ">
			            <span class="ty-sidebox__title-wrapper hidden-phone">Thông tin đơn hàng</span>
			                <span class="cm-combination" id="sw_sidebox_33">
			                    <span class="ty-sidebox__title-wrapper visible-phone">Thông tin đơn hàng</span>
			                    <span class="ty-sidebox__title-toggle visible-phone">
			                    <i class="ty-sidebox__icon-open ty-icon-down-open"></i>
			                    <i class="ty-sidebox__icon-hide ty-icon-up-open"></i>
			                    </span>
			                </span>
			        </h2>
			        <div class="ty-sidebox__body" id="sidebox_33">
			        <div id="checkout_info_products_41">
			    		<ul class="ty-order-products__list order-product-list">
			    			@foreach($carts as $cart)
			    			<li class="ty-order-products__item">
			                    <p class="ty-order-products__a">{{ $cart->name }}</p>
			                    <a data-ca-dispatch="delete_cart_item" href="http://babi.vn/index.php?dispatch=checkout.delete&amp;cart_id=2869693155&amp;redirect_mode=checkout" class="ty-order-products__item-delete delete" data-ca-target-id="cart_status*"><i title="Loại bỏ" class="ty-icon-cancel-circle"></i></a>
								<div class="ty-order-products__price">
			                            {{ $cart->qty }}&nbsp;x&nbsp;<span>{{ number_format($cart->price,0,",",".") }}</span>&nbsp;đ
			                    </div>
			                    <span class="ty-product-options clearfix"><span class="ty-product-options-name">Màu sắc:&nbsp;</span><span class="ty-product-options-content">{{ $cart->options->color }}&nbsp;</span></span><span class="ty-product-options clearfix"><span class="ty-product-options-name">Kích cỡ:&nbsp;</span><span class="ty-product-options-content">{{ $cart->options->size }}&nbsp;</span></span>
			                </li>
			                @endforeach
			            </ul>
					</div></div>
			    	</div>
			    	<div class="ty-sidebox checkout-summary">
			        <h2 class="ty-sidebox__title ">
			            <span class="ty-sidebox__title-wrapper hidden-phone">Tóm tắt đơn hàng</span>
			                <span class="cm-combination" id="sw_sidebox_32">
			                    <span class="ty-sidebox__title-wrapper visible-phone">Tóm tắt đơn hàng</span>
			                    <span class="ty-sidebox__title-toggle visible-phone">
			                        <i class="ty-sidebox__icon-open ty-icon-down-open"></i>
			                        <i class="ty-sidebox__icon-hide ty-icon-up-open"></i>
			                    </span>
			            </span>
			        </h2>
			        <div class="ty-sidebox__body" id="sidebox_32"><div class="ty-checkout-summary" id="checkout_info_summary_40">
			    	<table class="ty-checkout-summary__block">
			        <tbody>
			            <tr>
			                <td class="ty-checkout-summary__item">{{ $count }} sản phẩm</td>
			                <td class="ty-checkout-summary__item ty-right" data-ct-checkout-summary="items">
			                    <span><span>{{ number_format($total,0,",",".") }}</span>&nbsp;đ</span>
			                </td>
			            </tr>
			        </tbody>
			        <tbody>
			            <tr>
			                <th class="ty-checkout-summary__total" colspan="2" data-ct-checkout-summary="order-total">
			                    <div>
			                        Tổng đơn hàng
			                        <span class="ty-checkout-summary__total-sum"><span>{{ number_format($total,0,",",".") }}</span>&nbsp;đ</span>
			                    </div>
			                </th>
			            </tr>
			        </tbody>
			    </table>
			<!--checkout_info_summary_40--></div>
			</div>
			</div>				
		</div>
	</div>
</section>
<!-- MAIN-CONTENT-SECTION END -->
@stop

@section('scripts')
<script type="text/javascript" src="/js/parsley.js"></script>
<script type="text/javascript" src="/js/parsley.min.js"></script>
<script type="text/javascript">
$(document).ready(function(){
	  rome(date, { time: false });
	  $('#city').on('change', function() {
	  	var token = '<?php echo csrf_token(); ?>';
		var city_id = $('#city').val();
		$.ajax({
      url : "/checkout/adddistrict",
      type: "post",
      data: {
        city_id : city_id,
        _token : token,
     },
    }).done(function( rels ) {
      $('#district').html(rels);
    });
	});

	$('#district').on('change', function() {
	  	var token = '<?php echo csrf_token(); ?>';
		var district_id = $('#district').val();
		$.ajax({
      url : "/checkout/addform",
      type: "post",
      data: {
        district_id : district_id,
        _token : token,
     },
    }).done(function( rels ) {
      $('#form').html(rels);
    });
	});
});
</script>

@stop