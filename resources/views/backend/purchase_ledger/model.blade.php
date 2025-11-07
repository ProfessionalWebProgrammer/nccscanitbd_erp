<style type="text/css" media="screen">
           
  .modal-body .table th{
                padding: 0.45rem!important;
                font-size: 18px!important;
                font-weight: 600!important;
  }
  .modal-body .table .sub-head{
    			padding: 0.40rem!important;
                font-size: 17px!important;
                font-weight: 500!important;
    			color: green;
  }
  .modal-body .table .sub-head2{
    			padding: 0.40rem!important;
                font-size: 17px!important;
                font-weight: 500!important;
    			color: red;
  }
  .modal-body .table th:nth-child(2){
  text-align:right;
  }
  .modal-body .table td{
                padding: 0.25rem!important;
                font-size: 15px!important;
                font-weight: 300!important;
            }

        </style>

   
  <!-- modal amountReceiveable start -->
    <div class="modal fade" id="modalPurchaseStock">
            <div class="modal-dialog">
                <div class="modal-content bg-light">
                    <div class="modal-header">
                        <h4 class="modal-title">Individual Production Stock Out of {{$productName}}</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                        <div class="modal-body">
                           <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Date </th>
                                    <th align="center">Invoice</th>
                                  <th align="right">Quantity</th>
                                </tr>
                          </thead>
                             
                            <tbody>
                              @php 
                              $allData = DB::table('purchase_stockouts')->select('date','sout_number','stock_out_quantity')->where('product_id',$productID)
                              			->whereBetween('date', [$fdate, $tdate])->get();
                              $value = 0;
                              $total = 0;
                              @endphp
                              @if(count($allData) > 0)
                                @foreach($allData as $val)
                              		@php 
                              		$total += $val->stock_out_quantity; 
                              		@endphp 
                              		<tr>
                                      <td>{{$val->date}}</td>
                                      <td align="center">{{$val->sout_number}}</td>
                                      <td align="right">{{$val->stock_out_quantity}}</td>
                                    </tr>
                                @endforeach
                                  <tr>
                                    <td class="sub-head">Total:</td>
                                    <td class="sub-head" colspan="2" align="right">{{number_format($total,2) ?? '0'}}/-</td>
                                	</tr>
                              @endif 
                                   
                            </tbody>
                             </table>
                        </div>                     
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
    <!-- /.modal end -->        


