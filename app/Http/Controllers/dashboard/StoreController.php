<?php

namespace App\Http\Controllers\dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Intervention\Image\Facades\Image;
use Storage;
use App\User;
use App\Models\Store;
use App\Models\Offer;
use App\Models\Category;

class StoreController extends Controller
{
    public function _construct(){
        $this->middleware(['permission:stores_read'])->only('index');
        $this->middleware(['permission:stores_delete'])->only('destroy');
        $this->middleware(['permission:stores_create'])->only('store');
        $this->middleware(['permission:stores_update'])->only('update');

    } //end of construct

    public function index()
    {
        $stores=Store::with('offers','ads','user')->get();
        return view('controlPanel/stores',compact('stores'));
    }

    public function create()
    {
        $cats=Category::get();
        return view('controlPanel/addNewStore',compact('cats'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'=>'required|unique:users',
            'phone'=>'required|unique:users',
            'description'=>'required',
            'address'=>'required',
            'image'=>'image',
            'password'=>'required|confirmed',
            // 'category_id'=>'required',
        ]);

        $data=$request->only('name','phone','address');
        if($request->image){
            Image::make($request->image)->resize(300, null, function ($constraint) {
                $constraint->aspectRatio();
            })->save(public_path('uploads/stores/'.$request->image->hashName()));
            $data['image']=$request->image->hashName();
        }
        $data['password']= bcrypt($request->password);

        $user = User::create($data);
        $user->attachRole('store');
        $storeData=$request->except(['name','phone','address','password','password_confirmation']);
        $user=User::get()->last();
        $storeData['user_id'] = $user->id;
        Store::create($storeData);

        return back()->with('status','تم الاضافة بنجاح');
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $cats=Category::get();
        $store=Store::with('user')->find($id);
        return view('controlPanel/addNewStore',compact('store','cats'));
    }

    public function update(Request $request, $id)
    {
        $store = Store::find($id);
        $userimag= User::find($store->user_id);

        $request->validate([
            'name'=>[
                'required',
                Rule::unique('users')->ignore($userimag->id),
            ],
            'phone'=>[
                'required',
                Rule::unique('users')->ignore($userimag->id),
            ],
            'description'=>'required',
            'address'=>'required',
            'image'=>'image',
            'password'=>'required|confirmed',
            // 'category_id'=>'required',
        ]);

        $data=$request->only('name','phone','address');

        if($request->image){
            if($userimag->image != 'default.jpg'){
                Storage::disk('public_uploads')->delete('/stores/'.$userimag->image);
            }
            Image::make($request->image)->resize(300, null, function ($constraint) {
                $constraint->aspectRatio();
            })->save(public_path('uploads/stores/'.$request->image->hashName()));
            $data['image']=$request->image->hashName();
        }

        $data['password']= bcrypt($request->password);

        $user = User::where('id', '=', $store->user_id)->update($data);

        $storeData=$request->except(['name','phone','address','password','password_confirmation','_token','_method','image']);
        Store::where('id', '=', $id)->update($storeData);
        return back()->with('status','تم تعديل البيانات');
    }

    public function activeStore($id)
    {
        $store = Store::findOrFail($id);
        if($store->temp_disable == 0)
            Store::where('id',$id)->update(['temp_disable'=>1]);
        else
            Store::where('id',$id)->update(['temp_disable'=>0]);
        return back()->with('status', 'تم التعطيل بنجاح ');
    }
    public function storOffers($id)
    {
        $store=$id;
        $offers=Offer::where('store_id','=',$id)->get();
        return view('controlPanel/storeOffers',compact('offers','store'));
    }

    public function destroy($id)
    {
        $store = Store::find($id);
        $userimag= User::find($store->user_id);
        if($userimag->image != 'default.jpg'){
            Storage::disk('public_uploads')->delete('/stores/'.$userimag->image);
        }
        $user = User::where('id', '=', $store->user_id)->first();
        $st = Store::where('id', '=', $id)->update(['user_id'=>null]);
        $user->delete();
        $stor = Store::find($id);
        $stor->delete();
        return back()->with('status','تم الحذف بنجاح');
    }
}
