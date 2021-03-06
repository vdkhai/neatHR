<!DOCTYPE html>
<html lang="en">
	<head>

		<meta charset="UTF-8">

		<!-- Always force latest IE rendering engine (even in intranet) & Chrome Frame -->
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">

		<title>
			@section('title')
				Administration
			@show
		</title>

		<meta name="keywords" content="@yield('keywords')" />
		<meta name="author" content="@yield('author')" />
		<!-- Google will often use this as its description of your page/site. Make it good. -->
		<meta name="description" content="@yield('description')" />

		<!-- Speaking of Google, don't forget to set your site up: http://google.com/webmasters -->
		<meta name="google-site-verification" content="">

		<!-- Dublin Core Metadata : http://dublincore.org/ -->
		<meta name="DC.title" content="Project Name">
		<meta name="DC.subject" content="@yield('description')">
		<meta name="DC.creator" content="@yield('author')">

		<!--  Mobile Viewport Fix -->
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">

		<!-- This is the traditional favicon.
		 - size: 16x16 or 32x32
		 - transparency is OK
		 - see wikipedia for info on browser support: http://mky.be/favicon/ -->
		<link rel="shortcut icon" href="{{{ asset('assets/ico/favicon.png') }}}">

		<!-- iOS favicons. -->
		<link rel="apple-touch-icon-precomposed" sizes="144x144" href="{{{ asset('assets/ico/apple-touch-icon-144-precomposed.png') }}}">
		<link rel="apple-touch-icon-precomposed" sizes="114x114" href="{{{ asset('assets/ico/apple-touch-icon-114-precomposed.png') }}}">
		<link rel="apple-touch-icon-precomposed" sizes="72x72" href="{{{ asset('assets/ico/apple-touch-icon-72-precomposed.png') }}}">
		<link rel="apple-touch-icon-precomposed" href="{{{ asset('assets/ico/apple-touch-icon-57-precomposed.png') }}}">

		<!-- CSS -->
	    {{ Basset::show('admin.css') }}

		<style>
		body {
			padding: 60px 0;
		}
		</style>

		@yield('styles')

		<!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
		<!--[if lt IE 9]>
		<!--<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>-->
		<![endif]-->

		<!-- Asynchronous google analytics; this is the official snippet.
		 Replace UA-XXXXXX-XX with your site's ID and uncomment to enable.
		<script type="text/javascript">
			var _gaq = _gaq || [];
		    _gaq.push(['_setAccount', 'UA-31122385-3']);
		    _gaq.push(['_trackPageview']);

		    (function() {
		        var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
		            ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
		            var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
		    })();
		</script> -->

	</head>
	<body>
		<!-- Navbar -->
		@include('admin/partials/topbar')
		<!-- ./ navbar -->

		<!-- Container -->
		<div class="container">
			<div class="row row-offcanvas row-offcanvas-right">

			@if (isset($employee->id) && $employee->id > 0)
				<div id="sidebar" class="col-xs-12 col-sm-3 sidebar-offcanvas" role="navigation">
					<!-- Sidebar -->
					@include('admin/partials/sidebar')
					<!-- ./ Sidebar -->
				</div>

				<div class="col-xs-12 col-sm-9">
					@include('admin/notifications')
					<!-- ./ notifications -->

					<!-- Content -->
					@yield('content')
					<!-- ./ content -->
				</div>
			@else
				<div class="col-xs-12 col-sm-12">
					@include('admin/notifications')
					<!-- ./ notifications -->

					<!-- Content -->
					@yield('content')
					<!-- ./ content -->
				</div>
			@endif

			</div>

		</div>
		<!-- ./ container -->
		<hr/>
		<!-- Footer -->
		<footer class="clearfix">
			@yield('admin/footer')
		</footer>
		<!-- ./ Footer -->

		<!-- Javascripts -->
	    {{ Basset::show('admin.js') }}

	    <script type="text/javascript">
	        $('.wysihtml5').wysihtml5();
	        $(prettyPrint);
	    </script>

	    @yield('scripts')

		<div id="loading" style="display: none;" class="in">
			<p style="position: absolute; top: 20%; left: 40%;"><img src="{{{URL::route('imagecache', ['template' => 'general', 'filename' => 'loading.gif'])}}}" /> Please wait for loading...</p>
		</div>
		<script type="text/javascript">
			$(document).ready(function() {
				$(document).ajaxStart(function () {
					var modalBackdrop = $('.modal-backdrop');
					if(modalBackdrop == 'undefined'){
						$('#loading').addClass('modal-backdrop');
					}
					$('#loading').show();
				}).ajaxStop(function () {
					$('#loading').removeClass('modal-backdrop').hide();
				}).ajaxError(function(){
					$('#loading').removeClass('modal-backdrop').hide();
				});
			});
		</script>

	</body>
</html>