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
                            <h4>Instruction videos list</h4>
                            <div class="add-product">
                                <a href="{{url('admin/add-configuration')}}">Add Instruction videos</a>
                            </div>
                            <table>
                                <tr>
                                    <th>Sr. no </th>
                                    <th>Link</th>
									<th>Image</th>
									<th>Status</th>
                                    <th>Action</th>
                                </tr>
								@foreach($videos as $key => $video)
                                <tr>
                                    <td>{{$key+1}}</td>
                                    <td><a target="_blank" href="{{url($video->name)}}">{{$video->name}}</a></td>
									@if($video->thumb_image)
										<td><img src="{{url($video->thumb_image)}}" /></td>
									@else
										<td>N/A</td>
									@endif
									<td>
										<label class="toggleSwitch nolabel" onclick="">
											<input class="toggle-switch" data-type="video" data-id="{{$video->id}}" type="checkbox" @if($video->status) checked @endif/>
											<span>
												<span>OFF</span>
												<span>ON</span>
											</span>
											<a></a>
										</label>
                                    </td>
                                    <td>
                                        <button data-toggle="tooltip" title="Trash" class="pd-setting-ed" onclick="deleteData({{$video->id}},'video')"><i class="fa fa-trash-o" aria-hidden="true"></i></button>
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