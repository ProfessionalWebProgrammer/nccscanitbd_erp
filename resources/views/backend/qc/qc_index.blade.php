@extends('layouts.purchase_deshboard')

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper purchasecontent">
        <!-- Main content -->
        <div class="content px-4 ">
            <div class="container-fluid" style="background:#ffffff; padding:0px 40px;min-height:85vh">
              <div class="row pt-3">
                  	<div class="col-md-12 text-right">
                      	<a href="{{ route('qc.parameter.create') }}" class=" btn btn-success mr-2">Q C Parameter</a>
                      	<a href="{{ route('qualityControl.create') }}" class=" btn btn-success mr-2">Create Q C</a>
                    </div>
                </div>

                <div class="text-center pt-3">
                    <h3 class="text-uppercase font-weight-bold">Naba Crop Care</h3>
		                  <p>Head office, Rajshahi, Bangladesh</p>
                </div>
                <div class="py-4">
                    <div class="text-center">
                        <h5 class="text-uppercase font-weight-bold">Quality Controls List</h5>
                        <hr>
                    </div>
                    <table id="example3" class="table table-bordered table-striped" style="font-size: 15px;">
                        <thead>
                            <tr class="text-center table-header-fixt-top">
                                <th style="width:42px;">SI.No</th>
                                <th>Chalan No</th>
                                <th>Supplier Name</th>
                                <th>Product Name</th>
                                <th>Product Qty</th>
                                <th>Status</th>
                                <th>Remarks</th>
                                <th style="width:58px;">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $sl = 0;
                            @endphp

                            @foreach ($qcontrolls as $val)
                                @php
                                    $sl++;
                                    $supplier = DB::table('suppliers')->where('id',$val->supplier_id)->value('supplier_name');
                                    $pName = DB::table('row_materials_products')->where('id',$val->product_id)->value('product_name');
                                @endphp
                                <tr>
                                    <td class="align-middle">{{ $sl }}</td>
                                    <td>{{$val->chalan_no}} </td>
                                    <td>{{$supplier}} </td>
                                    <td>{{$pName}} </td>
                                    <td> {{$val->qty}} </td>
                                    
                                  <td> @if($val->status == 1) <span class="badge btn-sm badge-success p-1 pb-2">Accept</span> @else <span class="badge btn-sm badge-danger p-1 pb-2">Rejected</span> @endif</td>
                                    <td> {{$val->remarks}} </td>
                                    <td class="text-center align-middle">
                                         <a class="btn btn-xs purchaseedit" style="background-color: #66BB6A" href="{{route('qualityControl.edit',$val->id)}}"
                                            data-toggle="tooltip" data-placement="top" title="Return"><i
                                                class="fas fa-edit"></i> </a>
                                      <a href="{{route('qualityControl.view',$val->id)}}" class="btn btn-primary btn-xs"><span
                                                class="fa fa-eye"></span></a>
                                        <a class="btn btn-xs btn-danger purchasedelete" href="" data-toggle="modal" data-target="#delete"
                                                        data-myid="{{ $val->id }}"><i class="far fa-trash-alt"></i>
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
                    <form action="{{route('qualityControl.delete')}}" method="POST">
                        {{ method_field('delete') }}
                        @csrf

                        <div class="modal-body">
                            <p>Are you sure to delete this Quality Control Parameter?</p>

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
    @push('end_js')

        <script>
            $(function() {
                $('[data-toggle="tooltip"]').tooltip()
            })
            $('#delete').on('show.bs.modal', function(event) {
                //console.log('hello test');
                var button = $(event.relatedTarget)
                var id = button.data('myid')

                var modal = $(this)

                modal.find('.modal-body #mid').val(id);
            })
        </script>

    @endpush
@endsection
