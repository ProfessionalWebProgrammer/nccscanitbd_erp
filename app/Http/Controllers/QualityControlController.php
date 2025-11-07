<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\QualityControl;
use App\Models\QualityParameter;
use App\Models\SalesProduct;
use App\Models\Supplier;
use App\Models\Factory;
use App\Models\SalesStockIn;
use App\Models\Wip;
use App\Models\SalesCategory;
use App\Models\RowMaterialsProduct;
use Carbon\Carbon;
use Auth;
use DB;

class QualityControlController extends Controller
{
    public function qualityControlList(){
      $qcontrolls = QualityControl::where('item_type',2)->get();
      return view('backend.qc.qc_index',compact('qcontrolls'));
    }

    public function qualityControlCreate(){
      $qcParameters = QualityParameter::where('item_type',2)->get();
      $products = RowMaterialsProduct::all();
      $supplier = Supplier::all();
      $qcTypes = DB::table('qc_parameter_types')->get();
      return view('backend.qc.qc_create',compact('products','supplier','qcParameters','qcTypes'));
    }

    public function qualityControlStore(Request $request){
      //dd($request->all());
      //$data = QualityControl::create($request->all());
      $qc = new QualityControl;
      $qc->item_type = 2;
      $qc->chalan_no = $request->chalan_no;
      $qc->supplier_id = $request->supplier_id;
      $qc->product_id = $request->product_id;
      $qc->qty = $request->qty;
      $qc->status = $request->status;
      $qc->remarks = $request->remarks;
      $qc->save();
      if($qc->save()){
        foreach($request->parameter_id as $key=> $data){
          DB::table('qc_details')->insert([
            'qc_id' => $qc->id,
            'item_type' => 2,
            'parameter_id' => $request->parameter_id[$key],
            'parameter_type_id' => $request->parameter_type_id[$key],
            'standard_qty' => $request->standard_qty[$key],
            'parameter_qty' => $request->parameter_qty[$key]
          ]);
        }
      }

      if($qc->save()){
        return redirect()->route('qualityControlList')->with('success','Qquality Control Create Successfull!');
      } else {
        return redirect()->back()->with('warning','Qquality Control data not Store!');
      }
    }

  public function qualityControlView($id){
  	$data = QualityControl::where('id',$id)->where('item_type',2)->first();
    return view('backend.qc.invoice',compact('data'));
  }

    public function qualityControlEdit($id){
      $data = QualityControl::where('id',$id)->first();
      $qcParameters = QualityParameter::all();
      $products = RowMaterialsProduct::all();
      $supplier = Supplier::all();
      $qcTypes = DB::table('qc_parameter_types')->get();
      return view('backend.qc.qc_edit',compact('data','products','supplier','qcParameters','qcTypes'));
    }
    /*
    DB::table('users')
            ->where('id', $user->id)
            ->update(['active' => true]);
    */
    public function qualityControlUpdate(Request $request, $id){
      //dd($request->all());
      // $qc->update($request->all());

      $qc = QualityControl::find($id);
      $qc->item_type = 2;
      $qc->chalan_no = $request->chalan_no ?? $qc->chalan_no;
      $qc->supplier_id = $request->supplier_id ?? $qc->supplier_id;
      $qc->product_id = $request->product_id ?? $qc->product_id;
      $qc->qty = $request->qty ?? $qc->qty;
      $qc->status = $request->status ?? $qc->status;
      $qc->remarks = $request->remarks ?? $qc->remarks;
      $qc->save();

              if($qc->save()){
                foreach($request->parameter_id as $key=> $data){
                  if(!empty($request->id[$key])){
                    DB::table('qc_details')->where('id', $request->id[$key])->update([
                      'qc_id' => $id,
                      'item_type' => 2,
                      'parameter_id' => $request->parameter_id[$key],
                      'parameter_type_id' => $request->parameter_type_id[$key],
                      'standard_qty' => $request->standard_qty[$key],
                      'parameter_qty' => $request->parameter_qty[$key]
                    ]);
                  } else {
                    DB::table('qc_details')->insert([
                      'qc_id' => $id,
                      'item_type' => 2,
                      'parameter_id' => $request->parameter_id[$key],
                      'parameter_type_id' => $request->parameter_type_id[$key],
                      'standard_qty' => $request->standard_qty[$key],
                      'parameter_qty' => $request->parameter_qty[$key]
                    ]);
                  }

                }
              }


      return redirect()->route('qualityControlList')->with('success','Quality Control Updated Successfull!');
    }

