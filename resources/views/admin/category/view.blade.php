@extends('layout.admin')

@section('style')
	<link rel="stylesheet" href="{{ url('admin/css/toggle.css') }}">
@endsection
@section('content')


         <div class="product-status mg-b-30">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="product-status-wrap">
                            <h4>Category List</h4>
                            <div class="add-product">
                                <a href="{{url('admin/add-category')}}">Add Category</a>
                            </div>
                            <table>
                                <tr>
                                    <th>Sr. no </th>
                                    <th>Product Title</th>
                                    <th>Status</th>
                                    <th>Stock</th>
                                    <th>Setting</th>
                                </tr>
								@foreach($categories as $key => $category)
                                <tr>
                                    <td>{{$key+1}}</td>
                                    <td>{{$category->title}}</td>
                                    <td>
										<label class="toggleSwitch nolabel" onclick="">
											<input class="toggle-switch" data-type="category" data-id="{{$category->id}}" type="checkbox" @if($category->status) checked @endif/>
											<span>
												<span>OFF</span>
												<span>ON</span>
											</span>
											<a></a>
										</label>
                                    </td>
                                    <td>{{$category->stock}}</td>
                                    <td>
                                        <!-- button data-toggle="tooltip" title="Edit" class="pd-setting-ed"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></button -->
                                        <button data-toggle="tooltip" title="Trash" class="pd-setting-ed" onclick="deleteData({{$category->id}},'category')"><i class="fa fa-trash-o" aria-hidden="true"></i></button>
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