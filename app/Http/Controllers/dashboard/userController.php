<?php

namespace App\Http\Controllers\dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use App\Models\Role;
class userController extends Controller
{
    public function _construct(){
        $this->middleware(['permission:users_read'])->only('index');
        $this->middleware(['permission:users_delete'])->only('destroy');
        $this->middleware(['permission:users_create'])->only('store');
        $this->middleware(['permission:users_update'])->only('update');

    } //end of construct

    public function index()
    {
        // $users=User::get();
        $users=Role::has('users')
        ->where('name', 'store')
        ->orWhere('name', 'delegate')
        ->orWhere('name', 'client')
        ->with('users')
        ->get();
        return view('controlPanel/users',compact('users'));
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $data=$request->all();
        $request->validate([
            'name'=>'required|unique:users',
            'phone'=>'required|unique:users',
            'password'=>'required|confirmed',
        ]);
        $data['password']= bcrypt($request->password);
        $user = User::create($data);
        $user->attachRole($request->role);
        // $user->permissions()->sync($permissions);
        // if($request->role == 'support'){
        //     $user->syncPermissions(['stores_read','stores_create','stores_update']);
        // }
        // elseif($request->role == 'auditor')
        // {
        //     $user->syncPermissions([]);
        // }
        // else
        // {
        //     $user->syncPermissions([]);
        // }

        return back()->with('status','تم الاضافة بنجاح');
    }

    public function show($id)
    {
        $user=User::findOrFail($id);
        return view('controlPanel/user',compact('user'));
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
            'password'=>'required|confirmed',
        ]);
        $data=$request->except(['role','password_confirmation','_token','_method']);
        $data['password']= bcrypt($request->password);

        $user = User::where('id', '=', $id)->update($data);
        return back()->with('status','تم تعديل البيانات بنجاح');
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();
        return redirect('Dashboard/users')->with('status','تم الحذف بنجاح');
    }
}
