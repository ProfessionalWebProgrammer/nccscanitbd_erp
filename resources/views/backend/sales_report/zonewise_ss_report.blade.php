@extends('layouts.sales_dashboard')

@push('addcss')
<style>
    .tableFixHead          { overflow: auto; height: 600px; }
    .tableFixHead thead th { position: sticky; top: 0; z-index: 1; }
</style>

@endpush


@section('print_menu')

			<li class="nav-item">
                </li>

@endsection

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">


        <!-- Main content -->
        <div class="content px-4 ">
          <div class="row pt-3">
                  	<div class="col-md-12 text-right">
                        <button class="btn btn-sm  btn-success mt-1" id="btnExport"  >
                           Export
                        </button>
                        <button class="btn btn-sm  btn-warning mt-1"  onclick="printland()"  id="printland"  >
                           PrintLands.
                        </button>
                    </div>
                </div>

            <div class="container-fluid" style="background:#ffffff; padding:0px 40px;min-height:85vh"  id="contentbody">
                 <div class="challanlogo" align="center" >


                   <div class="row pt-2">
                  	<div class="col-md-4 text-left">
                      <h5 class="text-uppercase font-weight-bold">Zone Wise Monthly Sales Statement Report</h5>
                      <h6>{{date('F-Y',strtotime($year.'-'.$month))}}</h6>

                    </div>
                  	<div class="col-md-4 pt-3 text-center">
                      	<h3 class="text-uppercase font-weight-bold">Naba Crop Care</h3>
		                  <p>Head office, Rajshahi, Bangladesh</p>
                    </div>
                </div>



                    </div>
                <div class="py-4 table-responsive tableFixHead">
                    <table id="datatablecustom" class="table table-bordered table-striped table-fixed"
                    style="font-size: 15px;width:100%">
                      <thead>
                            <tr class="text-center table-header-fixt-top">
                                <th>Zone</th>
                                <th>Area</th>
                                <th>Current Month</th>
                                <th>Previous Month</th>
                                <th>Pre Previous Month</th>
                                <th>Monthly Target</th>
                                <th>Quarterly Total</th>
                                <th>Current Month Credit</th>
                                <th>Previous Month Credit</th>
                                <th>Target Credit</th>
                                @foreach ($categorys as $key=> $item)

                                @php
                                $total[$key]  = 0;
                                $catname[$key]  = $item->category_name;
                                @endphp

                                    <th>{{ $item->category_name }}</th>
                                @endforeach
                              </tr>
                        </thead>
                        <tbody style="font-size: 18px;">
                            @php
                            $totalcl = 0;
                            $totalpml = 0;
                            $totalppml = 0;
                            $totalqs = 0;
                            $totalcc = 0;
                            $totalpmc = 0;
                            $total = 0;
                        @endphp

                            @foreach ($areadata as $item)
                                @php
                                    $qutarly = $item->current_sale + $item->pre_month_sale + $item->pre_pre_month_sale;
                                @endphp
                                <tr>
                                    {{-- <td>{{ $loop->iteration }}</td> --}}
                                    <td>{{ $item->zone }}</td>
                                    <td>{{ $item->area }}</td>
                                    <td>{{ $item->current_sale }}</td>
                                    <td>{{ $item->pre_month_sale }}</td>
                                    <td>{{ $item->pre_pre_month_sale }}</td>
                                    <td></td>
                                    <td>{{ $qutarly }}</td>
                                    <td>{{ $item->current_debit-$item->current_credit }}</td>
                                    <td>{{ $item->pre_month_debit-$item->pre_month_credit }}</td>
                                    <td>{{ $item->dlr_police_station }}</td>
                                    <td>{{$item->cat1}} <br><span style="color: #ff7c7c;">({{$catname[0]}})</span></td>
                                    <td>{{$item->cat3}} <br><span style="color: #ff7c7c;">({{$catname[1]}})</span></td>
                                    <td>{{$item->cat4}} <br><span style="color: #ff7c7c;">({{$catname[2]}})</span></td>
                                    <td>{{$item->cat5}} <br><span style="color: #ff7c7c;">({{$catname[3]}})</span></td>
                                    <td>{{$item->cat6}} <br><span style="color: #ff7c7c;">({{$catname[4]}})</span></td>

                                </tr>

                            @endforeach

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
 <script type="text/javascript">
    $(function () {
        $("#btnExport").click(function () {
            $("#datatablecustom").table2excel({
                filename: "MonthlySalesStatement.xls"
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
@endsection
