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

      .content-wrapper .container{
      max-width: 1140px !important;
      background:#ffffff !important;
        padding:0px 40px !important;
        min-height:85vh !important;
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
      <div class="row">
       <div class="hover_manu_content" >
          @php

        $authid = Auth::id();
                  $salesdata = DB::table('permissions')
                 ->where('head', 'Sales')
                 ->where('user_id', $authid)
                 ->pluck('name')
                 ->toArray();
             $purchasedata = DB::table('permissions')
                 ->where('head', 'Purchase')
                 ->where('user_id', $authid)
                 ->pluck('name')
                 ->toArray();
             $accountsdata = DB::table('permissions')
                 ->where('head', 'Accounts')
                 ->where('user_id', $authid)
                 ->pluck('name')
                 ->toArray();
             $settingsdata = DB::table('permissions')
                 ->where('head', 'Settings')
                 ->where('user_id', $authid)
                 ->pluck('name')
                 ->toArray();


     @endphp
  {{-- style="background-image:url({{asset('public/ruby.jpg')}});background-size: contain;" --}}
        {{-- <div class="row pt-3">
           <div class="col-md-8 m-auto">
             <div class="row">
             <div class="col-md-3">
             	 @if (!empty($salesdata))
                      <a class="btn btn-primary btn-xl my-2  w-100 from-control mx-2 mainmanu" href="{{route('sales.dashboard')}}">Sales</a>
                  @endif
             </div>
             <div class="col-md-3">
               	@if (!empty($accountsdata))
                 <a class="btn btn-success btn-xl my-2  w-100 from-control mx-2 mainmanu" href="{{route('account.dashboard')}}" style="background: #28A745; border-color:#28A745;">Accounts</a>
                 @endif
             </div>
               <div class="col-md-3">
                  @if (!empty($settingsdata))
                 <a class="btn btn-primary btn-xl my-2 w-100 from-control mx-2 mainmanu" href="{{route('settings.dashboard')}}" style="background: #DC3545; border-color:#DC3545;">Settings</a>
                 @endif
               </div>
               <div class="col-md-3">
                  @if (!empty($settingsdata))
                 <a class="btn btn-primary btn-xl my-2 w-100 from-control mx-2 mainmanu" href="{{route('crm.dashboard')}}" style="background: #ae15d5; border-color:#ae15d5;">CRM</a>
                 @endif
               </div>
             </div>
         	</div>
          </div> --}}

        <div class="row pt-3">
          	<div class="col-md-4 m-auto sales_main_button">
              	<a href="{{route('purchase.dashboard')}}" class="text-center pt-1 pb-2 py-3 btn btn-block text-dark text-center linkbtn" >Purchase Department</a>
        	</div>
        </div>
       <div class="row pt-5 px-3">
                   @if (in_array('purchaseentry', $purchasedata))

                    <div class="col-md-2 p-1 sales_button" style="border-radius: 8px;">
                        <div class="mx-1">
                          <a href="{{route('purchase.entry')}}" class="btn btn-block  linkbtn text-center py-3" >GRR Entry</a>
                        </div>
                    </div>
                    <div class="col-md-2 p-1 sales_button" style="border-radius: 8px;">
                        <div class="mx-1">
                          <a href="{{route('purchase.index')}}" class="btn btn-block linkbtn text-center py-3" >Purchase List</a>
                        </div>
                    </div>
                    <div class="col-md-2 p-1 sales_button" style="border-radius: 8px;">
                        <div class="mx-1">
                          <a href="{{route('purchase.bag.entry')}}" class="btn btn-block linkbtn text-center py-3" >MRR Entry (Bag)</a>
                        </div>
                    </div>

                    <div class="col-md-2 p-1 sales_button" style="border-radius: 8px;">
                        <div class="mx-1">
                          <a href="{{route('purchase.bag.index')}}" class="btn btn-block linkbtn text-center py-3" >Bag List</a>
                        </div>
                    </div>
                  <div class="col-md-2 p-1 sales_button" style="border-radius: 8px;">
                        <div class="mx-1">
                          <a href="{{route('finish.goods.manual.purchse.create')}}" class="btn btn-block  linkbtn text-center py-3" >MRR Entry (F.G)</a>
                        </div>
                    </div>
                  <div class="col-md-2 p-1 sales_button" style="border-radius: 8px;">
                        <div class="mx-1">
                          <a href="{{route('finish.goods.manual.purchse.list')}}" class="btn btn-block linkbtn text-center py-3">F.G. Purchase List</a>
                        </div>
                    </div>
                    @endif
                    @if (in_array('production', $purchasedata))
                    <div class="col-md-2 p-1 sales_button" style="border-radius: 8px;">
                        <div class="mx-1">
                          <a href="{{route('production.stock.out.list')}}" class="btn btn-block text-center linkbtn py-3">Production</a>
                        </div>
                    </div>
                  @endif
                   @if (in_array('purchaseentry', $purchasedata))
                  <div class="col-md-2 p-1 sales_button" style="border-radius: 8px;">
                      <div class="mx-1">
                        <a href="{{route('production.cost.menu')}}" class="btn btn-block text-center linkbtn py-3">Cost</a>
                      </div>
                  </div>
                  @endif
                   @if (in_array('purchaseledger', $purchasedata))
                   <div class="col-md-2 my-2 sales_button" style="border-radius: 8px;">
                       <div class="mx-1">
                           <a href="{{route('purchase.reports')}}" class="btn btn-block  text-center py-3 linkbtn" >Purchase Report</a>
                       </div>
                   </div>
                    <div class="col-md-2 p-1 sales_button" style="border-radius: 8px;">
                        <div class="mx-1">
                          <a href="{{route('purchase.ledger.index')}}" class="btn btn-block linkbtn text-center py-3" >Ledger</a>
                        </div>
                    </div>
                  @endif
                  @if (in_array('generalpurchase', $purchasedata))


                    <div class="col-md-2 p-1 sales_button" style="border-radius: 8px;">
                        <div class="mx-1">
                          <a href="{{route('general.purchase.page.index')}}" class="btn btn-block text-center linkbtn py-3" >General</a>
                        </div>
                    </div>
                   @endif
                  @if (in_array('purchaseentry', $purchasedata))
                    <div class="col-md-2 p-1 sales_button" style="border-radius: 8px;">
                        <div class="mx-1">
                          <a href="{{route('purchase.return.index')}}" class="btn btn-block  text-center linkbtn py-3" >Return</a>
                        </div>
                    </div>

                    <div class="col-md-2 p-1 sales_button" style="border-radius: 8px;">
                        <div class="mx-1">
                          <a href="{{route('purchase.transfer.index')}}" class="btn btn-block text-center linkbtn py-3" >Transfer</a>
                        </div>
                    </div>

                    <div class="col-md-2 p-1 sales_button" style="border-radius: 8px;">
                        <div class="mx-1">
                          <a href="{{route('purchase.damage.index')}}" class="btn btn-block text-center linkbtn py-3">Damage</a>
                        </div>
                    </div>

                  <div class="col-md-2 p-1 sales_button" style="border-radius: 8px;">
                        <div class="mx-1">
                          <a href="{{route('purchase.set_margin.index')}}" class="btn btn-block text-center linkbtn py-3" >Set Margin</a>
                        </div>
                    </div>

                    <div class="col-md-2 p-1 sales_button" style="border-radius: 8px;">
                        <div class="mx-1">
                          <a href="{{route('supplier.index')}}" class="btn btn-block  text-center linkbtn py-3" >Supplier</a>
                        </div>
                    </div>
                    @endif
                     @if (in_array('lcentry', $purchasedata))
                    <div class="col-md-2 p-1 sales_button" style="border-radius: 8px;">
                        <div class="mx-1">
                          <a href="{{route('lcEntryIndex')}}" class="btn btn-block  text-center linkbtn py-3" >L.C</a>
                        </div>
                    </div>
                    @endif
                @if (in_array('purchaseentry', $purchasedata))
                    <div class="col-md-2 p-1 sales_button" style="border-radius: 8px;">
                        <div class="mx-1">
                          <a href="{{route('row.materials.index')}}" class="btn btn-block text-center linkbtn py-3" >R. Materials</a>
                        </div>
                    </div>
                  <div class="col-md-2 p-1 sales_button" style="border-radius: 8px;">
                        <div class="mx-1">
                          <a href="{{route('row.materials.issues.index')}}" class="btn btn-block text-center linkbtn py-3" >Stock Out Issues</a>
                        </div>
                    </div>
                    <div class="col-md-2 p-1 sales_button" style="border-radius: 8px;">
                        <div class="mx-1">
                          <a href="{{route('rfq.list')}}" class="btn btn-block text-center linkbtn py-3" >RFQ Order</a>
                        </div>
                    </div>
                    <div class="col-md-2 p-1 sales_button" style="border-radius: 8px;">
                        <div class="mx-1">
                          <a href="{{route('cs.list')}}" class="btn btn-block text-center linkbtn py-3" >Comparative Statement</a>
                        </div>
                    </div>
                    <div class="col-md-2 p-1 sales_button" style="border-radius: 8px;">
                        <div class="mx-1">
                          <a href="{{route('purchaseOrderList')}}" class="btn btn-block text-center linkbtn py-3" >Purchase Order</a>
                        </div>
                    </div>
                    <div class="col-md-2 p-1 sales_button" style="border-radius: 8px;">
                        <div class="mx-1">
                          <a href="{{route('qualityControlList')}}" class="btn btn-block text-center linkbtn py-3" >Quality Control</a>
                        </div>
                    </div>
                  <div class="col-md-2 p-1 sales_button" style="border-radius: 8px;">
                        <div class="mx-1">
                          <a href="{{route('fgQualityControlList')}}" class="btn btn-block text-center linkbtn py-3" >F G Quality Control</a>
                        </div>
                    </div>

                  @endif
                  @if (in_array('purchasereport', $purchasedata))
                    {{-- <div class="col-md-2 p-1 sales_button" style="border-radius: 8px;">
                        <div class="mx-1">
                          <a href="{{route('purchase.reports')}}" class="btn btn-block text-center linkbtn py-3">GRR Reports</a>
                        </div>
                    </div> --}}

                  <div class="col-md-2 p-1 sales_button" style="border-radius: 8px;">
                        <div class="mx-1">
                          <a href="{{route('production.reports')}}" class="btn btn-block text-center linkbtn py-3">Production Reports</a>
                        </div>
                    </div>
					@endif
					<div class="col-md-2 p-1 sales_button" style="border-radius: 8px;">
                        <div class="mx-1">
                          <a href="{{route('rentalProfileIndex')}}" class="btn btn-block text-center linkbtn py-3">Rental</a>
                        </div>
                    </div>
                  </div>
        </div>
      </div>
      </div><!-- /.container-fluid -->

   {{--  <div style="position: absolute; padding:10px"  class="menuclass">
      <a href="{{route('purchase.dashboard')}}" class="btn btn-sm btn-primary">Menu </a>

  </div> --}}







        @yield('content')


  @php
  $saleslimit = DB::table('margins')->where('head',"Purchase")->first();
  if($saleslimit != null){
   $salesamount = $saleslimit->amount;
  }else{
   $salesamount = 0;
  }


  $thisdate = date('Y-m-d');

  $totalsaleamout = DB::table('purchase_ledgers')->where('date',$thisdate)->sum('credit');

@endphp

  @if($salesamount < $totalsaleamout  && $salesamount != 0)
    <input type="hidden" id="saleslimitmargin" class="form-control" value="1">

  @else
  <input type="hidden" id="saleslimitmargin" class="form-control" value="0">
  @endif




<!-- /.Modal -->
<div class="modal fade" id="salesOvermarginlimite">
        <div class="modal-dialog">
          <div class="modal-content bg-danger" >
            <div class="modal-header">
              <h4 class="modal-title">Purchase Limite Over</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body ">

               <p>Purchase Limit is Over Today </p>
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

  <script>

  </script>








</body>

</html>
