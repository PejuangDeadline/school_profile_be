<?php

namespace App\Http\Controllers;
use App\Models\MstFeature;
use App\Models\Branch;
use App\Models\Dropdown;

use Illuminate\Http\Request;

class MstFeatureController extends Controller
{
    public function index(){
        $feature = MstFeature::get();
        $branch = Branch::get();
        $dropdown = Dropdown::where('category','Feature')->get();

        return view('feature.index', compact('feature','branch','dropdown'));
    }
}
