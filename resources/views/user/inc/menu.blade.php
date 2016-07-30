<!-- MAIN-MENU-AREA START -->
<header class="main-menu-area">
	<div class="container">
		<div class="row">
			<!-- SHOPPING-CART START -->
			<div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 pull-right shopingcartarea">
				<div class="shopping-cart-out pull-right">
					<div class="shopping-cart">
						<a class="shop-link" href="{{ url('/cart') }}" title="View my shopping cart">
							<i class="fa fa-shopping-cart cart-icon"></i>
							<b>Giỏ hàng</b>
							<span class="ajax-cart-quantity">{{ $count }}</span>
						</a>
					</div>
				</div>
			</div>	
			<!-- SHOPPING-CART END -->
			<!-- MAINMENU START -->
			<div class="col-lg-9 col-md-9 col-sm-12 col-xs-12 no-padding-right menuarea">
				<div class="mainmenu">
					<nav>
						<ul class="list-inline mega-menu">
							<li class="active"><a href="{{ url('/') }}">Home</a></li>
							@if($categories)
							<?php
								$category = $categories::where('parent_id', '=', 0)->get();
							?>
							@foreach($category as $list)
							<li>
								<a href="{{ url('/category/'.$list->slug) }}">{{ $list->name }}</a>
								<?php
									$category2 = $categories::where('parent_id', '=', $list->id)->get();
								?>
								@if($category2->count() > 0)
								<!-- DRODOWN-MEGA-MENU START -->
								<div class="drodown-mega-menu">
									<div class="left-mega col-xs-6">
										<div class="mega-menu-list">
											<ul>
												@foreach($category2 as $list2)
												<li><a href="{{ url('/category/'.$list->slug.'/'.$list2->slug) }}">{{ $list2->name }}</a></li>
												@endforeach
											</ul>
										</div>
									</div>
								</div>
								<!-- DRODOWN-MEGA-MENU END -->
								@endif
							</li>
							@endforeach
							@endif
						</ul>
					</nav>
				</div>
			</div>
			<!-- MAINMENU END -->
		</div>
		<div class="row">
			<!-- MOBILE MENU START -->
			<div class="col-sm-12 mobile-menu-area">
				<div class="mobile-menu hidden-md hidden-lg" id="mob-menu">
					<span class="mobile-menu-title">MENU</span>
					<nav>
						<ul>
							<li><a href="{{ url('/') }}">Home</a></li>
							@if($categories)
							<?php
								$category = $categories::where('parent_id', '=', '')->get();
							?>
							@foreach($category as $list)								
							<li><a href="{{ url('/category/'.$list->slug) }}">{{ $list->name }}</a>
							<?php
								$category2 = $categories::where('parent_id', '=', $list->id)->get();
							?>
							@if($category2->count() > 0)
								<ul>
									@foreach($category2 as $list2)
									<li><a href="{{ url('/category/'.$list->slug.'/'.$list2->slug) }}">{{ $list2->name }}</a></li>
									@endforeach
								</ul>
							@endif	
							</li>
							@endforeach
							@endif
						</ul>
					</nav>
				</div>						
			</div>
			<!-- MOBILE MENU END -->
		</div>				
	</div>
</header>
<!-- MAIN-MENU-AREA END -->