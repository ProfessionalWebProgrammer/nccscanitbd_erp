<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProductionFactory;
use App\Models\Factory;
// use App\DealerType;
// use App\Company;
// use App\Division;
use DB;

class FactoryController extends Controller
{
    public function index()
    {
        $factorys = DB::select('SELECT factories.id,factories.factory_name,factories.factory_contact_number,factories.factory_address,factories.stock_limit_status,companies.company_title,dealer_types.type_title,divisions.division_title FROM `factories`
        LEFT JOIN companies on companies.id = factories.factory_company_id
        LEFT JOIN dealer_types ON dealer_types.id = factories.factory_type_id
        LEFT JOIN divisions ON divisions.id = factories.factory_division_id');

       // dd($factorys);
        
        return view('backend.warehouse.index',compact('factorys'));
        // dd($factorys);
    }
    public function getcreate()
    {
        //$divisions = Division::latest('id')->get();
       

        return view('backend.warehouse.create');
    }

    public function postcreate(Request $request)
    {
        // dd($request);
        $factory = new Factory;
        $factory->factory_name  =   $request->factory_name;
        $factory->factory_company_id  =   $request->factory_company_id;
        $factory->factory_type_id  =   $request->factory_type_id;
        $factory->factory_division_id  =   $request->factory_division_id;
        $factory->factory_contact_number  =   $request->factory_contact_number;
        $factory->factory_address  =   $request->address;
        $factory->stock_limit_status  =   $request->stock_limit_status;
        $factory->save();
        return redirect()->Route('warehouse.index')->with('success','Factory Create Successfull');
    }

    // werehouse edit by Reza
        public function getedit($id)
        {
            $werehousedata = Factory::where('id', $id)->first();
            return view('backend.warehouse.editwerehouse', compact('werehousedata'));
        }
  
		public function deletewarehouse(Request $request)
        {
        	//dd($request->all());
          	Factory::where('id',$request->id)->delete();
          	return redirect()->back()->with('success','Factory Deleted Successfull');
        }
  
    public function postedit(Request $request)
    {
        // dd($request);
        $id = $request->id;
        // dd($id);
        $factory =Factory::find($id);
        $factory->factory_name  =   $request->factory_name;
        $factory->factory_company_id  =   $request->factory_company_id;
        $factory->factory_type_id  =   $request->factory_type_id;
        $factory->factory_division_id  =   $request->factory_division_id;
        $factory->factory_contact_number  =   $request->factory_contact_number;
        $factory->factory_address  =   $request->factory_address;
        $factory->stock_limit_status  =   $request->stock_limit_status;
        $factory->save();
        return redirect()->Route('warehouse.index')->with('success','Factory Update Successfull');
    }

    public function APICashList(){
        $medicineFactory = Factory::ALL();
        return $medicineFactory;
    }
  
  
  public function index1()
    {
        $factorys = DB::select('SELECT factories.id,factories.factory_name,factories.factory_contact_number,factories.factory_address,factories.stock_limit_status,companies.company_title,dealer_types.type_title,divisions.division_title FROM `factories`
        LEFT JOIN companies on companies.id = factories.factory_company_id
        LEFT JOIN dealer_types ON dealer_types.id = factories.factory_type_id
        LEFT JOIN divisions ON divisions.id = factories.factory_division_id');

       // dd($factorys);
        
        return response($factorys);
        // dd($factorys);
    }
  
  
   public function productionfactoryindex()
    {
        $factorys = ProductionFactory::all();
       // dd($factorys);
        
        return view('backend.warehouse.production_factory_index',compact('factorys'));
        // dd($factorys);
    }
    public function productionfactorycreate()
    {
        //$divisions = Division::latest('id')->get();
       

        return view('backend.warehouse.production_factory_create');
    }

    public function productionfactorystore(Request $request)
    {
        // dd($request);
        $factory = new ProductionFactory;
        $factory->factory_name  =   $request->factory_name;
        $factory->factory_contact_number  =   $request->factory_contact_number;
        $factory->factory_address  =   $request->address;
        $factory->save();
        return redirect()->Route('production.factory.index')->with('success','Factory Create Successfull');
    }

        public function productionfactoryedit($id)
        {
            $werehousedata = ProductionFactory::where('id', $id)->first();
            return view('backend.warehouse.production_factory_edit', compact('werehousedata'));
        }
  
		public function deleteproductionfactory(Request $request)
        {
        	//dd($request->all());
          	ProductionFactory::where('id',$request->id)->delete();
          	return redirect()->back()->with('success','Factory Deleted Successfull');
        }
  
    public function productionfactoryupdte(Request $request)
    {
        // dd($request);
        $id = $request->id;
        // dd($id);
        $factory =ProductionFactory::find($id);
       $factory->factory_name  =   $request->factory_name;
        $factory->factory_contact_number  =   $request->factory_contact_number;
        $factory->factory_address  =   $request->address;
        $factory->save();
        return redirect()->Route('production.factory.index')->with('success','Factory Update Successfull');
    }
  
}
