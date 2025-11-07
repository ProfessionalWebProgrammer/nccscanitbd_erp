
@php

$today = date('Y-m-d');
//dd($today);

$awnotification = DB::table('asset_notifications')
		->select('asset_notifications.*','asset_categories.name as catname','asset_products.product_name','asset_products.warranty_date')
        ->leftJoin('asset_categories', 'asset_categories.id', 'asset_notifications.category_id')
        ->leftJoin('asset_products', 'asset_products.id', 'asset_notifications.product_id')
		->where('type','warranty')
		->where('status',0)
		->get();
$alnotification = DB::table('asset_notifications')
		->select('asset_notifications.*','asset_categories.name as catname','asset_products.product_name','asset_products.warranty_date')
        ->leftJoin('asset_categories', 'asset_categories.id', 'asset_notifications.category_id')
        ->leftJoin('asset_products', 'asset_products.id', 'asset_notifications.product_id')
		->where('type','license')
		->where('status',0)
		->get();




@endphp

 <!-- modal -->
    <div class="modal fade" id="asset_notification" data-keyboard="false" data-backdrop="static">
            <div class="modal-dialog">
                <div class="modal-content bg-danger">
                    <div class="modal-header">
                        <h4 class="modal-title">Please Check This</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                  <form action="{{ Route('asset.notification.confirm') }}" method="POST">
               		 @csrf
                        <div class="modal-body">
                          @foreach($awnotification as $data)
                          @php
                           $warranty_date = $data->warranty_date;
                           $notificationdate = $data->before_day;
                          @endphp
                          
                          @if($notificationdate == $today)
                            <p>Asset Product Name: {{$data->product_name}},  Warranty Data:{{date('d-F-Y', strtotime($warranty_date))}}</p>

                            <input type="hidden" class="thisdata" name="thisdata" value="1">
                            <input type="hidden" class="" name="notificationid[]" value="{{$data->id}}">
                            <input type="hidden" class="" name="product_id[]" value="{{$data->product_id}}">
                          @else
                          <input type="hidden" class="thisdata" name="thisdata" value="0">
                          @endif
                           
                          @endforeach
                          
                        </div>
                        <div class="modal-footer justify-content-between">
                            <button type="button" class="btn btn-outline-light" data-dismiss="modal">Close</button>
                          
                            <button type="submit" class="btn btn-outline-light">Check</button>
                        </div>
                    
                     </form>
                   
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
    <!-- /.modal -->



@php

$today = date('Y-m-d');


$snotification = DB::table('sales_stock_notifications')
        	->select('sales_stock_notifications.*','sales_products.product_name','factories.factory_name')
            ->leftjoin('sales_products', 'sales_products.id', 'sales_stock_notifications.product_id')
            ->leftjoin('factories', 'factories.id', 'sales_stock_notifications.warehouse_id')
		->where('status',0)
		->get();


@endphp

 <!-- modal -->
    <div class="modal fade" id="stocknotification" data-keyboard="false" data-backdrop="static">
            <div class="modal-dialog">
                <div class="modal-content bg-danger">
                    <div class="modal-header">
                        <h4 class="modal-title">Please Stock In This Product</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                  <form action="{{ Route('stockin.notification.confirm') }}" method="POST">
               		 @csrf
                        <div class="modal-body" id="stockmbody">
                          @foreach($snotification as $data)
                            <div class="mainstockclass" >
                                <p>WareHouse: {{$data->factory_name}}, Product: {{$data->product_name}}, Minimum Stock: {{$data->minimum_qty}},
                                  Stock:<span class="stockbalance"></span></p>

                                <input type="hidden" class="stockdat" name="thisdata" value="1">
                                <input type="hidden" class="notificationid" name="notificationid[]" value="{{$data->id}}">
                                <input type="hidden" class="product_id" name="product_id[]" value="{{$data->product_id}}">
                                <input type="hidden" class="warehouse_id" name="warehouse_id[]" value="{{$data->warehouse_id}}">
                                <input type="hidden" class="min_qty" name="min_qty[]" value="{{$data->minimum_qty}}">
                              </div>
                           
                          @endforeach
                          
                        </div>
                        <div class="modal-footer justify-content-between">
                            <button type="button" class="btn btn-outline-light" data-dismiss="modal">Close</button>
                          
                            <button type="submit" class="btn btn-outline-light">Check</button>
                        </div>
                    
                     </form>
                   
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
    <!-- /.modal -->


<script>
  $(document).ready(function() {
    var hasclass =  $('.thisdata').val();
    if(hasclass == 1){
      $('#asset_notification').modal('show');
    }
    
    var stockhasclass =  $('.stockdat').val();
    
    
     
    
     $('.product_id').each(function() {

                // $('.totalvalueid').attr("value", "0");
                var parent = $(this).closest('.mainstockclass');

                var product_id=parent.find('.product_id').val();
                var warehouse_id= parent.find('.warehouse_id').val();
                var min_qty= parent.find('.min_qty').val();
             
      			// console.log(product_id);

                  
                  
                  $.ajax({
                            url : '{{url('/sales/product/stock/')}}/'+product_id+'/'+warehouse_id,
                            type: "GET",
                            dataType: 'json',
                            success : function(data){
                                console.log(data);
                              
                              var stock = data.stock;
                              
                              parent.find('.stockbalance').html(stock);
                              
                              if(min_qty > stock){
                              
                              $('#stocknotification').modal('show');
                                
                              }else{
                              
                              	parent.css("display", "none");
                                parent.find('.notificationid').val('');
                                
                              }
                              
                            
                          
                            
                        }
                        });
                
              



              

         })
    
       
 });
</script>




