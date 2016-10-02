<?php

namespace App\Http\Controllers;

use App\Http\Requests;

use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Auth;

use Request;

use App\User;

use LRedis;

class ChatController extends Controller
{


	public function homepage()
	{
		return view("test");
	}

	public function sendMessage(){

		$redis = LRedis::connection();

		$user = User::where("name" , Request::input('user'))->first();

		$data = ['message' => Request::input('message'), 'user' => Request::input('user') , 'user_img' => $user->img];

		$redis->publish('message', json_encode($data));

		return response()->json([]);

	}
}
