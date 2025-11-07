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
                      <h5 class="text-uppercase font-weight-bold">Daily Sales Report</h5>
                      <p>From {{date('d M, Y',strtotime($fdate))}} to {{date('d M, Y',strtotime($tdate))}}</p>

                    </div>
                  	<div class="col-md-4 pt-3 text-center">
                      	<h3 class="text-uppercase font-weight-bold">Naba Crop Care</h3>
                  			<p>Head office, Rajshahi, Bangladesh</p>
                    </div>
                </div>
                <div class="text-center pt-3">

                    <hr>
                    <input type="hidden" name="datepick" value="{{$date}}">
                    <input type="hidden" id="fdate" name="fdate" value="{{$fdate}}">
                    <input type="hidden" id="tdate" name="tdate" value="{{$tdate}}">
                   <input type="hidden" id="serach-vendor" name="serach-vendor" value="{{$vid}}">
                   <input type="hidden" id="area-search" name="area-search" value="{{$aid}}">
                  <input type="hidden" id="zone-search" name="zone-search" value="{{$zid}}">
                  
                </div>
            </div>
            <div class="py-4 table-responsive">
                <table id="reporttable" class="table table-bordered table-striped table-fixed" style="font-size: 15px;">
                    <thead>
                        <tr class="table-header-fixt-top">
                            <th>SI. No</th>
                            <th>Date</th>
                            <th>Vendor</th>
                            <th>Area</th>
                            <th>Warehouse</th>
                            <th>Invoice</th>
                            <th>Product Name</th>
                            <th>Qty (Pcs)</th>
                            <th>Qty (KG)</th>
                            <th>Qty (Ton)</th>
                            <th>Unit Price</th>
                            <th>Total Value</th>

                        </tr>
                    </thead>
                    <tbody id="tbodyShow">

                    </tbody>
                    <tfoot id="tfootShow">

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

<script>
    function loadDataAuto() {
        var groupBy = function(xs, key) {
            return xs.reduce(function(rv, x) {
                (rv[x[key]] = rv[x[key]] || []).push(x);
                return rv;
            }, {});
        };

        var zoneID = $('#zone-search').val();
        var areaID = $('#area-search').val();
        var productID = $('#product_item').val();
        var vendorID = $('#serach-vendor').val();
        var wirehouseId = $('#warehouse_id').val();
        var fdate = $('#fdate').val();
        var tdate = $('#tdate').val();
		//alert(areaID);
        //console.log(fdate);

        $.ajax({
            method: 'GET',
            url: '{{url("/daily/sales/report/ajaxlist")}}?fdate={{$fdate}}&tdate={{$tdate}}&vid={{$vid}}&aid={{$aid}}&zid={{$zid}}',

            success: function(data) {
               // console.log(data);
                var dataList = data['data'];
                dealer_list = groupBy(dataList, 'dealer_name');
                var zone_list = '';
                var area_list = '';
                var area_list = '';
                var invoice_list = '';
                var fnamehold = '';
                var namehold = '';
                var zonehold = '';
                var areahold = '';
                var invoicehold = '';
                var fname_list = '';
                var tqty = 0;
                var tqty_kg = 0;
                var tqty_ton = 0;
                var tcost = 0;
                var count = 1;
                $("#tbodyShow").html("");
                $("#tfootShow").html("");
                for (var i = 0; i < dataList.length; i++) {

                    if (dataList[i]['dealer_name'] != null) {



                        tqty += parseFloat(dataList[i]['qty']);
                        tqty_kg += parseFloat(dataList[i]['qty_kg'] ? dataList[i]['qty_kg'] : 0);
                        tqty_ton += parseFloat(dataList[i]['qty_ton']);
                        tcost += parseFloat(dataList[i]['total_price']);

                        var row = '<tr id="tr' + (i + 1) + '">';
                        row += '<td>' + count + '</td>';
                        row += '<td nowrap="nowrap" style="width: 2%; color:#000">' +
                            dataList[i]['date'] + '</td>';
                        // row += '<td nowrap="nowrap" style="width: 2%;">' + dataList[i]['dealer_name'] + '</td>';
                        // row += '<td nowrap="nowrap">' + dataList[i]['zone'] + '</td>';
                        // row += '<td nowrap="nowrap">' + dataList[i]['area'] + '</td>';
                        // row += '<td nowrap="nowrap">' + dataList[i]['factory_name'] + '</td>';
                        if (namehold != dataList[i]['dealer_name']) {
                            row += '<td rowspan=' + dealer_list[dataList[i]['dealer_name']]
                                .length + '>' + dataList[i]['dealer_name'] + '</td>';
                            namehold = dataList[i]['dealer_name'];
                            // zonehold = '';
                            // zone_list = groupBy(dealer_list[dataList[i]['dealer_name']], 'zone');
                            areahold = '';
                            area_list = groupBy(dealer_list[dataList[i]['dealer_name']],
                                'area');
                            fnamehold = '';
                            fname_list = groupBy(dealer_list[dataList[i]['dealer_name']],
                                'factory_name');
                            invoicehold = '';
                            invoice_list = groupBy(dealer_list[dataList[i]['dealer_name']],
                                'invoice_no');
                            // console.log(dataList[i]);
                            //  console.log(invoice_list);
                            // console.log("====================");
                        }


                        // if(zonehold != dataList[i]['zone']){
                        //   row += '<td rowspan=' + zone_list[dataList[i]['zone']].length + '>' + dataList[i]['zone'] + '</td>';
                        //   zonehold = dataList[i]['zone'];
                        // }

                        if (areahold != dataList[i]['area']) {
                            row += '<td rowspan=' + area_list[dataList[i]['area']].length +
                                '>' + dataList[i]['area'] + '</td>';
                            areahold = dataList[i]['area'];
                        }

                        if (fnamehold != dataList[i]['factory_name']) {
                            row += '<td rowspan=' + fname_list[dataList[i]['factory_name']]
                                .length + '>' + dataList[i]['factory_name'] + '</td>';
                            fnamehold = dataList[i]['factory_name'];
                        }
                        if (invoicehold != dataList[i]['invoice_no']) {
                            row += '<td  style="#000;font-weight: bold;" rowspan=' + invoice_list[dataList[i][
                                'invoice_no'
                            ]].length + '>' + dataList[i]['invoice_no'] + '</td>';
                            invoicehold = dataList[i]['invoice_no'];
                        }

                        // row += '<td>' + dataList[i]['zone'] + '</td>';
                        // row += '<td>' + dataList[i]['area'] + '</td>';
                        //row += '<td>' + dataList[i]['invoice_no'] + '</td>';
                        row += '<td  style="color:#000;">' + dataList[i]['product_name'] +
                            '</td>';
                        row += '<td style="color:#000">' + dataList[i]['qty'] + '</td>';
                        row += '<td style="color:#000">' + dataList[i]['qty_kg'] + '</td>';
                        row += '<td style="color:#000">' + dataList[i]['qty_ton'] + '</td>';
                        row += '<td style="color:#000">' + dataList[i]['unit_price'] + '</td>';
                        row += '<td style="color:#000">' + dataList[i]['total_price'] +
                            '</td>';
                        row += '</tr>';
                        // console.log(row);
                        $("#tbodyShow").append(row);
                        count++;
                    }



                    $("#datatable").attr('hidden', false);
                    // $("#loading").attr('hidden', true);
                }


                var row1 = '<tr id="tr' + (i + 1) + '">';
                row1 += '<td class="text-right" colspan="7">' + 'Total = ' + '</td>';
                row1 += '<td>' + tqty.toFixed(2) + '</td>';
                row1 += '<td>' + tqty_kg.toFixed(2) + '</td>';
                row1 += '<td>' + tqty_ton.toFixed(0) + '</td>';
                row1 += '<td>' + '' + '</td>';
                row1 += '<td>' + tcost.toFixed(2) + '</td>';
                row1 += '</tr>';
                $("#tfootShow").append(row1);


                //   $("#datatable").dataTable( {
                //   dom: 'Blfrtip',
                //   buttons: [
                //       'excel', 'pdf'
                //   ],
                //   order: [],

                // });
            }

        });
    }


    $(document).ready(function() {
        $("#success-alert").fadeTo(7000, 7000).slideUp(1000);
        // console.log('find');
        // var fdate= $date.val();
        // console.log(fdate);
        // $("#loading").attr('hidden', false);
        $("#datatable").attr('hidden', true);
        loadDataAuto();
        $("#datatable").DataTable({
            responsive: true
        });
    });

    function search() {
        // $("#loading").attr('hidden', false);
        $("#datatable").attr('hidden', true);
        $("#tbodyShow").html("");
        $("#tfootShow").html("");
        loadDataAuto();
        // $("#datatable").removeAttr('hidden');
        // $("#loading").attr('hidden', true);
    }
