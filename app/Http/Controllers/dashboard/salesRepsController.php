<?php

namespace App\Http\Controllers\dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Delegate;
use App\User;

class salesRepsController extends Controller
{
    public function _construct(){
        $this->middleware(['permission:delegates_read'])->only('index');
        $this->middleware(['permission:delegates_delete'])->only('destroy');
        $this->middleware(['permission:delegates_create'])->only('store');
        $this->middleware(['permission:delegates_update'])->only('update');

    } //end of construct

    public function index()
    {
        $delegates=Delegate::with('user')->get();
        return view('controlPanel/salesReps',compact('delegates'));
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'=>'required|unique:users',
            'phone'=>'required|unique:users',
            'national_id'=>'required|unique:delegates',
            'password'=>'required|confirmed',
        ]);
        $data=$request->only('name','phone');
        $data['password']= bcrypt($request->password);
        $user = User::create($data);
        $user->attachRole('delegate');
        // $user->permissions()->sync($permissions);

        $delegData=$request->except(['name','phone','password','password_confirmation']);
        $user=User::get()->last();
        $delegData['user_id'] = $user->id;
        Delegate::create($delegData);
        return back()->with('status','تم اضافة مندوب جديد بنجاح');
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
        $request->validate([
            'name'=>'required',
            'phone'=>'required',
            'national_id'=>'required',
            'password'=>'required|confirmed',
        ]);
        $data=$request->only('name','phone');
        $data['password']= bcrypt($request->password);
        $deleg=Delegate::find($id);
        $user = User::where('id', '=', $deleg->user_id)->update($data);

        $delegData=$request->only('national_id');

        Delegate::where('id', '=', $id)->update($delegData);

        return back()->with('status','تم تعديل بيانات المندوب');
    }

    public function activeDelegate($id)
    {
        $deleg = Delegate::findOrFail($id);
        if($deleg->temp_disable == 0)
            Delegate::where('id',$id)->update(['temp_disable'=>1]);
        else
            Delegate::where('id',$id)->update(['temp_disable'=>0]);
        return back()->with('status', 'تم التعطيل بنجاح ');
    }

    public function destroy($id)
    {
        $deleg = Delegate::find($id);
        $user = User::where('id', '=', $deleg->user_id)->first();
        $delegate = Delegate::where('id', '=', $id)->update(['user_id'=>null]);

        $user->delete();
        $del = Delegate::find($id);
        $del->delete();
        return back()->with('status','تم الحذف بنجاح');
    }
}
