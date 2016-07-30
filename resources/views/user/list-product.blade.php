<?php use Illuminate\Support\Str as Str; 
    use Illuminate\Support\Facades\Session as Session;
 ?>
@extends('user.template')
@section('title')
    @if (empty($seo['title']))
        <title>Danh mục sản phẩm | Hikids</title>
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
						<span itemprop="title">{{ $category->name }}</span>
					</div>
				</div>
				<!-- BSTORE-BREADCRUMB END -->
		</div>
	</div>
	<br/>
	<div class="row">
		<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
			<!-- PRODUCT-LEFT-SIDEBAR START -->
			<div class="product-left-sidebar">
				<h2 class="left-title pro-g-page-title">Bộ lọc</h2>
				<form action="{!! url('/categories').'/'.$category->slug !!}" method="get" id="form_filter" name="form_filter">
				<!-- SINGLE SIDEBAR PRICE START -->
				<div class="product-single-sidebar">
					<span class="sidebar-title">Price</span>
					<ul>
						<li> 
							<input type="text" id="min_price" name="min_price" /> đ -
							<input type="text" id="max_price" name="max_price" /> đ 
						</li>
						<li>
							<div id="price-range"></div>	
						</li>
					</ul>
				</div>
				<!-- SINGLE SIDEBAR PRICE END -->
				<!-- SINGLE SIDEBAR CATEGORIES START -->
				@if (count($colors)>0)
				<div class="product-single-sidebar">
					<span class="sidebar-title">Màu sắc</span>
					<div style="max-height: 200px; overflow-y: auto;">
						<ul>
						@foreach ($colors as $color)
						<?php $checked = in_array(''.$color->id, $color_selected) ? 'checked="checked"' : ''?>
							<li>
								<label class="cheker">
									<input type="checkbox" value="{{ $color->id }}" <?php echo $checked;?> name="color_ids[]" />
									<span></span>
								</label>
								<span> {{ $color->title }} </span>
							</li>
						@endforeach
						</ul>
					</div>
				</div>
				@endif
				<!-- SINGLE SIDEBAR CATEGORIES END -->
				<!-- SINGLE SIDEBAR AVAILABILITY START -->
				@if (count($sizes)>0)
				<div class="product-single-sidebar">
					<span class="sidebar-title">Kích cỡ</span>
					<div style="max-height: 200px; overflow-y: auto;">
						<ul>
						@foreach ($sizes as $size)
						<?php $checked = in_array(''.$size->id, $size_selected) ? 'checked="checked"' : ''?>
							<li>
								<label class="cheker">
									<input type="checkbox" value="{{ $size->id }}" <?php echo $checked;?> name="size_ids[]" />
									<span></span>
								</label>
								<span> {{ $size->title }} </span>
							</li>
						@endforeach
						</ul>
					</div>
				</div>
				@endif
				<!-- SINGLE SIDEBAR AVAILABILITY END -->
				<button class="btn btn-succsess" type="submit">Lọc sản phẩm</button>
				</form>
			</div>
			<!-- PRODUCT-LEFT-SIDEBAR END -->
		</div>
		<div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
			<div class="right-all-product">
				@if(!empty($category->thumbnail))
				<!-- PRODUCT-CATEGORY-HEADER START -->
				<div class="product-category-header">
					<div class="category-header-image">
						<img src="{{ config('image.image_url').'/productCategories/'.$category->thumbnail.'_870x217.png' }}" alt="category-header" />							
					</div>
				</div>
				@endif
				<!-- PRODUCT-CATEGORY-HEADER END -->
				<div class="product-category-title">
					<!-- PRODUCT-CATEGORY-TITLE START -->
					<h1>
						<span class="cat-name">{{ $category->name }}</span>
						<span class="count-product">Tìm thấy {{ $total_products }} sản phẩm</span>
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
							<div class="col-md-4">
								<div class="item">
									<div class="new-product">
										<div class="single-product-item">
											<div class="product-image zoom-img">
												<a href="{{ url('/product/'.$item->slug) }}"><img src="{{ config('image.image_url').'/products/'.$item->image_url().'_400x300.png' }}" alt="{{ $item->name }}" title="{{ $item->name }}" /></a>
												<span class="new-mark-box">new</span>
											</div>
											<div class="product-info ty-grid-list__item-name">
												<h3><a href="{{ url('/product/'.$item->slug) }}" class="product-title" title="{{ $item->name }}">{{ $item->name }}</a></h3>
												<div class="price-box ty-grid-list__price">
													<span class="price">{{ number_format($item->price,0,",",".") }}  đ</span>
													@if(!empty($item->old_price))
													<span class="old-price">{{ number_format($item->old_price,0,",",".") }} đ</span>
													@endif
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
									<a href="{{ $products->url($products->currentPage() - 1) }}" ><i class="fa fa-chevron-left"></i>Previous</a>
								</li>
								@endif
								@for ($i = 1; $i <= $products->lastPage(); $i++)
								<li class="{{ $products->currentPage() == $i ? 'active' : '' }}">
									<span><a class="pagi-num" href="{{ $products->url($i) }}">{{ $i }}</a></span>
								</li>
								@endfor
								@if($products->currentPage() != $products->lastPage())
								<li>
									<a href="{{ $products->url($products->currentPage() + 1 ) }}" >Next<i class="fa fa-chevron-right"></i></a>
								</li>
								@endif
							</ul>
						</div>
					</div>
					@endif
					<!-- PRODUCT-SHOOTING-RESULT END -->
					<div class="col-xs-12 introduce">
					{!! $category->description !!}
					</div>
				</div>
			</div>
			<!-- ALL GATEGORY-PRODUCT END -->
		</div>
	</div>
</div>
</section>
<!-- MAIN-CONTENT-SECTION END -->
@stop	

@section('scripts')
<script type="text/javascript">
$(document).ready(function(){
	var min_price = <?php echo $min_price; ?>;
	var max_price = <?php echo $max_price; ?>;
	var min_price_get = <?php echo $min_price_get; ?>;
	var max_price_get = <?php echo $max_price_get; ?>;
	$( "#price-range" ).slider({
		range: true,
		min: min_price_get,
		max: max_price_get,
		values: [ min_price, max_price ],
		slide: function( event, ui ) {
			$( "#min_price" ).val( ui.values[ 0 ] );
			$( "#max_price" ).val( ui.values[ 1 ] );
		}
	});
		
	$( "#min_price" ).val( $( "#price-range" ).slider( "values", 0 ) );
	$( "#max_price" ).val( $( "#price-range" ).slider( "values", 1 ) );
	});
		</script>	
@stop