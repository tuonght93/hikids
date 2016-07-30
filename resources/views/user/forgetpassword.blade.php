<?php use Illuminate\Support\Str as Str; 
	use Illuminate\Support\Facades\Session as Session;
 ?>
@extends('user.template')
@section('title')
	@if (empty($seo['title']))
		<title>Quên mật khẩu | Hikids</title>
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
				<h2 class="page-title">Quên mật khẩu</h2>
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
						<h3 class="box-subheading">bạn là khách chưa có tài khoản</h3>
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
					<form class="new-account-box" id="accountLogin" method="post" action="" data-parsley-validate>
						<input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
						<h3 class="box-subheading">Lấy lại mật khẩu</h3>
						<div class="form-content">
							@if(Session::has('errors'))
							  <div class="alert alert-danger alert-white rounded">
								<button type="button" data-dismiss="alert" aria-hidden="true" class="close">×</button>
								<div class="icon" data-dismiss="alert" aria-hidden="true" class="close"></div>
								  <strong>Lỗi!</strong>
								  @foreach ($errors->all() as $error)
									  {{ $error }}<br/>
								  @endforeach
							</div>
							@endif
							<div class="form-group primary-form-group">
			                	<label for="loginemail">Email</label>
			                  {!! Form::text('email', Input::old('email',''), array('placeholder' => 'Email', 'class' => 'form-control input-feild', 'id' => 'email', 'required' => '""', 'data-parsley-type'=> 'email', 'data-parsley-required-message'=> 'Phiền bạn nhập email', 'data-parsley-type-message'=> 'Không đúng định dạng email')) !!}
			                </div>
							<div class="submit-button">
								<button type="submit" name="btnrepass" class="btn main-btn"><span><i class="fa fa-lock submit-icon "></i>Lấy lại mật khẩu</span></button>
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