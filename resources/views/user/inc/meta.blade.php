<meta http-equiv="refresh" content="1200"/>
<meta name="revisit-after" content="1 DAYS"/>
<meta name="description" content="<?php echo $seo['description']?>"/>
<?php if (!empty($seo['keyword'])) {
  echo '<meta name="keywords" content="'.$seo['keyword'].'"/>';
}?>
<meta property="og:title" content="<?php echo $seo['title']?>"/>

<?php if (!empty($seo['description'])) {
  echo '<meta property="og:description" content="'.$seo['description'].'"/>';
}?>
<meta property="og:url" content="<?php echo URL::current()?>"/>
<?php if (!empty($seo['image'])) {
  echo '<meta property="og:image" content="'.$seo['image'].'"/>';
}?>
<meta name="robots" content="index,follow,noodp">

<meta property="og:type" content="article"/>
<meta property="og:site_name" content="Hikids.vn"/>

<meta name="author" content="Hikids.vn"/>
<meta name="rating" content="general"/>
<meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1,user-scalable=no"/>
<meta name="apple-mobile-web-app-capable" content="yes"/>
<meta name="apple-mobile-web-app-status-bar-style" content="black"/>
<meta http-equiv="content-language" content="vi" />
<meta name="geo.region" content="VN-SG" />
<meta name="geo.position" content="10.772737;106.689129" />
<meta name="ICBM" content="10.772737, 106.689129" />
<link rel="canonical" href="http://hikids.vn/" />


<?php if (!empty($seo['created_at'])) {
  echo '<meta property="article:published_time" content="'.$seo['created_at'].'"/>';
}?>
<?php if (!empty($seo['updated_at'])) {
  echo '<meta property="article:modified_time" content="'.$seo['updated_at'].'"/>';
}?>
<?php if (!empty($seo['updated_at'])) {
  echo '<meta property="article:updated_time" content="'.$seo['updated_at'].'"/>';
}?>

<link rel="shortcut icon" type="image/x-icon" href="">
	
<link href='http://fonts.googleapis.com/css?family=Oswald:400,700' rel='stylesheet' type='text/css'> 
<link href='http://fonts.googleapis.com/css?family=Open+Sans:400,300,600' rel='stylesheet' type='text/css'>
<link href='http://fonts.googleapis.com/css?family=Bitter:400,700,400italic&amp;subset=latin,latin-ext' rel='stylesheet' type='text/css'>

{!! HTML::style('user/css/animate.css') !!}		

{!! HTML::style('user/css/jquery.fancybox.css') !!}		

{!! HTML::style('user/css/jquery.bxslider.css') !!}			

{!! HTML::style('user/css/meanmenu.min.css') !!}

{!! HTML::style('user/css/jquery-ui-slider.css') !!}			

{!! HTML::style('user/css/nivo-slider.css') !!}			

{!! HTML::style('user/css/owl.carousel.css') !!}	
	
{!! HTML::style('user/css/owl.theme.css') !!}

{!! HTML::style('user/css/bootstrap.min.css') !!}	

{!! HTML::style('user/css/font-awesome.min.css') !!}

{!! HTML::style('user/css/normalize.css') !!}

{!! HTML::style('user/css/main.css') !!}

{!! HTML::style('user/style.css') !!}

{!! HTML::style('user/css/responsive.css') !!}

{!! HTML::style('user/css/ie.css') !!}

{!! HTML::style('user/css/rome.min.css') !!}

{!! HTML::style('user/css/extra.css') !!}

{!! HTML::script('user/js/vendor/modernizr-2.6.2.min.js') !!}
