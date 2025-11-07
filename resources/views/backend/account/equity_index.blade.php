@extends('layouts.account_dashboard')

@section('header_menu')

@endsection

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper  accountscontent">
        <!-- Main content -->
        <div class="content px-4 ">
            <div class="container-fluid">
              <div class="text-right mt-2">
              <li class="nav-item d-none d-sm-inline-block">
                  <a href="{{ route('accounts.equity.create') }}" class=" btn btn-success mr-2">Create Equity</a>
              </li>
              <li class="nav-item d-none d-sm-inline-block">
                  <a href="{{ route('accounts.equity.category') }}" class=" btn btn-warning mr-2">Equity Category</a>
              </li>
			</div>
                <div class="text-center pt-3">
                  <h3 class="text-uppercase font-weight-bold">Naba Crop Care</h3>
                  <p>Head office, Rajshahi, Bangladesh</p>
                </div>
                <div class="py-4">
                    <div class="text-center">
                        <h5 class="text-uppercase font-weight-bold">Equity List</h5>
                        <hr>
                    </div>

                    <table id="example1" class="table table-bordered table-striped" style="font-size: 15px;">
                        <thead>
                            <tr class="text-center">
                                <th>SI. No</th>
                                <th>Date</th>
                                <th>Bank/Cash</th>
                                <th>Head</th>
                               <th>Category</th>
                               <th>Name</th>
                                <th>Percentage</th>
                                <th>Amount</th>

                                <th width="10%">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $sl = 0;
                            @endphp
                            @foreach($datas as $data)

                                    @php
                                    $sl++;
                          			if(!empty($data->bank_id)){
                          				$name = DB::table('master_banks')->where('bank_id', $data->bank_id)->value('bank_name');
                          			} elseif(!empty($data->cash_id)) {
                          				$name = DB::table('master_cashes')->where('wirehouse_id', $data->cash_id)->value('wirehouse_name');
                                } else {
                                  $name = 'Opening Balance';
                                }

                                	@endphp
                                <tr>
                                    <td class="align-middle">{{ $sl }}</td>
                                    <td>{{$data->date}}</td>
                                    <td>{{$name}}</td>
                                    <td>{{$data->head}}</td>
                                    <td>{{$data->cat_name}}</td>
                                    <td>{{$data->name}}</td>
                                    <td>{{$data->percentage}}</td>
                                    <td>{{number_format($data->amount,2)}}</td>

                                    <td class="text-center align-middle">
                                     {{--   <a class="btn btn-sm text-light accountsedit" style="background-color: #66BB6A" href="#/{{$data->id }}"
                                            data-toggle="tooltip" data-placement="top" title="Edit"><i
                                                class="fas fa-edit"></i> </a>  --}}
                                      	<a class="btn btn-xs btn-danger accountsdelete" href="" data-toggle="modal" data-target="#delete" data-myid="{{ $data->id }}"><i class="far fa-trash-alt"></i> </a>
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
                    <form action="{{route('accounts.equity.delete')}}" method="POST">
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
