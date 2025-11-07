@extends('layouts.account_dashboard')
@push('addcss')
<style>
    .alerts-border {
        border: 3px solid #000;
    }
  
  .linkbtn{
  	border-radius: 15px; 
    font-weight: 800;
    font-size: 18px;
  }
</style>
@endpush
@section('content')

<div class="content-wrapper">
    <!-- Main content -->
    <div class="content">
        <div class="container  pt-5" style="position:relative;">
            
          <div class="pb-3 pt-2">
                <div class="row  pt-3">
                    <div class="col-md-4 m-auto sales_main_button">
                        <a href="#" class="text-center pt-1 pb-2  btn btn-block  text-center linkbtn" >Reports</a>
                    </div>
                </div>
                <div class="row pt-5 px-3">
                    
                    <div class="col-md-2 my-2 sales_button" style="border-radius: 8px;">
                        <div class="mx-1">
                            <a href="{{URL('/accounts/income/statement/index')}}" class="btn btn-block  text-center py-3 linkbtn" >Income Statement</a>
                        </div>
                    </div>
                    <div class="col-md-2 my-2 sales_button" style="border-radius: 8px;">
                        <div class="mx-1">
                            <a href="{{route('compared.income.statement.index')}}" class="btn btn-block  text-center py-3 linkbtn" >Compared Income Statement</a>
                        </div>
                    </div>
                  {{-- <div class="col-md-2 my-2 sales_button" style="border-radius: 8px;">
                        <div class="mx-1">
                            <a href="{{route('manual.income.statement.index')}}" class="btn btn-block  text-center py-3 linkbtn" >New Income Statement</a>
                        </div>
                    </div>
                   <div class="col-md-2 my-2 sales_button" style="border-radius: 8px;">
                        <div class="mx-1">
                            <a href="{{route('pl.income.statement.index')}}" class="btn btn-block  text-center py-3 linkbtn" >PL Statement</a>
                        </div>
                    </div> --}}
                  
                        <div class="col-md-2 my-2 sales_button" style="border-radius: 8px;">
                        <div class="mx-1">
                            <a href="{{URL('/accounts/new/income/statement/index')}}" class="btn btn-block  text-center py-3 linkbtn" >Comprehensive Income </a>
                        </div>
                    </div>
                  
                  <div class="col-md-2 my-2 sales_button" style="border-radius: 8px;">
                        <div class="mx-1">
                            <a href="{{URL('/accounts/trial/balance/index')}}" class="btn btn-block  text-center py-3 linkbtn" >Compared Trail Balance</a>
                        </div>
                    </div>
                    <div class="col-md-2 my-2 sales_button" style="border-radius: 8px;">
                        <div class="mx-1">
                            <a href="{{URL('/accounts/operating/cash/flow/index')}}" class="btn btn-block  text-center py-3 linkbtn" >Operating Cash Flow</a>
                        </div>
                    </div>
                    <div class="col-md-2 my-2 sales_button" style="border-radius: 8px;">
                        <div class="mx-1">
                            <a href="{{ URL('/accounts/total/cash/flow/index')}}" class="btn btn-block  text-center py-3 linkbtn" >Cash Flow</a>
                        </div>
                    </div>
                  
                  <div class="col-md-2 my-2 sales_button" style="border-radius: 8px;">
                        <div class="mx-1">
                            <a href="{{ URL('/accounts/new/total/cash/flow/index')}}" class="btn btn-block  text-center py-3 linkbtn" >New Cash Flow</a>
                        </div>
                    </div>
                  <div class="col-md-2 my-2 sales_button" style="border-radius: 8px;">
                        <div class="mx-1">
                            <a href="{{ URL('/accounts/company/summary/index')}}" class="btn btn-block  text-center py-3 linkbtn" >Company Summary Report</a>
                        </div>
                    </div>
                   <div class="col-md-2 my-2 sales_button" style="border-radius: 8px;">
                        <div class="mx-1">
                            <a href="{{ URL('/accounts/balance/sheet/index')}}" class="btn btn-block  text-center py-3 linkbtn" >Balance Sheet</a>
                        </div>
                    </div>
                  
                     <div class="col-md-2 my-2 sales_button" style="border-radius: 8px;">
                        <div class="mx-1">
                            <a href="{{ URL('financial/report/index')}}" class="btn btn-block  text-center py-3 linkbtn" >Financial  Report</a>
                        </div>
                    </div>
                  
                
                    
                   <div class="col-md-2 my-2 sales_button" style="border-radius: 8px;">
                        <div class="mx-1">
                            <a href="{{ URL('/expenditure/pie/chart/index')}}" class="btn btn-block text-center py-3 linkbtn" >Expenditure Pie Chart</a>
                        </div>
                    </div>
                  
                  <div class="col-md-2 my-2 sales_button" style="border-radius: 8px;">
                        <div class="mx-1">
                            <a href="{{ URL('/accounts/pie/chart/index')}}" class="btn btn-block text-center py-3 linkbtn" >Pie Chart</a>
                        </div>
                    </div>
                  
                   <div class="col-md-2 my-2 sales_button" style="border-radius: 8px;">
                        <div class="mx-1">
                            <a href="{{ URL('/budget/pie/chart/index')}}" class="btn btn-block text-center py-3 linkbtn" >Budget Pie Chart</a>
                        </div>
                    </div>
                  
                   <div class="col-md-2 my-2 sales_button" style="border-radius: 8px;">
                        <div class="mx-1">
                            <a href="{{ URL('/top/ten/collection/index')}}" class="btn btn-block text-center py-3 linkbtn" >Top Ten Collection Report</a>
                        </div>
                    </div>
                  
                   <div class="col-md-2 my-2 sales_button" style="border-radius: 8px;">
                        <div class="mx-1">
                            <a href="{{ URL('/top/ten/expanse/index')}}" class="btn btn-block text-center py-3 linkbtn" >Top Ten Expense Report</a>
                        </div>
                    </div>
                  <div class="col-md-2 my-2 sales_button" style="border-radius: 8px;">
                        <div class="mx-1">
                            <a href="{{ route('cash.receivable.report.index')}}" class="btn btn-block text-center py-3 linkbtn" >Cash Receivable Report</a>
                        </div>
                    </div>
                  <div class="col-md-2 my-2 sales_button" style="border-radius: 8px;">
                        <div class="mx-1">
                            <a href="{{ route('pl.analytical.report.index')}}" class="btn btn-block text-center py-3 linkbtn" >PL Analytical Report</a>
                        </div>
                    </div>
                    <div class="col-md-2 my-2 sales_button" style="border-radius: 8px;">
                        <div class="mx-1">
                            <a href="{{ route('cashFlowStatement.report.index')}}" class="btn btn-block text-center py-3 linkbtn" >Cash Flow Statement Report</a>
                        </div>
                    </div>

                </div>
            </div> <!-- /.alert Border -->
        </div>
    </div><!-- /.container-fluid -->
<!-- /.content -->
</div>
<!-- /.content-wrapper -->
@endsection