@extends('layout.admin')

@section('content')


         <div class="product-status mg-b-30">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="product-status-wrap">
                            <h4>User List</h4>
                            <div class="add-product">
                                <!-- a href="{{url('admin/add-product')}}">Add Product</a -->
                            </div>
                            <table>
                                <tr>
                                    <th>Sr. no </th>
                                    <th>name</th>
                                    <th>email</th>
                                    <th>phone</th>
                                    <th>dob</th>
                                    <th>gender</th>
									<th>Action</th>
                                </tr>
								@foreach($all_users as $key => $all_user)
                                <tr>
                                    <td>{{$key+1}}</td>
                                    <td>{{$all_user->name}}</td>
                                    <td>{{$all_user->email}}</td>
                                    <td>{{$all_user->phone}}</td>
                                    <td>{{($all_user->dob) ? $all_user->dob:'N/A'}}</td>
                                    <td>{{($all_user->gender) ? $all_user->gender:'N/A'}}</td>
                                    <td>
                                        <!-- button data-toggle="tooltip" title="Edit" class="pd-setting-ed"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></button -->
                                        <button data-toggle="tooltip" title="Trash" class="pd-setting-ed" onclick="deleteData({{$all_user->id}},'user_by_id')"><i class="fa fa-trash-o" aria-hidden="true"></i></button>
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