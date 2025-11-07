@extends('layouts.employee_dashboard')
@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Main content -->
        <div class="content px-4 ">
            <div class="container-fluid">
                <div class="pt-3">
                  <div class="col-md-12 text-right">
                      	<a href="{{ route('hrpayroll.employee.leaveApplication.create') }}" class="btn btn-sm btn-success">Leave Application Create</a>
                  </div>
                  <div class="text-center">
                    <h3 class="text-uppercase font-weight-bold">Naba Crop Care</h3>
                    <p>Head office, Rajshahi, Bangladesh</p>
                  </div>

                </div>
                <div class="py-4 table-responsive">
                    <div class="text-center">
                        <h5 class="text-uppercase font-weight-bold">Leave Application List</h5>

                        <hr>
                    </div>
                    <table id="example1" class="table table-bordered table-striped" style="font-size: 15px;">
                        <thead>
                            <tr class="text-center">
                                <th>SL.</th>
                                <th>Date</th>
                                <th>Request Day/Hours</th>
                                <th>Decription</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>


                          <tr>
                            <td>1</td>
                            <td>22-09-2023</td>
                            <td>2 Days</td>
                            <td>Prayer for 2 days leave for personal task</td>
                            <td><span class="badge p-2 badge-primary">Pending</span></td>
                            <td class="text-center">
                                <a href="#"
                                    class="btn btn-xs btn-info my-1" data-toggle="tooltip" data-placement="top" title="Application Edit"><i class="far fa-edit "></i></a>
                                <a class="btn btn-xs btn-danger " href="" data-toggle="modal" data-target="#delete"
                                                data-myid="#"><i class="far fa-trash-alt"></i> </a>
                            </td>
                          </tr>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
