@extends('layout.admin')
@section('style')
	<link rel="stylesheet" href="{{ url('admin/css/dropzone/dropzone.css') }}">
	<style>
	.breadcome-list {
		margin: 30px 0px 30px;
	}
	</style>
@endsection
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
									<!-- Multi Upload Start-->
									<div class="multi-uploaded-area mg-tb-15">
										<div class="container-fluid">
											<div class="row">
												<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
													<div class="dropzone-pro">
														<div id="dropzone">
															<form action="/admin/upload" class="dropzone dropzone-custom needsclick" id="demo-upload">
																{{ csrf_field() }}
																<div class="dz-message needsclick download-custom">
																	<i class="fa fa-cloud-download" aria-hidden="true"></i>
																	<h2>Drop files here or click to upload.</h2>
																	<p><span class="note needsclick">(This is just a demo dropzone. Selected files are <strong>not</strong> actually uploaded.)</span>
																	</p>
																</div>
															</form>
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
									<!-- Multi Upload End-->
									{{Form::open(['url'=>url($urlform),'id'=>'general_form'])}}
                                        <div class="row">
												<div class="col-md-12 form-group">
												  <label>Category</label>
												  <select name="cat_id" class="product-category form-control">
															<option value="0">Select category</option>
															@foreach($categories as $category)
																<option value="{{encryptID($category->id)}}" @if($category->id == $cat_id) selected @endif>{{$category->title}}</option>
															@endforeach
														</select>
												</div>
												@if($product_fields)
													@foreach($product_fields as $product_field)
													<div class="col-md-6 form-group">
													  <label>{{$product_field->label}}</label>
													  @if($product_field->field)
														<select name="{{$product_field->name}}" class="form-control">
															<option value="">Select {{$product_field->label}}</option>
															@if(isAssoc($product_field->field))
																@foreach($product_field->field as $array_key => $product_field_field)
																	<option value="{{$product_field_field}}" @if($product[$product_field->name] == $product_field_field) selected @endif>{{$array_key}}</option>
																@endforeach
															@else
																@foreach($product_field->field as $product_field_field)
																	<option value="{{$product_field_field}}" @if($product[$product_field->name] == $product_field_field) selected @endif>{{$product_field_field}}</option>
																@endforeach
															@endif
														</select>
													  @else
														<input class="form-control" name="{{$product_field->name}}" value="{{$product[$product_field->name]}}" type="text" aria-invalid="false">
													  @endif
													</div>
													@endforeach
												@endif
                                        </div>
										@if($cat_id === 6)
										@if($my_product->product_field)
										@foreach($my_product->product_field as $product_key => $productfield)
										<div class="row <?php echo ($product_key) ? 'child':'parent'; ?>">
											<input name="product_field_id[]" value="{{$productfield->id}}" type="hidden">
											<div class="col-md-3 form-group">
											  <label>Band size</label>
												<select name="Band_size_ID[]" class="form-control">
													<option value="">Select Band size</option>
													@foreach([24,26,28,30,32,34,36,38,40,42,44,46,48,50] as $band_size_ID)
														<option value="{{$band_size_ID}}"  @if($band_size_ID == $productfield->Band_size_ID) selected @endif>{{$band_size_ID}}</option>
													@endforeach
												</select>
											</div>
											<div class="col-md-3 form-group">
											  <label>Cup size</label>
												<select name="Cup_size_ID[]" class="form-control">
													<option value="">Select Cup size</option>
													@foreach(["AA","A","B","C","D","DD","E","F","FF","G","GG","H","HH","J","JJ","K"] as $cup_size_ID)
														<option value="{{$cup_size_ID}}"  @if($cup_size_ID == $productfield->Cup_size_ID) selected @endif>{{$cup_size_ID}}</option>
													@endforeach
												</select>
											</div>
											<div class="col-md-2 form-group">
												<label>Colour</label>
												<input class="form-control" name="color[]" value="{{$productfield->color}}" type="text" aria-invalid="false">
											</div>
											<div class="col-md-2 form-group">
												<label>Image</label>
												<input class="form-control" name="image[]" type="file" aria-invalid="false">
											</div>
											<div class="col-md-1 form-group">
												<label>Quantity</label>
												<input class="form-control" name="quantity[]" value="{{$productfield->quantity}}" type="text" aria-invalid="false">
											</div>
											<div class="col-md-1 form-group">
												<label>&nbsp;</label><br/>
												@if(!$product_key)
													<button type="button" data-toggle="tooltip" title="" class="pd-setting-ed plus-circle-button" data-original-title="Add"><i class="fa fa-plus-circle" aria-hidden="true"></i></button>
												@else
													<button type="button" data-toggle="tooltip" title="" class="pd-setting-ed minus-circle-button" data-original-title="Add"><i class="fa fa-minus-circle" aria-hidden="true"></i></button>
												@endif
											</div>
										</div>
										@endforeach
										@endif
										@endif
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

@section('script')
	<script src="{{ url('admin/js/wow.min.js') }}"></script>
	<script src="{{ url('admin/js/dropzone/dropzone.js') }}"></script>
@endsection