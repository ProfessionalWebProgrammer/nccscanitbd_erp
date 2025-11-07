<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;

use App\Models\User;
use App\Models\EmployeeAttendance;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class AuthController extends Controller
{
  public function register(Request $request) {
      $fields = $request->validate([
          'name' => 'required|string',
          'email' => 'required|string|unique:users,email',
          'password' => 'required|string|confirmed'
      ]);

      $user = User::create([
          'name' => $fields['name'],
          'email' => $fields['email'],
          'password' => Hash::make($fields['password'])
      ]);

      $token = $user->createToken('myapptoken')->plainTextToken;

      $response = [
          'user' => $user,
          'token' => $token
      ];

      return response($response, 201);
  }

  public function login(Request $request) {
      $fields = $request->validate([
          'email' => 'required|string',
          'password' => 'required|string'
      ]);

      // Check email
      $user = User::where('email', $fields['email'])->first();

      // Check password
      if(!$user || !Hash::check($fields['password'], $user->password)) {
          return response([
              'message' => 'Bad creds'
          ], 401);
      }

      $token = $user->createToken('myapptoken')->plainTextToken;

      $response = [
          'user' => $user,
          'token' => $token
      ];

      return response($response, 201);
  }

  public function logout(Request $request) {
    if(!empty($request->employee_id)){
    $id = $request->employee_id;
    } else {
    $user = auth()->user();
      $id = $user->id;
    }
    
   $date = date('Y-m-d');
    
    $emp =  EmployeeAttendance::where('employee_id', $id)->where('date',$date)->first();
	 $mytime = Carbon::now();
     $time = date('g:i a',strtotime($mytime));
    
    $val = $request->exit_location;
       $location = explode(",",$val);
       $data =  unserialize(file_get_contents('http://www.geoplugin.net/extras/nearby.gp?lat='.$location[0].'&long='.$location[1].'&output=json'));
       $place = $data[0]['geoplugin_place'].', '.$data[0]['geoplugin_region'];
    
    if(!empty($emp)){
      $emp->exit_time = $time;
      $emp->exit_location = $place;
      $emp->save();
    } else {
    	return [
          'message' => 'You are not Employee'
      ];
    }
    
    auth()->user()->tokens()->delete();
    
      return [
          'message' => 'Logged out'
      ];
  }
}
