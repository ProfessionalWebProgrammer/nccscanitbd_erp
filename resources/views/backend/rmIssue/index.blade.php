@extends('layouts.purchase_deshboard')


@push('addcss')
<style>
    .tableFixHead          { overflow: auto; height: 600px; }
    .tableFixHead thead th { position: sticky; top: 0; z-index: 1; }
</style>

@endpush

@section('header_menu')

@endsection


@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper purchasecontent">

        <!-- Main content -->
        <div class="content px-4 ">
            <div class="container-fluid" style="background:#ffffff; padding:0px 40px;min-height:85vh;min-width: 100% !important;">
              <div class="row pt-3">
				<div class="col-md-12 text-right">
                      	<a href="{{route('row.materials.issuesCreate')}}" class=" btn btn-success mr-2">Entry Stock Out Issue</a>
                    </div>
                </div>
                <div class="text-center pt-3">
                    <h3 class="text-uppercase font-weight-bold">Naba Crop Care</h3>
                  		<p>Head office, Rajshahi, Bangladesh</p>
                    <h5>Stock Out Issue List</h5>
                </div>
                <div class="py-4 table-responsive ">
                    <table id="example1" class="table table-bordered table-striped" style="font-size: 15px;">
                        <thead>
                            <tr class="text-center table-header-fixt-top">
                                <th>No</th>
                                <th>Date</th>
                              	<th>Supplier Name</th>
                              	<th>Factory Name</th>
                                <th>Product Name</th>
                                <th>Stock Out Qty (Kg)</th>
                                <th>Issued By</th>
                                <th>Note</th>                          	
                                 <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
								 @foreach($data as $val)
                         		
                                <tr>
                                    <td class="tdNo">{{ $loop->iteration }}</td>
                                    <td class="tdDate">{{ date("d-m-Y ", strtotime($val->date)) }} </td>
                                    <td class="tdSupplierName">{{$val->supplier_name}}</td>
                                    <td class="tdSupplierName">{{$val->factory_name}}</td>
                                   <td class="tdProductName text-center">{{$val->product_name}} </td>
                                    <td class="tdProductName text-center">{{$val->qty}} </td>
                                    <td class="tdProductName">{{$val->issued_by}}</td>
                                	<td class="tdProductName">{{$val->note}}</td>
                                   
                                    <td align="center">
                                        
                                      <a class="btn btn-xs btn-primary "
                                            href="{{route('row.materials.issues.view', $val->id)}}"
                                            data-toggle="tooltip" data-placement="top" title="View Invoice"><i
                                                class="far fa-eye"></i> </a>
                                   
                                        <a data-toggle="modal" data-target="#delete"data-myid="{{$val->id}}"
                                            class="btn btn-xs btn-danger purchasedelete"><span class="fa fa-trash"></span></a>

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
                <form action="{{ route('row.materials.issuesDelete') }}" method="POST">
                    {{ method_field('delete') }}
                    @csrf

                    <div class="modal-body">
                        <p>Are you sure to delete this?</p>

                        <input type="hidden" id="mid" name="id" value="">
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
           // console.log('hello test');
            var button = $(event.relatedTarget)
            //var title = button.data('mytitle')
            var id = button.data('myid')

            var modal = $(this)

            modal.find('.modal-body #mid').val(id);
        })
    </script>

@endpush
