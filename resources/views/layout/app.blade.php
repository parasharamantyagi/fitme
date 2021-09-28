
<!doctype html>
<html lang="en">
   <head>
      <!-- Required meta tags -->
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
      <!-- Bootstrap CSS -->
      <link rel="stylesheet" href="{{ url('clients/bootstrap.min.css') }}">
      <link rel="stylesheet" href="{{ url('clients/custom.css') }}">
      <link rel="stylesheet" href="{{ url('clients/csss/style.css') }}">
      <link rel="stylesheet" href="{{ url('clients/csss/normalize.css') }}" media="screen">
		<link rel="stylesheet" href="{{ url('clients/csss/grid.css') }}" media="screen">
		<link rel="stylesheet" href="{{ url('clients/csss/animate.min.css') }}" media="screen">
		<title>Fitme</title>
   </head>
   <body>
   <header id="header">
		
			
		</header>
	<!-- Modal -->
	<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content modal-padding">
				<div class="modal-header border-0">
					<h3 class="modal-title w-100 text-center" id="exampleModalLabel">Log In</h3>
					<button type="button" id="login_close" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					{{Form::open(['url'=>url('login'),'id'=>'general_form'])}}
						<div class="form-label-group">
							<label for="inputEmail">Email address</label>
							<input type="email" id="inputEmail" name="email" class="form-control" placeholder="Email address" required autofocus>
						</div>
						<div class="form-label-group">
							<label for="inputPassword">Password</label>
							<input type="password" id="inputPassword" name="password" class="form-control" placeholder="Password" required>
						</div>
						<div class="d-flex align-items-center justify-content-between mb-3">
						<div class="custom-control custom-checkbox ">
							<input type="checkbox" class="custom-control-input" id="customCheck1">
							<label class="custom-control-label" for="customCheck1">Remember password</label>
						</div>
						<a href="#" data-toggle="modal" data-target="#exampleModal1" id="example_forgot_model">Forget Password</a>
						</div>
						<button class="btn btn-lg btn-primary btn-block text-uppercase" type="submit">Sign in</button>
					{{Form::close()}}
				</div>
			</div>   
		</div>
	</div> 
					<!-- Modal -->
					
		<!-- forget password Modal -->
		<div class="modal fade p-0" id="exampleModal1" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
			<div class="modal-dialog" role="document">
				<div class="modal-content modal-padding">
					<div class="modal-header border-0 pb-0">
						<h3 class="modal-title w-100 text-center" id="exampleModalLabel">Reset Your Password</h3>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body">
					<p class="mt-0 text-center">Enter your email, and we,ll send you an email to reset your password</p>
					{{Form::open(['url'=>url('forget-password'),'id'=>'general_form'])}}
						<div class="form-label-group">
							<label for="inputEmail">Email address</label>
							<input type="email" id="inputEmail" name="email" class="form-control" placeholder="Email address" required autofocus>
							@if(Session::has('invalid_email'))
								<p class="text-danger">{{ Session::get('invalid_email') }}</p>
							@endif
											</div>
						<button class="btn btn-lg btn-primary btn-block text-uppercase" type="submit">Submit</button>
						{{Form::close()}}
					</div>
				</div>   
			</div>
		</div> 
												<!-- Modal -->
		@yield('content')
										

		<footer id="footer">
		
		</footer>
      <!-- JavaScript -->
	  <script src="{{ url('clients/plugins/bower_components/jquery/dist/jquery.min.js') }}"></script>
      <!-- Bootstrap tether Core JavaScript -->
      <script src="{{ url('clients/bootstrap/dist/js/bootstrap.min.js') }}"></script>
      <script src="{{ url('clients/js/custom.js') }}"></script>
      <!--This page JavaScript -->
      <!--chartis chart-->
      <script src="{{ url('clients/plugins/bower_components/chartist/dist/chartist.min.js') }}"></script>
      <script src="{{ url('clients/plugins/bower_components/chartist-plugin-tooltips/dist/chartist-plugin-tooltip.min.js') }}"></script>
      <script src="{{ url('clients/js/pages/dashboards/dashboard1.js') }}"></script>
      <script src="http://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>
	  <script src="{{ url('clients/js/form-validate.js') }}"></script>
	  <script src="{{ url('clients/js/jquery.validate.js') }}"></script>
	  <script src="{{ url('clients/js/jquery.toast.js') }}"></script>
	  
	@if(Session::has('success_message'))
	 <script>
			$.toast({
				  heading             : 'Success',
				  text                : "{{Session::get('success_message')}}",
				  loader              : true,
				  loaderBg            : '#fff',
				  showHideTransition  : 'fade',
				  icon                : 'success',
				  hideAfter           : 3000,
				  position            : 'top-right'
			});
	   
	   </script>
	@endif
	
		<script>
			$(document).ready( function () {
				$('#example_forgot_model').click(function(){
					$('#login_close').click();
				});
			});
		</script>
	  
	@if(Session::has('invalid_login'))
		<script>
			$(document).ready( function () {
				$('#example_login_model').click();
			});
		</script>
	@endif
	@if(Session::has('invalid_email'))
		<script>
			$(document).ready( function () {
				$('#example_forgot_model').click();
			});
		</script>
	@endif
		@yield('script')
   </body>
</html>
