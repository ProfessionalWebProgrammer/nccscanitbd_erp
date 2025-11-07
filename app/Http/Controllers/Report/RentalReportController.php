<?php

namespace App\Http\Controllers\Report;

use Auth;
use Session;

use DateInterval;
use DatePeriod;
use DataTables;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Http\Controllers\Controller;

class RentalReportController extends Controller
{
public function allReports(){

    return view('backend.rentalReport.index');
}

public function rentalGoodReceiveReport(){
  return view('backend.rentalReport.received.report');
}

public function rentalGoodDeliveryReport(){
  return view('backend.rentalReport.delivery.report');
}

public function rentalGoodDeliveryLedger(){
  return view('backend.rentalReport.deliveryLedger.ledger');
}

public function rentalGoodCollectionSlip(){
  return view('backend.rentalReport.collectionSlip.view');
}

}
