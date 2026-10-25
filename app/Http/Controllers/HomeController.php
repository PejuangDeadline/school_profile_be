<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        if(auth()->user()->role == 'User'){
            $id_branch = auth()->user()->id_branch;
            $branch = Branch::where('id',$id_branch)->first();
            $branch_name = $branch->name;
        }
        else{
            $branch_name = "Selamat Datang di Sekolah Islam Kharisma";
        }

        return view('home.index',compact('branch_name'));
    }
}

