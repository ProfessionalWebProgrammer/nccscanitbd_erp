@extends('layouts.hrPayroll_dashboard')
@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Main content -->
        <div class="content px-4 ">
            <div class="container-fluid">
                <div class="pt-3">
                  <div class="col-md-12 text-right">
                        <a href="{{route('hrpayroll.time.attendance.lateManage.prority.create')}}" class="btn btn-sm btn-success">Employee Deducted Leave Prority Create </a>
                      	<a href="{{route('hrpayroll.time.attendance.lateManage.list')}}" class="btn btn-sm btn-success">Employee Late Policy </a>
                  </div>
                  <div class="text-center">
                    <h3 class="text-uppercase font-weight-bold">Naba Crop Care</h3>
                    <p>Head office, Rajshahi, Bangladesh</p>
                  </div>

                </div>
                <div class="py-4 table-responsive">
                    <div class="text-center">
                      <h5 class="text-uppercase font-weight-bold">Employee Late Policy List</h5>
                      <hr>
                    </div>
                    <table id="example1" class="table table-bordered table-striped" style="font-size: 15px;">
                        <thead>
                          <tr class="text-center">
                              <th>SL.</th>
                              <th>Head</th>
                              <th>Description</th>
                              <th>Action</th>
                          </tr>
                        </thead>
                        <tbody>
                          @for($i = 1; $i <= 7; $i++)
                                <tr>
                                    <td>{{$i}}</td>
                                    <td>Prority {{$i}}</td>
                                    <td>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</td>
                                    <td class="text-center">
                                        <a href="#"
                                            class="btn btn-xs btn-info my-1" data-toggle="tooltip" data-placement="top" title="Employee Edit"><i class="far fa-edit "></i></a>

                                        <a class="btn btn-xs btn-danger " href="" data-toggle="modal" data-target="#delete"
                                                        data-myid=""><i class="far fa-trash-alt"></i> </a>
                                    </td>
                                </tr>
                          @endfor
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
