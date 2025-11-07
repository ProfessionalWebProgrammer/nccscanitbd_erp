@extends('layouts.crm_dashboard')


@section('header_menu')



@endsection

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">


        <!-- Main content -->
        <div class="content px-4 ">
            <div class="container" style="background:#fff; min-height:85vh;">

               <li class="nav-item d-none d-sm-inline-block">
        <a href="{{ URL('/client/requirement/create') }}" class=" btn btn-success btn-sm mt-1 mr-2">Requirement Entry</a>
    </li>


                <div class="text-center pt-3">
                    <h3 class="text-uppercase font-weight-bold">Naba Crop Care</h3>
                    <p>Head office, Rajshahi, Bangladesh</p>
                </div>
                <div>
                    <div class="text-center">
                        <h5 class="text-uppercase font-weight-bold">Requirement List</h5>
                        <hr>
                    </div>
                    <table id="example3" class="table table-bordered table-striped" style="font-size: 15px;">
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
                                <th>User Feedback</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($crdata as $item)

                                <tr>
                                    <td class="align-middle">{{ $loop->iteration }}</td>

                                    <td class="align-middle">{{ $item->date }}</td>
                                    <td class="align-middle">{{ sprintf("%06d", $item->id); }}</td>
                                    <td class="align-middle">{{ $item->client_name }}</td>
                                    <td class="align-middle">{{ $item->contacts_person }}</td>
                                    <td class="align-middle">{{ $item->subject }}</td>
                                    <td class="align-middle">{{ $item->department }}</td>
                                    <td class="align-middle">{{ $item->emp_name }}</td>
                                    <td class="align-middle">{{ $item->feedback }}</td>


                                    <td class="text-center align-middle">
                                      <a class="btn btn-sm text-light btn-primary"
                                            href="{{ URL::to('/view/requirement/' . $item->id) }}" data-toggle="tooltip"
                                            data-placement="top" title="view"><i class="fa-solid fa-eye"></i></a>
                                       {{-- <a class="btn btn-sm text-light" style="background-color: #66BB6A"
                                            href="{{ URL::to('/expance/edit/' . $item->id) }}" data-toggle="tooltip"
                                            data-placement="top" title="Edit"><i class="fas fa-edit"></i> </a> --}}
                                      <a class="btn btn-sm btn-dark accountsdelete" href=""
                                                data-myid="{{ $item->id }}" data-mytitle="" data-toggle="modal"
                                                data-target="#assinguser"><i class="fas fa-user-edit"></i>
                                            </a>
                                       <a class="btn btn-sm btn-danger assinguser" href=""
                                                data-myid="{{ $item->id }}" data-mytitle="" data-toggle="modal"
                                                data-target="#delete"><i class="far fa-trash-alt"></i>
                                            </a>

                                      <a class="btn btn-sm btn-info mt-1" href=""
                                                data-myid="{{ $item->id }}" data-mytitle="" data-toggle="modal"
                                                data-target="#feedback">Feedback
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
                    <form action="{{ url('/client/requirement/delete/') }}" method="POST">
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



        <div class="modal fade" id="assinguser">
            <div class="modal-dialog">
                <div class="modal-content ">
                    <div class="modal-header">
                        <h4 class="modal-title">Assign Person</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action="{{ url('/client/requirement/assign/') }}" method="POST">
                         @csrf

                        <div class="modal-body">
                            <div class="form-group">
                              <label for="exampleInputEmail1">Select Employee</label>
                             <select class="form-control select2" name="assign_user">
                                          <option>Select Employee</option>
                                          @foreach($emps as $item)
                                          	<option value="{{$item->id}}">{{$item->emp_name}}</option>
                                          @endforeach
                                      	</select>

                           </div>

                            <input type="hidden" id="mid" name="id">
                            <input type="hidden" id="minvoice" name="invoice">
                        </div>
                        <div class="modal-footer justify-content-between">
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-success">Save</button>
                        </div>
                    </form>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>

        <!-- /.modal -->



        <div class="modal fade" id="feedback">
            <div class="modal-dialog">
                <div class="modal-content ">
                    <div class="modal-header">
                        <h4 class="modal-title">User Feedback</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action="{{ url('/client/requirement/feedback/') }}" method="POST">
                         @csrf

                        <div class="modal-body">
                            <div class="form-group">
                              <label for="exampleInputEmail1">Select Employee</label>
                             <textarea class="form-control" name="feedback" id="exampleFormControlTextarea1" rows="3"></textarea>
                           </div>

                            <input type="hidden" id="mid" name="id">
                            <input type="hidden" id="minvoice" name="invoice">
                        </div>
                        <div class="modal-footer justify-content-between">
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-success">Save</button>
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


           $('#assinguser').on('show.bs.modal', function(event) {
                        console.log('hello test');
                        var button = $(event.relatedTarget)
                        var title = button.data('mytitle')
                        var id = button.data('myid')

                        var modal = $(this)

                        modal.find('.modal-body #mid').val(id);
                    });
      $('#feedback').on('show.bs.modal', function(event) {
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
