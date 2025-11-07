@extends('layouts.hrPayroll_dashboard')

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Main content -->
        <div class="content px-4 ">
            <div class="container-fluid">
                <div class="pt-3">
                  <div class="col-md-12 text-right">
                    <a href="{{route('hrpayroll.time.attendance.employeeWisePolicyAssign.create')}}" class="btn btn-sm btn-success">Leave Policy Assign</a>
                      <!-- <a href="{{route('hrpayroll.time.attendance.lateManage.prority.list')}}" class="btn btn-sm btn-success">Deducted Leave Type Prorities</a> -->
                  </div>
                  <div class="text-center">
                    <h3 class="text-uppercase font-weight-bold">Naba Crop Care</h3>
                    <p>Head office, Rajshahi, Bangladesh</p>
                  </div>

                </div>
                <div class="py-4 table-responsive">
                    <div class="text-center">
                        <h5 class="text-uppercase font-weight-bold">Employee Wise Policy List</h5>

                        <hr>
                    </div>
                    <table id="example1" class="table table-bordered table-striped" style="font-size: 15px;">
                        <thead>
                            <tr class="text-center">
                                <th>SL.</th>
                                <th>Name</th>
                                <th>Leave Policy</th>
                                <!-- <th>Status </th> -->
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>


                                <tr>
                                    <td>1</td>
                                    <td>Mr Aminul Islam</td>
                                    <td> Policy-1, Policy-3, Policy-4, Policy-6</td>


                                    <!-- <td> <span class="btn btn-success btn-xs" data-toggle="tooltip" data-placement="top" title="Approved">Approved</span></td> -->
                                    <td class="text-center">
                                        <a href="#"
                                            class="btn btn-xs btn-info my-1" data-toggle="tooltip" data-placement="top" title="Employee Edit"><i class="far fa-edit "></i></a>

                                        <a class="btn btn-xs btn-danger " href="" data-toggle="modal" data-target="#delete"
                                                        data-myid=""><i class="far fa-trash-alt"></i> </a>
                                    </td>
                                </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
