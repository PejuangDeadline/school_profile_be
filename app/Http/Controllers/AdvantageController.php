<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Advantage;
use Illuminate\Support\Facades\DB;

class AdvantageController extends Controller
{
    public function index($id)
    {
        // dd('hai');
        $id = decrypt($id);
        $advantage = Advantage::select('advantages.*','institutions.name as institution_name','institutions.id as id_institution')
        ->leftjoin('institutions','institutions.id','advantages.id_institution')
        ->where('id_institution',$id)
        ->get();

        return view('advantage.index',compact('id','advantage'));
    }

    public function store(Request $request)
    {

        $id_institution = $request->id_institution;
        //dd($id_institution);
        DB::beginTransaction();

        try {

            $store = Advantage::create([
                'id_institution' => $id_institution,
                'title' =>$request->title,
                'description' => $request->description,
                'is_active' => 1,
            ]);
            
            DB::commit();
            // all good
            $id_ins = encrypt($id_institution);
            return redirect('/advantage/' . $id_ins)->with('status','Success Add Advantage');
        } catch (\Exception $e) {
            // dd($e);
            DB::rollback();
            // something went wrong
            $id_ins = encrypt($id_institution);
            return redirect('/advantage/' . $id_ins)->with('failed','Failed Add advantage');
        }
    }

    public function update(Request $request) {
        $id = $request->id;
        $id_institution = $request->id_institution;
    
        DB::beginTransaction();
    
        try {
            // Retrieve the existing Advantage record
            $advantage = Advantage::find($id);
    
            if (!$advantage) {
                // Handle the case where the record doesn't exist
                return redirect('/advantage/' . encrypt($id_institution))->with('failed', 'Advantage record not found');
            }
    
            // Update the title
            $newTitle = $request->title;
            // You might want to sanitize or validate the 'title' here before updating it.
            if ($newTitle !== $advantage->title) {
                $advantage->title = $newTitle;
            }
    
            // Update the description
            $newDescription = $request->description;
            // You might want to sanitize or validate the 'description' here before updating it.
            if ($newDescription !== $advantage->description) {
                $advantage->description = $newDescription;
            }
    
            // Check if any attributes have been modified after making changes
            if ($advantage->isDirty()) {
                // Save changes only if something has been modified
                $advantage->save();
            } else {
                // No changes have been made
                return redirect('/advantage/' . encrypt($id_institution))->with('failed', 'No changes have been made');
            }
    
            DB::commit();
            // all good
    
            $id_ins = encrypt($id_institution);
            return redirect('/advantage/' . $id_ins)->with('status', 'Success Update Advantage');
        } catch (\Exception $e) {
            DB::rollback();
            // dd($e);
            // something went wrong
            $id_ins = encrypt($id_institution);
            return redirect('/advantage/' . $id_ins)->with('failed', 'Failed Update Advantage');
        }
    }
    
    
    public function delete(Request $request){
        // dd('store');
        $id = $request->id;
        $id_institution = $request->id_institution;
        $id_ins = encrypt($id_institution);
        DB::beginTransaction();

        try {
            //cari gambar lama
            $image = Advantage::where('id',$id)->first();

            $delete = Advantage::where('id',$id)->delete();


            DB::commit();
            // all good
            return redirect('/advantage/' . $id_ins)->with('status','Success Delete Vision');
        } catch (\Exception $e) {
            //dd($e);
            DB::rollback();
            // something went wrong
            return redirect('/advantage/' . $id_ins)->with('failed','Failed Delete Vision');
        }
    }

    public function active(Request $request){
      
        $id = $request->id;
        $id_institution = $request->id_institution;
        $id_ins = encrypt($id_institution);
        DB::beginTransaction();

        try {
           // Find the Vision record with the given ID
           $vision = Advantage::find($id);
    
           if (!$vision) {
               // Handle the case where the record doesn't exist
               return redirect('/advantage/' . $id_ins)->with('failed', 'Advantage record not found');
           }
   
           // Update the 'is_active' column to '0'
           $vision->is_active = '1';
           $vision->save(); // Save the changes to the database


            DB::commit();
            // all good
            return redirect('/advantage/' . $id_ins)->with('status', 'Success: Status changed to Active');
        } catch (\Exception $e) {
            //dd($e);
            DB::rollback();
            // something went wrong
            return redirect('/advantage/' . $id_ins)->with('failed','Failed Delete Vision');
        }
    }
    

    public function deactive(Request $request) {
        $id = $request->id;
        $id_institution = $request->id_institution;
        $id_ins = encrypt($id_institution);
        
        DB::beginTransaction();
    
        try {
            // Find the Vision record with the given ID
            $vision = Advantage::find($id);
    
            if (!$vision) {
                // Handle the case where the record doesn't exist
                return redirect('/advantage/' . $id_ins)->with('failed', 'Advantage record not found');
            }
    
            // Update the 'is_active' column to '0'
            $vision->is_active = '0';
            $vision->save(); // Save the changes to the database
    
            DB::commit();
            
            return redirect('/advantage/' . $id_ins)->with('status', 'Success: Status changed to Inactive');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect('/advantage/' . $id_ins)->with('failed', 'Failed to change status');
        }
    }
}
