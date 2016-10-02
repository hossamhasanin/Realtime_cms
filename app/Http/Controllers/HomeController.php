<?php

namespace App\Http\Controllers;

use App\Http\Requests;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;

use App\User;

use LRedis;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('admin');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::find(Auth::user()->id);
        $users->online = 1;
        $users->save();
        $online_users = User::where("online" , 1)->get();

        $redis = LRedis::connection();

        $data = ['online_name' => $users->name, 'image' => $users->img];

        $redis->publish('online_users', json_encode($data));


        return view('admin.index' , ["online_users" => $online_users]);
    }
}
