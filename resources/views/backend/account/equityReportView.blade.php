@extends('layouts.account_dashboard')

@section('header_menu')

@endsection

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper  accountscontent">
        <!-- Main content -->
        <div class="content px-4 ">
          <div class="col-md-12 text-right">

                 <button class="btn btn-sm  btn-warning mt-1"  onclick="printDiv('contentbody')"  id="printbtn"  > Print  </button>

          </div>
            <div class="container-fluid" id="contentbody" style="min-width: 90% !important;">

                <div class="text-center pt-3">
                  <h3 class="text-uppercase font-weight-bold">Naba Crop Care</h3>
                  <p>Head office, Rajshahi, Bangladesh</p>
                </div>
                <div class="py-4">
                    <div class="text-center mb-3">
                        <h5 class="text-uppercase font-weight-bold">Equity Report View</h5>
                    </div>

                    <table id="example1" class="table table-bordered table-striped" style="font-size: 15px;">
                        <thead>
                            <tr class="text-center">
                                <th>SI. No</th>
                                <th>Date</th>
                                <th>Bank/Cash</th>
                                <th>Head</th>
                               <th>Name</th>
                                <th>Percentage</th>
                                <th>Amount</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $sl = 0;
                                $total = 0;
                            @endphp
                            @foreach($datas as $data)

                                    @php
                                    $sl++;
                          			if(!empty($data->bank_id)){
                          				$name = DB::table('master_banks')->where('bank_id', $data->bank_id)->value('bank_name');
                          			} elseif(!empty($data->cash_id)) {
                          				$name = DB::table('master_cashes')->where('wirehouse_id', $data->cash_id)->value('wirehouse_name');
                                } else {
                                  $name = 'Opening Balance';
                                }
                                $total += $data->amount;
                                	@endphp
                                <tr>
                                    <td class="align-middle">{{ $sl }}</td>
                                    <td>{{$data->date}}</td>
                                    <td>{{$name}}</td>
                                    <td>{{$data->head}}</td>
                                    <td>{{$data->name}}</td>
                                    <td>{{$data->percentage}} %</td>
                                    <td align="right">{{number_format($data->amount,2)}}</td>


                                </tr>
                            @endforeach
                            <tr>
                              <td>Total Amount: </td>
                              <td colspan="100%" align="right">{{number_format($total,2)}}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    @push('end_js')

        <script type="text/javascript">
            $(function() {
                $('[data-toggle="tooltip"]').tooltip()
            });



                function printDiv(divName) {
                         var printContents = document.getElementById(divName).innerHTML;
                         var originalContents = document.body.innerHTML;

                         document.body.innerHTML = printContents;

                         window.print();

                         document.body.innerHTML = originalContents;
                    }
        </script>

    @endpush
@endsection
