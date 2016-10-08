<?php

namespace App\Http\Controllers;

use App\Http\Requests;

use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Auth;

use Request;

use App\User;

use App\Chat;

use LRedis;

class ChatController extends Controller
{


	public function homepage()
	{
		return view("test");
	}

	public function sendMessage(Request $request){
/*
		$redis = LRedis::connection();
*/
		$user = User::where("name" , Request::input('user'))->first();
/*
		$data = ['message' => Request::input('message'), 'user' => Request::input('user') , 'user_img' => $user->img];

		$redis->publish('message', json_encode($data));

		return response()->json([]);
*/

		$chat = new Chat;
		$chat->user = Request::input('user');
		$chat->body = Request::input('message');
		$chat->save();

		//return response()->json(["id" => $chat->id , "user_img" => $user->img , "user" => Request::input('user') , "message" => Request::input('message')]);

		return $chat;

	}

	public function show_all_message(Request $request)
	{/*
		set_time_limit(0);
		$last_message = Chat::orderBy('id', 'desc')->latest()->get();

		while (true) {
			
			$now_message = Request::input('last');

			if ($now_message != $last_message && $now_message != null){
				$latest_messages = Chat::where("id" , ">" , Request::input('last'))->get()->first();
				$userImage = User::where("name" , $latest_messages->user)->first();

				return response()->json(["user" => $latest_messages->user , "body" => $latest_messages->body , "user_img" => $userImage->img , "id" => $latest_messages->id]);
			} else {
				sleep(1);
				continue;
			}
		}
*/
			set_time_limit(0);
		while (true){

			$last_ajax_call = Request::get("timestamp");

			clearstatcache();
			//$from = isset(Request::get('from')) ? (int)Request::get("from") : null;

			$last_message = Chat::orderBy('id', 'desc')->get()->first();

		    if ($last_ajax_call == null || $last_message > $last_ajax_call) {
		        $messages = $last_ajax_call != null ? Chat::where('created_at', '>', $last_ajax_call) : $last_message;
		        return $messages->latest()->get();
		         $result = array(
			            'data_from_file' => $data,
			            'timestamp' => $last_message
			     );

		        // encode to JSON, render the result (for AJAX)
		        $json = json_encode($result);
		        echo $json;
		        break;
		    } else {
		        sleep(1);
		        continue;
		    }

		}
			
	}

}
