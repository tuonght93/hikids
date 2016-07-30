<?php use Illuminate\Support\Str as Str; 
    use Illuminate\Support\Facades\Session as Session;
 ?>
@extends('back.template')

@section('title')
   <title>Products | HappySkin Admin</title>
   <meta name="csrf-token" content="{{ csrf_token() }}" />
@stop

@section('css')
  <link href="/css/summernote.css" rel="stylesheet"> 
  <link href="/css/element/blue.css" rel="stylesheet">
  <link href="/css/model_component.css" rel="stylesheet">
  
@stop

@section('content')
      <div class="page-head">
        <h2>Người dùng hệ thống </h2>
        <ol class="breadcrumb">
          <li><a href="{{ url('/manage/user') }}">Người dùng</a></li>
          <li>{{ empty($user->id) ? 'Thêm mới' : 'Sửa' }}</li>
        </ol>
      </div>
      <div class="cl-mcont">
          <div class="row">
            <div class="col-md-12">            
            {!! Form::open(['url' => '/manage/user/'.$user->id, 'method' => empty($user->id) ? 'POST' : 'PUT', 'role' => 'form', 'files' => 'true', 'class' => 'form-horizontal group-border-dashed', 'style' => 'border-radius: 0px;', 'id' => 'form_user']) !!} 
              <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">

              <div class="block-flat">
                <div class="header">
                  <h3>Thông tin</h3>
                </div>
                <div class="content">

                  @include('errors/error_validation', ['errors' => $errors])

                  <div class="form-group">
                    <label class="col-sm-3 control-label">Tài khoản</label>
                    <div class="col-sm-6">

                      {!! Form::text('username', $user->username, array('placeholder' => 'Tên tài khoản', 'class' => 'form-control')) !!}

                    </div>
                  </div>

                  <div class="form-group">
                    <label class="col-sm-3 control-label">Email</label>
                    <div class="col-sm-6">
                      {!! Form::text('email', $user->email, array('placeholder' => 'Email', 'class' => 'form-control')) !!}
                    </div>
                  </div>

                  <div class="form-group">
                    <label class="col-sm-3 control-label">Mật khẩu</label>
                    <div class="col-sm-6">
                      {!! Form::password('password', array('class' => 'form-control', 'id' => 'password', 'title' => 'Mật khẩu')) !!}
                    </div>
                  </div>

                  <div class="form-group">
                    <label class="col-sm-3 control-label">Nhập lại mật khẩu</label>
                    <div class="col-sm-6">
                      {!! Form::password('password_confirmation', array('class' => 'form-control', 'id' => 'password_confirm', 'title' => 'Mật khẩu')) !!}                    
                    </div>
                  </div>

                  <div class="form-group" id="form_select_role">
                    <label class="col-sm-3 control-label">Quyền truy cập</label>
                    <div class="col-sm-6">
                       <?php 
                            $data_roles = array();
                        ?>
                        @foreach($roles as $role)
                          <?php
                            $data_roles[''.$role->type] = $role->name;
                          ?>             
                        @endforeach
                        {!! Form::select('role', $data_roles,$user->role_id?$user->role_id:3, array('id' => 'role', 'class' => 'form-control')) !!}
                    </div>
                  </div>

                  <div class="form-group" id="form_select_ticketroom">
                    <label class="col-sm-3 control-label">Tỉnh/Thành phố</label>
                    <div class="col-sm-6">
                       <?php 
                            $data_cities[] = "-- Thành phố --";
                        ?>
                        @foreach($cities as $city)
                          <?php
                            $data_cities[''.$city->slug] = $city->name;
                          ?>             
                        @endforeach
                        {!! Form::select('city', $data_cities,$user->city , array('id' => 'role', 'class' => 'form-control')) !!}
                    </div>
                  </div>                  

                </div>
              </div>  

              <div class="row block-flat">
                <div class="col-sm-offset-2 col-sm-10">
                    <a href="{{ url('/manage/user') }}" class="btn btn-default">Trở lại</a>
                    <button id="form_submit" type="submit" class="btn btn-primary wizard-next">Lưu thông tin</button>
                </div>
              </div>

              </form>            
            </div>
          </div>
      </div>

@stop

@section('script')
  <script type="text/javascript" src="/js/summernote.min.js"></script>
  <script type="text/javascript" src="/js/icheck.min.js"></script>
  
  
  
@stop

@section('scriptend')
    <script type="text/javascript">
      $(document).ready(function(){
        $('#role').change(function(){
          if ($(this).val() == '2') {
            $('#form_select_ticketroom').css('display', 'block');
          } else {
            $('#form_select_ticketroom').css('display', 'none');
          }
        });

        if ($('#role').val() == '2') {
          $('#form_select_ticketroom').css('display', 'block');
        } else {
          $('#form_select_ticketroom').css('display', 'none');
        }
      });
            
    </script>  
@stop



