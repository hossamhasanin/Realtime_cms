<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\App;

use App\Posts;

use Closure;

use App\Category;

use App\User;

use App\Permission;

use Purifier;

use Image;

use LRedis;

use DB;

use Storage;

use App\Http\Requests;

class PostsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __construct()
    {
        $this->middleware("Posts");
    }

    public function index()
    {
        $user_per = Permission::find(Auth::user()->status);
        if ($user_per->full_control_posts == 0){
            $posts = Posts::where("id" , Auth::user()->id)->paginate(10);
            $last_posts = Posts::take(8)->orderBy('id', 'desc')->get();
            return view("admin.allposts" , ["posts" => $posts , "last_posts" => $last_posts]);
        } else {
            $posts = Posts::paginate(10);
            $last_posts = Posts::take(8)->orderBy('id', 'desc')->get();
            return view("admin.allposts" , ["posts" => $posts , "last_posts" => $last_posts]);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $per = Permission::find(Auth::user()->status)->categories;
        if ($per != null){
            $pure_cats = explode("," , $per);
        } else {
            $pure_cats = Category::get();
        }
        return view("admin.createpost" , ["cats" => $pure_cats]);
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
                "title" => "required|max:255",
                "slug" => "required|max:255|unique:posts",
                "content" => "required|min:5",
                "image" => "required|image",
            ]);
        $per = Permission::find(Auth::user()->status)->categories;
        $pure_cats = explode("," , $per);
        if (!in_array($request->category , $pure_cats)){
            return redirect()->route("dashboard");
        } else {

        $post = new Posts;
        $post->title = $request->title;
        $post->slug = $request->slug;
        $find_cat = Category::where("name" , $request->category)->first();
        $post->category_id = $find_cat->id;
        $post->content = Purifier::clean($request->content);
        $post->users_id = Auth::user()->id;

        if ($request->hasFile("image")){
            $image = $request->File("image");
            $image_name = time() . "." . $image->getClientOriginalExtension();
            $location = public_path("images/posts/".$image_name);
            Image::make($image)->resize(250 , 250)->save($location);
            $post->image = $image_name;
        }

        $post->save();
/*
        $online_post = Category::where("id" , $request->category_id);

        $online_user = User::where("id" , Auth::user()->id);
        
        $pusher = App::make('pusher');

        $pusher->trigger( 'real-time-apps',
                      'notifications', 
                      ['post' =>["title" => $request->title , "slug" => $request->slug , "category" => $online_post->name , "created_by" => $online_user->name]]);
       */ //socket

        $redis = LRedis::connection();

        $data = ['title' => $request->title, 'slug' => $request->slug];

        $redis->publish('postes', json_encode($data));


        
        session()->flash("success_add_post" , "Success :) , The post:" . $request->title . "added");
        return redirect()->route("admin.posts.index");

        }

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
        $post = Posts::find($id);
        $per = Permission::find(Auth::user()->status)->categories;
        if ($per != null){
            $pure_cats = explode("," , $per);
        } else {
            $pure_cats = Category::get();
        }
        return view("admin.editpost" , ["post" => $post , "cats" => $pure_cats]);
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
            "title" => "required|max:255",
            "slug" => "required|unique:posts,slug,$id",
            "image" => "required|image|mimes:jpg,png,gif",
            "category" => "required",
            ]);
        $per = Permission::find(Auth::user()->status)->categories;
        $pure_cats = explode("," , $per);
        if (!in_array($request->category , $pure_cats)){
            return redirect()->route("dashboard");
        } else {

            $post = Posts::find($id);
            $post->title = $request->title;
            $post->slug = $request->slug;
            $find_cat = Category::where("name" , $request->category)->first();
            $post->category_id = $find_cat->id;
            $post->users_id = Auth::user()->id;
            $post->content = Purifier::clean($request->content);

            if ($request->hasFile("image")){
                $image = $request->File("image");
                $image_name = time() . "." . $image->getClientOriginalExtension();
                $location = public_path("images/posts/".$image_name);
                Storage::delete("posts/".$post->image);
                Image::make($image)->resize(250 , 250)->save($location);
                $post->image = $image_name;
            }

            $post->save();

            session()->flash("success_edit_post" , "Success :) , You add new thigs");
            return redirect()->route("admin.posts.index");

        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $post = Posts::find($id);
        if ($post){
            $posttitle = $post->title;
            Storage::delete("posts/".$post->image);
            $post->delete();

            $pusher = App::make("pusher");
            $pusher->trigger("real-time-apps" , "notifications" , ["post_deleted" => "the post ".$posttitle ."is deleted"]);

            session()->flash("success_delete_post" , "This post " . $posttitle . "deleted");
            return redirect()->back();
        } else {
            return "Erorr Not Found";
        }
    }
}
