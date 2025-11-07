@extends('layouts.sales_dashboard')

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper salescontent">


        <!-- Main content -->
        <div class="content px-4 ">
            <div class="container-fluid" style="background:#ffffff; padding:0px 40px; min-height:85vh;">
              <div class="row pt-3">
                  	<div class="col-md-12 text-right">
                      	 <a href="{{ route('sales.damage.create') }}" class=" btn btn-sm btn-success mr-2">Damage Entry</a>

                    </div>
                </div>
                <div class="text-center pt-3">
                    <h3 class="text-uppercase font-weight-bold">Naba Crop Care</h3>
                  <p>Head office, Rajshahi, Bangladesh</p>
                    <h5>Damage List</h5>
                </div>
                <div class="py-4">
                    <table id="example3" class="table table-bordered table-striped table-fixed" style="font-size: 15px;">
                        <thead>
                            <tr class="text-center table-header-fixt-top">
                                <th>Sl</th>
                                <th> Date</th>
                                <th>Invoice</th>
                                <th>Product</th>
                                <th>Wirehouse</th>
                                <th>Qntty</th>
                                <th>Rate</th>
                                <th>Total Value</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody style="font-size: 18px;">

                            @foreach ($damagelist as $data)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ date("d-m-Y", strtotime($data->date)) }}</td>
                                    <td>{{ $data->invoice }}</td>
                                    <td>{{ $data->product_name }}</td>
                                    <td>{{ $data->factory_name }}</td>
                                    <td align="center">{{ $data->quantity }}</td>
                                    <td align="right">{{ number_format($data->rate,2) }}</td>
                                    <td align="right">{{ number_format($data->quantity*$data->rate,2) }}</td>
                                    <td class="text-center align-middle">
                                        <a class="btn btn-xs btn-info salesedit"                                                                                                                                                                                                                                                                   color: white;"
                                            href="{{route('sales.damage.edit',$data->id )}}"
                                            data-toggle="tooltip" data-placement="top" title="Edit"><i class="far fa-edit "></i></a>
                                            
                                            <a class="btn btn-xs btn-primary" href="{{route('sales.damage.invoice.view',$data->id )}}"
                                            data-toggle="tooltip" data-placement="top" title="Edit"><i class="far fa-eye "></i></a>
                                            
                                            <a class="btn btn-xs btn-danger salesdelete" href="" data-toggle="modal" data-target="#delete"
                                            data-myid="{{ $data->id }}"><i class="far fa-trash-alt"></i> </a>
                                        
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
                <form action="{{ route('sales.damage.delete') }}" method="POST">
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


        $("#sbtn" ).click(function( event ){
        $.ajax({
            url : '{{url('sales/salesNumber')}}',
            type: "GET",
            dataType: 'json',
            success : function(data){
              if(data.length!=0)
              {
                  var dln = parseInt(data[0].invoice_no)+1;
                  document.getElementById("invoiceNo").innerHTML = dln;
              }
              else{
                  document.getElementById("invoiceNo").innerHTML = 100001;
              }

          }
        });
    });

    </script>

@endpush
