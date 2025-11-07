<?php

namespace App\Http\Controllers;

use Session;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Employee;
use App\Models\UserUpLink;
use App\Models\UserSelectItem;
use App\Models\ApproveCheckBoxItem;
use App\Models\ApprovedUser;
use App\Models\RowMaterialsProduct;
use App\Models\Requisition;
use App\Models\RequisitionUser;
//use App\Models\RequisitionDetail;
use App\Models\SalesProduct;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class RequisitionController extends Controller
{
    public function index()
    {
      $authid = Auth::id();
        $from = Requisition::where('from_user',$authid)->where('invoice', 'like', 'Mr-%')->orderby('id','desc')->get();
        $tomassage = Requisition::select('requisitions.*','requisition_users.to_user_id')->leftJoin('requisition_users', 'requisitions.id', '=', 'requisition_users.requisition_id')->where('requisition_users.to_user_id',$authid)->where('requisitions.invoice', 'like', 'Mr-%')->orderby('requisitions.id','desc')->groupBy('requisitions.invoice')->get();
        $myid = Auth::id();
     // dd($myid);
       return view('backend.userRequisition.index', compact('from','tomassage','myid'));
    }

    public function create(){
      //$users =User::all();
      $suppliers = Supplier::all();
    //  $products = RowMaterialsProduct::orderBy('id','desc')->get();
    return view('backend.userRequisition.create', compact('suppliers'));
    }

    public function store(Request $request){
      //dd($request->all());
      $myid = Auth::id();
      $upLinkUsers = UserUpLink::where('user_id',$myid)->get();
      // if(!empty($upLinkUsers)){
      //   dd($upLinkUsers);
      // } else {
      //   return "empty";
      // }

      $req = new Requisition;

      $image = $request->file('doc');
      $request->validate([
           'doc' => 'mimes:jpeg,jpg,png,pdf|required|max:20000' // max 10000kb
       ]);

       $name = time() . '.' . $image->getClientOriginalExtension();
       $image->move(public_path('uploads/requisition/'), $name);

       $req->from_user = $myid;
       $req->reference = $request->reference;
       $req->date = $request->date;
       $req->supplier_id = $request->supplier_id;
       $req->amount = $request->amount;
       $req->doc =  $name;
       $req->description = $request->description;
       $req->status=0;
       $req->save();
       $id = $req->id + 10000;
       $req->invoice = 'Mr-'.$id;
       if($req->save()){
         if(!empty($upLinkUsers)){
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
              //  dd($myid);
           }
         } else {
           $appUser = new  ApprovedUser;
           $appUser->requisition_id = $req->id;
           $appUser->user_id = $myid;
           $appUser->status = 2;
           $appUser->save();

           $reqUser = new RequisitionUser;
           $reqUser->requisition_id = $req->id;
           $reqUser->to_user_id = $myid;
           $reqUser->invoice = $req->invoice;
           $reqUser->status = 0;
           $reqUser->save();
         }
       } else {
           return redirect()->back()->with('warning', "Data can't store in Requisition Detail Table!");
       }
      return redirect()->back()->with('success', 'Requisition Message Sent Successfully');
    }

    public function chatEdit($id, $user){
    //  dd($user);
      $myid = Auth::id();
      $data = Requisition::where('id',$id)->first();
    //  $items = ApproveCheckBoxItem::get();
      $approvedUserId = $user;
      return view('backend.userRequisition.edit', compact('data','myid','approvedUserId'));
    }

      public function approved(Request $request, $id){
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

        return redirect()->route('user.multiFunction.requisition.list')->with('success', 'Requisition Approved Successfully');
      }

      public function chatView($id){

       	$data =  Requisition::select('requisitions.*')->leftJoin('requisition_users', 'requisitions.id', '=', 'requisition_users.requisition_id')->where('requisitions.id',$id)->where('requisitions.invoice', 'like', 'Mr-%')->first();
        //dd($data);
        $myid = Auth::id();
        $reqId = $id;
        //$data = Requisition::where('id',$id)->first();
        if($data->status == 4){
        $userId = $data->from_user;
        $reqUser = RequisitionUser::where('requisition_id',$id)->where('to_user_id',$userId)->where('invoice',$data->invoice)->where('invoice', 'like', 'Mr-%')->first();
        $reqUser->status = 1;
        $reqUser->save();

      } else {
        $checkedUser = ApprovedUser::where('requisition_id',$id)->where('user_id',$myid)->whereNotNull('note')->first();
        $userId = $myid;
        if(!empty($checkedUser)){
          $reqUser = RequisitionUser::where('requisition_id',$id)->where('to_user_id',$userId)->where('invoice',$data->invoice)->where('invoice', 'like', 'Mr-%')->first();
          $reqUser->status = 500;
          $reqUser->save();
          RequisitionUser::where('requisition_id',$id)->where('to_user_id',$myid)->where('invoice',$data->invoice)->where('status',11)->where('invoice', 'like', 'Mr-%')->delete();
        } else {
          $reqUser = RequisitionUser::where('requisition_id',$id)->where('to_user_id',$userId)->where('invoice',$data->invoice)->where('invoice', 'like', 'Mr-%')->first();
          $reqUser->status = 1;
          $reqUser->save();
        }
      }

        return view('backend.userRequisition.invoice', compact('data','reqId'));
      }

      public function edit($id){
        $myid = Auth::id();
        $data = Requisition::where('id',$id)->first();
      //  $users =User::all();
        $suppliers = Supplier::all();
      //  $products = RowMaterialsProduct::orderBy('id','desc')->get();
        return view('backend.userRequisition.requisitionEdit', compact('data','myid','suppliers','id'));
      }

      public function update(Request $request){
        dd($request->all());
      }
}
