<?php

namespace App\Http\Controllers\Production;

use App\Models\Factory;
use App\Models\FinishedGood;
use App\Models\PurchaseStockout;
use App\Models\SalesProduct;
use App\Models\SalesStockIn;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\RowMaterialsProduct;
use App\Http\Controllers\Controller;
use App\Models\ProductionFactory;


class PStockInController extends Controller
{
    public function psilist(Request $request)
    {
        $fdate = $request->fdate;
        $tdate = $request->tdate;
        
       
       
        $stock_ins = SalesStockIn::select('sales_stock_ins.*','sales_products.product_name','factories.factory_name')
            ->leftjoin('sales_products', 'sales_products.id', 'sales_stock_ins.prouct_id')
            ->leftjoin('factories', 'factories.id', 'sales_stock_ins.factory_id')

            ->get();
           // dd($stock_ins);
        
        return view('backend.production.stock_in_list', compact('stock_ins'));
    }

    public function deletestockin(Request $request)
    {
    	//dd($request->all());
      	SalesStockIn::where('id',$request->id)->delete();
      	return redirect()->back()->with('success', 'Manual Stock Deleted Successfully');
    }
   
    public function psicreate()
    {
        $finishedgoods = SalesProduct::all();
        $products = RowMaterialsProduct::all();
        $stores = Factory::all();
       $pfactory = ProductionFactory::all();
        return view('backend.production.stock_in_create', compact('products', 'stores', 'finishedgoods','pfactory'));
    }

  

    public function psistore(Request $request)
    {

     //dd($request->all());

      $invoice = PurchaseStockout::latest('id')->first();
        
        
        
        foreach($request->product_id as $key=>$prouct_ids)
            {
              
                
                
                        
                    $stockin =   new SalesStockIn;
                    $stockin->date = $request->date;
                    $stockin->prouct_id = $request->product_id[$key];
                    $stockin->quantity = $request->p_qty[$key];
                    $stockin->factory_id = $request->wirehouse_id;
              $stockin->production_factory_id =  $request->production_factory_id;
                $stockin->expire_date =  $request->expire_date;
            
          
                    $stockin->batch_id = $request->batch[$key];
                    $stockin->production_rate = $request->production_rate[$key];
                    $stockin->total_cost =$request->production_rate[$key]*$request->p_qty[$key];

                    $stockin->save();

                
              
            }


        




            return redirect()->route('production.stock.in.list')->with('success', 'Manual Stock In Successfully');
            



    }


    public function psocheckout($invoice)
    {

       // dd($invoice);
        
       
       $finishedgoods = SalesProduct::all();
       $products = RowMaterialsProduct::all();
       $stores = Factory::all();
       return view('backend.production.invoice_checkout', compact('stock_out','products', 'stores', 'finishedgoods'));

        
       
    }

    public function psoupdate(Request $request)
    {

      // dd($request->all());

        
        
      

     


          $stockin =   SalesStockIn::where('sout_number',$request->sout_number)->first();
          $stockin->date = $request->date;
          $stockin->prouct_id = $request->finish_goods_id;
          $stockin->quantity = $request->fg_qty;
          $stockin->factory_id = $request->wirehouse_id;
          $stockin->batch_id = $request->batch;
          //$stockin->sout_number = $request->sout_number;
          $stockin->production_rate = $request->production_rate;
          $stockin->total_cost =$request->production_rate*$request->p_qty;


           
        



            return redirect()->back()->with('success', 'Production Stock Out Update Successfully');
            



    }
  
   public function stockinnotificationlist()
    {
      
      $notifications = DB::table('sales_stock_notifications')
        ->select('sales_stock_notifications.*','sales_products.product_name','factories.factory_name')
            ->leftjoin('sales_products', 'sales_products.id', 'sales_stock_notifications.product_id')
            ->leftjoin('factories', 'factories.id', 'sales_stock_notifications.warehouse_id')
        ->get();
    
        return view('backend.production.notification_list', compact('notifications'));
    }
   public function stockinnotification()
    {
      
      $warehouses = Factory::all();
      $product =  SalesProduct::all();
        return view('backend.production.notification', compact('warehouses','product'));
    }
    public function stockinnotificationstore(Request $request)
    {
      //dd($request->all());
      
          DB::table('sales_stock_notifications')->insert([
           'warehouse_id' => $request->warehouse_id,
           'product_id' => $request->product_id,
           'minimum_qty' => $request->minimum_qty

          ]);
      
        return redirect()->route('stockin.notification')->with('success', 'Notification Created Successfull');
    }
  public function notificationdelete(Request $request)
    {
    	//dd($request->all());
      	DB::table('sales_stock_notifications')->where('id',$request->id)->delete();
      
      	return redirect()->back()->with('success', ' Deleted Successfull');
    }
  
  
   public function stockinnotificationconfirm(Request $request)
    {
     // dd($request->all());
     
     
     foreach($request->product_id as $key => $item){
       if($request->notificationid[$key] != null){
          DB::table('sales_stock_notifications')->where('id',$request->notificationid[$key])->update([

               'status' => 1,

              ]);
       }
     }
      
         
      
        return redirect()->back()->with('success', 'Notification Seen');
    }
  
  	
  


}
