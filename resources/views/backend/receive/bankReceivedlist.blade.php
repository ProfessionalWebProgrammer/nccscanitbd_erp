@extends('layouts.account_dashboard')

    @section('content')
        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper accountscontent">

			<div class="row pt-2 pb-2 ml-3">
                      <div class="col-md-6 text-left ml-5">
                      	<a href="{{ URL('/bank/receive/create') }}" class=" btn btn-sm btn-success mr-2">Create Bank Receive</a>
                       </div>
                  </div>
            <!-- Main content -->
            <div class="content px-4 ">
                <div class="container" style="background:#ffffff; padding:0px 40px;min-height:85vh">



                    <div class="text-center">
                      	<h3 class="text-uppercase font-weight-bold">Naba Crop Care</h3>
                  		<p>Head office, Rajshahi, Bangladesh</p>
                      	<h5 class="text-uppercase font-weight-bold">Bank Received List</h5>
                    </div>
                    <div class="py-4">

                        <div class="text-center">

                            <hr>
                        </div>


                        <form action="{{ route('bank.receive.index') }}" method="get">
                            <div class="row pb-4">
                                <div class="col-md-4 "></div>
                                <div class="col-md-8 input-group rounded">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="">Date</span>
                                    </div>
                                    <input type="text" name="date" class="form-control float-right" id="daterangepicker"
                                        value="{{ $date }}">
                                    <div class="input-group-prepend  pr-2">

                                    </div>
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="">Invoice</span>
                                    </div>
                                    <input type="text" name="invoice" value="{{ $invoice }}"
                                        class="form-control float-right">

                                    <div class="input-group-prepend  pr-2">

                                    </div>
                                    <div class="input-group-prepend pr-2">
                                        <button type="submit" class="btn btn-sm btn-success"><i class="fas fa-search"></i>
                                            Search</button>
                                    </div>

                                    <div class="input-group-prepend pr-2">
                                        <a href="{{ route('bank.receive.index') }}" class="btn btn-sm btn-danger"><i
                                                class="far fa-times-circle"></i>
                                            Clear</a>
                                    </div>
                                    {{-- <div class="input-group-prepend">
                                            <button class="btn btn-sm btn-warning"><i class="fas fa-print"></i>
                                                Print</button>
                                            </div> --}}
                                </div>

                            </div>
                        </form>


                        <table id="example3" class="table table-bordered table-striped" style="font-size: 15px;">
                            <thead>
                                <tr class="text-center table-header">
                                    <th>Sl</th>
                                    <th>User</th>
                                    <th>Company Name & Account</th>
                                    <th> Name</th>
                                    <th>Payment Date</th>
                                    <th>Invoice</th>
                                    <th>Amount</th>
                                    <th>Updated By</th>
                                    <th width="12%">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $sl = 0;
                              		$total = 0;
                                @endphp
                                 @php
                            $startSerial = ($data->currentPage() - 1) * $data->perPage() + 1;
                          @endphp
                                @foreach ($data as $item)

                                    @php
                                        $sl++;
                                        $username = DB::table('users')
                                            ->where('id', $item->created_by)
                                            ->value('name');
                                        $updatename = DB::table('users')
                                            ->where('id', $item->updated_by)
                                            ->value('name');
                              			$total += $item->amount;

                                    if(empty($data->d_s_name)){
                                      $name = \App\Models\InterCompany::where('id',$item->sister_concern_id)->value('name');
                                    }
                                    @endphp
                                    <tr>
                                        <td class="align-middle">{{ $startSerial++ }}</td>
                                        <td class="text-center align-middle">{{ $username }} <br>
                                            {{ $item->created_at }}
                                        </td>
                                        <td class="align-middle">{{ $item->bank_name }}</td>
                                        <td class="align-middle">{{ $item->d_s_name ?? $name}}</td>
                                        <td class="align-middle">{{ $item->payment_date }}</td>
                                        <td class="text-center align-middle">{{ $item->invoice }}</td>
                                        <td class="text-right align-middle"> {{ number_format($item->amount,2) }}/-</td>
                                        <td class="align-middle">
                                            @if ($updatename)
                                                {{ $item->updated_at }} ({{ $updatename }})
                                            @endif
                                        </td>
                                        <td class="text-center align-middle">
                                            <a class="btn btn-xs text-light accountsedit" style="background-color: #66BB6A"
                                                href="{{ URL::to('/bank/receive/edit/' . $item->invoice) }}"
                                                data-toggle="tooltip" data-placement="top" title="Edit"><i
                                                    class="fas fa-edit"></i> </a>
                                          <a class="btn btn-xs text-light btn-primary" href="{{ URL::to('/bank/receive/view/' . $item->invoice) }}"
                                                data-toggle="tooltip" data-placement="top" title="View"><i
                                                    class="fas fa-eye"></i> </a>
                                            <a class="btn btn-xs btn-danger accountsdelete" href=""
                                                data-myid="{{ $item->id }}" data-mytitle="" data-toggle="modal"
                                                data-target="#delete"><i class="far fa-trash-alt"></i>
                                            </a>
                                        </td>
                                    </tr>

                                @endforeach
                              <tr style="background: #C641CF; color: #fff;">
                                  <td>Total</td>
                                  <td></td>
                                  <td></td>
                                  <td></td>
                                  <td></td>
                                  <td></td>
                                  <td>{{number_format($total,2)}}</td>
                                  <td></td>
                                  <td></td>

                              </tr>
                            </tbody>
                        </table>
                         <div>
                           {{--$data->links()--}}
                           {{ $data->appends(Request::except('token'))->links() }}
                       </div>
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
                    <form action="{{ route('bank.receive.delete') }}" method="POST">
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


            $(document).ready(function() {

                $("#daterangepicker").change(function() {
                    var a = document.getElementById("today");
                    a.style.display = "none";
                });






            });
        </script>

    @endpush
