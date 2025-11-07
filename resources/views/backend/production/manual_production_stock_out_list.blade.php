@extends('layouts.purchase_deshboard')

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper purchasecontent">


        <!-- Main content -->
        <div class="content px-4 ">
            <div class="container-fluid" style="background:#ffffff; padding:0px 40px;min-height:85vh">
              <div class="row">
                      <div class="col-md-12 text-right pt-3">
                          <a href="{{route('production.process.loss.list')}}" class="btn btn-sm btn-danger">Production Process Loss</a>
                          <a href="{{route('wpf.list')}}" class="btn btn-sm btn-primary">Weekly Production Forcasting</a>
                          <a href="{{route('production.fg.set.list')}}" class="btn btn-sm btn-success">Finised Good Set</a>
                          <a href="{{route('auto.production.stock.out.create')}}" class="btn btn-sm btn-warning">Autometic Production </a>
                         <a href="{{route('production.stock.out.create')}}" class="btn btn-sm btn-success">Production Create</a>
                          <a href="{{route('production.packing.consumption.list')}}" class="btn btn-sm btn-primary">Packing Consumption</a>
                      </div>
                  </div>
                <div class="text-center pt-3">
                    <h3 class="text-uppercase font-weight-bold">Naba Crop Care</h3>
                  <p>Head office, Rajshahi, Bangladesh</p>
                </div>
                
                <div class="py-4 table-responsive">
                  <div class="text-center pt-3">
                    <h5 class="text-uppercase font-weight-bold">Finish Goods Stock In List</h5>
                 </div>
                    <table id="example3" class="table table-bordered table-striped table-fixed"
                        style="font-size: 15px;table-layout: inherit;">
                        <thead>
                            <tr class="table-header-fixt-top">
                              <th>No</th>
                              <th>Invoice No</th>
                              <th>Date</th>
                              <th>Finished Goods</th>
                               <th>Qty</th>
                              <th>Wirehouse Name</th>
                              <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($finishGoods as $key=>$data)
                              <tr>
                                <td>{{++$key}}</td>
                                <td>PJV-{{$data->sout_number}}</td>
                                <td>{{$data->date}}</td>
                                <td>{{$data->product_name}}</td>
                                <td>{{$data->quantity }}</td>
                                <td>{{$data->wirehouse_name}}</td>

                                <td>
                                  
                               {{--  
                                 <a href="{{route('production.stock.out.checkout',$data->sout_number)}}" class="btn btn-xs btn-info purchaseedit">Checkout Invoice</span></a>
                                   <a href="#" class="btn btn-xs btn-danger purchasedelete" data-myid="{{ $data->sout_number }}"
                                    data-mytitle="" data-toggle="modal" data-target="#delete"
                                    style="margin-bottom:2px"><i class="ti-trash"></i>Delete</a> --}}
                              		<a href="{{route('production.manual.stock.in.invoice.view',$data->sout_number)}}" class="btn btn-xs btn-success"><i class="far fa-eye"></i></a>
                  					<a href="{{route('production.fgStock.in.edit',$data->sout_number)}}" class="btn btn-xs btn-primary"><i class="far fa-edit"></i></a>
                   				 <a href="{{route('production.fgStock.in.delete',$data->id)}}" target="_blank" class="btn btn-xs btn-danger purchasedelete"><i class="far fa-trash-alt"></i></a>
                                </td>
                          </tr>
                            @endforeach

                            </tbody>

                    </table>
					
					<div class="text-center pt-3">
                    <h5 class="text-uppercase font-weight-bold">Production Stock Out List</h5>
                 </div>
                    <table id="example1" class="table table-bordered table-striped table-fixed"
                        style="font-size: 15px;table-layout: inherit;">
                        <thead>
                            <tr class="table-header-fixt-top">
                              <th>No</th>
                              <th>Invoice No</th>
                              <th>Date</th>
                              <th>Product Name</th>
                               <th>Qty</th>
                              <th>Wirehouse Name</th>
                              <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($rawMaterials as $key=>$data)
                              <tr>
                                <td>{{++$key}}</td>
                                <td>PJV-{{$data->sout_number}}</td>
                                <td>{{$data->date}}</td>
                                <td>{{$data->product_name}}</td>
                                <td>{{$data->qty }}</td>
                                <td>{{$data->wirehouse_name}}</td>

                                <td>
                                 {{-- <a href="{{route('production.manual.stock.in.invoice.view',[$data->sout_number])}}" class="btn btn-xs btn-primary">Invoice View</span></a>
                                 <a href="{{route('production.stock.out.checkout',$data->sout_number)}}" class="btn btn-xs btn-info purchaseedit">Checkout Invoice</span></a>
                                   <a href="#" class="btn btn-xs btn-danger purchasedelete" data-myid="{{ $data->sout_number }}"
                                    data-mytitle="" data-toggle="modal" data-target="#delete"
                                    style="margin-bottom:2px"><i class="ti-trash"></i>Delete</a> --}}
                   				 <a href="{{route('production.rmStock.out.delete',$data->id)}}" target="_blank" class="btn btn-xs btn-danger purchasedelete"><i class="ti-trash"></i>Delete</a>
                                </td>
                          </tr>
                            @endforeach

                            </tbody>

                    </table>

                </div>
            </div>
        </div>
    </div>



@endsection


@push('end_js')

<script>
    $(function() {
        $('[data-toggle="tooltip"]').tooltip()
    })


    $('#delete').on('show.bs.modal', function(event) {
       // console.log('hello test');
        var button = $(event.relatedTarget);
        var id = button.data('myid');

        var modal = $(this);

        modal.find('.modal-body #minvoice').val(id);
    })
</script>

@endpush
