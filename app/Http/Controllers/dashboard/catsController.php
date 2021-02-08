<?php

namespace App\Http\Controllers\dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Intervention\Image\Facades\Image;
use Storage;
use App\Models\Category;

class catsController extends Controller
{
    public function _construct(){
        $this->middleware(['permission:categories_read'])->only('index');
        $this->middleware(['permission:categories_delete'])->only('destroy');
        $this->middleware(['permission:categories_create'])->only('store');
        $this->middleware(['permission:categories_update'])->only('update');

    } //end of construct

    public function index()
    {
        $categories=Category::get();
        return view('controlPanel/cats',compact('categories'));
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $data=$request->except('image');
        $request->validate([
            'name'=>'required|unique:categories',
            'image'=>'image|mimes:png,jpg,jpeg,svg',
        ]);
        if($request->image){
            Image::make($request->image)->resize(300, null, function ($constraint) {
                $constraint->aspectRatio();
            })->save(public_path('uploads/categories/'.$request->image->hashName()));
            $data['image']=$request->image->hashName();
        }

        // if($request->image){
        //     $name = $request->name;
        //     $imgName = $name.'.'.$request->image->extension();
        //     $request->image->move(public_path('imgs/categories/'),$imgName);
        //     $data['image']=$imgName;
        // }
        Category::create($data);
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
        $Category = Category::find($id);
        $request->validate([
            'name'=>[
                'required',
                Rule::unique('categories')->ignore($Category->id),
            ],
            'image'=>'image',
        ]);

        $data=$request->except(['_token','_method','image']);
        if($request->image){
            if($Category->image != 'default.jpg'){
                Storage::disk('public_uploads')->delete('/categories/'.$Category->image);
            }
            Image::make($request->image)->resize(300, null, function ($constraint) {
                $constraint->aspectRatio();
            })->save(public_path('uploads/categories/'.$request->image->hashName()));
            $data['image']=$request->image->hashName();
        }
        Category::where('id', '=', $id)->update($data);
        return back()->with('status','تم التعديل بنجاح');
    }

    public function destroy($id)
    {
        $Category = Category::find($id);
        if($Category->image != 'default.jpg'){
            Storage::disk('public_uploads')->delete('/categories/'.$Category->image);
        }
        $Category->stores()->delete();
        $Category->delete();
        return back()->with('status','تم الحذف بنجاح');
    }
}
