<?php

namespace App\Http\Controllers;

use App\Models\ComProfile;
use Illuminate\Http\Request;

class ComProfleController extends Controller
{
    public function comprofile()
    {
      	$comdata = ComProfile::where('id',1)->first();
    	return view('backend.profile.com_profile',compact('comdata'));
    }
  	 public function storedata(Request $request)
    {
        //dd($request->all());
        $data = ComProfile::where('id',1)->first();
        $data->com_name = $request->com_name;
       if($request->com_logo == null){
          $data->com_logo = $request->com_logo_old;
       }else{
        //image code
       	unlink('public/' . $request->com_logo_old);
        $image = $request->com_logo;

        $image_name = hexdec(uniqid(5));
        $exa = strtolower($image->getClientOriginalExtension());
        $filename = strtolower($image->getClientOriginalName());
        $image_full_name = $image_name . '.' . $filename;
        $upload_path = 'public/';
        $image_url = $image_full_name;
        $image->move($upload_path, $image_full_name);
        $data->com_logo = $image_url;
       
       //image code end
       }
        $data->com_phone = $request->com_phone;
        $data->com_email = $request->com_email;
        $data->com_address_l1 = $request->com_address1;
        $data->com_address_l2 = $request->com_address2;
       
        $data->save();
       return redirect()->back()->with('success','Data Updated Successfull !!!');
    }
}
