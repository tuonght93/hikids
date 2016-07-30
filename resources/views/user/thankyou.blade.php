<?php use Illuminate\Support\Str as Str; 
    use Illuminate\Support\Facades\Session as Session;
 ?>
@extends('user.template')
@section('title')
    @if (empty($seo['title']))
        <title>Cảm ơn | Hikids</title>
    @else
        <title>{{ $seo['title'] }}</title>
    @endif
@stop
@section('main')
<section class="main-content-section">
<div class="container">
  <div class="row thankyou-message">
      <div class="col-md-12">
          <div class="thankyou-message-icon">
              <div class="icon icon--order-success svg">
                  <svg xmlns="http://www.w3.org/2000/svg" width="72px" height="72px">
                      <g fill="none" stroke="#8EC343" stroke-width="2">
                          <circle cx="36" cy="36" r="35" style="stroke-dasharray:240px, 240px; stroke-dashoffset: 480px;"></circle>
                          <path d="M17.417,37.778l9.93,9.909l25.444-25.393" style="stroke-dasharray:50px, 50px; stroke-dashoffset: 0px;"></path>
                      </g>
                  </svg>
              </div>
          </div>
          <div class="thankyou-message-text">
              <h3>Cảm ơn bạn đã đặt hàng</h3>
              <p>
                  
                  Chúng tôi sẽ liên lạc với bạn theo số điện thoại của bạn trong thời gian sớm nhất!
                  
              </p>
              <em>
                  
              </em>
          </div>
      </div>
  </div>
  <div class="row thankyou-infos">
      <div class="col-md-4 thankyou-infos-left">
          
          <div class="order-summary order-summary--custom-background-color ">
              <div class="order-summary-header">
                  
                  <h2>
                      <label class="control-label">Địa chỉ giao hàng &amp; thanh toán</label>
                  </h2>
                  
              </div>
              <div class="summary-section">
                  <p class="address-name">
                      {{ $order->name }}
                  </p>
                  <p class="address-address">
                      {{ $order->address }}
                  </p>
                  <!-- 
                  <p class="address-province">
                      Hà Nội
                  </p> -->
                  
                  
                  <p class="address-phone">
                      {{ $order->phone }}
                  </p>
                  
              </div>
          </div>
          

          
      </div>
      <div class="col-md-8 thankyou-infos-right">
          <div class="order-summary order-summary--custom-background-color ">
              <div class="order-summary-header">
                  <h2>
                      <label class="control-label">Đơn hàng</label>
                      {{ $order->code }}
                  </h2>
              </div>
              <div class="summary-body  summary-section">
                  <div class="summary-product-list">
                      <ul class="product-list">
                          @foreach( $orderdetails as $orderdetail )
                          <li class="product product-has-image clearfix">
                              <img src="{{ config('image.image_url').'/products/'.$orderdetail->product->image_url().'_70x70.png' }}" alt="{{ $orderdetail->product->name }} - {{ $orderdetail->color }} / {{ $orderdetail->size }}" class="pull-left product-image">
                              
                              <div class="product-info pull-left">
                                  <span class="product-info-name">
                                      <span>{{ $orderdetail->product->name }}</span> x {{ $orderdetail->qty }}
                                  </span>
                                  
                                  <span class="product-info-description">
                                      {{ $orderdetail->color }} / {{ $orderdetail->size }}
                                  </span>
                                  
                                  
                              </div>
                              <span class="product-price pull-right">
                                  {{ number_format($orderdetail->price,0,",",".") }}đ
                              </span>
                          </li>
                          @endforeach
                      </ul>
                  </div>
              </div>
              
              <div class="summary-section">
                  <div class="total-line total-line-subtotal clearfix">
                      <span class="total-line-name pull-left">
                          
                          Giá
                          
                      </span>
                      <span class="total-line-subprice pull-right">
                           {{ number_format($order->total,0,",",".") }}đ
                      </span>
                  </div>
                  
                  
                  <div class="total-line total-line-shipping clearfix">
                      <span class="total-line-name pull-left">
                          Phí ship
                      </span>
                      <span class="pull-right">
                          
                          {{ number_format($order->shipping,0,",",".") }}đ
                          
                      </span>
                  </div>
                  
                  
                  <div class="total-line payment-info clearfix">
                      <span class="total-line-name pull-left">
                          Phương thức thanh toán
                      </span>
                      <span class="pull-right text-right">
                          <span>Thanh toán khi giao hàng (COD)</span><br>
                          <small>
                              cod
                          </small>
                  </div>
                  
              </div>
              <div class="summary-section">
                  <div class="total-line total-line-total clearfix">
                      <strong class="total-line-name pull-left">
                          Tổng cộng
                      </strong>
                      <span class="total-line-price pull-right">
                          {{ number_format($order->total+$order->shipping,0,",",".") }}đ
                      </span>
                  </div>
              </div>
          </div>
          <div class="order-success unprint">
              <a href="{{ url('/') }}" class="btn btn-primary">
                  Tiếp tục mua hàng
              </a>
              <!-- <a onclick="window.print()" class="nounderline print-link" href="javascript:void(0)">
                  In 
              </a> -->
          </div>
      </div>
  </div>
</div>
</section>
@stop