@extends('layout.admin')

@section('style')
	<link rel="stylesheet" href="{{ url('admin/css/toggle.css') }}">
	<style>
	.breadcome-list {
		margin: 30px 0px 30px;
	}
	</style>
@endsection
@section('content')


         <div class="single-product-tab-area mg-t-0 mg-b-30">
            <div class="container-fluid">
                <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="review-tab-pro-inner">
                                
                                <div id="myTabContent" class="tab-content custom-product-edit">
                                    <div class="product-tab-list tab-pane fade active in" id="description">
										<div class="row">
											<div class="col-md-4 form-group">
												  <label>User name</label>
												  <span class="form-control">{{($user_voucher->user_detail->name) ? $user_voucher->user_detail->name : 'N/A'}}</span>
											</div>
											<div class="col-md-4 form-group">
												  <label>User email</label>
												  <span class="form-control">{{$user_voucher->user_detail->email}}</span>
											</div>
											<div class="col-md-4 form-group">
												  <label>Voucher</label>
												  <span class="form-control">{{$user_voucher->token_detail->token_name}}</span>
											</div>
											<div class="col-md-4 form-group">
												  <label>Amount</label>
												  <span class="form-control">{{$user_voucher->token_detail->amount}}</span>
											</div>
											<div class="col-md-4 form-group">
												  <label>Voucher Type</label>
												  <span class="form-control">{{$user_voucher->token_detail->type}}</span>
											</div>
											<div class="col-md-4 form-group">
												  <label>Status</label>
												  <span class="form-control">{{($user_voucher->status) ? 'Approve':'Disapprove '}}</span>
											</div>
										</div>
										<div class="row">
											<div class="col-md-6 form-group">
												  <img src="{{url($user_voucher->front_image)}}">
											</div>
											<div class="col-md-6 form-group">
												  <img src="{{url($user_voucher->back_image)}}">
											</div>
										</div>
										{{Form::open(['url'=>url('admin/membership-voucher-verify/'.encryptID($user_voucher->id)),'id'=>'general_form'])}}
										<div class="row">
                                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                <div class="text-center custom-pro-edt-ds">
													<input type="submit" name="submit" class="btn btn-ctl-bt waves-effect waves-light m-r-10" value="Verify" />
													<input type="submit" name="submit" class="btn btn-ctl-bt waves-effect waves-light m-r-10" value="Discard" />
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

@endsection