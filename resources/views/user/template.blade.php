<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->

  <head>
    <meta charset="utf-8"/>
    @yield('title')

    @include('user/inc/meta')

    @yield('head')
    <!--
    {!! HTML::style('http://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800') !!}
    {!! HTML::style('http://fonts.googleapis.com/css?family=Josefin+Slab:100,300,400,600,700,100italic,300italic,400italic,600italic,700italic') !!}
    -->
  </head>

  <body class="index-2">

      @include('user/inc/header')

      @include('user/inc/menu')

      @yield('main')

      @include('user/inc/footer')

      @include('user/inc/script')

      @yield('scripts')

  </body>
</html>