    public function qualityControlDelete(Request $request){

      $id = $request->id;
      $data = QualityControl::where('item_type',2)->destroy($id);
      $del = DB::table('qc_details')->where('qc_id',$id)->delete();
      if($data && $del){
        return redirect()->back()->with('success','Quality Control Deleted successfully!');
      }
    }


    public function qcParameterCreate(){
      $qcParameters = QualityParameter::where('item_type',2)->get();
      return view('backend.qc.qc_parameter_create',compact('qcParameters'));
    }

    public function qcParameterStore(Request $request){
      //dd($request->all());
      $request->validate([
          'name' => 'required'
      ]);

      $data = QualityParameter::create($request->all());
      if($data){
        return redirect()->back()->with('success','Q C Parameter Create Successfull!');
      } else {
        return redirect()->back()->with('warning','Q C Parameter not Store!');
      }

    }

    public function qcParameterEdit($id){
      $data = QualityParameter::where('id',$id)->where('item_type',2)->first();
      // dd($data);
      return view('backend.qc.qc_parameter_edit',compact('data'));
    }

    public function qcParameterUpdate(Request $request, $id){
      //dd($request->all());
      $parameter = QualityParameter::where('item_type',2)->find($id);
      $parameter->name = $request->name ?? $parameter->name;
      $parameter->standard = $request->standard ?? $parameter->standard;
      $parameter->save();
      //$parameter->update($request->all());
      return redirect()->route('qc.parameter.create')->with('success','Q C Parameter Updated Successfull!');
    }

    public function qcParameterDelete(Request $request){
      $id = $request->id;
      $data = QualityParameter::where('item_type',2)->destroy($id);
      if($data){
        return redirect()->back()->with('success','Q C Parameter Deleted successfully!');
      }
    }

  public function qcParameterValue($id){
  $data = DB::table('quality_parameters')->where('id', $id)->where('item_type',2)->value('standard');
    return response($data);
  }

 // F G Product method

   public function fgQualityControlList(){
      $qcontrolls = QualityControl::where('item_type',1)->orderBy('id', 'DESC')->get();
      return view('backend.fg_qc.index',compact('qcontrolls'));
    }

    public function fgQualityControlCreate(){
      $qcParameters = QualityParameter::where('item_type',1)->get();

        $products = DB::table('wips')->select('sales_products.product_name as name','wips.*')
                    ->leftJoin('sales_products', 'sales_products.id', '=', 'wips.prouct_id')->groupBy('wips.prouct_id')->get();
      //dd($products);
      $warehouse = Factory::all();
      $qcTypes = DB::table('qc_parameter_types')->get();
      return view('backend.fg_qc.create',compact('products','warehouse','qcParameters','qcTypes'));
    }

    public function fgQualityControlStore(Request $request){
      //dd($request->all());

      //$data = QualityControl::create($request->all());
      $qc = new QualityControl;
      $qc->item_type = 1;
      $qc->batch_no = $request->batch_no;
      $qc->chalan_no = $request->chalan_no;
      $qc->warehouse_id = $request->warehouse_id;
      $qc->product_id = $request->product_id;
      $qc->qty = $request->qty;
      $qc->status = $request->status;
      $qc->remarks = $request->remarks;
      $qc->save();
      if($qc->save()){
        foreach($request->parameter_id as $key=> $data){
          DB::table('qc_details')->insert([
            'qc_id' => $qc->id,
            'item_type' => 1,
            'parameter_id' => $request->parameter_id[$key],
            'parameter_type_id' => $request->parameter_type_id[$key],
            'standard_qty' => $request->standard_qty[$key],
            'parameter_qty' => $request->parameter_qty[$key]
          ]);
        }
      }

      if($request->status == 1){
        $data = DB::table('wips')->where('batch_id',$request->batch_no)->first();
        
        $stockin =   new SalesStockIn;
        $stockin->date = $data->date;
        $stockin->prouct_id = $data->prouct_id;
        $stockin->quantity = $data->quantity;
        $stockin->factory_id = $data->warehouse_id;
        $stockin->production_factory_id =  $data->production_factory_id;
        $stockin->expire_date =  $data->expire_date;
        $stockin->batch_id = $data->batch_id;
        $stockin->sout_number = $data->sout_number;
        $stockin->total_cost = $data->total_cost;
        $stockin->production_rate = $data->production_rate;
        $stockin->save();
      } else {
        return redirect()->back()->with('warning',' Rejected & F G Qquality Control data not Store in Sales Stock!');
      }

      if($qc->save()){
        return redirect()->route('fgQualityControlList')->with('success','F G Qquality Control Create Successfull!');
      } else {
        return redirect()->back()->with('warning','F G Qquality Control data not Store!');
      }
    }

