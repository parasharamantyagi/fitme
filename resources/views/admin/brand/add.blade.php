@extends('layout.admin')
@section('style')
	
	<style>
	label.extra-filed {
		height: 38px;
	}
	button.form-control.btn.btn-ctl-bt.waves-effect.waves-light.m-r-10 {
		width: 22%;
		border-radius: 3px;
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
										</div>
										
										@if($product_fields)
										{{Form::open(['url'=>url($urlform),'id'=>'general_form'])}}
										<div class="row">
											<div class="col-md-6 form-group">
												<label>{{$title}}</label>
												<input class="form-control" name="name" value="" type="text" aria-invalid="false">
												<input name="cat_id" value="{{$cat_id}}" type="hidden">
											</div>
											<div class="col-md-6 form-group">
												<label>&nbsp;</label>
												<button type="submit" class="form-control btn btn-ctl-bt waves-effect waves-light m-r-10">Save</button>
											</div>
										</div>
										{{Form::close()}}
										<div class="row">
											<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
												<div class="product-status-wrap">
													<table>
															@foreach($product_fields->field as $product_key => $product_val)
															<tr>
																<td>{{$product_val}}</td>
																<td><button data-toggle="tooltip" title="" class="pd-setting-ed" onclick="deleteData('{{json_encode(array($product_val,$cat_id))}}','brand_delete')" data-original-title="Trash"><i class="fa fa-trash-o" aria-hidden="true"></i></button></td>
															</tr>
															@endforeach
													</table>
												</div>
											</div>
                                        </div>
										@endif
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

@endsection