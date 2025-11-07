@extends('layouts.purchase_deshboard')

@section('header_menu')

        <div class="mt-2">
        <li class="nav-item d-none d-sm-inline-block">
            <a href="{{ url('/direct/labour/newCost/create') }}" class=" btn btn-xs btn-success mr-2">Create Direct Labour Cost</a>
            <a href="{{ route('manufacturing.newCost.list') }}" class="btn btn-xs  btn-success ">Manufacturing Cost</a>
	    </li>
        </div>
@endsection

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper accountscontent">
        <!-- Main content -->
        <div class="content px-4 ">
            <div class="container-fluid">
			
                <div class="text-center pt-3">
                    <h3 class="text-uppercase font-weight-bold">Naba Crop Care</h3>
                    <p>Head office, Rajshahi, Bangladesh</p>
                </div>
                <div class="py-4">
                    <div class="text-center">
                        <h5 class="text-uppercase font-weight-bold">Direct Labour Cost List</h5>
                        <hr>
                    </div>
                    <table id="example3" class="table table-bordered table-striped" style="font-size: 15px;">
                        <thead>
                            <tr class="text-center">
                                <th>SL.</th>
                                <th>Date</th>
                              	<th>F.G. Qty</th>
                                <th>Invoice</th>
                                <th>Head</th>
                                <th>Quantity</th>
                                <th>Unite Cost</th>
                                <th>Total Cost</th>
                                <th width="10%">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data as $key => $item)
                            <tr>
                                <td>{{$loop->iteration}}</td>
                                <td>{{$item->date}}</td>
                              	<td>{{$item->quantity}}</td>
                                <td>{{$item->invoice}}</td>
                                <td>{{$item->head}}</td>
                                <td>{{$item->labour_qty}}</td>
                                <td>{{number_format($item->per_person_cost,2)}}</td>
                                <td>{{number_format($item->total_cost,2)}}</td>
                                <td class="text-center"> 
                                  	{{-- <a href="{{route('direct.labour.newCost.edit',$item->chalan_no)}}" class="btn btn-sm btn-info"><span class="fa fa-edit"></span></a> --}}
                              		<a class="btn btn-xs btn-danger purchasedelete" href="" data-toggle="modal" data-target="#delete" data-myid="{{ $item->id }}"><i class="far fa-trash-alt"></i> </a>
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
                    <form action="{{route('direct.labour.newCost.delete')}}" method="POST">
                        {{ method_field('delete') }}
                        @csrf

                        <div class="modal-body">
                            <p>Do you want to Delete?</p>

                            <input type="hidden" id="mid" name="id">
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
                var id = button.data('myid')

                var modal = $(this)

                modal.find('.modal-body #mid').val(id);
            })
        </script>

    @endpush
@endsection
