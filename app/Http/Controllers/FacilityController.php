<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\Dropdown;
use App\Models\Facility;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class FacilityController extends Controller
{
    public function index(){
        // dd('hai');
        $dropdownBranches = Branch::get();
        $id_branch = auth()->user()->id_branch;

        $facilities = Facility::select('facilities.*','branches.id as id_branch','branches.name','branches.grade','branches.city')
            ->leftJoin('branches','facilities.id_branch','branches.id')
            ->where('id_branch',$id_branch)
            ->get();

        return view('facility.index',compact('dropdownBranches','facilities'));
    }

    public function store(Request $request){
        //dd($request->all());
        $request->validate([
            'facility_name' => 'required',
            'description' => 'required'
        ]);

        $created_by = auth()->user()->email;
        $id_branch = auth()->user()->id_branch;
        
        DB::beginTransaction();

        try {

            //upload file
            if ($request->hasFile('file_image')) {
                $path_attach = $request->file('file_image');
                $url = $path_attach->move('storage/facility', $path_attach->hashName());
            }

            $query = Facility::create([
                'id_branch' => $id_branch,
                'facility_name' => $request->facility_name,
                'description' => $request->description,
                'file_icon' => $url,
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
            'facility_name' => 'required',
            'description' => 'required',
        ]);

        $created_by = auth()->user()->email;
        $id_branch = auth()->user()->id_branch;
        
        DB::beginTransaction();

        try {

            $query = Facility::where('id',$request->id_facility)->update([
                'id_branch' => $id_branch,
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

    public function updateIcon(Request $request){
        // dd($request->all());
        $request->validate([
            'id_facility' => 'required',
            'file_image' => 'required|mimes:jpeg,jpg,png|max:2048'
        ]);

        $created_by = auth()->user()->email;
        $id_branch = auth()->user()->id_branch;
        
        DB::beginTransaction();

        try {
            //cari gambar lama
            $image = Facility::where('id',$request->id_facility)->first();

            $image_path = $image->file_icon;  // Value is not URL but directory file path
            if(File::exists($image_path)) {
                File::delete($image_path);
            }

            //upload file
            if ($request->hasFile('file_image')) {
                $path_attach = $request->file('file_image');
                $url = $path_attach->move('storage/facility', $path_attach->hashName());
            }

            $query = Facility::where('id',$request->id_facility)->update([
                'file_icon' => $url
            ]);

            DB::commit();
            // all good

            return redirect('/facility')->with('status','Success Update Facility Icon');
        } catch (\Exception $e) {
            //dd($e);
            DB::rollback();
            // something went wrong

            return redirect('/facility')->with('failed','Failed Update Facility Icon');
        }
    }

    public function delete(Request $request){
        //dd($request->all());
        
        DB::beginTransaction();

        try {
            //cari gambar lama
            $image = Facility::where('id',$request->id_facility)->first();

            $image_path = $image->file_icon;  // Value is not URL but directory file path
            if(File::exists($image_path)) {
                File::delete($image_path);
            }

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
