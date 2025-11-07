<?php

namespace App\Http\Controllers\Production;

use App\Models\Wip;
use App\Models\Factory;
use App\Models\FinishedGood;
use App\Models\PurchaseStockout;
use App\Models\SalesProduct;
use App\Models\SalesStockIn;
use App\Models\ProductionFactory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\FinishedGoodSet;
use App\Models\RowMaterialsProduct;
use App\Models\Purchase;
use App\Models\PurchaseDetail;
use App\Http\Controllers\Controller;
use App\Models\PackingConsumptions;
use App\Models\Account\ChartOfAccounts;
use App\Traits\ChartOfAccount;


class PStockOutController extends Controller
{
  use ChartOfAccount;
    public function psolist(Request $request)
    {
        $fdate = $request->fdate;
        $tdate = $request->tdate;

        if($fdate && $tdate) {
            $stock_out = DB::select('SELECT DISTINCT purchase_stockouts.sout_number,purchase_stockouts.date,sales_products.product_name,purchase_stockouts.fg_qty,purchase_stockouts.fg_out_qty,factories.factory_name as wirehouse_name,SUM(purchase_stockouts.stock_out_quantity) as qty, purchase_stockouts.temp_qty FROM `purchase_stockouts`
            LEFT JOIN factories ON factories.id = purchase_stockouts.wirehouse_id
            LEFT JOIN sales_products ON sales_products.id = purchase_stockouts.finish_goods_id
            WHERE purchase_stockouts.sout_number NOT LIKE "Sal-%" AND purchase_stockouts.date BETWEEN "'.$fdate.'" AND "'.$tdate.'"
            GROUP BY purchase_stockouts.sout_number,purchase_stockouts.date,purchase_stockouts.fg_qty order by date desc, sout_number desc');

        }else{
            $stock_out = DB::select('SELECT DISTINCT purchase_stockouts.sout_number,purchase_stockouts.date,sales_products.product_name,purchase_stockouts.fg_qty,purchase_stockouts.fg_out_qty,factories.factory_name as wirehouse_name,SUM(purchase_stockouts.stock_out_quantity) as qty, purchase_stockouts.temp_qty FROM `purchase_stockouts`
            LEFT JOIN factories ON factories.id = purchase_stockouts.wirehouse_id
            LEFT JOIN sales_products ON sales_products.id = purchase_stockouts.finish_goods_id
            WHERE purchase_stockouts.sout_number NOT LIKE "Sal-%"
            GROUP BY purchase_stockouts.sout_number,purchase_stockouts.fg_qty,purchase_stockouts.date order by date desc, sout_number desc');
        }


        return view('backend.production.production_stock_out_list', compact('stock_out'));
    }

      public function psoinvoiceview($invoice)
    {

       // dd($invoice);
        $stock_out = DB::select('SELECT purchase_stockouts.*,row_materials_products.product_name,row_materials_products.rate,factories.factory_name as wirehouse_name FROM `purchase_stockouts`
                   	LEFT JOIN row_materials_products ON row_materials_products.id = purchase_stockouts.product_id
                    LEFT JOIN factories ON factories.id = purchase_stockouts.wirehouse_id
                    WHERE purchase_stockouts.sout_number NOT LIKE "Sal-%" AND purchase_stockouts.sout_number = "'.$invoice.'"');
      $productionRate = SalesStockIn::where('sout_number',$invoice)->value('production_rate');
		//dd($productionRate);
        return view('backend.production.invoice_view', compact('stock_out','productionRate'));
    }


    public function psocreate()
    {
        $finishedgoods = SalesProduct::all();
        $products = RowMaterialsProduct::all();
        $stores = Factory::all();
        $pfactory = ProductionFactory::all();
        return view('backend.production.production_stock_out_create', compact('products', 'stores', 'finishedgoods','pfactory'));
    }

    public function getproductqty($id)
    {
        $data = array();
        $rawProduct = RowMaterialsProduct::where('id',$id)->first();
        $stockin = DB::select('SELECT sum(receive_quantity) as stock_in, purchase_rate FROM `purchases` WHERE product_id="'.$id.'"');
        $stockout=DB::select('SELECT SUM(stock_out_quantity) as stockout FROM `purchase_stockouts` WHERE product_id="'.$id.'"');
        $pr =DB::select('SELECT SUM(return_quantity) as val FROM `purchase_returns` WHERE product_id="'.$id.'"');
        $cstock =(($rawProduct->opening_balance+ $stockin[0]->stock_in)-($stockout[0]->stockout +$pr[0]->val ?? 0));

        if($stockin[0]->purchase_rate > 0 || $rawProduct->rate > 0 ){
          $data['stock'] = $cstock;
        } else {
          $data['stock'] = 0;
        }
        $data['name'] = $rawProduct->product_name;
        return response($data);

    }
    public function getBagStock($id)
    {
        $data = array();
        $rawProduct = RowMaterialsProduct::where('id',$id)->first();
        $stockin = DB::select('SELECT sum(receive_quantity) as stock_in, purchase_rate FROM `purchases` WHERE product_id="'.$id.'"');
        $stockout = DB::select('SELECT SUM(qty) as stockout FROM `packing_consumptions` WHERE bag_id="'.$id.'"');
        $pr = DB::select('SELECT SUM(return_quantity) as val FROM `purchase_returns` WHERE product_id="'.$id.'"');
        $cstock =(($rawProduct->opening_balance+ $stockin[0]->stock_in)-($stockout[0]->stockout +$pr[0]->val ?? 0));

          if($stockin[0]->purchase_rate > 0 || $rawProduct->rate > 0 ){
          $data['stock'] = $cstock;
        } else {
          $data['stock'] = 0;
        }
        $data['name'] = $rawProduct->product_name;
        return response($data);
    }
  	public function getProductWipQty($id){
    	$qty = DB::table('wips')->where('prouct_id',$id)->value('quantity');
      return $qty;
    }

    public function psostore(Request $request)
    {

     //dd($request->all());
     // dd($request->reprocess_qty);
    	if($request->reprocess_finish_goods_id){
      	$reStockin =  SalesStockIn::where('prouct_id',$request->reprocess_finish_goods_id)->orderBy('id','DESC')->first();
      	//dd($reStockin->quantity);
     	if(!empty($reProQty = $reStockin->quantity )) {
      	$reStockin->quantity = $reProQty - $request->reprocess_qty ?? 0;
      	$reStockin->reprocess_qty = $request->reprocess_qty ?? 0;
      	$reStockin->save();
         }
        }
		    $qty = 0;
      	$bag = DB::table('sales_products')->where('id',$request->finish_goods_id)->value('product_weight');
      	$amount = DB::table('ppls')->value('amount');
		      $processLoss = ($request->fg_qty*$amount)/100;
      	//dd($processLoss);

      if(!empty($request->wastage)){
      	$wastage = $request->wastage;
      } else {
        $wastage = 0;
      }

      	if(!empty($request->reject_qty)){
      	$reject_qty = $request->reject_qty;
      } else {
        $reject_qty = 0;
      }

      if(!empty($request->wip_qty)){
        $wip_qty = $request->wip_qty;
        DB::table('wips')->where('prouct_id',$request->finish_goods_id)->delete();
      } else {
       $wip_qty = 0;
      }

      	$temp = $wastage + $reject_qty + $wip_qty;
      	$qty = ($temp+$request->fg_qty)/$bag;

      	$invoice = PurchaseStockout::latest('id')->first();
        if($invoice){
        	$sout_number = 'PRO-'.+10000 + $invoice->id +1;
        }
        else{
        	$sout_number = 'PRO-10000';
        }

		$expireDay =  date('Y-m-d', strtotime(date('Y-m-d'). ' + '. $request->expire_date .' days'));
        $tatal_cost =0;
        $totalManuFacturingCostOfRM = 0;
        foreach($request->product_id as $key=>$prouct_ids)
            {
               // $avgrate = DB::select('SELECT AVG(purchases.purchase_rate) as rate FROM `purchases` WHERE purchases.product_id ="'.$request->product_id[$key].'" ');

               $avgrate = DB::select('SELECT SUM(bill_quantity) as qty, SUM(purchase_value) as value FROM `purchases` WHERE purchases.product_id ="'.$request->product_id[$key].'" ');

                 /* if($avgrate[0]->rate){
                  $rateP = $avgrate[0]->rate;
                  $rateRM = RowMaterialsProduct::where('id',$request->product_id[$key])->value('rate');
                  if($rateRM > 0){
                    $rate = ($rateP+$rateRM)/2;
                  } else {
                    $rate = $rateP;
                  }

                } else {
                  $rate = RowMaterialsProduct::where('id',$request->product_id[$key])->value('rate');
                } */

                if($avgrate[0]->value){
                  $rateRM = RowMaterialsProduct::where('id',$request->product_id[$key])->first();
                  if($rateRM){
                    $openingValue = $rateRM->opening_balance * $rateRM->rate;
                    $openingQty = $rateRM->opening_balance;
                    $rate = ($avgrate[0]->value+$openingValue)/($avgrate[0]->qty+$openingQty);
                  } else {
                    $rate = ($avgrate[0]->value)/($avgrate[0]->qty);
                  }

                } else {
                  $rate = RowMaterialsProduct::where('id',$request->product_id[$key])->value('rate');
                }

                $productionCost = $rate*$request->p_qty[$key];
                $tatal_cost += $productionCost;


         		    $stock_out = new PurchaseStockout;
                $stock_out->date = $request->date;
                $stock_out->referance = $request->referance;
                $stock_out->batch = $request->batch;
                $stock_out->finish_goods_id = $request->finish_goods_id;
                $stock_out->fg_qty = $qty;
           		  $stock_out->fg_out_qty = $qty;
                $stock_out->sout_number = $sout_number;
                //$stock_out->wirehouse_id = $request->wirehouse_id;
                $stock_out->wirehouse_id =  $request->wirehouse_id;
                $stock_out->production_factory_id =  $request->production_factory_id;
                $stock_out->expire_date = $expireDay;
                $stock_out->product_id = $request->product_id[$key];
                $stock_out->stock_opening = $request->stock[$key];
                $stock_out->previous_stock_out_quantity = $request->p_qty[$key];
                $stock_out->stock_out_quantity = $request->p_qty[$key];
                $stock_out->temp_qty = $temp;
                $stock_out->stock_out_rate = $rate;
                $stock_out->total_amount = $productionCost;
                // dd($stock_out);
                $stock_out->save();
            }

            $this->createCreditForRawMaterials('Raw Materials' , $tatal_cost , $request->date, $request->referance, $sout_number);
           // $this->createDebitForFinishedGoods('Work-in-Progress (WIP)' ,  $tatal_cost , $request->date, $request->referance, $sout_number);

            // $this->createCreditForRawMaterials('Work-in-Progress (WIP)' , $tatal_cost , $request->date, $request->referance, $sout_number);
            $this->createDebitForFinishedGoods('Finished Goods' ,  $tatal_cost , $request->date, $request->referance, $sout_number);



//$stock_out->stock_out_quantity = $request->p_qty[$key];
           /*
           $wip = new Wip;
            $wip->date = $request->date;
            $wip->prouct_id = $request->finish_goods_id;
            $wip->quantity = $request->fg_qty;
            $wip->warehouse_id = $request->wirehouse_id;
         	  $wip->production_factory_id =  $request->production_factory_id;
            $wip->expire_date =  $request->expire_date;
            $wip->batch_id = $request->batch;
            $wip->sout_number = $sout_number;
            $wip->total_cost = round($tatal_cost,2);
            $wip->production_rate = round($tatal_cost,2)/$request->fg_qty;
            $wip->status = 1;
            $wip->save();
          */
      		//dd($bag);

          $stockin =   new SalesStockIn;
          $stockin->date = $request->date;
          $stockin->prouct_id = $request->finish_goods_id;
          $stockin->quantity = $qty;
          $stockin->factory_id = $request->wirehouse_id;
       	  $stockin->production_factory_id =  $request->production_factory_id;
          $stockin->expire_date = $expireDay;
          $stockin->batch_id = $request->batch;
          $stockin->sout_number = $sout_number;
          $stockin->total_cost = $tatal_cost;
          $stockin->production_rate = $tatal_cost/$qty;
      	  $stockin->fg_out_qty = $qty;
      	  $stockin->process_loss = $processLoss;
          $stockin->save();

           // return redirect()->back()->with('success', 'Production Stock Out & Sales Stock In Store Successfully');
       return redirect()->route('production.stock.out.invoice.view',$sout_number);
    }

    public function psoEdit($invoice){
      $finishGood = SalesStockIn::where('sout_number',$invoice)->first();
      $rawMaterials = PurchaseStockout::where('sout_number',$invoice)->get();
      $finishedgoods = SalesProduct::all();
      $products = RowMaterialsProduct::all();
      $stores = Factory::all();
      $pfactory = ProductionFactory::all();
      return view('backend.production.auto_production_stock_out_edit', compact('finishGood','rawMaterials','products', 'stores', 'finishedgoods','pfactory','invoice'));

    }

      public function psoUpdate (Request $request){
      //dd($request->all());
      $invoice = $request->invoice;
      $qty = 0;
      $bag = DB::table('sales_products')->where('id',$request->finish_goods_id)->value('product_weight');
      $qty = $request->fg_qty;

      $expireDay =  date('Y-m-d', strtotime(date('Y-m-d'). ' + '. $request->expire_date .' days'));
          $tatal_cost =0;
          $totalManuFacturingCostOfRM = 0;
          foreach($request->product_id as $key=>$prouct_ids)
              {
                $stock_out = PurchaseStockout::where('sout_number',$invoice)->first();
                 $avgrate = DB::select('SELECT SUM(bill_quantity) as qty, SUM(purchase_value) as value FROM `purchases` WHERE purchases.product_id ="'.$request->product_id[$key].'" ');
                  if($avgrate[0]->value){
                    $rateRM = RowMaterialsProduct::where('id',$request->product_id[$key])->first();
                    if($rateRM){
                      $openingValue = $rateRM->opening_balance * $rateRM->rate;
                      $openingQty = $rateRM->opening_balance;
                      $rate = ($avgrate[0]->value+$openingValue)/($avgrate[0]->qty+$openingQty);
                    } else {
                      $rate = ($avgrate[0]->value)/($avgrate[0]->qty);
                    }

                  } else {
                    $rate = RowMaterialsProduct::where('id',$request->product_id[$key])->value('rate');
                  }

                  //dd($stock_out->stock_out_quantity);
                  $productionCost = $rate * $stock_out->stock_out_quantity;
                  $tatal_cost += $productionCost;



                  $stock_out->date = $request->date;
                  $stock_out->referance = $request->referance;
                  $stock_out->batch = $request->batch;
                  $stock_out->finish_goods_id = $request->finish_goods_id;
                  $stock_out->fg_qty = $qty;
                  $stock_out->fg_out_qty = $qty;
                  //$stock_out->sout_number = $sout_number;
                  $stock_out->wirehouse_id =  $request->wirehouse_id;
                  $stock_out->production_factory_id =  $request->production_factory_id;
                  $stock_out->expire_date = $expireDay;
                  $stock_out->product_id = $request->product_id[$key];
                //  $stock_out->stock_opening = $request->stock[$key];
                //  $stock_out->previous_stock_out_quantity = $request->p_qty[$key];
                //  $stock_out->stock_out_quantity = $request->p_qty[$key];
                //  $stock_out->temp_qty = $temp;
                  $stock_out->stock_out_rate = $rate;
                  $stock_out->total_amount = $productionCost;
                  // dd($stock_out);
                  $stock_out->save();
              }
              $rawM =   ChartOfAccounts::where('invoice',$invoice)->where('ac_individual_account_id',114)->first();
              $rawM->credit = $tatal_cost;
              $rawM->save();

              $fg =   ChartOfAccounts::where('invoice',$invoice)->where('ac_individual_account_id',94)->first();
              $fg->debit = $tatal_cost;
              $fg->save();

              
              $stockin =  SalesStockIn::where('sout_number',$invoice)->first();
              $stockin->date = $request->date;
              $stockin->prouct_id = $request->finish_goods_id;
              $stockin->quantity = $qty;
              $stockin->factory_id = $request->wirehouse_id;
           	  $stockin->production_factory_id =  $request->production_factory_id;
              $stockin->expire_date = $expireDay;
              $stockin->batch_id = $request->batch;
              $stockin->sout_number = $invoice;
              $stockin->total_cost = $tatal_cost;
              $stockin->production_rate = $tatal_cost/$qty;
          	  $stockin->fg_out_qty = $qty;
          	  //$stockin->process_loss = $processLoss;
              $stockin->save();

               // return redirect()->back()->with('success', 'Production Stock Out & Sales Stock In Store Successfully');
           return redirect()->route('production.stock.out.invoice.view',$invoice);

    }

  		public function psoListManual(){
         // $finishGoods = DB::table('sales_stock_ins')->select()->
          $date = '2023-07-01';
        $rawMaterials =   DB::select('SELECT DISTINCT purchase_stockouts.sout_number,purchase_stockouts.id,purchase_stockouts.date,r.product_name,purchase_stockouts.fg_qty,factories.factory_name as wirehouse_name,SUM(purchase_stockouts.stock_out_quantity) as qty FROM `purchase_stockouts`
            LEFT JOIN factories ON factories.id = purchase_stockouts.wirehouse_id
            LEFT JOIN row_materials_products as r ON r.id = purchase_stockouts.product_id
            WHERE purchase_stockouts.date >= "'.$date.'"
            GROUP BY purchase_stockouts.product_id order by date desc, sout_number desc');

           $finishGoods =   DB::select('SELECT DISTINCT sales_stock_ins.sout_number,sales_stock_ins.id, sales_stock_ins.date,s.product_name,s.id as product_id,factories.factory_name as wirehouse_name,sales_stock_ins.quantity  FROM `sales_stock_ins`
            LEFT JOIN factories ON factories.id = sales_stock_ins.factory_id
            LEFT JOIN sales_products as s ON s.id = sales_stock_ins.prouct_id
            WHERE sales_stock_ins.date >= "'.$date.'"
            order by date desc, sout_number desc');

        return view('backend.production.manual_production_stock_out_list', compact('finishGoods','rawMaterials'));
        }

        public function psoSTockInInvoiceview($invoice){
            // dd($invoice);
            $data = SalesStockIn::select('f.factory_name as name')->where('sout_number',$invoice)
              		->leftjoin('factories as f','f.id','=','sales_stock_ins.factory_id')->first();
          	$fGoods = SalesStockIn::select('s.product_name as name','s.product_dp_price as price','sales_stock_ins.date','sales_stock_ins.quantity as qty')->leftjoin('sales_products as s' ,'s.id','=','sales_stock_ins.prouct_id')->where('sout_number',$invoice)->get();
            $rowProducts = PurchaseStockout::select('r.product_name as name','r.rate','purchase_stockouts.date','purchase_stockouts.stock_out_quantity as qty','purchase_stockouts.stock_out_rate')
              			->leftjoin('row_materials_products as r' ,'r.id','=','purchase_stockouts.product_id')->where('sout_number',$invoice)->get();
          //dd($rowProducts);
            return view('backend.production.manual_production_stock_in_invoice_view', compact('invoice','data','fGoods','rowProducts'));
        }

  		public function psoFGEdit($invoice){
        //dd($invoice);
          $data = SalesStockIn::where('sout_number',$invoice)->first();
          $finishedgoods = SalesProduct::all();
          $products = RowMaterialsProduct::all();
          $stores = Factory::all();
          $pfactory = ProductionFactory::all();
          $fGoods = SalesStockIn::select('s.*','sales_stock_ins.id as fgId','sales_stock_ins.quantity as qty')->leftjoin('sales_products as s' ,'s.id','=','sales_stock_ins.prouct_id')->where('sout_number',$invoice)->orderby('s.product_name', 'ASC')->get();
          $rowProducts = PurchaseStockout::select('r.*','purchase_stockouts.id as rmId','purchase_stockouts.stock_out_quantity as qty')->leftjoin('row_materials_products as r' ,'r.id','=','purchase_stockouts.product_id')->where('sout_number',$invoice)->orderby('r.product_name','ASC')->get();

          return view('backend.production.manual_production_stock_out_list_edit', compact('invoice','data','finishedgoods','pfactory','stores','products','fGoods','rowProducts'));
        }

  		public function psoUpdateManual(Request $request){
        // dd($request->all());
          $invoice = $request->invoice;
          $expireDay =  date('Y-m-d', strtotime(date('Y-m-d'). ' + '. $request->expire_date .' days'));
          $tatal_cost =0;
          SalesStockIn::where('sout_number',$invoice)->delete();

              foreach($request->finish_goods_id as $key => $fg_ids)
                {
                $stockin =   new SalesStockIn;
                $stockin->date = $request->date;
                $stockin->prouct_id = $request->finish_goods_id[$key];
                $stockin->quantity = $request->fg_qty[$key];
                $stockin->factory_id = $request->wirehouse_id;
                $stockin->production_factory_id =  $request->production_factory_id;
                $stockin->expire_date = $expireDay;
                $stockin->sout_number = $invoice;
                $stockin->fg_out_qty = $request->fg_qty[$key];
                $stockin->save();
            }

       		PurchaseStockout::where('sout_number',$invoice)->delete();
          	foreach($request->product_id as $key=>$prouct_ids)
            {
              	$rate =0;
                $avgrate = DB::select('SELECT AVG(purchases.purchase_rate) as rate FROM `purchases` WHERE purchases.product_id ="'.$request->product_id[$key].'" ');
                $openingRate = DB::table('row_materials_products')->where('id',$request->product_id[$key])->value('rate');
          		$rate = ($openingRate+$avgrate[0]->rate)/2;
          		//$tatal_cost += $rate*$request->p_qty[$key];
         		$stock_out = new PurchaseStockout;
                $stock_out->date = $request->date;
                $stock_out->referance = $request->referance;
                $stock_out->sout_number = $invoice;
                $stock_out->wirehouse_id =  $request->wirehouse_id;
                $stock_out->production_factory_id =  $request->production_factory_id;
                $stock_out->expire_date = $expireDay;
                $stock_out->product_id = $request->product_id[$key];
                $stock_out->stock_opening = $request->stock[$key];
                $stock_out->stock_out_quantity = $request->p_qty[$key];
                $stock_out->stock_out_rate = $rate;
                $stock_out->total_amount = $rate*$request->p_qty[$key];
                $stock_out->save();
          }
          return redirect()->back()->with('success', 'Production Stock Out & Sales Stock In Update Successfully');
        }

  		public function psoFGDelete($id){
        DB::table('sales_stock_ins')->where('id',$id)->delete();
        return redirect()->back()->with('success', 'Production Delete Successfully');
      	}

  		public function psoRMDelete($id){
        DB::table('purchase_stockouts')->where('id',$id)->delete();
        return redirect()->back()->with('success', 'Production Delete Successfully');
      	}

      public function psoStoreManual(Request $request){
        //dd($request->all());
        $invoice = PurchaseStockout::latest('id')->first();
        if($invoice){
        	$sout_number = 10000 + $invoice->id +1;
        }
        else{
        	$sout_number = 10000;
        }

		$expireDay =  date('Y-m-d', strtotime(date('Y-m-d'). ' + '. $request->expire_date .' days'));
        $tatal_cost =0;

        foreach($request->product_id as $key=>$prouct_ids)
            {
          		$rate = 0;
                $avgrate = DB::select('SELECT AVG(purchases.purchase_rate) as rate FROM `purchases` WHERE purchases.product_id ="'.$request->product_id[$key].'" ');
                $openingRate = DB::table('row_materials_products')->where('id',$request->product_id[$key])->value('rate');
          		$rate = ($openingRate+$avgrate[0]->rate)/2;
          		//$tatal_cost += $rate*$request->p_qty[$key];
         		$stock_out = new PurchaseStockout;
                $stock_out->date = $request->date;
                $stock_out->referance = $request->referance;
               // $stock_out->batch = $request->batch;
                //$stock_out->finish_goods_id = $request->finish_goods_id;
               // $stock_out->fg_qty = $qty;
           		//$stock_out->fg_out_qty = $qty;
                $stock_out->sout_number = $sout_number;
                $stock_out->wirehouse_id =  $request->wirehouse_id;
                $stock_out->production_factory_id =  $request->production_factory_id;
                $stock_out->expire_date = $expireDay;
                $stock_out->product_id = $request->product_id[$key];
                $stock_out->stock_opening = $request->stock[$key];
                $stock_out->stock_out_quantity = $request->p_qty[$key];
                //$stock_out->temp_qty = $temp;
                $stock_out->stock_out_rate = $rate;
                $stock_out->total_amount =$rate*$request->p_qty[$key];
                // dd($stock_out);
                $stock_out->save();
            }

         foreach($request->finish_goods_id as $key2 => $fg_ids)
            {
        	$stockin =   new SalesStockIn;
            $stockin->date = $request->date;
            $stockin->prouct_id = $request->finish_goods_id[$key2];
            $stockin->quantity = $request->fg_qty[$key2];
            $stockin->factory_id = $request->wirehouse_id;
            $stockin->production_factory_id =  $request->production_factory_id;
            $stockin->expire_date = $expireDay;
            $stockin->sout_number = $sout_number;
            $stockin->fg_out_qty = $request->fg_qty[$key2];
            $stockin->save();
      }
        return redirect()->back()->with('success', 'Production Stock Out & Sales Stock In Store Successfully');
      }

    public function psocheckout($invoice)
    {
       // dd($invoice);
       /* $stock_out = DB::select('SELECT purchase_stockouts.*,row_materials_products.product_name, sales_stock_ins.*, factories.factory_name as wirehouse_name FROM `purchase_stockouts`
       	LEFT JOIN row_materials_products ON row_materials_products.id = purchase_stockouts.product_id
        LEFT JOIN factories ON factories.id = purchase_stockouts.wirehouse_id
        LEFT JOIN sales_stock_ins ON sales_stock_ins.sout_number = purchase_stockouts.sout_number
        WHERE purchase_stockouts.sout_number = "'.$invoice.'"'); */
        $stock_out = DB::table('purchase_stockouts')->select('purchase_stockouts.*')
              ->leftJoin('row_materials_products', 'row_materials_products.id', '=', 'purchase_stockouts.product_id')
              ->where('purchase_stockouts.sout_number',$invoice)->get();
     //$val =  DB::table('sales_stock_ins')->where('sout_number',10838)->first();
	//	dd($val);
       $finishedgoods = SalesProduct::all();
       $products = RowMaterialsProduct::all();
       $stores = Factory::all();
      //dd($stock_out);
       return view('backend.production.invoice_checkout', compact('stock_out','products', 'stores', 'finishedgoods'));
    }
/*
    public function psoupdate(Request $request)
    {
    	//dd($request->all());
      //dd($request->total_qty);
      //	PurchaseStockout::where('sout_number', $request->sout_number)->delete();

        if($request->reprocess_finish_goods_id){
      	$reStockin =  SalesStockIn::where('prouct_id',$request->reprocess_finish_goods_id)->orderBy('id','DESC')->first();
      	//dd($reStockin->quantity);
     	if(!empty($reProQty = $reStockin->quantity )) {
      	$reStockin->quantity = $reProQty - $request->reprocess_qty ?? 0;
      	$reStockin->reprocess_qty = $request->reprocess_qty ?? 0;
      	$reStockin->save();
         }
        }

      	DB::table('wips')->insert([
          	'prouct_id' => $request->finish_goods_id,
          	'quantity' => $request->wip_qty,
      		'date' => $request->date,
      		'sout_number' => $request->sout_number,
      		'status' => 1]);

       	$tatal_cost = 0;
      	$totalQty = 0;
      	$process_loss = $request->process_loss ?? 0;
        $wastage = $request->wastage ?? 0;
        $reject_qty = $request->reject_qty ?? 0;
      	$totalQty = $request->fg_out_qty - ($process_loss + $wastage + $reject_qty+$request->wip_qty);
      	$qty =  $totalQty/$request->weight;
      //dd($qty);
        foreach($request->product_id as $key=>$prouct_ids)
            {
               $avgrate = DB::select('SELECT SUM(bill_quantity) as qty, SUM(purchase_value) as value FROM `purchases` WHERE purchases.product_id ="'.$request->product_id[$key].'" ');

                if($avgrate[0]->value){
                  $rateRM = RowMaterialsProduct::where('id',$request->product_id[$key])->first();
                  if($rateRM){
                    $openingValue = $rateRM->opening_balance * $rateRM->rate;
                    $openingQty = $rateRM->opening_balance;
                    $rate = ($avgrate[0]->value+$openingValue)/($avgrate[0]->qty+$openingQty);
                  } else {
                    $rate = ($avgrate[0]->value)/($avgrate[0]->qty);
                  }

                } else {
                  $rate = RowMaterialsProduct::where('id',$request->product_id[$key])->value('rate');
                }


                $tatal_cost += round($rate*$request->p_qty[$key],2);
         		//$stock_out = new PurchaseStockout;
          		$stock_out = PurchaseStockout::where('sout_number',$request->sout_number)->where('product_id',$prouct_ids)->first();

          		if(!empty($stock_out)){
                $stock_out->date = $request->date;
                $stock_out->referance = $request->referance;
                $stock_out->batch = $request->batch;
                $stock_out->finish_goods_id = $request->finish_goods_id;
                $stock_out->fg_qty = $request->fg_qty;
                $stock_out->fg_out_qty = $qty;
                $stock_out->sout_number = $request->sout_number;
                $stock_out->wirehouse_id =  $request->wirehouse_id;
                $stock_out->product_id = $request->product_id[$key];
          		$stock_out->previous_stock_out_quantity = $stock_out->stock_out_quantity;
                $stock_out->stock_out_quantity = $request->p_qty[$key];
                $stock_out->stock_out_rate = $rate;
          		//$stock_out->previous_total_amount = $stock_out->total_amount;
                $stock_out->total_amount = $rate*$request->p_qty[$key];
                $stock_out->note = $request->note;
                // dd($stock_out);
                $stock_out->save();
                  } else {
                  $stock_out_pro = new PurchaseStockout;
               	$stock_out_pro->date = $request->date;
                $stock_out_pro->referance = $request->referance;
                $stock_out_pro->batch = $request->batch;
                $stock_out_pro->finish_goods_id = $request->finish_goods_id;
                $stock_out_pro->fg_qty = $request->fg_qty;
                $stock_out_pro->fg_out_qty = $qty;
                $stock_out_pro->sout_number = $request->sout_number;
                $stock_out_pro->wirehouse_id =  $request->wirehouse_id;
                $stock_out_pro->product_id = $request->product_id[$key];
          		$stock_out_pro->previous_stock_out_quantity = 0 ;
                $stock_out_pro->stock_out_quantity = $request->p_qty[$key];
                $stock_out_pro->stock_out_rate = $rate;
                $stock_out_pro->total_amount = $rate*$request->p_qty[$key];
                $stock_out_pro->note = $request->note;
                $stock_out_pro->save();
                }
            }


          $stockin =  SalesStockIn::where('sout_number',$request->sout_number)->first();
          $stockin->date = $request->date;
          $stockin->prouct_id = $request->finish_goods_id;
          $stockin->quantity = $qty;
          $stockin->factory_id = $request->wirehouse_id;
          $stockin->batch_id = $request->batch;
          $stockin->sout_number = $request->sout_number;
          $stockin->total_cost = round($tatal_cost,2);
          $stockin->production_rate = round($tatal_cost/$request->total_qty,2);
          $stockin->fg_out_qty = $qty;
          $stockin->referance = $request->referance;
          //$stockin->process_loss = $request->process_loss ?? $stockin->process_loss;
          $stockin->wastage = $request->wastage ?? $stockin->wastage;
      	  $stockin->reject_qty = $request->reject_qty ?? $stockin->reject_qty;
          $stockin->note = $request->note;
          $stockin->save();
          return redirect()->back()->with('success', 'Production Stock Out Update Successfully');
    }
*/
	public function newTab(){
    return "Production Stock Out Delete Successfully";
    }

    public function psodelete(Request $request)
    {
            // ChartOfAccounts::where('invoice',$request->invoice)->delete();
             PurchaseStockout::where('sout_number', $request->invoice)->delete();
			 Wip::where('sout_number', $request->invoice)->delete();
      		 SalesStockIn::where('sout_number',$request->invoice)->delete();

       // return redirect()->route('production.stock.out.newTab');
            return redirect()->back()->with('success', 'Production Stock Out Delete Successfully');
      		//return redirect()->away('https://www.google.com');
    }

  public function psoInvoiceDelete($invoice){
    //dd($invoice);
    ChartOfAccounts::where('invoice',$invoice)->delete();
    PurchaseStockout::where('sout_number', $invoice)->delete();
	Wip::where('sout_number', $invoice)->delete();
    SalesStockIn::where('sout_number',$invoice)->delete();

    return redirect()->back()->with('success', 'Production Stock Out Delete Successfully');
  }

   public function autopsocreate()
    {
     //   $finishedgoods = SalesProduct::all();
        $products = RowMaterialsProduct::all();
        $stores = Factory::all();
        $pfactory = ProductionFactory::all();

        $finishedgoods =   FinishedGoodSet::select('finished_good_sets.fg_id as id','sales_products.product_name')
       			->leftjoin('sales_products','sales_products.id','finished_good_sets.fg_id')
       			->groupby('fg_id')->get();

        return view('backend.production.auto_production_stock_out_create', compact('products', 'stores', 'finishedgoods','pfactory'));
    }

  public function ppLossIndex(){
	$datas = DB::table('ppls')->get();
    //dd($datas);
    return view('backend.production.ppls_index', compact('datas'));
  }

  public function ppLossStore(Request $request){
	DB::table('ppls')->insert([
    'amount' => $request->amount,
    'created_at' => date('Y-m-d H:i:s'),
     'updated_at' => date('Y-m-d H:i:s')
    ]);
     return redirect()->route('production.process.loss.list')->with('success', 'Production Process Loss Set Successfully');
  }

  public function ppLossEdit($id){
  $data = DB::table('ppls')->where('id',$id)->first();
    return view('backend.production.ppls_edit', compact('data'));
  }

  public function ppLossUpdate(Request $request){
  	DB::table('ppls')->where('id',$request->id)->update([
    'amount' => $request->amount,
    ]);
     return redirect()->route('production.process.loss.list')->with('success', 'Production Process Loss Set Update Successfully');
  }

  public function ppLossDelete(Request $request){
  	DB::table('ppls')->where('id', $request->id)->delete();
   return redirect()->back()->with('success', 'Production Process Loss Set Delete Successfully.');
  }

   public function fgsetindex(Request $request)
    {
     $data = FinishedGoodSet::select('finished_good_sets.invoice','finished_good_sets.fg_id','finished_good_sets.fg_qty','sales_products.product_name as fg_name')
       			->leftjoin('sales_products','sales_products.id','finished_good_sets.fg_id')
       			->groupby('invoice')->get();
       // dd($data);
        return view('backend.production.fg_set_list', compact('data'));
    }


   public function fgsetcreate()
    {
        $finishedgoods = SalesProduct::all();
        $products = RowMaterialsProduct::all();
        $stores = Factory::all();
        $pfactory = ProductionFactory::all();
        return view('backend.production.fg_set_create', compact('products', 'stores', 'finishedgoods','pfactory'));
    }



   public function fgsetstore(Request $request)
    {
	//dd($request->all());
     $invoice = FinishedGoodSet::latest('id')->first();


        if($invoice){
        	$inv = 10000 + $invoice->id +1;
        }
        else{
        	$inv = 10000;
        }


        foreach($request->product_id as $key=>$prouct_ids)
            {
         		$stock_out = new FinishedGoodSet;
                $stock_out->invoice = $inv;
                $stock_out->fg_id = $request->finish_goods_id;
                $stock_out->fg_qty = 1;
                $stock_out->rm_id = $request->product_id[$key];
                $stock_out->rm_qty = $request->p_qty[$key]/$request->fg_qty;
                $stock_out->save();

            }

            return redirect()->route('production.fg.set.list')->with('success', 'Finised Goods Set Successfully');
    }



    public function getfgsetdata($id)
    {
     $data =  DB::table('finished_good_sets')->select('finished_good_sets.*','row_materials_products.product_name')
                     ->leftjoin('row_materials_products','row_materials_products.id','finished_good_sets.rm_id')
       				->where('fg_id',$id)->get();

       // dd($data);

        return response($data);
    }

  public function fgsetEdit($id){
      $data =  DB::table('finished_good_sets')->where('fg_id',$id)->first();
      //dd($data);
      $finishedgoods = SalesProduct::all();
      $products = RowMaterialsProduct::all();
      $stores = Factory::all();
      $pfactory = ProductionFactory::all();
      return view('backend.production.fg_set_edit', compact('data','products', 'stores', 'finishedgoods','pfactory'));

  }

  public function fgsetUpdate(Request $request){
  //dd($request->all());
   	$invoice = '';
     if($request->new_product == 0 ){
	 foreach($request->product_id as $key=>$prouct_ids)
            {

                //$stock_out->invoice = $inv;

                $stock_out = FinishedGoodSet::where('id', $request->id[$key])->first();
                        $stock_out->fg_id = $request->finish_goods_id;
                        $stock_out->fg_qty = 1;
                        $stock_out->rm_id = $request->product_id[$key];
                        $stock_out->rm_qty = $request->p_qty[$key]/$request->fg_qty;
                        $stock_out->save();
                		$invoice = $stock_out->invoice;
            }

       } else {
       foreach($request->product_id as $key=>$prouct_ids){
                $stock_out_n = new FinishedGoodSet;
                $stock_out_n->invoice = $invoice;
                $stock_out_n->fg_id = $request->finish_goods_id;
                $stock_out_n->fg_qty = 1;
                $stock_out_n->rm_id = $request->product_id[$key];
                $stock_out_n->rm_qty = $request->p_qty[$key]/$request->fg_qty;
                $stock_out_n->save();
       }
              }

            return redirect()->route('production.fg.set.list')->with('success', 'Finised Goods Set Update Successfully');
  }

public function fgsetdelete(Request $request){
	//dd($request->invoice);
   FinishedGoodSet::where('invoice', $request->invoice)->delete();
   return redirect()->back()->with('success', 'Finised Goods Set Delete Successfully.');
}
	public function packinglist(){
    $datas = DB::table('packing_consumptions')->select('sales_products.product_name','row_materials_products.product_name as name','packing_consumptions.*')
      		->leftjoin('sales_products', 'sales_products.id', '=', 'packing_consumptions.product_id')
      		->leftjoin('row_materials_products', 'row_materials_products.id', '=', 'packing_consumptions.bag_id')->orderBy('id','desc')->get();
     // dd($datas);
       return view('backend.packing.index', compact('datas'));
    }
  public function packingcreate(){
  $finishedgoods = SalesProduct::all();
  /*$purchases = DB::table('purchases')->select('purchases.product_id','purchases.purchase_id','row_materials_products.product_name')
            ->leftjoin('row_materials_products', 'row_materials_products.id', '=', 'purchases.product_id')
            ->where('purchases.purchas_unit',"bag")->groupBy('purchases.product_id')->get(); */
    $purchases =  DB::table('row_materials_products')->where('unit','PCS')->get();
    $date = date('Y-m-d');
    $invoices = SalesStockIn::select('sout_number as invoice')->whereNotNull('sout_number')->get();

   /* $invoices = SalesStockIn::select('sout_number as invoice')->where('date',$date)->get();
    $data = [];
    foreach($purchases as $val){
    	$data = $val->purchase_id;
    }
    if(!empty($data)){
      $data = explode(',',$data);
    }*/

    //$data = [58,135];
    //$bagDetails = PurchaseDetail::whereIn('purchase_id',$data)->leftjoin('row_materials_products', 'row_materials_products.id', '=', 'purchase_details.product_id')->groupBy('purchase_details.product_id')->get();
   // $bagDetails = PurchaseDetail::select('purchase_details.product_id')->leftjoin('purchases', 'purchases.purchase_id', '=', 'purchase_details.purchase_id')->groupBy('purchase_details.product_id')->get();
    // dd($bagDetails);
     return view('backend.packing.create', compact('finishedgoods','purchases','invoices'));
  }

  public function packingstore(Request $request){
    // return $request->all();
    $month = date('m', strtotime($request->date));

    foreach($request->product_id as $key => $val){
      // $rate = DB::table('purchases')->where('product_id',$request->bag_id[$key])->whereMonth('date',$month)->avg('purchase_rate');
      $data = DB::table('purchases')->select(DB::raw('SUM(bill_quantity) as qty'),DB::raw('SUM(purchase_value) as amount'))->where('product_id',$request->bag_id[$key])->get();

       /*$rateRaw = RowMaterialsProduct::where('id',$request->bag_id[$key])->value('rate');

        if($data[0]->qty > 1){
            $rate = $data[0]->purchase_rate ?? $data[0]->amount/$data[0]->qty;
            if($rateRaw > 0){
                $rate = ($rate+$rateRaw)/2;
            } else {
                $rate = $rate;
            }
        } else {
            $rate = $rateRaw;
        } */

        $rateRaw = RowMaterialsProduct::where('id',$request->bag_id[$key])->first();
        if($data[0]->qty > 1){
            if($rateRaw){
                $openingQty = $rateRaw->opening_balance;
                $openingValue = $rateRaw->opening_balance * $rateRaw->rate;
                $rate = ($openingValue + $data[0]->amount)/($openingQty + $data[0]->qty);
            } else {
                $rate = $data[0]->amount/$data[0]->qty;
            }
        } else {
            $rate = $rateRaw->rate;
        }

      $amount = $request->qty[$key]*$rate;
      /* $avgrate = DB::select('SELECT AVG(purchases.purchase_rate) as rate FROM `purchases`
        WHERE purchases.product_id ="'.$product->id.'" and purchases.date  "'.$startdate.'" and "'.$tdate.'"'); */


      $id = DB::table('packing_consumptions')->insertGetId([
          'date' => $request->date,
          'pro_invoice' => $request->pro_invoice,
          'product_id' => $val,
          'bag_id' => $request->bag_id[$key],
          'pre_qty' => $request->qty[$key],
          'qty' => $request->qty[$key],
          'rate' => $rate,
          'amount' => $amount,
          'note' => $request->note,
          'status' => 1,
      ]);

       if($id){
            $invoice = 'CBAG-'. $id;
               $bagPurchase = DB::table('packing_consumptions')->where('id',$id)->update([
                  'invoice' => $invoice,
              ]);

        /*$this->createCreditForRawMaterials('Bag' , $rate , $request->date, $request->note, $invoice = 1001);
        $this->createDebitForFinishedGoods('Finished Goods' ,  $rate , $request->date, $request->note, $invoice = 1001);
        */
        $this->createCreditForRawMaterials('Bag' , $amount , $request->date, $request->note, $invoice);
        $this->createDebitForFinishedGoods('Finished Goods' ,  $amount , $request->date, $request->note, $invoice);
    }
    }
     return redirect()->back()->with('success', 'Finised Goods Products Bag Consumption Save Successfully.');
    }
  public function packingEdit($id){
     $packingConsumption = PackingConsumptions::findOrFail($id);
     $finishedgoods = SalesProduct::all();
     $purchases =  DB::table('row_materials_products')->where('unit','PCS')->get();
     /*$purchases = DB::table('purchases')->select('purchases.product_id','purchases.purchase_id','row_materials_products.product_name')
            ->leftjoin('row_materials_products', 'row_materials_products.id', '=', 'purchases.product_id')
            ->where('purchases.purchas_unit',"bag")->groupBy('purchases.product_id')->get(); */
            $invoices = SalesStockIn::select('sout_number as invoice')->whereNotNull('sout_number')->get();
     return view('backend.packing.edit',[
        'finishedgoods' => $finishedgoods,
        'purchases' => $purchases,
        'packingConsumption' => $packingConsumption,
        'invoices' => $invoices
     ]);
  }
  public function packingUpdate(Request $request , $id){
    $packingConsumption = PackingConsumptions::findOrFail($id);
    $month = date('m', strtotime($request->date));
    $invoice = $packingConsumption->invoice;
    //ChartOfAccounts::where('invoice',$invoice)->delete();

    foreach($request->product_id as $key => $val){
      $data = DB::table('purchases')->select(DB::raw('SUM(bill_quantity) as qty'),DB::raw('SUM(purchase_value) as amount'))->where('product_id',$request->bag_id[$key])->get();
        $rateRaw = RowMaterialsProduct::where('id',$request->bag_id[$key])->first();
        if($data[0]->qty > 1){
            if($rateRaw){
                $openingQty = $rateRaw->opening_balance;
                $openingValue = $rateRaw->opening_balance * $rateRaw->rate;
                $rate = ($openingValue + $data[0]->amount)/($openingQty + $data[0]->qty);
            } else {
                $rate = $data[0]->amount/$data[0]->qty;
            }
        } else {
            $rate = $rateRaw->rate;
        }

      /* $avgrate = DB::select('SELECT AVG(purchases.purchase_rate) as rate FROM `purchases`
        WHERE purchases.product_id ="'.$product->id.'" and purchases.date  "'.$startdate.'" and "'.$tdate.'"'); */
        $amount = $request->qty[$key]*$rate;

      /*$packingConsumption->update([
      'date' => $request->date,
      'pro_invoice' => $request->pro_invoice,
      'product_id' => $val,
      'bag_id' => $request->bag_id[$key],
      'qty' => $request->qty[$key],
      'rate' => $rate,
      'amount' => $amount,
      'note' => $request->note,
       'status' => 1,
        ]);*/

        $packingConsumption->pre_qty = $packingConsumption->qty;
        $packingConsumption->qty = $request->qty[$key];
        $packingConsumption->rate = $rate;
        $packingConsumption->pre_amount = $packingConsumption->amount;
        $packingConsumption->amount = $amount;
        $packingConsumption->note = $request->note;
        $packingConsumption->save();

      $bag = ChartOfAccounts::where('invoice',$invoice)->where('ac_individual_account_id',103)->first();
      $bag->credit = $amount;
      $bag->save();

        $fg = ChartOfAccounts::where('invoice',$invoice)->where('ac_individual_account_id',94)->first();
        $fg->debit = $amount;
        $fg->save();

    }
     return redirect()->route('production.packing.consumption.list')->with('success', 'Finised Goods Products Bag Consumption update Successfully.');
  }
  
  public function packingdelete(Request $request){
    //dd($request->id);
    $invoice = DB::table('packing_consumptions')->where('id',$request->id)->value('invoice');
    ChartOfAccounts::where('invoice',$invoice)->delete();
    DB::table('packing_consumptions')->where('id',$request->id)->delete();
    return redirect()->back()->with('danger', 'Finised Goods Products Bag Consumption Delete Successfully.');
    }


  public function reprocessList(){
      //return "Ok";

      $datas = DB::table('reprocess')->select('reprocess.*','s.product_name')->leftjoin('sales_products as s','s.id','reprocess.fg_id')->where('status','1')->orderby('date','desc')->get();

      return view('backend.production.reprocessProductionStockOutList', compact('datas'));

  }

  public function reprocesscreate(){
      $finishedgoods = SalesProduct::all();
        return view('backend.production.reprocessProductionStockOutCreate', compact('finishedgoods'));
  }

  public function reprocessStore(Request $request){

      //dd($request->all());
      $invoice = DB::table('reprocess')->latest('id')->first();


        if($invoice){
        	$inv = 10000 + $invoice->id +1;
        }
        else{
        	$inv = 10000;
        }


        foreach($request->finish_goods_id as $key=>$id)
            {
         		DB::table('reprocess')->insert([
                  'invoice'=>$inv,
                  'date'=>$request->date,
                  'fg_id'=>$id,
                  'quantity'=>$request->qty[$key],
                  'note'=>$request->referance,
                  'status'=>1,
                ]);

            }

            return redirect()->route('reprocess.production.stock.out.list')->with('success', 'Reprocess Finised Goods Items Save Successfully');

  }

  public function reprocessDelete($id){
     DB::table('reprocess')->where('id',$id)->delete();
     return redirect()->back()->with('success', 'Reprocess Finised Goods Item Data Delete Successfully');
  }
}
