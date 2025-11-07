@extends('layouts.crm_dashboard')


@section('header_menu')



@endsection

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">


        <!-- Main content -->
        <div class="content px-4 ">
            <div class="container-fluid" style="background:#fff; min-height:85vh;">
                <div class="text-center pt-3">
                    <h3 class="text-uppercase font-weight-bold">Naba Crop Care</h3>
                    <p>Head office, Rajshahi, Bangladesh</p>
                </div>
                <div>
                    <div class="text-center">
                        <h5 class="text-uppercase font-weight-bold">Client Requirment Report</h5>
                        <hr>
                    </div>
                  <div class="row">
                    <div class="col-md-6 text-left">
                          <h5 class="text-uppercase font-weight-bold">Client Name: {{$client->client_name}}</h5>
                      </div>
                     <div class="col-md-6 text-right">
                          <h5 class=" "> {{date("d F Y - h:i a")}}</h5>
                      </div>
                   </div>
                    <table class="table table-bordered table-striped" style="font-size: 15px;">
                        <thead>
                            <tr class="text-center">
                                <th width="3%">Sl</th>
                                <th>Date</th>
                                <th>Invoice</th>
                                <th>Client Name</th>
                                <th>Contacts Person</th>
                                <th>Subject</th>
                                <th>Department</th>
                                <th>Assign By</th>
                                <th>User feedback</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($reportData as $item)

                                <tr>
                                    <td class="align-middle">{{ $loop->iteration }}</td>

                                    <td class="align-middle">{{ $item->date }}</td>

                                  <td class="align-middle">{{ sprintf("%06d", $item->id); }}</td>
                                    <td class="align-middle">{{ $item->client_name }}</td>
                                    <td class="align-middle">{{ $item->contacts_person }}</td>
                                    <td class="align-middle">{{ $item->subject }}</td>
                                    <td class="align-middle">{{ $item->department }}</td>
                                    <td class="align-middle">{{ $item->assign_user }}</td>
                                   <td class="align-middle">{{ $item->feedback }}</td>
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
                    <form action="{{ route('delete.progress') }}" method="POST">
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


    <script>
        $(function() {
            $('[data-toggle="tooltip"]').tooltip()
        })

        $(document).ready(function() {

                   $('#delete').on('show.bs.modal', function(event) {
                        console.log('hello test');
                        var button = $(event.relatedTarget)
                        var title = button.data('mytitle')
                        var id = button.data('myid')

                        var modal = $(this)

                        modal.find('.modal-body #mid').val(id);
                    });







            });


    </script>
@endsection
