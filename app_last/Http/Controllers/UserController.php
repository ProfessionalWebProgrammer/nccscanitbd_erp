<?php

namespace App\Http\Controllers;

use Session;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Factory;
use App\Models\Employee;
use App\Models\UserUpLink;
use App\Models\UserSelectItem;
use App\Models\ApproveCheckBoxItem;
use App\Models\Transfer;
use App\Models\Permission;
use App\Models\Messaging;
use App\Models\ApprovedUser;
use App\Models\RowMaterialsProduct;
use App\Models\Requisition;
use App\Models\RequisitionUser;
use App\Models\RequisitionDetail;
use App\Models\SalesProduct;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function userList(Request $request)
    {
        // dd($request->all());
    $users =User::all();

        return view('backend.user.index', compact('users'));
    }
    //Create Transfer
    public function userCreate()
    {
        $emp = Employee::ALL();
        $users =User::all();
       // dd($emp);
        return view('backend.user.create', compact('emp','users'));
    }

    public function getemp($id)
    {
        $emp = Employee::where('id',$id)->first();

       // dd($emp);
        return $emp;
    }

    //Srore Transfer
    public function UserStore(Request $request)
    {
     //dd($request->all());
     $validated = $request->validate([
         'email' => 'unique:users,email'
    ]);

    if ($validated == true) {

        $user = new User;
      //  $user->parent_id = $request->parent_id;
        $user->name=$request->name;
        $user->email=$request->email;
        $user->password= Hash::make($request->password);
        $user->emp_id=$request->emp_id;
        $user->save();


        if($request->emp_id){
        $Employee =  Employee::where('id',$request->emp_id)->first();
        $Employee->user_id=$user->id;
        $Employee->save();
        }

        foreach($request->parent_id as $key => $val){
        $link =  new UserUpLink;
        $link->user_id = $user->id;
        $link->parent_id = $request->parent_id[$key];
        $link->status = 1;
        $link->save();
        }

     return redirect()->route('user.setting.list')->with('success', 'User Create Successfully');
    }

    }

    public function Userdelete(Request $request){
        //dd($request->all());

        User::where('id', $request->id)->delete();

        return redirect()->route('user.setting.list')->with('success', 'User Delete Successfully');
    }

    public function userSetPermission($id){
       // dd($id);

       $user =  User::where('id', $id)->first();

        return view('backend.user.set_permission', compact('user'));
    }

    public function userSetPermissionStore(Request $request){
      //  dd($request->all());

      if(Auth::id() == 101){


          Permission::where('user_id',$request->user_id)->delete();
            if($request->sales){

                foreach ($request->sales as $key => $item) {

                    $data = new Permission();
                    $data->name=$item;
                    $data->head="Sales";
                    $data->user_id=$request->user_id;
                    $data->save();
                }

            }
            if($request->purchase){
                foreach ($request->purchase as $key => $item) {

                    $data = new Permission();
                    $data->name=$item;
                    $data->head="Purchase";
                    $data->user_id=$request->user_id;
                    $data->save();
                }
            }
            if($request->accounts){


                foreach ($request->accounts as $key => $item) {

                    $data = new Permission();
                    $data->name=$item;
                    $data->head="Accounts";
                    $data->user_id=$request->user_id;
                    $data->save();
                }


            }
            if($request->settings){

                foreach ($request->settings as $key => $item) {
                    $data = new Permission();
                    $data->name=$item;
                    $data->head="Settings";
                    $data->user_id=$request->user_id;
                    $data->save();

                }
            }
            if($request->marketing){

                foreach ($request->marketing as $key => $item) {
                    $data = new Permission();
                    $data->name=$item;
                    $data->head="Marketing";
                    $data->user_id=$request->user_id;
                    $data->save();

                }
            }

        return redirect()->back()->with('success', 'User Permission Set Successfully');

      }else{

       return redirect()->back()->with('warning', 'You have no permission to do that.');
      }




    }

     public function chatlist()
    {
       $authid = Auth::id();

 		// $from =Messaging::where('from_user',$authid)->orderby('id','desc')->get();
 		// $tomassage =Messaging::where('to_user',$authid)->orderby('id','desc')->get();
        $from = Requisition::where('from_user',$authid)->where('requisitions.invoice', 'like', 'Pr-%')->orderby('id','desc')->get();
 		    $tomassage = Requisition::select('requisitions.*','requisition_users.to_user_id')->leftJoin('requisition_users', 'requisitions.id', '=', 'requisition_users.requisition_id')->where('requisition_users.to_user_id',$authid)->where('requisitions.invoice', 'like', 'Pr-%')->orderby('id','desc')->groupBy('requisitions.invoice')->get();
		//dd($tomassage);
       $myid = Auth::id();

      // dd($myid);
        return view('backend.chat.chat_list', compact('from','tomassage','myid'));

       // dd($emp);

    }

   public function chatCreate()
    {
 	    $users =User::all();
      $products = RowMaterialsProduct::orderBy('id','desc')->get();
      //$products = SalesProduct::orderBy('id','desc')->whereNotNull('category_id')->get();
    return view('backend.chat.create', compact('users','products'));

    }

   public function chatStore(Request $request)
    {
        //dd($request->all());
		    $myid = Auth::id();
        $upLinkUsers = UserUpLink::where('user_id',$myid)->get();
        //dd($userId);
        /*
        $user = new Messaging;
        $user->date_time=Carbon::now();
        $user->from_user=$myid;
        $user->to_user=$request->user_id;
        $user->subject=$request->subject;
        $user->item=$request->item;
        $user->unit=$request->unit;
        $user->specification=$request->specification;
        $user->qty=$request->qty;
        $user->required_date=$request->required_date;
        $user->last_purchase_date=$request->last_purchase_date;
        $user->lup=$request->lup;
        $user->description=$request->description;
        $user->save();
     	  $id = $user->id+10000;
        $user->invoice = 'Rq-'.$id;
        $user->save(); RequisitionDetail
        */
     //$Date = ;



        $req = new Requisition;
        $req->from_user = $myid;
        //$req->to_user_id = $request->user_id;
        //$req->approved_user = $request->approved_user;
        $req->reference = $request->reference;
        //$req->required_date =
        $req->last_purchase_date = $request->last_purchase_date;
        $req->description = $request->description;
      	$req->status=0;
        $req->save();
        $id = $req->id + 10000;
        $req->invoice = 'Pr-'.$id;
        $req->save();
        if($req->save()){
          foreach($request->item as $key=> $data){
            //delivery_date

              $days = DB::table('row_materials_products')->where('id',$request->item[$key])->value('days');
     		     $reqDate = date('Y-m-d', strtotime(Carbon::now(). ' + '.$days.' days'));

            $req_d = new RequisitionDetail;
            $req_d->req_id = $req->id;
            $req_d->delivery_date = $reqDate;
            $req_d->item = $request->item[$key];
            $req_d->specification = $request->specification[$key];
            $req_d->unit = $request->unit[$key];
            $req_d->stock = $request->stock[$key];
            $req_d->qty = $request->qty[$key];
            $req_d->lup = $request->lup[$key];
            $req_d->save();
          }
          if($upLinkUsers){
            foreach($upLinkUsers as $val){
              $appUser = new  ApprovedUser;
              $appUser->requisition_id = $req->id;
              $appUser->user_id = $val->parent_id;
              $appUser->status = 2;
              $appUser->save();

              $reqUser = new RequisitionUser;
              $reqUser->requisition_id = $req->id;
              $reqUser->to_user_id = $val->parent_id;
              $reqUser->invoice = $req->invoice;
              $reqUser->status = 0;
              $reqUser->save();
                //Parent user er uplink e access petay chailay ekhanay loop ghuratay hobay
                //
            }
          }


            /* foreach($request->user_id as $key=> $data){
             	DB::table('requisition_users')->insert([
                  'requisition_id'=>$req->id,
                  'to_user_id'=>$request->user_id[$key],
                  'invoice'=>$req->invoice,
                  'status'=>0,
                ]);
             } */


        } else {
          return redirect()->back()->with('warning', "Data can't store in Requisition Detail Table!");
        }


     return redirect()->back()->with('success', 'Requisition Message Sent Successfully');
    }

  public function chatSeen(Request $request)
    {
   //    dd($request->all());
        $user =  Requisition::where('id',$request->id)->first();
   // dd($user);
        $user->status=1;
        $user->save();
     return redirect()->route('user.chat.list')->with('success', 'Seen Message');
    }

  public function chatEdit($id, $user){
  //  dd($user);
    $myid = Auth::id();
    $data = Requisition::where('id',$id)->first();
    $items = ApproveCheckBoxItem::get();
    $approvedUserId = $user;
    return view('backend.chat.edit', compact('data','myid','approvedUserId','items'));
  }

  public function chatAgainEdit($id){
    $myid = Auth::id();
    $data = Requisition::where('id',$id)->first();
    $users =User::all();
    //$selectedUser = RequisitionUser::select('users.*')->leftJoin('users', 'requisition_users.to_user_id', '=', 'users.id')->where('requisition_users.requisition_id',$data->id)->get();
    $details = RequisitionDetail::where('req_id',$data->id)->get();
    $products = RowMaterialsProduct::orderBy('id','desc')->get();

    return view('backend.chat.requisitionEdit', compact('data','myid','users','details','products','id'));
  }

  public function chatUpdate(Request $request){
     $myid = Auth::id();
  	//dd($request->all());
    //$data = DB::table('requisitions')->where('id',$request->id)->first();
    $req = Requisition::where('id',$request->id)->first();
        $req->from_user = $myid;
        //$req->to_user_id = $request->user_id;
        $req->approved_user = $request->approved_user;
        $req->reference = $request->reference;
        $req->required_date = $request->required_date;
        $req->last_purchase_date = $request->last_purchase_date;
        $req->description = $request->description;
     	$req->status=0;
        $req->save();
        if($req->save()){
          foreach($request->item as $key=> $data){
            if(!empty($request->item_id)){
            $req_d = RequisitionDetail::where('req_id',$req->id)->where('id',$request->item_id)->first();
            $req_d->item = $request->item[$key];
            $req_d->specification = $request->specification[$key];
            $req_d->unit = $request->unit[$key];
            $req_d->stock = $request->stock[$key];
            $req_d->qty = $request->qty[$key];
            $req_d->lup = $request->lup[$key];
            $req_d->save();
            } else {
            	$req_d = new RequisitionDetail;
                $req_d->req_id = $req->id;
                $req_d->item = $request->item[$key];
                $req_d->specification = $request->specification[$key];
                $req_d->unit = $request->unit[$key];
                $req_d->stock = $request->stock[$key];
                $req_d->qty = $request->qty[$key];
                $req_d->lup = $request->lup[$key];
                $req_d->save();
                }

          }
          RequisitionUser::where('requisition_id', $req->id)->delete();

             foreach($request->user_id as $key=> $data){
               $reqUser = new RequisitionUser;
               $reqUser->requisition_id = $req->id;
               $reqUser->to_user_id = $val->parent_id;
               $reqUser->invoice = $req->invoice;
               $reqUser->status = 0;
               $reqUser->save();
             }
        } else {
          return redirect()->back()->with('warning', "Data can't update in the Requisition Detail Table!");
        }


     return redirect()->back()->with('success', 'Requisition Update Message Sent Successfully');
  }

  public function approved(Request $request, $id){
      // dd($request->all());

  /*  DB::table('requisitions')->where('id',$id)->update([
      'status' => $request->status,
    ]); */

    $itemData = RequisitionDetail::where('req_id',$id)->first();

    $departmentId = $itemData->product->department_id;

    $employeeUsers = Employee::select('user_id')->where('emp_department_id',$departmentId)->get();
    //dd($employeeUsers);

    $req = Requisition::where('id',$id)->first();
    $req->status = $request->status;
    $req->save();


      if($request->status == 4){
        $reject = new RequisitionUser;
        $reject->requisition_id = $id;
        $reject->to_user_id = $req->from_user;
        $reject->invoice = $req->invoice;
      //  $reject->status = 0;
        $reject->save();

        $approved = new ApprovedUser;
        $approved->requisition_id = $id;
        $approved->user_id = $req->from_user;
        $approved->note = $request->note;
        $approved->status = 3;
        $approved->save();
      } else {
        $reject = new RequisitionUser;
        $reject->requisition_id = $id;
        $reject->to_user_id = $req->from_user;
        $reject->invoice = $req->invoice;
        $reject->status = 100;
        $reject->save();

        $approved = new ApprovedUser;
        $approved->requisition_id = $id;
        $approved->user_id = $req->from_user;
      //  $approved->note = '';
        $approved->status = 3;
        $approved->save();




        foreach($employeeUsers as $val){

            $reqUser = new RequisitionUser;
            $reqUser->requisition_id = $id;
            $reqUser->to_user_id = $val->user_id;
            $reqUser->invoice = $req->invoice;
            $reqUser->status = 11;
            $reqUser->save();

            $approved = new ApprovedUser;
            $approved->requisition_id = $id;
            $approved->user_id = $val->user_id;
            //$approved->note = '';
            $approved->status = 3;
            $approved->save();
        }


      }

      if($request->user != 101){
        $approved = ApprovedUser::where('requisition_id',$id)->where('user_id',$request->user)->first();
        $approved->note = $request->note ?? 'Test';
        $approved->status = $request->status ;
        $approved->save();
      } else {
        $approved = new ApprovedUser;
        $approved->requisition_id = $id;
        $approved->user_id = 101;
        $approved->note = $request->note ?? 'Test';
        $approved->status = $request->status;
        $approved->save();
      }

    /*  $checkedUser = ApprovedUser::where('requisition_id',$id)->whereNotNull('note')->first();
      if(!empty($checkedUser->user_id)){
        $checkedUserId = $checkedUser->user_id;
      } else {
        $checkedUserId = 101;
      }

      dd($checkedUserId);
      */



      if(isset($request->item)){
        foreach($request->item as $key => $val){
          $select = new UserSelectItem();
          $select->user_id = $request->user;
          $select->requisition_id = $id;
          $select->item_id = $request->item[$key];
          $select->save();
        }
      } else {

      }



    //$name = DB::table('employees')->where('user_id',$request->id ?? $id)->value('emp_name');
    //dd($name);
    return redirect()->route('user.chat.list')->with('success', 'Requisition Approved Successfully');
  }

  public function chatView($id){
	//$data = Messaging::where('id',$id)->first();
	//$data = Requisition::where('id',$id)->first();
    //$data = DB::table('requisitions')->where('id',$id)->first();
   	$data =  DB::table('requisitions')->select('requisitions.*')->leftJoin('requisition_users', 'requisitions.id', '=', 'requisition_users.requisition_id')->where('requisitions.id',$id)->first();
    //dd($data);
    $myid = Auth::id();
    $reqId = $id;
    //$data = Requisition::where('id',$id)->first();
    if($data->status == 4){
    $userId = $data->from_user;
    $reqUser = RequisitionUser::where('requisition_id',$id)->where('to_user_id',$userId)->where('invoice',$data->invoice)->first();
    $reqUser->status = 1;
    $reqUser->save();

  } else {
    $checkedUser = ApprovedUser::where('requisition_id',$id)->where('user_id',$myid)->whereNotNull('note')->first();
    $userId = $myid;
    if(!empty($checkedUser)){
      $reqUser = RequisitionUser::where('requisition_id',$id)->where('to_user_id',$userId)->where('invoice',$data->invoice)->first();
      $reqUser->status = 500;
      $reqUser->save();
      RequisitionUser::where('requisition_id',$id)->where('to_user_id',$myid)->where('invoice',$data->invoice)->where('status',11)->delete();
    } else {
      $reqUser = RequisitionUser::where('requisition_id',$id)->where('to_user_id',$userId)->where('invoice',$data->invoice)->first();
      $reqUser->status = 1;
      $reqUser->save();
    }
  }

    return view('backend.chat.invoice', compact('data','reqId'));
  }

   public function passwordchangeindex()
    {
        return view('backend.user.password_change');
    }

   public function passwordchange(Request $request)
    {

     	 $user = User::find($request->id);
        $user->password= Hash::make($request->password);
       $user->save();


         return redirect()->route('user.password.password.index')->with('success', 'Password Change Successfully');
    }



  public function userNotification(Request $request)
    {
        // dd($request->all());
   		 $users =User::all();

        return view('backend.user.notification', compact('users'));
    }


   public function thememood(Request $request)
    {
        // dd($request->all());
   		 $user =Auth::id();

     		$data = DB::table('theme_moods')->where('user_id',$user)->first();

     	if($data != null){
        	DB::table('theme_moods')->where('user_id',$user)->update(['mood'=>$request->flexRadioDefault]);
        }else{
        	DB::table('theme_moods')->where('user_id',$user)->insert(['mood'=>$request->flexRadioDefault,'user_id'=>$user]);
        }

        return redirect()->back();
    }

    public function checkBoxIndex(){
      $datas = ApproveCheckBoxItem::get();
      return view('backend.user.checkBoxItem', compact('datas'));
    }

    public function checkBoxStore(Request $request){
      //dd($request->all());
      $emp = new ApproveCheckBoxItem();
      $emp->fill($request->all());
      $emp->save();
        return redirect()->back()->with('success','Data Store Successfull');
    }

    public function checkBoxEdit($id){
      return "Edit";
    }

    public function checkBoxUpdate(Request $request){
      return "Update";
    }

    public function checkBoxDelete(Request $request){
    //  dd($request->all());
      ApproveCheckBoxItem::where('id',$request->id)->delete();
      return redirect()->back()->with('warning','Data Deleted Successfull');
    }

}
