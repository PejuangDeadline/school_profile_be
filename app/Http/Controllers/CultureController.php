<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\Culture;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class CultureController extends Controller
{
    public function index($id)
    {
        // dd('hai');
        $id = decrypt($id);
        $culture = Culture::select('cultures.*','institutions.name as institution_name')
        ->leftjoin('institutions','institutions.id','cultures.id_institution')
        ->where('id_institution',$id)
        ->get();

        return view('culture.index',compact('culture','id'));
    }

    public function store(Request $request)
    {
        //dd('store');
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
                $url = $path_attach->move('storage/culture', $path_attach->hashName());
            }

            $store = Culture::create([
                'id_institution' => $id_institution,
                'title' => $request->title,
                'description' => $request->description,
                'img' => $url,
            ]);


            DB::commit();
            // all good
            $id_ins = encrypt($id_institution);
            return redirect('/culture/' . $id_ins)->with('status','Success Add Culture');
        } catch (\Exception $e) {
            //dd($e);
            DB::rollback();
            // something went wrong
            $id_ins = encrypt($id_institution);
            return redirect('/culture/' . $id_ins)->with('failed','Failed Add Culture');
        }
    }

    public function update(Request $request){
        //dd('store');
        $request->validate([
            'file_image' => 'required|mimes:jpeg,jpg,png|max:2048'
        ]);

        $id_institution = $request->id_institution;

        DB::beginTransaction();

        try {
            //cari gambar lama
            $image = Culture::where('id',$id_institution)->first();

            $image_path = $image->img;  // Value is not URL but directory file path
            if(File::exists($image_path)) {
                File::delete($image_path);
            }

            //upload gambar baru
            if ($request->hasFile('file_image')) {
                $path_attach = $request->file('file_image');
                $url = $path_attach->move('storage/culture', $path_attach->hashName());
            }

            $update = Culture::where('id',$id_institution)->update([
                'id_institution' => $id_institution,
                'title' => $request->title,
                'description' => $request->description,
                'img' => $url,
            ]);


            DB::commit();
            // all good

            $id_ins = encrypt($id_institution);
            return redirect('/culture/' . $id_ins)->with('status','Success Update Culture');
        } catch (\Exception $e) {
            dd($e);
            DB::rollback();
            // something went wrong
            $id_ins = encrypt($id_institution);
            return redirect('/culture/' . $id_ins)->with('failed','Failed Update Culture');
        }
    }

    public function delete(Request $request){
        //dd('store');
        $id_institution = $request->id_institution;
        DB::beginTransaction();

        try {
            //cari gambar lama
            $image = Culture::where('id',$request->id_institution)->first();

            $image_path = $image->attachment;  // Value is not URL but directory file path
            if(File::exists($image_path)) {
                File::delete($image_path);
            }

            $delete = Culture::where('id',$request->id_institution)->delete();


            DB::commit();
            // all good
            $id_ins = encrypt($id_institution);
            return redirect('/culture/' . $id_ins)->with('status','Success Delete Culture');
        } catch (\Exception $e) {
            //dd($e);
            DB::rollback();
            // something went wrong
            $id_ins = encrypt($id_institution);
            return redirect('/culture/' . $id_ins)->with('failed','Failed Delete Culture');
        }
    }
}
