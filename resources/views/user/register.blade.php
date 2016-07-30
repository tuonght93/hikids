<?php use Illuminate\Support\Str as Str; 
    use Illuminate\Support\Facades\Session as Session;
 ?>
@extends('user.template')
@section('title')
    @if (empty($seo['title']))
        <title>Thanh toán | Shop thời trang</title>
    @else
        <title>{{ $seo['title'] }}</title>
    @endif
@stop
@section('main')
<br/>
<!-- MAIN-CONTENT-SECTION START -->
<section class="main-content-section">
	<div class="container">
		<div class="row">
			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
				<h2 class="page-title">Đăng nhập / Đăng ký</h2>
			</div>
			@if(Session::has('success'))
			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			  <div class="alert alert-success alert-white rounded">
			    <button type="button" data-dismiss="alert" aria-hidden="true" class="close">×</button>
			    <div class="icon" data-dismiss="alert" aria-hidden="true" class="close"></div>
			      <strong>Thành công! </strong>
			      {{ Session::get( 'success' ) }}
			</div>
			</div>
			 @endif
			<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
				<!-- CREATE-NEW-ACCOUNT START -->
				<div class="create-new-account">
					<form class="new-account-box primari-box" id="create-new-account" method="post" action="#">
						<h3 class="box-subheading">Đăng ký và đăng nhập tài khoản</h3>
						<div class="form-content">
							<p>Bạn đã có tài khoản</p>
							<div class="submit-button">
								<a href="{{ url('/user/login') }}" id="SubmitCreate" class="btn main-btn">
									<span>
										<i class="fa fa-user submit-icon"></i>
										Đăng nhập
									</span>											
								</a>
							</div>
						</div>
					</form>							
				</div>
				<!-- CREATE-NEW-ACCOUNT END -->
			</div>
			<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
				<!-- REGISTERED-ACCOUNT START -->
				<div class="primari-box registered-account">
					<form class="new-account-box" id="accountLogin" method="post" action="{{ url('/user/register') }}" data-parsley-validate>
						<input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
						<h3 class="box-subheading">Đăng ký tài khoản</h3>
						<div class="form-content">
							@if(Session::has('errors'))
								@foreach ($errors->all() as $error)
				          <p style="color:red">{{ $error }}</p>
					      @endforeach
					    @endif
							<div class="form-group primary-form-group">
								<label for="loginemail">Tên đăng nhập</label>
			                  {!! Form::text('username', Input::old('username',''), array('placeholder' => 'Tên đăng nhập', 'class' => 'form-control input-feild', 'id' => 'username', 'required' => '""', 'data-parsley-required-message'=> 'Vui lòng điền tên đăng nhập')) !!}
			                </div>
			                <div class="form-group primary-form-group">
			                	<label for="loginemail">Mật khẩu</label>
			                  {!! Form::password('password', array('placeholder' => 'Mật khẩu', 'class' => 'form-control input-feild', 'id' => 'password', 'required' => '""', 'data-parsley-required-message'=> 'Vui lòng điền mật khẩu' )) !!}
			                </div>
			                <div class="form-group primary-form-group">
			                	<label for="loginemail">Nhập lại mật khẩu</label>
			                  {!! Form::password('password_confirmation', array('placeholder' => 'Nhập lại mật khẩu', 'class' => 'form-control input-feild', 'id' => 'password_confirmation', 'required' => '""','data-parsley-equalto'=> '#password', 'data-parsley-equalto-message'=> 'Mật khẩu xác nhận không chính xác!', 'data-parsley-required-message'=> 'Vui lòng điền mật khẩu' )) !!}
			                </div>
			                <div class="form-group primary-form-group">
			                	<label for="loginemail">Email</label>
			                  	{!! Form::text('email', Input::old('email',''), array('placeholder' => 'Email', 'class' => 'form-control input-feild', 'id' => 'email', 'required' => '""', 'data-parsley-type'=> 'email', 'data-parsley-required-message'=> 'Vui lòng nhập email', 'data-parsley-type-message'=> 'Không đúng định dạng email')) !!}
			                </div>
			                <div class="form-group primary-form-group">
			                	<label for="loginemail">Họ và tên</label>
			                  {!! Form::text('fullname', Input::old('fullname',''), array('placeholder' => 'Họ và tên', 'class' => 'form-control input-feild', 'id' => 'fullname', 'required' => '""', 'data-parsley-required-message'=> 'Vui lòng nhập họ và tên')) !!}
			                </div>
			                <div class="form-group primary-form-group">
			                	<label for="loginemail">Địa chỉ</label>
			                  {!! Form::text('city', Input::old('city',''), array('placeholder' => 'Địa chỉ', 'class' => 'form-control input-feild', 'id' => 'city')) !!}
			                </div>
			                <div class="form-group primary-form-group">
			                	<label for="loginemail">Điện thoại</label>
			                  {!! Form::text('phone', Input::old('phone',''), array('placeholder' => 'Điện thoai', 'class' => 'form-control input-feild', 'id' => 'phone', 'data-parsley-length'=> '[10, 11]', 'data-parsley-type' =>'number', 'data-parsley-type-message'=> 'Mục này phải nhập số', 'data-parsley-length-message'=> 'Số điện thoại phải 10 hoặc 11 số')) !!}
			                </div>
							<div class="forget-password">
								<p><a href="{{ url('/user/forgetPassword') }}">Nhấn vào đây nếu bạn quên mật khẩu</a></p>
							</div>
							<div class="submit-button">
								<button type="submit" name="btnreg" class="btn main-btn"><span><i class="fa fa-lock submit-icon "></i>Đăng ký</span></button>
							</div>
						</div>
					</form>							
				</div>
				<!-- REGISTERED-ACCOUNT END -->
			</div>				
		</div>
	</div>
</section>
<!-- MAIN-CONTENT-SECTION END -->	
@stop

@section('scripts')
<script type="text/javascript" src="/js/parsley.js"></script>
<script type="text/javascript" src="/js/parsley.min.js"></script>
@stop