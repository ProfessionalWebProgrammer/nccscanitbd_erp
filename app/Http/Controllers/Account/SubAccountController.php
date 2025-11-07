<?php

namespace App\Http\Controllers\Account;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Account\SubAccount;
use App\Models\Account\MainAccount;

class SubAccountController extends Controller
{
    public function index(){
        $subAccounts = SubAccount::with('acMainAccount')->selectRaw('*,ROW_NUMBER() OVER (ORDER BY id) AS row_num')->paginate(10);
        return view('backend.account.sub_account.index',[
            'subAccounts' => $subAccounts
        ]);
    }

    public function create(){
        $mainAccounts = MainAccount::get();
        return view('backend.account.sub_account.create',[
            'mainAccounts' => $mainAccounts
        ]);
    }

    public function store(Request $request){
        // return $request->all();
        $subAccount = new SubAccount();
        $subAccount->fill($request->all());
        $mainAccountInfo = MainAccount::where('id',$request->ac_main_account_id)->first('code');
        $subAccountInfo = SubAccount::where('ac_main_account_id',$request->ac_main_account_id)->orderBy('id','desc')->first('code');
        if($subAccountInfo){
            $subAccount ->code =  $subAccountInfo->code + 1;
        }else{
            $subAccount ->code =   @$mainAccountInfo->code + 1;
        }
      
     
        if($subAccount->save()){
            return redirect()->back()->with('success','sub Account Created Successfully');
        }
    }

    public function destroy(Request $request){
        SubAccount::where('id',$request->id)->delete();
        return redirect()->back()->with('success','Sub Account Deleted Successfully');

    }
}
