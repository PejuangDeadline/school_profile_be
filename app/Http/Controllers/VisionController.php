<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Vision;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class VisionController extends Controller
{
    public function index($id)
    {
        // dd('hai');
        $id = decrypt($id);
        $vision = Vision::select('visions.*','institutions.name as institution_name','institutions.id as id_institution')
        ->leftjoin('institutions','institutions.id','visions.id_institution')
        ->where('id_institution',$id)
        ->get();

        return view('vision.index',compact('id','vision'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'file_image' => 'required|mimes:jpeg,jpg,png|max:2048'
        ]);

        $id_institution = $request->id_institution;
        //dd($id_institution);
        DB::beginTransaction();

        try {

            //upload file
            if ($request->hasFile('file_image')) {
                $path_attach = $request->file('file_image');
                $url = $path_attach->move('storage/vision', $path_attach->hashName());
            }

            $store = Vision::create([
                'id_institution' => $id_institution,
                'description' => $request->description,
                'is_active' => 1,
                'img' => $url,
            ]);
            
            DB::commit();
            // all good
            $id_ins = encrypt($id_institution);
            return redirect('/vision/' . $id_ins)->with('status','Success Add Vision');
        } catch (\Exception $e) {
            // dd($e);
            DB::rollback();
            // something went wrong
            $id_ins = encrypt($id_institution);
            return redirect('/vision/' . $id_ins)->with('failed','Failed Add Vision');
        }
    }

    public function update(Request $request) {
        $id = $request->id;
        $id_institution = $request->id_institution;
    
        DB::beginTransaction();
    
        try {
            // Retrieve the existing Vision record
            $vision = Vision::find($id);
    
            if (!$vision) {
                // Handle the case where the record doesn't exist
                return redirect('/vision/' . encrypt($id_institution))->with('failed', 'Vision record not found');
            }
    
            // Check if the 'img' attribute is dirty (modified)
            if ($request->hasFile('file_image')) {
                // Delete the old image file
                $image_path = $vision->img;
                if (File::exists($image_path)) {
                    File::delete($image_path);
                }
    
                // Upload and save the new image
                $path_attach = $request->file('file_image');
                $url = $path_attach->move('storage/vision', $path_attach->hashName());
    
                $vision->img = $url;
            }
    
            // Update other attributes
            $newDescription = $request->description;
            // You might want to sanitize or validate the 'description' here before updating it.
            $vision->description = $newDescription;
            $id_ins = encrypt($id_institution);
            // Check if any attributes have been modified
            if (!$vision->isDirty()) {
                // No changes have been made
                return redirect('/vision/' . $id_ins)->with('failed', 'No changes have been made');
            }
    
            // Save changes only if something has been modified
            $vision->save();
    
            DB::commit();
            // all good
    
           
            return redirect('/vision/' . $id_ins)->with('status', 'Success Update Vision');
        } catch (\Exception $e) {
            DB::rollback();
            dd($e);
            // something went wrong
            $id_ins = encrypt($id_institution);
            return redirect('/vision/' . $id_ins)->with('failed', 'Failed Update Vision');
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
            $image = Vision::where('id',$id)->first();

            $image_path = $image->attachment;  // Value is not URL but directory file path
            if(File::exists($image_path)) {
                File::delete($image_path);
            }

            $delete = Vision::where('id',$id)->delete();


            DB::commit();
            // all good
            return redirect('/vision/' . $id_ins)->with('status','Success Delete Vision');
        } catch (\Exception $e) {
            //dd($e);
            DB::rollback();
            // something went wrong
            return redirect('/vision/' . $id_ins)->with('failed','Failed Delete Vision');
        }
    }

    public function active(Request $request){
      
        $id = $request->id;
        $id_institution = $request->id_institution;
        $id_ins = encrypt($id_institution);
        DB::beginTransaction();

        try {
           // Find the Vision record with the given ID
           $vision = Vision::find($id);
    
           if (!$vision) {
               // Handle the case where the record doesn't exist
               return redirect('/vision/' . $id_ins)->with('failed', 'Vision record not found');
           }
   
           // Update the 'is_active' column to '0'
           $vision->is_active = '1';
           $vision->save(); // Save the changes to the database


            DB::commit();
            // all good
            return redirect('/vision/' . $id_ins)->with('status', 'Success: Status changed to Active');
        } catch (\Exception $e) {
            //dd($e);
            DB::rollback();
            // something went wrong
            return redirect('/vision/' . $id_ins)->with('failed','Failed Delete Vision');
        }
    }
    

    public function deactive(Request $request) {
        $id = $request->id;
        $id_institution = $request->id_institution;
        $id_ins = encrypt($id_institution);
        
        DB::beginTransaction();
    
        try {
            // Find the Vision record with the given ID
            $vision = Vision::find($id);
    
            if (!$vision) {
                // Handle the case where the record doesn't exist
                return redirect('/vision/' . $id_ins)->with('failed', 'Vision record not found');
            }
    
            // Update the 'is_active' column to '0'
            $vision->is_active = '0';
            $vision->save(); // Save the changes to the database
    
            DB::commit();
            
            return redirect('/vision/' . $id_ins)->with('status', 'Success: Status changed to Inactive');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect('/vision/' . $id_ins)->with('failed', 'Failed to change status');
        }
    }
}
