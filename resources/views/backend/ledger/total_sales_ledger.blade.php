@extends('layouts.sales_dashboard')

@push('addcss')
    <style>
        .text_sale {
            color: #1fb715;
        }
        .text_credit{
            color: #5a6eff;
          {{-- color: #f90b0b; --}}
        }
        .tableFixHead          { overflow: auto; height: 600px; }
    	.tableFixHead thead th { position: sticky; top: 0; z-index: 1; }




      .main-sidebar{
      	background: #161616 !important;
         color: #52CD9F !important;
      }
      .main-header{
      	background: #000000 !important;
         color: #52CD9F !important;
      }
      table tr:hover {
      background: #202020 !important;
      }
      .table, .table td, .table th {
          border-color: rgb(64 64 64);
      }

      .table, .table td{
          padding:7px;
      }
      .nav-sidebar .nav-item>.nav-link {
          color: #52CD9F !important;
      }
      .table-header-fixt-top{
      background: #202020 !important;
      }
      .table.table-bordered{
     background: #202020 !important;
      }


    </style>
@endpush


@section('print_menu')

			<li class="nav-item">
                    <button class="btn btn-sm  btn-success mt-1" id="btnExport"  >
                       Export
                    </button>
                </li>
			<li class="nav-item ml-1">
                    <button class="btn btn-sm  btn-warning mt-1"  onclick="printDiv('reporttable')"  id="printbtn"  >
                       Print
                    </button>
                </li>

@endsection

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper" id="contentbody" {{--style="background:#fff !important;color:#000"--}}>


        <!-- Main content -->
        <div class="content px-4 ">
            <div class="container-fluid" style="background:#ffffff; padding:0px 40px;min-height:85vh">
                <div class="py-5" >


                  <input type="hidden" name="fdate" id="fdate" value="{{$fdate}}">
                  <input type="hidden" name="tdate" id="tdate" value="{{$tdate}}">

                    <div class="table-responsive tableFixHead pb-5 pr-2" id="reporttable">

                      	<div class="row pt-2">
                            <div class="col-md-3 text-left">
                              <h5 class="text-uppercase font-weight-bold">Sales Ledger</h5>
                              <p>From {{date('d M, Y',strtotime($fdate))}} to {{date('d M, Y',strtotime($tdate))}}</p>

                            </div>
                            <div class="col-md-6 pt-3 text-center">
                                <h3 class="text-uppercase font-weight-bold">Naba Crop Care</h3>
                                <p>Head office, Rajshahi, Bangladesh</p>
                            </div>

                        </div>


                    <table   class="table table-bordered p-2" style="font-size: 16px; font-weight: 600; border:2px solid; background: #171717; color: #52CD9F !important;">
                        <thead>
                            <tr class="text-center table-header-fixt-top" style="background-color: #171717 !important;">
                                <th>Date</th>
                                <th>Store/Transaction</th>
                                <th>Inv No</th>
                                <th>Product</th>
                              <th>Qty (PCS)</th>
                                 <th>Qty (KG)</th>
                              <th>Qty (Ton)</th>

                            {{--  @if($salesunit->sales_kg != null)

                                <th>Qty (KG)</th>
                              <th>Qty (Ton)</th>
                                @endif
                              	@if($salesunit->discount_amount != null)
                                <th>Dis.</th>
                             @endif
                              @if($salesunit->free != null)
                              <th>Free </th>
                              @endif  --}}
                                <th>Price </th>

                                <th>Value</th>

                                <th>Debit</th>
                                <th>Credit</th>
                                <th>Closing Balance</th>
                            </tr>
                        </thead>

                         <tbody id="tbodyShow" style="font-size: 14px;">

                   		 </tbody>
                      <tfoot id="tfootShow" >

                   		 </tfoot>
                    </table>
                </div>
                </div>
            </div>
        </div>
    </div>



@endsection


@push('end_js')

    <script>
         function loadDataAuto() {
                var groupBy = function(xs, key) {
                    return xs.reduce(function(rv, x) {
                        (rv[x[key]] = rv[x[key]] || []).push(x);
                        return rv;
                    }, {});
                };

           var vendorid = [];
           @if($vid)
             @foreach($vid as $data)
             vendorid.push("{{$data}}");
             @endforeach
           @endif

            var zoneID = [];
             @if($zid)
            @foreach($zid as $data)
           zoneID.push("{{$data}}");
           @endforeach
            @endif

           var areaID = [];
           @if($aid)
            @foreach($aid as $data)
           areaID.push("{{$data}}");
           @endforeach
           @endif

           var wirehouseId = [];
           @if($wid)
            @foreach($wid as $data)
           wirehouseId.push("{{$data}}");
           @endforeach
           @endif

            var product_id = [];
           @if($pid)
           @foreach($pid as $data)
           product_id.push("{{$data}}");
           @endforeach
           @endif



                var fdate = $('#fdate').val();
                var tdate = $('#tdate').val();
//warehouse_id:wirehouseId,product_id:product_id,
                //console.log(fdate);
				var gt_cb = 0;
                $.ajax({
                      type: 'POST',

                    url: '{{url("get/sales/total/ledger/data")}}',

                   /* send the csrf-token and the input to the controller */
                    data: {_token:"{{ csrf_token() }}", fdate:fdate,tdate:tdate,vendor_id:vendorid,dlr_zone_id:zoneID,dlr_area_id:areaID},

                    success: function(data) {
                    //    console.log(data);
                      var vendordata = data['data'];

                   //   console.log(vendordata);



                      $("#tbodyShow").html("");

                      cccc = 1;

                         $.each(vendordata, function(index,item) {
                         //console.log();

                            		var t_qty = 0;
                                    var t_qtykg = 0;
                                    var t_qtyton = 0;
                                    var t_value = 0;
                                    var t_dis = 0;
                                    var t_free = 0;
                                    var t_debit = 0;
                                    var t_credit = 0;
                                    var t_cb = 0;



                         var openingbalance = Number(item.dlr_base)+Number(item.debit_a)-Number(item.credit_a);

                           var closingbalance = parseFloat(openingbalance.toFixed(2));
                           gt_cb += parseFloat(openingbalance.toFixed(2));

                         // console.log(item.dlr_base);

                        // openingbalance =	openingbalance.toFixed(2);
                           var row = '<tr style="font-size: 16px; font-weight:bold; color:">';
                         row +='<td colspan="6">'+item.d_s_name+'- Zone - '+item.zone_title+'</td>';
                         row +='<td ></td>';
                         row +='<td ></td>';
                         row +='<td colspan="3">Opening Balance</td>';
                         row +='<td class="text-right">'+closingbalance+'</td>';
                          row +='</tr>';



                         //console.log(vendordata[i]['dealer_id']);
                         cccc++;
                         $.ajax({
                          	type: 'POST',

                           	url: '{{url("get/sales/total/ledger/vendor/data")}}',
                          	data: {_token:"{{ csrf_token() }}", fdate:fdate,tdate:tdate,vendor_id:item.dealer_id,warehouse_id:wirehouseId,product_id:product_id},
							success: function(data) {
                              var datadetails = data['data'];

                             //$("#tbodyShow").append(row);
                              //row = '';

							   var count = 1;
                             var drow = '';
                              for (var j = 0; j < datadetails.length; j++) {

                                 		t_qty += Number(datadetails[j]['qty_pcs']);
                                        t_qtykg += Number(datadetails[j]['qty_kg']);
                                        t_qtyton += Number(datadetails[j]['qty_kg'] / 1000);
                                        t_value += Number(datadetails[j]['total_price']);
                                        t_dis += Number(datadetails[j]['discount_amount']);
                                        t_free += Number(datadetails[j]['free']);
                                        t_debit += Number(datadetails[j]['debit']);
                                        t_credit += Number(datadetails[j]['credit']);
                                        closingbalance += Number(datadetails[j]['debit'])-Number(datadetails[j]['credit']);


                                //		gt_qty += Number(datadetails[j]['qty_pcs']);
                                     //   gt_qtykg += Number(datadetails[j]['qty_kg']);
                                    //    gt_qtyton += Number(datadetails[j]['qty_kg'] / 1000);
                                    //    gt_value += Number(datadetails[j]['total_price']);
                                    //    gt_dis += Number(datadetails[j]['discount_amount']);
                                    //    gt_free += Number(datadetails[j]['free']);
                                    //    gt_debit += Number(datadetails[j]['debit']);
                                     //   gt_credit += Number(datadetails[j]['credit']);
                                     //   gt_cb += Number(datadetails[j]['debit'])-Number(datadetails[j]['credit']);






                                	var clss = '';
                                		if (datadetails[j]['priority'] == 1) {
                                            clss = 'highlighted text_sale font-weight-bold';

                                        }else if (datadetails[j]['priority'] == 5) {
                                            clss = 'highlighted text-primary font-weight-bold';
                                        } else if (datadetails[j]['priority'] == 2) {
                                            clss = 'highlighted text_return font-weight-bold';
                                        } else if (datadetails[j]['credit'] != null || datadetails[j]['journal_id'] != null) {
                                            clss = 'highlighted text_credit font-weight-bold';
                                        } else {
                                            clss = '';
                                        }


                                var   nullvalue = '';
                                drow += '<tr>';
                               drow +='<td class="'+ clss +'">'+datadetails[j]['ledger_date']+'</td>';
                                if(datadetails[j]['narration'] != null){ 
                                drow +='<td class="'+ clss +'">'+datadetails[j]['warehouse_bank_name']+'</br>'+datadetails[j]['narration']+'</td>';
                                } else {
                                drow +='<td class="'+ clss +'">'+datadetails[j]['warehouse_bank_name']+'</td>';
                                }
                               
                               drow +='<td class="'+ clss +'">'+datadetails[j]['invoice']+'</td>';

                               if(datadetails[j]['product_name'] != null){
                              	drow +='<td class="text-right '+ clss +'">'+datadetails[j]['product_name']+'</td>';
                               }else{
                                drow +='<td class="text-right '+ clss +'"></td>';
                               }

                               if(datadetails[j]['qty_pcs'] != null){
                              	drow +='<td class="text-right '+ clss +'">'+datadetails[j]['qty_pcs']+'</td>';
                               }else{
                                drow +='<td class="text-right '+ clss +'"></td>';
                               }

                               if(datadetails[j]['qty_kg'] != null){
                              	drow +='<td class="text-right '+ clss +'">'+datadetails[j]['qty_kg']+'</td>';
                               }else{
                                drow +='<td class="text-right '+ clss +'"></td>';
                               }

                                if(datadetails[j]['qty_kg'] != null){
                                  var thisval = (datadetails[j]['qty_kg']/1000);
                              	drow +='<td class="text-right '+ clss +'">'+(thisval.toFixed(2))+'</td>';
                               }else{
                                drow +='<td class="text-right '+ clss +'"></td>';
                               }

                               if(datadetails[j]['unit_price'] != null){
                              	drow +='<td class="text-right '+ clss +'">'+datadetails[j]['unit_price']+'</td>';
                               }else{
                                drow +='<td class="text-right '+ clss +'"></td>';
                               }

                               if(datadetails[j]['total_price'] != null){
                              	drow +='<td class="text-right '+ clss +'">'+datadetails[j]['total_price']+'</td>';
                               }else{
                                drow +='<td class="text-right '+ clss +'"></td>';
                               }

                                 if(datadetails[j]['debit'] != null){
                              	drow +='<td class="text-right '+ clss +'">'+datadetails[j]['debit']+'</td>';
                               }else{
                                drow +='<td class="text-right '+ clss +'"></td>';
                               }

                                if(datadetails[j]['credit'] != null){
                              	drow +='<td class="text-right '+ clss +'">'+datadetails[j]['credit']+'</td>';
                               }else{
                                drow +='<td class="text-right '+ clss +'"></td>';
                               }



                                if(datadetails[j]['priority'] != 0 || datadetails[j]['credit'] != null || datadetails[j]['journal_id']  != null){
                              	drow +='<td class="text-right '+ clss +'">'+closingbalance+'</td>';
                               }else{
                                drow +='<td class="text-right '+ clss +'">-</td>';
                               }


                               drow +='</tr>'




                               }
                              //End second forloop

                              //console.log(drow);
                             $("#tbodyShow").append(row);
                           // row =''
                                 $("#tbodyShow").append(drow);

                               var sbrow = '<tr style="font-size: 16px;color:#17a50d; font-weight:bold;border-bottom:2px solid;">';
                                 sbrow +=' <td colspan="4">Subtotal</td>';
                                 sbrow +='<td class="text-right" >'+t_qty+'</td>';
                                 sbrow +='<td class="text-right" >'+t_qtykg+'</td>';
                                 sbrow +='<td class="text-right" >'+(t_qtyton.toFixed(2))+'</td>';
                                 sbrow +='<td class="text-right" ></td>';
                                 sbrow +='<td class="text-right" >'+(t_value.toFixed(2))+'</td>';
                                 sbrow +='<td class="text-right" >'+t_debit+'</td>';
                                 sbrow +='<td class="text-right" >'+t_credit+'</td>';
                                 sbrow +='<td class="text-right" >'+closingbalance+'</td>';

                                  sbrow +='</tr>';

                              $("#tbodyShow").append(sbrow);






                           	}
                           //End second ajax success function


                          	});
                           //End second ajax
                         // console.log(row);





                           });
                      //End foreach
                      			var gt_qty = {{$salesunit->qty_pcs ? $salesunit->qty_pcs : 0}};
                                var gt_qtykg = {{$salesunit->sales_kg ? $salesunit->sales_kg : 0}};
                                var gt_qtyton = {{$salesunit->sales_kg ? $salesunit->sales_kg/1000 : 0}};
                                var gt_value = {{$salesunit->total_price ? $salesunit->total_price : 0}};
                                var gt_dis = {{$salesunit->discount_amount ? $salesunit->discount_amount : 0}};
                                var gt_free = {{$salesunit->free ? $salesunit->free : 0}};
                                var gt_debit = {{$salesunit->debit ? $salesunit->debit : 0}};
                                var gt_credit = {{$salesunit->credit ? $salesunit->credit : 0}};
                                gt_cb += {{($salesunit->debit ? $salesunit->debit : 0)-($salesunit->credit ? $salesunit->credit : 0)}};
                      console.log(gt_qty);

                      var gtrow = '<tr><td colspan="100%" style="border-left: white;border-right: white;padding: 30px;"></td></tr>';
                                 gtrow +=' <tr style="font-size: 16px; font-weight:bold; border-top:2px solid;">';
                                 gtrow +=' <td colspan="4">GrandTotal</td>';
                                 gtrow +='<td class="text-right" >'+gt_qty+'</td>';
                                 gtrow +='<td class="text-right" >'+gt_qtykg+'</td>';
                                 gtrow +='<td class="text-right" >'+gt_qtyton+'</td>';
                                 gtrow +='<td class="text-right" ></td>';
                                 gtrow +='<td class="text-right" >'+gt_value+'</td>';
                                 gtrow +='<td class="text-right" >'+gt_debit+'</td>';
                                 gtrow +='<td class="text-right" >'+gt_credit+'</td>';
                                 gtrow +='<td class="text-right" >'+(gt_cb.toFixed(2))+'</td>';

                                  gtrow +='</tr>';
                       $("#tfootShow").html(gtrow);





                         }
                  //End first ajax success




                });
           //End first ajax
            }


            $(document).ready (function(){

              loadDataAuto();

        });
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
                filename: "SalesLedger.xls"
            });
        });
    });
</script>

@endpush
