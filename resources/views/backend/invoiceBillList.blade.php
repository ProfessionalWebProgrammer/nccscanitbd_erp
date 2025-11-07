@extends('layouts.settings_dashboard')
@section('print_menu')
			<li class="nav-item">
                    <a  href="{{route('invoiceBillCreate')}}" class="btn btn-sm  btn-success mt-1" >
                       Create Invoice
                    </a>
                </li>
			
@endsection
@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">


        <!-- Main content -->
        <div class="content px-4 ">
            <div class="container-fluid">
                <div class="text-center pt-3">
                    <h3 class="text-uppercase font-weight-bold">SBMS V.2 - Scan It</h3>
                    <p>Official Conpany Address <br> Road:1200 , House 005, Dhaka- 1202</p>
                    <h6>01712345678 , 86458415</h6>
                    <h5>Notification Archive List</h5>
                </div>
                <div class="py-4">
                    <table id="example1" class="table table-bordered table-striped table-fixed" style="font-size: 15px;">
                        <thead>
                            <tr class="text-center table-header-fixt-top">
                                <th>Sl</th>
                                <th>Invoice To</th>
                                <th>Item 1</th>
                                <th>Item 2</th>
                                <th>Amount</th>
                                <th>Advance</th>
                                <th>Status</th>
								<th>Action</th>
                            </tr>
                        </thead>
                        <tbody style="font-size: 18px;">
						@php
                          $si = 1
                          @endphp
                            @foreach ($invoices as $val)

                                <tr>
                                    <td>{{$si++}}</td>
                                    <td>{{$val->t_company}}</td>
                                    <td>{{$val->p_name1}}</td>
                                    <td>{{$val->p_name2}}</td>
                                    <td>{{$val->pay_total_bill}}</td>
                                  	<td>{{$val->pay_advn_amount}}</td>
                                    <td>
                                      @if($val->status == 1)
                                      <span class="btn btn-sm btn-primary">Active</span>
                                      @else 
                                      <span class="btn btn-sm btn-danger">Inactive</span>
                                      @endif 
                                    </td>
                                    <td>
                                      <a class="btn btn-sm mb-1 salesedit"
                                            style="background-color: mediumaquamarine;                                                                                                                                                                                                                                                                    color: white;"
                                            href="{{route('invoiceBillEdit',$val->id)}}"
                                            data-toggle="tooltip" data-placement="top" title="Edit Invoice Bill"><i
                                                class="fas fa-edit"></i></a>
                                  	<a class="btn btn-sm btn-primary " href="{{route('invoiceBillView',$val->id)}}" data-toggle="tooltip"
                                            data-placement="top" title="View Invoice Bill"><i class="far fa-eye"></i> </a>
                                      
                                            <a class="btn btn-sm btn-danger salesdelete" href="" data-toggle="modal" data-target="#delete"
                                            data-myid="{{ $val->id }}"><i class="far fa-trash-alt"></i>
                                   </td>
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
                <form action="{{ route('invoiceBillDelete') }}" method="POST">
                    {{ method_field('delete') }}
                    @csrf

                    <div class="modal-body">
                        <p>Are you sure to delete this?</p>

                        <input type="hidden" id="mid" name="id">
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
            //console.log(id);
            var modal = $(this)

            modal.find('.modal-body #mid').val(id);
        })
    </script>

@endpush
