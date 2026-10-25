<?php

namespace App\Http\Controllers;
use App\Models\User;
use App\Models\Dropdown;


use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        $user = User::select('users.*','branches.name as branchname','branches.city')
            ->leftJoin('branches','users.id_branch','branches.id')
            ->get();
        $dropdown = Dropdown::where('category','Role')
        ->get();
        return view('users.index',compact('user','dropdown'));
    }

    
    public function store(Request $request)
    {
        
        $request->validate([
            'name' => 'required',
            'email' => 'required',
            'role' => 'required',
            'password' => 'required',
        ]);

        $password = bcrypt($request->password);

        if($request->role == 'Super Admin' || $request->role == 'Admin'){
            $id_branch = '999';
        }
        else{
            $id_branch = '0';
        }

        $addUser=User::create([
            'id_branch' => $id_branch,
            'id_type' => '0',
            'name' => $request->name,
            'email' => $request->email,
            'password' => $password,
            'role' => $request->role,
            'last_login' => null,
            'is_active' => '1',

        ]);
        if ($addUser) {
            return redirect('/user')->with('status','Success Add Rule');
        }else{
            return redirect('/user')->with('failed','Failed Add Rule');
        }
    }

    public function revoke($id)
    {
        $revoke= User::where('id',$id)
        ->update([
            'is_active' => '0',
        ]);

            return redirect('/user')->with('status','Success Revoke User');
        
    }
    public function access($id)
    {
        $access= User::where('id',$id)
        ->update([
            'is_active' => '1',
        ]);
            return redirect('/user')->with('status','Success Give User Access');
    }


    public function update(Request $request, $id)
    {
        if($request->role == 'Super Admin' || $request->role == 'Admin'){
            $id_branch = '999';
        }
        else{
            $id_branch = '0';
        }

        $role= User::where('id',$id)
        ->update([
            'id_branch' => $id_branch,
            'role' => $request->role,
        ]);
            return redirect('/user')->with('status','Success Revoke User');
    }
}
