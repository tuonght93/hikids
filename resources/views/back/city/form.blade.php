<?php use Illuminate\Support\Str as Str; 
    use Illuminate\Support\Facades\Session as Session;
 ?>
@extends('back.template')

@section('title')
   <title>City | Hikids Admin</title>
   <meta name="csrf-token" content="{{ csrf_token() }}" />
@stop

@section('css')
  <link href="/css/summernote.css" rel="stylesheet"> 
  <link href="/css/element/blue.css" rel="stylesheet">
  <link href="/css/model_component.css" rel="stylesheet">
  <link href="/css/bootstrap-multiselect.css" rel="stylesheet">
  <link href="/css/editor/redactor.css" rel="stylesheet">
  
@stop

@section('content')
      <div class="page-head">
        <h2>{{ empty($city->id) ? 'Thêm mới màu' : 'Sửa màu' }}</h2>
        <ol class="breadcrumb">
          <li><a href="{{ url('/manage/city') }}">City</a></li>
          <li>{{ empty($city->id) ? 'Thêm mới' : 'Sửa' }}</li>
        </ol>
      </div>
      <div class="cl-mcont">
          <div class="row">
            <div class="col-md-12">            
            {!! Form::open(['url' => '/manage/city/'.$city->id, 'method' => empty($city->id) ? 'POST' : 'PUT', 'role' => 'form', 'files' => 'true', 'class' => 'form-horizontal group-border-dashed', 'style' => 'border-radius: 0px;', 'id' => 'form_city',]) !!} 
              <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">

              <div class="block-flat">
                <div class="header">
                  <h3>Chi tiết</h3>                  
                </div>
                <div class="content">

                  @include('errors/error_validation', ['errors' => $errors])

                    <div class="form-group">
                      <label class="col-sm-3 control-label">Tên Tỉnh / Thành phố</label>
                      <div class="col-sm-6">
                        {!! Form::text('name', $city->name, array('placeholder' => 'Tiêu đề', 'class' => 'form-control')) !!}
                      </div>
                    </div>

                    <div class="form-group">
                      <label class="col-sm-3 control-label">Giá free shipping</label>
                      <div class="col-sm-6">
                        {!! Form::text('freeshipping', $city->freeshipping, array('placeholder' => 'Nhập giá free shipping', 'class' => 'form-control')) !!}
                      </div>
                    </div>

                    <div class="form-group">
                      <label class="col-sm-3 control-label">Giá shipping</label>
                      <div class="col-sm-6">
                        {!! Form::text('shippingcost', $city->shippingcost, array('placeholder' => 'Giá shipping', 'class' => 'form-control')) !!}
                      </div>
                    </div>
                </div>
              </div>  

              <div class="row block-flat">
                <div class="col-sm-offset-2 col-sm-10">
                    <a href="/manage/city" class="btn btn-default">Trở lại</a>
                    <button id="form_submit" type="button" class="btn btn-primary wizard-next">Lưu thông tin</button>
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
  <script type="text/javascript" src="/js/bootstrap-multiselect.js"></script>
  
  <script type="text/javascript" src="/js/editor/redactor.js"></script>
  <script type="text/javascript" src="/js/editor/vi.js"></script>
  
  
  
@stop

@section('scriptend')
    <script type="text/javascript">
      $(document).ready(function(){
        $( ".rich_text" ).each(function(){
          $(this).redactor(
              {
                imageUpload: '/ajax/uploadImage?_token='+$('meta[name="csrf-token"]').attr('content'),
                lang: 'vi',
                imageUploadCallback: true
              }
            );
        });

        function sendFile(file, editor, welEditable) {
          var  data = new FormData();
          data.append("file", file);
          var url = '/ajax/uploadImage';
          $.ajax({
              headers: {
                  'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
              },
              data: data,
              type: "POST",
              url: url,
              cache: false,
              contentType: false,
              processData: false,
              success: function(data) {
                  editor.insertImage(welEditable, data.url);
              }
          });
        }

        if(jQuery().iCheck){
          $('.icheck').iCheck({
            checkboxClass: 'icheckbox_square-blue checkbox',
            radioClass: 'iradio_square-blue'
          });
        }
        var type_content = $('#type_content').val();

        check_display_target_id(); //load lan dau sau khi valid error
        $('#type_content').change(function(){
          check_display_target_id();
        });

        $('#form_submit').click(function(){
          // $("#content").val($("#city_content").code());
          $('#form_city').submit();
        });
      });

      function check_display_target_id() {
        if ($('#type_content').val() == 'skintest') {
          $('#div_target_id').css('display', 'none');
        } else {
          $('#div_target_id').css('display', 'block');
        }
      }
            
    </script>  
@stop



