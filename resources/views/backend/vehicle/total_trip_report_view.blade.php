@extends('layouts.settings_dashboard')
@section('print_menu')

			<li class="nav-item">
                    <button class="btn btn-sm  btn-success mt-1" id="btnExport"  >
                       Export
                    </button>
                </li>
			<li class="nav-item ml-1">
                    <button class="btn btn-sm  btn-warning mt-1"  onclick="printDiv('contentbody')"  id="printbtn"  >
                       Print
                    </button>
                </li>

@endsection

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper salescontent" id="contentbody">


        <!-- Main content -->
        <div class="content px-4 ">
            <div class="container-fluid">
                <div class="text-center pt-3">
                    <h3 class="text-uppercase font-weight-bold">Naba Crop Care</h3>
		                  <p>Head office, Rajshahi, Bangladesh</p>
                    <h5>Total Trip  Report</h5>
                   <h6>From {{ date('d F Y', strtotime($fdate)) }}
                        To
                        {{ date('d F Y', strtotime($tdate)) }}</h6>

                    <hr>

                </div>
                <div class="py-4 table-responsive">
                    <table id="datatablecustom" class="table table-bordered table-striped table-fixed" style="font-size: 15px;">
                        <thead>
                            <tr class="text-center table-header-fixt-top">
                                <th>Sl</th>
                                <th>Date</th>
                                <th>Invoice</th>
                                <th>Driver Name</th>
                                <th>Vehicle</th>
                                <th>Note</th>
                                <th>Income Amount</th>
                            </tr>
                        </thead>
                        <tbody style="font-size: 18px;">
							@php
                          		$total = 0;
                          	@endphp
                           @foreach ($trips as $date)
                          		@php
                          			$total += $date->trip_value;
                          		@endphp
                          	  <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $date->date }} </td>
                                    <td>{{ $date->invoice }} </td>
                                    <td>{{ $date->driver_name }} </td>
                                    <td>{{ $date->vehicle_number }} </td>
                                    <td>{{ $date->note }} </td>
                                    <td class="text-right">{{ number_format($date->trip_value) }} </td>
                                </tr>
                            @endforeach
                          <tr>
                              <th colspan="6">Total</th>
                              <th class="text-right"> {{number_format($total)}}</th>
                             <tr>
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
                <form action="{{ route('trip.delete') }}" method="POST">
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
            $("#datatablecustom").table2excel({
                filename: "TotalTripReport.xls"
            });
        });
    });

</script>

@endpush
