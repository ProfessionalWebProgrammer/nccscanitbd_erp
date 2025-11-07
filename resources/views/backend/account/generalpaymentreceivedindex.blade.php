@extends('layouts.account_dashboard')


@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper accountscontent">
        <!-- Main content -->
        <div class="content px-4 ">
            <div class="container" style="background:#ffffff; padding:0px 40px;min-height:85vh">

               <div class="row pt-3">
                      <div class="col-md-6 text-left">
                      	 <a href="{{ URL('/general/payment/received/create') }}" class=" btn btn-success mr-2">General Payment Received</a>
                       </div>
                    <div class="col-md-6 text-right">

                      </div>
                  </div>
                <div class="text-center pt-3">
                  <h3 class="text-uppercase font-weight-bold">Naba Crop Care</h3>
                  <p>Head office, Rajshahi, Bangladesh</p>
                </div>
                <div class="py-4">
                    <div class="text-center">
                        <h5 class="text-uppercase font-weight-bold">General Payment List</h5>
                        <hr>
                    </div>

                    <table id="example1" class="table table-bordered table-striped" style="font-size: 15px;">
                        <thead>
                            <tr class="text-center" style="background: #FA621C; color: #fff;">
                                <th>SI. No</th>
                                 <th>Date</th>
                                <th>Head</th>
                                <th>Collection Mode</th>
                              	<th>Collection On</th>
                              	<th>Vehicle Number</th>
                              	<th>Amount</th>
                                <th width="10%">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $sl = 0;
                          		$total = 0;
                            @endphp
                            @foreach($listdata as $data)
                                @php
                                    $sl++;
                          			$total += $data->amount;
                                @endphp
                                <tr>
                                    <td class="text-center">{{ $sl }}</td>
                                    <td class="text-center">{{date('d-M-Y',strtotime($data->payment_date))}}</td>
                                    <td>{{$data->payment_description}}</td>
                                    <td>{{$data->type}}</td>

                                    <td>
                                      @if($data->type == "Cash")
                                      	{{$data->wirehouse_name}}
                                      @else
                                      	{{$data->bank_name}}
                                      @endif
                                  	</td>
                                    <td class="text-right">{{$data->vehicle_number}}</td>
                                    <td class="text-right">{{number_format($data->amount,2)}}</td>

                                    <td class="text-center align-middle">
                                        <a class="btn btn-sm text-light accountsedit" style="background-color: #66BB6A" href="{{URL::to('/general/payment/received/edit/'. $data->id)}}"
                                            data-toggle="tooltip" data-placement="top" title="Return"><i
                                                class="fas fa-edit"></i> </a>
                                      	<a class="btn btn-sm btn-danger accountsdelete" href="" data-toggle="modal" data-target="#delete" data-myid="{{ $data->id }}"><i class="far fa-trash-alt"></i> </a>
                                    </td>
                                </tr>
                            @endforeach
                          		<tr style="background: #C641CF; color: #fff;">
                                  <td>Total</td>
                                  <td></td>
                                  <td></td>
                                  <td></td>
                                  <td></td>
                                  <td></td>
                                  <td class="text-right">{{number_format($total,2)}}</td>
                                  <td></td>
                          		</tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
      <!-- modal -->
    <div class="modal fade" id="delete">
            <div class="modal-dialog">
                <div class="modal-content bg-danger">
                    <div class="modal-header">
                        <h4 class="modal-title">Delete Confirmation</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action="{{route('general.payment.recived.delete')}}" method="POST">
                        {{ method_field('delete') }}
                        @csrf

                        <div class="modal-body">
                            <p>Are you sure to delete this Payment Received?</p>

                            <input type="hidden" id="mid" name="id">
                            <input type="hidden" id="minvoice" name="invoice">
                        </div>
                        <div class="modal-footer justify-content-between">
                            <button type="button" class="btn btn-outline-light" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-outline-light">Confirm</button>
                        </div>
                    </form>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
    <!-- /.modal -->
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
