@extends('layouts.account_dashboard')
@section('header_menu')
<div class="text-left">
    <a href="{{ URL('/asset/create') }}" class=" btn btn-success btn-xs mr-2 mt-2">Create New Asset</a>
</div>
@endsection
@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper  accountscontent">


        <!-- Main content -->
        <div class="content ">
            <div class="container">
                <div class="text-center pt-5">
                    <h3 class="text-uppercase font-weight-bold">Naba Crop Care</h3>
		            <p>Head office, Rajshahi, Bangladesh</p>
                    <h5>Asset List</h5>
                </div>
                <div class="py-4 table-responsive">
                    <table id="example3" class="table table-bordered table-striped table-fixed" style="font-size: 15px;">
                        <thead>
                            <tr class="text-center table-header-fixt-top">
                                <th>Sl</th>
                                <th>Date</th>
                                <th>Invoice</th>
                                <th>Asset Type</th>
                                <th>Client</th>
                                <th>Asset Value</th>
                                <th>Payment </th>
                                <th>Remaining </th>
                                <th>Type</th>
                                <th>Payment Mode</th>
                                <th>Description</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>

                            @foreach ($assets as $data)
                                <tr>
                                    <td class="text-center">{{ $loop->iteration }}</td>
                                    <td class="text-center">{{ date('d-M-Y', strtotime($data->date)) }}</td>
                                    <td class="text-left">{{ $data->invoice }}</td>
                                    <td class="text-left">{{$data->asset_type_name}}</td>
                                    <td class="text-lef">{{$data->name}}</td>
                                    <td class="text-right">{{ number_format($data->asset_value) }}</td>
                                    <td class="text-right">{{ number_format($data->payment_value) }}</td>
                                    <td class="text-right">{{ number_format($data->remaining_value) }}</td>
                                    <td class="text-right">{{ $data->asset_term }}</td>
                                    <td class="text-lef">
                                        @if ($data->payment_mode == 'Bank')
                                            {{ $data->payment_mode }}
                                            <span
                                                class="text-danger">({{ DB::table('master_banks')->where('bank_id', $data->bank_id)->value('bank_name') }})</span>
                                        @elseif($data->payment_mode == "Cash")
                                            {{ $data->payment_mode }} <span
                                                class="text-danger">({{ DB::table('master_cashes')->where('wirehouse_id', $data->wirehouse_id)->value('wirehouse_name') }})</span>
                                        @endif
                                    </td>
                                    <td class="text-left">{{ $data->description }}</td>


                                    <td class="text-center align-middle">
                                        {{-- <a class="btn btn-xs accountsedit" style="background-color: mediumaquamarine; href="{{route('asset.edit',$data->id)}}" data-toggle="tooltip" data-placement="top" title="CheckOut Asset"><i class="fas fa-spinner"></i></a> --}}
                                                
                                        <a class="btn btn-xs btn-primary" href="{{route('asset.invoice.view',$data->id)}}" ><i class="far fa-eye"></i></a>
                                                    
                                        <a class="btn btn-xs btn-danger accountsdelete" href="" data-toggle="modal" data-target="#delete"
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
	    <div class="modal fade" id="delete">
        <div class="modal-dialog">
            <div class="modal-content bg-danger">
                <div class="modal-header">
                    <h4 class="modal-title">Delete Confirmation</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('asset.delete') }}" method="POST">
                    {{ method_field('delete') }}
                    @csrf

                    <div class="modal-body">
                        <p>Are you sure to delete this Asset?</p>

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
