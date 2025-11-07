@extends('layouts.purchase_deshboard')
<style>
/*.tableFixHead {
       overflow: auto;
       height: 600px;
 overflow-x: scroll;
 overflow-y: scroll;
   }


 .wrapper{

   z-index: 1;
 }

table td:first-child {
 position: sticky;
 left: 0;
 background-color: #f5f5f5;
}

 table{
 overflow-y: scroll;
 }

 tableFixHead thead th {
       position: sticky;
       top: 200px;
       z-index: 1;
   } */

 /* ==============new scc start ============= */



table {

 font-size: 11px!important;
 white-space: nowrap;
 margin: 0;
 border: none;
 border-collapse: separate;
 border-spacing: 0;
 table-layout: fixed;
 border: 1px solid black;
 overflow-y: scroll;
}
table td,
table th {
 border: 1px solid black;
 padding: 0.5rem 1rem;

}
 .content-wrapper{
   z-index: 1;
/* margin-top:-43%!important; */
 }
table thead th {
 padding: 8px;
 position: sticky;
 top: 0;
 z-index: 1;
 width: 45vw;
 background: #FA621C;
 color:#000;
}

table td {
 padding-bottom: 7px;
 text-align: center;

}

table tbody td:first-child {
 font-weight: 100;
 text-align: left;
 position: relative;
}
table thead th:first-child {
 position: sticky!important;
 left: 0;
 z-index: 1;
}
table tbody td:first-child {
 position: sticky;
 left: 0;
 background: #f5f5f5;
 z-index: 1;
}
caption {
 text-align: left;
 padding: 0.25rem;
 position: sticky;
 left: 0;
}

[role="region"][aria-labelledby][tabindex] {
 width: 100%;
 max-height: 400px;
 overflow: auto;
}
[role="region"][aria-labelledby][tabindex]:focus {
 //box-shadow: 0 0 0.5em rgba(0, 0, 0, 0.5);
 outline: 0;
}
 footer.main-footer{
 display: none!important;
   z-index: -1;
 }
 .hover_manu_content{
     position: absolute;
   width: 100%;
   float: left;
   top: -390px;
   opacity: 0;
 background: #fff;
  margin-left: -15px;
}
 /* ========new css end====== */
 /*

 table {
 white-space: nowrap;
 margin: 0;
 border: none;
 border-collapse: separate;
 border-spacing: 0;
 table-layout: fixed;
 border: 1px solid black;
}
table td,
table th {
 border: 1px solid black;
 padding: 0.5rem 1rem;
}
table thead th {
 padding: 3px;
 position: sticky;
 top: 0;
 z-index: 1;
 width: 25vw;
 background: #009;
}
table td {
 background: #fff;
 padding: 4px 5px;
 text-align: center;
}

table tbody th {
 font-weight: 100;
 font-style: italic;
 text-align: left;
 position: relative;
}
table thead th:first-child {
 position: sticky;
 left: 0;
 z-index: 2;
}
table tbody th {
 position: sticky;
 left: 0;
 background: green;
 z-index: 1;
}
caption {
 text-align: left;
 padding: 0.25rem;
 position: sticky;
 left: 0;
}

[role="region"][aria-labelledby][tabindex] {
 width: 100%;
 max-height: 98vh;
 overflow: auto;
}
[role="region"][aria-labelledby][tabindex]:focus {
 box-shadow: 0 0 0.5em rgba(0, 0, 0, 0.5);
 outline: 0;
} */

</style>
@section('print_menu')

     <li class="nav-item">

               </li>
     <li class="nav-item ml-1">

               </li>
<li class="nav-item ml-1">

               </li>

@endsection

