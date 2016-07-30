<?php use Illuminate\Support\Str as Str; 
    use Illuminate\Support\Facades\Session as Session;
 ?>
@extends('back.template')

@section('title')
   <title>Size | HappySkin Admin</title>
@stop

@section('css')
   <link rel="stylesheet" type="text/css" href="/css/dataTables.bootstrap.css">
@stop

@section('content')
  <div class="page-head">
      <h2>Danh sách màu</h2>
      <ol class="breadcrumb">
        <li><a href="{{ url('/manage/size') }}">Size</a></li>
        <li>Danh sách</li>
      </ol>
    </div>

      <div class="cl-mcont">
          
          <div class="row">
            <div class="col-md-12">
              <div class="block-flat">
                <div class="content">
                  <a href="{{ url('/manage/size/create') }}" class="btn btn-primary">Thêm mới</a>
                  @include('errors/error_validation', ['errors' => $errors])
                    <div id="datatable-icons_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer">
                      <div class="row table-responsive" >
                        <div class="col-sm-12">
                          <table id="datatable-icons" class="table table-bordered dataTable no-footer" role="grid" aria-describedby="datatable-icons_info">
                            <thead>
                              <tr role="row">
                                <th style="width: 5%;">STT</th>
                                <th style="width: 10%;">Tiêu đề</th>
                                <th style="width: 35%;">Giới thiệu</th>
                                <th style="width: 10%;">Ngày tạo</th>
                                <th style="width: 10%;">Thao tác</th>
                              </tr>
                            </thead>
                            <tbody>
                            @if ($sizes)
                              <?php $i = 1;?>
                              @foreach($sizes as $size)
                                <tr class="" role="">
                                    <td><?php echo $i?></td>
                                    <td>{!! $size->title !!}</td>
                                    <td>{!! $size->content !!}</td>
                                    <td class="center">{{ date('d-m-Y H:i:s', strtotime($size->created_at)) }}</td>
                                    <td><a class="btn btn-primary btn-xs" href="{{ url('/manage/size/'.$size->id) }}"  data-toggle="tooltip"><i class="fa fa-pencil"></i></a>
                                        <button data-toggle="modal" data-target="#mod-error" class="delete_size btn btn-danger btn-xs" size-id="{{ $size->id }}"  ><i class="fa fa-times"></i></button>
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
        var dataTable = $('#datatable-icons').DataTable( {
           "lengthMenu": [ 10, 30, 50, 100],
           "pageLength": 10,
           "aoColumnDefs": [
              {
               bSortable: false,
               aTargets: [ -1, -5, ]
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
          $('.delete_size').click(function() {          
            var id = $(this).attr('size-id');
            $('#form_model').attr('action', '/manage/size/'+id+'/destroy');
          }); 

        }); //End document ready      


    </script>  
@stop



