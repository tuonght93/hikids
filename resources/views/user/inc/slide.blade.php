<!-- HEADER-BOTTOM-AREA START -->
@if(count($slides) > 0) 
<section class="header-bottom-area">
	<div class="container">
		<div class="row">
			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
				<!-- MAIN-SLIDER-AREA START -->
				<div class="main-slider-area">
					<div class="slider-area">
						<div id="wrapper">
							<div class="slider-wrapper">
								<div id="mainSlider" class="nivoSlider">
									@foreach ($slides as $slide)
									<img src="{{ config('image.image_url').'/slides/'.$slide->thumbnail.'_1140x350.png' }}" alt="{{ $slide->title }}" title="#{{ $slide->slug }}"/>
									@endforeach
								</div>
								@foreach ($slides as $slide)
								<div id="{{ $slide->slug }}" class="nivo-html-caption">
									<div class="slider-progress"></div>
									<div class="slider-cap-text slider-text2">
										<div class="d-table-cell">
											<h2 class="animated bounceInDown">{!! $slide->title !!}</h2>
											<p class="animated bounceInUp">{!! $slide->content !!}</p>	
											<a class="wow zoomInDown" data-wow-duration="1s" data-wow-delay="1s" href="{{ url($slide->link) }}">Đọc thêm <i class="fa fa-caret-right"></i></a>
										</div>
									</div>
								</div>
								@endforeach
							</div>
						</div>								
					</div>											
				</div>	
				<!-- MAIN-SLIDER-AREA END -->
			</div>						
		</div>
	</div>
</section>
@endif
<!-- HEADER-BOTTOM-AREA END -->