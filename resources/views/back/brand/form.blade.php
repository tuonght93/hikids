<?php use Illuminate\Support\Str as Str; 
    use Illuminate\Support\Facades\Session as Session;
 ?>
@extends('back.template')

@section('title')
   <title>Brand | Hikids Admin</title>
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
        <h2>{{ empty($brand->id) ? 'Thêm mới màu' : 'Sửa màu' }}</h2>
        <ol class="breadcrumb">
          <li><a href="{{ url('/manage/brand') }}">Brand</a></li>
          <li>{{ empty($brand->id) ? 'Thêm mới' : 'Sửa' }}</li>
        </ol>
      </div>
      <div class="cl-mcont">
          <div class="row">
            <div class="col-md-12">            
            {!! Form::open(['url' => '/manage/brand/'.$brand->id, 'method' => empty($brand->id) ? 'POST' : 'PUT', 'role' => 'form', 'files' => 'true', 'class' => 'form-horizontal group-border-dashed', 'style' => 'border-radius: 0px;', 'id' => 'form_brand',]) !!} 
              <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">

              <div class="block-flat">
                <div class="header">
                  <h3>Chi tiết</h3>                  
                </div>
                <div class="content">

                  @include('errors/error_validation', ['errors' => $errors])

                    <div class="form-group">
                      <label class="col-sm-3 control-label">Tiêu đề</label>
                      <div class="col-sm-6">
                        {!! Form::text('title', $brand->title, array('placeholder' => 'Tiêu đề', 'class' => 'form-control')) !!}
                      </div>
                    </div>

                    <div class="form-group">
                      <label>Nội dung</label>
                      <!--<div id="tip_content"></div>-->
                      <textarea name="content" id="content" class="rich_text">{{ old('content') ? old('content') : $brand->content }}</textarea>
                    </div>

                    <div class="header">
                      <h3>Ảnh slide</h3>                  
                    </div>

                    <div class="form-group">
                      <label class="col-sm-3 control-label" >
                      @if (!empty($brand->thumbnail))
                        <img src="{{ config('image.image_url').'/brands/'.$brand->thumbnail.'_150x150.png' }}"/>
                        @else
                          <img src="/images/default_150x150.png"/>
                        @endif
                      </label>
                      <div class="col-sm-6">   
                          <input type="file" name="image_upload" id="image_upload"  class="form-control"/>     
                      </div>
                    </div>
                </div>
              </div>  

              <div class="row block-flat">
                <div class="col-sm-offset-2 col-sm-10">
                    <a href="/manage/brand" class="btn btn-default">Trở lại</a>
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
          // $("#content").val($("#brand_content").code());
          $('#form_brand').submit();
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



