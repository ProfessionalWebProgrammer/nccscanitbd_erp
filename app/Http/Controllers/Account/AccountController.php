<?php

namespace App\Http\Controllers\Account;
use Auth;

use App\Models\Dealer;
use App\Models\Supplier;
use App\Models\Payment;
use App\Models\MainBank;
use App\Models\DealerArea;
use App\Models\DealerZone;
use App\Models\MasterBank;
use App\Models\MasterCash;
use App\Models\SalesLedger;
use App\Models\SalesStockIn;
use App\Models\ExpanseGroup;
use App\Models\AssetClint;
use App\Models\Sale;
use App\Models\AssetProduct;
use App\Models\IncomeStatement;
use App\Models\OthersIncome;
use App\Models\SalesReturn;
use App\Models\ExpanseType;
use App\Models\Purchase;
use App\Models\InterCompany;
use App\Models\PurchaseStockout;
use App\Models\ManufacturingCost;
use App\Models\Account\ChartOfAccounts;
use App\Models\Account\AssetDepreciationInfoDetails;
use App\Models\Account\SubAccount;
use App\Models\Account\SubSubAccount;
use Illuminate\Support\Facades\Cache;



use App\Models\RowMaterialsProduct;

use App\Models\SalesProduct;
use Illuminate\Http\Request;

use App\Models\Payment_number;
use App\Models\ExpanseSubgroup;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use App\Traits\AccountInfoAdd;
use App\Traits\TrailBalance;
use App\Traits\ChartOfAccount;

class AccountController extends Controller
{
  use AccountInfoAdd;
  use TrailBalance;
  use ChartOfAccount;
    public function masterbankIndex()
    {

        $banks = MasterBank::leftjoin('main_banks', 'master_banks.main_bank_id', 'main_banks.id')->get();
        //dd($banks);
        return view('backend.account.master_bank_index', compact('banks'));
    }

  public function othersManu()
    {


        return view('backend.account.account_manu_page_index');
    }
  public function reportManu()
    {
        return view('backend.account.account_report_manu_page_index');
    }
   public function receivemenu()
    {


        return view('backend.account.account_receive_manu_page_index');
    }
   public function paymentmenu()
    {
        return view('backend.account.account_payment_manu_page_index');
    }
   public function assetmenu()
    {
        return view('backend.account.account_asset_manu_page_index');
    }


	public function masterbankdelete(Request $request)
    {
      MasterBank::where('bank_id',$request->id)->delete();
      return redirect()->back()->with('success','Master Bank Deleted Successfull!');
    }

    public function masterbankCreate(Request $request)
    {

        $mainbank = MainBank::all();
      $loantype = DB::table('loan_types')->get();

        return view('backend.account.master_bank_create', compact('mainbank','loantype'));
    }


    public function masterbankStore(Request $request)
    {
     //   dd($request->all());

        $MasterBank = new MasterBank();
        $MasterBank->bank_name = $request->bank_name;
        $MasterBank->bank_op = $request->bank_op;
        $MasterBank->main_bank_id = $request->main_bank_id;
        $MasterBank->bank_licence = $request->bank_licence;
        $MasterBank->bank_address = $request->bank_address;
        $MasterBank->bank_starting_balance = $request->bank_starting_balance;
        $MasterBank->loan_type = $request->loan_type;
        $MasterBank->loan_amount = $request->loan_amount;
        $MasterBank->loan_fdate = $request->loan_fdate;
        $MasterBank->loan_tdate = $request->loan_tdate;
        $MasterBank->save();

        $this->createBankForCoa($request->bank_name);

		//$bank_id = MasterBank::latest('id')->first();
      	foreach ($request->cheque_book_serial_no as $key => $serial_no)
        {
          DB::table('cheque_books')->insert([
         'bank_id' => $MasterBank->bank_id,
         'cheque_book_no' => $request->cheque_book_no,
         'cheque_book_serial_no' => $serial_no,
         'status' => '1',
         'created_at' => date('Y-m-d H:i:s'),
         'updated_at' => date('Y-m-d H:i:s')
       ]);
     }

        return redirect()->route('master.bank.index')
            ->with('success', 'Bank Created Successfull');
    }

   public function masterbankEdit($id)
    {

        $mainbank = MainBank::all();
      $masterBank =  MasterBank::where('bank_id',$id)->first();

      $loantype = DB::table('loan_types')->get();

        return view('backend.account.master_bank_edit', compact('mainbank','loantype','masterBank'));
    }


    public function masterbankUpdate(Request $request)
    {


    //   dd($request->all());

        $MasterBank = MasterBank::where('bank_id',$request->bank_id)->first();

     // dd($MasterBank);
        $MasterBank->bank_name = $request->bank_name;
        $MasterBank->bank_op = $request->bank_op;
        $MasterBank->main_bank_id = $request->main_bank_id;
        $MasterBank->bank_licence = $request->bank_licence;
      	/*$MasterBank->cheque_book_no = $request->cheque_book_no;
        $MasterBank->cheque_book_serial_no = $request->cheque_book_serial_no; */
        $MasterBank->bank_address = $request->bank_address;
        $MasterBank->bank_starting_balance = $request->bank_starting_balance;

        $MasterBank->loan_type = $request->loan_type;
        $MasterBank->loan_amount = $request->loan_amount;
        $MasterBank->loan_fdate = $request->loan_fdate;
        $MasterBank->loan_tdate = $request->loan_tdate;


        $MasterBank->save();


        return redirect()->route('master.bank.index')
            ->with('success', 'Bank Edit Successfull');
    }


    public function mainbankCreate(Request $request)
    {

        $mainbank = MainBank::all();

        return view('backend.account.main_bank', compact('mainbank'));
    }

	public function deletemainbank(Request $request)
    {
      //dd($request->all());
      MainBank::where('id',$request->id)->delete();
      return redirect()->back()->with('success', 'Main Bank Deleted Successfull');
    }

    public function mainbankStore(Request $request)
    {


        //dd($request->all());

        $MainBank = new MainBank();
        $MainBank->name = $request->name;
        $MainBank->description = $request->description;
        $MainBank->save();


        return redirect()->back()
            ->with('success', 'Main Bank Created Successfull');
    }


  public function loantypeCreate(Request $request)
    {

        $datas = DB::table('loan_types')->get();

        return view('backend.account.loan_type', compact('datas'));
    }

	public function deleteloantype(Request $request)
    {
      //dd($request->all());
      DB::table('loan_types')->where('id',$request->id)->delete();
      return redirect()->back()
            ->with('success', ' Deleted Successfull');
    }

    public function loantypeStore(Request $request)
    {


        //dd($request->all());

         DB::table('loan_types')->insert([

            'type' => $request->type,
            'description' => $request->description

         ]);



        return redirect()->back()
            ->with('success', 'Created Successfull');
    }



    public function mastercashIndex()
    {

        $cashs = MasterCash::all();
        //dd($cashs);
        return view('backend.account.master_cash_index', compact('cashs'));
    }
	public function mastercashdelete(Request $request)
    {
    	//dd($request->all());
     	MasterCash::where('wirehouse_id',$request->id)->delete();
      	return redirect()->back()->with('success', 'Main Bank Deleted Successfull');
    }

    public function mastercashCreate(Request $request)
    {
        return view('backend.account.master_cash_create');
    }


    public function mastercashStore(Request $request)
    {
        //dd($request->all());

        $Mastercash = new MasterCash();
        $Mastercash->wirehouse_name = $request->wirehouse_name;
        $Mastercash->wirehouse_opb = $request->wirehouse_opb;
        $Mastercash->wirehouse_address = $request->wirehouse_address;

        $Mastercash->save();

        $this->createCashForCoa($request->wirehouse_name);


        return redirect()->route('master.cash.index')
            ->with('success', 'Cash Created Successfull');
    }

    public function masterCashEdit($id){
      $data = MasterCash::where('wirehouse_id',$id)->first();
    	//dd($data);
       return view('backend.account.master_cash_edit', compact('data'));
    }

    public function masterCashUpdate(Request $request){
    DB::table('master_cashes')->where('wirehouse_id',$request->id)->update([
    'wirehouse_name' => $request->wirehouse_name,
     'wirehouse_opb' => $request->wirehouse_opb,
      'wirehouse_address' => $request->wirehouse_address
    ]);


            return redirect()->route('master.cash.index')->with('success', 'Master Cash Update Successfull');
    }

    public function expanseIndex()
    {

        $subgroups = ExpanseSubgroup::all();
        $groups = ExpanseGroup::all();

        //dd($banks);
        return view('backend.account.expancecreate', compact('subgroups', 'groups'));
    }

  	public function expancegroupedit($id)
    {
      $group = ExpanseGroup::where('id',$id)->first();
      return view('backend.account.expansegroupedit', compact('group'));
    }

  	public function expancegroupupdate(Request $request)
    {
      //dd($request->all());
      	$ExpanseGroup = ExpanseGroup::where('id',$request->id)->first();
        $ExpanseGroup->group_name = $request->expanse_group_name;
        $ExpanseGroup->save();


        return redirect()->route('expanse.index')->with('success', 'Expanse Group Updated Successfull');
    }



	public function expancesubgroupedit($id)
    {
      $subgroups = ExpanseSubgroup::where('id',$id)->first();
      $groups = ExpanseGroup::all();
      return view('backend.account.expancesubgroupedit', compact('subgroups','groups'));
    }


    public function expancesubgroupupdate(Request $request)
    {
       // dd($request->all());
        $ExpanseGroup =  ExpanseGroup::where('id', $request->group_id)->first();
        $date = date('2023-10-01');

        $ExpanseSubgroup =  ExpanseSubgroup::where('id', $request->id)->first();

        $this->updateLedgerForCoa($ExpanseSubgroup->subgroup_name,$ExpanseGroup->group_name,$request->expanse_sub_group_name);
        $invoice = $ExpanseSubgroup->invoice;
        $ExpanseSubgroup->group_name = $ExpanseGroup->group_name;
        $ExpanseSubgroup->group_id = $request->group_id;
        $ExpanseSubgroup->subgroup_name = $request->expanse_sub_group_name;
        $ExpanseSubgroup->balance = $request->balance;
        $ExpanseSubgroup->save();

        if($request->balance){
          ChartOfAccounts::where('invoice',$invoice)->delete();
            $this->expenseSubGroupDebit($request->expanse_sub_group_name ,$request->balance, $date , $description = 'Expense Ledger', $invoice );
        }

        return redirect()->route('expanse.index')->with('success', 'Expanse SubGroup Updated Successfull');
    }



  	public function expancegroupdelete(Request $request)
    {
      //dd('group Deleted');
      ExpanseGroup::where('id',$request->id)->delete();
      return redirect()->back()->with('success', 'Group Deleted Successfull');
    }




  	public function expancesubgroupdelete(Request $request)
    {
      //
      $invoice = ExpanseSubgroup::where('id',$request->id)->value('invoice');

      $data = ExpanseSubgroup::where('id',$request->id)->delete();

      ChartOfAccounts::where('invoice',$invoice)->delete();

      return redirect()->back()->with('success', 'Expense Sub-Group Deleted Successfull');
    }

    public function expanseGroupStore(Request $request)
    {
        //dd($request->all());
      	$data = ExpanseGroup::where('group_name',$request->expanse_group_name)->first();
      	if(!empty($data)){
          return redirect()->back()->with('success', 'The Expanse Group Already Exists');
        } else {
        $ExpanseGroup = new ExpanseGroup();
        $ExpanseGroup->group_name = $request->expanse_group_name;
        $ExpanseGroup->save();
        $this->createExpenseGroupForCoa($request->expanse_group_name);
        return redirect()->back()->with('success', 'Expanse Group Created Successfull');
        }
    }

    public function expanseSubGroupStore(Request $request)
    {


        $ExpanseGroup =  ExpanseGroup::where('id', $request->group_id)->first();

		$data = ExpanseSubgroup::where('subgroup_name',$request->expanse_sub_group_name)->first();
      	if(!empty($data)){
        return redirect()->back()->with('success', 'The Expanse Sub-Group Already Exists');
        } else {
        // dd($ExpanseGroup);
        $ExpanseSubgroup = new ExpanseSubgroup();
        $ExpanseSubgroup->group_name = $ExpanseGroup->group_name;
        $ExpanseSubgroup->group_id = $request->group_id;
        $ExpanseSubgroup->subgroup_name = $request->expanse_sub_group_name;
        $ExpanseSubgroup->balance = $request->balance;
        $ExpanseSubgroup->save();
        $date = date('2023-10-01');
        $invoice = 'E-Pay-Inv-'.$ExpanseSubgroup->id;
        $ExpanseSubgroup->invoice = $invoice;
        $ExpanseSubgroup->save();

        $added = $this->createLedgerForCoa($ExpanseGroup->group_name ,$request->expanse_sub_group_name);
        if($added){
           $this->expenseSubGroupDebit($request->expanse_sub_group_name ,$request->balance, $date , $description = 'Expense Ledger', $invoice );
        }


        return redirect()->back()->with('success', 'Expanse Sub-Group Created Successfull');
        }
    }

	public function expenceSubSubCreate(Request $request){
      $allData = DB::table('expanse_sub_subgroups')->get();
      $subgroups = ExpanseSubgroup::all();
      $groups = ExpanseGroup::all();
      return view('backend.account.expanse_sub_sub_list', compact('allData','subgroups','groups'));
    }

	public function expenceSubSubStore(Request $request){
     //dd($request->all());

        $name = ExpanseGroup::where('id', $request->group_id)->value('group_name');
        $subgroup_name = ExpanseSubgroup::where('id', $request->subgroup_id)->value('subgroup_name');
      	$data = DB::table('expanse_sub_subgroups')->where('subSubgroup_name',$request->subSubgroup_name)->first();

        if(!empty($data)){
        return redirect()->back()->with('success', 'The Expence Sub Sub-Ledger Already Exists');
        } else {
         DB::table('expanse_sub_subgroups')->insert([
         'group_id' => $request->group_id,
         'subgroup_id' => $request->subgroup_id,
         'group_name' => $name,
         'subgroup_name' => $subgroup_name,
         'subSubgroup_name' => $request->subSubgroup_name,
          ]);
        $this->createSubLedgerForCoa($name ,$subgroup_name ,$request->subSubgroup_name );

        return redirect()->back()->with('success', 'Expence Sub Sub-Ledger Created Successfull');
        }
    }

  	public function expenceSubSubDelete(Request $request){
      //dd($request->id);
    	 DB::table('expanse_sub_subgroups')->where('id',$request->id)->delete();
      return redirect()->back()->with('success', 'Expence Sub-Ledger Deleted Successfull');
    }

    public function expansetypeCreate(Request $request)
    {

        $expansetypes = ExpanseType::all();

        return view('backend.account.expanse_type', compact('expansetypes'));
    }



    public function expansetypeStore(Request $request)
    {


     //   dd($request->all());

        $MainBank = new ExpanseType();
        $MainBank->title = $request->title;
        $MainBank->description = $request->description;
        $MainBank->save();


        return redirect()->back()
            ->with('success', 'Created Successfull');
    }


  	public function deleteexpansetype(Request $request)
    {
    //  dd($request->all());
      ExpanseType::where('id',$request->id)->delete();
      return redirect()->back()
            ->with('success', 'Main Bank Deleted Successfull');
    }




    public function bankBookIndex()
    {

        $allBanks = MasterBank::orderBy('bank_name', 'asc')->get();

        //dd($banks);
        return view('backend.account.bank_book_index', compact('allBanks'));
    }


    public function bankBookReport(Request $request)
    {
        // dd($request->all());
        if (isset($request->date)) {
            $dates = explode(' - ', $request->date);
            $fdate = date('Y-m-d', strtotime($dates[0]));
            $tdate = date('Y-m-d', strtotime($dates[1]));
        }

		if($fdate == '2023-10-01'){
        $predate = "2023-09-30";
        } else {
        $predate = date('Y-m-d', strtotime('-1 day', strtotime($fdate)));
        }
        $payment_opening_date = DB::select('SELECT payments.payment_date FROM `payments`
        						GROUP BY payments.payment_date ORDER by payments.payment_date asc LIMIT 1');

        $startdate = '2023-09-30';


        if ($request->bank_id) {
            $allBanks = MasterBank::whereIn('bank_id', $request->bank_id)->orderBy('bank_name', 'asc')->get();
        } else {
            $allBanks = MasterBank::orderBy('bank_name', 'asc')->get();
        }

        return view('backend.account.bank_book_report', compact('allBanks', 'fdate', 'tdate', 'predate', 'startdate'));
    }

    public function bankBookReportGet($fdate, $tdate){
    $fdate = date('Y-m-d',  strtotime($fdate));
    $tdate = date('Y-m-d',  strtotime($tdate));
    if($fdate == '2023-10-01'){
        $predate = "2023-09-30";
        } else {
        $predate = date('Y-m-d', strtotime('-1 day', strtotime($fdate)));
        }
        $payment_opening_date = DB::select('SELECT payments.payment_date FROM `payments`
                    GROUP BY payments.payment_date ORDER by payments.payment_date asc LIMIT 1');

        $startdate = '2023-09-30';
        $allBanks = MasterBank::orderBy('bank_name', 'asc')->get();

        return view('backend.account.bank_book_report', compact('allBanks', 'fdate', 'tdate', 'predate', 'startdate'));
  }

  public function masterbankBookIndex()
    {

        $allBanks = MasterBank::orderBy('bank_name', 'asc')->get();
        $allmainBanks = MainBank::orderBy('name', 'asc')->get();

        //dd($banks);
        return view('backend.account.main_bank_book_index', compact('allBanks','allmainBanks'));
    }


    public function masterbankBookReport(Request $request)
    {


      //   dd($request->all());


        if (isset($request->date)) {
            $dates = explode(' - ', $request->date);
            $fdate = date('Y-m-d', strtotime($dates[0]));
            $tdate = date('Y-m-d', strtotime($dates[1]));
        }


        $predate =  $predate = date('Y-m-d', strtotime('-1 day', strtotime($fdate)));

        $payment_opening_date = DB::select('SELECT payments.payment_date FROM `payments`
        GROUP BY payments.payment_date ORDER by payments.payment_date asc LIMIT 1');

        $startdate = $payment_opening_date[0]->payment_date;


        if ($request->bank_id) {
            $allBanks = MasterBank::whereIn('bank_id', $request->bank_id)->orderBy('bank_name', 'asc')->get();
        } else {
            $allBanks = MasterBank::orderBy('bank_name', 'asc')->get();
        }

       if ($request->main_bank_id) {
                  $allMainBanks = MainBank::whereIn('id', $request->main_bank_id)
                    			->orderBy('name', 'asc')->get();

         $allBanks = [];

        } else {
            if ($request->bank_id) {
              $allMainBanks = MasterBank::select('main_banks.*')->leftjoin('main_banks','main_banks.id','=','master_banks.main_bank_id')
                			->whereIn('master_banks.bank_id', $request->bank_id)->groupby('main_banks.id')->whereNotNull('main_bank_id')
                    			->orderBy('main_banks.name', 'asc')->get();

                  $allBanks = MasterBank::whereIn('bank_id', $request->bank_id)->whereNull('main_bank_id')
                    ->orderBy('bank_name', 'asc')->get();
              } else {
              $allMainBanks = MasterBank::select('main_banks.*')->leftjoin('main_banks','main_banks.id','=','master_banks.main_bank_id')->whereNotNull('main_bank_id')
                				->groupby('main_banks.id')->orderBy('main_banks.name', 'asc')->get();
                  $allBanks =MasterBank::whereNull('main_bank_id')->orderBy('bank_name', 'asc')->get();
              }
        }

        //dd($allMainBanks);

        return view('backend.account.main_bank_book_report', compact('allBanks', 'fdate', 'tdate', 'predate', 'startdate','allMainBanks'));
    }


    public function cashBookIndex()
    {

        $allFactory = MasterCash::orderBy('wirehouse_name', 'asc')->get();

        //dd($banks);
        return view('backend.account.cash_book_index', compact('allFactory'));
    }


    public function cashBookReport(Request $request)
    {

        //dd($request->all());
        if (isset($request->date)) {
            $dates = explode(' - ', $request->date);
            $fdate = date('Y-m-d', strtotime($dates[0]));
            $tdate = date('Y-m-d', strtotime($dates[1]));
        }
      	if($fdate <= '2023-10-01'){
        $predate = "2023-09-30";
        } else {
        $predate = date('Y-m-d', strtotime('-1 day', strtotime($fdate)));
        }


       /* $payment_opening_date = DB::select('SELECT payments.payment_date FROM `payments`
        GROUP BY payments.payment_date ORDER by payments.payment_date asc LIMIT 1');

        $startdate = $payment_opening_date[0]->payment_date;
		*/
		$startdate ="2023-10-01";
        if ($request->wirehouse_id) {
           $allFactory = MasterCash::whereIn('wirehouse_id', $request->wirehouse_id)->orderBy('wirehouse_name', 'asc')->get();
          //$allFactory = MasterCash::whereIn('wirehouse_id', $request->wirehouse_id)->orderBy('wirehouse_name', 'asc')->get();
        } else {
            //$allFactory = MasterCash::where('wirehouse_id', '!=', 47)->orderBy('wirehouse_name', 'asc')->get();
          $allFactory = MasterCash::orderBy('wirehouse_name', 'asc')->get();
        }

        //dd($allFactory);

        return view('backend.account.cash_book_report', compact('allFactory', 'fdate', 'tdate', 'predate', 'startdate'));
    }

    public function cashBookReportGet($fdate,$tdate){
      $fdate = date('Y-m-d',  strtotime($fdate));
      $tdate = date('Y-m-d',  strtotime($tdate));
      if($fdate == '2023-10-01'){
          $predate = "2023-09-30";
          } else {
          $predate = date('Y-m-d', strtotime('-1 day', strtotime($fdate)));
          }
          $startdate ="2023-09-30";

            $allFactory = MasterCash::orderBy('wirehouse_name', 'asc')->get();

        return view('backend.account.cash_book_report', compact('allFactory', 'fdate', 'tdate', 'predate', 'startdate'));
    }

    public function trailbalanceIndex()
    {
        $areas = DealerArea::All();

        return view('backend.account.trail_balance_index', compact('areas'));
    }


   public function trailbalance(Request $request)
    {
        //dd($request->all());
        //$fdate = "2020-01-01";
       // $tdate = $request->date;
		//$cdate = "2022-12-01";
         if (isset($request->date)) {
             $dates = explode(' - ', $request->date);
             $fdate = date('Y-m-d', strtotime($dates[0]));
             $tdate = date('Y-m-d', strtotime($dates[1]));
         }
     $date = $fdate;
     $data = [];
     $purchaseData = DB::table('purchase_stockouts')->select('stock_out_quantity','stock_out_rate')->whereNotNull('product_id')->whereBetween('date',[$fdate,$tdate])->get();
     $totalPurchase = 0;
     foreach($purchaseData as $val){
     	$totalPurchase += $val->stock_out_quantity * $val->stock_out_rate;
     }
     //dd($totalPurchase);
     $cogsData = $totalPurchase;
     $data['purchase_amount'] = DB::table('purchase_ledgers')
            ->whereNotNull('supplier_id')
            ->whereBetween('date', [$fdate, $tdate])
            ->sum('credit');
     $damage = DB::table('purchase_damages')->whereNotNull('product_id')->whereBetween('date', [$fdate, $tdate])->get();
     $totalDamageVal =0;
     foreach($damage as $val)
     {
     $totalDamageVal += $val->quantity*$val->rate;
     }
     $data['totalDamageVal'] = $totalDamageVal;
    // dd($data['purchase_amount']);

        $data['purchase_return'] = DB::table('purchase_returns')
                    ->whereBetween('date', [$fdate, $tdate])
                    ->sum('total_amount');

     $data['purchase_sup_payment_amount'] = DB::table('purchase_ledgers')
                                ->whereNotNull('supplier_id')
                                ->whereBetween('date', [$fdate, $tdate])
                                ->sum('debit');
      //$startdate = '2023-01-01'; $fdate
		$startdate = $fdate;
     // dd($tdate); ->where('category_id',32)
	//	$predate = date('Y-m-d', strtotime('-1 day', strtotime($fdate)));

		if($fdate > '2023-07-01'){
                    $predate = date('Y-m-d', strtotime('-1 day', strtotime($fdate)));
                        } else {
                                $predate ='2023-07-01';
                                }
      /*
        $data['rmproduct'] = RowMaterialsProduct::where('unit','Kg')->orderBy('product_name', 'ASC')->get();
     	$gtotlaStock = 0;
      $gtotalReturn = 0;
      $total_stockoutval = 0;
      $gTotalstockPurchase = 0;
	  $gTotalReturnPurchase = 0;
      $sdate = '2023-01-01';
      $pdate = date('Y-m-d', strtotime('-1 day', strtotime($fdate)));
      foreach ($data['rmproduct'] as $key => $data){

      	$data['opbcalculet'] = DB::table('row_materials_products')->where('id',$data->id)->sum('opening_balance');
       $data['stocin'] = DB::table('purchases')->where('product_id',$data->id)->whereBetween('date',[$fdate,$tdate])->sum('inventory_receive');
       $dataRate = DB::table('purchases')->select('bill_quantity','purchase_value')->where('product_id', $data->id)->whereBetween('date',[$fdate,$tdate])->get();
                                $valueTemp = 0;
                                $valueQty = 0;
                                $rate = 0;
                                foreach($dataRate as $key => $val){
                                  $valueTemp += $val->purchase_value;
                                  $valueQty += $val->bill_quantity;
                                }
                                if($valueTemp > 0 && $valueQty > 0){
                                  $rate = $valueTemp / $valueQty;
                                  $rate = round($rate,2);
                                } else {
                                $rate = 0;
                              }
       /* $avgrate = DB::select('SELECT AVG(purchases.purchase_rate) as rate FROM `purchases`
        WHERE purchases.product_id ="'.$data->id.'" and purchases.date between "'.$startdate.'" and "'.$tdate.'"');
        $pRate = $avgrate[0]->rate; */

       /*	$data['stocko'] = DB::table('purchase_stockouts')->where('product_id',$data->id)->whereBetween('date',[$fdate,$tdate])->sum('stock_out_quantity');
        $data['return'] = DB::table('purchase_returns')->where('product_id',$data->id)->whereBetween('date',[$fdate,$tdate])->sum('return_quantity');
        $data['pre_stocko'] = DB::table('purchases')->where('product_id',$data->id)->whereBetween('date',[$fdate,$pdate])->sum('receive_quantity');
                                  if(!$data['stocin']){
                                  $qty = round($data['opbcalculet'] + $data['pre_stocko'],2);
                                   // $qty = round($opbcalculet[0]->opening_blns + $pre_stocko[0]->stockout,2);
                                  } else {
                                  $qty = round($data['opbcalculet'] + $data['pre_stocko'],2) + round($data['stocin'],2);
                                     //$qty = round($opbcalculet[0]->opening_blns + $pre_stocko[0]->stockout,2) + round($stocin[0]->stock_in,2);
                                  }

                                  $gtotlaStock += round($qty*$rate,2);
         $gtotalReturn += round($data['return'],2)*$rate;
         $total_stockoutval += round($data['stocko'],2)*$rate;

      }
	if(date("m", strtotime($fdate)) == 01){
    $data['bagPurchase'] = DB::table('purchase_details')->leftjoin('purchases', 'purchases.purchase_id','=','purchase_details.purchase_id')->whereBetween('purchases.date', [$fdate, $tdate])->sum('amount');
    } else {
    $data['bagPurchase'] = 0;
    }
      // $data['bagStockOut'] = DB::table('purchase_stockouts')->leftjoin('row_materials_products as r', 'r.id','=','purchase_stockouts.product_id')->where('r.unit','PCS')->whereBetween('purchase_stockouts.date', [$fdate, $tdate])->sum('total_amount');
	$data['packing_cost'] = DB::table('packing_consumptions')->whereBetween('date', [$fdate, $tdate])->sum('amount');
     $dir_labordata = DB::select('SELECT SUM(direct_labour_costs.total_cost) as dlcost FROM `direct_labour_costs`
                    	WHERE  direct_labour_costs.date BETWEEN "'.$fdate.'" and "'.$tdate.'"');

        $manufacturingcost = DB::select('SELECT SUM(manufacturing_costs.total_cost) as mfcost FROM `manufacturing_costs` WHERE  manufacturing_costs.date BETWEEN "'.$fdate.'" and "'.$tdate.'"');
		$data['packing_cost'] = DB::table('packing_consumptions')->whereBetween('date', [$fdate, $tdate])->sum('amount');

    	$data['inventory'] = ($gtotlaStock + $data['bagPurchase']) - ($total_stockoutval + $data['packing_cost'] + $gtotalReturn);  */
    	//$data['cogs'] = $total_stockoutval + $data['packing_cost'] + $dir_labordata[0]->dlcost + $manufacturingcost[0]->mfcost;
     	//$tempdata = $data['packing_cost'] + $dir_labordata[0]->dlcost + $manufacturingcost[0]->mfcost;
     	//dd($total_stockoutval);

     //dd($total_stockoutval);
   // $data['totalPurchase'] = $gTotalstockPurchase - $gTotalReturnPurchase;
        /*$sales = DB::table('sales_ledgers')->select([DB::raw("SUM(total_price) total_price"), DB::raw("SUM(discount_amount) discount_amount")])
                    ->whereNotNull('sale_id')->whereBetween('ledger_date', [$fdate, $tdate])->first(); */
        $sales = SalesLedger::whereBetween('ledger_date', [$fdate, $tdate])->sum('total_price');



        $data['sales_amount'] = $sales;

        $data['sales_return'] = DB::table('sales_returns')
            ->where('is_active', 1)
            ->whereBetween('date', [$fdate, $tdate])
            ->sum('grand_total');
       //$data['receive_amount'] = $sales->total_credit;
       $data['receive_amount'] = DB::table('sales_ledgers')
            ->whereNotNull('invoice')
            ->whereBetween('ledger_date', [$fdate, $tdate])
            ->sum('credit');

     $data['expanse_amount'] = DB::table('payments')
            ->where('payment_type', 'EXPANSE')
           ->where('status', 1)
            ->whereBetween('payment_date', [$fdate, $tdate])
            ->sum('amount');

      $data['expanse_details'] = DB::table('payments')->select([
                              DB::raw("SUM(amount) expamount"),'expanse_subgroups.group_id','expanse_subgroups.group_name'])
                           ->leftJoin('expanse_subgroups', 'expanse_subgroups.id', '=', 'payments.expanse_subgroup_id')
                           ->where('payment_type', 'EXPANSE')
                          ->where('status', 1)
                          ->whereBetween('payment_date', [$fdate, $tdate])
                          ->groupby('expanse_subgroups.group_id')->get();


      //$fdate = '2023-01-01';


     	$data['equitiy'] = DB::table('equities')->whereBetween('date', [$fdate, $tdate])->sum('amount');
       //	$allBanks = MasterBank::orderBy('bank_name', 'asc')->get();

		/*TRANSFER Debit  */
		$data['bank_transfer_amount'] = DB::table('payments')
          	->whereNotNull('bank_id')
            ->where('payment_type', 'TRANSFER')->where('transfer_type', 'RECEIVE')
            ->where('status', 1)
            ->whereBetween('payment_date', [$startdate, $tdate])
            ->sum('amount');

     $data['bank_transfer_payment'] = DB::table('payments')
          				->whereNotNull('bank_id')->where('payment_type', 'TRANSFER')->where('transfer_type', 'PAYMENT')->where('status', 1)->whereBetween('payment_date', [$startdate, $tdate])->sum('amount');

      	$data['cash_transfer_receive_amount'] = DB::table('payments')->where('type', 'CASH')->where('payment_type', 'TRANSFER')->where('transfer_type', 'RECEIVE')->where('wirehouse_id', '!=', 47)->where('status', 1)->whereBetween('payment_date', [$startdate, $tdate])->sum('amount');
		$data['cash_transfer_payment_amount'] = DB::table('payments')->where('type', 'CASH')->where('payment_type', 'TRANSFER')->where('transfer_type', 'PAYMENT')->where('wirehouse_id', '!=', 47)->where('status', 1)->whereBetween('payment_date', [$startdate, $tdate])->sum('amount');


      	$data['bank_open'] = DB::table('master_banks')->sum('bank_op');
      	$data['cash_open'] = DB::table('master_cashes')->where('wirehouse_id', '!=', 47)->sum('wirehouse_opb');
      	$data['bank_receive_amount'] = DB::table('payments')->where('payment_type', 'RECEIVE')->where('type', 'BANK')->where('status', 1)->whereBetween('payment_date', [$startdate, $tdate])->sum('amount');

     	$data['cash_receive_amount'] = DB::table('payments')->where('payment_type', 'RECEIVE')->where('type', 'CASH')->where('wirehouse_id', '!=', 47)->where('status', 1)->whereBetween('payment_date', [$startdate, $tdate])->sum('amount');

      $data['expanse_amount_bank'] = DB::table('payments')
            ->where('payment_type', 'EXPANSE')
        	->where('type', 'BANK')
           ->where('status', 1)
            ->whereBetween('payment_date', [$startdate, $tdate])
            ->sum('amount');

	$data['bankCharge_amount'] = DB::table('payments')
            ->where('payment_type', 'EXPANSE')
        	->where('type', 'BANK')
           ->where('status', 2)->where('expanse_status', 2)
            ->whereBetween('payment_date', [$startdate, $tdate])
            ->sum('amount');

      $data['expanse_amount_cash'] = DB::table('payments')
            ->where('payment_type', 'EXPANSE')
        	->where('type', 'CASH')->where('status', 1)
           ->where('wirehouse_id', '!=', 47)
            ->whereBetween('payment_date', [$startdate, $tdate])
            ->sum('amount');

      $data['bank_payment_amount'] = DB::table('payments')
            ->where('status', 1)
        	->where('type', 'BANK')
            ->where('payment_type', 'PAYMENT')
            ->whereBetween('payment_date', [$startdate, $tdate])
            ->sum('amount');

      $data['cash_payment_amount'] = DB::table('payments')
            ->where('wirehouse_id', '!=', 47)
        	->where('type', 'CASH')->where('status', 1)
            ->where('payment_type', 'PAYMENT')
            ->whereBetween('payment_date', [$startdate, $tdate])
            ->sum('amount');

      /* Only for SHIMUL ENTERPRISE- RAJSHAHI here table-name 'master_cashes' & 'wirehouse_id', '=', 47 */
      $cash_open = DB::table('master_cashes')->where('wirehouse_id', '=', 47)->sum('wirehouse_opb');
      $cash_receive = DB::table('payments')->where('payment_type', 'RECEIVE')->where('type', 'CASH')->where('wirehouse_id', '=', 47)->where('status', 1)->whereBetween('payment_date', [$fdate, $tdate])->sum('amount');
      $cash_transfer_amount = DB::table('payments')->where('type', 'CASH')->where('payment_type', 'TRANSFER')->where('wirehouse_id', '=', 47)->where('transfer_type', 'RECEIVE')->where('status', 1)->whereBetween('payment_date', [$fdate, $tdate])->sum('amount');
      $cash_transfer_payment_amount = DB::table('payments')->where('type', 'CASH')->where('payment_type', 'TRANSFER')->where('wirehouse_id', '=', 47)->where('transfer_type', 'PAYMENT')->where('status', 1)->whereBetween('payment_date', [$fdate, $tdate])->sum('amount');
      $cash_amount = DB::table('payments')->where('type', 'CASH')->where('payment_type', 'PAYMENT')->where('wirehouse_id', '=', 47)->where('status', 1)->whereBetween('payment_date', [$fdate, $tdate])->sum('amount');
      $expanse_amount = DB::table('payments')->where('payment_type', 'EXPANSE')->where('type', 'CASH')->where('wirehouse_id', '=', 47)->where('status', 1)->whereBetween('payment_date', [$fdate, $tdate]) ->sum('amount');

      //$data['shimul_amount'] =  ($cash_amount + $expanse_amount + $cash_transfer_rec_amount) - ($cash_open + $cash_receive + $cash_transfer_amount + $cash_transfer_pay_amount);
      $data['shimul_amount'] =  ($cash_amount + $expanse_amount + $cash_transfer_payment_amount) - ($cash_open + $cash_receive + $cash_transfer_amount);

	  //$data['laibilities'] =	$data['shimul_amount'];

      /* end */
//dd($cash_transfer_amount);
        $data['payment_amount'] = DB::table('payments')
            ->where('status', 1)
            ->where('payment_type', 'PAYMENT')
            ->whereBetween('payment_date', [$fdate, $tdate])
            ->sum('amount');


		//$startDate = '2023-01-01'; ->whereNotNull('product_id')


        /*$data['sales_amount'] = DB::table('sales')
            ->where('is_active', 1)
            ->whereBetween('date', [$fdate, $tdate])
            ->sum('grand_total');

     $data['sales_amount'] = DB::table('sales_ledgers')->select([DB::raw("SUM(discount_amount) discount"),DB::raw("SUM(total_price) total")])
            ->whereNotIn('sale_id',[304,302,295,296,297,298,307])
            ->whereBetween('ledger_date', [$fdate, $tdate])->get();

     //dd($data['sales_amount']);
     */

     /* if($tdate <= '2023-01-31'){
       $data['sales_amount'] = 127212135;
     } else {}  */



     /*	$data['sales_amount'] = DB::table('sales_ledgers')
            ->whereNotNull('sale_id')
            ->whereBetween('ledger_date', [$fdate, $tdate])
            ->sum('total_price'); */



    /* $data['sales_amount'] = DB::table('sales_ledgers')
            ->whereNotNull('sale_id')
            ->whereBetween('ledger_date', [$fdate, $tdate])
            ->sum('total_price'); */


        $data['journal_debit'] = DB::table('journal_entries')
            ->whereBetween('date', [$fdate, $tdate])
            ->sum('debit');
        $data['journal_credit'] = DB::table('journal_entries')
            ->whereBetween('date', [$fdate, $tdate])
            ->sum('credit');

        $data['general_purchase_amount'] = DB::table('general_purchases')
            ->whereBetween('date', [$fdate, $tdate])
            ->sum('total_value');
        $data['assets_amount'] = DB::table('assets')
            ->whereBetween('date', [$fdate, $tdate])
            ->sum('asset_value');

       $data['asset_depreciations'] = DB::table('asset_depreciations')
            ->whereBetween('date', [$fdate, $tdate])
           ->sum('yearly_amount');

      //  $data['equitiy'] = DB::table('equities')->whereBetween('date', [$cdate, $tdate])->sum('amount');

		$data['otherIncome'] = DB::table('payments as p')
          	->whereNotNull('p.income_source_id')->where('p.status', 1)->whereBetween('p.payment_date', [$fdate, $tdate])->sum('p.amount');

        $data['loan_amount'] = DB::table('master_banks')
         // ->where('loan_fdate', '<=', $fdate)
          ->whereBetween('loan_tdate', [$startdate, $tdate])
          ->sum('loan_amount');
       $data['bank_overderft'] = DB::table('master_banks')
         // ->where('loan_fdate', '<=', $fdate)
           ->whereBetween('loan_tdate', [$startdate, $tdate])
        	->sum('loan_amount');

       $data['borrow_from'] = DB::table('borrows')
         // ->where('loan_fdate', '<=', $fdate)
           ->whereBetween('date', [$startdate, $tdate])
         	 ->sum('amount');

       $data['lease'] = DB::table('leases')
         // ->where('loan_fdate', '<=', $fdate)
          ->whereBetween('date', [$startdate, $tdate])
        	->sum('amount');

      $data['bad_debt_amount'] = DB::table('bad_debts')
            ->whereBetween('date', [$startdate, $tdate])
         	->sum('amount');


            //FOR COGS


          //$allp = SalesProduct::all();
     /*
			$allp = SalesLedger::whereNotNull('product_id')->groupBy('product_id')->get('product_id');
            $startdate = '2020-01-01';
            $fdate2 =date('Y-m-d', strtotime('-1 day', strtotime($fdate)));

            foreach ($allp as $key => $product) {

                $todaystock = \App\Models\SalesStockIn::where('prouct_id',$product->product_id)->whereBetween('date',[$fdate2,$tdate])->sum('quantity');
                $openingstock = \App\Models\SalesStockIn::where('prouct_id',$product->product_id)->whereBetween('date',[$startdate,$fdate2])->sum('quantity');

                $sales = \App\Models\SalesLedger::where('product_id',$product->product_id)->whereBetween('ledger_date',[$fdate2,$tdate])->sum('qty_pcs');
                $opsales = \App\Models\SalesLedger::where('product_id',$product->product_id)->whereBetween('ledger_date',[$startdate,$fdate2])->sum('qty_pcs');


                $returnp = DB::table('sales_returns')->join('sales_return_items', 'sales_return_items.id', '=', 'sales_return_items.return_id')->where('product_id',$product->product_id)->whereBetween('date',[$fdate2,$tdate])->sum('qty');
                $opreturnp =DB::table('sales_returns')->join('sales_return_items', 'sales_return_items.id', '=', 'sales_return_items.return_id')->where('product_id',$product->product_id)->whereBetween('date',[$startdate,$fdate2])->sum('qty');



                $transfer_from = \App\Models\Transfer::where('product_id',$product->product_id)->whereBetween('date',[$fdate2,$tdate])->sum('qty');
                $optransfer_from = \App\Models\Transfer::where('product_id',$product->product_id)->whereBetween('date',[$startdate,$fdate2])->sum('qty');

                $transfer_to = \App\Models\Transfer::where('product_id',$product->product_id)->whereBetween('date',[$fdate2,$tdate])->sum('qty');
                $optransfer_to = \App\Models\Transfer::where('product_id',$product->product_id)->whereBetween('date',[$startdate,$fdate2])->sum('qty');

                $damage = \App\Models\SalesDamage::where('product_id',$product->product_id)->whereBetween('date',[$fdate2,$tdate])->sum('quantity');
                $opdamage = \App\Models\SalesDamage::where('product_id',$product->product_id)->whereBetween('date',[$startdate,$fdate2])->sum('quantity');

                $product_name = \App\Models\SalesProduct::where('id',$product->product_id)->value('product_name');

                $productdetails = SalesProduct::where('id',$product->product_id)->first();
				if(!empty($productdetails)){
                $pob = $productdetails->opening_balance;
                } else {
                $pob = 0;
                }
                $opblnce = ($pob+$openingstock+$optransfer_to)-($opsales+$optransfer_from+$opdamage);
                $clb = ($opblnce+$todaystock+$transfer_to)- ($sales+$transfer_from+$damage);

                $productrate = \App\Models\SalesStockIn::where('prouct_id',$product->product_id)->avg('production_rate');

              $openingbalance = $opblnce*$productrate;
              $clsingbalance =$clb*$productrate;
              $todaystock = $todaystock*$productrate;
           	  //dd($productrate);

                $productname = SalesProduct::where('id', $product->product_id)->value('product_name');


                  $dir_labordata=  DB::select('SELECT SUM(direct_labour_costs.total_cost) as dlcost FROM `direct_labour_costs`
                    WHERE  direct_labour_costs.fg_id ="'.$product->product_id.'" AND  direct_labour_costs.date BETWEEN "'.$startdate.'" and "'.$tdate.'"');

                $ind_labordate =   DB::select('SELECT SUM(indirect_costs.total_cost) as ilcost FROM `indirect_costs`
                WHERE  indirect_costs.fg_id ="'.$product->product_id.'" AND  indirect_costs.date BETWEEN "'.$startdate.'" and "'.$tdate.'"');


                $dir_labor =  $dir_labordata[0]->dlcost;
                $ind_labor =  $ind_labordate[0]->ilcost;

              $cogs += ($openingbalance + $todaystock - $clsingbalance)+($dir_labor+$ind_labor);

            }
     */
			//dd($clsingbalance);



          //dd($cogs);


     //  dd($data);
	/*$cogs = 0;
	$startdate = '2022-06-01';
    $fdate2 =date('Y-m-d', strtotime('-1 day', strtotime($fdate)));

	$rmproduct = RowMaterialsProduct::all();

      	$cogs2 = 0;
     	//$pdate =  date('Y-m-d', strtotime('-1 day', strtotime($fdate)));
      	$mydate = Purchase::orderBy('date', 'asc')->value('date');
        if(!empty($mydate)){
          $sdate = Purchase::orderBy('date', 'asc')->first()->date;
        }


      foreach ($rmproduct as $key => $product){
		$opening_balanceppp = RowMaterialsProduct::where('id', $product->id)->value('opening_balance');

        $opening_balance  = DB::select('SELECT SUM(purchase_set_opening_balance.opening_balance) as opbalance FROM `purchase_set_opening_balance`
            where purchase_set_opening_balance.product_id="' . $product->id . '"  and  purchase_set_opening_balance.date between "' . $startdate . '" and "' . $tdate . '" ');


        $stocktotal = DB::select('SELECT SUM(purchases.inventory_receive) as srcv FROM `purchases`
            where purchases.product_id="' . $product->id . '" and  purchases.date between "' . $fdate . '" and "' . $tdate . '" ');

        $pre_stocktotal = DB::select('SELECT SUM(purchases.inventory_receive) as srcv FROM `purchases`
            where purchases.product_id="' . $product->id . '"  and  purchases.date between "' . $startdate . '" and "' . $fdate2 . '" ');

        $return = $returns = DB::select('SELECT SUM(purchase_returns.return_quantity) as return_qty FROM `purchase_returns`
             WHERE purchase_returns.product_id="' . $product->id . '" and purchase_returns.date between "' . $fdate . '" and "' . $tdate . '" ');
        $pre_return = $returns = DB::select('SELECT SUM(purchase_returns.return_quantity) as return_qty FROM `purchase_returns`
             WHERE purchase_returns.product_id="' . $product->id . '" and purchase_returns.date between "' . $startdate . '" and "' . $fdate2 . '"');

        $transfer_to = DB::select('SELECT SUM(purchase_transfers.receive_qty) as transfers_qty FROM `purchase_transfers`
            WHERE purchase_transfers.product_id="' . $product->id . '"  and purchase_transfers.date between "' . $fdate . '" and "' . $tdate . '" ');
        $pre_transfer_to = DB::select('SELECT SUM(purchase_transfers.receive_qty) as transfers_qty FROM `purchase_transfers`
            WHERE purchase_transfers.product_id="' . $product->id . '"  and purchase_transfers.date BETWEEN "' . $startdate . '" and "' . $fdate2. '"');

        $transfer_from = DB::select('SELECT SUM(purchase_transfers.qty) as transfers_qty FROM `purchase_transfers`
            WHERE purchase_transfers.product_id="' . $product->id . '"  and purchase_transfers.date between "' . $fdate . '" and "' . $tdate . '" ');
        $pre_transfer_from = DB::select('SELECT SUM(purchase_transfers.qty) as transfers_qty FROM `purchase_transfers`
            WHERE purchase_transfers.product_id="' . $product->id . '"  and purchase_transfers.date BETWEEN "' . $startdate. '" and "' . $fdate2 . '"');

        $stock_out = DB::select('SELECT SUM(purchase_stockouts.stock_out_quantity) as stockout FROM `purchase_stockouts`
            WHERE purchase_stockouts.product_id ="' . $product->id . '"  and purchase_stockouts.date between "' . $fdate . '" and "' . $tdate . '" ');
        $pre_stock_out = DB::select('SELECT SUM(purchase_stockouts.stock_out_quantity) as stockout FROM `purchase_stockouts`
            WHERE purchase_stockouts.product_id ="' . $product->id . '" and purchase_stockouts.date BETWEEN "' . $startdate . '" and "' . $fdate2 . '"');

        $openingbalance =  $opening_balanceppp+$opening_balance[0]->opbalance + $pre_stocktotal[0]->srcv - $pre_return[0]->return_qty + $pre_transfer_to[0]->transfers_qty - $pre_transfer_from[0]->transfers_qty - $pre_stock_out[0]->stockout;

        $clsingbalance = $openingbalance + $stocktotal[0]->srcv - $return[0]->return_qty + $transfer_to[0]->transfers_qty - $transfer_from[0]->transfers_qty - $stock_out[0]->stockout;

        $todaypurchase = $stocktotal[0]->srcv; */


		/*$dir_labordata =  DB::select('SELECT SUM(direct_labour_costs.total_cost) as dlcost FROM `direct_labour_costs`
                    WHERE  direct_labour_costs.fg_id ="'.$product->id.'" AND  direct_labour_costs.date BETWEEN "'.$startdate.'" and "'.$tdate.'"'); */

       /* $avgrate = DB::select('SELECT AVG(purchases.purchase_rate) as rate FROM `purchases`
        WHERE purchases.product_id ="'.$product->id.'" and purchases.date between "'.$startdate.'" and "'.$tdate.'"');
        $rate = $avgrate[0]->rate; */
       /*
        $billQty = 0;
     	$billAmount = 0;
        $avgrateData = DB::select('SELECT `bill_quantity`,`purchase_value` FROM `purchases`
        WHERE purchases.product_id ="'.$product->id.'" and purchases.date between "'.$startdate.'" and "'.$tdate.'"');
		//dd($avgrateData);
        foreach($avgrateData as $val){
        $billQty += $val->bill_quantity;
     	$billAmount += $val->purchase_value;
        }
        if($billQty > 0){
        	$rate = $billAmount/$billQty;
        }
        */
        //dd($rate);
        /*$openingbalance = $openingbalance*$rate;
        $clsingbalance = $clsingbalance*$rate;
        $todaypurchase = $todaypurchase*$rate;
        $cogs2 += ($openingbalance + $todaypurchase) - $clsingbalance;
        }

     	$dir_labordata = DB::select('SELECT SUM(direct_labour_costs.total_cost) as dlcost FROM `direct_labour_costs`
                    	WHERE  direct_labour_costs.date BETWEEN "'.$fdate.'" and "'.$tdate.'"'); */
        /*$ind_labordate = DB::select('SELECT SUM(indirect_costs.total_cost) as ilcost FROM `indirect_costs`
                		WHERE  indirect_costs.fg_id ="'.$product->id.'" AND  indirect_costs.date BETWEEN "'.$startdate.'" and "'.$tdate.'"'); */

        /*$manufacturingcost = DB::select('SELECT SUM(manufacturing_costs.total_cost) as mfcost FROM `manufacturing_costs` WHERE  manufacturing_costs.date BETWEEN "'.$fdate.'" and "'.$tdate.'"');
		$data['packing_cost'] = DB::table('packing_consumptions')->whereBetween('date', [$fdate, $tdate])->sum('amount');
		$cogs2 += $dir_labordata[0]->dlcost + $manufacturingcost[0]->mfcost + $data['packing_cost']; */

		//dd($dLabour);
 	 //dd($cogs);

   	//dd($data['sales_amount']);
     //$data['cogs'] = 0;
    // dd($sales);

        return view('backend.account.trail_balance', compact('sales','cogsData','startdate','date', 'fdate', 'tdate', 'data'));
    }


    public function trailbalanceheadchangestore(Request $request)
    {
       // dd($request->all());
        //$fdate = "2020-01-01";
       // $tdate = $request->date;

      $uid = Auth::id();

      DB::table('trail_balance_heads')->where('user_id',$uid)->delete();

      foreach($request->head as $key=> $data){
        if($request->change_name[$key] != null){
          DB::table('trail_balance_heads')->insert([

            'head'=>$request->head[$key],
            'change_name'=>$request->change_name[$key],
            'user_id'=>$uid,

          ]);

        }
      }

        return redirect()->back();
    }



 	public function incomeStatementIndexNew()
    {
    $areas = DealerArea::All();

        return view('backend.account.new_income_statement_input', compact('areas'));
    }

  public function incomeStatementNew(Request $request)
    {
        //dd($request->all());

      //  $fdate = "2020-01-01";
      //  $tdate = $request->date;

          if (isset($request->date)) {
             $dates = explode(' - ', $request->date);
             $fdate = date('Y-m-d', strtotime($dates[0]));
             $tdate = date('Y-m-d', strtotime($dates[1]));
            $year = date('Y', strtotime($tdate));
         }

        // dd($request);
        // $fdate = $request->from_date;
        // $tdate = $request->to_date;
        // $dlr_id = $request->vendor_id;

        $data = [];




      	$sales_amount =  DB::table('sales_ledgers')->select(DB::raw('sum(total_price) as totalPrice'),DB::raw('sum(discount_amount) as discountPrice'))
              ->whereNotNull('sale_id')
              ->whereBetween('ledger_date', [$fdate, $tdate])
              ->first();
    $salesDealer =  DB::table('sales_ledgers')->select(DB::raw('sum(total_price) as totalPrice'),DB::raw('sum(discount_amount) as discountPrice'))
              ->whereNotIn('vendor_id',['284','285'])->whereNotNull('sale_id')
              ->whereBetween('ledger_date', [$fdate, $tdate])
              ->first();
      $data['salesDealer'] = $salesDealer->totalPrice + $salesDealer->discountPrice;
     /*   $total_sales_amount =  DB::table('sales')->where('ledger_status',1)
              ->whereNotNull('invoice_no')
              ->whereBetween('date', [$fdate, $tdate])
              ->sum('price'); */

   		$data['sales'] = $sales_amount->totalPrice + $sales_amount->discountPrice;

         $data['sales_return'] = DB::table('sales_returns')
            ->where('is_active', 1)
            ->whereBetween('date', [$fdate, $tdate])
            ->sum('grand_total');


		/* if($tdate <= '2023-01-31'){
          $data['sales'] = 127212135;
        } else {}

        $data['sales'] = $sales_amount - $sales_return; */


      /* $data['asset_depreciations'] = DB::table('asset_depreciations')->select('asset_depreciations.*','asset_products.product_name','assets.asset_head')
          		->leftJoin('assets', 'assets.id', 'asset_depreciations.asset_id')
          		->leftJoin('asset_products', 'asset_products.id', 'asset_depreciations.asset_product_id')
            ->whereBetween('asset_depreciations.date', [$fdate, $tdate])
            ->get();
            */

		 $data['asset_depreciations'] = DB::table('asset_depreciations')->leftJoin('assets', 'assets.id', 'asset_depreciations.asset_id')
          		->leftJoin('asset_products', 'asset_products.id', 'asset_depreciations.asset_product_id')
            	->whereBetween('asset_depreciations.date', [$fdate, $tdate])->sum('asset_depreciations.yearly_amount');

		//dd($data['asset_depreciations']);


            $startdate = '2023-07-01';
    		if($fdate > '2023-07-01'){
            $fdate2 =date('Y-m-d', strtotime('-1 day', strtotime($fdate)));
            } else {
            $fdate2 = '2023-07-01';
            }

			$rmproduct = RowMaterialsProduct::all();

      	$cogs = 0;

      foreach ($rmproduct as $key => $product){
		$opening_balanceppp = RowMaterialsProduct::where('id', $product->id)->value('opening_balance');

        $opening_balance  = DB::select('SELECT SUM(purchase_set_opening_balance.opening_balance) as opbalance FROM `purchase_set_opening_balance`
            where purchase_set_opening_balance.product_id="' . $product->id . '"  and  purchase_set_opening_balance.date between "' . $startdate . '" and "' . $tdate . '" ');


        $stocktotal = DB::select('SELECT SUM(purchases.inventory_receive) as srcv FROM `purchases`
            where purchases.product_id="' . $product->id . '" and  purchases.date between "' . $fdate . '" and "' . $tdate . '" ');

        $pre_stocktotal = DB::select('SELECT SUM(purchases.inventory_receive) as srcv FROM `purchases`
            where purchases.product_id="' . $product->id . '"  and  purchases.date between "' . $startdate . '" and "' . $fdate2 . '" ');

        $return = $returns = DB::select('SELECT SUM(purchase_returns.return_quantity) as return_qty FROM `purchase_returns`
             WHERE purchase_returns.product_id="' . $product->id . '" and purchase_returns.date between "' . $fdate . '" and "' . $tdate . '" ');
        $pre_return =  DB::select('SELECT SUM(purchase_returns.return_quantity) as return_qty FROM `purchase_returns`
             WHERE purchase_returns.product_id="' . $product->id . '" and purchase_returns.date between "' . $startdate . '" and "' . $fdate2 . '"');

        $transfer_to = DB::select('SELECT SUM(purchase_transfers.receive_qty) as transfers_qty FROM `purchase_transfers`
            WHERE purchase_transfers.product_id="' . $product->id . '"  and purchase_transfers.date between "' . $fdate . '" and "' . $tdate . '" ');
        $pre_transfer_to = DB::select('SELECT SUM(purchase_transfers.receive_qty) as transfers_qty FROM `purchase_transfers`
            WHERE purchase_transfers.product_id="' . $product->id . '"  and purchase_transfers.date BETWEEN "' . $startdate . '" and "' . $fdate2. '"');

        $transfer_from = DB::select('SELECT SUM(purchase_transfers.qty) as transfers_qty FROM `purchase_transfers`
            WHERE purchase_transfers.product_id="' . $product->id . '"  and purchase_transfers.date between "' . $fdate . '" and "' . $tdate . '" ');
        $pre_transfer_from = DB::select('SELECT SUM(purchase_transfers.qty) as transfers_qty FROM `purchase_transfers`
            WHERE purchase_transfers.product_id="' . $product->id . '"  and purchase_transfers.date BETWEEN "' . $startdate. '" and "' . $fdate2 . '"');

        $stock_out = DB::select('SELECT SUM(purchase_stockouts.stock_out_quantity) as stockout FROM `purchase_stockouts`
            WHERE purchase_stockouts.product_id ="' . $product->id . '"  and purchase_stockouts.date between "' . $fdate . '" and "' . $tdate . '" ');
        $pre_stock_out = DB::select('SELECT SUM(purchase_stockouts.stock_out_quantity) as stockout FROM `purchase_stockouts`
            WHERE purchase_stockouts.product_id ="' . $product->id . '" and purchase_stockouts.date BETWEEN "' . $startdate . '" and "' . $fdate2 . '"');

        $openingbalance =  $opening_balanceppp+$opening_balance[0]->opbalance + $pre_stocktotal[0]->srcv - $pre_return[0]->return_qty + $pre_transfer_to[0]->transfers_qty - $pre_transfer_from[0]->transfers_qty - $pre_stock_out[0]->stockout;

        $clsingbalance = $openingbalance + $stocktotal[0]->srcv - $return[0]->return_qty + $transfer_to[0]->transfers_qty - $transfer_from[0]->transfers_qty - $stock_out[0]->stockout;

        $todaypurchase = $stocktotal[0]->srcv;

        $avgrate = DB::select('SELECT AVG(purchases.purchase_rate) as rate FROM `purchases`
        WHERE purchases.product_id ="'.$product->id.'" and purchases.date between "'.$startdate.'" and "'.$tdate.'"');

      $openingbalance = $openingbalance*$avgrate[0]->rate;
      $clsingbalance = $clsingbalance*$avgrate[0]->rate;
      $todaypurchase = $todaypurchase*$avgrate[0]->rate;
      $cogs += ($openingbalance + $todaypurchase) - $clsingbalance;
      }
      $data['dir_labordata'] = DB::select('SELECT SUM(direct_labour_costs.total_cost) as dlcost FROM `direct_labour_costs`
                    	WHERE  direct_labour_costs.date BETWEEN "'.$startdate.'" and "'.$tdate.'"');
        /*$ind_labordate = DB::select('SELECT SUM(indirect_costs.total_cost) as ilcost FROM `indirect_costs`
                		WHERE  indirect_costs.fg_id ="'.$product->id.'" AND  indirect_costs.date BETWEEN "'.$startdate.'" and "'.$tdate.'"'); */

        $data['manufacturingcost'] = DB::select('SELECT SUM(manufacturing_costs.total_cost) as mfcost FROM `manufacturing_costs` WHERE  manufacturing_costs.date BETWEEN "'.$startdate.'" and "'.$tdate.'"');

        $cogs += $data['dir_labordata'][0]->dlcost + $data['manufacturingcost'][0]->mfcost;

     	$data['cogs'] = $cogs;
        $allincome = $request->income_head;
        $alleincomeamount = $request->income_amount;


        $allincome =  DB::table('payments')->select([
                              DB::raw("SUM(amount) incomeamount"),
        					'income_sources.name','payments.income_source_id'
                           ])
      			->leftjoin('income_sources','income_sources.id', '=', 'payments.income_source_id')
          		->whereBetween('payment_date', [$fdate, $tdate])->where('payments.income_source_id','!=', ' ')
          		->groupby('income_source_id')->get();


        $allexpasne =  DB::table('payments')->select([
                              DB::raw("SUM(amount) expamount"),
        					'expanse_groups.id','expanse_groups.group_name'
                           ])
                         ->leftJoin('expanse_subgroups', 'expanse_subgroups.id', '=', 'payments.expanse_subgroup_id')
          				->leftJoin('expanse_groups', 'expanse_groups.id', '=', 'expanse_subgroups.group_id')
                         ->where('payment_type', 'EXPANSE')
                        ->whereBetween('payment_date', [$fdate, $tdate])
         				 ->where('status', 1)
                        ->groupby('expanse_subgroups.group_id')
                        ->get();
 //dd($allexpasneamount);

        	$taxes = DB::table('taxes')->where('year',$year)->value('tax');

      		//$financial_expenses = DB::table('financial_expenses')->where('year',$year)->value('expense');

      		$financial_expenses = DB::table('financial_expenses')->where('year',$year)->get();

        //dd($financial_expenses);
        return view('backend.account.PL_StatementReport', compact('sales_amount','fdate', 'tdate','taxes', 'data','allincome','allexpasne','financial_expenses'));
    }


    public function incomestatementIndex()
    {
    	$areas = DealerArea::All();
        return view('backend.account.income_statement_input', compact('areas'));
    }

    public function incomestatement(Request $request)
    {
          if (isset($request->date)) {
             $dates = explode(' - ', $request->date);
             $fdate = date('Y-m-d', strtotime($dates[0]));
             $tdate = date('Y-m-d', strtotime($dates[1]));
            $year = date('Y', strtotime($tdate));
         }
        $checkDate = $fdate;
            $data = [];
            $expenseData = [];
           $individualAccountInfo = $this->getChartOfExpenseAccountInfo($fdate, $tdate);
           foreach($individualAccountInfo as $account){
              /* if($checkDate == '2023-10-01'){
                 //$preStartDate = '2023-10-01';
                 $preEndDate = '2023-10-01';
                 $preData = ChartOfAccounts::with('acSubSubAccount:id,title')->select('ac_sub_account_id',
                         DB::raw('SUM(debit) - SUM(credit) as balance')
                         )->where('invoice','LIKE','E-Pay-Inv%')
                         ->where('ac_sub_account_id',$account->acSubAccount?->id)
                         ->where(function ($query) use ($fdate, $preEndDate) {
                         $query->whereBetween('date', [$fdate, $preEndDate]);
                       })->first();
               } else {
                 $preDepTime =  strtotime($fdate);
                 $fdate = '2023-10-01';
                 //$preStartDate = date("Y-m-01", strtotime("-1 month", $preDepTime));
                 $preEndDate = date("Y-m-t", strtotime("-1 month", $preDepTime));

                 $preData = ChartOfAccounts::select('ac_sub_account_id',
                         DB::raw('SUM(debit) - SUM(credit) as balance')
                         )
                         ->where('ac_sub_account_id',$account->acSubAccount?->id)
                         ->where(function ($query) use ($fdate, $preEndDate) {
                         $query->whereBetween('date', [$fdate, $preEndDate]);
                       })->first();
               }

               $fdate = '2023-10-01';

               $currentData = ChartOfAccounts::select('ac_sub_account_id',
                       DB::raw('SUM(debit) - SUM(credit) as balance')
                       )
                       ->where('ac_sub_account_id',$account->acSubAccount?->id)
                       ->where(function ($query) use ($fdate, $tdate) {
                       $query->whereBetween('date', [$fdate, $tdate]);
                     })->first();

                   $closing = $currentData->balance;
                   $opening = $preData->balance ?? 0;

                if($checkDate == '2023-10-01'){
                    $amount = $closing;
                    } else {
                        $amount = $closing - $opening;
                    }
                   */

                   if($checkDate == '2023-10-01'){
                     $preEndDate = '2023-10-01';
                     $preData = ChartOfAccounts::with('acSubSubAccount:id,title')->select('ac_sub_account_id',
                             DB::raw('SUM(debit) - SUM(credit) as balance')
                             )->where('invoice','LIKE','E-Pay-Inv%')
                             ->where('ac_sub_account_id',$account->acSubAccount?->id)->whereBetween('date', [$fdate, $preEndDate])->first();

                        $amount = $account->balance -  $preData->balance;
                   } else {
                       $amount = $account->balance;
                   }

                   $expenseData[] = $this->getDebitForIncomeStatement($account->ac_sub_account_id, $account->acSubAccount?->title,$amount);

           }



            if (isset($request->date)) {
             $dates = explode(' - ', $request->date);
             $fdate = date('Y-m-d', strtotime($dates[0]));
             $tdate = date('Y-m-d', strtotime($dates[1]));
            $year = date('Y', strtotime($tdate));
         }

                $fGoods = SalesProduct::select('id','opening_balance','rate')->whereNotNull('rate')->get();

          $closingFGStock = 0;
          $openingFGStock = 0;
          $startDate = '2023-10-01';
          if($fdate <= '2023-10-01'){
            $pdate = '2023-10-01';
          } else {
            $pdate = date('Y-m-d', strtotime('-1 day', strtotime($fdate)));
          }

            foreach($fGoods as $all_products){

              $stockOp = \App\Models\SalesStockIn::where('prouct_id',$all_products->id)->whereBetween('date',[$startDate,$pdate])->sum('quantity');
              $salesOp = \App\Models\SalesLedger::where('product_id',$all_products->id)->whereBetween('ledger_date',[$startDate,$pdate])->sum('qty_pcs');
              $returnpOp = DB::table('sales_returns')->join('sales_return_items', 'sales_returns.id', '=', 'sales_return_items.return_id')->where('sales_return_items.product_id',$all_products->id)->whereBetween('sales_returns.date',[$startDate,$pdate])->sum('sales_return_items.qty');
              $damageOp = \App\Models\SalesDamage::where('product_id',$all_products->id)->whereBetween('date',[$startDate,$pdate])->sum('quantity');
              $transfer_fromOp = \App\Models\Transfer::where('product_id',$all_products->id)->whereBetween('date',[$startDate,$pdate])->sum('qty');
              $transfer_toOp = \App\Models\Transfer::where('product_id',$all_products->id)->where('confirm_status', 1)->whereBetween('date',[$startDate,$pdate])->sum('qty');


                                      $stock = \App\Models\SalesStockIn::where('prouct_id',$all_products->id)->whereBetween('date',[$fdate,$tdate])->sum('quantity');
                                      $sales = \App\Models\SalesLedger::where('product_id',$all_products->id)->whereBetween('ledger_date',[$fdate,$tdate])->sum('qty_pcs');
                                      $returnp = DB::table('sales_returns')->join('sales_return_items', 'sales_returns.id', '=', 'sales_return_items.return_id')->where('sales_return_items.product_id',$all_products->id)->whereBetween('sales_returns.date',[$fdate,$tdate])->sum('sales_return_items.qty');
                                      $damage = \App\Models\SalesDamage::where('product_id',$all_products->id)->whereBetween('date',[$fdate,$tdate])->sum('quantity');
                                      $transfer_from = \App\Models\Transfer::where('product_id',$all_products->id)->whereBetween('date',[$fdate,$tdate])->sum('qty');
                                      $transfer_to = \App\Models\Transfer::where('product_id',$all_products->id)->where('confirm_status', 1)->whereBetween('date',[$fdate,$tdate])->sum('qty');

                                      $openingBalance = (($all_products->opening_balance + $stockOp + $returnpOp + $transfer_toOp) - ($damageOp + $salesOp + $transfer_fromOp)) * $all_products->rate;


                                      if($fdate <= '2023-10-01'){
                                      $closingFGStock += (($all_products->opening_balance + $stock + $returnp + $transfer_to) - ($damage + $sales + $transfer_from)) * $all_products->rate;
                                      $openingFGStock += $all_products->opening_balance * $all_products->rate;
                                    } else {
                                        $openingFGStock += $openingBalance;
                                      $closingFGStock += (($openingBalance + $stock + $returnp + $transfer_to) - ($damage + $sales + $transfer_from)) * $all_products->rate;

                                    }
            }


   $data['openingAmount'] = $openingFGStock;
   $data['closingAmount'] = $closingFGStock;

      	$sales_amount =  DB::table('sales_ledgers')->select(DB::raw('sum(total_price) as totalPrice'),DB::raw('sum(discount_amount) as discountPrice'))
              ->whereNotNull('sale_id')
              ->whereBetween('ledger_date', [$fdate, $tdate])
              ->first();

         $data['sales_return'] = DB::table('sales_returns')
            ->where('is_active', 1)
            ->whereBetween('date', [$fdate, $tdate])
            ->sum('grand_total');


          $data['salesDiscount'] = $sales_amount->discountPrice;
          $data['sales'] = $sales_amount->totalPrice + $sales_amount->discountPrice;


      $data['monthlyCom'] =  DB::table('sales_ledgers')->where('invoice','LIKE', 'Jar-%')->where('priority',100)
                          ->whereBetween('ledger_date', [$fdate, $tdate])
                          ->sum('credit');

		   $data['asset_depreciations'] = DB::table('asset_depreciations')->leftJoin('assets', 'assets.id', 'asset_depreciations.asset_id')
          		->leftJoin('asset_products', 'asset_products.id', 'asset_depreciations.asset_product_id')
            	->whereBetween('asset_depreciations.date', [$fdate, $tdate])->sum('asset_depreciations.yearly_amount');

        /* $allincome = $request->income_head;
        $alleincomeamount = $request->income_amount; */


        $allincome =  DB::table('payments')->select([ DB::raw("SUM(amount) incomeamount"),'income_sources.name','payments.income_source_id'])
                    ->leftjoin('income_sources','income_sources.id', '=', 'payments.income_source_id')
                    ->whereBetween('payment_date', [$fdate, $tdate])->where('payments.income_source_id','!=', ' ')
                    ->groupby('income_source_id')->get();


     /*   $allexpasne =  DB::table('payments')->select([
                              DB::raw("SUM(amount) expamount"),'expanse_groups.id','expanse_groups.group_name'])
          				     ->leftJoin('expanse_groups', 'expanse_groups.id', '=', 'payments.expanse_type_id')
                             ->where('payment_type', 'EXPANSE')
                             ->whereBetween('payment_date', [$fdate, $tdate])
         				      ->where('status', 1)
                             ->groupby('payments.expanse_type_id')->get(); */

        	$taxes = DB::table('taxes')->where('year',$year)->value('tax');

      		$financial_expenses = DB::table('financial_expenses')->where('year',$year)->get();


            $data['direct_labour_costs'] = DB::table('direct_labour_costs')
                                      ->where('status', 1)
                                      ->whereBetween('date', [$fdate, $tdate])
                                      ->sum('total_cost');

            $data['depreciationAmounts'] = AssetDepreciationInfoDetails::whereBetween('date',[$fdate, $tdate])->sum('account_value');
          /*
            $data['manufacturing_costs'] = DB::table('manufacturing_costs')->select('head','total_cost')
                                      ->where('status', 1)
                                      ->whereBetween('date', [$fdate, $tdate])->groupBy('head_id')->get();

            $data['totalManufacturingCost'] =  DB::table('manufacturing_costs')->where('status', 1)->whereBetween('date', [$fdate, $tdate]) ->sum('total_cost');

        */

         $categories = DB::table('sales_categories')->select('id', 'category_name as name')->whereIn('id',[34,35,36,37,38,40])->get();

         /* if($tdate <= '2023-10-31'){
            $totalRawCost = -11479;
        } else {
            $totalRawCost = 0;
        } */

          $totalRawCost = 0;
        $totalRawCost2 = 0;
        $totalPackCost = 0;
        $assetData = [];
        $individualAccountInfo = $this->getNewChartOfAccountInfoForIncomeStatement($fdate, $tdate);
        //dd($individualAccountInfo);
        foreach($individualAccountInfo as $account){
                if($account->acSubAccount?->id == 8){
            if($account->acSubSubAccount->title == 'Cost of Good Sold of Finished Goods (Packing)'){
                $totalPackCost += $account->total_debit - $account->total_credit;
            } elseif($account->acSubSubAccount->title == 'Cost of Good Sold of Finished Goods (FGCOGS)'){

                $totalRawCost += $account->total_debit - $account->total_credit;
            }
            elseif($account->acSubSubAccount->title == 'Cost of Goods Sold of Raw Material (RMCOGS)'){

                $totalRawCost2 += $account->total_debit - $account->total_credit;
            }else {

            }
          }
        }

        $assetData = [
            'rawCogs' => $totalRawCost + $totalRawCost2,
            'packCogs'  => $totalPackCost,
        ];

        $days = date_diff(date_create($fdate),date_create($tdate));

      //  dd($days->days);



      if($days->days <= 30){

        $totalExpCost = 0;

        foreach ($expenseData as $key => $value) {
          if($value['id'] != 60){
            $totalExpCost += $value['debit'];
          }
        }

        $totalIncome = 0;
        foreach ($allincome as $key=>$item) {
          $totalIncome += $item->incomeamount;
        }
        //dd($expenseData);
        $salesRevenue = ($totalIncome + $data['sales']) - ($data['sales_return'] + $sales_amount->discountPrice);
        $netAmount = $salesRevenue - $totalExpCost;
        //dd($netAmount);
        $preTime = strtotime($fdate);
        $preStartDate = date("Y-m-01", strtotime("-1 month", $preTime));
        $preEndDate = date("Y-m-t", strtotime("-1 month", $preTime));


        $retrailEarningOpening = IncomeStatement::whereBetween('date',[$preStartDate,$preEndDate])->sum('net_amount');

        if($netAmount > 0){
          $netAmountTotal = $retrailEarningOpening + $netAmount;
        }else{
          $netAmountTotal = $retrailEarningOpening - abs($netAmount);
        }

        $incomeStVal =  IncomeStatement::whereBetween('date',[$fdate,$tdate])->first();
        if($incomeStVal){
          $incomeStVal->date = $tdate;
          $incomeStVal->opening = $netAmount;
          $incomeStVal->net_amount = $netAmountTotal;
          $incomeStVal->note = $tdate.' Month Net Revenue Amount' ;
          $incomeStVal->save();
        } else {
          $incomeStatement = new IncomeStatement();
          $incomeStatement->date = $tdate;
          $incomeStatement->opening = $netAmount;
          $incomeStatement->net_amount = $netAmountTotal;
          $incomeStatement->note = $tdate.' Month Net Revenue Amount' ;
          $incomeStatement->save();
        }

      }

        return view('backend.account.nIncomeStatement', compact('assetData','expenseData','sales_amount','fdate', 'tdate','taxes', 'data','allincome','financial_expenses','categories'));
    }

    public function comparedIncomeStatementIndex(){
        return view('backend.account.chart_of_account.compared_pl_report_input');
    }

    public function comparedIncomeStatement(Request $request){
//  dd($request->all());
  $information = [];
      if($request->date){
        $dates = explode(' - ', $request->date);
        $fdate = date('Y-m-d', strtotime($dates[0]));
        $endDate = date('Y-m-d', strtotime($dates[1]));
      }
      $tdate = date("Y-m-t", strtotime($fdate));

      while($tdate <= $endDate){
          $monthWord = date('F, y', strtotime($fdate));
          $tdate = date("Y-m-t", strtotime($fdate));
          $year = date('Y', strtotime($tdate));

          $checkDate = $fdate;
              $data = [];

    /*          $expenseData = [];
             $individualAccountInfo = $this->getChartOfExpenseAccountInfo($fdate, $tdate);
             foreach($individualAccountInfo as $account){

                     if($checkDate == '2023-10-01'){
                       $preEndDate = '2023-10-01';
                       $preData = ChartOfAccounts::with('acSubSubAccount:id,title')->select('ac_sub_account_id',
                               DB::raw('SUM(debit) - SUM(credit) as balance')
                               )->where('invoice','LIKE','E-Pay-Inv%')
                               ->where('ac_sub_account_id',$account->acSubAccount?->id)->whereBetween('date', [$fdate, $preEndDate])->first();

                          $amount = $account->balance -  $preData->balance;
                     } else {
                         $amount = $account->balance;
                     }

                     $expenseData[] = $this->getDebitForIncomeStatement($account->ac_sub_account_id, $account->acSubAccount?->title,$amount);

             }
*/

             /* $expenseData = [];
             $expenseIds = SubAccount::select('id','title')->where('ac_main_account_id',5)->groupBy('title')->orderBy('title', 'asc')->get();
             foreach($expenseIds as $val){
               $temp = ChartOfAccounts::select( DB::raw('SUM(debit) as total_debit'),
                       DB::raw('SUM(credit) as total_credit'),
                       DB::raw('SUM(debit) - SUM(credit) as balance')
                   )->where('ac_main_account_id',5)->where('ac_sub_account_id',$val->id)
                   ->where(function ($query) use ($fdate, $tdate) {
                       $query->whereBetween('date', [$fdate, $tdate]);
                   })->first();

             $expenseData[] = $this->getDebitSectionExpense($val->id, $val->title, $temp->balance); */

             $expenseData = [];
            $individualAccountInfo = $this->getChartOfExpenseAccountInfo($fdate, $tdate);
                foreach($individualAccountInfo as $account){

                    if($checkDate == '2023-10-01'){
                     $preEndDate = '2023-10-01';
                     $preData = ChartOfAccounts::with('acSubSubAccount:id,title')->select('ac_sub_account_id',
                             DB::raw('SUM(debit) - SUM(credit) as balance')
                             )->where('invoice','LIKE','E-Pay-Inv%')
                             ->where('ac_sub_account_id',$account->acSubAccount?->id)->whereBetween('date', [$fdate, $preEndDate])->first();

                        $amount = $account->balance -  $preData->balance;
                   } else {
                       $amount = $account->balance;
                   }
                  $expenseData[] = $this->getDebitForIncomeStatement($account->ac_sub_account_id, $account->acSubAccount?->title,$amount);
                }



                  $fGoods = SalesProduct::select('id','opening_balance','rate')->whereNotNull('rate')->get();

            $closingFGStock = 0;
            $openingFGStock = 0;
            $startDate = '2023-10-01';
            if($fdate <= '2023-10-01'){
              $pdate = '2023-10-01';
            } else {
              $pdate = date('Y-m-d', strtotime('-1 day', strtotime($fdate)));
            }

              foreach($fGoods as $all_products){

                $stockOp = \App\Models\SalesStockIn::where('prouct_id',$all_products->id)->whereBetween('date',[$startDate,$pdate])->sum('quantity');
                $salesOp = \App\Models\SalesLedger::where('product_id',$all_products->id)->whereBetween('ledger_date',[$startDate,$pdate])->sum('qty_pcs');
                $returnpOp = DB::table('sales_returns')->join('sales_return_items', 'sales_returns.id', '=', 'sales_return_items.return_id')->where('sales_return_items.product_id',$all_products->id)->whereBetween('sales_returns.date',[$startDate,$pdate])->sum('sales_return_items.qty');
                $damageOp = \App\Models\SalesDamage::where('product_id',$all_products->id)->whereBetween('date',[$startDate,$pdate])->sum('quantity');
                $transfer_fromOp = \App\Models\Transfer::where('product_id',$all_products->id)->whereBetween('date',[$startDate,$pdate])->sum('qty');
                $transfer_toOp = \App\Models\Transfer::where('product_id',$all_products->id)->where('confirm_status', 1)->whereBetween('date',[$startDate,$pdate])->sum('qty');


                                        $stock = \App\Models\SalesStockIn::where('prouct_id',$all_products->id)->whereBetween('date',[$fdate,$tdate])->sum('quantity');
                                        $sales = \App\Models\SalesLedger::where('product_id',$all_products->id)->whereBetween('ledger_date',[$fdate,$tdate])->sum('qty_pcs');
                                        $returnp = DB::table('sales_returns')->join('sales_return_items', 'sales_returns.id', '=', 'sales_return_items.return_id')->where('sales_return_items.product_id',$all_products->id)->whereBetween('sales_returns.date',[$fdate,$tdate])->sum('sales_return_items.qty');
                                        $damage = \App\Models\SalesDamage::where('product_id',$all_products->id)->whereBetween('date',[$fdate,$tdate])->sum('quantity');
                                        $transfer_from = \App\Models\Transfer::where('product_id',$all_products->id)->whereBetween('date',[$fdate,$tdate])->sum('qty');
                                        $transfer_to = \App\Models\Transfer::where('product_id',$all_products->id)->where('confirm_status', 1)->whereBetween('date',[$fdate,$tdate])->sum('qty');

                                        $openingBalance = (($all_products->opening_balance + $stockOp + $returnpOp + $transfer_toOp) - ($damageOp + $salesOp + $transfer_fromOp)) * $all_products->rate;


                                        if($fdate <= '2023-10-01'){
                                        $closingFGStock += (($all_products->opening_balance + $stock + $returnp + $transfer_to) - ($damage + $sales + $transfer_from)) * $all_products->rate;
                                        $openingFGStock += $all_products->opening_balance * $all_products->rate;
                                      } else {
                                          $openingFGStock += $openingBalance;
                                        $closingFGStock += (($openingBalance + $stock + $returnp + $transfer_to) - ($damage + $sales + $transfer_from)) * $all_products->rate;

                                      }
              }


     $data['openingAmount'] = $openingFGStock;
     $data['closingAmount'] = $closingFGStock;

        	$sales_amount =  DB::table('sales_ledgers')->select(DB::raw('sum(total_price) as totalPrice'),DB::raw('sum(discount_amount) as discountPrice'))
                ->whereNotNull('sale_id')
                ->whereBetween('ledger_date', [$fdate, $tdate])
                ->first();

           $sales_return = DB::table('sales_returns')
              ->where('is_active', 1)
              ->whereBetween('date', [$fdate, $tdate])
              ->sum('grand_total');

        //   $salesRevenue = $sales_amount->totalPrice - ($sales_amount->discountPrice + $sales_return);
           $salesRevenue = $sales_amount->totalPrice - ($sales_return);
            //$data['salesDiscount'] = $sales_amount->discountPrice;

      /*  $data['monthlyCom'] =  DB::table('sales_ledgers')->where('invoice','LIKE', 'Jar-%')->where('priority',100)
                            ->whereBetween('ledger_date', [$fdate, $tdate])
                            ->sum('credit'); */

  		   $data['asset_depreciations'] = DB::table('asset_depreciations')->leftJoin('assets', 'assets.id', 'asset_depreciations.asset_id')
            		->leftJoin('asset_products', 'asset_products.id', 'asset_depreciations.asset_product_id')
              	->whereBetween('asset_depreciations.date', [$fdate, $tdate])->sum('asset_depreciations.yearly_amount');

        //  $allincome = $request->income_head;
          //$alleincomeamount = $request->income_amount;


          /*$allincome =  DB::table('payments')->select([ DB::raw("SUM(amount) incomeamount"),'income_sources.name','payments.income_source_id'])
                      ->leftjoin('income_sources','income_sources.id', '=', 'payments.income_source_id')
                      ->whereBetween('payment_date', [$fdate, $tdate])->where('payments.income_source_id','!=', ' ')
                      ->groupby('income_source_id')->get(); */

          $othersIncome = Payment::whereNotNull('income_source_id')->whereBetween('payment_date', [$fdate, $tdate])->sum('amount');

        /*  $allexpasne =  DB::table('payments')->select([
                                DB::raw("SUM(amount) expamount"),'expanse_groups.id','expanse_groups.group_name'])
            				                ->leftJoin('expanse_groups', 'expanse_groups.id', '=', 'payments.expanse_type_id')
                                    ->where('payment_type', 'EXPANSE')
                                    ->whereBetween('payment_date', [$fdate, $tdate])
           				                  ->where('status', 1)
                                    ->groupby('payments.expanse_type_id')->get(); */

          	    $taxes = DB::table('taxes')->where('year',$year)->value('tax');

        		$financial_expenses = DB::table('financial_expenses')->where('year',$year)->get();


                $data['direct_labour_costs'] = DB::table('direct_labour_costs')
                                        ->where('status', 1)
                                        ->whereBetween('date', [$fdate, $tdate])
                                        ->sum('total_cost');

           $data['depreciationAmounts'] = AssetDepreciationInfoDetails::whereBetween('date',[$fdate, $tdate])->sum('account_value');

          $totalRawCost = 0;
          $totalRawCost2 = 0;
          $totalPackCost = 0;
          $assetData = [];
          $individualAccountInfo = $this->getNewChartOfAccountInfoForIncomeStatement($fdate, $tdate);

          foreach($individualAccountInfo as $account){
                  if($account->acSubAccount?->id == 8){
              if($account->acSubSubAccount->title == 'Cost of Good Sold of Finished Goods (Packing)'){
                  $totalPackCost += $account->total_debit - $account->total_credit;
              } elseif($account->acSubSubAccount->title == 'Cost of Good Sold of Finished Goods (FGCOGS)'){

                  $totalRawCost += $account->total_debit - $account->total_credit;
              }
              elseif($account->acSubSubAccount->title == 'Cost of Goods Sold of Raw Material (RMCOGS)'){

                  $totalRawCost2 += $account->total_debit - $account->total_credit;
              }else {

              }
            }
          }

          $pCost = $totalRawCost + $totalRawCost2 + $totalPackCost;


          $tempArray = [
              'month' => $monthWord,
              'costData' => $pCost,
              'expenseData' => $expenseData,
              'taxes' => $taxes,
              'data' => $data,
              'othersIncome' => $othersIncome,
            //  'allexpasne' => $allexpasne,
              'financial_expenses' => $financial_expenses,
              'salesRevenue' => $salesRevenue,
              //'categories' => $categories,
          ];
          $information[] = $tempArray;
          $fdate = date("Y-m-d", strtotime( $tdate. " +1 day"));
          $tdate = date("Y-m-t", strtotime($fdate));
        }

      // dd($information);

        return view('backend.account.chart_of_account.compared_pl_report_view',[
            'information' => $information
        ]);
}

    public function incomestatement_oldMethod(Request $request)
    {
        //dd($request->all());

      //  $fdate = "2020-01-01";
      //  $tdate = $request->date;

          if (isset($request->date)) {
             $dates = explode(' - ', $request->date);
             $fdate = date('Y-m-d', strtotime($dates[0]));
             $tdate = date('Y-m-d', strtotime($dates[1]));
            $year = date('Y', strtotime($tdate));
         }

        // dd($request);
        // $fdate = $request->from_date;
        // $tdate = $request->to_date;
        // $dlr_id = $request->vendor_id;

        $data = [];
      if($request->type == 1){
      	$rmproduct = RowMaterialsProduct::where('category_id',31)->orderBy('product_name', 'ASC')->get();
        //$rmproduct = RowMaterialsProduct::orderBy('product_name', 'ASC')->get();
		$cogs = 0;
      	$totalStockoutRaw = 0;
        foreach ($rmproduct as $key => $data){
        $stockraw = DB::table('purchase_stockouts')->where('product_id',$data->id)->whereBetween('date',[$fdate,$tdate])->sum('total_amount');
        $totalStockoutRaw += $stockraw;
        }
        $cogsRaw = $totalStockoutRaw;

        $mediProduct = RowMaterialsProduct::where('category_id',32)->orderBy('product_name', 'ASC')->get();
      	$totalStockoutMedi = 0;

      foreach ($mediProduct as $key => $data){
       $stockmedi = DB::table('purchase_stockouts')->where('product_id',$data->id)->whereBetween('date',[$fdate,$tdate])->sum('total_amount');
       $totalStockoutMedi += $stockmedi;
      }
        $cogsRawM = $totalStockoutMedi;
    	$cogs =  $cogsRaw + $cogsRawM;
      }

      //dd($cogsRawM);

      if($request->type == 2) {
      	$rmproduct = RowMaterialsProduct::where('category_id',31)->orderBy('product_name', 'ASC')->get();
        //$rmproduct = RowMaterialsProduct::where('id',5)->orderBy('product_name', 'ASC')->get();
		$cogs = 0;
       $totalStockoutRaw = 0;
	   $sdate = '2023-07-01';
      foreach ($rmproduct as $key => $data){

       $stockraw = DB::table('purchase_stockouts')->where('product_id',$data->id)->whereBetween('date',[$fdate,$tdate])->sum('stock_out_quantity');
		//dd($stockraw);
       //$dataRate = DB::table('purchases')->select('bill_quantity','purchase_value')->where('product_id', $data->id)->whereBetween('date',[$sdate,$tdate])->get();
 		$dataPRate = DB::select('SELECT SUM(purchases.bill_quantity) as qty, SUM(purchases.purchase_value) as value FROM `purchases`
        			WHERE purchases.product_id ="'.$data->id.'" and purchases.date between "'.$fdate.'" and "'.$tdate.'"');

       /* if(empty($dataRate)){
          $rate = RowMaterialsProduct::where('id',$data->id)->value('rate');
          $totalStockoutRaw += round($stockraw*$rate,2);
          dd($rate);
        } else { */
                                $valueTemp = 0;
                                $valueQty = 0;
                                $rate = 0;
          						$openQty = 0;
                               /* foreach($dataRate as $key => $val){
                                  $valueTemp += $val->purchase_value;
                                  $valueQty += $val->bill_quantity;
                                }
          						$openTemp  = RowMaterialsProduct::select('rate','opening_balance')->where('id',$data->id)->first();
          						if($openTemp->opening_balance > 0 && $openTemp->rate > 0){
          						$openQty = $openTemp->opening_balance/$openTemp->rate;
          						$valueTemp += $openTemp->opening_balance;
          						$valueQty += $openQty;
                                } */

       						if(!empty($dataPRate[0]->value)){
          						$valueTemp = $dataPRate[0]->value;
          						$valueQty = $dataPRate[0]->qty;


          						$openTemp  = RowMaterialsProduct::select('rate','opening_balance')->where('id',$data->id)->first();
          						if($openTemp->opening_balance > 0 && $openTemp->rate > 0){
          						$openQty = $openTemp->opening_balance;
          						$valueTemp += $openTemp->opening_balance*$openTemp->rate;
          						$valueQty += $openQty;
                                }
                                  $rate = $valueTemp/$valueQty;
                                  $rate = round($rate,3);

          						} else {
                                $rate = RowMaterialsProduct::where('id',$data->id)->value('rate');

                                }


            $totalStockoutRaw += round($stockraw*$rate,3);

    }

      $cogsRaw = $totalStockoutRaw;
      //dd($cogsRaw);

    $mediProduct = RowMaterialsProduct::where('category_id',32)->orderBy('product_name', 'ASC')->get();

      $totalStockoutMedi = 0;

      foreach ($mediProduct as $key => $data){

       $stockmedi = DB::table('purchase_stockouts')->where('product_id',$data->id)->whereBetween('date',[$fdate,$tdate])->sum('stock_out_quantity');

      // $dataRate = DB::table('purchases')->select('bill_quantity','purchase_value')->where('product_id', $data->id)->whereBetween('date',[$sdate,$tdate])->get();
 		$dataPRate = DB::select('SELECT SUM(purchases.bill_quantity) as qty, SUM(purchases.purchase_value) as value FROM `purchases`
        			WHERE purchases.product_id ="'.$data->id.'" and purchases.date between "'.$fdate.'" and "'.$tdate.'"');

       /* if(empty($dataRate)){
          $rate = RowMaterialsProduct::where('id',$data->id)->value('rate');
          $totalStockoutMedi += round($stockmedi*$rate,2);
        } else { */
                               $valueTemp = 0;
                                $valueQty = 0;
                                $rate = 0;
          						$openQty = 0;
                               /* foreach($dataRate as $key => $val){
                                  $valueTemp += $val->purchase_value;
                                  $valueQty += $val->bill_quantity;
                                }
          					$openTemp  = RowMaterialsProduct::select('rate','opening_balance')->where('id',$data->id)->first();
          						if($openTemp->opening_balance > 0 && $openTemp->rate > 0){
          						$openQty = $openTemp->opening_balance/$openTemp->rate;
          						$valueTemp += $openTemp->opening_balance;
          						$valueQty += $openQty;
                                } */

        if(!empty($dataPRate[0]->value)) {
          						$valueTemp = $dataPRate[0]->value;
          						$valueQty = $dataPRate[0]->qty;
          						$openTemp  = RowMaterialsProduct::select('rate','opening_balance')->where('id',$data->id)->first();
          						if($openTemp->opening_balance > 0 && $openTemp->rate > 0){
          						$openQty = $openTemp->opening_balance;
          						$valueTemp += $openTemp->opening_balance*$openTemp->rate;
          						$valueQty += $openQty;
                                }

                                  $rate = $valueTemp/$valueQty;
                                  $rate = round($rate,3);
                                  //dd($rate);
                              } else {
                                $rate = RowMaterialsProduct::where('id',$data->id)->value('rate');
                                }



        //	$rate = ceil($rate);
            $totalStockoutMedi += round($stockmedi*$rate,3);

      }
	$cogsRawM = $totalStockoutMedi;

    $cogs =  $cogsRaw + $cogsRawM;
      }
    /*$dir_labordata = DB::select('SELECT SUM(direct_labour_costs.total_cost) as dlcost FROM `direct_labour_costs` WHERE  direct_labour_costs.date BETWEEN "'.$fdate.'" and "'.$tdate.'"');
    $manufacturingcost = DB::select('SELECT SUM(manufacturing_costs.total_cost) as mfcost FROM `manufacturing_costs` WHERE  manufacturing_costs.date BETWEEN "'.$fdate.'" and "'.$tdate.'"'); */


    $packing_cost = DB::table('packing_consumptions')->whereBetween('date', [$fdate, $tdate])->sum('amount');
    $manufacturingcost = DB::table('manufacturing_costs')->where('status', 1)->whereBetween('date', [$fdate, $tdate])->sum('total_cost');


   /* $fGoods = SalesStockIn::select('s.product_weight','sales_stock_ins.quantity as qty')
            ->leftjoin('sales_products as s' ,'s.id','=','sales_stock_ins.prouct_id')
            ->whereBetween('sales_stock_ins.date',[$fdate, $tdate])->get();
        $fgRate = 0;
        $productionKg = 0;
        foreach($fGoods as $val){
            $productionKg += $val->product_weight*$val->qty;
        }

     $totalAmount = DB::table('purchase_stockouts')->whereBetween('date',[$fdate,$tdate])->sum('total_amount');

     $fgRate = $totalAmount/$productionKg;
            */

            //$fGoods = SalesStockIn::whereBetween('date',[$fdate, $tdate])->groupby('prouct_id')->get();

            $fGoods = SalesStockIn::select('s.id','s.product_weight','s.product_barcode as rate','s.opening_balance as openingBag')
                    ->leftjoin('sales_products as s' ,'s.id','=','sales_stock_ins.prouct_id')
                    ->whereBetween('sales_stock_ins.date',[$fdate, $tdate])->groupby('sales_stock_ins.prouct_id')->get();

           // dd($fGoods);
            $openingKgAmount = 0; $closingKgAmount = 0;

            foreach($fGoods as $all_products){

              $startdate = '2023-07-01';
                                    $reprocessBag = 0;

                                    if($fdate > '2023-07-01'){
                                        $fdate2 = date('Y-m-d', strtotime('-1 day', strtotime($fdate)));
                                    }
                                    else {
                                        $fdate2 ='2023-07-01';
                                    }
                                    $todaystock = \App\Models\SalesStockIn::select([DB::raw("SUM(quantity) quantity")])->where('prouct_id',$all_products->id)->whereBetween('date',[$fdate,$tdate])->get();

                                    $openingstock = \App\Models\SalesStockIn::where('prouct_id',$all_products->id)->whereBetween('date',[$startdate,$fdate2])->sum('quantity');

                                    $sales = \App\Models\SalesLedger::where('product_id',$all_products->id)->whereBetween('ledger_date',[$fdate,$tdate])->sum('qty_pcs');
                                    $opsales = \App\Models\SalesLedger::where('product_id',$all_products->id)->whereBetween('ledger_date',[$startdate,$fdate2])->sum('qty_pcs');


                                    $returnp = DB::table('sales_returns')->join('sales_return_items', 'sales_returns.id', '=', 'sales_return_items.return_id')->where('sales_return_items.product_id',$all_products->id)->whereBetween('sales_returns.date',[$fdate,$tdate])->sum('sales_return_items.qty');
                                    $opreturnp =DB::table('sales_returns')->join('sales_return_items', 'sales_returns.id', '=', 'sales_return_items.return_id')->where('sales_return_items.product_id',$all_products->id)->whereBetween('sales_returns.date',[$startdate,$fdate2])->sum('sales_return_items.qty');


                                    $transfer_from = \App\Models\Transfer::where('product_id',$all_products->id)->whereBetween('date',[$fdate,$tdate])->sum('qty');
                                    $optransfer_from = \App\Models\Transfer::where('product_id',$all_products->id)->whereBetween('date',[$startdate,$fdate2])->sum('qty');

                                    $transfer_to = \App\Models\Transfer::where('product_id',$all_products->id)->where('confirm_status', 1)->whereBetween('date',[$fdate,$tdate])->sum('qty');
                                    $optransfer_to = \App\Models\Transfer::where('product_id',$all_products->id)->where('confirm_status', 1)->whereBetween('date',[$startdate,$fdate2])->sum('qty');

                                    $damage = \App\Models\SalesDamage::where('product_id',$all_products->id)->whereBetween('date',[$fdate,$tdate])->sum('quantity');
                                    $opdamage = \App\Models\SalesDamage::where('product_id',$all_products->id)->whereBetween('date',[$startdate,$fdate2])->sum('quantity');

                                    $reprocessQty = DB::table('reprocess')->where('fg_id',$all_products->id)->whereBetween('date',[$fdate,$tdate])->sum('quantity');


                                    $product_name = $all_products->product_name;
                                    $productWeight = $all_products->product_weight;
                                    $reprocessBag = $reprocessQty/$productWeight;


                                    $opblnce = ($openingstock+$optransfer_to + $all_products->openingBag)-($opsales+$optransfer_from+$opdamage);
                                    $clb = ($opblnce+$todaystock[0]->quantity+$transfer_to+$returnp)- ($sales+$returnp+$transfer_from+$damage+$reprocessBag);

                                    $openingKgAmount += $opblnce*$productWeight*$all_products->rate;
                                    $closingKgAmount += $clb*$productWeight*$all_products->rate;
            }

   $data['openingAmount'] = $openingKgAmount;
   $data['closingAmount'] = $closingKgAmount;

           // dd($closingKgAmount);

 //   //dd($productionValue);

      /* cogs Alldata start*/ /*
       $data['rmproduct'] = RowMaterialsProduct::where('unit','Kg')->orderBy('product_name', 'ASC')->get();
     	$gtotlaStock = 0;
      $gtotalReturn = 0;
      $total_stockoutval = 0;
      $gTotalstockPurchase = 0;
	  $gTotalReturnPurchase = 0;
      $sdate = '2023-01-01';
      $pdate = date('Y-m-d', strtotime('-1 day', strtotime($fdate)));
      foreach ($data['rmproduct'] as $key => $data){

      $data['opbcalculet'] = DB::table('row_materials_products')->where('id',$data->id)->sum('opening_balance');
       $data['stocin'] = DB::table('purchases')->where('product_id',$data->id)->whereBetween('date',[$fdate,$tdate])->sum('inventory_receive');
       $dataRate = DB::table('purchases')->select('bill_quantity','purchase_value')->where('product_id', $data->id)->whereBetween('date',[$fdate,$tdate])->get();
                                $valueTemp = 0;
                                $valueQty = 0;
                                $rate = 0;
                                foreach($dataRate as $key => $val){
                                  $valueTemp += $val->purchase_value;
                                  $valueQty += $val->bill_quantity;
                                }
                                if($valueTemp > 0 && $valueQty > 0){
                                  $rate = $valueTemp / $valueQty;
                                  $rate = round($rate,2);
                                } else {
                                $rate = 0;
                              }


       	$data['stocko'] = DB::table('purchase_stockouts')->where('product_id',$data->id)->whereBetween('date',[$fdate,$tdate])->sum('stock_out_quantity');
        $data['return'] = DB::table('purchase_returns')->where('product_id',$data->id)->whereBetween('date',[$fdate,$tdate])->sum('return_quantity');
        $data['pre_stocko'] = DB::table('purchases')->where('product_id',$data->id)->whereBetween('date',[$fdate,$pdate])->sum('receive_quantity');
                                  if(!$data['stocin']){
                                  $qty = round($data['opbcalculet'] + $data['pre_stocko'],2);
                                   // $qty = round($opbcalculet[0]->opening_blns + $pre_stocko[0]->stockout,2);
                                  } else {
                                  $qty = round($data['opbcalculet'] + $data['pre_stocko'],2) + round($data['stocin'],2);
                                     //$qty = round($opbcalculet[0]->opening_blns + $pre_stocko[0]->stockout,2) + round($stocin[0]->stock_in,2);
                                  }

                                  $gtotlaStock += round($qty*$rate,2);
         $gtotalReturn += round($data['return'],2)*$rate;
         $total_stockoutval += round($data['stocko'],2)*$rate;


      }
	if(date("m", strtotime($tdate)) == 01){
    $data['bagPurchase'] = DB::table('purchase_details')->leftjoin('purchases', 'purchases.purchase_id','=','purchase_details.purchase_id')->whereBetween('purchases.date', [$fdate, $tdate])->sum('amount');
    } else {
    $data['bagPurchase'] = 0;
    }

      //new cogs code
      $purchaseData = DB::table('purchase_stockouts')->select('stock_out_quantity','stock_out_rate')->whereNotNull('product_id')->whereBetween('date',[$fdate,$tdate])->get();
     $totalPurchase = 0;
     foreach($purchaseData as $val){
     	$totalPurchase += $val->stock_out_quantity * $val->stock_out_rate;
     }
      //new cogs code end
     //dd($totalPurchase);

      // $data['bagStockOut'] = DB::table('purchase_stockouts')->leftjoin('row_materials_products as r', 'r.id','=','purchase_stockouts.product_id')->where('r.unit','PCS')->whereBetween('purchase_stockouts.date', [$fdate, $tdate])->sum('total_amount');

     $dir_labordata = DB::select('SELECT SUM(direct_labour_costs.total_cost) as dlcost FROM `direct_labour_costs`
                    	WHERE  direct_labour_costs.date BETWEEN "'.$fdate.'" and "'.$tdate.'"');

        $manufacturingcost = DB::select('SELECT SUM(manufacturing_costs.total_cost) as mfcost FROM `manufacturing_costs` WHERE  manufacturing_costs.date BETWEEN "'.$fdate.'" and "'.$tdate.'"');
		$packing_cost = DB::table('packing_consumptions')->whereBetween('date', [$fdate, $tdate])->sum('amount');

    	$data['inventory'] = ($gtotlaStock + $data['bagPurchase']) - ($total_stockoutval + $packing_cost + $gtotalReturn);
    	$cogs = $totalPurchase + $packing_cost + $dir_labordata[0]->dlcost + $manufacturingcost[0]->mfcost;
       /*

      /* cogsAllData end*/

		/*$data['rmproduct'] = RowMaterialsProduct::where('unit','Kg')->where('category_id',32)->orderBy('product_name', 'ASC')->get();

        $total_stockoutvalM = 0;

        $sdate = '2022-12-01';
        $pdate = date('Y-m-d', strtotime('-1 day', strtotime($fdate)));
      foreach ($data['rmproduct'] as $key => $data){

       $dataRate = DB::table('purchases')->select('bill_quantity','purchase_value')->where('product_id', $data->id)->whereBetween('date',[$fdate,$tdate])->get();
                                $valueTemp = 0;
                                $valueQty = 0;
                                $rate = 0;
                                foreach($dataRate as $key => $val){
                                  $valueTemp += $val->purchase_value;
                                  $valueQty += $val->bill_quantity;
                                }
                                if($valueTemp > 0 && $valueQty > 0){
                                  $rate = $valueTemp / $valueQty;
                                  $rate = round($rate,2);
                                } else {
                                $rate = 0;
                              }

       	$data['stocko'] = DB::table('purchase_stockouts')->where('product_id',$data->id)->whereBetween('date',[$fdate,$tdate])->sum('stock_out_quantity');

         $total_stockoutvalM += round($data['stocko'],2)*$rate;

      }
      $data['rmproduct'] = RowMaterialsProduct::where('unit','Kg')->orderBy('product_name', 'ASC')->get();

      $total_stockoutvalAll = 0;
      foreach ($data['rmproduct'] as $key => $data){

       $dataRate = DB::table('purchases')->select('bill_quantity','purchase_value')->where('product_id', $data->id)->whereBetween('date',[$fdate,$tdate])->get();
                                $valueTemp = 0;
                                $valueQty = 0;
                                $rate = 0;
                                foreach($dataRate as $key => $val){
                                  $valueTemp += $val->purchase_value;
                                  $valueQty += $val->bill_quantity;
                                }
                                if($valueTemp > 0 && $valueQty > 0){
                                  $rate = $valueTemp / $valueQty;
                                  $rate = round($rate,2);
                                } else {
                                $rate = 0;
                              }

       	$data['stockoAll'] = DB::table('purchase_stockouts')->where('product_id',$data->id)->whereBetween('date',[$fdate,$tdate])->sum('stock_out_quantity');
        $total_stockoutvalAll += round($data['stockoAll'],2)*$rate;

      }


    	$data['bagPurchase'] = DB::table('purchase_details')->leftjoin('purchases', 'purchases.purchase_id','=','purchase_details.purchase_id')->whereBetween('purchases.date', [$fdate, $tdate])->sum('amount');

     	$dir_labordata = DB::select('SELECT SUM(direct_labour_costs.total_cost) as dlcost FROM `direct_labour_costs`
                    		WHERE  direct_labour_costs.date BETWEEN "'.$fdate.'" and "'.$tdate.'"');

        $manufacturingcost = DB::select('SELECT SUM(manufacturing_costs.total_cost) as mfcost FROM `manufacturing_costs` WHERE  manufacturing_costs.date BETWEEN "'.$fdate.'" and "'.$tdate.'"');
		$packing_cost = DB::table('packing_consumptions')->whereBetween('date', [$fdate, $tdate])->sum('amount');

      	$cogsRaw = $total_stockoutvalAll - $total_stockoutvalM;
      	$cogsRawM = $total_stockoutvalM; */

      	//$data['cogs'] = $total_stockoutvalAll + $dir_labordata[0]->dlcost + $data['packing_cost'] + $manufacturingcost[0]->mfcost;

      //$data['cogsRaw'] + $data['cogsRawM']
       /*  $sales_amount = DB::table('sales')
            ->where('is_active', 1)
            ->whereBetween('date', [$fdate, $tdate])
            ->sum('grand_total'); */

      /*	$sales_amount =  DB::table('sales_ledgers')
            ->whereNotNull('sale_id')
            ->whereBetween('ledger_date', [$fdate, $tdate])
            ->sum('total_price'); */

      	$sales_amount =  DB::table('sales_ledgers')->select(DB::raw('sum(total_price) as totalPrice'),DB::raw('sum(discount_amount) as discountPrice'))
              ->whereNotNull('sale_id')
              ->whereBetween('ledger_date', [$fdate, $tdate])
              ->first();
    $salesDealer =  DB::table('sales_ledgers')->select(DB::raw('sum(total_price) as totalPrice'),DB::raw('sum(discount_amount) as discountPrice'))
              ->whereNotIn('vendor_id',['284','285'])->whereNotNull('sale_id')
              ->whereBetween('ledger_date', [$fdate, $tdate])
              ->first();
      $data['salesDealer'] = $salesDealer->totalPrice + $salesDealer->discountPrice;

         $data['sales_return'] = DB::table('sales_returns')
            ->where('is_active', 1)
            ->whereBetween('date', [$fdate, $tdate])
            ->sum('grand_total');

      $data['sales'] = $sales_amount->totalPrice + $sales_amount->discountPrice;
      $data['monthlyCom'] =  DB::table('sales_ledgers')->where('invoice','LIKE', 'Jar-%')->where('priority',100)
                          ->whereBetween('ledger_date', [$fdate, $tdate])
                          ->sum('credit');
      //$data['journalDiscount'] = DB::table('journal_entries')->where('ledger_id',15)->whereBetween('date', [$fdate, $tdate])->sum('credit');

//dd($data['journalDiscount']);

		/*if($tdate <= '2023-01-31'){
          $data['sales'] = 127212135;
        } else {}
        $data['sales'] = $sales_amount - $sales_return; */


      /* $data['asset_depreciations'] = DB::table('asset_depreciations')->select('asset_depreciations.*','asset_products.product_name','assets.asset_head')
          		->leftJoin('assets', 'assets.id', 'asset_depreciations.asset_id')
          		->leftJoin('asset_products', 'asset_products.id', 'asset_depreciations.asset_product_id')
            ->whereBetween('asset_depreciations.date', [$fdate, $tdate])
            ->get();
            */

		 $data['asset_depreciations'] = DB::table('asset_depreciations')->leftJoin('assets', 'assets.id', 'asset_depreciations.asset_id')
          		->leftJoin('asset_products', 'asset_products.id', 'asset_depreciations.asset_product_id')
            	->whereBetween('asset_depreciations.date', [$fdate, $tdate])->sum('asset_depreciations.yearly_amount');


		//dd($rMACost);
		//dd($data['asset_depreciations']);

/*
            $startdate = '2022-12-01';
            $fdate2 =date('Y-m-d', strtotime('-1 day', strtotime($fdate)));
			$rmproduct = RowMaterialsProduct::where('category_id', 32)->get();
      		$cogsRawM = 0;

      		foreach ($rmproduct as $key => $product){
		$opening_balanceppp = RowMaterialsProduct::where('id', $product->id)->value('opening_balance');

        $opening_balance  = DB::select('SELECT SUM(purchase_set_opening_balance.opening_balance) as opbalance FROM `purchase_set_opening_balance`
            where purchase_set_opening_balance.product_id="' . $product->id . '"  and  purchase_set_opening_balance.date between "' . $startdate . '" and "' . $tdate . '" ');


        $stocktotal = DB::select('SELECT SUM(purchases.inventory_receive) as srcv FROM `purchases`
            where purchases.product_id="' . $product->id . '" and  purchases.date between "' . $fdate . '" and "' . $tdate . '" ');

        $pre_stocktotal = DB::select('SELECT SUM(purchases.inventory_receive) as srcv FROM `purchases`
            where purchases.product_id="' . $product->id . '"  and  purchases.date between "' . $startdate . '" and "' . $fdate2 . '" ');

        $return = $returns = DB::select('SELECT SUM(purchase_returns.return_quantity) as return_qty FROM `purchase_returns`
             WHERE purchase_returns.product_id="' . $product->id . '" and purchase_returns.date between "' . $fdate . '" and "' . $tdate . '" ');
        $pre_return = $returns = DB::select('SELECT SUM(purchase_returns.return_quantity) as return_qty FROM `purchase_returns`
             WHERE purchase_returns.product_id="' . $product->id . '" and purchase_returns.date between "' . $startdate . '" and "' . $fdate2 . '"');

        $transfer_to = DB::select('SELECT SUM(purchase_transfers.receive_qty) as transfers_qty FROM `purchase_transfers`
            WHERE purchase_transfers.product_id="' . $product->id . '"  and purchase_transfers.date between "' . $fdate . '" and "' . $tdate . '" ');
        $pre_transfer_to = DB::select('SELECT SUM(purchase_transfers.receive_qty) as transfers_qty FROM `purchase_transfers`
            WHERE purchase_transfers.product_id="' . $product->id . '"  and purchase_transfers.date BETWEEN "' . $startdate . '" and "' . $fdate2. '"');

        $transfer_from = DB::select('SELECT SUM(purchase_transfers.qty) as transfers_qty FROM `purchase_transfers`
            WHERE purchase_transfers.product_id="' . $product->id . '"  and purchase_transfers.date between "' . $fdate . '" and "' . $tdate . '" ');
        $pre_transfer_from = DB::select('SELECT SUM(purchase_transfers.qty) as transfers_qty FROM `purchase_transfers`
            WHERE purchase_transfers.product_id="' . $product->id . '"  and purchase_transfers.date BETWEEN "' . $startdate. '" and "' . $fdate2 . '"');

        $stock_out = DB::select('SELECT SUM(purchase_stockouts.stock_out_quantity) as stockout FROM `purchase_stockouts`
            WHERE purchase_stockouts.product_id ="' . $product->id . '"  and purchase_stockouts.date between "' . $fdate . '" and "' . $tdate . '" ');
        $pre_stock_out = DB::select('SELECT SUM(purchase_stockouts.stock_out_quantity) as stockout FROM `purchase_stockouts`
            WHERE purchase_stockouts.product_id ="' . $product->id . '" and purchase_stockouts.date BETWEEN "' . $startdate . '" and "' . $fdate2 . '"');

        $openingbalance =  $opening_balanceppp+$opening_balance[0]->opbalance + $pre_stocktotal[0]->srcv - $pre_return[0]->return_qty + $pre_transfer_to[0]->transfers_qty - $pre_transfer_from[0]->transfers_qty - $pre_stock_out[0]->stockout;

        $clsingbalance = $openingbalance + $stocktotal[0]->srcv - $return[0]->return_qty + $transfer_to[0]->transfers_qty - $transfer_from[0]->transfers_qty - $stock_out[0]->stockout;

        $todaypurchase = $stocktotal[0]->srcv;
       	$billQty = 0;
     	$billAmount = 0;
        $avgrateData = DB::select('SELECT `bill_quantity`,`purchase_value` FROM `purchases`
        WHERE purchases.product_id ="'.$product->id.'" and purchases.date between "'.$startdate.'" and "'.$tdate.'"');
        foreach($avgrateData as $val){
        $billQty += $val->bill_quantity;
     	$billAmount += $val->purchase_value;
        }
        if($billQty > 0){
        	$rate = $billAmount/$billQty;
        } else {
        	$rate = 0;
        }
        $openingbalance = $openingbalance*$rate;
        $clsingbalance = $clsingbalance*$rate;
        $todaypurchase = $todaypurchase*$rate;
        $cogsRawM += ($openingbalance + $todaypurchase) - $clsingbalance;
        }

      $data['cogsRawM'] = $cogsRawM;

			$rmproduct = RowMaterialsProduct::all();
      	$cogs = 0;
	/*
      foreach ($rmproduct as $key => $product){
		$opening_balanceppp = RowMaterialsProduct::where('id', $product->id)->value('opening_balance');

        $opening_balance  = DB::select('SELECT SUM(purchase_set_opening_balance.opening_balance) as opbalance FROM `purchase_set_opening_balance`
            where purchase_set_opening_balance.product_id="' . $product->id . '"  and  purchase_set_opening_balance.date between "' . $startdate . '" and "' . $fdate2 . '" ');

        $stocktotal = DB::select('SELECT SUM(purchases.inventory_receive) as srcv FROM `purchases`
            where purchases.product_id="' . $product->id . '" and  purchases.date between "' . $fdate . '" and "' . $tdate . '" ');

        $pre_stocktotal = DB::select('SELECT SUM(purchases.inventory_receive) as srcv FROM `purchases`
            where purchases.product_id="' . $product->id . '"  and  purchases.date between "' . $startdate . '" and "' . $fdate2 . '" ');

        $return = $returns = DB::select('SELECT SUM(purchase_returns.return_quantity) as return_qty FROM `purchase_returns`
             WHERE purchase_returns.product_id="' . $product->id . '" and purchase_returns.date between "' . $fdate . '" and "' . $tdate . '" ');
        $pre_return = $returns = DB::select('SELECT SUM(purchase_returns.return_quantity) as return_qty FROM `purchase_returns`
             WHERE purchase_returns.product_id="' . $product->id . '" and purchase_returns.date between "' . $startdate . '" and "' . $fdate2 . '"');

        $transfer_to = DB::select('SELECT SUM(purchase_transfers.receive_qty) as transfers_qty FROM `purchase_transfers`
            WHERE purchase_transfers.product_id="' . $product->id . '"  and purchase_transfers.date between "' . $fdate . '" and "' . $tdate . '" ');
        $pre_transfer_to = DB::select('SELECT SUM(purchase_transfers.receive_qty) as transfers_qty FROM `purchase_transfers`
            WHERE purchase_transfers.product_id="' . $product->id . '"  and purchase_transfers.date BETWEEN "' . $startdate . '" and "' . $fdate2. '"');

        $transfer_from = DB::select('SELECT SUM(purchase_transfers.qty) as transfers_qty FROM `purchase_transfers`
            WHERE purchase_transfers.product_id="' . $product->id . '"  and purchase_transfers.date between "' . $fdate . '" and "' . $tdate . '" ');
        $pre_transfer_from = DB::select('SELECT SUM(purchase_transfers.qty) as transfers_qty FROM `purchase_transfers`
            WHERE purchase_transfers.product_id="' . $product->id . '"  and purchase_transfers.date BETWEEN "' . $startdate. '" and "' . $fdate2 . '"');

        $stock_out = DB::select('SELECT SUM(purchase_stockouts.stock_out_quantity) as stockout FROM `purchase_stockouts`
            WHERE purchase_stockouts.product_id ="' . $product->id . '"  and purchase_stockouts.date between "' . $fdate . '" and "' . $tdate . '" ');
        $pre_stock_out = DB::select('SELECT SUM(purchase_stockouts.stock_out_quantity) as stockout FROM `purchase_stockouts`
            WHERE purchase_stockouts.product_id ="' . $product->id . '" and purchase_stockouts.date BETWEEN "' . $startdate . '" and "' . $fdate2 . '"');

        $openingbalance =  $opening_balanceppp+$opening_balance[0]->opbalance + $pre_stocktotal[0]->srcv - $pre_return[0]->return_qty + $pre_transfer_to[0]->transfers_qty - $pre_transfer_from[0]->transfers_qty - $pre_stock_out[0]->stockout;

        $clsingbalance = $openingbalance + $stocktotal[0]->srcv - $return[0]->return_qty + $transfer_to[0]->transfers_qty - $transfer_from[0]->transfers_qty - $stock_out[0]->stockout;

        $todaypurchase = $stocktotal[0]->srcv;

		$dir_labordata=  DB::select('SELECT SUM(direct_labour_costs.total_cost) as dlcost FROM `direct_labour_costs`
                    WHERE  direct_labour_costs.fg_id ="'.$product->id.'" AND  direct_labour_costs.date BETWEEN "'.$startdate.'" and "'.$tdate.'"');

       $ind_labordate =   DB::select('SELECT SUM(indirect_costs.total_cost) as ilcost FROM `indirect_costs`
                WHERE  indirect_costs.fg_id ="'.$product->id.'" AND  indirect_costs.date BETWEEN "'.$startdate.'" and "'.$tdate.'"');

        $dir_labor =  $dir_labordata[0]->dlcost;
        $ind_labor =  $ind_labordate[0]->ilcost;

        $manufacturingcost = DB::select('SELECT SUM(manufacturing_costs.total_cost) as mfcost FROM `manufacturing_costs` WHERE  manufacturing_costs.fg_id ="'.$product->id.'" AND  manufacturing_costs.date BETWEEN "'.$startdate.'" and "'.$tdate.'"');


        $avgrate = DB::select('SELECT AVG(purchases.purchase_rate) as rate FROM `purchases`
        WHERE purchases.product_id ="'.$product->id.'" and purchases.date between "'.$startdate.'" and "'.$tdate.'"');

      $openingbalance = $openingbalance*$avgrate[0]->rate;
      $clsingbalance = $clsingbalance*$avgrate[0]->rate;
      $todaypurchase = $todaypurchase*$avgrate[0]->rate;
      $cogs += ($openingbalance + $todaypurchase + $dir_labor + $ind_labor + $manufacturingcost[0]->mfcost) - $clsingbalance;
      }
	*/
      /*foreach ($rmproduct as $key => $product){
		$opening_balanceppp = RowMaterialsProduct::where('id', $product->id)->value('opening_balance');

        $opening_balance  = DB::select('SELECT SUM(purchase_set_opening_balance.opening_balance) as opbalance FROM `purchase_set_opening_balance`
            where purchase_set_opening_balance.product_id="' . $product->id . '"  and  purchase_set_opening_balance.date between "' . $startdate . '" and "' . $tdate . '" ');


        $stocktotal = DB::select('SELECT SUM(purchases.inventory_receive) as srcv FROM `purchases`
            where purchases.product_id="' . $product->id . '" and  purchases.date between "' . $fdate . '" and "' . $tdate . '" ');

        $pre_stocktotal = DB::select('SELECT SUM(purchases.inventory_receive) as srcv FROM `purchases`
            where purchases.product_id="' . $product->id . '"  and  purchases.date between "' . $startdate . '" and "' . $fdate2 . '" ');

        $return = $returns = DB::select('SELECT SUM(purchase_returns.return_quantity) as return_qty FROM `purchase_returns`
             WHERE purchase_returns.product_id="' . $product->id . '" and purchase_returns.date between "' . $fdate . '" and "' . $tdate . '" ');
        $pre_return = $returns = DB::select('SELECT SUM(purchase_returns.return_quantity) as return_qty FROM `purchase_returns`
             WHERE purchase_returns.product_id="' . $product->id . '" and purchase_returns.date between "' . $startdate . '" and "' . $fdate2 . '"');

        $transfer_to = DB::select('SELECT SUM(purchase_transfers.receive_qty) as transfers_qty FROM `purchase_transfers`
            WHERE purchase_transfers.product_id="' . $product->id . '"  and purchase_transfers.date between "' . $fdate . '" and "' . $tdate . '" ');
        $pre_transfer_to = DB::select('SELECT SUM(purchase_transfers.receive_qty) as transfers_qty FROM `purchase_transfers`
            WHERE purchase_transfers.product_id="' . $product->id . '"  and purchase_transfers.date BETWEEN "' . $startdate . '" and "' . $fdate2. '"');

        $transfer_from = DB::select('SELECT SUM(purchase_transfers.qty) as transfers_qty FROM `purchase_transfers`
            WHERE purchase_transfers.product_id="' . $product->id . '"  and purchase_transfers.date between "' . $fdate . '" and "' . $tdate . '" ');
        $pre_transfer_from = DB::select('SELECT SUM(purchase_transfers.qty) as transfers_qty FROM `purchase_transfers`
            WHERE purchase_transfers.product_id="' . $product->id . '"  and purchase_transfers.date BETWEEN "' . $startdate. '" and "' . $fdate2 . '"');

        $stock_out = DB::select('SELECT SUM(purchase_stockouts.stock_out_quantity) as stockout FROM `purchase_stockouts`
            WHERE purchase_stockouts.product_id ="' . $product->id . '"  and purchase_stockouts.date between "' . $fdate . '" and "' . $tdate . '" ');
        $pre_stock_out = DB::select('SELECT SUM(purchase_stockouts.stock_out_quantity) as stockout FROM `purchase_stockouts`
            WHERE purchase_stockouts.product_id ="' . $product->id . '" and purchase_stockouts.date BETWEEN "' . $startdate . '" and "' . $fdate2 . '"');

        $openingbalance =  $opening_balanceppp+$opening_balance[0]->opbalance + $pre_stocktotal[0]->srcv - $pre_return[0]->return_qty + $pre_transfer_to[0]->transfers_qty - $pre_transfer_from[0]->transfers_qty - $pre_stock_out[0]->stockout;

        $clsingbalance = $openingbalance + $stocktotal[0]->srcv - $return[0]->return_qty + $transfer_to[0]->transfers_qty - $transfer_from[0]->transfers_qty - $stock_out[0]->stockout;

        $todaypurchase = $stocktotal[0]->srcv; */
        /*$avgrate = DB::select('SELECT AVG(purchases.purchase_rate) as rate FROM `purchases`
        WHERE purchases.product_id ="'.$product->id.'" and purchases.date between "'.$startdate.'" and "'.$tdate.'"'); */
       /*	$billQty = 0;
     	$billAmount = 0;
        $avgrateData = DB::select('SELECT `bill_quantity`,`purchase_value` FROM `purchases`
        WHERE purchases.product_id ="'.$product->id.'" and purchases.date between "'.$startdate.'" and "'.$tdate.'"')
        foreach($avgrateData as $val){
        $billQty += $val->bill_quantity;
     	$billAmount += $val->purchase_value;
        }
        if($billQty > 0){
        	$rate = $billAmount/$billQty;
        }
        $openingbalance = $openingbalance*$rate;
        $clsingbalance = $clsingbalance*$rate;
        $todaypurchase = $todaypurchase*$rate;
        $cogs += ($openingbalance + $todaypurchase) - $clsingbalance;
        }

      $data['cogsRaw'] = $cogs - $cogsRawM;

       $data['dir_labordata'] = DB::select('SELECT SUM(direct_labour_costs.total_cost) as dlcost FROM `direct_labour_costs`
                    	WHERE  direct_labour_costs.date BETWEEN "'.$fdate.'" and "'.$tdate.'"');

        $data['manufacturingcost'] = DB::select('SELECT SUM(manufacturing_costs.total_cost) as mfcost FROM `manufacturing_costs` WHERE  manufacturing_costs.date BETWEEN "'.$fdate.'" and "'.$tdate.'"');
      	$data['packing_cost'] = DB::table('packing_consumptions')->whereBetween('date', [$fdate, $tdate])->sum('amount');

    	$cogs += $data['dir_labordata'][0]->dlcost + $data['manufacturingcost'][0]->mfcost + $data['packing_cost'];

     	$data['cogs'] = $cogs; */

        $allincome = $request->income_head;
        $alleincomeamount = $request->income_amount;


        $allincome =  DB::table('payments')->select([
                              DB::raw("SUM(amount) incomeamount"),
        					'income_sources.name','payments.income_source_id'
                           ])
                    ->leftjoin('income_sources','income_sources.id', '=', 'payments.income_source_id')
                    ->whereBetween('payment_date', [$fdate, $tdate])->where('payments.income_source_id','!=', ' ')
                    ->groupby('income_source_id')->get();


        $allexpasne =  DB::table('payments')->select([
                              DB::raw("SUM(amount) expamount"),
        					'expanse_groups.id','expanse_groups.group_name'
                           ])
                         ->leftJoin('expanse_subgroups', 'expanse_subgroups.id', '=', 'payments.expanse_subgroup_id')
          				 ->leftJoin('expanse_groups', 'expanse_groups.id', '=', 'expanse_subgroups.group_id')
                         ->where('payment_type', 'EXPANSE')->whereNotNull('bank_id')
                         ->whereBetween('payment_date', [$fdate, $tdate])
         				 ->where('status', 1)
                         ->groupby('expanse_subgroups.group_id')
                         ->get();
 //dd($allexpasneamount);

        	$taxes = DB::table('taxes')->where('year',$year)->value('tax');

      		//$financial_expenses = DB::table('financial_expenses')->where('year',$year)->value('expense');

      		$financial_expenses = DB::table('financial_expenses')->where('year',$year)->get();



      $data['direct_labour_costs'] = DB::table('direct_labour_costs')
                                      ->where('status', 1)
                                      ->whereBetween('date', [$fdate, $tdate])
                                      ->sum('total_cost');


      $data['manufacturing_costs'] = DB::table('manufacturing_costs')->select('head','total_cost')
                                      ->where('status', 1)
                                      ->whereBetween('date', [$fdate, $tdate])->groupBy('head_id')->get();
      //dd($data['cogs']);
       // dd($data['packing_cost']);
     // dd($cogs);
        return view('backend.account.nIncomeStatement', compact('manufacturingcost','packing_cost','cogsRaw','cogsRawM','cogs','sales_amount','fdate', 'tdate','taxes', 'data','allincome','allexpasne','financial_expenses'));
    }

 	public function manualIncomeStatementIndex(){
    return view('backend.account.incomeStatementInputManual');
    }
   public function manualIncomeStatement(Request $request)
    {
        //dd($request->all());

          if (isset($request->date)) {
             $dates = explode(' - ', $request->date);
             $fdate = date('Y-m-d', strtotime($dates[0]));
             $tdate = date('Y-m-d', strtotime($dates[1]));
            $year = date('Y', strtotime($tdate));
         }

        $data = [];
      if($request->type == 1){
      	$rmproduct = RowMaterialsProduct::where('category_id',31)->orderBy('product_name', 'ASC')->get();
		$cogs = 0;
      	$totalStockoutRaw = 0;
        foreach ($rmproduct as $key => $data){
        $stockraw = DB::table('purchase_stockouts')->where('product_id',$data->id)->whereBetween('date',[$fdate,$tdate])->sum('total_amount');
        $totalStockoutRaw += $stockraw;
        }
        $cogsRaw = $totalStockoutRaw;

        $mediProduct = RowMaterialsProduct::where('category_id',32)->orderBy('product_name', 'ASC')->get();
      	$totalStockoutMedi = 0;

      foreach ($mediProduct as $key => $data){
       $stockmedi = DB::table('purchase_stockouts')->where('product_id',$data->id)->whereBetween('date',[$fdate,$tdate])->sum('total_amount');
       $totalStockoutMedi += $stockmedi;
      }
        $cogsRawM = $totalStockoutMedi;
    	$cogs =  $cogsRaw + $cogsRawM;
      }

      //dd($cogsRawM);

      if($request->type == 2) {
      $rmproduct = RowMaterialsProduct::where('category_id',31)->orderBy('product_name', 'ASC')->get();
		$cogs = 0;
       $totalStockoutRaw = 0;
	   $sdate = '2023-07-01';
      foreach ($rmproduct as $key => $data){

       $stockraw = DB::table('purchase_stockouts')->where('product_id',$data->id)->whereBetween('date',[$fdate,$tdate])->sum('stock_out_quantity');

       $dataRate = DB::table('purchases')->select('bill_quantity','purchase_value')->where('product_id', $data->id)->whereBetween('date',[$sdate,$tdate])->get();

                                $valueTemp = 0;
                                $valueQty = 0;
                                $rate = 0;
                                foreach($dataRate as $key => $val){
                                  $valueTemp += $val->purchase_value;
                                  $valueQty += $val->bill_quantity;
                                }
                                if($valueTemp > 0 && $valueQty > 0){
                                  $rate = $valueTemp/$valueQty;
                                  $rate = round($rate,2);
                                } else {
                                $rate = 0;
                              }
            $totalStockoutRaw += round($stockraw*$rate,2);
    }
//dd($cogsRaw);
      $cogsRaw = $totalStockoutRaw;


    $mediProduct = RowMaterialsProduct::where('category_id',32)->orderBy('product_name', 'ASC')->get();

      $totalStockoutMedi = 0;

      foreach ($mediProduct as $key => $data){

       $stockmedi = DB::table('purchase_stockouts')->where('product_id',$data->id)->whereBetween('date',[$fdate,$tdate])->sum('stock_out_quantity');

       $dataRate = DB::table('purchases')->select('bill_quantity','purchase_value')->where('product_id', $data->id)->whereBetween('date',[$sdate,$tdate])->get();

                                $valueTemp = 0;
                                $valueQty = 0;
                                $rate = 0;
                                foreach($dataRate as $key => $val){
                                  $valueTemp += $val->purchase_value;
                                  $valueQty += $val->bill_quantity;
                                }
                                if($valueTemp > 0 && $valueQty > 0){
                                  $rate = $valueTemp/$valueQty;
                                  $rate = round($rate,2);
                                } else {
                                $rate = 0;
                              }
            $totalStockoutMedi += round($stockmedi*$rate,2);
    }

	$cogsRawM = $totalStockoutMedi;

    $cogs =  $cogsRaw + $cogsRawM;
      }

    $packing_cost = DB::table('packing_consumptions')->whereBetween('date', [$fdate, $tdate])->sum('amount');
    $manufacturingcost = DB::table('manufacturing_costs')->where('status', 1)->whereBetween('date', [$fdate, $tdate])->sum('total_cost');


      	$sales_amount =  DB::table('sales_ledgers')->select(DB::raw('sum(total_price) as totalPrice'),DB::raw('sum(discount_amount) as discountPrice'))
              ->whereNotNull('sale_id')
              ->whereBetween('ledger_date', [$fdate, $tdate])
              ->first();
    $salesDealer =  DB::table('sales_ledgers')->select(DB::raw('sum(total_price) as totalPrice'),DB::raw('sum(discount_amount) as discountPrice'))
              ->whereNotIn('vendor_id',['284','285'])->whereNotNull('sale_id')
              ->whereBetween('ledger_date', [$fdate, $tdate])
              ->first();
      $data['salesDealer'] = $salesDealer->totalPrice + $salesDealer->discountPrice;

         $data['sales_return'] = DB::table('sales_returns')
            ->where('is_active', 1)
            ->whereBetween('date', [$fdate, $tdate])
            ->sum('grand_total');

      $data['sales'] = $sales_amount->totalPrice + $sales_amount->discountPrice;

		 $data['asset_depreciations'] = DB::table('asset_depreciations')->leftJoin('assets', 'assets.id', 'asset_depreciations.asset_id')
          		->leftJoin('asset_products', 'asset_products.id', 'asset_depreciations.asset_product_id')
            	->whereBetween('asset_depreciations.date', [$fdate, $tdate])->sum('asset_depreciations.yearly_amount');

        $allincome = $request->income_head;
        $alleincomeamount = $request->income_amount;


        $allincome =  DB::table('payments')->select([
                              DB::raw("SUM(amount) incomeamount"),
        					'income_sources.name','payments.income_source_id'
                           ])
                    ->leftjoin('income_sources','income_sources.id', '=', 'payments.income_source_id')
                    ->whereBetween('payment_date', [$fdate, $tdate])->where('payments.income_source_id','!=', ' ')
                    ->groupby('income_source_id')->get();


        $allexpasne =  DB::table('payments')->select([
                              DB::raw("SUM(amount) expamount"),
        					'expanse_groups.id','expanse_groups.group_name'
                           ])
                         ->leftJoin('expanse_subgroups', 'expanse_subgroups.id', '=', 'payments.expanse_subgroup_id')
          				 ->leftJoin('expanse_groups', 'expanse_groups.id', '=', 'expanse_subgroups.group_id')
                         ->where('payment_type', 'EXPANSE')
                         ->whereBetween('payment_date', [$fdate, $tdate])
         				 ->where('status', 1)
                         ->groupby('expanse_subgroups.group_id')
                        ->get();


        	$taxes = DB::table('taxes')->where('year',$year)->value('tax');

      		$financial_expenses = DB::table('financial_expenses')->where('year',$year)->get();



      $data['direct_labour_costs'] = DB::table('direct_labour_costs')
                                      ->where('status', 1)
                                      ->whereBetween('date', [$fdate, $tdate])
                                      ->sum('total_cost');


      $data['manufacturing_costs'] = DB::table('manufacturing_costs')->select('head','total_cost')
                                      ->where('status', 1)
                                      ->whereBetween('date', [$fdate, $tdate])->groupBy('head_id')->get();
        return view('backend.account.nIncomeStatement', compact('manufacturingcost','packing_cost','cogsRaw','cogsRawM','cogs','sales_amount','fdate', 'tdate','taxes', 'data','allincome','allexpasne','financial_expenses'));
    }


   public function NEWincomestatementIndex()
    {

    $areas = DealerArea::All();

        return view('backend.account.income_statement_input_new', compact('areas'));
    }


    public function NEWincomestatement(Request $request)
    {
     //  dd($request->all());

      //  $fdate = "2020-01-01";
      //  $tdate = $request->date;

          if (isset($request->date)) {
             $dates = explode(' - ', $request->date);
             $fdate = date('Y-m-d', strtotime($dates[0]));
             $tdate = date('Y-m-d', strtotime($dates[1]));

            $year = date('Y', strtotime($tdate));
         }


        // dd($request);
        // $fdate = $request->from_date;
        // $tdate = $request->to_date;
        // $dlr_id = $request->vendor_id;


        $data = [];


         $sales_amount = DB::table('sales')
            ->where('is_active', 1)
            ->whereBetween('date', [$fdate, $tdate])
            ->sum('grand_total');
         $sales_return = DB::table('sales_returns')
            ->where('is_active', 1)
            ->whereBetween('date', [$fdate, $tdate])
            ->sum('grand_total');

        $data['sales'] = $sales_amount- $sales_return;



      $data['asset_depreciations'] = DB::table('asset_depreciations')->select('asset_depreciations.*','asset_products.product_name','assets.asset_head')
          		->leftJoin('assets', 'assets.id', 'asset_depreciations.asset_id')
          		->leftJoin('asset_products', 'asset_products.id', 'asset_depreciations.asset_product_id')
            ->whereBetween('asset_depreciations.date', [$fdate, $tdate])
            ->get();


        $purchase_stockouts = DB::table('purchase_stockouts')
            ->whereBetween('date', [$fdate, $tdate])
            ->sum('total_amount');

      $direct_labour_costs = DB::table('direct_labour_costs')
            ->whereBetween('date', [$fdate, $tdate])
            ->sum('total_cost');
      $manufacturing_costs = DB::table('manufacturing_costs')
            ->whereBetween('date', [$fdate, $tdate])
            ->sum('total_cost');

	$data['manufacturing_costs']  =$manufacturing_costs;





           // $allp = SalesProduct::all();

            $startdate = '2022-06-01';
            $fdate2 =date('Y-m-d', strtotime('-1 day', strtotime($fdate)));

            $rmproduct = RowMaterialsProduct::all();

      	$cogs2 = 0;
     	$totalOpeningBBBB = 0;


      foreach ($rmproduct as $key => $product){
		$opening_balanceppp = RowMaterialsProduct::where('id', $product->id)->value('opening_balance');

        $opening_balance  = DB::select('SELECT SUM(purchase_set_opening_balance.opening_balance) as opbalance FROM `purchase_set_opening_balance`
            where purchase_set_opening_balance.product_id="' . $product->id . '"  and  purchase_set_opening_balance.date between "' . $startdate . '" and "' . $fdate2 . '" ');


        $stocktotal = DB::select('SELECT SUM(purchases.inventory_receive) as srcv FROM `purchases`
            where purchases.product_id="' . $product->id . '" and  purchases.date between "' . $fdate . '" and "' . $tdate . '" ');

        $pre_stocktotal = DB::select('SELECT SUM(purchases.inventory_receive) as srcv FROM `purchases`
            where purchases.product_id="' . $product->id . '"  and  purchases.date between "' . $startdate . '" and "' . $fdate2 . '" ');

        $return = $returns = DB::select('SELECT SUM(purchase_returns.return_quantity) as return_qty FROM `purchase_returns`
             WHERE purchase_returns.product_id="' . $product->id . '" and purchase_returns.date between "' . $fdate . '" and "' . $tdate . '" ');
        $pre_return = $returns = DB::select('SELECT SUM(purchase_returns.return_quantity) as return_qty FROM `purchase_returns`
             WHERE purchase_returns.product_id="' . $product->id . '" and purchase_returns.date between "' . $startdate . '" and "' . $fdate2 . '"');

        $transfer_to = DB::select('SELECT SUM(purchase_transfers.receive_qty) as transfers_qty FROM `purchase_transfers`
            WHERE purchase_transfers.product_id="' . $product->id . '"  and purchase_transfers.date between "' . $fdate . '" and "' . $tdate . '" ');
        $pre_transfer_to = DB::select('SELECT SUM(purchase_transfers.receive_qty) as transfers_qty FROM `purchase_transfers`
            WHERE purchase_transfers.product_id="' . $product->id . '"  and purchase_transfers.date BETWEEN "' . $startdate . '" and "' . $fdate2. '"');

        $transfer_from = DB::select('SELECT SUM(purchase_transfers.qty) as transfers_qty FROM `purchase_transfers`
            WHERE purchase_transfers.product_id="' . $product->id . '"  and purchase_transfers.date between "' . $fdate . '" and "' . $tdate . '" ');
        $pre_transfer_from = DB::select('SELECT SUM(purchase_transfers.qty) as transfers_qty FROM `purchase_transfers`
            WHERE purchase_transfers.product_id="' . $product->id . '"  and purchase_transfers.date BETWEEN "' . $startdate. '" and "' . $fdate2 . '"');

        $stock_out = DB::select('SELECT SUM(purchase_stockouts.stock_out_quantity) as stockout FROM `purchase_stockouts`
            WHERE purchase_stockouts.product_id ="' . $product->id . '"  and purchase_stockouts.date between "' . $fdate . '" and "' . $tdate . '" ');
        $pre_stock_out = DB::select('SELECT SUM(purchase_stockouts.stock_out_quantity) as stockout FROM `purchase_stockouts`
            WHERE purchase_stockouts.product_id ="' . $product->id . '" and purchase_stockouts.date BETWEEN "' . $startdate . '" and "' . $fdate2 . '"');

        //$openingbalance =  $opening_balanceppp+$opening_balance[0]->opbalance + $pre_stocktotal[0]->srcv - $pre_return[0]->return_qty + $pre_transfer_to[0]->transfers_qty - $pre_transfer_from[0]->transfers_qty - $pre_stock_out[0]->stockout;
         $openingbalance =  ($opening_balanceppp+$opening_balance[0]->opbalance + $pre_stocktotal[0]->srcv  + $pre_transfer_to[0]->transfers_qty) - ($pre_return[0]->return_qty + $pre_transfer_from[0]->transfers_qty + $pre_stock_out[0]->stockout);




        $clsingbalance = $openingbalance + $stocktotal[0]->srcv - $return[0]->return_qty + $transfer_to[0]->transfers_qty - $transfer_from[0]->transfers_qty - $stock_out[0]->stockout;

        $totalOpeningBBBB += $stock_out[0]->stockout;


        $todaypurchase = $stocktotal[0]->srcv;

		$dir_labordata=  DB::select('SELECT SUM(direct_labour_costs.total_cost) as dlcost FROM `direct_labour_costs`
                    WHERE  direct_labour_costs.fg_id ="'.$product->id.'" AND  direct_labour_costs.date BETWEEN "'.$startdate.'" and "'.$tdate.'"');

       $ind_labordate =   DB::select('SELECT SUM(indirect_costs.total_cost) as ilcost FROM `indirect_costs`
                WHERE  indirect_costs.fg_id ="'.$product->id.'" AND  indirect_costs.date BETWEEN "'.$startdate.'" and "'.$tdate.'"');

        $dir_labor =  $dir_labordata[0]->dlcost;
        $ind_labor =  $ind_labordate[0]->ilcost;

        $manufacturingcost = DB::select('SELECT SUM(manufacturing_costs.total_cost) as mfcost FROM `manufacturing_costs` WHERE  manufacturing_costs.fg_id ="'.$product->id.'" AND  manufacturing_costs.date BETWEEN "'.$startdate.'" and "'.$tdate.'"');


        $avgrate = DB::select('SELECT AVG(purchases.purchase_rate) as rate FROM `purchases`
        WHERE purchases.product_id ="'.$product->id.'" and purchases.date between "'.$startdate.'" and "'.$tdate.'"');


     // dump($openingbalance .' X '.$avgrate[0]->rate.' = '.$openingbalance * $avgrate[0]->rate );
      $openingbalance = $openingbalance*$avgrate[0]->rate;
      $clsingbalance = $clsingbalance*$avgrate[0]->rate;
      $todaypurchase = $todaypurchase*$avgrate[0]->rate;

      $cogs2 += ($openingbalance + $todaypurchase + $dir_labor + $ind_labor + $manufacturingcost[0]->mfcost) - $clsingbalance;
      }
      return $totalOpeningBBBB;
 	 //dd($cogs2);
     $data['cogs'] = $cogs2;


        $allincome = $request->income_head;
        $alleincomeamount = $request->income_amount;


        $allincome =  DB::table('incomes')->select([
                              DB::raw("SUM(amount) incomeamount"),
        					'income_sources.name','incomes.income_source_id'
                           ])
      			->leftjoin('income_sources','income_sources.id', '=', 'incomes.income_source_id')
          ->whereBetween('date', [$fdate, $tdate])
          		->groupby('income_source_id')->get();


        $allexpasne =  DB::table('payments')->select([
                              DB::raw("SUM(amount) expamount"),
        					'expanse_subgroups.group_id','expanse_subgroups.group_name'
                           ])
                         ->leftJoin('expanse_subgroups', 'expanse_subgroups.id', '=', 'payments.expanse_subgroup_id')
                         ->where('payment_type', 'EXPANSE')
                        ->whereBetween('payment_date', [$fdate, $tdate])
         				 ->where('status', 1)
                        ->groupby('expanse_subgroups.group_id')
                        ->get();
 //dd($allexpasneamount);

        	$taxes = DB::table('taxes')->where('year',$year)->value('tax');






 //     dd($data);


        return view('backend.account.income_statement_report_new', compact('fdate', 'tdate','taxes', 'data','allincome','allexpasne'));
    }




  public function operatingcashflowIndex()
    {

    $areas = DealerArea::All();

        return view('backend.account.cash_flow_input', compact('areas'));
    }


    public function operatingcashflowReport(Request $request)
    {
      // dd($request->all());

        $fdate = "2020-01-01";
        $tdate = $request->date;

      $year = date('Y', strtotime($tdate));

        //  if (isset($request->date)) {
        //     $dates = explode(' - ', $request->date);
        //     $fdate = date('Y-m-d', strtotime($dates[0]));
        //     $tdate = date('Y-m-d', strtotime($dates[1]));
        // }





        $data = [];


         $sales_amount = DB::table('sales')
            ->where('is_active', 1)
            ->whereBetween('date', [$fdate, $tdate])
            ->sum('grand_total');
         $sales_return = DB::table('sales_returns')
            ->where('is_active', 1)
            ->whereBetween('date', [$fdate, $tdate])
            ->sum('grand_total');

        $data['sales'] = $sales_amount- $sales_return;

        $data['receive_amount'] = DB::table('payments')
            ->where('status', 1)
            ->where('payment_type', 'RECEIVE')
            ->whereBetween('payment_date', [$fdate, $tdate])
            ->sum('amount');

       $data['payment_amount'] = DB::table('payments')
            ->where('status', 1)
            ->where('payment_type', 'PAYMENT')
            ->whereBetween('payment_date', [$fdate, $tdate])
            ->sum('amount');


       $purchaseamount = DB::table('purchase_ledgers')
            ->whereNotNull('purcahse_id')
            ->whereBetween('date', [$fdate, $tdate])
            ->sum('credit');

       $purchasereturnamount = DB::table('purchase_returns')
            ->whereBetween('date', [$fdate, $tdate])
            ->sum('total_amount');

      $data['purchase_amount']  = $purchaseamount -  $purchasereturnamount;




      $data['asset_depreciations'] = DB::table('asset_depreciations')->whereBetween('asset_depreciations.date', [$fdate, $tdate])
            ->sum("yearly_amount");




        $cogs = 0;
      $opinventory = 0;
      $inventory = 0;

            $allp = SalesProduct::all();

            $startdate = '2023-07-01';
            $fdate2 =date('Y-m-d', strtotime('-1 day', strtotime($fdate)));

            foreach ($allp as $key => $product) {

                $todaystock = \App\Models\SalesStockIn::where('prouct_id',$product->id)->whereBetween('date',[$fdate,$tdate])->sum('quantity');
                $openingstock = \App\Models\SalesStockIn::where('prouct_id',$product->id)->whereBetween('date',[$startdate,$fdate2])->sum('quantity');

                $sales = \App\Models\SalesLedger::where('product_id',$product->id)->whereBetween('ledger_date',[$fdate,$tdate])->sum('qty_pcs');
                $opsales = \App\Models\SalesLedger::where('product_id',$product->id)->whereBetween('ledger_date',[$startdate,$fdate2])->sum('qty_pcs');


               $returnp = DB::table('sales_returns')->join('sales_return_items', 'sales_return_items.id', '=', 'sales_return_items.return_id')->where('product_id',$product->id)->whereBetween('date',[$fdate,$tdate])->sum('qty');
                 $opreturnp =DB::table('sales_returns')->join('sales_return_items', 'sales_return_items.id', '=', 'sales_return_items.return_id')->where('product_id',$product->id)->whereBetween('date',[$startdate,$fdate2])->sum('qty');



                $transfer_from = \App\Models\Transfer::where('product_id',$product->id)->whereBetween('date',[$fdate,$tdate])->sum('qty');
                $optransfer_from = \App\Models\Transfer::where('product_id',$product->id)->whereBetween('date',[$startdate,$fdate2])->sum('qty');

                $transfer_to = \App\Models\Transfer::where('product_id',$product->id)->whereBetween('date',[$fdate,$tdate])->sum('qty');
                $optransfer_to = \App\Models\Transfer::where('product_id',$product->id)->whereBetween('date',[$startdate,$fdate2])->sum('qty');

                 $damage = \App\Models\SalesDamage::where('product_id',$product->id)->whereBetween('date',[$fdate,$tdate])->sum('quantity');
                $opdamage = \App\Models\SalesDamage::where('product_id',$product->id)->whereBetween('date',[$startdate,$fdate2])->sum('quantity');

                $product_name = \App\Models\SalesProduct::where('id',$product->id)->value('product_name');

                $productdetails = SalesProduct::where('id',$product->id)->first();

                $opblnce = ($productdetails->opening_balance+$openingstock+$optransfer_to)-($opsales+$optransfer_from+$opdamage);
                $clb = ($opblnce+$todaystock+$transfer_to)- ($sales+$transfer_from+$damage);

                $productrate = \App\Models\SalesStockIn::where('prouct_id',$product->id)->avg('production_rate');

              $openingbalance = $opblnce*$productrate;
              $clsingbalance =$clb*$productrate;
              $todaystock = $todaystock*$productrate;

           // dd($opsales);

                $productname = SalesProduct::where('id', $product->id)->value('product_name');


                  $dir_labordata=  DB::select('SELECT SUM(direct_labour_costs.total_cost) as dlcost FROM `direct_labour_costs`
                    WHERE  direct_labour_costs.fg_id ="'.$product->id.'" AND  direct_labour_costs.date BETWEEN "'.$startdate.'" and "'.$tdate.'"');

                $ind_labordate =   DB::select('SELECT SUM(indirect_costs.total_cost) as ilcost FROM `indirect_costs`
                WHERE  indirect_costs.fg_id ="'.$product->id.'" AND  indirect_costs.date BETWEEN "'.$startdate.'" and "'.$tdate.'"');


                $dir_labor =  $dir_labordata[0]->dlcost;
                $ind_labor =  $ind_labordate[0]->ilcost;


               $cogs += ($openingbalance + $todaystock - $clsingbalance)+($dir_labor+$ind_labor);

              $opinventory += $opblnce*$productrate;
              $inventory += $clb*$productrate;


            }



            $data['cogs'] = $cogs;

            $data['opening_inventory_sales'] = $opinventory;
            $data['inventory_sales'] = $inventory;


       $rmproduct = RowMaterialsProduct::all();

     // dd($data['inventory_sales']);

      $totalrmvalue = 0;
      foreach ($rmproduct as $key => $product){



        $opening_balanceppp = RowMaterialsProduct::where('id', $product->id)->value('opening_balance');

        $opening_balance  = DB::select('SELECT SUM(purchase_set_opening_balance.opening_balance) as opbalance FROM `purchase_set_opening_balance`
            where purchase_set_opening_balance.product_id="' . $product->id . '" and   purchase_set_opening_balance.date between "' . $fdate . '" and "' . $tdate . '" ');


        $pre_stocktotal = DB::select('SELECT SUM(purchases.inventory_receive) as srcv FROM `purchases`
            where purchases.product_id="' . $product->id . '" and  purchases.date between "' . $fdate . '" and "' . $tdate . '" ');

         $pre_return = $returns = DB::select('SELECT SUM(purchase_returns.return_quantity) as return_qty FROM `purchase_returns`
             WHERE purchase_returns.product_id="' . $product->id . '" and purchase_returns.date between "' . $fdate . '" and "' . $tdate . '"');

         $pre_transfer_to = DB::select('SELECT SUM(purchase_transfers.receive_qty) as transfers_qty FROM `purchase_transfers`
            WHERE purchase_transfers.product_id="' . $product->id . '"  and purchase_transfers.date BETWEEN "' . $fdate . '" and "' . $tdate . '"');

         $pre_transfer_from = DB::select('SELECT SUM(purchase_transfers.qty) as transfers_qty FROM `purchase_transfers`
            WHERE purchase_transfers.product_id="' . $product->id . '"  and purchase_transfers.date BETWEEN "' . $fdate . '" and "' . $tdate . '"');

        $pre_stock_out = DB::select('SELECT SUM(purchase_stockouts.stock_out_quantity) as stockout FROM `purchase_stockouts`
            WHERE purchase_stockouts.product_id ="' . $product->id . '" AND purchase_stockouts.date BETWEEN "' . $fdate . '" and "' . $tdate . '"');

        $totalstock =  $product->opening_balance+$opening_balance[0]->opbalance + $pre_stocktotal[0]->srcv - $pre_return[0]->return_qty + $pre_transfer_to[0]->transfers_qty - $pre_transfer_from[0]->transfers_qty - $pre_stock_out[0]->stockout;





        $avgrate = DB::select('SELECT AVG(purchases.purchase_rate) as rate FROM `purchases`
        WHERE purchases.product_id ="'.$product->id.'" and purchases.date between "'.$fdate.'" and "'.$tdate.'"');

      $totalstockval = $totalstock*$avgrate[0]->rate;
     // $clsingbalance =$clsingbalance*$avgrate[0]->rate;
    //  $todaypurchase = $todaypurchase*$avgrate[0]->rate;


        $totalrmvalue += $totalstockval;

      }

      $data['inventory_purchase'] = $totalrmvalue;

    //  dd($data);


        $allincome = $request->income_head;
        $alleincomeamount = $request->income_amount;


        $allincome =  DB::table('incomes')->select([
                              DB::raw("SUM(amount) incomeamount"),
        					'income_sources.name','incomes.income_source_id'
                           ])
      			->leftjoin('income_sources','income_sources.id', '=', 'incomes.income_source_id')
          ->whereBetween('date', [$fdate, $tdate])
          		->groupby('income_source_id')->get();


        $allexpasne =  DB::table('payments')->where('payment_type', 'EXPANSE')
                        ->whereBetween('payment_date', [$fdate, $tdate])
         				 ->where('status', 1)
                        ->sum("amount");
 //dd($allexpasneamount);
      	$taxes = DB::table('taxes')->where('year',$year)->value('tax');





        //dd($data);


        return view('backend.account.cash_flow_report', compact('fdate', 'tdate','taxes', 'data','allincome','allexpasne'));
    }




   public function totalcashflowIndex()
    {

    $areas = DealerArea::All();

        return view('backend.account.total_cash_flow_input', compact('areas'));
    }


    public function totalcashflowReport(Request $request)
    {
      // dd($request->all());



        $tdate = $request->date;
      $year = date('Y', strtotime($tdate));
      $fdate = $year."-01-01";









        //  if (isset($request->date)) {
        //     $dates = explode(' - ', $request->date);
        //     $fdate = date('Y-m-d', strtotime($dates[0]));
        //     $tdate = date('Y-m-d', strtotime($dates[1]));
        // }





        $data = [];


         $sales_amount = DB::table('sales')
            ->where('is_active', 1)
            ->whereBetween('date', [$fdate, $tdate])
            ->sum('grand_total');
         $sales_return = DB::table('sales_returns')
            ->where('is_active', 1)
            ->whereBetween('date', [$fdate, $tdate])
            ->sum('grand_total');

        $data['sales'] = $sales_amount- $sales_return;

        $data['receive_amount'] = DB::table('payments')
            ->where('status', 1)
            ->where('payment_type', 'RECEIVE')
            ->whereBetween('payment_date', [$fdate, $tdate])
            ->sum('amount');

       $data['payment_amount'] = DB::table('payments')
            ->where('status', 1)
            ->where('payment_type', 'PAYMENT')
            ->whereBetween('payment_date', [$fdate, $tdate])
            ->sum('amount');


       $purchaseamount = DB::table('purchase_ledgers')
            ->whereNotNull('purcahse_id')
            ->whereBetween('date', [$fdate, $tdate])
            ->sum('credit');

       $purchasereturnamount = DB::table('purchase_returns')
            ->whereBetween('date', [$fdate, $tdate])
            ->sum('total_amount');

      $data['purchase_amount']  = $purchaseamount -  $purchasereturnamount;



       $data['journal_debit'] = DB::table('journal_entries')
            ->whereBetween('date', [$fdate, $tdate])
            ->sum('debit');
        $data['journal_credit'] = DB::table('journal_entries')
            ->whereBetween('date', [$fdate, $tdate])
            ->sum('credit');

        $data['general_purchase_amount'] = DB::table('general_purchases')
            ->whereBetween('date', [$fdate, $tdate])
            ->sum('total_value');
        $data['assets_amount'] = DB::table('assets')
            ->whereBetween('date', [$fdate, $tdate])
          ->where('intangible',0)->where('investment',0)
            ->sum('asset_value');

      $data['assets_investment'] = DB::table('assets')
            ->whereBetween('date', [$fdate, $tdate])
          ->where('intangible',0)->where('investment',1)
            ->sum('asset_value');
      $data['assets_intangible'] = DB::table('assets')
            ->whereBetween('date', [$fdate, $tdate])
          ->where('intangible',1)->where('investment',0)
            ->sum('asset_value');



      $data['expanse_amount'] = DB::table('payments')
            ->where('payment_type', 'EXPANSE')
        ->where('status', 1)
            ->whereBetween('payment_date', [$fdate, $tdate])
            ->sum('amount');

       $data['equitiy'] = DB::table('equities')->whereBetween('date', [$fdate, $tdate])
         ->sum('amount');

        $data['loan_amount'] = DB::table('master_banks')
         // ->where('loan_fdate', '<=', $fdate)
         //->where('loan_tdate', '>=', $tdate)
          ->whereBetween('loan_tdate', [$fdate, $tdate])

        	->sum('loan_amount');
       $data['bank_overderft'] = DB::table('master_banks')
         // ->where('loan_fdate', '<=', $fdate)
        //  ->where('loan_tdate', '<', $tdate)
          ->whereBetween('loan_tdate', [$fdate, $tdate])


        	->sum('loan_amount');

       $data['borrow_from'] = DB::table('borrows')
         // ->where('loan_fdate', '<=', $fdate)
          ->whereBetween('date', [$fdate, $tdate])
          ->where('type',"Short_Term")


        	->sum('amount');

        $data['non_borrow'] = DB::table('borrows')
         // ->where('loan_fdate', '<=', $fdate)
          ->whereBetween('date', [$fdate, $tdate])
          ->where('type',"Long_Term")


        	->sum('amount');


       $data['lease'] = DB::table('leases')
         // ->where('loan_fdate', '<=', $fdate)
          ->whereBetween('date', [$fdate, $tdate])



        	->sum('amount');

      $data['bad_debt_amount'] = DB::table('bad_debts')
            ->whereBetween('date', [$fdate, $tdate])
         	->sum('amount');



      $data['asset_depreciations'] = DB::table('asset_depreciations')->whereBetween('asset_depreciations.date', [$fdate, $tdate])
            ->sum("yearly_amount");




        $cogs = 0;
      $opinventory = 0;
      $inventory = 0;

            $allp = SalesProduct::all();

            $startdate = '2020-01-01';
            $fdate2 =date('Y-m-d', strtotime('-1 day', strtotime($fdate)));

            foreach ($allp as $key => $product) {

                $todaystock = \App\Models\SalesStockIn::where('prouct_id',$product->id)->whereBetween('date',[$fdate,$tdate])->sum('quantity');
                $openingstock = \App\Models\SalesStockIn::where('prouct_id',$product->id)->whereBetween('date',[$startdate,$fdate2])->sum('quantity');

                $sales = \App\Models\SalesLedger::where('product_id',$product->id)->whereBetween('ledger_date',[$fdate,$tdate])->sum('qty_pcs');
                $opsales = \App\Models\SalesLedger::where('product_id',$product->id)->whereBetween('ledger_date',[$startdate,$fdate2])->sum('qty_pcs');


               $returnp = DB::table('sales_returns')->join('sales_return_items', 'sales_return_items.id', '=', 'sales_return_items.return_id')->where('product_id',$product->id)->whereBetween('date',[$fdate,$tdate])->sum('qty');
                 $opreturnp =DB::table('sales_returns')->join('sales_return_items', 'sales_return_items.id', '=', 'sales_return_items.return_id')->where('product_id',$product->id)->whereBetween('date',[$startdate,$fdate2])->sum('qty');



                $transfer_from = \App\Models\Transfer::where('product_id',$product->id)->whereBetween('date',[$fdate,$tdate])->sum('qty');
                $optransfer_from = \App\Models\Transfer::where('product_id',$product->id)->whereBetween('date',[$startdate,$fdate2])->sum('qty');

                $transfer_to = \App\Models\Transfer::where('product_id',$product->id)->whereBetween('date',[$fdate,$tdate])->sum('qty');
                $optransfer_to = \App\Models\Transfer::where('product_id',$product->id)->whereBetween('date',[$startdate,$fdate2])->sum('qty');

                 $damage = \App\Models\SalesDamage::where('product_id',$product->id)->whereBetween('date',[$fdate,$tdate])->sum('quantity');
                $opdamage = \App\Models\SalesDamage::where('product_id',$product->id)->whereBetween('date',[$startdate,$fdate2])->sum('quantity');

                $product_name = \App\Models\SalesProduct::where('id',$product->id)->value('product_name');

                $productdetails = SalesProduct::where('id',$product->id)->first();

                $opblnce = ($productdetails->opening_balance+$openingstock+$optransfer_to)-($opsales+$optransfer_from+$opdamage);
                $clb = ($opblnce+$todaystock+$transfer_to)- ($sales+$transfer_from+$damage);

                $productrate = \App\Models\SalesStockIn::where('prouct_id',$product->id)->avg('production_rate');

              $openingbalance = $opblnce*$productrate;
              $clsingbalance =$clb*$productrate;
              $todaystock = $todaystock*$productrate;

           // dd($opsales);

                $productname = SalesProduct::where('id', $product->id)->value('product_name');


                  $dir_labordata=  DB::select('SELECT SUM(direct_labour_costs.total_cost) as dlcost FROM `direct_labour_costs`
                    WHERE  direct_labour_costs.fg_id ="'.$product->id.'" AND  direct_labour_costs.date BETWEEN "'.$startdate.'" and "'.$tdate.'"');

                $ind_labordate =   DB::select('SELECT SUM(indirect_costs.total_cost) as ilcost FROM `indirect_costs`
                WHERE  indirect_costs.fg_id ="'.$product->id.'" AND  indirect_costs.date BETWEEN "'.$startdate.'" and "'.$tdate.'"');


                $dir_labor =  $dir_labordata[0]->dlcost;
                $ind_labor =  $ind_labordate[0]->ilcost;


               $cogs += ($openingbalance + $todaystock - $clsingbalance)+($dir_labor+$ind_labor);

              $opinventory += $opblnce*$productrate;
              $inventory += $clb*$productrate;


            }



            $data['cogs'] = $cogs;

            $data['opening_inventory_sales'] = $opinventory;
            $data['inventory_sales'] = $inventory;


       $rmproduct = RowMaterialsProduct::all();

     // dd($data);

      $totalrmvalue = 0;
      foreach ($rmproduct as $key => $product){



        $opening_balanceppp = RowMaterialsProduct::where('id', $product->id)->value('opening_balance');

        $opening_balance  = DB::select('SELECT SUM(purchase_set_opening_balance.opening_balance) as opbalance FROM `purchase_set_opening_balance`
            where purchase_set_opening_balance.product_id="' . $product->id . '" and   purchase_set_opening_balance.date between "' . $fdate . '" and "' . $tdate . '" ');


        $pre_stocktotal = DB::select('SELECT SUM(purchases.inventory_receive) as srcv FROM `purchases`
            where purchases.product_id="' . $product->id . '" and  purchases.date between "' . $fdate . '" and "' . $tdate . '" ');

         $pre_return = $returns = DB::select('SELECT SUM(purchase_returns.return_quantity) as return_qty FROM `purchase_returns`
             WHERE purchase_returns.product_id="' . $product->id . '" and purchase_returns.date between "' . $fdate . '" and "' . $tdate . '"');

         $pre_transfer_to = DB::select('SELECT SUM(purchase_transfers.receive_qty) as transfers_qty FROM `purchase_transfers`
            WHERE purchase_transfers.product_id="' . $product->id . '"  and purchase_transfers.date BETWEEN "' . $fdate . '" and "' . $tdate . '"');

         $pre_transfer_from = DB::select('SELECT SUM(purchase_transfers.qty) as transfers_qty FROM `purchase_transfers`
            WHERE purchase_transfers.product_id="' . $product->id . '"  and purchase_transfers.date BETWEEN "' . $fdate . '" and "' . $tdate . '"');

        $pre_stock_out = DB::select('SELECT SUM(purchase_stockouts.stock_out_quantity) as stockout FROM `purchase_stockouts`
            WHERE purchase_stockouts.product_id ="' . $product->id . '" AND purchase_stockouts.date BETWEEN "' . $fdate . '" and "' . $tdate . '"');

        $totalstock =  $product->opening_balance+$opening_balance[0]->opbalance + $pre_stocktotal[0]->srcv - $pre_return[0]->return_qty + $pre_transfer_to[0]->transfers_qty - $pre_transfer_from[0]->transfers_qty - $pre_stock_out[0]->stockout;





        $avgrate = DB::select('SELECT AVG(purchases.purchase_rate) as rate FROM `purchases`
        WHERE purchases.product_id ="'.$product->id.'" and purchases.date between "'.$fdate.'" and "'.$tdate.'"');

      $totalstockval = $totalstock*$avgrate[0]->rate;
     // $clsingbalance =$clsingbalance*$avgrate[0]->rate;
    //  $todaypurchase = $todaypurchase*$avgrate[0]->rate;


        $totalrmvalue += $totalstockval;

      }

      $data['inventory_purchase'] = $totalrmvalue;

    //  dd($data);


        $allincome = $request->income_head;
        $alleincomeamount = $request->income_amount;


        $allincome =  DB::table('incomes')->select([
                              DB::raw("SUM(amount) incomeamount"),
        					'income_sources.name','incomes.income_source_id'
                           ])
      			->leftjoin('income_sources','income_sources.id', '=', 'incomes.income_source_id')
          ->whereBetween('date', [$fdate, $tdate])
          		->groupby('income_source_id')->get();


        $data['allexpasne'] =  DB::table('payments')->where('payment_type', 'EXPANSE')
                        ->whereBetween('payment_date', [$fdate, $tdate])
         				 ->where('status', 1)
                        ->sum("amount");

       $data['dividend'] =  DB::table('payments')->where('payment_type', 'PAYMENT')->where('others_payment_type', 'dividend')
                        ->whereBetween('payment_date', [$fdate, $tdate])
         				 ->where('status', 1)
                        ->sum("amount");
      $data['tax_payment_amount'] =  DB::table('payments')->where('payment_type', 'PAYMENT')->where('others_payment_type', 'tax')
                        ->whereBetween('payment_date', [$fdate, $tdate])
         				 ->where('status', 1)
                        ->sum("amount");



      $data['tax'] =  DB::table('taxes')
                        ->where('year', $year)
         				->value("tax");





        //For Pre Year



       $preyear = $year-1;
      $prefdate = $preyear."-01-01";
      $pretdate = $preyear."-12-31";

        $predata = [];


         $sales_amount = DB::table('sales')
            ->where('is_active', 1)
            ->whereBetween('date', [$prefdate, $pretdate])
            ->sum('grand_total');
         $sales_return = DB::table('sales_returns')
            ->where('is_active', 1)
            ->whereBetween('date', [$prefdate, $pretdate])
            ->sum('grand_total');

        $predata['sales'] = $sales_amount- $sales_return;

        $predata['receive_amount'] = DB::table('payments')
            ->where('status', 1)
            ->where('payment_type', 'RECEIVE')
            ->whereBetween('payment_date', [$prefdate, $pretdate])
            ->sum('amount');

       $predata['payment_amount'] = DB::table('payments')
            ->where('status', 1)
            ->where('payment_type', 'PAYMENT')
            ->whereBetween('payment_date', [$prefdate, $pretdate])
            ->sum('amount');


       $purchaseamount = DB::table('purchase_ledgers')
            ->whereNotNull('purcahse_id')
            ->whereBetween('date', [$prefdate, $pretdate])
            ->sum('credit');

       $purchasereturnamount = DB::table('purchase_returns')
            ->whereBetween('date', [$prefdate, $pretdate])
            ->sum('total_amount');

      $predata['purchase_amount']  = $purchaseamount -  $purchasereturnamount;



       $predata['journal_debit'] = DB::table('journal_entries')
            ->whereBetween('date', [$prefdate, $pretdate])
            ->sum('debit');
        $predata['journal_credit'] = DB::table('journal_entries')
            ->whereBetween('date', [$prefdate, $pretdate])
            ->sum('credit');

        $predata['general_purchase_amount'] = DB::table('general_purchases')
            ->whereBetween('date', [$prefdate, $pretdate])
            ->sum('total_value');
        $predata['assets_amount'] = DB::table('assets')
            ->whereBetween('date', [$prefdate, $pretdate])
          ->where('intangible',0)->where('investment',0)
            ->sum('asset_value');

      $predata['assets_investment'] = DB::table('assets')
            ->whereBetween('date', [$prefdate, $pretdate])
          ->where('intangible',0)->where('investment',1)
            ->sum('asset_value');
      $predata['assets_intangible'] = DB::table('assets')
            ->whereBetween('date', [$prefdate, $pretdate])
          ->where('intangible',1)->where('investment',0)
            ->sum('asset_value');



      $predata['expanse_amount'] = DB::table('payments')
            ->where('payment_type', 'EXPANSE')
        ->where('status', 1)
            ->whereBetween('payment_date', [$prefdate, $pretdate])
            ->sum('amount');

       $predata['equitiy'] = DB::table('equities')->whereBetween('date', [$prefdate, $pretdate])
         ->sum('amount');

        $predata['loan_amount'] = DB::table('master_banks')
         // ->where('loan_fdate', '<=', $fdate)
         // ->where('loan_tdate', '>=', $pretdate)
          ->whereBetween('loan_tdate', [$prefdate, $pretdate])


        	->sum('loan_amount');
       $predata['bank_overderft'] = DB::table('master_banks')
         // ->where('loan_fdate', '<=', $fdate)
          //->where('loan_tdate', '<', $pretdate)
          ->whereBetween('loan_tdate', [$prefdate, $pretdate])

        	->sum('loan_amount');

       $predata['borrow_from'] = DB::table('borrows')
         // ->where('loan_fdate', '<=', $fdate)
          ->whereBetween('date', [$prefdate, $pretdate])
          ->where('type',"Short_Term")


        	->sum('amount');

        $predata['non_borrow'] = DB::table('borrows')
         // ->where('loan_fdate', '<=', $fdate)
          ->whereBetween('date', [$prefdate, $pretdate])
          ->where('type',"Long_Term")


        	->sum('amount');


       $predata['lease'] = DB::table('leases')
         // ->where('loan_fdate', '<=', $fdate)
          ->whereBetween('date', [$prefdate, $pretdate])



        	->sum('amount');

      $predata['bad_debt_amount'] = DB::table('bad_debts')
            ->whereBetween('date', [$prefdate, $pretdate])
         	->sum('amount');



      $predata['asset_depreciations'] = DB::table('asset_depreciations')->whereBetween('asset_depreciations.date', [$prefdate, $pretdate])
            ->sum("yearly_amount");


       $cogs = 0;
      $opinventory = 0;
      $inventory = 0;

            $allp = SalesProduct::all();

            $prestartdate = '2020-01-01';
            $prefdate2 =date('Y-m-d', strtotime('-1 day', strtotime($prefdate)));

            foreach ($allp as $key => $product) {

                $todaystock = \App\Models\SalesStockIn::where('prouct_id',$product->id)->whereBetween('date',[$prefdate,$pretdate])->sum('quantity');
                $openingstock = \App\Models\SalesStockIn::where('prouct_id',$product->id)->whereBetween('date',[$prestartdate,$prefdate2])->sum('quantity');

                $sales = \App\Models\SalesLedger::where('product_id',$product->id)->whereBetween('ledger_date',[$prefdate,$pretdate])->sum('qty_pcs');
                $opsales = \App\Models\SalesLedger::where('product_id',$product->id)->whereBetween('ledger_date',[$prestartdate,$prefdate2])->sum('qty_pcs');


               $returnp = DB::table('sales_returns')->join('sales_return_items', 'sales_return_items.id', '=', 'sales_return_items.return_id')->where('product_id',$product->id)->whereBetween('date',[$prefdate,$pretdate])->sum('qty');
                 $opreturnp =DB::table('sales_returns')->join('sales_return_items', 'sales_return_items.id', '=', 'sales_return_items.return_id')->where('product_id',$product->id)->whereBetween('date',[$prestartdate,$prefdate2])->sum('qty');



                $transfer_from = \App\Models\Transfer::where('product_id',$product->id)->whereBetween('date',[$prefdate,$pretdate])->sum('qty');
                $optransfer_from = \App\Models\Transfer::where('product_id',$product->id)->whereBetween('date',[$prestartdate,$prefdate2])->sum('qty');

                $transfer_to = \App\Models\Transfer::where('product_id',$product->id)->whereBetween('date',[$prefdate,$pretdate])->sum('qty');
                $optransfer_to = \App\Models\Transfer::where('product_id',$product->id)->whereBetween('date',[$prestartdate,$prefdate2])->sum('qty');

                 $damage = \App\Models\SalesDamage::where('product_id',$product->id)->whereBetween('date',[$prefdate,$pretdate])->sum('quantity');
                $opdamage = \App\Models\SalesDamage::where('product_id',$product->id)->whereBetween('date',[$prestartdate,$prefdate2])->sum('quantity');

                $product_name = \App\Models\SalesProduct::where('id',$product->id)->value('product_name');

                $productdetails = SalesProduct::where('id',$product->id)->first();

                $opblnce = ($productdetails->opening_balance+$openingstock+$optransfer_to)-($opsales+$optransfer_from+$opdamage);
                $clb = ($opblnce+$todaystock+$transfer_to)- ($sales+$transfer_from+$damage);

                $productrate = \App\Models\SalesStockIn::where('prouct_id',$product->id)->avg('production_rate');

              $openingbalance = $opblnce*$productrate;
              $clsingbalance =$clb*$productrate;
              $todaystock = $todaystock*$productrate;

           // dd($opsales);

                $productname = SalesProduct::where('id', $product->id)->value('product_name');


                  $dir_labordata=  DB::select('SELECT SUM(direct_labour_costs.total_cost) as dlcost FROM `direct_labour_costs`
                    WHERE  direct_labour_costs.fg_id ="'.$product->id.'" AND  direct_labour_costs.date BETWEEN "'.$prestartdate.'" and "'.$pretdate.'"');

                $ind_labordate =   DB::select('SELECT SUM(indirect_costs.total_cost) as ilcost FROM `indirect_costs`
                WHERE  indirect_costs.fg_id ="'.$product->id.'" AND  indirect_costs.date BETWEEN "'.$prestartdate.'" and "'.$pretdate.'"');


                $dir_labor =  $dir_labordata[0]->dlcost;
                $ind_labor =  $ind_labordate[0]->ilcost;


               $cogs += ($openingbalance + $todaystock - $clsingbalance)+($dir_labor+$ind_labor);

              $opinventory += $opblnce*$productrate;
              $inventory += $clb*$productrate;


            }



            $predata['cogs'] = $cogs;

            $predata['opening_inventory_sales'] = $opinventory;
            $predata['inventory_sales'] = $inventory;


       $rmproduct = RowMaterialsProduct::all();

     // dd($data);

      $totalrmvalue = 0;
      foreach ($rmproduct as $key => $product){



        $opening_balanceppp = RowMaterialsProduct::where('id', $product->id)->value('opening_balance');

        $opening_balance  = DB::select('SELECT SUM(purchase_set_opening_balance.opening_balance) as opbalance FROM `purchase_set_opening_balance`
            where purchase_set_opening_balance.product_id="' . $product->id . '" and   purchase_set_opening_balance.date between "' . $prefdate . '" and "' . $pretdate . '" ');


        $pre_stocktotal = DB::select('SELECT SUM(purchases.inventory_receive) as srcv FROM `purchases`
            where purchases.product_id="' . $product->id . '" and  purchases.date between "' . $prefdate . '" and "' . $pretdate . '" ');

         $pre_return = $returns = DB::select('SELECT SUM(purchase_returns.return_quantity) as return_qty FROM `purchase_returns`
             WHERE purchase_returns.product_id="' . $product->id . '" and purchase_returns.date between "' . $prefdate . '" and "' . $pretdate . '"');

         $pre_transfer_to = DB::select('SELECT SUM(purchase_transfers.receive_qty) as transfers_qty FROM `purchase_transfers`
            WHERE purchase_transfers.product_id="' . $product->id . '"  and purchase_transfers.date BETWEEN "' . $prefdate . '" and "' . $pretdate . '"');

         $pre_transfer_from = DB::select('SELECT SUM(purchase_transfers.qty) as transfers_qty FROM `purchase_transfers`
            WHERE purchase_transfers.product_id="' . $product->id . '"  and purchase_transfers.date BETWEEN "' . $prefdate . '" and "' . $pretdate . '"');

        $pre_stock_out = DB::select('SELECT SUM(purchase_stockouts.stock_out_quantity) as stockout FROM `purchase_stockouts`
            WHERE purchase_stockouts.product_id ="' . $product->id . '" AND purchase_stockouts.date BETWEEN "' . $prefdate . '" and "' . $pretdate . '"');

        $totalstock =  $product->opening_balance+$opening_balance[0]->opbalance + $pre_stocktotal[0]->srcv - $pre_return[0]->return_qty + $pre_transfer_to[0]->transfers_qty - $pre_transfer_from[0]->transfers_qty - $pre_stock_out[0]->stockout;





        $avgrate = DB::select('SELECT AVG(purchases.purchase_rate) as rate FROM `purchases`
        WHERE purchases.product_id ="'.$product->id.'" and purchases.date between "'.$prefdate.'" and "'.$pretdate.'"');

      $totalstockval = $totalstock*$avgrate[0]->rate;
     // $clsingbalance =$clsingbalance*$avgrate[0]->rate;
    //  $todaypurchase = $todaypurchase*$avgrate[0]->rate;


        $totalrmvalue += $totalstockval;

      }

      $predata['inventory_purchase'] = $totalrmvalue;

    //  dd($data);


        $allincome = $request->income_head;
        $alleincomeamount = $request->income_amount;


       $predata['allincome']  =  DB::table('incomes')->select([
                              DB::raw("SUM(amount) incomeamount"),
        					'income_sources.name','incomes.income_source_id'
                           ])
      			->leftjoin('income_sources','income_sources.id', '=', 'incomes.income_source_id')
          ->whereBetween('date', [$prefdate, $pretdate])
          		->groupby('income_source_id')->get();


        $predata['allexpasne'] =  DB::table('payments')->where('payment_type', 'EXPANSE')
                        ->whereBetween('payment_date', [$prefdate, $pretdate])
         				 ->where('status', 1)
                        ->sum("amount");

       $predata['dividend'] =  DB::table('payments')->where('payment_type', 'PAYMENT')->where('others_payment_type', 'dividend')
                        ->whereBetween('payment_date', [$prefdate, $pretdate])
         				 ->where('status', 1)
                        ->sum("amount");
      $predata['tax_payment_amount'] =  DB::table('payments')->where('payment_type', 'PAYMENT')->where('others_payment_type', 'tax')
                        ->whereBetween('payment_date', [$prefdate, $pretdate])
         				 ->where('status', 1)
                        ->sum("amount");



      $predata['tax'] =  DB::table('taxes')
                        ->where('year', $preyear)
         				->value("tax");








        //dd($predata);


        return view('backend.account.total_cash_flow_report', compact('fdate', 'tdate', 'data','predata','year'));
    }



	public function currentliabilities(Request $request)
    {
    	$f_date = '';
        $t_date = '';
      	$date = '';
      	if (isset($request->date)) {
                    $date = $request->date;
                    $dates = explode(' - ', $request->date);
                    $f_date = date('Y-m-d', strtotime($dates[0]));
                    $t_date = date('Y-m-d', strtotime($dates[1]));
                }

      	if($request->opbalance){ $opbalance = 1; }else{  $opbalance = ''; }
      	if($request->clbalance){ $clbalance = 1; }else{  $clbalance = ''; }
      	if($request->totalpayable){ $totalpayable = 1; }else{  $totalpayable = ''; }
      	if($request->totalpaid){ $totalpaid = 1; }else{  $totalpaid = ''; }
      	if($request->recivedquantity){ $recivedquantity = 1; }else{  $recivedquantity = ''; }
      	if($request->totalreturn){ $totalreturn = 1; }else{  $totalreturn = ''; }

         //dd($opbalance);
        $suppliers = Supplier::orderBy('supplier_name', 'ASC')->get();

      	return view('backend.account.currentliabilitiesreport',compact('date','suppliers','f_date','t_date','opbalance','clbalance','totalpayable','totalpaid','recivedquantity','totalreturn'));
    }



    public function getbankbalance($id)
    {

      $bank = MasterBank::where('bank_id',$id)->first();

    $totaldata = Payment::select(
      DB::raw('sum(CASE WHEN payment_type = "RECEIVE" AND type = "BANK"  THEN `amount` ELSE null END) as totalrcv'),
      DB::raw('sum(CASE WHEN payment_type = "PAYMENT" AND type = "BANK"  THEN `amount` ELSE null END) as totalpay'),
      DB::raw('sum(CASE WHEN payment_type = "TRANSFER" AND type = "BANK" AND transfer_type = "RECEIVE"  THEN `amount` ELSE null END) as trtotalrcv'),
      DB::raw('sum(CASE WHEN payment_type = "TRANSFER" AND type = "BANK" AND transfer_type = "PAYMENT"  THEN `amount` ELSE null END) as trtotalpay'),
      DB::raw('sum(CASE WHEN payment_type = "OTHERS" AND type = "BANK" AND transfer_type = "RECEIVE"  THEN `amount` ELSE null END) as ottotalrcv'),
      DB::raw('sum(CASE WHEN payment_type = "OTHERS" AND type = "BANK" AND transfer_type = "PAYMENT"  THEN `amount` ELSE null END) as ottotalpay'),
      DB::raw('sum(CASE WHEN payment_type = "EXPANSE" AND type = "BANK"  THEN `amount` ELSE null END) as extotalrcv'),
      DB::raw('sum(CASE WHEN payment_type = "COLLECTION" AND type = "BANK"  THEN `amount` ELSE null END) as cltotalrcv'),
      DB::raw('sum(CASE WHEN payment_type = "RETURN" AND type = "BANK"  THEN `amount` ELSE null END) as returnVal')
      )->where('status', 1)->where('bank_id',$id)->first();


    $loandcheck = DB::table('master_banks')->where('bank_id',$id)->value('loan_amount');


    $totalrcv = $totaldata->totalrcv+$totaldata->trtotalrcv+$totaldata->ottotalrcv+$totaldata->cltotalrcv+$loandcheck+$totaldata->returnVal;
    $totalpay = $totaldata->totalpay+$totaldata->trtotalpay+$totaldata->ottotalpay+$totaldata->extotalrcv;

//dd($totaldata);
        $clb = $bank->bank_op + $totalrcv - $totalpay;

        return response($clb);

    }

    public function getchasbalance($id)
    {

        $cash = MasterCash::where('wirehouse_id',$id)->first();
        $fdate = "2023-07-01";
        $tdate =date('Y-m-d');
    $totaldata = Payment::select(
      DB::raw('sum(CASE WHEN payment_type = "RECEIVE" AND type = "CASH" AND payment_date BETWEEN  "'.$fdate.'" AND "'.$tdate.'" THEN `amount` ELSE null END) as totalrcv'),
      DB::raw('sum(CASE WHEN payment_type = "PAYMENT" AND type = "CASH" AND payment_date BETWEEN  "'.$fdate.'" AND "'.$tdate.'" THEN `amount` ELSE null END) as totalpay'),
      DB::raw('sum(CASE WHEN payment_type = "TRANSFER" AND type = "CASH" AND transfer_type = "RECEIVE" AND payment_date BETWEEN  "'.$fdate.'" AND "'.$tdate.'" THEN `amount` ELSE null END) as trtotalrcv'),
      DB::raw('sum(CASE WHEN payment_type = "TRANSFER" AND type = "CASH" AND transfer_type = "PAYMENT" AND payment_date BETWEEN  "'.$fdate.'" AND "'.$tdate.'" THEN `amount` ELSE null END) as trtotalpay'),
      DB::raw('sum(CASE WHEN payment_type = "OTHERS" AND type = "CASH" AND transfer_type = "RECEIVE" AND payment_date BETWEEN  "'.$fdate.'" AND "'.$tdate.'" THEN `amount` ELSE null END) as ottotalrcv'),
      DB::raw('sum(CASE WHEN payment_type = "OTHERS" AND type = "CASH" AND transfer_type = "PAYMENT" AND payment_date BETWEEN  "'.$fdate.'" AND "'.$tdate.'" THEN `amount` ELSE null END) as ottotalpay'),
      DB::raw('sum(CASE WHEN payment_type = "EXPANSE" AND type = "CASH" AND payment_date BETWEEN  "'.$fdate.'" AND "'.$tdate.'" THEN `amount` ELSE null END) as extotalrcv'),
      DB::raw('sum(CASE WHEN payment_type = "COLLECTION" AND type = "CASH" AND payment_date BETWEEN  "'.$fdate.'" AND "'.$tdate.'" THEN `amount` ELSE null END) as cltotalrcv'),
      DB::raw('sum(CASE WHEN payment_type = "RETURN" AND type = "CASH" AND payment_date BETWEEN  "'.$fdate.'" AND "'.$tdate.'" THEN `amount` ELSE null END) as returnVal')
    )
      ->where('status', 1)->where('wirehouse_id', $id)->first();


    $totalrcv = $totaldata->totalrcv+$totaldata->trtotalrcv+$totaldata->ottotalrcv+$totaldata->cltotalrcv+$totaldata->returnVal;
    $totalpay = $totaldata->totalpay+$totaldata->trtotalpay+$totaldata->ottotalpay+$totaldata->extotalrcv;
    $clb = $cash->wirehouse_opb + $totalrcv - $totalpay;

        return response($clb);

    }

    public function companysummaryIndex()
    {

    $areas = DealerArea::All();

        return view('backend.account.company_summary_index', compact('areas'));
    }


    public function companysummaryreport(Request $request)
    {
       // dd($request->all());

        if (isset($request->date)) {
                    $date = $request->date;
                    $dates = explode(' - ', $request->date);
                    $fdate = date('Y-m-d', strtotime($dates[0]));
                    $tdate = date('Y-m-d', strtotime($dates[1]));
                }


        $data = [];


      $data['expanse_amount'] = DB::table('payments')
            ->where('payment_type', 'EXPANSE')
        ->where('status', 1)
            ->whereBetween('payment_date', [$fdate, $tdate])
            ->sum('amount');

        $data['payment_amount'] = DB::table('payments')
            ->where('status', 1)
            ->where('payment_type', 'PAYMENT')
            ->whereBetween('payment_date', [$fdate, $tdate])
            ->sum('amount');

        $data['receive_amount'] = DB::table('payments')
            ->where('status', 1)
            ->where('payment_type', 'RECEIVE')
            ->whereBetween('payment_date', [$fdate, $tdate])
            ->sum('amount');


       $purchaseamount = DB::table('purchase_ledgers')
            ->whereNotNull('purcahse_id')
            ->whereBetween('date', [$fdate, $tdate])
            ->sum('credit');

       $purchasereturnamount = DB::table('purchase_returns')
            ->whereBetween('date', [$fdate, $tdate])
            ->sum('total_amount');

      $data['purchase_amount']  = $purchaseamount -  $purchasereturnamount;

        $sales_amount = DB::table('sales')
            ->where('is_active', 1)
            ->whereBetween('date', [$fdate, $tdate])
            ->sum('grand_total');
        $sales_return = DB::table('sales_returns')
            ->where('is_active', 1)
            ->whereBetween('date', [$fdate, $tdate])
            ->sum('grand_total');

      $data['sales_amount'] = $sales_amount - $sales_return;

        $data['journal_debit'] = DB::table('journal_entries')
            ->whereBetween('date', [$fdate, $tdate])
            ->sum('debit');
        $data['journal_credit'] = DB::table('journal_entries')
            ->whereBetween('date', [$fdate, $tdate])
            ->sum('credit');

        $data['general_purchase_amount'] = DB::table('general_purchases')
            ->whereBetween('date', [$fdate, $tdate])
            ->sum('total_value');
        $data['assets_amount'] = DB::table('assets')
            ->whereBetween('date', [$fdate, $tdate])
            ->sum('asset_value');







      //   dd($allexpasne);


        return view('backend.account.company_summary_report', compact('fdate', 'tdate', 'data'));
    }

   public function equityIndex()
    {

    $datas = DB::table('equities')->select('equities.*','equity_categories.name as cat_name')
      			->leftjoin('equity_categories','equity_categories.id', '=', 'equities.equity_category')->get();

        return view('backend.account.equity_index', compact('datas'));
    }

    public function equityReportView()
    {

    $datas = DB::table('equities')->select('equities.*')->get();

        return view('backend.account.equityReportView', compact('datas'));
    }

  public function equitycreate()
    {

    $ecats = DB::table('equity_categories')->get();
	$banks = DB::table('master_banks')->get();
    $allcashs = MasterCash::orderBy('wirehouse_name', 'asc')->get();
        return view('backend.account.equity_create', compact('ecats','banks','allcashs'));
    }


    public function storeequity(Request $request)
    {
    //  dd($request->all());
      $usid = Auth::id();
      if($request->payment_by == "1"){

        foreach($request->name as $key=> $val) {
          $paymentInvoNumber = new Payment_number();
          $paymentInvoNumber->amount = $request->amount[$key];
          $paymentInvoNumber->user_id = $usid;
          $paymentInvoNumber->save();

          $invoice = 'Equ-'.$paymentInvoNumber->id;
          DB::table('equities')->insert([
           'invoice'=> $invoice,
          'bank_id'=> '',
          'type' =>'OPEN',
          'head'=> $request->head,
          'date'=> $request->date,
          'equity_category'=> $request->equity_category,
          'name'=> $request->name[$key],
          'percentage'=> $request->percentage[$key],
          'amount'=> $request->amount[$key],
          ]);

          /* $date = date('2023-10-01');
          $this->createCreditForFinishedGoodsSale('Equity',$request->amount[$key],$date,$narration='Equity Opening',$invoice);
          */

        }
      }
      elseif ($request->payment_by == "bank"){
           foreach($request->name as $key=> $data) {
            $paymentInvoNumber = new Payment_number();
            $paymentInvoNumber->amount = $request->amount[$key];
            $paymentInvoNumber->user_id = $usid;
            $paymentInvoNumber->save();
            $invoice = 'Equ-'.$paymentInvoNumber->id;
            DB::table('equities')->insert([
             'invoice'=> $invoice,
            'bank_id'=> $request->bank_id[$key],
            'type' =>'BANK',
            'head'=> $request->head,
            'date'=> $request->date,
            'equity_category'=> $request->equity_category,
            'name'=> $request->name[$key],
            'percentage'=> $request->percentage[$key],
            'amount'=> $request->amount[$key],
            ]);

             $bankdetails = MasterBank::where('bank_id', $request->bank_id[$key])->first();

            $bank_receieve = new Payment();
            $bank_receieve->bank_id = $request->bank_id[$key];
            $bank_receieve->bank_name = $bankdetails->bank_name;
            //$bank_receieve->vendor_id = $request->dealer_id[$key];
            $bank_receieve->amount = $request->amount[$key];
            $bank_receieve->payment_date = $request->date;
            $bank_receieve->payment_type = 'RECEIVE';
            $bank_receieve->type = 'BANK';
            $bank_receieve->invoice = $invoice;
            $bank_receieve->created_by =  $usid;
            // $bank_receieve->ledger_status = 1;
            $bank_receieve->payment_description = $request->name[$key].' '.$request->head;
             $bank_receieve->save();
     	}

      } else {
      	foreach($request->name as $key=> $data) {
           $paymentInvoNumber = new Payment_number();
            $paymentInvoNumber->amount = $request->amount[$key];
            $paymentInvoNumber->user_id = $usid;
            $paymentInvoNumber->save();
            $invoice = 'Equ-'.$paymentInvoNumber->id;

            DB::table('equities')->insert([
             'invoice'=> $invoice,
            'cash_id'=> $request->cash_id[$key],
            'type' =>'CASH',
            'head'=> $request->head,
            'date'=> $request->date,
            'equity_category'=> $request->equity_category,
            'name'=> $request->name[$key],
            'percentage'=> $request->percentage[$key],
            'amount'=> $request->amount[$key],
            ]);


            $cashdetails = MasterCash::where('wirehouse_id', $request->cash_id[$key])->first();
            //dd($cashdetails);
            $cash_receieve = new Payment();
            $cash_receieve->wirehouse_id = $request->cash_id[$key];
            $cash_receieve->wirehouse_name = $cashdetails->wirehouse_name;
            //$cash_receieve->vendor_id = $request->dealer_id[$key];
            $cash_receieve->amount = $request->amount[$key];
            $cash_receieve->payment_date = $request->date;
            $cash_receieve->payment_type = 'RECEIVE';
            $cash_receieve->type = 'CASH';
            $cash_receieve->payment_description = $request->name[$key].' '.$request->head;
            $cash_receieve->invoice = $invoice;
            $cash_receieve->created_by =  $usid;
          	$cash_receieve->save();
     	}
      }

 				return redirect()->route('accounts.equity.index')->with('success','Equity Craete Successfull!');
    }


  public function deleteequity(Request $request)
    {
        $invoice = DB::table('equities')->where('id',$request->id)->value('invoice');
    	DB::table('payments')->where('invoice',$invoice)->delete();
     	DB::table('equities')->where('id',$request->id)->delete();
        //ChartOfAccounts::where('invoice',$invoice)->delete();
 				return redirect()->route('accounts.equity.index')->with('success','Equity Delete Successfull!');
    }

  public function equitycategory()
    {

    $datas = DB::table('equity_categories')->get();

        return view('backend.account.equity_category', compact('datas'));
    }

    public function equitycategoryStore(Request $request)
    {
     //   dd($request->all());
            DB::table('equity_categories')->insert([
            'name'=> $request->name,
            'description'=> $request->description,
            ]);


 				return redirect()->route('accounts.equity.category')->with('success','Equity Category Craete Successfull!');
    }


   public function balancesheetIndex()
    {

        $areas = DealerArea::All();

        return view('backend.account.balance_sheet_index', compact('areas'));
    }


    public function balancesheetreport(Request $request)
    {
        //dd($request->all());

       /* $fdate = "2023-01-01";
        $tdate = $request->date;*/
      if (isset($request->date)) {
             $dates = explode(' - ', $request->date);
             $fdate = date('Y-m-d', strtotime($dates[0]));
             $tdate = date('Y-m-d', strtotime($dates[1]));
         }

       $year = date('Y', strtotime($tdate));

        // if (isset($request->date)) {
        //     $dates = explode(' - ', $request->date);
        //     $fdate = date('Y-m-d', strtotime($dates[0]));
        //     $tdate = date('Y-m-d', strtotime($dates[1]));
        // }
 		$taxes = DB::table('taxes')->where('year',$year)->value('tax');

        $data = [];

        $allEquitiy = DB::table('equities')->whereBetween('date', [$fdate, $tdate])->sum('amount');
      	$otherIncome = DB::table('payments as p')->whereNotNull('p.income_source_id') ->where('p.status', 1)->whereBetween('p.payment_date', [$fdate, $tdate])->sum('p.amount');

		/*TRANSFER Debit  */
		$bank_transfer_amount = DB::table('payments')->whereNotNull('bank_id')->where('payment_type', 'TRANSFER')->where('transfer_type', 'RECEIVE')->where('status', 1)->whereBetween('payment_date', [$fdate, $tdate])->sum('amount');
		$bank_transfer_payment = DB::table('payments')->whereNotNull('bank_id')->where('payment_type', 'TRANSFER')->where('transfer_type', 'PAYMENT')->where('status', 1)->whereBetween('payment_date', [$fdate, $tdate])->sum('amount');

      	$data['bank_open'] = DB::table('master_banks')->sum('bank_op');
      	$data['cash_open'] = DB::table('master_cashes')->where('wirehouse_id', '!=', 47)->sum('wirehouse_opb');
		$data['cash_transfer_receive_amount'] = DB::table('payments')->where('type', 'CASH')->where('payment_type', 'TRANSFER')->where('transfer_type', 'RECEIVE')->where('wirehouse_id', '!=', 47)->where('status', 1)->whereBetween('payment_date', [$fdate, $tdate])->sum('amount');
    	$data['cash_transfer_payment_amount'] = DB::table('payments')->where('type', 'CASH')->where('payment_type', 'TRANSFER')->where('transfer_type', 'PAYMENT')->where('wirehouse_id', '!=', 47)->where('status', 1)->whereBetween('payment_date', [$fdate, $tdate])->sum('amount');
		$bank_receive_amount = DB::table('payments')->where('payment_type', 'RECEIVE')->where('type', 'BANK')->where('status', 1)->whereBetween('payment_date', [$fdate, $tdate])->sum('amount');
      	$cash_receive_amount = DB::table('payments')->where('payment_type', 'RECEIVE')->where('type', 'CASH')->where('wirehouse_id', '!=', 47)->where('status', 1)->whereBetween('payment_date', [$fdate, $tdate])->sum('amount');
      	$data['expanse_amount_bank'] = DB::table('payments')->where('payment_type', 'EXPANSE')->where('type', 'BANK')->where('status', 1)->whereBetween('payment_date', [$fdate, $tdate])->sum('amount');
      	$data['expanse_amount_cash'] = DB::table('payments')->where('payment_type', 'EXPANSE')->where('type', 'CASH')->where('status', 1)->where('wirehouse_id', '!=', 47)->whereBetween('payment_date', [$fdate, $tdate])->sum('amount');
      	$data['bank_payment_amount'] = DB::table('payments')->where('status', 1)->where('type', 'BANK')->where('payment_type', 'PAYMENT')->whereBetween('payment_date', [$fdate, $tdate])->sum('amount');
      	$data['cash_payment_amount'] = DB::table('payments')->where('wirehouse_id', '!=', 47)->where('type', 'CASH')->where('status', 1)->where('payment_type', 'PAYMENT')->whereBetween('payment_date', [$fdate, $tdate])->sum('amount');

      	//$totalBankCash = ($data['cash_open'] +$cash_receive_amount +$data['cash_transfer_receive_amount'] + $bank_transfer_amount +$data['bank_open'] +$bank_receive_amount) - ($data['bank_payment_amount'] +$data['expanse_amount_bank']+$bank_transfer_payment+$data['cash_payment_amount']+ $data['expanse_amount_cash']+$data['cash_transfer_payment_amount']);
   		$totalBankCash = ($cash_receive_amount +$data['cash_transfer_receive_amount'] + $bank_transfer_amount +$bank_receive_amount) - ($data['bank_payment_amount'] +$data['expanse_amount_bank']+$bank_transfer_payment+$data['cash_payment_amount']+ $data['expanse_amount_cash']+$data['cash_transfer_payment_amount']);



      	//$receive_amount = $bank_receive_amount + $cash_receive_amount;

      	$expanseAmountTotal = $data['expanse_amount_bank'] + $data['expanse_amount_cash'];



		//->where('type', 'BANK')

	/* shariar code start */
     $bank_transfer = DB::table('payments')->whereNotNull('bank_id')->where('payment_type', 'TRANSFER')->where('status', 1)->whereBetween('payment_date', [$fdate, $tdate])->sum('amount');
     $cash_transfer_rec_amount = DB::table('payments')->where('type', 'CASH')->where('payment_type', 'TRANSFER')->where('transfer_type', 'RECEIVE')->where('wirehouse_id', '!=', 47)->where('status', 1)->whereBetween('payment_date', [$fdate, $tdate])->sum('amount');
     $cash_transfer_pay_amount = DB::table('payments')->where('type', 'CASH')->where('payment_type', 'TRANSFER')->where('transfer_type', 'PAYMENT')->where('wirehouse_id', '!=', 47)->where('status', 1)->whereBetween('payment_date', [$fdate, $tdate])->sum('amount');
	 $Acash_amount = DB::table('payments')->where('type', 'CASH')->where('payment_type', 'PAYMENT')->where('wirehouse_id', '!=', 47)->where('status', 1)->whereBetween('payment_date', [$fdate, $tdate])->sum('amount');
     $Aexpanse_amount = DB::table('payments')->where('payment_type', 'EXPANSE')->where('type', 'CASH')->where('wirehouse_id', '!=', 47)->where('status', 1)->whereBetween('payment_date', [$fdate, $tdate]) ->sum('amount');

      /* Only for SHIMUL ENTERPRISE- RAJSHAHI here table-name 'master_cashes' & 'wirehouse_id', '=', 47 */

       $cash_open = DB::table('master_cashes')->where('wirehouse_id', '=', 47)->sum('wirehouse_opb');
      $cash_receive = DB::table('payments')->where('payment_type', 'RECEIVE')->where('type', 'CASH')->where('wirehouse_id', '=', 47)->where('status', 1)->whereBetween('payment_date', [$fdate, $tdate])->sum('amount');
      $cash_transfer_amount = DB::table('payments')->where('type', 'CASH')->where('payment_type', 'TRANSFER')->where('wirehouse_id', '=', 47)->where('transfer_type', 'RECEIVE')->where('status', 1)->whereBetween('payment_date', [$fdate, $tdate])->sum('amount');
      $cash_transfer_payment_amount = DB::table('payments')->where('type', 'CASH')->where('payment_type', 'TRANSFER')->where('wirehouse_id', '=', 47)->where('transfer_type', 'PAYMENT')->where('status', 1)->whereBetween('payment_date', [$fdate, $tdate])->sum('amount');
      $cash_amount = DB::table('payments')->where('type', 'CASH')->where('payment_type', 'PAYMENT')->where('wirehouse_id', '=', 47)->where('status', 1)->whereBetween('payment_date', [$fdate, $tdate])->sum('amount');
      $expanse_amount = DB::table('payments')->where('payment_type', 'EXPANSE')->where('type', 'CASH')->where('wirehouse_id', '=', 47)->where('status', 1)->whereBetween('payment_date', [$fdate, $tdate]) ->sum('amount');

      //$data['shimul_amount'] =  ($cash_amount + $expanse_amount + $cash_transfer_rec_amount) - ($cash_open + $cash_receive + $cash_transfer_amount + $cash_transfer_pay_amount);
      $data['shimul_amount'] =  ($cash_amount + $expanse_amount + $cash_transfer_payment_amount) - ($cash_open + $cash_receive + $cash_transfer_amount);

	  $laibilities =	$data['shimul_amount'];
      /* end */
      /*
      $total_temp =  ($cash_amount + $expanse_amount) - ($data['cash_open'] + $cash_receive + $cash_transfer_amount);
      $data['total_laibilities'] = $bank_transfer + $cash_transfer_rec_amount + $total_temp;
      */

     // $data['cash'] = ($data['cash_open'] + $cash_receive_amount + $cash_transfer_rec_amount) - ($Acash_amount + $Aexpanse_amount+$cash_transfer_pay_amount);
      $data['cash'] = ($cash_receive_amount + $cash_transfer_rec_amount) - ($Acash_amount + $Aexpanse_amount+$cash_transfer_pay_amount);

      /* end*/
       /*$purchaseamount = DB::table('purchase_ledgers')
            ->whereNotNull('purcahse_id')
            ->whereBetween('date', [$fdate, $tdate])
            ->sum('credit');
            $startDate = "2023-01-01";
            */
      $startDate = $fdate;
     /* $supplier_payment_amount = DB::table('payments')
            ->where('status', 1)->where('supplier_id', '!=', null)->where('payment_type', 'PAYMENT')
            ->whereBetween('payment_date', [$fdate, $tdate])->sum('amount'); */
      	$supplier_payment_amount = DB::table('purchase_ledgers')->whereNotNull('supplier_id')->whereBetween('date', [$fdate, $tdate])->sum('debit');
      //->whereNotNull('product_id')
	  $purchaseamount = DB::table('purchase_ledgers')->whereNotNull('supplier_id')->whereBetween('date', [$fdate, $tdate])->sum('credit');

       $purchasereturnamount = DB::table('purchase_returns')->whereBetween('date', [$startDate, $tdate])->sum('total_amount');

      $purchase_amount  = $purchaseamount -  ($purchasereturnamount + $supplier_payment_amount);
      //dd($supplier_payment_amount);
      /*  $sales_amount = DB::table('sales')
            ->where('is_active', 1)
            ->whereBetween('date', [$fdate, $tdate])
            ->sum('grand_total'); sum('total_price') */
      $sales_amount = DB::table('sales_ledgers')->select([DB::raw("SUM(total_price) total_price"), DB::raw("SUM(discount_amount) discount_amount")])
        				->whereNotNull('sale_id')->whereBetween('ledger_date', [$fdate, $tdate])->first();

     $sales_return = DB::table('sales_returns')->where('is_active', 1)->whereBetween('date', [$fdate, $tdate])->sum('grand_total');

      /* if($tdate == '2023-01-31'){
        $data['sales_amount'] = 127212135;
      } else { } */
      //$data['sales_amount'] = $sales_amount - $sales_return;


		//$data['sales_amount'] = $sales_amount - $sales_return;

      $data['bankCharge_amount'] = DB::table('payments')
            ->where('payment_type', 'EXPANSE')
        	->where('type', 'BANK')
           ->where('status', 1)->where('expanse_status', 2)
            ->whereBetween('payment_date', [$fdate, $tdate])
            ->sum('amount');


        $data['journal_debit'] = DB::table('journal_entries')
            ->whereBetween('date', [$fdate, $tdate])
            ->sum('debit');
        $data['journal_credit'] = DB::table('journal_entries')
            ->whereBetween('date', [$fdate, $tdate])
            ->sum('credit');

        $data['general_purchase_amount'] = DB::table('general_purchases')
            ->whereBetween('date', [$fdate, $tdate])
            ->sum('total_value');
        $assets_amount = DB::table('assets')
            ->whereBetween('date', [$fdate, $tdate])
          ->where('intangible',0)->where('investment',0)
            ->sum('asset_value');
      $assets_investment = DB::table('assets')
            ->whereBetween('date', [$fdate, $tdate])
          ->where('intangible',0)->where('investment',1)
            ->sum('asset_value');
      $assets_intangible = DB::table('assets')
            ->whereBetween('date', [$fdate, $tdate])
          ->where('intangible',1)->where('investment',0)
            ->sum('asset_value');

       $asset_depreciations = DB::table('asset_depreciations')->select('asset_depreciations.*','asset_products.product_name','assets.asset_head')
          		->leftJoin('assets', 'assets.id', 'asset_depreciations.asset_id')
          		->leftJoin('asset_products', 'asset_products.id', 'asset_depreciations.asset_product_id')
            ->whereBetween('asset_depreciations.date', [$fdate, $tdate])
            ->get();
     // dd($data['asset_depreciations']);


        $loan_amount = DB::table('master_banks')
         // ->where('loan_fdate', '<=', $fdate)
          ->where('loan_tdate', '>=', $tdate)
        	->sum('loan_amount');

       $bank_overderft = DB::table('master_banks')
         // ->where('loan_fdate', '<=', $fdate)
          ->where('loan_tdate', '<', $tdate)

        	->sum('loan_amount');

       $borrow_from = DB::table('borrows')
         // ->where('loan_fdate', '<=', $fdate)
          ->whereBetween('date', [$fdate, $tdate])
          ->where('type',"Short_Term")->where('type', 'BANK')
        	->sum('amount');

        $non_borrow = DB::table('borrows')
         // ->where('loan_fdate', '<=', $fdate)
          ->whereBetween('date', [$fdate, $tdate])->where('type',"Long_Term")->where('type', 'BANK')->sum('amount');


       $lease = DB::table('leases')
         // ->where('loan_fdate', '<=', $fdate)
          ->whereBetween('date', [$fdate, $tdate])->sum('amount');

      $bad_debt_amount = DB::table('bad_debts')
            ->whereBetween('date', [$fdate, $tdate])
         	->sum('amount');

      /*foreach ($rmproduct as $key => $product){
		$opening_balanceppp = RowMaterialsProduct::where('id', $product->id)->value('opening_balance');

        $opening_balance  = DB::select('SELECT SUM(purchase_set_opening_balance.opening_balance) as opbalance FROM `purchase_set_opening_balance`
            where purchase_set_opening_balance.product_id="' . $product->id . '"  and  purchase_set_opening_balance.date between "' . $startdate . '" and "' . $fdate2 . '" ');


        $stocktotal = DB::select('SELECT SUM(purchases.inventory_receive) as srcv FROM `purchases`
            where purchases.product_id="' . $product->id . '" and  purchases.date between "' . $startdate . '" and "' . $tdate . '" ');

        $pre_stocktotal = DB::select('SELECT SUM(purchases.inventory_receive) as srcv FROM `purchases`
            where purchases.product_id="' . $product->id . '"  and  purchases.date between "' . $startdate . '" and "' . $fdate2 . '" ');

        $return = $returns = DB::select('SELECT SUM(purchase_returns.return_quantity) as return_qty FROM `purchase_returns`
             WHERE purchase_returns.product_id="' . $product->id . '" and purchase_returns.date between "' . $fdate . '" and "' . $tdate . '" ');
        $pre_return = $returns = DB::select('SELECT SUM(purchase_returns.return_quantity) as return_qty FROM `purchase_returns`
             WHERE purchase_returns.product_id="' . $product->id . '" and purchase_returns.date between "' . $startdate . '" and "' . $fdate2 . '"');

        $transfer_to = DB::select('SELECT SUM(purchase_transfers.receive_qty) as transfers_qty FROM `purchase_transfers`
            WHERE purchase_transfers.product_id="' . $product->id . '"  and purchase_transfers.date between "' . $fdate . '" and "' . $tdate . '" ');
        $pre_transfer_to = DB::select('SELECT SUM(purchase_transfers.receive_qty) as transfers_qty FROM `purchase_transfers`
            WHERE purchase_transfers.product_id="' . $product->id . '"  and purchase_transfers.date BETWEEN "' . $startdate . '" and "' . $fdate2. '"');

        $transfer_from = DB::select('SELECT SUM(purchase_transfers.qty) as transfers_qty FROM `purchase_transfers`
            WHERE purchase_transfers.product_id="' . $product->id . '"  and purchase_transfers.date between "' . $fdate . '" and "' . $tdate . '" ');
        $pre_transfer_from = DB::select('SELECT SUM(purchase_transfers.qty) as transfers_qty FROM `purchase_transfers`
            WHERE purchase_transfers.product_id="' . $product->id . '"  and purchase_transfers.date BETWEEN "' . $startdate. '" and "' . $fdate2 . '"');

        $stock_out = DB::select('SELECT SUM(purchase_stockouts.stock_out_quantity) as stockout FROM `purchase_stockouts`
            WHERE purchase_stockouts.product_id ="' . $product->id . '"  and purchase_stockouts.date between "' . $startdate . '" and "' . $tdate . '" ');
        $pre_stock_out = DB::select('SELECT SUM(purchase_stockouts.stock_out_quantity) as stockout FROM `purchase_stockouts`
            WHERE purchase_stockouts.product_id ="' . $product->id . '" and purchase_stockouts.date BETWEEN "' . $startdate . '" and "' . $fdate2 . '"');

        $openingbalance =  $opening_balanceppp+$opening_balance[0]->opbalance + $pre_stocktotal[0]->srcv - $pre_return[0]->return_qty + $pre_transfer_to[0]->transfers_qty - $pre_transfer_from[0]->transfers_qty - $pre_stock_out[0]->stockout;

        $clsingbalance = $openingbalance + $stocktotal[0]->srcv - $return[0]->return_qty + $transfer_to[0]->transfers_qty - $transfer_from[0]->transfers_qty - $stock_out[0]->stockout;

        $todaypurchase = $stocktotal[0]->srcv;
 		$open += $opening_balanceppp; */

        //$inventory += ($opening_balanceppp+$opening_balance[0]->opbalance + $stocktotal[0]->srcv + $pre_stocktotal[0]->srcv + $transfer_from[0]->transfers_qty + $pre_transfer_from[0]->transfers_qty) - ($pre_return[0]->return_qty + $return[0]->return_qty + $transfer_to[0]->transfers_qty + $pre_transfer_to[0]->transfers_qty + $stock_out[0]->stockout + $pre_stock_out[0]->stockout);
        /*$avgrate = DB::select('SELECT AVG(purchases.purchase_rate) as rate FROM `purchases`
        WHERE purchases.product_id ="'.$product->id.'" and purchases.date between "'.$startdate.'" and "'.$tdate.'"'); */
       /* $startdate = '2022-12-01';
        $opening_balanceppp = RowMaterialsProduct::where('id', $product->id)->value('opening_balance');
        $stockIn = DB::table('purchases')->where('product_id',$product->id)->whereBetween('date',[$startdate,$tdate])->sum('inventory_receive');
        $stockOut = DB::table('purchase_stockouts')->where('product_id',$product->id)->whereBetween('date',[$startdate,$tdate])->sum('stock_out_quantity');
        $stockReturn = DB::table('purchase_returns')->where('product_id',$product->id)->whereBetween('date',[$startdate,$tdate])->sum('return_quantity');

        $billQty = 0;
     	$billAmount = 0;
        $rateData = DB::select('SELECT `bill_quantity`,`purchase_value` FROM `purchases`
        WHERE purchases.product_id ="'.$product->id.'" and purchases.date between "'.$startdate.'" and "'.$tdate.'"');

        foreach($rateData as $val){
        $billQty += $val->bill_quantity;
     	$billAmount += $val->purchase_value;
        }
        if($billQty > 0){
        	$rate = $billAmount/$billQty;
          $rate = round($rate,2);
        } */

       // $stockOut += $stock_out[0]->stockout;
        //$stockIn += $stocktotal[0]->srcv;
        //$stockIn += $stock;
       /* $openingbalance = $openingbalance*$rate;
        $clsingbalance = $clsingbalance*$rate;
        $todaypurchase = $todaypurchase*$rate;
        $inventory += $openingbalance - $clsingbalance;
        $cogs2 += ($openingbalance + $todaypurchase) - $clsingbalance; */

       // $inventory += round((($opening_balanceppp + $stockIn) - ($stockOut +$stockReturn)),2)*$rate;

        //$inventory += round((($opening_balanceppp + $stockIn) - ($stockOut +$stockReturn)),2);
       // $cogs2 += round($stockOut,2)*$rate;
        //$cogs2 += $stockOut;
       // dd($cogs2);
       // }
     // dd($open);
      /*
      $dir_labordata = DB::select('SELECT SUM(direct_labour_costs.total_cost) as dlcost FROM `direct_labour_costs`
                    	WHERE  direct_labour_costs.date BETWEEN "'.$startdate.'" and "'.$tdate.'"');
        $ind_labordate = DB::select('SELECT SUM(indirect_costs.total_cost) as ilcost FROM `indirect_costs`
                		WHERE  indirect_costs.fg_id ="'.$product->id.'" AND  indirect_costs.date BETWEEN "'.$startdate.'" and "'.$tdate.'"');

        $manufacturingcost = DB::select('SELECT SUM(manufacturing_costs.total_cost) as mfcost FROM `manufacturing_costs` WHERE  manufacturing_costs.date BETWEEN "'.$startdate.'" and "'.$tdate.'"');
		$data['packing_cost'] = DB::table('packing_consumptions')->whereBetween('date', [$startdate, $tdate])->sum('amount');

		$cogs2 += $dir_labordata[0]->dlcost + $manufacturingcost[0]->mfcost + $data['packing_cost']; */

      	$sales_amount = $sales_amount->total_price - $sales_return;

        $allincome =  DB::table('incomes')->whereBetween('date', [$fdate, $tdate])->sum('amount');


        $allexpasne =  DB::table('payments')->where('payment_type', 'EXPANSE')
                        ->whereBetween('payment_date', [$fdate, $tdate])->where('status', 1)->sum('amount');

      $asset_depreciations = DB::table('asset_depreciations')->whereBetween('asset_depreciations.date', [$fdate, $tdate])->sum('yearly_amount');

      $totalamountwithtaxs =($sales_amount + $allincome) - ($asset_depreciations + $allexpasne);
      //dd($totalamountwithtaxs);
     $taxtamount = round(($totalamountwithtaxs/100)*($taxes));
      $damage = DB::table('purchase_damages')->whereNotNull('product_id')->whereBetween('date', [$fdate, $tdate])->get();
     $totalDamageVal =0;
     foreach($damage as $val)
     {
     $totalDamageVal += $val->quantity*$val->rate;
     }
     $data['totalDamageVal'] = $totalDamageVal;

      //dd($sales_amount);
      if($request->type == 2)
      {
      $totalrmvalue = 0;
      $total_stockoutval = 0;
      $total_currentval = 0;
	  $inventory = 0;
      //$startdate = $startDate = $fdate "2023-01-01";
      $fdate2 =date('Y-m-d', strtotime('-1 day', strtotime($tdate)));
      $stockOut = 0;
      $stockIn = 0;
      $open = 0;
      $rmproduct = RowMaterialsProduct::orderBy('product_name', 'ASC')->get();
      $gtotlaStock = 0;
      $gtotalReturn = 0;
      $total_stockoutval = 0;
      $cogs = 0;

      foreach ($rmproduct as $key => $data){

       $sdate = $fdate;
      //$pdate = date('Y-m-d', strtotime('-1 day', strtotime($fdate)));
        //$opbcalculet = DB::select('SELECT sum(row_materials_products.opening_balance) as opening_blns FROM `row_materials_products` where row_materials_products.id = "'.$data->id.'"');
       $opbcalculet = DB::table('row_materials_products')->where('id',$data->id)->sum('opening_balance');
       $stocin = DB::table('purchases')->where('product_id',$data->id)->whereBetween('date',[$fdate,$tdate])->sum('inventory_receive');
       $dataRate = DB::table('purchases')->select('bill_quantity','purchase_value')->where('product_id', $data->id)->whereBetween('date',[$sdate,$tdate])->get();

                              	$valueTemp = 0;
                              	$valueQty = 0;
                              	$rate = 0;
                              	foreach($dataRate as $key => $val){
                              		$valueTemp += $val->purchase_value;
                              		$valueQty += $val->bill_quantity;
                              	}
                              	if($valueTemp > 0 && $valueQty > 0){
                              		$rate = $valueTemp/$valueQty;
                              		$rate = round($rate,2);
                              	} else {
                              	$rate = 0;
                              }

       /* $stocko = DB::select('SELECT SUM(purchase_stockouts.stock_out_quantity) as stockout, SUM(purchase_stockouts.total_amount) as stockout_value  FROM `purchase_stockouts` WHERE purchase_stockouts.product_id = "'.$data->id.'" and  purchase_stockouts.date between "'.$fdate.'" and "'.$tdate.'" ');
        $pre_stocko = DB::select('SELECT SUM(purchases.receive_quantity) as stockout FROM `purchases` WHERE purchases.product_id = "'.$data->id.'" and  purchases.date between "'.$sdate.'" and "'.$pdate.'" ');
		*/
        $stocko = DB::table('purchase_stockouts')->where('product_id',$data->id)->whereBetween('date',[$fdate,$tdate])->sum('stock_out_quantity');
        $return = DB::table('purchase_returns')->where('product_id',$data->id)->whereBetween('date',[$fdate,$tdate])->sum('return_quantity');
        //$pre_stocko = DB::table('purchases')->where('product_id',$data->id)->whereBetween('date',[$fdate,$pdate])->sum('receive_quantity');
        $damage = DB::table('purchase_damages')->where('product_id',$data->id)->whereBetween('date',[$fdate,$tdate])->sum('quantity');
        /* $avgrate = DB::select('SELECT AVG(purchases.purchase_rate) as rate FROM `purchases`
        WHERE purchases.product_id ="'.$data->id.'" and purchases.date between "'.$sdate.'" and "'.$tdate.'"'); */
        if(!empty($damage) && !empty($opbcalculet)){
         $qty = ($stocin + $opbcalculet) - $damage;
        } else {
          $qty = $stocin;
        }
         $gtotlaStock += round($qty*$rate,2);
         $gtotalReturn += round($return,2)*$rate;
         $total_stockoutval += round($stocko,2)*$rate;
      }

     // $stocin = DB::table('purchases')->select('product_id','')->whereBetween('date',[$fdate,$tdate])->sum('total_payable_amount');

      //dd($totalInventoryAmount);

      	//$bagPurchase = DB::table('purchase_details')->select( DB::raw('SUM(purchase_details.amount) AS amount'))->leftjoin('purchases', 'purchases.purchase_id','=','purchase_details.purchase_id')->whereBetween('purchases.date', [$fdate, $tdate])->first();
      	if(date("m", strtotime($tdate)) == 01){
      	$bagPurchase = DB::table('purchase_details')->leftjoin('purchases', 'purchases.purchase_id','=','purchase_details.purchase_id')->whereBetween('purchases.date', [$fdate, $tdate])->sum('amount');
        } else {
        	$bagPurchase = 0;
        }
      //$bagStockOut = DB::table('purchase_stockouts')->leftjoin('row_materials_products as r', 'r.id','=','purchase_stockouts.product_id')->where('r.unit','PCS')->whereBetween('purchase_stockouts.date', [$fdate, $tdate])->sum('total_amount');
		$dir_labordata = DB::select('SELECT SUM(direct_labour_costs.total_cost) as dlcost FROM `direct_labour_costs`
                    	WHERE  direct_labour_costs.date BETWEEN "'.$fdate.'" and "'.$tdate.'"');
      	$manufacturingcost = DB::select('SELECT SUM(manufacturing_costs.total_cost) as mfcost FROM `manufacturing_costs` WHERE  manufacturing_costs.date BETWEEN "'.$fdate.'" and "'.$tdate.'"');

      	$packing_cost = DB::table('packing_consumptions')->whereBetween('date', [$fdate, $tdate])->sum('amount');
		//$inventory = ($gtotlaStock + $bagPurchase) - ($total_stockoutval + $packing_cost + $gtotalReturn+$dir_labordata[0]->dlcost + $manufacturingcost[0]->mfcost);
     	$inventory = $gtotlaStock - ($total_stockoutval + $packing_cost);
      	//$cogs = $total_stockoutval + $packing_cost + $dir_labordata[0]->dlcost + $manufacturingcost[0]->mfcost;
       $cogs = $total_stockoutval + $packing_cost;
    }
      	//$cogs = $total_stockoutval;

      /*$purchase_val  = $purchaseamount -  $purchasereturnamount;
      	$inventory = $purchase_val - $cogs; */
      //dd($bagPurchase);
       $equitiy = DB::table('equities')->select('equity_categories.name', DB::raw('SUM(equities.amount) AS amount'))
         	    ->leftjoin('equity_categories','equity_categories.id', '=', 'equities.equity_category')->whereBetween('date', [$fdate, $tdate])->groupby('equity_categories.id')->get();
      $receive_amount = DB::table('sales_ledgers')->whereNotNull('invoice')->whereBetween('ledger_date', [$fdate, $tdate])->sum('credit');

      $accountRece = ($sales_amount) - $receive_amount;

      if($request->type == 1){
     $purchaseData = DB::table('purchase_stockouts')->select('stock_out_quantity','stock_out_rate')->whereNotNull('product_id')->whereBetween('date',[$fdate,$tdate])->get();
     //$damage = DB::table('purchase_damages')->whereBetween('date',[$fdate,$tdate])->sum('quantity');
        $totalPurchaseOut = 0;
     foreach($purchaseData as $val){
     	$totalPurchaseOut += $val->stock_out_quantity * $val->stock_out_rate;
     }
        $inventory = $purchaseamount - ($totalPurchaseOut + $purchasereturnamount + $data['totalDamageVal']);
        $cogs = $totalPurchaseOut;
      }

      return view('backend.account.balance_sheet', compact('borrow_from','bad_debt_amount','non_borrow','lease','expanseAmountTotal','assets_investment','otherIncome','taxtamount','sales_amount','equitiy','laibilities','purchase_amount','loan_amount','bank_overderft','assets_intangible','asset_depreciations','assets_amount','accountRece','totalBankCash','inventory','cogs','fdate', 'tdate', 'data','taxes'));
    }


  public function allIncomeInedex()
    {
    $datas = DB::table('payments as p')->select('p.id','p.payment_date as date','p.bank_name','p.wirehouse_name','income_sources.name as isname','p.amount','p.type','p.production_head as head','p.payment_description as description')
      			->leftjoin('income_sources','income_sources.id', '=', 'p.income_source_id')->whereNotNull('p.income_source_id')->get();


        return view('backend.account.income_index', compact('datas'));
    }

  public function allIncomecreate()
    {
    	$allcashs = MasterCash::orderBy('wirehouse_name', 'asc')->get();
        $allBanks = MasterBank::orderBy('bank_name', 'asc')->get();
  	//	$iss = DB::table('income_sources')->get();
        $assetProduct =  AssetProduct::all();
        return view('backend.account.income_create',compact('allcashs','allBanks','assetProduct'));
    }


    public function allIncomeentry(Request $request)
    {
        	//dd($request->all());
      	$now = new Carbon();
       	$ctime = date("Y-m-d H:i:s", strtotime($now));
       if ($request->bank_id != null) {
            $bankname = MasterBank::where('bank_id', $request->bank_id)->value('bank_name');
            $cashdetails = 'null';
            $type = 'BANK';
        } else {
            $cashdetails = MasterCash::where('wirehouse_id', $request->wirehouse_id)->value('wirehouse_name');
            $bankname = 'null';
            $type = 'CASH';
        }
           foreach($request->head as $key=> $data) {

              $otherIncomeId =  DB::table('payments')->insertGetId([
                'bank_id'=> $request->bank_id,
                'bank_name'=> $bankname,
                'wirehouse_id'=> $request->wirehouse_id,
                'wirehouse_name'=> $cashdetails,
                'income_source_id'=> $request->income_source_id[$key],
                'amount'=> $request->amount[$key],
                'payment_date'=> $request->date,
                'payment_type'=> 'RECEIVE',
                'type'=> $type,
                'payment_description'=> $request->description,
                'created_at' => $ctime,
                'production_head'=> $request->head[$key],
                'status'=> 1
                ]);
                $invoice = 'OIn-'.+1000+$otherIncomeId;

                Payment::where('id',$otherIncomeId)->update([
                   'invoice' => $invoice,
               ]);

               $OthersIncome = new OthersIncome();

               $OthersIncome->product_id = $request->income_source_id[$key];
               $OthersIncome->date = $request->date;
               $OthersIncome->invoice = $invoice;
               $OthersIncome->amount = $request->amount[$key];
               $OthersIncome->head = $request->head[$key];
               $OthersIncome->description = $request->description;
               $OthersIncome->save();

            if($type == 'BANK'){
              $this->creditJournalForSupplier('Others Income' , $request->amount[$key], $request->date, $request->description,$invoice);
              $this->createDebitForBankReceive($bankname, $request->amount[$key], $request->date, $request->description,$invoice);
            } else {
              $this->creditJournalForSupplier('Others Income', $request->amount[$key], $request->date, $request->description,$invoice);
              $this->createDebitForCashReceive($cashdetails, $request->amount[$key], $request->date, $request->description,$invoice);
            }
      }
 			return redirect()->route('all.income.index')->with('success','Others Income Entry Successfull!');
    }


  public function otherIncomeView($id)
    {
    $data = DB::table('payments as p')->select('p.id','p.invoice','p.payment_date as date','p.bank_name','p.wirehouse_name','income_sources.name as isname','p.amount','p.type','p.production_head as head','p.payment_description as description')
      			->leftjoin('income_sources','income_sources.id', '=', 'p.income_source_id')->where('p.id',$id)->first();
	$userName =  DB::table('users')->where('id', Auth::id())->value('name');

        return view('backend.account.income_view', compact('data','userName'));
    }

   public function deleteallIncome(Request $request)
    {
        //dd($request->all());
      $invoice = Payment::where('id',$request->id)->value('invoice');
      DB::table('payments')->where('id',$request->id)->delete();
     // DB::table('incomes')->where('id',$id)->delete();
     OthersIncome::where('invoice',$invoice)->delete();
     ChartOfAccounts::where('invoice',$invoice)->delete();

 		return redirect()->route('all.income.index')->with('success','Delete Successfull!');
    }

    public function allIncomeSourcecreate()
    {
     // dd('ddd');

    $datas = DB::table('income_sources')->get();

        return view('backend.account.income_source', compact('datas'));
    }



    public function allIncomeSourceentry(Request $request)
    {
        //dd($request->all());
             DB::table('income_sources')->insert([
            'name'=> $request->name,
            'description'=> $request->description,

            ]);

 				return redirect()->route('all.income.source.create')->with('success','Income source Create Successfull!');
    }


    public function deleteSourceIncome(Request $request)
    {
        //dd($request->all());

      DB::table('income_sources')->where('id',$request->id)->delete();

 				return redirect()->route('all.income.source.create')->with('success','Delete Successfull!');
    }






  public function loanBInedex()
    {

    $datas = DB::table('borrows')->get();

        return view('backend.account.loan_and_borrow_index', compact('datas'));
    }

  public function loanBcreate()
    {

  $iss = DB::table('borrows')->get();

    $banks = MasterBank::all();
    $cashes = MasterCash::all();
    $ascs = AssetClint::all();
    $companys = DB::table('company_names')->get();


        return view('backend.account.loan_and_borrow_create',compact('banks','cashes','ascs','companys'));
    }


    public function loanBentry(Request $request)
    {
      //  dd($request->all());
             DB::table('borrows')->insert([
            'description'=> $request->description,
            'date'=> $request->date,

            'payment_mode'=> $request->payment_mode,
            'bank_id'=> $request->bank_id,
            'warehouse_id'=> $request->warehouse_id,

            'from_date'=> $request->from_date,
               'from_client_id'=> $request->from_client_id,
            'to_company_id'=> $request->to_company_id,
                'from_company_id'=> $request->from_company_id,
            'to_client_id'=> $request->to_client_id,
            'amount'=> $request->amount,
            'type'=> $request->type,





            ]);



 				return redirect()->route('loan.borrowing.index')->with('success',' Entry Successfull!');
    }


    public function deleteloanB(Request $request)
    {
        //dd($request->all());

      DB::table('borrows')->where('id',$request->id)->delete();
 				return redirect()->route('loan.borrowing.index')->with('success','Delete Successfull!');
    }



   public function ltrInedex()
    {

    $datas = DB::table('ltrs')->get();

        return view('backend.account.ltr_index', compact('datas'));
    }

  public function ltrcreate()
    {

  $iss = DB::table('borrows')->get();

    $banks = MasterBank::all();
    $cashes = MasterCash::all();
    $ascs = AssetClint::all();
    $companys = DB::table('company_names')->get();


        return view('backend.account.ltr_create',compact('banks','cashes','ascs','companys'));
    }


    public function ltrentry(Request $request)
    {
     //   dd($request->all());
             DB::table('ltrs')->insert([
            'description'=> $request->description,
            'date'=> $request->date,
            'head'=> $request->head,

            'payment_mode'=> $request->payment_mode,
            'bank_id'=> $request->bank_id,
            'warehouse_id'=> $request->warehouse_id,

            'from_date'=> $request->from_date,
               'from_client_id'=> $request->from_client_id,
            'to_company_id'=> $request->to_company_id,
                'from_company_id'=> $request->from_company_id,
            'to_client_id'=> $request->to_client_id,
            'amount'=> $request->amount,
            'type'=> $request->type,





            ]);



 				return redirect()->route('ltr.index')->with('success',' Entry Successfull!');
    }


    public function deleteltr(Request $request)
    {
        //dd($request->all());

      DB::table('ltrs')->where('id',$request->id)->delete();
 				return redirect()->route('loan.borrowing.index')->with('success','Delete Successfull!');
    }




   public function BadDebtInedex()
    {

    $datas = DB::table('bad_debts')->get();

        return view('backend.account.bad_debt_index', compact('datas'));
    }

  public function BadDebtcreate()
    {



    $banks = MasterBank::all();
    $cashes = MasterCash::all();

        return view('backend.account.bad_debt_create',compact('banks','cashes'));
    }


    public function BadDebtentry(Request $request)
    {
     //   dd($request->all());
             DB::table('bad_debts')->insert([
            'description'=> $request->description,
            'date'=> $request->date,

            'head'=> $request->head,

            'amount'=> $request->amount,





            ]);



 				return redirect()->route('bad.debt.index')->with('success',' Entry Successfull!');
    }


    public function deleteBadDebt(Request $request)
    {
        //dd($request->all());

      DB::table('bad_debts')->where('id',$request->id)->delete();
 				return redirect()->route('bad.debt.index')->with('success','Delete Successfull!');
    }





  public function leaseInedex()
    {

    $datas = DB::table('leases')->select('leases.*','asset_clints.name')->leftJoin('asset_clints', 'asset_clints.id', 'leases.client_id')->get();

        return view('backend.account.lease_index', compact('datas'));
    }

  public function leasecreate()
    {

  $iss = DB::table('leases')->get();

    $banks = MasterBank::all();
    $cashes = MasterCash::all();
     $assetclint = AssetClint::all();

        return view('backend.account.lease_create',compact('banks','cashes','assetclint'));
    }


    public function leaseentry(Request $request)
    {
        //dd($request->all());
             DB::table('leases')->insert([
            'description'=> $request->description,
            'date'=> $request->date,
            'head'=> $request->head,

            'payment_mode'=> $request->payment_mode,
            'bank_id'=> $request->bank_id,
            'warehouse_id'=> $request->warehouse_id,

            'amount'=> $request->amount,
            'type'=> $request->type,
            'year'=> $request->year,
            'client_id'=> $request->client_id,






            ]);



 				return redirect()->route('lease.index')->with('success',' Entry Successfull!');
    }


    public function deletelease(Request $request)
    {
        //dd($request->all());

      DB::table('leases')->where('id',$request->id)->delete();
 				return redirect()->route('lease.index')->with('success','Delete Successfull!');
    }




  public function companyCreate(Request $request)
    {

        $datas = DB::table('company_names')->get();

        return view('backend.account.company_name', compact('datas'));
    }

	public function deletecompany(Request $request)
    {
      //dd($request->all());
      DB::table('company_names')->where('id',$request->id)->delete();
      return redirect()->back()
            ->with('success', 'Deleted Successfull');
    }

    public function companyStore(Request $request)
    {


        //dd($request->all());

         DB::table('company_names')->insert([
            'name'=> $request->name,
            'address'=> $request->address,








            ]);

        return redirect()->back()
            ->with('success', ' Created Successfull');
    }


  public function budgetindex(Request $request)
    {

        $datas = DB::table('budgets')->get();

        return view('backend.account.budget_list', compact('datas'));
    }

  public function budgetcreate(Request $request)
    {



        return view('backend.account.budget_input');
    }
    public function budgetentry(Request $request)
    {


        //dd($request->all());

         DB::table('budgets')->insert([
            'company'=> $request->company,
            'budget_amount'=> $request->budget_amount,
            'budget_year'=> $request->budget_year,
            'description'=> $request->description








            ]);

        return redirect()->route('budget.index')
            ->with('success', ' Created Successfull');
    }

  public function deletebudget(Request $request)
    {
      //dd($request->all());
      DB::table('budgets')->where('id',$request->id)->delete();
      return redirect()->back()
            ->with('success', 'Deleted Successfull');
    }



   public function budgetdistributioncreate($id)
    {
 			$budgets = DB::table('budgets')->where('id',$id)->first();
     $zones = DealerZone::all();
        $datas = DB::table('budget_ditributions')->get();
     $subgroups = ExpanseSubgroup::all();

        return view('backend.account.budget_distribution_input', compact('datas','zones','budgets','subgroups'));
    }


   public function budgetdistributionentry(Request $request)
    {


      //  dd($request->all());
     foreach($request->month as $key => $item){
           DB::table('budget_ditributions')->insert([
                'budget_id'=> $request->budget_id,
                'month'=> $request->month[$key],
                'zone_id'=> $request->zone_id[$key],
                'amount'=> $request->amount[$key],
                'expanse_subgroup_id'=> $request->expanse_subgroup_id[$key],
             'remaining_amount'=> $request->amount[$key],
                   ]);


     }



        return redirect()->route('budget.index')
            ->with('success', ' Created Successfull');
    }


  public function budgetdistributionindex($id)
    {
 			$budgets = DB::table('budgets')->where('id',$id)->first();
     $zones = DealerZone::all();
        $datas = DB::table('budget_ditributions')->select('budget_ditributions.*','dealer_zones.zone_title','expanse_subgroups.subgroup_name','expanse_subgroups.group_name')
          		->leftjoin('dealer_zones', 'dealer_zones.id', 'budget_ditributions.zone_id')
          		->leftjoin('expanse_subgroups', 'expanse_subgroups.id', 'budget_ditributions.expanse_subgroup_id')
          		->get();

        return view('backend.account.budget_distribution_list', compact('datas','zones','budgets'));
    }


    public function deletebudgetdistribution(Request $request)
    {
      //dd($request->all());
      DB::table('budget_ditributions')->where('id',$request->id)->delete();
      return redirect()->back()
            ->with('success', 'Deleted Successfull');
    }





  public function factory_overheadindex(Request $request)
    {

        $datas = DB::table('factory_overheads')->get();

        return view('backend.account.budget_list', compact('datas'));
    }

  public function factory_overheadcreate(Request $request)
    {



        return view('backend.account.factory_overhead_input');
    }
    public function factory_overheadentry(Request $request)
    {


        //dd($request->all());

         DB::table('factory_overheads')->insert([
            'date'=> $request->date,
            'head'=> $request->head,
            'amount'=> $request->amount

            ]);

        return redirect()->route('factory_overhead.index')
            ->with('success', ' Created Successfull');
    }

  public function deletefactory_overhead(Request $request)
    {
      //dd($request->all());
      DB::table('factory_overheads')->where('id',$request->id)->delete();
      return redirect()->back()
            ->with('success', 'Deleted Successfull');
    }






  public function piechartIndex()
    {

        $areas = DealerArea::All();

        return view('backend.account.pie_chart_index', compact('areas'));
    }


    public function piechart(Request $request)
    {
     //   dd($request->all());
        //$fdate = "2020-01-01";
       // $tdate = $request->date;

      //   if (isset($request->date)) {
      //       $dates = explode(' - ', $request->date);
       //      $fdate = date('Y-m-d', strtotime($dates[0]));
       //      $tdate = date('Y-m-d', strtotime($dates[1]));
       //  }

       if (isset($request->date)) {
         	$fdate = $request->date . "-01";
            //$tdate = $request->month_year."-31";
            $tdate = date("Y-m-t", strtotime($fdate));
            $month_name =  date('F', strtotime($fdate));
         }

      //dd($month_name);



        $data = [];


       /* $data['expanse_amount'] = DB::table('payments')
            ->where('payment_type', 'EXPANSE')
          ->where('status', 1)
            ->whereBetween('payment_date', [$fdate, $tdate])
            ->sum('amount'); */

      $data['expanse_details'] = DB::table('payments')->select([
                              DB::raw("SUM(amount) expamount"),
        					'expanse_subgroups.group_id','expanse_subgroups.group_name'
                           ])
       		 ->leftJoin('expanse_subgroups', 'expanse_subgroups.id', '=', 'payments.expanse_subgroup_id')
       		 ->where('payment_type', 'EXPANSE')
        ->where('status', 1)
            ->whereBetween('payment_date', [$fdate, $tdate])
        	->groupby('expanse_subgroups.group_id')
            ->get();

        $data['payment_amount'] = DB::table('payments')
            ->where('status', 1)
            ->where('payment_type', 'PAYMENT')
            ->whereBetween('payment_date', [$fdate, $tdate])
            ->sum('amount');

       $data['genaral_payment_amount'] = DB::table('payments')
            ->where('status', 1)
            ->where('payment_type', 'PAYMENT')
            ->whereBetween('payment_date', [$fdate, $tdate])
            ->sum('amount');

        $data['receive_amount'] = DB::table('payments')
            ->where('status', 1)
            ->where('payment_type', 'RECEIVE')
            ->whereBetween('payment_date', [$fdate, $tdate])
            ->sum('amount');


        $purchaseamount = DB::table('purchase_ledgers')
            ->whereNotNull('purcahse_id')
            ->whereBetween('date', [$fdate, $tdate])
            ->sum('credit');

        $purchasereturnamount = DB::table('purchase_returns')
            ->whereBetween('date', [$fdate, $tdate])
            ->sum('total_amount');

      $data['purchase_amount']  = $purchaseamount -  $purchasereturnamount;

        $sales_amount = DB::table('sales')
            ->where('is_active', 1)
            ->whereBetween('date', [$fdate, $tdate])
            ->sum('grand_total');
        $sales_return = DB::table('sales_returns')
            ->where('is_active', 1)
            ->whereBetween('date', [$fdate, $tdate])
            ->sum('grand_total');

       $data['sales_amount'] = $sales_amount - $sales_return;


        $data['journal_debit'] = DB::table('journal_entries')
            ->whereBetween('date', [$fdate, $tdate])
            ->sum('debit');
        $data['journal_credit'] = DB::table('journal_entries')
            ->whereBetween('date', [$fdate, $tdate])
            ->sum('credit');

        $data['general_purchase_amount'] = DB::table('general_purchases')
            ->whereBetween('date', [$fdate, $tdate])
            ->sum('total_value');
        $data['assets_amount'] = DB::table('assets')
            ->whereBetween('date', [$fdate, $tdate])
            ->sum('asset_value');

      $purchase_stockouts = DB::table('purchase_stockouts')
            ->whereBetween('date', [$fdate, $tdate])
            ->sum('total_amount');

      /*$direct_labour_costs = DB::table('direct_labour_costs')
            ->whereBetween('date', [$fdate, $tdate])
            ->sum('total_cost');
      $manufacturing_costs = DB::table('manufacturing_costs')
            ->whereBetween('date', [$fdate, $tdate])
            ->sum('total_cost');

	$data['production_cost']  = $purchase_stockouts+$direct_labour_costs+$manufacturing_costs;
	*/

    $factoryOverHead = ChartOfAccounts::select(DB::raw('SUM(debit) - SUM(credit) as balance'))
                    ->where('ac_sub_account_id',21)
                    ->where('invoice','NOT LIKE','E-Pay-Inv%')
                    ->whereBetween('date', [$fdate, $tdate])->get();

    $directLabourCost = ChartOfAccounts::select(DB::raw('SUM(debit) - SUM(credit) as balance'))
                    ->where('ac_sub_account_id',56)
                    ->where('invoice','NOT LIKE','E-Pay-Inv%')
                    ->whereBetween('date', [$fdate, $tdate])->get();

    $productionCost = ChartOfAccounts::select(DB::raw('SUM(debit) - SUM(credit) as balance'))
                    ->where('ac_sub_account_id',8)->whereBetween('date', [$fdate, $tdate])->get();

    $data['production_cost'] = $factoryOverHead[0]->balance + $directLabourCost[0]->balance + $productionCost[0]->balance;

            //FOR COGS

    $totalExpense = 0;
    $checkDate = $fdate;
           $individualAccountInfo = $this->getChartOfExpenseAccountInfo($fdate, $tdate);
           foreach($individualAccountInfo as $account){
                    if($account->acSubAccount?->id != 8 && $account->acSubAccount?->id != 60){
                   if($checkDate == '2023-10-01'){
                     $preEndDate = '2023-10-01';
                     $preData = ChartOfAccounts::with('acSubSubAccount:id,title')->select('ac_sub_account_id',
                             DB::raw('SUM(debit) - SUM(credit) as balance')
                             )->where('invoice','LIKE','E-Pay-Inv%')
                             ->where('ac_sub_account_id',$account->acSubAccount?->id)->whereBetween('date', [$fdate, $preEndDate])->first();

                        $amount = $account->balance -  $preData->balance;
                   } else {
                       $amount = $account->balance;
                   }

                   $totalExpense += $amount;
                    }

           }

    $data['expanse_amount'] = $totalExpense;

           //dd($productionCost[0]->balance);


    //   dd($data);




        return view('backend.account.pie_chart', compact('fdate', 'tdate', 'data','month_name'));
    }



  public function expenditurepiechartIndex()
    {

        $areas = DealerArea::All();

        return view('backend.account.expenditure_pie_chart_index', compact('areas'));
    }


    public function expenditurepiechart(Request $request)
    {
       // dd($request->all());
        //$fdate = "2020-01-01";
       // $tdate = $request->date;

      //   if (isset($request->date)) {
      //       $dates = explode(' - ', $request->date);
       //      $fdate = date('Y-m-d', strtotime($dates[0]));
       //      $tdate = date('Y-m-d', strtotime($dates[1]));
       //  }

       if (isset($request->date)) {
         	$fdate = $request->date . "-01";
            //$tdate = $request->month_year."-31";
            $tdate = date("Y-m-t", strtotime($fdate));
            $month_name =  date('F', strtotime($fdate));
         }

      //dd($month_name);



        $data = [];


        $data['expanse_amount'] = DB::table('payments')
            ->where('payment_type', 'EXPANSE')
          ->where('status', 1)
            ->whereBetween('payment_date', [$fdate, $tdate])
            ->sum('amount');

     /* $data['expanse_details'] = DB::table('payments')->select([
                              DB::raw("SUM(amount) expamount"),
        					'expanse_subgroups.group_id','expanse_subgroups.group_name'
                           ])
       		 ->leftJoin('expanse_subgroups', 'expanse_subgroups.id', '=', 'payments.expanse_subgroup_id')
       		 ->where('payment_type', 'EXPANSE')
            ->where('status', 1)
            ->whereBetween('payment_date', [$fdate, $tdate])
        	->groupby('expanse_type_id')
            ->get(); */

    $expenseInfo = [];
    $checkDate = $fdate;
           $individualAccountInfo = $this->getChartOfExpenseAccountInfo($fdate, $tdate);
           foreach($individualAccountInfo as $account){
                    if($account->acSubAccount?->id != 8 && $account->acSubAccount?->id != 60){
                   if($checkDate == '2023-10-01'){
                     $preEndDate = '2023-10-01';
                     $preData = ChartOfAccounts::with('acSubSubAccount:id,title')->select('ac_sub_account_id',
                             DB::raw('SUM(debit) - SUM(credit) as balance')
                             )->where('invoice','LIKE','E-Pay-Inv%')
                             ->where('ac_sub_account_id',$account->acSubAccount?->id)->whereBetween('date', [$fdate, $preEndDate])->first();

                        $amount = $account->balance -  $preData->balance;
                   } else {
                       $amount = $account->balance;
                   }

                   $expenseInfo[] = $this->getDebitForIncomeStatement($account->ac_sub_account_id, $account->acSubAccount?->title,$amount);
                    }

           }

        //dd($expenseInfo);
            //FOR COGS




        //    dd($cogs);


      // dd($data);




        return view('backend.account.expenditure_pie_chart', compact('fdate', 'tdate', 'data','month_name','expenseInfo'));
    }



    public function budgetepiechartIndex()
    {

        $budgets = DB::table('budgets')->get();


        return view('backend.account.budget_pie_chart_index', compact('budgets'));
    }


    public function budgetpiechart(Request $request)
    {
       // dd($request->all());
        //$fdate = "2020-01-01";
       // $tdate = $request->date;

      //   if (isset($request->date)) {
      //       $dates = explode(' - ', $request->date);
       //      $fdate = date('Y-m-d', strtotime($dates[0]));
       //      $tdate = date('Y-m-d', strtotime($dates[1]));
       //  }

       if (isset($request->date)) {
         	$fdate = $request->date . "-01";
            //$tdate = $request->month_year."-31";
            $tdate = date("Y-m-t", strtotime($fdate));
            $month_name =  date('F', strtotime($fdate));
         }

      //dd($month_name);



        $data = [];


        $data['budget_total_amount'] = DB::table('budgets')
          ->where('id',$request->budget_id)
            ->sum('budget_amount');

      $data['budget_ditribute_amount'] = DB::table('budget_ditributions')
          ->where('budget_id',$request->budget_id)
            ->where('month', $request->date)
            ->sum('amount');

      $data['budget_amount'] = DB::table('budget_ditributions')->select([
                              DB::raw("SUM(budget_ditributions.amount) budgetamount"),
        					'dealer_zones.zone_title'
                           ])
       		 ->leftJoin('dealer_zones', 'dealer_zones.id', '=', 'budget_ditributions.zone_id')
       		  ->where('budget_ditributions.month', $request->date)
        	->groupby('dealer_zones.zone_title')
            ->get();



            //FOR COGS




        //    dd($cogs);


       //dd($data);




        return view('backend.account.budget_pie_chart', compact('fdate', 'tdate', 'data','month_name'));
    }



  public function taxCreate(Request $request)
    {

        $datas = DB::table('taxes')->get();

        return view('backend.account.taxes', compact('datas'));
    }

	public function taxdelete(Request $request)
    {
      //dd($request->all());
      DB::table('taxes')->where('id',$request->id)->delete();
      return redirect()->back()
            ->with('success', 'Deleted Successfull');
    }

    public function taxStore(Request $request)
    {

        //dd($request->all());

         DB::table('taxes')->insert([
            'head'=> $request->head,
            'tax'=> $request->tax,
            'year'=> $request->year,
            ]);

        return redirect()->back()
            ->with('success', ' Created Successfull');
    }

  /*
  Financial Expense by Shariar
  */

  public function financialExpenseCreate(Request $request){
  $datas = DB::table('financial_expenses')->get();
  return view('backend.account.financial_expense', compact('datas'));
  }

  public function financialExpenseStore(Request $request){
  DB::table('financial_expenses')->insert([
            'head'=> $request->head,
            'expense'=> $request->expense,
            'year'=> $request->year,
            ]);

        return redirect()->back()
            ->with('success', ' Created Successfull');
  }

  public function financialExpenseDelete(Request $request){
    DB::table('financial_expenses')->where('id',$request->id)->delete();
      return redirect()->back()
            ->with('success', 'Data Deleted Successfull');

  }


    public function toptencollectionreportindex()
    {

        return view('backend.account.toptenreportindexcollection');
    }



      public function toptencollectionreportpiechart(Request $request)
    {

 		 if (isset($request->date)) {
         	   $dates = explode(' - ', $request->date);
            $fdate = date('Y-m-d', strtotime($dates[0]));
            $tdate = date('Y-m-d', strtotime($dates[1]));
         }


      $data = DB::table('payments as t1')
            // ->leftjoin('sales as t1','t1.id','t5.sale_id')
              ->leftjoin('dealers as t2', 't1.vendor_id', '=', 't2.id');



        $data = $data->select(
              't2.d_s_name',
            't1.vendor_id',
            DB::raw('sum(CASE WHEN t1.payment_date between "' . $fdate . '" AND  "' . $tdate . '" THEN `amount` ELSE null END) as amount')


        )
            ->whereNotNull('t2.d_s_name')->where('status',1)->where('payment_type',"RECEIVE")->groupBy('t1.vendor_id')
            ->orderBy('amount', 'desc')->take(10)->get();


     // dd( $data );



        return view('backend.account.toptenreportcollection', compact('fdate', 'tdate', 'data',));
    }
    public function toptenexpansereportindex()
    {

        return view('backend.account.toptenreportindexexpanse');
    }


      public function toptenexpansereportpiechart(Request $request)
    {

 		 if (isset($request->date)) {
         	   $dates = explode(' - ', $request->date);
            $fdate = date('Y-m-d', strtotime($dates[0]));
            $tdate = date('Y-m-d', strtotime($dates[1]));
         }


      $data = DB::table('payments as t1')
            // ->leftjoin('sales as t1','t1.id','t5.sale_id')
            ->leftjoin('expanse_subgroups as t2', 't1.expanse_subgroup_id', '=', 't2.id');


        $data = $data->select(
              't2.group_name',
            't2.group_id',
            DB::raw('sum(CASE WHEN t1.payment_date between "' . $fdate . '" AND  "' . $tdate . '" THEN `amount` ELSE null END) as amount')


        )
            ->whereNotNull('t2.group_name')->where('status',1)->where('payment_type',"EXPANSE")->groupBy('t2.group_id')
            ->orderBy('amount', 'desc')->take(10)->get();


    // dd( $data );



        return view('backend.account.toptenreportexpanse', compact('fdate', 'tdate', 'data',));
    }

  	public function cashreceivablereportIndex()
    {
    	return view('backend.account.cash_receivable_report_index');
    }

  	public function cashreceivablereportView(Request $request)
    {
    	if (isset($request->date)) {
         	   $dates = explode(' - ', $request->date);
            $fdate = date('Y-m-d', strtotime($dates[0]));
            $tdate = date('Y-m-d', strtotime($dates[1]));
         }

        $dealers = DB::table('sales')
          ->select('sales.dealer_id','dealers.d_s_name')
          ->leftJoin('dealers','dealers.id','sales.dealer_id')
          ->whereBetween('payment_date', [$fdate, $tdate])
          ->groupby('dealer_id')
          ->get();
      	//dd($dealers);
      return view('backend.account.cash_receivable_report_view',compact('dealers','fdate','tdate'));
    }







   public function financialreportIndex()
    {

        $areas = DealerArea::All();

        return view('backend.account.financial_report_index', compact('areas'));
    }


    public function financialreportreport(Request $request)
    {
    //    dd($request->all());
        $fdate = "2020-01-01";
        $tdate = $request->date;


      $year = date('Y', strtotime($tdate));

        // if (isset($request->date)) {
        //     $dates = explode(' - ', $request->date);
        //     $fdate = date('Y-m-d', strtotime($dates[0]));
        //     $tdate = date('Y-m-d', strtotime($dates[1]));
        // }
 			$taxes = DB::table('taxes')->where('year',$year)->value('tax');



        $data = [];


      $data['expanse_amount'] = DB::table('payments')
            ->where('payment_type', 'EXPANSE')
        ->where('status', 1)
            ->whereBetween('payment_date', [$fdate, $tdate])
            ->sum('amount');

      $data['expanse_type'] = DB::table('payments')->select('expanse_types.title', DB::raw('SUM(payments.amount) AS amount'))
         	->leftjoin('expanse_types','expanse_types.id', '=', 'payments.expanse_type_id')
             ->where('payment_type', 'EXPANSE')
        ->where('status', 1)
        ->whereNotNull('expanse_type_id')
            ->whereBetween('payment_date', [$fdate, $tdate])
        ->groupby('expanse_type_id')

            ->get();

        $data['payment_amount'] = DB::table('payments')
            ->where('status', 1)
            ->where('payment_type', 'PAYMENT')
            ->whereBetween('payment_date', [$fdate, $tdate])
            ->sum('amount');

        $data['receive_amount'] = DB::table('payments')
            ->where('status', 1)
            ->where('payment_type', 'RECEIVE')
            ->whereBetween('payment_date', [$fdate, $tdate])
            ->sum('amount');


       $purchaseamount = DB::table('purchase_ledgers')
            ->whereNotNull('purcahse_id')
            ->whereBetween('date', [$fdate, $tdate])
            ->sum('credit');

       $purchasereturnamount = DB::table('purchase_returns')
            ->whereBetween('date', [$fdate, $tdate])
            ->sum('total_amount');

      $data['purchase_amount']  = $purchaseamount -  $purchasereturnamount;

        $sales_amount = DB::table('sales')
            ->where('is_active', 1)
            ->whereBetween('date', [$fdate, $tdate])
            ->sum('grand_total');
        $sales_return = DB::table('sales_returns')
            ->where('is_active', 1)
            ->whereBetween('date', [$fdate, $tdate])
            ->sum('grand_total');

      $data['sales_amount'] = $sales_amount - $sales_return;


       // dd($data['sales_amount']);
        $data['journal_debit'] = DB::table('journal_entries')
            ->whereBetween('date', [$fdate, $tdate])
            ->sum('debit');
        $data['journal_credit'] = DB::table('journal_entries')
            ->whereBetween('date', [$fdate, $tdate])
            ->sum('credit');

        $data['general_purchase_amount'] = DB::table('general_purchases')
            ->whereBetween('date', [$fdate, $tdate])
            ->sum('total_value');

        $data['assets_amount'] = DB::table('assets')
            ->whereBetween('date', [$fdate, $tdate])
          ->where('intangible',0)->where('investment',0)
            ->sum('asset_value');

       $data['assets_type'] = DB::table('assets')->select('asset_types.asset_type_name', DB::raw('SUM(assets.asset_value) AS asset_value'))
         	->leftjoin('asset_types','asset_types.id', '=', 'assets.asset_type')
             ->whereBetween('date', [$fdate, $tdate])
          ->where('intangible',0)->where('investment',0)
        ->groupby('asset_type')
         ->get();


      $data['assets_investment'] = DB::table('assets')
            ->whereBetween('date', [$fdate, $tdate])
          ->where('intangible',0)->where('investment',1)
            ->sum('asset_value');
      $data['assets_intangible'] = DB::table('assets')
            ->whereBetween('date', [$fdate, $tdate])
          ->where('intangible',1)->where('investment',0)
            ->sum('asset_value');

       $data['asset_depreciations'] = DB::table('asset_depreciations')->select('asset_depreciations.*','asset_products.product_name','assets.asset_head')
          		->leftJoin('assets', 'assets.id', 'asset_depreciations.asset_id')
          		->leftJoin('asset_products', 'asset_products.id', 'asset_depreciations.asset_product_id')
            ->whereBetween('asset_depreciations.date', [$fdate, $tdate])
            ->get();
     // dd($data['asset_depreciations']);

       $data['equitiy'] = DB::table('equities')->select('equity_categories.name', DB::raw('SUM(equities.amount) AS amount'))
         	->leftjoin('equity_categories','equity_categories.id', '=', 'equities.equity_category')
            ->whereBetween('date', [$fdate, $tdate])
         ->groupby('equity_categories.id')
            ->get();



        $data['loan_amount'] = DB::table('master_banks')
         // ->where('loan_fdate', '<=', $fdate)
          ->where('loan_tdate', '>=', $tdate)

        	->sum('loan_amount');
       $data['bank_overderft'] = DB::table('master_banks')
         // ->where('loan_fdate', '<=', $fdate)
          ->where('loan_tdate', '<', $tdate)

        	->sum('loan_amount');

       $data['borrow_from'] = DB::table('borrows')
         // ->where('loan_fdate', '<=', $fdate)
          ->whereBetween('date', [$fdate, $tdate])
          ->where('type',"Short_Term")


        	->sum('amount');

        $data['non_borrow'] = DB::table('borrows')
         // ->where('loan_fdate', '<=', $fdate)
          ->whereBetween('date', [$fdate, $tdate])
          ->where('type',"Long_Term")


        	->sum('amount');


       $data['lease'] = DB::table('leases')
         // ->where('loan_fdate', '<=', $fdate)
          ->whereBetween('date', [$fdate, $tdate])



        	->sum('amount');

       $data['ltrs'] = DB::table('ltrs')
         // ->where('loan_fdate', '<=', $fdate)
          ->whereBetween('date', [$fdate, $tdate])
        ->sum('amount');

      $data['bad_debt_amount'] = DB::table('bad_debts')
            ->whereBetween('date', [$fdate, $tdate])
         	->sum('amount');



   // dd($data);






        $cogs = 0;

            $allp = SalesProduct::all();

            $startdate = '2020-01-01';
            $fdate2 =date('Y-m-d', strtotime('-1 day', strtotime($fdate)));

                    $inventory =0;

            foreach ($allp as $key => $product){

                $todaystock = \App\Models\SalesStockIn::where('prouct_id',$product->id)->whereBetween('date',[$fdate,$tdate])->sum('quantity');
                $openingstock = \App\Models\SalesStockIn::where('prouct_id',$product->id)->whereBetween('date',[$startdate,$fdate2])->sum('quantity');

                $sales = \App\Models\SalesLedger::where('product_id',$product->id)->whereBetween('ledger_date',[$fdate,$tdate])->sum('qty_pcs');
                $opsales = \App\Models\SalesLedger::where('product_id',$product->id)->whereBetween('ledger_date',[$startdate,$fdate2])->sum('qty_pcs');


               $returnp = DB::table('sales_returns')->join('sales_return_items', 'sales_return_items.id', '=', 'sales_return_items.return_id')->where('product_id',$product->id)->whereBetween('date',[$fdate,$tdate])->sum('qty');
                 $opreturnp =DB::table('sales_returns')->join('sales_return_items', 'sales_return_items.id', '=', 'sales_return_items.return_id')->where('product_id',$product->id)->whereBetween('date',[$startdate,$fdate2])->sum('qty');



                $transfer_from = \App\Models\Transfer::where('product_id',$product->id)->whereBetween('date',[$fdate,$tdate])->sum('qty');
                $optransfer_from = \App\Models\Transfer::where('product_id',$product->id)->whereBetween('date',[$startdate,$fdate2])->sum('qty');

                $transfer_to = \App\Models\Transfer::where('product_id',$product->id)->whereBetween('date',[$fdate,$tdate])->sum('qty');
                $optransfer_to = \App\Models\Transfer::where('product_id',$product->id)->whereBetween('date',[$startdate,$fdate2])->sum('qty');

                 $damage = \App\Models\SalesDamage::where('product_id',$product->id)->whereBetween('date',[$fdate,$tdate])->sum('quantity');
                $opdamage = \App\Models\SalesDamage::where('product_id',$product->id)->whereBetween('date',[$startdate,$fdate2])->sum('quantity');

                $product_name = \App\Models\SalesProduct::where('id',$product->id)->value('product_name');

                $productdetails = SalesProduct::where('id',$product->id)->first();

                $opblnce = ($productdetails->opening_balance+$openingstock+$optransfer_to)-($opsales+$optransfer_from+$opdamage);
                $clb = ($opblnce+$todaystock+$transfer_to)- ($sales+$transfer_from+$damage);

                $productrate = \App\Models\SalesStockIn::where('prouct_id',$product->id)->avg('production_rate');

              $openingbalance = $opblnce*$productrate;
              $clsingbalance =$clb*$productrate;
              $todaystock = $todaystock*$productrate;

           // dd($opsales);

                $productname = SalesProduct::where('id', $product->id)->value('product_name');


                  $dir_labordata=  DB::select('SELECT SUM(direct_labour_costs.total_cost) as dlcost FROM `direct_labour_costs`
                    WHERE  direct_labour_costs.fg_id ="'.$product->id.'" AND  direct_labour_costs.date BETWEEN "'.$startdate.'" and "'.$tdate.'"');

                $ind_labordate =   DB::select('SELECT SUM(indirect_costs.total_cost) as ilcost FROM `indirect_costs`
                WHERE  indirect_costs.fg_id ="'.$product->id.'" AND  indirect_costs.date BETWEEN "'.$startdate.'" and "'.$tdate.'"');


                $dir_labor =  $dir_labordata[0]->dlcost;
                $ind_labor =  $ind_labordate[0]->ilcost;


               $cogs += ($openingbalance + $todaystock - $clsingbalance)+($dir_labor+$ind_labor);

              $inventory += $clb*$productdetails->product_dp_price;


            }



            $data['cogs'] = $cogs;

            $data['inventory_sales'] = $inventory;

       $rmproduct = RowMaterialsProduct::all();

     // dd($data['inventory_sales']);

      $totalrmvalue = 0;

      foreach ($rmproduct as $key => $product){



        $opening_balanceppp = RowMaterialsProduct::where('id', $product->id)->value('opening_balance');

        $opening_balance  = DB::select('SELECT SUM(purchase_set_opening_balance.opening_balance) as opbalance FROM `purchase_set_opening_balance`
            where purchase_set_opening_balance.product_id="' . $product->id . '" and   purchase_set_opening_balance.date between "' . $fdate . '" and "' . $tdate . '" ');


        $pre_stocktotal = DB::select('SELECT SUM(purchases.inventory_receive) as srcv FROM `purchases`
            where purchases.product_id="' . $product->id . '" and  purchases.date between "' . $fdate . '" and "' . $tdate . '" ');

         $pre_return = $returns = DB::select('SELECT SUM(purchase_returns.return_quantity) as return_qty FROM `purchase_returns`
             WHERE purchase_returns.product_id="' . $product->id . '" and purchase_returns.date between "' . $fdate . '" and "' . $tdate . '"');

         $pre_transfer_to = DB::select('SELECT SUM(purchase_transfers.receive_qty) as transfers_qty FROM `purchase_transfers`
            WHERE purchase_transfers.product_id="' . $product->id . '"  and purchase_transfers.date BETWEEN "' . $fdate . '" and "' . $tdate . '"');

         $pre_transfer_from = DB::select('SELECT SUM(purchase_transfers.qty) as transfers_qty FROM `purchase_transfers`
            WHERE purchase_transfers.product_id="' . $product->id . '"  and purchase_transfers.date BETWEEN "' . $fdate . '" and "' . $tdate . '"');

        $pre_stock_out = DB::select('SELECT SUM(purchase_stockouts.stock_out_quantity) as stockout FROM `purchase_stockouts`
            WHERE purchase_stockouts.product_id ="' . $product->id . '" AND purchase_stockouts.date BETWEEN "' . $fdate . '" and "' . $tdate . '"');

        $totalstock =  $product->opening_balance+$opening_balance[0]->opbalance + $pre_stocktotal[0]->srcv - $pre_return[0]->return_qty + $pre_transfer_to[0]->transfers_qty - $pre_transfer_from[0]->transfers_qty - $pre_stock_out[0]->stockout;





        $avgrate = DB::select('SELECT AVG(purchases.purchase_rate) as rate FROM `purchases`
        WHERE purchases.product_id ="'.$product->id.'" and purchases.date between "'.$fdate.'" and "'.$tdate.'"');

      $totalstockval = $totalstock*$avgrate[0]->rate;
     // $clsingbalance =$clsingbalance*$avgrate[0]->rate;
    //  $todaypurchase = $todaypurchase*$avgrate[0]->rate;


        $totalrmvalue += $totalstockval;

      }

      $data['inventory_purchase'] = $totalrmvalue;





        $allincome =  DB::table('incomes')
          ->whereBetween('date', [$fdate, $tdate])->sum('amount');


        $allexpasne =  DB::table('payments')
                         ->where('payment_type', 'EXPANSE')
                        ->whereBetween('payment_date', [$fdate, $tdate])
                        ->where('status', 1)
                        ->sum('amount');

      $asset_depreciations = DB::table('asset_depreciations')
        ->whereBetween('asset_depreciations.date', [$fdate, $tdate])
            ->sum('yearly_amount');

      $totalamountwithtaxs =$data['sales_amount']-$cogs-$asset_depreciations+$allincome-$allexpasne;
     // dd($allincome);
     $data['taxtamount'] = ($totalamountwithtaxs/100)*($taxes);











    //  dd($data);




        return view('backend.account.financial_report', compact('fdate', 'tdate', 'data','taxes'));
    }






   public function newtotalcashflowIndex()
    {

    $areas = DealerArea::All();

        return view('backend.account.total_cash_flow_input_new', compact('areas'));
    }


    public function newtotalcashflowReport(Request $request)
    {
      //dd($request->all());



        $tdate = $request->date;
      $year = date('Y', strtotime($tdate));
      $fdate = $year."-01-01";









        //  if (isset($request->date)) {
        //     $dates = explode(' - ', $request->date);
        //     $fdate = date('Y-m-d', strtotime($dates[0]));
        //     $tdate = date('Y-m-d', strtotime($dates[1]));
        // }





        $data = [];


         $sales_amount = DB::table('sales')
            ->where('is_active', 1)
            ->whereBetween('date', [$fdate, $tdate])
            ->sum('grand_total');

         $sales_return = DB::table('sales_returns')
            ->where('is_active', 1)
            ->whereBetween('date', [$fdate, $tdate])
            ->sum('grand_total');


        $data['sales'] = $sales_amount- $sales_return;

        $data['receive_amount'] = DB::table('payments')
            ->where('status', 1)
            ->where('payment_type', 'RECEIVE')
            ->whereBetween('payment_date', [$fdate, $tdate])
            ->sum('amount');

       $data['payment_amount'] = DB::table('payments')
            ->where('status', 1)
            ->where('payment_type', 'PAYMENT')
            ->whereBetween('payment_date', [$fdate, $tdate])
            ->sum('amount');


       $purchaseamount = DB::table('purchase_ledgers')
            ->whereNotNull('purcahse_id')
            ->whereBetween('date', [$fdate, $tdate])
            ->sum('credit');

       $purchasereturnamount = DB::table('purchase_returns')
            ->whereBetween('date', [$fdate, $tdate])
            ->sum('total_amount');

      $data['purchase_amount']  = $purchaseamount -  $purchasereturnamount;



       $data['journal_debit'] = DB::table('journal_entries')
            ->whereBetween('date', [$fdate, $tdate])
            ->sum('debit');
        $data['journal_credit'] = DB::table('journal_entries')
            ->whereBetween('date', [$fdate, $tdate])
            ->sum('credit');

        $data['general_purchase_amount'] = DB::table('general_purchases')
            ->whereBetween('date', [$fdate, $tdate])
            ->sum('total_value');
        $data['assets_amount'] = DB::table('assets')
            ->whereBetween('date', [$fdate, $tdate])
          ->where('intangible',0)->where('investment',0)
            ->sum('asset_value');

      $data['assets_investment'] = DB::table('assets')
            ->whereBetween('date', [$fdate, $tdate])
          ->where('intangible',0)->where('investment',1)
            ->sum('asset_value');
      $data['assets_intangible'] = DB::table('assets')
            ->whereBetween('date', [$fdate, $tdate])
          ->where('intangible',1)->where('investment',0)
            ->sum('asset_value');



      $data['expanse_amount'] = DB::table('payments')
            ->where('payment_type', 'EXPANSE')
        ->where('status', 1)
            ->whereBetween('payment_date', [$fdate, $tdate])
            ->sum('amount');



       $data['equitiy'] = DB::table('equities')->whereBetween('date', [$fdate, $tdate])
         ->sum('amount');

        $data['loan_amount'] = DB::table('master_banks')
         // ->where('loan_fdate', '<=', $fdate)
         //->where('loan_tdate', '>=', $tdate)
          ->whereBetween('loan_tdate', [$fdate, $tdate])

        	->sum('loan_amount');
       $data['bank_overderft'] = DB::table('master_banks')
         // ->where('loan_fdate', '<=', $fdate)
        //  ->where('loan_tdate', '<', $tdate)
          ->whereBetween('loan_tdate', [$fdate, $tdate])


        	->sum('loan_amount');

       $data['borrow_from'] = DB::table('borrows')
         // ->where('loan_fdate', '<=', $fdate)
          ->whereBetween('date', [$fdate, $tdate])
          ->where('type',"Short_Term")


        	->sum('amount');

        $data['non_borrow'] = DB::table('borrows')
         // ->where('loan_fdate', '<=', $fdate)
          ->whereBetween('date', [$fdate, $tdate])
          ->where('type',"Long_Term")


        	->sum('amount');


       $data['lease'] = DB::table('leases')
         // ->where('loan_fdate', '<=', $fdate)
          ->whereBetween('date', [$fdate, $tdate])



        	->sum('amount');

      $data['bad_debt_amount'] = DB::table('bad_debts')
            ->whereBetween('date', [$fdate, $tdate])
         	->sum('amount');



      $data['asset_depreciations'] = DB::table('asset_depreciations')->whereBetween('asset_depreciations.date', [$fdate, $tdate])
            ->sum("yearly_amount");

    /*  $data['asset_depreciations'] = DB::table('asset_depreciations')->select('asset_depreciations.*','asset_products.product_name','assets.asset_head')
          		->leftJoin('assets', 'assets.id', 'asset_depreciations.asset_id')
          		->leftJoin('asset_products', 'asset_products.id', 'asset_depreciations.asset_product_id')
            ->whereBetween('asset_depreciations.date', [$fdate, $tdate])
            ->get();  */


        $purchase_stockouts = DB::table('purchase_stockouts')
            ->whereBetween('date', [$fdate, $tdate])
            ->sum('total_amount');

      $direct_labour_costs = DB::table('direct_labour_costs')
            ->whereBetween('date', [$fdate, $tdate])
            ->sum('total_cost');
      $manufacturing_costs = DB::table('manufacturing_costs')
            ->whereBetween('date', [$fdate, $tdate])
            ->sum('total_cost');

	$data['manufacturing_costs']  =$manufacturing_costs;



        $cogs = 0;
      $opinventory = 0;
      $inventory = 0;

            $allp = SalesProduct::all();

            $startdate = '2020-01-01';
            $fdate2 =date('Y-m-d', strtotime('-1 day', strtotime($fdate)));

            foreach ($allp as $key => $product) {

              $stockdata = DB::table('sales_stock_ins')->select(
                 DB::raw('sum(CASE WHEN date BETWEEN  "'.$fdate.'" AND  "'.$tdate.'" THEN `quantity` ELSE null END) as todaystock'),
                 DB::raw('sum(CASE WHEN date BETWEEN  "'.$startdate.'" AND  "'.$fdate2.'" THEN `quantity` ELSE null END) as openingstock')
              )->where('prouct_id',$product->id)->first();

                $todaystock = $stockdata->todaystock;
                $openingstock = $stockdata->openingstock;

               // $todaystock = \App\Models\SalesStockIn::where('prouct_id',$product->id)->whereBetween('date',[$fdate,$tdate])->sum('quantity');
               // $openingstock = \App\Models\SalesStockIn::where('prouct_id',$product->id)->whereBetween('date',[$startdate,$fdate2])->sum('quantity');

                $salesdata = DB::table('sales_ledgers')->select(
                 DB::raw('sum(CASE WHEN ledger_date BETWEEN  "'.$fdate.'" AND  "'.$tdate.'" THEN `qty_pcs` ELSE null END) as sales'),
                 DB::raw('sum(CASE WHEN ledger_date BETWEEN  "'.$startdate.'" AND  "'.$fdate2.'" THEN `qty_pcs` ELSE null END) as opsales')
              )->where('product_id',$product->id)->first();
            // dd($salesdata);
                $sales = $salesdata->sales;
                $opsales = $salesdata->opsales;

            //    $sales = \App\Models\SalesLedger::where('product_id',$product->id)->whereBetween('ledger_date',[$fdate,$tdate])->sum('qty_pcs');
            //    $opsales = \App\Models\SalesLedger::where('product_id',$product->id)->whereBetween('ledger_date',[$startdate,$fdate2])->sum('qty_pcs');



                $returdata = DB::table('sales_returns')->select(
                 DB::raw('sum(CASE WHEN date BETWEEN  "'.$fdate.'" AND  "'.$tdate.'" THEN `qty` ELSE null END) as returnp'),
                 DB::raw('sum(CASE WHEN date BETWEEN  "'.$startdate.'" AND  "'.$fdate2.'" THEN `qty` ELSE null END) as opreturnp')
              )->join('sales_return_items', 'sales_return_items.id', '=', 'sales_return_items.return_id')->where('product_id',$product->id)->first();

                $returnp = $returdata->returnp;
                $opreturnp = $returdata->opreturnp;

             //  $returnp = DB::table('sales_returns')->join('sales_return_items', 'sales_return_items.id', '=', 'sales_return_items.return_id')->where('product_id',$product->id)->whereBetween('date',[$fdate,$tdate])->sum('qty');
             //   $opreturnp =DB::table('sales_returns')->join('sales_return_items', 'sales_return_items.id', '=', 'sales_return_items.return_id')->where('product_id',$product->id)->whereBetween('date',[$startdate,$fdate2])->sum('qty');


                $transferdata = DB::table('transfers')->select(
                 DB::raw('sum(CASE WHEN date BETWEEN  "'.$fdate.'" AND  "'.$tdate.'" THEN `qty` ELSE null END) as transfer_from'),
                 DB::raw('sum(CASE WHEN date BETWEEN  "'.$startdate.'" AND  "'.$fdate2.'" THEN `qty` ELSE null END) as optransfer_from')
              )->where('product_id',$product->id)->first();

                $transfer_from = $transferdata->transfer_from;
                $optransfer_from = $transferdata->optransfer_from;


             //   $transfer_from = \App\Models\Transfer::where('product_id',$product->id)->whereBetween('date',[$fdate,$tdate])->sum('qty');
             //   $optransfer_from = \App\Models\Transfer::where('product_id',$product->id)->whereBetween('date',[$startdate,$fdate2])->sum('qty');

                $transfer_to = 0;
                $optransfer_to = 0;

               $damagedata = DB::table('sales_damages')->select(
                 DB::raw('sum(CASE WHEN date BETWEEN  "'.$fdate.'" AND  "'.$tdate.'" THEN `quantity` ELSE null END) as damage'),
                 DB::raw('sum(CASE WHEN date BETWEEN  "'.$startdate.'" AND  "'.$fdate2.'" THEN `quantity` ELSE null END) as opdamage')
              )->where('product_id',$product->id)->first();

                $damage = $damagedata->damage;
                $opdamage = $damagedata->opdamage;

                //  $damage = \App\Models\SalesDamage::where('product_id',$product->id)->whereBetween('date',[$fdate,$tdate])->sum('quantity');
              //  $opdamage = \App\Models\SalesDamage::where('product_id',$product->id)->whereBetween('date',[$startdate,$fdate2])->sum('quantity');

                $product_name = \App\Models\SalesProduct::where('id',$product->id)->value('product_name');

                $productdetails = SalesProduct::where('id',$product->id)->first();

                $opblnce = ($productdetails->opening_balance+$openingstock+$optransfer_to)-($opsales+$optransfer_from+$opdamage);
                $clb = ($opblnce+$todaystock+$transfer_to)- ($sales+$transfer_from+$damage);

                $productrate = \App\Models\SalesStockIn::where('prouct_id',$product->id)->avg('production_rate');

              $openingbalance = $opblnce*$productrate;
              $clsingbalance =$clb*$productrate;
              $todaystock = $todaystock*$productrate;

           // dd($opsales);

                $productname = SalesProduct::where('id', $product->id)->value('product_name');


                  $dir_labordata=  DB::select('SELECT SUM(direct_labour_costs.total_cost) as dlcost FROM `direct_labour_costs`
                    WHERE  direct_labour_costs.fg_id ="'.$product->id.'" AND  direct_labour_costs.date BETWEEN "'.$startdate.'" and "'.$tdate.'"');

                $ind_labordate =   DB::select('SELECT SUM(indirect_costs.total_cost) as ilcost FROM `indirect_costs`
                WHERE  indirect_costs.fg_id ="'.$product->id.'" AND  indirect_costs.date BETWEEN "'.$startdate.'" and "'.$tdate.'"');


                $dir_labor =  $dir_labordata[0]->dlcost;
                $ind_labor =  $ind_labordate[0]->ilcost;


               $cogs += ($openingbalance + $todaystock - $clsingbalance)+($dir_labor+$ind_labor);

              $opinventory += $opblnce*$productrate;
              $inventory += $clb*$productrate;


            }

//dd($data);

            $data['cogs'] = $cogs;

            $data['opening_inventory_sales'] = $opinventory;
            $data['inventory_sales'] = $inventory;


       $rmproduct = RowMaterialsProduct::all();

     // dd($data);

      $totalrmvalue = 0;
      foreach ($rmproduct as $key => $product){



        $opening_balanceppp = RowMaterialsProduct::where('id', $product->id)->value('opening_balance');

        $opening_balance  = DB::select('SELECT SUM(purchase_set_opening_balance.opening_balance) as opbalance FROM `purchase_set_opening_balance`
            where purchase_set_opening_balance.product_id="' . $product->id . '" and   purchase_set_opening_balance.date between "' . $fdate . '" and "' . $tdate . '" ');


        $pre_stocktotal = DB::select('SELECT SUM(purchases.inventory_receive) as srcv FROM `purchases`
            where purchases.product_id="' . $product->id . '" and  purchases.date between "' . $fdate . '" and "' . $tdate . '" ');

         $pre_return = $returns = DB::select('SELECT SUM(purchase_returns.return_quantity) as return_qty FROM `purchase_returns`
             WHERE purchase_returns.product_id="' . $product->id . '" and purchase_returns.date between "' . $fdate . '" and "' . $tdate . '"');

         $pre_transfer_to = DB::select('SELECT SUM(purchase_transfers.receive_qty) as transfers_qty FROM `purchase_transfers`
            WHERE purchase_transfers.product_id="' . $product->id . '"  and purchase_transfers.date BETWEEN "' . $fdate . '" and "' . $tdate . '"');

         $pre_transfer_from = DB::select('SELECT SUM(purchase_transfers.qty) as transfers_qty FROM `purchase_transfers`
            WHERE purchase_transfers.product_id="' . $product->id . '"  and purchase_transfers.date BETWEEN "' . $fdate . '" and "' . $tdate . '"');

        $pre_stock_out = DB::select('SELECT SUM(purchase_stockouts.stock_out_quantity) as stockout FROM `purchase_stockouts`
            WHERE purchase_stockouts.product_id ="' . $product->id . '" AND purchase_stockouts.date BETWEEN "' . $fdate . '" and "' . $tdate . '"');

        $totalstock =  $product->opening_balance+$opening_balance[0]->opbalance + $pre_stocktotal[0]->srcv - $pre_return[0]->return_qty + $pre_transfer_to[0]->transfers_qty - $pre_transfer_from[0]->transfers_qty - $pre_stock_out[0]->stockout;





        $avgrate = DB::select('SELECT AVG(purchases.purchase_rate) as rate FROM `purchases`
        WHERE purchases.product_id ="'.$product->id.'" and purchases.date between "'.$fdate.'" and "'.$tdate.'"');

      $totalstockval = $totalstock*$avgrate[0]->rate;
     // $clsingbalance =$clsingbalance*$avgrate[0]->rate;
    //  $todaypurchase = $todaypurchase*$avgrate[0]->rate;


        $totalrmvalue += $totalstockval;

      }

      $data['inventory_purchase'] = $totalrmvalue;

      //dd($data);


        $allincome = $request->income_head;
        $alleincomeamount = $request->income_amount;


        $allincome =  DB::table('incomes')->select([
                              DB::raw("SUM(amount) incomeamount"),
        					'income_sources.name','incomes.income_source_id'
                           ])
      			->leftjoin('income_sources','income_sources.id', '=', 'incomes.income_source_id')
          ->whereBetween('date', [$fdate, $tdate])
          		->groupby('income_source_id')->get();


        $data['allexpasne'] =  DB::table('payments')->where('payment_type', 'EXPANSE')
                        ->whereBetween('payment_date', [$fdate, $tdate])
         				 ->where('status', 1)
                        ->sum("amount");

       $data['dividend'] =  DB::table('payments')->where('payment_type', 'PAYMENT')->where('others_payment_type', 'dividend')
                        ->whereBetween('payment_date', [$fdate, $tdate])
         				 ->where('status', 1)
                        ->sum("amount");
      $data['tax_payment_amount'] =  DB::table('payments')->where('payment_type', 'PAYMENT')->where('others_payment_type', 'tax')
                        ->whereBetween('payment_date', [$fdate, $tdate])
         				 ->where('status', 1)
                        ->sum("amount");



      $data['tax'] =  DB::table('taxes')
                        ->where('year', $year)
         				->value("tax");

         $data['assets_type'] = DB::table('assets')->select('asset_types.asset_type_name', DB::raw('SUM(assets.asset_value) AS asset_value'))
         	->leftjoin('asset_types','asset_types.id', '=', 'assets.asset_type')
             ->whereBetween('date', [$fdate, $tdate])
          ->where('intangible',0)->where('investment',0)
        ->groupby('asset_type')
         ->get();
       $data['expanse_type'] = DB::table('payments')->select('expanse_types.title', DB::raw('SUM(payments.amount) AS amount'))
         	->leftjoin('expanse_types','expanse_types.id', '=', 'payments.expanse_type_id')
             ->where('payment_type', 'EXPANSE')
        ->where('status', 1)
        ->whereNotNull('expanse_type_id')
            ->whereBetween('payment_date', [$fdate, $tdate])
        ->groupby('expanse_type_id')

            ->get();



     // dd($data);

        //For Pre Year



       $preyear = $year-1;
      $prefdate = $preyear."-01-01";
      $pretdate = $preyear."-12-31";

        $predata = [];


         $sales_amount = DB::table('sales')
            ->where('is_active', 1)
            ->whereBetween('date', [$prefdate, $pretdate])
            ->sum('grand_total');
         $sales_return = DB::table('sales_returns')
            ->where('is_active', 1)
            ->whereBetween('date', [$prefdate, $pretdate])
            ->sum('grand_total');

        $predata['sales'] = $sales_amount- $sales_return;

        $predata['receive_amount'] = DB::table('payments')
            ->where('status', 1)
            ->where('payment_type', 'RECEIVE')
            ->whereBetween('payment_date', [$prefdate, $pretdate])
            ->sum('amount');

       $predata['payment_amount'] = DB::table('payments')
            ->where('status', 1)
            ->where('payment_type', 'PAYMENT')
            ->whereBetween('payment_date', [$prefdate, $pretdate])
            ->sum('amount');


       $purchaseamount = DB::table('purchase_ledgers')
            ->whereNotNull('purcahse_id')
            ->whereBetween('date', [$prefdate, $pretdate])
            ->sum('credit');

       $purchasereturnamount = DB::table('purchase_returns')
            ->whereBetween('date', [$prefdate, $pretdate])
            ->sum('total_amount');

      $predata['purchase_amount']  = $purchaseamount -  $purchasereturnamount;



       $predata['journal_debit'] = DB::table('journal_entries')
            ->whereBetween('date', [$prefdate, $pretdate])
            ->sum('debit');
        $predata['journal_credit'] = DB::table('journal_entries')
            ->whereBetween('date', [$prefdate, $pretdate])
            ->sum('credit');

        $predata['general_purchase_amount'] = DB::table('general_purchases')
            ->whereBetween('date', [$prefdate, $pretdate])
            ->sum('total_value');
        $predata['assets_amount'] = DB::table('assets')
            ->whereBetween('date', [$prefdate, $pretdate])
          ->where('intangible',0)->where('investment',0)
            ->sum('asset_value');

      $predata['assets_investment'] = DB::table('assets')
            ->whereBetween('date', [$prefdate, $pretdate])
          ->where('intangible',0)->where('investment',1)
            ->sum('asset_value');
      $predata['assets_intangible'] = DB::table('assets')
            ->whereBetween('date', [$prefdate, $pretdate])
          ->where('intangible',1)->where('investment',0)
            ->sum('asset_value');



      $predata['expanse_amount'] = DB::table('payments')
            ->where('payment_type', 'EXPANSE')
        ->where('status', 1)
            ->whereBetween('payment_date', [$prefdate, $pretdate])
            ->sum('amount');

       $predata['equitiy'] = DB::table('equities')->whereBetween('date', [$prefdate, $pretdate])
         ->sum('amount');

        $predata['loan_amount'] = DB::table('master_banks')
         // ->where('loan_fdate', '<=', $fdate)
         // ->where('loan_tdate', '>=', $pretdate)
          ->whereBetween('loan_tdate', [$prefdate, $pretdate])


        	->sum('loan_amount');
       $predata['bank_overderft'] = DB::table('master_banks')
         // ->where('loan_fdate', '<=', $fdate)
          //->where('loan_tdate', '<', $pretdate)
          ->whereBetween('loan_tdate', [$prefdate, $pretdate])

        	->sum('loan_amount');

       $predata['borrow_from'] = DB::table('borrows')
         // ->where('loan_fdate', '<=', $fdate)
          ->whereBetween('date', [$prefdate, $pretdate])
          ->where('type',"Short_Term")


        	->sum('amount');

        $predata['non_borrow'] = DB::table('borrows')
         // ->where('loan_fdate', '<=', $fdate)
          ->whereBetween('date', [$prefdate, $pretdate])
          ->where('type',"Long_Term")


        	->sum('amount');


       $predata['lease'] = DB::table('leases')
         // ->where('loan_fdate', '<=', $fdate)
          ->whereBetween('date', [$prefdate, $pretdate])



        	->sum('amount');

      $predata['bad_debt_amount'] = DB::table('bad_debts')
            ->whereBetween('date', [$prefdate, $pretdate])
         	->sum('amount');



      $predata['asset_depreciations'] = DB::table('asset_depreciations')->whereBetween('asset_depreciations.date', [$prefdate, $pretdate])
            ->sum("yearly_amount");


       $cogs = 0;
      $opinventory = 0;
      $inventory = 0;

            $allp = SalesProduct::all();

            $prestartdate = '2020-01-01';
            $prefdate2 =date('Y-m-d', strtotime('-1 day', strtotime($prefdate)));

            foreach ($allp as $key => $product) {

              $stockdata = DB::table('sales_stock_ins')->select(
                 DB::raw('sum(CASE WHEN date BETWEEN  "'.$prefdate.'" AND  "'.$prefdate.'" THEN `quantity` ELSE null END) as todaystock'),
                 DB::raw('sum(CASE WHEN date BETWEEN  "'.$prestartdate.'" AND  "'.$prefdate2.'" THEN `quantity` ELSE null END) as openingstock')
              )->where('prouct_id',$product->id)->first();

                $todaystock = $stockdata->todaystock;
                $openingstock = $stockdata->openingstock;

               // $todaystock = \App\Models\SalesStockIn::where('prouct_id',$product->id)->whereBetween('date',[$prefdate,$prefdate])->sum('quantity');
               // $openingstock = \App\Models\SalesStockIn::where('prouct_id',$product->id)->whereBetween('date',[$prestartdate,$prefdate2])->sum('quantity');

                $salesdata = DB::table('sales_ledgers')->select(
                 DB::raw('sum(CASE WHEN ledger_date BETWEEN  "'.$prefdate.'" AND  "'.$prefdate.'" THEN `qty_pcs` ELSE null END) as sales'),
                 DB::raw('sum(CASE WHEN ledger_date BETWEEN  "'.$prestartdate.'" AND  "'.$prefdate2.'" THEN `qty_pcs` ELSE null END) as opsales')
              )->where('product_id',$product->id)->first();
            // dd($salesdata);
                $sales = $salesdata->sales;
                $opsales = $salesdata->opsales;

            //    $sales = \App\Models\SalesLedger::where('product_id',$product->id)->whereBetween('ledger_date',[$prefdate,$prefdate])->sum('qty_pcs');
            //    $opsales = \App\Models\SalesLedger::where('product_id',$product->id)->whereBetween('ledger_date',[$prestartdate,$prefdate2])->sum('qty_pcs');



                $returdata = DB::table('sales_returns')->select(
                 DB::raw('sum(CASE WHEN date BETWEEN  "'.$prefdate.'" AND  "'.$prefdate.'" THEN `qty` ELSE null END) as returnp'),
                 DB::raw('sum(CASE WHEN date BETWEEN  "'.$prestartdate.'" AND  "'.$prefdate2.'" THEN `qty` ELSE null END) as opreturnp')
              )->join('sales_return_items', 'sales_return_items.id', '=', 'sales_return_items.return_id')->where('product_id',$product->id)->first();

                $returnp = $returdata->returnp;
                $opreturnp = $returdata->opreturnp;

             //  $returnp = DB::table('sales_returns')->join('sales_return_items', 'sales_return_items.id', '=', 'sales_return_items.return_id')->where('product_id',$product->id)->whereBetween('date',[$prefdate,$prefdate])->sum('qty');
             //   $opreturnp =DB::table('sales_returns')->join('sales_return_items', 'sales_return_items.id', '=', 'sales_return_items.return_id')->where('product_id',$product->id)->whereBetween('date',[$prestartdate,$prefdate2])->sum('qty');


                $transferdata = DB::table('transfers')->select(
                 DB::raw('sum(CASE WHEN date BETWEEN  "'.$prefdate.'" AND  "'.$prefdate.'" THEN `qty` ELSE null END) as transfer_from'),
                 DB::raw('sum(CASE WHEN date BETWEEN  "'.$prestartdate.'" AND  "'.$prefdate2.'" THEN `qty` ELSE null END) as optransfer_from')
              )->where('product_id',$product->id)->first();

                $transfer_from = $transferdata->transfer_from;
                $optransfer_from = $transferdata->optransfer_from;


             //   $transfer_from = \App\Models\Transfer::where('product_id',$product->id)->whereBetween('date',[$prefdate,$prefdate])->sum('qty');
             //   $optransfer_from = \App\Models\Transfer::where('product_id',$product->id)->whereBetween('date',[$prestartdate,$prefdate2])->sum('qty');

                $transfer_to = 0;
                $optransfer_to = 0;

               $damagedata = DB::table('sales_damages')->select(
                 DB::raw('sum(CASE WHEN date BETWEEN  "'.$prefdate.'" AND  "'.$prefdate.'" THEN `quantity` ELSE null END) as damage'),
                 DB::raw('sum(CASE WHEN date BETWEEN  "'.$prestartdate.'" AND  "'.$prefdate2.'" THEN `quantity` ELSE null END) as opdamage')
              )->where('product_id',$product->id)->first();

                $damage = $damagedata->damage;
                $opdamage = $damagedata->opdamage;

                //  $damage = \App\Models\SalesDamage::where('product_id',$product->id)->whereBetween('date',[$prefdate,$prefdate])->sum('quantity');
              //  $opdamage = \App\Models\SalesDamage::where('product_id',$product->id)->whereBetween('date',[$startdate,$fdate2])->sum('quantity');
                $product_name = \App\Models\SalesProduct::where('id',$product->id)->value('product_name');

                $productdetails = SalesProduct::where('id',$product->id)->first();

                $opblnce = ($productdetails->opening_balance+$openingstock+$optransfer_to)-($opsales+$optransfer_from+$opdamage);
                $clb = ($opblnce+$todaystock+$transfer_to)- ($sales+$transfer_from+$damage);

                $productrate = \App\Models\SalesStockIn::where('prouct_id',$product->id)->avg('production_rate');

              $openingbalance = $opblnce*$productrate;
              $clsingbalance =$clb*$productrate;
              $todaystock = $todaystock*$productrate;

           // dd($opsales);

                $productname = SalesProduct::where('id', $product->id)->value('product_name');


                  $dir_labordata=  DB::select('SELECT SUM(direct_labour_costs.total_cost) as dlcost FROM `direct_labour_costs`
                    WHERE  direct_labour_costs.fg_id ="'.$product->id.'" AND  direct_labour_costs.date BETWEEN "'.$prestartdate.'" and "'.$pretdate.'"');

                $ind_labordate =   DB::select('SELECT SUM(indirect_costs.total_cost) as ilcost FROM `indirect_costs`
                WHERE  indirect_costs.fg_id ="'.$product->id.'" AND  indirect_costs.date BETWEEN "'.$prestartdate.'" and "'.$pretdate.'"');


                $dir_labor =  $dir_labordata[0]->dlcost;
                $ind_labor =  $ind_labordate[0]->ilcost;


               $cogs += ($openingbalance + $todaystock - $clsingbalance)+($dir_labor+$ind_labor);

              $opinventory += $opblnce*$productrate;
              $inventory += $clb*$productrate;


            }



            $predata['cogs'] = $cogs;

            $predata['opening_inventory_sales'] = $opinventory;
            $predata['inventory_sales'] = $inventory;


       $rmproduct = RowMaterialsProduct::all();

     // dd($data);

      $totalrmvalue = 0;
      foreach ($rmproduct as $key => $product){



        $opening_balanceppp = RowMaterialsProduct::where('id', $product->id)->value('opening_balance');

        $opening_balance  = DB::select('SELECT SUM(purchase_set_opening_balance.opening_balance) as opbalance FROM `purchase_set_opening_balance`
            where purchase_set_opening_balance.product_id="' . $product->id . '" and   purchase_set_opening_balance.date between "' . $prefdate . '" and "' . $pretdate . '" ');


        $pre_stocktotal = DB::select('SELECT SUM(purchases.inventory_receive) as srcv FROM `purchases`
            where purchases.product_id="' . $product->id . '" and  purchases.date between "' . $prefdate . '" and "' . $pretdate . '" ');

         $pre_return = $returns = DB::select('SELECT SUM(purchase_returns.return_quantity) as return_qty FROM `purchase_returns`
             WHERE purchase_returns.product_id="' . $product->id . '" and purchase_returns.date between "' . $prefdate . '" and "' . $pretdate . '"');

         $pre_transfer_to = DB::select('SELECT SUM(purchase_transfers.receive_qty) as transfers_qty FROM `purchase_transfers`
            WHERE purchase_transfers.product_id="' . $product->id . '"  and purchase_transfers.date BETWEEN "' . $prefdate . '" and "' . $pretdate . '"');

         $pre_transfer_from = DB::select('SELECT SUM(purchase_transfers.qty) as transfers_qty FROM `purchase_transfers`
            WHERE purchase_transfers.product_id="' . $product->id . '"  and purchase_transfers.date BETWEEN "' . $prefdate . '" and "' . $pretdate . '"');

        $pre_stock_out = DB::select('SELECT SUM(purchase_stockouts.stock_out_quantity) as stockout FROM `purchase_stockouts`
            WHERE purchase_stockouts.product_id ="' . $product->id . '" AND purchase_stockouts.date BETWEEN "' . $prefdate . '" and "' . $pretdate . '"');

        $totalstock =  $product->opening_balance+$opening_balance[0]->opbalance + $pre_stocktotal[0]->srcv - $pre_return[0]->return_qty + $pre_transfer_to[0]->transfers_qty - $pre_transfer_from[0]->transfers_qty - $pre_stock_out[0]->stockout;





        $avgrate = DB::select('SELECT AVG(purchases.purchase_rate) as rate FROM `purchases`
        WHERE purchases.product_id ="'.$product->id.'" and purchases.date between "'.$prefdate.'" and "'.$pretdate.'"');

      $totalstockval = $totalstock*$avgrate[0]->rate;
     // $clsingbalance =$clsingbalance*$avgrate[0]->rate;
    //  $todaypurchase = $todaypurchase*$avgrate[0]->rate;


        $totalrmvalue += $totalstockval;

      }

      $predata['inventory_purchase'] = $totalrmvalue;

    //  dd($data);


        $allincome = $request->income_head;
        $alleincomeamount = $request->income_amount;


       $predata['allincome']  =  DB::table('incomes')->select([
                              DB::raw("SUM(amount) incomeamount"),
        					'income_sources.name','incomes.income_source_id'
                           ])
      			->leftjoin('income_sources','income_sources.id', '=', 'incomes.income_source_id')
          ->whereBetween('date', [$prefdate, $pretdate])
          		->groupby('income_source_id')->get();


        $predata['allexpasne'] =  DB::table('payments')->where('payment_type', 'EXPANSE')
                        ->whereBetween('payment_date', [$prefdate, $pretdate])
         				 ->where('status', 1)
                        ->sum("amount");

       $predata['dividend'] =  DB::table('payments')->where('payment_type', 'PAYMENT')->where('others_payment_type', 'dividend')
                        ->whereBetween('payment_date', [$prefdate, $pretdate])
         				 ->where('status', 1)
                        ->sum("amount");
      $predata['tax_payment_amount'] =  DB::table('payments')->where('payment_type', 'PAYMENT')->where('others_payment_type', 'tax')
                        ->whereBetween('payment_date', [$prefdate, $pretdate])
         				 ->where('status', 1)
                        ->sum("amount");



      $predata['tax'] =  DB::table('taxes')
                        ->where('year', $preyear)
         				->value("tax");








     //  dd($predata);


        return view('backend.account.total_cash_flow_report_new', compact('fdate', 'tdate', 'data','predata','year'));
    }
public function plAnalyticalReportIndex(){
   	return view('backend.account.pl_analytical_report_input');
    }

  	public function plAnalyticalReportView(Request $request){

      if (isset($request->date)) {
             $dates = explode(' - ', $request->date);
             $fdate = date('Y-m-d', strtotime($dates[0]));
             $tdate = date('Y-m-d', strtotime($dates[1]));
            $year = date('Y', strtotime($tdate));
         }

        $data = [];
     /* if($request->type == 1){

      	$rmproduct = RowMaterialsProduct::where('category_id',31)->orderBy('product_name', 'ASC')->get();

		$cogs = 0;
      	$totalStockoutRaw = 0;
        foreach ($rmproduct as $key => $data){
        $stockraw = DB::table('purchase_stockouts')->where('product_id',$data->id)->whereBetween('date',[$fdate,$tdate])->sum('total_amount');
        $totalStockoutRaw += $stockraw;
        }
        $cogsRaw = $totalStockoutRaw;

        $mediProduct = RowMaterialsProduct::where('category_id',32)->orderBy('product_name', 'ASC')->get();
      	$totalStockoutMedi = 0;

      foreach ($mediProduct as $key => $data){
       $stockmedi = DB::table('purchase_stockouts')->where('product_id',$data->id)->whereBetween('date',[$fdate,$tdate])->sum('total_amount');
       $totalStockoutMedi += $stockmedi;
      }
        $cogsRawM = $totalStockoutMedi;
    	$cogs =  $cogsRaw + $cogsRawM;
     } */
      $cogs = 0;
      $rmproduct = RowMaterialsProduct::orderBy('product_name', 'ASC')->get();
       foreach ($rmproduct as $key => $data){
       $cogs += DB::table('purchase_stockouts')->where('product_id',$data->id)->whereBetween('date',[$fdate,$tdate])->sum('total_amount');
      }

      //dd($cogsRawM);

     /*
      if($request->type == 2) {
      $rmproduct = RowMaterialsProduct::where('category_id',31)->orderBy('product_name', 'ASC')->get();
		$cogs = 0;
       $totalStockoutRaw = 0;
	   $sdate = '2022-12-30';
      foreach ($rmproduct as $key => $data){

       $stockraw = DB::table('purchase_stockouts')->where('product_id',$data->id)->whereBetween('date',[$fdate,$tdate])->sum('stock_out_quantity');

       $dataRate = DB::table('purchases')->select('bill_quantity','purchase_value')->where('product_id', $data->id)->whereBetween('date',[$sdate,$tdate])->get();

                                $valueTemp = 0;
                                $valueQty = 0;
                                $rate = 0;
                                foreach($dataRate as $key => $val){
                                  $valueTemp += $val->purchase_value;
                                  $valueQty += $val->bill_quantity;
                                }
                                if($valueTemp > 0 && $valueQty > 0){
                                  $rate = $valueTemp/$valueQty;
                                  $rate = round($rate,2);
                                } else {
                                $rate = 0;
                              }
            $totalStockoutRaw += round($stockraw*$rate,2);
    }

      $cogsRaw = $totalStockoutRaw;


    $mediProduct = RowMaterialsProduct::where('category_id',32)->orderBy('product_name', 'ASC')->get();

      $totalStockoutMedi = 0;

      foreach ($mediProduct as $key => $data){

       $stockmedi = DB::table('purchase_stockouts')->where('product_id',$data->id)->whereBetween('date',[$fdate,$tdate])->sum('stock_out_quantity');

       $dataRate = DB::table('purchases')->select('bill_quantity','purchase_value')->where('product_id', $data->id)->whereBetween('date',[$sdate,$tdate])->get();

                                $valueTemp = 0;
                                $valueQty = 0;
                                $rate = 0;
                                foreach($dataRate as $key => $val){
                                  $valueTemp += $val->purchase_value;
                                  $valueQty += $val->bill_quantity;
                                }
                                if($valueTemp > 0 && $valueQty > 0){
                                  $rate = $valueTemp/$valueQty;
                                  $rate = round($rate,2);
                                } else {
                                $rate = 0;
                              }
            $totalStockoutMedi += round($stockmedi*$rate,2);
    }

	$cogsRawM = $totalStockoutMedi;

    $cogs =  $cogsRaw + $cogsRawM;
      }

 	*/

    $packing_cost = DB::table('packing_consumptions')->whereBetween('date', [$fdate, $tdate])->sum('amount');
    $manufacturingcost = DB::table('manufacturing_costs')->where('status', 1)->whereBetween('date', [$fdate, $tdate])->sum('total_cost');

	$sales_amount =  DB::table('sales_ledgers')->select(DB::raw('sum(total_price) as totalPrice'),DB::raw('sum(discount_amount) as discountPrice'))
              ->whereNotNull('sale_id')
              ->whereBetween('ledger_date', [$fdate, $tdate])
              ->first();

    $sales_return = DB::table('sales_returns')
            ->where('is_active', 1)
            ->whereBetween('date', [$fdate, $tdate])
            ->sum('grand_total');

      $direct_labour_costs = DB::table('direct_labour_costs')
                                      ->where('status', 1)
                                      ->whereBetween('date', [$fdate, $tdate])
                                      ->sum('total_cost');


      $grossProfit = round($sales_amount->totalPrice  - ($sales_return + $cogs + $manufacturingcost + $packing_cost+ $direct_labour_costs),2);

      $grossProfitPercent = round($grossProfit/($sales_amount->totalPrice  - $sales_return )*100,2);



		 $data['asset_depreciations'] = DB::table('asset_depreciations')->leftJoin('assets', 'assets.id', 'asset_depreciations.asset_id')
          		->leftJoin('asset_products', 'asset_products.id', 'asset_depreciations.asset_product_id')
            	->whereBetween('asset_depreciations.date', [$fdate, $tdate])->sum('asset_depreciations.yearly_amount');

        $allincome = $request->income_head;
        $alleincomeamount = $request->income_amount;


        $allincome =  DB::table('payments')->select([
                              DB::raw("SUM(amount) incomeamount"),
        					'income_sources.name','payments.income_source_id'
                           ])
      			->leftjoin('income_sources','income_sources.id', '=', 'payments.income_source_id')
          		->whereBetween('payment_date', [$fdate, $tdate])->where('payments.income_source_id','!=', ' ')
          		->groupby('income_source_id')->get();


        $allexpasne =  DB::table('payments')->select([
                              DB::raw("SUM(amount) expamount"),
        					'expanse_subgroups.group_id as id','expanse_groups.group_name'])
                         ->leftJoin('expanse_subgroups', 'expanse_subgroups.id', '=', 'payments.expanse_subgroup_id')
          				->leftJoin('expanse_groups', 'expanse_groups.id', '=', 'expanse_subgroups.group_id')
                         ->where('payment_type', 'EXPANSE')
                        ->whereBetween('payment_date', [$fdate, $tdate])
         				 ->where('status', 1)
                        ->groupby('expanse_subgroups.group_id')
                        ->get();
       $expasneAmount =  DB::table('payments')->where('payment_type', 'EXPANSE')
                        ->whereBetween('payment_date', [$fdate, $tdate])
         				 ->where('status', 1)
                        ->sum('amount');
      $netProfit = $grossProfit - $expasneAmount;

     // dd($expasneAmount);

        	$taxes = DB::table('taxes')->where('year',$year)->value('tax');

      		$financial_expenses = DB::table('financial_expenses')->where('year',$year)->get();


        return view('backend.account.pl_analytical_report_view', compact('fdate', 'tdate','taxes', 'data','allincome','allexpasne','financial_expenses','grossProfit','grossProfitPercent','netProfit'));
    }

  public function plAnalyticalMonthlyReportView(Request $request){

     $months = [];

    $months = $request->months;
    $fromMonth = $months[0];
    $count = count($request->months) - 1;
    $toMonth =  $months[$count];
    $currentYear = Carbon::now()->year;

    /* match($fromMonth) {
                            '01' => 'January',
                            '02' => 'February',
                            '03' => 'March',
                            '04' => 'April',
                        };*/

    $information = [];
    foreach($months as $key => $month){
       $sales_amount =  SalesLedger::select(DB::raw('sum(total_price) as totalPrice'),DB::raw('sum(discount_amount) as discountPrice'))
                                  ->whereYear('ledger_date', $currentYear)
                                  ->whereMonth('ledger_date',$month)
                                  ->whereNotNull('sale_id')
                                  ->first();
      $sales_return = SalesReturn::where('is_active', 1)
                                   ->whereYear('date', $currentYear)
                                   ->whereMonth('date',$month)
                                   ->sum('grand_total');
      $cogs = 0;
      $rmproduct = RowMaterialsProduct::orderBy('product_name', 'ASC')->get();
      foreach ($rmproduct as $key => $data){
        $cogs += PurchaseStockout::where('product_id',$data->id)
          ->whereYear('date', $currentYear)
          ->whereMonth('date',$month)
          ->sum('total_amount');
      }

      $manufacturingcost = ManufacturingCost::where('status', 1)
        									  ->whereYear('date', $currentYear)
          									  ->whereMonth('date',$month)
        									  ->sum('total_cost');
      $packing_cost = DB::table('packing_consumptions')->whereYear('date', $currentYear)
          									           ->whereMonth('date',$month)
        											->sum('amount');
      $direct_labour_costs = DB::table('direct_labour_costs')
                                      ->where('status', 1)
                                      ->whereYear('date', $currentYear)
          						      ->whereMonth('date',$month)
                                      ->sum('total_cost');


      $grossProfit = round($sales_amount->totalPrice  - ($sales_return + $cogs + $manufacturingcost + $packing_cost+ $direct_labour_costs),2);

      $grossProfitPercent = round($grossProfit/($sales_amount->totalPrice  - $sales_return )*100,2);
      $data['asset_depreciations'] = DB::table('asset_depreciations')->leftJoin('assets', 'assets.id', 'asset_depreciations.asset_id')
                                    ->leftJoin('asset_products', 'asset_products.id', 'asset_depreciations.asset_product_id')
                                    ->whereYear('asset_depreciations.date', $currentYear)
                                    ->whereMonth('asset_depreciations.date',$month)
                                    ->sum('asset_depreciations.yearly_amount');
      $allincome =  DB::table('payments')->select([
                              DB::raw("SUM(amount) incomeamount"),
        					'income_sources.name','payments.income_source_id'
                           ])
                    ->leftjoin('income_sources','income_sources.id', '=', 'payments.income_source_id')
                    ->whereYear('payment_date', $currentYear)
                    ->whereMonth('payment_date',$month)
                    ->where('payments.income_source_id','!=', ' ')
                    ->groupby('income_source_id')->get();

      $allexpasne =  DB::table('payments')->select([
                              DB::raw("SUM(amount) expamount"),
        					'expanse_subgroups.group_id as id','expanse_groups.group_name'])
                         ->leftJoin('expanse_subgroups', 'expanse_subgroups.id', '=', 'payments.expanse_subgroup_id')
          				->leftJoin('expanse_groups', 'expanse_groups.id', '=', 'expanse_subgroups.group_id')
                         ->where('payment_type', 'EXPANSE')
                        ->whereYear('payment_date', $currentYear)
                        ->whereMonth('payment_date',$month)
         				 ->where('status', 1)
                        ->groupby('expanse_subgroups.group_id')
                        ->get();
       $expasneAmount =  DB::table('payments')->where('payment_type', 'EXPANSE')
                        ->whereYear('payment_date', $currentYear)
                       ->whereMonth('payment_date',$month)
         				 ->where('status', 1)
                        ->sum('amount');
      $netProfit = $grossProfit - $expasneAmount;
      $differenceGrossAndNet = $grossProfit - $netProfit;
      $monthWord = date('F', strtotime("2000-$month-01"));
      $data = [
        'grossProfit' => $grossProfit,
        'month' => $monthWord,
        'netProfit' => $netProfit,
        'grossProfitPercent' => $grossProfitPercent,
        'differenceGrossAndNet' => $differenceGrossAndNet,
        'allexpasne' => $allexpasne,
        'month_no' => $month
      ];
      $information[] = $data;
    }
    Cache::put('monthArray', $months);
    Cache::put('month-wise-all-information', $information);


   return view('backend.account.pl_analytical_monthlyReport_view', compact('months','fromMonth','toMonth','information'));
  }

  public function plAnalyticalMonthlyReportViewThreatDetection(Request $request){

      $months = [];

    $months = $request->months;
    $fromMonth = $months[0];
    $count = count($request->months) - 1;
    $toMonth =  $months[$count];
    $currentYear = Carbon::now()->year;

    /* match($fromMonth) {
                            '01' => 'January',
                            '02' => 'February',
                            '03' => 'March',
                            '04' => 'April',
                        };*/

    $information = [];
    foreach($months as $key => $month){
       $sales_amount =  SalesLedger::select(DB::raw('sum(total_price) as totalPrice'),DB::raw('sum(discount_amount) as discountPrice'))
                                  ->whereYear('ledger_date', $currentYear)
                                  ->whereMonth('ledger_date',$month)
                                  ->whereNotNull('sale_id')
                                  ->first();
      $sales_return = SalesReturn::where('is_active', 1)
                                   ->whereYear('date', $currentYear)
                                   ->whereMonth('date',$month)
                                   ->sum('grand_total');
      $cogs = 0;
      $rmproduct = RowMaterialsProduct::orderBy('product_name', 'ASC')->get();
      foreach ($rmproduct as $key => $data){
        $cogs += PurchaseStockout::where('product_id',$data->id)
          ->whereYear('date', $currentYear)
          ->whereMonth('date',$month)
          ->sum('total_amount');
      }

      $manufacturingcost = ManufacturingCost::where('status', 1)
        									  ->whereYear('date', $currentYear)
          									  ->whereMonth('date',$month)
        									  ->sum('total_cost');
      $packing_cost = DB::table('packing_consumptions')->whereYear('date', $currentYear)
          									           ->whereMonth('date',$month)
        											->sum('amount');
      $direct_labour_costs = DB::table('direct_labour_costs')
                                      ->where('status', 1)
                                      ->whereYear('date', $currentYear)
          						      ->whereMonth('date',$month)
                                      ->sum('total_cost');


      $grossProfit = round($sales_amount->totalPrice  - ($sales_return + $cogs + $manufacturingcost + $packing_cost+ $direct_labour_costs),2);

      $grossProfitPercent = round($grossProfit/($sales_amount->totalPrice  - $sales_return )*100,2);
      $data['asset_depreciations'] = DB::table('asset_depreciations')->leftJoin('assets', 'assets.id', 'asset_depreciations.asset_id')
                                    ->leftJoin('asset_products', 'asset_products.id', 'asset_depreciations.asset_product_id')
                                    ->whereYear('asset_depreciations.date', $currentYear)
                                    ->whereMonth('asset_depreciations.date',$month)
                                    ->sum('asset_depreciations.yearly_amount');
      $allincome =  DB::table('payments')->select([
                              DB::raw("SUM(amount) incomeamount"),
        					'income_sources.name','payments.income_source_id'
                           ])
                    ->leftjoin('income_sources','income_sources.id', '=', 'payments.income_source_id')
                    ->whereYear('payment_date', $currentYear)
                    ->whereMonth('payment_date',$month)
                    ->where('payments.income_source_id','!=', ' ')
                    ->groupby('income_source_id')->get();

      $allexpasne =  DB::table('payments')->select([
                              DB::raw("SUM(amount) expamount"),
        					'expanse_subgroups.group_id as id','expanse_groups.group_name'])
                         ->leftJoin('expanse_subgroups', 'expanse_subgroups.id', '=', 'payments.expanse_subgroup_id')
          				->leftJoin('expanse_groups', 'expanse_groups.id', '=', 'expanse_subgroups.group_id')
                         ->where('payment_type', 'EXPANSE')
                        ->whereYear('payment_date', $currentYear)
                        ->whereMonth('payment_date',$month)
         				 ->where('status', 1)
                        ->groupby('expanse_subgroups.group_id')
                        ->get();
       $expasneAmount =  DB::table('payments')->where('payment_type', 'EXPANSE')
                        ->whereYear('payment_date', $currentYear)
                       ->whereMonth('payment_date',$month)
         				 ->where('status', 1)
                        ->sum('amount');
      $netProfit = $grossProfit - $expasneAmount;
      $differenceGrossAndNet = $grossProfit - $netProfit;
      $monthWord = date('F', strtotime("2000-$month-01"));
      $data = [
        'grossProfit' => $grossProfit,
        'month' => $monthWord,
        'netProfit' => $netProfit,
        'grossProfitPercent' => $grossProfitPercent,
        'differenceGrossAndNet' => $differenceGrossAndNet,
        'allexpasne' => $allexpasne,
        'month_no' => $month
      ];
      $information[] = $data;
    }

    $ledgerMonths = [];
          foreach ($information as $data){
               foreach ($data['allexpasne'] as $expasne){
                     $subExpenseLedgers =  DB::table('payments')->select([DB::raw("SUM(amount) amount"),'expanse_subgroups.subgroup_name'])
                                                     ->leftJoin('expanse_subgroups', 'expanse_subgroups.id', '=', 'payments.expanse_subgroup_id')
                                                     ->where('expanse_type_id',$expasne->id)->where('payment_type', 'EXPANSE')
                                                     ->whereYear('payment_date', date('Y'))
                                                     ->whereMonth('payment_date',$data['month_no'])
                                                     ->where('status', 1)->groupby('payments.expanse_subgroup_id')->orderby('payments.amount','DESC')->get();
                     foreach ($subExpenseLedgers as $key => $subExpenseLedger){

                       $subLedgerName = $subExpenseLedger->subgroup_name;
                       $currentMonth = $data['month'];

                       if (!isset($ledgerMonths[$subLedgerName])) {
                         $ledgerMonths[$subLedgerName] = [$currentMonth];
                       } else {
                         $ledgerMonths[$subLedgerName][] = $currentMonth;
                       }

                     }
               }
          }
    return view('backend.account.pl_analytical_report_threat_detection_view', compact('months','information','ledgerMonths'));
  }

  public function plAnalyticalReportThreatDetectionView(Request $request){
     return view('backend.account.pl_analytical_report_threat_detection_view');
  }

  public function sisterConcernIndex(){
    $sisterCompany = InterCompany::orderBy('name', 'asc')->get();
    return view('backend.account.sisterConcernBookIndex', compact('sisterCompany'));
  }

  public function sisterConcernReport(Request $request){
    if (isset($request->date)) {
        $dates = explode(' - ', $request->date);
        $fdate = date('Y-m-d', strtotime($dates[0]));
        $tdate = date('Y-m-d', strtotime($dates[1]));
    }
    if($fdate <= '2023-10-01'){
    $predate = "2023-10-01";
    } else {
    $predate = date('Y-m-d', strtotime('-1 day', strtotime($fdate)));
    }

    $startdate ="2023-10-01";
    if ($request->company_id) {
       $allCompany = InterCompany::whereIn('id', $request->company_id)->where('status',1)->orderBy('name', 'asc')->get();
    } else {
        $allCompany = InterCompany::where('status',1)->orderBy('name', 'asc')->get();
    }

    return view('backend.account.sisterConcernBookReport', compact('allCompany', 'fdate', 'tdate', 'predate', 'startdate'));
  }

  public function sisterConcernReportView($fdate, $tdate){
    $fdate = date('Y-m-d',  strtotime($fdate));
    $tdate = date('Y-m-d',  strtotime($tdate));
    if($fdate <= '2023-10-01'){
    $predate = "2023-10-01";
    } else {
    $predate = date('Y-m-d', strtotime('-1 day', strtotime($fdate)));
    }

    $startdate ="2023-10-01";

        $allCompany = InterCompany::where('status',1)->orderBy('name', 'asc')->get();

    return view('backend.account.sisterConcernBookReport', compact('allCompany', 'fdate', 'tdate', 'predate', 'startdate'));
  }

  public function cashFlowStatementIndex(){
      return view('backend.account.bank_cash_flow_index');
  }

  public function cashFlowStatementView(Request $request){

    if (isset($request->date)) {
        $dates = explode(' - ', $request->date);
        $fdate = date('Y-m-d', strtotime($dates[0]));
        $tdate = date('Y-m-d', strtotime($dates[1]));
    }
    /*$date = $request->monthYear;
    $fdate = $request->monthYear.'-01';
    $tdate = $request->monthYear.'-31';
    $month = date('F',strtotime($fdate));
    */
    $startdate = '2023-10-01';
    if($fdate == '2023-10-01'){
        $predate = "2023-10-01";
        } else {
        $predate = date('Y-m-d', strtotime('-1 day', strtotime($fdate)));
        }
    $allBanks = MasterBank::orderBy('bank_name', 'asc')->get();
    $allCashes = MasterCash::orderBy('wirehouse_name', 'asc')->get();

    return view('backend.account.bank_cash_flow_report', compact('fdate','tdate','allBanks','allCashes','startdate','predate'));
  }

  public function rmCogsReportView($fdate,$tdate){
    $fdate = date('Y-m-d',  strtotime($fdate));
    $tdate = date('Y-m-d',  strtotime($tdate));

    if($fdate <= '2023-10-01'){
     $preday = "2023-09-30";
     } else {
     $preday = date('Y-m-d', strtotime('-1 day', strtotime($fdate)));
     }
     $sdate = "2023-09-30";
     //$invoices = ChartOfAccounts::select( DB::raw('SUM(debit) - SUM(credit) as balance'))->where('ac_sub_sub_account_id',13)->whereBetween('date',[$sdate,$tdate])->first();
      $invoices = ChartOfAccounts::select('date','invoice')->where('ac_sub_sub_account_id',13)->whereBetween('date',[$sdate,$tdate])->groupBy('invoice')->get();

     return view('backend.ledger.rmCogsReportView', compact('invoices','fdate','tdate','preday','sdate'));
  }

  public function fgCogsReportView($fdate,$tdate){
    $fdate = date('Y-m-d',  strtotime($fdate));
    $tdate = date('Y-m-d',  strtotime($tdate));

    if($fdate <= '2023-10-01'){
     $preday = "2023-09-30";
     } else {
     $preday = date('Y-m-d', strtotime('-1 day', strtotime($fdate)));
     }
     $sdate = "2023-09-30";
     $invoices = ChartOfAccounts::select('date','invoice')->where('ac_sub_sub_account_id',14)->whereBetween('date',[$sdate,$tdate])->groupBy('invoice')->get();
     //dd($invoices);

     return view('backend.ledger.fgCogsReportView', compact('invoices','fdate','tdate','preday','sdate'));
  }

  public function bagCogsReportView($fdate,$tdate){
    $fdate = date('Y-m-d',  strtotime($fdate));
    $tdate = date('Y-m-d',  strtotime($tdate));

    if($fdate <= '2023-10-01'){
     $preday = "2023-09-30";
     } else {
     $preday = date('Y-m-d', strtotime('-1 day', strtotime($fdate)));
     }
     $sdate = "2023-09-30";
     $invoices = ChartOfAccounts::select('invoice')->where('ac_sub_sub_account_id',163)->whereBetween('date',[$sdate,$tdate])->groupBy('invoice')->get();
    // dd($invoices);

     return view('backend.ledger.bagCogsReportView', compact('invoices','fdate','tdate','preday','sdate'));
  }

}
