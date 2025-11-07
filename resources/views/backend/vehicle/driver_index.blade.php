@extends('layouts.settings_dashboard')

@section('header_menu')
    <li class="nav-item d-none d-sm-inline-block">
        <a href="{{ route('driver.create') }}" class=" btn btn-success mr-2">Driver Entry</a>
    </li>
@endsection

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper salescontent">


        <!-- Main content -->
        <div class="content px-4 ">
            <div class="container-fluid">
                <div class="text-center pt-3">
                    <h3 class="text-uppercase font-weight-bold">SBMS V.2 - Scan It</h3>
                    <p>Official Conpany Address <br> Road:1200 , House 005, Dhaka- 1202</p>
                    <h6>01712345678 , 86458415</h6>
                    <h5>Driver  List</h5>
                </div>
                <div class="py-4">
                    <table id="example1" class="table table-bordered table-striped table-fixed" style="font-size: 15px;">
                        <thead>
                            <tr class="text-center table-header-fixt-top">
                                <th>Sl</th>
                                <th>Name</th>
                                <th>Phone</th>
                                <th>Vehicle Number</th>
                                <th>Address</th>
                               
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody style="font-size: 18px;">

                           @foreach ($drivers as $date)
                               
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $date->name }} </td>
                                    <td>{{ $date->phone }}</td>
                                    <td>{{ $date->vehicle_number }}</td>
                                    <td>{{ $date->address }}</td>
                               

                                    <td class="text-center align-middle">
                                    {{--   <a class="btn btn-sm mb-1 salesedit"
                                            style="background-color: mediumaquamarine;                                                                                                                                                                                                                                                                    color: white;"
                                            href="{{ route('sales.return.edit', $all_returnslist->invoice_no) }}"
                                            data-toggle="tooltip" data-placement="top" title="CheckOut Invoice"><i
                                                class="fas fa-spinner"></i></a>
                                           <a class="btn btn-xs btn-primary " href="{{URL::to('/sales/return/view/'.$all_returnslist->invoice_no)}}" data-toggle="tooltip"
                                            data-placement="top" title="View Return Invoice"><i class="far fa-eye"></i> </a>  --}}
                                      
                                            <a class="btn btn-xs btn-danger salesdelete" href="" data-toggle="modal" data-target="#delete"
                                            data-myid="{{ $date->id }}"><i class="far fa-trash-alt"></i>
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
                <form action="{{ route('delete.driver') }}" method="POST">
                    {{ method_field('delete') }}
                    @csrf

                    <div class="modal-body">
                        <p>Are you sure to delete this?</p>

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


  
@endsection


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

