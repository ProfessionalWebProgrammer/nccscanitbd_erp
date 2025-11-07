@extends('layouts.sales_dashboard')
@section('header_menu')

@endsection

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">


        <!-- Main content -->
        <div class="content px-4 ">
          <div class="col-md-12 pt-3" align="right" id="btndiv">
            <button class="btn btn-outline-warning"  onclick="printDiv('cardbody')"><i class="fa fa-print"
                    aria-hidden="true"> Print </i></button>

         </div>
            <div class="container-fluid" id="cardbody">
                <div class="text-center pt-3">
                    <h3 class="text-uppercase font-weight-bold">Naba Crop Care</h3>
                  <p>Head office, Rajshahi, Bangladesh</p>
                </div>
                <div class="text-center pt-2 mb-4">
                    <h5 class="text-uppercase font-weight-bold">Chalan View</h5>
                   <hr>
                </div>
                <div class="col-md-12">
                <div class="row ">
                    <div class="col-md-6 text-left" style="width:50%; display:block;">
                      <p class="h4">Dealer : {{$salesdetails->d_s_name}}</p>
                      <p class="h4">Address : {{$invoice->dlr_address ?? $salesdetails->dlr_address}}</p>
                      <p class="h4">Warehouse : {{ $salesdetails->factory_name}}</p>
                      <p class="h4">Driver Name : {{ $invoice->driver ?? ''}}</p>
                      <p class="h4">Driver Phone : {{ $invoice->phone ?? ''}}</p>
                      <p class="h4">Vehicle No : {{ $invoice->vehicle ?? ''}}</p>
                      <form action="{{route('sales.on.invoice.update')}}" method="POST">
                        <p class="h4">Transport Cost :
                       @csrf
                       <input type="hidden" name="invoice" value="{{$salesdetails->invoice_no}}">
                       <input type="text" style="border: none;" oninput="showButton()" name="tcost" value="{{$salesdetails->transport_cost}}"  class="form-comtrol">  </td> <td><button class="btn btn-sm btn-outline-info m-2" type="submit" style="display:none" id="button">Save</button>

                       </p>
                       </form>
                    </div>
                    <div class="col-md-6 text-right" style="width:50%; display:block;">
                      <h4>Invoice Date : {{ date('d-m-Y',strtotime($salesdetails->date)) }}</h4>
                      <h5>Chalan Date : {{ date('d-m-Y',strtotime($invoice->date)) }}</h5>
                      <h4>Invoice : {{$invoice->invoice_no}}</h4>
                      <div class=" ">
                          <img class="img-fluid bg-light" style="height: 40px; width: 210px;" src="{{ asset('public/backend/images/barcode-png.png') }}"
                              alt="Barcode-Display">
                      </div>
                      <h5 class="mt-2 mb-3">Current Time:  {{date('g:i a',strtotime(Carbon\Carbon::now()))}} </br> Current Date: {{date('d-m-Y',strtotime(Carbon\Carbon::now()))}}</h5>
                      <h5>Create By: {{$user}}</h5>
                    </div>
                </div>
                </div>
                <div class="row">
                    {{-- <div class="col-md-1"></div> --}}
                    <div class="col-md-12 mt-5">
                        <table id="" class="table table-bordered table-striped table-fixed" style="font-size:20px;">
                            <thead>
                                <tr>
                                    <th width="10%">Si No</th>
                                    <th>Product Name</th>
                                    <th class="text-center" colspan="2">Quantity</th>
                                    {{-- <th class="text-right">Amount</th> --}}
                                </tr>
                            </thead>
                            <tbody>

                                @php
                                    $totalvalue = 0;
                                    $totaldes = 0;
                                    $totalAmount = 0;
                                @endphp

                                @foreach ($salesitems as $item)
								                @php
                              		$totalvalue += $item->qty_pcs;
                                  $weightUnit = \App\Models\ProductUnit::where('id',$item->product_weight_unit)->value('unit_name');
                                  $unit =\App\Models\ProductUnit::where('id',$item->product_unit)->value('unit_name');
                                  //$amount = ($item->qty_pcs * $item->unit_price) - $item->discount_amount;
                                  //$totalAmount += $amount;
                                @endphp
                                @if($item->qty_pcs > 0)
                                <tr>
                                    <td>{{$loop->iteration}}</td>
                                    <td>{{$item->product_name}}</td>

                                    <td  align="center">{{$item->qty_pcs*$item->product_weight}}  {{$weightUnit}}</td>
                                    <td  align="center">{{$item->qty_pcs}}  {{$unit}}</td>
                                   {{-- <td align="right">{{number_format($amount,2)}}</td> --}}
                                </tr>
								                        @else

                                        @endif
                                @endforeach

                            </tbody>
                          <tr>
                            <td colspan="3" align="left" >Total:</td>
                            <td align="center" >{{$totalvalue}}</td>
                           {{-- <td align="right">{{number_format($totalAmount,2)}}</td> --}}
                          </tr>
                          {{-- <tr>
                            <th  colspan="5" style="text-transform: capitalize; text-align:left;">Total Amount in words: {{convert_number($totalAmount).convert_paisa((string)$totalAmount)}}</th>
                           <tr> --}}
                        </table>
                    </div>
                </div>
              <div class="col-md-12 mt-5" ><br> <br><br></div>
                <div class="row mt-5 pb-5" >
                  <table style="width:100%">
                    <tr >
                      <th  width="25%" style="text-align:center;" ><span style=" margin-top:10px; border-top:1px solid #333;" >Delivered By</span></th>
                      <th  width="25%" style="text-align:center;"><span style=" margin-top:10px; border-top:1px solid #333;" >Checked By</span></th>
                      <th  width="25%" style="text-align:center;"><span style=" margin-top:10px; border-top:1px solid #333;" >Received By</span></th>
                      <th  width="25%" style="text-align:center;"><span style=" margin-top:10px; border-top:1px solid #333;" >Autorise By</span></th>
                    </tr>
                  </table>
                    <br><br>
                </div>
            </div>
            <!-- /.container-fluid -->
        </div>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
		<script>
            function printDiv(divName) {
                var printContents = document.getElementById(divName).innerHTML;
                var originalContents = document.body.innerHTML;
                document.body.innerHTML = printContents;
                window.print();
                document.body.innerHTML = originalContents;
            }
			 function showButton() {
                var a = document.getElementById("button");
                   a.style.display = "block";
                }
        </script>
@endsection
