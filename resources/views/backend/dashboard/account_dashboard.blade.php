@extends('layouts.account_dashboard')

@section('content')
<style>

      .menuclass{
        display: none;
      }
      .nav-pills.account_dashboard_tab .nav-link{
        margin: 5px;
        padding: 12px 40px;
        font-size: 16px;
        color: #111;
        font-weight: 600;
        border: 1px solid #111;
        background-color: #fff;
        transition: all .2s ease-in-out;
    }
    
    .nav-pills.account_dashboard_tab .nav-link.active{
        background-color: #28a745;
        border-color:#28a745;
        color: #fff;
    }
    
    .nav-pills.account_dashboard_tab .nav-link:not(.active):hover {
        color: #111;
        box-shadow: 0px 2px 10px 1px;
    }
</style>

<div class="content-wrapper">
    <!-- Main content -->
    <div class="content" >
      <div class="container-fluid" style="background:#fff!important; min-height:85vh;">

       <div class="row">
        <div class="col-md-2 mt-5">
             <!-- Main Sidebar Container -->
        <aside >
            @include('_partials_.sidebar')
        </aside>
        </div>
         <div class="col-md-10">

           <div class="mb-3" >

            @php
                 $authid = Auth::id();
                 $salesdata = DB::table('permissions')
                     ->where('head', 'Sales')
                     ->where('user_id', $authid)
                     ->pluck('name')
                     ->toArray();

                 $accountsdata = DB::table('permissions')
                     ->where('head', 'Accounts')
                     ->where('user_id', $authid)
                     ->pluck('name')
                     ->toArray();

               //  dd($accountsdata);
             @endphp

                <div class="row pt-3">
                    <div class="col-md-4 m-auto sales_main_button">
                        <a href="{{route('account.dashboard')}}" class="text-center pt-1 pb-2 py-3 btn btn-block text-center linkbtn" >Accounts Department</a>
                    </div>
                </div>
                <div class="row pt-5 px-3">
                    <!--Tabs-->
                    <div class="col-md-12">
                        <ul class="nav nav-pills account_dashboard_tab mb-3" id="pills-tab" role="tablist">
                            <li class="nav-item" role="presentation">
                            <button class="nav-link" id="pills-create-entry-tab" data-toggle="pill" data-target="#pills-create-entry" type="button" role="tab" aria-controls="pills-create-entry" aria-selected="false">Create Book</button>
                          </li>
                          <li class="nav-item" role="presentation">
                            <button class="nav-link" id="pills-asset-entry-tab" data-toggle="pill" data-target="#pills-asset-entry" type="button" role="tab" aria-controls="pills-asset-entry" aria-selected="false">Assets Book</button>
                          </li>
                          
                          <li class="nav-item" role="presentation">
                            <button class="nav-link" id="pills-accountBook-tab" data-toggle="pill" data-target="#pills-accountBook" type="button" role="tab" aria-controls="pills-accountBook" aria-selected="false">Account Book</button>
                          </li>
                          
                          <li class="nav-item" role="presentation">
                            <button class="nav-link" id="pills-bank-posting-tab" data-toggle="pill" data-target="#pills-bank-posting" type="button" role="tab" aria-controls="pills-bank-posting" aria-selected="true">Bank Posting</button>
                          </li>
                          <li class="nav-item" role="presentation">
                            <button class="nav-link" id="pills-journal-posting-tab" data-toggle="pill" data-target="#pills-journal-posting" type="button" role="tab" aria-controls="pills-journal-posting" aria-selected="false">Journal Posting</button>
                          </li>
                         
                          <li class="nav-item" role="presentation">
                            <button class="nav-link" id="pills-share-capital-tab" data-toggle="pill" data-target="#pills-share-capital" type="button" role="tab" aria-controls="pills-share-capital" aria-selected="false">Share Capital</button>
                          </li>
                          
                          <li class="nav-item" role="presentation">
                            <button class="nav-link" id="pills-reports-tab" data-toggle="pill" data-target="#pills-reports" type="button" role="tab" aria-controls="pills-reports" aria-selected="false">Accounts Reports</button>
                          </li>
                          
                          <li class="nav-item" role="presentation">
                            <button class="nav-link" id="pills-inventory-management-tab" data-toggle="pill" data-target="#pills-inventory-management" type="button" role="tab" aria-controls="pills-inventory-management" aria-selected="false">Inventory Management</button>
                          </li>
                          
                          <li class="nav-item" role="presentation">
                            <button class="nav-link" id="pills-sales-department-tab" data-toggle="pill" data-target="#pills-sales-department" type="button" role="tab" aria-controls="pills-sales-department" aria-selected="false">Sales Department</button>
                          </li>
                        </ul>
                        
                        <div class="tab-content" id="pills-tabContent">
                            <div class="tab-pane fade" id="pills-bank-posting" role="tabpanel" aria-labelledby="pills-bank-posting-tab">
                                <div class="row">
                                    @if (in_array('receive', $accountsdata))
                                        <div class="col-md-2 p-1 sales_button" style="border-radius: 8px;">
                                            <div class="mx-1">
                                              <a href="{{URL('/account/manu/receive')}}" class="btn btn-block text-center py-3 linkbtn" >Receive</a>
                                            </div>
                                        </div>
                                    @endif
                
                                    @if (in_array('payment', $accountsdata))
                                        <div class="col-md-2 p-1 sales_button" style="border-radius: 8px;">
                                            <div class="mx-1">
                                              <a href="{{route('account.manu.payment')}}" class="btn btn-block text-center py-3 linkbtn" >Payment</a>
                                            </div>
                                        </div>
                                   @endif
                               </div><!--.row-->
                            </div><!--#pills-bank-posting-->
                          
                          <div class="tab-pane fade" id="pills-journal-posting" role="tabpanel" aria-labelledby="pills-journal-posting-tab">
                                <div class="row">
                                    @if (in_array('acreate', $accountsdata))
                                        <div class="col-md-2 p-1 sales_button" style="border-radius: 8px;">
                                            <div class="mx-1">
                                              <a href="{{URL('/amount/transfer/list')}}" class="btn btn-block text-center py-3 linkbtn" >Contra Entry</a>
                                            </div>
                                        </div>
                                        <div class="col-md-2 p-1 sales_button" style="border-radius: 8px;">
                                            <div class="mx-1">
                                              <a href="{{URL('/journal/entry/index')}}" class="btn btn-block text-center py-3 linkbtn" >Journal</a>
                                            </div>
                                        </div>
                                        <div class="col-md-2 p-1 sales_button" style="border-radius: 8px;">
                                            <div class="mx-1">
                                              <a href="{{URL('/expanse/payment/index')}}" class="btn btn-block text-center py-3 linkbtn">Expense</a>
                                            </div>
                                        </div>
                                    @endif
                            </div><!--.row-->
                          </div><!--#pills-journal-posting-->
                          
                          <div class="tab-pane fade" id="pills-share-capital" role="tabpanel" aria-labelledby="pills-share-capital-tab">
                                <div class="row">
                                    @if (in_array('acreate', $accountsdata))
                                       <div class="col-md-2 p-1 sales_button" style="border-radius: 8px;">
                                            <div class="mx-1">
                                              <a href="{{URL('/accounts/equity/index')}}" class="btn btn-block text-center py-3 linkbtn" >Equity</a>
                                            </div>
                                        </div>
                                        <div class="col-md-2 p-1 sales_button" style="border-radius: 8px;">
                                            <div class="mx-1">
                                              <a href="{{URL('/direct/labour/cost/list')}}" class="btn btn-block text-center py-3 linkbtn" >Costing</a>
                                            </div>
                                        </div>
                                    @endif
                                </div><!--.row-->
                          </div><!--#pills-share-capital-->
                          
                          <div class="tab-pane fade" id="pills-create-entry" role="tabpanel" aria-labelledby="pills-create-entry-tab">
                                <div class="row">
                                     @if (in_array('acreate', $accountsdata))
                                        <div class="col-md-2 p-1 sales_button" style="border-radius: 8px;">
                                            <div class="mx-1">
                                              <a href="{{ URL('/master/bank/index')}}" class="btn btn-block text-center py-3 linkbtn">Bank/Cash</a>
                                            </div>
                                        </div>
                    
                                        <div class="col-md-2 p-1 sales_button" style="border-radius: 8px;">
                                            <div class="mx-1">
                                              <a href="{{route('account.manu.index')}}" class="btn btn-block text-center py-3 linkbtn" >Others Income Entry </a>
                                            </div>
                                        </div>
                                        
                                        <div class="col-md-2 p-1 sales_button" style="border-radius: 8px;">
                                            <div class="mx-1">
                                              <a href="{{route('individual.account.list')}}" class="btn btn-block text-center py-3 linkbtn" >Individual Account</a>
                                            </div>
                                        </div>
                                        <div class="col-md-2 p-1 sales_button" style="border-radius: 8px;">
                                          <div class="mx-1">
                                            <a href="{{route('chat.of.account.list')}}" class="btn btn-block text-center py-3 linkbtn" >Chart Of Account</a>
                                          </div>
                                      </div>
                                    @endif
                                </div><!--.row-->
                          </div><!--#pills-create-entry-->
                          
                          <div class="tab-pane fade" id="pills-asset-entry" role="tabpanel" aria-labelledby="pills-asset-entry-tab">
                                <div class="row">
                                    @if (in_array('acreate', $accountsdata))
                                       <div class="col-md-2 p-1 sales_button" style="border-radius: 8px;">
                                            <div class="mx-1">
                                              <a href="{{route('account.manu.asset')}}" class="btn btn-block text-center py-3 linkbtn" >Asset</a>
                                            </div>
                                        </div>
                                    @endif
                                    <div class="col-md-2 p-1 sales_button" style="border-radius: 8px;">
                                        <div class="mx-1">
                                          <a href="{{route('get.chat.of.account.depreciation')}}" class="btn btn-block text-center py-3 linkbtn" >Assets Depreciation</a>
                                        </div>
                                    </div>
                                </div><!--.row-->
                          </div><!--#pills-asset-entry-->
                          
                          <div class="tab-pane fade" id="pills-reports" role="tabpanel" aria-labelledby="pills-reports-tab">
                                <div class="row">
                                    @if (in_array('incomestement', $accountsdata))
                                        <div class="col-md-2 p-1 sales_button" style="border-radius: 8px;">
                                            <div class="mx-1">
                                              <a href="{{route('account.manu.report.index')}}" class="btn btn-block text-center py-3 linkbtn" >Detail Reports </a>
                                            </div>
                                        </div>
                                    @endif
                                 
                                    <div class="col-md-2 p-1 sales_button" style="border-radius: 8px;">
                                        <div class="mx-1">
                                          <a href="{{route('chat.of.account.journal.input')}}" class="btn btn-block text-center py-3 linkbtn" >Journal Report</a>
                                        </div>
                                    </div>
                                    <div class="col-md-2 p-1 sales_button" style="border-radius: 8px;">
                                        <div class="mx-1">
                                          <a href="{{route('chat.of.account.trail.balance.input')}}" class="btn btn-block text-center py-3 linkbtn" >Single Trail Balance</a>
                                        </div>
                                    </div>
                                    <div class="col-md-2 p-1 sales_button" style="border-radius: 8px;">
                                      <div class="mx-1">
                                        <a href="{{route('chat.of.account.extended.trail.balance.input')}}" class="btn btn-block text-center py-3 linkbtn" >Extended Trail Balance</a>
                                      </div>
                                    </div>
                                    
                                    <div class="col-md-2 p-1 sales_button" style="border-radius: 8px;">
                                      <div class="mx-1">
                                        <a href="{{route('chat.of.account.balance.sheet.input')}}" class="btn btn-block text-center py-3 linkbtn" >Balance Sheet</a>
                                      </div>
                                    </div>
                                    
                                  
                                    <div class="col-md-2 p-1 sales_button" style="border-radius: 8px;">
                                        <div class="mx-1">
                                          <a href="{{route('chat.of.account.compared.balance.sheet.input')}}" class="btn btn-block text-center py-3 linkbtn" >Compared Balance Sheet</a>
                                        </div>
                                    </div>
                                </div><!--.row-->
                          </div><!--#pills-reports-->
                          
                          <div class="tab-pane fade" id="pills-accountBook" role="tabpanel" aria-labelledby="pills-accountBook-tab">
                                <div class="row">
                                    <div class="col-md-2 p-1 sales_button" style="border-radius: 8px;">
                                        <div class="mx-1">
                                          <a href="{{URL('/report/daybook/index')}}" class="btn btn-block text-center py-3 linkbtn">Daybook</a>
                                        </div>
                                    </div>
                                    
                      	            <div class="col-md-2 p-1 sales_button" style="border-radius: 8px;">
                                        <div class="mx-1">
                                          <a href="{{ URL('/bank/book/index') }}" class="btn btn-block text-center py-3 linkbtn">Bank Book</a>
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-2 p-1 sales_button" style="border-radius: 8px;">
                                        <div class="mx-1">
                                          <a href="{{ URL('/cash/book/index') }}" class="btn btn-block text-center py-3 linkbtn">Cash Book</a>
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-2 p-1 sales_button" style="border-radius: 8px;">
                                        <div class="mx-1">
                                          <a href="{{route('journal.report.index')}}" class="btn btn-block text-center py-3 linkbtn" >Journal Book</a>
                                        </div>
                                    </div>
                                    
                                    <ul class="nav nav-pills account_dashboard_tab mb-3" id="pills-tab-2" role="tablist">
                                        <li class="nav-item" role="presentation">
                                            <button class="nav-link btn btn-block text-center py-3 linkbtn" style="border: 3px solid #003064;padding: 19px 63px !important;overflow: hidden;border-radius: 8px;" id="pills-ledgerBook-tab" data-toggle="pill" data-target="#pills-ledgerBook" type="button" role="tab" aria-controls="pills-ledgerBook" aria-selected="false">Ledger Book</button>
                                        </li>
                                    </ul>
                                    
                                    <div class="tab-content col-md-12" id="pills-tab2Content">
                                        <div class="tab-pane fade" id="pills-ledgerBook" role="tabpanel" aria-labelledby="pills-ledgerBook-tab">
                                            <div class="row">
                                                <div class="col-md-2 p-1 sales_button" style="border-radius: 8px;">
                                                    <div class="mx-1">
                                                      <a href="{{route('sales.ledger.index')}}" class="btn btn-block text-center py-3 linkbtn" >Sales Ledger</a>
                                                    </div>
                                                </div>
                                                <div class="col-md-2 p-1 sales_button" style="border-radius: 8px;">
                                                    <div class="mx-1">
                                                      <a href="{{route('purchase.ledger.index')}}" class="btn btn-block text-center py-3 linkbtn" >Purchase Ledger</a>
                                                    </div>
                                                </div>
                                                <div class="col-md-2 p-1 sales_button" style="border-radius: 8px;">
                                                    <div class="mx-1">
                                                      <a href="{{route('expasne.report.index')}}" class="btn btn-block text-center py-3 linkbtn" >Expanses Report</a>
                                                    </div>
                                                </div>
                                           </div><!--.row-->
                                        </div><!--#pills-bank-posting-->
                                    </div><!--.tab-content-->
                      	
                               </div><!--.row-->
                          </div><!--#pills-accountBook-->  
                          
                          <div class="tab-pane fade" id="pills-inventory-management" role="tabpanel" aria-labelledby="pills-inventory-management-tab">
                                <div class="row">
                                    {{--<div class="col-md-2 p-1 sales_button" style="border-radius: 8px;">
                                        <div class="mx-1">
                                          <a href="{{route('sales.stock.total.report.index')}}" class="btn btn-block text-center py-3 linkbtn" >F.G Stock Report</a>
                                        </div>
                                    </div>--}}
                                    
                                    <div class="col-md-2 p-1 sales_button" style="border-radius: 8px;">
                                        <div class="mx-1">
                                            <a href="{{route('fgTransfer.report.index')}}" class="btn btn-block text-center py-3 linkbtn" >F.G Inventory Report</a>
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-2 p-1 sales_button" style="border-radius: 8px;">
                                        <div class="mx-1">
                                            <a href="{{route('fgTransfer.short.summary.report.index')}}" class="btn btn-block text-center py-3 linkbtn" >F.G Short Summary</a>
                                        </div>
                                    </div>
                                    
                                    @if(Auth::id() != 169)
                                        <div class="col-md-2 p-1 sales_button" style="border-radius: 8px;">
                                            <div class="mx-1">
                                              <a href="{{route('purchase.stock.ledger.index')}}" class="btn btn-block text-center py-3 linkbtn" >R. M Stock Ledger </a>
                                            </div>
                                        </div>
                                    @endif
                                    
                                    <div class="col-md-2 p-1 sales_button" style="border-radius: 8px;">
                                        <div class="mx-1">
                                          <a href="{{route('purchase.rmShortSummary.index')}}" class="btn btn-block text-center py-3 linkbtn" >R. M Short Summary </a>
                                        </div>
                                    </div>
                               </div><!--.row-->
                          </div><!--#pills-inventory-management-->
                          
                          <div class="tab-pane fade" id="pills-sales-department" role="tabpanel" aria-labelledby="pills-sales-department-tab">
                                <div class="row">
                                    @if (in_array('salesledger', $salesdata))
                                        <div class="col-md-2 p-1 sales_button" style="border-radius: 8px;">
                                            <div class="mx-1">
                                              <a href="{{route('sales.ledger.index')}}" class="btn btn-block text-center py-3 linkbtn">Sales Ledger</a>
                                            </div>
                                        </div>
                                        
                                        <div class="col-md-3 p-1 sales_button" style="border-radius: 8px;">
                                            <div class="mx-1">
                                              <a href="{{route('all.sales.report.index')}}" class="btn btn-block text-center py-3 linkbtn">Zone Wise Sales Report</a>
                                            </div>
                                        </div>
                                    @endif
                                    
                                    <div class="col-md-3 p-1 sales_button" style="border-radius: 8px;">
                                        <div class="mx-1">
                                            <a href="{{route('short.summary.report.index')}}" class="btn btn-block text-center py-3 linkbtn" >Category Wise Sales R.</a>
                                        </div>
                                    </div>
                                
                                    <div class="col-md-3 p-1 sales_button" style="border-radius: 8px;">
                                        <div class="mx-1">
                                          <a href="{{route('category.wise.summary.report.index')}}" class="btn btn-block text-center py-3 linkbtn" >Category Wise Sumary R.</a>
                                        </div>
                                    </div>
                                    <div class="col-md-3 p-1 sales_button" style="border-radius: 8px;">
                                        <div class="mx-1">
                                          <a href="{{url('/sales/progress/report/individual/input')}}" class="btn btn-block text-center py-3 linkbtn" >Sales Progress Report (Individual)</a>
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-2 p-1 sales_button" style="border-radius: 8px;">
                                        <div class="mx-1">
                                          <a href="{{route('sales.return.report.index')}}" class="btn btn-block text-center py-3 linkbtn">Return Report</a>
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-2 p-1 sales_button" style="border-radius: 8px;">
                                        <div class="mx-1">
                                          <a href="{{route('sales.cogs.report')}}" class="btn btn-block text-center py-3 linkbtn" >COGS</a>
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-2 p-1 sales_button" style="border-radius: 8px;">
                                        <div class="mx-1">
                                          <a href="{{route('sales.discount.report.index')}}" class="btn btn-block text-center py-3 linkbtn">Discount Report</a>
                                        </div>
                                    </div>
                                    <div class="col-md-2 p-1 sales_button" style="border-radius: 8px;">
                                        <div class="mx-1">
                                          <a href="{{route('sales.categoryWiseGP.report.index')}}" class="btn btn-block text-center py-3 linkbtn">Brand Wise GP Report</a>
                                        </div>
                                    </div>
                                    
                               </div><!--.row-->
                          </div><!--#pills-sales-department-->  
                          
                          <hr/>
                            <div class="row">
                              {{--@if (in_array('purchaseledger', $purchasedata))--}}
                                <div class="col-md-2 my-2 sales_button" style="border-radius: 8px;">
                                   <div class="mx-1">
                                       <a href="{{route('purchase.reports')}}" class="btn btn-block  text-center py-3 linkbtn" >Purchase Report</a>
                                   </div>
                                </div>
                                {{--@endif--}}
                            </div><!--.row-->
                          
                        </div><!--.tab-content-->
                    </div>
                    <!--Tabs-->
                    
                
              

            {{-- <div class="col-md-2 p-1 sales_button" style="border-radius: 8px;">
              <div class="mx-1">
                <a href="{{route('chat.of.account.income.statement.input')}}" class="btn btn-block text-center py-3 linkbtn" >Income Statement</a>
              </div>
          </div> --}}
            

                  </div>
                </div>
                </div>


                 {{--   <div class="col-lg-12" style="height:390px;">
                      <h4 style="    display: flex;align-items: center;justify-content: center;width: 100%;height: 100%;">Accounts Deshboard</h4>
                    </div>
                    <div class="col-lg-12 px-5" style="">
                      <div class="input-group mb-3">
                        <input type="text" class="form-control" placeholder="Search here" aria-label="Recipient's username" aria-describedby="button-addon2">
                        <div class="input-group-append">
                          <button class="btn btn-primary" type="button" id="button-addon2" style="margin-left: -9px;"><i class="fas fa-search"></i></button>
                        </div>
                      </div>
                    </div>  --}}

        </div>
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->


@endsection


@push('end_js')
<script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>


@endpush
