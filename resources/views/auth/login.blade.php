<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="shortcut icon" href="/assets/img/favicon.png">
    <title>Online Survey</title>
    <link href="http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,400italic,700,800" rel="stylesheet" type="text/css">
    <link href="http://fonts.googleapis.com/css?family=Raleway:300,200,100" rel="stylesheet" type="text/css">
    <link href="http://fonts.googleapis.com/css?family=Open+Sans+Condensed:300,700" rel="stylesheet" type="text/css">
    <link href="/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/css/font-awesome.min.css">
    <!--if lt IE 9script(src='https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js')
    -->
    <link rel="stylesheet" type="text/css" href="/css/nanoscroller.css">
    <link href="/css/style.css" rel="stylesheet">
    <link href="/css/extra.css" rel="stylesheet">
  </head>
  <body class="texture" style="opacity: 1; margin-left: 0px;">
    <div id="cl-wrapper" class="login-container">
          
      <div class="middle-login">
        <div class="block-flat">
          <div class="header">
            <h3 class="text-center">Admin manage</h3>
          </div>
          <div>
            {!! Form::open(['url' => '/manage/login', 'method' => 'post', 'class' => 'form-horizontal', 'style' => 'margin-bottom: 0px !important;']) !!} 
              <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
              <div class="content">

                @include('errors/error_validation', ['errors' => $errors])

                <div class="form-group">
                  <div class="col-sm-12">
                    <div class="input-group"><span class="input-group-addon"><i class="fa fa-user"></i></span>
                      {!! Form::text('username', Input::old('username',''), array('placeholder' => 'Tên đăng nhập', 'class' => 'form-control', 'id' => 'username', 'required' => '""')) !!}
                    </div>
                  </div>
                </div>
                <div class="form-group">
                  <div class="col-sm-12">
                    <div class="input-group"><span class="input-group-addon"><i class="fa fa-lock"></i></span>
                       {!! Form::password('password', array('placeholder' => 'Mật khẩu', 'class' => 'form-control', 'id' => 'password', 'required' => '""' )) !!}
                    </div>
                  </div>
                </div>

                <div class="form-group">
                  <div class="col-sm-12">
                    <div class="checkbox">
                      <label>
                        <input type="checkbox" name="remember" data-parsley-multiple="remember" value="1"> Nhớ mật khẩu
                      </label>
                    </div>
                  </div>
                </div>

              </div>
              <div class="foot">                
                <button data-dismiss="modal" type="submit" class="btn btn-primary">Đăng nhập</button>
              </div>
            {!! Form::close() !!}
            
          </div>
        </div>
        <div class="text-center out-links"><a href="http://techup.vn">© 2015 Demo TechUp</a></div>
      </div>
    

    </div>

    <script type="text/javascript" src="/js/jquery.js"></script>
    <script type="text/javascript" src="/js/jquery.nanoscroller.js"></script>
    <script type="text/javascript" src="/js/cleanzone.js"></script>
    <script src="/js/bootstrap.min.js"></script>
    <script type="text/javascript">
      $(document).ready(function(){
        //initialize the javascript
        App.init();
        
      });
      
    </script>
  </body>
</html>