@extends('layout.admin')

@section('content')

	<div class="single-product-tab-area mg-b-30">
            <!-- Single pro tab review Start-->
            <div class="single-pro-review-area">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="review-tab-pro-inner">
                                
                                <div id="myTabContent" class="tab-content custom-product-edit">
                                    <div class="product-tab-list tab-pane fade active in" id="description">
									{{Form::open(['url'=>url('admin/add-user'),'id'=>'general_form'])}}
                                        <div class="row">
												<div class="col-md-6 form-group">
												  <label>Name</label>
												  <input class="form-control" name="name" type="text" aria-invalid="false">
												</div>
												<div class="col-md-6 form-group">
												  <label>Roll</label>
												  <select name="roll_id" class="form-control">
														<option value="">Select roll</option>
														<option value="3">Roll 3</option>
														<option value="4">Roll 4</option>
													</select>
												</div>
                                        </div>
										<div class="row">
												<div class="col-md-6 form-group">
												  <label>Email</label>
												  <input class="form-control" name="email" type="text" aria-invalid="false">
												</div>
												<div class="col-md-6 form-group">
												  <label>Password</label>
												  <input class="form-control" name="password" type="text" aria-invalid="false">
												</div>
                                        </div>
										<div class="row">
												<div class="col-md-6 form-group">
												  <label>Dob</label>
												  <input class="form-control" name="dob" type="date" aria-invalid="false">
												</div>
												<div class="col-md-6 form-group">
												  <label>Gender</label>
												  <select name="gender" class="form-control">
														<option value="">Select gender</option>
														<option value="male">Male</option>
														<option value="female">Female</option>
													</select>
												</div>
                                        </div>
										<div class="row">
												<div class="col-md-6 form-group">
												  <label>Address</label>
												  <input class="form-control" name="address" type="text" aria-invalid="false">
												</div>
												<div class="col-md-6 form-group">
												  <label>Phone</label>
												  <input class="form-control" name="phone" type="text" aria-invalid="false">
												</div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                <div class="text-center custom-pro-edt-ds">
                                                    <button type="submit" class="btn btn-ctl-bt waves-effect waves-light m-r-10">Save
														</button>
                                                    <button type="button" class="btn btn-ctl-bt waves-effect waves-light">Discard
														</button>
                                                </div>
                                            </div>
                                        </div>
										{{Form::close()}}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

@endsection