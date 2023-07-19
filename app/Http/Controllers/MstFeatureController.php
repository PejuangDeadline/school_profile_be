<?php

namespace App\Http\Controllers;
use App\Models\MstFeature;
use App\Models\Branch;
use App\Models\Dropdown;

use Illuminate\Http\Request;

class MstFeatureController extends Controller
{
    public function index(){
        $feature = MstFeature::select('mst_features.id','branches.name','mst_features.feature','mst_features.id_branch')
        ->leftJoin('branches', 'mst_features.id_branch', '=', 'branches.id')
        ->get();
        $branch = Branch::get();
        $dropdown = Dropdown::where('category', 'Feature')
        ->orderBy('name_value', 'asc')
        ->get();

        return view('feature.index', compact('feature','branch','dropdown'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'branch' => 'required',
            'feature' => 'required',
        ]);

        $check = MstFeature::where('id_branch',$request->branch)
        ->where('feature',$request->feature)
        ->count();
        if ($check >= 1) {
            return redirect('/feature')->with('failed','Failed Add Feature, Data Already Exist');
        }

        $addFeature = MstFeature::create([
            'id_branch' => $request->branch,
            'feature' => $request->feature,
        ]);
        if ($addFeature) {
            return redirect('/feature')->with('status','Success Add Feature');
        }else{
            return redirect('/feature')->with('failed','Failed Add Feature');
        }
    }

    public function delete($id)
    {
        $deleteFeature=MstFeature::where('id',$id)
        ->delete();
        if ($deleteFeature) {
            return redirect('/feature')->with('status','Success Delete Feature');
        }else{
            return redirect('/feature')->with('failed','Failed Delete Feature');
        }
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'branch' => 'required',
            'feature' => 'required',
        ]);

        //Validate Input
        $validateInput =  MstFeature::where('id',$id)->first();
        $validateInput->id_branch = $request->branch;
        $validateInput->feature = $request->feature;

       if($validateInput->isDirty()){
       
          try {
            $updateFeature=MstFeature::where('id',$id)
            ->update([
                'id_branch' => $request->branch,
                'feature' => $request->feature,
            ]);
            if ($updateFeature) {
                return redirect('/feature')->with('status','Success Update Feature');
            }else{
                return redirect('/feature')->with('failed','Failed Update Feature');
            }
          } catch (\Throwable $th) {
           return redirect('/feature')->with('failed','Failed Update Feature');
          }

      } else{
       return redirect('/feature')->with('failed','There is no Change in Feature Data');
      }
         
    }
}
