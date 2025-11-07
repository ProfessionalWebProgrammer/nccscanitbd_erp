@extends('layouts.sales_dashboard')
@section('header_menu')
    <li class="nav-item d-none d-sm-inline-block">

	</li>
@endsection


@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper salescontent">
        <!-- Main content -->
        <div class="content px-4 ">
            <div class="container-fluid" style="background: #ffffff; padding: 0px 40px;">
              <div class="row pt-3">
                	<div class="col-md-4">
                      	 <a href="{{ URL('/deler/delete/log') }}" class=" btn btn-sm btn-success mr-2">Delete Log</a>
                  {{--    	 <a href="{{ route('dealer.archive.log') }}" class=" btn btn-sm btn-success mr-2">Archive Log</a>     --}}
                    </div>
                  	<div class="col-md-8 text-right">
                      	<a href="{{route('dealer.create')}}" class="btn btn-sm btn-success">Dealer Create</a>
                      	<a href="{{route('dealer.type.create')}}" class="btn btn-sm btn-success">Dealer Type</a>
                      	<a href="{{route('dealer.zone.create')}}" class="btn btn-sm btn-success">Dealer Zone</a>
                      	<a href="{{route('dealer.subzone.create')}}" class="btn btn-sm btn-success">Dealer Sub-Zone</a>
                      	<a href="{{route('dealer.area.create')}}" class="btn btn-sm btn-success">Dealer Area</a>
                    </div>
                </div>

                <div class="text-center pt-3">
                    <h3 class="text-uppercase font-weight-bold">Naba Crop Care</h3>
		                  <p>Head office, Rajshahi, Bangladesh</p>
                </div>
                <div class="py-4">
                    <div class="text-center">
                        <h5 class="text-uppercase font-weight-bold">Dealer List</h5>
                        <hr>
                    </div>
                    <div class="my-3">
                      <form action="{{ route('dealer.index') }}" method="get">
                        <div class="input-group rounded">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="">Dealer Area</span>
                            </div>
                            <select name="dlr_area_id" class="form-control select2" id="">
                                <option value="">== Select One ==</option>
                               @foreach($dealerarea as $data)
                               <option value="{{$data->id}}" @if($rdarea == $data->id) selected @endif>{{$data->area_title}}</option>
                              @endforeach
                            </select>
                            <div class="input-group-prepend  pr-2">

                            </div>
                            <div class="input-group-prepend ">
                                <span class="input-group-text" id="">Dealer Zone</span>
                            </div>
                            <select name="dlr_zone_id" class="form-control select2" id="">
                                <option value="">== Select One ==</option>
                               @foreach($dealerzone as $data)
                               <option value="{{$data->id}}" @if($rdzone == $data->id) selected @endif>{{$data->zone_title}}</option>
                              @endforeach
                            </select>
                            <div class="input-group-prepend  pr-2">

                            </div>
                            <div class="input-group-prepend pr-2">
                                <button class="btn btn-sm btn-success"><i class="fas fa-search"></i> Search</button>
                            </div>
                            <div class="input-group-prepend pr-2">
                                <a href="{{ route('dealer.index') }}" class="btn btn-sm btn-danger"><i class="far fa-times-circle"></i>
                                    Clear</a>
                            </div>
                            <div class="input-group-prepend">
                                <button class="btn btn-sm btn-warning"><i class="fas fa-print"></i>
                                    Print</button>
                            </div>
                        </div>

                          </form>

                    </div>
                    <table id="example3" class="table table-bordered table-striped" style="font-size: 10px;">
                        <thead>
                            <tr class="text-center table-header-fixt-top">
                                <th>SI.</th>
                                <th>Name</th>
                                <th>Code</th>
                                <th>Proprietor Name</th>
                                <th>Zone</th>
                                <th>Region</th>
                                <th>Area</th>
                                <th>Type</th>
                                <th>Credit Limite</th>
                                <th>Phone Number</th>
                                <th>Adddress</th>
                                <th width="10%">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($dealer as $dlr)




                                <tr>
                                    <td>{{ $loop->iteration }} </td>
                                    <td>{{ $dlr->d_s_name }} </td>
                                    <td>{{ $dlr->dlr_code }} </td>
                                    <td>{{ $dlr->d_proprietor_name }}</td>
                                    <td>{{ $dlr->zone_title }}</td>
                                    <td>{{ $dlr->subzone_title }}</td>
                                    <td>{{ $dlr->area_title }}</td>
                                    <td>{{ $dlr->type_title }}</td>


                                    <td>{{ number_format($dlr->dlr_police_station,2) }}</td>

                                    <td>{{ $dlr->dlr_mobile_no }}</td>
                                    <td style="font-size:9px; text-transform: capitalize;font-weight: 300;">{{ $dlr->dlr_address }}</td>
                                    <td class="text-center align-middle">
                                         <a class="btn btn-xs salesedit" style="background-color: #66BB6A"
                                            href="{{ URL::to('edit/deler/' . $dlr->id) }}" data-toggle="tooltip"
                                            data-placement="top" title="Edit"><i class="fas fa-edit"></i> </a>
                                        <a class="btn btn-xs btn-danger salesdelete" href=""  data-toggle="modal" data-target="#delete"
                                                        data-myid="{{ $dlr->id }}"><i class="far fa-trash-alt"></i>
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
                    <form action="{{route('dealer.delete')}}" method="POST">
                        {{ method_field('delete') }}
                        @csrf

                        <div class="modal-body">
                            <p>Are you sure to delete this Vendor?</p>

                            <input type="hidden" id="mid" name="id">

                        </div>
                        <div class="modal-footer justify-content-between">
                            <button type="button" class="btn btn-outline-light" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-outline-light ">Confirm</button>
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
                var title = button.data('mytitle')
                var id = button.data('myid')

                var modal = $(this)

                modal.find('.modal-body #mid').val(id);
            })
        </script>

    @endpush
@endsection
