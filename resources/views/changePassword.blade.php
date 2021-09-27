@extends('layout.client')

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
                           {{Form::open(['url'=>url('change-password'),'id'=>'general_form'])}}	
                              <h3 class="page-title font-bold t text-center w-100 mb-5">Reset Your Password</h3>
                              <div class="general-info">
                              <div class="form-group">
                                    <label for="InputNumber">Old Password:</label>
                                    <input type="password" name="old_password" class="form-control" id="InputNumber" aria-describedby="emailHelp" placeholder="Enter old password">
									<span>@if ($errors->has('old_password')) {{ $errors->get('old_password')[0] }} @endif</span>
								</div>
                              <div class="form-group">
                                    <label for="InputNumber">New Password:</label>
                                    <input type="password" name="new_password" class="form-control" id="InputNumber" aria-describedby="emailHelp" placeholder="Enter new password">
									<span>@if ($errors->has('new_password')) {{ $errors->get('new_password')[0] }} @endif</span>
								 </div>
                                 <div class="form-group">
                                    <label for="InputNumber">Confirm New Password:</label>
                                    <input type="password" name="confirm_password" class="form-control" id="InputNumber" aria-describedby="emailHelp" placeholder="Confirm new password">
									<span>@if ($errors->has('confirm_password')) {{ $errors->get('confirm_password')[0] }} @endif</span>
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