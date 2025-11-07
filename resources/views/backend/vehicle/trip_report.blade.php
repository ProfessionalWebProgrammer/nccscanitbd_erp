@extends('layouts.settings_dashboard')
@section('print_menu')

			<li class="nav-item">
                    <button class="btn btn-sm  btn-success mt-1" id="btnExport"  >
                       Export
                    </button>
                </li>
			<li class="nav-item ml-1">
                    <button class="btn btn-sm  btn-warning mt-1"  onclick="printDiv('contentbody')"  id="printbtn"  >
                       Print
                    </button>
                </li>

@endsection

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper salescontent" id="contentbody">

        <!-- Main content -->
        <div class="content px-4 ">
            <div class="container-fluid">
                <div class="text-center pt-3">
                    <h3 class="text-uppercase font-weight-bold">Naba Crop Care</h3>
		                  <p>Head office, Rajshahi, Bangladesh</p>
                    <h5>Trip  Report</h5>
                   <h6>From {{ date('d F Y', strtotime($fdate)) }}
                        To
                        {{ date('d F Y', strtotime($tdate)) }}</h6>

                    <hr>

                </div>
                <div class="py-4 table-responsive">
                    <table id="datatablecustom" class="table table-bordered table-striped table-fixed" style="font-size: 15px;">
                        <thead>
                            <tr class="text-center table-header-fixt-top">
                                <th>Date</th>
                                <th>Invoice</th>
                                <th>Driver Name</th>
                                <th>Vehicle</th>
                                <th>Note</th>
                                <th>Total Trip Amount</th>
                            </tr>
                        </thead>
                        <tbody style="font-size: 18px;">
							@php
                          		$grandtotalincome = 0;
                          		$totaltripsfare = 0;
                            @endphp
                           @foreach ($trips as $date)
                          @php
                          $subTotalNetIncome = 0;
                          $totaltripsfare += $date->trip_value;
                          @endphp
                          	  <tr style="background: khaki">
                                   {{-- <td>{{ $loop->iteration }}</td> --}}
                                    <td>{{ $date->date }} </td>
                                    <td>{{ $date->invoice }} </td>
                                    <td>{{ $date->driver_name }} </td>
                                    <td>{{ $date->vehicle_number }} </td>
                                    <td>{{ $date->note }} </td>
                                    <td class="text-right">{{ number_format($date->trip_value) }}/- </td>
                                </tr>
                            <tr class="text-center table-header-fixt-top">
                              <th>Sl</th>
                                <th colspan="2">Expanse Head</th>
                                <th>Rate</th>
                                <th>Quantity</th>
                                <th>Amount</th>
                            </tr>

                          		@php
                          			$group_id = 1;
                          			$expanses = DB::table('trips_expances')->where('invoice', $date->invoice)->where('expanse_group_id',$group_id)->get();
                          			$totalTexpanse = 0;
                          		@endphp
                          		<tr>
                                  <td colspan="6">Trip Expanse</td>
                                </tr>
                               @foreach ($expanses as $expanse)
                          		@php
                          			$totalTexpanse += $expanse->expanse_amount;
                          		@endphp

                                  <tr>
                                    	<td>{{ $loop->iteration }}</td>
                                        <td colspan="2">{{ $expanse->expanse_head }} </td>
                                        <td  class="text-center">@if($expanse->rate !== null) {{ $expanse->rate}}<small>(Rate)</small> @else - @endif <small></small></td>
                                        <td  class="text-center">@if($expanse->qntty !== null) {{ $expanse->qntty }}<small>(Quantity)</small> @else - @endif </td>
                                        <td  class="text-right">{{ number_format($expanse->expanse_amount) }}/- </td>
                                    </tr>

                                @endforeach
                          			<tr>
                                        <td colspan="5" class="text-right">Total Trip Expanse</td>
                                        <td class="text-right">{{ number_format($totalTexpanse) }}/- </td>
                                    </tr>
                              @php
                          			$group_id = 2;
                          			$expanses = DB::table('trips_expances')->where('invoice', $date->invoice)->where('expanse_group_id',$group_id)->get();
                          			$totalMexpanse = 0;
                          		@endphp
                          		<tr>
                                  <td colspan="6">Maintainance Expanse</td>
                                </tr>
                               @foreach ($expanses as $expanse)
                          		@php
                          			$totalMexpanse += number_format($expanse->expanse_amount);
                          		@endphp

                                  <tr>
                                    	<td>{{ $loop->iteration }}</td>
                                        <td colspan="2">{{ $expanse->expanse_head }} </td>
                                        <td  class="text-center">@if($expanse->rate !== null) {{ $expanse->rate}}<small>(Rate)</small> @else - @endif <small></small></td>
                                        <td  class="text-center">@if($expanse->qntty !== null) {{ $expanse->qntty }}<small>(Quantity)</small> @else - @endif </td>
                                        <td  class="text-right">{{ number_format($expanse->expanse_amount) }}/- </td>
                                    </tr>

                                @endforeach
                          			<tr>
                                        <td colspan="5" class="text-right">Total Maintainance Expanse</td>
                                        <td class="text-right">{{ number_format($totalMexpanse) }}/- </td>
                                    </tr>
                          		@php
                          			$group_id = 4;
                          			$expanses = DB::table('trips_expances')->where('invoice', $date->invoice)->where('expanse_group_id',$group_id)->get();
                          			$totalOexpanse = 0;
                          		@endphp
                          		<tr>
                                  <td colspan="6">Others Expanse</td>
                                </tr>
                               @foreach ($expanses as $expanse)
                          		@php
                          			$totalOexpanse += $expanse->expanse_amount;
                          		@endphp

                                  <tr>
                                    	<td>{{ $loop->iteration }}</td>
                                        <td colspan="2">{{ $expanse->expanse_head }} </td>
                                        <td  class="text-center">@if($expanse->rate !== null) {{ $expanse->rate}}<small>(Rate)</small> @else - @endif <small></small></td>
                                        <td  class="text-center">@if($expanse->qntty !== null) {{ $expanse->qntty }}<small>(Quantity)</small> @else - @endif </td>
                                        <td  class="text-right">{{ number_format($expanse->expanse_amount) }}/- </td>
                                    </tr>

                                @endforeach
                          			<tr>
                                        <td colspan="5" class="text-right">Total Others Expanse</td>
                                        <td class="text-right">{{ number_format($totalOexpanse) }}/- </td>
                                    </tr>
                          		@php
                          			$group_id = 3;
                          			$expanses = DB::table('trips_expances')->where('invoice', $date->invoice)->where('expanse_group_id',$group_id)->get();
                          			$totalexpanse = 0;
                                    $totaldriverincome = 0;
                          		@endphp
                          		<tr>
                                  <td colspan="6">Driver Expanse</td>
                                </tr>
                               @foreach ($expanses as $expanse)
                          		@php
                          			$totalexpanse += $expanse->expanse_amount;
                          		@endphp

                                  <tr>
                                    	<td>{{ $loop->iteration }}</td>
                                        <td colspan="2">{{ $expanse->expanse_head }} </td>
                                        <td  class="text-center">@if($expanse->rate !== null) {{ $expanse->rate}}<small>(Rate)</small> @else - @endif <small></small></td>
                                        <td  class="text-center">@if($expanse->qntty !== null) {{ $expanse->qntty }}<small>(Quantity)</small> @else - @endif </td>
                                        <td  class="text-right">{{ number_format($expanse->expanse_amount) }}/- </td>
                                    </tr>

                                @endforeach
                          			<tr>
                                        <td colspan="5" class="text-right">Total Expanse</td>
                                        <td class="text-right">{{ number_format($totalexpanse) }}/- </td>
                                    </tr>
                                     @php
                                        $result = $date->trip_value - $totalexpanse;
                          				$driverIncome = ($result * number_format($date->commission))/100;
                                        $totaldriverincome += $driverIncome;
                                    @endphp
                          			<tr style="background: antiquewhite;">
                                        <td colspan="5" class="text-right">Driver Trip Commission {{ $date->commission }}% ( {{ $date->driver_name }} ):</td>
                                        <td class="text-right">{{ number_format($driverIncome) }}/- </td>
                                    </tr>
                          			<tr style="background:#4083a3;">
                                      @php
                                      $grandtotalincome += $totaltripsfare - ($totalTexpanse + $totalOexpanse + $totalMexpanse + $totalTexpanse + $totaldriverincome);
                                      @endphp
                                      <td colspan="5" class="text-right">Sub Total Net Income:</td>
                                      <td class="text-right">{{$grandtotalincome}}/-</td>
                                    </tr>

                            @endforeach
                           </tbody>
                      	   <tfoot>

                             <tr style="background: chocolate;">
                                        <th colspan="5" class="text-right">Grand Total Net Income:</th>
                                        <th class="text-right">{{ $grandtotalincome }}/- </th>
                                    </tr>
                           </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>

@endsection
