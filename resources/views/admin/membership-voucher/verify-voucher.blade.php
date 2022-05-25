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
                            <h4>Membership List</h4>
                            <div class="add-product">
                                <a href="{{url('admin/add-token')}}">Add Token</a>
                            </div>
                            <table>
                                <tr>
                                    <th>Sr. no </th>
									<th>Email</th>
                                    <th>Token</th>
                                    <th>Amount</th>
                                    <th>Type</th>
                                    <th>Valid to</th>
                                    <th>Detail</th>
                                </tr>
								@foreach($tokens as $key => $token)
                                <tr>
                                    <td>{{$key+1}}</td>
									<td>{{$token->email}}</td>
                                    <td>{{$token->token_name}}</td>
                                    <td>{{$token->amount}}</td>
									<td>{{$token->type}}</td>
									<td>{{$token->valid_to}}</td>
                                    <td>
										<button data-toggle="tooltip" title="Detail" class="pd-setting-ed" onclick="editData('{{encryptID($token->id)}}','membership-voucher-detail')"><i class="fa fa-eye" aria-hidden="true"></i></button>
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