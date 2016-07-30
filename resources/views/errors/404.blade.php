<?php use Illuminate\Support\Str as Str; 
    use Illuminate\Support\Facades\Session as Session;
 ?>
@extends('front.none_template')

@section('title')
   <title>Login | HappySkin Admin</title>
@stop

@section('content')
    
    <div id="cl-wrapper" class="error-container">
      <div class="page-error">
        <h1 class="number text-center">404</h1>
        <h2 class="description text-center">Sorry, but this page doesn't exists!</h2>
        <h3 class="text-center">Would you like to go <a href="{{ url('/manage') }}">home</a>?</h3>
      </div>
       <div class="text-center out-links"><a href="#">© 2015 Malaria</a></div>
    </div>
    
@stop

@section('script')
    <script src="/js/validation/parsley.min.js" type="text/javascript"></script>
    <script src="/js/validation/dateiso.js" type="text/javascript"></script>
@stop

