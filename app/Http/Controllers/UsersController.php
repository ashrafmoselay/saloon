<?php
namespace App\Http\Controllers;
use App\User;
use Illuminate\Http\Request;

class UsersController extends Controller
{

    public function index()
    {
        $users = User::get();
        return view('users.index',compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $user = new User;
        return view('users.create',compact('user'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $inputs = $request->except('_token');
        if($inputs['password']){
            $inputs['password'] = bcrypt($inputs['password']);
        }
        $inputs['show_cost_price'] =  $request->has('show_cost_price');
        $inputs['show_sale_price'] =  $request->has('show_sale_price');
        $user = User::create($inputs);
        if($request->hasFile('photo')) {
            $user->addMedia($request->file('photo'))->toMediaCollection('photo');
        }
        $user->assignRole($inputs['role']);
        if($inputs['stores']){
            $user->stores()->attach($inputs['stores']);
        }
        return redirect(route('users.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::findOrFail($id);
        return view('users.show',compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        return view('users.edit',compact('user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        $inputs = $request->except('_token');
        if($inputs['password']){
            $inputs['password'] = bcrypt($request->password);
        }else{
            $inputs['password'] = $user->password;
        }

        $inputs['show_cost_price'] =  $request->has('show_cost_price');
        $inputs['show_sale_price'] =  $request->has('show_sale_price');
        $user->update($inputs);
        if($request->hasFile('photo')) {
            $user->media()->delete();
            $user->addMedia($request->file('photo'))->toMediaCollection('photo');
        }
        $user->stores()->detach();
        if($inputs['stores']){
            $user->stores()->attach($inputs['stores']);
        }
        $user->syncRoles($inputs['role']);
        return redirect(route('users.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        if($user->delete()){
            return "done";
        }
        return "failed";
    }


}
