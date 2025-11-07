@extends('layouts.account_dashboard')



@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper  accountscontent">
        <!-- Main content -->
        <div class="content px-4 ">
            <div class="container-fluid">
              <div class="text-right">
                  <li class="nav-item pt-2 d-none d-sm-inline-block">
                    <a href="{{ URL('/master/bank/create') }}" class=" btn btn-success mr-2">Create Master Bank</a>
                    <a href="{{ URL('/main/bank/create') }}" class=" btn btn-warning  mr-2">Create Main Bank</a>
                    <a href="{{ URL('/loan/type/create') }}" class=" btn btn-danger  mr-2">Loan Type</a>
                    <a href="{{ URL('master/cash/index') }}" class=" btn btn-success mr-2">Master Cash</a>
                </li>
                </div>

                <div class="text-center pt-3">
                  <h3 class="text-uppercase font-weight-bold">Naba Crop Care</h3>
                  <p>Head office, Rajshahi, Bangladesh</p>
                </div>
                <div class="py-4">
                    <div class="text-center">
                        <h5 class="text-uppercase font-weight-bold">Bank List</h5>
                        <hr>
                    </div>

                    <table id="example1" class="table table-bordered table-striped" style="font-size: 15px;">
                        <thead>
                            <tr class="text-center">
                                <th>SI. No</th>
                                <th>Main Bank </th>
                                <th>Bank Name</th>
                                <th>A/C</th>
                                <th>Opening Balance</th>
                                <th>Loan Type</th>
                                <th>Loan Amount</th>
                                <th>Starting Balance</th>
                                <th>Address</th>
                                <th width="10%">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $sl = 0;
                            @endphp
                            @foreach($banks as $data)
                                @php
                                    $sl++;
                                @endphp
                                <tr>
                                    <td class="align-middle">{{ $sl }}</td>
                                    <td>{{$data->name}}</td>

                                    <td>{{$data->bank_name}}</td>
                                   <td>{{$data->bank_licence}}</td>
                                    <td>{{$data->bank_op}}</td>
                                   <td>{{DB::table('loan_types')->where('id',$data->loan_type)->value('type')}}</td>
                                    <td>{{number_format($data->loan_amount,2)}}</td>
                                    <td>{{number_format($data->bank_starting_balance,2)}}</td>
                                    <td>{{$data->bank_address}}</td>


                                    <td class="text-center align-middle">
                                        <a class="btn btn-xs text-light accountsedit" style="background-color: #66BB6A" href="{{route('master.bank.edit',$data->bank_id)}}"
                                            data-toggle="tooltip" data-placement="top" title="Edit"><i
                                                class="fas fa-edit"></i> </a>
                                      	<a class="btn btn-xs btn-danger accountsdelete" href="" data-toggle="modal" data-target="#delete" data-myid="{{ $data->bank_id }}"><i class="far fa-trash-alt"></i> </a>
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
                    <form action="{{route('master.bank.delete')}}" method="POST">
                        {{ method_field('delete') }}
                        @csrf

                        <div class="modal-body">
                            <p>Are you sure to delete this Master Bank?</p>

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
