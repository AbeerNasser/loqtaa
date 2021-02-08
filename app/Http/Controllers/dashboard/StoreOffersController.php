<?php

namespace App\Http\Controllers\dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;
use Storage;
use App\Models\Offer;
class StoreOffersController extends Controller
{
    public function _construct(){
        $this->middleware(['permission:offers_read'])->only('index');
        $this->middleware(['permission:offers_delete'])->only('destroy');
        $this->middleware(['permission:offers_create'])->only('store');
        $this->middleware(['permission:offers_update'])->only('update');

    } //end of construct

    public function index()
    {
        //
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $request->validate([
            'product'=>'required',
            'price'=>'required',
            'image'=>'image',
        ]);
        $data=$request->all();
        if($request->image){
            Image::make($request->image)->resize(300, null, function ($constraint) {
                $constraint->aspectRatio();
            })->save(public_path('uploads/offers/'.$request->image->hashName()));
            $data['image']=$request->image->hashName();
        }
        $offer = Offer::create($data);

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
        $offr = Offer::findOrFail($id);
        $request->validate([
            'product'=>'required',
            'price'=>'required',
        ]);
        $data=$request->except(['_token','_method','image']);

        if($request->image){
            if($offr->image != 'default.png'){
                Storage::disk('public_uploads')->delete('/offers/'.$offr->image);
            }
            Image::make($request->image)->resize(300, null, function ($constraint) {
                $constraint->aspectRatio();
            })->save(public_path('uploads/offers/'.$request->image->hashName()));
            $data['image']=$request->image->hashName();
        }

        $offer = Offer::where('id','=',$id)->update($data);

        return back()->with('status','تم الاضافة بنجاح');
    }
    public function activeOffer($id)
    {
        $offer = Offer::findOrFail($id);
        if($offer->status == 0)
            Offer::where('id',$id)->update(['status'=>1]);
        else
            Offer::where('id',$id)->update(['status'=>0]);
        return back()->with('status', 'تم التعطيل بنجاح ');
    }
    public function destroy($id)
    {
        $offer = Offer::findOrFail($id);
        if($offer->image != 'default.png'){
            Storage::disk('public_uploads')->delete('/offers/'.$offer->image);
        }
        $offer->delete();
        return back()->with('status','تم الحذف بنجاح');
    }
}
