<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>NCC | V.3.5</title>

 

    @include('_partials_.css')
  
    <link rel="stylesheet" href="{{ asset('public/css/customcss_sales.css') }}">

    <style>
    #pushnavbar{
        display:none;
    }
      
      .hovermanu{
          display: inline-block;
        font-size:25px;
      }
      
      .linkbtn{
        font-size: 16px; 
        font-weight: 800; 
        border: 3px solid #003064; 
        border-radius: 8px;
        padding: 20px 8px !important
      }
      
      .content-wrapper .container-fluid, .content-wrapper .container{
      background:#ffffff !important; 
        padding:0px 40px !important;
        min-height:85vh ;
}  
  </style>

</head>
  
 
<!--
`body` tag options:

  Apply one or more of the following classes to to the body tag
  to get the desired effect

  * sidebar-collapse
  * sidebar-mini
-->
@section('headernavmanuname')
  <li class="nav-item mr-3">
   <a href="{{url('/')}}" class="navbar-brand">
        <img src="{{ asset('public/backend/dist/img/AdminLTELogo.png') }}" alt="AdminLTE Logo"
                    class="brand-image img-circle elevation-3" style="opacity: .8">
                <span class="brand-text font-weight-light">SBMS | V.3.5</span>
      </a>
    </li>
 @endsection
<body class="hold-transition sidebar-collapse layout-top-nav">
<div class="wrapper">
        <!-- Navbar -->
        @include('_partials_.navbar')
  
  {{-- FOr Manu --}}
  
  
    <div class="container-fluid" style="position:relative;">
       <div class="hover_manu_content" >
          @php
         $authid = Auth::id();
         $salesdata = DB::table('permissions')
             ->where('head', 'Sales')
             ->where('user_id', $authid)
             ->pluck('name')
             ->toArray();
       
         
     @endphp
         
        <div class="row pt-3">
              <div class="col-md-4 m-auto sales_main_button">
                  <a href="{{route('sales.dashboard')}}" class="text-center pt-1 pb-2 py-3 btn btn-block text-dark text-center salesdashboardname" style="border: 3px solid #003064; border-radius: 8px;font-weight: 800;font-size: 24px;">Sales Department</a>
              </div>
        </div>
         
         
          <div class="row pt-5 px-3 text-center">
                     @if (in_array('salesentry', $salesdata))
                      <div class="col-md-2 p-1 sales_button" style="border-radius: 8px;">
                          <div class="mx-1">
                            <a href="{{route('sales.create')}}" class="btn btn-block  text-center py-3 linkbtn">Sales Entry</a>
                          </div>
                      </div>

                      <div class="col-md-2 p-1 sales_button" style="border-radius: 8px;">
                          <div class="mx-1">
                            <a href="{{route('sales.index')}}" class="btn btn-block  text-center py-3 linkbtn">Sales List</a>
                          </div>
                      </div>
                  @endif
                    @if (in_array('salesdc', $salesdata))
                    <div class="col-md-2 p-1 sales_button" style="border-radius: 8px;">
                        <div class="mx-1">
                          <a href="{{route('delivery.status')}}" class="btn btn-block text-dark text-center py-3 linkbtn">D.C</a>
                        </div>
                    </div>
                 @endif
                 @if (in_array('salestc', $salesdata))
                    <div class="col-md-2 p-1 sales_button" style="border-radius: 8px;">
                        <div class="mx-1">
                          <a href="{{route('transfer.status')}}" class="btn btn-block text-dark text-center py-3 linkbtn">T.C</a>
                        </div>
                    </div>
                @endif

                    @if (in_array('salesledger', $salesdata))

                    <div class="col-md-2 p-1 sales_button" style="border-radius: 8px;">
                        <div class="mx-1">
                          <a href="{{route('sales.ledger.index')}}" class="btn btn-block  text-center py-3 linkbtn">Sales Ledger</a>
                        </div>
                    </div>
                    @endif


                       @if (in_array('order', $salesdata))
                    <div class="col-md-2 p-1 sales_button" style="border-radius: 8px;">
                        <div class="mx-1">
                          <a href="{{route('sales.order.index')}}" class="btn btn-block text-dark text-center py-3 linkbtn">Order & List</a>
                        </div>
                    </div>
                    @endif

                    @if (in_array('screate', $salesdata))

                    <div class="col-md-2 p-1 sales_button" style="border-radius: 8px;">
                        <div class="mx-1">
                          <a href="{{route('dealer.index')}}" class="btn btn-block text-center py-3 linkbtn">Dealers</a>
                        </div>
                   </div>


                    <div class="col-md-2 p-1 sales_button" style="border-radius: 8px;">
                        <div class="mx-1">
                          <a href="{{route('sales.item.index')}}" class="btn btn-block text-center py-3 linkbtn">Products</a>
                        </div>
                    </div>

                    <div class="col-md-2 p-1 sales_button" style="border-radius: 8px;">
                        <div class="mx-1">
                          <a href="{{route('sales.damage.index')}}" class="btn btn-block  text-center py-3 linkbtn">Damage</a>
                        </div>
                    </div>

                    <div class="col-md-2 p-1 sales_button" style="border-radius: 8px;">
                        <div class="mx-1">
                          <a href="{{route('product.transfer.list')}}" class="btn btn-block text-center py-3 linkbtn">Transfer</a>
                        </div>
                    </div>

                    <div class="col-md-2 p-1 sales_button" style="border-radius: 8px;">
                        <div class="mx-1">
                          <a href="{{route('sales.return.index')}}" class="btn btn-block text-center py-3 linkbtn">Return</a>
                        </div>
                    </div>
                    <div class="col-md-2 p-1 sales_button" style="border-radius: 8px;">
                        <div class="mx-1">
                          <a href="{{route('sales.return.report.index')}}" class="btn btn-block text-center py-3 linkbtn">Return Report</a>
                        </div>
                    </div>

                    <div class="col-md-2 p-1 sales_button" style="border-radius: 8px;">
                        <div class="mx-1">
                          <a href="{{route('sales.set_margin.index')}}" class="btn btn-block  text-center py-3 linkbtn">Set Margin</a>
                        </div>
                    </div>

                    <div class="col-md-2 p-1 sales_button" style="border-radius: 8px;">
                        <div class="mx-1">
                          <a href="{{route('sales.monthly.incentive')}}" class="btn btn-block  text-center py-3 linkbtn">Incentives</a>
                        </div>
                    </div>

                    <div class="col-md-2 p-1 sales_button" style="border-radius: 8px;">
                        <div class="mx-1">
                          <a href="{{route('production.stock.in.list')}}" class="btn btn-block text-center py-3 linkbtn">F.G Stocks</a>
                        </div>
                    </div>

                    <div class="col-md-2 p-1 sales_button " style="border-radius: 8px;">
                        <div class="mx-1">
                          <a href="{{route('special.rate.create')}}" class="btn btn-block text-center py-3 linkbtn">Spacial Rate</a>
                        </div>
                    </div>
                     @endif

                    @if (in_array('salesreport', $salesdata))
                    <div class="col-md-2 p-1 sales_button" style="border-radius: 8px;">
                        <div class="mx-1 ">
                          <a href="{{route('reports.index')}}" class="btn btn-block text-center py-3 linkbtn">Reports</a>
                        </div>
                    </div>
                    @endif
                  </div>
        </div>
        </div>
        </div>
      </div><!-- /.container-fluid -->
  
  {{-- <div class="menuclass" style="position: absolute; padding:3px">
      <a href="{{route('sales.dashboard')}}" class=""  data-toggle="tooltip" data-placement="bottom" title="Menu"><i class="fa fa-arrow-left" aria-hidden="true"></i> </a>
               
  </div> --}}
  
        
      
 
  
  
        @yield('content')
  
  
  
  
