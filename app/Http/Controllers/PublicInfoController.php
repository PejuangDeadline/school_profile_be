<?php

namespace App\Http\Controllers;

use App\Models\Dropdown;
use App\Models\PublicInfo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class PublicInfoController extends Controller
{
    public function index(){
        // dd('hai');
        $dropdowns['feature'] = Dropdown::where('category','Feature')
            ->orderBy('category','asc')
            ->get();

        $id_branch = auth()->user()->id_branch;
        
        $infos = PublicInfo::where('id_branch',$id_branch)->orderBy('created_at','desc')->get();

        return view('public_info.index',compact('dropdowns','infos'));
    }

    public function store(Request $request){
        //dd('hai');
        $request->validate([
            'category' => 'required',
            'title' => 'required',
            'content' => 'required',
            'attachment' => 'required|mimes:jpeg,jpg,png|max:2048'
        ]);

        $created_by = auth()->user()->email;
        $id_branch = auth()->user()->id_branch;

        DB::beginTransaction();

        try {

            //upload file
            if ($request->hasFile('attachment')) {
                $path_attach = $request->file('attachment');
                $url = $path_attach->move('storage/public_info', $path_attach->hashName());
            }

            $store = PublicInfo::create([
                'id_branch' => $id_branch,
                'attachment' => $url,
                'category' => $request->category,
                'title' => $request->title,
                'title_slug' => Str::slug($request->title),
                'content' => $request->content,
                'created_by' => $created_by
            ]);


            DB::commit();
            // all good

            return redirect('/public-info')->with('status','Success Add Public Info');
        } catch (\Exception $e) {
            //dd($e);
            DB::rollback();
            // something went wrong

            return redirect('/public-info')->with('failed','Failed Add Public Info');
        }
    }

    public function update(Request $request){
        //dd('hai');
        $request->validate([
            'category' => 'required',
            'title' => 'required',
            'content' => 'required'
        ]);

        $id_info = $request->id_info;
        $created_by = auth()->user()->email;
        $id_branch = auth()->user()->id_branch;

        DB::beginTransaction();

        try {
            //upload file
            if ($request->hasFile('attachment')) {
                //cari gambar lama
                $image = PublicInfo::where('id',$id_info)->first();

                $image_path = $image->attachment;  // Value is not URL but directory file path
                if(File::exists($image_path)) {
                    File::delete($image_path);
                }

                $path_attach = $request->file('attachment');
                $url = $path_attach->move('storage/public_info', $path_attach->hashName());

                $update = PublicInfo::where('id',$id_info)->update([
                    'id_branch' => $id_branch,
                    'attachment' => $url,
                    'category' => $request->category,
                    'title' => $request->title,
                    'title_slug' => Str::slug($request->title),
                    'content' => $request->content,
                    'created_by' => $created_by
                ]);
            }
            else{
                $update = PublicInfo::where('id',$id_info)->update([
                    'id_branch' => $id_branch,
                    'category' => $request->category,
                    'title' => $request->title,
                    'title_slug' => Str::slug($request->title),
                    'content' => $request->content,
                    'created_by' => $created_by
                ]);
            }

            DB::commit();
            // all good

            return redirect('/public-info')->with('status','Success Update Public Info');
        } catch (\Exception $e) {
            //dd($e);
            DB::rollback();
            // something went wrong

            return redirect('/public-info')->with('failed','Failed Update Public Info');
        }
    }

    public function delete(Request $request){
        //dd($request->all());
        $id_info = $request->id_info;
        
        DB::beginTransaction();

        try {
            //cari gambar lama
            $image = PublicInfo::where('id',$id_info)->first();

            $image_path = $image->attachment;  // Value is not URL but directory file path
            if(File::exists($image_path)) {
                File::delete($image_path);
            }

            $query = PublicInfo::where('id',$id_info)->delete();

            DB::commit();
            // all good

            return redirect('/public-info')->with('status','Success Delete Public Info');
        } catch (\Exception $e) {
            //dd($e);
            DB::rollback();
            // something went wrong

            return redirect('/public-info')->with('failed','Failed Delete Public Info');
        }
    }
}
