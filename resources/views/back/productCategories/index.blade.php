<?php use Illuminate\Support\Str as Str; 
    use Illuminate\Support\Facades\Session as Session;
 ?>
@extends('back.template')

@section('title')
   <title>Products | HappySkin Admin</title>
@stop

@section('css')
   <link rel="stylesheet" type="text/css" href="/css/dataTables.bootstrap.css">
@stop

@section('content')
  <div class="page-head">
      <h2>Danh sách chuyên mục</h2>
      <ol class="breadcrumb">
        <li><a href="{{ url('/manage/productCategory') }}">Chuyên mục</a></li>
        <li>Danh sách</li>
      </ol>
    </div>

      <div class="cl-mcont">
          
          <div class="row">
            <div class="col-md-12">
              <div class="block-flat">
                <div class="content">
                  <a href="{{ url('/manage/productCategory/create') }}" class="btn btn-primary">Thêm mới</a>
                  @include('errors/error_validation', ['errors' => $errors])
                    <div id="datatable-icons_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer">
                      <div class="row table-responsive" >
                        <div class="col-sm-12">
                          <table id="datatable-icons" class="table table-bordered dataTable no-footer" role="grid" aria-describedby="datatable-icons_info">
                            <thead>
                              <tr role="row">
                                <th style="width: 5%;">STT</th>
                                <th class="sorting" style="width: 10%;">Ảnh</th>
                                <th class="sorting" style="width: 20%;">Tên chuyên mục</th>
                                <th class="sorting" >Giới thiệu</th>
                                <th style="width: 13%;">Ngày tạo</th>
                                <th style="width: 12%;">Thao tác</th>
                              </tr>
                            </thead>
                            <tbody>
                            @if ($categories)
                              <?php $i = 1;?>
                              @foreach($categories as $category)
                                <?php 
                                  $tr_class = $i % 2 == 1 ? "odd" : "even";
                                ?>
                                <tr class="{{ $tr_class }}" role="">
                                    <td class="sorting_1">{{ $i }}</td>
                                    <td>
                                      @if (empty($category->thumbnail))
                                        <img src="{{ config('image.image_url_admin').'/default_70x70.png' }}" />
                                      @else
                                        <img src="{{ config('image.image_url').'/productCategories/'.$category->thumbnail.'_70x70.png' }}" />
                                      @endif
                                    </td>
                                    @if ($category->parent_id == '')
                                      <td><strong>{!! $category->syntax.$category->name !!} </strong>({{$category->slug}})</td>
                                    @else
                                      <td>{!! $category->syntax.$category->name !!} ({{$category->slug}}) </td>
                                    @endif
                                    <td>{!! $category->description !!} </td>
                                    <td class="center">{{ date('d-m-Y H:i:s', strtotime($category->created_at)) }}</td>
                                    <td>
                                        <a class="btn btn-primary btn-xs" href="{{ url('/manage/product?category_id='.$category->id) }}"  data-toggle="tooltip"><i class="fa fa-file"></i></a>
                                        <a class="btn btn-primary btn-xs" href="{{ url('/manage/productCategory/'.$category->id) }}"  data-toggle="tooltip"><i class="fa fa-pencil"></i></a>
                                        <button data-toggle="modal" data-target="#mod-error" class="delete_category btn btn-danger btn-xs" category-id="{{ $category->id }}"  ><i class="fa fa-times"></i></button>
                                     </td>
                                </tr>
                                <?php $i++?>
                              @endforeach
                            @endif
                            </tbody>
                          </table>
                        </div>
                      </div>
                    </div>

                </div>
              </div>
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
              <form method="POST" role="form"  id="form_model">
                <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                <button type="button" data-dismiss="modal" class="btn btn-default">Không</button>
                <button type="submit" class="btn btn-danger" id="model_submit">Có</button>
              </form>            
              </div>
            </div>
            <!-- /.modal-content-->
          </div>
          <!-- /.modal-dialog-->
        </div>
@stop

@section('script')
    <script src="/js/jquery.dataTables.min.js" type="text/javascript"></script>
    <script src="/js/dataTables.bootstrap.min.js" type="text/javascript"></script>
@stop

@section('scriptend')
    <script type="text/javascript">
      $(document).ready(function(){
        $('#datatable-icons').dataTable({
           "lengthMenu": [ 20, 50, 100],
           "pageLength": 20,
           "aoColumnDefs": [
              {
               bSortable: false,
               aTargets: [ -1 ]
              }
            ],
            "language": {
                  "lengthMenu": "Hiển thị _MENU_ bản ghi",
                  "search": "Tìm kiếm",
                  "loadingRecords": "Xin vui lòng đợi - đang xử lý...",
                  "zeroRecords": "Không tìm thấy bản ghi nào",
                  "sInfoFiltered": " ( tìm kiếm từ _MAX_ bản ghi )",
                  "infoEmpty": "Không tìm thấy dữ liệu để hiển thị",
                  "info": "Hiển thị _START_ tới _END_ của _TOTAL_ bản ghi",                 
                  "paginate": {
                    "last": "Trang cuối",
                    "previous": "Trang trước",
                    "next": "Trang sau",
                    "first": "Trang đầu"
                  }
            }
        });

        $(document.body).on('click', '.delete_category', function() {          
          var id = $(this).attr('category-id');
          $('#form_model').attr('action', '/manage/productCategory/'+id+'/destroy');
        });

      });
    </script>  
@stop



