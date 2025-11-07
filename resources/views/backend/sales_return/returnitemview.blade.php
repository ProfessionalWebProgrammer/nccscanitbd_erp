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
           <div class="container-fluid" style="background:#ffffff; padding:0px 40px;min-height:85vh"id="cardbody">
                <div class="text-center pt-3">
                    <h3 class="text-uppercase font-weight-bold">Naba Crop Care</h3>
		                  <p>Head office, Rajshahi, Bangladesh</p>
                </div>
                <div class="text-center pt-3">
                    <h5 class="text-uppercase font-weight-bold">Return Voucher</h5>
                   <hr>
                </div>
                <div class="row pt-4">

                    <div class="col-md-8">
                        <div class="text-left">
                            <div class="mt-3">
                                <table style="font-size:22px;">
                                    <tr>
                                        <td>Date : </td>
                                        <td> {{$returninvoicedata->date}} </td>
                                    </tr>
                                    <tr>
                                    <td>Invoice : </td>
                                    <td>{{$returninvoicedata->invoice_no}}</td>

                                    </tr>
                                  	{{-- <tr>
                                        <td>Dealer : </td>
                                        <td> {{DB::table('dealers')->where('id',$returninvoicedata->dealer_id)->value('d_s_name');}} </td>
                                    </tr> --}}
                                    <tr>
                                        <td>Warehouse : </td>
                                        <td>{{DB::table('factories')->where('id',$returninvoicedata->warehouse_id)->value('factory_name');}}  </td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-1"> </div>
                </div>
                <div class="row">
                    <div class="col-md-12 mt-5">
                        <table id="" class="table table-bordered table-striped table-fixed" style="font-size:20px;">
                            <thead>
                                <tr>
                                    <th style="width: 10px">#</th>
                                    <th>Product Name</th>
                                    <th>Dealer</th>
                                    <th>Price</th>
                                    <th>Quantity</th>
                                    <th>Debit Amount</th>
                                    <th>Credit Amount</th>
                                </tr>
                            </thead>
                            <tbody>

                                @php
                                    $totalvalue = 0;
                                    $totalqnt = 0;
                                @endphp

                                @foreach ($returnitems as $item)

                                @php
                                  $totalvalue += $item->total_price+$item->discount_amount;
                                  $totalqnt += $item->qty;
                              	@endphp
                                <tr>
                                    <td>{{$loop->iteration}}</td>
                                    <td>{{DB::table('sales_products')->where('id',$item->product_id)->value('product_name')}}</td>
                                    <td></td>
                                    <td align="right">{{number_format($item->unit_price,2)}}</td>
                                    <td  align="right">{{number_format($item->qty,2)}}</td>
                                    <td  align="right">{{number_format(($item->total_price+$item->discount_amount),2)}}/-</td>
                                    <td  align="right">0/-</td>
                                </tr>
                                @endforeach
                                
                                <tr>
                                    <td colspan="2"></td>
                                    <td>{{DB::table('dealers')->where('id',$returninvoicedata->dealer_id)->value('d_s_name');}}</td>
                                    <td align="right"></td>
                                    <td class="text-right">{{number_format($totalqnt,2)}}</td>
                                    <td  align="right">0/-</td>
                                    <td class="text-right">{{number_format($totalvalue,2)}}/-</td>
                                </tr>


                            </tbody>
                            <tfoot >

                                  <tr class="font-weight-bold">
                                      <td colspan="7" >Total Amount: {{ convert_number($totalvalue).convert_paisa((string)$totalvalue) }} </td>
                                      {{-- <td class="text-right">{{$totalqnt}}</td>
                                      <td class="text-right">{{number_format($totalvalue,2)}}</td> --}}
                                  </tr>
                              </tfoot>
                        </table>
                    </div>
                </div>
                <div class="col-md-12 mt-5" ><br> <br><br></div>
                <div class="row mt-5 pb-5" >
                  <table style="width:100%">
                    <tr >
                      <th  width="33.33%" style="text-align:center;" ><span style=" margin-top:10px; border-top:1px solid #333;" >Delivered By</span></th>
                      <th  width="33.33%" style="text-align:center;"><span style=" margin-top:10px; border-top:1px solid #333;" >Printed By</span></th>
                      <th  width="33.33%" style="text-align:center;"><span style=" margin-top:10px; border-top:1px solid #333;" >Autorise By</span></th>
                    </tr>
                  </table>
                    <br><br>
                </div>
                {{-- <div class="row mt-5 pb-5">
                    <div class="col-md-3">
                        <div class="text-center " style="font-size:22px;">
                            <p></p>
                            <hr class="bg-light my-0" width="70%">
                            <p>Delivered By</p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="text-center" style="font-size:22px;">
                            <p></p>
                            <hr class="bg-light my-0" width="70%">
                            <p>Printed By</p>
                        </div>
                    </div>
                    <div class="col-md-3 text-center" style="font-size:22px;">
                        <p></p>
                        <hr class="bg-light my-0" width="70%">
                        <p>Autorise Signature</p>
                    </div>
                </div> --}}
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
