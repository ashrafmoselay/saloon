<?php

namespace App\Http\Controllers;

use App\Permission;
use App\PermissionRole;
use Illuminate\Http\Request;
use App\Role;
use Exception;

class RolesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $roles = Role::get();
        return view('roles.index',compact('roles'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $role = new \Spatie\Permission\Models\Role();
        $data = Permission::getRoutePermission();
        $controllers = $data['controllers'];
        $methods = $data['methods'];
        return view('roles.create',compact('role','methods','controllers'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $inputs = $request->all();
        $inputs['guard_name'] = 'web';
        try{
            $role = Role::create($inputs);
            $allpermisions = [];
            foreach($inputs['perm'] as $permisionName=>$on){
                $permission = Permission::firstOrCreate(['name' => $permisionName]);
                array_push($allpermisions,$permission);
            }
            $role->syncPermissions($allpermisions);
            return redirect('roles');
        }catch(Exception $e){
            return back()->with('alert-danger', ' حدث خطأ اثناء الاضافه  '.$e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Role $role)
    {
        return view('roles.show',compact('role'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Role $role)
    {

        $data = Permission::getRoutePermission();
        $controllers = $data['controllers'];
        $methods = $data['methods'];

        return view('roles.edit',compact('role','controllers','methods'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Role $role)
    {
        $inputs = $request->all();
        $role->update($inputs);
        $allpermisions = [];
        foreach($inputs['perm'] as $permisionName=>$on){
                $permission = Permission::firstOrCreate(['name' => $permisionName]);
                array_push($allpermisions,$permission);
        }
        $role->syncPermissions($allpermisions);
        return redirect('roles');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Role $role)
    {
        $role->delete();
        return "done";
    }
}
