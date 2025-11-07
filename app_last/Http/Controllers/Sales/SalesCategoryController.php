<?php

namespace App\Http\Controllers\Sales;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\SalesCategory;
use App\Models\SalesSubCategory;
use DB;

class SalesCategoryController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //get all Department list and view in division page
       
        $categorys = SalesCategory::orderBy('id','desc')->get();

        return view('backend.sales_product.category',compact('categorys'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd($request);
        $validatedData = $request->validate([
            'category_name' => 'required|unique:sales_categories',
            ],[
                'category_name.required'=>'The Category Name is Required',
                'category_name.unique'=>'The Category Name is alreday Exists',
            ]);

        $categorys = new SalesCategory();
        $categorys->category_name = $request->category_name;
        // dd($categorys);
        $categorys->save();
        return redirect()->route('sales.category.index')->with('success','Category Create Successful');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
      
      	 $editabledata = SalesCategory::where('id',$id)->first();
      //dd($editabledata);
         return view('backend.sales_product.salescategoryedit',compact('editabledata'));
    }
    public function update(Request $request)
    {
        //dd($request->all());
      
        $validatedData = $request->validate([
            'category_name' => 'required|unique:sales_categories',
            ],[
                'category_name.required'=>'The Category Name is Required',
                'category_name.unique'=>'The Category Name is alreday Exists',
            ]);

        $categorys = SalesCategory::where('id',$request->id)->first();
        $categorys->category_name = $request->category_name;
        $categorys->save();
        return redirect()->route('sales.category.index')->with('success','Category Edited Successful');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
      //dd($request->all());
        SalesCategory::where('id',$request->id)->delete();
        return redirect()->route('sales.category.index')
                        ->with('delete', 'Category Delete  successfully .');
    }
    public function indexSubCat()
    {
        $salesCats = SalesCategory::orderby('category_name','ASC')->get();
        $categorys = SalesSubCategory::select('sales_sub_categories.*','s.category_name')->leftJoin('sales_categories as s','s.id','=','sales_sub_categories.cat_id')->orderBy('sales_sub_categories.id','desc')->get();
        return view('backend.sales_product.subCategory',compact('categorys','salesCats'));
    }
    public function storeSubCat(Request $request){
      //dd($request->all());

      $validatedData = $request->validate([
          'name' => 'required|unique:sales_sub_categories',
          ],[
              'name.required'=>'The Sub Category Name is Required',
              'name.unique'=>'The Sub Category Name is alreday Exists',
          ]);

      $categorys = new SalesSubCategory();
      $categorys->cat_id = $request->cat_id;
      $categorys->name = $request->name;
      $categorys->save();
      return redirect()->route('sales.sub.category.index')->with('success','Sub Category Create Successful');
    }

    public function editSubCat($id){
      $editabledata = SalesSubCategory::where('id',$id)->first();
      //dd($editabledata);
      $salesCats = SalesCategory::orderby('category_name','ASC')->get();
      return view('backend.sales_product.salesSubCategoryedit',compact('editabledata','salesCats'));
    }

    public function updateSubCat(Request $request)
    {

        $categorys = SalesSubCategory::where('id',$request->id)->first();
        $categorys->cat_id = $request->cat_id;
        $categorys->name = $request->name;
        $categorys->save();
        return redirect()->route('sales.sub.category.index')->with('success','Sub Category Edited Successful');
    }

public function destroySubCat(Request $request){
  //dd($request->id);
  SalesSubCategory::where('id',$request->id)->delete();
  return redirect()->route('sales.sub.category.index')
                  ->with('delete', 'Sub Category Delete  successfully .');
}
}
