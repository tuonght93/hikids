<?php use Illuminate\Support\Str as Str; 
    use Illuminate\Support\Facades\Session as Session;
 ?>
@extends('user.template')
@section('title')
    @if (empty($seo['title']))
        <title>Chính sách | Hikids</title>
    @else
        <title>{{ $seo['title'] }}</title>
    @endif
@stop
@section('main')
<section class="main-content-section">
	<div class="container">
		<div class="row">
			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
				<!-- BSTORE-BREADCRUMB START -->
				<div class="bstore-breadcrumb">
					<div style="float: left;" itemscope="" itemtype="http://data-vocabulary.org/Breadcrumb">
						<a href="{{ url('/') }}" itemprop="url">Trang chủ</a>
					</div>
					<div style="float: left;" itemscope="" itemtype="http://data-vocabulary.org/Breadcrumb">
						<span><i class="fa fa-caret-right"></i></span>
						<span itemprop="title">{{ $page->title }}</span>
					</div>
				</div>
				<!-- BSTORE-BREADCRUMB END -->
			</div>
		</div>
		<br/>
		<div class="row">
			<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
				<div class="ty-sidebox fyi">
        			<h2 class="ty-sidebox__title ">
	            		<span class="ty-sidebox__title-wrapper hidden-phone">Bạn cần biết</span>
                        <span class="cm-combination" id="sw_sidebox_108">
                            <span class="ty-sidebox__title-wrapper visible-phone">Bạn cần biết</span>
                            <span class="ty-sidebox__title-toggle visible-phone">
	                        	<i class="ty-sidebox__icon-open ty-icon-down-open"></i>
	                        	<i class="ty-sidebox__icon-hide ty-icon-up-open"></i>
                    		</span>
            			</span>
        			</h2>
        			<div class="ty-sidebox__body" id="sidebox_108">
						<div class="ty-text-links-wrapper">
        					<span id="sw_text_links_361" class="ty-text-links-btn cm-combination visible-phone">
		            			<i class="ty-icon-short-list"></i>
		            			<i class="ty-icon-down-micro ty-text-links-btn__arrow"></i>
        					</span>
    						<ul id="text_links_361" class="ty-text-links">
    							@foreach ($lists as $list)
                            	<li class="ty-text-links__item ty-level-0">
                            		<a class="ty-text-links__a" href="{{ url('/page/'.$list->slug) }}">{{ $list->title }}</a> 
                                </li>
                                @endforeach
                			</ul>
						</div>
    				</div>
    			</div>
			</div>
			<div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
				<div class="ty-mainbox-container clearfix">
	                <h1 class="ty-mainbox-title">
	                    <span>Phương thức thanh toán</span>
	                </h1>
	                <div class="ty-mainbox-body">
	                	<div class="ty-wysiwyg-content">
				    		<div>
				    			<div class="wrapper-page">
				    				{!! $page->content !!}
								</div>
							</div>
						</div>
					</div>
    			</div>
			</div>
		</div>
	</div>
</section>
@stop