@extends('layout.admin')

@section('content')


         <div class="product-status mg-b-30">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="product-status-wrap">
                            <h4>Order List</h4>
                            <div class="add-product">
                                <!-- a href="{{url('admin/add-product')}}">Add Product</a -->
                            </div>
                            <table>
                                <tr>
                                    <th>Sr. no </th>
                                    <th>name</th>
                                    <th>email</th>
                                    <th>phone</th>
                                    <th>Amount</th>
									<th>Action</th>
                                </tr>
								@foreach($all_Orders as $key => $all_Order)
                                <tr>
                                    <td>{{$key+1}}</td>
                                    <td>{{($all_Order->name) ? $all_Order->name: 'N/A'}}</td>
                                    <td>{{$all_Order->email}}</td>
                                    <td>{{($all_Order->phone) ? $all_Order->phone:'N/A' }}</td>
                                    <td>{{my_currecy($all_Order->amount)}}</td>
                                    <td>
                                        <button data-toggle="tooltip" title="View detail" class="pd-setting-ed" onclick="editData('{{encryptID($all_Order->id)}}','order-detail')"><i class="fa fa-eye" aria-hidden="true"></i></button>
                                     </td>
                                </tr>
								@endforeach
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

@endsection