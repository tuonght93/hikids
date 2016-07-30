<?php use Illuminate\Support\Str as Str; 
	use Illuminate\Support\Facades\Session as Session;
 ?>
@extends('user.template')
@section('title')
	@if (empty($seo['title']))
		<title>Cập nhật mật khẩu | Hikids</title>
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
			<!-- BSTORE-BREADCRUMB START -->
			<div class="bstore-breadcrumb">
				<div style="float: left;" itemscope="" itemtype="http://data-vocabulary.org/Breadcrumb">
					<a href="{{ url('/') }}" itemprop="url">Trang chủ</a>
				</div>
				<div style="float: left;" itemscope="" itemtype="http://data-vocabulary.org/Breadcrumb">
					<span><i class="fa fa-caret-right"></i></span>
					<span itemprop="title">Cập nhật mật khẩu</span>
				</div>
			</div>
			</div>
			<!-- BSTORE-BREADCRUMB END -->
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
						<input type="hidden" name="hash_key" value="{{ $hash_key }}">
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
				              	<label for="loginemail">Mật khẩu mới</label>
				                {!! Form::password('password', array('placeholder' => 'Mật khẩu', 'class' => 'form-control input-feild', 'id' => 'password', 'required' => '""' )) !!}
				              </div>
				              <div class="form-group primary-form-group">
				              	<label for="loginemail">Nhập lại mật khẩu</label>
				              	{!! Form::password('password_confirmation', array('placeholder' => 'Mật khẩu', 'class' => 'form-control input-feild', 'id' => 'password_confirmation', 'required' => '""' )) !!}
				              </div>
							<div class="submit-button">
								<button type="submit" name="btnrepass" class="btn main-btn"><span><i class="fa fa-lock submit-icon "></i>Cập nhật mật khẩu</span></button>
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