<?php

namespace App\Http\Controllers\dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;
use Storage;
use App\Models\Ad;

class adsController extends Controller
{
    public function _construct(){
        $this->middleware(['permission:ads_read'])->only('index');
        $this->middleware(['permission:ads_delete'])->only('destroy');
        $this->middleware(['permission:ads_create'])->only('store');
        $this->middleware(['permission:ads_update'])->only('update');

    } //end of construct

    public function index()
    {
        $ads=Ad::get();
        return view('controlPanel/ads',compact('ads'));
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $data=$request->except('image');
        $request->validate([
            'description'=>'required',
            'urlink'=>'required|url',
            'image'=>'image|mimes:png,jpg,jpeg,svg',
        ]);

        if($request->image){
            Image::make($request->image)->resize(300, null, function ($constraint) {
                $constraint->aspectRatio();
            })->save(public_path('uploads/ads/'.$request->image->hashName()));
            $data['image']=$request->image->hashName();
        }

        // if($request->image){
        //     $name = $request->name;
        //     $imgName = $name.'.'.$request->image->extension();
        //     $request->image->move(public_path('imgs/ads/'),$imgName);
        //     $data['image']=$imgName;
        // }
        Ad::create($data);
        return back()->with('status','تم الاضافة بنجاح');
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        $ads = Ad::find($id);
        $request->validate([
            'description'=>'required',
            'urlink'=>'required|url',
            'image'=>'image|mimes:png,jpg,jpeg,svg',
        ]);
        $data=$request->except(['_token','_method','image']);
        if($request->image){
            if($ads->image != 'default.jpeg'){
                Storage::disk('public_uploads')->delete('/ads/'.$ads->image);
            }
            Image::make($request->image)->resize(300, null, function ($constraint) {
                $constraint->aspectRatio();
            })->save(public_path('uploads/ads/'.$request->image->hashName()));
            $data['image']=$request->image->hashName();
        }
        Ad::where('id', '=', $id)->update($data);
        return back()->with('status','تم التعديل بنجاح');
    }

    public function destroy($id)
    {
        $ads = Ad::find($id);
        if($ads->image != 'default.jpeg'){
            Storage::disk('public_uploads')->delete('/ads/'.$ads->image);
        }
        $ads->delete();
        return back()->with('status','تم الحذف بنجاح');
    }
}
