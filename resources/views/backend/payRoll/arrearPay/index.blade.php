@extends('layouts.hrPayroll_dashboard')

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Main content -->
        <div class="content px-4 ">
            <div class="container-fluid">
                <div class="pt-3">
                  <div class="col-md-12 text-right">
                      <a href="{{route('hrpayroll.employee.arrearPayment.create')}}" class="btn btn-sm btn-success">Arrear Payment Create</a>
                  </div>
                  <div class="text-center">
                    <h3 class="text-uppercase font-weight-bold">Naba Crop Care</h3>
                    <p>Head office, Rajshahi, Bangladesh</p>
                  </div>

                </div>
                <div class="py-4 table-responsive">
                    <div class="text-center">
                        <h5 class="text-uppercase font-weight-bold">Employee Arrear Payment List</h5>

                        <hr>
                    </div>
                    <table id="example1" class="table table-bordered table-striped" style="font-size: 15px;">
                        <thead>
                            <tr class="text-center">
                                <th>SL.</th>
                                <th>Date </th>
                                <th>Arrear Date </th>
                                <th>Name </th>
                                <th>Amount</th>
                                <th>Payment By</th>
                                <th>Remarks</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                                <tr>
                                    <td>1</td>
                                    <td>23-09-2023</td>
                                    <td>05-07-2023</td>
                                    <td> Mr Abdul Karim</td>
                                    <td align="right"> 1,000.00</td>
                                    <td align="center"> HR Manager</td>
                                    <td> Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed. </td>
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
