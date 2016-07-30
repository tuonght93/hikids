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
        <h2>Sửa sản phẩm</h2>
        <ol class="breadcrumb">
          <li><a href="{{ url('/manage/product') }}">Products</a></li>
          <li>{{ empty($product->id) ? 'Thêm mới' : 'Sửa' }}</li>
        </ol>
      </div>
      <div class="cl-mcont">
          <div class="row">
            <div class="col-md-12">            
            {!! Form::open(['url' => '/manage/product/'.$product->id, 'method' => empty($product->id) ? 'POST' : 'PUT', 'role' => 'form', 'files' => 'true', 'class' => 'form-horizontal group-border-dashed', 'style' => 'border-radius: 0px;', 'id' => 'form_product']) !!} 
              <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">

              <div class="block-flat">
                <div class="header">
                  <h3>Thông tin sản phẩm</h3>                  
                </div>
                <div class="content">

                  @include('errors/error_validation', ['errors' => $errors])

                    <div class="form-group">
                      <label class="col-sm-3 control-label">Tên sản phẩm</label>
                      <div class="col-sm-6">
                        {!! Form::text('name', $product->name, array('placeholder' => 'Tên sản phẩm', 'class' => 'form-control')) !!}
                      </div>
                    </div> 

                    <div class="form-group">
                      <label class="col-sm-3 control-label">Giá cũ</label>
                      <div class="col-sm-6">
                        {!! Form::text('old_price', $product->old_price, array('placeholder' => 'Giá cũ', 'class' => 'form-control')) !!}
                      </div>
                    </div> 

                    <div class="form-group">
                      <label class="col-sm-3 control-label">Giá bán</label>
                      <div class="col-sm-6">
                        {!! Form::text('price', $product->price, array('placeholder' => 'Giá bán', 'class' => 'form-control')) !!}
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="col-sm-3 control-label">Xuất xứ</label>
                      <div class="col-sm-6">
                        {!! Form::text('madein', $product->madein, array('placeholder' => 'Xuất xứ', 'class' => 'form-control')) !!}
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="col-sm-3 control-label">Sản phẩm bán chạy / nổi bật</label>
                      <div class="col-sm-6">
                        <label class="radio-inline">
                          <input type="radio" <?php if(!$product || $product->selling == 0) echo 'checked="checked"'; ?> name="selling" class="icheck" value="0"> Không
                        </label>
                        <label class="radio-inline">
                          <input type="radio" <?php if($product->selling == 1) echo 'checked="checked"' ?> name="selling" class="icheck" value="1"> Có
                        </label>
                      </div>
                    </div>
                    <div class="form-group">
                      <label>Giới thiệu tổng quan</label>
                      <div id="product_introduce"></div>
                      <textarea name="introduce" style="display: none;" id="introduce">{{ old('introduce') ? old('introduce') : $product->introduce }}</textarea>
                    </div>              
                    <div class="form-group">
                      <label>Mô tả</label>
                      <div id="product_details"></div>
                      <textarea name="detail" style="display: none;" id="details">{{ old('detail') ? old('detail') : $product->detail }}</textarea>
                    </div>
                </div>
              </div> 

              <div class="form-group">
                <label class="col-sm-3 control-label">Thương hiệu</label>
                <div class="col-sm-6">
                  <?php 
                      $data_brands = array();
                      $data_brands[''] = 'Chọn thương hiệu';                            
                  ?>
                  @foreach($brands as $brand)
                    <?php
                      $data_brands[''.$brand->id] = $brand->title;
                    ?>             
                  @endforeach
                  {!! Form::select('brand', $data_brands,$product->brand_id, array('id' => 'brand', 'class' => 'form-control')) !!}
                 <!--<input type="hidden" name="categories" id="categories"/>-->
                </div>
              </div>

              <div class="form-group">
                <label class="col-sm-3 control-label">Chuyên mục</label>
                <div class="col-sm-6">
                  <?php 
                      $data_categories = array();
                      $data_categories[''] = 'Chọn chuyên mục';                            
                  ?>
                  @foreach($categories as $category)
                    <?php
                      $data_categories[''.$category->id] = $category->syntax.$category->name;
                    ?>             
                  @endforeach
                  {!! Form::select('category', $data_categories,$product->category_id, array('id' => 'category', 'class' => 'form-control')) !!}
                 <!--<input type="hidden" name="categories" id="categories"/>-->
                </div>
              </div>

              <div class="row">
                <div class="col-sm-12">
                  <div class="block-flat">
                    <div class="header">
                      <h3>Thông số</h3>
                    </div>
                      <div style="height: 200px; overflow-y: scroll;">
                        @if(!empty($productdetails))
                        <?php
                          $productcolor = array();
                          $productsize = array();
                          $qty = array();
                          foreach ($productdetails as $productdetail) {
                            $productcolor[] = $productdetail->color_id;
                            $productsize[] = $productdetail->color_id.'-'.$productdetail->size_id;
                            $qty[] = $productdetail->qty;
                          }
                        ?>
                        @endif
                          @if ($colors)                            
                            @foreach($colors as $color)
                            <?php if (!empty($productcolor) && in_array($color->id, $productcolor)) {
                                  $checked = 'checked="checked"';
                                } else {
                                  $checked = "";
                                }
                            ?>
                              <div class="radio">
                                <label class="col-sm-6 col-md-6 col-lg-5">
                                  <input type="checkbox" name="color[]" class="icheck color" <?php echo $checked ?> value="{{ $color->id }}"/> &nbsp;&nbsp;{{ $color->title }}
                                </label>
                                <div class="form-group" id="action{{$color->id}}" >
                                  <div class="col-sm-12">
                                  @if ($sizes)
                                    @foreach($sizes as $size)
                                    <?php if (!empty($productcolor) && in_array($color->id, $productcolor) && !empty($productsize) && in_array($color->id.'-'.$size->id, $productsize)) {
                                          $checked1 = 'checked="checked"';
                                        } else {
                                          $checked1 = "";
                                        }
                                    ?>
                                    <label class="checkbox-inline">
                                      <input type="checkbox" name="size[]" class="icheck" <?php echo $checked1 ?> value="{{ $color->id.'-'.$size->id }}" /> {{$size->title}}
                                    </label>
                                    <?php
                                      $quantity = $product->productdetails()->where('color_id', '=', $color->id)->where('size_id', '=', $size->id)->first();
                                    ?>
                                    <label class="checkbox-inline">
                                      <input class="form-control" id="qty" style="width: 60px;" min="0" name="{{ $color->id.'-'.$size->id }}" type="number" value="{{ $quantity['qty'] }}">
                                    </label>
                                    
                                    @endforeach
                                  @endif
                                  </div>
                                </div>
                              </div>
                            @endforeach
                          @endif
                      </div>
                    </div>
                </div>
              </div>
              

              <div class="block-flat">
                <div class="header">
                  <h3>Ảnh sản phẩm</h3>
                </div>
                <div class="content">
                  <div class="row">                    
                    <?php $photos = $product->photos ?>
                    @if ($photos)
                      @foreach ($photos as $photo)
                        <?php $isThumb = $photo->image == $product->image_thumb ? 'checked="checked"' : ''; ?>
                        <div class="col-sm-4 col-md-4 col-lg-3" id="{{ $photo->id }}">
                          <div class="block-flat">
                            <div class="header">
                               <img src="{{ config('image.image_url').'/products/'.$photo->image_url().'_100x100.png' }}" />
                            </div>
                           
                            <div class="content">
                              <div class="radio">
                                <label>
                                  <input type="radio" <?php echo $isThumb ?> name="image_thumb" class="icheck" value="{{ $photo->image }}"> Đặt làm đại diện
                                </label>
                              </div>                              
                                <div class="radio">
                                <label>
                                  <button type="button" data-toggle="modal" data-target="#mod-error" style="margin-left: -1px;" class="btn btn-danger btn-xs delete_productphoto" div-id="{{ $photo->id }}" photo-id="{{ $photo->id }}"><i class="fa fa-times"></i></button> Xóa ảnh này
                                </label>
                                </div>                              
                            </div>
                          </div>
                        </div>
                      @endforeach
                    @endif
                  </div>
                  
                  <div class="form-group">
                    <label class="col-sm-3 control-label" for="image_upload">Upload ảnh sản phẩm (hỗ trợ upload nhiều ảnh)</label>
                    <div class="col-sm-6">
                      <input type="file" multiple name="image_upload[]" id="image_upload"  class="form-control">
                    </div>
                  </div>
                  
                    
                </div>
              </div>
              <div class="row block-flat">
                <div class="col-sm-offset-2 col-sm-10">
                    <a href="/manage/product" class="btn btn-default">Trở lại</a>
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
  <script type="text/javascript" src="/js/bootstrap-multiselect.js"></script>
  
  
  