  public function fgQualityControlView($id){
  	$data = QualityControl::where('id',$id)->where('item_type',1)->first();
    return view('backend.fg_qc.invoice',compact('data'));
  }


  public function fgQualityControlEdit($id){
    $data = QualityControl::where('id',$id)->first();
    $qcParameters = QualityParameter::all();
    //$products = RowMaterialsProduct::all();
    //$products = SalesProduct::all();
    $products = DB::table('wips')->select('sales_products.product_name as name','wips.*')
                ->leftJoin('sales_products', 'sales_products.id', '=', 'wips.prouct_id')->groupBy('wips.prouct_id')->get();

    $qcTypes = DB::table('qc_parameter_types')->get();
    $warehouse = Factory::all();
    //$supplier = Supplier::all();
    return view('backend.fg_qc.edit',compact('data','products','qcParameters','qcTypes','warehouse'));
  }
  /*
  DB::table('users')
          ->where('id', $user->id)
          ->update(['active' => true]);
  */
  public function fgQualityControlUpdate(Request $request, $id){
    //dd($request->all());
    // $qc->update($request->all());

    $qc = QualityControl::find($id);
    $qc->item_type = 1;
    $qc->chalan_no = $request->chalan_no ?? $qc->chalan_no;
    $qc->batch_no = $request->batch_no ?? $qc->batch_no;
    $qc->warehouse_id = $request->warehouse_id ?? $qc->warehouse_id;
    $qc->product_id = $request->product_id ?? $qc->product_id;
    $qc->qty = $request->qty ?? $qc->qty;
    $qc->status = $request->status ?? $qc->status;
    $qc->remarks = $request->remarks ?? $qc->remarks;
    $qc->save();

            if($qc->save()){
              foreach($request->parameter_id as $key=> $data){
                if(!empty($request->id[$key])){
                  DB::table('qc_details')->where('id', $request->id[$key])->update([
                    'qc_id' => $id,
                    'item_type' => 1,
                    'parameter_id' => $request->parameter_id[$key],
                    'parameter_type_id' => $request->parameter_type_id[$key],
                    'standard_qty' => $request->standard_qty[$key],
                    'parameter_qty' => $request->parameter_qty[$key]
                  ]);
                } else {
                  DB::table('qc_details')->insert([
                    'qc_id' => $id,
                    'item_type' => 1,
                    'parameter_id' => $request->parameter_id[$key],
                    'parameter_type_id' => $request->parameter_type_id[$key],
                    'standard_qty' => $request->standard_qty[$key],
                    'parameter_qty' => $request->parameter_qty[$key]
                  ]);
                }

              }
            }


    return redirect()->route('fgQualityControlList')->with('success','F G Quality Control Updated Successfull!');
  }


    public function fgQualityControlDelete(Request $request){

      $id = $request->id;
      $data = QualityControl::where('item_type',1)->destroy($id);
      $del = DB::table('qc_details')->where('qc_id', $id)->delete();
      if($data && $del){
        return redirect()->back()->with('success','F G Quality Control Deleted successfully!');
      }
    }


    public function fgQcParameterCreate(){
      $qcParameters = QualityParameter::where('item_type','=','1')->get();
      return view('backend.fg_qc.parameter_create',compact('qcParameters'));
    }

    public function fgQcParameterStore(Request $request){
      //dd($request->all());
      $request->validate([
          'name' => 'required'
      ]);

      $data = QualityParameter::create($request->all());
      if($data){
        return redirect()->back()->with('success','F G Q C Parameter Create Successfull!');
      } else {
        return redirect()->back()->with('warning','F G Q C Parameter not Store!');
      }

    }

    public function fgQcParameterEdit($id){
      $data = QualityParameter::where('id',$id)->where('item_type',1)->first();
      // dd($data);
      return view('backend.fg_qc.parameter_edit',compact('data'));
    }

    public function fgQcParameterUpdate(Request $request, $id){
      //dd($request->all());
      $parameter = QualityParameter::where('item_type',1)->find($id);
      $parameter->name = $request->name ?? $parameter->name;
      $parameter->standard = $request->standard ?? $parameter->standard;
      $parameter->save();
      //$parameter->update($request->all());
      return redirect()->route('fg.qc.parameter.create')->with('success','F G Q C Parameter Updated Successfull!');
    }

    public function fgQcParameterDelete(Request $request){
      $id = $request->id;
      $data = QualityParameter::where('item_type',1)->destroy($id);
      if($data){
        return redirect()->back()->with('success','F G Q C Parameter Deleted successfully!');
      }
    }

  public function fgQcParameterValue($id){
  $data = DB::table('quality_parameters')->where('id', $id)->where('item_type',1)->value('standard');
    return response($data);
  }


}
