@extends('layouts.account_dashboard')



@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper accountscontent">


        <!-- Main content -->
        <div class="content px-4 ">
           <div class="container" style="background:#f5f5f5; padding:0px 40px;min-height:85vh;min-width: 100%;">
             <div class="row pt-3">
                      <div class="col-md-12 text-left">
                      <a href="{{ URL('/expanse/payment/create') }}" class=" btn btn-sm btn-success mr-2">Create Expence  Payment</a>
                      <a href="{{ URL('/expasne/report/index') }}" class=" btn btn-sm btn-success mr-2"> Expence  Report</a>
                      <a href="{{ URL('/expanse/index') }}" class=" btn btn-sm btn-success mr-2"> Expence  Groups List/Create</a>
                      <a href="{{ route('expanse.set_margin.index') }}" class=" btn btn-sm btn-success mr-2"> Expence Set Margin</a>
 					 <a href="{{ route('expanse.SubSubGroup.create') }}" class=" btn btn-sm btn-success mr-2"> Expence Sub Ledger Create</a>
        	         </div>

                  </div>
                <div class="text-center pt-3">
                    <h3 class="text-uppercase font-weight-bold">Naba Crop Care</h3>
                    <p>Head office, Rajshahi, Bangladesh</p>
                </div>
                <div>
                    <div class="text-center">
                        <h5 class="text-uppercase font-weight-bold">Chart Of Account List</h5>
                        <hr>
                    </div>
                    
                    <table id="datatable" class="table table-bordered table-striped" style="font-size: 15px;">
                        <thead>
                            <tr class="text-center">
                                <th>Sl</th>
                                <th>Group Name</th>
                                <th>Ledger</th>
                                <th>Sub Ledger</th>
                            </tr>
                        </thead>
                        <tbody>
                          @php 
                          $i = 0;
                          @endphp 
                            @foreach ($data as $item)

                                @php
                               $i++;
                                $sl = 0;
                                $expLadgers = DB::table('expanse_subgroups')->where('group_id',$item->id)->get();
      
                                @endphp
                                    <tr>
                                        <td class="align-middle">{{ $i}}</td>
                                        <td class="align-middle">{{$item->group_name}}</td>
                                        <td class="align-middle"></td>
                                        <td class="align-middle"></td>
                                    </tr>
                          		@foreach ($expLadgers as $item)
                          				@php 
                          					$sl++;
                          					$expSubLadgers = DB::table('expanse_sub_subgroups')->where('subgroup_id',$item->id)->get();
                          					$ssL = 0;
                          				@endphp 
									<tr>
                                        <td class="align-middle"></td>
                                        <td class="align-middle text-right">{{$sl}}</td>
                                        <td class="align-middle">{{$item->subgroup_name}}</td>
                                        <td class="align-middle"></td>
                                    </tr>
                          				@foreach ($expSubLadgers as $item)
                          				@php 
                          					$ssL++;
                          				@endphp 
                                        <tr>
                                            <td class="align-middle"></td>
                                            <td class="align-middle"></td>
                                            <td class="align-middle text-right">{{$ssL}}</td>
                                            <td class="align-middle">{{$item->subSubgroup_name}}</td>
                                        </tr>
                          
                            		@endforeach
                            	@endforeach
                           @endforeach



                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

        <!-- /.modal -->

      {{--   <div class="modal fade" id="delete">
            <div class="modal-dialog">
                <div class="modal-content bg-danger">
                    <div class="modal-header">
                        <h4 class="modal-title">Delete Confirmation</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action="{{ route('expanse.payment.delete') }}" method="POST">
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
  --}}
        <!-- /.modal -->



@php
  $saleslimit = DB::table('margins')->where('head',"Expanse")->first();
  if($saleslimit != null){
   $salesamount = $saleslimit->amount;
  }else{
   $salesamount = 0;
  }


  $thisdate = date('Y-m-d');

  $totalsaleamout = DB::table('payments')->where('payment_date',$thisdate)->where('status',1)->sum('amount');

@endphp

  @if($salesamount < $totalsaleamout  && $salesamount != 0)
    <input type="hidden" id="saleslimitmargin" class="form-control" value="1">

  @else
  <input type="hidden" id="saleslimitmargin" class="form-control" value="0">
  @endif


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


            $(document).ready(function() {

                var limitval = $('#saleslimitmargin').val();

                if(limitval == 1){
                    $('#salesOvermarginlimite').modal('show');
                }

              });





        </script>



    @endpush
