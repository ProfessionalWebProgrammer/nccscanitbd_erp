@extends('layouts.purchase_deshboard')
@section('print_menu')
			{{-- <li class="nav-item">
                    <button class="btn btn-sm  btn-success mt-1" id="btnExport"  >
                       Export
                    </button>
                </li> --}}
			<li class="nav-item ml-1">
                    <button class="btn btn-sm  btn-warning mt-1"  onclick="printDiv('contentbody')"  id="printbtn"  >
                       Print
                    </button>
            </li>
@endsection
@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper" id="contentbody">


        <!-- Main content -->
        <div class="content px-4 ">
            <div class="container" style="background:#ffffff; padding:0px 40px;min-height:85vh">
                <div class="text-center pt-3">
                    <h3 class="text-uppercase font-weight-bold">Naba Crop Care</h3>
                  <p>Head office, Rajshahi, Bangladesh</p>
                </div>
                <div class="text-center pt-3">
                    <h5 class="text-uppercase font-weight-bold">Production Stock Out Invoice List</h5>


                </div>
                <div class="py-4 table-responsive">
                    <div class="" style="margin-left: 30px" >
                        <h5>Invoice No: PJV-{{$invoice}}</h5>
                         <h5>Wirehouse Name: {{$data->name}}</h5>     
                      </div>
                  <div class="col-md-12 text-left mt-5" >
                  	<h5>Finish Goods Product List </h5>
                  </div>
                  <table id="datatable" class="table table-bordered table-striped table-fixed mt-2"
                        style="font-size: 11px;table-layout: inherit;">
                        <thead>
                            <tr>
                              <th>No</th>
                              <th>Date</th>
                              <th>Name</th>
                               {{-- <th>Opening</th> --}}
                               <th>Quantity</th>
                               {{-- <th>Closing</th>--}}
                              <th>Rate</th>
                              <th>Total Amount</th>  
                             </tr>
                            </thead>
                            <tbody>

                            @php
                            $totalq = 0;

                            $totala = 0;
                            @endphp

                            @foreach($fGoods as $key=>$data)
                            	@php 
                                  $amount = 0; 
                                  $amount = $data->price*$data->qty; 
                              	  $totalq += $data->qty;
                              	  $totala += $amount;
                                @endphp 
                              <tr>
                                <td>{{++$key}}</td>
                                <td>{{$data->date}}</td>
                                <td>{{$data->name}}</td>
                                <td>{{number_format($data->qty,2)}}</td>
                                <td>{{number_format($data->price,2)}}</td>
                                <td>{{number_format($amount,2)}}</td>

                          </tr>
                            @endforeach
                            </tbody>
                           <tfoot>
                            <tr style="font-size: 18px;background: #42e1e1; color:#000;">
                              <th colspan="3" style="text-align:center">Total</th>
                              <th>{{number_format($totalq,2)}}</th>
                              <th></th>
                              <th>{{number_format($totala,2)}}</th>
                            </tr>

                            </tfoot>

                    </table>
                  <div class="col-md-12 text-left mt-5" >
                  	<h5>Raw Materials Product List </h5>
                  </div>
                    <table id="datatable" class="table table-bordered table-striped table-fixed mt-2"
                        style="font-size: 11px;table-layout: inherit;">
                        <thead>
                            <tr>
                              <th>No</th>
                              <th>Date</th>
                              <th>Item</th>
                               {{-- <th>Opening</th> --}}
                               <th>Quantity</th>
                               {{-- <th>Closing</th> --}}
                              <th>Rate</th>
                              <th>Total Amount</th>
                             </tr>
                            </thead>
                            <tbody>

                            @php
                            $totalq = 0;

                            $totala = 0;
                            @endphp

                            @foreach($rowProducts as $key=>$data)
                            @php 
                                $rate = 0; $amount = 0; 
                                $rate = ($data->rate+$data->stock_out_rate)/2;
                                $amount = $rate*$data->qty; 
                              	$totalq += $data->qty; 
                              	$totala += $amount;
                                @endphp 
                              <tr>
                                <td>{{++$key}}</td>
                                <td>{{$data->date}}</td>
                                <td>{{$data->name}}</td>
                                <td>{{number_format($data->qty,2)}}</td>
                                <td>{{number_format($rate,2)}}</td>
                                <td>{{number_format($amount,2)}}</td>

                          </tr>
                            @endforeach
                            </tbody>
                             <tfoot>
                            <tr style="font-size: 18px;background: #42e1e1; color:#000;">
                              <th colspan="3" style="text-align:center">Total:</th>
                              <th>{{number_format($totalq,2)}}</th>
                              <th></th>
                              <th>{{number_format($totala,2)}}</th>
                            </tr>

                            </tfoot> 

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
@endsection
