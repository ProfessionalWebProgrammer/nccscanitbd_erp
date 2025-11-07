@extends('layouts.hrPayroll_dashboard')
@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Main content -->
        <div class="content px-4 ">
            <div class="container-fluid">
                <div class="pt-3">

                  <div class="text-center">
                    <h3 class="text-uppercase font-weight-bold">Naba Crop Care</h3>
                    <p>Head office, Rajshahi, Bangladesh</p>
                  </div>

                </div>
                <div class="py-4 table-responsive">
                    <div class="text-center">
                        <h5 class="text-uppercase font-weight-bold">Employee Final settlement report</h5>
                      	 {{-- <p>Date: </p> --}}
                        <hr>
                    </div>
                    <table class="table table-bordered table-striped" style="font-size: 15px;">
                        <thead>
                            <tr class="text-center">
                                <th>Title</th>
                                <th>Amount</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                 $grandTotalGrossSalary = 0;
                                 $grandTotalOt = 0;
                                 $grandTotalLoan = 0;
                                 $grandTotalAccidentBenefit = 0;
                                 $grandTotalEarnLeave = 0;
                            @endphp
                         @foreach ($employees as $employee)
                            @php
                                $grandTotalGrossSalary += $employee['total_gross_salary'];
                                $grandTotalOt += $employee['total_ot'];
                                $grandTotalLoan += $employee['total_loan'];
                                $grandTotalAccidentBenefit += $employee['accident_benefit'];  
                                $grandTotalEarnLeave += $employee['earn_leave'];
                            @endphp
                            <tr class="text-center table-warning">
                                <th colspan="2" class="text-left" style="color:brown">{{ $employee['emp_name'] }}</th>
                            </tr>
                            <tr>
                                <td>Total Gross Salary</td>
                                <td>{{ number_format($employee['total_gross_salary'] , 2)  }}</td>
                            </tr>
                            <tr>
                                <td>Total Over Time Cost</td>
                                <td>{{ number_format($employee['total_ot'] , 2)  }}</td>
                            </tr>
                            <tr>
                                <td>Total Loan</td>
                                <td>{{ number_format($employee['total_loan'] , 2)  }}</td>
                            </tr>
                            <tr>
                                <td>Total Accident Benefit Cost</td>
                                <td>{{ number_format($employee['accident_benefit'] , 2)  }}</td>
                            </tr>
                            <tr>
                                <td>Total Earning Leave Cost</td>
                                <td>{{ number_format($employee['earn_leave'] , 2)  }}</td>
                            </tr>
                            <tr class="table-info">
                                <td>Sub Total</td>
                                <td>{{ number_format($employee['total_gross_salary'] + $employee['total_ot'] + $employee['total_loan'] + $employee['accident_benefit'] + $employee['earn_leave'] , 2)  }}</td>
                            </tr>
                         @endforeach
                         <tr style="background:#000000;color:#ffffff">
                            <td>Grand Total</td>
                            <td>{{ number_format( $grandTotalGrossSalary + $grandTotalOt + $grandTotalLoan + $grandTotalAccidentBenefit + $grandTotalEarnLeave , 2)  }}</td>
                        </tr>
                          
                        </tbody>
                        <tfoot>
                          <tr>

                          </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
