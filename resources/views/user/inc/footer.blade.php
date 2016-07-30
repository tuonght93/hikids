<!-- COMPANY-FACALITY START -->
<section class="company-facality">
	<div class="container">
		<div class="row">
			<div class="company-facality-row">
				<!-- SINGLE-FACALITY START -->						
				<div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
					<div class="single-facality">
						<div class="facality-icon">
							<i class="fa fa-car"></i>
						</div>
						<div class="facality-text">
							<h3 class="facality-heading-text">GIAO HÀNG TOÀN QUỐC</h3>
							<span>Check out store for latest</span>
						</div>
					</div>
				</div>
				<!-- SINGLE-FACALITY END -->
				<!-- SINGLE-FACALITY START -->
				<div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
					<div class="single-facality">
						<div class="facality-icon">
							<i class="fa fa-rocket"></i>
						</div>
						<div class="facality-text">
							<h3 class="facality-heading-text">MIỄN PHÍ GIAO HÀNG</h3>
							<span>khi đặt hàng hơn 500.000 đ</span>
						</div>
					</div>
				</div>
				<!-- SINGLE-FACALITY END -->
				<!-- SINGLE-FACALITY START -->
				<div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
					<div class="single-facality">
						<div class="facality-icon">
							<i class="fa fa-umbrella"></i>
						</div>
						<div class="facality-text">
							<h3 class="facality-heading-text">HỖ TRỢ 24/7</h3>
							<span>tư vấn trực tuyến</span>
						</div>
					</div>
				</div>
				<!-- SINGLE-FACALITY END -->
				<!-- SINGLE-FACALITY START -->						
				<div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
					<div class="single-facality">
						<div class="facality-icon">
							<i class="fa fa-refresh"></i>
						</div>
						<div class="facality-text">
							<h3 class="facality-heading-text">ĐỔI TRẢ 10 NGÀY</h3>
							<span>đảm bảo hoàn lại tiền</span>
						</div>
					</div>
				</div>		
				<!-- SINGLE-FACALITY END -->					
			</div>
		</div>
	</div>
</section>
<!-- COMPANY-FACALITY END -->
<!-- FOOTER-TOP-AREA START -->
<section class="footer-top-area">
	<div class="container">
		<div class="footer-top-container">
			<div class="row">
				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
					<!-- FOOTER-TOP-RIGHT-1 START -->
					<div class="footer-top-right-1">
						<div class="row">
							<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12 hidden-sm">
								<!-- STATICBLOCK START -->
								<div class="staticblock">
									<h2>Về Hikids</h2>
									<p>Hikids.vn chuyên bán quần áo trẻ em online với hàng ngàn mẫu mã để quý khách lựa chọn cho bé yêu của bạn.</p> 
									<p>Hãy đặt hàng online để được hưởng nhiều ưu đãi hơn tại siêu thị mẹ và bé Hikids.Chọn mua ngay các mẫu quần áo trẻ em mới nhất trong danh mục "Hàng mới nhất"</p>
								</div>
								<!-- STATICBLOCK END -->
							</div>
							<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
								<!-- STORE-INFORMATION START -->
								<div class="Store-Information">
									<h2>Thông tin</h2>
									<ul>
										<li>
											<div class="info-lefticon">
												<i class="fa fa-map-marker"></i>
											</div>
											<div class="info-text">
												<p>Địa chỉ: 7B/105/35 Thành Thái, Phường 14, Quận 10, TP Hồ Chí Minh </p>
											</div>
										</li>
										<li>
											<div class="info-lefticon">
												<i class="fa fa-phone"></i>
											</div>
											<div class="info-text call-lh">
												<p>Gọi cho chúng tôi : 0911-331-616</p>
											</div>
										</li>
										<li>
											<div class="info-lefticon">
												<i class="fa fa-envelope-o"></i>
											</div>
											<div class="info-text">
												<p>Email : <a href="mailto:sales@yourcompany.com"><i class="fa fa-angle-double-right"></i> support@hikids.vn</a></p>
											</div>
										</li>
									</ul>
								</div>
								<!-- STORE-INFORMATION END -->
							</div>
							<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12 hidden-sm">
								<!-- STATICBLOCK START -->
								<div class="staticblock">
									<h2>Chính sách</h2>
									<ul>
										@foreach ($pages as $page)
										<li>
											<div class="info-text">
												<p><a href="{{ url('/page/'.$page->slug) }}">{{ $page->title }}</a></p>
											</div>
										</li>
										@endforeach
									</ul>
								</div>
								<!-- STATICBLOCK END -->
							</div>
							<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12 hidden-sm">
								<!-- STATICBLOCK START -->
								<div class="staticblock">
									<h2>Bản đồ</h2>
									<div class="google-map-area">
										<div class="google-map">
											<div id="googleMap" style="width:100%;height:150px;"></div>
										</div>
									</div>
								</div>
								<!-- STATICBLOCK END -->
							</div>
						</div>
					</div>
					<!-- FOOTER-TOP-RIGHT-1 END -->
				</div>
			</div>
		</div>
	</div>
</section>
<!-- FOOTER-TOP-AREA END -->
<!-- COPYRIGHT-AREA START -->
<footer class="copyright-area">
	<div class="container">
		<div class="row">
			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
				<div class="copy-right">
					<address>Copyright © {!! date('Y') !!} Hikids.vn</address>
				</div>
				<div class="scroll-to-top">
					<a href="#" class="bstore-scrollertop"><i class="fa fa-angle-double-up"></i></a>
				</div>
			</div>
		</div>
	</div>
</footer> 
<!-- COPYRIGHT-AREA END -->