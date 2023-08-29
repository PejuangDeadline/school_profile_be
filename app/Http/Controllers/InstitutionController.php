<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\Dropdown;
use App\Models\Institution;
use App\Models\InstitutionProfile;
use App\Models\Rule;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use App\Traits\searchAreaTrait;

class InstitutionController extends Controller
{
    use searchAreaTrait;
    public function index(){

        $institutions = Institution::select(
                'institutions.*',
                'institution_profiles.id as id_profile'
            )
            ->leftJoin('institution_profiles','institutions.id','institution_profiles.id_institution')
            ->get();

        $dropdownGrades = Dropdown::where('category','Grade')
            ->get();

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

        return view('institutions.index',compact('institutions','dropdownGrades','provinces'));
    }

    public function store(Request $request){
        $request->validate([
            'inst_name' => 'required'
        ]);

        DB::beginTransaction();

        try {
            $query = Institution::create([
                'name' => $request->inst_name,
                'is_active' => '1'
            ]);

            DB::commit();
            // all good

            return redirect('/institution')->with('status','Success Add Institution');
        } catch (\Exception $e) {
            DB::rollback();
            // something went wrong

            return redirect('/institution')->with('failed','Failed Add Institution');
        }
    }

    public function createProfile($id_inst){
        $id_inst = decrypt($id_inst);

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

        return view('institutions.create_profile',compact('id_inst','provinces'));
    }

    public function editProfile($id_profile){
        $id_profile = decrypt($id_profile);

        $profile = InstitutionProfile::where('id',$id_profile)->first();

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

        return view('institutions.edit_profile',compact('profile','id_profile','provinces'));
    }

    public function storeProfile(Request $request){
        // dd($request->all());

        $request->validate([
            'id_inst' => 'required',
            'about' => 'required',
            'vision' => 'required',
            'mission' => 'required',
        ]);

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

        // create by email
        $created_by=auth()->user()->email;

        DB::beginTransaction();

        try {

            //Area Province by ID
            $province_name = $this->provinceName($token, $request->province_by_id);
            //Area City by ID
            $city_name = $this->cityName($token, $request->city);
            //Area District by ID
            $district_name = $this->districtName($token, $request->district);
            //Area Subdistrict by ID
            $subdistrict_name = $this->subdistrictName($token, $request->subdistrict);

            $query = InstitutionProfile::create([
                'id_institution' => $request->id_inst,
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
                'owner' => $request->owner,
                'established' => $request->established,
                'created_by' => $created_by,
            ]);

            DB::commit();
            // all good

            return redirect('/institution')->with('status','Success Add Institution Profile');
        } catch (\Exception $e) {
            //dd($e);
            DB::rollback();
            // something went wrong

            return redirect('/institution')->with('failed','Failed Add Institution Profile');
        }
    }

    public function updateProfile(Request $request){
        // dd($request->all());

        $request->validate([
            'id_profile' => 'required',
            'about' => 'required',
            'vision' => 'required',
            'mission' => 'required',
        ]);

        $id_profile = $request->id_profile;
        $profile = InstitutionProfile::where('id',$id_profile)->first();

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

        // compare data with database
        $profile->province = $province_name;
        $profile->city = $city_id;
        $profile->district = $district_id;
        $profile->sub_district = $subdistrict_id;

        DB::beginTransaction();

        try {
            if($profile->isDirty())
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

                $query =  InstitutionProfile:: where('id',$request->id_profile)
                    ->update([
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
                        'owner' => $request->owner,
                        'established' => $request->established
                    ]);
            }
            else
            {
                //dd('tidak berubah');
                $query =  InstitutionProfile:: where('id',$request->id_profile)
                    ->update([
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
                        'owner' => $request->owner,
                        'established' => $request->established
                    ]);
            }

            DB::commit();
            // all good

            return redirect('/institution')->with('status','Success Update Institution Profile');
        } catch (\Exception $e) {
            //dd($e);
            DB::rollback();
            // something went wrong

            return redirect('/institution')->with('failed','Failed Update Institution Profile');
        }
    }

    public function indexBranch(){
        // dd('hai');
        $branchs = Branch::get();

        $dropdownGrades = Dropdown::where('category','Grade')
            ->get();

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

        $users = User::where('id_branch','0')
            ->where('role','User')
            ->get();

        return view('branch.index',compact('branchs','dropdownGrades','provinces','users'));
    }

    public function storeBranch(Request $request){
        //dd($request->all());
        $request->validate([
            "id_inst" => "required",
            "grade" => "required",
            "name_branch" => "required",
            "province_by_id" => "required"
        ]);

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

        // create by email
        $created_by=auth()->user()->email;

        DB::beginTransaction();
        try {
            //Area name by ID
            $province_name = $this->provinceName($token, $request->province_by_id);
            //Area City by ID
            $city_name = $this->cityName($token, $request->city);
            //Area District by ID
            $district_name = $this->districtName($token, $request->district);
            //Area Subdistrict by ID
            $subdistrict_name = $this->subdistrictName($token, $request->subdistrict);

            //check grade already
            $checkGrade = Branch::where('id_institution',$request->id_inst)
                            ->where('grade',$request->grade)
                            ->where('province',$province_name)
                            ->count();

            if($checkGrade > 0){
                return redirect('/institution')->with('failed','Branch With Grade '.$request->grade.' in Province '.$province_name.' Already Exist' );
            }


            $query = Branch::create([
                'id_institution' => $request->id_inst,
                'grade' => $request->grade,
                'name' => $request->name_branch,
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
                'owner' => $request->owner,
                'established' => $request->established,
                'created_by' => $created_by,
                'is_active' => '1'
            ]);

            DB::commit();
            // all good

            return redirect('/institution')->with('status','Success Add Branch');
        } catch (\Exception $e) {
            DB::rollback();
            // something went wrong

            return redirect('/institution')->with('failed','Failed Add Branch');
        }
    }

    public function userBranch(Request $request){
        // dd('hai');
        $request->validate([
            'user' => 'required'
        ]);

        DB::beginTransaction();

        try {
            $query = User::where('id',$request->user)->update([
                'id_branch' => $request->id_branch
            ]);

            DB::commit();
            // all good

            return redirect('/branch')->with('status','Success Add User');
        } catch (\Exception $e) {
            DB::rollback();
            // something went wrong

            return redirect('/branch')->with('failed','Failed Add User');
        }
    }
}
