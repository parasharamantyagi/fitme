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
											@foreach($product->app_product_images as $product_image)
												<div class="col-md-{{(12/count($product->app_product_images))}} form-group">
													<img src="{{url($product_image->file_path)}}" class="form-control" alt="" style="height: 200px;width: 375px;" />
													<div class="row product_images_action">
														<div class="col-md-2 form-group">
														<label class="toggleSwitch nolabel" onclick="" style="margin-top: 5px;">
																<input class="toggle-switch" data-type="product_images" data-id="{{$product_image->id}}" type="checkbox"  @if($product_image->status) checked @endif/>
																<span>
																	<span>OFF</span>
																	<span>ON</span>
																</span>
																<a></a>
														</label>
														</div>
														<div class="col-md-4 form-group custom-pro-edt-ds">
														<button type="submit" class="btn btn-ctl-bt waves-effect waves-light m-r-10" onclick="deleteData({{$product_image->id}},'product_image')">Delete</button>
														</div>
													</div>
												</div>
											@endforeach
											<div class="col-md-4 form-group">
												  <label>{{$p_filed[0]}}</label>
												  <span class="form-control">{{$product->brand_name}}</span>
											</div>
											<div class="col-md-4 form-group">
												  <label>{{$p_filed[1]}}</label>
												  <span class="form-control">{{$product->Bra_type_ID}}</span>
											</div>
											<div class="col-md-4 form-group">
												  <label>{{$p_filed[2]}}</label>
												  <span class="form-control">{{$product->Band_size_ID}}</span>
											</div>
											<div class="col-md-4 form-group">
												  <label>{{$p_filed[15]}}</label>
												  <span class="form-control">{{$product->Bra_name}}</span>
											</div>
											<div class="col-md-4 form-group">
												  <label>{{$p_filed[16]}}</label>
												  <div class="form-control" style="background-color: black;">
													<span></span>
												  </div>
											</div>
											<div class="col-md-4 form-group">
												  <label>{{$p_filed[17]}}</label>
												  <span class="form-control">{{my_currecy($product->price)}}</span>
											</div>
										</div>
										
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
            </div>
        </div>
		
		
		

@endsection