@extends('layout.client')

@section('content')


		<div class="page-wrapper">
            <!-- ============================================================== -->
            <!-- Bread crumb and right sidebar toggle -->
            <!-- ============================================================== -->
			{{Form::open(['url'=>url('provider/admin-profile'),'id'=>'general_form'])}}	
            <div class="page-breadcrumb bg-white">
               <div class="row align-items-center">
                  <div class="col-md-12 d-flex justify-content-between align-items-center">
                     <h3 class="page-title font-bold">Manage Account</h3>
                     <button class="custom-btn-col">Save</button>
                  </div>
               </div>
            </div>
            <div class="admin-detail-page mb-5 mt-5">
               <div class="container-detail">
                  <div class="row">
                     <div class="col-md-12">
                        <div class="admin-image-col">
                           <h4 class="mb-4">Upload Picture</h4>
                           <div class="avatar-wrapper">
                              <img class="profile-pic" src="{{url('clients/images/user-image.png')}}" />
                              <div class="upload-button">
                                 <i class="fa fa-arrow-circle-up" aria-hidden="true"></i>
                              </div>
                              <input class="file-upload" type="file" accept="image/*"/>
                           </div>
                        </div>
                        <div class="admin-detail-col pl-0 mt-5">
                              <div class="general-info">
                                 <h4 class="mb-4">Contact Information</h4>
                                 <div class="form-group">
                                    <label for="InputEmail1">Email address:</label>
                                    <input type="email" name="email" value="{{$userAuth->email}}" class="form-control" id="InputEmail1" aria-describedby="emailHelp" placeholder="Enter email">
                                 </div>
                                 <div class="form-group">
                                    <label for="InputNumber">Phone Number:</label>
                                    <input type="number" name="phone" value="{{$userAuth->phone}}" class="form-control" id="InputNumber" aria-describedby="emailHelp" placeholder="Enter number">
                                 </div>
                              </div>
                              <div class="general-info">
                                 <h4 class="mb-4">General Information</h4>
                                 <div class="form-group">
                                    <label for="InputName">First Name:</label>
                                    <input type="text" name="name" value="{{$userAuth->name}}" class="form-control" id="InputEmail1" aria-describedby="emailName" placeholder="Enter name">
                                 </div>
                                 <div class="form-group">
                                    <label for="InputNumber">DOB:</label>
                                    <input type="date" name="dob" value="{{$userAuth->dob}}" class="form-control" id="InputNumber" aria-describedby="emailHelp" placeholder="Enter Date of Birth">
                                 </div>
                                 <div class="form-group">
                                    <label for="InputNumber">Gender:</label>
                                    <select name="gender">
                                       <option @if($userAuth->gender === 'Male') ? selected : '' @endif>Male</option>
                                       <option @if($userAuth->gender === 'Female') ? selected : '' @endif>Female</option>
                                       <option @if($userAuth->gender === 'Other') ? selected : '' @endif>Other</option>
                                    </select>
                                 </div>
                              </div>
                           
                        </div>
                     </div>
                  </div>
               </div>
            </div>
            {{Form::close()}}
            <!-- ============================================================== -->
            <!-- End Container fluid  -->
            <!-- ============================================================== -->
            <!-- ============================================================== -->
            <!-- footer -->
            <!-- ============================================================== -->
            <footer class="footer text-center"> 2021 © USCIS <a
               href="#">uscis.com</a>
            </footer>
            <!-- ============================================================== -->
            <!-- End footer -->
            <!-- ============================================================== -->
         </div>
        

@endsection