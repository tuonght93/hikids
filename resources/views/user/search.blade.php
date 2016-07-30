<?php use Illuminate\Support\Str as Str; 
    use Illuminate\Support\Facades\Session as Session;
 ?>
@extends('user.template')
@section('title')
    @if (empty($seo['title']))
        <title>Kết quả tìm kiếm1 | Happy Skin</title>
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
				<a href="{{ url('/') }}">Trang chủ</a>
				<span><i class="fa fa-caret-right	"></i></span>
				<span>Search</span>
			</div>
			<!-- BSTORE-BREADCRUMB END -->
		</div>
	</div>
	<div class="row">
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<div class="right-all-product">
				<div class="product-category-title">
					<!-- PRODUCT-CATEGORY-TITLE START -->
					<h1>
						<span class="cat-name">Kết quả tìm kiếm : {{ $keyword }}</span>
						<span class="count-product">Sản phẩm tìm thấy : {{ $products->count() }}</span>
					</h1>
					<!-- PRODUCT-CATEGORY-TITLE END -->
				</div>
			</div>
			<!-- ALL GATEGORY-PRODUCT START -->
			<div class="new-product-area">					
				<div class="row">
					<div class="col-xs-12">
						<div class="row">
							<!-- HOME2-NEW-PRO-CAROUSEL START -->
							<!-- <div class="home2-new-pro-carousel"> -->
								<!-- NEW-PRODUCT SINGLE ITEM START -->
							@foreach($products as $item)
							<div class="col-md-3">
								<div class="item">
									<div class="new-product">
										<div class="single-product-item">
											<div class="product-image">
												<a href="{{ url('/product/'.$item->slug) }}"><img src="{{ config('image.image_url').'/products/'.$item->image_url().'_400x300.png' }}" alt="{{ $item->name }}" /></a>
												<span class="new-mark-box">new</span>
											</div>
											<div class="product-info">
												<h3><a href="{{ url('/product/'.$item->slug) }}" title="{{ $item->name }}">{{ $item->name }}</a></h3>
												<div class="price-box">
													<span class="price">{{ number_format($item->price) }}  đ</span>
													<span class="old-price">{{ number_format($item->old_price) }} đ</span>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
							@endforeach
								<!-- NEW-PRODUCT SINGLE ITEM END -->
							<!-- </div> -->
							<!-- HOME2-NEW-PRO-CAROUSEL END -->
						</div>
					</div>
				</div>
			</div>
			<!-- ALL GATEGORY-PRODUCT END -->
			<!-- PRODUCT-SHOOTING-RESULT START -->
			@if($products->count() < $products->total())
			<div class="product-shooting-result product-shooting-result-border">
				<div class="showing-item">
					<span>Hiển thị 1 - {{ $products->count() }} của {{ $products->total() }} sản phẩm</span>
				</div>
				<div class="showing-next-prev">
					<ul class="pagination-bar">
						@if($products->currentPage() != 1)
						<li>
							<a href="{{ str_replace('/?','?',$products->url($products->currentPage() - 1)) }}" ><i class="fa fa-chevron-left"></i>Previous</a>
						</li>
						@endif
						@for ($i = 1; $i <= $products->lastPage(); $i++)
						<li class="{{ $products->currentPage() == $i ? 'active' : '' }}">
							<span><a class="pagi-num" href="{{ str_replace('/?','?',$products->url($i)) }}">{{ $i }}</a></span>
						</li>
						@endfor
						@if($products->currentPage() != $products->lastPage())
						<li>
							<a href="{{ str_replace('/?','?',$products->url($products->currentPage() + 1 )) }}" >Next<i class="fa fa-chevron-right"></i></a>
						</li>
						@endif
					</ul>
				</div>
			</div>
			@endif
			<!-- PRODUCT-SHOOTING-RESULT END -->
		</div>
	</div>
</div>
</section>
<!-- MAIN-CONTENT-SECTION END -->
@stop	