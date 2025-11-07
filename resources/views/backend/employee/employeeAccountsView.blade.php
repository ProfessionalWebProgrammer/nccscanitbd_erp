@extends('layouts.hrPayroll_dashboard')

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">


        <!-- Main content -->
        <div class="content px-4 ">
               <div class="container-fluid">

                    <div class="row ">

                      <div class="col-md-12  bg-light pb-5">
                        <div class="pt-5 text-center">
                            <h4 class="font-weight-bolder text-uppercase"> Employee Account View</h4>
                            <hr width="33%">
                        </div>
                      <div class="col-md-12 mb-4">
                        <div class="row">
                      <div class="col-md-4">
                      </div>
                      <div class="col-md-4">
                        @php
                        $designations = DB::table('designations')->where('id',$employeeData->emp_designation_id)->value('designation_title');
                        $dept = DB::table('departments')->where('id',$employeeData->emp_department_id)->value('department_title');
                        @endphp
                          <span class="h4">Name: {{ $employeeData ? $employeeData->emp_name:''}}</span><br>
                          <span class="h5 text-capitalize">Designation: {{$designations}}</span><br>
                          <span class="h5 text-capitalize">Department: {{$dept}}</span><br>
                          <span class="h5">Contact No: {{ $employeeData ? $employeeData->emp_mobile_number:''}}</span>
                      </div>
                      <div class="col-md-4">
                      </div>
                      </div>
                      </div>

                      <div class="col-md-5  m-auto">
                        <input type="hidden" name="emp_id"
                                        value="{{$emp_id}}">
                         <table id="reporttable" class="table table-bordered table-striped table-fixed"
                            style="font-size: 6;table-layout: inherit;">
                      <thead>
                                <tr style="background:#8888f7;">
                                    <td><b>Head </b></td>
                                    <td align="center"><b>Amount</b></td>

                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Basic Salary</td>
                                    <td align="center">{{ $employeeac ? $employeeac->basic_salary:0}}/-</td>

                                </tr>
                               <tr>
                                    <td>Work Houre</td>
                                    <td align="center">{{ $employeeac ? $employeeac->work_houre:''}}</td>

                                </tr>
                                <tr>
                                    <td>Overtime Per Houre</td>
                                    <td align="center">{{ $employeeac ? $employeeac->overtime_per_houre:''}}</td>

                                </tr>
                                <tr>
                                    <td>MA</td>
                                    <td align="center">{{ $employeeac ? $employeeac->MA:0}}/-</td>

                                </tr>
                               <tr>
                                    <td>HRA</td>
                                    <td align="center">{{ $employeeac ? $employeeac->HRA:0}}/-</td>

                                </tr>

                              <tr>
                                    <td>PB</td>
                                    <td align="center">{{ $employeeac ? $employeeac->PB:0}}/-</td>

                                </tr>

                               <tr>
                                    <td>DA</td>
                                    <td align="center">{{ $employeeac ? $employeeac->DA:0}}/-</td>

                                </tr>

                              <tr>
                                    <td>TA</td>
                                    <td align="center">{{ $employeeac ? $employeeac->TA:0}}/-</td>

                                </tr>
                               <tr>
                                    <td>FB</td>
                                    <td align="center">{{ $employeeac ? $employeeac->FB:0}}/-</td>

                                </tr>
                                <tr>
                                    <td>Fuel Cost</td>
                                    <td align="center">{{ $employeeac ? $employeeac->fuel_cost:0}}/-</td>

                                </tr>
                                <tr>
                                    <td>Out Station</td>
                                    <td align="center">{{ $employeeac ? $employeeac->out_station:0}}/-</td>
                                </tr>
                                <tr>
                                    <td>Arrears</td>
                                    <td align="center">{{ $employeeac ? $employeeac->arrears:0}}/-</td>
                                </tr>

                              <tr>
                                    <td>Tax</td>
                                    <td align="center">{{ $employeeac ? $employeeac->Tax: 0}}%</td>

                                </tr>

                                <tr>
                                    <td>Gross Salary</td>
                                    <td align="center">{{ $employeeac ? $employeeac->net_salary:0}}/-</td>

                                </tr>


                                 <tr>
                                    <td>Tax Amount</td>
                                    <td align="center">{{ $employeeac ? $employeeac->EPF_amount:0}}/-</td>
                                </tr>

                                <tr>
                                    <td>Gross Salary After Tax</td>
                                    <td align="center">{{ $employeeac ? $employeeac->net_salary_after_EPF:0}}/-</td>
                                </tr>
                                <tr>
                                   <td>MC Install</td>
                                   <td align="center">{{ $employeeac ? $employeeac->mc_install:0}}/-</td>
                               </tr>
                                <tr>
                                   <td>Korje Hasana</td>
                                   <td align="center">{{ $employeeac ? $employeeac->korje_hasana:0}}/-</td>
                               </tr>
                                <tr>
                                   <td>Loan Deduction</td>
                                   <td align="center">{{ $employeeac ? $employeeac->loan_deduction:0}}/-</td>
                               </tr>
                                <tr>
                                   <td>House Rent</td>
                                   <td align="center">{{ $employeeac ? $employeeac->house_rent:0}}/-</td>
                               </tr>
                                <tr>
                                   <td>Others Deduction</td>
                                   <td align="center">{{ $employeeac ? $employeeac->others_deduction:0}}/-</td>
                               </tr>
                                <tr style="background:#8888f7;">
                                   <td><b>Total Gross Salary</b></td>
                                   <td align="center"><b>{{ $employeeac ? $employeeac->total_gross_salary:0}}/-</b></td>
                               </tr>
                            </tbody>
					 </table>
                    </div>
                    </div>








                    </div>
                </div>

        </div>
        <!-- /.container-fluid -->
    </div>
    <!-- /.content -->

    <!-- /.content-wrapper -->
@endsection

@push('end_js')

<script>

   $(function() {
            $('[data-toggle="tooltip"]').tooltip()
        })

      function calculatesalary(){



               var basic_salary =  $('#basic_salary').val();
               var work_houre =  $('#work_houre').val();
               var overtime_per_houre =  $('#overtime_per_houre').val();
               var MA =  $('#MA').val();
               var HRA =  $('#HRA').val();
               var PB =  $('#PB').val();
               var DA =  $('#DA').val();
               var TA =  $('#TA').val();
               var FB =  $('#FB').val();
               var Tax =  $('#Tax').val();
               //var net_salary =
          var net_salary = Number(basic_salary)+Number(MA)+Number(HRA)+Number(PB)+Number(DA)+Number(TA)+Number(FB);

        if(Tax != ''){
        var withouttax = (net_salary/100)*(100-Number(Tax));
        }else{
         var withouttax = net_salary;
        }

          var EPF =  $('#EPF').val();
             if(Tax != ''){
            var EPF_amount = (withouttax/100)*(Number(EPF));
             }else{
             var EPF_amount = '';
            }

          $('#net_salary').val(withouttax);

          $('#EPF_amount').val(EPF_amount);
          $('#net_salary_after_EPF').val(Number(withouttax)-Number(EPF_amount));

        }

</script>

@endpush
