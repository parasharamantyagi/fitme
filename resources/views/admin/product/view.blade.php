@extends('layout.admin')
@section('style')
	<style>
	select.product-category.list.form-control {
		width: 20%;
		height: 34px;
		margin: 2px;
		border-radius: 3px;
	}
	</style>
@endsection
@section('content')


         <div class="product-status mg-b-30">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="product-status-wrap">
                            <select name="cat_id" class="product-category list form-control">
								<option value="0">Select category</option>
								@foreach($categories as $category)
									<option value="{{encryptID($category->id)}}" @if($category->id == $cat_id) selected @endif>{{$category->title}}</option>
								@endforeach
							</select>
                            <div class="add-product">
                                <a href="{{url('admin/add-product')}}">Add Product</a>
                            </div>
                            <table>
								@if($label_of_fileds)
                                <tr>
                                    <th>Sr. no </th>
                                    <th>{{$label_of_fileds[0]}}</th>
                                    <th>{{$label_of_fileds[1]}}</th>
                                    <th>{{$label_of_fileds[2]}}</th>
                                    <th>{{$label_of_fileds[3]}}</th>
                                    <th>{{$label_of_fileds[4]}}</th>
                                    <th>Setting</th>
                                </tr>
								@foreach($products as $key => $product)
                                <tr>
                                    <td>{{$key+1}}</td>
                                    <td>{{$product[$name_of_fileds[0]]}}</td>
                                    <td>{{$product[$name_of_fileds[1]]}}</td>
                                    <td>{{$product[$name_of_fileds[2]]}}</td>
                                    <td>{{$product[$name_of_fileds[3]]}}</td>
                                    <td>{{$product[$name_of_fileds[4]]}}</td>
                                    <td>
                                        <!-- button data-toggle="tooltip" title="Edit" class="pd-setting-ed" onclick="editData({{$product['id']}},'add-product')"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></button -->
                                        <button data-toggle="tooltip" title="Trash" class="pd-setting-ed" onclick="deleteData({{$product['id']}},'product')"><i class="fa fa-trash-o" aria-hidden="true"></i></button>
                                    </td>
                                </tr>
								@endforeach
								@endif
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

@endsection