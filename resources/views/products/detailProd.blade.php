@extends('layouts.master')
@section('title')@parent- {{ $product->name }} @stop
@inject('productsHelper', 'App\Http\Controllers\ProductsController')

@include('partial.message')

@section('metaLabels')
    @parent
    @include('partial.social_tags', [
        'title' => $product->name,
        'image' => isset($product->features['images'][0]) ? URL::to('/').$product->features['images'][0] : '/img/no-image.jpg',
        'description' => substr($product->description, 0, 197).'...',
        'id' =>$product->id,
        'brand' => isset($product->features['brand'])?$product->features['brand']:'',
        'rate_val' => $product->rate_val,
        'rate_count' => $product->rate_count
    ])
@stop

@section('breadcrumbs')
    @parent
    {!! Breadcrumbs::render('productDetail', $product) !!}
@stop



@if($product->status==0)
    <div class="alert alert-danger" role="alert">
        {{ trans('product.show_view.status_inactive') }}
    </div>
@endif

@section('content')
    @parent

    @if (Auth::id()===$product->user_id)
        @section('panel_left_content')
            @include('user.partial.menu_dashboard')

			<div class="row hidden-xs">
	            <div class="col-md-12">
	        		{!! Form::open(['route' => ['products.change_status', $product->id], 'method' => 'post', 'class' => 'form-inline']) !!}
	                    <a href="{{ route('products.edit',[$product->id]) }}" style="width:100%" class="btn btn-success btn-sm">
							<span class="glyphicon glyphicon-edit"></span>&nbsp;
	                    	{{ trans('globals.edit') }}
	                    </a>

						<div class="row">&nbsp;</div>

	                    <button type="submit" class="btn btn-primary btn-danger btn-sm" style="width:100%">
							<span class="glyphicon @if ($product->status) glyphicon-ban-circle @else glyphicon-ok-circle @endif"></span>&nbsp;
	                    	{{ $product->status ? trans('globals.disable') : trans('globals.enable') }}
	                    </button>

						<div class="row">&nbsp;</div>

	                    @if ($product->type=='key')
	                        <button type="button" ng-controller="ModalCtrl" style="width:100%" ng-init="data={'data':{{ $product->id }}}" ng-click="modalOpen({templateUrl:'/modalAllKeys',controller:'getKeysVirtualProducts',resolve:'data'})" class="btn btn-primary btn-sm">
								<span class="glyphicon glyphicon-eye-open"></span>&nbsp;
	                        	{{ trans('product.globals.see_keys') }}
	                        </button>
	                    @endif
	                {!! Form::close() !!}
	            </div>
	        </div>

        @stop
    @endif


	@section('center_content')

		<div class="page-header">
            <h5>{{ $product->name }}</h5>
        </div>

		<div class="row">

	        <div id="slider">
	            <div class="col-md-6" id="carousel-bounding-box">
	                <div id="galleryProducts" class="carousel slide">

	                    <div class="carousel-inner">
							<?php $selector = 0; ?>
							@foreach($product->features['images'] as $image)
	                            <div class="@if ($selector == 0) active @endif item" data-slide-number = "{{ $selector++ }}">
	                                <img src=" {{ $image }}" class="img-responsive img-rounded">
	                            </div>
	                        @endforeach
	                    </div>

	                    <a class="carousel-control left" href="#galleryProducts" data-slide="prev">‹</a>
	                    <a class="carousel-control right" href="#galleryProducts" data-slide="next">›</a>
	                </div>
	            </div>
	        </div>

	        <div class="col-md-3">
				<hr class="visible-xs visible-sm">
				<h6>{{ \Utility::showPrice($product->price) }}</h6>
				<hr class="hidden-sm hidden-xs">
				<ul class="list-unstyled">
					<li><label>{{ trans('store.condition') }}:</label>&nbsp;{{ ucwords($product->condition) }}</li>
					<li><label>{{ trans('globals.brand') }}:</label>&nbsp;{{ ucwords($product->brand) }}</li>
					@foreach ($product->features as $key => $feature)
						@if ($key != 'images')
							<li><label>{{ ucwords($key) }}:</label>&nbsp;{{ ucwords($feature) }}</li>
						@endif
					@endforeach
					<li>
						@if ($product->stock <= $product->low_stock)
							<span class = "label label-warning">{{ trans('store.lowStock') }}</span>
						@else
							<span class = "label label-success">{{ trans('store.inStock') }}</span>
						@endif
					</li>
				</ul>
				<hr class="visible-xs visible-sm">
	        </div>

	        <div class="col-md-3">

	        	<div class="panel panel-default">
		        	<div class="panel-body">

	                    {!! Form::open(array('url' => route('orders.add_to_order',['cart',$product->id]), 'method' => 'put')) !!}
	                    <div class="row">
							<div class="col-lg-12">
								<label for = "quantity">{{ trans('store.quantity_long') }}:</label>
									{!! Form::selectRange(
			                            	'quantity', 1,
			                            	$product->stock, 1,
			                                ['class' => 'form-control input-sm']
			                        ) !!}
		                    </div>
	                    </div>

	                    <hr>

	                    <div class="row">
	                    	<div class="col-lg-12">
								<button type="submit" class="btn btn-warning btn-sm" style="width:100%">
									<span class="glyphicon glyphicon-shopping-cart"></span>&nbsp;
									{{ trans('store.add_to_cart') }}
								</button>
							</div>
	                    </div>

						<div class="row">&nbsp;</div>

	                    <div class="row">

	                    	<div class="col-lg-12">

									@if (Auth::check())

		                                <div class="dropdown">

		                                    <button class="btn btn-default dropdown-toggle btn-sm" style="width:100%" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
		                                        <span class="glyphicon glyphicon-heart"></span>&nbsp;
		                                        {{ trans('store.addToWishList') }}
		                                        <span class="caret"></span>
		                                    </button>

		                                    <ul class="dropdown-menu dropdown-menu-left btn-sm" aria-labelledby="dropdownMenu1">
		                                        <li>
		                                            <a href="{{ route('orders.add_to_order',['wishlist',$product->id]) }}">
		                                                {{ trans('store.wish_list') }}
		                                            </a>
		                                        </li>
		                                        @if (count($allWishes)>0)
		                                            <li class="dropdown-header">{{ trans('store.your_wish_lists') }}</li>
		                                        @endif
		                                        @foreach($allWishes as $wishList)
		                                            <li><a href="{{ route('orders.add_to_order_by_id',[$wishList->id,$product->id]) }}">{{ $wishList->description }}</a></li>
		                                        @endforeach

		                                    </ul>
		                                </div>

	                                @else
	                                    <a  href="/auth/login btn-sm" class="btn btn-info" style="width:100%">
	                                    	<span class="glyphicon glyphicon-heart"></span>&nbsp;
	                                    	{{ trans('store.addToWishList') }}
	                                    </a>
	                                @endif

							</div>
	                    </div>

						{{-- Virtual Products --}}
	                    @if ($product->type=='key')
	                    	<hr>
	                       	<label for = "email">{{ trans('globals.send_to') }}:</label>
	                       	{!! Form::email('email',(Auth::check()?Auth::user()->email:null), ['class'=>'form-control input-sm',(Auth::check()?'':'disabled')=>(Auth::check()?'':'disabled')]) !!}
	                    @endif

	                    {!! Form::close() !!}

					</div> {{-- panel-body --}}
				</div>
	        </div>
		</div>

		<div class="row">&nbsp;</div>

		<div class="row">
			<div class="col-md-6 hidden-sm hidden-xs" id="slider-thumbs">
		      	<ul class="list-inline">
					<?php $selector = 0; ?>
					@foreach($product->features['images'] as $image)
						<li>
							<a id="carousel-selector-{{ $selector++ }}" class="selected">
								<img src=" {{ $image }}?h=50" class="img-responsive img-rounded">
							</a>
						</li>
					@endforeach
		        </ul>
		    </div>

	        <div class="col-md-6">
				<div class="hidden-xs hidden-sm">
					@if (trim($product->description) != '')
		        	<label>{{ trans('store.description') }}:</label>&nbsp;
					{{ $product->description }}
					@else
						&nbsp;
					@endif
				</div>
	        </div>

		</div>

		<div class="row">&nbsp;</div>

		<div class="page-header">
            <h5>{{ trans('store.suggestions.product') }}</h5>
        </div>
		<div class="row">
			@if (count($product->group))
                @include('products.group')
            @else
	            <section class="products_view">
                    <div class="container-fluid marketing">
                        <div class="row">
                            @foreach ($suggestions as $productSuggestion)
                                @include('products.partial.productBox', $productSuggestion)
                            @endforeach
                        </div>
                    </div>
	            </section>
            @endif
		</div>

	 @stop
