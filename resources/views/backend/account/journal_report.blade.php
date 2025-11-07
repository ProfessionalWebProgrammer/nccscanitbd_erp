@extends('layouts.account_dashboard')


@section('print_menu')

			
@endsection

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper accountscontent">
<div class="col-md-9 m-auto">
    <li class="nav-item">
				<div class="text-right">
                      	<button class="btn btn-xs  btn-success mr-1 mt-2" id="btnExport"  >
                       Export
                    </button>
                    <button class="btn btn-xs  btn-warning mt-2"  onclick="printDiv('contentbody')"  id="printbtn"  >
                       Print
                    </button>
                    </div>
            </li>
</div>

        <!-- Main content -->
        <div class="content p-4 ">
            <div class="container" id="contentbody">
                <div class="text-center pt-3">
                    <h3 class="text-uppercase font-weight-bold">Naba Crop Care</h3>
                    <p>Head office, Rajshahi, Bangladesh</p>
                </div>
                <div>
                    <div class="text-center">
                        <h5 class="text-uppercase font-weight-bold">Journal Book</h5>
                        <p>From {{date('d m, Y',strtotime($fdate))}} to {{date('d m, Y',strtotime($tdate))}}</p>
                        <hr>
                    </div>
                    <table id="reporttable" class="table table-bordered table-striped" style="font-size: 15px;">
                        <thead>
                            <tr >
                                <th>Sl</th>
                                <th class="text-center">Date</th>
                                <th class="text-center">Invoice</th>
                                {{-- <th>Vendor/Supplier Name </th>
                                <th>Others Tpye</th> --}}
                                <th>Particular</th>
                                <th class="text-center">Debit</th>
                                <th class="text-center">Credit</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $sl = 0;
                          $td = 0;
                          $tc = 0;
                             @endphp
                            @foreach ($data as $item)

                                @php
                                $sl++;
                          $td += $item->debit;
                          $tc += $item->credit;
                                 @endphp
                                    <tr >
                                        <td class="align-middle">{{ $sl }}</td>
                                        <td class="align-middle text-center"> {{date('d m, Y',strtotime($item->date))}}</td>
                                        <td class="align-middle text-center"> <a href="{{route('journal.entry.view', $item->invoice )}}">{{$item->invoice}}</a></td>
                                       {{--  <td class="align-middle">{{ $item->supplier_name }} {{$item->d_s_name}}</td>
                                        <td class="align-middle"> {{$item->type}}</td> --}}

                                        <td class="align-middle"> {{$item->subject}}</td>
                                        <td class="align-middle text-center"> {{number_format($item->debit,2)}}</td>
                                        <td class="align-middle text-center"> {{number_format($item->credit,2)}}</td>

                                    </tr>

                            @endforeach
                          </tbody>
                      <tfoot>
                                <tr>
                                        <td class="align-middle" colspan="4">Total</td>
                                        <td class="align-middle text-center"> {{number_format($td, 2)}}</td>
                                        <td class="align-middle text-center"> {{number_format($tc, 2)}}</td>

                                    </tr>


                        </tfoot>
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
                    <form action="{{ route('journal.entry.delete') }}" method="POST">
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
                //console.log('hello test');
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
        <script type="text/javascript">
            function printDiv(divName) {
                     var printContents = document.getElementById(divName).innerHTML;
                     var originalContents = document.body.innerHTML;

                     document.body.innerHTML = printContents;

                     window.print();

                     document.body.innerHTML = originalContents;
                }
        </script>

        <script type="text/javascript">
            $(function () {
                $("#btnExport").click(function () {
                    $("#reporttable").table2excel({
                        filename: "Jarnal_report_book.xls"
                    });
                });
            });
        </script>

    @endpush
