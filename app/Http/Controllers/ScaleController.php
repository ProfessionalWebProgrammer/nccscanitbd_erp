<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Factory;
use App\Models\Employee;
use App\Models\Dealer;
use App\Models\Dealer_demand;
use App\Models\Ddl_check_out;
use App\Models\Transaction;
use App\Models\Bank;
use App\Models\Sale;
use App\Models\Returnstbl;
use App\Models\ReturnItem;
use App\Models\Batch;
use App\Models\DeliveryConfirm;
use App\Models\Vehicle;
use App\Models\Demand_number;
use App\Models\User;
use App\Models\Scale;
use App\Models\RowMaterialsProduct;
use App\Models\ScaleRowMaterial;
use App\Models\Ledger;
use App\Models\Supplier;
use Auth;
use DB;
use Session;
use Carbon\Carbon;

class ScaleController extends Controller
{
  public function index()
  {

    $list =  $saleslist = DB::select('SELECT scales.*,(select name from users where id=user_id) as created_by_name FROM `scales`
LEFT JOIN users ON users.id = scales.user_id order by scale_no desc LIMIT 4000');


    return view('backend.scale.index', compact('list'));
  }


  public function scaleSummary()
  {

    $list =  $saleslist = DB::select('SELECT scales.*,(select name from users where id=user_id) as created_by_name FROM `scales`
LEFT JOIN users ON users.id = scales.user_id order by scale_no desc LIMIT 4000');


    return view('backend.scale.scale_summary', compact('list'));
  }

  public function create()
  {

    $id = Auth::id();
    $dealerlogid = Dealer::latest('id')->where('user_id', '=', $id)->get();
    $products = Product::orderBy('product_name', 'ASC')->get();
    $dealers = Dealer::orderBy('d_s_name', 'ASC')->get();
    $employees = Employee::latest('id')->get();
    $factoryes = Factory::latest('id')->get();
    $banks = Bank::latest('id')->get();
    $vehicles = Vehicle::all();
    //dd( $request->all());

    $date = date('d M Y');



    return view('backend.scale.create', compact('products', 'factoryes', 'date', 'dealers', 'dealerlogid', 'employees', 'banks', 'vehicles'));
  }

  public function createcopy(Request $request)
  {
    if ($request->ajax()) {
      $sales = Sale::where('invoice_no', $request->invoice)->first();
      $ledger = DB::table('ledgers as t1')
        ->select('t1.*', 't2.d_s_name', 't3.product_name')
        ->leftjoin('dealers as t2', 't1.vendor_id', '=', 't2.id')
        ->leftjoin('products as t3', 't1.product_id', '=', 't3.id')
        ->where('invoice', $request->invoice)
        ->whereNotNull('product_id')
        ->get();
      $ledgercount = DB::table('ledgers as t1')
        ->where('invoice', $request->invoice)
        ->whereNotNull('product_id')
        ->count();

      $output = '';
      $row = '';

      if (!empty($ledger)) {

        foreach ($ledger as $key => $data) {


          $output      .= '<tr class="test_row_' . $request->invoice . '">';

          if ($key == 0) {
            $output      .= '<input type="hidden" name="invoice[]" value="' . $request->invoice . '" />';
            $output      .= '<td  rowspan="' . $ledgercount . '" > ' . $request->invoice . ' </td>';
            $output      .= '<td rowspan="' . $ledgercount . '" >' . $data->d_s_name . '</td> ';
          }

          $output      .= '<td class="test-product">' . $data->product_name . '</td>';
          $output     .= '<td class="test-qty">' . $data->qty_pcs . '</td>';
          $output     .= '<td class="test-qty_kg">' . $data->qty_kg . '</td>';

          if ($key == 0) {
            $output      .= '<td width="5%" rowspan="' . $ledgercount . '">
                  <button type ="button" class="btn-remove btn btn-sm btn-danger"  data-testid="' . $request->invoice . '">
                  Delete
                  </button>                       
                  </td>';
          }

          $output      .= '</tr>';
        }
      } else {

        $output      .= '<tr> <td colspan="100%"> Invalid Invoice 
            	
                  </td> </tr>';
      }

      //  $output      .= '<tr > <td colspan="100%">  </td> </tr>';

      echo json_encode($output);
    }
  }


  public function scalegenerate(Request $request)
  {
    //   dd($request->all());


    //	$sales_invoice = '';
    //	if(isset($request->invoice)){
    //       $sales_invoice = implode('_',$request->invoice);
    //   }

    // dd($sales_invoice);

    $id = Auth::id();

    $scale_insert = new Scale();
    $scale_insert->user_id = $id;
    $scale_insert->warehouse_id = $request->warehouse_id;
    $scale_insert->date = date('Y-m-d');
    $scale_insert->vehicle = $request->vehicle;
    $scale_insert->driver_name = $request->driver_name;
    $scale_insert->driver_mobile = $request->driver_mobile;
    $scale_insert->unload_weight = $request->unload_weight;
    // $scale_insert->load_weight = $request->load_weight;
    //  $scale_insert->actual_weight = $request->actual_weight;
    //  $scale_insert->sales_invoice = $sales_invoice;
    $scale_insert->save();
    $scale_insert->scale_no = $scale_insert->id + 100000;
    $scale_insert->save();



    return redirect()->route('backend.scale.index')
      ->with('success', 'Scale Create successfully .');
  }

  public function scaleEdit($id)
  {
    //dd($request->all());

    $scale =  Scale::where('scale_no', $id)->first();


    $factoryes = Factory::latest('id')->get();


    return view('backend.scale.edit', compact('scale', 'factoryes'));
  }



  public function scaleEditStore(Request $request)
  {
    //   dd($request->all());


    if ($request->invoice) {

      $sales_invoice = '';
      if (isset($request->invoice)) {
        $sales_invoice = implode('_', $request->invoice);
      }

      // dd($sales_invoice);

      $id = Auth::id();

      $scale_insert = Scale::find($request->id);
      $scale_insert->user_id = $id;
      $scale_insert->vehicle = $request->vehicle;
      $scale_insert->driver_name = $request->driver_name;
      $scale_insert->driver_mobile = $request->driver_mobile;
      $scale_insert->unload_weight = $request->unload_weight;
      $scale_insert->load_weight = $request->load_weight;
      $scale_insert->actual_weight = $request->actual_weight;
      $scale_insert->sales_invoice = $sales_invoice;
      $scale_insert->load_status = 1;
      $scale_insert->save();




      return redirect()->route('backend.scale.index')
        ->with('success', 'Scale Create successfully .');
    } else {

      return redirect()->back();
    }
  }

  public function destroy(Request $request, $id)
  {
    //dd($request->all());

    Scale::where('scale_no', $request->id)->delete();

    return redirect()->route('backend.scale.index')
      ->with('delete', 'Scale Delete  successfully .');
  }

  public function scaleView($id)
  {
    //dd($request->all());

    $scale =  Scale::where('scale_no', $id)->first();

    $sale_items = explode('_', $scale->sales_invoice);


    return view('backend.scale.scale_view', compact('scale', 'sale_items'));
  }


  public function deliveryconfirm($id)
  {


    $scale =  Scale::where('scale_no', $id)->first();

    $sale_items = explode('_', $scale->sales_invoice);


    $uid = Auth::id();
    //dd($id);

    $scale = Scale::where('scale_no', $id)->first();
    $scale->delivery_status = 1;
    $scale->delivery_by = $uid;
    $scale->delivery_at = Carbon::now();
    $scale->save();

    foreach ($sale_items as $invoice) {

      $sales = \App\Models\Sale::where('invoice_no', $invoice)->first();

      $sale = Sale::find($sales->id);
      $sale->delivery = 1;
      $sale->dc_by = $uid;
      $sale->dc_at = Carbon::now();
      $sale->save();
    }


    return view('backend.scale.scale_view', compact('scale', 'sale_items'));
  }


  public function RowMaterialsIndex()
  {

    $list =  $saleslist = DB::select('SELECT scale_row_materials.*,suppliers.supplier_name,row_materials_products.product_name,(select name from users where id=user_id) as created_by_name FROM `scale_row_materials`
LEFT JOIN users ON users.id = scale_row_materials.user_id 
LEFT JOIN suppliers ON suppliers.id = scale_row_materials.supplier_id 
LEFT JOIN row_materials_products ON row_materials_products.id = scale_row_materials.rm_product_id 
order by scale_no desc LIMIT 4000');


    return view('backend.scale.row_materials_index', compact('list'));
  }

  public function RowMaterialsScaleSummary()
  {

    $list =  $saleslist = DB::select('SELECT scale_row_materials.*,suppliers.supplier_name,row_materials_products.product_name,(select name from users where id=user_id) as created_by_name FROM `scale_row_materials`
LEFT JOIN users ON users.id = scale_row_materials.user_id 
LEFT JOIN suppliers ON suppliers.id = scale_row_materials.supplier_id 
LEFT JOIN row_materials_products ON row_materials_products.id = scale_row_materials.rm_product_id 
order by scale_no desc LIMIT 4000');


    return view('backend.scale.row_materials_scale_summary', compact('list'));
  }

  public function RowMaterialsCreate()
  {

    $id = Auth::id();
    $factoryes = Factory::latest('id')->get();

    $date = date('Y-m-d');

    $rm_products = RowMaterialsProduct::orderBy('product_name', 'ASC')->get();

    $suppliers = Supplier::orderBy('supplier_name', 'ASC')->get();

    return view('backend.scale.row_materials_create', compact('rm_products', 'factoryes', 'suppliers', 'date'));
  }

  public function RowMaterialsScalegenerate(Request $request)
  {
    // dd($request->all());



    $id = Auth::id();

    $scale_insert = new ScaleRowMaterial();
    $scale_insert->user_id = $id;
    $scale_insert->warehouse_id = $request->warehouse_id;
    $scale_insert->date = $request->testdate;
    $scale_insert->supplier_id = $request->supplier_id;
    $scale_insert->vehicle = $request->vehicle;
    $scale_insert->unload_weight = $request->unload_weight;
    $scale_insert->load_weight = $request->load_weight;
    $scale_insert->actual_weight = $request->actual_weight;

    $scale_insert->rm_product_id = $request->rm_product_id;
    $scale_insert->chalan_qty = $request->chalan_qty;
    if ($request->unload_weight) {
      $scale_insert->load_status = 0;
    }
    $scale_insert->save();
    $scale_insert->scale_no = $scale_insert->id + 100000;
    $scale_insert->save();



    return redirect()->route('row.materials.scale.index')
      ->with('success', 'Scale Create successfully .');
  }

  public function RowMaterialsView($id)
  {
    //dd($request->all());

    $scale =  ScaleRowMaterial::where('scale_no', $id)
      ->leftJoin('suppliers', 'scale_row_materials.supplier_id', '=', 'suppliers.id')
      ->leftJoin('row_materials_products', 'scale_row_materials.rm_product_id', '=', 'row_materials_products.id')
      ->first();

    // dd($scale);

    return view('backend.scale.row_materials_scale_view', compact('scale'));
  }




  public function RowMaterialsEdit($id)
  {


    $scale = ScaleRowMaterial::where('scale_no', $id)->first();
    //dd($list);

    $factoryes = Factory::latest('id')->get();
    $rm_products = RowMaterialsProduct::orderBy('product_name', 'ASC')->get();

    $suppliers = Supplier::orderBy('supplier_name', 'ASC')->get();

    return view('backend.scale.row_materials_edit', compact('factoryes', 'scale', 'rm_products', 'suppliers'));
  }

  public function RowMaterialsEditStore(Request $request)
  {
    // dd($request->all());



    $id = Auth::id();

    $scale_insert = ScaleRowMaterial::find($request->id);
    $scale_insert->user_id = $id;
    $scale_insert->warehouse_id = $request->warehouse_id;
    $scale_insert->date = $request->testdate;
    $scale_insert->supplier_id = $request->supplier_id;
    $scale_insert->vehicle = $request->vehicle;
    $scale_insert->unload_weight = $request->unload_weight;
    $scale_insert->load_weight = $request->load_weight;
    $scale_insert->actual_weight = $request->actual_weight;
    $scale_insert->rm_product_id = $request->rm_product_id;
    $scale_insert->chalan_qty = $request->chalan_qty;

    if ($request->unload_weight) {
      $scale_insert->load_status = 0;
    }
    $scale_insert->save();




    return redirect()->route('row.materials.scale.index')
      ->with('success', 'Scale Update successfully .');
  }


  public function RowMaterialsDestroy(Request $request)
  {
    //dd($request->all());

    ScaleRowMaterial::where('scale_no', $request->id)->delete();

    return redirect()->route('row.materials.scale.index')
      ->with('success', 'Scale Delete  successfully .');
  }


  public function RowMaterialsDeliveryconfirm($id)
  {





    $uid = Auth::id();
    //dd($id);

    $scale = ScaleRowMaterial::where('scale_no', $id)->first();
    $scale->delivery_status = 1;
    $scale->delivery_by = $uid;
    $scale->delivery_at = Carbon::now();
    $scale->save();




    $scale =  ScaleRowMaterial::where('scale_no', $id)
      ->leftJoin('suppliers', 'scale_row_materials.supplier_id', '=', 'suppliers.id')
      ->leftJoin('row_materials_products', 'scale_row_materials.rm_product_id', '=', 'row_materials_products.id')
      ->first();
    //dd($list);

    return view('backend.scale.row_materials_scale_view', compact('scale'));
  }


  public function ScaleLoadUnloadSummary()
  {

    $scalelist =  $saleslist = DB::select('SELECT scales.*,(select name from users where id=user_id) as created_by_name FROM `scales`
LEFT JOIN users ON users.id = scales.user_id order by scale_no desc LIMIT 4000');


    $scalerowlist =  $saleslist = DB::select('SELECT scale_row_materials.*,suppliers.supplier_name,row_materials_products.product_name,(select name from users where id=user_id) as created_by_name FROM `scale_row_materials`
LEFT JOIN users ON users.id = scale_row_materials.user_id 
LEFT JOIN suppliers ON suppliers.id = scale_row_materials.supplier_id 
LEFT JOIN row_materials_products ON row_materials_products.id = scale_row_materials.rm_product_id 
order by scale_no desc LIMIT 4000');

    $statalload = Scale::where('load_status', 1)->count();
    $statalunload = Scale::where('load_status', 0)->count();

    $srmtatalload = ScaleRowMaterial::where('load_status', 1)->count();
    $srmtatalunload = ScaleRowMaterial::where('load_status', 0)->count();

    //   dd($statalunload);


    return view('backend.scale.load_unload_summary', compact('scalelist', 'scalerowlist', 'srmtatalload', 'srmtatalunload', 'statalload', 'statalunload'));
  }
}
