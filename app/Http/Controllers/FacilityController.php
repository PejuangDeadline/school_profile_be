<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\Dropdown;
use App\Models\Facility;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FacilityController extends Controller
{
    public function index(){
        // dd('hai');
        $dropdownBranches = Branch::get();

        $facilities = Facility::select('facilities.*','branches.id as id_branch','branches.name','branches.grade','branches.city')
            ->leftJoin('branches','facilities.id_branch','branches.id')
            ->get();

        return view('facility.index',compact('dropdownBranches','facilities'));
    }

    public function store(Request $request){
        //dd($request->all());
        $request->validate([
            'branch' => 'required',
            'facility_name' => 'required',
            'description' => 'required',
        ]);

        $created_by = auth()->user()->email;
        
        DB::beginTransaction();

        try {

            $query = Facility::create([
                'id_branch' => $request->branch,
                'facility_name' => $request->facility_name,
                'description' => $request->description,
                'created_by' => $created_by,
            ]);

            DB::commit();
            // all good

            return redirect('/facility')->with('status','Success Add Facility');
        } catch (\Exception $e) {
            //dd($e);
            DB::rollback();
            // something went wrong

            return redirect('/facility')->with('failed','Failed Add Facility');
        }
    }

    public function update(Request $request){
        // dd($request->all());
        $request->validate([
            'id_facility' => 'required',
            'branch' => 'required',
            'facility_name' => 'required',
            'description' => 'required',
        ]);

        $created_by = auth()->user()->email;
        
        DB::beginTransaction();

        try {

            $query = Facility::where('id',$request->id_facility)->update([
                'id_branch' => $request->branch,
                'facility_name' => $request->facility_name,
                'description' => $request->description,
                'created_by' => $created_by,
            ]);

            DB::commit();
            // all good

            return redirect('/facility')->with('status','Success Update Facility');
        } catch (\Exception $e) {
            //dd($e);
            DB::rollback();
            // something went wrong

            return redirect('/facility')->with('failed','Failed Update Facility');
        }
    }

    public function delete(Request $request){
        //dd($request->all());
        
        DB::beginTransaction();

        try {

            $query = Facility::where('id',$request->id_facility)->delete();

            DB::commit();
            // all good

            return redirect('/facility')->with('status','Success Delete Facility');
        } catch (\Exception $e) {
            //dd($e);
            DB::rollback();
            // something went wrong

            return redirect('/facility')->with('failed','Failed Delete Facility');
        }
    }
}
