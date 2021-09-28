@extends('layout.admin')

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
										@if($category->status)
											<button class="pd-setting">Active</button>
										@else
											<button class="ds-setting">Disabled</button>
										@endif
                                    </td>
                                    <td>{{$category->status}}</td>
                                    <td>
                                        <!-- button data-toggle="tooltip" title="Edit" class="pd-setting-ed"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></button -->
                                        <button data-toggle="tooltip" title="Trash" class="pd-setting-ed" onclick="deleteCategory({{$category->id}})"><i class="fa fa-trash-o" aria-hidden="true"></i></button>
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