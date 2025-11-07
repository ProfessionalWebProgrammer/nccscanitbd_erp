<?php

namespace App\Http\Controllers\CRM;

use App\Models\MarketingProduct;
use App\Models\InterCompany;
use App\Models\SalesCategory;
use App\Models\SalesSubCategory;
use App\Models\MarketingOrderSpecificationHead;
use App\Models\MarketingOrderSpecification;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Traits\ChartOfAccount;
use App\Models\Account\ChartOfAccounts;

class MarketingProductController extends Controller
{
  use ChartOfAccount;
      public function index(){
        $products = MarketingProduct::select('marketing_products.*','s.category_name','ss.name as subCat')->leftJoin('sales_categories as s','s.id','=','marketing_products.category_id')
                    ->leftJoin('sales_sub_categories as ss','ss.id','=','marketing_products.sub_category_id')->orderBy('id','DESC')->get();
        return view('backend.mt_product.index',compact('products'));
      }

      public function create(){
        $categories = SalesCategory::latest('id')->get();
        $subCategories = SalesSubCategory::orderby('name','asc')->get();
        $specifications = MarketingOrderSpecificationHead::all();
        return view('backend.mt_product.create',compact('categories','subCategories','specifications'));
      }

      public function store( Request $request){
        //dd($request->all());
        $data = new MarketingProduct;
        $image = $request->file('image');
        $request->validate([
             'image' => 'mimes:jpeg,jpg,png|required|max:20000' // max 10000kb
         ]);

         $name = time() . '.' . $image->getClientOriginalExtension();
         //$name = time() . '.' .$request->image->extension();
         $image->move(public_path('uploads/marketing/'), $name);
        $data->name = $request->name;
        $data->code = $request->code;
        $data->category_id  = $request->category_id ;
        $data->sub_category_id  = $request->sub_category_id ;
        $data->unit = $request->unit;
        $data->image   = $name;
        $data->specification   = $request->specification ?? '';
        $data->status   = 1;
        $data->save();

        if(!empty($request->specification_id)){
          foreach($request->specification_id as $key => $value) {
            $val = new MarketingOrderSpecification;
            $val->item_id = $data->id;
            $val->specification_id = $request->specification_id[$key];
            $val->value = $request->value[$key];
            $val->save();
          }
        }
        return redirect()->Route('marketing.item.index')->with('success','Marketing Product Create Successffull');
      }

      public function getproductdata($id){
        $data = array();
        $result = MarketingProduct::where('id',$id)->first();
        $data['specification'] = $result->specification;
          return response($data);
      }

      public function edit($id){
        return 'ok';
      }
      public function update(Request $request){
        return 'ok';
        /*
        if(!empty($request->specification_id)){

            MarketingOrderSpecification::where('item_id',$id)->delete();
          foreach($request->specification_id as $key => $value) {
              $val = new MarketingOrderSpecification;
              $val->item_id = $proucts->id;
              $val->specification_id = $request->specification_id[$key];
              $val->value = $request->value[$key];
              $val->save();

          }
        }
        */
      }
      public function delete(Request $request){
        MarketingProduct::findOrFail($request->id)->Delete($request->all());
        return redirect()->route('marketing.item.index')
                        ->with('delete', 'Marketing Products Delete  successfully .');
      }


      public function indexInterCompany(){
        $company = InterCompany::orderBy('id','DESC')->get();
        return view('backend.interCompany.index',compact('company'));
      }
      public function createInterCompany(){
        return view('backend.interCompany.create');
      }
      public function storeInterCompany( Request $request){
       //dd($request->all());
        $data = new InterCompany;

        $data->name = $request->name;
        $data->address = $request->address;
        $data->balance = $request->balance;
        $data->status   = 1;
        $data->save();
        $invoice = 'IC-Inv-'.$data->id;
        $data->invoice = $invoice;
        $data->save();
        $date = date('2023-10-01');

        $this->createCreditForFinishedGoodsSale('Account Payable (Intercompany)',$request->balance,$date,$narration='Inter Company Opening', $invoice);

        return redirect()->Route('inter.company.index')->with('success','Inter Company Create Successffull');
      }
      public function editInterCompany($id){
        return 'ok';
      }
      public function updateInterCompany(Request $request){
        return 'ok';
      }
      public function deleteInterCompany(Request $request){
        //MarketingProduct::findOrFail($request->id)->Delete($request->all());
        $data = InterCompany::where('id',$request->id)->first();
        $data->status = 0;
        $data->save();
        
        ChartOfAccounts::where('invoice',$data->invoice)->delete();
        
        return redirect()->route('inter.company.index')
                        ->with('delete', 'Inter Company Delete  successfully .');
      }

      public function indexSpecificationHead(){
        $heads = MarketingOrderSpecificationHead::orderBy('id','DESC')->get();
        return view('backend.mt_product.specification',compact('heads'));

      }

      /*public function createSpecificationHead(){
        return view('backend.specificationHead.create');
      }*/
      public function storeSpecificationHead( Request $request){
        $data = new MarketingOrderSpecificationHead;
        $data->name = $request->name;
        $data->save();
        return redirect()->Route('specification.head.index')->with('success','Specification Head Create Successffull');
      }
      public function editSpecificationHead($id){
        return "Ok";
      }
      public function updateSpecificationHead( Request $request){
        return "Ok";
      }
      public function deleteSpecificationHead( Request $request){
        MarketingOrderSpecificationHead::where('id',$request->id)->delete();

        return redirect()->route('specification.head.index')
                        ->with('delete', 'Specification Head Delete  successfully .');
      }
}
