@extends('layouts.sales_dashboard')

@section('print_menu')


@endsection

@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">



    <!-- Main content -->
    <div class="content px-4 ">
      			<div class="row pt-2">
                  	<div class="col-md-12 text-right">
                      <button class="btn btn-sm  btn-success mt-1" id="btnExport"> Export </button>
                      <button class="btn btn-sm  btn-warning mt-1" onclick="printDiv('contentbody')" id="printbtn"> Print </button>
                      <button class="btn btn-sm  btn-warning mt-1" onclick="printland()" id="printland">  PrintLands. </button>
                    </div>
                </div>

        <div class="container-fluid" style="background:#ffffff; padding:0px 40px;min-height:85vh"  id="contentbody">
            <div class="challanlogo" align="center">
              <div class="row pt-2">
                  	<div class="col-md-4 text-left">
                      <h5 class="text-uppercase font-weight-bold">Dealer Sales Report</h5>
                      <p>From {{date('d M, Y',strtotime($fdate))}} to {{date('d M, Y',strtotime($tdate))}}</p>

                    </div>
                  	<div class="col-md-4 pt-3 text-center">
                      	<h3 class="text-uppercase font-weight-bold">Naba Crop Care</h3>
                  <p>Head office, Rajshahi, Bangladesh</p>
                    </div>
                </div>
                <div class="text-center pt-3">

                  
                </div>
            </div>
            <div class="py-4 table-responsive">
                <table id="reporttable" class="table table-bordered table-striped table-fixed" style="font-size: 15px;">
                    <thead>
                        <tr class="table-header-fixt-top">
                            <th>SI. No</th>
                            <th>Product Name</th>
                            <th>Qty (Bag)</th>
                            <th>Qty (Kg)</th>
                            <th>Qty (Ton)</th>
                            {{-- <th>Unit Price</th>
                            <th>Total Value</th> --}}
                        </tr>
                    </thead>
                    <tbody>
                      @php 
                      $grandTotalBag = 0; $grandTotalKg = 0; 
                      @endphp 
                     @foreach ($dealers as $val) 
                      <tr>
                        <td colspan="100%"> {{$val->name}} </td>
                      </tr>
                      @php 
                      	$details = \App\Models\SalesLedger::select([DB::raw("SUM(qty_pcs) total_bag"), DB::raw("SUM(qty_kg) total_kg"), 'product_name'])
                      				->where('vendor_id',$val->vendor_id)->whereBetween('ledger_date', [$fdate, $tdate])->groupBy('product_id')->get(); 
                     	$subTotalBag = 0;
                      	$subTotalKg = 0; 
                      @endphp 
                      @foreach ($details as $data) 
                      @php
                      $subTotalBag += $data->total_bag;
                      $subTotalKg += $data->total_kg;
                      
                      $grandTotalBag += $data->total_bag;
                      $grandTotalKg += $data->total_kg;
                      @endphp 
                        @if($data->total_bag != null)
                        <tr>
                          <td>{{$loop->iteration - 1}}</td>
                          <td>{{$data->product_name}}</td>
                          <td>{{$data->total_bag}}</td>
                          <td>{{$data->total_kg}}</td>
                          <td>{{$data->total_kg/1000}}</td>
                        </tr>
                        @endif
                      @endforeach
                      <tr style="background:#3ab0bd; font-weight:600; font-size:16px;">
                      	<td colspan="2">Sub Total</td>
                          <td>{{$subTotalBag}} (Bag)</td>
                          <td>{{$subTotalKg}} (Kg)</td>
                          <td>{{$subTotalKg/1000}} (Ton)</td>
                      </tr>
					@endforeach
                    </tbody>
                    <tfoot>
						<tr style="background:#FA621C; font-weight:700; font-size:18px; color:#f5f5f5;">
                      	<td colspan="2">Grand Total</td>
                          <td>{{$grandTotalBag}} (Bag)</td>
                          <td>{{$grandTotalKg}} (Kg)</td>
                          <td>{{$grandTotalKg/1000}} (Ton)</td>
                      </tr>
                    </tfoot>
                </table>

                </table>
            </div>
        </div>
    </div>
</div>
<script>

</script>
@endsection


@push('end_js')

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
    $(function() {
        $("#btnExport").click(function() {
            $("#reporttable").table2excel({
                filename: "DealerSalesReport.xls"
            });
        });
    });

    function printland() {

        printJS({
            printable: 'contentbody',
            type: 'html',
            font_size: '16px;',
            style: ' @page { size: A4 landscape; max-height:100%; max-width:100%} table, th, td {border: 1px solid black; border-collapse: collapse; padding: 0px 3px}  h5{margin-top: 0; margin-bottom: .5rem;} .challanlogo{margin-left:150px}'
        })

    }
</script>
@endpush
