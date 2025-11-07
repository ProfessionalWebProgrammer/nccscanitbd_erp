@extends('layouts.account_dashboard')

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper  accountscontent">


        <!-- Main content -->
        <div class="content px-4 ">
            <div class="container-fluid">

               <div class="row pt-3">
                  <div class="col-md-6 text-right">

                      </div>
                      <div class="col-md-6 text-right">
                      	<a href="{{ URL('/amount/transfer/create') }}" class=" btn btn-success mr-2">Create Transfer</a>
                       </div>
                   
                  </div>


                <div class="text-center pt-3">
                    <h3 class="text-uppercase font-weight-bold">Naba Crop Care</h3>
		                  <p>Head office, Rajshahi, Bangladesh</p>
                </div>
                <div class="text-center pt-3">
                    <h5 class="text-uppercase font-weight-bold">Amount Trasnfer List View</h5>
                    <hr>
                </div>
                <div class="py-4">
                    <table id="example3" class="table table-bordered table-striped table-fixed" style="font-size: 15px;">
                        <thead>
                            <tr class="text-center">
                                <th>SI. No</th>
                                <th>Transfer Invoice</th>
                                <th>Date</th>
                                <th>Transfer From</th>
                                <th>Transfer To</th>
                              	<th>Transfer Amount</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($listData as $item)

                            @if ($item->count != 2)

                            @else

                                @php
                                    $from = DB::table('payments')
                                        ->where('transfer_invoice', $item->transfer_invoice)
                                        ->where('transfer_type', 'PAYMENT')
                                        ->first();
                                     //dd($from);
                                    // $fromname = null;
                                    if ($from->bank_name != null) {
                                        $fromname = $from->bank_name;
                                    } elseif ($from->wirehouse_name != null) {
                                        $fromname = $from->wirehouse_name;
                                    }

                                    $to = DB::table('payments')
                                        ->where('transfer_invoice', $item->transfer_invoice)
                                        ->where('transfer_type', 'RECEIVE')->first();
                                     //dd($to->bank_name);

                                    if ($to->bank_name != null) {
                                        $toname = $to->bank_name;
                          				//dd($toname);
                                    } elseif ($to->wirehouse_name != null) {
                                        $toname = $to->wirehouse_name;
                                    }

                                @endphp
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $item->transfer_invoice }}</td>
                                    <td>{{ $item->payment_date }}</td>
                                    <td>{{ $fromname }}</td>
                                    <td>{{ $toname }}</td>
                                  	<td>{{ number_format($to->amount,2) }}</td>
                                    <td class="text-center">
                                        {{--<a class="btn btn-xs btn-info accountsedit"
                                            href="{{ URL::to('/amount/transfer/edit/' . $item->transfer_invoice) }}"
                                            data-toggle="tooltip" data-placement="top" title="Edit"><i
                                                class="fas fa-edit"></i> </a> --}}
                                      <a class="btn btn-xs btn-primary accountsedit"
                                            href="{{ URL::to('/amount/transfer/view/' . $item->transfer_invoice) }}"
                                            data-toggle="tooltip" data-placement="top" title="View"><i
                                                class="fas fa-eye"></i> </a>
                                        <a class="btn btn-xs btn-danger accountsdelete" href="" data-toggle="modal" data-target="#delete"
                                                        data-myid="{{ $item->transfer_invoice }}"><i class="far fa-trash-alt"></i></a>
                                    </td>
                                </tr>

                                @endif
                            @endforeach
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
                    <form action="{{route('amount.transfer.delete')}}" method="POST">
                        {{ method_field('delete') }}
                        @csrf

                        <div class="modal-body">
                            <p>Are you sure to delete this Item?</p>

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

                modal.find('.modal-body #minvoice').val(id);
            })
        </script>

    @endpush
@endsection
