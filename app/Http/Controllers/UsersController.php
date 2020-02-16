<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Role as Roles;
use App\Permission as Permissions;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::all();

        return view('users/index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // return User::create([
        //     'name' => $data['name'],
        //     'email' => $data['email'],
        //     'password' => Hash::make($data['password']),
        // ]);

        return view('users/create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // return User::create([
        //     'name' => $data['name'],
        //     'email' => $data['email'],
        //     'password' => Hash::make($data['password']),
        // ]);

        $reg = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('users.index')
                        ->with('success','Settings updated successfully');
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
        //
        $data = User::where('id',$id)->with('roles')->first();
        //dd($data->roles[0]->name);
        $roles = Roles::all();
        $permissions = Permissions::all()->pluck('name');
        $userPermissions = [];
           
        $userPermissions = User::where('id',$id)->with('permissions')->first();
        $userPermissions = collect($userPermissions)['permissions'];
        $userPerms = [];
        foreach ($userPermissions as $key => $permission) {
            //dd($permission['name']);
            array_push($userPerms, $permission['name']);
        }
        
        return view('users/edit', compact('data','roles','permissions','userPerms'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $req, $id)
    {
        //
        $user = User::findOrFail($id);
        $user->active = $req->status;
        $user->save();
        $user->syncRoles();
        $user->assignRole($req->role);
        $user->syncPermissions();
        foreach ($req->permissions as $key => $permission) {
            # code...
            $user->givePermissionTo($permission);
        }
        //dd($req->all());

        return redirect()->route('users.index')
                        ->with('success','Settings updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function logs($userId){
        $user = User::findOrFail($userId);
        $actions = $user->actions;
        //dd($actions);
        return view('users/audit', compact('actions','user'));
    }
}
