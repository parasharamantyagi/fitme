@extends('layout.app')

@section('content')
		<div class="page-wrapper">
            <!-- ============================================================== -->
            <!-- Bread crumb and right sidebar toggle -->
            <!-- ============================================================== -->
            <div class="change-pass-col-page mb-5 mt-5">
               <div class="container-detail">
                  <div class="row">
					<div id="preloader"></div>
                     <div class="col-md-12">
                        <div class="admin-change-pass-col ">
                           {{Form::open(['url'=>url('reset-password/'.$id),'id'=>'general_form'])}}	
                              <h3 class="page-title font-bold t text-center w-100 mb-5">Reset password</h3>
								<div class="form-group">
                                    <label for="InputNumber">New Password</label>
                                    <input type="password" name="new_password" class="form-control" id="InputNumber" placeholder="Enter new password">
								 </div>
								<div class="form-group">
                                    <label for="InputNumber">Confirm Password:</label>
                                    <input type="password" name="confirm_password" class="form-control" id="InputNumber" placeholder="Enter Confirm password">
									@if(Session::has('error_message'))
										<p class="text-danger">{{ Session::get('error_message') }}</p>
									@endif
                                 </div>
                                 <button class="custom-btn-col w-100">Submit</button>
                           {{Form::close()}}
                        </div>
                     </div>
                     </div>
                  </div>
               </div>
            </div>
		
        

@endsection