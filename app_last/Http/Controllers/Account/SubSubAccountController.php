<?php

namespace App\Http\Controllers\Account;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Account\SubSubAccount;
use App\Models\Account\SubAccount;

class SubSubAccountController extends Controller
{
    public function index(){
        $subSubAccounts = SubSubAccount::with('acSubAccount')->selectRaw('*,ROW_NUMBER() OVER (ORDER BY id) AS row_num')->orderBy('id','desc')->paginate(10);
        return view('backend.account.sub_sub_account.index',[
            'subSubAccounts' => $subSubAccounts
        ]);
    }

    public function create(){
        $subAccounts = SubAccount::get();
        return view('backend.account.sub_sub_account.create',[
            'subAccounts' => $subAccounts
        ]);
    }

    public function store(Request $request){
        // return $request->all();
        $subSubAccount = new SubSubAccount();
        $subSubAccount->fill($request->all());
        $subAccountInfo = SubAccount::where('id',$request->ac_sub_account_id)->orderBy('id','desc')->first('code');
        $subSubAccountInfo = SubSubAccount::where('ac_sub_account_id',$request->ac_sub_account_id)->orderBy('id','desc')->first('code');
        if($subSubAccountInfo){
            $subSubAccount->code =  $subSubAccountInfo->code + 1;
        }else{
            $subSubAccount->code =   @$subAccountInfo->code + 1;
        }
      
     
        if($subSubAccount->save()){
            return redirect()->back()->with('success','Sub Sub Account Created Successfully');
        }
    }

    public function destroy(Request $request){
        SubSubAccount::where('id',$request->id)->delete();
        return redirect()->back()->with('success','Sub Sub Account Deleted Successfully');

    }
}
