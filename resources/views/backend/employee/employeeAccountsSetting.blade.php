@extends('layouts.hrPayroll_dashboard')

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">


        <!-- Main content -->
        <div class="content px-4 ">
            <form action="{{ URL::to('/employee/accounts/store') }}" method="POST">
                @csrf
                <div class="container-fluid">
                    <div class="pt-3 text-center">
                        <h4 class="font-weight-bolder text-uppercase"> Employee Account Setting</h4>
                        <hr width="33%">
                    </div>
                    <div class="row pt-4">
                        <input type="hidden" name="emp_id"
                                        value="{{$emp_id}}">
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label">Basic Salary :</label>
                                <div class="col-sm-8">
                                    <input type="Text" name="basic_salary"
                                        class="form-control" placeholder="Basic Salary " oninput="calculatesalary()" id="basic_salary" value="{{ $employeeac ? $employeeac->basic_salary:''}}">
                                </div>
                            </div>
                        </div>

                       <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label">Work Houre:</label>
                                <div class="col-sm-8">
                                    <input type="Text" name="work_houre"
                                        class="form-control" placeholder="Work Houre" oninput="calculatesalary()" id="work_houre" value="{{ $employeeac ? $employeeac->work_houre:''}}">
                                </div>
                            </div>
                        </div>

                       <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label">Overtime Per houre:</label>
                                <div class="col-sm-8">
                                    <input type="Text" name="overtime_per_houre"
                                        class="form-control" placeholder="Overtime Per houre" oninput="calculatesalary()" id="overtime_per_houre" value="{{ $employeeac ? $employeeac->overtime_per_houre:''}}">
                                </div>
                            </div>
                        </div>
                      <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label">MA:</label>
                                <div class="col-sm-8">
                                    <input type="Text" name="MA"
                                        class="form-control" placeholder="MA" id="MA" oninput="calculatesalary()" value="{{ $employeeac ? $employeeac->MA:''}}">
                                </div>
                            </div>
                        </div>

                      <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label">HRA:</label>
                                <div class="col-sm-8">
                                    <input type="Text" name="HRA"
                                        class="form-control" placeholder="HRA" id="HRA" oninput="calculatesalary()" value="{{ $employeeac ? $employeeac->HRA:''}}">
                                </div>
                            </div>
                        </div>

                       <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label">PB:</label>
                                <div class="col-sm-8">
                                    <input type="Text" name="PB"
                                        class="form-control" placeholder="PB" id="PB" oninput="calculatesalary()" value="{{ $employeeac ? $employeeac->PB:''}}">
                                </div>
                            </div>
                        </div>

                       <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label">DA:</label>
                                <div class="col-sm-8">
                                    <input type="Text" name="DA"
                                        class="form-control" placeholder="DA" id="DA" oninput="calculatesalary()" value="{{ $employeeac ? $employeeac->DA:''}}">
                                </div>
                            </div>
                        </div>
                       <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label">TA:</label>
                                <div class="col-sm-8">
                                    <input type="Text" name="TA"
                                        class="form-control" placeholder="TA" id="TA" oninput="calculatesalary()" value="{{ $employeeac ? $employeeac->TA:''}}">
                                </div>
                            </div>
                        </div>


                        <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label">FB:</label>
                                <div class="col-sm-8">
                                    <input type="Text" name="FB"
                                        class="form-control" placeholder="FB" id="FB" oninput="calculatesalary()" value="{{ $employeeac ? $employeeac->FB:''}}">
                                </div>
                            </div>
                        </div>


                        <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label">CA:</label>
                                <div class="col-sm-8">
                                    <input type="Text" name="CV"
                                        class="form-control" placeholder="CA" id="CA" oninput="calculatesalary()" value="{{ $employeeac ? $employeeac->CA:''}}">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label">CV:</label>
                                <div class="col-sm-8">
                                    <input type="Text" name="CV"
                                        class="form-control" placeholder="CV" id="CV" oninput="calculatesalary()" value="{{ $employeeac ? $employeeac->CV:''}}">
                                </div>
                            </div>
                        </div>
                       <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label">FA:</label>
                                <div class="col-sm-8">
                                    <input type="Text" name="FA"
                                        class="form-control" placeholder="FA" id="FA" oninput="calculatesalary()" value="{{ $employeeac ? $employeeac->FA:''}}">
                                </div>
                            </div>
                        </div>

                       <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label">Fuel Cost:</label>
                                <div class="col-sm-8">
                                    <input type="Text" name="fuel_cost"
                                        class="form-control" placeholder="Fuel Cost" oninput="calculatesalary()" id="f_cost" value="{{ $employeeac ? $employeeac->fuel_cost:''}}">
                                </div>
                            </div>
                        </div>
                       <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label">Out Station:</label>
                                <div class="col-sm-8">
                                    <input type="Text" name="out_station"
                                        class="form-control" placeholder="Out Station" oninput="calculatesalary()" id="out_station" value="{{ $employeeac ? $employeeac->out_station:''}}">
                                </div>
                            </div>
                        </div>
                       <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label">Arrears:</label>
                                <div class="col-sm-8">
                                    <input type="Text" name="arrears"
                                        class="form-control" placeholder="Arrears" oninput="calculatesalary()" id="arrears" value="{{ $employeeac ? $employeeac->arrears:''}}">
                                </div>
                            </div>
                        </div>
                      <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label">Gross Salary:</label>
                                <div class="col-sm-8">
                                    <input type="Text" name="net_salary"
                                        class="form-control" placeholder="Net Salary" oninput="calculatesalary()" id="net_salary" value="{{ $employeeac ? $employeeac->net_salary:''}}">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                             <div class="form-group row">
                                 <label class="col-sm-4 col-form-label">Tax(%):</label>
                                 <div class="col-sm-8">
                                     <input type="Text" name="Tax"
                                         class="form-control" placeholder="Tax(%)" oninput="calculatesalary()" id="Tax" value="{{ $employeeac ? $employeeac->Tax:''}}">
                                 </div>
                             </div>
                         </div>


                    {{-- <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label">EPF(%):</label>
                                <div class="col-sm-8">
                                    <input type="Text" name="EPF"
                                        class="form-control" placeholder="EPF(%)" id="EPF" oninput="calculatesalary()" value="{{ $employeeac ? $employeeac->EPF:''}}">
                                </div>
                            </div>
                        </div> --}}

                        <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label">Tax Amount:</label>
                                <div class="col-sm-8">
                                    <input type="Text" name="EPF_amount"
                                        class="form-control" placeholder="Tax Amount" oninput="calculatesalary()" id="EPF_amount" value="{{ $employeeac ? $employeeac->EPF_amount:''}}">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label">G. Salary After Tax:</label>
                                <div class="col-sm-8">
                                    <input type="Text" name="net_salary_after_EPF"
                                        class="form-control" placeholder="Groll Salary After Tax" oninput="calculatesalary()" id="net_salary_after_EPF" value="{{ $employeeac ? $employeeac->net_salary_after_EPF:''}}">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                             <div class="form-group row">
                                 <label class="col-sm-4 col-form-label">Others Deduction:</label>
                                 <div class="col-sm-8">
                                     <input type="Text" name="others_deduction"
                                         class="form-control" placeholder="Others Deduction" oninput="calculatesalary()" id="other_deduc" value="{{ $employeeac ? $employeeac->others_deduction:''}}">
                                 </div>
                             </div>
                         </div>
                        <div class="col-md-6">
                             <div class="form-group row">
                                 <label class="col-sm-4 col-form-label">MC Install:</label>
                                 <div class="col-sm-8">
                                     <input type="Text" name="mc_install"
                                         class="form-control" placeholder="MC Install" oninput="calculatesalary()" id="mc_install" value="{{ $employeeac ? $employeeac->mc_install:''}}">
                                 </div>
                             </div>
                         </div>
                        <div class="col-md-6">
                             <div class="form-group row">
                                 <label class="col-sm-4 col-form-label">Korje Hasana:</label>
                                 <div class="col-sm-8">
                                     <input type="Text" name="korje_hasana"
                                         class="form-control" placeholder="Korje Hasana" oninput="calculatesalary()" id="korje_hasana" value="{{ $employeeac ? $employeeac->korje_hasana:''}}">
                                 </div>
                             </div>
                         </div>
                        <div class="col-md-6">
                             <div class="form-group row">
                                 <label class="col-sm-4 col-form-label">Loan Deduction:</label>
                                 <div class="col-sm-8">
                                     <input type="Text" name="loan_deduction"
                                         class="form-control" placeholder="Loan Deduction" oninput="calculatesalary()" id="loan_deduc" value="{{ $employeeac ? $employeeac->loan_deduction:''}}">
                                 </div>
                             </div>
                         </div>
                        <div class="col-md-6">
                             <div class="form-group row">
                                 <label class="col-sm-4 col-form-label">House Rent:</label>
                                 <div class="col-sm-8">
                                     <input type="Text" name="house_rent"
                                         class="form-control" placeholder="House Rent" oninput="calculatesalary()" id="house_rent" value="{{ $employeeac ? $employeeac->house_rent:''}}">
                                 </div>
                             </div>
                         </div>
                        <div class="col-md-6">
                             <div class="form-group row">
                                 <label class="col-sm-4 col-form-label">Accident Benefit:</label>
                                 <div class="col-sm-8">
                                     <input type="Text" name="accident_benefit"
                                         class="form-control" placeholder="Accident Benefit" oninput="calculatesalary()" id="abenefit_rent" value="{{ $employeeac ? $employeeac->accident_benefit:''}}">
                                 </div>
                             </div>
                         </div>
                        <div class="col-md-6">
                             <div class="form-group row">
                                 <label class="col-sm-4 col-form-label">Total Gross Salary:</label>
                                 <div class="col-sm-8">
                                     <input type="Text" name="total_gross_salary"
                                         class="form-control" placeholder="Total Gross Salary" oninput="calculatesalary()" id="total_gross_salary" value="{{ $employeeac ? $employeeac->total_gross_salary:''}}">
                                 </div>
                             </div>
                         </div>

                    </div>
                </div>
                <div class="row pb-5">
                    <div class="col-md-6 mt-3">
                        <div class="text-right">
                            <button type="submit" class="btn custom-btn-sbms-submit"> Submit </button>
                        </div>
                    </div>
                    <div class="col-md-6 mt-3">

                    </div>
                </div>
            </form>
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
               var CA =  $('#CA').val();
               var CV =  $('#CV').val();
               var FA =  $('#FA').val();
               var f_cost =  $('#f_cost').val();
               var out_station =  $('#out_station').val();
               var arrears =  $('#arrears').val();
               var Tax =  $('#Tax').val();
               var other_deduc =  $('#other_deduc').val();
               var mc_install =  $('#mc_install').val();
               var korje_hasana =  $('#korje_hasana').val();
               var loan_deduc =  $('#loan_deduc').val();
               var house_rent =  $('#house_rent').val();

               var deduction = Number(other_deduc)+Number(mc_install)+Number(korje_hasana)+Number(loan_deduc)+Number(house_rent);
               //var net_salary =
          var net_salary = Number(basic_salary)+Number(MA)+Number(HRA)+Number(PB)+Number(DA)+Number(TA)+Number(FB)+Number(CA)+Number(CV)+Number(FA)+Number(f_cost)+Number(out_station)+Number(arrears);

        if(Tax != ''){
        // var withouttax = (net_salary/100)*(100-Number(Tax));
        var tax_amount = (net_salary * Number(Tax))/100;
        }else{
         var tax_amount = '';
        }

            /*   var EPF =  $('#EPF').val();
             if(Tax != ''){
            var EPF_amount = (withouttax/100)*(Number(EPF));
             }else{
             var EPF_amount = '';
            }
            */

          $('#net_salary').val(net_salary);

          $('#EPF_amount').val(tax_amount);
          // $('#net_salary_after_EPF').val(Number(withouttax)-Number(EPF_amount));
          $('#net_salary_after_EPF').val(net_salary - tax_amount);
          $('#total_gross_salary').val(net_salary - tax_amount - deduction);
        }


</script>

@endpush
