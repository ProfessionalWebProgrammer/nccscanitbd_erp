@extends('layouts.account_dashboard')




    @section('content')
        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper accountscontent">


            <!-- Main content -->
            <div class="content px-4 ">
                <div class="container" style="background:#ffffff; padding:0px 40px;min-height:85vh">
                    <div class="text-center pt-3">
                        <h3 class="text-uppercase font-weight-bold">Naba Crop Care</h3>
                  		<p>Head office, Rajshahi, Bangladesh</p>
                    </div>
                    <div class="py-4">

                        <div class="text-center">
                            <h5 class="text-uppercase font-weight-bold">Delete Log List</h5>
                            <hr>
                        </div>





                        <table id="example3" class="table table-bordered table-striped" style="font-size: 15px;">
                             <thead>
                            <tr>
                                <th>SI. No</th>
                                <th>Deleted By</th>
                                <th>Company Name and Account</th>
                                <th>Supplier or Vender Name</th>
                                <th>Payment Date</th>
                                <th>Payment type</th>
                                 <th>Invoice</th>
                                <th>Amount</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach($payment_logs as $data)
                          @php
                          	$deletedby = DB::table('users')->where('id',$data->deleted_by)->value('name');
                          @endphp
                          	 <tr>
                                <td>{{$loop->iteration}}</td>
                          		<td class="text-center"><b>{{$deletedby}}</b><br>  {{$data->updated_at}}</td>
                          		<td>{{$data->bank_name}}</td>
                          		<td>{{$data->d_s_name}} {{$data->supplier_name}}</td>
                          		<td>{{$data->payment_date}}</td>
                          		<td>{{$data->payment_type}}</td>
                          		<td>{{$data->invoice}}</td>
                          		<td>{{$data->amount}}</td>
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
