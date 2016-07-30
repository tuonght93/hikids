@if(Session::has('errors'))
  <div class="alert alert-danger alert-white rounded">
    <button type="button" data-dismiss="alert" aria-hidden="true" class="close">×</button>
    <div class="icon" data-dismiss="alert" aria-hidden="true" class="close"><i class="fa fa-times-circle"></i></div>
      <strong>Lỗi!</strong>
      @foreach ($errors->all() as $error)
          {{ $error }}<br/>
      @endforeach
</div>
 @endif

 @if(Session::has('success'))
  <div class="alert alert-success alert-white rounded">
    <button type="button" data-dismiss="alert" aria-hidden="true" class="close">×</button>
    <div class="icon" data-dismiss="alert" aria-hidden="true" class="close"><i class="fa fa-times-circle"></i></div>
      <strong>Thành công! </strong>
      {{ Session::get( 'success' ) }}
</div>
 @endif