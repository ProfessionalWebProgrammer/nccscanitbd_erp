@extends('layouts.hrPayroll_dashboard')

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Main content -->
        <div class="content px-4 ">
            <div class="container-fluid">
                <div class=" row pt-3">
                  <div class="col-md-12 text-center">
                    <h3 class="text-uppercase font-weight-bold">Naba Crop Care</h3>
                    <p>Head office, Rajshahi, Bangladesh</p>
                  </div>

                </div>
                <div class="py-4">
                    <div class="text-center ">
                        <h5 class="text-uppercase font-weight-bold ">Employee Production Report List</h5>
                        <p class="pb-3">Date: {{date('d-m-Y',strtotime($fdate))}} to {{date('d-m-Y',strtotime($tdate))}}</p>
                        <hr>
                    </div>
                    <table id="example1" class="table table-bordered table-striped" style="font-size: 12px;">
                        <thead>
                            <tr class="text-center">
                                <th>SL.</th>
                                <th>Date</th>
                                <th>Item</th>
                                <th>Category</th>
                                <th>Quantity</th>
                                <th>Rate</th>
                                <th>Amount</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                            $totalQty = 0;
                            $totalAmount = 0;
                            @endphp
                            @foreach ($employees as $emp)
                            <tr>
                              <td colspan="100%" style="font-size:16px; background: #df9a79;">{{$emp->employee->emp_name}},  {{$emp->employee->designation->designation_title}}, {{$emp->employee->department->department_title}} </td>
                            </tr>
                                @php
                                    $datas = \App\Models\EmployeeProduction::where('emp_id',$emp->emp_id)->whereBetween('date',[$fdate, $tdate])->orderby('date','asc')->get();
                                    $subTotalQty = 0;
                                    $subTotalAmount = 0;
                                @endphp
                                @foreach($datas as $val)
                                @php
                                $subTotalQty += $val->qty;
                                $totalQty += $val->qty;
                                $subTotalAmount += $val->amount;
                                $totalAmount += $val->amount;
                                @endphp
                                <tr style="font-size:13px;">
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ date('d-M-Y',strtotime($val->date))}}</td>
                                    <td>{{ $val->product->name }}</td>
                                    <td></td>
                                    <td class="text-center">{{$val->qty}}</td>
                                    <td class="text-center">{{$val->rate}}</td>
                                    <td class="text-center">{{ number_format($val->amount,2)}}</td>
                                </tr>
                                @endforeach
                                <tr style="font-size:16px; background: #47b9bf;">
                                  <td colspan="4">Sub Total: </td>
                                  <td class="text-center">{{$subTotalQty}}</td>
                                  <td></td>
                                  <td class="text-center">{{number_format($subTotalAmount,2)}}</td>
                                </tr>
                            @endforeach

                        </tbody>
                        <tfoot>
                          <tr style="font-size:16px; background: #248b3c;">
                            <td colspan="4">Sub Total: </td>
                            <td class="text-center">{{$totalQty}} Pcs</td>
                            <td></td>
                            <td class="text-center">{{number_format($totalAmount,2)}}/-</td>
                          </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>

@endsection
