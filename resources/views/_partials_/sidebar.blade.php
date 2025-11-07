 <!-- Sidebar -->
 <div class="sidebar">
     <!-- Sidebar user panel (optional) -->
     {{--<div class="user-panel mt-3 pb-3 mb-3 d-flex">
         <div class="image">
             <div class="text-white pt-2">
                 <i class="fas fa-tachometer-alt"></i>
             </div>
         </div>
         <div class="info">
             <a href="{{ URL('/') }}" class="d-block"
                 style="    font-size: 20px;font-weight: bold;color: white;">Dashboard</a>
         </div>
     </div> --}}

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
        $marketingdata = DB::table('permissions')
                      ->where('head', 'Marketing')
                      ->where('user_id', $authid)
                      ->pluck('name')
                      ->toArray();

     @endphp


     <!-- Sidebar Menu -->
     <nav class="mt-2">
         <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
             <!-- Add icons to  -->

		@if (!empty($salesdata))
		    <a class="btn btn-primary my-1 mx-2 mainmanu" href="{{route('sales.dashboard')}}">Sales</a>
        @endif
          @if (!empty($purchasedata))
           <a  class="btn btn-primary my-1 mx-2 mainmanu" href="{{route('purchase.dashboard')}}" style="background: #bd7e0b; border-color:#bd7e0b;">Purchase</a>
            @endif
            @if (!empty($accountsdata))
           <a class="btn btn-primary my-1 mx-2 mainmanu" href="{{route('account.dashboard')}}" style="background: #28A745; border-color:#28A745;">Accounts</a>
           @endif
            @if (!empty($settingsdata))
           <a class="btn btn-primary my-1 mx-2 mainmanu" href="{{route('settings.dashboard')}}" style="background: #DC3545; border-color:#DC3545;">Settings</a>
           @endif
           @if (!empty($marketingdata))
           <a class="btn btn-primary my-1 mx-2 mainmanu" href="{{route('crm.dashboard')}}" style="background: #ae15d5; border-color:#ae15d5;">Marketing</a>
           @endif
           <a class="btn btn-primary my-1 mx-2 mainmanu" href="{{route('tenderBidding.dashboard')}}" style="background: #045f8f; border-color:#045f8f;">Tender Bidding</a>

           <a class="btn btn-primary my-1 mx-2 mainmanu" href="{{route('hrpayroll.dashboard')}}" style="background: #b8cd0b; border-color:#b8cd0b;">HR & Payroll</a>

           <a class="btn btn-primary my-1 mx-2 mainmanu" href="{{route('hrpayroll.employee.selfServiceProfile.dashboard')}}" >Employee Portal</a>



      {{--

           @if (!empty($salesdata))
                 <li class="nav-item">
                     <a href="#" class="nav-link">
                         <i class="fab fas fa-cart-plus"></i>
                         <p>
                             Sales
                             <i class="fas fa-angle-left right"></i>
                         </p>
                     </a>


                     <ul class="nav nav-treeview">

                         @if (in_array('salesentry', $salesdata))

                             <li class="nav-item">
                                 <a href="{{ URL('/sales/create') }}" class="nav-link">
                                     <i class="fas fa-cart-plus"></i>
                                     <p>
                                         POS
                                     </p>
                                 </a>
                             </li>



                             <li class="nav-item">
                                 <a href="{{ URL('/sales/list') }}" class="nav-link">
                                     <i class="fas fa-shopping-cart"></i>
                                     <p>Sales List</p>
                                 </a>
                             </li>

                         @endif


                         @if (in_array('salesledger', $salesdata))

                             <li class="nav-item">
                                 <a href="{{ URL('/sales/ledger/index') }}" class="nav-link">
                                     <i class="far fa-sticky-note"></i>
                                     <p>
                                         Sales Ledger
                                     </p>
                                 </a>
                             </li>

                         @endif

                         @if (in_array('salesreport', $salesdata))
                             <li class="nav-item">
                                 <a href="#" class="nav-link">
                                     <i class="far fa-file-alt"></i>
                                     <p>
                                         Sales Reports
                                         <i class="fas fa-angle-left right"></i>
                                     </p>
                                 </a>
                                 <ul class="nav nav-treeview">
                                     <li class="nav-item">
                                         <a href="{{ URL('/daily/sales/report/index') }}" class="nav-link">
                                             <i class="far fa-file-alt"></i>
                                             <p>Daily Sales Report</p>
                                         </a>
                                     </li>

                                     <li class="nav-item">
                                         <a href="{{ URL('/short/summary/report/index') }}" class="nav-link">
                                             <i class="far fa-file-alt"></i>
                                             <p>Short Summary Report</p>
                                         </a>
                                     </li>



                             <li class="nav-item">
                                 <a href="{{ URL('/sales/total/ledger/index') }}" class="nav-link">
                                     <i class="far fa-sticky-note"></i>
                                     <p>
                                         Total Sales Report
                                     </p>
                                 </a>
                             </li>



                                     <li class="nav-item">
                                         <a href="{{ URL('/monthly/sales/report/index') }}" class="nav-link">
                                             <i class="far fa-file-alt"></i>
                                             <p>Monthly Sales Statement R.</p>
                                         </a>
                                     </li>

                                     <li class="nav-item">
                                         <a href="{{ URL('/zone/wise/sales/report/index') }}" class="nav-link">
                                             <i class="far fa-file-alt"></i>
                                             <p>Zone Wise Sales Statement R.</p>
                                         </a>
                                     </li>
                                     <li class="nav-item">
                                         <a href="{{ URL('/yearly/vendor/sales/report/index') }}"
                                             class="nav-link">
                                             <i class="far fa-file-alt"></i>
                                             <p>Yearly Vendor Sales Statement R.</p>
                                         </a>
                                     </li>

                                     <li class="nav-item">
                                         <a href="{{ URL('/yearly/vendor/daterange/sales/report/index') }}"
                                             class="nav-link">
                                             <i class="far fa-file-alt"></i>
                                             <p>Daterange Yearly Vendor Sales Statement R.</p>
                                         </a>
                                     </li>

                                     <li class="nav-item">
                                         <a href="{{ URL('/yearly/sales/statement/report/index') }}"
                                             class="nav-link">
                                             <i class="far fa-file-alt"></i>
                                             <p>Yearly Sales Statement R.</p>
                                         </a>
                                     </li>

                                     <li class="nav-item">
                                         <a href="{{ URL('/monthly/employee/target/report/index') }}"
                                             class="nav-link">
                                             <i class="far fa-file-alt"></i>
                                             <p>Monthly Employee Target R.</p>
                                         </a>
                                     </li>
                                     <li class="nav-item">
                                         <a href="{{ URL('/yearly/sales/target/report/index') }}"
                                             class="nav-link">
                                             <i class="far fa-file-alt"></i>
                                             <p>Yearly  Target Report.</p>
                                         </a>
                                     </li>


                                      <li class="nav-item">
                                         <a href="{{ URL('/sales-report/yearly-short-summary-target-report-input') }}"
                                             class="nav-link">
                                             <i class="far fa-file-alt"></i>
                                             <p>Yearly  Short Summary Report.</p>
                                         </a>
                                     </li>
                                   <li class="nav-item">
                                         <a href="{{ URL('/sales-report/yearly-short-summary-company-report-input') }}"
                                             class="nav-link">
                                             <i class="far fa-file-alt"></i>
                                             <p>Yearly  Company Summary Report.</p>
                                         </a>
                                     </li>


                                     <li class="nav-item">
                                         <a href="{{ URL('/sales/trial/balance/index') }}" class="nav-link">
                                             <i class="far fa-file-alt"></i>
                                             <p>Trail Balance</p>
                                         </a>
                                     </li>




                                     <li class="nav-item">
                                         <a href="{{ URL('/sales/stock/report/index') }}" class="nav-link">
                                             <i class="far fa-file-alt"></i>
                                             <p>Stock Report</p>
                                         </a>
                                     </li>

                                     <li class="nav-item">
                                         <a href="{{ URL('/sales/stock/total/report/index') }}"
                                             class="nav-link">
                                             <i class="far fa-file-alt"></i>
                                             <p>Total Stock Report</p>
                                         </a>
                                     </li>


                                     <li class="nav-item">
                                         <a href="{{ URL('/various/vendor/report/index') }}" class="nav-link">
                                             <i class="far fa-file-alt"></i>
                                             <p>Various Type Vendor Report</p>
                                         </a>
                                     </li>

                                     <li class="nav-item">
                                         <a href="{{ route('sales.cogs.report') }}" class="nav-link">
                                             <i class="far fa-sticky-note"></i>
                                             <p>
                                                 Sales COGS Report
                                             </p>
                                         </a>
                                     </li>
                                    <li class="nav-item">
                                         <a href="{{ route('zonewise.pie.chart.index') }}" class="nav-link">
                                             <i class="far fa-sticky-note"></i>
                                             <p>
                                                 Zonewise Pie Chart
                                             </p>
                                         </a>
                                     </li>
                                 </ul>
                             </li>
                         @endif

                        <li class="nav-item">
                                 <a href="{{ route('delivery.status') }}" class="nav-link">
                                     <i class="fas fa-list-alt"></i>
                                     <p>DC</p>
                                 </a>
                             </li>



                         @if (in_array('order', $salesdata))

                             <li class="nav-item">
                                 <a href="#" class="nav-link">
                                     <i class="fab fas fa-cart-plus"></i>
                                     <p>
                                         Order
                                         <i class="fas fa-angle-left right"></i>
                                     </p>
                                 </a>
                                 <ul class="nav nav-treeview">
                                     <li class="nav-item">
                                         <a href="{{ URL('/sales/order/create') }}" class="nav-link">
                                             <i class="fas fa-cart-plus"></i>
                                             <p>
                                                 Order Create
                                             </p>
                                         </a>
                                     </li>
                                     <li class="nav-item">
                                         <a href="{{ URL('/sales/order/list') }}" class="nav-link">
                                             <i class="fas fa-shopping-cart"></i>
                                             <p>Order List</p>
                                         </a>
                                     </li>


                                 </ul>
                             </li>

                         @endif

                         @if (in_array('screate', $salesdata))

                             <li class="nav-item">
                                 <a href="{{ route('sales.return.index') }}" class="nav-link">
                                     <i class="fas fa-shipping-fast"></i>
                                     <p>Return</p>
                                 </a>
                             </li>


                             <li class="nav-item">
                                 <a href="{{ route('product.transfer.list') }}" class="nav-link">
                                     <i class="fas fa-list-alt"></i>
                                     <p>Transfer </p>
                                 </a>
                             </li>
                             <li class="nav-item">
                                 <a href="{{ route('sales.damage.index') }}" class="nav-link">
                                     <i class="fas fa-list-alt"></i>
                                     <p>Damage </p>
                                 </a>
                             </li>


                         		<li class="nav-item">
                                         <a href="{{ route('production.stock.in.list') }}" class="nav-link">
                                             <i class="fas fa-layer-group"></i>
                                             <p>Finished Goods Stock In (Manual)</p>
                                         </a>
                                     </li>

                             <li class="nav-item">
                                 <a href="#" class="nav-link">
                                     <i class="fas fa-user-tie"></i>
                                     <p>
                                         Vendor
                                         <i class="fas fa-angle-left right"></i>
                                     </p>
                                 </a>
                                 <ul class="nav nav-treeview">
                                     <li class="nav-item">
                                         <a href="{{ URL('/deler/create') }}" class="nav-link">
                                             <i class="far fa-edit"></i>
                                             <p>Create Vendor</p>
                                         </a>
                                     </li>
                                     <li class="nav-item">
                                         <a href="{{ URL('/deler/index') }}" class="nav-link">
                                             <i class="far fa-list-alt"></i>
                                             <p>Vendor List</p>
                                         </a>
                                     </li>

                                     <li class="nav-item">
                                         <a href="{{ Route('dealer.type.create') }}" class="nav-link">
                                             <i class="fas fa-user-tie"></i>
                                             <p>Vendor Type</p>
                                         </a>
                                     </li>


                                     <li class="nav-item">
                                         <a href="{{ Route('dealer.zone.create') }}" class="nav-link">
                                             <i class="fas fa-user-tie"></i>
                                             <p>Vendor Zone</p>
                                         </a>
                                     </li>



                                     <li class="nav-item">
                                         <a href="{{ Route('dealer.subzone.create') }}" class="nav-link">
                                             <i class="fas fa-user-tie"></i>
                                             <p>Vendor SubZone</p>
                                         </a>
                                     </li>

                                     <li class="nav-item">
                                         <a href="{{ Route('dealer.area.create') }}" class="nav-link">
                                             <i class="fas fa-user-tie"></i>
                                             <p>Vendor Area</p>
                                         </a>
                                     </li>
                                 </ul>
                             </li>

                        	<li class="nav-item">
                                         <a href="{{ Route('sales.monthly.incentive') }}" class="nav-link">
                                             <i class="fas fa-user-tie"></i>
                                             <p>Monthly Incentive</p>
                                         </a>
                                     </li>


                       <li class="nav-item">
                                         <a href="{{ Route('sales.yearly.incentive') }}" class="nav-link">
                                             <i class="fas fa-user-tie"></i>
                                             <p>Yearly Incentive</p>
                                         </a>
                                     </li>


                             <li class="nav-item">
                                 <a href="#" class="nav-link">
                                     <i class="fab fa-product-hunt"></i>
                                     <p>
                                         Sales Product
                                         <i class="fas fa-angle-left right"></i>
                                     </p>
                                 </a>
                                 <ul class="nav nav-treeview">
                                     <li class="nav-item">
                                         <a href="{{ URL('/sales/item/create') }}" class="nav-link">
                                             <i class="fas fa-university"></i>
                                             <p>Sales Item Create</p>
                                         </a>
                                     </li>
                                     <li class="nav-item">
                                         <a href="{{ URL('/sales/item/index') }}" class="nav-link">
                                             <i class="fas fa-university"></i>
                                             <p>Sales Item List</p>
                                         </a>
                                     </li>

                                     <li class="nav-item">
                                         <a href="{{ URL('/sales/category/index') }}" class="nav-link">
                                             <i class="fas fa-university"></i>
                                             <p>Sales Item Category</p>
                                         </a>
                                     </li>


                                 </ul>
                             </li>

                             <li class="nav-item">
                                 <a href="{{ route('special.rate.create') }}" class="nav-link">
                                     <i class="fas fa-list-alt"></i>
                                     <p>Special Rate</p>
                                 </a>
                             </li>

                           <li class="nav-item">
                                 <a href="{{ route('stockin.notification.list') }}" class="nav-link">
                                     <i class="fas fa-list-alt"></i>
                                     <p>Stock Notification</p>
                                 </a>
                             </li>


                         @endif
                     </ul>
                 </li>
             @endif





             @if (!empty($purchasedata))
                 <li class="nav-item">
                     <a href="#" class="nav-link">
                         <i class="fab fas fa-cart-plus"></i>
                         <p>
                             Purchase & Manufacture
                             <i class="fas fa-angle-left right"></i>
                         </p>
                     </a>
                     <ul class="nav nav-treeview">




                         @if (in_array('purchaseentry', $purchasedata))

                             <li class="nav-item">
                                 <a href="{{ URL('/purchase/index') }}" class="nav-link">
                                     <i class="fas fa-th-list"></i>
                                     <p>Purchase List</p>
                                 </a>
                             </li>


                             <li class="nav-item">
                                 <a href="{{ URL('/purchase/entry') }}" class="nav-link">
                                     <i class="fas fa-shopping-bag"></i>
                                     <p>
                                         Purchase Entry
                                     </p>
                                 </a>
                             </li>

                             <li class="nav-item">
                                 <a href="{{ URL('/purchase/bag/index') }}" class="nav-link">
                                     <i class="fas fa-th-list"></i>
                                     <p>Purchase Bag List</p>
                                 </a>
                             </li>

                             <li class="nav-item">
                                 <a href="{{ URL('/purchase/bag/entry') }}" class="nav-link">
                                     <i class="fas fa-shopping-bag"></i>
                                     <p>
                                         Purchase Bag Entry
                                     </p>
                                 </a>
                             </li>

                         @endif

                         @if (in_array('production', $purchasedata))

                             <li class="nav-item">
                                 <a href="#" class="nav-link">
                                     <i class="fas fa-industry"></i>
                                     <p>
                                         Production
                                         <i class="fas fa-angle-left right"></i>
                                     </p>
                                 </a>
                                 <ul class="nav nav-treeview">

                                     <li class="nav-item">
                                         <a href="{{ route('production.stock.out.list') }}" class="nav-link">
                                             <i class="fas fa-layer-group"></i>
                                             <p>Production Stock Out List</p>
                                         </a>
                                     </li>

                                     <li class="nav-item">
                                         <a href="{{ route('production.stock.out.create') }}"
                                             class="nav-link">
                                             <i class="fas fa-layer-group"></i>
                                             <p>Production Stock Out</p>
                                         </a>
                                     </li>


                                     <li class="nav-item">
                                         <a href="{{ route('production.stockout.report.index') }}"
                                             class="nav-link">
                                             <i class="fas fa-layer-group"></i>
                                             <p>Production StockOut Report</p>
                                         </a>
                                     </li>

                                    <li class="nav-item">
                                         <a href="{{ URL('/production/cogm/report/index') }}"
                                             class="nav-link">
                                             <i class="far fa-file-alt"></i>
                                             <p>C.O.G.M. Report</p>
                                         </a>
                                     </li>




                                 </ul>
                             </li>
                         @endif

                         @if (in_array('purchaseledger', $purchasedata))
                             <li class="nav-item">
                                 <a href="#" class="nav-link">
                                     <i class="far fa-file-alt"></i>
                                     <p>
                                         Purchase Ledgers
                                         <i class="fas fa-angle-left right"></i>
                                     </p>
                                 </a>
                                 <ul class="nav nav-treeview">
                                     <li class="nav-item">
                                         <a href="{{ URL('/purchase/ledger/index') }}" class="nav-link">
                                             <i class="fas fa-shopping-bag"></i>
                                             <p>
                                                 Purchase Ledger
                                             </p>
                                         </a>
                                     </li>

                                     <li class="nav-item">
                                         <a href="{{ URL('/purchase/stock/ledger/index') }}" class="nav-link">
                                             <i class="fas fa-shopping-bag"></i>
                                             <p>
                                                 Stock Ledger
                                             </p>
                                         </a>
                                     </li>

                                     <li class="nav-item">
                                         <a href="{{ URL('/purchase/bag/stock/ledger/index') }}"
                                             class="nav-link">
                                             <i class="fas fa-shopping-bag"></i>
                                             <p>
                                                 Bag Stock Ledger
                                             </p>
                                         </a>
                                     </li>

                                 </ul>
                             </li>


                         @endif

                         @if (in_array('purchasereport', $purchasedata))
                             <li class="nav-item">
                                 <a href="#" class="nav-link">
                                     <i class="far fa-file-alt"></i>
                                     <p>
                                         Purchase Reports
                                         <i class="fas fa-angle-left right"></i>
                                     </p>
                                 </a>
                                 <ul class="nav nav-treeview">

                                     <li class="nav-item">
                                         <a href="{{ URL('/purchase/report/index') }}" class="nav-link">
                                             <i class="far fa-file-alt"></i>
                                             <p>Purchase Report</p>
                                         </a>
                                     </li>

                                     <li class="nav-item">
                                         <a href="{{ URL('/bag/purchase/report/index') }}" class="nav-link">
                                             <i class="far fa-file-alt"></i>
                                             <p>Purchase Bag Report</p>
                                         </a>
                                     </li>


                                     <li class="nav-item">
                                         <a href="{{ URL('/monthly/purchase/report/index') }}"
                                             class="nav-link">
                                             <i class="far fa-file-alt"></i>
                                             <p>Monthly Purchase Report</p>
                                         </a>
                                     </li>

                                     <li class="nav-item">
                                         <a href="{{ URL('/yearly/purchase/report/index') }}"
                                             class="nav-link">
                                             <i class="far fa-file-alt"></i>
                                             <p>Yearly Purchase Report</p>
                                         </a>
                                     </li>

                                     <li class="nav-item">
                                         <a href="{{ URL('purchase/stock/report/index') }}" class="nav-link">
                                             <i class="far fa-file-alt"></i>
                                             <p>Stock Report</p>
                                         </a>
                                     </li>

                                     <li class="nav-item">
                                         <a href="{{ URL('purchase/inventory/report/index') }}"
                                             class="nav-link">
                                             <i class="far fa-file-alt"></i>
                                             <p>Inventory Report</p>
                                         </a>
                                     </li>


                                     <li class="nav-item">
                                         <a href="{{ route('cogs.report') }}" class="nav-link">
                                             <i class="far fa-sticky-note"></i>
                                             <p>
                                                 COGS Report
                                             </p>
                                         </a>
                                     </li>




                                     <li class="nav-item">
                                        <a href="{{ URL('/current/liabilities/report') }}" class="nav-link">
                                            <i class="far fa-file-alt"></i>
                                            <p>Current Liabilities</p>
                                        </a>
                                    </li>



                                 </ul>
                             </li>
                         @endif









                         @if (in_array('generalpurchase', $purchasedata))
                             <li class="nav-item">
                                 <a href="#" class="nav-link">
                                     <i class="fas fa-dolly-flatbed"></i>
                                     <p>
                                         General Purchase
                                         <i class="fas fa-angle-left right"></i>
                                     </p>
                                 </a>
                                 <ul class="nav nav-treeview">
                                     <li class="nav-item">
                                         <a href="{{ URL('general/purchase/general/purchase/create') }}"
                                             class="nav-link">
                                             <i class="fas fa-dolly-flatbed"></i>
                                             <p>General Purchase</p>
                                         </a>
                                     </li>
                                     <li class="nav-item">
                                         <a href="{{ URL('general/purchase/index') }}" class="nav-link">
                                             <i class="fas fa-dolly-flatbed"></i>
                                             <p>General Purchase list</p>
                                         </a>
                                     </li>
                                     <li class="nav-item">
                                         <a href="{{ URL('/general/purchase/general/category') }}"
                                             class="nav-link">
                                             <i class="fas fa-chart-pie"></i>
                                             <p>General Category</p>
                                         </a>
                                     </li>
                                     <li class="nav-item">
                                         <a href="{{ route('general.purchase.generalsubcategory') }}"
                                             class="nav-link">
                                             <i class="fas fa-chart-pie"></i>
                                             <p>General Sub-Category</p>
                                         </a>
                                     </li>

                                   <hr class="bg-light m-0 p-0">
                                   	<li class="nav-item">
                                         <a href="{{ route('general.purchase.supplier.index') }}" class="nav-link">
                                             <i class="fas fa-chart-pie"></i>
                                             <p>General Supplier</p>
                                         </a>
                                     </li>
                                   <li class="nav-item">
                                         <a href="{{ route('general.purchase.general.wirehouse.index') }}" class="nav-link">
                                             <i class="fas fa-chart-pie"></i>
                                             <p>General Wirehouse</p>
                                         </a>
                                     </li>
                                     <hr class="bg-light m-0 p-0">
                                     <li class="nav-item">
                                         <a href="{{ route('general.product.list') }}" class="nav-link">
                                             <i class="fas fa-chart-pie"></i>
                                             <p>General Product</p>
                                         </a>
                                     </li>
                                     <li class="nav-item">
                                         <a href="{{ route('general.purchase.ledger.index') }}"
                                             class="nav-link">
                                             <i class="fas fa-chart-pie"></i>
                                             <p>General Ledger</p>
                                         </a>
                                     </li>
                                   <li class="nav-item">
                                         <a href="{{ route('comparison.report.index') }}"
                                             class="nav-link">
                                             <i class="fas fa-chart-pie"></i>
                                             <p>Comparison Report</p>
                                         </a>
                                     </li>

                                     <li class="nav-item">
                                         <a href="{{ route('general.purchase.report.index') }}"
                                             class="nav-link">
                                             <i class="fas fa-chart-pie"></i>
                                             <p>General Report</p>
                                         </a>
                                     </li>
                                   	<li class="nav-item">
                                         <a href="{{ route('general.purchase.stock.report.index') }}"
                                             class="nav-link">
                                             <i class="fas fa-chart-pie"></i>
                                             <p>G. P. Stock Report</p>
                                         </a>
                                     </li>
                                   	<li class="nav-item">
                                         <a href="{{ route('general.purchase.total.stock.report.input') }}"
                                             class="nav-link">
                                             <i class="fas fa-chart-pie"></i>
                                             <p>G. P. Total Stock Report</p>
                                         </a>
                                     </li>
                                     <hr class="bg-light m-0 p-0">
                                     <li class="nav-item">
                                         <a href="{{ route('general.purchase.transfer.index') }}"
                                             class="nav-link">
                                             <i class="fas fa-chart-pie"></i>
                                             <p>General Transfer</p>
                                         </a>
                                     </li>
                                     <li class="nav-item">
                                         <a href="{{ route('general.purchase.stockout.index') }}"
                                             class="nav-link">
                                             <i class="fas fa-chart-pie"></i>
                                             <p>General Stock Out</p>
                                         </a>
                                     </li>
                                 </ul>
                             </li>
                         @endif


                         @if (in_array('pcreate', $purchasedata))
                             <li class="nav-item">
                                 <a href="{{ URL('/purchase/return/index') }}" class="nav-link">
                                     <i class="fas fa-shipping-fast"></i>
                                     <p>
                                         Purchase Return
                                     </p>
                                 </a>
                             </li>
                             <li class="nav-item">
                                 <a href="{{ URL('/purchase/transfer/index') }}" class="nav-link">
                                     <i class="fas fa-shipping-fast"></i>
                                     <p>
                                         Purchase Transfer
                                     </p>
                                 </a>
                             </li>

                             <li class="nav-item">
                                 <a href="{{ URL('/purchase/damage/index') }}" class="nav-link">
                                     <i class="fas fa-shipping-fast"></i>
                                     <p>
                                         Purchase Damage
                                     </p>
                                 </a>
                             </li>


                             <li class="nav-item">
                                 <a href="#" class="nav-link">
                                     <i class="fas fa-university"></i>
                                     <p>
                                         Supplier
                                         <i class="fas fa-angle-left right"></i>
                                     </p>
                                 </a>
                                 <ul class="nav nav-treeview">

                                     <li class="nav-item">
                                         <a href="{{ URL('/supplier/index') }}" class="nav-link">
                                             <i class="far fa-list-alt"></i>
                                             <p>Supplier</p>
                                         </a>
                                     </li>

                                     <li class="nav-item">
                                         <a href="{{ URL('/supplier/group/index') }}" class="nav-link">
                                             <i class="far fa-list-alt"></i>
                                             <p>Supplier Group</p>
                                         </a>
                                     </li>
                                    <li class="nav-item">
                                         <a href="{{ URL('/supplier/category/group/create') }}" class="nav-link">
                                             <i class="far fa-list-alt"></i>
                                             <p>Supplier Category Group</p>
                                         </a>
                                     </li>




                                 </ul>
                             </li>



                             <li class="nav-item">
                                 <a href="#" class="nav-link">
                                     <i class="fab fa-product-hunt"></i>
                                     <p>
                                         Row Materials
                                         <i class="fas fa-angle-left right"></i>
                                     </p>
                                 </a>
                                 <ul class="nav nav-treeview">
                                     <li class="nav-item">
                                         <a href="{{ URL('/product/row/materials/index') }}" class="nav-link">
                                             <i class="fas fa-shopping-bag"></i>
                                             <p>
                                                 Row Materials Product
                                             </p>
                                         </a>
                                     </li>

                                     <li class="nav-item">
                                         <a href="{{ URL('/category/row/materials/index') }}"
                                             class="nav-link">
                                             <i class="fas fa-shopping-bag"></i>
                                             <p>
                                                 Row Materials Category
                                             </p>
                                         </a>
                                     </li>



                                 </ul>
                             </li>

                         @endif



                     </ul>
                 </li>
             @endif












             @if (!empty($accountsdata))
                 <li class="nav-item">
                     <a href="#" class="nav-link">
                         <i class="fas fa-credit-card"></i>
                         <p>
                             Account
                             <i class="fas fa-angle-left right"></i>
                         </p>
                     </a>


                     <ul class="nav nav-treeview">

                         @if (in_array('receive', $accountsdata))

                             <li class="nav-item">
                                 <a href="#" class="nav-link">
                                     <i class="fas fa-money-bill-wave"></i>
                                     <p>
                                         Receive
                                         <i class="fas fa-angle-left right"></i>
                                     </p>
                                 </a>
                                 <ul class="nav nav-treeview">
                                     <li class="nav-item">
                                         <a href="{{ URL('/bank/receive/index') }}" class="nav-link">
                                             <i class="fas fa-university"></i>
                                             <p>Bank Receive</p>
                                         </a>
                                     </li>
                                     <li class="nav-item">
                                         <a href="{{ URL('/cash/receive/index') }}" class="nav-link">
                                             <i class="fas fa-money-bill-wave"></i>
                                             <p>Cash Receive</p>
                                         </a>
                                     </li>

                                     <li class="nav-item">
                                        <a href="{{ URL('/general/payment/received/index') }}" class="nav-link">
                                            <i class="fas fa-university"></i>
                                            <p>General Payment Received</p>
                                        </a>
                                    </li>


                                     <li class="nav-item">
                                        <a href="{{ URL('/payment/delete/log') }}" class="nav-link">
                                            <i class="fas fa-university"></i>
                                            <p>Delete Log</p>
                                        </a>
                                    </li>

                                 </ul>
                             </li>

                         @endif

                         @if (in_array('payment', $accountsdata))
                             <li class="nav-item">
                                 <a href="#" class="nav-link">
                                     <i class="fas fa-credit-card"></i>
                                     <p>
                                         Payment
                                         <i class="fas fa-angle-left right"></i>
                                     </p>
                                 </a>
                                 <ul class="nav nav-treeview">

                                     <li class="nav-item">
                                         <a href="{{ URL('/all/payment/index') }}" class="nav-link">
                                             <i class="fas fa-university"></i>
                                             <p>Bank/Cash Payment</p>
                                         </a>
                                     </li>

                                     <li class="nav-item">
                                         <a href="{{ URL('/bank/payment/index') }}" class="nav-link">
                                             <i class="fas fa-university"></i>
                                             <p>Bank Payment List</p>
                                         </a>
                                     </li>
                                     <li class="nav-item">
                                         <a href="{{ URL('/cash/payment/index') }}" class="nav-link">
                                             <i class="fas fa-money-bill-wave"></i>
                                             <p>Cash Payment List</p>
                                         </a>
                                     </li>
                                     <li class="nav-item">
                                         <a href="{{ route('payment.report.index') }}" class="nav-link">
                                             <i class="fas fa-money-bill-wave"></i>
                                             <p>Payment Report</p>
                                         </a>
                                     </li>

                                     <li class="nav-item">
                                         <a href="{{ URL('/others/payment/index') }}" class="nav-link">
                                             <i class="fas fa-university"></i>
                                             <p>Others Payment </p>
                                         </a>
                                     </li>
                                   	<li class="nav-item">
                                         <a href="{{ route('general.purchase.supplier.payment') }}" class="nav-link">
                                             <i class="fas fa-money-bill-wave"></i>
                                             <p>General Supplier Payment</p>
                                         </a>
                                    </li>

                                   <li class="nav-item">
                                         <a href="{{ route('other.payment.report.index') }}" class="nav-link">
                                             <i class="fas fa-money-bill-wave"></i>
                                             <p>Other Payment Report</p>
                                         </a>
                                     </li>


                                 </ul>
                             </li>

                         @endif

                         @if (in_array('daybook', $accountsdata))

                             <li class="nav-item">
                                 <a href="#" class="nav-link">
                                     <i class="fas fa-credit-card"></i>
                                     <p>
                                         Daybook
                                         <i class="fas fa-angle-left right"></i>
                                     </p>
                                 </a>

                                 <ul class="nav nav-treeview">
                                    <li class="nav-item">
                                         <a href="{{ URL('/report/daybook/index') }}" class="nav-link">
                                             <i class="far fa-file-alt"></i>
                                             <p>Daybook</p>
                                         </a>
                                     </li>

                                     <li class="nav-item">
                                         <a href="{{ URL('/bank/book/index') }}" class="nav-link">
                                             <i class="fas fa-university"></i>
                                             <p>Bank Book</p>
                                         </a>
                                     </li>
                                     <li class="nav-item">
                                         <a href="{{ URL('/cash/book/index') }}" class="nav-link">
                                             <i class="fas fa-money-bill-wave"></i>
                                             <p>Cash Book</p>
                                         </a>
                                     </li>
                                    <li class="nav-item">
                                         <a href="{{ URL('/master/bank/book/index') }}" class="nav-link">
                                             <i class="fas fa-university"></i>
                                             <p>MB Account</p>
                                         </a>
                                     </li>
                                 </ul>
                             </li>
                         @endif

                         @if (in_array('acreate', $accountsdata))

                             <li class="nav-item">
                                 <a href="#" class="nav-link">
                                     <i class="fas fa-exchange-alt"></i>
                                     <p>
                                         Amount Transfer
                                         <i class="fas fa-angle-left right"></i>
                                     </p>
                                 </a>
                                 <ul class="nav nav-treeview">
                                     <li class="nav-item">
                                         <a href="{{ URL('/amount/transfer/create') }}" class="nav-link">
                                             <i class="fas fa-edit"></i>
                                             <p>Create Transfer</p>
                                         </a>
                                     </li>
                                     <li class="nav-item">
                                         <a href="{{ URL('/amount/transfer/list') }}" class="nav-link">
                                             <i class="fas fa-list-alt"></i>
                                             <p>Transfer List</p>
                                         </a>
                                     </li>
                                 </ul>
                             </li>


                             <li class="nav-item">
                                 <a href="{{ URL('/journal/entry/index') }}" class="nav-link">
                                     <i class="fas fa-university"></i>
                                     <p>Journal Entry</p>
                                 </a>
                             </li>

                       <li class="nav-item">
                                 <a href="{{ URL('/journal/report/index') }}" class="nav-link">
                                     <i class="fas fa-university"></i>
                                     <p>Journal Report</p>
                                 </a>
                             </li>


                             <li class="nav-item">
                                 <a href="{{ URL('/expanse/payment/index') }}" class="nav-link">
                                     <i class="fas fa-university"></i>
                                     <p>Expanse Entry</p>
                                 </a>
                             </li>

                             <li class="nav-item">
                                 <a href="{{ URL('/expasne/report/index') }}" class="nav-link">
                                     <i class="far fa-file-alt"></i>
                                     <p>Expanse Report</p>
                                 </a>
                             </li>


                             <li class="nav-item">
                                 <a href="{{ URL('/expanse/index') }}" class="nav-link">
                                     <i class="fas fa-university"></i>
                                     <p>Expanse Groups List/Create</p>
                                 </a>
                             </li>


                             <li class="nav-item">
                                 <a href="#" class="nav-link">
                                     <i class="far fa-file-alt"></i>
                                     <p>
                                         Asset
                                         <i class="fas fa-angle-left right"></i>
                                     </p>
                                 </a>
                                 <ul class="nav nav-treeview">
                                     <li class="nav-item">
                                         <a href="{{ URL('/asset/index') }}" class="nav-link">
                                             <i class="far fa-file-alt"></i>
                                             <p> Asset</p>
                                         </a>
                                     </li>
                                     <li class="nav-item">
                                         <a href="{{ URL('/asset/short/term/libilities/list') }}"
                                             class="nav-link">
                                             <i class="fas fa-user-tie"></i>
                                             <p>Short Term Libilities</p>
                                         </a>
                                     </li>
                                     <li class="nav-item">
                                         <a href="{{ URL('/asset/long/term/libilities/list') }}"
                                             class="nav-link">
                                             <i class="fas fa-user-tie"></i>
                                             <p>Long Term Libilities</p>
                                         </a>
                                     </li>
                                    <li class="nav-item">
                                         <a href="{{ URL('/asset/clint/list') }}" class="nav-link">
                                             <i class="fas fa-user-tie"></i>
                                             <p>Asset Client</p>
                                         </a>
                                     </li>


                                     <li class="nav-item">
                                         <a href="{{ URL('/asset/type') }}" class="nav-link">
                                             <i class="fas fa-user-tie"></i>
                                             <p>Asset Type</p>
                                         </a>
                                     </li>
                                    <li class="nav-item">
                                         <a href="{{ URL('/asset/category') }}" class="nav-link">
                                             <i class="fas fa-user-tie"></i>
                                             <p>Asset Category</p>
                                         </a>
                                     </li>
                                   <li class="nav-item">
                                         <a href="{{ URL('/asset/product') }}" class="nav-link">
                                             <i class="fas fa-user-tie"></i>
                                             <p>Asset Product</p>
                                         </a>
                                     </li>

                                   <li class="nav-item">
                                         <a href="{{ URL('/asset/license') }}" class="nav-link">
                                             <i class="fas fa-user-tie"></i>
                                             <p>Asset License</p>
                                         </a>
                                     </li>


                                   <li class="nav-item">
                                         <a href="{{ URL('/asset/investment/list') }}" class="nav-link">
                                             <i class="fas fa-user-tie"></i>
                                             <p>Asset Investment</p>
                                         </a>
                                     </li>

                                    <li class="nav-item">
                                         <a href="{{ URL('/asset/Intangible/list') }}" class="nav-link">
                                             <i class="fas fa-user-tie"></i>
                                             <p>Asset Intangible</p>
                                         </a>
                                     </li>


                                     <li class="nav-item">
                                         <a href="{{ URL('/asset/depreciation/list') }}" class="nav-link">
                                             <i class="fas fa-user-tie"></i>
                                             <p>Asset Depreciation</p>
                                         </a>
                                     </li>




                                     <li class="nav-item">
                                         <a href="{{ URL('/asset/report/index') }}" class="nav-link">
                                             <i class="fas fa-user-tie"></i>
                                             <p>Asset Report</p>
                                         </a>
                                     </li>
                                   @if(Auth::id() == 101)
                                    <li class="nav-item">
                                         <a href="{{ URL('/asset/notification/list') }}" class="nav-link">
                                             <i class="fas fa-user-tie"></i>
                                             <p>Asset Notification</p>
                                         </a>
                                     </li>
                                   @endif
                                 </ul>
                             </li>

                          <li class="nav-item">
                                 <a href="{{ URL('/accounts/equity/index') }}" class="nav-link">
                                     <i class="fas fa-university"></i>
                                     <p>Equity</p>
                                 </a>
                             </li>




                             <li class="nav-item">
                                 <a href="#" class="nav-link">
                                     <i class="fas fa-credit-card"></i>
                                     <p>
                                         Costing
                                         <i class="fas fa-angle-left right"></i>
                                     </p>
                                 </a>
                                 <ul class="nav nav-treeview">
                                     <li class="nav-item">
                                         <a href="{{ URL('/direct/labour/cost/list') }}" class="nav-link">
                                             <i class="far fa-file-alt"></i>
                                             <p>Direct Labour Cost</p>
                                         </a>
                                     </li>


                                     <li class="nav-item">
                                         <a href="{{ URL('/indirect/cost/list') }}" class="nav-link">
                                             <i class="far fa-file-alt"></i>
                                             <p>Indirect Labour Cost</p>
                                         </a>
                                     </li>

                                     <li class="nav-item">
                                         <a href="{{ URL('/manufacturing/cost/list') }}" class="nav-link">
                                             <i class="far fa-file-alt"></i>
                                             <p>Manufacturing Cost</p>
                                         </a>
                                     </li>
                                 </ul>
                             </li>






                             <li class="nav-item">
                                 <a href="{{ URL('/others/type/create') }}" class="nav-link">
                                     <i class="fas fa-university"></i>
                                     <p>Others Type</p>
                                 </a>
                             </li>

                             <li class="nav-item">
                                 <a href="{{ URL('/master/bank/index') }}" class="nav-link">
                                     <i class="fas fa-university"></i>
                                     <p>Master Bank</p>
                                 </a>
                             </li>
                             <li class="nav-item">
                                 <a href="{{ URL('/master/cash/index') }}" class="nav-link">
                                     <i class="fas fa-money-bill-wave"></i>
                                     <p>Master Cash</p>
                                 </a>
                             </li>


                       <li class="nav-item">
                                 <a href="{{ URL('/company/name/create') }}" class="nav-link">
                                     <i class="fas fa-money-bill-wave"></i>
                                     <p>Company Name</p>
                                 </a>
                             </li>


                       <li class="nav-item">
                             <a href="{{ URL('loan/borrowing/index') }}" class="nav-link">
                                 <i class="far fa-file-alt"></i>
                                 <p>Borrow Entry</p>
                             </a>
                         </li>

                        <li class="nav-item">
                             <a href="{{ URL('lease/index') }}" class="nav-link">
                                 <i class="far fa-file-alt"></i>
                                 <p>Lease Entry</p>
                             </a>
                         </li>


                       <li class="nav-item">
                             <a href="{{ URL('bad/debt/index') }}" class="nav-link">
                                 <i class="far fa-file-alt"></i>
                                 <p>Bad Debt Entry</p>
                             </a>
                         </li>

                        <li class="nav-item">
                             <a href="{{ URL('budget/index') }}" class="nav-link">
                                 <i class="far fa-file-alt"></i>
                                 <p>Budget</p>
                             </a>
                         </li>


                        <li class="nav-item">
                             <a href="{{ URL('tax/create') }}" class="nav-link">
                                 <i class="far fa-file-alt"></i>
                                 <p>Taxes</p>
                             </a>
                         </li>




                         @endif

                         @if (in_array('tbalance', $accountsdata))
                         <li class="nav-item">
                             <a href="{{ URL('/accounts/trial/balance/index') }}" class="nav-link">
                                 <i class="far fa-file-alt"></i>
                                 <p>Trail Balance</p>
                             </a>
                         </li>

                         @endif
                         @if (in_array('incomestement', $accountsdata))
                       <li class="nav-item">
                             <a href="{{ URL('/all/income/index') }}" class="nav-link">
                                 <i class="far fa-file-alt"></i>
                                 <p>Income Entry</p>
                             </a>
                         </li>


                         <li class="nav-item">
                             <a href="{{ URL('/accounts/income/statement/index') }}" class="nav-link">
                                 <i class="far fa-file-alt"></i>
                                 <p>Income Statement</p>
                             </a>
                         </li>

                         <li class="nav-item">
                             <a href="{{ URL('/accounts/operating/cash/flow/index') }}" class="nav-link">
                                 <i class="far fa-file-alt"></i>
                                 <p>Operating Cash Flow</p>
                             </a>
                         </li>
                        <li class="nav-item">
                             <a href="{{ URL('/accounts/total/cash/flow/index') }}" class="nav-link">
                                 <i class="far fa-file-alt"></i>
                                 <p> Cash Flow</p>
                             </a>
                         </li>

                        <li class="nav-item">
                             <a href="{{ URL('/accounts/balance/sheet/index') }}" class="nav-link">
                                 <i class="far fa-file-alt"></i>
                                 <p>Balance Sheet</p>
                             </a>
                         </li>

                          <li class="nav-item">
                             <a href="{{ URL('/accounts/company/summary/index') }}" class="nav-link">
                                 <i class="far fa-file-alt"></i>
                                 <p>Company Summary Report</p>
                             </a>
                         </li>

                        <li class="nav-item">
                             <a href="{{ URL('/accounts/pie/chart/index') }}" class="nav-link">
                                 <i class="far fa-file-alt"></i>
                                 <p>Pie Chart</p>
                             </a>
                         </li>
                       <li class="nav-item">
                             <a href="{{ URL('/expenditure/pie/chart/index') }}" class="nav-link">
                                 <i class="far fa-file-alt"></i>
                                 <p>Expenditure Pie Chart</p>
                             </a>
                         </li>
                        <li class="nav-item">
                             <a href="{{ URL('/budget/pie/chart/index') }}" class="nav-link">
                                 <i class="far fa-file-alt"></i>
                                 <p>Budget Pie Chart</p>
                             </a>
                         </li>


                         @endif


                     </ul>
                 </li>
             @endif


             @if (!empty($settingsdata))
                 <li class="nav-item">
                     <a href="#" class="nav-link">
                         <i class="fas fa-university"></i>
                         <p>
                             Settings
                             <i class="fas fa-angle-left right"></i>
                         </p>
                     </a>
                     <ul class="nav nav-treeview">
                        @if (in_array('warehouse', $settingsdata))
                         <li class="nav-item">
                             <a href="#" class="nav-link">
                                 <i class="fas fa-university"></i>
                                 <p>
                                     Warehouse
                                     <i class="fas fa-angle-left right"></i>
                                 </p>
                             </a>
                             <ul class="nav nav-treeview">
                                 <li class="nav-item">
                                     <a href="{{ URL('/warehouse/create') }}" class="nav-link">
                                         <i class="far fa-edit"></i>
                                         <p>Create Warehouse </p>
                                     </a>
                                 </li>
                                 <li class="nav-item">
                                     <a href="{{ URL('/warehouse/index') }}" class="nav-link">
                                         <i class="far fa-list-alt"></i>
                                         <p>Warehouse List</p>
                                     </a>
                                 </li>
                             </ul>
                         </li>


                         @endif




						 <li class="nav-item">
                             <a href="#" class="nav-link">
                                 <i class="fas fa-users"></i>
                                 <p>
                                     Vehicle
                                     <i class="fas fa-angle-left right"></i>
                                 </p>
                             </a>
                             <ul class="nav nav-treeview">
                                 <li class="nav-item">
                                     <a href="{{ route('vehicle.create') }}" class="nav-link">
                                         <i class="far fa-edit"></i>
                                         <p>Vehicle Create </p>
                                     </a>
                                 </li>
                                <li class="nav-item">
                                     <a href="{{ route('vehicle.list') }}" class="nav-link">
                                         <i class="far fa-list-alt"></i>
                                         <p>Vehicle List </p>
                                     </a>
                                 </li>
                                <li class="nav-item">
                                     <a href="{{ route('vehicle.category') }}" class="nav-link">
                                         <i class="far fa-edit"></i>
                                         <p>Vehicle Category </p>
                                     </a>
                                 </li>


                                <li class="nav-item">
                                     <a href="{{ route('driver.list') }}" class="nav-link">
                                         <i class="far fa-edit"></i>
                                         <p>Driver list</p>
                                     </a>
                                 </li>
                               <li class="nav-item">
                                     <a href="{{ route('trip.create') }}" class="nav-link">
                                         <i class="far fa-edit"></i>
                                         <p>Trip Entry</p>
                                     </a>
                                 </li>

                               <li class="nav-item">
                                     <a href="{{ route('trip.list') }}" class="nav-link">
                                         <i class="far fa-edit"></i>
                                         <p>Trip List</p>
                                     </a>
                                 </li>

                                <li class="nav-item">
                                     <a href="{{ route('trip.report.index') }}" class="nav-link">
                                         <i class="far fa-edit"></i>
                                         <p>Trip Report</p>
                                     </a>
                                 </li>
                               	<li class="nav-item">
                                     <a href="{{ route('total.trip.report.index') }}" class="nav-link">
                                         <i class="far fa-edit"></i>
                                         <p>Total Trip Report</p>
                                     </a>
                                 </li>

                             </ul>
                         </li>



                         @if (in_array('employee', $settingsdata))

                         <li class="nav-item">
                             <a href="#" class="nav-link">
                                 <i class="fas fa-users"></i>
                                 <p>
                                     Employee
                                     <i class="fas fa-angle-left right"></i>
                                 </p>
                             </a>
                             <ul class="nav nav-treeview">
                                 <li class="nav-item">
                                     <a href="{{ route('employee.create') }}" class="nav-link">
                                         <i class="far fa-edit"></i>
                                         <p>Create Employee </p>
                                     </a>
                                 </li>
                                 <li class="nav-item">
                                     <a href="{{ route('employee.list') }}" class="nav-link">
                                         <i class="far fa-list-alt"></i>
                                         <p>Employee List</p>
                                     </a>
                                 </li>


                                   <li class="nav-item">
                                     <a href="{{ route('employee.designation.create') }}" class="nav-link">
                                         <i class="far fa-list-alt"></i>
                                         <p>Employee Designation</p>
                                     </a>
                                 </li>
                                <li class="nav-item">
                                     <a href="{{ route('employee.departments.create') }}" class="nav-link">
                                         <i class="far fa-list-alt"></i>
                                         <p>Employee Department</p>
                                     </a>
                                 </li>
                               <li class="nav-item">
                                     <a href="{{ route('employee.stafcategory.create') }}" class="nav-link">
                                         <i class="far fa-list-alt"></i>
                                         <p>Employee Staff Category</p>
                                     </a>
                                 </li>


                                 <li class="nav-item">
                                     <a href="{{ route('employee.target.set.index') }}" class="nav-link">
                                         <i class="far fa-list-alt"></i>
                                         <p>Employee Sales Target</p>
                                     </a>
                                 </li>



                               	<li class="nav-item">
                                     <a href="{{ route('employee.attendance.form') }}" class="nav-link">
                                         <i class="far fa-list-alt"></i>
                                         <p>Employee Attendance</p>
                                     </a>
                                 </li>
                               	<li class="nav-item">
                                     <a href="{{ route('employee.overtime.create') }}" class="nav-link">
                                         <i class="far fa-list-alt"></i>
                                         <p>Employee Overtime</p>
                                     </a>
                                 </li>
                               	<li class="nav-item">
                                     <a href="{{ route('employee.attendance.list') }}" class="nav-link">
                                         <i class="far fa-list-alt"></i>
                                         <p>E. Attendance List</p>
                                     </a>
                                 </li>
                               	<li class="nav-item">
                                     <a href="{{ route('employee.leave.of.absent.form') }}" class="nav-link">
                                         <i class="far fa-list-alt"></i>
                                         <p>E. Leave Of Absence</p>
                                     </a>
                                 </li>
                               	<li class="nav-item">
                                     <a href="{{ route('employee.leave.of.absent.list') }}" class="nav-link">
                                         <i class="far fa-list-alt"></i>
                                         <p>Leave Of Absence List</p>
                                     </a>
                                 </li>

                                 <li class="nav-item">
                                     <a href="{{route('employee.other.amount.pay.list')}}" class="nav-link">
                                         <i class="far fa-list-alt"></i>
                                         <p>Employee Other Amount </p>
                                     </a>
                               </li>



                               <li class="nav-item">
                                     <a href="{{route('employee.salary.pay')}}" class="nav-link">
                                         <i class="far fa-list-alt"></i>
                                         <p>E. Salary Pay Form </p>
                                     </a>
                               </li>
                               <li class="nav-item">
                                     <a href="{{route('employee.salary.pay.list')}}" class="nav-link">
                                         <i class="far fa-list-alt"></i>
                                         <p>E. Salary Pay List </p>
                                     </a>
                               </li>

                               <li class="nav-item">
                                     <a href="{{ route('monthly.salary.and.attendance.report') }}" class="nav-link">
                                         <i class="far fa-list-alt"></i>
                                         <p>Monthly Salary And Attendance Report </p>
                                     </a>
                               </li>
                               <li class="nav-item">
                                     <a href="{{ route('employee.monthly.deduction.filter') }}" class="nav-link">
                                         <i class="far fa-list-alt"></i>
                                         <p>E. Monthly Deduction Report </p>
                                     </a>
                               </li>
                               <li class="nav-item">
                                     <a href="{{ route('employee.salary.certificate.form') }}" class="nav-link">
                                         <i class="far fa-list-alt"></i>
                                         <p>E. Salary Certificate </p>
                                     </a>
                               </li>
                             </ul>
                         </li>
                         @endif


                         @if (in_array('scalerm', $settingsdata))
                         <li class="nav-item">
                             <a href="#" class="nav-link">
                                 <i class="fas fa-university"></i>
                                 <p>
                                     Scale (Row Materials)
                                     <i class="fas fa-angle-left right"></i>
                                 </p>
                             </a>
                             <ul class="nav nav-treeview">

                                 <li class="nav-item">
                                     <a href="{{ URL('row/materials/scale/index') }}" class="nav-link">
                                         <i class="far fa-list-alt"></i>
                                         <p>Scale List</p>
                                     </a>
                                 </li>

                                 <li class="nav-item">
                                     <a href="{{ URL('row/materials/scale/entry') }}" class="nav-link">
                                         <i class="far fa-list-alt"></i>
                                         <p>Scale Entry </p>
                                     </a>
                                 </li>
                                 <li class="nav-item">
                                     <a href="{{ URL('row/materials/scale/summary') }}" class="nav-link">
                                         <i class="far fa-list-alt"></i>
                                         <p>Scale Summary </p>
                                     </a>
                                 </li>

                             </ul>
                         </li>



                         @endif


                         @if (in_array('usersetting', $settingsdata))
                         <li class="nav-item">
                             <a href="#" class="nav-link">
                                 <i class="fab fa-product-hunt"></i>
                                 <p>
                                     User Settings
                                     <i class="fas fa-angle-left right"></i>
                                 </p>
                             </a>
                             <ul class="nav nav-treeview">
                                 <li class="nav-item">
                                     <a href="{{ URL('user/setting/list') }}" class="nav-link">
                                         <i class="fas fa-shopping-bag"></i>
                                         <p>
                                             User List
                                         </p>
                                     </a>
                                 </li>

                                 <li class="nav-item">
                                     <a href="{{ URL('user/setting/create') }}" class="nav-link">
                                         <i class="fas fa-shopping-bag"></i>
                                         <p>
                                             Create User
                                         </p>
                                     </a>
                                 </li>








                             </ul>
                         </li>

                         @endif

                         <li class="nav-item">
                                     <a href="{{ URL('user/password/change/index') }}" class="nav-link">
                                         <i class="fas fa-shopping-bag"></i>
                                         <p>
                                             Password Change
                                         </p>
                                     </a>
                                 </li>

                     </ul>
                 </li>
             @endif
	--}}

         </ul>
     </nav>
     <!-- /.sidebar-menu -->
 </div>
 <!-- /.sidebar -->
