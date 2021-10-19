@extends('layout.admin')

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
											<img src="{{url('products/logo.jpg')}}" alt="" style="height: 200px;" />
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
												<span class="red"></span> <span class="green"></span> <span class="yellow"></span> <span class="black"></span> <span class="white"></span>
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
								<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
									<ul id="myTab" class="tab-review-design">
										<li class="active"><a href="#description">Total amount - {{$order->amount}}</a></li>
									</ul>
								</div>
							</div>
                    	</div>
                    </div>
                </div>
            </div>
        </div>

@endsection