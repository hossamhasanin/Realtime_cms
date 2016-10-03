<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\User;

use App\Http\Controllers\Controller;

use DB;

use Image;

use Storage;

use App\Http\Requests;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware("User");
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::paginate(10);
        $last_users = DB::table('users')->take(8)->orderBy('id', 'desc')->get();
        return view("admin.allusers" , ["users" => $users , "last_users" => $last_users]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request , [
                "name" => "required|unique:users|max:255",
                "password" => "required|max:255",
                "email" => "required|email|unique:users",
                "user_image" => "required",
            ]);
        $user = new User;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->status = $request->status;
        $user->password = bcrypt($request->password);

        if ($request->hasFile("user_image")){
            $image = $request->file("user_image");
            $imagename = time() . "." . $image->getClientOriginalExtension();
            $location = public_path("images/users/" . $imagename);
            Image::make($image)->resize(160 , 160)->save($location);
            $user->img = $imagename;
        }

        $user->save();

        session()->flash("success_add_user" , "Success , you add new user :" . $request->name);
        return redirect()->route("admin.users.index");
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::find($id);
        return view("admin.edituser" , ["user" => $user]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request , [
                "name" => "required|max:255",
                "email" => "required|max:255",
                "user_image" => "image|mimes:jpg,png,gif",
            ]);
        $user = User::find($id);
        $user->name = $request->name;
        $user->email = $request->email;
        $user->status = $request->status;
        if (!empty($request->new_password)){
            $user->password = bcrypt($request->new_password);
        } else {
            $user->password = $request->old_password;
        }

        if ($request->hasFile("user_image")){
            $image = $request->file("user_image");
            $image_name = time() . "." . $image->getClientOriginalExtension();
            $location = public_path("images/users/" . $image_name);
            Storage::delete("users/".$user->img);
            $user->img = $image_name;
            Image::make($image)->resize(160 , 160)->save($location);
        }

        $user->save();

        session()->flash("success_edit_user" , "Success :) the new opthins save");
        return redirect()->route("admin.users.index");

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::find($id);
        if ($user){
            $username = $user->name;
            Storage::delete("users/".$user->img);
            $user->delete();

            session()->flash("success_delete_user" , "This user " . $username . "deleted");
            return redirect()->back();
        } else {
            return "Erorr Not Found";
        }
    }
}
