<?php

namespace App\Http\Controllers;

use App\Models\Machine;

use App\Models\Factory;
use App\Models\Vehicle;
use App\Models\Driver;
use App\Models\SalesProduct;
use App\Models\Trip;
use App\Models\TripsExpance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class MachineController extends Controller
{
    public function index(Request $request)
    {
        // dd($request->all());

        $machine = Machine::all();
        return view('backend.machine.index', compact('machine'));
    }
  
  
    public function create()
    {	
        $factory = Factory::all();
        return view('backend.machine.create', compact('factory'));
    }

    
    public function store(Request $request)
    {
      //dd($request->all());
 			$storeVehicle = new Machine();
      		$storeVehicle->factory_id = $request->factory_id;
            $storeVehicle->name = $request->name;
            $storeVehicle->type = $request->type;
            $storeVehicle->work = $request->work;
            $storeVehicle->production_per_hour = $request->production_per_hour;
            $storeVehicle->lifecycle = $request->lifecycle;
            $storeVehicle->efficiency = $request->efficiency;
            $storeVehicle->description = $request->description;
            $storeVehicle->save();
      
        return redirect()->route('machine.list')->with('success', 'Machine Create Successfully');
    }
  
  
   public function edit($id)
    {
     $machine = Machine::where('id',$id)->first();
     $factory = Factory::all();
        return view('backend.machine.edit', compact('machine','factory'));
    }

    
    public function update(Request $request)
    {
     // dd($request->all());
 			$storeVehicle =  Machine::where('id',$request->id)->first();
            $storeVehicle->factory_id = $request->factory_id;
            $storeVehicle->name = $request->name;
            $storeVehicle->type = $request->type;
            $storeVehicle->work = $request->work;
            $storeVehicle->production_per_hour = $request->production_per_hour;
            $storeVehicle->lifecycle = $request->lifecycle;
            $storeVehicle->efficiency = $request->efficiency;
            $storeVehicle->description = $request->description;
            $storeVehicle->save();
      
        return redirect()->route('machine.list')->with('success', 'Machine Edit Successfully');
    }

    public function delete(Request $request){
     //   dd($request->all());

		Machine::where('id',$request->id)->delete();
      
        return redirect()->route('machine.list')->with('success', 'Delete Successfull.');
    }
  
  
   
  
  
  
  
  
  
}
