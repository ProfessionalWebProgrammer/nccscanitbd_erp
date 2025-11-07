@extends('layouts.account_dashboard')

@push('addcss')
    <style>
        .text_sale {
            color: #f7ee79;
        }

        .text_credit {
            color: lime;
        }

    </style>
@endpush

@section('print_menu')

			<li class="nav-item">

                </li>

@endsection


@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper" >


        <!-- Main content -->
        <div class="content px-4 ">
          <div class="row pt-3">
                  	<div class="col-md-12 text-right">
                      	<button class="btn btn-sm  btn-success mt-1" id="btnExport"  >
                           Export
                        </button>
                        <button class="btn btn-sm  btn-warning mt-1"  onclick="printDiv('contentbody')"  id="printbtn">
                           Print
                        </button>
                    </div>
                </div>

            <div class="container-fluid" id="contentbody" >


               <div class="row pt-2">
                  	<div class="col-md-4 text-left">
                      <h5 class="text-uppercase font-weight-bold">Statement of Comprehensive Income</h5>
                      <p>From {{date('d m, Y',strtotime($fdate))}} to {{date('d m, Y',strtotime($tdate))}}</p>

                    </div>
                  	<div class="col-md-4 pt-3 text-center">
                      <h3 class="text-uppercase font-weight-bold">Naba Crop Care</h3>
                      <p>Head office, Rajshahi, Bangladesh</p>
                    </div>
                </div>

                <div class="py-4">


                    <div class="py-4 col-md-8 m-auto table-responsive">
                        <table id="reporttable" class="table table-bordered table-striped table-fixed"
                            style="font-size: 6;table-layout: inherit;">
                            <thead>
                                <tr class="text-center">
                                    <th>Head </th>
                                    <th>Amount (BDT)</th>

                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $total = 0;
                                @endphp


                                <tr>
                                    @php
                                        $total += $data['sales'];
                                    @endphp
                                    <td>Sales Revenues</td>
                                    <td align="right">{{ number_format($data['sales'], 2) }}</td>

                                </tr>

                               <tr style="font-weight: bold;color:red">
                                    <td>Variable Manufacturing  Costs:</td>
                                    <td align="right"></td>

                                </tr>

                               <tr>
                                    @php
                                        $total += $data['manufacturing_costs'];
                                    @endphp
                                    <td>Raw & Packing Materials Used</td>
                                    <td align="right">{{ number_format($data['manufacturing_costs'], 2) }}</td>

                                </tr>
                              <tr>
                                    @php
                                        $total += 0;
                                    @endphp
                                    <td>Variable Factory Overheads</td>
                                    <td align="right">0</td>

                                </tr>


                                <tr style="font-weight: bold;color:red">
                                    <td>Total Variable Mfg. Cost :</td>
                                    <td align="right">{{ number_format($data['manufacturing_costs'], 2) }}</td>

                                </tr>



                                <tr>
                                    @php
                                        $total -= $data['cogs'];
                                    @endphp
                                    <td>C.O.G.S (Direct Operating Cost)</td>
                                    <td align="right">{{ number_format($data['cogs'], 2) }}</td>

                                </tr>
                                <tr style="font-weight: bold;color:red">
                                    <td>Gross profit</td>
                                    <td align="right">{{ number_format($total, 2) }} @if($total != 0)({{  number_format(($total/$data['sales'])*100,2) }}%) @endif</td>

                                </tr>






                                @if ($allexpasne)

                                <tr style="font-weight: bold;color:blue">
                                    <td>All Expanse</td>
                                    <td align="right"></td>

                                </tr>

                                @php
                              $expansetotal = 0;
                              @endphp
                                @foreach ($allexpasne as $key=>$item)

                                <tr>
                                    @php
                                        $total -= $item->expamount;
                                        $expansetotal += $item->expamount;
                                    @endphp
                                    <td class="pl-5">{{$item->group_name ? $item->group_name : "Others Expnase" }}</td>
                                    <td align="right">{{  number_format($item->expamount,2) }}</td>

                                </tr>

                                @endforeach

                                <tr style="font-weight: bold">
                                    <td>Total Expnase</td>
                                    <td align="right">{{ number_format($expansetotal, 2) }}</td>

                                </tr>
                              @if($data['asset_depreciations'])
                               <tr style="font-weight:bold">
                                    <td colspan="100%">Depreciation Amount </td>

                                </tr>
                              @php
                              $tpped = 0;
                              @endphp
                              @foreach($data['asset_depreciations'] as $item)
                             	 <tr>
                                      @php
                                     $tpped += $item->yearly_amount;
                                  $total -= $item->yearly_amount;
                                     @endphp
                                    <td style="padding-left:30px">{{$item->asset_head}}-{{$item->product_name}}</td>
                                    <td align="right">{{number_format($item->yearly_amount,2)}}</td>

                                </tr>
                              @endforeach
                              <tr style="font-weight:bold">
                                   <td>Total  Depreciation Amount</td>
                                    <td align="right">{{number_format($tpped, 2)}}</td>

                                </tr>
                              @endif
                               <tr style="font-weight:bold">
                                   <td>Grand Total  Expanse</td>
                                    <td align="right">{{number_format($tpped+$expansetotal, 2)}}</td>

                                </tr>


                                  <tr style="font-weight: bold;color:blue">
                                    <td>Operating Profit</td>
                                    <td align="right">{{ number_format($total, 2)}}</td>

                                </tr>

                                 @endif




                               @if ($allincome)

                                <tr style="font-weight: bold;color:blue">
                                    <td>Others Income</td>
                                    <td align="right"></td>

                                </tr>

                              @php
                              $incometotal = 0;
                              @endphp
                                @foreach ($allincome as $key=>$item)



                                <tr>
                                    @php
                                        $total += $item->incomeamount;
                                  $incometotal += $item->incomeamount;
                                    @endphp
                                    <td class="pl-5">{{$item->name}}</td>
                                    <td align="right">{{ number_format($item->incomeamount,2)}}</td>

                                </tr>

                                @endforeach
								<tr style="font-weight: bold">
                                    <td>Total Income</td>
                                    <td align="right">{{ number_format($incometotal,2)}}</td>

                                </tr>


                                @endif


                                <tr style="font-weight: bold">
                                    <td>Operating Profit (Before Tax)</td>
                                    <td align="right">{{ number_format($total,2) }}</td>

                                </tr>


                                <tr style="font-weight: bold">
                                    <td>Taxes</td>
                                    <td align="right">{{ number_format($taxes,2) }}% ({{($total/100)*($taxes)}})</td>

                                </tr>









                            </tbody>

                            <tfoot>
                                <tr style="color:red; font-weight:bold">
                                    <th>Net Profit (After Tax)</th>
                                    <td align="right">{{ number_format(($total/100)*(100-$taxes),2) }}</td>

                                </tr>

                            </tfoot>




                        </table>
                    </div>

                </div>
            </div>
        </div>
    </div>


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
    $(function () {
        $("#btnExport").click(function () {
            $("#reporttable").table2excel({
                filename: "Income_statement.xls"
            });
        });
    });
</script>

@endpush
