<?php

namespace App\Http\Controllers;

use App\Models\Gallery;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class GalleryController extends Controller
{
    public function index(){
        // dd('hai');
        $galleries = Gallery::get();
        return view('gallery.index',compact('galleries'));
    }

    public function store(Request $request){
        //dd('store');
        $request->validate([
            'file_image' => 'required|mimes:jpeg,jpg,png|max:2048'
        ]);

        DB::beginTransaction();

        try {

            //upload file
            if ($request->hasFile('file_image')) {
                $path_attach = $request->file('file_image');
                $url = $path_attach->move('storage/gallery', $path_attach->hashName());
            }
    
            $store = Gallery::create([
                'attachment' => $url
            ]);
    

            DB::commit();
            // all good

            return redirect('/gallery')->with('status','Success Add Gallery');
        } catch (\Exception $e) {
            //dd($e);
            DB::rollback();
            // something went wrong

            return redirect('/gallery')->with('failed','Failed Add Gallery');
        }
    }

    public function update(Request $request){
        //dd('store');
        $request->validate([
            'file_image' => 'required|mimes:jpeg,jpg,png|max:2048'
        ]);

        DB::beginTransaction();

        try {
            //cari gambar lama
            $image = Gallery::where('id',$request->id_gallery)->first();

            $image_path = $image->attachment;  // Value is not URL but directory file path
            if(File::exists($image_path)) {
                File::delete($image_path);
            }

            //upload gambar baru
            if ($request->hasFile('file_image')) {
                $path_attach = $request->file('file_image');
                $url = $path_attach->move('storage/gallery', $path_attach->hashName());
            }
        
            $update = Gallery::where('id',$request->id_gallery)->update([
                'attachment' => $url
            ]);
    

            DB::commit();
            // all good

            return redirect('/gallery')->with('status','Success Update Gallery');
        } catch (\Exception $e) {
            //dd($e);
            DB::rollback();
            // something went wrong

            return redirect('/gallery')->with('failed','Failed Update Gallery');
        }
    }

    public function delete(Request $request){
        //dd('store');

        DB::beginTransaction();

        try {
            //cari gambar lama
            $image = Gallery::where('id',$request->id_gallery)->first();

            $image_path = $image->attachment;  // Value is not URL but directory file path
            if(File::exists($image_path)) {
                File::delete($image_path);
            }
        
            $delete = Gallery::where('id',$request->id_gallery)->delete();
    

            DB::commit();
            // all good

            return redirect('/gallery')->with('status','Success Delete Gallery');
        } catch (\Exception $e) {
            //dd($e);
            DB::rollback();
            // something went wrong

            return redirect('/gallery')->with('failed','Failed Delete Gallery');
        }
    }
}
