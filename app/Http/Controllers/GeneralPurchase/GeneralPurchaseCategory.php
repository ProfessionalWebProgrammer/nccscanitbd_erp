<?php

namespace App\Http\Controllers\GeneralPurchase;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\GeneralCategory;
use App\Models\GeneralSubCategory;
use DB;
class GeneralPurchaseCategory extends Controller
{
    public function index()
    {
        $categories = GeneralCategory::all();
        return view('backend.general_purchase.ganeral_category', compact('categories'));
    }

    public function storecategory(Request $request)
    {
        $catdata =  new GeneralCategory();
        $catdata->gcategory_name =  $request->category_name;
        $catdata->save();
        return redirect()->back();
    }

    public function destroy(Request $request)
    {
      //dd($request->all());
        GeneralCategory::where('id', $request->invoice)->delete();
        return redirect()->back()->with('success', 'Category Delete Successfull');
    }

    public function subcategory()
    {
        $categories = GeneralCategory::all();
        $subcatdata = DB::table('general_sub_categories')
          	->select('general_sub_categories.*','general_categories.gcategory_name')
      		->leftJoin('general_categories', 'general_categories.id', 'general_sub_categories.general_category_id')
          	->get();
        return view('backend.general_purchase.ganeral_sub_category', compact('categories', 'subcatdata'));
    }

    public function storesubcategory(Request $request)
    {
       
        $catdata =  new GeneralSubCategory();
        $catdata->general_category_id =  $request->general_category_id;
        $catdata->general_sub_category_name =  $request->general_sub_category_name;
        $catdata->save();
        return redirect()->back()->with('success', 'Sub-Category Created Successfull');
    }
    public function destroysubcat(Request $request)
    {
        //dd($request->all());
        GeneralSubCategory::where('id', $request->id)->delete();
        return redirect()->back()->with('success', 'Sub-Category Delete Successfull');
    }
}
