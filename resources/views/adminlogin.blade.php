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
                           {{Form::open(['url'=>url('admin-login'),'id'=>'general_form'])}}	
                              <h3 class="page-title font-bold t text-center w-100 mb-5">Admin login</h3>
								<div class="form-group">
                                    <label for="InputNumber">Email</label>
                                    <input type="text" name="email" class="form-control" id="InputNumber" aria-describedby="emailHelp" placeholder="Enter email">
									@if(Session::has('invalid_login'))
										<p class="text-danger">{{ Session::get('invalid_login') }}</p>
									@endif
								 </div>
								<div class="form-group">
                                    <label for="InputNumber">Password:</label>
                                    <input type="password" name="password" class="form-control" id="InputNumber" aria-describedby="emailHelp" placeholder="Enter password">
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