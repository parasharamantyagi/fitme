@extends('layout.admin')

@section('style')
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
                    <div class="col-lg-12">
						<div class="single-product-pr">
							@foreach($user_products as $user_product)
							<div class="row">
								<div class="col-lg-5 col-md-5 col-sm-5 col-xs-12">
									<div id="myTabContent1" class="tab-content">
										<div class="product-tab-list tab-pane fade active in" id="single-tab1">
											<img src="{{url(product_first_image($user_product->product->app_product_images))}}" alt="" style="height: 200px;width: 375px;" />
										</div>
									</div>
								</div>
								<div class="col-lg-7 col-md-7 col-sm-7 col-xs-12">
									<div class="single-product-details res-pro-tb">
										<h1>{{$user_product->product->Bra_name}}</h1>
										<div class="single-pro-price">
											<span class="single-regular">{{my_currecy($user_product->product->price)}}</span>
										</div>
										<div class="single-pro-size">
											<h6>Size</h6>
											<span>{{$user_product->product->Band_size_ID}}</span>
										</div>
										<div class="color-quality-pro">
											<div class="color-quality-details">
												<h5>Color</h5>
												<span style="background: {{$user_product->color}};"></span>
											</div>
											<div class="color-quality">
												<h4>Quality</h4>
												<div class="quantity">
													<div class="pro-quantity-changer">
														<input type="text" value="{{$user_product->quantity}}" style="background-color: #fff;" disabled />
													</div>
												</div>
											</div>
										</div>
										<div class="single-pro-cn" style="padding: 50px;"></div>
									</div>
								</div>
							</div>
							@endforeach
						</div>
					</div>
                </div>
            </div>
        </div>
		
		
		<div class="single-pro-review-area mt-t-30 mg-b-30">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12">
                    	<div class="single-tb-pr">
                    		<div class="row">
								<div class="col-md-6">
									<ul id="myTab" class="tab-review-design">
										<li class="active"><a href="#description">Name - {{($user_address->name) ? $user_address->name: 'N/A'}}</a></li>
									</ul>
								</div>
								<div class="col-md-6">
									<ul id="myTab" class="tab-review-design">
										<li class="active"><a href="#description">phone - {{($user_address->phone) ? $user_address->phone: 'N/A'}}</a></li>
									</ul>
								</div>
								<div class="col-md-12">
									<ul id="myTab" class="tab-review-design">
										<li class="active"><a href="#description">Address - {{($user_address->address) ? $user_address->address: 'N/A'}}</a></li>
									</ul>
									<ul id="myTab" class="tab-review-design">
										<li class="active"><a href="#description">Total amount - {{my_currecy($order->amount)}}</a></li>
									</ul>
								</div>
							</div>
                    	</div>
                    </div>
                </div>
            </div>
        </div>

@endsection