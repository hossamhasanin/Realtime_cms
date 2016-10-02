<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\User;

use App\Permission;

use App\Category;

use Illuminate\Support\Facades\Auth;

use LRedis;

use App\Http\Requests;

class PagesController extends Controller
{
    public function profile($user)
    {
    	$users = User::where("name" , $user)->first();
    	return view("admin.profile" , ["user" => $users]);
    }

    public function settings()
    {
        $pers = Permission::paginate(10);
        $cats = Category::get();
    	return view("admin.settings" , ["pers" => $pers , "cats" => $cats]);
    }

    public function logoutoff()
    {
    	$user = User::find(Auth::user()->id);
    	$user->online = 0;
    	$user->save();

    	$redis = LRedis::connection();

        $data = ['offline_name' => $user->name, 'image' => $user->img];

        $redis->publish('online_users', json_encode($data));

        Auth::logout();

        return redirect("/login/");


    }
}
