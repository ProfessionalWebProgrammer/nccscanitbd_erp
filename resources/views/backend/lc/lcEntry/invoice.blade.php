@extends('layouts.purchase_deshboard')
<style>
  table{
  border-collapse: collapse;
  }
  .table td, .table th{
    border-top:none!important
  }
  table, .table td, .table th{
border: 1px solid #666!important;
  }
  table.custom{
    border: none!important;
  }
</style>

@section('print_menu')
			{{-- <li class="nav-item">
                    <button class="btn btn-sm  btn-success mt-1" id="btnExport"  >
                       Export
                    </button>
                </li> --}}
			<li class="nav-item ml-1">
                    <button class="btn btn-xs  btn-warning mt-1"  onclick="printDiv('contentbody')"  id="printbtn"  >
                       Print
                    </button>
            </li>
@endsection

@section('content')

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper salescontent" id="contentbody">


        <!-- Main content -->
        <div class="content px-4 ">
            <div class="container-fluid bg-white p-5">
              <div class="row">
                {{-- <div class="col-md-3">
                  <div class="imag">
                    <img src="{{ asset('public/uploads/logo.jpg') }}" class="w-60" style="width:80px" alt="User Image">
                  </div>
                </div>
                <div class="col-md-12">
                  <div class="row">
                  <div class="col-md-12 mt-3 mb-3">
                    <h3 class="text-uppercase font-weight-bold">Naba Crop Care</h3>
                  	<p>Head office, Rajshahi, Bangladesh</p>
                    <h3 class="text-center mt-4"><u>L.C Invoice </u></h3>
                  </div>
                    </div>
                </div> --}}
                <div class="col-md-12 mt-5">
                  <div class="row">
                    <div class="col-md-12">
                      <div class="text-center">
                        <h1><b>Naba Crop Care</b></h1>
                        <p>Head office, Rajshahi, Bangladesh</p>
                        <h4 class="mt-2">L.C Invoice </h4>
                      </div>
                    </div>
                    <div class="col-md-12 mt-4">
                      <div class="row">
                        <div class="col-md-8 ">
                        <div class="h5 ">
                         <span >LC No: {{ $val->lc_number }}</span> </br>
                         <span >Exporter: {{$val->exporteLedger->name}}</span> </br>
                          <span>Country of Origin: {{$val->country}}</span></br>
                          <span >Date: {{date("M d, Y", strtotime($val->date))}}</span>
                    	</div>
                    </div>
                    <div class="col-md-4 mt-4">
                      <div class="row">
                        <div class="col-md-1"></div>
                        <div class="col-md-11 text-right">
                          <div class="h5 ">
                            <span >Shipment Date: {{date("M d, Y", strtotime($val->shipment_date))}}</span></br>
                            <span >Payment Date: {{date("M d, Y", strtotime($val->payment_date))}}</span></br>
                            <span >Acceptance Date: {{date("M d, Y", strtotime($val->acceptance_date))}}</span></br>
                          </div>
                        </div>
                  </div>
                  </div>
                  </div>
                  </div>

                <div class="col-md-12 mt-4">
                  <div class="row">
                    <div class="col-md-8 ">
                      <span class="h5">Bank Info</span></br>
                      <span>Issues Bank:  {{$val->issuesBank->bank_name ?? ''}}</span></br>
                      <span>Beneficiary Bank:  {{$val->beneficiaryBank->bank_name ?? ''}}</span></br>
                      <span>Discounting Bank:  {{$val->discountingBank->bank_name ?? ''}}</span></br>
                      <span>Confirming Bank:  {{$val->confirmingBank->bank_name ?? ''}}</span></br>
                      <span>Paymnet Bank:  {{$val->paymentBank->bank_name ?? ''}}</span></br>
                      <span>Agent Bank:  {{$val->agentBank->name ?? ''}}</span></br>

                    </div>
                    <div class="col-md-4 mt-4">
                      <div class="row">
                        <div class="col-md-1"></div>
                        <div class="col-md-11 text-right">
                          <span class="h5">Ledger Info</span></br>
                          <span>LC Group: {{ $val->lcGroup->name}}</span></br>
                          <span>LC Ledger: {{$val->lcLedger->name}}</span></br>
                          <span>C n f Name: {{$val->cnf->name}}</span></br>
                          <span>Mother Vessel: {{$val->motherVessel->name}}</span></br>
                          <span>Port Of Entry: {{$val->portOfEntry->name}}</span></br>
                          <span>Port Of Discharge: {{$val->portOfDischarge->name}}</span>
                        </div>
                        </div>
                      </div>
                  </div>
                </div>

                <div class="col-md-12 mt-4 mb-3">

                </div>
              </div>

                <div class="py-0">
                    <table class="table" style="font-size: 15px;">
                        <thead>
                            <tr >
                                <th>Sl No</th>
                                <th>Item Name</th>
                                <th>H.S Code</th>
                                <th>LC Qty</th>
                                <th>Receive Qty</th>
                                <th>Rate (USD)</th>
                                <th>Value (USD)</th>
                                <th>Rate (BDT)</th>
                                <th>Value (BDT)</th>
                                <th>Bank Change</th>
                                <th>Total</th>
                                <th>Remarks</th>
                            </tr>
                        </thead>

                        <tbody style="font-size: 16px;">

                              <tr>
                                    <td>1</td>
                                    <td>{{$val->item->product_name}}</td>
                                	  <td>{{$val->hs_code}}</td>
                                    <td>{{$val->lc_qty}}</td>
                                    <td>{{$val->receive_qty}}</td>
                                	  <td class="text-right">{{number_format($val->usd_rate,2)}}/-</td>
                                	  <td class="text-right">{{number_format($val->usd_value,2)}}/-</td>
                                	  <td class="text-right">{{number_format($val->bdt_rate,2)}}/-</td>
                                	  <td class="text-right">{{number_format($val->bdt_value,2)}}/-</td>
                                	  <td class="text-right">{{number_format($val->amount,2)}}/-</td>
                                	  <td class="text-right">{{number_format($val->bdt_value+$val->amount,2)}}/-</td>
                                    <td>{{$val->remarks}}</td>
                                </tr>
                                <tr>
                                  <th  colspan="100%" style="text-transform: capitalize; text-align:left;">Total Amount in words: {{convert_number($val->bdt_value+$val->amount).convert_paisa((string)$val->bdt_value+$val->amount)}}</th>
                                 <tr>

                           </tbody>
                    </table>
                </div>


              <div class="col-md-10 m-auto mt-5 mb-5">
                   <div class="row">
                     <div class="col-md-4">
                       <div class="text-left mt-5">
                          <span>--------------------</br>
                       		Prepared By: </span>
                       </div>
                     </div>
                     <div class="col-md-4">
                       <div class="text-center mt-5">
                         <span>-------------------- </br>
                       		Checked By: </span>
                       </div>
                     </div>
                     <div class="col-md-4">
                       <div class="text-right mt-5">
                         <span>------------------- </br>
                       		Approved By: </span>
                       </div>
                     </div>

                   </div>
            </div>
						<div class="col-md-12 mt-5"></div>
          {{--  <div class="col-md-12 mt-1 mb-5">
                 <div class="row">
                   <div class="col-md-4 ml-2 text-center">
                     <div class="text-left mt-5">
                        <h3>Corporate Office</h3>
                        <span>Silverstone Shoppire, House# 09, Road# 23,</br> Block # B, Banani, Dhaka</span>
                     </div>
                   </div>
                   <div class="col-md-4 ml-2 text-center">
                     <div class="text-left mt-5">
                       <h3>Hade Office</h3>
                       <span>Nabil House, 15/2 Ahmadnagor, Sopura, </br>Boalia, Rajshahi</span>
                     </div>
                   </div>
                   <div class="col-md-3 ml-4 text-center">
                     <div class="text-left mt-5">
                       <h3>Project Office</h3>
                       <span>Nabil Industrial Park , Verapora Bazar, </br> Daokandi, Paba, Rajshahi.</span>
                     </div>
                   </div>

                 </div>
          </div> --}}

            </div>
        </div>
    </div>

@endsection


@push('end_js')

    <script>
        $(function() {
            $('[data-toggle="tooltip"]').tooltip()
        })


        $('#delete').on('show.bs.modal', function(event) {
            console.log('hello test');
            var button = $(event.relatedTarget)
            var title = button.data('mytitle')
            var id = button.data('myid')

            var modal = $(this)

            modal.find('.modal-body #mid').val(id);
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
            $("#datatablecustom").table2excel({
                filename: "Invoice-purchase-order.xls"
            });
        });
    });

</script>

@endpush
