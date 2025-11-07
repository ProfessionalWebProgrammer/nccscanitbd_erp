@extends('layouts.hrPayroll_dashboard')

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Main content -->
        <div class="content px-4 ">
            <div class="container-fluid">
                <div class="pt-3">
                  <div class="col-md-12 text-right">
                      <a href="{{route('hrpayroll.employee.salaryLoanConfiguration.create')}}" class="btn btn-sm btn-success">Salary Loan Configuration Create</a>
                  </div>
                  <div class="text-center">
                    <h3 class="text-uppercase font-weight-bold">Naba Crop Care</h3>
                    <p>Head office, Rajshahi, Bangladesh</p>
                  </div>

                </div>
                <div class="py-4 table-responsive">
                    <div class="text-center">
                        <h5 class="text-uppercase font-weight-bold">Employee Salary Loan Configuration List</h5>

                        <hr>
                    </div>
                    <table id="example1" class="table table-bordered table-striped" style="font-size: 15px;">
                        <thead>
                            <tr class="text-center">
                                <th>SL.</th>
                                <th>Head </th>
                                <th>Basic Salary Amount</th>
                                <th>Loan Amount</th>
                                <th>Payment Method</th>
                                <th>Remarks</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>


                                <tr>
                                    <td>1</td>
                                    <td>House Loan, Bike Loan, Others Loan</td>
                                    <td align="right"> 20,000.00</td>
                                    <td align="right"> 60,000.00</td>
                                    <td align="center"> Bank</td>
                                    <td> Only for parmanent Empoyee and Job Duration At list 5 Years </td>
                                    <td class="text-center">
                                        <a href="#"
                                            class="btn btn-xs btn-info my-1" data-toggle="tooltip" data-placement="top" title="Employee Edit"><i class="far fa-edit "></i></a>

                                        <a class="btn btn-xs btn-danger " href="" data-toggle="modal" data-target="#delete"
                                                        data-myid=""><i class="far fa-trash-alt"></i> </a>
                                    </td>
                                </tr>
                                <tr>
                                    <td>2</td>
                                    <td>House Loan, Bike Loan, Others Loan</td>
                                    <td align="right"> 30,000.00</td>
                                    <td align="right"> 90,000.00</td>
                                    <td align="center"> Bank</td>
                                    <td> Only for parmanent Empoyee and Job Duration At list 5 Years </td>
                                    <td class="text-center">
                                        <a href="#"
                                            class="btn btn-xs btn-info my-1" data-toggle="tooltip" data-placement="top" title="Employee Edit"><i class="far fa-edit "></i></a>

                                        <a class="btn btn-xs btn-danger " href="" data-toggle="modal" data-target="#delete"
                                                        data-myid=""><i class="far fa-trash-alt"></i> </a>
                                    </td>
                                </tr>
                                <tr>
                                    <td>3</td>
                                    <td>House Loan, Bike Loan, Others Loan</td>
                                    <td align="right"> 40,000.00</td>
                                    <td align="right"> 120,000.00</td>
                                    <td align="center"> Bank</td>
                                    <td> Only for parmanent Empoyee and Job Duration At list 5 Years </td>
                                    <td class="text-center">
                                        <a href="#"
                                            class="btn btn-xs btn-info my-1" data-toggle="tooltip" data-placement="top" title="Employee Edit"><i class="far fa-edit "></i></a>

                                        <a class="btn btn-xs btn-danger " href="" data-toggle="modal" data-target="#delete"
                                                        data-myid=""><i class="far fa-trash-alt"></i> </a>
                                    </td>
                                </tr>
                                <tr>
                                    <td>4</td>
                                    <td>House Loan, Bike Loan, Others Loan</td>
                                    <td align="right"> 50,000.00</td>
                                    <td align="right"> 150,000.00</td>
                                    <td align="center"> Bank</td>
                                    <td> Only for parmanent Empoyee and Job Duration At list 6 Years </td>
                                    <td class="text-center">
                                        <a href="#"
                                            class="btn btn-xs btn-info my-1" data-toggle="tooltip" data-placement="top" title="Employee Edit"><i class="far fa-edit "></i></a>

                                        <a class="btn btn-xs btn-danger " href="" data-toggle="modal" data-target="#delete"
                                                        data-myid=""><i class="far fa-trash-alt"></i> </a>
                                    </td>
                                </tr>
                                <tr>
                                    <td>5</td>
                                    <td>House Loan, Bike Loan, Others Loan</td>
                                    <td align="right"> 60,000.00</td>
                                    <td align="right"> 200,000.00</td>
                                    <td align="center"> Bank</td>
                                    <td> Only for parmanent Empoyee and Job Duration At list 7 Years </td>
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
