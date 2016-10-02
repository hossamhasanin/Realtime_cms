<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;

use App\Category;

use App\Http\Requests;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    function __construct()
    {
        $this->middleware("admin");
    }

    public function index()
    {
        $cats = Category::paginate(10);
        return view("admin.allcats" , ["cats" => $cats]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $parent_cats = Category::where("parent" , 0)->get();
        return view("admin.createcat" , ["parent_cats" => $parent_cats]);
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
            "name" => "required|max:255|min:3|unique:categories",
            "parent" => "required|alpha_num",
            ]);
        $cat = new Category;
        $cat->name = $request->name;
        $cat->status = $request->status;
        $cat->parent = $request->parent;
        $cat->users_id = Auth::user()->id;

        $cat->save();

        session()->flash("success_add_category" , "Success :), Category is added");
        return redirect()->route("admin.categories.index");
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
        $cat = Category::find($id);
        $parent_cats = Category::where("id" , "!=" , $id)->get();
        return view("admin.editcat" , ["parent_cats" => $parent_cats , "cat" => $cat]);
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
            "name" => "required|max:255|min:3|unique:categories,name,$id",
            "parent" => "required|alpha_num",
            ]);
        $cat = Category::find($id);
        $cat->name = $request->name;
        $cat->status = $request->status;
        $cat->parent = $request->parent;
        $cat->users_id = Auth::user()->id;

        $cat->save();

        session()->flash("success_add_category" , "Success :), Category is added");
        return redirect()->route("admin.categories.index");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $cat = Category::find($id);
        if ($cat){
            $catname = $cat->name;
            $cat->delete();

            session()->flash("success_delete_category" , "Done :) , The category " . $catname . "deleted");
            return redirect()->route("admin.categories.index");
        }
    }
}
