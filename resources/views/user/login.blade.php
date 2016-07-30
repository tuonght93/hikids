<?php use Illuminate\Support\Str as Str; 
    use Illuminate\Support\Facades\Session as Session;
 ?>
@extends('user.template')
@section('title')
    @if (empty($seo['title']))
        <title>Đăng nhập | Hikidss</title>
    @else
        <title>{{ $seo['title'] }}</title>
    @endif
@stop
@section('main')
<!-- MAIN-CONTENT-SECTION START -->
<br/>
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
						<h3 class="box-subheading">Bạn là khách chưa có tài khoản</h3>
						<div class="form-content">
							<p>Bạn chưa có tài khoản</p>
							<div class="submit-button">
								<a href="{{ url('/user/register') }}" id="SubmitCreate" class="btn main-btn">
									<span>
										<i class="fa fa-user submit-icon"></i>
										Đăng ký
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
					<form class="new-account-box" id="accountLogin" method="post" action="{{ url('/user/login') }}" data-parsley-validate>
						<input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
						<h3 class="box-subheading">Đăng nhập</h3>
						<div class="form-content">
							@if(Session::has('errors'))
							@foreach ($errors->all() as $error)
					          <p style="color:red">{{ $error }}</p>
					    @endforeach
					    @endif
							<div class="form-group primary-form-group">
								<label for="loginemail">Tên đăng nhập</label>
								{!! Form::text('username', Input::old('username',''), array('placeholder' => 'Tên đăng nhập', 'class' => 'form-control input-feild', 'id' => 'username', 'required' => '""', 'data-parsley-required-message'=> 'Bạn phải nhập trường này')) !!}
							</div>
							<div class="form-group primary-form-group">
								<label for="password">Password</label>
								{!! Form::password('password', array('placeholder' => 'Mật khẩu', 'class' => 'form-control input-feild', 'id' => 'password', 'required' => '""', 'data-parsley-required-message'=> 'Bạn phải nhập trường này' )) !!}
							</div>
							<div class="forget-password">
								<p><a href="{{ url('/user/forgetPassword') }}">Nhấn vào đây nếu bạn quên mật khẩu</a></p>
							</div>
							<div class="submit-button">
								<button type="submit" class="btn main-btn"><span><i class="fa fa-lock submit-icon "></i>Đăng nhập</span></button>&nbsp
								<span>Hoặc</span>&nbsp
								<a href="{{ url('/facebook') }}" class="btn btn-facebook"><span><i class="fa fa-facebook submit-icon "></i>Đăng nhập bằng Facebook</span></a>
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