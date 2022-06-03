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
									{{Form::open(['url'=>url($form_url),'id'=>'general_form'])}}
                                        <div class="row">
												<div class="col-md-6 form-group">
												  <label>Token</label>
												  <input class="form-control" name="token_name" type="text" value="{{$token['token_name']}}" aria-invalid="false" required>
												</div>
												<div class="col-md-6 form-group">
												  <label>Amount</label>
													<input class="form-control" name="amount" type="text" value="{{$token['amount']}}" aria-invalid="false" required>
												</div>
                                        </div>
										<div class="row">
												<div class="col-md-6 form-group">
												  <label>Type</label>
													<select name="type" class="form-control" aria-invalid="false" required>
														<option value="">Select type</option>
														<option value="percentage" @if($token['type'] == 'percentage') selected @endif>Percentage</option>
														<option value="fixed" @if($token['type'] == 'fixed') selected @endif>Fixed</option>
													</select>
												</div>
												<div class="col-md-6 form-group">
												  <label>Valid to</label>
												  <input class="form-control" name="valid_to" type="date" value="{{$token['valid_to']}}" min="{{$current_date}}" aria-invalid="false">
												</div>
                                        </div>
										<div class="row">
												<div class="col-md-6 form-group">
												  <label>Image</label>
												  <input class="form-control" name="image" type="file" aria-invalid="false">
												</div>
                                        </div>
										<div class="row">
												<div class="col-md-6 form-group">
												  <label>Misapplying message</label>
												  <input class="form-control" name="misapplying_message" type="text" value="{{$token['misapplying_message']}}" aria-invalid="false" required>
												</div>
												<div class="col-md-6 form-group">
												  <label>Applying message</label>
												  <input class="form-control" name="applying_message" type="text" value="{{$token['applying_message']}}" aria-invalid="false" required>
												</div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                <div class="text-center custom-pro-edt-ds">
                                                    <button type="submit" class="btn btn-ctl-bt waves-effect waves-light m-r-10">Save</button>
                                                    <button type="button" class="btn btn-ctl-bt waves-effect waves-light">Discard</button>
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