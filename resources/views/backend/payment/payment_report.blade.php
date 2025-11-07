@extends('layouts.account_dashboard')


@section('header_menu')
<li class="nav-item d-none d-sm-inline-block">
@endsection

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">


        <!-- Main content -->
        <div class="content px-4 ">
           <div class="container" style="background:#ffffff; padding:0px 40px;min-height:85vh">

              <div class="row pt-3">
                      <div class="col-md-6 text-left">
                      	    <a href="{{ URL('/bank/payment/create') }}" class=" btn btn-success mr-2">Create Bank Payment</a>

                       </div>
                    <div class="col-md-6 text-right">

                      </div>
                  </div>
                <div class="text-center pt-3">
                    <h3 class="text-uppercase font-weight-bold">Naba Crop Care</h3>
                    <p>Head office, Rajshahi, Bangladesh</p>
                </div>
                <div>
                    <div class="text-center">
                        <h5 class="text-uppercase font-weight-bold">Payment Report</h5>
                        <hr>
                    </div>
                    <table id="datatablecustom" class="table table-bordered table-striped" style="font-size: 15px;">
                        <thead>
                            <tr class="text-center">
                                <th>Sl</th>
                                <th>Bank\Cash Name</th>
                                <th>Supplyer Name</th>
                                <th>Payment Date</th>
                                <th>Type</th>
                                <th>Invoice</th>
                                <th>Amount</th>

                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $sl = 0;
                                $total = 0;
                             @endphp
                            @foreach ($data as $item)

                                @php
                                $sl++;
                                $total += $item->amount;
                                @endphp
                                    <tr>
                                        <td class="align-middle">{{ $sl }}</td>
                                        <td class="align-middle">{{$item->bank_name}} {{$item->wirehouse_name}}</td>
                                        <td class="align-middle">{{$item->supplier_name}}</td>
                                        <td class="align-middle">{{$item->payment_date}}</td>
                                        <td class="align-middle">{{$item->type}}</td>
                                        <td class="text-center align-middle">{{$item->invoice}}</td>
                                        <td class="text-right align-middle"> {{number_format($item->amount, 2)}}/-</td>

                                   </tr>

                            @endforeach




                        </tbody>

                        <tfoot>
                            <tr style="background-color:rgba(238, 107, 107, 0.473); font-weight: bold;">
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td>Total</td>
                                <td align="right">{{number_format($total, 2)}}/-</td>
                            </tr>
                        </tfoot>
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
@endsection
