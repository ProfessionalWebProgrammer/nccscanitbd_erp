<?php

namespace App\Http\Controllers;

use App\Models\Meter;
use App\Models\MeterReading;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class MeterController extends Controller
{
    public function index(Request $request)
    {
        // dd($request->all());

        $meter = Meter::all();
        return view('backend.meter.index', compact('meter'));
    }
    
    public function create()
    {
        return view('backend.meter.create');
    }

    
    public function store(Request $request)
    {
    //  dd($request->all());
 			$storeVehicle = new Meter();
            $storeVehicle->meter_no = $request->meter_no;
            $storeVehicle->meter_name = $request->meter_name;
          
            $storeVehicle->opening_reading = $request->opening_reading;
           $storeVehicle->producton_per_hour = $request->producton_per_hour;
            $storeVehicle->per_cycle_rotation = $request->per_cycle_rotation;
            $storeVehicle->save();
      
        return redirect()->route('meter.list')->with('success', 'Meter Create Successfully');
    }
  
  
    public function edit($id)
    {
      $meter = Meter::where('id',$id)->first();
        return view('backend.meter.edit', compact('meter'));
    }

    
    public function update(Request $request)
    {
    //  dd($request->all());
 			$storeVehicle = Meter::where('id',$request->id)->first();
            $storeVehicle->meter_no = $request->meter_no;
            $storeVehicle->meter_name = $request->meter_name;
          
            $storeVehicle->opening_reading = $request->opening_reading;
           $storeVehicle->producton_per_hour = $request->producton_per_hour;
            $storeVehicle->per_cycle_rotation = $request->per_cycle_rotation;
            $storeVehicle->save();
      
        return redirect()->route('meter.list')->with('success', 'Meter Edit Successfully');
    }

    public function delete(Request $request){
       // dd($request->all());

		Meter::where('id',$request->id)->delete();
      
        return redirect()->route('meter.list')->with('success', 'Delete Successfull.');
    }
  
  
  
  
  
  
    public function meterreadingindex(Request $request)
    {
        // dd($request->all());

        $meter = MeterReading::all();
        return view('backend.meter.mrindex', compact('meter'));
    }
    
    public function meterreadingcreate()
    {
       $meter = Meter::all();
        return view('backend.meter.mrcreate', compact('meter'));
    }

    
    public function meterreadingstore(Request $request)
    {
      //dd($request->all());
 			$storeVehicle = new MeterReading();
            $storeVehicle->meter_no = $request->meter_no;
            $storeVehicle->date = $request->date;
          
            $storeVehicle->time = $request->time;
           $storeVehicle->opening_reading = $request->opening_reading;
            $storeVehicle->present_reading = $request->input_reading;
            $storeVehicle->save();
      
        return redirect()->route('meter.reading.list')->with('success', 'Entry Successfully');
    }
  
   public function meterreadingedit($id)
    {
       $meter = Meter::all();
     $meterreding =  MeterReading::where('id',$id)->first();
        return view('backend.meter.mredit', compact('meter','meterreding'));
    }

    
    public function meterreadingupdate(Request $request)
    {
      //dd($request->all());
 			$storeVehicle =  MeterReading::where('id',$request->id)->first();
            $storeVehicle->meter_no = $request->meter_no;
            $storeVehicle->date = $request->date;
          
            $storeVehicle->time = $request->time;
           $storeVehicle->opening_reading = $request->opening_reading;
            $storeVehicle->present_reading = $request->input_reading;
            $storeVehicle->save();
      
        return redirect()->route('meter.reading.list')->with('success', 'Entry Successfully');
    }

    public function meterreadingdelete(Request $request){
       // dd($request->all());

		MeterReading::where('id',$request->id)->delete();
      
        return redirect()->route('meter.reading.list')->with('success', 'Delete Successfull.');
    }
  
  
  
   
  
  
  
  
  
  
}
