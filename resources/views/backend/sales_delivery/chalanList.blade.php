@extends('layouts.sales_dashboard')

@push('addcss')

@endpush

@section('header_menu')

@endsection


@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper salescontent">

        <!-- Main content -->
        <div class="content px-4 ">
            <div class="container" style="background: #f5f5f5; padding: 0px 40px;">
                <div class="text-center pt-3">
                    <h3 class="text-uppercase font-weight-bold">Naba Crop Care</h3>
                  <p>Head office, Rajshahi, Bangladesh</p>
                    <h5>Sales Delivery Chalan List</h5>
                </div>
                <div class="py-4 table-responsive">
                    <table id="example3" class="table table-bordered table-striped table-fixed" style="font-size: 15px;">
                       <thead>
                      <tr>
                          <th>Si.No</th>
                          <th>Date</th>
                           <th>Vehicle</th>
                          <th>Sales No</th>
                          <th>Chalan No</th>
                          <th>Invoice</th>
                          <th>Action</th>
                      </tr>
                	</thead>
                <tbody>
                @foreach($data as $val)

                    <tr>
                        <td>{{$loop->iteration}}</td>
                      	<td>{{$val->date}}</td>
                      	<td>{{$val->vehicle}}</td>
                        <td>{{$val->sales_id}}</td>
                        <td>{{$val->chalan_no}}</td>
                        <td>{{$val->invoice_no}}</td>
                        <td align="center">
                          <a href="{{ route('delivery.chalan.view', $val->chalan_no) }}" class="btn btn-primary btn-xs" data-toggle="tooltip" data-placement="top"  title="Chalan View"> <i class="fal fa-eye"></i> </a>
                          <a class="btn btn-xs btn-danger salesdelete" href="" data-toggle="modal" data-target="#delete" data-myid="{{ $val->chalan_no}}"><i class="far fa-trash-alt"></i>  </a>
                      	</td>
                    </tr>
                @endforeach
                </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>



    <!-- /.modal -->

    <div class="modal fade" id="delete">
        <div class="modal-dialog">
            <div class="modal-content bg-danger">
                <div class="modal-header">
                    <h4 class="modal-title">Delete Confirmation</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('sales.chalan.delete') }}" method="POST">
                    {{ method_field('delete') }}
                    @csrf

                    <div class="modal-body">
                        <p>Are you sure to delete this invoice?</p>

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



@endsection

@push('end_js')

    <script>
        $(function() {
            $('[data-toggle="tooltip"]').tooltip()
        })


        $('#delete').on('show.bs.modal', function(event) {
            console.log('hello test');
            var button = $(event.relatedTarget)
          //  var title = button.data('mytitle')
            var id = button.data('myid')
            var modal = $(this)

            modal.find('.modal-body #mid').val(id);
        })
    </script>

@endpush
