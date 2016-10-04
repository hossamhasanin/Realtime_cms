<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Permission;

use App\Category;

class PermissionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pers = Permission::paginate(10);
        $cats = Category::get();
        return view("admin.allperms" , ["pers" => $pers , "cats" => $cats]);
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
                "name" => "required|unique:permissions",
                "dep" => "required",
                "descrip" => "required",
                "posts_control" => "required"
            ]);
        

        $departs = implode("," , $request->dep);
        $perms = new Permission;
        $perms->name = $request->name;
        $perms->description = $request->descrip;
        $perms->departments = $departs;
        $perms->full_control_posts = $request->posts_control;
        if ($request->cats or $request->cats != ""){
            $cats = implode("," , $request->cats);
            $perms->categories = $cats;
        } else {
            $perms->categories = null;
        }

        $perms->save();

        session()->flash("success_add_perms" , "the new permission added success");
        return redirect()->route("settings");

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
        $perm = Permission::find($id);
        $cats = Category::get();
        return view("admin.editperm" , ["perm" => $perm , "cats" => $cats]);
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
                "name" => "required|unique:permissions,name,$id",
                "dep" => "required",
                "descrip" => "required",
                "posts_control" => "required"
            ]);
        

        $departs = implode("," , $request->dep);
        $perms = Permission::find($id);
        $perms->name = $request->name;
        $perms->description = $request->descrip;
        $perms->departments = $departs;
        $perms->full_control_posts = $request->posts_control;
        if ($request->cats or $request->cats != ""){
            $cats = implode("," , $request->cats);
            $perms->categories = $cats;
        } else {
            $perms->categories = null;
        }

        $perms->save();

        session()->flash("success_edit_perms" , "the permission edited success");
        return redirect()->route("settings");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $per = Permission::find($id);
        if ($per){
            $per->delete();

            session()->flash("success_delete_perm" , "You delete perm success");
            return redirect()->route("settings");
        } else {
            return "Error 404 Not found";
        }
    }
}
