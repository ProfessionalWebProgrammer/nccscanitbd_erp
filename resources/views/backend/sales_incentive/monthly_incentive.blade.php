@extends('layouts.sales_dashboard')
@section('header_menu')
    <li class="nav-item btn btn-xs d-none d-sm-inline-block mr-2">
        <a href="{{route('sales.yearly.incentive')}}" class="btn btn-success">Yearly Incentive</a>
	</li>
	<li class="nav-item btn btn-xs d-none d-sm-inline-block mr-2">
        <a href="{{route('sales.daily.incentive')}}" class="btn btn-success">Daily Incentive</a>
	</li>
@endsection
@section('content')
<!-- Content Wrapper. Contains page content -->

<div class="content-wrapper salescontent">

    <div class="container-fluid" style="background:#ffffff; padding:0px 40px;min-height:85vh">
    <div class="row">
        <div class="col-md-5" style="border-right: 2px solid black">

            <div class="content px-4 ">

                <form class="floating-labels m-t-40" action="{{ Route('sales.monthly.incentive.store') }}" method="POST">
                    @csrf

                    <div class="">
                        <div class="pt-3 text-center">
                            <h4 class="font-weight-bolder text-uppercase">Monthly Incentive Set</h4>
                            <hr width="33%">
                        </div>

                        <div class="row pt-4">
                            <div class="form-group col-md-12">
                                <label class=" col-form-label">Category :</label>
                                <select name="category_id" class="form-control select2 " required>
                                       <option value=""> Select Category </option>
                                          @foreach ($categories as $item)
                                            <option value="{{ $item->id }}">{{ $item->category_name }}</option>
                                          @endforeach
                                 </select>

                                <!-- <input type="text" name="type_title" class="form-control" placeholder="Monthly Incentive Title"> -->
                            </div>
                            <div class="form-group col-md-12">
                                <div class="row">
                                    <div class="form-group col-md-6">
                                        <label class=" col-form-label">Min Target:</label>
                                        <input type="text" name="min_target" required class="form-control" placeholder="Min Target">
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label class=" col-form-label">Max Target:</label>
                                        <input type="text" name="max_target" required class="form-control" placeholder="Max Target">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group col-md-12">
                                <label class="col-form-label">Achive Commision :</label>
                                <input type="text" name="achive_commission" required class="form-control" placeholder="Achive Commision">
                            </div>
                            <div class="form-group col-md-12">
                                <label class="col-form-label">Type Description :</label>
                                <textarea name="description" class="form-control" id="" cols="30" rows="5" placeholder="Monthly Incentive Description"></textarea>
                            </div>

                        </div>
                    </div>
                    <div class="row pb-5">
                        <div class="col-md-6 mt-3">
                            <div class="text-right">
                                <button type="submit" class="btn btn-primary custom-btn-sbms-submit"> Submit </button>
                            </div>
                        </div>
                        <div class="col-md-6 mt-3">

                        </div>
                    </div>

                </form>

            </div>
        </div>



        <div class="col-md-7">

            <div class="content px-4 ">
                <div class="">
                    <div class="py-4">
                        <div class="text-center">
                            <h5 class="text-uppercase font-weight-bold">Monthly Incentive List</h5>
                            <hr>
                        </div>
                        <table id="example5" class="table table-bordered table-striped" style="font-size: 15px;">
                            <thead>
                                <tr class="text-center table-header-fixt-top">
                                    <th width="10%">SI. No</th>
                                    <th>Category</th>

                                    <th>Target Amount</th>
                                    <th>Achive Commision</th>
                                    <th>Description</th>
                                    <th width="10%">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($montlyins as $item)
                                @php
                                $name = DB::table('sales_categories')->where('id',$item->category_id)->value('category_name');
                                @endphp
                                <tr>
                                    <td class="align-middle">{{ $loop->iteration }}</td>
                                    <td class="text-left align-middle">{{ $name }} </td>

                                    <td class="text-center font-weight-bold align-middle">{{ $item->target_amount }}-{{$item->max_target_amount}} </td>
                                    <td class="text-center align-middle">{{ $item->achive_commision }}% </td>
                                    <td class="text-left align-middle">{{ $item->description }} </td>
                                    <td class="text-center align-middle">
                                        <a class="btn btn-xs  salesedit" style="background-color: #66BB6A" href="{{URL('/sales/monthly/incentive/edit/'.$item->id)}}"
                                        data-toggle="tooltip" data-placement="top" title="Edit"><i class="fas fa-edit"></i> </a>
                                        <a class="btn btn-xs btn-danger salesdelete" href="" data-toggle="modal" data-target="#delete" data-myid="{{ $item->id }}"><i class="far fa-trash-alt"></i> </a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>

</div>
<!-- /.content-wrapper -->
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
            <form action="{{route('sales.monthly.incentive.delete')}}" method="POST">
                {{ method_field('delete') }}
                @csrf

                <div class="modal-body">
                    <p>Are you sure to delete this Incentive?</p>

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
