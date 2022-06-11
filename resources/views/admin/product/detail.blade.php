@extends('layout.admin')

@section('style')
	<link rel="stylesheet" href="{{ url('admin/css/toggle.css') }}">
	<style>
	.breadcome-list {
		margin: 30px 0px 30px;
	}
	label.toggleSwitch.nolabel {
		float: right;
		margin: 4px 25px;
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
											<div class="breadcomb-ctn">
												<h2>Product image</h2>
											</div>
											@foreach($product->product_images as $product_image)
												<div class="col-md-{{(12/count($product->product_images))}} form-group">
													<img src="{{app_file_url($product_image->file_path)}}" class="form-control" alt="" style="height: 200px;width: 375px;" />
													<div class="row product_images_action">
														<div class="col-md-2 form-group">
														<label class="toggleSwitch nolabel" onclick="">
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
											</div>
											<div class="breadcomb-ctn">
												<h2>Extra image</h2>
												@foreach($product->admin_product_field as $productfield)
												<div class="row">
												<div class="col-md-4 form-group">
													<label>{{$productfield->color}}</label>
													<img src="{{app_file_url($productfield->image)}}" class="form-control" alt="" style="height: 200px;width: 375px;" />
													<div class="row product_images_action">
														<label class="toggleSwitch nolabel" onclick="">
																<input class="toggle-switch" data-type="product_field_image" data-id="{{$productfield->id}}" type="checkbox"  @if($productfield->status) checked @endif/>
																<span>
																	<span>OFF</span>
																	<span>ON</span>
																</span>
																<a></a>
														</label>
														<div class="col-md-4 form-group custom-pro-edt-ds">
														<button type="submit" class="btn btn-ctl-bt waves-effect waves-light m-r-10" onclick="deleteData({{$productfield->id}},'product_image')">Delete</button>
														</div>
													</div>
												</div>
												@foreach($productfield->admin_product_field_images as $productFieldImages)
													<div class="col-md-3 form-group">
															<label>{{$productfield->color}} (Sub image)</label>
															<img src="{{app_file_url($productFieldImages->file_path)}}" class="form-control" alt="" style="height: 200px;width: 375px;" />
															<div class="row product_images_action">
															<label class="toggleSwitch nolabel" onclick="">
																	<input class="toggle-switch" data-type="product_images" data-id="{{$productFieldImages->id}}" type="checkbox"  @if($productFieldImages->status) checked @endif/>
																	<span>
																		<span>OFF</span>
																		<span>ON</span>
																	</span>
																	<a></a>
															</label>
															<div class="col-md-4 form-group custom-pro-edt-ds">
															<button type="submit" class="btn btn-ctl-bt waves-effect waves-light m-r-10" onclick="deleteData({{$productFieldImages->id}},'product_image')">Delete</button>
															</div>
															</div>
														</div>
												@endforeach
												</div>
											@endforeach
											</div>
											<div class="row">
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
												  <label>price</label>
												  <span class="form-control">{{my_currecy($product->price)}}</span>
											</div>
										</div>
										<label>Color</label>
										{{Form::open(['url'=>url('admin/product-multi-images'),'id'=>'general_form'])}}
										<input class="form-control" name="product_id" type="hidden" value="{{$product->id}}">
										@foreach($product->product_field as $productField)
										<div class="row parent_{{$productField->id}}">
											<div class="col-md-4 form-group">
												  <span class="form-control color_{{$productField->id}}">{{$productField->color}}</span>
											</div>
											<div class="col-md-4 form-group">
												 <input class="form-control" name="productField_id[]" type="hidden" value="{{$productField->id}}">
												 <input class="form-control" name="images[]" type="file" aria-invalid="false">
											</div>
											<div class="col-md-4 form-group">
												 <button type="button" data-toggle="tooltip" data-id="{{$productField->id}}" title="" class="pd-setting-ed plus-circle-button-multi_image" data-original-title="Add"><i class="fa fa-plus-circle" aria-hidden="true"></i></button>
											</div>
										</div>
										@endforeach
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
		
		
		

@endsection