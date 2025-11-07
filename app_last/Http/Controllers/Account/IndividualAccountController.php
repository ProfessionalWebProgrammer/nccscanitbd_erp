<?php

namespace App\Http\Controllers\Account;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Account\IndividualAccount;
use App\Models\Account\SubAccount;
use App\Models\Account\SubSubAccount;

class IndividualAccountController extends Controller
{
    public function index(){
        $individualAccounts = IndividualAccount::with('acSubSubAccount')->selectRaw('*,ROW_NUMBER() OVER (ORDER BY id) AS row_num')->orderBy('id','desc')->paginate(10);
        return view('backend.account.individual_account.index',[
            'individualAccounts' => $individualAccounts
        ]);
    }

    public function create(){
        $subSubAccounts = SubSubAccount::get();
        return view('backend.account.individual_account.create',[
            'subSubAccounts' => $subSubAccounts
        ]);
    }

    public function store(Request $request){
        $individualAccount = new IndividualAccount();
        $individualAccount->fill($request->all());
        if($individualAccount->save()){
            return redirect()->back()->with('success','Individual Account Created Successfully');
        }
    }

    public function destroy(Request $request){
        IndividualAccount::where('id',$request->id)->delete();
        return redirect()->back()->with('success','Individual Account Deleted Successfully');

    }
}
