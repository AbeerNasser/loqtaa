<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Store;
use App\Models\Ad;
use App\Models\Delegate;
use App\Models\Category;
use App\Models\Role;
use App\User;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        // $this->middleware(['role:admin|super_admin|support|auditor']);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $stors=Store::count();
        $ads=Ad::count();
        $delegates=Delegate::count();
        $categories=Category::count();
        // $users=User::count();
        $users=Role::has('users')
        ->where('name', 'admin')
        ->orWhere('name', 'support')
        ->orWhere('name', 'auditor')
        ->count();
        return view('controlPanel/index',compact('stors','ads','delegates','categories','users'));
    }
}
