@extends('layouts.hrPayroll_dashboard')

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Main content -->
        <div class="content px-4 ">
            <div class="container-fluid">
                <div class="pt-3">
                  <div class="col-md-12 text-right">
                    <a href="{{route('hrpayroll.time.attendance.employeeHolidayCalender.create')}}" class="btn btn-sm btn-success">Holiday Calendar Create</a>
                      <!-- <a href="{{route('hrpayroll.time.attendance.lateManage.prority.list')}}" class="btn btn-sm btn-success">Deducted Leave Type Prorities</a> -->
                  </div>
                  <div class="text-center">
                    <h3 class="text-uppercase font-weight-bold">Naba Crop Care</h3>
                    <p>Head office, Rajshahi, Bangladesh</p>
                  </div>

                </div>
                <div class="py-4 table-responsive">
                    <div class="text-center">
                        <h5 class="text-uppercase font-weight-bold">Holiday Calendar List</h5>

                        <hr>
                    </div>
                    <table id="example1" class="table table-bordered table-striped" style="font-size: 15px;">
                        <thead>
                            <tr class="text-center">
                                <th>SL.</th>
                                <th>Date</th>
                                <th>Day</th>
                                <th>Holiday Name</th>
                                <th>Day Count </th>
                                <th>Description </th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>


                                <tr>
                                    <td>1</td>
                                    <td>21 Feb 2023</td>
                                    <td>Tuesday</td>
                                    <td>Mother Language Shaheed Day</td>
                                    <td>1</td>
                                    <td>Mother Language Shaheed Day</td>
                                    <td class="text-center">
                                        <a href="#"
                                            class="btn btn-xs btn-info my-1" data-toggle="tooltip" data-placement="top" title="Employee Edit"><i class="far fa-edit "></i></a>

                                        <a class="btn btn-xs btn-danger " href="" data-toggle="modal" data-target="#delete"
                                                        data-myid=""><i class="far fa-trash-alt"></i> </a>
                                    </td>
                                </tr>
                                <tr>
                                  <td>2</td>
                                  <td>8 Mar 2023</td>
                                  <td>Wednesday</td>
                                  <td>Shab e-Barat</td>
                                  <td>1</td>
                                  <td>Shab e-Barat</td>
                                  <td class="text-center">
                                      <a href="#"
                                          class="btn btn-xs btn-info my-1" data-toggle="tooltip" data-placement="top" title="Employee Edit"><i class="far fa-edit "></i></a>

                                      <a class="btn btn-xs btn-danger " href="" data-toggle="modal" data-target="#delete"
                                                      data-myid=""><i class="far fa-trash-alt"></i> </a>
                                  </td>
                                </tr>
                                <tr>
                                  <td>3</td>
                                  <td>17 Mar 2023</td>
                                  <td>Friday</td>
                                  <td>Sheikh Mujibur Rahman's Birthday</td>
                                  <td>1</td>
                                  <td>Sheikh Mujibur Rahman's Birthday</td>
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
