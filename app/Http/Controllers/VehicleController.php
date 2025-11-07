<?php

namespace App\Http\Controllers;

use App\Models\Factory;
use App\Models\Vehicle;
use App\Models\Driver;
use App\Models\SalesProduct;
use App\Models\Trip;
use App\Models\TripHistory;
use App\Models\TripsExpance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class VehicleController extends Controller
{
    public function index(Request $request)
    {
        // dd($request->all());

        $vehicles = Vehicle::all();
        return view('backend.vehicle.index', compact('vehicles'));
    }
    
    public function create()
    {
       $category = DB::table('vehicle_categories')->get();
        return view('backend.vehicle.create', compact('category'));
    }

    
    public function store(Request $request)
    {
     // dd($request->all());
 			$storeVehicle = new Vehicle();
            $storeVehicle->vehicle_title = $request->vehicle_title;
            $storeVehicle->category_id = $request->category_id;
            $storeVehicle->vehicle_number = $request->vehicle_number;
            $storeVehicle->oil_opening = $request->oil_opening;
            $storeVehicle->description = $request->description;
            $storeVehicle->save();
      
        return redirect()->route('vehicle.list')->with('success', 'Vehicle Create Successfully');
    }

    public function delete(Request $request){
     //   dd($request->all());

		Vehicle::where('id',$request->id)->delete();
      
        return redirect()->route('vehicle.list')->with('success', 'Delete Successfull.');
    }
  
  
   
  
  
  
  
  
  
    public function categoryCreate()
    {
        $category = DB::table('vehicle_categories')->get();
        
        return view('backend.vehicle.category', compact('category'));
    }

    //Srore Transfer
    public function categoryStore(Request $request)
    {
      
      DB::table('vehicle_categories')->insert([
      'name' =>  $request->name,
      'description' =>  $request->description,
      
      ]);

        return redirect()->back()->with('success', 'Create Successfully');
    }

    public function deleteCategory(Request $request){
        //dd($request->all());

        $uid = Auth::id();
      
 			DB::table('vehicle_categories')->where('id',$request->id)->delete();

    

           
      

       


        return redirect()->back()->with('success', 'Delete Successfull.');
    }
  
  
  
   public function driverindex(Request $request)
    {
        // dd($request->all());

        $drivers = Driver::all();
     
     	$vehicles = Vehicle::all();
     
        return view('backend.vehicle.driver_index', compact('vehicles','drivers'));
    }
    
    public function drivercreate()
    {
       $category = DB::table('vehicle_categories')->get();
        return view('backend.vehicle.driver_create', compact('category'));
    }

    
    public function driverstore(Request $request)
    {
     //dd($request->all());
 			$storeDriver = new Driver();
            $storeDriver->name = $request->name;
            $storeDriver->vehicle_number = $request->vehicle_number;
            $storeDriver->phone = $request->phone;
            $storeDriver->address = $request->address;
            $storeDriver->save();
      
        return redirect()->route('driver.list')->with('success', 'Driver Create Successfully');
    }

    public function driverdelete(Request $request){
     //   dd($request->all());

		Driver::where('id',$request->id)->delete();
      
        return redirect()->route('driver.list')->with('success', 'Delete Successfull.');
    }
  //Vehical Commission start 
  /**public function commissionIndex(Request $request)
    {
     
     	$datas = VehicleCommission::all();
     
        return view('backend.vehicle.commission.index', compact('datas'));
    }
    
    public function commissionCreate()
    {
        return view('backend.vehicle.commission.create');
    }

    
    public function commissionStore(Request $request)
    {
     //dd($request->all());
 			$storeData = new VehicleCommission();
            $storeData->commission = $request->commission;
            $storeData->save();
      
        return redirect()->route('commission.list')->with('success', 'Driver Create Successfully');
    }
  
	public function commissionEdit($id){
    
    }
  	public function commissionUpdate(Request $request, $id){
    }
  
    public function commissionDelete(Request $request){
     //   dd($request->all());

		VehicleCommission::where('id',$request->id)->delete();
      
        return redirect()->route('commission.list')->with('success', 'Delete Successfull.');
    } */
  //Vehical Commission end
  
  
  public function tripindex(Request $request)
    {
        // dd($request->all());

        $drivers = Driver::all();
     
     	$trips = Trip::select('trips.*','t3.name as driver_name','t2.vehicle_number')
          		->leftjoin('vehicles as t2', 'trips.vehicle_id', '=', 't2.id')
          		->leftjoin('drivers as t3', 'trips.driver_id', '=', 't3.id')
          			->get();
     
        return view('backend.vehicle.trip_index', compact('trips','drivers'));
    }
    
    public function tripcreate()
    {
       	$category = DB::table('vehicle_categories')->get();
        $drivers = Driver::all();
     	$vehicles = Vehicle::all(); 
        return view('backend.vehicle.trip_create', compact('category','vehicles','drivers'));
    }

    
    public function tripstore(Request $request)
    {
     		//dd($request->all());
      		  $storeTrip = new Trip();
              $storeTrip->date = $request->date;
              $storeTrip->note = $request->note;
              $storeTrip->commission = $request->commission;
              $storeTrip->driver_id = $request->driver_id;
              $storeTrip->vehicle_id = $request->vehicle_id;
              $storeTrip->trip_value = $request->total_trip_amount;
              $storeTrip->save();
              $storeTrip->invoice = $storeTrip->id+100000;
              $storeTrip->save();
      		  $tripInvoice = $storeTrip->invoice;
      
 			foreach($request->from_place as $key => $value){
              $storeTripHistory = new TripHistory();
              $storeTripHistory->trip_invoice = $tripInvoice;
              $storeTripHistory->trip_from = $request->from_place[$key];
              $storeTripHistory->trip_to = $request->to_place[$key];
              $storeTripHistory->income_amount = $request->trip_amount[$key];
              $storeTripHistory->save();
            }
      
      
        return redirect()->route('trip.list')->with('success', 'Trip Create Successfully');
    }
  public function viewtripexpanse($id)
  {
  	    $trips = Trip::select('trips.*','t3.name as driver_name','t2.vehicle_number')
          		->leftjoin('vehicles as t2', 'trips.vehicle_id', '=', 't2.id')
          		->leftjoin('drivers as t3', 'trips.driver_id', '=', 't3.id')
      			->where('trips.invoice',$id)
          		->first();
    	$triphistory = TripHistory::where('trip_invoice',$id)->get();
    	$expanses = TripsExpance::where('invoice',$id)->get();
  	return view('backend.vehicle.view_expanse_detailes',compact('trips','expanses','triphistory'));
  }
  public function addtripexpanse($id)
  {
    $expanse_groups =  DB::table('vehicle_expanse_groups')->get();
    $trips = Trip::select('trips.*','t3.name as driver_name','t3.id as driver_id','t2.vehicle_number')
          		->leftjoin('vehicles as t2', 'trips.vehicle_id', '=', 't2.id')
          		->leftjoin('drivers as t3', 'trips.driver_id', '=', 't3.id')
      			->where('trips.invoice',$id)
          		->first();
  	return view('backend.vehicle.trip_expanse_create',compact('trips','expanse_groups'));
  }
  public function storetripexpanse(Request $request)
  {
    //dd($request->all());
    		foreach($request->expanse_head as $key => $value){
              $storeTripExpanse = new TripsExpance();
              $storeTripExpanse->invoice = $request->invoice;
              $storeTripExpanse->driver_id = $request->driver_id;
              $storeTripExpanse->expanse_group_id = $request->expanse_group_id;
              $storeTripExpanse->expanse_head = $request->expanse_head[$key];
              $storeTripExpanse->rate = $request->rate[$key];
              $storeTripExpanse->qntty = $request->qntty[$key];
              $storeTripExpanse->expanse_amount = $request->expanse_amount[$key];
              $storeTripExpanse->save();
            }
    return redirect()->route('trip.list')->with('success','Trip Expanse Stored Succcessfull');
  }

    public function tripdelete(Request $request){
       //dd($request->all());

		Trip::where('id',$request->id)->delete();
      
        return redirect()->route('trip.list')->with('success', 'Delete Successfull.');
    }
  
    public function tripdemocreate(){
    return view('backend.vehicle.demo');
    }
  
  public function addallvehicleexpense(){
  	$vehicles = Vehicle::all(); 
    return view('backend.vehicle.vehicle_expanse_create', compact('vehicles'));
  }
  
  public function storeAllVehicleExpense(Request $request){
    
  }
  
   public function tripreportindex()
    {
        $drivers = Driver::all();     
     	$vehicles = Vehicle::all();
        return view('backend.vehicle.trip_report_index', compact('vehicles','drivers'));
    }
  
  
   public function tripreport(Request $request)
    {
     
    // dd($request->all());     
      $trips = Trip::select('trips.*','t3.name as driver_name','t2.vehicle_number')
          		->leftjoin('vehicles as t2', 'trips.vehicle_id', '=', 't2.id')
          		->leftjoin('drivers as t3', 'trips.driver_id', '=', 't3.id');
     
    if (isset($request->date)) {
            $dates = explode(' - ', $request->date);
            $fdate = date('Y-m-d', strtotime($dates[0]));
            $tdate = date('Y-m-d', strtotime($dates[1]));
      
       $trips =  $trips->whereBetween('trips.date', [$fdate, $tdate]);
        }
     

     if ($request->vehicle_id != null) {
           
      
       $trips =  $trips->where('trips.vehicle_id', $request->vehicle_id);
        }
     
           $trips =  $trips->get();
     
     
      
        return view('backend.vehicle.trip_report', compact('trips','fdate','tdate'));
    }
  
  
  	public function totaltripreportindex()
    {
        return view('backend.vehicle.total_trip_report_index');
    	
    }
  	
  	   public function totaltripreportview(Request $request)
    {
     
    // dd($request->all());     
      $trips = Trip::select('trips.*','t3.name as driver_name','t2.vehicle_number')
          		->leftjoin('vehicles as t2', 'trips.vehicle_id', '=', 't2.id')
          		->leftjoin('drivers as t3', 'trips.driver_id', '=', 't3.id')
         		->orderBy('t2.vehicle_number','asc');
     
    if (isset($request->date)) {
            $dates = explode(' - ', $request->date);
            $fdate = date('Y-m-d', strtotime($dates[0]));
            $tdate = date('Y-m-d', strtotime($dates[1]));
      
       $trips =  $trips->whereBetween('trips.date', [$fdate, $tdate]);
        }
     
       $trips =  $trips->get();
       return view('backend.vehicle.total_trip_report_view', compact('trips','fdate','tdate'));
    }
  
}