@stop

@section('scriptend')
    <script type="text/javascript">
      $(document).ready(function(){
        $('#product_details,#product_introduce').summernote({
          height: 200,
          onImageUpload: function(files, editor, welEditable) {
              sendFile(files[0], editor, welEditable);
          }
        });

        $("#product_details").code($("#details").val());
        $("#product_introduce").code($("#introduce").val());

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

         $("#brand").multiselect({
            buttonClass : 'form-control',
            buttonWidth: '200',
            enableHTML : true,
            numberDisplayed:1,
            maxHeight : 300,
            maxWidth : 400,
            dropRight: true,
            nonSelectedText : 'Chọn chủ đề',
            nSelectedText: 'Lựa chọn',
            filterPlaceholder: 'Tìm kiếm',
            enableCaseInsensitiveFiltering: true,
            enableFiltering: true,
            enableTextTitle: true,
            templates: {
              li: '<li><a tabindex="0"><div class="radio"><label class="icheckbox_square-blue checkbox"></label></div></a></li>',
            },
         });
         $("#category").multiselect({
            buttonClass : 'form-control',
            buttonWidth: '200',
            enableHTML : true,
            numberDisplayed:1,
            maxHeight : 300,
            maxWidth : 400,
            dropRight: true,
            nonSelectedText : 'Chọn chủ đề',
            nSelectedText: 'Lựa chọn',
            filterPlaceholder: 'Tìm kiếm',
            enableCaseInsensitiveFiltering: true,
            enableFiltering: true,
            enableTextTitle: true,
            templates: {
              li: '<li><a tabindex="0"><div class="radio"><label class="icheckbox_square-blue checkbox"></label></div></a></li>',
            },
         });

        $("#skintype, #producttype").multiselect({
            buttonClass : 'form-control',
            buttonWidth: '200',
            enableHTML : true,
            numberDisplayed:1,
            maxHeight : 300,
            maxWidth : 400,
            dropRight: true,
            nonSelectedText : 'Chọn loại da',
            nSelectedText: 'Lựa chọn',
            filterPlaceholder: 'Tìm kiếm',
            enableCaseInsensitiveFiltering: true,
            enableFiltering: true,
            enableTextTitle: true,
            inputClass: 'iCheck',
            templates: {
              li: '<li><a tabindex="0"><div class="radio"><label class="icheckbox_square-blue checkbox"></label></div></a></li>',
            },
         });


        $('#form_submit').click(function(){
          $("#details").val($("#product_details").code());
          $("#introduce").val($("#product_introduce").code());
          $('#form_product').submit();
        });

        $('.delete_productphoto').click(function(){
          var id = $(this).attr('photo-id');
          $('#model_submit').attr('photo-id', ''+id);
          $('#model_submit').attr('div-id', $(this).attr('div-id'));
        });

        $('#model_submit').click(function(){
          var  id = $(this).attr('photo-id');
          var div_id = $(this).attr('div-id');
          var url = '/manage/productPhoto/'+id;
          $.ajax({
              headers: {
                  'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
              },
              type: "DELETE",
              url: url,
              cache: false,
              contentType: false,
              processData: false,
              success: function(data) {
                  if (data.status == 200 ) {
                    $('#'+div_id).remove();
                  } else {
                    alert('Xóa ảnh bị lỗi, có thể ảnh không tồn tại');
                  }
              }
          });
        });

        $('#radio').click(function(){
          alert('asd');
          var id = $('.color').val();
          alert(id);
          // $('#action'+id).show();
          $('.color').change(function(){
            alert('12312312');
            var stt=this.checked;
            var val=$(this).val();
            alert(val);
            if($(this).checked){ //Có check: THêm quyền cho nó
              $('#action'+val).show();
            }else{ //không check: Bỏ quyền của nó đi
              $('#action'+val).hide();
            }
          });
        });

      });      
    </script>  
@stop



