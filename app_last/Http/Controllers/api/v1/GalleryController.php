<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use App\Models\Gallery;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class GalleryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Gallery::get();
      
      
        if($data){
                return response()->json(['gallery'=>$data,'status'=>201]);
            }
            else
            {
                return response()->json(['res'=>'Data Not Found','status'=>404]);
            }
            
    }
    public function gallery(){
        $data = Gallery::get();
      return view('backend.gallery.index', compact('data'));
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
      $id = Auth::id();
      $img = new Gallery;
      //dd($request->all());
      
      $image = $request->file('image');
      //$image = imageresolution($image);
     $request->validate([
          'image' => 'mimes:jpeg,jpg,png|required|max:20000' // max 10000kb
      ]);
      
      $name = rand() . '.' . $image->getClientOriginalExtension();
      $image->move(public_path('uploads/gallery/'), $name);

      $img->user_id = $request->user_id ?? $id;
      $img->image   = $name;
      $img->note   = $request->note ?? '';
      
      /*
      $img->user_id = $request->user_id ?? '';
      $img->image  =  $request->image;
      */
      
      $img->status  =  $request->status;
      $img->save();
      
      
      if($img->save()){
            return response()->json(['success'=>'Gallery Created Successfull','status'=>201]);
        }
        else
        {
            return response()->json(['res'=>'Gallery Data Not Found','status'=>404]);
        }
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
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
      //dd($request->id);
      Gallery::where('id',$request->id)->delete();
      return redirect()->back()->with('success','Gallery Deleted Successfull');
    }
}
