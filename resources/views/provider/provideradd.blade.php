@extends('layout.client')

@section('content')


         <div class="page-wrapper">
            <!-- ============================================================== -->
            <!-- Bread crumb and right sidebar toggle -->
            <!-- ============================================================== -->
			{{Form::open(['url'=>url($pageData['form_action']),'id'=>'general_form'])}}
            <div class="page-breadcrumb bg-white">
               <div class="row align-items-center">
                  <div class="col-md-12 d-flex justify-content-between align-items-center">
                     <h3 class="page-title font-bold">{{$pageData['title']}}</h3>
                     <button class="custom-btn-col">Save</button>
                  </div>
               </div>
            </div>
            <div class="client-detail-page mb-5 mt-5">
               <div class="container-detail">
					<div class="row">
                     <div class="col-md-6">
                        <div class="user-detail">
                              <div class="general-info">
                                 <div class="form-group">
                                    <div class="d-flex">
                                    <label for="InputEmail1">Company Name:</label>
                                    <div class="w-100">
                                       <input type="name" class="form-control" name="name" value="{{ (old('name')) ? old('name') : $client->name}}" id="name" aria-describedby="nameHelp">
                                       <span>@if ($errors->has('name')) {{ $errors->get('name')[0] }} @endif</span>
                                    </div>
                                 </div>
									
								 </div>
                                 <div class="form-group">
                                    <div class="d-flex">
                                       <label for="InputEmail1">Contact:</label>
                                       <div class="w-100">
                                          <input type="name" class="form-control" name="contact" value="{{ (old('contact')) ? old('contact') : $client->contact}}" id="name" aria-describedby="nameHelp">
                                       <span>@if ($errors->has('contact')) {{ $errors->get('contact')[0] }} @endif</span>
                                       </div>
                                    </div>
								 </div>
                                 <div class="form-group">
                                 <div class="d-flex">
                                    <label for="InputNumber">Phone:</label>
                                    <div class="w-100">
                                       <input type="number" class="form-control" name="phone_no" value="{{ (old('phone_no')) ? old('phone_no') : $client->phone}}" id="InputNumber" aria-describedby="phone Help">
                                       <span>@if ($errors->has('phone_no')) {{ $errors->get('phone_no')[0] }} @endif</span>
                                    </div>
                                 </div>
								 </div>
                                 <div class="form-group">
                                 <div class="d-flex">
                                    <label for="InputNumber">Email:</label>
                                    <div class="w-100">
                                       <input type="email" class="form-control" name="email" value="{{ (old('email')) ? old('email') : $client->email}}" id="InputEmail" aria-describedby="Email Help">
                                       <span>@if ($errors->has('email')) {{ $errors->get('email')[0] }} @endif</span>
                                    </div>
                                 </div>
								</div>
                              </div>
                              <div class="general-info mt-5">
                                 <h4 class="mb-4">Mailing Address</h4>
                                 <div class="form-group">
                                    <div class="d-flex">
                                    <label for="InputName">Address:</label>
                                    <div class="w-100">
                                       <input type="text" class="form-control" name="mailing_address" value="{{(old('mailing_address')) ? old('mailing_address') : $client->mailing_address}}" id="InputEmail1" aria-describedby="textName">
									   <span>@if ($errors->has('mailing_address')) {{ $errors->get('mailing_address')[0] }} @endif</span>
									</div>
                                 </div>
                                 </div>
                                 <div class="inputs-inline">
                                       <div class="form-group city-name">
                                       <div class="d-flex">
                                          <label for="InputName">City:</label>
                                          <input type="text" class="form-control" name="mailing_city" value="{{(old('mailing_city')) ? old('mailing_city') : $client->mailing_city}}" id="InputEmail1" aria-describedby="textName">
                                       </div>
                                       </div>  
                                       <div class="form-group state">
                                       <div class="d-flex">
                                          <span>State:</span>
                                          <input type="text" class="form-control" name="mailing_state" value="{{(old('mailing_state')) ? old('mailing_state') : $client->mailing_state}}" id="InputEmail1" aria-describedby="textName">
                                       </div>
                                       </div>   
                                    <div class="form-group zip">
                                    <div class="d-flex">
                                       <span>Zip:</span>
                                       <input type="number" class="form-control" name="mailing_zip" value="{{(old('mailing_zip')) ? old('mailing_zip') : $client->mailing_zip}}" id="InputNumber" aria-describedby="emailHelp">
                                    </div>
                                    </div>
                                 </div>
								 <div class="form-group">
								 <span>@if ($errors->has('mailing_city')) {{ $errors->get('mailing_city')[0] }} @endif</span>
								 <span>@if ($errors->has('mailing_state')) {{ $errors->get('mailing_state')[0] }} @endif</span>
								 <span>@if ($errors->has('mailing_zip')) {{ $errors->get('mailing_zip')[0] }} @endif</span>
								 </div>
                              </div>
                              <div class="general-info mt-5">
                                 <h4 class="mb-4">Shiping Address</h4>
								 <div class="form-group">
                                    <div class="d-flex">
                                    <label for="InputName">Address:</label>
                                    <div class="w-100">
                                       <input type="text" class="form-control" name="shiping_address" value="{{(old('shiping_address')) ? old('shiping_address') : $client->shiping_address}}" id="InputEmail1" aria-describedby="textName">
									<span>@if ($errors->has('shiping_address')) {{ $errors->get('shiping_address')[0] }} @endif</span>
									</div>
                                 </div>
                                 </div>
								 
								 
                                 <div class="inputs-inline">
                                       <div class="form-group city-name">
                                       <div class="d-flex">
                                          <label for="InputName">City:</label>
                                          <input type="text" class="form-control" name="shiping_city" value="{{(old('shiping_city')) ? old('shiping_city') : $client->shiping_city}}" id="InputEmail1" aria-describedby="textName">
                                       </div>
                                       </div>  
                                       <div class="form-group state">
                                       <div class="d-flex">
                                          <span>State:</span>
                                          <input type="text" class="form-control" name="shiping_state" value="{{(old('shiping_state')) ? old('shiping_state') : $client->shiping_state}}" id="InputEmail1" aria-describedby="textName">
                                       </div>
                                       </div>   
                                    <div class="form-group zip">
                                    <div class="d-flex">
                                       <span>Zip:</span>
                                       <input type="number" class="form-control" name="shiping_zip" value="{{(old('shiping_zip')) ? old('shiping_zip') : $client->shiping_zip}}" id="InputNumber" aria-describedby="emailHelp">
                                    </div>
                                    </div>
                                 </div>
								 <div class="form-group">
								 <span>@if ($errors->has('shiping_city')) {{ $errors->get('shiping_city')[0] }} @endif</span>
								 <span>@if ($errors->has('shiping_state')) {{ $errors->get('shiping_state')[0] }} @endif</span>
								 <span>@if ($errors->has('shiping_zip')) {{ $errors->get('shiping_zip')[0] }} @endif</span>
								 </div>
                              </div>
                           
                        </div>
                     </div>
                     <div class="col-md-5">
                        <div class="general-info ml-md-4 ml-0">
                           <div class="form-group">
                              <div class="d-flex">
                                    <label for="InputName">Status:</label>
                                    <select name="status">
                                       <option value="Active" @if($client->status === 'Active') ? selected : '' @endif>Active</option>
                                       <option value="Deactive" @if($client->status === 'Deactive') ? selected : '' @endif>Deactive</option>
                                    </select>
                              </div>
                                 </div><div class="form-group city-name">
                                       <div class="d-flex">
                                          <label for="InputName">Card Rate:</label>
                                          <div class="w-100">
                                             <input type="number" class="form-control" name="card_rate" value="{{(old('card_rate')) ? old('card_rate') : $client->card_rate}}" id="InputEmail1" aria-describedby="textName" step="0.01" placeholder="$0000">
                                             <span>@if ($errors->has('card_rate')) {{ $errors->get('card_rate')[0] }} @endif</span>
                                          </div>
                                          </div>
									  </div> 
                                 <div class="form-group">
                                 <div class="d-flex">
                                    <label for="InputName">Terms:</label>
                                    <select>
                                       <option>Invoice</option>
                                       <option>Voice</option>
                                    </select>
                                 </div>
                                 </div>
                              </div>              
                     </div>
                  </div>
               </div>
            </div>
			{{Form::close()}}
            
            <!-- ============================================================== -->
            <!-- End Container fluid  -->
            <!-- ============================================================== -->
            <!-- ============================================================== -->
            <!-- footer -->
            <!-- ============================================================== -->
            <footer class="footer text-center"> 2021 © USCIS <a
               href="#">uscis.com</a>
            </footer>
            <!-- ============================================================== -->
            <!-- End footer -->
            <!-- ============================================================== -->
         </div>
        

@endsection