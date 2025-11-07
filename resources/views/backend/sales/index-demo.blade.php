@extends('layouts.sales_dashboard')

@push('addcss')

@endpush

@section('header_menu')
 <div class="mt-2">
<li class="nav-item d-none d-sm-inline-block">
        <a href="{{ URL('/sales/delete/log') }}" class=" btn btn-xs btn-success mr-2">Delete Log</a>
	</li>
    
</div>
@endsection


@section('content')
<style>
  input.form-control{
  border-radius: 0px!important;
  }
  </style>
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper salescontent">


        <!-- Main content -->
        <div class="content px-4 ">
            <div class="container-fluid" style="background: #f5f5f5; padding: 0px 40px;">
                   
                <div class="text-center pt-3">

                    <h3 class="text-uppercase font-weight-bold">Naba Crop Care</h3>
                  <p>Head office, Rajshahi, Bangladesh</p>
                    <h5>Sales List</h5>
                </div>
                <div class="py-4 table-responsive">

                   

                    <table id="example3" class="table table-bordered table-striped table-fixed" style="font-size: 15px;">
                        <thead>
                            <tr class="text-center table-header-fixt-top">
                                <th>Sl</th>
                                <th>Dealer Name </th>
                               
                            </tr>
                        </thead>
                        <tbody style="font-size: 18px;">

                            @foreach ($data as $val)
                              
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $val->d_s_name }}</td>
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
                <form action="{{ route('sales.invoice.delete') }}" method="POST">
                    {{ method_field('delete') }}
                    @csrf

                    <div class="modal-body">
                        <p>Are you sure to delete this invoice?</p>

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



@endsection

@push('end_js')

    <script>
        $(function() {
            $('[data-toggle="tooltip"]').tooltip()
        })


        $('#delete').on('show.bs.modal', function(event) {
            //console.log('hello test');
            var button = $(event.relatedTarget)
            var id = button.data('myid')
			var WaireHouse = button.data('WaireHouse')
            var modal = $(this)

            modal.find('.modal-body #minvoice').val(id);
        })
    </script>

@endpush
