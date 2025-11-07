@extends('layouts.account_dashboard')



@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper accountscontent">


        <!-- Main content -->
        <div class="content px-4 ">
           <div class="container" style="background:#f5f5f5; padding:0px 40px;min-height:85vh;min-width: 100%;">
             <div class="row pt-3">
                      <div class="col-md-12 text-left">
                      <a href="{{ URL('/expanse/payment/create') }}" class=" btn btn-success mr-2">Create Expence  Payment</a>
                      <a href="{{ URL('/expasne/report/index') }}" class=" btn btn-success mr-2"> Expence  Report</a>
                      <a href="{{ URL('/expanse/index') }}" class=" btn btn-success mr-2"> Expence  Groups List/Create</a>
                      <a href="{{ route('expanse.set_margin.index') }}" class=" btn btn-success mr-2"> Expence Set Margin</a>
                      <a href="{{ route('expanse.type.create') }}" class=" btn btn-success mr-2"> Expence Type</a>
 					 <a href="{{ route('expanse.SubSubGroup.create') }}" class=" btn btn-success mr-2"> Expence Sub Ledger Create</a>

        	            </div>

                  </div>
                <div class="text-center pt-3">
                    <h3 class="text-uppercase font-weight-bold">Naba Crop Care</h3>
                    <p>Head office, Rajshahi, Bangladesh</p>
                </div>
                <div>
                    <div class="text-center">
                        <h5 class="text-uppercase font-weight-bold">Expence Payment List</h5>
                        <hr>
                    </div>
                    <form action="{{ route('expanse.payment.index') }}" method="get">
                        <div class="row pb-4">
                                <div class="col-md-4 "></div>
                                <div class="col-md-8 input-group rounded">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="">Date</span>
                                    </div>
                                    <input type="text" name="date" class="form-control float-right"
                                        id="daterangepicker" value="{{$date}}">
                                    <div class="input-group-prepend  pr-2">

                                    </div>
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="">Invoice</span>
                                    </div>
                                    <input type="text" name="invoice" value="{{$invoice}}" class="form-control float-right"
                                        >

                                    <div class="input-group-prepend  pr-2">

                                    </div>
                                    <div class="input-group-prepend pr-2">
                                        <button type="submit" class="btn btn-sm btn-success"><i class="fas fa-search"></i>
                                            Search</button>
                                    </div>

                                    <div class="input-group-prepend pr-2">
                                        <a href="{{ route('expanse.payment.index') }}" class="btn btn-sm btn-danger"><i class="far fa-times-circle"></i>
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
                            <tr class="text-center">
                                <th>Sl</th>
                                <th>User</th>
                                <th>Ledger</th>
                                <th>Date</th>
                                <th>Amount</th>
                            </tr>
                        </thead>
                        <tbody>
                          <tr>
                                        <td class="align-middle">1</td>
                                        <td class="text-center align-middle">Admin - 31-01-2023</td>
                            			<td>Admnistrative Expenses</td>
                            			<td>31-01-2023</td>
                            			<td>3,686,308/-</td>
                            			
                            </tr>
                          <tr>
                                        <td class="align-middle">2</td>
                                        <td class="text-center align-middle">Admin - 31-01-2023</td>
                            			<td>Marketing Expenses</td>
                            			<td>31-01-2023</td>
                            			<td>359,015/-</td>
                            			
                            </tr>
                          <tr>
                                        <td class="align-middle">3</td>
                                        <td class="text-center align-middle">Admin - 31-01-2023</td>
                            			<td>Field Force Expenses</td>
                            			<td>31-01-2023</td>
                            			<td>2,361,237/-</td>
                            			
                            </tr>
                          <tr>
                                        <td class="align-middle">4</td>
                                        <td class="text-center align-middle">Admin - 31-01-2023</td>
                            			<td>Distribution Expenses</td>
                            			<td>31-01-2023</td>
                            			<td>576,229/-</td>
                            			
                            </tr>
                          <tr>
                                        <td class="align-middle" colspan="4">Grand Total :</td>
                                        
                            			<td>6,982,789/-</td>
                            			
                            </tr>
                          {{--  @php
                                $sl = 0;
                             @endphp
                            @foreach ($data as $item)

                                @php
                                $sl++;
                                $username = DB::table('users')->where('id',$item->created_by)->value('name');
                                $group = DB::table('expanse_groups')->where('id',$item->expanse_type_id)->value('group_name');
                                $subgroup = DB::table('expanse_subgroups')->where('id',$item->expanse_subgroup_id)->value('subgroup_name');
                                $subSubgroup = DB::table('expanse_sub_subgroups')->where('id',$item->expanse_subSubgroup_id)->value('subSubgroup_name');
                                @endphp
                                    <tr>
                                        <td class="align-middle">{{ $sl }}</td>
                                        <td class="text-center align-middle">{{$username}} <br> {{$item->created_at}}
                                        </td>
                                        <td class="align-middle">{{$item->bank_name}} {{$item->wirehouse_name}}</td>
                                        <td class="align-middle">{{$group}}</td>
                                        <td class="align-middle">{{$subgroup}}</td>
                                        <td class="align-middle">{{$subSubgroup}}</td>
                                        <td class="align-middle">{{$item->payment_date}}</td>
                                        <td class="text-center align-middle">{{$item->invoice}}</td>
                                        <td class="text-center align-middle">{{$item->expanse_rate}}</td>
                                        <td class="text-center align-middle">{{$item->expanse_qntty}}</td>

                                        <td class="text-right align-middle"> {{number_format($item->amount, 2)}}/-</td>
                                        <td class="text-center align-middle">
                                            <a class="btn btn-sm text-light accountsedit" style="background-color: #66BB6A" href="{{route('expanse.payment.edit',$item->id)}}"
                                                data-toggle="tooltip" data-placement="top" title="Edit"><i
                                                    class="fas fa-edit"></i> </a>
                                          <a class="btn btn-sm btn-danger accountsdelete" href="" data-myid="{{ $item->id }}"
                                                        data-mytitle="" data-toggle="modal" data-target="#delete"><i
                                                            class="far fa-trash-alt"></i>
                                                </td>
                                    </tr>

                            @endforeach

--}}

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




<!-- /.Modal -->
<div class="modal fade" id="salesOvermarginlimite">
        <div class="modal-dialog">
          <div class="modal-content bg-danger" >
            <div class="modal-header">
              <h4 class="modal-title">Expanse Limite Over</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body ">

               <p>Expanse Limit is Over Today </p>
            </div>
            <div class="modal-footer justify-content-between">
                <p  ></p>
              <button type="button" class="btn btn-primary"data-dismiss="modal">Close</button>
            </div>
          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
      </div>








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
