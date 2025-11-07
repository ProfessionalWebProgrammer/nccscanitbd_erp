@extends('layouts.employee_dashboard')
<style media="screen">
.nav-item.hovermanu{
display: none;
}
</style>
@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper salescontent">
        <!-- Main content -->
        <div class="content px-4 ">
            <div class="container-fluid" style="background: #ffffff; padding: 0px 40px;">
              	<div class="row pt-3">
                  	<div class="col-md-12 text-right">
                    </div>
                </div>
                <div class="text-center pt-3">
                    <h3 class="text-uppercase font-weight-bold">Naba Crop Care</h3>
                  <p>Head office, Rajshahi, Bangladesh</p>
                </div>
                <div class="py-4">
                  @if(!empty($requisitionData))
                    <div class="text-center">
                        <h5 class="text-uppercase font-weight-bold">Traking Result</h5>
                        <h5 class="text-uppercase font-weight-bold">Purchase Requisition No: {{$invoice}}</h5>
                        <hr>
                    </div>
                    <div class="my-3">
                      @php
                      $rfqData = \App\Models\Rfq::where('pr_no',$invoice)->first();
                      $csData = \App\Models\Cs::where('pr_no',$invoice)->first();
                      $poData = DB::table('purchase_order_creates')->where('pr_no',$invoice)->first();

                      @endphp
                    </div>
                    <table class="table table-bordered table-striped" style="font-size: 15px;">
                        <thead>
                            <tr class="text-center table-header-fixt-top">
                              @if(!empty($requisitionData))
                                <th>Date</th>
                                <th>Status</th>
                                <th>Remarks</th>
                                @endif
                              @if(!empty($rfqData))
                                <th>Date</th>
                                <th>Status</th>
                                <th>Remarks</th>
                                @if(!empty($csData))
                                  <th>Date</th>
                                  <th>Status</th>
                                  <th>Remarks</th>

                                  @if(!empty($poData))
                                    <th>Date</th>
                                    <th>Status</th>
                                    <th>Remarks</th>
                                    @else
                                    <th style="background: #0f3866;">P.O Status</th>
                                    @endif
                                  @else
                                  <th style="background: #0f3866;">C.S Status</th>
                                  @endif

                                @else
                                <th style="background: #0f3866;">Status</th>
                                @endif


                            </tr>
                        </thead>
                        <tbody>
                          <tr>
                            @if(!empty($requisitionData))
                            <td align="center">{{date("d-m-Y", strtotime($requisitionData->created_at))}} </td>
                            <td>Purchase Requisition</td>
                            <td>@if($requisitionData->status == 3) <span class="text-success">  <i class="fa fa-check-circle" aria-hidden="true"></i> Done </span> @elseif($requisitionData->status == 4)  <span class="text-danger"><i class="fa fa-times" aria-hidden="true"></i> Rejected </span> @else <span class="text-info"><i class="fas fa-thumbtack"></i> Pending </span> @endif </td>
                            @endif
                            @if(!empty($rfqData))
                            <td align="center">{{date("d-m-Y", strtotime($rfqData->created_at))}} </td>
                            <td>RFQ</td>
                            <td> <span class="text-success"> <i class="fa fa-check-circle" aria-hidden="true"></i> Done </span> </td>
                            @if(!empty($csData))
                            <td align="center">{{date("d-m-Y", strtotime($csData->created_at))}} </td>
                            <td>C.S</td>
                            <td> <span class="text-success"> <i class="fa fa-check-circle" aria-hidden="true"></i> Done </span> </td>
                            @if(!empty($poData))
                            <td align="center">{{date("d-m-Y", strtotime($poData->created_at))}} </td>
                            <td>P.O</td>
                            <td> <span class="text-success"> <i class="fa fa-check-circle" aria-hidden="true"></i> Done </span> </td>
                            @else
                            <td><span class="text-info"><i class="fas fa-thumbtack"></i> Waiting For P.O.</span></td>
                            @endif
                            @else
                            <td><span class="text-info"><i class="fas fa-thumbtack"></i> Waiting For C.S.</span></td>
                            @endif
                            @else
                            <td ><span class="text-warning"><i class="fas fa-thumbtack"></i> No Step Taking Againest this Invoice: <strong style="color:#333;">{{$invoice}}</strong></span></td>
                            @endif


                          </tr>
                        </tbody>
                    </table>
                    @else
                    <h4>Data Not Found</h4>
                    @endif
                </div>
            </div>
        </div>
    </div>

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
