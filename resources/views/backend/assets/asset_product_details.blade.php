@extends('layouts.account_dashboard')
@section('header_menu')

@endsection
@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">


        <!-- Main content -->
        <div class="content px-4 ">
          <div class="row pt-2">
                  	<div class="col-md-12 text-right">
                        <a href="{{ URL('/asset/product/create') }}" class=" btn btn-success btn-sm mr-2 mt-1">Create New Asset Product</a>
                    </div>
                </div>
            <div class="container-fluid">
                <div class="text-center pt-3">
                    <h3 class="text-uppercase font-weight-bold">SBMS V.2 - Scan It</h3>
                    <p>Road:1200 , House 005, Dhaka- 1202</p>
                    <h6>01712345678 , 86458415</h6>
                    <h5>Asset Product Details</h5>
                  
                </div>
                <div class="row pt-4">

                    <div class="col-md-8">
                        <div class="text-left">
                            <div class="mt-3">
                                <table style="font-size:22px;">
                                    <tr>
                                        <td>Product Name</td>
                                        <td> : </td>
                                        <td>{{$assetproduct->product_name}} </td>
                                    </tr>
                                    <tr>
                                        <td>Category</td>
                                        <td> : </td>
                                        <td>{{$assetproduct->catname}} </td>
                                    </tr>
                                  <tr>
                                        <td>Description</td>
                                        <td> : </td>
                                        <td>{{$assetproduct->description}} </td>
                                    </tr>
                                   <tr>
                                        <td>Warranty Date</td>
                                        <td> : </td>
                                        <td>{{$assetproduct->warranty_date}} </td>
                                    </tr>
                                  
                                     <tr>
                                        <td>Guarantee Date</td>
                                        <td> : </td>
                                        <td>{{$assetproduct->guarantee_date}} </td>
                                    </tr>
                                  
                                </table>
                            </div>
                        </div>
                    </div>
                    
                </div>
                <div class="row">
                   
                    <div class="col-md-5 mt-5">
                        <table id=""  class="table table-bordered table-striped table-fixed"  style="font-size:16px;">
                            <thead>
                                <tr>
                                    <th>Specification Head</th>
                                    <th>Specification Value</th>
                                
                                </tr>
                            </thead>
                            <tbody>

                              
                                @foreach ($assetproductdetails as $item)
									<tr>
                                      <td>{{$item->head}}</td>
                                      <td>{{$item->value}}</td>
                                
                                  	</tr>
                              
                                @endforeach
                                
                              
                            </tbody>
                         
                        </table>
                    </div>
                     <div class="col-md-7  my-5">
                  			<img src="{{asset('public/uploads/')}}/{{$assetproduct->image}}" alt="nothing" width="600" >
                  	</div> 
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
                    <form action="{{ route('delete.asset.product') }}" method="POST">
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
        </script>

    @endpush

