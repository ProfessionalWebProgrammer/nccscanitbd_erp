@extends('layouts.settings_dashboard')


@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper salescontent">
        <!-- Main content -->
        <div class="content px-4 ">
            <div class="container">
                <div class="text-center pt-3">
                    <h3 class="text-uppercase font-weight-bold">Naba Crop Care</h3>
		                  <p>Head office, Rajshahi, Bangladesh</p>
                    <h5>Trip Expanse View List</h5>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="py-4 table-responsive">
                            <div class="row">
                                <div class="col-md-6">
                                    <h5>Date : {{ date('l, jS \of F, Y', strtotime($trips->date)) }}</h5>
                                    <h5>Invoice: {{ $trips->invoice }}</h5>
                                    <h5>Driver Name: {{ $trips->driver_name }}</h5>
                                    <h5>Vehicle: {{ $trips->vehicle_number }}</h5>
                                    <h5>Income Amount: {{ $trips->trip_value }}</h5>
                                    <h5>Note: {{ $trips->note }}</h5>
                                </div>
                                <div class="col-md-12 text-right">
                                    <table class="table table-bordered table-striped table-fixed" style="font-size: 15px;">
                                        <thead>
                                            <tr class="text-center table-header-fixt-top">
                                                <th>Sl</th>
                                                <th>From Place</th>
                                                <th>To Placet</th>
                                                <th>Income Amount</th>
                                            </tr>
                                        </thead>
                                        <tbody style="font-size: 18px;">
                                            @php
                                                $totalincome = 0;
                                            @endphp
                                            @foreach ($triphistory as $history)
                                                @php
                                                    $totalincome += $history->income_amount;
                                                @endphp
                                                <tr>
                                                    <td class="text-center">{{ $loop->iteration }}</td>
                                                    <td class="text-left">{{ $history->trip_from }} </td>
                                                    <td class="text-left">{{ $history->trip_to }} </td>
                                                    <td class="text-right">{{ number_format($history->income_amount) }}
                                                    </td>
                                                </tr>
                                            @endforeach
                                            <tr>
                                                <td class="text-right" colspan="3">Total Income</td>
                                                <td class="text-right">{{ number_format($totalincome) }}</td>
                                            </tr>
                                        </tbody>
                                    </table>

                                </div>
                                <div class="col-md-12">
                                    <table class="table table-bordered table-striped table-fixed" style="font-size: 15px;">
                                        <thead>
                                            <tr class="text-center table-header-fixt-top">
                                                <th>Sl</th>
                                                <th>Expanse Head</th>
                                                <th>Rate</th>
                                                <th>Quantity</th>
                                                <th>Expanse Amount</th>
                                            </tr>
                                        </thead>
                                        <tbody style="font-size: 18px;">
                                            @php
                                                $totalexpanse = 0;
                                            @endphp
                                            @foreach ($expanses as $date)
                                                @php
                                                    $totalexpanse += $date->expanse_amount;
                                                @endphp
                                                <tr>
                                                    <td class="text-center">{{ $loop->iteration }}</td>
                                                    <td>{{ $date->expanse_head }} </td>
                                                    <td class="text-right">@if($date->rate == null) - @else {{ $date->rate }}  @endif </td>
                                                    <td class="text-right">@if($date->qntty == null) - @else {{ $date->qntty }}  @endif </td>
                                                    <td class="text-right">{{ number_format($date->expanse_amount) }}
                                                    </td>
                                                </tr>
                                            @endforeach
                                            <tr>
                                                <td class="text-right" colspan="4">Total Expanse</td>
                                                <td class="text-right">{{ number_format($totalexpanse) }}</td>
                                            </tr>
                                            <tr>
                                                <td class="text-right" colspan="4">Trip Income Balance</td>
                                                <td class="text-right">
                                                    {{ number_format($trips->trip_value - $totalexpanse) }}
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
