@extends('layouts.crm_dashboard')

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper salescontent">
        <!-- Main content -->
        <div class="content px-4 ">
            <div class="container-fluid" style="background: #ffffff; padding: 0px 40px;">
              	<div class="row pt-3">
                  	<div class="col-md-12 text-right">
                      {{--	<a href="{{route('product.unit.create')}}" class="btn btn-sm btn-success">Product Unit</a>
                      	<a href="{{route('sales.category.index')}}" class="btn btn-sm btn-success">Product Category</a>
                        <a href="{{route('marketingOrder.tracking.create')}}" class="btn btn-sm btn-success">Traking Entry </a>
                       <a href="{{route('specification.head.index')}}" class="btn btn-sm btn-success mr-2">Specification Head</a> --}}
                    </div>
                </div>
                <div class="text-center pt-3">
                    <h3 class="text-uppercase font-weight-bold">Naba Crop Care</h3>
                  <p>Head office, Rajshahi, Bangladesh</p>
                </div>
                <div class="py-4">
                    <div class="text-center">
                        <h5 class="text-uppercase font-weight-bold">Traking List</h5>
                        <h5 class="text-uppercase font-weight-bold">Purchase Order No: {{$data->invoice}}</h5>
                        <hr>
                    </div>
                    <div class="my-3">

                    </div>
                    <table class="table table-bordered table-striped" style="font-size: 13px;">
                        <thead>
                            <tr class="text-center table-header-fixt-top">
                                <th>SI. No</th>
                                <th>Date</th>
                                <!-- <th>Invoice Number</th> -->
                                <th>Progress Stage</th>
                                <th>Progress Value</th>
                                <th>Remarks</th>
                                <th>User Name</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($datas as $val)

                                <tr>
                                    <td>{{ $loop->iteration }} </td>
                                    <td>{{date("M d, Y", strtotime($val->date))}} </td>

                                    <td>
                                      @if($val->stage == 1)
                                      1st Stage
                                      @elseif($val->stage == 2)
                                      2nd Stage
                                      @elseif($val->stage == 3)
                                      3rd Stage
                                      @elseif($val->stage == 4)
                                      4th Stage
                                      @else
                                      5th Stage
                                      @endif
                                     </td>
                                    <td>{{ $val->value }} %</td>
                                    <td>{{ $val->remarks }}</td>
                                    <td>{{ $val->user->name }}</td>
                                    <td align="center"> @if($val->status == 1)
                                        <span class="btn btn-success btn-xs" data-toggle="tooltip" data-placement="top" title="" data-original-title=""><i class="fa fa-check" aria-hidden="true"></i> </span>
                                       @else
                                         <span class="btn btn-danger btn-xs" data-toggle="tooltip" data-placement="top" title="" data-original-title=""> <i class="fas fa-times"></i></span>
                                       @endif</td>

                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                </div>
                <div class="col-md-12">
                    <h2>Progress Bar of Purchase Order</h2>
                    <table class="table table-bordered ">
                      <thead >
                        <tr style="background:#0d2a6c;">
                          <td width="10%">Date</td>
                          <td>Progress</td>
                        </tr>
                      </thead>
                      <tbody>
                        @php
                        $total = 0;
                        @endphp
                      @foreach ($datas as $val)
                      @php
                      $total += $val->value;
                      @endphp
                      <tr >
                        <td>{{date("M d, Y", strtotime($val->date))}}</td>
                        <td>
                          <div class="progress" style="height:50px">
                            <div class="progress-bar bg-success" style="width:{{$val->value}}%;height:50px">{{$val->value}} %</div>
                          </div>
                      </td>
                      </tr>
                      @endforeach
                      @php
                      $remaining = 100 - $total;
                      @endphp
                      <tr>
                        <td>Total Task: </td>
                        <td>
                          <div class="progress" style="height:50px">
                            <div class="progress-bar bg-warning" style="width:100%;height:50px">100 %</div>
                          </div>
                        </td>
                      </tr>
                      <tr>
                        <td>Task Complete: </td>
                        <td>
                          <div class="progress" style="height:50px">
                            <div class="progress-bar bg-success" style="width:{{$total}}%;height:50px">{{$total}} %</div>
                          </div>
                        </td>
                      </tr>
                      <tr>
                        <td>Remaining Task: </td>
                        <td>
                          <div class="progress" style="height:50px">
                            <div class="progress-bar bg-primary" style="width:{{$remaining}}%;height:50px">{{$remaining}} %</div>
                          </div>
                        </td>
                      </tr>
                    </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    @push('end_js')

        <script>
            $(function() {
                $('[data-toggle="tooltip"]').tooltip()
            })


            $('#delete').on('show.bs.modal', function(event) {
                console.log('hello test');
                var button = $(event.relatedTarget)
                var title = button.data('mytitle')
                var id = button.data('myid')

                var modal = $(this)

                modal.find('.modal-body #mid').val(id);
            })
        </script>

    @endpush
@endsection
