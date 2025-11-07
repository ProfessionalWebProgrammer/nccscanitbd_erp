@extends('layouts.purchase_deshboard')

@section('header_menu')
<li class="nav-item d-none d-sm-inline-block">
    
</li>
@endsection


@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper purchasecontent">
        <!-- Main content -->
        <div class="content px-4 ">
            <div class="container-fluid" style="background:#ffffff; padding:0px 40px;min-height:85vh">
              <div class="row pt-3">
                  	<div class="col-md-12 text-right">
                      	<a href="{{ URL('/supplier/group/create') }}" class=" btn btn-success btn-sm">Create Supplier Group</a>                     
                    </div>
                </div>
                <div class="text-center pt-3">
                    <h3 class="text-uppercase font-weight-bold">SBMS V.2 - Scan It</h3>
                    <p>Official Conpany Address <br> Road:1200 , House 005, Dhaka- 1202</p>
                    <h6>01712345678 , 86458415</h6>
                </div>
                <div class="py-4">
                    <div class="text-center">
                        <h5 class="text-uppercase font-weight-bold">Supplier Group List</h5>
                        <hr>
                    </div>
                    <table id="example1" class="table table-bordered table-striped" style="font-size: 15px;">
                        <thead>
                            <tr class="text-center table-header-fixt-top">
                                <th>SI. No</th>
                                <th>Group Name</th>
                                <th>Propreitor Name</th>
                                <th>Phone</th>
                                <th>Opening Balance</th>
                                <th width="10%">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $sl = 0;
                            @endphp

                            @foreach ($suppliergroups as $item)
                                
                            
                           
                                @php
                                    $sl++;

                                    $openingbalance  = DB::table('suppliers')->where('group_id',$item->id)->sum('opening_balance');
                                @endphp
                                <tr>
                                    <td class="align-middle">{{ $sl }}</td>
                                    <td>{{$item->group_name}} </td>
                                    <td>{{$item->proprietor_name}} </td>
                                    <td> {{$item->phone}} </td>
                                    <td> {{$openingbalance}} </td>
                                    <td class="text-center align-middle">
                                        <a class="btn btn-xs purchaseedit" style="background-color: #66BB6A" href="{{URL::to('/supplier/group/edit/'.$item->id)}}"
                                            data-toggle="tooltip" data-placement="top" title="Return"><i
                                                class="fas fa-edit"></i> </a>
                                        <a class="btn btn-xs btn-danger purchasedelete" href="" data-toggle="modal" data-target="#delete"
                                                        data-myid="{{ $item->id }}"><i class="far fa-trash-alt"></i>
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
                    <form action="{{route('supplier.group.delete')}}" method="POST">
                        {{ method_field('delete') }}
                        @csrf

                        <div class="modal-body">
                            <p>Are you sure to delete this Supplier Group?</p>

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
