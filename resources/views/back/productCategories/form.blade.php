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
        <h2>Sửa chuyên mục</h2>
        <ol class="breadcrumb">
          <li><a href="{{ url('/manage/productCategory') }}">Chuyên mục</a></li>
          <li>{{ empty($category->id) ? 'Thêm mới' : 'Sửa' }}</li>
        </ol>
      </div>
      <div class="cl-mcont">
          <div class="row">
            <div class="col-md-12">            
            {!! Form::open(['url' => '/manage/productCategory/'.$category->id, 'method' => empty($category->id) ? 'POST' : 'PUT', 'role' => 'form', 'files' => 'true', 'class' => 'form-horizontal group-border-dashed', 'style' => 'border-radius: 0px;', 'id' => 'form_category']) !!} 
              <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">

              <div class="block-flat">
                <div class="header">
                  <h3>Chi tiết chuyên mục</h3>                  
                </div>
                <div class="content">

                  @include('errors/error_validation', ['errors' => $errors])

                    <div class="form-group">
                      <label class="col-sm-3 control-label">Tiêu đề</label>
                      <div class="col-sm-6">
                        {!! Form::text('name', $category->name, array('placeholder' => 'Tiêu đề', 'class' => 'form-control')) !!}
                      </div>
                    </div>                    

                    <div class="form-group">
                      <label>Giới thiệu</label>
                      <div id="category_description"></div>
                      <textarea name="description" style="display: none;" id="description">{{ old('description') ? old('description') : $category->description }}</textarea>
                    </div>

                    <div class="form-group">
                      <label class="col-sm-3 control-label">Chuyên mục cha</label>
                      <div class="col-sm-6">
                        <?php 
                            $data_categories[''] = 'Chọn chuyên mục cha';
                        ?>
                        @foreach($categories as $cat)
                          <?php
                            $data_categories[''.$cat->id] = $cat->syntax.$cat->name;
                          ?>             
                        @endforeach
                        {!! Form::select('parent', $data_categories,$category->parent_id, array('id' => 'parent', 'class' => 'form-control')) !!}

                      </div>
                    </div>

                     <div class="form-group">
                          <label class="col-sm-3 control-label">Vị trí</label>
                          <div class="col-sm-6">
                        {!! Form::number('position', $category->position, array('placeholder' => 'Vị trí', 'class' => 'form-control', 'min' => 0)) !!}
                            
                          </div>
                      </div>

                      <div class="header">
                      <h3>Ảnh đại diện</h3>                  
                    </div>

                    <div class="form-group">
                      <label class="col-sm-3 control-label" >
                      @if (!empty($category->thumbnail))
                        <img src="{{ config('image.image_url').'/productCategories/'.$category->thumbnail.'_150x150.png' }}"/>
                        @else
                          <img src="{{ config('image.image_url_admin').'/default_150x150.png' }}"/>
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
                    <a href="/productCategory" class="btn btn-default">Trở lại</a>
                    <button id="form_submit" type="button" class="btn btn-primary wizard-next">Lưu thông tin</button>
                </div>
              </div>

              </form>            
            </div>
          </div>
      </div>

       <div id="mod-error" tabindex="-1" role="dialog" class="modal fade">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" data-dismiss="modal" aria-hidden="true" class="close">×</button>
              </div>
              <div class="modal-body">
                <div class="text-center">
                  <div class="i-circle danger"><i class="fa fa-times"></i></div>
                  <p>Bạn có chắn chắn muốn xóa không?</p>
                </div>
              </div>
              <div class="modal-footer">              
              <!--<form method="DELETE" role="form" id="form_model">
                <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                <button type="button" data-dismiss="modal" class="btn btn-default">Không</button>
                <button type="submit" class="btn btn-danger" id="model_submit">Có</button>
              </form>-->
              <button type="button" data-dismiss="modal" class="btn btn-default">Không</button>
              <button type="button" data-dismiss="modal" class="btn btn-danger" id="model_submit">Có</button>
              </div>
            </div>
            <!-- /.modal-content-->
          </div>
          <!-- /.modal-dialog-->
        </div>
@stop

@section('script')
  <script type="text/javascript" src="/js/summernote.min.js"></script>
  <script type="text/javascript" src="/js/icheck.min.js"></script>
  
  
  
@stop

@section('scriptend')
    <script type="text/javascript">
      $(document).ready(function(){
        $('#category_description').summernote({
          height: 200,
          onImageUpload: function(files, editor, welEditable) {
              sendFile(files[0], editor, welEditable);
          }
        });

        $("#category_description").code($("#description").val());

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

        $('#form_submit').click(function(){
          $("#description").val($("#category_description").code());
          $('#form_category').submit();
        });
      });
            
    </script>  
@stop