</script>




{{-- <script type="text/javascript">
    $(document).ready(function() {
        $('#datatable').DataTable({

                // processing: true,
                "serverSide": true,

            ajax: '{{ route('daily.sales.report.ajaxlist') }}?fdate={{$fdate}}&tdate={{$tdate}}',
columns: [
{ data: 'DT_RowIndex', name: 'DT_RowIndex' },
{ data: 'date', name: 'date' },
{ data: 'dealer_name', name: 'dealer_name' },
{ data: 'area', name: 'area' },
{ data: 'factory_name',name:'factory_name' },
{ data: 'invoice_no',name:'invoice_no' },
{ data: 'product_name',name:'product_name' },
{ data: 'qty',name:'qty' },
{ data: 'qty_kg',name:'qty_kg' },
{ data: 'qty_ton',name:'qty_ton' },
{ data: 'unit_price',name:'unit_price' },
{ data: 'total_price',name:'total_price' }
],
"footerCallback": function( tfoot, data, start, end, display ) {
var total = 0;
var t_unit = 0;
var t_qty_ton = 0;
var t_qty_kg = 0;
var t_qty= 0;
data.forEach(function(entry) {
total += parseFloat(entry.total_price);
t_unit += parseFloat(entry.unit_price);
t_qty_ton += parseFloat(entry.qty_ton);
t_qty_kg += parseFloat(entry.qty_kg);
t_qty += parseFloat(entry.qty);
});
$(tfoot).find('th').eq(5).html( total.toFixed(2) );
$(tfoot).find('th').eq(4).html( t_unit.toFixed(2) );
$(tfoot).find('th').eq(3).html( t_qty_ton.toFixed(2) );
$(tfoot).find('th').eq(2).html( t_qty_kg.toFixed(2) );
$(tfoot).find('th').eq(1).html( t_qty.toFixed(2) );

},
"buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
}).buttons().container().appendTo('#example3_wrapper .col-md-6:eq(0)');
});



</script> --}}




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
                filename: "DailySalesReport.xls"
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
