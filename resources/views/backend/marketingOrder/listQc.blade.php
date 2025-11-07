@extends('layouts.crm_dashboard')

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper salescontent">
        <!-- Main content -->
        <div class="content px-4 ">
            <div class="container-fluid" style="background: #ffffff; padding: 0px 40px;">
              	<div class="row pt-3">
                  	<div class="col-md-12 text-right">
                        <a href="{{route('marketingOrder.qc.create')}}" class="btn btn-sm btn-success">Create Q.C Order</a>
                    </div>
                </div>
                <div class="text-center pt-3">
                    <h3 class="text-uppercase font-weight-bold">Naba Crop Care</h3>
                  <p>Head office, Rajshahi, Bangladesh</p>
                </div>
                <div class="py-4">
                    <div class="text-center">
                        <h5 class="text-uppercase font-weight-bold">Q.C Order List</h5>
                        <hr>
                    </div>
                    <div class="my-3">

                    </div>
                    <table id="example3" class="table table-bordered table-striped" style="font-size: 15px;">
                        <thead>
                            <tr class="text-center table-header-fixt-top">
                                <th>SI. No</th>
                                <th>Date</th>
                                <th>Require Date</th>
                                <th>Invoice</th>
                                <th>Item Name</th>

                                <th>Unit</th>
                                <th>Receive Quantity</th>
                                <th>Note</th>
                                <th>Status</th>
                                <th>User</th>
                                <th width="10%">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($datas as $data)
                                  @php
                                  $item = \App\Models\MarketingProduct::where('id',$data->item_id)->first();

                                  $user = \App\Models\User::where('id',$data->user_id)->value('name');
                                  @endphp
                                <tr>
                                    <td>{{ $loop->iteration }} </td>
                                    <td>{{ $data->date }} </td>
                                    <td>{{ $data->require_date }} </td>
                                    <td>{{ $data->invoice }} </td>
                                    <td>{{ $item->name?? '' }}</td>

                                  {{-- <td><a href="{{URL::to('/public/uploads/marketing/')}}/{{$item->image}}" target="_blank"><img class="gallery" style="height:50px;" src="{{URL::to('/public/uploads/marketing/')}}/{{$item->image}}" alt="Image"></a></td> --}}
                                    <td>{{ $item->unit?? '' }}</td>
                                    @if(!empty($data->qtyReceive))
                                    <td>{{ $data->qtyReceive }}</td>
                                    @else
                                    <td>{{ $data->qtyFull }}</td>
                                    @endif
                                    <td>{{ $data->note }}</td>

                                    <td align="center">@if($data->receive_ststus == 1)
                                       <span class="badge badge-success p-2"> Received </span>
                                        @elseif($data->receive_ststus == 2)
                                        <span class="badge badge-danger p-2"> Not Received </span>
                                       @else <span class="badge badge-primary p-2"> Full Receive </span> @endif </td>
                                       <td>{{ $user }}</td>
                                    <td>
                                       {{--<a class="btn btn-xs salesedit" style="background-color: #66BB6A"
                                            href="{{ URL::to('/marketing/order/item/edit/' . $data->id) }}" data-toggle="tooltip"
                                            data-placement="top" title="Edit"><i class="fas fa-edit"></i> </a> --}}
                                            <a  @if(empty($data->status)) style="display:none;" @endif class="btn btn-xs btn-primary "
                                                href="{{ route('marketingOrder.item.View', $data->invoice) }}"
                                                data-toggle="tooltip" data-placement="top" title="Q.C Order Invoice View"><i
                                                    class="far fa-eye"></i> </a>
                                        <a class="btn btn-xs btn-danger marketingdelete" href="" data-toggle="modal" data-target="#delete"
                                                        data-myid="{{ $data->id }}"><i class="far fa-trash-alt"></i>
                                        </a>
                                    </td>
                                </tr>
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
                    <form action="{{route('marketingOrder.qc.delete')}}" method="POST">
                        {{ method_field('delete') }}
                        @csrf

                        <div class="modal-body">
                            <p>Are you sure to delete this Post?</p>

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
