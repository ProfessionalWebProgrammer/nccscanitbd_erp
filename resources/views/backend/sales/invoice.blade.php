
@extends('layouts.sales_dashboard')

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">


        <!-- Main content -->
        <div class="content px-4 ">
              <div class="col-md-12 pt-3" align="right" id="btndiv">
                <button class="btn btn-outline-warning"  onclick="printDiv('cardbody')"><i class="fa fa-print"
                        aria-hidden="true"> Print </i></button>
             </div>
            <div class="container-fluid pl-5 pr-5" id="cardbody">
                <div class="text-center pt-3">
                    <h3 class="text-uppercase font-weight-bold">Naba Crop Care</h3>
                  <p>Head office, Rajshahi, Bangladesh</p>
                </div>
                <div class="text-center pt-1 pb-3">
                    <h5 class="text-uppercase font-weight-bold">Invoice View</h5>
                   <hr>
                </div>

                <div class="col-md-12">
                <div class="row">
                  <div class="col-md-6 text-left" style="width:50%; display:block;">
                    <h4>Invoice Date : {{ date("d-m-Y", strtotime($salesdetails->date))}}</h4>
                    <p class="h5">Dealer : {{$salesdetails->d_s_name}}</p>
                    <p class="h5">Address : {{$salesdetails->dlr_address}}</p>
                    <p class="h5">Warehouse : {{ $salesdetails->factory_name}}</p>
                     <form action="{{route('sales.on.invoice.update')}}" method="POST">
                       <p class="h5">Transport Cost :
                      @csrf
                      <input type="hidden" name="invoice" value="{{$salesdetails->invoice_no}}">
                      <input type="text" style="border: none;" oninput="showButton()" name="tcost" value="{{$salesdetails->transport_cost}}"  class="form-comtrol">  </td> <td><button class="btn btn-sm btn-outline-info m-2" type="submit" style="display:none" id="button">Save</button>

                      </p>
                      </form>
                      <h5 class="mt-2">Current Time:  {{date('g:i a',strtotime(Carbon\Carbon::now()))}} </br> Current Date: {{date('d-m-Y',strtotime(Carbon\Carbon::now()))}}</h5>
                  </div>
                  <div class="col-md-6 text-right" style="width:50%; display:block;">
                   <p class="h6 "> <b>Opening Balance : @if($openingBalance) {{number_format(($openingBalance[0]->balance + $salesdetails->dlr_base),2) }} @else {{number_format(($salesdetails->dlr_base),2) }} @endif </b></p>
                    <p class="h6 "> <b>Current Invoice Value : {{number_format($salesdetails->grand_total,2)}}</b></p>
                    <p class="h6 "> <b>Current Balance : @if($openingBalance){{number_format(($openingBalance[0]->balance + $salesdetails->dlr_base + $salesdetails->grand_total),2) }} @else  {{number_format(($salesdetails->dlr_base + $salesdetails->grand_total),2) }}  @endif </b></p>
                    <p class="h6 "> <b>Last Payment Amount : @if($lastPaymentDate){{ number_format($lastPaymentDate->credit,2) }} @else  @endif</b></p>
                    <p class="h6 "> <b>Last Payment Date : @if($lastPaymentDate) {{ date('d-m-Y',strtotime($lastPaymentDate->ledger_date)) }} @else  @endif</b></p>
                    <h4>Invoice : {{$invoice}}</h4>
                    <div class="mb-3">
                        <img class="img-fluid bg-light" style="height: 40px; width: 210px;" src="{{ asset('public/backend/images/barcode-png.png') }}"
                            alt="Barcode-Display">
                    </div>
                    <h5>Create By: {{$user}}</h5>
                  </div>
                </div>
                </div>

                <div class="row">
                    {{-- <div class="col-md-1"></div> --}}
                    <div class="col-md-12 mt-5">
                        <table id="" class="table table-bordered table-striped table-fixed" style="font-size:16px;">
                            <thead>
                                <tr>
                                    <th style="width: 10px">#</th>
                                    <th>Product Name</th>
                                    <th>Price</th>
                                    <th colspan="2" style="text-align:center">Quantity</th>
                                    <th>Commission</th>
                                    <th>Comm Value</th>
                                    {{-- <th>Free</th> --}}
                                    <th>Total Value</th>
                                </tr>
                            </thead>
                            <tbody>

                                @php
                                    $totalvalue = 0;
                                    $totaldes = 0;
                                @endphp

                                @foreach ($salesitems as $item)

                                @php
                                $totalvalue += $item->total_price+$item->discount_amount;
                                $totaldes += $item->discount_amount;
                            @endphp
                                <tr>
                                    <td>{{$loop->iteration}}</td>

                                    <td>{{$item->product_name}}</td>
                                    <td align="right">{{$item->unit_price}}</td>
                                    <td  align="right">{{$item->qty * $item->product->product_weight }} {{$item->product->weightUnit->unit_name}}</td>
                                    <td  align="right">{{$item->qty }} {{$item->product->unit->unit_name}}</td>
                                  	@if($item->discount_amount > 0)
                                    <td  align="right">@if($item->discount > 0) {{ $item->discount }} %  @else  0  @endif</td>
                                    <td  align="right">{{number_format($item->discount_amount,2)}}</td>
                                    @else
                                    <td  align="right"></td>
                                    <td  align="right"></td>
                                    @endif
                                    {{-- <td  align="right">{{number_format($item->bonus,2)}}</td> --}}
                                    <td  align="right">{{number_format($item->total_price+$item->discount_amount,2)}}</td>

                                </tr>

                                @endforeach


                            </tbody>
                            <tfoot class="text-right">
                                <tr class="font-weight-bold">
                                    <td colspan="7">Total Value</td>
                                    <td>{{number_format($totalvalue,2)}}</td>
                                </tr>
                                <tr class="font-weight-bold">
                                    <td colspan="7">Commission</td>
                                    <td>{{number_format($totaldes,2)}}</td>
                                </tr>
                                <tr class="font-weight-bold">
                                    <td colspan="7">Payable</td>
                                    <td>{{number_format($totalvalue-$totaldes,2)}}</td>
                                </tr>
                                <tr>
                                  <th  colspan="100%" style="text-transform: capitalize; text-align:left;">Total Amount in words: {{convert_number($totalvalue-$totaldes).convert_paisa((string)($totalvalue-$totaldes))}}</th>
                                 <tr>
                            </tfoot>
                        </table>
                    </div>
                    {{-- <div class="col-md-1"></div> --}}
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