@section('content')

   <!-- Content Wrapper. Contains page content -->
   <div class="content-wrapper">


       <!-- Main content -->
       <div class="content px-4 ">
         <div class="row pt-3">
              <div class="col-md-12 text-right">
                     <button class="btn btn-sm  btn-success mt-1" id="btnExport"  >
                      Export
                   </button>
                 <button class="btn btn-sm  btn-warning mt-1"  onclick="printDiv('contentbody')"  id="printbtn"  >
                      Print
                   </button>
                 <!-- <button class="btn btn-sm  btn-warning mt-1"  onclick="printland()"  id="printland"  >
                      PrintLands.
                   </button> -->

              </div>
          </div>

           <div class="container-fluid tableFixHead"  style="background:#ffffff; padding:0px 40px;min-height:85vh" id="contentbody">
             <div class="row pt-2">
                   <div class="col-md-5 text-left">
                     <h5 class="text-uppercase font-weight-bold">LC Report <br> {{ date("F d, Y", strtotime($fdate)) }} to {{date("F d, Y", strtotime($tdate))}}</h5>

                   </div>
                   <div class="col-md-4 pt-3 text-center">
                       <h3 class="text-uppercase font-weight-bold">Naba Crop Care</h3>
                 <p>Head office, Rajshahi, Bangladesh</p>
                   </div>
               </div>

             <div role="region" aria-labelledby="caption" tabindex="0" style="min-height:370px;">
               <table id="reporttable">
                 <caption id="caption"></caption>
                 <thead>
                   <tr>
                      <th>Date</th>
                      <th>Item Name</th>
                      <th>Group</th>
                      <th>Ledger</th>
                      <th>LC No</th>
                      <th>Issues Bank </th>
                      <th>Beneficiary Bank </th>
                      <th>Discounting Bank </th>
                      <th>Confirming  Bank </th>
                      <th>Agent  Bank </th>
                      <th>Exporter</th>
                      <th>H.S Code</th>
                      <th>Country </th>
                      <th>L.C Qty (Kg) </th>
                      <th>Rate (USD)</th>
                      <th>Value (USD)</th>
                      <th>Rate (BDT)</th>
                      <th>Value (BDT)</th>
                      <th>Shipment Date</th>
                      <th>CNF Name</th>
                      <th>Mother Vessel </th>
                      <th>Port of Entry </th>
                      <th>Port of Discharge </th>
                      <th>Receive Qty (Kg)</th>
                      <th>Acceptance Date</th>
                      <th>Payment  Date</th>
                      <th>Payment  Bank</th>
                      <th>Bank Charge</th>
                      <th class="w-100">Remarks</th>
                    </tr>
                 </thead>
                 @php
                  $totalUsd = 0;
                  $totalBdt = 0;
                  $totalLcQty = 0;
                  $totalReceiveQty = 0;
                  $totalCharge = 0;
                 @endphp
                 <tbody>
                     @foreach($lcReports as $key=>$val)
                     @php
                         $totalUsd += $val->usd_value;
                         $totalBdt += $val->bdt_value;
                         $totalLcQty += $val->lc_qty;
                         $totalReceiveQty += $val->receive_qty;
                         $totalCharge += $val->amount;
                     @endphp
                   <tr>
                    <td>{{ date("d-m-Y", strtotime($val->date)) }} </td>
                    <td>{{ $val->item->product_name }} </td>
                    <td>{{ $val->lcGroup->name }} </td>
                    <td>{{ $val->lcLedger->name }} </td>
                    <td>{{ $val->lc_number }} </td>
                    <td>{{ $val->issuesBank->bank_name }} </td>
                    <td>{{ $val->beneficiaryBank->bank_name }} </td>
                    <td>{{ $val->discountingBank->bank_name }} </td>
                    <td>{{ $val->confirmingBank->bank_name }} </td>
                    <td>{{ $val->agentBank->name }} </td>
                    <td>{{ $val->exporteLedger->name }} </td>
                    <td>{{ $val->hs_code }} </td>
                    <td>{{ $val->country }} </td>
                    <td>{{ $val->lc_qty }} </td>
                    <td>{{ $val->usd_rate }} </td>
                    <td>{{ number_format($val->usd_value,2) }} </td>
                    <td>{{ $val->bdt_rate }} </td>
                    <td>{{ number_format($val->bdt_value,2) }} </td>
                    <td>{{ date("d-m-Y", strtotime($val->shipment_date)) }} </td>
                    <td>{{ $val->cnf->name }} </td>
                    <td>{{ $val->motherVessel->name }} </td>
                    <td>{{ $val->portOfEntry->name }} </td>
                    <td>{{ $val->portOfDischarge->name }} </td>
                    <td>{{ $val->receive_qty }} </td>
                    <td>{{ date("d-m-Y", strtotime($val->acceptance_date)) }} </td>
                    <td>{{ date("d-m-Y", strtotime($val->payment_date)) }} </td>
                    <td>{{ $val->paymentBank->bank_name }} </td>
                    <td>{{ number_format($val->amount,2) }} </td>
                    <td style="font-size:9px; text-transform: capitalize;font-weight: 300;">{{ $val->remarks }}</td>
                   </tr>
                   @endforeach
                   <tr style="color: black;font-size:16px; font-weight: 600;">
                      <td>Total:</td>
                      <td colspan="13" style="text-align:right;">{{ number_format($totalLcQty,2) }}</td>
                      <td colspan="2" style="text-align:right;">{{ number_format($totalUsd,2) }}</td>
                      <td colspan="2" style="text-align:right;">{{ number_format($totalBdt,2) }}</td>
                      <td colspan="6" style="text-align:right;">{{ number_format($totalReceiveQty,2) }}</td>
                      <td colspan="4" style="text-align:right;">{{ number_format($totalCharge,2) }}</td>
                      <td></td>
                    </tr>
                 </tbody>
               </table>
             </div>


           </div>
       </div>
   </div>

   <script>
       $(function() {
           $('[data-toggle="tooltip"]').tooltip()
       })
   </script>



<script type="text/javascript">
   function printDiv(divName) {
            var printContents = document.getElementById(divName).innerHTML;
            var originalContents = document.body.innerHTML;

            document.body.innerHTML = printContents;

            window.print();

            document.body.innerHTML = originalContents;
       }
</script>

<script type="text/javascript">
   $(function () {
       $("#btnExport").click(function () {
           $("#reporttable").table2excel({
               filename: "lcReport.xls"
           });
       });
   });
</script>
@endsection
