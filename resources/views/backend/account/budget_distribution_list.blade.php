@extends('layouts.account_dashboard')
@section('header_menu')
   
@endsection
@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper  accountscontent">


        <!-- Main content -->
        <div class="content px-4 ">
            <div class="container-fluid">
                <div class="text-center pt-3">
                    <h3 class="text-uppercase font-weight-bold">SBMS V.2 - Scan It</h3>
                    <p>Official Conpany Address <br> Road:1200 , House 005, Dhaka- 1202</p>
                    <h6>01712345678 , 86458415</h6>
                    <h5>Budget Distribution List</h5>
                </div>
                <div class="py-4">
                  
                     			<h4>Company Name: {{$budgets->company}}</h4>
                              <h4>Budget Amount: {{$budgets->budget_amount}}</h4>
                              <h4>Budget Year: {{$budgets->budget_year}}</h4>
                  
                    <table id="example1" class="table table-bordered table-striped table-fixed" style="font-size: 15px;">
                        <thead>
                            <tr class="text-center table-header-fixt-top">
                                <th>Sl</th>
                                <th>Month</th>
                                <th>Expanse Subgroup-Group</th>

                                <th>Zone</th>
                                <th>Amount</th>
                                <th>Remaining</th>
                               
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>

                            @foreach ($datas as $data)
                          @php
                          $zones = DB::table('dealer_zones')->where('id',$data->zone_id)->value('zone_title');
                          @endphp
                                <tr>
                                    <td >{{ $loop->iteration }}</td>
                                   <td >{{ $data->month }}</td>
                                   <td >{{ $data->subgroup_name }} - {{$data->group_name}}</td>
                                    <td >{{ $zones }}</td>
                                    <td class="text-right">{{ $data->amount }}</td>
                                    <td class="text-right">{{ $data->remaining_amount }}</td>
                                


                                    <td class="text-center align-middle">
                                       {{-- <a class="btn btn-sm accountsedit"
                                            style="background-color: mediumaquamarine;                                                                                                                                                                                                                                                                    color: white;"
                                            href="" data-toggle="tooltip" data-placement="top" title="CheckOut Invoice"><i
                                                class="fas fa-spinner"></i></a>  --}}
                                       
                                        <a class="btn btn-sm btn-danger accountsdelete" href="" data-toggle="modal" data-target="#delete"
                                                        data-myid="{{ $data->id }}"><i class="far fa-trash-alt"></i>
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
	    <div class="modal fade" id="delete">
        <div class="modal-dialog">
            <div class="modal-content bg-danger">
                <div class="modal-header">
                    <h4 class="modal-title">Delete Confirmation</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('budget.distribution.delete') }}" method="POST">
                    {{ method_field('delete') }}
                    @csrf

                    <div class="modal-body">
                        <p>Are you sure to delete this Asset?</p>

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
