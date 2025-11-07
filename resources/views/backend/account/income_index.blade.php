@extends('layouts.account_dashboard')

@section('header_menu')


@endsection


@section('content')


@php
function taka_format($amount)
{
$tmp = explode(".",$amount);  // for float or double values
$strMoney = "";
$amount = $tmp[0];
$strMoney .= substr($amount, -3,3 );
$amount = substr($amount, 0,-3 );
while(strlen($amount)>0)
{
$strMoney = substr($amount, -2,2 ).",".$strMoney;
$amount = substr($amount, 0,-2 );
}

if(isset($tmp[1]))         // if float and double add the decimal digits here.
{
return $strMoney.".".$tmp[1];
}
return $strMoney;
}


@endphp

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper  accountscontent">
        <!-- Main content -->
        <div class="content px-4 ml-5 ">
          <li class="pt-2 nav-item d-none d-sm-inline-block">
              <a href="{{ route('all.income.create') }}" class=" btn btn-success mr-2">Income Entry</a>
          </li>
          <li class="nav-item d-none d-sm-inline-block">
              <a href="{{ route('all.income.source.create') }}" class=" btn btn-warning mr-2">Income Source Settings</a>
          </li>
            <div class="container-fluid">
                <div class="text-center pt-3">
                  <h3 class="text-uppercase font-weight-bold">Naba Crop Care</h3>
                  <p>Head office, Rajshahi, Bangladesh</p>
                </div>

                <div class="py-4">
                    <div class="text-center">
                        <h5 class="text-uppercase font-weight-bold">Income List</h5>
                        <hr>
                    </div>

                    <table id="example1" class="table table-bordered table-striped" style="font-size: 15px;">
                        <thead>
                            <tr class="text-center">
                                <th>SI. No</th>

                                <th>Date</th>
                                <th>Name</th>
                              	<th>Type</th>
                              	<th>Head</th>
                                <th>Income Source</th>
                               <th>Amount</th>
                               <th>Description</th>


                                <th width="10%">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $sl = 0;
                            @endphp
                            @foreach($datas as $data)
                                @php
                                    $sl++;
                                @endphp
                                <tr>
                                    <td class="align-middle">{{ $sl }}</td>
                                    <td>{{$data->date}}</td>
                                  @if(!empty($data->bank_name))
                                  	<td>{{$data->bank_name}}</td>
                                  @else
                                  	<td>{{$data->wirehouse_name}}</td>
                                  @endif
                                  	<td>{{$data->type}}</td>
                                  	<td>{{$data->head}}</td>
                                    <td>{{$data->isname}}</td>
                                    <td>{{number_format($data->amount,2)}}</td>
                                    <td>{{$data->description}}</td>


                                    <td class="text-center align-middle">
                                      <a class="btn btn-xs text-light btn-primary" href="{{route('all.income.view',$data->id)}}"
                                            data-toggle="tooltip" data-placement="top" title="View"><i
                                                class="fas fa-eye"></i> </a> 
                                      	<a class="btn btn-xs btn-danger accountsdelete" href="" data-toggle="modal" data-target="#delete" data-myid="{{ $data->id }}"><i class="far fa-trash-alt"></i> </a>
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
                    <form action="{{route('all.income.delete')}}" method="POST">
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
