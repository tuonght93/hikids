<?php use Illuminate\Support\Str as Str; 
    use Illuminate\Support\Facades\Session as Session;
 ?>
@extends('back.template')

@section('title')
   <title>Products | Manage Admin</title>
   <meta name="csrf-token" content="{{ csrf_token() }}" />
@stop

@section('css')
  <link href="/css/summernote.css" rel="stylesheet"> 
  <link href="/css/element/blue.css" rel="stylesheet">
  <link href="/css/model_component.css" rel="stylesheet">
  <link rel="stylesheet" type="text/css" href="/css/dataTables.bootstrap.css">
  <style type="text/css">
   #datatable-icons2_info, #datatable-icons2_length, #datatable-icons2_paginate, #datatable-icons2_filter {
    display: none;}
    .modal-dialog {width: 900px}
  </style>
  
@stop

@section('content')
      <div class="page-head">
        <h2>Người dùng hệ thống </h2>
        <ol class="breadcrumb">
          <li><a href="{{ url('/manage/order') }}">Hóa đơn</a></li>
          <li>{{ empty($order->id) ? 'Thêm mới' : 'Sửa' }}</li>
        </ol>
      </div>
      <div class="cl-mcont">
          <div class="row">            
            {!! Form::open(['url' => '/manage/order/'.$order->id, 'method' => empty($order->id) ? 'POST' : 'PUT', 'role' => 'form', 'files' => 'true', 'class' => 'form-horizontal group-border-dashed', 'style' => 'border-radius: 0px;', 'id' => 'form_user']) !!} 
              <div class="col-md-12">
              <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">

              <div class="block-flat">
                <div class="header">
                  <h3>Thông tin</h3>
                </div>
                <div class="content">

                  @include('errors/error_validation', ['errors' => $errors])

                  <div class="form-group">
                    <label class="col-sm-3 control-label">Tên khách hàng</label>
                    <div class="col-sm-6">

                      {!! Form::text('name', $order->name, array('disabled' => 'disabled','placeholder' => 'Tên khách hàng', 'class' => 'form-control')) !!}

                    </div>
                  </div>

                  <div class="form-group">
                    <label class="col-sm-3 control-label">Điện thoại</label>
                    <div class="col-sm-6">
                      {!! Form::text('phone', $order->phone, array('disabled' => 'disabled','placeholder' => 'Số điện thoại', 'class' => 'form-control')) !!}
                    </div>
                  </div>

                  <div class="form-group">
                    <label class="col-sm-3 control-label">Email</label>
                    <div class="col-sm-6">
                      {!! Form::text('email', $order->email, array('disabled' => 'disabled','placeholder' => 'Email', 'class' => 'form-control')) !!}
                    </div>
                  </div>

                  <div class="form-group">
                    <label class="col-sm-3 control-label">Địa chỉ</label>
                    <div class="col-sm-6">
                      {!! Form::text('address', $order->address, array('disabled' => 'disabled','placeholder' => 'Website', 'class' => 'form-control')) !!}
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-sm-3 control-label">Trạng thái</label>
                    <div class="col-sm-6">
                      <select class="form-control" name="status">
                        <option value="1" <?php if($order->status == 0) echo 'selected'?>>Vừa được đặt</option>
                        <option value="1" <?php if($order->status == 1) echo 'selected'?>>Đã xác nhận</option>
                        <option value="2" <?php if($order->status == 2) echo 'selected'?>>Đang vận chuyển</option>
                        <option value="3" <?php if($order->status == 3) echo 'selected'?>>Đã thanh toán</option>
                        <option value="4" <?php if($order->status == 4) echo 'selected'?>>Hoàn thành</option>
                      </select>
                    </div>
                  </div>
                </div>
              </div> 

              <div class="block-flat">
                <div class="header">
                  <h3>Thông tin hóa đơn</h3>
                </div>
                <div class="content">
                  <div id="datatable-icons_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer">
                    <div class="row table-responsive" >
                      <div class="col-sm-12">
                        <table id="datatable-icons2"  cellpadding="0" cellspacing="0" border="0" class="display" width="100%">
                          <thead>
                              <tr role="row">
                                <th style="width: 5%;">STT</th>
                              <th>Tên sản phẩm</th>
                              <th style="width: 10%;" >Số lượng</th> 
                              <th style="width: 10%;">Màu sắc</th>
                              <th style="width: 10%;">Kích cỡ</th>
                              <th style="width: 10%;">Giá bán</th>
                              </tr>
                          </thead>
                        </table>
                      </div>
                      <div class="col-sm-12">
                        
                      </div>
                    </div>
                  </div>
                </div>
              </div> 

              <div class="row block-flat">
                <div class="col-sm-offset-2 col-sm-10">
                    <a href="{{ url('/manage/order') }}" class="btn btn-default">Trở lại</a>
                    <button id="form_submit" type="submit" class="btn btn-primary wizard-next">Lưu thông tin</button>
                </div>
              </div>            
            </div>

          </form>
          </div>
      </div>

@stop

@section('script')
  <script type="text/javascript" src="/js/summernote.min.js"></script>
  <script type="text/javascript" src="/js/icheck.min.js"></script>
  <script src="/js/jquery.dataTables.js" type="text/javascript"></script>
  <script src="/js/dataTables.bootstrap.min.js" type="text/javascript"></script>
  
  
@stop

@section('scriptend')
    <script type="text/javascript">
      $(document).ready(function(){  
         var dataTable = $('#datatable-icons2').DataTable( {
            "processing": true,
            "serverSide": true,
            "lengthMenu": [ 15, 30, 50],
            "pageLength": 15,
            "aoColumnDefs": [
              {
                 bSortable: false,
                 aTargets: [  -1, -2, -3 ]
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
                url :"<?php echo url('/manage/order/ajaxSearch')?>", // json datasource
                type: "post",
                data: {
                  _token : "<?php echo csrf_token(); ?>",
                  "order_id": "<?php echo $order->id; ?>"
                },
                error: function(){
                    $(".datatable-icons-error").html("");
                    $("#datatable-icons2").append('<tbody class="employee-grid-error"><tr><th colspan="3">Không tìm thấy dữ liệu</th></tr></tbody>');
                    $("#datatable-icons_processing").css("display","none"); 
                }
            }
        } );
        
        dataTable.on('xhr', function () {
          setTimeout(function(){
            initFunctions();
          }, 1000);
        });
        });
  function initFunctions(){
        
        };
         
</script>
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



