<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    @yield('title')
    <link href="http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,400italic,700,800" rel="stylesheet" type="text/css">
    <link href="http://fonts.googleapis.com/css?family=Raleway:300,200,100" rel="stylesheet" type="text/css">
    <link href="http://fonts.googleapis.com/css?family=Open+Sans+Condensed:300,700" rel="stylesheet" type="text/css">
    <script src="/js/jquery.js"></script>
   
    <!-- Bootstrap core CSS -->
    <link href="/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/css/font-awesome.min.css">
   
   <link rel="stylesheet" type="text/css" href="/css/nanoscroller.css">
    <!-- Plugins Includes -->
    
    <!-- General Plugins Instances -->
    @yield('css')
   
    <!-- Template Style -->
    <link href="/css/style.css" rel="stylesheet">  
  </head>

  <body class="texture">
    <div id="cl-wrapper" class="login-container">
      @yield('content')

    </div>
    <script type="text/javascript" src="/js/jquery.nanoscroller.js"></script>
    <script type="text/javascript" src="/js/cleanzone.js"></script>
    <script src="/js/bootstrap.min.js"></script>

    @yield('script')

    <script type="text/javascript">
      $(document).ready(function(){
        //initialize the javascript
        App.init();
      });
      
    </script>
  </body>
</html>