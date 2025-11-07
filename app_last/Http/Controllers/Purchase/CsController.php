<?php

namespace App\Http\Controllers\Purchase;

use DB;
use Auth;
use Session;
use Carbon\Carbon;
use App\Models\Cs;
use App\Models\Requisition;
use App\Models\Rfq;
use App\Models\RowMaterialsProduct;
use App\Models\SalesProduct;
use App\Models\Supplier;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      $data = Cs::orderBy('id', 'DESC')->get();
      return view('backend.cs.index',compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //$products = SalesProduct::all();
      	$products = RowMaterialsProduct::all();
      	$suppliers = Supplier::all();
      	$rfqs = Rfq::select('invoice')->whereNotNull('invoice')->whereNotNull('pr_no')->get();
        return view('backend.cs.create',compact('products','suppliers','rfqs'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      //dd($request->all());
      $in = DB::table('css')->latest('id')->first();
       $temp = 0;
          if ($in) {
            $temp = 10000 + $in->id;
              $invoice = 'Cs-'.$temp;
          } else {
              $invoice = Cs-10001;
          }
        //dd($invoice);
      
      $pr_no = Rfq::where('invoice',$request->rfq_no)->value('pr_no');
      //$pr_no = Requisition::where('invoice',);
      DB::table('css')->insert([
        'pr_no' => $pr_no,
        'rfq_no' => $request->rfq_no,
        'invoice' => $invoice,
        'issue_date' => $request->issue_date,  
        'item' => $request->item,
        'qty' => $request->qty,
        'unit' => $request->unit,
        'supplier1' => $request->supplier1,
        'rate1' => $request->rate1,
        'supplier2' => $request->supplier2,
        'rate2' => $request->rate2,
        'supplier3' => $request->supplier3,
        'rate3' => $request->rate3,
        'supplier4' => $request->supplier4,
        'rate4' => $request->rate4,
        'specification' => $request->specification,
        'description' => $request->description,
      ]);
          return redirect()->back()->with('success','CS Create Successfull');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
      $data = Cs::where('id', $id)->first();
      return view('backend.cs.invoice',compact('data'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
       //$products = SalesProduct::all();
        $products = RowMaterialsProduct::all();
        $data = Cs::where('id', $id)->first();
        $rfqs = Rfq::select('invoice')->whereNotNull('invoice')->get();
        return view('backend.cs.edit',compact('products','data','rfqs'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // $data = $request->all();
      if(!empty($request->selected)){
      $data = explode(' - ', $request->selected);
        $supplier = $data[0];
        $rate = $data[1];
      } else {
        $supplier = '';
        $rate = '';
      }
        
      
      	if(!empty($request->rfq_no)){
        	$pr_no = Rfq::where('invoice',$request->rfq_no)->value('pr_no');
        } else {
         $pr_no = '';
        }
        
      
        $cs = Cs::findOrFail($id);
      	$cs->pr_no = $pr_no ?? $cs->pr_no;
        $cs->rfq_no = $request->rfq_no ?? $cs->rfq_no;
        $cs->issue_date = $request->issue_date;
        $cs->supplier1 = $request->supplier1;
        $cs->rate1 = $request->rate1;
        $cs->supplier2 = $request->supplier2;
        $cs->rate2 = $request->rate2;
        $cs->supplier3 = $request->supplier3;
        $cs->rate3 = $request->rate3;
        $cs->supplier4 = $request->supplier4;
        $cs->rate4 = $request->rate4;
        $cs->item = $request->item;
        $cs->unit = $request->unit;
        $cs->specification = $request->specification;
        $cs->description = $request->description;
        $cs->selected_supplier = $supplier;
        $cs->selected_rate = $rate;
        $cs->negotiate = $request->negotiate;
        $cs->save();

        /*
        DB::table('css')->update([
            'invoice' => $cs->invoice,
            'issue_date' => $request->issue_date,
            'supplier1' => $request->supplier1,
            'rate1' => $request->rate1,
            'supplier2' => $request->supplier2,
            'rate2' => $request->rate2,
            'supplier3' => $request->supplier3,
            'rate3' => $request->rate3,
            'supplier4' => $request->supplier4,
            'rate4' => $request->rate4,
            'item' => $request->item,
            'unit' => $request->unit,
            'specification' => $request->specification,
            'description' => $request->description,
            'selected_supplier' => $supplier,
            'selected_rate' => $rate,
            'negotiate' => $request->negotiate,
          ]);
*/
          return redirect()->route('cs.list')->with('success','CS updated Successfull');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
      //dd($request->id);
      $del = Cs::where('id', $request->id)->delete();
      if($del){
        return redirect()->route('cs.list')->with('success', 'CS Delete Successfully');
      }
    }
}
