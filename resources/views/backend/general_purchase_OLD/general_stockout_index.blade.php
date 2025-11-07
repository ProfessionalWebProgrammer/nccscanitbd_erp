@extends('layouts.purchase_deshboard')

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper purchasecontent">


        <!-- Main content -->
        <div class="content px-4 ">
            <div class="container-fluid" style="background:#ffffff; padding:0px 40px;min-height:85vh">
                <div class="text-center pt-3">
                    <h3 class="text-uppercase font-weight-bold">SBMS V.2 - Scan It</h3>
                    <p>Official Conpany Address <br> Road:1200 , House 005, Dhaka- 1202</p>
                    <h6>01712345678 , 86458415</h6>
                    <h5>General Stock Out List</h5>
                </div>
                <div class="row">
                    <div class="col-md-6"></div>
                    <div class="col-md-6 text-right">
                        <a href="{{ route('general.purchase.stockout.create') }}" class="btn btn-sm btn-primary"> Create
                            Stock-Out</a>
                    </div>
                </div>
                <form action="{{ url('/general/purchase/stockout/index') }}" method="GET">
                    @csrf
                    <div class="row pt-4 pb-2 mt-3 rounded" style="background: #033133;">
                        <div class="col-md-3">
                            <div class="form-group row">
                                <label class="col-md-4 pt-1 text-right" for="">From Date:</label>
                                <input class="col-md-8 form-control" name="fdate" value="{{ $fdate }}" type="date">
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group row">
                                <label class="col-md-4 pt-1 text-right" for="">To Date:</label>
                                <input class="col-md-8 form-control" name="tdate" type="date" value="{{ $tdate }}">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group row">
                                <label class="col-md-4 pt-1 text-right" for="">Wirehouse:</label>
                                <select class="col-md-7 form-control select2" name="factory" id="">
                                    <option value="">Select Wirehouse</option>
                                    @foreach ($wirehouses as $wh)
                                        <option style="color:#000;font-weight:600;" value="{{ $wh->wirehouse_id  }}"
                                            @if ($wh->wirehouse_id == $fid) selected @endif>
                                            {{ $wh->wirehouse_name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group row">
                                <br>
                                <div class="col-md-12">
                                    <button class=" btn btn-primary" type="submit">Search</button>
                                    <a href="{{ url('/general/purchase/stockout/index') }}"
                                        class="btn btn-warning">Clear</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
                <div class="py-4">
                    <table id="example1" class="table table-bordered table-striped table-fixed" style="font-size: 15px;">
                        <thead>
                            <tr class="text-center table-header-fixt-top">
                                <th>Sl</th>
                                <th>Date</th>
                                <th>Wirehouse</th>
                                <th>Product Name</th>
                                <th>Product Price</th>
                                <th>Quantity</th>
                                <th>Dimension</th>
                                <th>Referance</th>
                                <th>Note</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody style="font-size: 18px;">

                            @foreach ($stockoutdata as $tdata)
                                <tr>
                                    <td class="text-center">{{ $loop->iteration }}</td>
                                    <td class="text-center">{{ date('d-F-Y', strtotime($tdata->date)) }}</td>
                                    <td class="text-center">{{ $tdata->factory_name }}</td>
                                    <td class="text-left">{{ $tdata->gproduct_name }}</td>
                                    <td class="text-right">{{ $tdata->price }}</td>
                                    <td class="text-center">{{ $tdata->quantity }}</td>
                                    <td class="text-center">{{ $tdata->dimensions }}</td>
                                    <td class="text-center">{{ $tdata->Referance }}</td>
                                    <td class="text-center">{{ $tdata->note }}</td>


                                    <td class="text-center align-middle">
                                        <a class="btn btn-sm purchaseedit"
                                            style="background-color: mediumaquamarine;                                                                                                                                                                                                                                                                    color: white;"
                                            href="{{ URL('/general/purchase/edit/' . $tdata->id) }}"
                                            data-toggle="tooltip" data-placement="top" title="CheckOut Invoice"><i
                                                class="fas fa-spinner"></i></a>
                                        <a class="btn btn-sm btn-primary " href="" data-toggle="tooltip"
                                            data-placement="top" title="View Invoice"><i class="far fa-eye"></i> </a>
                                        <a class="btn btn-sm btn-danger purchasedelete" href="" data-toggle="modal" data-target="#delete"
                                                        data-myid="{{$tdata->id }}"><i class="far fa-trash-alt"></i>
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
                <form action="{{ route('generalpurchase.stockout.delete') }}" method="POST">
                    {{ method_field('delete') }}
                    @csrf

                    <div class="modal-body">
                        <p>Are you sure to delete this This Stock Out?</p>

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
    <script>
        $(function() {
            $('[data-toggle="tooltip"]').tooltip()
        })
    </script>
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
