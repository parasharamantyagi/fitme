@extends('layout.admin')

@section('content')


         <div class="single-product-tab-area mg-t-0 mg-b-30">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12">
						<div class="single-product-pr">
							<div class="row">
								<div class="col-lg-5 col-md-5 col-sm-5 col-xs-12">
									<div id="myTabContent1" class="tab-content">
										<div class="product-tab-list tab-pane fade active in" id="single-tab1">
											<img src="{{url('products/logo.jpg')}}" alt="" />
										</div>
										<div class="product-tab-list tab-pane fade" id="single-tab2">
											<img src="{{url('products/logo.jpg')}}" alt="" />
										</div>
										<div class="product-tab-list tab-pane fade" id="single-tab3">
											<img src="{{url('products/logo.jpg')}}" alt="" />
										</div>
										<div class="product-tab-list tab-pane fade" id="single-tab4">
											<img src="{{url('products/logo.jpg')}}" alt="" />
										</div>
										<div class="product-tab-list tab-pane fade" id="single-tab5">
											<img src="{{url('products/logo.jpg')}}" alt="" />
										</div>
									</div>
									<!-- ul id="single-product-tab">
										<li class="active">
											<a href="#single-tab1"><img src="{{url('products/logo.jpg')}}" alt="" /></a>
										</li>
										<li>
											<a href="#single-tab2"><img src="{{url('products/logo.jpg')}}" alt="" /></a>
										</li>
										<li>
											<a href="#single-tab3"><img src="{{url('products/logo.jpg')}}" alt="" /></a>
										</li>
										<li>
											<a href="#single-tab4"><img src="{{url('products/logo.jpg')}}" alt="" /></a>
										</li>
									</ul -->
								</div>
								<div class="col-lg-7 col-md-7 col-sm-7 col-xs-12">
									<div class="single-product-details res-pro-tb">
										<h1>Product ITEM TITLE</h1>
										<span class="single-pro-star">
											<i class="fa fa-star"></i>
											<i class="fa fa-star"></i>
											<i class="fa fa-star"></i>
											<i class="fa fa-star"></i>
											<i class="fa fa-star"></i>
										</span>
										<div class="single-pro-price">
											<span class="single-regular">$150.00</span><span class="single-old"><del>$20.00</del></span>
										</div>
										<div class="single-pro-size">
											<h6>Size</h6>
											<span>S</span> <span>M</span> <span>L</span> <span>XL</span> <span>XXL</span>
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
														<input type="text" value="1" style="background-color: #fff;" disabled />
													</div>
												</div>
											</div>
										</div>
										<!-- div class="single-pro-cn">
											<h3>OVERVIEW</h3>
											<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
												consequat. Duis aute irure dolor in reprehenderit in voluptate </p>
										</div -->
									</div>
								</div>
							</div>
						</div>
					</div>
                </div>
            </div>
        </div>

@endsection