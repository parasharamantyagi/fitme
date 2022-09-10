<!doctype html>
<html class="no-js" lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Fitme {{ isset($title) ? ' | '.$title : '' }}</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	
    <!-- favicon
		============================================ -->
    <link rel="shortcut icon" type="image/x-icon" href="img/logo/logosn_11zon.ico">
    <!-- Google Fonts
		============================================ -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:100,300,400,700,900" rel="stylesheet">
    <!-- Bootstrap CSS
		============================================ -->
    <link rel="stylesheet" href="{{ url('admin/css/bootstrap.min.css') }}">
    <!-- Bootstrap CSS
		============================================ -->
    <link rel="stylesheet" href="{{ url('admin/css/font-awesome.min.css') }}">
	
    <link rel="stylesheet" href="{{ url('admin/css/toaster.css') }}">
    <!-- animate CSS
		============================================ -->
    <link rel="stylesheet" href="{{ url('admin/css/animate.css') }}">
    <!-- normalize CSS
		============================================ -->
    <link rel="stylesheet" href="{{ url('admin/css/normalize.css') }}">
    <!-- meanmenu icon CSS
		============================================ -->
    <link rel="stylesheet" href="{{ url('admin/css/meanmenu.min.css') }}">
    <!-- main CSS
		============================================ -->
    <link rel="stylesheet" href="{{ url('admin/css/main.css') }}">
    <!-- morrisjs CSS
		============================================ -->
    <link rel="stylesheet" href="{{ url('admin/css/morrisjs/morris.css') }}">
    <!-- mCustomScrollbar CSS
		============================================ -->
    <link rel="stylesheet" href="{{ url('admin/css/scrollbar/jquery.mCustomScrollbar.min.css') }}">
    <!-- metisMenu CSS
		============================================ -->
    <link rel="stylesheet" href="{{ url('admin/css/metisMenu/metisMenu.min.css') }}">
    <link rel="stylesheet" href="{{ url('admin/css/metisMenu/metisMenu-vertical.css') }}">
    <!-- calendar CSS
		============================================ -->
    <!-- style CSS
		============================================ -->
    <link rel="stylesheet" href="{{ url('admin/style.css') }}">
    <!-- responsive CSS
		============================================ -->
    <link rel="stylesheet" href="{{ url('admin/css/responsive.css') }}">
    <!-- modernizr JS
		============================================ -->
	@yield('style')
</head>

<body>
    <!--[if lt IE 8]>
            <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
        <![endif]-->

    
    <!-- Start Welcome area -->
    <div class="all-content-wrapper">
        
        <div class="header-advance-area">
            <!-- Mobile Menu end -->
            <div class="breadcome-area">
                <h2>welcome to fitme</h2>
            </div>
        </div>
		<div id="preloader"></div>
		@yield('content')
		
		
        <!-- div class="footer-copyright-area">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="footer-copy-right">
                            <p>Copyright © 2018 <a href="https://colorlib.com/wp/templates/">Colorlib</a> All rights reserved.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div -->
    </div>
    <!-- jquery
		============================================ -->
    <script src="{{ url('admin/js/vendor/jquery-1.12.4.min.js') }}"></script>
    <!-- bootstrap JS
		============================================ -->
    <script src="{{ url('admin/js/jquery.toast.js') }}"></script>
	
    <script src="{{ url('admin/js/bootstrap.min.js') }}"></script>
	
	<script src="{{ url('admin/js/form-validate.js') }}"></script>
	
	<script src="{{ url('admin/js/jquery.validate.js') }}"></script>
	
    <!-- price-slider JS
		============================================ -->
    <script src="{{ url('admin/js/jquery-price-slider.js') }}"></script>
    <!-- meanmenu JS
		============================================ -->
    <script src="{{ url('admin/js/jquery.meanmenu.js') }}"></script>
    <!-- owl.carousel JS
		============================================ -->
    <script src="{{ url('admin/js/owl.carousel.min.js') }}"></script>
    <!-- sticky JS
		============================================ -->
    <script src="{{ url('admin/js/jquery.sticky.js') }}"></script>
    <!-- scrollUp JS
		============================================ -->
    <script src="{{ url('admin/js/jquery.scrollUp.min.js') }}"></script>
    <!-- mCustomScrollbar JS
		============================================ -->
    <script src="{{ url('admin/js/scrollbar/jquery.mCustomScrollbar.concat.min.js') }}"></script>
    <script src="{{ url('admin/js/scrollbar/mCustomScrollbar-active.js') }}"></script>
    <!-- metisMenu JS
		============================================ -->
    <script src="{{ url('admin/js/metisMenu/metisMenu.min.js') }}"></script>
    <script src="{{ url('admin/js/metisMenu/metisMenu-active.js') }}"></script>
    <!-- sparkline JS
		============================================ -->
    <!-- plugins JS
		============================================ -->
    <script src="{{ url('admin/js/plugins.js') }}"></script>
    <!-- main JS
		============================================ -->
    <script src="{{ url('admin/js/main.js') }}"></script>
	
	<script src="{{ url('admin/js/custom.js') }}"></script>
	
	@yield('script')
	@if(Session::has('success_message'))
	<script>
	$.toast({
          heading             : 'Success',
          text                : "{{ Session::get('success_message') }}",
          loader              : true,
          loaderBg            : '#fff',
          showHideTransition  : 'fade',
          icon                : 'success',
          hideAfter           : 3000,
          position            : 'top-right'
      });
	</script>
	@endif
</body>

</html>