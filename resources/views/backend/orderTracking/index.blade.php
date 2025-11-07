@extends('layouts.crm_dashboard')

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper salescontent">
        <!-- Main content -->
        <div class="content px-4 ">
            <div class="container-fluid" style="background: #ffffff; padding: 0px 40px;">
              	<div class="row pt-3">
                  	<div class="col-md-12 text-right">
                      {{--	<a href="{{route('product.unit.create')}}" class="btn btn-sm btn-success">Product Unit</a>
                      	<a href="{{route('sales.category.index')}}" class="btn btn-sm btn-success">Product Category</a> --}}
                        <a href="{{route('marketingOrder.tracking.create')}}" class="btn btn-sm btn-success">Traking Entry </a>
                      {{--  <a href="{{route('specification.head.index')}}" class="btn btn-sm btn-success mr-2">Specification Head</a> --}}
                    </div>
                </div>
                <div class="text-center pt-3">
                    <h3 class="text-uppercase font-weight-bold">Naba Crop Care</h3>
                  <p>Head office, Rajshahi, Bangladesh</p>
                </div>
                <div class="py-4">
                    <div class="text-center">
                        <h5 class="text-uppercase font-weight-bold">Traking List</h5>
                        <hr>
                    </div>
                    <div class="my-3">

                    </div>
                    <table id="example1" class="table table-bordered table-striped" style="font-size: 13px;">
                        <thead>
                            <tr class="text-center table-header-fixt-top">
                                <th>SI. No</th>
                                <th>Date</th>
                                <th>Invoice Number</th>
                                <th>Progress Stage</th>
                                <th>Progress Value</th>
                                <th>Remarks</th>
                                <th>User Name</th>
                                <th>Status</th>
                                <th width="10%">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($datas as $data)

                                <tr>
                                    <td>{{ $loop->iteration }} </td>
                                    <td>{{ $data->date }} </td>
                                    <td>{{ $data->invoice }}</td>
                                    <td>
                                      @if($data->stage == 1)
                                      1st Stage
                                      @elseif($data->stage == 2)
                                      2nd Stage
                                      @elseif($data->stage == 3)
                                      3rd Stage
                                      @elseif($data->stage == 4)
                                      4th Stage
                                      @else
                                      5th Stage
                                      @endif
                                     </td>
                                    <td>{{ $data->value }} %</td>
                                    <td>{{ $data->remarks }}</td>
                                    <td>{{ $data->user->name }}</td>
                                    <td> @if($data->status == 1)<span class="badge badge-success p-2"> Active </span> @else <span class="badge badge-danger p-2"> InActive </span>@endif</td>
                                    <td align="center">
                                       <a class="btn btn-xs marketingedit" style="background-color: #66BB6A"
                                            href="{{ URL::to('/marketing/item/order/traking/edit/' . $data->invoice) }}" data-toggle="tooltip"
                                            data-placement="top" title="Edit"><i class="fas fa-edit"></i> </a>
                                            <a href="{{route('marketingOrder.tracking.invoice',$data->invoice)}}" class="btn btn-primary btn-xs"><span
                                                      class="fa fa-eye"></span></a>

                                        {{-- <a class="btn btn-xs btn-danger marketingdelete" href="" data-toggle="modal" data-target="#delete"
                                                        data-myid="{{ $data->id }}"><i class="far fa-trash-alt"></i>
                                        </a> --}}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

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
