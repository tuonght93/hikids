 
<!-- jquery js -->
{!! HTML::script('user/js/vendor/jquery-1.11.3.min.js') !!}
<!-- <script src="js/vendor/jquery-1.11.3.min.js"></script> -->

<!-- fancybox js -->
{!! HTML::script('user/js/jquery.fancybox.js') !!}
<!-- <script src="js/jquery.fancybox.js"></script> -->

<!-- bxslider js -->
{!! HTML::script('user/js/jquery.bxslider.min.js') !!}
<!-- <script src="js/jquery.bxslider.min.js"></script> -->

<!-- meanmenu js -->
{!! HTML::script('user/js/jquery.meanmenu.js') !!}
<!-- <script src="js/jquery.meanmenu.js"></script> -->

<!-- owl carousel js -->
{!! HTML::script('user/js/owl.carousel.min.js') !!}
<!-- <script src="js/owl.carousel.min.js"></script> -->

<!-- nivo slider js -->
{!! HTML::script('user/js/jquery.nivo.slider.js') !!}
<!-- <script src="js/jquery.nivo.slider.js"></script> -->

<!-- jqueryui js -->
{!! HTML::script('user/js/jqueryui.js') !!}
<!-- <script src="js/jqueryui.js"></script> -->

<!-- bootstrap js -->
{!! HTML::script('user/js/bootstrap.min.js') !!}
<!-- <script src="js/bootstrap.min.js"></script> -->

{!! HTML::script('user/js/rome.min.js') !!}
<!-- <script type="text/javascript" src="/js/rome.min.js"></script> -->

<!-- wow js -->
{!! HTML::script('user/js/wow.js') !!}
<!-- <script src="js/wow.js"></script>		 -->
<script>
	new WOW().init();
</script>

<!-- Google Map js -->
{!! HTML::script('https://maps.googleapis.com/maps/api/js') !!}
<!-- <script src="https://maps.googleapis.com/maps/api/js"></script>	 -->
<script>
	function initialize() {
	  var mapOptions = {
		zoom: 8,
		scrollwheel: false,
		center: new google.maps.LatLng(10.768776, 106.666676)
	  };
	  var map = new google.maps.Map(document.getElementById('googleMap'),
		  mapOptions);
	  var marker = new google.maps.Marker({
		position: map.getCenter(),
		map: map
	  });

	}
	google.maps.event.addDomListener(window, 'load', initialize);				
</script>
<!-- main js -->
{!! HTML::script('user/js/main.js') !!}