@stop


@section('scripts')
    @parent
    <script>

		$('#galleryProducts').carousel({
		    interval: 4000
		});

		// handles the carousel thumbnails
		$('[id^=carousel-selector-]').click( function(){
		  var id_selector = $(this).attr("id");
		  var id = id_selector.substr(id_selector.length -1);
		  id = parseInt(id);
		  $('#galleryProducts').carousel(id);
		  $('[id^=carousel-selector-]').removeClass('selected');
		  $(this).addClass('selected');
		});

		// when the carousel slides, auto update
		$('#galleryProducts').on('slid', function (e) {
		  var id = $('.item.active').data('slide-number');
		  id = parseInt(id);
		  $('[id^=carousel-selector-]').removeClass('selected');
		  $('[id=carousel-selector-'+id+']').addClass('selected');
		});

		(function(app){
            app.controller('StoreProducts', ['$scope', function($scope){
                $scope.isCollapsedDescription = true;
                $scope.isCollapseComments = true;
                $scope.myInterval = 3000;
                $scope.checkButtonDescription = 1;
                $scope.checkButtonComments = 1;
                $scope.product=({!! $product->toJson() !!});
                $scope.detailComments=({!! $jsonDetails !!});

            }]);

            // app.filter('dateToISO', function() {
            //     return function(input) {
            //         input = new Date(input).toISOString();
            //         return input;
            //     };
            // });

            app.config(
                ['$animateProvider',
                    function ($animateProvider) {
                        $animateProvider.classNameFilter(/carousel/);
                    }]);
        })(angular.module("AntVel"));

    </script>
@stop


