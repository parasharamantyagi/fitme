@extends('layout.client')

@section('content')

		<div id="confimation_model" class="modal fade" tabindex="-1" role="dialog">
		  <div class="modal-dialog" role="document">
			<div class="modal-content">
			  <div class="modal-header">
				<h5 class="modal-title">Confirmation</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				  <span aria-hidden="true">&times;</span>
				</button>
			  </div>
			  <div class="modal-body">
				<p id="modal-body-message"></p>
			  </div>
			  <div class="modal-footer">
				<button type="button" class="btn btn-primary yes">Yes</button>
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
			  </div>
			</div>
		  </div>
		</div>


         <div class="page-wrapper">
            <!-- ============================================================== -->
            <!-- Bread crumb and right sidebar toggle -->
            <!-- ============================================================== -->
			{{Form::open(['url'=>url($form_action),'id'=>'general_form','enctype'=>'multipart/form-data'])}}	
            <div class="page-breadcrumb bg-white">
               <div class="row align-items-center">
                  <div class="col-md-12 d-flex justify-content-between align-items-center">
                     <h3 class="page-title font-bold">Client Information</h3>
                     <div class="cstm-call">
                        <button class="custom-btn-col">Save</button>
						<a href="{{ url('provider/client') }}" class="custom-btn-col">Cancel</a>
                     </div>
                  </div>
               </div>
            </div>
            <div class="client-detail-page mb-5 mt-5">
               <div class="container-detail">
                  <div class="row">
                     <div class="col-md-4">
                        <div class="user-image-col">
                           <div class="avatar-wrapper">
							<?php if($client->image){ ?>
								<img class="profile-pic" src="{{ url($client->image) }}" />
							<?php }else{ ?>
								<img class="profile-pic" src="{{ url('images/id-img.jpg') }}" />
							<?php } ?>
                              <div class="upload-button">
                                 <i class="fa fa-arrow-circle-up" aria-hidden="true"></i>
                              </div>
                              <input class="file-upload" name="image" type="file" />
                           </div>
                           <h4 class="text-center">Upload Picture</h4>
                           <h4 class="text-center"><input type="button" class="btn btn-info" value="Send link"></input></h4>
                        </div>
                     </div>
                     <div class="col-md-8">
                        <div class="user-detail">
                              <div class="general-info mt-5">
                                 <h4 class="mb-4">General Information</h4>
                                 <div class="form-group">
                                    <label for="InputName">Name:</label>
                                    <input type="text" name="name" value="{{(old('name')) ? old('name') : $client->name}}" class="form-control" id="InputEmail1" aria-describedby="emailName" placeholder="Enter name">
									<span>@if ($errors->has('name')) {{ $errors->get('name')[0] }} @endif</span>
								 </div>
								 <div class="form-group">
                                    <label for="InputNumber">Phone Number:</label>
                                    <input type="text" name="phone" value="{{(old('phone')) ? old('phone') : $client->phone}}" class="form-control" id="InputNumber" aria-describedby="emailHelp" placeholder="Enter number">
									<span>@if ($errors->has('phone')) {{ $errors->get('phone')[0] }} @endif</span>
									<input type="hidden" name="send_sms" value="false">
								 </div>
                                 <div class="form-group">
                                    <label for="InputNumber">DOB:</label>
                                    <input type="date" name="dob" value="{{(old('dob')) ? old('dob') : $client->dob}}" class="form-control" id="InputNumber" aria-describedby="emailHelp" placeholder="Enter Date of Birth">
									<span>@if ($errors->has('dob')) {{ $errors->get('dob')[0] }} @endif</span>
								 </div>
                                 <div class="form-group">
                                    <label for="InputNumber">Origin:</label>
                                    <input type="text" name="origin" value="{{(old('origin')) ? old('origin') : $client->origin}}" class="form-control" id="InputNumber" aria-describedby="emailHelp" placeholder="Enter origin">
									<span>@if ($errors->has('origin')) {{ $errors->get('origin')[0] }} @endif</span>
								 </div>
                                 <div class="form-group">
                                    <label for="InputNumber">Gender:</label>
                                    <select name="gender">
                                       <option @if($client->gender === 'Male' || old('gender') === 'Male') ? selected : '' @endif>Male</option>
                                       <option @if($client->gender === 'Female' || old('gender') === 'Female') ? selected : '' @endif>Female</option>
                                       <option @if($client->gender === 'Other' || old('gender') === 'Other') ? selected : '' @endif>Other</option>
                                    </select>
                                 </div>
                                 <div class="form-group">
                                    <label for="InputNumber">Eyes:</label>
									<select name="eyes">
                                       <option @if($client->eyes === 'Black' || old('eyes') === 'Black') ? selected : '' @endif>Black</option>
                                       <option @if($client->eyes === 'Blue' || old('eyes') === 'Blue') ? selected : '' @endif>Blue</option>
                                       <option @if($client->eyes === 'Brown' || old('eyes') === 'Brown') ? selected : '' @endif>Brown</option>
                                       <option @if($client->eyes === 'Gray' || old('eyes') === 'Gray') ? selected : '' @endif>Gray</option>
                                       <option @if($client->eyes === 'Green' || old('eyes') === 'Green') ? selected : '' @endif>Green</option>
                                       <option @if($client->eyes === 'Hazel' || old('eyes') === 'Hazel') ? selected : '' @endif>Hazel</option>
                                       <option @if($client->eyes === 'Maroon' || old('eyes') === 'Maroon') ? selected : '' @endif>Maroon</option>
                                       <option @if($client->eyes === 'Multicolored' || old('eyes') === 'Multicolored') ? selected : '' @endif>Multicolored</option>
                                       <option @if($client->eyes === 'Pink' || old('eyes') === 'Pink') ? selected : '' @endif>Pink</option>
                                       <option @if($client->eyes === 'Unknown' || old('eyes') === 'Unknown') ? selected : '' @endif>Unknown</option>
                                    </select>
									<span>@if ($errors->has('eyes')) {{ $errors->get('eyes')[0] }} @endif</span>
								 </div>
                                 <div class="form-group">
                                    <label for="InputNumber">Hair:</label>
									
									<select name="hair">
                                       <option @if($client->hair === 'Bald' || old('hair') === 'Bald') ? selected : '' @endif>Bald</option>
                                       <option @if($client->hair === 'Black' || old('hair') === 'Black') ? selected : '' @endif>Black</option>
                                       <option @if($client->hair === 'Blond or Strawberry' || old('hair') === 'Blond or Strawberry') ? selected : '' @endif>Blond or Strawberry</option>
									   <option @if($client->hair === 'Blue' || old('hair') === 'Blue') ? selected : '' @endif>Blue</option>
									   <option @if($client->hair === 'Brown' || old('hair') === 'Brown') ? selected : '' @endif>Brown</option>
									   <option @if($client->hair === 'Gray or Partially' || old('hair') === 'Gray or Partially') ? selected : '' @endif>Gray or Partially</option>
									   <option @if($client->hair === 'Green' || old('hair') === 'Green') ? selected : '' @endif>Green</option>
									   <option @if($client->hair === 'Orange' || old('hair') === 'Orange') ? selected : '' @endif>Orange</option>
									   <option @if($client->hair === 'Pink' || old('hair') === 'Pink') ? selected : '' @endif>Pink</option>
									   <option @if($client->hair === 'Purple' || old('hair') === 'Purple') ? selected : '' @endif>Purple</option>
									   <option @if($client->hair === 'Red or Auburn' || old('hair') === 'Red or Auburn') ? selected : '' @endif>Red or Auburn</option>
									   <option @if($client->hair === 'Sandy' || old('hair') === 'Sandy') ? selected : '' @endif>Sandy</option>
									   <option @if($client->hair === 'Unknown' || old('hair') === 'Unknown') ? selected : '' @endif>Unknown</option>
									   <option @if($client->hair === 'White' || old('hair') === 'White') ? selected : '' @endif>White</option>
									</select>
									<span>@if ($errors->has('hair')) {{ $errors->get('hair')[0] }} @endif</span>
								 </div>
                              </div>
                              <div class="general-info mt-5">
                                 <h4 class="mb-4">Application Status</h4>
                                 <div class="form-group">
                                    <label for="InputSelect">Status:</label>
                                    <select name="status">
                                       <option @if($client->status === 'Do Not Remote From USA' || old('status') === 'Do Not Remote From USA') ? selected : '' @endif value="">Do Not Remote From USA</option>
                                       <option @if($client->status === 'Valid' || old('status') === 'Valid') ? selected : '' @endif value="Valid">Valid</option>
                                       <option @if($client->status === 'In Valid' || old('status') === 'In Valid') ? selected : '' @endif value="In Valid">In Valid</option>
                                    </select>
									<span>@if ($errors->has('status')) {{ $errors->get('status')[0] }} @endif</span>
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

@section('script')
<script>

	$(document).ready( function () {
		$('input[class="btn btn-info"]').click(function(){
			let phone_no = $('input[name="phone"]').val()
			if(phone_no){
				if(phone_no.includes("+")){
					$('#confimation_model').modal('show');
					$('#modal-body-message').html(`Do you want send link on ${phone_no} .?`);
				}else{
					$.toast({
						  heading             : 'Error',
						  text                : "Please add country code",
						  loader              : true,
						  loaderBg            : '#fff',
						  showHideTransition  : 'fade',
						  icon                : 'error',
						  hideAfter           : 3000,
						  position            : 'top-right'
					});
				}
			}else{
				$.toast({
					  heading             : 'Error',
					  text                : "No phone no found!",
					  loader              : true,
					  loaderBg            : '#fff',
					  showHideTransition  : 'fade',
					  icon                : 'error',
					  hideAfter           : 3000,
					  position            : 'top-right'
				});
			}
		});
		
		
		$('button[class="btn btn-primary yes"]').click(function(){
			let phone_no = $('input[name="phone"]').val();
			$('input[name="send_sms"]').val(true);
			$('#confimation_model').modal('hide');
		});
	});
</script>
@endsection