<?php

namespace App\Http\Controllers\Purchase;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use DB;
use Auth;
use Session;
use Carbon\Carbon;


class RentalController extends Controller
{
    
    public function rentalProfileIndex(){
        return view('backend.rental.rentalProfile.index');
    }
    
    public function rentalProfileCreate(){
        return view('backend.rental.rentalProfile.create');
    }
    
    
     public function rentalGoodsReceivedIndex(){
        return view('backend.rental.goodsReceived.index');
    }
    
    public function rentalGoodsReceivedCreate(){
        return view('backend.rental.goodsReceived.create');
    }
    
    public function rentalGoodsDeliveryIndex(){
        return view('backend.rental.goodsDelivery.index');
    }
    
    public function rentalGoodsDeliveryCreate(){
        return view('backend.rental.goodsDelivery.create');
    }
    
    public function rentalGoodsDeliveryCollectionIndex(){
        return view('backend.rental.deliveryCollection.index');
    }
    
    public function rentalGoodsDeliveryCollectionCreate(){
        return view('backend.rental.deliveryCollection.create');
    }
}







