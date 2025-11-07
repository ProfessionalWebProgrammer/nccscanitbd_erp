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
        <div class="content px-4 ">
          <li class="nav-item d-none d-sm-inline-block pt-2">
              <a href="{{ route('ltr.create') }}" class=" btn btn-success mr-2">LTR Entry</a>
          </li>

            <div class="container-fluid">
                <div class="text-center pt-3">
                    <h3 class="text-uppercase font-weight-bold">SBMS V.2 - Scan It</h3>
                    <p>Road:1200 , House 005, Dhaka- 1202</p>
                    <h6>01712345678 , 86458415</h6>
                </div>
            
                <div class="py-4">
                    <div class="text-center">
                        <h5 class="text-uppercase font-weight-bold">LTR List</h5>
                        <hr>
                    </div>
                   
                    <table id="example1" class="table table-bordered table-striped" style="font-size: 15px;">
                        <thead>
                            <tr class="text-center">
                                <th>SI. No</th>
                               
                                <th>Date</th>
                                <th>Bank/Warehouse</th>
                              
                               
                                
                               
                               <th>Head</th>
                               <th>Amount</th>
                             
                               
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
                          $name = '';
                          			if($data->bank_id){
                          				$name = DB::table('master_banks')->where('bank_id',$data->bank_id)->value('bank_name');
                          			}
                          			if($data->warehouse_id){
                          				$name = DB::table('master_cashes')->where('wirehouse_id',$data->warehouse_id)->value('wirehouse_name');
                         			 }
                          
                        		  $fromname = '';
                          			if($data->from_client_id != null){
											$fromname = DB::table('asset_clints')->where('id',$data->from_client_id)->value('name');
                          			}
                          			if($data->from_company_id != null){
											$fromname = DB::table('company_names')->where('id',$data->from_company_id)->value('name');
                          			}
                          
                          
                           $toname = '';
                          			if($data->to_client_id != null){
											$toname = DB::table('asset_clints')->where('id',$data->to_client_id)->value('name');
                          			}
                          			if($data->to_company_id != null){
											$toname = DB::table('company_names')->where('id',$data->to_company_id)->value('name');
                          			}
                                @endphp
                                <tr>
                                    <td class="align-middle">{{ $sl }}</td>
                                    <td>{{$data->date}}</td>
                                    <td>{{$name}}</td>
                                  
                                  
                                    
                                   
                                    <td>{{$data->head}}</td>
                                    <td>{{$data->amount}}</td>
                              
                                 
                                    <td class="text-center align-middle">
                                   {{--     <a class="btn btn-sm text-light accountsedit" style="background-color: #66BB6A" href="#/{{$data->id }}"
                                            data-toggle="tooltip" data-placement="top" title="Edit"><i
                                                class="fas fa-edit"></i> </a> --}}
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
                    <form action="{{route('ltr.delete')}}" method="POST">
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
