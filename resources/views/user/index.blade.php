<?php use Illuminate\Support\Str as Str; 
    use Illuminate\Support\Facades\Session as Session;
 ?>
@extends('user.template')
@section('title')
    @if (empty($seo['title']))
        <title>Trang chủ | Hikids</title>
    @else
        <title>{{ $seo['title'] }}</title>
    @endif
@stop
@section('main')
@include('user/inc/slide')
		
		<!-- MAIN-CONTENT-SECTION START -->
		<section class="main-content-section">
			<div class="container">
				<div class="row">
					<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
						<div class="row">
							@if($productsellings->count() > 0)
							<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
								<div class="new-product-area">
									<div class="left-title-area">
										<h2 class="left-title">Quần áo trẻ em bán chạy</h2>
									</div>						
									<div class="row">
										<div class="col-xs-12">
											<div class="row">
												<!-- HOME2-NEW-PRO-CAROUSEL START -->
												<!-- <div class="home2-new-pro-carousel"> -->
													<!-- NEW-PRODUCT SINGLE ITEM START -->
													@foreach($productsellings as $item)
													<div class="col-md-3">
													<div class="item">
														<div class="new-product">
															<div class="single-product-item">
																<div class="product-image zoom-img">
																	<a href="{{ url('/product/'.$item->slug) }}"><img class="zoom-img" src="{{ config('image.image_url').'/products/'.$item->image_url().'_300x300.png' }}" alt="{{ $item->name }}" title="{{ $item->name }}" /></a>
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
									</div>
								</div>										
							</div>
							@endif
							@if($categories)
							<?php
								$category = $categories::where('parent_id', '=', '')->get();
							?>
							@foreach($category as $cate)
							<?php
								$list = array();
								$list[] = $cate->id;
						        $listcates = $categories->get_categories_tree($cate->id,0);
						        foreach ($listcates as $listcate) {
						          $list[] = $listcate->id;
						        }
								$products = $categories->listproducts($list);
							?>
							@if(count($products) > 0)
							<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
								<div class="new-product-area">
									<div class="left-title-area">
										<h2 class="left-title"><a href="{{ url('/category/'.$cate->slug) }}">{{ $cate->name }}</a></h2>
										<?php
											$category2 = $categories::where('parent_id', '=', $cate->id)->get();
										?>
										@if($category2->count() > 0)
										<div class="ty-mainbox-submenu">
											<ul>
												@foreach($category2 as $cate2)
												<li><a href="{{ url('/category/'.$cate->slug.'/'.$cate2->slug) }}" > {{ $cate2->name }}</a></li>
												@endforeach
											</ul>
										</div>
										@endif
									</div>
								</div>					
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
																<div class="product-image zoom-img">
																	<a href="{{ url('/product/'.$item->slug) }}"><img class="zoom-img" src="{{ config('image.image_url').'/products/'.$item->image_url().'_300x300.png' }}" alt="{{ $item->name }}" title="{{ $item->name }}" /></a>
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
									</div>
								</div>	
							@endif
							@endforeach
							@endif									
							</div>
						</div>	
					</div>	
				</div>
		</section>
		<!-- MAIN-CONTENT-SECTION END -->

		
@stop