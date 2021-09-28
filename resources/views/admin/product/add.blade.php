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
									{{Form::open(['url'=>url('admin/add-product'),'id'=>'general_form'])}}
                                        <div class="row">
												<div class="col-md-6 form-group">
												  <label>name</label>
												  <input class="form-control" name="name" type="text" aria-invalid="false">
												</div>
												<div class="col-md-6 form-group">
												  <label>Image</label>
												  <input class="form-control" name="image" type="file" aria-invalid="false">
												</div>
                                        </div>
										<div class="row">
												<div class="col-md-6 form-group">
												  <label>Category</label>
												  <select name="cat_id" class="form-control">
															<option value="0">Select category</option>
															@foreach($categories as $category)
																<option value="{{$category->id}}">{{$category->title}}</option>
															@endforeach
														</select>
												</div>
												<div class="col-md-6 form-group">
												  <label>Quantity</label>
												  <input class="form-control" name="quantity" type="text" aria-invalid="false">
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