@extends('layouts.account_dashboard')
@section('header_menu')
@endsection

@push('addcss')
    <style>
        .text_sale {
            color: #1fb715;
        }
        .text_credit{
            color: #f90b0b;
        }
          .tableFixHead          { overflow: auto; height: 600px; }
    	.tableFixHead thead th { position: sticky; top: 0; z-index: 1; }

    </style>
@endpush

@section('print_menu')
@endsection

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper"  >


        <!-- Main content -->
        <div class="content px-4 ">
          <div class="row pt-2">
                  	<div class="col-md-12 text-right">
                         <button class="btn btn-sm  btn-success mt-1" id="btnExport"  >
                           Export
                        </button>
                        <button class="btn btn-sm  btn-warning mt-1"  onclick="printDiv('contentbody')"  id="printbtn"  >
                           Print
                        </button>
                    </div>
                </div>
            <div class="container-fluid " id="contentbody">
                <div class="text-center pt-3">
                    <h3 class="text-uppercase font-weight-bold">Naba Crop Care</h3>
                    <p>Head office, Rajshahi, Bangladesh</p>
                    <h5>Asset Depreciation Report</h5>
                    <p class=" font-weight-bold">Date : {{ date('d-F-Y', strtotime($startDate)) }} to
                        {{ date('d-F-Y', strtotime($finalDate)) }}</p>
                </div>
                <div  class="table-responsive tableFixHead pb-5" >
                   <table  id="reporttable" class="table table-bordered p-2" style="font-size: 14px; font-weight: 600; border:2px solid;">
                        <thead>
                            <tr class="text-center table-header-fixt-top" >

                                <th rowspan="2">Particulars</th>
                                <th colspan="4">Cost (Tk.)</th>
                                <th rowspan="2">Depreciation Rate</th>
                                <th colspan="4">Depreciation (Tk.)</th>
                                <th rowspan="2">Remaining Value</th>
                           </tr>
                           <tr>
                             <th>Balance </th>
                             <th>Addition </th>
                             <th>Adjustment</th>
                             <th>Total</th>
                             <th>D Balance </th>
                             <th>Current Month </th>
                             <th>Adjustment</th>
                             <th>Total</th>
                           </tr>
                        </thead>
                        <tbody>
                          @php
                          $totalOpeningAmount = 0;
                          $totalCurrentAmount = 0;
                          $totalSales = 0;
                          $totalAssetSales = 0;
                          $grandTotalCost = 0;
                          $totalOpeningDepreciationAmount = 0;
                          $totalDepCurrentAmount = 0;
                          $grandTotalDepreciationAmount = 0;
                          $grandTotalFinalBalance = 0;

                          @endphp
                          @foreach($assetCategory as $val)
                          <tr>
                            <td colspan="100%">{{$val->name}}</td>
                          </tr>
                          @php
                          $subTotalOpeningAmount = 0;
                          $subTotalCurrentAmount = 0;
                          $subTotalSales = 0;
                          $subTotalAssetSales = 0;
                          $subTotalCost = 0;
                          $subTotalOpeningDepreciationAmount = 0;
                          $subTotalDepCurrentAmount = 0;
                          $subTotalDepreciationAmount = 0;
                          $subTotalFinalBalance = 0;
                          $assetProducts = \App\Models\AssetProduct::where('group_id',$val->id)->get();

                          //$landAssetAmount = \App\Models\ExpanseSubgroup::where('subgroup_name','LAND AND LAND DEVELOPMENT (KAZIR PARA)')->sum('balance');
                          @endphp
                          @foreach($assetProducts as $key => $value)
                          @php


                          /* $preOpeningRemainingValue = \App\Models\Account\AssetDepreciationInfoDetails::where('product_id',$value->id)
                                            ->whereBetween('date',[$preStartDate2,$preEndDate2])->sum('account_value'); */

                          $openingAmount = \App\Models\Account\AssetDepreciationInfoDetails::where('product_id',$value->id)
                                            ->whereBetween('date',[$preStartDate,$preEndDate])->sum('total_asset');
                                            /* if($openingAmount){
                                              dd($openingAmount);
                                            } */



                          $openingDepreciationAmount = \App\Models\Account\AssetDepreciationInfoDetails::where('product_id',$value->id)
                                            ->whereBetween('date',[$preStartDate,$preEndDate])->sum('dep_account');

                          $preOpeningDep = \App\Models\AssetProduct::where('id',$value->id)->sum('dep_amount');

                          if($openingDepreciationAmount){
                            $openingDepreciationAmount = $openingDepreciationAmount;
                          } elseif($key == 1) {

                            $openingDepreciationAmount = $openingDepreciationAmount +$preOpeningDep;
                          } else {
                            $openingDepreciationAmount = $preOpeningDep;
                          }

                          $currentAmount = \App\Models\Account\AssetDepreciationInfoDetails::select(
                                            DB::raw('SUM(asset_value) as adition'),
                                            DB::raw('SUM(remaining_value) as remaining'),
                                            DB::raw('SUM(account_value) as amount'))
                                            ->where('product_id',$value->id)
                                            ->whereBetween('date',[$startDate,$finalDate])->groupBy('product_id')->first();

                          $assetSales = \App\Models\OthersIncome::where('product_id',$value->id)->whereBetween('date',[$startDate,$finalDate])->sum('amount');
                          if($assetSales){
                            $salesAdjustment =  (($assetSales * $value->depreciation_rate) / 100 ) / 12;
                          } else {
                            $salesAdjustment = 0;
                          }

                          if($currentAmount){
                            $totalCost = $currentAmount->adition + $openingAmount - $assetSales ;
                            $totalDepreciationAmount = $openingDepreciationAmount + $currentAmount->amount  - $salesAdjustment;

                            $totalCurrentAmount += $currentAmount->adition;
                            $subTotalCurrentAmount += $currentAmount->adition;
                            $totalDepCurrentAmount += $currentAmount->amount;
                            $subTotalDepCurrentAmount += $currentAmount->amount;
                          } else {
                            $totalCost = $openingAmount;
                            $totalDepreciationAmount =  $openingDepreciationAmount - $salesAdjustment;

                            $totalCurrentAmount += 0;
                            $subTotalCurrentAmount += 0;
                            $totalDepCurrentAmount += 0;
                            $subTotalDepCurrentAmount += 0;
                          }

                          $finalBalance = $totalCost - $totalDepreciationAmount;
                          $subTotalSales += $assetSales ?? 0;
                          $totalSales += $assetSales ?? 0;

                          $totalOpeningAmount += $openingAmount;
                          $subTotalOpeningAmount += $openingAmount;
                          $totalAssetSales += $salesAdjustment;
                          $subTotalAssetSales += $salesAdjustment;
                          $grandTotalCost += $totalCost;
                          $subTotalCost += $totalCost;
                          $totalOpeningDepreciationAmount += $openingDepreciationAmount;
                          $subTotalOpeningDepreciationAmount += $openingDepreciationAmount;
                          $grandTotalDepreciationAmount += $totalDepreciationAmount;
                          $subTotalDepreciationAmount += $totalDepreciationAmount;
                          $grandTotalFinalBalance += $finalBalance;
                          $subTotalFinalBalance += $finalBalance;
                          @endphp
                          @if($openingAmount || $currentAmount)
                                <tr>

                                    <td >{{$value->product_name}}</td>
                                    <td class="text-right">{{number_format($openingAmount,2)}}</td>
                                    <td class="text-right">{{number_format($currentAmount->adition ?? 0 ,2)}}</td>
                                    <td class="text-right">{{number_format($assetSales ,2 ?? 0)}}</td>
                                    <td class="text-right">{{number_format($totalCost,2)}}</td>
                                    <td class="text-center">{{$value->depreciation_rate}} %</td>
                                    <td class="text-right">{{number_format($openingDepreciationAmount,2)}}</td>
                                    <td class="text-right">{{number_format($currentAmount->amount ?? 0,2)}}</td>
                                    <td class="text-right">{{number_format($salesAdjustment,2)}}</td>
                                    <td class="text-right">{{number_format($totalDepreciationAmount,2)}}</td>
                                    <td class="text-right">{{number_format($finalBalance,2)}}</td>
                                </tr>
                                @endif
                            @endforeach
                          {{--  <tr>
                              <td >Land and Land Development (Kazir Para)</td>
                              <td class="text-right">{{number_format($landAssetAmount,2)}}</td>
                              <td class="text-right"></td>
                              <td class="text-right"></td>
                              <td class="text-right">{{number_format($landAssetAmount,2)}}</td>
                              <td class="text-center"></td>
                              <td class="text-right"></td>
                              <td class="text-right"></td>
                              <td class="text-right"></td>
                              <td class="text-right"></td>
                              <td class="text-right">{{number_format($landAssetAmount,2)}}</td>
                            </tr>
                            @php
                            $subTotalOpeningAmount += $landAssetAmount;
                            $subTotalCost += $landAssetAmount;
                            $subTotalFinalBalance += $landAssetAmount;
                            @endphp --}}
                            <tr style="background:#e4d5ad; font-size:16px; font-weight:600;">
                                <td class="text-center">Sub Total:</td>
                                <td class="text-right">{{number_format($subTotalOpeningAmount,2)}}</td>
                                <td class="text-right">{{number_format($subTotalCurrentAmount,2)}}</td>
                                <td class="text-right">{{number_format($subTotalSales ,2)}}</td>
                                <td class="text-right">{{number_format($subTotalCost,2)}}</td>
                                <td class="text-center"></td>
                                <td class="text-right">{{number_format($subTotalOpeningDepreciationAmount,2)}}</td>
                                <td class="text-right">{{number_format($subTotalDepCurrentAmount,2)}} </td>
                                <td class="text-right">{{number_format($subTotalAssetSales,2)}}</td>
                                <td class="text-right">{{number_format($subTotalDepreciationAmount,2)}}</td>
                                <td class="text-right">{{number_format($subTotalFinalBalance,2)}}</td>
                            </tr>
                      @endforeach
                      
                      <tr>
                        @php
                        $landAssetAmount = \App\Models\AssetProduct::where('group_id',20)->sum('balance');
                        @endphp
                          <td >Land and Land Development</td>
                          <td class="text-right">{{number_format($landAssetAmount,2)}}</td>
                          <td class="text-right"></td>
                          <td class="text-right"></td>
                          <td class="text-right">{{number_format($landAssetAmount,2)}}</td>
                          <td class="text-center"></td>
                          <td class="text-right"></td>
                          <td class="text-right"></td>
                          <td class="text-right"></td>
                          <td class="text-right"></td>
                          <td class="text-right">{{number_format($landAssetAmount,2)}}</td>
                        </tr>

                    @php
                      $totalOpeningAmount += $landAssetAmount;
                      $grandTotalCost += $landAssetAmount;
                      $grandTotalFinalBalance += $landAssetAmount;
                      @endphp
                    {{--  @php
                      $totalOpeningAmount += $landAssetAmount;
                      $grandTotalCost += $landAssetAmount;
                      $grandTotalFinalBalance += $landAssetAmount;
                      @endphp --}}
                            <tr style="background:#5dc2cc; font-size:16px; font-weight:600;">
                                <td class="text-center">Grand Total:</td>
                                <td class="text-right">{{number_format($totalOpeningAmount,2)}}</td>
                                <td class="text-right">{{number_format($totalCurrentAmount,2)}}</td>
                                <td class="text-right">{{number_format($totalSales ,2 ?? 0)}}</td>
                                <td class="text-right">{{number_format($grandTotalCost,2)}}</td>
                                <td class="text-center"></td>
                                <td class="text-right">{{number_format($totalOpeningDepreciationAmount,2)}}</td>
                                <td class="text-right">{{number_format($totalDepCurrentAmount,2)}} </td>
                                <td class="text-right">{{number_format($totalAssetSales,2)}}</td>
                                <td class="text-right">{{number_format($grandTotalDepreciationAmount,2)}}</td>
                                <td class="text-right">{{number_format($grandTotalFinalBalance,2)}}</td>
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
                filename: "Asset_Report.xls"
            });
        });
    });
</script>

@endsection
