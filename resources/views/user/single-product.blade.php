<?php use Illuminate\Support\Str as Str; 
    use Illuminate\Support\Facades\Session as Session;
 ?>
@extends('user.template')
@section('title')
    @if (empty($seo['title']))
        <title>Sản phẩm | Happy Skin</title>
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
						<span itemprop="title">{{ $product->name }}</span>
					</div>
				</div>
				<!-- BSTORE-BREADCRUMB END -->
			</div>
		</div>	
		<br/>			
		<div class="row">
			<div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
				<!-- SINGLE-PRODUCT-DESCRIPTION START -->
				<form action="{{ url('/cart') }}" method="post">
				<div class="row">

					<div class="col-lg-5 col-md-5 col-sm-4 col-xs-12">
						<input type="hidden" name="_token" id="token" value="<?php echo csrf_token(); ?>">
						<input type="hidden" name="product_id" id="product_id" value="{{ $product->id }}">
						<div class="single-product-view">
							  <!-- Tab panes -->
							<div class="tab-content">
								<div class="tab-pane active" id="{{ $product->id }}">
									<div class="single-product-image">
										<img src="{{ config('image.image_url').'/products/'.$product->image_url().'_800x600.png' }}" alt="{{ $product->name }}" title="{{ $product->name }}" />
										<a class="new-mark-box">new</a>
										<a class="fancybox" href="{{ config('image.image_url').'/products/'.$product->image_url().'_800x600.png' }}" data-fancybox-group="gallery"><span class="btn large-btn">View larger <i class="fa fa-search-plus"></i></span></a>
									</div>	
								</div>
								@if($productphotos)
								@foreach( $productphotos as $productphoto)
								<div class="tab-pane" id="{{ $productphoto->id }}">
									<div class="single-product-image">
										<img src="{{ config('image.image_url').'/products/'.$productphoto->image_url().'_800x600.png' }}" alt="single-product-image" />
										<a class="new-mark-box" href="#">new</a>
										<a class="fancybox" href="{{ config('image.image_url').'/products/'.$productphoto->image_url().'_800x600.png' }}" data-fancybox-group="gallery"><span class="btn large-btn">View larger <i class="fa fa-search-plus"></i></span></a>
									</div>	
								</div>
								@endforeach
								@endif
							</div>										
						</div>
						<div class="select-product">
							<!-- Nav tabs -->
							<ul class="nav nav-tabs select-product-tab bxslider">
								<li class="active">
									<a href="#{{ $product->id }}" data-toggle="tab"><img src="{{ config('image.image_url').'/products/'.$product->image_url().'_100x100.png' }}" alt="{{ $product->name }}" title="{{ $product->name }}" /></a>
								</li>
								@if($productphotos)
								@foreach( $productphotos as $productphoto)
								<li>
									<a href="#{{ $productphoto->id }}" data-toggle="tab"><img src="{{ config('image.image_url').'/products/'.$productphoto->image_url().'_100x100.png' }}" alt="{{ $product->name }}" title="{{ $product->name }}" /></a>
								</li>
								@endforeach
								@endif
							</ul>										
						</div>
					</div>
					<div class="col-lg-7 col-md-7 col-sm-8 col-xs-12">
						<div class="single-product-descirption">
							<h1>{{ $product->name }}</h1><br/><br/>
							<div class="single-product-price">
								<h2>{{ number_format($product->price,0,",",".") }}  đ</h2>
							</div>
							@if($product->introduce)
							<div class="single-product-desc">
								<p>{{ $product->introduce }}</p>
							</div>
							@endif
							@if(!empty($productdetails))
			                <?php
			                  $productcolor = array();
			                  $productsize = array();
			                  $qty = array();
			                  foreach ($productdetails as $productdetail) {
			                    $productcolors[] = $productdetail->color_id;
			                    $productsizes[] = $productdetail->color_id.'-'.$productdetail->size_id;
			                    $qty[] = $productdetail->qty;
			                    $listtitles[] = $productdetail->color->title;
			                  }
			                  $colors = array_unique($productcolors);
			                  $titles = array_unique($listtitles);
			                  $details = array_combine($colors,$titles);
			                ?>
                			@endif
							<div class="single-product-size">
								<p class="small-title">Màu sắc </p> 
								<select name="product_color" id="product_color">
								@foreach( $details as $colors => $titles)
									<option value="{{ $colors }}">{{ $titles }}</option>
								@endforeach
								</select>
							</div>
							<?php
								$colorfirst = $productcolors[0];
								$sizes = $lists->where('product_id', '=', $product->id)->where('color_id', '=', $colorfirst)->get();
							?>
							<div class="single-product-size">
								<p class="small-title">Kích cỡ </p> 
								<select name="product_size" id="product_size">
									@foreach ($sizes as $size)
									<option value="{{ $size->size_id }}">{{ $size->size->title }}</option>
									@endforeach
								</select>
							</div>
							<br/>
							<div class="single-product-add-cart">
								<button class="add-cart-text" type="submit" name="btncart" title="Add to cart">Mua ngay</button>
							</div>
						</div>
					</div>
				</div>
				</form>
				<!-- SINGLE-PRODUCT-DESCRIPTION END -->
				<!-- SINGLE-PRODUCT INFO TAB START -->
				<div class="row">
					<div class="col-sm-12">
						<div class="product-more-info-tab">
							<!-- Nav tabs -->
							<ul class="nav nav-tabs more-info-tab">
								<li class="active"><a href="#moreinfo" data-toggle="tab">Mô tả sản phẩm</a></li>
								<li><a href="#datasheet" data-toggle="tab">Hướng dẫn bảo quản</a></li>
							</ul>
							  <!-- Tab panes -->
							<div class="tab-content">
								<div class="tab-pane active" id="moreinfo">
									<div class="tab-description">
										{!! $product->detail !!}
									</div>
								</div>
								<div class="tab-pane" id="datasheet">
									<div class="deta-sheet">
										{!! $product->how_to_use !!}			
									</div>
								</div>
							</div>									
						</div>
					</div>
				</div>
				<!-- SINGLE-PRODUCT INFO TAB END -->
			</div>
			<!-- RIGHT SIDE BAR START -->
			<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
				<!-- SINGLE SIDE BAR START -->
			@if(!empty($vieweds))
				<div class="single-product-right-sidebar">
					<h2 class="left-title">Sản phẩm vừa xem</h2>
					<ul>
					@foreach($vieweds as $viewed)
						<li>
							<a href="{{ url('/product/'.$viewed->slug) }}"><img src="{{ config('image.image_url').'/products/'.$viewed->image_url().'_70x70.png' }}" alt="" /></a>
							<div class="r-sidebar-pro-content">
								<h5><a href="{{ url('/product/'.$viewed->slug) }}">{{ $viewed->name }}</a></h5><br/>
								<p>{{ number_format($viewed->price,0,",",".") }} đ</p>
							</div>
						</li>
					@endforeach
					</ul>
				</div>	
			@endif
				<!-- SINGLE SIDE BAR END -->
				<!-- SINGLE SIDE BAR START -->						
				<!-- <div class="single-product-right-sidebar">
					<div class="slider-right zoom-img">
						<a href="#"><img class="img-responsive" src="" alt="sidebar left" /></a>
					</div>							
				</div> -->
			</div>
			<!-- SINGLE SIDE BAR END -->				
		</div>
	</div>
</section>
<!-- MAIN-CONTENT-SECTION END -->

@stop