@php
  $saleslimit = DB::table('margins')->where('head',"Sales")->first();
  
  if($saleslimit != null){
   $salesamount = $saleslimit->amount;
  }else{
   $salesamount = 0;
  }
  
  
 //dd($salesamount);
  
  $thisdate = date('Y-m-d');
  
  $totalsaleamout = DB::table('sales_ledgers')->where('ledger_date',$thisdate)->sum('debit');
  
  
  
@endphp
  
  @if($salesamount < $totalsaleamout && $salesamount != 0)
    <input type="hidden" id="saleslimitmargin" class="form-control" value="1">
 
  @else
  <input type="hidden" id="saleslimitmargin" class="form-control" value="0">
  @endif




<!-- /.Modal -->
<div class="modal fade" id="salesOvermarginlimite">
        <div class="modal-dialog">
          <div class="modal-content bg-danger" >
            <div class="modal-header">
              <h4 class="modal-title">Sales Limite Over</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body ">
             
               <p>Sales Limit is Over Today </p>
            </div>
            <div class="modal-footer justify-content-between">
                <p  ></p>
              <button type="button" class="btn btn-primary"data-dismiss="modal">Close</button>
            </div>
          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
      </div>
    




  

        <!-- Control Sidebar -->
        <aside class="control-sidebar control-sidebar-dark">
            <!-- Control sidebar content goes here -->
        </aside>
        <!-- /.control-sidebar -->

        <!-- Main Footer -->
      @include('_partials_.notification_modal')
      
        @include('_partials_.footer')
    </div>
    <!-- ./wrapper -->

    <!-- REQUIRED SCRIPTS -->

 
  <script>
      $(document).ready(function() {
        
        var limitval = $('#saleslimitmargin').val();
        
        if(limitval == 1){
            $('#salesOvermarginlimite').modal('show');
        }
            
      });
    
  </script>

    @include('_partials_.js')
  
    @include('_partials_.sales_js')
  
     
 
 



   


    

</body>

</html>
