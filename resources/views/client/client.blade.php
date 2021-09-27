@extends('layout.client')

@section('content')


         <div class="page-wrapper">
            <!-- ============================================================== -->
            <!-- Bread crumb and right sidebar toggle -->
            <!-- ============================================================== -->
            <div class="page-breadcrumb bg-white">
               <div class="row align-items-center">
                  <div class="col-lg-12 col-md-12 d-flex justify-content-between align-items-center">
                     <h3 class="page-title font-bold">Clients</h3>
                     <a href="client-add"><button class="custom-btn-col">Add New</button></a>
                  </div>
               </div>
               <!-- /.col-lg-12 -->
            </div>
            <div class="container-fluid">
               <div class="row data-table-custom-table m-0">
                  
                     <div class="col-md-12 p-0">
                    <div class="main-table-col box-shadow-none mt-0 pt-0">
                      <div class="table-responsive custom-res-table border-radius-8">
                          <table id="myTable" class="table calender-table mt-0 mb-0 client-table ">
                               <thead class="thead-dark">
                                 <tr>
                                   <th scope="col" style="width: 1px;"></th>
                                   <th scope="col">ID</th>
                                   <th scope="col">Name</th>
                                   <th scope="col">Address</th>
                                   <th scope="col">Status</th>
                                 </tr>
                               </thead>
                               <tbody>
								@foreach($users as $user)
                                 <tr>
                                   <td></td>
                                   <td><a class="detail-page user_id" href="client-detail/{{$user->user_id}}">{{$user->user_id}}</a></td>
                                   <td><a class="detail-page" href="client-detail/{{$user->user_id}}">{{$user->name}}</a></td>
                                   <td>{{$user->origin.' '.$user->eyes}}</td>
                                   <td><a class="custom-status-btn closed-btn" href="client-detail/{{$user->user_id}}">{{$user->status}}</td>
                                 </tr>
								@endforeach
                               </tbody>
                             </table>
                         </div>
                      </div>
                  </div>
              </div>
					 
				
                  </div>
              
              
            </div>
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