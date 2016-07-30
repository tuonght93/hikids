<?php use Illuminate\Support\Str as Str; 
    use Illuminate\Support\Facades\Session as Session;
 ?>
@extends('back.template')

@section('title')
   <title>User | HappySkin Admin</title>
@stop

@section('css')
   <link rel="stylesheet" type="text/css" href="/css/dataTables.bootstrap.css">
     <link href="/css/model_component.css" rel="stylesheet">
@stop

@section('content')
  <div class="page-head">
      <h2>Danh sách người dùng</h2>
      <ol class="breadcrumb">
        <li><a href="{{ url('/manage/user') }}">Người dùng</a></li>
        <li>List</li>
      </ol>
    </div>

      <div class="cl-mcont">
          
          <div class="row">
            <div class="col-md-12">
              <div class="block-flat">
                <div class="content">
                  <a href="{{ url('/manage/user/create') }}" class="btn btn-primary">Thêm mới</a>
                  @include('errors/error_validation', ['errors' => $errors])
                  <div>
                    <div id="datatable-icons_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer">
                      <div class="row table-responsive" >
                        <div class="col-sm-12">
                          <table id="datatable-icons"  cellpadding="0" cellspacing="0" border="0" class="display" width="100%">
                            <thead>
                                <tr role="row">
                                  <th style="width: 5%;">STT</th>
                                  <th style="width: 30%;">Ảnh</th>
                                  <th >Email</th>
                                  <th style="width: 10%;" >Quyền</th><!-- 
                                  <th style="width: 10%;">Ngày tạo</th> -->
                                  <th style="width: 10%;">Trạng thái</th>
                                  <th style="width: 15%;">Action</th>
                                </tr>
                            </thead>
                          </table>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <div class="row">
            <div class="stats_bar">
              <div class="butpro butstyle">
                <div class="sub">
                  <h2>Admin</h2><span id="total_clientes">{{ $admin_count }}</span>
                </div>
                <div class="stat">{{ round($admin_count*100/$total,2) }}%</div>
              </div>
              <div class="butpro butstyle">
                <div class="sub">
                  <h2>Editor</h2><span id="total_clientes">{{ $editor_count }}</span>
                </div>
                <div class="stat">{{ round($editor_count*100/$total,2) }}%</div>
              </div>
               <div class="butpro butstyle">
                <div class="sub">
                  <h2>User</h2><span id="total_clientes">{{ $user_count }}</span>
                </div>
                <div class="stat">{{ round($user_count*100/$total,2) }}%</div>
              </div>
               <div class="butpro butstyle">
                <div class="sub">
                  <h2>Disabled</h2><span id="total_clientes">{{ $disable_count }}</span>
                </div>
                <div class="stat">{{ round($disable_count*100/$total,2) }}%</div>
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
                  <p id="model_content_confirm"></p>
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
    <script src="/js/jquery.dataTables.js" type="text/javascript"></script>
    <script src="/js/dataTables.bootstrap.min.js" type="text/javascript"></script>

@stop

@section('scriptend')
    <script type="text/javascript">
      $(document).ready(function(){  
         var dataTable = $('#datatable-icons').DataTable( {
            "processing": true,
            "serverSide": true,
            "lengthMenu": [ 15, 30, 50],
            "pageLength": 15,
            "aoColumnDefs": [
              {
                 bSortable: false,
                 aTargets: [  -1 ]
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
            },
            "ajax":{
                url :"<?php echo url('/manage/user/search')?>", // json datasource
                type: "post",
                data: {
                  _token : "<?php echo csrf_token(); ?>"
                },
                error: function(){
                    $(".datatable-icons-error").html("");
                    $("#datatable-icons").append('<tbody class="employee-grid-error"><tr><th colspan="3">Không tìm thấy dữ liệu</th></tr></tbody>');
                    $("#datatable-icons_processing").css("display","none"); 
                }
            }
        } );
        
        dataTable.on('xhr', function () {
          setTimeout(function(){
            initFunctions();
          }, 1000);
        });

         }); //End document ready
      
      function initFunctions(){
        $('.lock_user').click(function() {
          var id = $(this).attr('user-id');
          var status = $(this).attr('user-status');
          if (status == '0') {
            $('#model_content_confirm').html('Bạn chắc chắn muốn kích hoạt người dùng này ?');
          } else {
            $('#model_content_confirm').html('Bạn chắc chắn muốn khóa người dùng này ?');
          }
          $('#form_model').attr('action', '/manage/user/'+id+'/updateStatus');
        });

        $('button.delete_user').click(function() {          
          var id = $(this).attr('user-id');
          $('#form_model').attr('action', '/manage/user/'+id+'/destroy');
        });

      }
    </script>  
@stop



