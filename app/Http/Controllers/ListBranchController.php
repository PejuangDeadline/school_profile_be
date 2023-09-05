<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;
use App\Models\Rule;
use App\Models\Dropdown;
use App\Models\Branch;
use App\Traits\searchAreaTrait;


class ListBranchController extends Controller
{
    use searchAreaTrait;

    public function index($id){
        $id_branch = decrypt($id);
        $dropdownGrades = Dropdown::where('category','Grade')
        ->get();

        $branch = Branch::where('id_institution',$id_branch)->get();
        $institution = Branch::where('id_institution',$id_branch)->first();
         //API Regional
         $ruleAuthRegional = Rule::where('rule_name', 'API Auth Regional')->first();
         $url_AuthRegional = $ruleAuthRegional->rule_value;

         $ruleEmailRegional = Rule::where('rule_name', 'Email Auth Regional')->first();
         $emailRegional = $ruleEmailRegional->rule_value;

         $rulePasswordRegional = Rule::where('rule_name', 'Password Auth Regional')->first();
         $passwordRegional = $rulePasswordRegional->rule_value;

         $response = Http::post($url_AuthRegional, [
             'email' => $emailRegional,
             'password' => $passwordRegional,
         ]);

         $data = $response['data'];
         $token = $data['token'];

         //get list province
         $ruleApiProvince = Rule::where('rule_name', 'API List Province')->first();
         $url_ApiProvince = $ruleApiProvince->rule_value;

         $getProvince = Http::withToken($token)
             ->get($url_ApiProvince);
         $provinces = $getProvince['data'];
         //End API Regional


        return view('list-branch.index',compact('branch','provinces','institution','dropdownGrades'));
    }

    public function delete(Request $request,$id){
        //dd($id);

        // create by email
        $created_by = auth()->user()->email;

        DB::beginTransaction();
        try {

            $query =  Branch::where('id',$id)
                    ->update([
                        'is_active' => '0',
                        'created_by' => $created_by,
                    ]);
            DB::commit();
            // all good

            return redirect('/institution')->with('status','Success Delete Branch');
        } catch (\Exception $e) {
            //dd($e);
            DB::rollback();
            // something went wrong

            return redirect('/institution')->with('failed','Failed Delete Branch');
        }
    }

    public function editBranch($id_branch){
        //dd('masuk');
        $id_branch = decrypt($id_branch);
        $dropdownGrades = Dropdown::where('category','Grade')
        ->get();
        $branch = Branch::where('id',$id_branch)->first();

        //API Regional
        $ruleAuthRegional = Rule::where('rule_name', 'API Auth Regional')->first();
        $url_AuthRegional = $ruleAuthRegional->rule_value;

        $ruleEmailRegional = Rule::where('rule_name', 'Email Auth Regional')->first();
        $emailRegional = $ruleEmailRegional->rule_value;

        $rulePasswordRegional = Rule::where('rule_name', 'Password Auth Regional')->first();
        $passwordRegional = $rulePasswordRegional->rule_value;

        $response = Http::post($url_AuthRegional, [
            'email' => $emailRegional,
            'password' => $passwordRegional,
        ]);

        $data = $response['data'];
        $token = $data['token'];

        //get list province
        $ruleApiProvince = Rule::where('rule_name', 'API List Province')->first();
        $url_ApiProvince = $ruleApiProvince->rule_value;

        $getProvince = Http::withToken($token)
            ->get($url_ApiProvince);
        $provinces = $getProvince['data'];
        //End API Regional[[]]

        return view('list-branch.edit_branch',compact('branch','id_branch','provinces','dropdownGrades'));
    }

    public function update(Request $request){
        //dd($id);
        //dd($request->all());

        $request->validate([
            'id_branch' => 'required',
            'about' => 'required',
            'vision' => 'required',
            'mission' => 'required',
        ]);

        $id_branch = $request->id_branch;
        $branch = Branch::where('id',$id_branch)->first();
        //dd($branch);

        //get id if update regional
        $province_id = $request->province_by_id;
        $city_id = $request->city;
        $district_id = $request->district;
        $subdistrict_id = $request->subdistrict;

        //get Token Area
        $rule = Rule::where('rule_name', 'API Auth Regional')->first();
        $url_getToken = $rule->rule_value;

        $ruleAuthUsers = Rule::where('rule_name', 'Email Auth Regional')->first();
        $authUsername = $ruleAuthUsers->rule_value;

        $ruleAuthPass = Rule::where('rule_name', 'Password Auth Regional')->first();
        $authPassword = $ruleAuthPass->rule_value;

        $response = Http::post($url_getToken, [
            'email' => $authUsername,
            'password' => $authPassword,
        ]);

        $data = $response['data'];
        $token = $data['token'];

        //Area Province by ID
        $province_name = $this->provinceName($token, $request->province_by_id);
        //dd($province_name);
        // compare data with database
        $branch->province = $province_name;
        $branch->city = $city_id;
        $branch->district = $district_id;
        $branch->sub_district = $subdistrict_id;

        DB::beginTransaction();

        try {
            if($branch->isDirty())
            {
                //dd('berubah');
                //Area Province by ID
                $province_name = $this->provinceName($token, $province_id);
                //Area City by ID
                $city_name = $this->cityName($token, $city_id);
                //Area District by ID
                $district_name = $this->districtName($token, $district_id);
                //Area Subdistrict by ID
                $subdistrict_name = $this->subdistrictName($token, $subdistrict_id);

                $query =  Branch:: where('id',$request->id_branch)
                    ->update([
                        'grade' => $request->grade,
                        'name' => $request->name,
                        'about' => $request->about,
                        'vision' => $request->vision,
                        'mission' => $request->mission,
                        'lat' => $request->lat,
                        'long' => $request->long,
                        'addr' => $request->addr,
                        'province' => $province_name,
                        'city' => $city_name,
                        'district' => $district_name,
                        'sub_district' => $subdistrict_name,
                        'zip_code' => $request->zip_code,
                        'phone1' => $request->phone1,
                        'phone2' => $request->phone2,
                        'whatsapp' => $request->whatsapp,
                        'instagram' => $request->instagram,
                        'facebook' => $request->facebook,
                        'twitter' => $request->twitter,
                        'pic' => $request->pic,
                        'pic_no' => $request->pic_no,
                        'open_at' => $request->open_at,
                        'email' => $request->email,
                        'owner' => $request->owner,
                        'established' => $request->established
                    ]);
            }
            else
            {
                //dd('tidak berubah');
                $query =  Branch:: where('id',$request->id_branch)
                    ->update([
                        'grade' => $request->grade,
                        'name' => $request->name,
                        'about' => $request->about,
                        'vision' => $request->vision,
                        'mission' => $request->mission,
                        'lat' => $request->lat,
                        'long' => $request->long,
                        'addr' => $request->addr,
                        'zip_code' => $request->zip_code,
                        'phone1' => $request->phone1,
                        'phone2' => $request->phone2,
                        'whatsapp' => $request->whatsapp,
                        'instagram' => $request->instagram,
                        'facebook' => $request->facebook,
                        'twitter' => $request->twitter,
                        'pic' => $request->pic,
                        'pic_no' => $request->pic_no,
                        'open_at' => $request->open_at,
                        'email' => $request->email,
                        'owner' => $request->owner,
                        'established' => $request->established
                    ]);
            }

            DB::commit();
            // all good

            return redirect('/institution')->with('status','Success Update Branch');
        } catch (\Exception $e) {
            //dd($e);
            DB::rollback();
            // something went wrong

            return redirect('/institution')->with('failed','Failed Update Branch');
        }
    }

}
