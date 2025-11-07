@extends('layouts.purchase_deshboard')

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper purchasecontent">


        <!-- Main content -->
        <div class="content px-4 ">
            <div class="container-fluid" style="background:#ffffff; padding:0px 40px;min-height:85vh">
              <div class="row">
                      <div class="col-md-12 text-right pt-3">
                          <a href="{{route('production.fg.set.create')}}" class="btn btn-sm btn-success">Finished Good Set Entry</a>
                       </div>
                  </div>
                <div class="text-center pt-3">
                    <h3 class="text-uppercase font-weight-bold">Naba Crop Care</h3>
                  <p>Head office, Rajshahi, Bangladesh</p>
                </div>
                <div class="text-center pt-3">
                    <h5 class="text-uppercase font-weight-bold">Finished Goods List</h5>


                </div>
                <div class="py-4 table-responsive">
                    <table id="example3" class="table table-bordered table-striped table-fixed"
                        style="font-size: 15px;table-layout: inherit;">
                        <thead>
                            <tr class="table-header-fixt-top">
                              <th>No</th>
                              <th>Finished Good Name</th>
                              <th>Finished Good Qty</th>

                              <th>Row Materials</th>

                               <th width="250px">Action</th>
                            </tr>
                            </thead>
                            <tbody>
                           @foreach($data as $key=>$ddd)
                              <tr>
                                <td>{{++$key}}</td>
                                <td>{{$ddd->fg_name}}</td>
                                <td>{{$ddd->fg_qty}}</td>
                                <td align="right">
                                @php
                                  $rmdata = DB::table('finished_good_sets')
                                  				->select('finished_good_sets.*','row_materials_products.product_name')
                                  				->leftjoin('row_materials_products','row_materials_products.id','finished_good_sets.rm_id')
                                  				->where('invoice',$ddd->invoice)->get();
                                 // dd($rmdata);
                                @endphp
                                  @foreach($rmdata as $key=>$rmd)
                                  {{$rmd->product_name}} - {{$rmd->rm_qty}} <br>
                                   @endforeach
                                </td>


                                <td>
                               {{--  <a href="{{route('production.stock.out.invoice.view',$data->sout_number)}}" class="btn btn-xs btn-primary">Invoice View</span></a> --}}
                                 <a href="{{route('production.fg.set.edit',$ddd->fg_id)}}" class="btn btn-xs btn-info purchaseedit">Edit</span></a>  
                                 <a href="#" class="btn btn-xs btn-danger purchasedelete" data-myid="{{$ddd->invoice}}"
                                    data-mytitle="" data-toggle="modal" data-target="#delete"
                                    style="margin-bottom:2px"><i class="ti-trash"></i>Delete</a>  
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
            <form action="{{ route('production.fg.set.delete') }}" method="POST">
                {{ method_field('delete') }}
                @csrf

                <div class="modal-body">
                    <p>Are you sure to delete this Item?</p>

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

        modal.find('.modal-body #minvoice').val(id);
    })
</script>

@endpush
