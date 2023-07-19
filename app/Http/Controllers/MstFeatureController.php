<?php

namespace App\Http\Controllers;
use App\Models\MstFeature;
use App\Models\Branch;

use Illuminate\Http\Request;

class MstFeatureController extends Controller
{
    public function index(){
        $feature = MstFeature::get();
        $branch = Branch::get();

        return view('feature.index', compact('feature','branch'));
    }
}
