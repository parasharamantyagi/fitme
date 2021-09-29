@extends('layout.admin')

@section('content')


         <div class="product-status mg-b-30">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="product-status-wrap">
                            <h4>Product List</h4>
                            <div class="add-product">
                                <a href="{{url('admin/add-product')}}">Add Product</a>
                            </div>
                            <table>
                                <tr>
                                    <th>Sr. no </th>
                                    <th>Image</th>
                                    <th>name</th>
                                    <th>Category</th>
                                    <th>Status</th>
                                    <th>Quantity</th>
                                    <th>Setting</th>
                                </tr>
								@foreach($products as $key => $product)
                                <tr>
                                    <td>{{$key+1}}</td>
                                    <td><img src="{{'./../'.$product->image}}" alt=""></td>
                                    <td>{{$product->name}}</td>
                                    <td>{{$product->title}}</td>
                                    <td>
										@if($product->quantity)
											<button class="pd-setting">Active</button>
										@else
											<button class="ds-setting">Disabled</button>
										@endif
                                    </td>
                                    <td>{{$product->quantity}}</td>
                                    <td>
                                        <button data-toggle="tooltip" title="Edit" class="pd-setting-ed" onclick="editData({{$product->id}},'add-product')"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></button>
                                        <button data-toggle="tooltip" title="Trash" class="pd-setting-ed" onclick="deleteData({{$product->id}},'product')"><i class="fa fa-trash-o" aria-hidden="true"></i></button>
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