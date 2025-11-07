<?php

namespace App\Http\Controllers\Purchase;

use DB;
use Auth;
use Session;
use Carbon\Carbon;
use App\Models\Rfq;
use App\Models\RowMaterialsProduct;
use App\Models\SalesProduct;
use App\Models\Requisition;
use App\Models\Supplier;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class RfqController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Rfq::orderBy('id', 'DESC')->get();
        return view('backend.rfq.index',compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
       $suppliers = Supplier::all();
	     $products = RowMaterialsProduct::all();
       $purchaseRequisitions = Requisition::select('invoice')->whereNotNull('invoice')->get();
       return view('backend.rfq.create',compact('products','purchaseRequisitions','suppliers'));
    }


public function getSupplier($id){
  $data = [];
  $sup = Supplier::where('id',$id)->first();
  $data['name'] = $sup->contact_person ?? '';
  $data['desination'] = $sup->desination ?? '';
  $data['email'] = $sup->email ?? '';
  $data['phone'] = $sup->phone ?? '';
  $data['address'] = $sup->address ?? '';

    return response($data);
}
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
       // $data = $request->all();
       // dd($data);
      $in = DB::table('rfqs')->latest('id')->first();
      $temp = 0;
          if ($in) {
              $temp = 10000 + $in->id;
              $invoice = 'Rfq-'.$temp;
          } else {
              $invoice = 'Rfq-10000';
          }
          $rfq = new Rfq;
      	  $rfq->pr_no = $request->pr_no;
          $rfq->invoice = $invoice;
          $rfq->name = $request->name;
          $rfq->supplier_id = $request->supplier_id;
          /*$rfq->designation = $request->designation;
          $rfq->phone = $request->phone;
          $rfq->email = $request->email;
          $rfq->address = $request->address; */
          $rfq->issue_date = $request->issue_date;
          $rfq->response_date = $request->response_date;
          $rfq->description = $request->description;
          //$rfq->total_amount = $request->total_amount;
          $rfq->save();

      if($rfq->save()){
        foreach($request->item as $key=> $data){
          DB::table('rfq_details')->insert([
            'rfq_id' => $rfq->id,
            'item' => $request->item[$key],
            'specification' => $request->specification[$key],
            'unit' => $request->unit[$key],
            'qty' => $request->qty[$key],
            //'rate' => $request->rate[$key],
            //'amount' => $request->amount[$key]
          ]);
        }
      }

        return redirect()->back()->with('success','RFQ Order Create Successfull');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
      //dd($id);

      $data = Rfq::where('id', $id)->first();
      return view('backend.rfq.invoice',compact('data'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
      //dd($request->all());
        $del = Rfq::where('id', $request->id)->delete();
        $delSub = DB::table('rfq_details')->where('rfq_id', $request->id)->delete();
       // if($del && $delSub){}
        return redirect()->route('rfq.list')->with('success', 'RFQ Delete Successfully');

    }
}
