@extends('layout.app')

@section('content')


		<div class="page-wrapper">
            <!-- ============================================================== -->
            <!-- Bread crumb and right sidebar toggle -->
            <!-- ============================================================== -->
            <div class="change-pass-col-page mb-5 mt-5">
               <div class="container-detail">
                  <div class="row">
                     <div class="col-md-12">
                        <div class="admin-change-pass-col ">
                           {{Form::open(['id'=>'general_form'])}}	
                              <h3 class="page-title font-bold t text-center w-100 mb-5">Reset Your Password</h3>
                              <div class="general-info">
                              <div class="form-group">
                                    <label for="InputNumber">New Password:</label>
                                    <input type="password" name="new_password" class="form-control" id="InputNumber" aria-describedby="emailHelp" placeholder="Enter new password">
								 </div>
                                 <div class="form-group">
                                    <label for="InputNumber">Confirm New Password:</label>
                                    <input type="password" name="confirm_password" class="form-control" id="InputNumber" aria-describedby="emailHelp" placeholder="Confirm new password">
									@if(Session::has('error_message'))
										<span>{{ Session::get('error_message') }}</span>
									@endif
								 </div>
                                 <button class="custom-btn-col w-100">Change Password</button>
							</div>
                           {{Form::close()}}
                        </div>
                     </div>
                     </div>
                  </div>
               </div>
            </div>
		
        

@endsection