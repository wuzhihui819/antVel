<!DOCTYPE html>
<html lang="{{ App::getLocale() }}" ng-app="AntVel">
<head>
	@section('metaLabels')
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<base href="/">
		<meta name="description" content="">
		<meta name="author" content="">
	@show

	<link rel="icon" href="favicon.ico">
	<title>@section('title'){{ $main_company['website_name']}} @show</title>

	<script type="text/javascript">
	FileAPI = {
		debug: true
	};
	</script>

	{!! Html::style('/css/vendor/bootstrap.css') !!}
	@section('css')
		{!! Html::style('/css/app.css') !!}
		<!-- Custom styles for this template -->
		{!! Html::style('/css/carousel.css') !!}
		{!! Html::style('/css/vendor/angucomplete-alt.css') !!}
		{!! Html::style('/css/vendor/angular-notify.css') !!}
	@show

	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
	<!--[if lt IE 9]>
		<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
		<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
	<![endif]-->
</head>
<body>

<section class = "@yield('page_class', 'home')">

	{{-- Navigation bar section --}}
	@section('navigation')
		@include('partial.navigation')
	@show

	{{-- Breadcrumbs section --}}
	<div class="container">
		@section('breadcrumbs')
			<div class="row">&nbsp;</div>
		@show
	</div>

	{{-- Content page --}}
	@section('content')
		@section('panels')

			<div class="container">
				<div class="row">&nbsp;</div>
				<div class="row global-panels">

					{{-- left panel --}}
					@if (isset($panel['left']))
						{{-- desktops validation --}}
						<div class="col-sm-{{ $panel['left']['width'] or '2' }} col-md-{{ $panel['left']['width'] or '2' }} {{ $panel['left']['class'] or '' }}">
							@section('panel_left_content')
								Left content
							@show
						</div>
					@endif

					{{-- center content --}}
					<div class="col-xs-12 col-sm-{{ $panel['center']['width'] or '10' }} col-md-{{ $panel['center']['width'] or '10' }}">
						@section('center_content')
							Center content
						@show
					</div>

					{{-- right panel --}}
					@if (isset($panel['right']))
						<div class="hidden-xs col-sm-{{ $panel['right']['width'] or '2' }} col-md-{{ $panel['right']['width'] or '2' }} {{ $panel['right']['class'] or '' }}">
							@section('panel_right_content')
								Right content
							@show
						</div>
					@endif

				</div> {{-- globlas panels --}}
			</div> {{-- container --}}

		@show
	@show

</section>

@section('footer')
	<footer>
		@include('partial.footer')
	</footer>
@show

{{-- JavaScript vendor --}}
{!! Html::script('/js/vendor/jquery.min.js') !!}
{!! Html::script('/js/vendor/angular.min.js') !!}
{!! Html::script('/js/vendor/angular-sanitize.js') !!}
{!! Html::script('/js/vendor/ui-bootstrap-tpls.min.js') !!}
{!! Html::script('/js/vendor/angular-animate.min.js') !!}
{!! Html::script('/js/vendor/loading-bar.js') !!}
{!! Html::script('/js/vendor/angular-mocks.js') !!}
{!! Html::script('/js/vendor/angular-touch.min.js') !!}

{{-- Forms --}}
{!! Html::script('/js/vendor/xtForms/xtForm.js') !!}
{!! Html::script('/js/vendor/xtForms/xtForm.tpl.min.js') !!}

{!! Html::script('/js/vendor/bootstrap.min.js') !!}

{{-- Antvel - Angular module initialization --}}
<script>

	var ngModules = [
		'ngSanitize',
		'LocalStorageModule',
		'ui.bootstrap',
		'chieffancypants.loadingBar',
		'ngAnimate',
		'xtForm',
		'cgNotify',
		'ngTouch',
		'filters',
		'angucomplete-alt'
	];

	@section('before.angular') @show

	(function(){
		angular.module('AntVel',ngModules,
		function($interpolateProvider){
			$interpolateProvider.startSymbol('[[');
			$interpolateProvider.endSymbol(']]');
		}).config(function(localStorageServiceProvider, cfpLoadingBarProvider,$locationProvider){
			cfpLoadingBarProvider.includeSpinner = false;
			localStorageServiceProvider.setPrefix('tb');
			$locationProvider.html5Mode({enabled:true,rewriteLinks:false});
		});
	})();

</script>

{{-- Antvel - Angular functions --}}
{!! Html::script('/js/app.js') !!}

@section('scripts')
	{{-- Antvel - third part angular directives --}}
	{!! Html::script('/js/filters.js') !!}
	{!! Html::script('/js/vendor/angucomplete-alt.js') !!}
	{!! Html::script('/js/vendor/angular-notify.js') !!}
	{!! Html::script('/js/vendor/angular-local-storage.min.js') !!}

	{{-- All Jquery plugins in one file, optional by section --}}
	{!! Html::script('/js/plugins.js') !!}
@show

</body>
</html>
