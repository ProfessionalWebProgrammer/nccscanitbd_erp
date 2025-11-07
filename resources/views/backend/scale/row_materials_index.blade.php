@extends('layouts.settings_dashboard')

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Main content -->
        <div class="content px-4 ">
            <div class="container-fluid">
                <div class="text-center pt-3">
                    <h3 class="text-uppercase font-weight-bold">SBMS V.2 - Scan It</h3>
                    <p>Official Conpany Address <br> Road:1200 , House 005, Dhaka- 1202</p>
                    <h6>01712345678 , 86458415</h6>
                </div>
                <div class="py-4">
                    <div class="text-center">
                        <h5 class="text-uppercase font-weight-bold">Scale List</h5>
                        <hr>
                    </div>
                    <div class="my-3">

                    </div>
                    <table id="example1" class="table table-bordered table-striped" style="font-size: 15px;">
                        <thead>
                            <tr>
                                <th>Si.No</th>
                                <th>Date</th>
                                <th>Supplier Name</th>
                                <th>Vehicle</th>
                                <th>Status</th>
                                <th>Chalan Q</th>
                                <th>Scale No</th>
                                <th width="15%">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($list as $data)

                                @php
                                    
                                    if ($data->delivery_status == 0) {
                                        $incolor = 'color: rgb(255, 117, 117);';
                                    } else {
                                        $incolor = 'color: rgb(106, 255, 106);';
                                    }
                                @endphp

                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $data->date }}</td>
                                    <td>{{ $data->supplier_name }}</td>
                                    <td>{{ $data->vehicle }}</td>
                                    @if ($data->load_status == 0)
                                        <td style="color:rgb(255, 117, 117)">Unload</td>
                                    @else
                                        <td style="color:rgb(106, 255, 106)">Load</td>
                                    @endif
                                    <td>{{ $data->chalan_qty }}</td>

                                    <td style="{{ $incolor }}">{{ $data->scale_no }}</td>

                                    <td>
                                        <a href="#" class="btn btn-danger btn-xs purchasedelete" data-myid="{{ $data->scale_no }}"
                                            data-mytitle="" data-toggle="modal" data-target="#delete"
                                            style="margin-bottom:2px"><i class="ti-trash"></i>Delete</a>
                                        <a href="{{ route('row.materials.scale.view', $data->scale_no) }}"
                                            class="btn btn-primary btn-xs" style="margin-bottom:2px">Scale View</a>
                                        <a href="{{ route('row.materials.scale.edit', $data->scale_no) }}"
                                            class="btn btn-success btn-xs purchaseedit" style="margin-bottom:2px">Scale Edit</a>
                                        @if ($data->delivery_status == 0)
                                            <a href="{{ route('row.materials.scale.delivery.confirm', $data->scale_no) }}"
                                                class="btn btn-warning btn-xs " style="margin-bottom:2px">Delivery
                                                Confirm</a>
                                        @endif
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
            <form action="{{ route('row.materials.scale.destroy') }}" method="POST">
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
